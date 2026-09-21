/**
 * Tistory Style theme — front-end behaviours.
 * Vanilla JS replacement for the skin's jQuery-based drawer/menu scripts.
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {

		/* Mobile drawer sidebar */
		var openBtn  = document.querySelector( '.button-menu' );
		var closeBtn = document.querySelector( '.btn-aside-close' );
		var aside    = document.querySelector( '.area-aside' );

		function openAside() {
			if ( ! aside ) return;
			aside.classList.add( 'area-aside-on' );
			document.body.classList.add( 'bg-dimmed' );
			if ( openBtn ) {
				openBtn.setAttribute( 'aria-expanded', 'true' );
				openBtn.setAttribute( 'aria-label', '메뉴 닫기' );
			}
		}
		function closeAside() {
			if ( ! aside ) return;
			aside.classList.remove( 'area-aside-on' );
			document.body.classList.remove( 'bg-dimmed' );
			if ( openBtn ) {
				openBtn.setAttribute( 'aria-expanded', 'false' );
				openBtn.setAttribute( 'aria-label', '메뉴 열기' );
			}
		}

		if ( openBtn && aside ) {
			openBtn.setAttribute( 'aria-expanded', 'false' );
			openBtn.setAttribute( 'aria-controls', 'mobile-drawer' );
			aside.setAttribute( 'id', 'mobile-drawer' );
			openBtn.addEventListener( 'click', function ( e ) {
				e.preventDefault();
				e.stopPropagation();
				if ( aside.classList.contains( 'area-aside-on' ) ) {
					closeAside();
				} else {
					openAside();
				}
			} );
		}
		if ( closeBtn ) {
			closeBtn.addEventListener( 'click', function ( e ) {
				e.preventDefault();
				closeAside();
			} );
		}
		document.addEventListener( 'click', function ( e ) {
			if ( document.body.classList.contains( 'bg-dimmed' ) && aside && ! aside.contains( e.target ) && e.target !== openBtn ) {
				closeAside();
			}
		} );
		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' && aside && aside.classList.contains( 'area-aside-on' ) ) {
				closeAside();
			}
		} );

		/* Mega menu: expand the hover panel to fit the tallest submenu */
		var categoryList = document.querySelector( '.header .area-gnb .category_list' );
		if ( categoryList ) {
			var updateMegaMenuHeight = function () {
				var max = 0;
				categoryList.querySelectorAll( '.sub_category_list' ).forEach( function ( sub ) {
					var h = sub.scrollHeight || sub.offsetHeight;
					if ( h > max ) max = h;
				} );
				if ( max > 0 ) {
					categoryList.style.setProperty( '--megamenu-height', max + 'px' );
				}
			};
			categoryList.addEventListener( 'mouseenter', updateMegaMenuHeight );
			updateMegaMenuHeight();
		}

		/* Search input: submit on Enter (progressive enhancement, form already supports it) */
		document.querySelectorAll( '.searchInput' ).forEach( function ( input ) {
			input.addEventListener( 'keypress', function ( e ) {
				if ( e.key === 'Enter' ) {
					var form = input.closest( 'form' );
					if ( form ) form.submit();
				}
			} );
		} );

		/* WordPress embed height synchronization (prevents bottom clipping) */
		window.addEventListener( 'message', function ( event ) {
			if ( ! event.data || typeof event.data !== 'object' ) return;
			if ( event.data.message === 'height' && typeof event.data.value !== 'undefined' ) {
				var iframes = document.querySelectorAll( 'iframe.wp-embedded-content' );
				var targetHeight = parseInt( event.data.value, 10 );
				if ( isNaN( targetHeight ) || targetHeight <= 0 ) return;

				for ( var i = 0; i < iframes.length; i++ ) {
					var iframe = iframes[i];
					if ( ( event.data.secret && iframe.getAttribute( 'data-secret' ) === event.data.secret ) || iframe.contentWindow === event.source ) {
						iframe.height = targetHeight;
						iframe.style.setProperty( 'height', targetHeight + 'px', 'important' );
					}
				}
			}
		} );

	} );
} )();
