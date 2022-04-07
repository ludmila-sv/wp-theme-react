<?php
/**
 *  Main Theme Functions - link and implement all theme specific functionality here.
 *
 * @package pressfoundry
 */

/**
 * We include modules of theme, order matters!
 */
require_once __DIR__ . '/includes/acf-load.php';
require_once __DIR__ . '/includes/acf-enhancements.php';
require_once __DIR__ . '/includes/wp-cli-acf-tools.php';
require_once __DIR__ . '/includes/tinymce-plugins.php';
require_once __DIR__ . '/includes/class-clean-walker.php';
require_once __DIR__ . '/includes/dashboard/pressfoundry-logo.php';
require_once __DIR__ . '/includes/security/csp.php';
//require_once __DIR__ . '/includes/security/disable-public-rest.php';
require_once __DIR__ . '/includes/security/password-protected.php';
require_once __DIR__ . '/includes/security/hide-wp-version.php';
require_once __DIR__ . '/includes/head-top-footer-scripts.php';
require_once __DIR__ . '/includes/gforms-customizations.php';
require_once __DIR__ . '/includes/gutenberg-customizer.php';
require_once __DIR__ . '/includes/theme-customizations.php';
require_once __DIR__ . '/includes/theme-installer.php';
require_once __DIR__ . '/includes/react.php';


/**
 * Returns version string for assets.
 *
 * @return null|string
 */
function _get_asset_version() {

	return defined( 'ENV_DEV' ) ||
			( function_exists( 'is_wpe' ) && ! is_wpe() )
		? gmdate( 'YmdHis' ) : wp_get_theme()->get( 'Version' );

}


/**
 * Returns a google fonts url to be used in stylesheets
 *
 * @return string
 */
function _get_fonts_loading_url() {

	// TODO fill in here your font's URL.
	return '';// 'https://fonts.googleapis.com/css?family=Noto+Serif:400,700|Source+Sans+Pro:300,400,400i,700,700i';

}

/**
 * Theme setup hooks
 */
function pf_after_setup_theme() {

	if ( ! defined( 'WP_DEBUG' ) || ( defined( 'WP_DEBUG' ) && ! WP_DEBUG ) ) {
		show_admin_bar( false );
	}

	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'wp-block-styles' ); // required for blocks editor styles in Gutenberg.

	register_nav_menus(
		array(
			'primary' => 'Main Menu',
		)
	);

	add_editor_style(
		array(
			get_template_directory_uri() . '/assets/css/editor-style.css?ver=' . _get_asset_version(),
			_get_fonts_loading_url(),
		)
	);

}

add_action( 'after_setup_theme', 'pf_after_setup_theme' );


/**
 * Theme scripts and styles
 *
 * @return void
 */
function pf_enqueue_scripts() {

	$asset_version = _get_asset_version();
	$main_js_asset = include get_template_directory() . '/assets/js/main.asset.php';

	// it loads only necessary polyfills depending on browser.
	wp_enqueue_script( 'polyfill', 'https://polyfill.io/v3/polyfill.min.js', array(), '3.0', true );

	// for the gallery wp block.
	wp_enqueue_script(
		'fancybox',
		'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js',
		array(
			'jquery',
		),
		'3.5.7',
		true
	);

	/*
	// probably unnecessary as we do most work by custom js code.
	wp_enqueue_script(
		'bootstrap-js',
		'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js',
		array(
			'jquery',
		// 'popper-js' // add this if needed. see wp_enqueue_script below !
		),
		'4.4.1',
		true
	);
	*/

	//phpcs:ignore
	// wp_enqueue_script('popper-js', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array('jquery'), '1.16.0', true );

	/**
	 * Optimization Hints:
	 *  - make sure you really need fontawesome and bootstrap.
	 *  - bootstrap.scss can be linked to main.scss,
	 *  - can prepare single fonts linking file,
	 *  - self host google fonts font files.
	 */
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/assets/fonts/fontawesome/css/fontawesome-all.min.css', null, $asset_version );
	wp_enqueue_style( 'googlefonts', _get_fonts_loading_url(), null, $asset_version );
	wp_enqueue_style( 'fancybox', 'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css', null, '3.5.7' );

	wp_enqueue_style( 'pressfoundry-bs-style', get_template_directory_uri() . '/assets/css/bootstrap.css', null, $asset_version );
	wp_enqueue_style( 'pressfoundry-style', get_template_directory_uri() . '/assets/css/main.css', array( 'pressfoundry-bs-style' ), $asset_version );

	wp_enqueue_script(
		'pressfoundry-scripts',
		get_template_directory_uri() . '/assets/js/main.js',
		$main_js_asset['dependencies'],
		$main_js_asset['version'],
		true
	);

}

