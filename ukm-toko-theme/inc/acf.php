<?php
/**
 * Advanced Custom Fields & Fallback Meta Boxes.
 *
 * File ini menangani dua skenario:
 * 1. Jika ACF (gratis) aktif → daftarkan field groups via PHP + simpan ke ACF JSON.
 * 2. Jika ACF tidak aktif → gunakan custom meta boxes WordPress native sebagai fallback.
 *
 * Fitur yang membutuhkan ACF Pro ditandai dengan komentar [PRO].
 *
 * Field group yang didaftarkan:
 * - Spesifikasi Produk     → CPT 'produk' (harga, stok, satuan, berat)
 * - Galeri Produk          → CPT 'produk' (multiple images via ACF gratis)
 * - Varian Produk          → CPT 'produk' (FALLBACK: meta box custom karena Repeater = PRO)
 * - Informasi Klien        → CPT 'klien' (email, telepon, lokasi, WhatsApp)
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

// ============================================================
// Direktori ACF JSON — Sinkronisasi Field Group ke Git
// ============================================================

/**
 * Arahkan penyimpanan ACF JSON ke folder /acf-json di dalam tema.
 *
 * Ini memastikan field group ikut di-commit ke Git untuk kolaborasi
 * dan deployment yang konsisten antar environment.
 *
 * @since  1.0.0
 * @param  string $path Path default penyimpanan ACF JSON.
 * @return string Path custom di folder tema.
 */
function ukm_acf_json_save_point( $path ) {
	return UKM_THEME_DIR . 'acf-json';
}
add_filter( 'acf/settings/save_json', 'ukm_acf_json_save_point' );

/**
 * Arahkan pembacaan ACF JSON dari folder /acf-json di tema.
 *
 * @since  1.0.0
 * @param  array $paths Daftar path yang dibaca ACF.
 * @return array Daftar path dengan tambahan folder tema.
 */
function ukm_acf_json_load_point( $paths ) {
	$paths[] = UKM_THEME_DIR . 'acf-json';
	return $paths;
}
add_filter( 'acf/settings/load_json', 'ukm_acf_json_load_point' );

// ============================================================
// Registrasi Field Groups ACF (jika ACF aktif)
// ============================================================

/**
 * Daftarkan semua field group ACF via PHP.
 *
 * Catatan: Field group ini juga otomatis tersimpan ke /acf-json
 * via filter di atas saat pertama kali disimpan dari admin.
 * Jika file JSON sudah ada di /acf-json, ACF akan membaca dari sana.
 *
 * @since 1.0.0
 */
