<?php
/**
 * It returns associative array block styles, where key is block handle,
 * and value is array of styles for such block type, single entity of which is associative array style of settings.
 *
 * @package sues
 */

return array(

	'core/paragraph' => array(
		array(
			'name'  => 'lead',
			'label' => __( 'Lead' ),
		),
		array(
			'name'  => 'caption',
			'label' => __( 'Caption' ),
		),
		array(
			'name'  => 'subtitle-1',
			'label' => __( 'Subtitle-1' ),
		),
		array(
			'name'  => 'subtitle-2',
			'label' => __( 'Subtitle-2' ),
		),
		array(
			'name'  => 'overline',
			'label' => __( 'Overline' ),
		),
	),


	// Lets register styles for buttons.
	'core/button'    => array(
		array(
			'name'  => 'primary',
			'label' => __( 'Primary' ),
		),
		array(
			'name'  => 'secondary',
			'label' => __( 'Secondary' ),
		),
		array(
			'name'  => 'tertiary',
			'label' => __( 'Tertiary (Link)' ),
		),
	),

	// List with check mark in a circle.
	'core/list'      => array(
		array(
			'name'  => 'checked',
			'label' => __( 'Checked' ),
		),
	),

);
