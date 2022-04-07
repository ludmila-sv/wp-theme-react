<?php
/**
 * WP CLI tools to work with ACF field groups, import\export.
 *
 * @package pressfoundry
 */

if ( ! function_exists( 'acf_add_options_page' ) ) {

	include_once get_template_directory() . '/includes/acf/acf.php';

	add_filter(
		'acf/settings/path',
		function ( $path ) {
			return get_template_directory() . '/includes/acf/';
		}
	);

	add_filter(
		'acf/settings/dir',
		function ( $dir ) {
			return get_template_directory() . '/includes/acf/';
		}
	);

}

/**
 * Legacy: use `wp acf import` and `wp acf export`  Imports ACF fields from includes/acf-fields.json to database.
 *
 * @param $args
 * @param $assoc_args
 *
 * @return void
 * @throws \WP_CLI\ExitException Error.
 */
function _wp_cli_acf_import_legacy( $args, $assoc_args ) {

//	 acf_disable_filters();

	// read file.
	$json = file_get_contents( get_template_directory() . '/includes/acf-fields.json' );

	// decode json.
	$json = json_decode( $json, true );

	// validate json.
	if ( empty( $json ) ) {
		WP_CLI::error( __( 'Import file empty', 'acf-cli' ) );
		return;
	}

	// if importing an auto-json, wrap field group in array.
	if ( isset( $json['key'] ) ) {
		$json = array( $json );
	}

	// vars.
	// Remember imported field group ids.
	$ids = array();

	// enable local.
	acf_enable_local();

	// reset local (JSON class has already included .json field groups which may conflict).
	acf_reset_local();

	// Loop over json.
	foreach ( $json as $field_group ) {

		// Search database for existing field group.
		$post = acf_get_field_group_post( $field_group['key'] );
		if ( $post ) {
			$field_group['ID'] = $post->ID;
		}

		// Import field group.
		$field_group = acf_import_field_group( $field_group );

		// append message.
		$ids[] = $field_group['ID'];
	}

	// messages.
	if ( ! empty( $ids ) ) {

		// vars.
		$count   = count( $ids );
		$message = sprintf( _n( 'Imported %s field group', 'Imported %s field groups', $count, 'acf-cli' ), $count ) . '.';

		// add notice.
		WP_CLI::line( $message );

	}

	WP_CLI::success( __( 'ACF import completed successfully!', 'acf-cli' ) );
}

/**
 * Legacy: use `wp acf export`  Exports ACF fields from database to includes/acf-fields.php and includes/acf-fields.json
 *
 * @param array $args  Args passed into command.
 * @param array $assoc_args Associative args.
 *
 * @return void
 * @throws \WP_CLI\ExitException
 */
function _wp_cli_acf_export_legacy( $args = array(), $assoc_args = array() ) {

	acf_disable_filters();

	$json = false;

	/**
	 * Receives array of strings. Each element represents a key of the Field Group which should not be exported.
	 *
	 * @param array Field group keys to ignore.
	 */
	$ignore_groups = apply_filters( 'pf_cli_acf_export_ignore', array() );

	// load field groups.
	foreach ( acf_get_field_groups() as $field_group ) {

		// validate field group.
		if ( empty( $field_group ) || in_array( $field_group['key'], $ignore_groups, true ) ) {
			continue;
		}

		// load fields.
		$field_group['fields'] = acf_get_fields( $field_group );

		// prepare for export.
		$field_group = acf_prepare_field_group_for_export( $field_group );

		// add to json array.
		$json[] = $field_group;
	}

	// validate
	if ( $json === false ) {
		WP_CLI::error( __( 'No field groups to export', 'acf-cli' ) );
		return;
	}

	$jsonFilename = get_template_directory() . '/includes/acf-fields.json';
	$phpFilename  = get_template_directory() . '/includes/acf-fields.php';

	// check permissions.

	if ( ! is_writable( $filename = $jsonFilename )
	     || ! is_writable( $filename = $phpFilename ) ) {
		WP_CLI::error( __( 'Error: operation not permitted! Please, ensure that PHP has write access to the file:', 'acf-cli' ) . $filename );
	}

	// write JSON encoded fields.
	file_put_contents( $jsonFilename, acf_json_encode( $json ) );

	// write PHP representation of ACF fields
	file_put_contents( $phpFilename, _acf_json_to_php( $json ) );

	WP_CLI::success( __( 'ACF export completed successfuly!', 'acf-cli' ) );
}