function ukm_register_acf_field_groups() {

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// ---- Field Group 1: Spesifikasi Produk ----
	acf_add_local_field_group(
		array(
			'key'                   => 'group_ukm_spesifikasi_produk',
			'title'                 => 'Spesifikasi Produk',
			'fields'                => array(

				// Harga jual produk.
				array(
					'key'           => 'field_ukm_harga',
					'label'         => 'Harga Jual',
					'name'          => '_ukm_harga',
					'type'          => 'number',
					'instructions'  => 'Masukkan harga jual dalam Rupiah (tanpa titik/koma). Contoh: 75000',
					'required'      => 1,
					'min'           => 0,
					'step'          => 100,
					'prepend'       => 'Rp',
					'placeholder'   => '75000',
				),

				// Harga modal/beli (opsional, tersembunyi dari publik).
				array(
					'key'           => 'field_ukm_harga_modal',
					'label'         => 'Harga Modal',
					'name'          => '_ukm_harga_modal',
					'type'          => 'number',
					'instructions'  => 'Harga modal/beli. Tidak ditampilkan ke pengunjung.',
					'required'      => 0,
					'min'           => 0,
					'step'          => 100,
					'prepend'       => 'Rp',
				),

				// Stok tersedia.
				array(
					'key'           => 'field_ukm_stok',
					'label'         => 'Jumlah Stok',
					'name'          => '_ukm_stok',
					'type'          => 'number',
					'instructions'  => 'Jumlah stok yang tersedia saat ini.',
					'required'      => 1,
					'min'           => 0,
					'step'          => 1,
					'append'        => 'unit',
					'placeholder'   => '0',
					'default_value' => 0,
				),

				// Satuan produk.
				array(
					'key'           => 'field_ukm_satuan',
					'label'         => 'Satuan',
					'name'          => '_ukm_satuan',
					'type'          => 'select',
					'instructions'  => 'Pilih satuan jual produk.',
					'required'      => 1,
					'choices'       => array(
						'pcs'    => 'Pcs (satuan)',
						'kg'     => 'Kg (kilogram)',
						'gram'   => 'Gram',
						'liter'  => 'Liter',
						'ml'     => 'Ml (mililiter)',
						'karton' => 'Karton',
						'lusin'  => 'Lusin',
						'pak'    => 'Pak',
						'botol'  => 'Botol',
						'sachet' => 'Sachet',
					),
					'default_value' => 'pcs',
					'allow_null'    => 0,
					'multiple'      => 0,
					'ui'            => 1,
					'return_format' => 'value',
				),

				// Berat produk (untuk ongkos kirim WooCommerce).
				array(
					'key'           => 'field_ukm_berat',
					'label'         => 'Berat',
					'name'          => '_ukm_berat',
					'type'          => 'number',
					'instructions'  => 'Berat produk dalam gram. Digunakan untuk kalkulasi ongkos kirim.',
					'required'      => 0,
					'min'           => 0,
					'step'          => 1,
					'append'        => 'gram',
				),

				// SKU / Kode Produk.
				array(
					'key'           => 'field_ukm_sku',
					'label'         => 'Kode Produk (SKU)',
					'name'          => '_ukm_sku',
					'type'          => 'text',
					'instructions'  => 'Kode unik produk untuk inventaris. Contoh: SBK-001',
					'required'      => 0,
					'maxlength'     => 50,
					'placeholder'   => 'SBK-001',
				),

				// Status produk.
				array(
					'key'           => 'field_ukm_status_produk',
					'label'         => 'Status Produk',
					'name'          => '_ukm_status_produk',
					'type'          => 'select',
					'instructions'  => 'Status ketersediaan produk.',
					'required'      => 1,
					'choices'       => array(
						'tersedia'     => 'Tersedia',
						'habis'        => 'Stok Habis',
						'pesan_dulu'   => 'Indent / Pesan Dulu',
						'dihentikan'   => 'Tidak Dijual Lagi',
					),
					'default_value' => 'tersedia',
					'allow_null'    => 0,
					'ui'            => 1,
					'return_format' => 'value',
				),

				// Nomor WhatsApp untuk pemesanan cepat.
				array(
					'key'           => 'field_ukm_wa_pesan',
					'label'         => 'Nomor WhatsApp Pemesanan',
					'name'          => '_ukm_wa_pesan',
					'type'          => 'text',
					'instructions'  => 'Nomor WhatsApp untuk tombol "Pesan via WA". Format: 6281234567890 (tanpa + atau 0 di depan).',
					'required'      => 0,
					'placeholder'   => '6281234567890',
					'maxlength'     => 20,
				),

			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'produk',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => true,
			'description'           => 'Field spesifikasi lengkap untuk produk katalog UKM.',
		)
	);

	// ---- Field Group 2: Informasi Klien ----
	acf_add_local_field_group(
		array(
			'key'                   => 'group_ukm_informasi_klien',
			'title'                 => 'Informasi Kontak Klien',
			'fields'                => array(

				array(
					'key'          => 'field_ukm_klien_email',
					'label'        => 'Email',
					'name'         => '_ukm_klien_email',
					'type'         => 'email',
					'instructions' => 'Alamat email klien.',
					'required'     => 0,
					'placeholder'  => 'email@contoh.com',
				),

				array(
					'key'          => 'field_ukm_klien_telepon',
					'label'        => 'Nomor Telepon',
					'name'         => '_ukm_klien_telepon',
					'type'         => 'text',
					'instructions' => 'Nomor telepon atau HP klien.',
					'required'     => 0,
					'placeholder'  => '08123456789',
					'maxlength'    => 20,
				),

				array(
					'key'          => 'field_ukm_klien_whatsapp',
					'label'        => 'Nomor WhatsApp',
					'name'         => '_ukm_klien_whatsapp',
					'type'         => 'text',
					'instructions' => 'Nomor WhatsApp klien. Format: 6281234567890',
					'required'     => 0,
					'placeholder'  => '6281234567890',
					'maxlength'    => 20,
				),

				array(
					'key'          => 'field_ukm_klien_lokasi',
					'label'        => 'Lokasi / Alamat',
					'name'         => '_ukm_klien_lokasi',
					'type'         => 'textarea',
					'instructions' => 'Alamat lengkap atau nama daerah klien.',
					'required'     => 0,
					'rows'         => 3,
					'placeholder'  => 'Jl. Contoh No. 1, Kelurahan, Kecamatan, Kota',
				),

				array(
					'key'          => 'field_ukm_klien_jenis',
					'label'        => 'Jenis Klien',
					'name'         => '_ukm_klien_jenis',
					'type'         => 'select',
					'instructions' => 'Tipe bisnis klien.',
					'required'     => 0,
					'choices'      => array(
						'warung'     => 'Warung / Toko Kecil',
						'warung_makan' => 'Warung Makan / Restoran',
						'grosir'     => 'Grosir',
						'perorangan' => 'Perorangan',
						'institusi'  => 'Institusi / Kantor',
						'lainnya'    => 'Lainnya',
					),
					'default_value' => 'warung',
					'allow_null'   => 1,
					'ui'           => 1,
					'return_format' => 'value',
				),

				array(
					'key'          => 'field_ukm_klien_catatan',
					'label'        => 'Catatan Internal',
					'name'         => '_ukm_klien_catatan',
					'type'         => 'textarea',
					'instructions' => 'Catatan internal tentang klien ini. Tidak ditampilkan ke publik.',
					'required'     => 0,
					'rows'         => 4,
				),

			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'klien',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);
}
add_action( 'acf/init', 'ukm_register_acf_field_groups' );

// ============================================================
// FALLBACK: Meta Boxes Native (jika ACF tidak aktif)
// ============================================================

/**
 * Daftarkan meta boxes fallback jika ACF tidak tersedia.
 *
 * @since 1.0.0
 */
function ukm_register_fallback_meta_boxes() {

	// Jika ACF aktif, tidak perlu fallback.
	if ( function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// Meta box spesifikasi produk.
	add_meta_box(
		'ukm-produk-spesifikasi',
		__( 'Spesifikasi Produk', 'ukm-toko-theme' ),
		'ukm_render_produk_spesifikasi_meta_box',
		'produk',
		'normal',
		'high'
	);

	// Meta box varian produk.
	// [PRO: Dengan ACF Pro, ini menggunakan Repeater Field yang lebih dinamis]
	add_meta_box(
		'ukm-produk-varian',
		__( 'Varian Produk (Ukuran)', 'ukm-toko-theme' ),
		'ukm_render_produk_varian_meta_box',
		'produk',
		'normal',
		'default'
	);

	// Meta box informasi klien.
	add_meta_box(
		'ukm-klien-informasi',
		__( 'Informasi Kontak Klien', 'ukm-toko-theme' ),
		'ukm_render_klien_informasi_meta_box',
		'klien',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'ukm_register_fallback_meta_boxes' );

/**
 * Render meta box spesifikasi produk (fallback tanpa ACF).
 *
 * @since  1.0.0
 * @param  WP_Post $post Objek post yang sedang diedit.
 * @return void
 */
function ukm_render_produk_spesifikasi_meta_box( $post ) {
	// Nonce untuk keamanan form.
	wp_nonce_field( 'ukm_save_produk_spesifikasi', 'ukm_produk_spesifikasi_nonce' );

	// Ambil nilai yang sudah tersimpan.
	$harga          = get_post_meta( $post->ID, '_ukm_harga', true );
	$harga_modal    = get_post_meta( $post->ID, '_ukm_harga_modal', true );
	$stok           = get_post_meta( $post->ID, '_ukm_stok', true );
	$satuan         = get_post_meta( $post->ID, '_ukm_satuan', true );
	$berat          = get_post_meta( $post->ID, '_ukm_berat', true );
	$sku            = get_post_meta( $post->ID, '_ukm_sku', true );
	$status_produk  = get_post_meta( $post->ID, '_ukm_status_produk', true );
	$wa_pesan       = get_post_meta( $post->ID, '_ukm_wa_pesan', true );

	$satuan_options = array(
		'pcs'    => 'Pcs (satuan)',
		'kg'     => 'Kg (kilogram)',
		'gram'   => 'Gram',
		'liter'  => 'Liter',
		'ml'     => 'Ml (mililiter)',
		'karton' => 'Karton',
		'lusin'  => 'Lusin',
		'pak'    => 'Pak',
		'botol'  => 'Botol',
		'sachet' => 'Sachet',
	);

	$status_options = array(
		'tersedia'   => 'Tersedia',
		'habis'      => 'Stok Habis',
		'pesan_dulu' => 'Indent / Pesan Dulu',
		'dihentikan' => 'Tidak Dijual Lagi',
	);
	?>
	<style>
		.ukm-meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; padding: 8px 0; }
		.ukm-meta-field { display: flex; flex-direction: column; gap: 6px; }
		.ukm-meta-field label { font-weight: 600; font-size: 13px; color: #1d2327; }
		.ukm-meta-field input, .ukm-meta-field select { width: 100%; padding: 6px 10px; border: 1px solid #c3c4c7; border-radius: 4px; font-size: 14px; }
		.ukm-meta-field .description { font-size: 12px; color: #646970; }
		.ukm-meta-field .input-group { display: flex; gap: 0; }
		.ukm-meta-field .input-group .prepend, .ukm-meta-field .input-group .append { background: #f0f0f1; border: 1px solid #c3c4c7; padding: 6px 10px; font-size: 13px; color: #646970; }
		.ukm-meta-field .input-group .prepend { border-right: 0; border-radius: 4px 0 0 4px; }
		.ukm-meta-field .input-group .append { border-left: 0; border-radius: 0 4px 4px 0; }
		.ukm-meta-field .input-group input { border-radius: 0; flex: 1; }
	</style>

	<div class="ukm-meta-grid">

		<div class="ukm-meta-field">
			<label for="ukm_harga"><?php esc_html_e( 'Harga Jual', 'ukm-toko-theme' ); ?> <span style="color:red">*</span></label>
			<div class="input-group">
				<span class="prepend">Rp</span>
				<input type="number" id="ukm_harga" name="ukm_harga" value="<?php echo esc_attr( $harga ); ?>" min="0" step="100" placeholder="75000" required />
			</div>
			<span class="description"><?php esc_html_e( 'Harga dalam Rupiah, tanpa titik/koma.', 'ukm-toko-theme' ); ?></span>
		</div>

		<div class="ukm-meta-field">
			<label for="ukm_harga_modal"><?php esc_html_e( 'Harga Modal', 'ukm-toko-theme' ); ?></label>
			<div class="input-group">
				<span class="prepend">Rp</span>
				<input type="number" id="ukm_harga_modal" name="ukm_harga_modal" value="<?php echo esc_attr( $harga_modal ); ?>" min="0" step="100" placeholder="60000" />
			</div>
			<span class="description"><?php esc_html_e( 'Tidak ditampilkan ke pengunjung.', 'ukm-toko-theme' ); ?></span>
		</div>

		<div class="ukm-meta-field">
			<label for="ukm_stok"><?php esc_html_e( 'Jumlah Stok', 'ukm-toko-theme' ); ?> <span style="color:red">*</span></label>
			<div class="input-group">
				<input type="number" id="ukm_stok" name="ukm_stok" value="<?php echo esc_attr( $stok ); ?>" min="0" step="1" placeholder="0" required />
				<span class="append">unit</span>
			</div>
		</div>

		<div class="ukm-meta-field">
			<label for="ukm_satuan"><?php esc_html_e( 'Satuan Jual', 'ukm-toko-theme' ); ?></label>
			<select id="ukm_satuan" name="ukm_satuan">
				<?php foreach ( $satuan_options as $val => $label ) : ?>
					<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $satuan, $val ); ?>>
						<?php echo esc_html( $label ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="ukm-meta-field">
			<label for="ukm_berat"><?php esc_html_e( 'Berat', 'ukm-toko-theme' ); ?></label>
			<div class="input-group">
				<input type="number" id="ukm_berat" name="ukm_berat" value="<?php echo esc_attr( $berat ); ?>" min="0" step="1" placeholder="500" />
				<span class="append">gram</span>
			</div>
		</div>

		<div class="ukm-meta-field">
			<label for="ukm_sku"><?php esc_html_e( 'Kode Produk (SKU)', 'ukm-toko-theme' ); ?></label>
			<input type="text" id="ukm_sku" name="ukm_sku" value="<?php echo esc_attr( $sku ); ?>" placeholder="SBK-001" maxlength="50" />
		</div>

		<div class="ukm-meta-field">
			<label for="ukm_status_produk"><?php esc_html_e( 'Status Produk', 'ukm-toko-theme' ); ?></label>
			<select id="ukm_status_produk" name="ukm_status_produk">
				<?php foreach ( $status_options as $val => $label ) : ?>
					<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $status_produk, $val ); ?>>
						<?php echo esc_html( $label ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="ukm-meta-field">
			<label for="ukm_wa_pesan"><?php esc_html_e( 'WhatsApp Pemesanan', 'ukm-toko-theme' ); ?></label>
			<input type="text" id="ukm_wa_pesan" name="ukm_wa_pesan" value="<?php echo esc_attr( $wa_pesan ); ?>" placeholder="6281234567890" maxlength="20" />
			<span class="description"><?php esc_html_e( 'Tanpa + atau 0 di depan.', 'ukm-toko-theme' ); ?></span>
		</div>

	</div>
	<?php
}

/**
 * Render meta box varian produk (fallback tanpa ACF Repeater).
 *
 * [PRO: Dengan ACF Pro, gunakan Repeater Field untuk UX yang lebih baik]
 * Fallback ini menggunakan input HTML biasa dengan serialized array.
 *
 * @since  1.0.0
 * @param  WP_Post $post Objek post.
 * @return void
 */
function ukm_render_produk_varian_meta_box( $post ) {
	wp_nonce_field( 'ukm_save_produk_varian', 'ukm_produk_varian_nonce' );

	// Ambil varian yang tersimpan (format: array of arrays).
	$varian = get_post_meta( $post->ID, '_ukm_varian_produk', true );
	if ( ! is_array( $varian ) ) {
		$varian = array();
	}
	?>
	<p style="color:#646970;font-size:13px;margin:8px 0 16px">
		<?php
		// translators: teks penjelasan di bawah judul meta box varian produk.
		esc_html_e( 'Tambahkan varian ukuran produk (misal: 250ml, 500ml, 1L). Setiap varian dapat memiliki harga sendiri.', 'ukm-toko-theme' );
		?>
	</p>
	<p style="color:#D97706;font-size:12px;margin:0 0 16px;padding:8px 12px;background:#FEF9C3;border-radius:4px;border:1px solid #FDE68A">
		<?php esc_html_e( '[PRO: Dengan ACF Pro, fitur ini menggunakan Repeater Field yang lebih dinamis dan mudah dikelola]', 'ukm-toko-theme' ); ?>
	</p>

	<table id="ukm-varian-table" style="width:100%;border-collapse:collapse">
		<thead>
			<tr style="background:#f0f0f1">
				<th style="padding:8px 10px;text-align:left;font-size:13px;border:1px solid #c3c4c7"><?php esc_html_e( 'Ukuran/Varian', 'ukm-toko-theme' ); ?></th>
				<th style="padding:8px 10px;text-align:left;font-size:13px;border:1px solid #c3c4c7"><?php esc_html_e( 'Harga (Rp)', 'ukm-toko-theme' ); ?></th>
				<th style="padding:8px 10px;text-align:left;font-size:13px;border:1px solid #c3c4c7"><?php esc_html_e( 'Stok', 'ukm-toko-theme' ); ?></th>
				<th style="padding:8px 10px;text-align:center;font-size:13px;border:1px solid #c3c4c7"><?php esc_html_e( 'Hapus', 'ukm-toko-theme' ); ?></th>
			</tr>
		</thead>
		<tbody id="ukm-varian-tbody">
			<?php if ( ! empty( $varian ) ) : ?>
				<?php foreach ( $varian as $index => $item ) : ?>
					<tr class="ukm-varian-row">
						<td style="padding:6px;border:1px solid #c3c4c7">
							<input type="text" name="ukm_varian[<?php echo esc_attr( $index ); ?>][ukuran]"
								value="<?php echo esc_attr( isset( $item['ukuran'] ) ? $item['ukuran'] : '' ); ?>"
								placeholder="500ml" style="width:100%;padding:4px 8px;border:1px solid #c3c4c7;border-radius:3px" />
						</td>
						<td style="padding:6px;border:1px solid #c3c4c7">
							<input type="number" name="ukm_varian[<?php echo esc_attr( $index ); ?>][harga]"
								value="<?php echo esc_attr( isset( $item['harga'] ) ? $item['harga'] : '' ); ?>"
								min="0" step="100" placeholder="15000" style="width:100%;padding:4px 8px;border:1px solid #c3c4c7;border-radius:3px" />
						</td>
						<td style="padding:6px;border:1px solid #c3c4c7">
							<input type="number" name="ukm_varian[<?php echo esc_attr( $index ); ?>][stok]"
								value="<?php echo esc_attr( isset( $item['stok'] ) ? $item['stok'] : '' ); ?>"
								min="0" placeholder="0" style="width:100%;padding:4px 8px;border:1px solid #c3c4c7;border-radius:3px" />
						</td>
						<td style="padding:6px;text-align:center;border:1px solid #c3c4c7">
							<button type="button" class="ukm-hapus-varian button" style="color:#dc2626"><?php esc_html_e( 'Hapus', 'ukm-toko-theme' ); ?></button>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>

	<button type="button" id="ukm-tambah-varian" class="button button-secondary" style="margin-top:12px">
		<?php esc_html_e( '+ Tambah Varian', 'ukm-toko-theme' ); ?>
	</button>

	<script>
	(function() {
		var tbody = document.getElementById('ukm-varian-tbody');
		var index = <?php echo count( $varian ); ?>;

		document.getElementById('ukm-tambah-varian').addEventListener('click', function() {
			var row = document.createElement('tr');
			row.className = 'ukm-varian-row';
			row.innerHTML =
				'<td style="padding:6px;border:1px solid #c3c4c7"><input type="text" name="ukm_varian[' + index + '][ukuran]" placeholder="500ml" style="width:100%;padding:4px 8px;border:1px solid #c3c4c7;border-radius:3px" /></td>' +
				'<td style="padding:6px;border:1px solid #c3c4c7"><input type="number" name="ukm_varian[' + index + '][harga]" min="0" step="100" placeholder="15000" style="width:100%;padding:4px 8px;border:1px solid #c3c4c7;border-radius:3px" /></td>' +
				'<td style="padding:6px;border:1px solid #c3c4c7"><input type="number" name="ukm_varian[' + index + '][stok]" min="0" placeholder="0" style="width:100%;padding:4px 8px;border:1px solid #c3c4c7;border-radius:3px" /></td>' +
				'<td style="padding:6px;text-align:center;border:1px solid #c3c4c7"><button type="button" class="ukm-hapus-varian button" style="color:#dc2626"><?php esc_html_e( 'Hapus', 'ukm-toko-theme' ); ?></button></td>';
			tbody.appendChild(row);
			index++;
		});

		tbody.addEventListener('click', function(e) {
			if (e.target.classList.contains('ukm-hapus-varian')) {
				e.target.closest('tr').remove();
			}
		});
	})();
	</script>
	<?php
}

/**
 * Render meta box informasi klien (fallback tanpa ACF).
 *
 * @since  1.0.0
 * @param  WP_Post $post Objek post.
 * @return void
 */
function ukm_render_klien_informasi_meta_box( $post ) {
	wp_nonce_field( 'ukm_save_klien_informasi', 'ukm_klien_informasi_nonce' );

	$email    = get_post_meta( $post->ID, '_ukm_klien_email', true );
	$telepon  = get_post_meta( $post->ID, '_ukm_klien_telepon', true );
	$wa       = get_post_meta( $post->ID, '_ukm_klien_whatsapp', true );
	$lokasi   = get_post_meta( $post->ID, '_ukm_klien_lokasi', true );
	$jenis    = get_post_meta( $post->ID, '_ukm_klien_jenis', true );
	$catatan  = get_post_meta( $post->ID, '_ukm_klien_catatan', true );

	$jenis_options = array(
		''           => '— Pilih Jenis —',
		'warung'     => 'Warung / Toko Kecil',
		'warung_makan' => 'Warung Makan / Restoran',
		'grosir'     => 'Grosir',
		'perorangan' => 'Perorangan',
		'institusi'  => 'Institusi / Kantor',
		'lainnya'    => 'Lainnya',
	);
	?>
	<style>
		.ukm-klien-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; padding: 8px 0; }
		.ukm-klien-field { display: flex; flex-direction: column; gap: 6px; }
		.ukm-klien-field label { font-weight: 600; font-size: 13px; color: #1d2327; }
		.ukm-klien-field input, .ukm-klien-field select, .ukm-klien-field textarea { width: 100%; padding: 6px 10px; border: 1px solid #c3c4c7; border-radius: 4px; font-size: 14px; font-family: inherit; }
		.ukm-klien-field.full { grid-column: 1 / -1; }
	</style>

	<div class="ukm-klien-grid">

		<div class="ukm-klien-field">
			<label for="ukm_klien_email"><?php esc_html_e( 'Email', 'ukm-toko-theme' ); ?></label>
			<input type="email" id="ukm_klien_email" name="ukm_klien_email" value="<?php echo esc_attr( $email ); ?>" placeholder="email@contoh.com" />
		</div>

		<div class="ukm-klien-field">
			<label for="ukm_klien_telepon"><?php esc_html_e( 'Nomor Telepon', 'ukm-toko-theme' ); ?></label>
			<input type="text" id="ukm_klien_telepon" name="ukm_klien_telepon" value="<?php echo esc_attr( $telepon ); ?>" placeholder="08123456789" maxlength="20" />
		</div>

		<div class="ukm-klien-field">
			<label for="ukm_klien_whatsapp"><?php esc_html_e( 'Nomor WhatsApp', 'ukm-toko-theme' ); ?></label>
			<input type="text" id="ukm_klien_whatsapp" name="ukm_klien_whatsapp" value="<?php echo esc_attr( $wa ); ?>" placeholder="6281234567890" maxlength="20" />
		</div>

		<div class="ukm-klien-field">
			<label for="ukm_klien_jenis"><?php esc_html_e( 'Jenis Klien', 'ukm-toko-theme' ); ?></label>
			<select id="ukm_klien_jenis" name="ukm_klien_jenis">
				<?php foreach ( $jenis_options as $val => $label ) : ?>
					<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $jenis, $val ); ?>><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="ukm-klien-field full">
			<label for="ukm_klien_lokasi"><?php esc_html_e( 'Lokasi / Alamat', 'ukm-toko-theme' ); ?></label>
			<textarea id="ukm_klien_lokasi" name="ukm_klien_lokasi" rows="3" placeholder="<?php esc_attr_e( 'Jl. Contoh No. 1, Kelurahan, Kecamatan, Kota', 'ukm-toko-theme' ); ?>"><?php echo esc_textarea( $lokasi ); ?></textarea>
		</div>

		<div class="ukm-klien-field full">
			<label for="ukm_klien_catatan"><?php esc_html_e( 'Catatan Internal', 'ukm-toko-theme' ); ?></label>
			<textarea id="ukm_klien_catatan" name="ukm_klien_catatan" rows="4" placeholder="<?php esc_attr_e( 'Catatan khusus tentang klien ini...', 'ukm-toko-theme' ); ?>"><?php echo esc_textarea( $catatan ); ?></textarea>
		</div>

	</div>
	<?php
}

// ============================================================
// Simpan Meta Box Data (Fallback)
// ============================================================

/**
 * Simpan data meta box spesifikasi produk.
 *
 * @since  1.0.0
 * @param  int $post_id ID post yang sedang disimpan.
 * @return void
 */
function ukm_save_produk_spesifikasi_meta( $post_id ) {
	// Jika ACF aktif, biarkan ACF yang menyimpan.
	if ( function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// Jangan simpan saat autosave.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Verifikasi nonce.
	if ( ! isset( $_POST['ukm_produk_spesifikasi_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ukm_produk_spesifikasi_nonce'] ) ), 'ukm_save_produk_spesifikasi' ) ) {
		return;
	}

	// Periksa capability pengguna.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$satuan_allowed = array( 'pcs', 'kg', 'gram', 'liter', 'ml', 'karton', 'lusin', 'pak', 'botol', 'sachet' );
	$status_allowed = array( 'tersedia', 'habis', 'pesan_dulu', 'dihentikan' );

	// Simpan setiap field dengan sanitasi yang sesuai.
	$fields = array(
		'_ukm_harga'          => array( 'key' => 'ukm_harga', 'type' => 'float' ),
		'_ukm_harga_modal'    => array( 'key' => 'ukm_harga_modal', 'type' => 'float' ),
		'_ukm_stok'           => array( 'key' => 'ukm_stok', 'type' => 'int' ),
		'_ukm_berat'          => array( 'key' => 'ukm_berat', 'type' => 'int' ),
		'_ukm_sku'            => array( 'key' => 'ukm_sku', 'type' => 'text' ),
		'_ukm_wa_pesan'       => array( 'key' => 'ukm_wa_pesan', 'type' => 'text' ),
	);

	foreach ( $fields as $meta_key => $field ) {
		if ( ! isset( $_POST[ $field['key'] ] ) ) {
			continue;
		}

		$raw = wp_unslash( $_POST[ $field['key'] ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput

		switch ( $field['type'] ) {
			case 'float':
				$value = ukm_sanitize_float( $raw );
				break;
			case 'int':
				$value = absint( $raw );
				break;
			default:
				$value = sanitize_text_field( $raw );
				break;
		}

		update_post_meta( $post_id, $meta_key, $value );
	}

	// Satuan — harus dari daftar yang diizinkan.
	if ( isset( $_POST['ukm_satuan'] ) ) {
		$satuan = sanitize_text_field( wp_unslash( $_POST['ukm_satuan'] ) );
		if ( in_array( $satuan, $satuan_allowed, true ) ) {
			update_post_meta( $post_id, '_ukm_satuan', $satuan );
		}
	}

	// Status produk — harus dari daftar yang diizinkan.
	if ( isset( $_POST['ukm_status_produk'] ) ) {
		$status = sanitize_text_field( wp_unslash( $_POST['ukm_status_produk'] ) );
		if ( in_array( $status, $status_allowed, true ) ) {
			update_post_meta( $post_id, '_ukm_status_produk', $status );
		}
	}
}
add_action( 'save_post_produk', 'ukm_save_produk_spesifikasi_meta' );

/**
 * Simpan data meta box varian produk.
 *
 * Varian disimpan sebagai serialized array di satu meta key.
 * [PRO: Dengan ACF Pro Repeater, data disimpan secara lebih terstruktur]
 *
 * @since  1.0.0
 * @param  int $post_id ID post.
 * @return void
 */
function ukm_save_produk_varian_meta( $post_id ) {
	if ( function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! isset( $_POST['ukm_produk_varian_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ukm_produk_varian_nonce'] ) ), 'ukm_save_produk_varian' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$varian_bersih = array();

	if ( isset( $_POST['ukm_varian'] ) && is_array( $_POST['ukm_varian'] ) ) {
		$raw_varian = wp_unslash( $_POST['ukm_varian'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput

		foreach ( $raw_varian as $item ) {
			if ( ! isset( $item['ukuran'] ) || '' === trim( $item['ukuran'] ) ) {
				continue; // Lewati baris kosong.
			}

			$varian_bersih[] = array(
				'ukuran' => sanitize_text_field( $item['ukuran'] ),
				'harga'  => isset( $item['harga'] ) ? absint( $item['harga'] ) : 0,
				'stok'   => isset( $item['stok'] ) ? absint( $item['stok'] ) : 0,
			);
		}
	}

	if ( ! empty( $varian_bersih ) ) {
		update_post_meta( $post_id, '_ukm_varian_produk', $varian_bersih );
	} else {
		delete_post_meta( $post_id, '_ukm_varian_produk' );
	}
}
add_action( 'save_post_produk', 'ukm_save_produk_varian_meta' );

/**
 * Simpan data meta box informasi klien.
 *
 * @since  1.0.0
 * @param  int $post_id ID post.
 * @return void
 */
function ukm_save_klien_informasi_meta( $post_id ) {
	if ( function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! isset( $_POST['ukm_klien_informasi_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ukm_klien_informasi_nonce'] ) ), 'ukm_save_klien_informasi' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$jenis_allowed = array( 'warung', 'warung_makan', 'grosir', 'perorangan', 'institusi', 'lainnya', '' );

	$text_fields = array( 'ukm_klien_email', 'ukm_klien_telepon', 'ukm_klien_whatsapp' );

	foreach ( $text_fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			$meta_key = '_' . $field;

			if ( 'ukm_klien_email' === $field ) {
				$value = sanitize_email( wp_unslash( $_POST[ $field ] ) ); // phpcs:ignore
			} else {
				$value = sanitize_text_field( wp_unslash( $_POST[ $field ] ) ); // phpcs:ignore
			}

			update_post_meta( $post_id, $meta_key, $value );
		}
	}

	if ( isset( $_POST['ukm_klien_lokasi'] ) ) {
		update_post_meta( $post_id, '_ukm_klien_lokasi', sanitize_textarea_field( wp_unslash( $_POST['ukm_klien_lokasi'] ) ) );
	}

	if ( isset( $_POST['ukm_klien_jenis'] ) ) {
		$jenis = sanitize_text_field( wp_unslash( $_POST['ukm_klien_jenis'] ) );
		if ( in_array( $jenis, $jenis_allowed, true ) ) {
			update_post_meta( $post_id, '_ukm_klien_jenis', $jenis );
		}
	}

	if ( isset( $_POST['ukm_klien_catatan'] ) ) {
		update_post_meta( $post_id, '_ukm_klien_catatan', sanitize_textarea_field( wp_unslash( $_POST['ukm_klien_catatan'] ) ) );
	}
}
add_action( 'save_post_klien', 'ukm_save_klien_informasi_meta' );
