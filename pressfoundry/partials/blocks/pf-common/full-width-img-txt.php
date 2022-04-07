<?php
/**
 * Full-Width Image&Text block.
 *
 * @package pressfoundry
 */

$block_id = 'full-width-img-txt-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'full-width-img-txt full-width';

if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
$align       = get_field( 'alignment' ) ? get_field( 'alignment' ) : 'left';
$class_name .= ' text-block-' . $align;

$style = '';
if ( get_field( 'image' ) ) {
	$style = ' style="background-image: url( ' . wp_get_attachment_image_url( get_field( 'image' ), 'full' ) . ' );"';
}
?>

<section  id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<div class="full-width-img-txt__img d-none d-lg-block"<?php echo $style; // phpcs:ignore ?>></div>
	<div class="full-width-img-txt__img d-lg-none">
		<?php echo wp_get_attachment_image( get_field( 'image' ), 'large', false, array( 'class' => 'img-block' ) ); ?>
	</div>
	<div class="full-width-img-txt__container">
		<div class="full-width-img-txt__txt">
			<InnerBlocks />
		</div>
	</div>
</section>