/**
 * Exports ACF fields into /includes/acf-fields/field_name__code.php|json .
 *
 * @throws \WP_CLI\ExitException Error.
 */
function _wp_cli_acf_export_new() {
	_wp_cli_acf_do_export( false );
}

/**
 * Exports ACF field groups  only in JSON format, PHP is untouched.
 *
 * @throws \WP_CLI\ExitException Error.
 */
function _wp_cli_export_to_json_directly() {

	_wp_cli_acf_do_export( true );

}

/**
 * Imports ACF fields from /includes/acf-fields/*.json to database.
 *
 * @return void
 * @throws \WP_CLI\ExitException Throws error if something goes wrong.
 */
function _wp_cli_acf_import_new() {

	acf_disable_filters();

	$source_dir = get_template_directory() . '/includes/acf-fields/';

	$json_files = glob( $source_dir . '*.json' );

	$json = array();

	foreach ( $json_files as $json_file ) {

		// read file.
		$json_string = file_get_contents( $json_file );

		// decode json.
		$json_field_group = json_decode( $json_string, true );

		// validate json.
		if ( empty( $json_field_group ) ) {
			WP_CLI::error( __( 'Import file empty: ', 'acf-cli' ) . $json_file );
			return;
		}

		// if importing an auto-json, wrap field group in array.
		if ( isset( $json_field_group['key'] ) ) {
			$json_field_group = array( $json_field_group );
		}

		$json = array_merge( $json, $json_field_group );

	}

	// vars.
	// Remember imported field group ids.
	$ids = array();

	// enable local.
	acf_enable_local();

	// reset local (JSON class has already included .json field groups which may conflict).
	acf_reset_local();

	// Loop over json.
	foreach ( $json as $field_group ) {

		// Search database for existing field group.
		$post = acf_get_field_group_post( $field_group['key'] );
		if ( $post ) {
			$field_group['ID'] = $post->ID;
		}

		// Import field group.
		$field_group = acf_import_field_group( $field_group );

		// append message.
		$ids[] = $field_group['ID'];
	}
	// TODO: lets remove field groups that were not imported but exist in database.

	// messages.
	if ( ! empty( $ids ) ) {

		// vars.
		$count   = count( $ids );
		$message = sprintf( _n( 'Imported %s field group', 'Imported %s field groups', $count, 'acf-cli' ), $count ) . '.';

		// add notice.
		WP_CLI::line( $message );

	}

	WP_CLI::success( __( 'ACF import completed successfully!', 'acf-cli' ) );
}


/**
 * Export of ACF fields from database to includes/acf-fields/field-group-name.php|.json
 *
 * @param bool $json_only  IF true it will export as Json only. PHP files will be untouched.
 *
 * @return void
 * @throws \WP_CLI\ExitException Error if something goes wrong.
 */
