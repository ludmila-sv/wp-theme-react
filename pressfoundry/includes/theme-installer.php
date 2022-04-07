<?php
/**
 * Theme Installation functions.
 *
 * @package pressfoundry
 */

/**
 * Upload a sample image for GBs.
 *
 * @package pressfoundry
 */
function pf_upload_gb_image() {

	$gb_image_id = get_option( 'sample_image_id' );
	$gb_image    = $gb_image_id ? wp_get_attachment_image_url( $gb_image_id ) : false;

	if ( ! $gb_image ) {
		$image_original_path = get_template_directory() . '/assets/images/pf_sample.jpg';
		$image_path          = get_template_directory() . '/assets/images/pf_sample_copy.jpg';

		@copy( $image_original_path, $image_path );

		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';

		$file_array         = array();
		$file_array['name'] = wp_basename( 'pf_sample.jpg' );

		// Download file to temp location.
		$file_array['tmp_name'] = $image_path;


		$attachment_id = media_handle_sideload( $file_array, 0, 'Generic Image for Previews' );

		if ( is_wp_error( $attachment_id ) ) {
			echo 'Error uploading sample image: ' . esc_html( $attachment_id->get_error_message() );

			return false;
		} else {
			update_option( 'sample_image_id', $attachment_id );

			return $attachment_id;
		}
	} else {
		return $gb_image_id;
	}
}

/**
 * Create a preview page with all GBs.
 *
 * @package pressfoundry
 */
function pf_create_gb_page() {

	$title   = 'Gutenberg blocks';
	$gb_page = get_page_by_title( $title );

	if ( ! $gb_page ) { // && 'publish' !== $gb_page->post_status

		$content = file_get_contents( get_template_directory() . '/includes/sample-gb-page.html' );

		$image_id = pf_upload_gb_image();
		if ( $image_id ) {
			$img_src      = wp_get_attachment_image_url( $image_id, 'large' );
			$img_src_full = wp_get_attachment_image_url( $image_id, 'full' );

			$content = str_replace( '318', $image_id, $content );
			$content = str_replace( '/wp-content/themes/boilerplate-theme/assets/images/pf_sample.jpg', $img_src, $content );
			$content = str_replace( '/wp-content/themes/boilerplate-theme/assets/images/pf_sample-full.jpg', $img_src_full, $content );
		}

		$current_user    = wp_get_current_user();
		$current_user_id = $current_user->ID;

		$post_data = array(
			'post_title'    => $title,
			'post_content'  => $content,
			'post_type'     => 'page',
			'post_status'   => 'draft',
			'post_author'   => $current_user_id,
			'post_password' => '',
		);

		$post_id = wp_insert_post( $post_data, true );
		if ( is_wp_error( $post_id ) ) {
			echo 'Error creating sample GB page: ' . esc_html( $post_id->get_error_message() );
		}
	}

}

add_action( 'after_switch_theme', 'pf_create_gb_page', 10, 2 );

