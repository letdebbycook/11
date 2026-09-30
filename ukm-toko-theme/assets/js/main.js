/**
 * JavaScript utama tema ukm-toko-theme.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

( function () {
	'use strict';

	/**
	 * Varian produk — perbarui harga saat ukuran dipilih.
	 */
	function initVarianProduk() {
		var varianContainer = document.querySelector( '.ukm-varian-list' );

		if ( ! varianContainer ) {
			return;
		}

		var hargaDisplay = document.querySelector( '.ukm-produk-info__price-value' );
		var radios       = varianContainer.querySelectorAll( 'input[type="radio"]' );

		radios.forEach( function ( radio ) {
			radio.addEventListener( 'change', function () {
				var harga = this.getAttribute( 'data-harga' );

				if ( harga && hargaDisplay ) {
					// Format harga ke Rupiah.
					var hargaNum    = parseInt( harga, 10 );
					var hargaFormat = 'Rp ' + hargaNum.toLocaleString( 'id-ID' );
					hargaDisplay.textContent = hargaFormat;
				}
			} );
		} );
	}

	/**
	 * Lazy load gambar dengan IntersectionObserver sebagai enhancement.
	 * (Browser modern sudah mendukung loading="lazy" natively,
	 *  ini sebagai fallback untuk browser lama)
	 */
	function initLazyImages() {
		if ( 'loading' in HTMLImageElement.prototype ) {
			return; // Browser mendukung native lazy loading — tidak perlu polyfill.
		}

		var images = document.querySelectorAll( 'img[loading="lazy"]' );

		if ( ! images.length || ! ( 'IntersectionObserver' in window ) ) {
			return;
		}

		var observer = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					var img = entry.target;
					img.src = img.dataset.src || img.src;
					observer.unobserve( img );
				}
			} );
		}, { rootMargin: '200px 0px' } );

		images.forEach( function ( img ) {
			observer.observe( img );
		} );
	}

	/**
	 * Smooth scroll untuk anchor link internal.
	 */
	function initSmoothScroll() {
		document.addEventListener( 'click', function ( event ) {
			var link = event.target.closest( 'a[href^="#"]' );

			if ( ! link ) {
				return;
			}

			var href   = link.getAttribute( 'href' );
			var target = document.querySelector( href );

			if ( ! target ) {
				return;
			}

			event.preventDefault();

			var headerHeight = document.querySelector( '.ukm-site-header' )
				? document.querySelector( '.ukm-site-header' ).offsetHeight
				: 0;

			var targetTop = target.getBoundingClientRect().top + window.scrollY - headerHeight - 16;

			window.scrollTo( { top: targetTop, behavior: 'smooth' } );
			target.focus( { preventScroll: true } );
		} );
	}

	/**
	 * Tracking klik WhatsApp (opsional — untuk analitik).
	 */
	function initWhatsAppTracking() {
		var waButtons = document.querySelectorAll( '.ukm-wa-btn, .ukm-header-wa' );

		waButtons.forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				// Kirim event ke Google Analytics jika tersedia.
				if ( typeof gtag !== 'undefined' ) {
					gtag( 'event', 'click_whatsapp', {
						event_category: 'CTA',
						event_label: window.location.pathname,
					} );
				}
			} );
		} );
	}

	/**
	 * Tracking klik CTA (untuk analitik).
	 */
	function initCTATracking() {
		document.addEventListener( 'click', function ( event ) {
			var cta = event.target.closest( '.ukm-btn--primary' );

			if ( ! cta ) {
				return;
			}

			if ( typeof gtag !== 'undefined' ) {
				gtag( 'event', 'click_cta', {
					event_category: 'CTA',
					event_label: cta.textContent.trim(),
					event_value: window.location.pathname,
				} );
			}
		} );
	}

	// Inisialisasi saat DOM siap.
	document.addEventListener( 'DOMContentLoaded', function () {
		initVarianProduk();
		initLazyImages();
		initSmoothScroll();
		initWhatsAppTracking();
		initCTATracking();
	} );

} )();
