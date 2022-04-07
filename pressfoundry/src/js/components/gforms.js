/* This script just helps stilize file input field */

export default ( $ ) => {
	function fileInputHelper() {
		const fileInput = $(
			'.ginput_container_fileupload input[ type="file" ]'
		);

		if ( fileInput.val() ) {
			fileInput
				.parent()
				.siblings( 'label' )
				.append(
					'<span class="input-file-message">' +
						fileInput.val() +
						'</span>'
				);
		} else {
			fileInput
				.parent()
				.siblings( 'label' )
				.append(
					'<span class="input-file-message btn">Choose file</span>'
				);
		}

		$( document ).on( 'change', fileInput, function() {
			if ( fileInput.val() ) {
				fileInput
					.parent()
					.siblings( 'label' )
					.find( '.input-file-message' )
					.text( fileInput.val() )
					.removeClass( 'btn' );
			} else {
				fileInput
					.parent()
					.siblings( 'label' )
					.find( '.input-file-message' )
					.text( 'Choose file' )
					.addClass( 'btn' );
			}
		} );
	}

	function labelStyling() {
		$( '.ginput_container_checkbox, .ginput_container_radio' )
			.siblings( '.gfield_label' )
			.addClass( 'gfield_label-big' );
	}

	$( document ).on( 'gform_post_render', function() {
		fileInputHelper();
		labelStyling();
	} );
};
