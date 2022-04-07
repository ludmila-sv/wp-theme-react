export default function( $ ) {
	if ( $( '.wp-block-gallery' ).length > 0 && $( 'body').hasClass( 'gallery-fancybox') ) {
		let i = 0;
		$( '.wp-block-gallery' ).each( function() {
			i++;
			$( this ).find( 'figure a' ).each( function() {
				const caption = $( this ).siblings( 'figcaption' ).text();
				$( this ).attr( 'data-fancybox', 'gallery' + i );
				$( this ).attr( 'data-caption', caption );
			} );
		} );

		$( '.wp-block-gallery figure' ).each( function() {
			$( this ).append( '<div class="figure-zoom"></div>' );
		} );

		$( document ).on( 'click', '.figure-zoom', function() {
			$( this ).siblings( 'a' ).trigger( 'click' );
		} );

		$( '.wp-block-gallery a' ).fancybox( {
			// Options will go here
		} );
	}
}
