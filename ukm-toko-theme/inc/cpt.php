<?php
/**
 * Registrasi Custom Post Types (CPT).
 *
 * CPT yang didaftarkan:
 * 1. produk  — katalog produk sembako (terpisah dari WooCommerce product).
 * 2. klien   — data klien/mitra UKM.
 *
 * Flush rewrite rules HANYA saat aktivasi tema (lihat inc/setup.php).
 * Jangan panggil flush_rewrite_rules() di sini karena akan memperlambat
 * setiap request.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Daftarkan semua Custom Post Types tema.
 *
 * Dipanggil via hook 'init' dengan prioritas 0 agar terdaftar
 * sebelum plugin lain yang mungkin bergantung padanya.
 *
 * @since 1.0.0
 */
function ukm_register_post_types() {
	ukm_register_cpt_produk();
	ukm_register_cpt_klien();
}
add_action( 'init', 'ukm_register_post_types', 0 );

// ============================================================
// CPT 1: Produk
// ============================================================

/**
 * Daftarkan Custom Post Type 'produk'.
 *
 * CPT ini untuk katalog produk sembako UKM. Berbeda dari CPT
 * 'product' milik WooCommerce — ini untuk profil produk non-transaksional.
 * WooCommerce 'product' digunakan untuk fitur add-to-cart dan checkout.
 *
 * @since 1.0.0
 */
function ukm_register_cpt_produk() {

	$labels = array(
		'name'                  => _x( 'Produk', 'Post Type General Name', 'ukm-toko-theme' ),
		'singular_name'         => _x( 'Produk', 'Post Type Singular Name', 'ukm-toko-theme' ),
		'menu_name'             => __( 'Produk Katalog', 'ukm-toko-theme' ),
		'name_admin_bar'        => __( 'Produk Katalog', 'ukm-toko-theme' ),
		'archives'              => __( 'Arsip Produk', 'ukm-toko-theme' ),
		'attributes'            => __( 'Atribut Produk', 'ukm-toko-theme' ),
		'parent_item_colon'     => __( 'Produk Induk:', 'ukm-toko-theme' ),
		'all_items'             => __( 'Semua Produk', 'ukm-toko-theme' ),
		'add_new_item'          => __( 'Tambah Produk Baru', 'ukm-toko-theme' ),
		'add_new'               => __( 'Tambah Baru', 'ukm-toko-theme' ),
		'new_item'              => __( 'Produk Baru', 'ukm-toko-theme' ),
		'edit_item'             => __( 'Ubah Produk', 'ukm-toko-theme' ),
		'update_item'           => __( 'Perbarui Produk', 'ukm-toko-theme' ),
		'view_item'             => __( 'Lihat Produk', 'ukm-toko-theme' ),
		'view_items'            => __( 'Lihat Semua Produk', 'ukm-toko-theme' ),
		'search_items'          => __( 'Cari Produk', 'ukm-toko-theme' ),
		'not_found'             => __( 'Produk tidak ditemukan', 'ukm-toko-theme' ),
		'not_found_in_trash'    => __( 'Tidak ada produk di tempat sampah', 'ukm-toko-theme' ),
		'featured_image'        => __( 'Gambar Utama Produk', 'ukm-toko-theme' ),
		'set_featured_image'    => __( 'Atur gambar utama produk', 'ukm-toko-theme' ),
		'remove_featured_image' => __( 'Hapus gambar utama produk', 'ukm-toko-theme' ),
		'use_featured_image'    => __( 'Gunakan sebagai gambar utama', 'ukm-toko-theme' ),
		'insert_into_item'      => __( 'Sisipkan ke produk', 'ukm-toko-theme' ),
		'uploaded_to_this_item' => __( 'Diunggah ke produk ini', 'ukm-toko-theme' ),
		'items_list'            => __( 'Daftar produk', 'ukm-toko-theme' ),
		'items_list_navigation' => __( 'Navigasi daftar produk', 'ukm-toko-theme' ),
		'filter_items_list'     => __( 'Saring daftar produk', 'ukm-toko-theme' ),
	);

	$args = array(
		'label'               => __( 'Produk Katalog', 'ukm-toko-theme' ),
		'description'         => __( 'Katalog produk sembako UKM. Terpisah dari produk WooCommerce.', 'ukm-toko-theme' ),
		'labels'              => $labels,
		'supports'            => array(
			'title',           // Nama produk.
			'editor',          // Deskripsi produk (konten penuh).
			'thumbnail',       // Gambar utama.
			'excerpt',         // Deskripsi singkat.
			'custom-fields',   // Meta fields tambahan.
			'revisions',       // Riwayat perubahan.
		),
		'taxonomies'          => array( 'kategori-produk' ), // Taksonomi custom (lihat taxonomy.php).
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-cart',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => 'produk',             // URL: /produk/
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => array(
			'slug'       => 'produk',
			'with_front' => false,
		),
		'capability_type'     => 'post',               // Gunakan capabilities standar post.
		'show_in_rest'        => true,                 // Dukung editor blok Gutenberg.
		'rest_base'           => 'produk-katalog',     // Endpoint REST API.
	);

	register_post_type( 'produk', $args );
}

