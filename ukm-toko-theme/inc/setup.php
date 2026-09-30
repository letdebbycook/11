<?php
/**
 * Setup tema: theme support, nav menus, ukuran gambar.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Daftarkan fitur-fitur tema ke WordPress.
 *
 * Dipanggil via action hook 'after_setup_theme'.
 *
 * @since 1.0.0
 */
function ukm_theme_setup() {

	// Muat file terjemahan tema.
	load_theme_textdomain( UKM_TEXT_DOMAIN, UKM_THEME_DIR . 'languages' );

	// Izinkan WordPress mengatur tag <title> secara otomatis.
	add_theme_support( 'title-tag' );

	// Aktifkan featured image (thumbnail) untuk post & CPT.
	add_theme_support( 'post-thumbnails' );

	// Dukung berbagai tipe konten HTML5 agar markup lebih bersih.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		)
	);

	// Logo custom via Customizer.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 88,
			'width'       => 220,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'ukm-site-logo-text' ),
		)
	);

	// Embed responsif (YouTube, Vimeo, dll.) agar tidak overflow.
	add_theme_support( 'responsive-embeds' );

	// Style editor Gutenberg agar sama dengan frontend.
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );

	// Lebar konten default untuk editor blok.
	add_theme_support( 'align-wide' );

	// Format post (opsional, untuk blog).
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'video' ) );

	// Warna blok — disable palet default WordPress, gunakan palet tema.
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => __( 'Hijau Utama', 'ukm-toko-theme' ),
				'slug'  => 'primary',
				'color' => '#2D6A4F',
			),
			array(
				'name'  => __( 'Hijau Gelap', 'ukm-toko-theme' ),
				'slug'  => 'primary-dark',
				'color' => '#1B4332',
			),
			array(
				'name'  => __( 'Hijau Terang', 'ukm-toko-theme' ),
				'slug'  => 'primary-light',
				'color' => '#52B788',
			),
			array(
				'name'  => __( 'Abu Gelap', 'ukm-toko-theme' ),
				'slug'  => 'gray-900',
				'color' => '#111827',
			),
			array(
				'name'  => __( 'Abu Sedang', 'ukm-toko-theme' ),
				'slug'  => 'gray-500',
				'color' => '#6B7280',
			),
			array(
				'name'  => __( 'Abu Terang', 'ukm-toko-theme' ),
				'slug'  => 'gray-100',
				'color' => '#F3F4F6',
			),
			array(
				'name'  => __( 'Putih', 'ukm-toko-theme' ),
				'slug'  => 'white',
				'color' => '#FFFFFF',
			),
		)
	);

	// Nonaktifkan palet warna default WordPress agar admin pakai palet tema.
	add_theme_support( 'disable-custom-colors' );

	// Ukuran font blok.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name' => __( 'Kecil', 'ukm-toko-theme' ),
				'size' => 14,
				'slug' => 'small',
			),
			array(
				'name' => __( 'Normal', 'ukm-toko-theme' ),
				'size' => 16,
				'slug' => 'normal',
			),
			array(
				'name' => __( 'Sedang', 'ukm-toko-theme' ),
				'size' => 18,
				'slug' => 'medium',
			),
			array(
				'name' => __( 'Besar', 'ukm-toko-theme' ),
				'size' => 24,
				'slug' => 'large',
			),
			array(
				'name' => __( 'Sangat Besar', 'ukm-toko-theme' ),
				'size' => 36,
				'slug' => 'huge',
			),
		)
	);

	// Daftarkan menu navigasi.
	register_nav_menus(
		array(
			'primary'  => __( 'Menu Utama', 'ukm-toko-theme' ),
			'footer'   => __( 'Menu Footer', 'ukm-toko-theme' ),
			'social'   => __( 'Menu Media Sosial', 'ukm-toko-theme' ),
		)
	);
}
add_action( 'after_setup_theme', 'ukm_theme_setup' );

/**
 * Daftarkan ukuran gambar custom untuk tema.
 *
 * Dipanggil via action hook 'after_setup_theme'.
 *
 * @since 1.0.0
 */
