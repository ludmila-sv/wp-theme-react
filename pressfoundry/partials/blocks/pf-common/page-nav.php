<?php
/**
 * In-Page Navigation block.
 *
 * @package pressfoundry
 */

$block_id = 'page-nav-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'page-nav full-width';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}
?>

<div  id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<div class="page-nav__inner">
			<?php if ( get_field( 'title' ) ) { ?>
				<div class="page-nav__title"><?php the_field( 'title' ); ?></div>
			<?php } ?>

			<?php if ( have_rows( 'menu' ) ) : ?>
				<div class="page-nav__menu">
					<ul>
						<?php
						while ( have_rows( 'menu' ) ) :
							the_row();
							$menu_item        = get_sub_field( 'link' );
							$menu_item_title  = $menu_item['title'];
							$menu_item_url    = $menu_item['url'];
							$menu_item_target = $menu_item['target'] ? ' target="' . $menu_item['target'] . '"' : '';
							?>
							<li <?php if ( get_sub_field( 'has_submenu' ) ) { ?>class="has-submenu"<?php } ?>>
								<a class="page-nav__a scroll-to" href="<?php echo esc_url( $menu_item_url ); ?>"<?php echo esc_attr( $menu_item_target ); ?>><?php echo esc_html( $menu_item_title ); ?></a>
								<?php if ( have_rows( 'submenu' ) ) : ?>
									<div class="page-nav__submenu">
										<div class="page-nav__submenu__inner">
											<ul>
												<?php
												while ( have_rows( 'submenu' ) ) :
													the_row();
													$submenu_item   = get_sub_field( 'link' );
													$submenu_title  = $submenu_item['title'];
													$submenu_url    = $submenu_item['url'];
													$submenu_target = $submenu_item['target'] ? ' target="' . $menu['target'] . '"' : '';
													?>
													<li>
														<a class="page-nav__a scroll-to" href="<?php echo esc_url( $submenu_url ); ?>"<?php echo esc_attr( $submenu_target ); ?>><?php echo esc_html( $submenu_title ); ?></a>
													</li>
												<?php endwhile; ?>
											</ul>
										</div>
									</div>
								<?php endif; ?>
							</li>
						<?php endwhile; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php
			if ( get_field( 'button' ) ) {
				$button        = get_field( 'button' );
				$button_title  = $button['title'];
				$button_url    = $button['url'];
				$button_target = $button['target'] ? ' target="' . $button['target'] . '"' : '';
				?>
				<div class="page-nav__btn">
					<a class="btn btn-primary" href="<?php echo esc_url( $button_url ); ?>"<?php echo esc_attr( $button_target ); ?>><?php echo esc_html( $button_title ); ?></a>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
