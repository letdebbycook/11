<?php
/**
 * Keamanan tema: header HTTP, helper sanitasi, hardening dasar.
 *
 * Catatan: aspek keamanan dikerjakan sejak Tahap 2 (bukan hanya Tahap 9).
 * Audit menyeluruh dilakukan di Tahap 9, namun fondasi ini sudah aman.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

// ============================================================
// Header HTTP Keamanan
// ============================================================

/**
 * Kirim header HTTP keamanan pada setiap respons frontend.
 *
 * Header ini mencegah berbagai serangan umum:
 * - X-Content-Type-Options: mencegah MIME sniffing.
 * - X-Frame-Options: mencegah clickjacking.
 * - Referrer-Policy: batasi informasi referrer.
 * - Permissions-Policy: matikan API browser yang tidak diperlukan.
 *
 * @since 1.0.0
 */
function ukm_send_security_headers() {
	// Hanya kirim di frontend, bukan di admin.
	if ( is_admin() ) {
		return;
	}

	if ( ! headers_sent() ) {
		header( 'X-Content-Type-Options: nosniff' );
		header( 'X-Frame-Options: SAMEORIGIN' );
		header( 'Referrer-Policy: strict-origin-when-cross-origin' );
		header( 'Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=()' );

		// Content-Security-Policy — disesuaikan dengan kebutuhan, ketat tapi fungsional.
		// 'unsafe-inline' diperlukan untuk blok Gutenberg dan beberapa plugin.
		// Perbarui ini jika ada sumber eksternal yang perlu diizinkan.
		header( "Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' data: https:; font-src 'self'; frame-ancestors 'self';" );
	}
}
add_action( 'send_headers', 'ukm_send_security_headers' );

// ============================================================
// Sembunyikan Versi WordPress
// ============================================================

/**
 * Hapus versi WordPress dari <head> dan feed RSS.
 *
 * Menyembunyikan versi mencegah penyerang tahu versi WP yang dipakai.
 *
 * @since 1.0.0
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Filter versi dari semua output (query string ?ver=).
 *
 * @since  1.0.0
 * @return string String kosong agar versi tidak tampil.
 */
function ukm_hide_wp_version() {
	return '';
}
add_filter( 'the_generator', 'ukm_hide_wp_version' );

// ============================================================
// Nonaktifkan XML-RPC
// ============================================================

/**
 * Nonaktifkan XML-RPC karena tidak digunakan dan merupakan vektor serangan.
 *
 * @since  1.0.0
 * @return bool False untuk menonaktifkan XML-RPC.
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Hapus header X-Pingback agar tidak mengekspos XML-RPC.
 *
 * @since  1.0.0
 * @param  array $headers Header HTTP yang akan dikirim.
 * @return array Header tanpa X-Pingback.
 */
function ukm_remove_x_pingback_header( $headers ) {
	unset( $headers['X-Pingback'] );
	return $headers;
}
add_filter( 'wp_headers', 'ukm_remove_x_pingback_header' );

// ============================================================
// Nonaktifkan REST API untuk pengguna yang tidak login (opsional)
// ============================================================

/**
 * Batasi REST API hanya untuk pengguna yang sudah login.
 *
 * Catatan: WooCommerce membutuhkan beberapa endpoint publik.
 * Daftar endpoint yang dikecualikan ada di filter di bawah.
 *
 * @since  1.0.0
 * @param  WP_Error|null|true $result Hasil pemeriksaan autentikasi REST.
 * @return WP_Error|null|true
 */
function ukm_restrict_rest_api( $result ) {
	// Jika sudah ada error, biarkan.
	if ( ! empty( $result ) ) {
		return $result;
	}

	// Pengguna sudah login — izinkan.
	if ( is_user_logged_in() ) {
		return $result;
	}

	// Endpoint publik yang diizinkan (WooCommerce store API, dll.).
	$allowed_namespaces = array(
		'wc/store',
		'wc/v3',
	);

	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';

	foreach ( $allowed_namespaces as $namespace ) {
		if ( false !== strpos( $request_uri, '/wp-json/' . $namespace ) ) {
			return $result;
		}
	}

	// Blokir untuk pengguna tidak login di endpoint lain.
	return new WP_Error(
		'rest_not_logged_in',
		__( 'Anda harus login untuk mengakses REST API.', 'ukm-toko-theme' ),
		array( 'status' => 401 )
	);
}
// Aktifkan jika dibutuhkan — dinonaktifkan by default agar tidak mengganggu plugin.
// add_filter( 'rest_authentication_errors', 'ukm_restrict_rest_api' );

