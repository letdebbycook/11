<?php
/**
 * Fungsi utama tema ukm-toko-theme.
 *
 * File ini hanya sebagai titik masuk. Semua logika dipecah ke /inc
 * agar mudah dirawat dan diuji secara terpisah.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

// Keamanan: cegah akses langsung ke file ini.
defined( 'ABSPATH' ) || exit;

// ============================================================
// Konstanta global tema
// ============================================================

/**
 * Versi tema — dipakai sebagai cache-buster saat enqueue aset.
 * Selalu perbarui saat ada rilis baru.
 */
define( 'UKM_THEME_VERSION', '1.0.0' );

/**
 * Direktori tema (dengan trailing slash).
 */
define( 'UKM_THEME_DIR', trailingslashit( get_template_directory() ) );

/**
 * URL tema (dengan trailing slash).
 */
define( 'UKM_THEME_URI', trailingslashit( get_template_directory_uri() ) );

/**
 * Text domain tema — harus sama dengan yang di style.css.
 */
define( 'UKM_TEXT_DOMAIN', 'ukm-toko-theme' );

// ============================================================
// Muat file /inc secara berurutan sesuai dependensi
// ============================================================

$ukm_inc_files = array(
	'inc/setup.php',          // Theme support, nav menus, image sizes
	'inc/enqueue.php',        // Enqueue CSS & JS
	'inc/customizer.php',     // WordPress Customizer
	'inc/security.php',       // Header keamanan, helper sanitasi
	'inc/cpt.php',            // Custom Post Types
	'inc/taxonomy.php',       // Custom Taxonomies
	'inc/acf.php',            // Advanced Custom Fields & fallback meta boxes
	'inc/settings-page.php',  // Halaman opsi global (fallback ACF Options Page)
	'inc/woocommerce.php',    // Dukungan dan kustomisasi WooCommerce
	'inc/seo.php',            // Schema JSON-LD, breadcrumb, Open Graph
	'inc/template-functions.php', // Fungsi pembantu untuk template
);

foreach ( $ukm_inc_files as $ukm_file ) {
	$ukm_path = UKM_THEME_DIR . $ukm_file;

	if ( file_exists( $ukm_path ) ) {
		require_once $ukm_path;
	} else {
		// Catat error hanya di environment development — tidak bocor ke pengunjung.
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			// translators: %s adalah path file yang tidak ditemukan.
			trigger_error( sprintf( esc_html__( 'File tema tidak ditemukan: %s', 'ukm-toko-theme' ), esc_html( $ukm_path ) ), E_USER_WARNING );
		}
	}
}

// Bersihkan variabel loop.
unset( $ukm_inc_files, $ukm_file, $ukm_path );