function ukm_register_image_sizes() {

	// Thumbnail produk — rasio 4:3 untuk card.
	add_image_size( 'ukm-product-thumb', 520, 390, true );

	// Gambar featured produk — untuk halaman single.
	add_image_size( 'ukm-product-featured', 800, 600, true );

	// Banner hero — lebar penuh.
	add_image_size( 'ukm-hero-banner', 1920, 800, true );

	// Thumbnail blog — persegi.
	add_image_size( 'ukm-blog-thumb', 400, 300, true );

	// OG Image — standar Open Graph.
	add_image_size( 'ukm-og-image', 1200, 630, true );
}
add_action( 'after_setup_theme', 'ukm_register_image_sizes' );

/**
 * Tambahkan label ukuran gambar custom di media library WordPress.
 *
 * @since  1.0.0
 * @param  array $sizes Daftar ukuran gambar yang sudah ada.
 * @return array Daftar ukuran dengan tambahan custom tema.
 */
function ukm_add_image_size_names( $sizes ) {
	return array_merge(
		$sizes,
		array(
			'ukm-product-thumb'    => __( 'Thumbnail Produk (4:3)', 'ukm-toko-theme' ),
			'ukm-product-featured' => __( 'Gambar Utama Produk', 'ukm-toko-theme' ),
			'ukm-hero-banner'      => __( 'Banner Hero', 'ukm-toko-theme' ),
			'ukm-blog-thumb'       => __( 'Thumbnail Blog', 'ukm-toko-theme' ),
			'ukm-og-image'         => __( 'Open Graph (1200x630)', 'ukm-toko-theme' ),
		)
	);
}
add_filter( 'image_size_names_choose', 'ukm_add_image_size_names' );

/**
 * Daftarkan sidebar (widget area).
 *
 * @since 1.0.0
 */
function ukm_register_sidebars() {

	// Sidebar utama blog.
	register_sidebar(
		array(
			'id'            => 'ukm-sidebar-blog',
			'name'          => __( 'Sidebar Blog', 'ukm-toko-theme' ),
			'description'   => __( 'Widget untuk sidebar halaman blog dan arsip.', 'ukm-toko-theme' ),
			'before_widget' => '<div id="%1$s" class="ukm-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="ukm-widget__title">',
			'after_title'   => '</h3>',
		)
	);

	// Sidebar toko produk.
	register_sidebar(
		array(
			'id'            => 'ukm-sidebar-shop',
			'name'          => __( 'Sidebar Toko', 'ukm-toko-theme' ),
			'description'   => __( 'Widget untuk sidebar halaman arsip produk dan single produk.', 'ukm-toko-theme' ),
			'before_widget' => '<div id="%1$s" class="ukm-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="ukm-widget__title">',
			'after_title'   => '</h3>',
		)
	);

	// Footer kolom 1.
	register_sidebar(
		array(
			'id'            => 'ukm-footer-1',
			'name'          => __( 'Footer Kolom 1', 'ukm-toko-theme' ),
			'description'   => __( 'Widget area di footer, kolom pertama.', 'ukm-toko-theme' ),
			'before_widget' => '<div id="%1$s" class="ukm-footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="ukm-footer-heading">',
			'after_title'   => '</h4>',
		)
	);

	// Footer kolom 2.
	register_sidebar(
		array(
			'id'            => 'ukm-footer-2',
			'name'          => __( 'Footer Kolom 2', 'ukm-toko-theme' ),
			'description'   => __( 'Widget area di footer, kolom kedua.', 'ukm-toko-theme' ),
			'before_widget' => '<div id="%1$s" class="ukm-footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="ukm-footer-heading">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'ukm_register_sidebars' );

/**
 * Flush rewrite rules HANYA saat tema diaktifkan — bukan setiap request.
 *
 * Catatan: ini dipanggil via action 'after_switch_theme', bukan 'init',
 * agar tidak memperlambat setiap halaman yang dimuat.
 *
 * @since 1.0.0
 */
function ukm_flush_rewrite_on_activate() {
	// Pastikan CPT sudah terdaftar sebelum flush.
	if ( function_exists( 'ukm_register_post_types' ) ) {
		ukm_register_post_types();
	}
	if ( function_exists( 'ukm_register_taxonomies' ) ) {
		ukm_register_taxonomies();
	}
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'ukm_flush_rewrite_on_activate' );

/**
 * Ganti ukuran konten WordPress menjadi lebar yang sesuai tema.
 *
 * @since 1.0.0
 */
function ukm_content_width() {
	$GLOBALS['content_width'] = 1280;
}
add_action( 'after_setup_theme', 'ukm_content_width', 0 );
