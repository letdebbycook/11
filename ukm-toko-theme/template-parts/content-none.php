<?php
/**
 * Template Part: Tidak ada konten ditemukan.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */
?>
<div class="ukm-no-results">
	<svg class="ukm-no-results__icon" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
		<circle cx="11" cy="11" r="8"></circle>
		<path d="m21 21-4.35-4.35"></path>
		<path d="M8 11h6M11 8v6"></path>
	</svg>

	<?php if ( is_search() ) : ?>
		<h2 class="ukm-no-results__title">
			<?php
			printf(
				/* translators: %s istilah pencarian. */
				esc_html__( 'Tidak ada hasil untuk "%s"', 'ukm-toko-theme' ),
				'<em>' . esc_html( get_search_query() ) . '</em>'
			);
			?>
		</h2>
		<p class="ukm-no-results__desc">
			<?php esc_html_e( 'Coba kata kunci yang berbeda, atau gunakan kata yang lebih umum.', 'ukm-toko-theme' ); ?>
		</p>
		<form role="search" method="get" class="ukm-search-form-inline" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Coba kata kunci lain...', 'ukm-toko-theme' ); ?>" class="ukm-form-input" />
			<button type="submit" class="ukm-btn ukm-btn--primary"><?php esc_html_e( 'Cari', 'ukm-toko-theme' ); ?></button>
		</form>
	<?php else : ?>
		<h2 class="ukm-no-results__title"><?php esc_html_e( 'Belum ada konten', 'ukm-toko-theme' ); ?></h2>
		<p class="ukm-no-results__desc"><?php esc_html_e( 'Halaman ini belum memiliki konten yang tersedia.', 'ukm-toko-theme' ); ?></p>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ukm-btn ukm-btn--primary">
			<?php esc_html_e( 'Kembali ke Beranda', 'ukm-toko-theme' ); ?>
		</a>
	<?php endif; ?>
</div>
