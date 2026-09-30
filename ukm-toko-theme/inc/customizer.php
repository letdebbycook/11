<?php
/**
 * Customizer WordPress — warna, tipografi, header, footer.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Daftarkan pengaturan dan kontrol Customizer.
 *
 * @since  1.0.0
 * @param  WP_Customize_Manager $wp_customize Objek Customizer.
 * @return void
 */
function ukm_customize_register( $wp_customize ) {

	// ============================================================
	// Panel: Pengaturan Tema UKM
	// ============================================================

	$wp_customize->add_panel(
		'ukm_tema_panel',
		array(
			'title'       => __( 'Pengaturan Tema UKM', 'ukm-toko-theme' ),
			'description' => __( 'Kustomisasi tampilan tema toko sembako.', 'ukm-toko-theme' ),
			'priority'    => 30,
		)
	);

	// ============================================================
	// Section: Warna
	// ============================================================

	$wp_customize->add_section(
		'ukm_section_warna',
		array(
			'title'    => __( 'Warna Tema', 'ukm-toko-theme' ),
			'panel'    => 'ukm_tema_panel',
			'priority' => 10,
		)
	);

	// Warna aksen utama.
	$wp_customize->add_setting(
		'ukm_color_primary',
		array(
			'default'           => '#2D6A4F',
			'transport'         => 'postMessage',    // Live preview tanpa reload.
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ukm_color_primary',
			array(
				'label'       => __( 'Warna Aksen Utama', 'ukm-toko-theme' ),
				'description' => __( 'Warna tombol, link aktif, dan elemen aksen.', 'ukm-toko-theme' ),
				'section'     => 'ukm_section_warna',
			)
		)
	);

	// Warna aksen gelap (hover).
	$wp_customize->add_setting(
		'ukm_color_primary_dark',
		array(
			'default'           => '#1B4332',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ukm_color_primary_dark',
			array(
				'label'       => __( 'Warna Aksen Gelap (Hover)', 'ukm-toko-theme' ),
				'description' => __( 'Digunakan saat tombol/link di-hover.', 'ukm-toko-theme' ),
				'section'     => 'ukm_section_warna',
			)
		)
	);

	// Warna teks utama.
	$wp_customize->add_setting(
		'ukm_color_text',
		array(
			'default'           => '#111827',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ukm_color_text',
			array(
				'label'   => __( 'Warna Teks Utama', 'ukm-toko-theme' ),
				'section' => 'ukm_section_warna',
			)
		)
	);

	// Warna background halaman.
	$wp_customize->add_setting(
		'ukm_color_background',
		array(
			'default'           => '#FFFFFF',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ukm_color_background',
			array(
				'label'   => __( 'Warna Background Halaman', 'ukm-toko-theme' ),
				'section' => 'ukm_section_warna',
			)
		)
	);

	// ============================================================
	// Section: Tipografi
	// ============================================================

	$wp_customize->add_section(
		'ukm_section_tipografi',
		array(
			'title'    => __( 'Tipografi', 'ukm-toko-theme' ),
			'panel'    => 'ukm_tema_panel',
			'priority' => 20,
		)
	);

	// Ukuran font dasar.
	$wp_customize->add_setting(
		'ukm_font_size_base',
		array(
			'default'           => '16',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'ukm_font_size_base',
		array(
			'label'       => __( 'Ukuran Font Dasar (px)', 'ukm-toko-theme' ),
			'description' => __( 'Ukuran teks body. Direkomendasikan: 15–18px.', 'ukm-toko-theme' ),
			'section'     => 'ukm_section_tipografi',
			'type'        => 'range',
			'input_attrs' => array(
				'min'  => 14,
				'max'  => 20,
				'step' => 1,
			),
		)
	);

	// ============================================================
	// Section: Header
	// ============================================================

	$wp_customize->add_section(
		'ukm_section_header',
		array(
			'title'    => __( 'Header', 'ukm-toko-theme' ),
			'panel'    => 'ukm_tema_panel',
			'priority' => 30,
		)
	);

	// Teks nama toko di header (jika tidak ada logo).
	$wp_customize->add_setting(
		'ukm_header_site_name',
		array(
			'default'           => get_bloginfo( 'name' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'ukm_header_site_name',
		array(
			'label'       => __( 'Nama Toko di Header', 'ukm-toko-theme' ),
			'description' => __( 'Tampil jika custom logo belum diatur.', 'ukm-toko-theme' ),
			'section'     => 'ukm_section_header',
			'type'        => 'text',
		)
	);

	// Tampilkan nomor WhatsApp di header.
	$wp_customize->add_setting(
		'ukm_header_show_whatsapp',
		array(
			'default'           => true,
			'transport'         => 'refresh',
			'sanitize_callback' => 'ukm_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'ukm_header_show_whatsapp',
		array(
			'label'   => __( 'Tampilkan tombol WhatsApp di header', 'ukm-toko-theme' ),
			'section' => 'ukm_section_header',
			'type'    => 'checkbox',
		)
	);

	// Tampilkan mini cart di header.
	$wp_customize->add_setting(
		'ukm_header_show_cart',
		array(
			'default'           => true,
			'transport'         => 'refresh',
			'sanitize_callback' => 'ukm_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'ukm_header_show_cart',
		array(
			'label'   => __( 'Tampilkan ikon keranjang WooCommerce di header', 'ukm-toko-theme' ),
			'section' => 'ukm_section_header',
			'type'    => 'checkbox',
		)
	);

	// ============================================================
	// Section: Footer
	// ============================================================

	$wp_customize->add_section(
		'ukm_section_footer',
		array(
			'title'    => __( 'Footer', 'ukm-toko-theme' ),
			'panel'    => 'ukm_tema_panel',
			'priority' => 40,
		)
	);

	// Teks copyright footer.
	$wp_customize->add_setting(
		'ukm_footer_copyright',
		array(
			// translators: %d adalah tahun saat ini.
			'default'           => sprintf( __( '&copy; %d Toko Sembako. Semua hak dilindungi.', 'ukm-toko-theme' ), gmdate( 'Y' ) ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'ukm_sanitize_html',
		)
	);

	$wp_customize->add_control(
		'ukm_footer_copyright',
		array(
			'label'       => __( 'Teks Copyright', 'ukm-toko-theme' ),
			'description' => __( 'Teks di bagian bawah footer. HTML dasar diizinkan.', 'ukm-toko-theme' ),
			'section'     => 'ukm_section_footer',
			'type'        => 'textarea',
		)
	);

	// Teks deskripsi footer.
	$wp_customize->add_setting(
		'ukm_footer_desc',
		array(
			'default'           => __( 'Menyediakan kebutuhan sembako berkualitas dengan harga terjangkau untuk masyarakat sekitar.', 'ukm-toko-theme' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);

	$wp_customize->add_control(
		'ukm_footer_desc',
		array(
			'label'   => __( 'Deskripsi Singkat Toko di Footer', 'ukm-toko-theme' ),
			'section' => 'ukm_section_footer',
			'type'    => 'textarea',
		)
	);
}
add_action( 'customize_register', 'ukm_customize_register' );

/**
 * Sanitasi nilai checkbox Customizer.
 *
 * @since  1.0.0
 * @param  mixed $value Nilai dari kontrol checkbox.
 * @return bool True atau False.
 */
function ukm_sanitize_checkbox( $value ) {
	return (bool) $value;
}

/**
 * Output CSS dinamis berdasarkan pengaturan Customizer.
 *
 * Ini menggantikan penggunaan file CSS statis untuk nilai yang bisa
 * diubah pengguna. Di-inline di <head> agar tidak ada render-blocking.
 *
 * @since 1.0.0
 */
function ukm_customizer_dynamic_css() {
	$color_primary       = get_theme_mod( 'ukm_color_primary', '#2D6A4F' );
	$color_primary_dark  = get_theme_mod( 'ukm_color_primary_dark', '#1B4332' );
	$color_text          = get_theme_mod( 'ukm_color_text', '#111827' );
	$color_background    = get_theme_mod( 'ukm_color_background', '#FFFFFF' );
	$font_size_base      = absint( get_theme_mod( 'ukm_font_size_base', 16 ) );

	// Validasi warna — hanya izinkan hex color yang valid.
	$color_primary      = sanitize_hex_color( $color_primary ) ?: '#2D6A4F';
	$color_primary_dark = sanitize_hex_color( $color_primary_dark ) ?: '#1B4332';
	$color_text         = sanitize_hex_color( $color_text ) ?: '#111827';
	$color_background   = sanitize_hex_color( $color_background ) ?: '#FFFFFF';

	// Batasi ukuran font agar tidak di luar jangkauan.
	$font_size_base = max( 14, min( 20, $font_size_base ) );

	// Bangun CSS — hanya output jika nilai berbeda dari default.
	$css = '';

	$defaults_match = (
		'#2D6A4F' === $color_primary &&
		'#1B4332' === $color_primary_dark &&
		'#111827' === $color_text &&
		'#FFFFFF' === $color_background &&
		16 === $font_size_base
	);

	if ( ! $defaults_match ) {
		$css .= ':root {';

		if ( '#2D6A4F' !== $color_primary ) {
			$css .= '--ukm-color-primary:' . $color_primary . ';';
		}
		if ( '#1B4332' !== $color_primary_dark ) {
			$css .= '--ukm-color-primary-dark:' . $color_primary_dark . ';';
		}
		if ( '#111827' !== $color_text ) {
			$css .= '--ukm-color-gray-900:' . $color_text . ';';
		}
		if ( '#FFFFFF' !== $color_background ) {
			$css .= 'background-color:' . $color_background . ';';
		}
		if ( 16 !== $font_size_base ) {
			$css .= '--ukm-font-size-base:' . $font_size_base . 'px;';
		}

		$css .= '}';
	}

	if ( $css ) {
		echo '<style id="ukm-customizer-css">' . wp_strip_all_tags( $css ) . '</style>' . "\n";
	}
}
add_action( 'wp_head', 'ukm_customizer_dynamic_css', 99 );
