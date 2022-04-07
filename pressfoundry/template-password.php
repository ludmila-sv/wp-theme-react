<?php
/**
 * Template used to display password request form in case post\page or CPT item is password protected.
 *
 * @package pressfoundry
 */

get_header();
the_post();
?>

<section class="password-protect">

	<div class="container">

		<div class="password-protect-form">
			<?php echo get_the_password_form(); ?>
		</div>

	</div>

</section>

<?php
get_footer();
