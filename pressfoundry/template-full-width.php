<?php
/**
 * Full width page.
 *
 * Template Name: Full-width Page
 *
 * @package pressfoundry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; }

get_header();

the_post();

the_content();

get_footer();
