<?php
/**
 * Fixed Width block partial.
 *
 * @package pressfoundry
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'fixed-width-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'wp-block-fixed-width';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

?>
<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<InnerBlocks />
	</div>
</section>
