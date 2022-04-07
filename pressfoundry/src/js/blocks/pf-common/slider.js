export default function( $ ) {
	if ( $( '.slickjs' ).length > 0 ) {
		$( '.slickjs' ).each( function() {
			const prev = $( this ).siblings( '.slick-controls' ).find( '.slick-prev ');
			const next = $( this ).siblings( '.slick-controls' ).find( '.slick-next ');
			$( this ).slick( {
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: true,
				dots: false,
				arrows: true,
				autoplay: false,
				prevArrow: prev,
				nextArrow: next,
			} );
		} );
	}
	if ( $( '.slick-slider-js' ).length > 0 ) {
		$( '.slick-slider-js' ).each( function() {
			const prev = $( this ).closest( '.slider' ).find( '.slick-controls' ).find( '.slick-prev ');
			const next = $( this ).closest( '.slider' ).find( '.slick-controls' ).find( '.slick-next ');

			$( this ).on( 'init', function( event, slick ){
				$( this ).closest( '.slider' ).find( '.slick-controls' ).removeClass( 'd-none' );
			} );

			$( this ).slick( {
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: true,
				dots: false,
				arrows: true,
				autoplay: false,
				prevArrow: prev,
				nextArrow: next,
			} );
		} );
	}
}
