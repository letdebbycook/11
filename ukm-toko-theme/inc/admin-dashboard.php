<?php
/**
 * Admin Dashboard Khusus Toko UKM Sembako.
 *
 * Menyediakan dashboard modern, metrik bisnis sembako, status stok,
 * dan widget cepat di admin WordPress.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Daftarkan menu utama "Toko UKM" di sidebar admin WordPress.
 *
 * @since 1.0.0
 */
function ukm_register_admin_dashboard_menu() {
	// Menu Utama: Toko UKM
	add_menu_page(
		__( 'Dashboard Toko UKM', 'ukm-toko-theme' ),
		__( 'Toko UKM', 'ukm-toko-theme' ),
		'manage_options',
		'ukm-toko-dashboard',
		'ukm_render_admin_dashboard',
		'dashicons-store',
		3 // Tepat di bawah menu Dashboard utama WP.
	);

	// Submenu: Dashboard Toko
	add_submenu_page(
		'ukm-toko-dashboard',
		__( 'Dashboard Toko', 'ukm-toko-theme' ),
		__( 'Dashboard', 'ukm-toko-theme' ),
		'manage_options',
		'ukm-toko-dashboard',
		'ukm_render_admin_dashboard'
	);

	// Submenu: Semua Produk (Shortcut CPT)
	add_submenu_page(
		'ukm-toko-dashboard',
		__( 'Katalog Produk', 'ukm-toko-theme' ),
		__( 'Semua Produk', 'ukm-toko-theme' ),
		'manage_options',
		'edit.php?post_type=produk'
	);

	// Submenu: Tambah Produk
	add_submenu_page(
		'ukm-toko-dashboard',
		__( 'Tambah Produk Baru', 'ukm-toko-theme' ),
		__( 'Tambah Produk', 'ukm-toko-theme' ),
		'manage_options',
		'post-new.php?post_type=produk'
	);

	// Submenu: Kategori Sembako
	add_submenu_page(
		'ukm-toko-dashboard',
		__( 'Kategori Produk', 'ukm-toko-theme' ),
		__( 'Kategori Sembako', 'ukm-toko-theme' ),
		'manage_options',
		'edit-tags.php?taxonomy=kategori-produk&post_type=produk'
	);

	// Submenu: Mitra & Klien
	add_submenu_page(
		'ukm-toko-dashboard',
		__( 'Mitra & Klien UKM', 'ukm-toko-theme' ),
		__( 'Mitra & Klien', 'ukm-toko-theme' ),
		'manage_options',
		'edit.php?post_type=klien'
	);

	// Submenu: Pengaturan Toko
	add_submenu_page(
		'ukm-toko-dashboard',
		__( 'Pengaturan Toko UKM', 'ukm-toko-theme' ),
		__( 'Pengaturan Toko', 'ukm-toko-theme' ),
		'manage_options',
		'ukm-toko-settings',
		'ukm_render_settings_page'
	);
}
add_action( 'admin_menu', 'ukm_register_admin_dashboard_menu' );

/**
 * Enqueue CSS untuk Admin Dashboard & Pengaturan Toko.
 *
 * @since 1.0.0
 * @param string $hook Nama hook halaman admin saat ini.
 */
function ukm_enqueue_admin_dashboard_styles( $hook ) {
	$allowed_hooks = array(
		'toplevel_page_ukm-toko-dashboard',
		'toko-ukm_page_ukm-toko-settings',
		'settings_page_ukm-toko-settings',
		'index.php', // Dashboard utama WP
	);

	if ( in_array( $hook, $allowed_hooks, true ) ) {
		wp_enqueue_style(
			'ukm-admin-dashboard-style',
			UKM_THEME_URI . 'assets/css/admin-dashboard.css',
			array(),
			UKM_THEME_VERSION
		);
	}
}
add_action( 'admin_enqueue_scripts', 'ukm_enqueue_admin_dashboard_styles' );

/**
 * Daftarkan widget ringkasan Toko UKM di Dashboard utama WordPress (wp-admin/index.php).
 *
 * @since 1.0.0
 */
