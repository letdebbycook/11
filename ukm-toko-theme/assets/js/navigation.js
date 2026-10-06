/**
 * JavaScript navigasi: mobile menu, sticky header (Barter split layout).
 *
 * Prinsip:
 * - Tidak ada jQuery dependency.
 * - Aksesibel: ARIA attributes diperbarui secara dinamis.
 * - Graceful: jika JS dinonaktifkan, menu masih bisa diakses via CSS :focus-within.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

( function () {
	'use strict';

	/**
	 * Toggle mobile menu.
	 * Hamburger ada di header, mobile-nav ada di navbar.
	 */
	function initMobileMenu() {
		var menuToggle = document.getElementById( 'ukm-menu-toggle' );
		var mobileNav  = document.getElementById( 'ukm-mobile-nav' );
		var navbar     = document.querySelector( '.ukm-site-navbar' );

		if ( ! menuToggle ) {
			return;
		}

		menuToggle.addEventListener( 'click', function () {
			var isOpen = menuToggle.getAttribute( 'aria-expanded' ) === 'true';

			menuToggle.setAttribute( 'aria-expanded', isOpen ? 'false' : 'true' );

			if ( mobileNav ) {
				mobileNav.setAttribute( 'aria-hidden', isOpen ? 'true' : 'false' );
				if ( isOpen ) {
					mobileNav.hidden = true;
					mobileNav.classList.remove( 'is-open' );
				} else {
					mobileNav.hidden = false;
					mobileNav.classList.add( 'is-open' );
				}
			}

			if ( navbar ) {
				navbar.classList.toggle( 'mobile-open', ! isOpen );
			}

			var label = isOpen
				? ( window.ukmData && ukmData.i18n ? ukmData.i18n.menuToggleOpen : 'Buka menu' )
				: ( window.ukmData && ukmData.i18n ? ukmData.i18n.menuToggleClose : 'Tutup menu' );
			menuToggle.setAttribute( 'aria-label', label );
		} );

		// Tutup menu mobile jika klik di luar.
		document.addEventListener( 'click', function ( event ) {
			if ( ! mobileNav ) return;
			if (
				mobileNav.classList.contains( 'is-open' ) &&
				! mobileNav.contains( event.target ) &&
				! menuToggle.contains( event.target )
			) {
				menuToggle.setAttribute( 'aria-expanded', 'false' );
				mobileNav.setAttribute( 'aria-hidden', 'true' );
				mobileNav.hidden = true;
				mobileNav.classList.remove( 'is-open' );
				if ( navbar ) navbar.classList.remove( 'mobile-open' );
				menuToggle.setAttribute( 'aria-label', window.ukmData && ukmData.i18n ? ukmData.i18n.menuToggleOpen : 'Buka menu' );
			}
		} );

		// Tutup menu jika tekan Escape.
		document.addEventListener( 'keydown', function ( event ) {
			if ( ! mobileNav ) return;
			if ( event.key === 'Escape' && mobileNav.classList.contains( 'is-open' ) ) {
				menuToggle.setAttribute( 'aria-expanded', 'false' );
				mobileNav.setAttribute( 'aria-hidden', 'true' );
				mobileNav.hidden = true;
				mobileNav.classList.remove( 'is-open' );
				if ( navbar ) navbar.classList.remove( 'mobile-open' );
				menuToggle.focus();
			}
		} );
	}

	/**
	 * Sticky header dengan shadow saat scroll.
	 */
	function initStickyHeader() {
		var header = document.querySelector( '.ukm-site-header' );
		var navbar = document.querySelector( '.ukm-site-navbar' );

		if ( ! header ) {
			return;
		}

		var threshold = 10;

		function onScroll() {
			if ( window.scrollY > threshold ) {
				header.classList.add( 'is-scrolled' );
				if ( navbar ) navbar.classList.add( 'is-scrolled' );
			} else {
				header.classList.remove( 'is-scrolled' );
				if ( navbar ) navbar.classList.remove( 'is-scrolled' );
			}
		}

		onScroll();
		window.addEventListener( 'scroll', onScroll, { passive: true } );
	}

	/**
	 * Tambahkan efek hover underline aktif ke navbar item berdasarkan URL saat ini.
	 */
	function initNavbarActiveState() {
		var navLinks = document.querySelectorAll( '.ukm-navbar-menu a' );
		var currentUrl = window.location.href;

		navLinks.forEach( function ( link ) {
			if ( link.href === currentUrl || currentUrl.indexOf( link.href ) === 0 ) {
				link.parentElement.classList.add( 'current-menu-item' );
			}
		} );
	}

	/**
	 * Smooth scroll untuk anchor links di halaman yang sama.
	 */
	function initSmoothScroll() {
		var headerHeight = document.querySelector( '.ukm-site-header' );
		var navbarHeight = document.querySelector( '.ukm-site-navbar' );
		var offset = ( headerHeight ? headerHeight.offsetHeight : 80 )
		           + ( navbarHeight ? navbarHeight.offsetHeight : 52 );

		document.querySelectorAll( 'a[href^="#"]' ).forEach( function ( anchor ) {
			anchor.addEventListener( 'click', function ( e ) {
				var target = document.querySelector( this.getAttribute( 'href' ) );
				if ( target ) {
					e.preventDefault();
					var top = target.getBoundingClientRect().top + window.scrollY - offset - 16;
					window.scrollTo( { top: top, behavior: 'smooth' } );
				}
			} );
		} );
	}

	// Inisialisasi semua fitur navigasi.
	document.addEventListener( 'DOMContentLoaded', function () {
		initMobileMenu();
		initStickyHeader();
		initNavbarActiveState();
		initSmoothScroll();
	} );

} )();
