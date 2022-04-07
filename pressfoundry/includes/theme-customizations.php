<?php
/**
 * Theme customizations.
 *
 * @package pressfoundry
 */

/**
 * Add custom classes to body
 *
 * @param array $class Body Class.
 *
 * @return array
 */
function pf_body_class( $class ) {
	if ( 'fancybox' === get_field( 'gallery_lightbox_script', 'option' ) ) {
		$class[] = 'gallery-fancybox';
	} elseif ( 'pf' === get_field( 'gallery_lightbox_script', 'option' ) ) {
		$class[] = 'gallery-pf';
	} else {
		$class[] = 'gallery-fancybox';
	}

	return $class;
}

add_filter( 'body_class', 'pf_body_class', 10, 1 );

/**
 * Search among blog posts only
 *
 * @param object $query - wp query result.
 */
function pf_get_posts_search_filter( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_search ) {
		$query->set( 'post_type', array( 'post' ) );
	}
}

// add_action( 'pre_get_posts', 'pf_get_posts_search_filter' );

/**
 * Disable default Related Posts for WordPress output.
 */
// add_filter( 'rp4wp_append_content', '__return_false' );


/**
 * Remove Emoji
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

/**
 * Remove script type="text/javascript" for validator.w3.org
 *
 * @param string $tag The `<script>` tag for the enqueued script.
 * @param string $handle The script's registered handle.
 *
 * @return string;
 */
function pf_remove_type_attr( $tag, $handle ) {
	return preg_replace( "/ type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}

add_filter( 'style_loader_tag', 'pf_remove_type_attr', 10, 2 );
add_filter( 'script_loader_tag', 'pf_remove_type_attr', 10, 2 );

add_action(
	'template_redirect',
	function () {
		ob_start(
			function ( $buffer ) {
				$buffer = str_replace( array( ' type="text/javascript"', " type='text/javascript'" ), '', $buffer );
				$buffer = str_replace( array( ' type="text/css"', " type='text/css'" ), '', $buffer );

				return $buffer;
			}
		);
	}
);

/**
 * Modifies wp-spacer block
 *
 * @param string $block_content - the block content.
 * @param object $block - the block object.
 *
 * @return string;
 */
function pf_spacer_block( $block_content, $block ) {
	if ( 'core/spacer' !== $block['blockName'] ) {
		return $block_content;
	}
	$pattern = '/\sstyle="height:(\d+)px"/i';
	preg_match( $pattern, $block_content, $matches );
	$height = $matches[1];
	$return = '<div aria-hidden="true" class="wp-block-spacer">';
	$return .= '<div class="d-none d-lg-block" style="height:' . $height . 'px"></div>';
	$return .= '<div class="d-lg-none" style="height:' . $height / 2 . 'px"></div>';
	$return .= '</div>';

	return $return;
}

add_filter( 'render_block', 'pf_spacer_block', 10, 2 );

/**
 * Change excerpt length
 *
 * @package pressfoundry
 */
add_filter(
	'excerpt_length',
	function () {
		return 20;
	}
);

/**
 * Change excerpt read more text.
 *
 * @package pressfoundry
 */
function pf_excerpt_more() {
	global $post;

	return ' ...';
}

add_filter( 'excerpt_more', 'pf_excerpt_more' );

