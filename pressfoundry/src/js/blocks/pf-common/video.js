export default function( $ ) {
	$( '.play-video' ).each( function() {
		$( this ).click( function( event ) {
			event.preventDefault();

			$( this ).addClass( 'playing' );

			let videoSrc = $( this ).attr( 'href' );
			let video = '';

			if ( videoSrc === '#' ) {
				$( '.wp_video' )
					.find( '.source' )
					.each( function() {
						video +=
							'<source src="' +
							$( this ).attr( 'data-src' ) +
							'" type="' +
							$( this ).attr( 'data-type' ) +
							'" >';
					} );
				video = '<video controls autoplay loop>' + video + '</video>';
			} else {
				if ( videoSrc.indexOf( 'youtu' ) > 0 ) {
					videoSrc =
						`https://www.youtube.com/embed/` +
						youTubeGetID( videoSrc ) +
						'?autoplay=1&rel=0&wmode=opaque';
				}
				if ( videoSrc.indexOf( 'vimeo' ) > 0 ) {
					videoSrc =
						`https://player.vimeo.com/video/` +
						getVimeoId( videoSrc );
				}
				video =
					'<iframe src="' +
					videoSrc +
					'" frameborder="0" allowfullscreen allow="accelerometer; autoplay;"></iframe>';
			}

			$( 'body' ).append( '<div id="cover"></div>' );
			$( 'body' ).append( '<div id="video-block"></div>' );
			$( '#video-block' ).append( '<div id="iframe-wrapper"></div>' );
			$( '#iframe-wrapper' ).append( video );
			$( '#iframe-wrapper' ).append(
				'<div id="button-close"></div>'
			);

			const htmlH = $( window ).scrollTop();
			const y = htmlH + 60;

			$( '#video-block' ).css( 'top', y );
		} );
	} );

	$( document ).on( 'click', '#button-close', function( event ) {
		$( '#video-block' ).remove();
		$( '#cover' ).remove();
		$( '.play-video' ).removeClass( 'playing' );
		event.stopPropagation();
	} );
	$( document ).on( 'click', function( event ) {
		if ( $( '#video-block' ).length ) {
			if ( $( event.target ).closest( '#iframe-wrapper' ).length ) {
				return;
			}
			if ( $( event.target ).closest( '.play-video' ).length ) {
				return;
			}
			$( '#video-block' ).remove();
			$( '#cover' ).remove();
			$( '.play-video' ).removeClass( 'playing' );
			event.stopPropagation();
		}
	} );
}


function youTubeGetID( url ) {
	let ID = '';
	url = url
		.replace( /(>|<)/gi, '' )
		.split( /(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/ );
	if ( url[ 2 ] !== undefined ) {
		ID = url[ 2 ].split( /[^0-9a-z_\-]/i );
		ID = ID[ 0 ];
	} else {
		ID = url;
	}
	return ID;
}

/**
 * Get the vimeo id.
 * @param {string} vimeoStr - the url from which you want to extract the id
 * @returns {string|undefined}
 */
function getVimeoId(vimeoStr) {
	let str = vimeoStr;

	if (str.indexOf('#') > -1) {
		[str] = str.split('#');
	}

	if (str.indexOf('?') > -1 && str.indexOf('clip_id=') === -1) {
		[str] = str.split('?');
	}

	let id;
	let arr;

	const primary = /https?:\/\/vimeo\.com\/([0-9]+)/;

	const matches = primary.exec(str);
	if (matches && matches[1]) {
		return matches[1];
	}

	const vimeoPipe = [
		'https?://player.vimeo.com/video/[0-9]+$',
		'https?://vimeo.com/channels',
		'groups',
		'album',
	].join('|');

	const vimeoRegex = new RegExp(vimeoPipe, 'gim');

	if (vimeoRegex.test(str)) {
		arr = str.split('/');
		if (arr && arr.length) {
			id = arr.pop();
		}
	} else if (/clip_id=/gim.test(str)) {
		arr = str.split('clip_id=');
		if (arr && arr.length) {
			[id] = arr[1].split('&');
		}
	}

	return id;
}