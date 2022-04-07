<?php
/**
 * Gutenberg Customization.
 *
 * @package pressfoundry
 */

/**
 * Declare registration of block styles for headings, paragraphs, buttons and other standard blocks.
 *
 * @return void
 */
function pf_register_block_styles() {

	if ( function_exists( 'register_block_style' ) ) {

		$theme_block_styles = require __DIR__ . DIRECTORY_SEPARATOR . 'gutenberg' . DIRECTORY_SEPARATOR . 'block-styles.php';

		if ( is_array( $theme_block_styles ) ) {
			foreach ( $theme_block_styles as $block_name => $block_styles ) {
				// it's quick short fallback if there's only one style and someone made mistake, forgetting wrapping it into array - we just wrap it.
				if ( ! empty( $block_styles['name'] ) ) {
					$block_styles = array( $block_styles );
				}

				foreach ( $block_styles as $style_properties ) {
					register_block_style( $block_name, $style_properties );
				}
			}
		}
	}
}

add_filter( 'init', 'pf_register_block_styles', 10 );


/**
 * Define preset of font sizes.
 *
 * @return void
 */
function pf_setup_font_sizes() {

	add_theme_support(
		'editor-font-sizes',
		require __DIR__ . DIRECTORY_SEPARATOR . 'gutenberg' . DIRECTORY_SEPARATOR . 'font-sizes.php'
	);
}

add_action( 'after_setup_theme', 'pf_setup_font_sizes' );


/**
 * Setup colors for theme.
 *
 * @return void
 */
function pf_setup_color_palette() {
	// Editor Color Palette.
	add_theme_support(
		'editor-color-palette',
		require __DIR__ . DIRECTORY_SEPARATOR . 'gutenberg' . DIRECTORY_SEPARATOR . 'colors.php'
	);
}

add_action( 'after_setup_theme', 'pf_setup_color_palette' );

/**
 * Links block patterns and block patterns category definitions.
 *
 * @return void
 */
function pf_setup_block_patterns() {

	/* We load those from file, it's just PHP array of block pattern slugs.  */
	$block_patterns = require __DIR__ . DIRECTORY_SEPARATOR . 'gutenberg' . DIRECTORY_SEPARATOR . 'block-patterns.php';

	register_block_pattern_category(
		'pf',
		array( 'label' => __( 'Press Foundry' ) )
	);

	foreach ( $block_patterns as $block_pattern ) {
		register_block_pattern(
			'pf/' . $block_pattern,
			require __DIR__ . '/block-patterns/' . $block_pattern . '.php'
		);
	}

}

add_action( 'after_setup_theme', 'pf_setup_block_patterns' );