function _wp_cli_acf_do_export( $json_only = false ) {

	$dest_dir = get_template_directory() . '/includes/acf-fields/';

	$old_json_files = glob( $dest_dir . '*.json' );

	acf_disable_filters();

	// we keep track of all generated field groups files, their names without extensions will be here.
	$exported_field_groups = array();

	/**
	 * Receives array of strings. Each element represents a key of the Field Group which should not be exported.
	 *
	 * @param array Field group keys to ignore.
	 */
	$ignore_groups = apply_filters( 'pf_cli_acf_export_ignore', array() );

	// load field groups.
	foreach ( acf_get_field_groups() as $field_group ) {

		// validate field group.
		if ( empty( $field_group ) || in_array( $field_group['key'], $ignore_groups, true ) ) {
			continue;
		}

		// load fields.
		$field_group['fields'] = acf_get_fields( $field_group );

		// prepare for export.
		$field_group = acf_prepare_field_group_for_export( $field_group );

		// add to json array.
		$json = array( $field_group );

		// generate human readable__machine name.
		$field_group_file_name = _wp_cli_get_field_group_file_name( $field_group );

		$base_field_group_path = $dest_dir . $field_group_file_name;

		_wp_cli_save_field_group_as_json( $json, $base_field_group_path );

		// we store all saved groups file names.
		$exported_field_groups[] = $field_group_file_name;

	}

	// validate.
	if ( count( $exported_field_groups ) < 1 ) {
		WP_CLI::error( __( 'No field groups to export', 'acf-cli' ) );
		return;
	}

	// cleanup unused old files.
	_wp_cli_cleanup_old_files( 'json', $old_json_files, $exported_field_groups );

	// if we need to generate PHP as well.
	if ( ! $json_only ) {

		$old_php_files = glob( $dest_dir . '*.php' );

		// cleanup unused old php files.
		_wp_cli_cleanup_old_files( 'php', $old_php_files, $exported_field_groups );

		// convert new json files to PHP.
		_wp_cli_convert_json_to_php();
	}


	WP_CLI::success( __( 'ACF export completed successfully!', 'acf-cli' ) );

}

/**
 * Saves Field group's definition in JSON files.
 *
 * @param array  $json                 Array object of field group prepared for saving.
 * @param string $base_file_name_path  File path without extension to save data to.
 *
 * @throws \WP_CLI\ExitException  Error if existing file isn't writable to be overwritten.
 */
function _wp_cli_save_field_group_as_json( $json, $base_file_name_path ) {

	// we export one file for each group name.
	$json_file_name = $base_file_name_path . '.json';

	// check permissions.

	if ( file_exists( $json_file_name ) && ! is_writable( $json_file_name ) ) {
		WP_CLI::error( __( 'Error: operation not permitted! Please, ensure that PHP has write access to the file:', 'acf-cli' ) . $json_file_name );
	}

	// write JSON encoded fields.
	file_put_contents( $json_file_name, acf_json_encode( $json ) );

}

/**
 * Generate base file name without extension for our exported Field group.
 *
 * @param array $field_group field group definition with $field_group[key], $field_group[title].
 *
 * @return string
 * @throws \WP_CLI\ExitException Error if wrong field_group array missing `key` and `title` passed in.
 */
function _wp_cli_get_field_group_file_name( $field_group = array() ) {

	if ( empty( $field_group['title'] ) || empty( $field_group['key'] ) ) {
		WP_CLI::error( __( 'No field groups to export', 'acf-cli' ) );
	}

	// generate human readable__machine name.
	$field_group_title = preg_replace( '/[^a-z0-9_\-]/', '_', strtolower( $field_group['title'] ) );
	$field_group_title = preg_replace( '/[_]+/', '_', $field_group_title );

	return $field_group_title . '__' . $field_group['key'];

}

/**
 * Generates new acf-fields.php file which explicitly links all field groups files.
 *
 * @param array $exported_field_groups  Array of field groups names title__key without extension.
 *
 * @return false|int
 */
function _wp_cli_generate_php_linking_file( $exported_field_groups = array() ) {

	$php_linking_file_name = get_template_directory() . '/includes/acf-fields.php';

	// let's generate PHP linking file.
	$theme_slug = get_template();

	$php_linking_file_content  = "<?php\n";
	$php_linking_file_content .= "/**\n";
	$php_linking_file_content .= " * ACF field groups linked separately.\n";
	$php_linking_file_content .= " *\n";
	$php_linking_file_content .= " * @package $theme_slug;\n";
	$php_linking_file_content .= " */\n\n";
	$php_linking_file_content .= "if ( function_exists( 'acf_add_local_field_group' ) ) :\n\n";

	foreach ( $exported_field_groups as $exported_field_group_file_name ) {

		$php_linking_file_content .= "\trequire_once __DIR__ . '/acf-fields/$exported_field_group_file_name.php';\n";

	}

	$php_linking_file_content .= "\nendif;\n";

	return file_put_contents( $php_linking_file_name, $php_linking_file_content );

}