add_action( 'wp_enqueue_scripts', 'pf_enqueue_scripts' );

/**
 * Renders `<link rel="preload" href="">` tags for registered css files, for better performance.
 *
 * See:
 * https://web.dev/uses-rel-preload/
 * https://developer.mozilla.org/en-US/docs/Web/HTML/Preloading_content
 *
 * @return void
 */
function pf_preload_styles() {

	/**
	 * NB: you can also preconnect to font's server in case they are not self hosted. `preconnect` or `dns-prefetch` - NOT BOTH!
	 * and they should be listed before preloading fonts, and css.
	 */
	// echo '<link rel="preconnect" href="https://hello.myfonts.net" crossorigin>';

	/**
	 * Also preloading woff2 files of fonts gives good performance gain, and mitigates font flickering.
	 * You need only woff2 file of each font's file
	 */
	// echo '<link rel="preload" href="' . esc_attr( get_template_directory_uri() ) . '/assets/fonts/font-name/font-file.woff2" as="font" type="font/woff2" crossorigin>';

	$styles = wp_styles();

	foreach ( $styles->queue as $handle ) {

		$obj = $styles->registered[ $handle ];

		if ( null === $obj->ver ) {
			$ver = '';
		} else {
			$ver = $obj->ver ? $obj->ver : $styles->default_version;
		}

		if ( isset( $styles->args[ $handle ] ) ) {
			$ver = $ver ? $ver . '&amp;' . $styles->args[ $handle ] : $styles->args[ $handle ];
		}

		$src  = $obj->src;
		$href = $styles->_css_href( $src, $ver, $handle );
		echo '<link rel="preload" href="' . esc_attr( $href ) . '" as="style" type="text/css" crossorigin>';
	}
}

add_action( 'wp_head', 'pf_preload_styles', 3 );

/**
 * Outputs secured bootstrap-js tag with integrity checks, add other CDN loaded scripts here if there are any.
 *
 * @param string $tag The `<script>` tag for the enqueued script.
 * @param string $handle The script's registered handle.
 * @param string $src The script's source URL.
 *
 * @return string;
 */
function pf_external_scripts_integrity( $tag, $handle, $src ) {

	// add other script-handle => secured script tag here.
	$scripts = array(
		'bootstrap-js' => '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>',
		// phpcs:ignore
		'popper-js'    => '<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>',
		// phpcs:ignore
	);

	// it will replace only necessary one.
	if ( isset( $scripts[ $handle ] ) ) {
		$tag = $scripts[ $handle ];
	}

	return $tag;
}

add_filter( 'script_loader_tag', 'pf_external_scripts_integrity', 10, 3 );


/**
 * Enqueue block editor style for Gutenberg Blocks
 */
function pf_block_editor_styles() {
	$asset_version = _get_asset_version();

	wp_enqueue_style( 'googlefonts', _get_fonts_loading_url(), null, $asset_version );
	wp_enqueue_style( 'pressfoundry-blocks-editor-style', get_theme_file_uri( '/assets/css/blocks-editor-style.css' ), false, $asset_version, 'all' );

}

add_action( 'enqueue_block_editor_assets', 'pf_block_editor_styles' );