function ukm_register_dashboard_widget() {
	wp_add_dashboard_widget(
		'ukm_admin_dashboard_widget',
		__( 'Toko Sembako Berkah - Ringkasan Toko', 'ukm-toko-theme' ),
		'ukm_render_dashboard_widget'
	);
}
add_action( 'wp_dashboard_setup', 'ukm_register_dashboard_widget' );

/**
 * Render konten widget di Dashboard utama WordPress.
 *
 * @since 1.0.0
 */
function ukm_render_dashboard_widget() {
	$count_produk = (int) wp_count_posts( 'produk' )->publish;
	$count_klien  = (int) wp_count_posts( 'klien' )->publish;
	$nama_toko    = ukm_get_option( 'ukm_nama_toko', get_bloginfo( 'name' ) );
	$wa_nomor     = ukm_get_option( 'ukm_whatsapp_toko', '' );
	$jam_buka     = ukm_get_option( 'ukm_jam_buka', 'Senin - Sabtu, 08.00 - 20.00 WIB' );
	?>
	<div class="ukm-wp-widget-content">
		<div class="ukm-wp-widget-header">
			<div class="ukm-wp-widget-avatar"><span class="dashicons dashicons-store" style="font-size:24px;width:24px;height:24px"></span></div>
			<div>
				<h3 style="margin:0;font-size:15px;font-weight:700"><?php echo esc_html( $nama_toko ); ?></h3>
				<p style="margin:2px 0 0;font-size:12px;color:#64748b"><?php echo esc_html( $jam_buka ); ?></p>
			</div>
		</div>

		<div class="ukm-wp-widget-stats">
			<div class="ukm-wp-widget-stat-item">
				<span>Total Produk</span>
				<strong><?php echo esc_html( $count_produk ); ?></strong>
			</div>
			<div class="ukm-wp-widget-stat-item">
				<span>Mitra / Klien</span>
				<strong><?php echo esc_html( $count_klien ); ?></strong>
			</div>
		</div>

		<div style="display:flex;gap:8px;flex-wrap:wrap">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=ukm-toko-dashboard' ) ); ?>" class="button button-primary">
				<?php esc_html_e( 'Buka Dashboard UKM', 'ukm-toko-theme' ); ?>
			</a>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button" target="_blank">
				<?php esc_html_e( 'Lihat Website', 'ukm-toko-theme' ); ?>
			</a>
			<?php if ( $wa_nomor ) : ?>
				<a href="https://wa.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $wa_nomor ) ); ?>" class="button" target="_blank">
					<?php esc_html_e( 'WhatsApp Toko', 'ukm-toko-theme' ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
	<?php
}

/**
 * Render Halaman Admin Dashboard Toko UKM.
 *
 * @since 1.0.0
 */
function ukm_render_admin_dashboard() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Anda tidak memiliki izin untuk mengakses halaman ini.', 'ukm-toko-theme' ) );
	}

	$nama_toko   = ukm_get_option( 'ukm_nama_toko', get_bloginfo( 'name' ) );
	$tagline     = ukm_get_option( 'ukm_tagline_toko', get_bloginfo( 'description' ) );
	$wa_nomor    = ukm_get_option( 'ukm_whatsapp_toko', '' );
	$telp_toko   = ukm_get_option( 'ukm_telepon_toko', '-' );
	$alamat_toko = ukm_get_option( 'ukm_alamat_toko', '-' );
	$kota_toko   = ukm_get_option( 'ukm_kota_toko', '-' );
	$jam_buka    = ukm_get_option( 'ukm_jam_buka', 'Senin - Sabtu, 08.00 - 20.00 WIB' );

	// Statistik
	$count_produk = (int) wp_count_posts( 'produk' )->publish;
	$count_klien  = (int) wp_count_posts( 'klien' )->publish;
	$terms        = get_terms( array( 'taxonomy' => 'kategori-produk', 'hide_empty' => false ) );
	$count_terms  = is_array( $terms ) ? count( $terms ) : 0;

	// Query produk untuk cek stok
	$all_products = get_posts(
		array(
			'post_type'      => 'produk',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		)
	);

	$low_stock_count = 0;
	$out_stock_count = 0;
	foreach ( $all_products as $p ) {
		$stok   = (int) get_post_meta( $p->ID, '_ukm_stok', true );
		$status = get_post_meta( $p->ID, '_ukm_status_produk', true );
		if ( 'habis' === $status || 0 === $stok ) {
			$out_stock_count++;
		} elseif ( $stok > 0 && $stok <= 20 ) {
			$low_stock_count++;
		}
	}

	// 6 Produk Terkini
	$recent_products = get_posts(
		array(
			'post_type'      => 'produk',
			'posts_per_page' => 6,
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);
	?>

	<div class="wrap ukm-admin-wrap">

		<!-- HERO BANNER -->
		<section class="ukm-admin-hero">
			<div class="ukm-admin-hero__content">
				<span class="ukm-admin-hero__badge">
					<span class="dashicons dashicons-yes-alt" style="font-size:14px;width:14px;height:14px"></span>
					<?php esc_html_e( 'Sistem Aktif & Terhubung', 'ukm-toko-theme' ); ?>
				</span>
				<h1 class="ukm-admin-hero__title"><?php echo esc_html( $nama_toko ); ?></h1>
				<p class="ukm-admin-hero__desc">
					<?php echo esc_html( $tagline ?: __( 'Pusat manajemen katalog sembako, stok barang, informasi operasional, dan pelanggan UKM.', 'ukm-toko-theme' ) ); ?>
				</p>
			</div>
			<div class="ukm-admin-hero__actions">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ukm-admin-btn ukm-admin-btn--white" target="_blank">
					<span class="dashicons dashicons-admin-site-alt3"></span>
					<?php esc_html_e( 'Lihat Website', 'ukm-toko-theme' ); ?>
				</a>
				<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=produk' ) ); ?>" class="ukm-admin-btn ukm-admin-btn--glass">
					<span class="dashicons dashicons-plus-alt2"></span>
					<?php esc_html_e( 'Tambah Produk', 'ukm-toko-theme' ); ?>
				</a>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=ukm-toko-settings' ) ); ?>" class="ukm-admin-btn ukm-admin-btn--glass">
					<span class="dashicons dashicons-admin-generic"></span>
					<?php esc_html_e( 'Pengaturan', 'ukm-toko-theme' ); ?>
				</a>
			</div>
		</section>

		<!-- METRIC CARDS -->
		<section class="ukm-admin-metrics">
			<!-- Total Produk -->
			<div class="ukm-metric-card">
				<div class="ukm-metric-card__info">
					<span class="ukm-metric-card__label"><?php esc_html_e( 'Total Produk', 'ukm-toko-theme' ); ?></span>
					<span class="ukm-metric-card__value"><?php echo esc_html( $count_produk ); ?></span>
					<span class="ukm-metric-card__sub"><?php esc_html_e( 'Katalog aktif terpublikasi', 'ukm-toko-theme' ); ?></span>
				</div>
				<div class="ukm-metric-card__icon ukm-metric-card__icon--emerald">
					<span class="dashicons dashicons-cart"></span>
				</div>
			</div>

			<!-- Kategori -->
			<div class="ukm-metric-card">
				<div class="ukm-metric-card__info">
					<span class="ukm-metric-card__label"><?php esc_html_e( 'Kategori Sembako', 'ukm-toko-theme' ); ?></span>
					<span class="ukm-metric-card__value"><?php echo esc_html( $count_terms ); ?></span>
					<span class="ukm-metric-card__sub"><?php esc_html_e( 'Kelompok komoditas', 'ukm-toko-theme' ); ?></span>
				</div>
				<div class="ukm-metric-card__icon ukm-metric-card__icon--blue">
					<span class="dashicons dashicons-category"></span>
				</div>
			</div>

			<!-- Perhatian Stok -->
			<div class="ukm-metric-card">
				<div class="ukm-metric-card__info">
					<span class="ukm-metric-card__label"><?php esc_html_e( 'Perhatian Stok', 'ukm-toko-theme' ); ?></span>
					<span class="ukm-metric-card__value"><?php echo esc_html( $low_stock_count + $out_stock_count ); ?></span>
					<span class="ukm-metric-card__sub">
						<?php
						printf(
							/* translators: 1: jumlah stok tipis, 2: jumlah stok habis */
							esc_html__( '%1$d menipis, %2$d habis', 'ukm-toko-theme' ),
							$low_stock_count,
							$out_stock_count
						);
						?>
					</span>
				</div>
				<div class="ukm-metric-card__icon ukm-metric-card__icon--amber">
					<span class="dashicons dashicons-warning"></span>
				</div>
			</div>

			<!-- Mitra / Klien -->
			<div class="ukm-metric-card">
				<div class="ukm-metric-card__info">
					<span class="ukm-metric-card__label"><?php esc_html_e( 'Mitra & Klien', 'ukm-toko-theme' ); ?></span>
					<span class="ukm-metric-card__value"><?php echo esc_html( $count_klien ); ?></span>
					<span class="ukm-metric-card__sub"><?php esc_html_e( 'Mitra pemasok & distributor', 'ukm-toko-theme' ); ?></span>
				</div>
				<div class="ukm-metric-card__icon ukm-metric-card__icon--purple">
					<span class="dashicons dashicons-groups"></span>
				</div>
			</div>
		</section>

		<!-- GRID UTAMA (2 Kolom) -->
		<div class="ukm-admin-grid">

			<!-- KOLOM KIRI (Tabel Produk & Pintasan) -->
			<div class="ukm-admin-main-col">

				<!-- Tabel Produk Terkini -->
				<div class="ukm-admin-card">
					<div class="ukm-admin-card__header">
						<h2 class="ukm-admin-card__title">
							<span class="dashicons dashicons-list-view"></span>
							<?php esc_html_e( 'Inventaris & Produk Terkini', 'ukm-toko-theme' ); ?>
						</h2>
						<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=produk' ) ); ?>" class="ukm-admin-btn ukm-admin-btn--primary ukm-admin-btn--sm">
							<?php esc_html_e( 'Lihat Semua (Katalog)', 'ukm-toko-theme' ); ?> &rarr;
						</a>
					</div>
					<div class="ukm-admin-card__body" style="padding:0">
						<?php if ( ! empty( $recent_products ) ) : ?>
							<table class="ukm-admin-table">
								<thead>
									<tr>
										<th><?php esc_html_e( 'Produk', 'ukm-toko-theme' ); ?></th>
										<th><?php esc_html_e( 'SKU', 'ukm-toko-theme' ); ?></th>
										<th><?php esc_html_e( 'Harga', 'ukm-toko-theme' ); ?></th>
										<th><?php esc_html_e( 'Stok', 'ukm-toko-theme' ); ?></th>
										<th><?php esc_html_e( 'Status', 'ukm-toko-theme' ); ?></th>
										<th style="text-align:right"><?php esc_html_e( 'Aksi', 'ukm-toko-theme' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ( $recent_products as $prod ) :
										$p_id     = $prod->ID;
										$harga    = ukm_get_produk_field( '_ukm_harga', $p_id );
										$satuan   = ukm_get_produk_field( '_ukm_satuan', $p_id, 'pcs' );
										$stok     = (int) ukm_get_produk_field( '_ukm_stok', $p_id, 0 );
										$sku      = ukm_get_produk_field( '_ukm_sku', $p_id, '-' );
										$status   = ukm_get_produk_field( '_ukm_status_produk', $p_id, 'tersedia' );
										$terms    = get_the_terms( $p_id, 'kategori-produk' );
										$kat_nama = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : 'Umum';
										?>
										<tr>
											<td>
												<div style="display:flex;align-items:center;gap:12px">
													<div style="width:40px;height:40px;border-radius:6px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;font-size:20px;overflow:hidden">
														<?php if ( has_post_thumbnail( $p_id ) ) : ?>
															<?php echo get_the_post_thumbnail( $p_id, array( 40, 40 ), array( 'style' => 'object-fit:cover;width:100%;height:100%' ) ); ?>
														<?php else : ?>
															<span class="dashicons dashicons-products" style="color:#64748b"></span>
														<?php endif; ?>
													</div>
													<div>
														<strong style="display:block;font-size:13px"><?php echo esc_html( $prod->post_title ); ?></strong>
														<span style="font-size:11px;color:#64748b"><?php echo esc_html( $kat_nama ); ?></span>
													</div>
												</div>
											</td>
											<td><code style="background:#f1f5f9;padding:2px 6px;border-radius:4px"><?php echo esc_html( $sku ); ?></code></td>
											<td>
												<span style="font-weight:600;color:#1b4332">
													<?php echo esc_html( ukm_format_rupiah( $harga ) ); ?>
												</span>
												<span style="font-size:11px;color:#64748b">/ <?php echo esc_html( $satuan ); ?></span>
											</td>
											<td>
												<strong><?php echo esc_html( $stok ); ?></strong> <?php echo esc_html( $satuan ); ?>
											</td>
											<td>
												<?php if ( 'habis' === $status || 0 === $stok ) : ?>
													<span class="ukm-badge-pill ukm-badge-pill--danger">● <?php esc_html_e( 'Habis', 'ukm-toko-theme' ); ?></span>
												<?php elseif ( $stok <= 20 ) : ?>
													<span class="ukm-badge-pill ukm-badge-pill--warning">● <?php esc_html_e( 'Menipis', 'ukm-toko-theme' ); ?></span>
												<?php else : ?>
													<span class="ukm-badge-pill ukm-badge-pill--success">● <?php esc_html_e( 'Tersedia', 'ukm-toko-theme' ); ?></span>
												<?php endif; ?>
											</td>
											<td style="text-align:right">
												<a href="<?php echo esc_url( get_edit_post_link( $p_id ) ); ?>" class="button button-small">
													<?php esc_html_e( 'Edit', 'ukm-toko-theme' ); ?>
												</a>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						<?php else : ?>
							<p style="padding:24px;text-align:center;color:#64748b">
								<?php esc_html_e( 'Belum ada produk yang ditambahkan.', 'ukm-toko-theme' ); ?>
							</p>
						<?php endif; ?>
					</div>
				</div>

				<!-- Aksi Cepat Pengelola -->
				<div class="ukm-admin-card">
					<div class="ukm-admin-card__header">
						<h2 class="ukm-admin-card__title">
							<span class="dashicons dashicons-superhero"></span>
							<?php esc_html_e( 'Pintasan Pengelolaan Toko', 'ukm-toko-theme' ); ?>
						</h2>
					</div>
					<div class="ukm-admin-card__body">
						<div class="ukm-admin-shortcuts">
							<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=produk' ) ); ?>" class="ukm-shortcut-btn">
								<span class="dashicons dashicons-plus-alt"></span>
								<span><?php esc_html_e( 'Tambah Produk Sembako', 'ukm-toko-theme' ); ?></span>
							</a>
							<a href="<?php echo esc_url( admin_url( 'edit-tags.php?taxonomy=kategori-produk&post_type=produk' ) ); ?>" class="ukm-shortcut-btn">
								<span class="dashicons dashicons-tag"></span>
								<span><?php esc_html_e( 'Kelola Kategori', 'ukm-toko-theme' ); ?></span>
							</a>
							<a href="<?php echo esc_url( admin_url( 'admin.php?page=ukm-toko-settings' ) ); ?>" class="ukm-shortcut-btn">
								<span class="dashicons dashicons-admin-settings"></span>
								<span><?php esc_html_e( 'Pengaturan Toko & WA', 'ukm-toko-theme' ); ?></span>
							</a>
							<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="ukm-shortcut-btn">
								<span class="dashicons dashicons-art"></span>
								<span><?php esc_html_e( 'Kustomisasi Tampilan', 'ukm-toko-theme' ); ?></span>
							</a>
						</div>
					</div>
				</div>

			</div>

			<!-- KOLOM KANAN (Info Toko & Status Sistem) -->
			<div class="ukm-admin-side-col">

				<!-- Profil Toko & Kontak -->
				<div class="ukm-admin-card">
					<div class="ukm-admin-card__header">
						<h2 class="ukm-admin-card__title">
							<span class="dashicons dashicons-store"></span>
							<?php esc_html_e( 'Profil Toko Saat Ini', 'ukm-toko-theme' ); ?>
						</h2>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=ukm-toko-settings' ) ); ?>" class="ukm-admin-btn ukm-admin-btn--sm" style="color:var(--ukm-admin-primary)">
							<?php esc_html_e( 'Edit', 'ukm-toko-theme' ); ?>
						</a>
					</div>
					<div class="ukm-admin-card__body">
						<ul class="ukm-info-list">
							<li>
								<span class="dashicons dashicons-clock"></span>
								<div>
									<strong><?php esc_html_e( 'Jam Operasional', 'ukm-toko-theme' ); ?></strong>
									<span><?php echo esc_html( $jam_buka ); ?></span>
								</div>
							</li>
							<li>
								<span class="dashicons dashicons-phone"></span>
								<div>
									<strong><?php esc_html_e( 'WhatsApp Pemesanan', 'ukm-toko-theme' ); ?></strong>
									<span><?php echo esc_html( $wa_nomor ?: '-' ); ?></span>
									<?php if ( $wa_nomor ) : ?>
										<div style="margin-top:4px">
											<a href="https://wa.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $wa_nomor ) ); ?>" target="_blank" class="button button-small" style="font-size:11px">
												<?php esc_html_e( 'Tes WhatsApp', 'ukm-toko-theme' ); ?> &nearr;
											</a>
										</div>
									<?php endif; ?>
								</div>
							</li>
							<li>
								<span class="dashicons dashicons-location"></span>
								<div>
									<strong><?php esc_html_e( 'Alamat Fisik', 'ukm-toko-theme' ); ?></strong>
									<span><?php echo esc_html( $alamat_toko ); ?></span>
									<?php if ( $kota_toko && '-' !== $kota_toko ) : ?>
										<span style="display:block;color:#64748b"><?php echo esc_html( $kota_toko ); ?></span>
									<?php endif; ?>
								</div>
							</li>
						</ul>
					</div>
				</div>

				<!-- Status Sistem & Keamanan UKM -->
				<div class="ukm-admin-card">
					<div class="ukm-admin-card__header">
						<h2 class="ukm-admin-card__title">
							<span class="dashicons dashicons-shield"></span>
							<?php esc_html_e( 'Kesiapan Sistem & SEO', 'ukm-toko-theme' ); ?>
						</h2>
					</div>
					<div class="ukm-admin-card__body">
						<ul class="ukm-info-list">
							<li>
								<span class="dashicons dashicons-yes" style="color:#10b981"></span>
								<div>
									<strong><?php esc_html_e( 'Tema Aktif', 'ukm-toko-theme' ); ?></strong>
									<span>UKM Toko Sembako (v<?php echo esc_html( UKM_THEME_VERSION ); ?>)</span>
								</div>
							</li>
							<li>
								<span class="dashicons dashicons-yes" style="color:#10b981"></span>
								<div>
									<strong><?php esc_html_e( 'Database MySQL', 'ukm-toko-theme' ); ?></strong>
									<span><?php esc_html_e( 'Terhubung & 22 Produk Dummy Siap', 'ukm-toko-theme' ); ?></span>
								</div>
							</li>
							<li>
								<span class="dashicons dashicons-yes" style="color:#10b981"></span>
								<div>
									<strong><?php esc_html_e( 'Schema SEO JSON-LD', 'ukm-toko-theme' ); ?></strong>
									<span>LocalBusiness & Product Schema Aktif</span>
								</div>
							</li>
							<li>
								<span class="dashicons dashicons-admin-plugins" style="color:#3b82f6"></span>
								<div>
									<strong><?php esc_html_e( 'Integrasi WooCommerce', 'ukm-toko-theme' ); ?></strong>
									<span>
										<?php echo ukm_is_woocommerce_active() ? esc_html__( 'Aktif', 'ukm-toko-theme' ) : esc_html__( 'Siap Terintegrasi (Opsional)', 'ukm-toko-theme' ); ?>
									</span>
								</div>
							</li>
						</ul>
					</div>
				</div>

			</div>

		</div>

	</div>
	<?php
}
