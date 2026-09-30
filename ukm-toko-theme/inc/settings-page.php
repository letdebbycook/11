<?php
/**
 * Halaman Opsi Global Tema (Fallback ACF Options Page).
 *
 * Menyediakan halaman pengaturan di admin WordPress untuk informasi
 * global toko: nama, alamat, nomor telepon, WhatsApp, jam operasional,
 * dan media sosial.
 *
 * [PRO: Dengan ACF Pro, fitur ini menggunakan ACF Options Page yang lebih
 *  intuitif dan mendukung semua tipe field ACF secara langsung]
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Daftarkan halaman opsi global di menu admin.
 *
 * @since 1.0.0
 */
function ukm_register_settings_page() {
	add_options_page(
		__( 'Pengaturan Toko UKM', 'ukm-toko-theme' ),    // Judul halaman.
		__( 'Toko UKM', 'ukm-toko-theme' ),               // Label menu.
		'manage_options',                                   // Capability yang dibutuhkan.
		'ukm-toko-settings',                               // Slug halaman.
		'ukm_render_settings_page'                         // Callback render.
	);
}
add_action( 'admin_menu', 'ukm_register_settings_page' );

/**
 * Daftarkan semua setting WordPress menggunakan Settings API.
 *
 * @since 1.0.0
 */
function ukm_register_settings() {

	// ---- Section: Informasi Toko ----
	add_settings_section(
		'ukm_section_toko',
		__( 'Informasi Toko', 'ukm-toko-theme' ),
		'ukm_section_toko_description',
		'ukm-toko-settings'
	);

	$informasi_fields = array(
		'ukm_nama_toko'      => array(
			'label'       => __( 'Nama Toko', 'ukm-toko-theme' ),
			'type'        => 'text',
			'placeholder' => 'Toko Sembako Berkah',
			'description' => __( 'Nama resmi toko. Digunakan di judul halaman dan schema JSON-LD.', 'ukm-toko-theme' ),
		),
		'ukm_tagline_toko'   => array(
			'label'       => __( 'Tagline / Slogan', 'ukm-toko-theme' ),
			'type'        => 'text',
			'placeholder' => 'Belanja mudah, harga terjangkau.',
			'description' => __( 'Slogan singkat toko. Tampil di footer dan halaman utama.', 'ukm-toko-theme' ),
		),
		'ukm_alamat_toko'    => array(
			'label'       => __( 'Alamat Toko', 'ukm-toko-theme' ),
			'type'        => 'textarea',
			'placeholder' => 'Jl. Pasar Raya No. 10, RT 03/RW 05, Kelurahan Maju, Kecamatan Makmur, Kota Sejahtera 12345',
			'description' => __( 'Alamat lengkap toko. Digunakan untuk schema LocalBusiness.', 'ukm-toko-theme' ),
		),
		'ukm_kota_toko'      => array(
			'label'       => __( 'Kota', 'ukm-toko-theme' ),
			'type'        => 'text',
			'placeholder' => 'Jakarta Selatan',
		),
		'ukm_provinsi_toko'  => array(
			'label'       => __( 'Provinsi', 'ukm-toko-theme' ),
			'type'        => 'text',
			'placeholder' => 'DKI Jakarta',
		),
		'ukm_kodepos_toko'   => array(
			'label'       => __( 'Kode Pos', 'ukm-toko-theme' ),
			'type'        => 'text',
			'placeholder' => '12345',
			'maxlength'   => 10,
		),
	);

	foreach ( $informasi_fields as $key => $field ) {
		register_setting( 'ukm_toko_settings_group', $key, array( 'sanitize_callback' => 'ukm_sanitize_option_field' ) );
		add_settings_field(
			$key,
			esc_html( $field['label'] ),
			'ukm_render_settings_field',
			'ukm-toko-settings',
			'ukm_section_toko',
			array_merge( $field, array( 'id' => $key ) )
		);
	}

	// ---- Section: Kontak ----
	add_settings_section(
		'ukm_section_kontak',
		__( 'Kontak Toko', 'ukm-toko-theme' ),
		null,
		'ukm-toko-settings'
	);

	$kontak_fields = array(
		'ukm_telepon_toko'    => array(
			'label'       => __( 'Nomor Telepon', 'ukm-toko-theme' ),
			'type'        => 'text',
			'placeholder' => '021-1234567',
		),
		'ukm_whatsapp_toko'   => array(
			'label'       => __( 'Nomor WhatsApp', 'ukm-toko-theme' ),
			'type'        => 'text',
			'placeholder' => '6281234567890',
			'description' => __( 'Format internasional tanpa + (misal: 6281234567890). Digunakan untuk tombol WA.', 'ukm-toko-theme' ),
		),
		'ukm_email_toko'      => array(
			'label'       => __( 'Email Toko', 'ukm-toko-theme' ),
			'type'        => 'email',
			'placeholder' => 'toko@contoh.com',
		),
		'ukm_jam_buka'        => array(
			'label'       => __( 'Jam Operasional', 'ukm-toko-theme' ),
			'type'        => 'text',
			'placeholder' => 'Senin - Sabtu, 08.00 - 20.00 WIB',
		),
	);

	foreach ( $kontak_fields as $key => $field ) {
		register_setting( 'ukm_toko_settings_group', $key, array( 'sanitize_callback' => 'ukm_sanitize_option_field' ) );
		add_settings_field(
			$key,
			esc_html( $field['label'] ),
			'ukm_render_settings_field',
			'ukm-toko-settings',
			'ukm_section_kontak',
			array_merge( $field, array( 'id' => $key ) )
		);
	}

	// ---- Section: Media Sosial ----
	add_settings_section(
		'ukm_section_sosmed',
		__( 'Media Sosial', 'ukm-toko-theme' ),
		null,
		'ukm-toko-settings'
	);

	$sosmed_fields = array(
		'ukm_facebook_url'    => array(
			'label'       => __( 'Facebook', 'ukm-toko-theme' ),
			'type'        => 'url',
			'placeholder' => 'https://facebook.com/namatoko',
		),
		'ukm_instagram_url'   => array(
			'label'       => __( 'Instagram', 'ukm-toko-theme' ),
			'type'        => 'url',
			'placeholder' => 'https://instagram.com/namatoko',
		),
		'ukm_tiktok_url'      => array(
			'label'       => __( 'TikTok', 'ukm-toko-theme' ),
			'type'        => 'url',
			'placeholder' => 'https://tiktok.com/@namatoko',
		),
	);

	foreach ( $sosmed_fields as $key => $field ) {
		register_setting( 'ukm_toko_settings_group', $key, array( 'sanitize_callback' => 'ukm_sanitize_option_field' ) );
		add_settings_field(
			$key,
			esc_html( $field['label'] ),
			'ukm_render_settings_field',
			'ukm-toko-settings',
			'ukm_section_sosmed',
			array_merge( $field, array( 'id' => $key ) )
		);
	}
}
add_action( 'admin_init', 'ukm_register_settings' );

