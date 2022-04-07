export default function( $ ) {
	if ( $( '.accordion__list' ).length > 0 ) {
		$( '.accordion__item__title' ).on( 'click', function() {
			$( this )
				.parent()
				.toggleClass( 'accordion-open' );
		} );
	}
}
