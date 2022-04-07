<?php
/**
 * Link this file if you need these functions.
 *
 * @package pressfoundry
 */

/**
 * Like get_template_part() put lets you pass args to the template file
 * Args are available in the template as $template_args array
 *
 * @param string $file_handle        partial file name.
 * @param array  $template_args      style argument list.
 * @param array  $cache_args         argument list to be cached.
 * @return  void|bool|string
 */
function _get_template_part( $file_handle, $template_args = array(), $cache_args = array() ) {

	$template_args = wp_parse_args( $template_args );
	$cache_args    = wp_parse_args( $cache_args );

	if ( $cache_args ) {

		foreach ( $template_args as $key => $value ) {
			if ( is_scalar( $value ) || is_array( $value ) ) {
				$cache_args[ $key ] = $value;
			} elseif ( is_object( $value ) && method_exists( $value, 'get_id' ) ) {
				$cache_args[ $key ] = call_user_func( array( $value, 'get_id' ) );
			}
		}

		$cache = wp_cache_get( $file_handle, wp_json_encode( $cache_args ) );

		if ( false !== $cache ) {

			if ( ! empty( $template_args['return'] ) ) {
				return $cache;
			}

			echo $cache; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			return;
		}
	}

	$file = '';

	do_action( 'start_operation', '_get_template_part::' . $file_handle );

	if ( file_exists( get_stylesheet_directory() . '/' . $file_handle . '.php' ) ) {
		$file = get_stylesheet_directory() . '/' . $file_handle . '.php';
	} elseif ( file_exists( get_template_directory() . '/' . $file . '.php' ) ) {
		$file = get_template_directory() . '/' . $file_handle . '.php';
	}

	ob_start();
	$return = require $file;
	$data   = ob_get_clean();

	do_action( 'end_operation', '_get_template_part::' . $file_handle );

	if ( $cache_args ) {
		wp_cache_set( $file, $data, wp_json_encode( $cache_args ), 3600 );
	}

	if ( ! empty( $template_args['return'] ) ) {
		if ( false === $return ) {
			return false;
		} else {
			return $data;
		}
	}

	echo $data; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

}
