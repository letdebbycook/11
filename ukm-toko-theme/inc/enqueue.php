<?php
/**
 * Enqueue CSS dan JavaScript tema.
 *
 * Prinsip:
 * - Versi selalu pakai konstanta UKM_THEME_VERSION agar cache-buster konsisten.
 * - Font Inter di-self-host — tidak ada request ke Google Fonts CDN.
 * - CSS utama di-enqueue, critical CSS di-inline via wp_add_inline_style.
 * - JS utama di-defer, tidak ada library berat.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue aset frontend (CSS & JS).
 *
 * @since 1.0.0
 */
function ukm_enqueue_assets() {

	// ----------------------------------------------------------------
	// CSS
	// ----------------------------------------------------------------

	// Stylesheet utama tema (style.css di root).
	wp_enqueue_style(
		'ukm-main-style',
		get_stylesheet_uri(),
		array(),
		UKM_THEME_VERSION
	);

	// CSS komponen UI tema.
	wp_enqueue_style(
		'ukm-components',
		UKM_THEME_URI . 'assets/css/components.css',
		array( 'ukm-main-style' ),
		UKM_THEME_VERSION
	);

	// Inline critical CSS di <head> — menghilangkan render-blocking.
	// File critical.css di-generate secara lokal kemudian disimpan sebagai string.
	$critical_css_path = UKM_THEME_DIR . 'assets/css/critical.css';
	if ( file_exists( $critical_css_path ) ) {
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$critical_css = file_get_contents( $critical_css_path );
		if ( $critical_css ) {
			wp_add_inline_style( 'ukm-main-style', $critical_css );
		}
	}

	// CSS WooCommerce tambahan (hanya dimuat jika WooCommerce aktif).
	if ( ukm_is_woocommerce_active() ) {
		wp_enqueue_style(
			'ukm-woocommerce-style',
			UKM_THEME_URI . 'assets/css/woocommerce.css',
			array( 'ukm-main-style' ),
			UKM_THEME_VERSION
		);
	}

	// ----------------------------------------------------------------
	// Preload font Inter self-host (optimasi LCP & CLS)
	// ----------------------------------------------------------------
	add_action( 'wp_head', 'ukm_preload_fonts', 1 );

	// ----------------------------------------------------------------
	// JavaScript
	// ----------------------------------------------------------------

	// Script navigasi (mobile menu, dropdown).
	wp_enqueue_script(
		'ukm-navigation',
		UKM_THEME_URI . 'assets/js/navigation.js',
		array(),
		UKM_THEME_VERSION,
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);

	// Script utama tema.
	wp_enqueue_script(
		'ukm-main',
		UKM_THEME_URI . 'assets/js/main.js',
		array( 'ukm-navigation' ),
		UKM_THEME_VERSION,
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);

	// Lokalisasi data PHP → JavaScript (aman untuk data dinamis).
	wp_localize_script(
		'ukm-main',
		'ukmData',
		array(
			'ajaxUrl'   => esc_url( admin_url( 'admin-ajax.php' ) ),
			'nonce'     => wp_create_nonce( 'ukm_ajax_nonce' ),
			'homeUrl'   => esc_url( home_url( '/' ) ),
			'themeUrl'  => esc_url( UKM_THEME_URI ),
			'cartUrl'   => function_exists( 'wc_get_cart_url' ) ? esc_url( wc_get_cart_url() ) : '',
			'i18n'      => array(
				'menuToggleOpen'  => esc_html__( 'Buka menu', 'ukm-toko-theme' ),
				'menuToggleClose' => esc_html__( 'Tutup menu', 'ukm-toko-theme' ),
			),
		)
	);

	// Script WooCommerce mini-cart AJAX (hanya di halaman yang relevan).
	if ( ukm_is_woocommerce_active() && ! is_cart() && ! is_checkout() ) {
		wp_enqueue_script(
			'ukm-minicart',
			UKM_THEME_URI . 'assets/js/minicart.js',
			array( 'jquery', 'wc-cart-fragments' ),
			UKM_THEME_VERSION,
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);
	}

	// Script komentar (hanya di single post yang punya komentar).
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ukm_enqueue_assets' );

/**
 * Output tag preload untuk font Inter self-hosted.
 *
 * Preloading font mengurangi waktu render teks (menghilangkan FOUT).
 * Hanya preload varian yang dipakai di critical path.
 *
 * @since 1.0.0
 */
function ukm_preload_fonts() {
	$fonts = array(
		'inter/inter-regular.woff2',
		'inter/inter-medium.woff2',
		'inter/inter-bold.woff2',
	);

	foreach ( $fonts as $font_file ) {
		$font_path = UKM_THEME_DIR . 'assets/fonts/' . $font_file;
		if ( file_exists( $font_path ) ) {
			$font_url = UKM_THEME_URI . 'assets/fonts/' . $font_file;
			echo '<link rel="preload" href="' . esc_url( $font_url ) . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
		}
	}
}

/**
 * Enqueue aset untuk panel WordPress Customizer (preview real-time).
 *
 * @since 1.0.0
 */
function ukm_customizer_live_preview() {
	wp_enqueue_script(
		'ukm-customizer',
		UKM_THEME_URI . 'assets/js/customizer.js',
		array( 'jquery', 'customize-preview' ),
		UKM_THEME_VERSION,
		array(
			'in_footer' => true,
		)
	);
}
add_action( 'customize_preview_init', 'ukm_customizer_live_preview' );

/**
 * Enqueue aset untuk editor blok Gutenberg (admin).
 *
 * @since 1.0.0
 */
function ukm_enqueue_block_editor_assets() {
	// Style editor — agar tampilan di editor sama dengan frontend.
	wp_enqueue_style(
		'ukm-block-editor-style',
		UKM_THEME_URI . 'assets/css/editor-style.css',
		array( 'wp-edit-blocks' ),
		UKM_THEME_VERSION
	);
}
add_action( 'enqueue_block_editor_assets', 'ukm_enqueue_block_editor_assets' );

/**
 * Hapus emoji WordPress — menghemat DNS lookup & request JS/CSS kecil.
 *
 * Catatan: ini aman karena browser modern sudah mendukung emoji natively.
 *
 * @since 1.0.0
 */
function ukm_disable_emoji() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'ukm_disable_emoji_tinymce' );
	add_filter( 'wp_resource_hints', 'ukm_remove_emoji_dns_prefetch', 10, 2 );
}
add_action( 'init', 'ukm_disable_emoji' );

