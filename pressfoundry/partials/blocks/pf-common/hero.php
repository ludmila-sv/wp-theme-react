<?php
/**
 * Hero block.
 *
 * @package pressfoundry
 */

$block_id = 'hero-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'hero full-width';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}
$style = '';
if ( get_field( 'image' ) ) {
	$style = ' style="background-image: url( ' . wp_get_attachment_image_url( get_field( 'image' ), 'full' ) . ' );"';
}
?>

<section  id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<div class="hero__text">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 offset-lg-6 col-hd-5 offset-hd-7">
					<div class="hero__content">
						<InnerBlocks />
					</div>
					<?php if ( have_rows( 'buttons' ) ) : ?>
						<div class="hero__btns d-none d-sm-block">
							<?php
							while ( have_rows( 'buttons' ) ) :
								the_row();
								$button_class  = get_sub_field( 'button_class' );
								$button        = get_sub_field( 'button' );
								$button_url    = $button['url'] ? $button['url'] : '#';
								$button_title  = $button['title'] ? $button['title'] : '';
								$button_target = $button['target'] ? $button['target'] : '_self';
								?>
								<a class="btn btn-<?php echo esc_attr( $button_class ); ?>" href="<?php echo esc_url( $button_url ); ?>" target="<?php echo esc_attr( $button_target ); ?>"><?php echo esc_html( $button_title ); ?></a>
							<?php endwhile; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="hero__image"<?php echo $style; // phpcs:ignore ?>></div>

	<?php if ( have_rows( 'buttons' ) ) : ?>
		<div class="hero__btns d-sm-none">
			<?php
			while ( have_rows( 'buttons' ) ) :
				the_row();
				$button_class  = get_sub_field( 'button_class' );
				$button        = get_sub_field( 'button' );
				$button_url    = $button['url'] ? $button['url'] : '#';
				$button_title  = $button['title'] ? $button['title'] : '';
				$button_target = $button['target'] ? $button['target'] : '_self';
				?>
				<a class="btn btn-<?php echo esc_attr( $button_class ); ?>" href="<?php echo esc_url( $button_url ); ?>" target="<?php echo esc_attr( $button_target ); ?>"><?php echo esc_html( $button_title ); ?></a>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
</section>
