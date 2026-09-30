<?php
/**
 * Seeder data dummy produk dan klien.
 *
 * Cara penggunaan:
 * 1. Via WP-CLI: wp eval-file seeder.php
 * 2. Atau akses sekali via browser (hanya untuk admin):
 *    Buat halaman sementara yang load file ini.
 *
 * PERHATIAN: Jangan biarkan file ini bisa diakses publik di produksi.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

// Keamanan: hanya bisa dijalankan dari CLI atau admin yang login.
if ( ! defined( 'ABSPATH' ) ) {
	// Inisialisasi WordPress jika dijalankan dari CLI langsung.
	$wp_load = dirname( __DIR__, 4 ) . '/wp-load.php';
	if ( file_exists( $wp_load ) ) {
		require_once $wp_load;
	} else {
		exit( 'WordPress tidak ditemukan. Jalankan via WP-CLI dari root WordPress.' );
	}
}

if ( ! current_user_can( 'manage_options' ) && ! defined( 'WP_CLI' ) ) {
	exit( 'Akses ditolak. Hanya admin yang dapat menjalankan seeder.' );
}

/**
 * Data produk dummy — 22 produk di 4 kategori.
 */
$produk_data = array(

	// Kategori: Sembako
	array(
		'judul'    => 'Beras Premium 5kg',
		'sku'      => 'SBK-001',
		'harga'    => 75000,
		'modal'    => 60000,
		'stok'     => 50,
		'satuan'   => 'kg',
		'berat'    => 5000,
		'kategori' => 'sembako',
		'status'   => 'tersedia',
		'konten'   => 'Beras premium kualitas terbaik, pulen dan wangi. Cocok untuk konsumsi sehari-hari keluarga.',
		'wa'       => '',
	),
	array(
		'judul'    => 'Minyak Goreng 1 Liter',
		'sku'      => 'SBK-002',
		'harga'    => 18000,
		'modal'    => 14000,
		'stok'     => 100,
		'satuan'   => 'botol',
		'berat'    => 1100,
		'kategori' => 'sembako',
		'status'   => 'tersedia',
		'konten'   => 'Minyak goreng premium 1 liter. Jernih, tidak berbau, cocok untuk semua jenis masakan.',
		'wa'       => '',
	),
	array(
		'judul'    => 'Gula Pasir 1kg',
		'sku'      => 'SBK-003',
		'harga'    => 16000,
		'modal'    => 13000,
		'stok'     => 80,
		'satuan'   => 'kg',
		'berat'    => 1000,
		'kategori' => 'sembako',
		'status'   => 'tersedia',
		'konten'   => 'Gula pasir putih bersih 1kg. Manis alami untuk minuman dan masakan.',
		'wa'       => '',
	),
	array(
		'judul'    => 'Tepung Terigu Serbaguna 1kg',
		'sku'      => 'SBK-004',
		'harga'    => 13000,
		'modal'    => 10000,
		'stok'     => 60,
		'satuan'   => 'kg',
		'berat'    => 1000,
		'kategori' => 'sembako',
		'status'   => 'tersedia',
		'konten'   => 'Tepung terigu serbaguna untuk kue, gorengan, dan berbagai masakan.',
		'wa'       => '',
	),
	array(
		'judul'    => 'Garam Dapur 250gram',
		'sku'      => 'SBK-005',
		'harga'    => 5000,
		'modal'    => 3000,
		'stok'     => 150,
		'satuan'   => 'pak',
		'berat'    => 270,
		'kategori' => 'sembako',
		'status'   => 'tersedia',
		'konten'   => 'Garam dapur beryodium 250gram. Baik untuk kesehatan dan memasak.',
		'wa'       => '',
	),
	array(
		'judul'    => 'Telur Ayam 1 Kg',
		'sku'      => 'SBK-006',
		'harga'    => 28000,
		'modal'    => 24000,
		'stok'     => 30,
		'satuan'   => 'kg',
		'berat'    => 1000,
		'kategori' => 'sembako',
		'status'   => 'tersedia',
		'konten'   => 'Telur ayam segar 1kg isi sekitar 15-16 butir. Segar langsung dari peternak.',
		'wa'       => '',
	),
	array(
		'judul'    => 'Kecap Manis 600ml',
		'sku'      => 'SBK-007',
		'harga'    => 22000,
		'modal'    => 18000,
		'stok'     => 45,
		'satuan'   => 'botol',
		'berat'    => 700,
		'kategori' => 'sembako',
		'status'   => 'tersedia',
		'konten'   => 'Kecap manis 600ml untuk masakan Indonesia. Rasa khas, aroma harum.',
		'wa'       => '',
	),

	// Kategori: Minuman
	array(
		'judul'    => 'Air Mineral 600ml (1 Karton)',
		'sku'      => 'MNM-001',
		'harga'    => 45000,
		'modal'    => 38000,
		'stok'     => 20,
		'satuan'   => 'karton',
		'berat'    => 14400,
		'kategori' => 'minuman',
		'status'   => 'tersedia',
		'konten'   => 'Air mineral 600ml 1 karton isi 24 botol. Segar dan higienis.',
		'wa'       => '',
	),
	array(
		'judul'    => 'Teh Celup 25 Sachet',
		'sku'      => 'MNM-002',
		'harga'    => 12000,
		'modal'    => 9000,
		'stok'     => 60,
		'satuan'   => 'pak',
		'berat'    => 50,
		'kategori' => 'minuman',
		'status'   => 'tersedia',
		'konten'   => 'Teh celup premium 25 sachet. Rasa teh hitam yang kuat dan segar.',
		'wa'       => '',
	),
	array(
		'judul'    => 'Kopi Sachet 1 Box (10 sachet)',
		'sku'      => 'MNM-003',
		'harga'    => 20000,
		'modal'    => 16000,
		'stok'     => 40,
		'satuan'   => 'pak',
		'berat'    => 120,
		'kategori' => 'minuman',
		'status'   => 'tersedia',
		'konten'   => 'Kopi 3in1 sachet 1 box isi 10 sachet. Paduan kopi, gula, dan krimer yang pas.',
		'wa'       => '',
	),
	array(
		'judul'    => 'Sirup Fruity 630ml',
		'sku'      => 'MNM-004',
		'harga'    => 28000,
		'modal'    => 22000,
		'stok'     => 25,
		'satuan'   => 'botol',
		'berat'    => 700,
		'kategori' => 'minuman',
		'status'   => 'tersedia',
		'konten'   => 'Sirup berbagai rasa buah 630ml. Cocok untuk minuman keluarga dan takjil.',
		'wa'       => '',
	),
	array(
		'judul'    => 'Susu UHT Full Cream 1 Liter',
		'sku'      => 'MNM-005',
		'harga'    => 18000,
		'modal'    => 14500,
		'stok'     => 35,
		'satuan'   => 'liter',
		'berat'    => 1050,
		'kategori' => 'minuman',
		'status'   => 'tersedia',
		'konten'   => 'Susu UHT full cream 1 liter. Bergizi tinggi, cocok untuk anak dan dewasa.',
		'wa'       => '',
	),

	// Kategori: Kebersihan
	array(
		'judul'    => 'Sabun Mandi Batang',
		'sku'      => 'KBR-001',
		'harga'    => 8000,
		'modal'    => 6000,
		'stok'     => 90,
		'satuan'   => 'pcs',
		'berat'    => 90,
		'kategori' => 'kebersihan',
		'status'   => 'tersedia',
		'konten'   => 'Sabun mandi batang premium. Bersih, wangi, dan menjaga kelembapan kulit.',
		'wa'       => '',
	),
	array(
		'judul'    => 'Deterjen Bubuk 800gram',
		'sku'      => 'KBR-002',
		'harga'    => 18000,
		'modal'    => 14000,
		'stok'     => 55,
		'satuan'   => 'pak',
		'berat'    => 850,
		'kategori' => 'kebersihan',
		'status'   => 'tersedia',
		'konten'   => 'Deterjen bubuk 800gram. Ampuh membersihkan noda membandel, aman untuk mesin cuci.',
		'wa'       => '',
	),
	array(
		'judul'    => 'Sabun Cuci Piring 750ml',
		'sku'      => 'KBR-003',
		'harga'    => 14000,
		'modal'    => 11000,
		'stok'     => 40,
		'satuan'   => 'botol',
		'berat'    => 800,
		'kategori' => 'kebersihan',
		'status'   => 'tersedia',
		'konten'   => 'Sabun cuci piring 750ml. Berbusa banyak, efektif mengangkat lemak.',
		'wa'       => '',
	),
	array(
		'judul'    => 'Pembersih Lantai 780ml',
		'sku'      => 'KBR-004',
		'harga'    => 22000,
		'modal'    => 17000,
		'stok'     => 30,
		'satuan'   => 'botol',
		'berat'    => 850,
		'kategori' => 'kebersihan',
		'status'   => 'tersedia',
		'konten'   => 'Pembersih lantai 780ml. Membunuh kuman, aroma segar tahan lama.',
		'wa'       => '',
	),
	array(
		'judul'    => 'Pewangi Pakaian 900ml',
		'sku'      => 'KBR-005',
		'harga'    => 24000,
		'modal'    => 19000,
		'stok'     => 0,
		'satuan'   => 'botol',
		'berat'    => 950,
		'kategori' => 'kebersihan',
		'status'   => 'habis',
		'konten'   => 'Pewangi pakaian 900ml. Wangi tahan lama, menjaga kesegaran pakaian.',
		'wa'       => '',
	),

	// Kategori: Snack
	array(
		'judul'    => 'Biskuit Cream 130gram',
		'sku'      => 'SNK-001',
		'harga'    => 10000,
		'modal'    => 7500,
		'stok'     => 70,
		'satuan'   => 'pcs',
		'berat'    => 140,
		'kategori' => 'snack',
		'status'   => 'tersedia',
		'konten'   => 'Biskuit cream coklat 130gram. Renyah manis, cocok untuk cemilan keluarga.',
		'wa'       => '',
	),
	array(
		'judul'    => 'Keripik Kentang 80gram',
		'sku'      => 'SNK-002',
		'harga'    => 15000,
		'modal'    => 11000,
		'stok'     => 45,
		'satuan'   => 'pcs',
		'berat'    => 90,
		'kategori' => 'snack',
		'status'   => 'tersedia',
		'konten'   => 'Keripik kentang rasa original 80gram. Renyah gurih, tanpa pengawet berbahaya.',
		'wa'       => '',
	),
	array(
		'judul'    => 'Mi Instan Goreng (1 Karton)',
		'sku'      => 'SNK-003',
		'harga'    => 120000,
		'modal'    => 98000,
		'stok'     => 15,
		'satuan'   => 'karton',
		'berat'    => 2400,
		'kategori' => 'snack',
		'status'   => 'tersedia',
		'konten'   => 'Mi instan goreng 1 karton isi 40 bungkus. Praktis, lezat, harga ekonomis.',
		'wa'       => '',
	),
	array(
		'judul'    => 'Wafer Coklat 145gram',
		'sku'      => 'SNK-004',
		'harga'    => 12000,
		'modal'    => 9000,
		'stok'     => 55,
		'satuan'   => 'pcs',
		'berat'    => 155,
		'kategori' => 'snack',
		'status'   => 'tersedia',
		'konten'   => 'Wafer coklat 145gram. Berlapis coklat creamy, renyah dan lezat.',
		'wa'       => '',
	),
	array(
		'judul'    => 'Permen Mint (1 Toples)',
		'sku'      => 'SNK-005',
		'harga'    => 25000,
		'modal'    => 19000,
		'stok'     => 20,
		'satuan'   => 'pcs',
		'berat'    => 320,
		'kategori' => 'snack',
		'status'   => 'tersedia',
		'konten'   => 'Permen mint 1 toples isi sekitar 100 butir. Segar dan tahan lama.',
		'wa'       => '',
	),
);

