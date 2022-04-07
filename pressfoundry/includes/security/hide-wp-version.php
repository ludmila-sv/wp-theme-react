<?php
/**
 *  Hiding WP version from being displayed in html.
 *
 * @package pressfoundry
 */

remove_action( 'wp_head', 'wp_generator' );
