<?php
/**
 * Image & Text block.
 *
 * @package pressfoundry
 */

$block_id = 'img-txt-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'img-txt full-width';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}
if ( get_field( 'bg' ) ) {
	$class_name .= ' bg-color-' . get_field( 'bg' );
}
if ( get_field( 'align' ) ) {
	$class_name .= ' img-align-' . get_field( 'align' );
}
?>

<section  id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="img-txt__img">
					<?php echo wp_get_attachment_image( get_field( 'image' ), 'large', false, array( 'class' => '' ) ); ?>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="img-txt__txt">
					<InnerBlocks />
				</div>
			</div>
		</div>
	</div>
</section>