// ============================================================
// CPT 2: Klien
// ============================================================

/**
 * Daftarkan Custom Post Type 'klien'.
 *
 * CPT ini untuk menyimpan data klien/mitra toko UKM.
 * Tidak publik di arsip (has_archive = false), hanya untuk manajemen internal
 * dan bisa ditampilkan via shortcode atau widget jika diperlukan.
 *
 * @since 1.0.0
 */
function ukm_register_cpt_klien() {

	$labels = array(
		'name'                  => _x( 'Klien', 'Post Type General Name', 'ukm-toko-theme' ),
		'singular_name'         => _x( 'Klien', 'Post Type Singular Name', 'ukm-toko-theme' ),
		'menu_name'             => __( 'Data Klien', 'ukm-toko-theme' ),
		'name_admin_bar'        => __( 'Klien', 'ukm-toko-theme' ),
		'archives'              => __( 'Arsip Klien', 'ukm-toko-theme' ),
		'attributes'            => __( 'Atribut Klien', 'ukm-toko-theme' ),
		'parent_item_colon'     => __( 'Klien Induk:', 'ukm-toko-theme' ),
		'all_items'             => __( 'Semua Klien', 'ukm-toko-theme' ),
		'add_new_item'          => __( 'Tambah Klien Baru', 'ukm-toko-theme' ),
		'add_new'               => __( 'Tambah Baru', 'ukm-toko-theme' ),
		'new_item'              => __( 'Klien Baru', 'ukm-toko-theme' ),
		'edit_item'             => __( 'Ubah Data Klien', 'ukm-toko-theme' ),
		'update_item'           => __( 'Perbarui Klien', 'ukm-toko-theme' ),
		'view_item'             => __( 'Lihat Klien', 'ukm-toko-theme' ),
		'view_items'            => __( 'Lihat Semua Klien', 'ukm-toko-theme' ),
		'search_items'          => __( 'Cari Klien', 'ukm-toko-theme' ),
		'not_found'             => __( 'Klien tidak ditemukan', 'ukm-toko-theme' ),
		'not_found_in_trash'    => __( 'Tidak ada klien di tempat sampah', 'ukm-toko-theme' ),
		'featured_image'        => __( 'Logo/Foto Klien', 'ukm-toko-theme' ),
		'set_featured_image'    => __( 'Atur logo/foto klien', 'ukm-toko-theme' ),
		'remove_featured_image' => __( 'Hapus logo/foto klien', 'ukm-toko-theme' ),
		'use_featured_image'    => __( 'Gunakan sebagai foto klien', 'ukm-toko-theme' ),
		'items_list'            => __( 'Daftar klien', 'ukm-toko-theme' ),
		'items_list_navigation' => __( 'Navigasi daftar klien', 'ukm-toko-theme' ),
		'filter_items_list'     => __( 'Saring daftar klien', 'ukm-toko-theme' ),
	);

	$args = array(
		'label'               => __( 'Data Klien', 'ukm-toko-theme' ),
		'description'         => __( 'Data mitra dan klien UKM toko sembako.', 'ukm-toko-theme' ),
		'labels'              => $labels,
		'supports'            => array(
			'title',          // Nama klien / nama toko.
			'editor',         // Catatan atau deskripsi klien.
			'thumbnail',      // Logo atau foto klien.
			'custom-fields',  // Meta fields: email, telepon, lokasi.
			'revisions',
		),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 6,
		'menu_icon'           => 'dashicons-groups',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => false,   // Tidak perlu tampil di menu publik.
		'can_export'          => true,
		'has_archive'         => false,   // Tidak ada halaman arsip publik.
		'exclude_from_search' => true,    // Tidak muncul di hasil pencarian publik.
		'publicly_queryable'  => true,    // Single post masih bisa diakses via URL.
		'rewrite'             => array(
			'slug'       => 'klien',
			'with_front' => false,
		),
		'capability_type'     => 'post',
		'show_in_rest'        => true,
		'rest_base'           => 'klien',
	);

	register_post_type( 'klien', $args );
}

// ============================================================
// Kolom Admin Kustom untuk CPT Produk
// ============================================================

/**
 * Tambahkan kolom kustom pada tabel daftar produk di admin.
 *
 * @since  1.0.0
 * @param  array $columns Kolom default yang ada.
 * @return array Kolom yang sudah dimodifikasi.
 */
function ukm_produk_admin_columns( $columns ) {
	// Sisipkan kolom setelah checkbox dan judul.
	$new_columns = array();

	foreach ( $columns as $key => $value ) {
		$new_columns[ $key ] = $value;

		if ( 'title' === $key ) {
			$new_columns['ukm_harga']    = __( 'Harga', 'ukm-toko-theme' );
			$new_columns['ukm_stok']     = __( 'Stok', 'ukm-toko-theme' );
			$new_columns['ukm_kategori'] = __( 'Kategori', 'ukm-toko-theme' );
		}
	}

	return $new_columns;
}
add_filter( 'manage_produk_posts_columns', 'ukm_produk_admin_columns' );