/**
 * Data klien dummy.
 */
$klien_data = array(
	array(
		'nama'    => 'Toko Sembako Bu RT',
		'email'   => 'tobusembako.burt@contoh.com',
		'telepon' => '081234567890',
		'wa'      => '6281234567890',
		'lokasi'  => 'Jl. Cempaka No. 5, RT 03/RW 02, Kelurahan Damai, Kecamatan Makmur',
		'jenis'   => 'warung',
		'catatan' => 'Pelanggan setia sejak 2020. Biasanya belanja bulanan beras dan minyak.',
		'konten'  => 'Toko sembako ibu RT yang melayani kebutuhan warga sekitar kampung.',
	),
	array(
		'nama'    => 'Warung Makan Pak Slamet',
		'email'   => 'warung.slamet@contoh.com',
		'telepon' => '082345678901',
		'wa'      => '6282345678901',
		'lokasi'  => 'Jl. Melati No. 12, depan pasar tradisional, Kelurahan Sumber Jaya',
		'jenis'   => 'warung_makan',
		'catatan' => 'Membeli gula, tepung, dan minyak dalam jumlah banyak setiap 2 minggu.',
		'konten'  => 'Warung makan rumahan yang menyajikan masakan Jawa untuk sarapan dan makan siang.',
	),
);

