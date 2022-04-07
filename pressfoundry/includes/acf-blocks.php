<?php
/**
 *  Place all ACF powered blocks definitions here.
 *
 * @package pressfoundry
 */

/**
 * Registers ACF blocks.
 */
function pf_register_acf_block_types() {

	acf_register_block_type(
		array(
			'name'            => 'fixed-width',
			'title'           => __( 'Fixed Width' ),
			'description'     => __( 'Fixed width content (wysiwyg)' ),
			'render_template' => 'partials/blocks/common/fixed-width.php',
			'category'        => 'formatting',
			'keywords'        => array( 'common', 'content', 'fixed', 'width' ),
			'icon'            => 'fullscreen-exit-alt',
			'supports'        => array(
				'align'           => false,
				'anchor'          => true,
				'customClassName' => true,
				'jsx'             => true,
			),
		)
	);

	acf_register_block_type(
		array(
			'name'            => 'full-width',
			'title'           => __( 'Full Width' ),
			'description'     => __( 'Full width content for posts.' ),
			'render_template' => 'partials/blocks/common/full-width.php',
			'category'        => 'formatting',
			'keywords'        => array( 'common', 'content', 'full', 'width' ),
			'icon'            => 'fullscreen-alt',
			'supports'        => array(
				'align'           => false,
				'anchor'          => true,
				'customClassName' => true,
				'jsx'             => true,
			),
		)
	);

	acf_register_block_type(
		array(
			'name'            => 'pre-heading',
			'title'           => __( 'Pre-heading' ),
			'description'     => __( 'Text above a Heading' ),
			'render_template' => 'partials/blocks/common/pre-heading.php',
			'category'        => 'formatting',
			'keywords'        => array( 'pre-heading', 'preheading' ),
			'mode'            => 'auto',
			'icon'            => 'heading',
			'supports'        => array(
				'align'           => false,
				'anchor'          => true,
				'customClassName' => true,
				'jsx'             => false,
			),
		)
	);

	acf_register_block_type(
		array(
			'name'            => 'hero',
			'title'           => __( 'Hero' ),
			'description'     => __( 'Hero' ),
			'render_template' => 'partials/blocks/pf-common/hero.php',
			'category'        => 'pressfoundry',
			'keywords'        => array( 'hero' ),
			'mode'            => 'preview',
			'icon'            => 'cover-image',
			'supports'        => array(
				'mode'            => false,
				'align'           => false,
				'anchor'          => true,
				'customClassName' => true,
				'jsx'             => true,
			),
		)
	);

	acf_register_block_type(
		array(
			'name'            => 'page-header',
			'title'           => __( 'Page Header' ),
			'description'     => __( 'Page Header' ),
			'render_template' => 'partials/blocks/pf-common/page-header.php',
			'category'        => 'pressfoundry',
			'keywords'        => array( 'page header', 'header' ),
			'icon'            => 'heading',
			'supports'        => array(
				'align'           => false,
				'anchor'          => true,
				'customClassName' => true,
				'jsx'             => true,
			),
		)
	);

	acf_register_block_type(
		array(
			'name'            => 'cta',
			'title'           => __( 'CTA' ),
			'description'     => __( 'CTA' ),
			'render_template' => 'partials/blocks/pf-common/cta.php',
			'category'        => 'pressfoundry',
			'keywords'        => array( 'cta' ),
			'icon'            => 'megaphone',
			'supports'        => array(
				'align'           => false,
				'anchor'          => true,
				'customClassName' => true,
				'jsx'             => true,
			),
		)
	);

	acf_register_block_type(
		array(
			'name'            => 'audio',
			'title'           => __( 'Audio Button' ),
			'description'     => __( 'Audio Button' ),
			'render_template' => 'partials/blocks/pf-common/audio.php',
			'category'        => 'pressfoundry',
			'keywords'        => array( 'autio' ),
			'icon'            => 'embed-audio',
			'supports'        => array(
				'align'           => false,
				'anchor'          => true,
				'customClassName' => true,
				'jsx'             => true,
			),
		)
	);

	acf_register_block_type(
		array(
			'name'            => 'accordion',
			'title'           => __( 'Accordion' ),
			'description'     => __( 'Accordion' ),
			'render_template' => 'partials/blocks/pf-common/accordion.php',
			'category'        => 'pressfoundry',
			'keywords'        => array( 'accordion' ),
			'icon'            => 'menu-alt',
			'supports'        => array(
				'align'           => false,
				'anchor'          => true,
				'customClassName' => true,
				'jsx'             => true,
			),
		)
	);

	acf_register_block_type(
		array(
			'name'            => 'tabs',
			'title'           => __( 'Tabs' ),
			'description'     => __( 'Tabs' ),
			'render_template' => 'partials/blocks/pf-common/tabs.php',
			'category'        => 'pressfoundry',
			'keywords'        => array( 'tabs' ),
			'icon'            => 'admin-page',
			'supports'        => array(
				'align'           => false,
				'anchor'          => true,
				'customClassName' => true,
				'jsx'             => true,
			),
		)
	);

	acf_register_block_type(
		array(
			'name'            => 'tab',
			'title'           => __( 'Tab' ),
			'description'     => __( 'Tab' ),
			'render_template' => 'partials/blocks/pf-common/tab.php',
			'category'        => 'pressfoundry',
			'keywords'        => array( 'tab' ),
			'parent'          => array(
				'acf/tabs',
			),
			'icon'            => 'media-default',
			'supports'        => array(
				'align'           => false,
				'anchor'          => true,
				'customClassName' => true,
				'jsx'             => true,
			),
		)
	);

	acf_register_block_type(
		array(
			'name'            => 'slider',
			'title'           => __( 'Slider' ),
			'description'     => __( 'Slider' ),
			'render_template' => 'partials/blocks/pf-common/slider.php',
			'category'        => 'pressfoundry',
			'keywords'        => array( 'slider' ),
			'icon'            => 'format-gallery',
			'supports'        => array(
				'align'           => false,
				'anchor'          => true,
				'customClassName' => true,
				'jsx'             => true,
			),
		)
	);

	acf_register_block_type(
		array(
			'name'            => 'slider-slide',
			'title'           => __( 'Slide' ),
			'description'     => __( 'Slide used inside slider block' ),
			'render_template' => 'partials/blocks/pf-common/slider-slide.php',
			'category'        => 'pressfoundry',
			'keywords'        => array( 'slide' ),
			'mode'            => 'preview',
			'parent'          => array(
				'acf/slider',
			),
			'icon'            => 'images-alt2',
			'supports'        => array(
				'align'           => false,
				'anchor'          => true,
				'customClassName' => true,
				'jsx'             => true,
			),
		)
	);

	acf_register_block_type(
		array(
			'name'            => 'image-link',
			'title'           => __( 'Image with Link' ),
			'description'     => __( 'Image with Link' ),
			'render_template' => 'partials/blocks/pf-common/image-link.php',
			'category'        => 'pressfoundry',
			'keywords'        => array( 'image', 'link' ),
			'icon'            => 'cover-image',
			'supports'        => array(
				'align'           => false,
				'anchor'          => true,
				'customClassName' => true,
				'jsx'             => true,
			),
		)
	);

	acf_register_block_type(
		array(
			'name'            => 'video-text',
			'title'           => __( 'Video & Text' ),
			'description'     => __( 'Video & Text' ),
			'render_template' => 'partials/blocks/pf-common/video-text.php',
			'category'        => 'pressfoundry',
			'keywords'        => array( 'video', 'text' ),
			'icon'            => 'video-alt3',
			'supports'        => array(
				'align'           => false,
				'anchor'          => true,
				'customClassName' => true,
				'jsx'             => true,
			),
		)
	);

	acf_register_block_type(
		array(
			'name'            => 'video',
			'title'           => __( 'Custom Video' ),
			'description'     => __( 'Video' ),
			'render_template' => 'partials/blocks/pf-common/video.php',
			'category'        => 'pressfoundry',
			'keywords'        => array( 'video', 'text' ),
			'icon'            => 'video-alt3',
			'supports'        => array(
				'align'           => false,
				'anchor'          => true,
				'customClassName' => true,
			),
		)
	);


	acf_register_block_type(
		array(
			'name'            => 'img-txt',
			'title'           => __( 'Image & Text' ),
			'description'     => __( 'Image & Text' ),
			'render_template' => 'partials/blocks/pf-common/img-txt.php',
			'category'        => 'pressfoundry',
			'keywords'        => array( 'image', 'text' ),
			'icon'            => 'align-right',
			'supports'        => array(
				'align'           => false,
				'anchor'          => true,
				'customClassName' => true,
				'jsx'             => true,
			),
		)
	);

	acf_register_block_type(
		array(
			'name'            => 'full-width-img-txt',
			'title'           => __( 'Full-Width Image&Text' ),
			'description'     => __( 'Full-Width Image&Text' ),
			'render_template' => 'partials/blocks/pf-common/full-width-img-txt.php',
			'category'        => 'pressfoundry',
			'keywords'        => array( 'image', 'text' ),
			'icon'            => 'align-right',
			'supports'        => array(
				'align'           => false,
				'anchor'          => true,
				'customClassName' => true,
				'jsx'             => true,
			),
		)
	);

	acf_register_block_type(
		array(
			'name'            => 'text-bg',
			'title'           => __( 'Text Block' ),
			'description'     => __( 'Text on Colored Background' ),
			'render_template' => 'partials/blocks/pf-common/text-bg.php',
			'category'        => 'pressfoundry',
			'keywords'        => array( 'image', 'text' ),
			'icon'            => 'align-right',
			'supports'        => array(
				'align'           => false,
				'anchor'          => true,
				'customClassName' => true,
				'jsx'             => true,
			),
		)
	);

	acf_register_block_type(
		array(
			'name'            => 'page-nav',
			'title'           => __( 'In-Page Navigation' ),
			'description'     => __( 'In-Page Navigation' ),
			'render_template' => 'partials/blocks/pf-common/page-nav.php',
			'category'        => 'pressfoundry',
			'keywords'        => array( 'navigation', 'menu' ),
			'icon'            => 'editor-ul',
			'supports'        => array(
				'align'           => false,
				'anchor'          => true,
				'customClassName' => true,
				'jsx'             => true,
			),
		)
	);

}

// Check if function exists and hook into setup.
if ( function_exists( 'acf_register_block_type' ) ) {
	add_action( 'acf/init', 'pf_register_acf_block_types' );
}
