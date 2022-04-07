<?php
/**
 * Custom Video block.
 *
 * @package pressfoundry
 */

$block_id = 'custom-video-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'custom-video';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}
?>

<div  id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?><?php if ( 'right' === get_field( 'position' ) ) { //phpcs:ignore ?> video-text--right<?php } ?>">
	<div class="custom-video__video">
		<img class="custom-video__poster" src="<?php the_field( 'video_bg' ); ?>" alt="" />
		<?php if ( 'external' === get_field( 'video_source' ) ) { ?>
			<div class="custom-video__btn"><a href="<?php the_field( 'video_link' ); ?>" class="btn-play play-video"></a></div>
		<?php } elseif ( have_rows( 'wp_video' ) ) { ?>
			<div class="wp_video d-none">
				<?php
				while ( have_rows( 'wp_video' ) ) :
					the_row();
					?>
					<div class="source d-none" data-src="<?php echo esc_url( wp_get_attachment_url( get_sub_field( 'file' ) ) ); ?>" data-type="video/<?php the_sub_field( 'type' ); ?>"></div>
				<?php endwhile; ?>
			</div>
			<div class="custom-video__btn"><a href="#" class="btn-play play-video"></a></div>
		<?php } ?>
	</div>
</div>