// ============================================================
// Mulai Proses Seeder
// ============================================================

echo "\n=== UKM Toko Theme Seeder ===\n";
echo "Memulai proses import data dummy...\n\n";

$produk_berhasil = 0;
$produk_gagal    = 0;

foreach ( $produk_data as $produk ) {

	// Cek apakah produk sudah ada (berdasarkan judul) — cegah duplikat.
	$existing = get_page_by_title( $produk['judul'], OBJECT, 'produk' );
	if ( $existing ) {
		echo "[SKIP] '{$produk['judul']}' sudah ada (ID: {$existing->ID})\n";
		continue;
	}

	// Buat post produk.
	$post_id = wp_insert_post(
		array(
			'post_title'   => sanitize_text_field( $produk['judul'] ),
			'post_content' => wp_kses_post( $produk['konten'] ),
			'post_status'  => 'publish',
			'post_type'    => 'produk',
		),
		true
	);

	if ( is_wp_error( $post_id ) ) {
		echo "[ERROR] '{$produk['judul']}': " . $post_id->get_error_message() . "\n";
		$produk_gagal++;
		continue;
	}

	// Simpan meta fields.
	update_post_meta( $post_id, '_ukm_harga', $produk['harga'] );
	update_post_meta( $post_id, '_ukm_harga_modal', $produk['modal'] );
	update_post_meta( $post_id, '_ukm_stok', $produk['stok'] );
	update_post_meta( $post_id, '_ukm_satuan', $produk['satuan'] );
	update_post_meta( $post_id, '_ukm_berat', $produk['berat'] );
	update_post_meta( $post_id, '_ukm_sku', $produk['sku'] );
	update_post_meta( $post_id, '_ukm_status_produk', $produk['status'] );

	if ( $produk['wa'] ) {
		update_post_meta( $post_id, '_ukm_wa_pesan', $produk['wa'] );
	}

	// Tetapkan kategori produk.
	$term = get_term_by( 'slug', $produk['kategori'], 'kategori-produk' );
	if ( $term ) {
		wp_set_object_terms( $post_id, $term->term_id, 'kategori-produk' );
	}

	echo "[OK] Produk '{$produk['judul']}' dibuat (ID: {$post_id})\n";
	$produk_berhasil++;
}

