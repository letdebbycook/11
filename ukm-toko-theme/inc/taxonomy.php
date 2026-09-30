<?php
/**
 * Registrasi Custom Taxonomies.
 *
 * Taksonomi yang didaftarkan:
 * 1. kategori-produk — hierarkis, untuk CPT 'produk'.
 *    Term default: Sembako, Minuman, Kebersihan, Snack.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Daftarkan semua custom taxonomies tema.
 *
 * Dipanggil via hook 'init' dengan prioritas 0 — sama dengan CPT,
 * agar keduanya terdaftar sebelum flush_rewrite_rules() saat aktivasi.
 *
 * @since 1.0.0
 */
function ukm_register_taxonomies() {
	ukm_register_taxonomy_kategori_produk();
}
add_action( 'init', 'ukm_register_taxonomies', 0 );

/**
 * Daftarkan taksonomi 'kategori-produk'.
 *
 * Bersifat hierarkis (seperti kategori post WordPress) sehingga
 * bisa punya sub-kategori. Contoh: Sembako > Beras, Minuman > Minuman Segar.
 *
 * @since 1.0.0
 */
function ukm_register_taxonomy_kategori_produk() {

	$labels = array(
		'name'                       => _x( 'Kategori Produk', 'Taxonomy General Name', 'ukm-toko-theme' ),
		'singular_name'              => _x( 'Kategori Produk', 'Taxonomy Singular Name', 'ukm-toko-theme' ),
		'menu_name'                  => __( 'Kategori', 'ukm-toko-theme' ),
		'all_items'                  => __( 'Semua Kategori', 'ukm-toko-theme' ),
		'parent_item'                => __( 'Kategori Induk', 'ukm-toko-theme' ),
		'parent_item_colon'          => __( 'Kategori Induk:', 'ukm-toko-theme' ),
		'new_item_name'              => __( 'Nama Kategori Baru', 'ukm-toko-theme' ),
		'add_new_item'               => __( 'Tambah Kategori Baru', 'ukm-toko-theme' ),
		'edit_item'                  => __( 'Ubah Kategori', 'ukm-toko-theme' ),
		'update_item'                => __( 'Perbarui Kategori', 'ukm-toko-theme' ),
		'view_item'                  => __( 'Lihat Kategori', 'ukm-toko-theme' ),
		'separate_items_with_commas' => __( 'Pisahkan kategori dengan koma', 'ukm-toko-theme' ),
		'add_or_remove_items'        => __( 'Tambah atau hapus kategori', 'ukm-toko-theme' ),
		'choose_from_most_used'      => __( 'Pilih dari yang paling sering digunakan', 'ukm-toko-theme' ),
		'popular_items'              => __( 'Kategori Populer', 'ukm-toko-theme' ),
		'search_items'               => __( 'Cari Kategori', 'ukm-toko-theme' ),
		'not_found'                  => __( 'Kategori tidak ditemukan', 'ukm-toko-theme' ),
		'no_terms'                   => __( 'Belum ada kategori', 'ukm-toko-theme' ),
		'items_list'                 => __( 'Daftar kategori', 'ukm-toko-theme' ),
		'items_list_navigation'      => __( 'Navigasi daftar kategori', 'ukm-toko-theme' ),
		'back_to_items'              => __( 'Kembali ke kategori', 'ukm-toko-theme' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,                   // Seperti kategori, bukan tag.
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,                   // Tampilkan kolom kategori di tabel produk.
		'show_in_nav_menus' => true,
		'show_tagcloud'     => false,                  // Widget tag cloud tidak relevan.
		'show_in_rest'      => true,                   // Dukung editor blok Gutenberg.
		'rewrite'           => array(
			'slug'         => 'kategori-produk',
			'with_front'   => false,
			'hierarchical' => true,
		),
		'capabilities'      => array(
			'manage_terms' => 'manage_categories',
			'edit_terms'   => 'manage_categories',
			'delete_terms' => 'manage_categories',
			'assign_terms' => 'edit_posts',
		),
	);

	register_taxonomy( 'kategori-produk', array( 'produk' ), $args );
}

/**
 * Buat term kategori default jika belum ada.
 *
 * Dipanggil sekali saat aktivasi tema via hook 'after_switch_theme'.
 * Menggunakan wp_insert_term() yang aman — tidak akan membuat duplikat
 * karena mengecek apakah term sudah ada terlebih dahulu.
 *
 * Term default:
 * - Sembako     (slug: sembako)
 * - Minuman     (slug: minuman)
 * - Kebersihan  (slug: kebersihan)
 * - Snack       (slug: snack)
 *
 * @since 1.0.0
 */
function ukm_create_default_taxonomy_terms() {

	// Pastikan taksonomi sudah terdaftar.
	if ( ! taxonomy_exists( 'kategori-produk' ) ) {
		ukm_register_taxonomy_kategori_produk();
	}

	$default_terms = array(
		array(
			'name'        => 'Sembako',
			'slug'        => 'sembako',
			'description' => 'Produk sembako: beras, minyak, gula, tepung, dan kebutuhan pokok lainnya.',
		),
		array(
			'name'        => 'Minuman',
			'slug'        => 'minuman',
			'description' => 'Produk minuman: air mineral, teh, kopi, sirup, dan minuman kemasan.',
		),
		array(
			'name'        => 'Kebersihan',
			'slug'        => 'kebersihan',
			'description' => 'Produk kebersihan: sabun, detergen, pewangi, dan perlengkapan rumah tangga.',
		),
		array(
			'name'        => 'Snack',
			'slug'        => 'snack',
			'description' => 'Produk camilan dan makanan ringan.',
		),
	);

	foreach ( $default_terms as $term_data ) {
		// term_exists() mengembalikan array jika ada, null/0 jika tidak.
		$term_exists = term_exists( $term_data['slug'], 'kategori-produk' );

		if ( ! $term_exists ) {
			wp_insert_term(
				$term_data['name'],
				'kategori-produk',
				array(
					'slug'        => $term_data['slug'],
					'description' => $term_data['description'],
				)
			);
		}
	}
}
add_action( 'after_switch_theme', 'ukm_create_default_taxonomy_terms' );

/**
 * Tambahkan field kustom pada form tambah kategori produk.
 *
 * Field: ikon kategori (nama ikon atau URL).
 *
 * @since  1.0.0
 * @param  string $taxonomy Nama taksonomi yang sedang ditampilkan.
 * @return void
 */
function ukm_kategori_produk_add_form_fields( $taxonomy ) {
	?>
	<div class="form-field">
		<label for="ukm_kategori_ikon">
			<?php esc_html_e( 'Ikon Kategori', 'ukm-toko-theme' ); ?>
		</label>
		<input
			type="text"
			id="ukm_kategori_ikon"
			name="ukm_kategori_ikon"
			value=""
			maxlength="100"
		/>
		<p class="description">
			<?php esc_html_e( 'Nama kelas ikon (misal: dashicons-cart) atau URL gambar ikon.', 'ukm-toko-theme' ); ?>
		</p>
	</div>
	<?php
}
add_action( 'kategori-produk_add_form_fields', 'ukm_kategori_produk_add_form_fields' );

/**
 * Tampilkan field ikon pada form edit kategori produk.
 *
 * @since  1.0.0
 * @param  WP_Term $term Objek term yang sedang diedit.
 * @return void
 */
function ukm_kategori_produk_edit_form_fields( $term ) {
	$ikon = get_term_meta( $term->term_id, 'ukm_kategori_ikon', true );
	?>
	<tr class="form-field">
		<th scope="row">
			<label for="ukm_kategori_ikon">
				<?php esc_html_e( 'Ikon Kategori', 'ukm-toko-theme' ); ?>
			</label>
		</th>
		<td>
			<input
				type="text"
				id="ukm_kategori_ikon"
				name="ukm_kategori_ikon"
				value="<?php echo esc_attr( $ikon ); ?>"
				maxlength="100"
			/>
			<p class="description">
				<?php esc_html_e( 'Nama kelas ikon (misal: dashicons-cart) atau URL gambar ikon.', 'ukm-toko-theme' ); ?>
			</p>
		</td>
	</tr>
	<?php
}
add_action( 'kategori-produk_edit_form_fields', 'ukm_kategori_produk_edit_form_fields' );

/**
 * Simpan field ikon kategori produk saat form disimpan.
 *
 * @since  1.0.0
 * @param  int $term_id ID term yang sedang disimpan.
 * @return void
 */
function ukm_save_kategori_produk_fields( $term_id ) {
	// Verifikasi nonce untuk keamanan.
	if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'update-tag_' . $term_id ) ) {
		return;
	}

	if ( isset( $_POST['ukm_kategori_ikon'] ) ) {
		$ikon = sanitize_text_field( wp_unslash( $_POST['ukm_kategori_ikon'] ) );
		update_term_meta( $term_id, 'ukm_kategori_ikon', $ikon );
	}
}
add_action( 'created_kategori-produk', 'ukm_save_kategori_produk_fields' );
add_action( 'edited_kategori-produk', 'ukm_save_kategori_produk_fields' );
