<?php
/**
 * Default page template.
 *
 * @package pressfoundry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; }

get_header();

the_post();
?>

<div class="content">
	<div class="container">
		<?php the_content(); ?>
	</div>
</div>

<?php

get_footer();
