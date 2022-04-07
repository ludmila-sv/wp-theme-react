<?php
/**
 * Page Header block.
 *
 * @package pressfoundry
 */

$block_id = 'page-header-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'page-header full-width';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( get_field( 'color' ) ) {
	$class_name .= ' bg-color-' . get_field( 'color' );
}
?>

<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<div class="page-header__title">
		<div class="container">
			<h1><?php the_field( 'title' ); ?></h1>
		</div>
	</div>
</section>
