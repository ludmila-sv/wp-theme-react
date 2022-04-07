<?php
/**
 *  Disables Public REST disclosure and access.
 *
 * @package pressfoundry
 */

/**
 * Disables unauthenticated access to REST endpoints.
 */
add_filter(
	'rest_authentication_errors',
	function ( $result ) {

		// maybe authentication error already set.
		if ( empty( $result ) ) {
			if ( ! is_user_logged_in() ) {
				return new WP_Error( 'rest_not_logged_in', 'You are not currently logged in.', array( 'status' => 401 ) );
			}
		}

		return $result;
	}
);

add_action(
	'init',
	function () {

		if ( ! is_user_logged_in() ) {

			// to remove <link rel="https://api.w.org/" href="/wp-json/"> from head.
			remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );

			// to remove lines about rest api endpoint in /xmlrpc.php?rsd .
			remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );

			// to remove http header `Link: <https://example.com/wp-json/>; rel="https://api.w.org/"` .
			remove_action( 'template_redirect', 'rest_output_link_header', 11 );
		}

	}
);

