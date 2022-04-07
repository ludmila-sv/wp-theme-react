<?php
/**
 * Accordion block.
 *
 * @package pressfoundry
 */

$block_id = 'accordion-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'accordion';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}
?>

<section  id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<?php if ( get_field( 'title' ) ) { ?>
			<h2 class="accordion__title"><?php the_field( 'title' ); ?></h2>
		<?php } ?>
		<?php if ( have_rows( 'accordion' ) ) : ?>
			<div class="accordion__list">
				<?php
				while ( have_rows( 'accordion' ) ) :
					the_row();
					?>
					<div class="accordion__item">
						<div class="accordion__item__title"><?php the_sub_field( 'title' ); ?></div>
						<div class="accordion__item__text">
							<div class="accordion__item__text--inner"><?php the_sub_field( 'text' ); ?></div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
