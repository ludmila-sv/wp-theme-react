export default function( $ ) {
	const $siteHeader = $( '.header__main' );
	const $anouncementBar = $( '.announcement-bar' );
	const $menu = $( '.header__menu__wrapper', $siteHeader );
	const $menuInner = $( '.header__menu__inner', $siteHeader );
	const $submenu = $( '.submenu__wrapper', $siteHeader );
	const $submenuColumns = $( '.submenu__columns', $siteHeader );

	function adjustCss() {
		// 1. Adjust menu position
		const siteHeaderHeight = $siteHeader.outerHeight();
		const windowHeight = $( window ).height();
		let top = siteHeaderHeight;

		let anouncementHeight = 0;
		if ( $anouncementBar.hasClass( 'on' ) ) {
			anouncementHeight = $anouncementBar.outerHeight();
		}
		top = top + anouncementHeight;

		const h = windowHeight - top;

		const submenuInnerHeight = windowHeight - top - 104; // 104 - contact button block height

		if ( ! $( '.header__top' ).is( ':visible' ) ) { // mobile
			$menu.css( 'height', h + 'px' );
			$menu.css( 'top', top + 'px' );
			$menuInner.css( 'max-height', submenuInnerHeight + 'px' );
		} else {
			$menu.css( 'height', '' );
			$menu.css( 'top', '' );
			$menuInner.css( 'max-height', '' );
		}

		// 2. Adjust submenu
		const submenuHeight = windowHeight - top - 104; // 111 - contact button block height + its shadow height
		const submenuColumnsHeight = windowHeight - top - 111 - 65; // 65 - .submenu__header block height
		if ( ! $( '.header__top' ).is( ':visible' ) ) { // mobile
			$submenu.css( 'height', submenuHeight + 'px' );
			$submenuColumns.css( 'max-height', submenuColumnsHeight + 'px' );
		} else {
			$submenu.css( 'height', '' );
			$submenuColumns.css( 'max-height', '' );
		}

		// 3. Adjust page padding
		let paddingTop = 0;

		if ( $anouncementBar.hasClass( 'on' ) ) {
			paddingTop += anouncementHeight;
		}
		$( '.site-content' ).css( 'padding-top', paddingTop + 'px' );

		if ( ! $( '.header__top' ).is( ':visible' ) ) {
			if ( $( 'body' ).hasClass( 'announcement-bar-on' ) ) {
				$( '.header__main' ).css( 'top', anouncementHeight + 'px' );
			} else {
				$( '.header__main' ).css( 'top', '0' );
			}
		} else {
			$( '.header__main' ).css( 'top', '' );
		}
	}

	// Hide/show announcement-bar
	$( '#announcement-close' ).click( function() {
		$( 'body' ).removeClass( 'announcement-bar-on' );
		$( this ).closest( '.announcement-bar' ).removeClass( 'on' );

		setCookie( 'announcement', 'no', 1 ); // 1 - number of days to keep the cookie
		adjustCss();
	} );

	function setCookie( name, value, expireDays ) {
		name = encodeURIComponent( name );
		value = encodeURIComponent( value );
		let expires = new Date();
		expires.setDate( expires.getDate() + expireDays );
		expires = expires.toUTCString();

		const updatedCookie = name + '=' + value + '; path=/; expires=' + expires;

		document.cookie = updatedCookie;
	}

	function getCookie( name ) {
		const matches = document.cookie.match( new RegExp(
			'(?:^|; )' + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + '=([^;]*)'
		) );
		return matches ? decodeURIComponent( matches[ 1 ] ) : undefined;
	}

	if ( $( '.announcement-bar' ).length > 0 ) {
		if ( getCookie( 'announcement' ) && getCookie( 'announcement' ) === 'no' ){
			$( '.announcement-bar' ).removeClass( 'on' );
			$( 'body' ).removeClass( 'announcement-bar-on' );
		} else {
			$( '.announcement-bar' ).addClass( 'on' );
			$( 'body' ).addClass( 'announcement-bar-on' );
		}
	}
	adjustCss();

	$( window ).resize( function() {
		adjustCss();
	} );
}
