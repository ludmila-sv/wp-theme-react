export default function( $ ) {
	if ( $( '.tabs' ).length > 0 ) {
		$( '.tabs' ).each( function() {
			$( this ).find( '.tab' ).each( function() {
				const title = $( this ).data( 'title' );
				const tabId = $( this ).attr( 'id' );
				$( this ).closest( '.tabs' ).find( '.tabs-nav' ).find( 'ul' ).append( '<li><a class="tab-link" href="#' + tabId + '">' + title + '</a></li>' );
			} );
		} );

		$( document ).on( 'click', '.tabs-nav li', function( event ) {
			event.preventDefault();

			$( this ).closest( '.tabs-nav' ).find( 'li' ).each( function() {
				$( this ).removeClass( 'active' );
			} );

			$( this ).addClass( 'active' );
			const href = $( this ).find( 'a' ).attr( 'href' );
			const hash = href.substr( href.indexOf( '#' ) );

			$( this ).closest( '.tabs' ).find( '.tab' ).each( function() {
				$( this ).fadeOut();
			} );
			$( href ).fadeIn();

			/*if ( window.history.pushState ) {
				window.history.pushState( null, null, hash );
			} else {
				window.location.hash = hash;
			}*/
		} );

		const initialHash = window.location.hash;
		if ( initialHash && ! initialHash.match( /\// ) ) {
			$( '.tabs .tab' ).hide();
			$( '.tabs-nav a[href="' + initialHash + '"]' )
				.eq( 0 )
				.parent()
				.click();
		} else {
			$( '.tabs .tab' ).hide();
			$( '.tabs-nav a' )
				.eq( 0 )
				.parent()
				.click();
		}
	}
}