/**
 * Deskripsi section Informasi Toko.
 *
 * @since 1.0.0
 */
function ukm_section_toko_description() {
	echo '<p style="color:#646970">' . esc_html__( 'Informasi dasar toko yang tampil di berbagai bagian situs dan digunakan untuk schema JSON-LD (SEO).', 'ukm-toko-theme' ) . '</p>';
	// Tampilkan pesan jika ACF Pro tersedia — pengguna bisa beralih ke Options Page.
	if ( function_exists( 'acf_add_options_page' ) ) {
		echo '<p style="color:#2D6A4F;background:#D1FAE5;padding:8px 12px;border-radius:4px;border:1px solid #6EE7B7">';
		esc_html_e( 'ACF Pro terdeteksi. Anda dapat menggunakan ACF Options Page untuk pengalaman yang lebih baik.', 'ukm-toko-theme' );
		echo '</p>';
	} else {
		echo '<p style="color:#92400E;background:#FEF9C3;padding:8px 12px;border-radius:4px;border:1px solid #FDE68A;font-size:12px">';
		esc_html_e( '[PRO: Dengan ACF Pro, halaman ini menggunakan ACF Options Page yang mendukung lebih banyak tipe field]', 'ukm-toko-theme' );
		echo '</p>';
	}
}

/**
 * Render satu field di halaman pengaturan.
 *
 * @since  1.0.0
 * @param  array $args Argumen field (id, type, label, placeholder, dll.).
 * @return void
 */
function ukm_render_settings_field( $args ) {
	$id          = isset( $args['id'] ) ? $args['id'] : '';
	$type        = isset( $args['type'] ) ? $args['type'] : 'text';
	$placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';
	$description = isset( $args['description'] ) ? $args['description'] : '';
	$maxlength   = isset( $args['maxlength'] ) ? (int) $args['maxlength'] : 255;
	$value       = get_option( $id, '' );

	if ( 'textarea' === $type ) {
		printf(
			'<textarea id="%1$s" name="%1$s" rows="3" class="ukm-admin-textarea regular-text" placeholder="%2$s">%3$s</textarea>',
			esc_attr( $id ),
			esc_attr( $placeholder ),
			esc_textarea( $value )
		);
	} else {
		printf(
			'<input type="%1$s" id="%2$s" name="%2$s" value="%3$s" placeholder="%4$s" class="ukm-admin-input regular-text" maxlength="%5$d" />',
			esc_attr( $type ),
			esc_attr( $id ),
			esc_attr( $value ),
			esc_attr( $placeholder ),
			$maxlength
		);
	}

	if ( $description ) {
		echo '<p class="description" style="color:var(--ukm-admin-text-muted,#64748b);font-size:12px;margin-top:4px">' . esc_html( $description ) . '</p>';
	}
}

