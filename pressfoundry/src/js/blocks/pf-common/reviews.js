export default function( $ ) {
	if ( $( '.reviews__slider' ).length > 0 ) {
		$( '.reviews__slider' ).each( function() {
			const prev = $( this ).siblings( '.slick-controls' ).find( '.slick-prev ');
			const next = $( this ).siblings( '.slick-controls' ).find( '.slick-next ');
			$( this ).on( 'init', function( event, slick ){
				$( this ).closest( '.reviews__body' ).find( '.slick-controls' ).removeClass( 'd-none' );
			} );
			$( '.reviews__slider' ).slick( {
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: false,
				dots: false,
				arrows: true,
				autoplay: false,
				prevArrow: prev,
				nextArrow: next,
			} );
		} );
	}
}
