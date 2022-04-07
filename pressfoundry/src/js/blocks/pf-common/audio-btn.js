export default function( $ ) {
	if ( $( '.btn-audio' ).length > 0 ) {
		const player = new Audio();

		$( '.btn-audio' ).each( function() {

			$( this ).on( 'click', function( e ) {
				e.preventDefault();
				const file = $( this ).data( 'audio' );
				player.src = file;

				if ( ! $( this ).hasClass( 'playing' ) ) {
					player.play();
					$( this ).addClass( 'playing' );
				} else {
					player.pause();
					$( this ).removeClass( 'playing' );
				}
			} );

			player.addEventListener( 'ended', function() {
				$( '.btn-audio' ).removeClass( 'playing' );
			} );

		} );

	}
}