/**
 * Hapus plugin emoji dari TinyMCE.
 *
 * @since  1.0.0
 * @param  array $plugins Daftar plugin TinyMCE.
 * @return array Daftar tanpa plugin wpemoji.
 */
function ukm_disable_emoji_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	}
	return array();
}

/**
 * Hapus DNS prefetch emoji dari <head>.
 *
 * @since  1.0.0
 * @param  array  $urls          Daftar URL hints.
 * @param  string $relation_type Tipe relasi (dns-prefetch, dll.).
 * @return array Daftar URL tanpa emoji CDN.
 */
function ukm_remove_emoji_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
		$urls          = array_diff( $urls, array( $emoji_svg_url ) );
	}
	return $urls;
}

/**
 * Hapus versi WordPress dari query string aset — menghindari fingerprinting.
 *
 * @since  1.0.0
 * @param  string $src URL aset.
 * @return string URL tanpa ?ver=...
 */
function ukm_remove_asset_version( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'style_loader_src', 'ukm_remove_asset_version', 9999 );
add_filter( 'script_loader_src', 'ukm_remove_asset_version', 9999 );

if ( ! function_exists( 'ukm_is_woocommerce_active' ) ) {
	/**
	 * Periksa apakah plugin WooCommerce aktif.
	 *
	 * Helper kecil agar tidak perlu mengulang pemeriksaan di setiap file.
	 *
	 * @since  1.0.0
	 * @return bool True jika WooCommerce aktif.
	 */
	function ukm_is_woocommerce_active() {
		return class_exists( 'WooCommerce' );
	}
}
