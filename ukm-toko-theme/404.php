<?php
/**
 * Template 404 — Halaman Tidak Ditemukan.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="ukm-site-main ukm-page-404" role="main">
	<div class="ukm-container">
		<div class="ukm-404-wrapper">

			<!-- Ilustrasi 404 -->
			<div class="ukm-404-illustration" aria-hidden="true">
				<svg viewBox="0 0 400 250" xmlns="http://www.w3.org/2000/svg" width="320" height="200">
					<text x="50%" y="55%" text-anchor="middle" dominant-baseline="middle"
						font-size="120" font-weight="700" fill="var(--ukm-color-gray-100)"
						font-family="Inter, sans-serif">404</text>
					<text x="50%" y="82%" text-anchor="middle"
						font-size="18" fill="var(--ukm-color-gray-300)"
						font-family="Inter, sans-serif">Halaman tidak ditemukan</text>
				</svg>
			</div>

			<!-- Pesan -->
			<h1 class="ukm-404-title">
				<?php esc_html_e( 'Ups, halaman ini tidak ada.', 'ukm-toko-theme' ); ?>
			</h1>
			<p class="ukm-404-desc">
				<?php esc_html_e( 'Mungkin halaman sudah dipindah, dihapus, atau URL yang Anda masukkan salah ketik. Coba cari produk atau kembali ke beranda.', 'ukm-toko-theme' ); ?>
			</p>

			<!-- Kotak Pencarian -->
			<form role="search" method="get" class="ukm-404-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<label for="ukm-404-search-input" class="sr-only">
					<?php esc_html_e( 'Cari di situs ini', 'ukm-toko-theme' ); ?>
				</label>
				<input
					type="search"
					id="ukm-404-search-input"
					name="s"
					class="ukm-form-input"
					placeholder="<?php esc_attr_e( 'Cari produk atau artikel...', 'ukm-toko-theme' ); ?>"
				/>
				<button type="submit" class="ukm-btn ukm-btn--primary">
					<?php esc_html_e( 'Cari', 'ukm-toko-theme' ); ?>
				</button>
			</form>

			<!-- Tautan Cepat -->
			<div class="ukm-404-links">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ukm-btn ukm-btn--primary">
					<?php esc_html_e( 'Kembali ke Beranda', 'ukm-toko-theme' ); ?>
				</a>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'produk' ) ?: home_url( '/produk/' ) ); ?>" class="ukm-btn ukm-btn--outline">
					<?php esc_html_e( 'Lihat Produk', 'ukm-toko-theme' ); ?>
				</a>
			</div>

		</div>
	</div>
</main>

<?php get_footer(); ?>
