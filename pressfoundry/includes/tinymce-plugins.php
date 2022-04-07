<?php
/**
 *  Extend TinyMCE with new buttons and features.
 *
 * @package pressfoundry
 */

/**
 * Injects Ids of new buttons to tinyMCE. So later we add JS code to handle those buttons actions via these handles.
 *
 * @param array $buttons Existing buttons handles array.
 *
 * @return array
 */
function pf_mce_buttons_filter( $buttons ) {

	$buttons[] = 'btn_link';

//	$buttons[] = 'btn_fb_post';

	return $buttons;

}

add_filter( 'mce_buttons', 'pf_mce_buttons_filter' );


/**
 * Adds button's JS to tinyMCE.
 *
 * @param array $plugin_array Existing array of tinyMCE plugins JS scripts.
 *
 * @return array
 */
function pf_mce_external_plugins_filter( $plugin_array ) {

	$plugin_array['btn_link'] = get_template_directory_uri() . '/admin/btn_link.tinymce.js';

//	$plugin_array['btn_fb_post'] = get_template_directory_uri() . '/admin/btn_fb_post.tinymce.js';

	return $plugin_array;

}

add_filter( 'mce_external_plugins', 'pf_mce_external_plugins_filter' );

/**
 * Enhances ACF field with JS code which adds field name to wysiwyg fields.
 * So now backend wysiwyg fields can be styled if necessary.
 */
function pf_acf_better_wysiwyg_action() {

	echo '<script src="' . esc_attr( get_template_directory_uri() ) . '/admin/acf.better.wysiwyg.js' . '"></script>'; //phpcs:ignore

}

add_action( 'acf/input/admin_footer', 'pf_acf_better_wysiwyg_action' );
