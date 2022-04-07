<?php
/**
 * Set Content-Security-Policy headers and related stuff here.
 *
 * @package pressfoundry
 */

/**
 * Adds CSP HTTP headers before they're sent to the browser.
 *
 * @param string[] $headers Associative array of headers to be sent.
 * @param WP       $wp      Current WordPress environment instance.
 *
 * @return string[];
 */
function pf_csp_headers( $headers, $wp ) {

	if ( ! is_admin() ) {

		// By Default we disallow insertion of a website into iframe on some other sites, except this one.
		$headers['Content-Security-Policy'] = "frame-ancestors 'self'";

	}

	return $headers;
}
add_filter( 'wp_headers', 'pf_csp_headers', 10, 2 );
