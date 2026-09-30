<?php
/**
 * Template Arsip CPT Produk (archive-produk.php).
 *
 * Menampilkan daftar produk dengan filter kategori, pagination,
 * dan sidebar toko opsional.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="ukm-site-main ukm-archive-produk" role="main">
	<div class="ukm-container">

		<!-- Breadcrumb -->
		<?php ukm_breadcrumb(); ?>

		<!-- Header Arsip -->
		<header class="ukm-archive-header">
			<h1 class="ukm-archive-title">
				<?php
				if ( is_tax( 'kategori-produk' ) ) {
					single_term_title();
				} else {
					esc_html_e( 'Katalog Produk', 'ukm-toko-theme' );
				}
				?>
			</h1>
			<?php
			if ( is_tax( 'kategori-produk' ) ) {
				$term_desc = term_description();
				if ( $term_desc ) {
					echo '<p class="ukm-archive-desc">' . wp_kses_post( $term_desc ) . '</p>';
				}
			} else {
				echo '<p class="ukm-archive-desc">' . esc_html__( 'Temukan berbagai produk sembako dan kebutuhan rumah tangga berkualitas.', 'ukm-toko-theme' ) . '</p>';
			}
			?>
		</header>

		<!-- Filter Kategori -->
		<nav class="ukm-category-filter" aria-label="<?php esc_attr_e( 'Filter Kategori Produk', 'ukm-toko-theme' ); ?>">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'produk' ) ); ?>"
			   class="ukm-category-filter__item <?php echo ! is_tax() ? 'is-active' : ''; ?>">
				<?php esc_html_e( 'Semua', 'ukm-toko-theme' ); ?>
			</a>
			<?php
			$kategori_list = get_terms(
				array(
					'taxonomy'   => 'kategori-produk',
					'hide_empty' => true,
				)
			);

			if ( $kategori_list && ! is_wp_error( $kategori_list ) ) {
				foreach ( $kategori_list as $term ) {
					$is_active = is_tax( 'kategori-produk', $term->slug );
					printf(
						'<a href="%s" class="ukm-category-filter__item %s">%s <span class="ukm-category-filter__count">(%d)</span></a>',
						esc_url( get_term_link( $term ) ),
						$is_active ? 'is-active' : '',
						esc_html( $term->name ),
						absint( $term->count )
					);
				}
			}
			?>
		</nav>

		<!-- Layout: Grid Produk -->
		<div class="ukm-layout-archive">

			<!-- Grid Produk -->
			<div class="ukm-archive-main">
				<?php if ( have_posts() ) : ?>

					<!-- Jumlah produk -->
					<p class="ukm-archive-count" style="color:var(--ukm-color-gray-500);font-size:var(--ukm-font-size-sm);margin-bottom:var(--ukm-space-6)">
						<?php
						global $wp_query;
						printf(
							/* translators: %d jumlah produk ditemukan. */
							esc_html( _n( 'Menampilkan %d produk', 'Menampilkan %d produk', $wp_query->found_posts, 'ukm-toko-theme' ) ),
							absint( $wp_query->found_posts )
						);
						?>
					</p>

					<div class="ukm-product-grid">
						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content', 'produk' );
						endwhile;
						?>
					</div>

					<!-- Pagination -->
					<?php ukm_pagination(); ?>

				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'none' ); ?>
				<?php endif; ?>
			</div>
			<!-- /Grid Produk -->

			<!-- Sidebar Toko (opsional) -->
			<?php if ( is_active_sidebar( 'ukm-sidebar-shop' ) ) : ?>
				<aside class="ukm-archive-sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Sidebar Toko', 'ukm-toko-theme' ); ?>">
					<?php dynamic_sidebar( 'ukm-sidebar-shop' ); ?>
				</aside>
			<?php endif; ?>

		</div>
		<!-- /Layout -->

	</div>
</main>

<?php get_footer(); ?>