/**
 * Removes only old unused php\json files from directory.
 *
 * @param string $type                  php|json type of files to work with.
 * @param array  $old_files             Array of old file paths to work with.
 * @param array  $exported_field_groups Array of new field group file names without extension to check not to remove necessary files.
 */
function _wp_cli_cleanup_old_files( $type = 'php', $old_files = array(), $exported_field_groups = array() ) {

	foreach ( $old_files as $old_file_path ) {
		$name = basename( $old_file_path, '.' . $type );
		if ( false === array_search( $name, $exported_field_groups, true ) ) {
			WP_CLI::log( __( 'Removing Old Unnecessary ', 'acf-cli' ) . $type . ': ' . $old_file_path );
			unlink( $old_file_path );
		}
	}

}

/**
 * Converts JSON of fields definition to PHP code.
 *
 * @param array $json
 *
 * @return string
 */
function _acf_json_to_php( $json ) {
	$str_replace  = array(
		'  '         => "\t",
		"'!!__(!!\'" => "__('",
		"!!\', !!\'" => "', '",
		"!!\')!!'"   => "')",
		'array ('    => 'array(',
	);
	$preg_replace = array(
		'/([\t\r\n]+?)array/' => 'array',
		'/[0-9]+ => array/'   => 'array',
	);

	$php = '<?php' . "\n" . "\n" . "if( function_exists('acf_add_local_field_group') ):" . "\n" . "\n";

	foreach ( $json as $field_group ) {

		// code.
		$code = var_export( $field_group, true );

		// change double spaces to tabs.
		$code = str_replace( array_keys( $str_replace ), array_values( $str_replace ), $code );

		// correctly formats "=> array(" .
		$code = preg_replace( array_keys( $preg_replace ), array_values( $preg_replace ), $code );

		$php .= "acf_add_local_field_group({$code});\n\n";
	}

	$php .= "endif;\n";

	return $php;
}

/**
 * Converts all JSON field definitions to PHP.
 *
 * @throws \WP_CLI\ExitException Error.
 */
function _wp_cli_convert_json_to_php() {

	$dest_dir = get_template_directory() . '/includes/acf-fields/';

	$json_files = glob( $dest_dir . '*.json' );

	$exported_field_groups = array();

	foreach ( $json_files as $json_file ) {
		$name = basename( $json_file, '.json' );

		$exported_field_groups[] = $name;

		$php_file_name = $dest_dir . $name . '.php';

		// write PHP representation of ACF fields.
		file_put_contents( $php_file_name, _acf_json_to_php( json_decode( file_get_contents( $json_file ), true ) ) );

	}

	// generating primary acf-fields.php linking file for field groups.
	if ( false === _wp_cli_generate_php_linking_file( $exported_field_groups ) ) {
		WP_CLI::error( __( 'Error Writing /includes/acf-fields.php file', 'acf-cli' ) );
	}

	WP_CLI::success( __( 'ACF JSON Converted to PHP!', 'acf-cli' ) );

}



if ( defined( 'WP_CLI' ) && WP_CLI ) {

	// legacy approach with all fields in one file.
	WP_CLI::add_command( 'acf-import', '_wp_cli_acf_import_legacy' );
	WP_CLI::add_command( 'acf-export', '_wp_cli_acf_export_legacy' );

	// new approach.
	WP_CLI::add_command( 'acf export', '_wp_cli_acf_export_new' );
	WP_CLI::add_command( 'acf import', '_wp_cli_acf_import_new' );
	WP_CLI::add_command( 'acf export-json', '_wp_cli_export_to_json_directly' );
	WP_CLI::add_command( 'acf convert-json', '_wp_cli_convert_json_to_php' );
}
