import $ from 'jquery';
import { Dialog } from './gallery-dialog';

export function initGalleryBlocks( rootEl = document ) {
	if ( $( 'body').hasClass( 'gallery-pf') ) {
		rootEl.querySelectorAll( '.wp-block-gallery' ).forEach( ( el, index ) => {
			new BlockGallery( `wp-block-gallery-dialog-${ index }`, el );
		} );
	}
}

class BlockGallery {
	constructor( id, el ) {
		this.el = el;
		this.imgElements = [ ...el.querySelectorAll( 'img' ) ];
		this.aElements = [ ...el.querySelectorAll( 'a' ) ];
		this.$slick = null;

		this.dialog = new Dialog( {
			id,
			title: 'Images gallery',
			content: this.getDialogContent(),
			renderCallback: this.renderCallback.bind( this ),
		} );
		this.initEvents();
	}

	initEvents() {
		$( this.aElements ).on( 'click', this.openLightBox.bind( this ) );
	}

	getDialogContent() {
		return `
		<div class="gallery__slider slick-arrows-mobile-middle" data-block-gallery-slider>
			${ this.imgElements.reduce( ( result, imgEl ) => {
			return `${ result } ${ this.getSlideHtml( imgEl ) }`;
		}, '' ) }
		</div>
		`;
	}

	getSlideHtml( imgEl ) {
		const src = imgEl.getAttribute( 'data-full-url' );
		const alt = imgEl.getAttribute( 'alt' );
		return `<div class="gallery__slide">
			<div class="gallery__slide-inner">
				<img src="${ src }" alt="${ alt }" class="gallery__slide-img">
				${ ( () => {
					return alt
						? `<div class="gallery__slide-title">${ alt }</div>`
						: '';
				} )() }
			</div>
		</div>`;
	}

	renderCallback( dialogEl ) {
		if ( this.$slick ) {
			return this.$slick;
		}
		// lets initialize slick.
		const sliderEl = dialogEl.querySelector(
			'[data-block-gallery-slider]'
		);
		this.$slick = $( sliderEl ).slick( {
			arrows: true,
			dots: false,
		} );
		return this.$slick;
	}

	openLightBox( event ) {
		event.preventDefault();
		event.stopPropagation();
		const isClicked = ( element ) => event.currentTarget === element;
		let slideIndex = this.aElements.findIndex( isClicked );
		if ( ! slideIndex ) {
			slideIndex = 0;
		}
		this.dialog.open();
		this.$slick.slick( 'slickGoTo', slideIndex );
		// create popup if it doesn't exist, append to body, save reference to dom for ease of access.
	}
}
