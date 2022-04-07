<?php
/**
 * Image with Link block.
 *
 * @package pressfoundry
 */

$class_name = 'image-link';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! get_field( 'image' ) ) {
	$class_name .= ' no-img';
}

$button        = get_field( 'link' );
$button_url    = $button['url'] ? $button['url'] : '#';
$button_title  = $button['title'] ? $button['title'] : '';
$button_target = $button['target'] ? $button['target'] : '_self';
?>

<div class="<?php echo esc_attr( $class_name ); ?>">
	<?php if ( get_field( 'image' ) ) { ?>
		<div class="image-link__image"><img src="<?php echo esc_url( wp_get_attachment_image_url( get_field( 'image' ), 'large' ) ); ?>" alt="" /></div>
	<?php } ?>
	<div class="image-link__link"><a class="btn btn-tertiary" href="<?php echo esc_url( $button_url ); ?>" target="<?php echo esc_attr( $button_target ); ?>"><?php echo esc_html( $button_title ); ?></a></div>
</div>
