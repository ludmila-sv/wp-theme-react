export default function( $ ) {
	if ( $( '.page-nav' ).length > 0 ) {
		$( '.page-nav .has-submenu > a' ).on( 'click', function( e ) {
			e.preventDefault();
			$( this )
				.parent()
				.toggleClass( 'open' );
		} );

		const pagenavPosition = $( '.page-nav' ).offset().top;
		function pagenavScroll() {
			const top = $( '.announcement-bar.on' ).outerHeight();
			if ( $( window ).scrollTop() > pagenavPosition ) {
				$( 'body' ).addClass( 'pagenav-on' );
				$( '.page-nav' ).css( 'top', top + 'px' );
			} else {
				$( 'body' ).removeClass( 'pagenav-on' );
				$( '.page-nav' ).css( 'top', '' );
			}
		}
		pagenavScroll();

		$( window ).on( 'scroll', function() {
			pagenavScroll();
		} );

		function fixBottomPadding() {
			if ( $( window ).width() < 576 ) {
				const btnH = $( '.page-nav__btn' ).outerHeight();
				$( '.site-content' ).css( 'padding-bottom', btnH + 'px' );
			} else {
				$( '.site-content' ).css( 'padding-bottom', '' );
			}
		}
		fixBottomPadding();
		$( window ).resize( function() {
			fixBottomPadding();
			pagenavScroll();
		} );
	}
}
