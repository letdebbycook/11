/**
 * Customizer Live Preview JavaScript.
 *
 * Mengupdate tampilan preview Customizer secara real-time
 * tanpa reload halaman menggunakan transport: 'postMessage'.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

( function ( $ ) {
	'use strict';

	// ---- Warna Aksen Utama ----
	wp.customize( 'ukm_color_primary', function ( value ) {
		value.bind( function ( newval ) {
			document.documentElement.style.setProperty( '--ukm-color-primary', newval );
		} );
	} );

	// ---- Warna Aksen Gelap ----
	wp.customize( 'ukm_color_primary_dark', function ( value ) {
		value.bind( function ( newval ) {
			document.documentElement.style.setProperty( '--ukm-color-primary-dark', newval );
		} );
	} );

	// ---- Warna Teks ----
	wp.customize( 'ukm_color_text', function ( value ) {
		value.bind( function ( newval ) {
			document.documentElement.style.setProperty( '--ukm-color-gray-900', newval );
		} );
	} );

	// ---- Warna Background ----
	wp.customize( 'ukm_color_background', function ( value ) {
		value.bind( function ( newval ) {
			document.body.style.backgroundColor = newval;
		} );
	} );

	// ---- Ukuran Font ----
	wp.customize( 'ukm_font_size_base', function ( value ) {
		value.bind( function ( newval ) {
			document.documentElement.style.setProperty( '--ukm-font-size-base', newval + 'px' );
		} );
	} );

	// ---- Nama Toko di Header ----
	wp.customize( 'ukm_header_site_name', function ( value ) {
		value.bind( function ( newval ) {
			var logoText = document.querySelector( '.ukm-site-logo-text' );
			if ( logoText ) {
				var kata  = newval.trim().split( ' ' );
				var html  = '<span>' + kata[0] + '</span>';
				if ( kata.length > 1 ) {
					html += ' ' + kata.slice( 1 ).join( ' ' );
				}
				logoText.innerHTML = html;
			}
		} );
	} );

	// ---- Copyright Footer ----
	wp.customize( 'ukm_footer_copyright', function ( value ) {
		value.bind( function ( newval ) {
			var copyright = document.querySelector( '.ukm-footer-copyright' );
			if ( copyright ) {
				copyright.innerHTML = newval;
			}
		} );
	} );

	// ---- Deskripsi Footer ----
	wp.customize( 'ukm_footer_desc', function ( value ) {
		value.bind( function ( newval ) {
			var desc = document.querySelector( '.ukm-footer-desc' );
			if ( desc ) {
				desc.textContent = newval;
			}
		} );
	} );

} )( jQuery );
