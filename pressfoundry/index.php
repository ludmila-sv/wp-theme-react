<?php
/**
 *  Index Fallback template or Blog archive page
 *
 * @package pressfoundry
 */

/**
 * Theme scripts should be enabled after the DOM element is created by react.
 * So we enqueue scripts in react.
 *
 * @package pressfoundry
 */
function pf_dequeue_scripts() {
	wp_dequeue_script( 'pressfoundry-scripts' );
	// wp_deregister_script( 'pressfoundry-scripts' );
}
add_action( 'wp_print_scripts', 'pf_dequeue_scripts' );

get_header();

//$blog_url .= ( $current_page > 1 ) ? 'page/' . $current_page . '/';
?>

<?php // get_template_part( 'partials/headless/header' ); ?>

<div class="content" id="react-app-posts"></div>

<?php // get_template_part( 'partials/headless/footer' ); ?>
<?php get_footer(); ?>
