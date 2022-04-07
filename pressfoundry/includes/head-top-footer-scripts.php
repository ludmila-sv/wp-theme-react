<?php
/**
 *  Injects scripts\html to head\body_top and footer.
 *
 * @package pressfoundry
 */

/**
 * Adds output to html head
 *
 * @return void
 */
function pf_wp_head() {

	if ( function_exists( 'is_wpe' ) && is_wpe() ) {
		if ( get_field( 'header_scripts_production', 'options' ) ) {
			the_field( 'header_scripts_production', 'options' );
		}
	} elseif ( get_field( 'header_scripts_staging', 'options' ) ) {

		the_field( 'header_scripts_staging', 'options' );
	}

}
add_action( 'wp_head', 'pf_wp_head' );


/**
 * Outputs code on top right after opening Body tag.
 * At least for facebook SDK init
 *
 * @return void
 */
function pf_body_top() {

	if ( function_exists( 'is_wpe' ) && is_wpe() ) {
		if ( get_field( 'body_top_scripts_production', 'options' ) ) {
			the_field( 'body_top_scripts_production', 'options' );
		}
	} elseif ( get_field( 'body_top_scripts_staging', 'options' ) ) {
		the_field( 'body_top_scripts_staging', 'options' );
	}
}
add_action( 'body_top', 'pf_body_top' );


/**
 * Adds output to html head
 *
 * @return void
 */
function pf_wp_footer() {

	if ( function_exists( 'is_wpe' ) && is_wpe() ) {
		if ( get_field( 'footer_scripts_production', 'options' ) ) {
			the_field( 'footer_scripts_production', 'options' );
		}
	} elseif ( get_field( 'footer_scripts_staging', 'options' ) ) {
		the_field( 'footer_scripts_staging', 'options' );
	}

}
add_action( 'wp_footer', 'pf_wp_footer' );
