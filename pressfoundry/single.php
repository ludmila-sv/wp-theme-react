<?php
/**
 * Generic page for blog-single blog post.
 *
 * @package pressfoundry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

the_post();

$bottom_class_name = 'page-header__bottom';
if ( has_post_thumbnail() ) {
	$bottom_class_name .= ' page-header__bottom--img';
}

?>

<div class="blog-single">

	<div class="blog-single__header">
		<div class="container">

			<?php if ( ! empty( get_the_category() ) ) { ?>
				<div class="blog-single__categories">
					<?php the_category( ', ' ); ?>
				</div>
			<?php } ?>

			<h1 class="blog-single__title"><?php the_title(); ?></h1>

			<div class="blog-single__date"><?php the_date(); ?></div>

			<div class="blog-single__all"><a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">Blog</a></div>

		</div>

		<?php if ( has_post_thumbnail() ) { ?>
			<div class="container">
				<div class="blog-single__thumbnail">
					<div class="rounded-corners"><?php the_post_thumbnail( 'full' ); ?></div>
					<?php if ( get_the_post_thumbnail_caption() ) { ?>
						<div class="blog-single__thumbnail__caption"><?php the_post_thumbnail_caption(); ?></div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>

	<div class="blog-single__content content">
		<div class="container">
			<?php the_content(); ?>
		</div>
	</div>

	<div class="blog-single__footer">
		<div class="container">
			<div class="blog-single__footer__meta">
				<div class="blog-single__tags">
					<?php if ( ! empty( get_the_tags() ) ) { ?>
						<div class="blog-single__tags__title">Tags</div>
						<div class="blog-single__tags__list"><?php the_tags( '', ' ', '' ); ?></div>
					<?php } ?>
				</div>
				<div class="blog-single__share">
					<div class="blog-single__share__list"><?php get_template_part( 'partials/share' ); ?></div>
				</div>
			</div>
			<?php if ( get_field( 'bottom_text' ) ) { ?>
				<div class="blog-single__footer__txt"><?php the_field( 'bottom_text' ); ?></div>
			<?php } ?>
		</div>
	</div>

</div>

<?php
if ( class_exists( 'RP4WP' ) ) :
	$related_posts = true;
	set_query_var( 'related_posts', $related_posts );

	// Post Link Manager.
	$pl_manager = new RP4WP_Post_Link_Manager();

	$related_posts = $pl_manager->get_children( get_the_ID() );

	global $post;

	if ( count( $related_posts ) ) :
		$heading_text = RP4WP::get()->settings->get_option( 'heading_text' ) ? RP4WP::get()->settings->get_option( 'heading_text' ) : 'View related articles from Chamfr.';
		?>

		<div class="related-posts">
			<div class="container">
				<div class="related-posts__header">
					<h2><?php echo esc_html( $heading_text ); ?></h2>
					<div class="related-posts__all"><a class="btn btn-tertiary" href="/blog/">All Posts</a></div>
				</div>

				<div class="row">
					<?php
					$i = 0;
					foreach ( $related_posts as $post ) :
						setup_postdata( $post );
						$i++;
						?>
							<div class="col-lg-4">
								<?php get_template_part( 'partials/post' ); ?>
							</div>
						<?php
						if ( $i >= 3 ) {
							break;
						}
					endforeach;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</div>

		<?php
	endif;
endif;
?>


<?php
get_footer();
