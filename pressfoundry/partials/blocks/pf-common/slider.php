<?php
/**
 * Slider partial.
 *
 * @package pressfoundry
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'slider-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'slider';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}

$template = array(
	array(
		'acf/slider-slide',
		array(),
	),
	array(
		'acf/slider-slide',
		array(),
	),
);

$allowed_blocks = array(
	'acf/slider-slide',
);
?>
<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<div class="slick-slider-js">
		<InnerBlocks template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>"
			allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" />
	</div>
	<div class="slick-controls d-none">
		<div class="slick-prev"></div>
		<div class="slick-next"></div>
	</div>
</div>
