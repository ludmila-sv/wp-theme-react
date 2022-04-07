<?php
/**
 * Slide block partial.
 *
 * @package pressfoundry
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'slider-slide-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'slider__slide';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
$template = array(
	array(
		'core/image',
		array(),
	),
);
?>
<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<InnerBlocks template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" />
</div>