/**
 * Sanitasi nilai option — pilih metode berdasarkan nama field.
 *
 * @since  1.0.0
 * @param  string $value Nilai yang akan disanitasi.
 * @return string Nilai yang sudah disanitasi.
 */
function ukm_sanitize_option_field( $value ) {
	// Deteksi tipe berdasarkan nama option yang sedang disimpan.
	// WordPress memanggil callback ini dengan nilai saja, tanpa nama field.
	// Gunakan sanitize_textarea_field sebagai default yang aman untuk semua.
	if ( is_string( $value ) && ( false !== strpos( $value, 'http' ) ) ) {
		return esc_url_raw( $value );
	}

	return sanitize_textarea_field( wp_unslash( $value ) );
}

/**
 * Render halaman pengaturan toko.
 *
 * @since 1.0.0
 */
function ukm_render_settings_page() {
	// Hanya admin yang boleh melihat halaman ini.
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Anda tidak memiliki izin untuk mengakses halaman ini.', 'ukm-toko-theme' ) );
	}
	?>
	<div class="wrap ukm-admin-wrap">

		<!-- HERO HEADER PENGATURAN -->
		<section class="ukm-admin-hero" style="margin-bottom:24px;padding:24px 30px">
			<div class="ukm-admin-hero__content">
				<h1 class="ukm-admin-hero__title" style="font-size:22px">
					<span class="dashicons dashicons-admin-generic" style="font-size:22px;width:22px;height:22px;vertical-align:middle;margin-right:6px"></span>
					<?php esc_html_e( 'Pengaturan Toko UKM', 'ukm-toko-theme' ); ?>
				</h1>
				<p class="ukm-admin-hero__desc">
					<?php esc_html_e( 'Kelola identitas toko, nomor WhatsApp pemesanan, jam operasional, dan akun media sosial.', 'ukm-toko-theme' ); ?>
				</p>
			</div>
			<div class="ukm-admin-hero__actions">
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=ukm-toko-dashboard' ) ); ?>" class="ukm-admin-btn ukm-admin-btn--white">
					&larr; <?php esc_html_e( 'Kembali ke Dashboard UKM', 'ukm-toko-theme' ); ?>
				</a>
			</div>
		</section>

		<?php
		// Tampilkan pesan sukses setelah save.
		if ( isset( $_GET['settings-updated'] ) ) {
			add_settings_error( 'ukm_toko_settings_group', 'ukm_settings_saved', __( 'Pengaturan toko berhasil diperbarui.', 'ukm-toko-theme' ), 'success' );
		}
		settings_errors( 'ukm_toko_settings_group' );
		?>

		<div class="ukm-admin-card">
			<div class="ukm-admin-card__header">
				<h2 class="ukm-admin-card__title">
					<span class="dashicons dashicons-forms"></span>
					<?php esc_html_e( 'Formulir Konfigurasi Global', 'ukm-toko-theme' ); ?>
				</h2>
			</div>
			<div class="ukm-admin-card__body">
				<form method="post" action="options.php">
					<?php
					settings_fields( 'ukm_toko_settings_group' );
					do_settings_sections( 'ukm-toko-settings' );
					?>
					<div style="margin-top:28px;padding-top:20px;border-top:1px solid var(--ukm-admin-border,#e2e8f0)">
						<?php submit_button( __( 'Simpan Perubahan Pengaturan', 'ukm-toko-theme' ), 'primary large' ); ?>
					</div>
				</form>
			</div>
		</div>

	</div>
	<?php
}

// ============================================================
// Helper: Ambil Opsi Global
// ============================================================

/**
 * Ambil nilai opsi toko dengan mudah.
 *
 * Mendukung dua sumber:
 * 1. ACF Options Page (jika ACF Pro aktif dan options page didaftarkan).
 * 2. WordPress Options API (fallback default).
 *
 * @since  1.0.0
 * @param  string $key     Nama opsi.
 * @param  mixed  $default Nilai default jika opsi kosong.
 * @return mixed Nilai opsi.
 */
function ukm_get_option( $key, $default = '' ) {
	// Cek ACF Options Page terlebih dahulu (PRO).
	if ( function_exists( 'get_field' ) ) {
		$acf_value = get_field( $key, 'option' );
		if ( $acf_value ) {
			return $acf_value;
		}
	}

	// Fallback ke WordPress Options API.
	$value = get_option( $key, $default );

	return $value ?: $default;
}