/**
 * Isi kolom kustom produk di tabel admin.
 *
 * @since  1.0.0
 * @param  string $column  Nama kolom yang sedang dirender.
 * @param  int    $post_id ID post saat ini.
 * @return void
 */
function ukm_produk_admin_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'ukm_harga':
			$harga = get_post_meta( $post_id, '_ukm_harga', true );
			if ( $harga ) {
				// Format angka ke Rupiah.
				echo esc_html( 'Rp ' . number_format( (float) $harga, 0, ',', '.' ) );
			} else {
				echo '<span style="color:#999">—</span>';
			}
			break;

		case 'ukm_stok':
			$stok = get_post_meta( $post_id, '_ukm_stok', true );
			if ( '' !== $stok ) {
				$stok_int = (int) $stok;
				$warna    = $stok_int > 10 ? '#16A34A' : ( $stok_int > 0 ? '#D97706' : '#DC2626' );
				echo '<span style="color:' . esc_attr( $warna ) . ';font-weight:600">' . esc_html( $stok_int ) . '</span>';
			} else {
				echo '<span style="color:#999">—</span>';
			}
			break;

		case 'ukm_kategori':
			$terms = get_the_terms( $post_id, 'kategori-produk' );
			if ( $terms && ! is_wp_error( $terms ) ) {
				$term_names = wp_list_pluck( $terms, 'name' );
				echo esc_html( implode( ', ', $term_names ) );
			} else {
				echo '<span style="color:#999">—</span>';
			}
			break;
	}
}
add_action( 'manage_produk_posts_custom_column', 'ukm_produk_admin_column_content', 10, 2 );

/**
 * Aktifkan pengurutan kolom harga dan stok di admin.
 *
 * @since  1.0.0
 * @param  array $columns Kolom yang bisa diurutkan.
 * @return array Kolom dengan tambahan kolom sortable.
 */
function ukm_produk_sortable_columns( $columns ) {
	$columns['ukm_harga'] = 'ukm_harga';
	$columns['ukm_stok']  = 'ukm_stok';
	return $columns;
}
add_filter( 'manage_edit-produk_sortable_columns', 'ukm_produk_sortable_columns' );

/**
 * Query modifier untuk mengurutkan berdasarkan meta harga atau stok.
 *
 * @since  1.0.0
 * @param  WP_Query $query Query WordPress yang sedang diproses.
 * @return void
 */
function ukm_produk_orderby_meta( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}

	$orderby = $query->get( 'orderby' );

	if ( 'ukm_harga' === $orderby ) {
		$query->set( 'meta_key', '_ukm_harga' );
		$query->set( 'orderby', 'meta_value_num' );
	}

	if ( 'ukm_stok' === $orderby ) {
		$query->set( 'meta_key', '_ukm_stok' );
		$query->set( 'orderby', 'meta_value_num' );
	}
}
add_action( 'pre_get_posts', 'ukm_produk_orderby_meta' );

// ============================================================
// Kolom Admin Kustom untuk CPT Klien
// ============================================================

/**
 * Tambahkan kolom kustom pada tabel daftar klien di admin.
 *
 * @since  1.0.0
 * @param  array $columns Kolom default.
 * @return array Kolom yang sudah dimodifikasi.
 */
function ukm_klien_admin_columns( $columns ) {
	$new_columns = array();

	foreach ( $columns as $key => $value ) {
		$new_columns[ $key ] = $value;

		if ( 'title' === $key ) {
			$new_columns['ukm_klien_email']    = __( 'Email', 'ukm-toko-theme' );
			$new_columns['ukm_klien_telepon']  = __( 'Telepon', 'ukm-toko-theme' );
			$new_columns['ukm_klien_lokasi']   = __( 'Lokasi', 'ukm-toko-theme' );
		}
	}

	return $new_columns;
}
add_filter( 'manage_klien_posts_columns', 'ukm_klien_admin_columns' );

/**
 * Isi kolom kustom klien di tabel admin.
 *
 * @since  1.0.0
 * @param  string $column  Nama kolom.
 * @param  int    $post_id ID post.
 * @return void
 */
function ukm_klien_admin_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'ukm_klien_email':
			$email = get_post_meta( $post_id, '_ukm_klien_email', true );
			echo $email ? '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>' : '<span style="color:#999">—</span>';
			break;

		case 'ukm_klien_telepon':
			$telepon = get_post_meta( $post_id, '_ukm_klien_telepon', true );
			echo $telepon ? esc_html( $telepon ) : '<span style="color:#999">—</span>';
			break;

		case 'ukm_klien_lokasi':
			$lokasi = get_post_meta( $post_id, '_ukm_klien_lokasi', true );
			echo $lokasi ? esc_html( $lokasi ) : '<span style="color:#999">—</span>';
			break;
	}
}
add_action( 'manage_klien_posts_custom_column', 'ukm_klien_admin_column_content', 10, 2 );
