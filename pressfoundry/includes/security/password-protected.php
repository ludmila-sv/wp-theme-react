<?php
/**
 *  Password protected posts\pages\cpts logic.
 *
 * @package pressfoundry
 */

/**
 * Shows template for password requesting for in case Post\Page of CPT item is password protected.
 */
function pf_post_check_protected() {

	if ( current_user_can( 'administrator' ) ) {
		return;
	}

	if ( is_singular() || is_page() ) {

		if ( post_password_required() ) {

			get_template_part( 'template-password' );
			exit();

		}
	}
}

add_action( 'template_redirect', 'pf_post_check_protected' );
