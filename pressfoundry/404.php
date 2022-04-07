<?php
/**
 *  404 page template
 *
 * @package sues
 */

$subtitle404 = get_field( 'error404_subtitle', 'option' ) ? get_field( 'error404_subtitle', 'option' ) : '404 error';
$title404    = get_field( 'error404_title', 'option' ) ? get_field( 'error404_title', 'option' ) : 'Page Not Found';

get_header(); ?>

<div class="error-404__wrapper">
	<div class="container">
		<div class="error-404">
			<div class="error-404__subtitle"><?php echo esc_html( $subtitle404 ); ?></div>
			<h1 class="error-404__title"><?php echo esc_html( $title404 ); ?></h1>
			<?php if ( have_rows( 'error404_buttons', 'option' ) ) { ?>
				<div class="error-404__btns">
					<?php
					while ( have_rows( 'error404_buttons', 'option' ) ) :
						the_row();
						$button        = get_sub_field( 'link' );
						$button_url    = $button['url'] ? $button['url'] : '#';
						$button_title  = $button['title'] ? $button['title'] : '';
						$button_target = $button['target'] ? $button['target'] : '_self';
						?>
						<a class="btn btn-tertiary" href="<?php echo esc_url( $button_url ); ?>" target="<?php echo esc_attr( $button_target ); ?>"><?php echo esc_html( $button_title ); ?></a>
					<?php endwhile; ?>
				</div>
			<?php } else { ?>
				<div class="error-404__btns">
					<a class="btn btn-tertiary" href="/">Back Home</a>
				</div>
			<?php } ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