echo "\nSeeder Produk: {$produk_berhasil} berhasil, {$produk_gagal} gagal.\n\n";

// ============================================================
// Seeder Klien
// ============================================================

$klien_berhasil = 0;
$klien_gagal    = 0;

foreach ( $klien_data as $klien ) {

	$existing = get_page_by_title( $klien['nama'], OBJECT, 'klien' );
	if ( $existing ) {
		echo "[SKIP] Klien '{$klien['nama']}' sudah ada.\n";
		continue;
	}

	$post_id = wp_insert_post(
		array(
			'post_title'   => sanitize_text_field( $klien['nama'] ),
			'post_content' => wp_kses_post( $klien['konten'] ),
			'post_status'  => 'publish',
			'post_type'    => 'klien',
		),
		true
	);

	if ( is_wp_error( $post_id ) ) {
		echo "[ERROR] '{$klien['nama']}': " . $post_id->get_error_message() . "\n";
		$klien_gagal++;
		continue;
	}

	update_post_meta( $post_id, '_ukm_klien_email', sanitize_email( $klien['email'] ) );
	update_post_meta( $post_id, '_ukm_klien_telepon', sanitize_text_field( $klien['telepon'] ) );
	update_post_meta( $post_id, '_ukm_klien_whatsapp', sanitize_text_field( $klien['wa'] ) );
	update_post_meta( $post_id, '_ukm_klien_lokasi', sanitize_textarea_field( $klien['lokasi'] ) );
	update_post_meta( $post_id, '_ukm_klien_jenis', sanitize_text_field( $klien['jenis'] ) );
	update_post_meta( $post_id, '_ukm_klien_catatan', sanitize_textarea_field( $klien['catatan'] ) );

	echo "[OK] Klien '{$klien['nama']}' dibuat (ID: {$post_id})\n";
	$klien_berhasil++;
}

echo "\nSeeder Klien: {$klien_berhasil} berhasil, {$klien_gagal} gagal.\n";
echo "\n=== Seeder selesai! ===\n";