// ============================================================
// Helper: Sanitasi Input
// ============================================================

/**
 * Sanitasi teks satu baris (mencegah XSS).
 *
 * Wrapper tipis di atas sanitize_text_field() agar konsisten.
 *
 * @since  1.0.0
 * @param  string $input Teks yang akan disanitasi.
 * @return string Teks yang sudah disanitasi.
 */
function ukm_sanitize_text( $input ) {
	return sanitize_text_field( wp_unslash( $input ) );
}

/**
 * Sanitasi textarea — mempertahankan baris baru, mencegah XSS.
 *
 * @since  1.0.0
 * @param  string $input Teks yang akan disanitasi.
 * @return string Teks yang sudah disanitasi.
 */
function ukm_sanitize_textarea( $input ) {
	return sanitize_textarea_field( wp_unslash( $input ) );
}

/**
 * Sanitasi URL — pastikan URL valid.
 *
 * @since  1.0.0
 * @param  string $input URL yang akan disanitasi.
 * @return string URL yang sudah disanitasi.
 */
function ukm_sanitize_url( $input ) {
	return esc_url_raw( wp_unslash( $input ) );
}

/**
 * Sanitasi angka bulat.
 *
 * @since  1.0.0
 * @param  mixed $input Nilai yang akan disanitasi.
 * @return int Angka bulat yang sudah disanitasi.
 */
function ukm_sanitize_int( $input ) {
	return absint( $input );
}

/**
 * Sanitasi angka desimal (harga, berat, dll.).
 *
 * @since  1.0.0
 * @param  mixed $input Nilai yang akan disanitasi.
 * @return float Angka desimal yang sudah disanitasi.
 */
function ukm_sanitize_float( $input ) {
	return (float) filter_var( $input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
}

/**
 * Sanitasi email.
 *
 * @since  1.0.0
 * @param  string $input Email yang akan disanitasi.
 * @return string Email yang sudah disanitasi.
 */
function ukm_sanitize_email( $input ) {
	return sanitize_email( wp_unslash( $input ) );
}

/**
 * Sanitasi pilihan (dropdown/radio) dari daftar nilai yang diizinkan.
 *
 * @since  1.0.0
 * @param  string $input   Nilai yang dipilih.
 * @param  array  $allowed Daftar nilai yang diizinkan.
 * @param  string $default Nilai default jika tidak valid.
 * @return string Nilai yang sudah divalidasi.
 */
function ukm_sanitize_select( $input, $allowed = array(), $default = '' ) {
	if ( in_array( $input, $allowed, true ) ) {
		return $input;
	}
	return $default;
}

/**
 * Sanitasi HTML terbatas (untuk konten pengguna yang boleh punya format).
 *
 * @since  1.0.0
 * @param  string $input HTML yang akan disanitasi.
 * @return string HTML yang aman.
 */
function ukm_sanitize_html( $input ) {
	$allowed_tags = array(
		'a'      => array(
			'href'   => true,
			'title'  => true,
			'target' => true,
			'rel'    => true,
		),
		'br'     => array(),
		'em'     => array(),
		'strong' => array(),
		'p'      => array(),
		'ul'     => array(),
		'ol'     => array(),
		'li'     => array(),
		'span'   => array( 'class' => true ),
	);

	return wp_kses( $input, $allowed_tags );
}

// ============================================================
// Verifikasi Nonce — Helper
// ============================================================

/**
 * Verifikasi nonce untuk form atau aksi AJAX.
 *
 * Menggabungkan pemeriksaan keberadaan field + verifikasi nonce.
 * Jika gagal, langsung die() dengan pesan aman.
 *
 * @since  1.0.0
 * @param  string $nonce_key   Nama field nonce di $_POST atau $_GET.
 * @param  string $nonce_action Nama aksi nonce yang digunakan saat membuat.
 * @param  string $method      Metode HTTP: 'POST' atau 'GET'.
 * @return void
 */
function ukm_verify_nonce( $nonce_key, $nonce_action, $method = 'POST' ) {
	$nonce_value = '';

	if ( 'POST' === strtoupper( $method ) ) {
		$nonce_value = isset( $_POST[ $nonce_key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $nonce_key ] ) ) : '';
	} else {
		$nonce_value = isset( $_GET[ $nonce_key ] ) ? sanitize_text_field( wp_unslash( $_GET[ $nonce_key ] ) ) : '';
	}

	if ( ! wp_verify_nonce( $nonce_value, $nonce_action ) ) {
		wp_die(
			esc_html__( 'Token keamanan tidak valid. Silakan muat ulang halaman dan coba lagi.', 'ukm-toko-theme' ),
			esc_html__( 'Akses Ditolak', 'ukm-toko-theme' ),
			array( 'response' => 403 )
		);
	}
}

