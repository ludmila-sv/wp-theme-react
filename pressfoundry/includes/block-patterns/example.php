<?php
/**
 * Example pattern settings and template.
 * Hint: it's easy to layout blocks in Gutenberg then click on contextual menu of block which wraps those,
 * and select Copy, then just paste here in `content`.
 *
 * @package pressfoundry
 */

return array(
	'title'       => 'Example',
	'description' => 'Example Pattern - TODO update it with desired pattern',
	'categories'  => array( 'pf' ),
	'keywords'    => array( 'example', 'pattern' ),
	'content'     => '
<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column">
<!-- wp:paragraph -->
<p></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">

<!-- wp:paragraph {"textColor":"darkest-blue"} -->
<p class="has-darkest-blue-color has-text-color">Quod cotidieque vel ne, ea quis ludus pericula per. No legere sapientem dignissim qui, his ei errem <a href="#link-here">laboramus intellegam</a>, has nostrud demo an. In aeque omnes dicunt mea. In nam quis recusabo delicatissimi.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"borderRadius":0,"className":"is-style-primary"} -->
<div class="wp-block-button is-style-primary"><a class="wp-block-button__link no-border-radius">Get in Touch</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->',
);
