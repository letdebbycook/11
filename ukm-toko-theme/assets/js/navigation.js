/**
 * JavaScript navigasi: mobile menu, dropdown, panel pencarian.
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
	 */
	function initMobileMenu() {
		var menuToggle  = document.getElementById( 'ukm-menu-toggle' );
		var mobileNav   = document.getElementById( 'ukm-mobile-nav' );

		if ( ! menuToggle || ! mobileNav ) {
			return;
		}

		menuToggle.addEventListener( 'click', function () {
			var isOpen = menuToggle.getAttribute( 'aria-expanded' ) === 'true';

			menuToggle.setAttribute( 'aria-expanded', isOpen ? 'false' : 'true' );
			mobileNav.setAttribute( 'aria-hidden', isOpen ? 'true' : 'false' );

			if ( isOpen ) {
				mobileNav.hidden = true;
				mobileNav.classList.remove( 'is-open' );
				menuToggle.setAttribute( 'aria-label', ukmData.i18n.menuToggleOpen );
			} else {
				mobileNav.hidden = false;
				mobileNav.classList.add( 'is-open' );
				menuToggle.setAttribute( 'aria-label', ukmData.i18n.menuToggleClose );
			}
		} );

		// Tutup menu mobile jika klik di luar.
		document.addEventListener( 'click', function ( event ) {
			if (
				mobileNav.classList.contains( 'is-open' ) &&
				! mobileNav.contains( event.target ) &&
				! menuToggle.contains( event.target )
			) {
				menuToggle.setAttribute( 'aria-expanded', 'false' );
				mobileNav.setAttribute( 'aria-hidden', 'true' );
				mobileNav.hidden = true;
				mobileNav.classList.remove( 'is-open' );
				menuToggle.setAttribute( 'aria-label', ukmData.i18n.menuToggleOpen );
			}
		} );

		// Tutup menu jika tekan Escape.
		document.addEventListener( 'keydown', function ( event ) {
			if ( event.key === 'Escape' && mobileNav.classList.contains( 'is-open' ) ) {
				menuToggle.setAttribute( 'aria-expanded', 'false' );
				mobileNav.setAttribute( 'aria-hidden', 'true' );
				mobileNav.hidden = true;
				mobileNav.classList.remove( 'is-open' );
				menuToggle.focus();
			}
		} );
	}

	/**
	 * Toggle panel pencarian.
	 */
	function initSearchPanel() {
		var searchToggle = document.getElementById( 'ukm-search-toggle' );
		var searchPanel  = document.getElementById( 'ukm-search-panel' );
		var searchInput  = document.getElementById( 'ukm-search-input' );

		if ( ! searchToggle || ! searchPanel ) {
			return;
		}

		searchToggle.addEventListener( 'click', function () {
			var isOpen = searchToggle.getAttribute( 'aria-expanded' ) === 'true';

			searchToggle.setAttribute( 'aria-expanded', isOpen ? 'false' : 'true' );
			searchPanel.setAttribute( 'aria-hidden', isOpen ? 'true' : 'false' );

			if ( isOpen ) {
				searchPanel.hidden = true;
			} else {
				searchPanel.hidden = false;
				// Fokus ke input setelah panel terbuka.
				setTimeout( function () {
					if ( searchInput ) {
						searchInput.focus();
					}
				}, 50 );
			}
		} );

		// Tutup panel pencarian jika klik di luar.
		document.addEventListener( 'click', function ( event ) {
			if (
				! searchPanel.hidden &&
				! searchPanel.contains( event.target ) &&
				! searchToggle.contains( event.target )
			) {
				searchToggle.setAttribute( 'aria-expanded', 'false' );
				searchPanel.setAttribute( 'aria-hidden', 'true' );
				searchPanel.hidden = true;
			}
		} );

		// Tutup panel pencarian jika tekan Escape.
		document.addEventListener( 'keydown', function ( event ) {
			if ( event.key === 'Escape' && ! searchPanel.hidden ) {
				searchToggle.setAttribute( 'aria-expanded', 'false' );
				searchPanel.setAttribute( 'aria-hidden', 'true' );
				searchPanel.hidden = true;
				searchToggle.focus();
			}
		} );
	}

	/**
	 * Tambahkan class 'is-scrolled' ke header saat halaman di-scroll.
	 */
	function initStickyHeader() {
		var header = document.querySelector( '.ukm-site-header' );

		if ( ! header ) {
			return;
		}

		var threshold = 50;

		function onScroll() {
			if ( window.scrollY > threshold ) {
				header.classList.add( 'is-scrolled' );
			} else {
				header.classList.remove( 'is-scrolled' );
			}
		}

		// Periksa posisi scroll saat halaman pertama dimuat.
		onScroll();

		// Gunakan passive event listener untuk performa scroll lebih baik.
		window.addEventListener( 'scroll', onScroll, { passive: true } );
	}

	// Inisialisasi semua fitur navigasi.
	document.addEventListener( 'DOMContentLoaded', function () {
		initMobileMenu();
		initSearchPanel();
		initStickyHeader();
	} );

} )();