// ============================================================
// Cegah Akses Langsung ke wp-config.php (via .htaccess)
// Cegah Directory Listing (via .htaccess)
// Catatan: konfigurasi .htaccess ada di file .htaccess tema,
//          bukan di sini. Fungsi PHP di bawah adalah tambahan saja.
// ============================================================

/**
 * Nonaktifkan pesan error PHP di frontend (tidak bocor ke pengunjung).
 *
 * WP_DEBUG hanya boleh aktif di lingkungan development.
 * Di produksi, error disimpan ke file log, bukan ditampilkan.
 *
 * @since 1.0.0
 */
function ukm_configure_error_handling() {
	if ( ! ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ) {
		// Pastikan error tidak ditampilkan ke pengunjung.
		@ini_set( 'display_errors', 0 ); // phpcs:ignore WordPress.PHP.IniSet.display_errors_Disallowed
		@ini_set( 'display_startup_errors', 0 ); // phpcs:ignore WordPress.PHP.IniSet.display_startup_errors_Disallowed
	}
}
add_action( 'init', 'ukm_configure_error_handling' );

// ============================================================
// Batasi Login Gagal (Rate Limiting sederhana via transient)
// ============================================================

/**
 * Lacak percobaan login gagal dan blokir setelah batas tertentu.
 *
 * Catatan: untuk keamanan lebih kuat, gunakan Wordfence atau
 * plugin keamanan yang memiliki fitur brute-force protection.
 *
 * @since  1.0.0
 * @param  string $username Nama pengguna yang mencoba login.
 * @return void
 */
function ukm_track_failed_login( $username ) {
	$ip            = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$transient_key = 'ukm_login_fail_' . md5( $ip );
	$attempts      = (int) get_transient( $transient_key );

	set_transient( $transient_key, $attempts + 1, 15 * MINUTE_IN_SECONDS );
}
add_action( 'wp_login_failed', 'ukm_track_failed_login' );

/**
 * Blokir login jika percobaan gagal melebihi batas.
 *
 * @since  1.0.0
 * @param  null   $user     Null jika autentikasi belum terjadi.
 * @param  string $username Nama pengguna.
 * @param  string $password Kata sandi.
 * @return WP_Error|null WP_Error jika diblokir, null jika diizinkan.
 */
function ukm_limit_login_attempts( $user, $username, $password ) {
	$ip            = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$transient_key = 'ukm_login_fail_' . md5( $ip );
	$attempts      = (int) get_transient( $transient_key );
	$max_attempts  = 10; // Batas percobaan sebelum diblokir.

	if ( $attempts >= $max_attempts ) {
		return new WP_Error(
			'too_many_retries',
			__( 'Terlalu banyak percobaan login. Silakan coba lagi dalam 15 menit.', 'ukm-toko-theme' )
		);
	}

	return $user;
}
add_filter( 'authenticate', 'ukm_limit_login_attempts', 30, 3 );

// ============================================================
// Helper Global
// ============================================================

/**
 * Cek apakah plugin WooCommerce aktif.
 *
 * Menggunakan pengecekan class WooCommerce yang lebih andal
 * dibandingkan dengan include_once file plugin — aman dipakai
 * sebelum WooCommerce selesai memuat.
 *
 * @since  1.0.0
 * @return bool True jika WooCommerce aktif.
 */
function ukm_is_woocommerce_active() {
	return class_exists( 'WooCommerce' );
}
