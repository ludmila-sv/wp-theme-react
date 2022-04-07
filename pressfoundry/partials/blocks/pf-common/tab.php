<?php
/**
 * Tab block.
 *
 * @package pressfoundry
 */

$template = array(
	array(
		'core/paragraph',
		array(),
	),
);

?>

<div class="tab" id=<?php echo esc_attr( sanitize_title( get_field( 'title' ) ) ); ?> data-title="<?php echo esc_attr( get_field( 'title' ) ); ?>">
	<InnerBlocks template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" />
</div>
