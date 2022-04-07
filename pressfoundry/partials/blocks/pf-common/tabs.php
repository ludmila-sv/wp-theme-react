<?php
/**
 * Tabs block.
 *
 * @package pressfoundry
 */

$block_id = 'tabs-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'tabs';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}
$template       = array(
	array(
		'acf/tab',
		array(),
	),
	array(
		'acf/tab',
		array(),
	),
);
$allowed_blocks = array(
	'acf/tab',
);

?>

<div  id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<div class="tabs-nav"><ul></ul></div>
	<div class="tabs-content">
		<InnerBlocks template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>"
			allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" />
	</div>
</div>
