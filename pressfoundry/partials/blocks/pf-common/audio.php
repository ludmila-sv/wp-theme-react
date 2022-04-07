<?php
/**
 * Audio button block.
 *
 * @package pressfoundry
 */

$block_id = 'audio-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'audio-button';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}
?>

<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<a class="btn-audio" href="#" data-audio="<?php the_field( 'file' ); ?>"><span class="btn-audio__play"></span><?php the_field( 'title' ); ?></a>
</div>
