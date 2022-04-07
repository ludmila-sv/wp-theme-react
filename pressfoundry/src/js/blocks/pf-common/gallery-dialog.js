export class Dialog {
	constructor( settings = {} ) {
		this.settings = {
			id: 'dialog',
			title: 'Dialog',
			content: '',
			renderCallback: () => {},
			beforeOpenCallback: () => {},
			afterOpenCallback: () => {},
			beforeCloseCallback: () => {},
			afterCloseCallback: () => {},
			...settings,
		};

		this.el = this.renderDialog();
		this.dialogEl = this.el.querySelector( '[data-dialog-element]' );
		this.overlayEl = this.el.querySelector( '[data-dialog-overlay]' );
		this.focusedElBeforeOpen = null;

		const focusableEls = this.dialogEl.querySelectorAll(
			'a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), [tabindex="0"]'
		);
		this.focusableEls = [ ...focusableEls ];

		this.firstFocusableEl = this.focusableEls[ 0 ];
		this.lastFocusableEl = this.focusableEls[
			this.focusableEls.length - 1
		];

		this.close(); // Reset
		this.addEventListeners();
	}

	open() {
		this.settings.beforeOpenCallback( this );
		this.dialogEl.removeAttribute( 'aria-hidden' );
		this.overlayEl.removeAttribute( 'aria-hidden' );

		this.focusedElBeforeOpen = document.activeElement;

		this.dialogEl.addEventListener(
			'keydown',
			this._handleKeyDown.bind( this )
		);

		this.overlayEl.addEventListener( 'click', this.close.bind( this ) );

		this.firstFocusableEl.focus();
		this.settings.afterOpenCallback( this );
	}

	close() {
		this.settings.beforeCloseCallback( this );
		this.dialogEl.setAttribute( 'aria-hidden', true );
		this.overlayEl.setAttribute( 'aria-hidden', true );

		if ( this.focusedElBeforeOpen ) {
			this.focusedElBeforeOpen.focus();
		}
		this.settings.afterCloseCallback( this );
	}

	_handleKeyDown( e ) {
		const KEY_TAB = 9;
		const KEY_ESC = 27;

		switch ( e.keyCode ) {
			case KEY_TAB:
				if ( this.focusableEls.length === 1 ) {
					e.preventDefault();
					break;
				}
				if ( e.shiftKey ) {
					// handleBackwardTab();
					if ( document.activeElement === this.firstFocusableEl ) {
						e.preventDefault();
						this.lastFocusableEl.focus();
					}
				} else {
					// handleForwardTab();
					// eslint-disable-next-line no-lonely-if
					if ( document.activeElement === this.lastFocusableEl ) {
						e.preventDefault();
						this.firstFocusableEl.focus();
					}
				}
				break;
			case KEY_ESC:
				this.close();
				break;
			default:
				break;
		}
	}

	addEventListeners() {
		const closeDialogEls = this.el.querySelectorAll(
			'[data-close-dialog]'
		);
		for ( let i = 0; i < closeDialogEls.length; i++ ) {
			closeDialogEls[ i ].addEventListener( 'click', () => {
				this.close();
			} );
		}
	}

	renderDialog() {
		let el = document.getElementById( this.settings.id );
		if ( el ) {
			return el;
		}
		const template = `
		<div class="dialog__root" id="${ this.settings.id }">
			<div class="dialog-overlay" tabindex="-1" id="${ this.settings.id }-overlay" data-dialog-overlay data-close-dialog></div>
			<div class="dialog" role="dialog" aria-label="${ this.settings.title }" id="${ this.settings.id }-dialog" data-dialog-element>
				<div class="dialog__inner" data-dialog-content>
				${ this.settings.content }
				</div>
				<button type="button" aria-label="Close" class="dialog__close" data-close-dialog><span class="close-icon"></span></button>
			</div>
		</div>
		`;

		document.body.insertAdjacentHTML( 'beforeend', template );
		el = document.getElementById( this.settings.id );

		this.settings.renderCallback( el, this );

		return el;
	}
}
