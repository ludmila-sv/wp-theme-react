<?php
/**
 * Gravity Forms customizations.
 *
 * @package pressfoundry
 */

/**
 * Gravity form spinner
 *
 * @param string $image_src spinner's src.
 * @param string $form gravity form.
 * @return string
 */
function pf_spinner_url( $image_src, $form ) {
	return get_template_directory_uri() . '/assets/images/gforms/spinner.svg';
}
add_filter( 'gform_ajax_spinner_url', 'pf_spinner_url', 10, 2 );
