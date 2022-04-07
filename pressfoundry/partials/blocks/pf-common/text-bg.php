<?php
/**
 * CTA block.
 *
 * @package pressfoundry
 */

$block_id = 'text-bg-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'text-bg full-width';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}
if ( get_field( 'bg' ) ) {
	$class_name .= ' bg-color-' . get_field( 'bg' );
}
?>

<section  id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-hd-5">
				<?php if ( get_field( 'title' ) ) { ?>
					<h2 class="text-bg__title"><?php the_field( 'title' ); ?></h2>
				<?php } ?>
				<?php if ( get_field( 'button' ) ) { ?>
					<div class="text-bg__btn">
						<?php
						$button        = get_field( 'button' );
						$button_url    = $button['url'] ? $button['url'] : '#';
						$button_title  = $button['title'] ? $button['title'] : '';
						$button_target = $button['target'] ? ' target="' . $button['target'] . '"' : '';
						$button_type   = get_field( 'button_type' ) ? get_field( 'button_type' ) : 'primary';
						?>
						<a class="btn btn-<?php echo esc_attr( $button_type ); ?>" href="<?php echo esc_url( $button_url ); ?>"<?php echo esc_attr( $button_target ); ?>><?php echo esc_html( $button_title ); ?></a>
					</div>
				<?php } ?>
			</div>
			<div class="col-lg-6 col-hd-7">
				<div class="text-bg__txt">
					<InnerBlocks />
				</div>
			</div>
		</div>
	</div>
	<?php if ( get_field( 'curved_bottom' ) ) { ?>
		<div class="text-bg__svg">
			<svg width="1680" height="38" viewBox="0 118 1680 38" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M840 156C1544.16 156 2115 86.1564 2115 0L-435 -0.000222928C-435 86.1562 135.837 156 840 156Z" fill="#1049DC"/>
			</svg>
		</div>
	<?php } ?>
</section>
