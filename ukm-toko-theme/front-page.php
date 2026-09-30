<?php
/**
 * Template Halaman Depan (front-page.php).
 *
 * Digunakan saat "Halaman Depan" diatur ke halaman statis
 * maupun saat diset ke "Postingan Terbaru" — WordPress otomatis
 * memprioritaskan file ini.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="ukm-site-main ukm-front-page" role="main">

	<?php
	/**
	 * Jika halaman ini adalah halaman statis dengan konten blok Gutenberg,
	 * tampilkan konten halaman tersebut (termasuk blok custom Hero Banner,
	 * Product Grid, Testimonial Slider yang sudah didaftarkan).
	 */
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'ukm-front-page-content' ); ?>>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
			<?php
		endwhile;
	else :
		/**
		 * Fallback: jika belum ada konten halaman, tampilkan seksi default.
		 * Ini berguna saat tema baru diaktifkan dan belum ada blok yang ditambahkan.
		 */
		?>

		<!-- SEKSI HERO FALLBACK -->
		<section class="ukm-hero-fallback ukm-section--lg" style="background:var(--ukm-color-gray-50);text-align:center;padding:80px 24px">
			<div class="ukm-container">
				<p class="ukm-section-heading__label"><?php esc_html_e( 'Selamat Datang', 'ukm-toko-theme' ); ?></p>
				<h1><?php echo esc_html( ukm_get_option( 'ukm_nama_toko', get_bloginfo( 'name' ) ) ); ?></h1>
				<p style="max-width:52ch;margin:16px auto 32px;color:var(--ukm-color-gray-500)">
					<?php echo esc_html( get_bloginfo( 'description' ) ?: __( 'Menyediakan kebutuhan sembako berkualitas dengan harga terjangkau.', 'ukm-toko-theme' ) ); ?>
				</p>
				<div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'produk' ) ?: home_url( '/produk/' ) ); ?>" class="ukm-btn ukm-btn--primary ukm-btn--lg">
						<?php esc_html_e( 'Lihat Produk', 'ukm-toko-theme' ); ?>
					</a>
					<?php
					$wa_nomor = ukm_get_option( 'ukm_whatsapp_toko', '' );
					if ( $wa_nomor ) :
					?>
						<a href="https://wa.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $wa_nomor ) ); ?>" class="ukm-btn ukm-btn--secondary ukm-btn--lg" target="_blank" rel="noopener noreferrer">
							<?php esc_html_e( 'Hubungi Kami', 'ukm-toko-theme' ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<!-- SEKSI PRODUK TERBARU FALLBACK -->
		<section class="ukm-section">
			<div class="ukm-container">
				<div class="ukm-section-heading">
					<span class="ukm-section-heading__label"><?php esc_html_e( 'Katalog', 'ukm-toko-theme' ); ?></span>
					<h2 class="ukm-section-heading__title"><?php esc_html_e( 'Produk Tersedia', 'ukm-toko-theme' ); ?></h2>
					<p class="ukm-section-heading__desc">
						<?php esc_html_e( 'Pilih dari berbagai produk sembako dan kebutuhan sehari-hari.', 'ukm-toko-theme' ); ?>
					</p>
				</div>

				<?php
				// Query produk terbaru dari CPT 'produk'.
				$produk_args = array(
					'post_type'      => 'produk',
					'posts_per_page' => 8,
					'post_status'    => 'publish',
					'orderby'        => 'date',
					'order'          => 'DESC',
					'no_found_rows'  => true, // Optimalkan query — tidak butuh pagination di sini.
				);

				$produk_query = new WP_Query( $produk_args );

				if ( $produk_query->have_posts() ) :
				?>
					<div class="ukm-product-grid">
						<?php
						while ( $produk_query->have_posts() ) :
							$produk_query->the_post();
							get_template_part( 'template-parts/content', 'produk' );
						endwhile;
						wp_reset_postdata();
						?>
					</div>

					<div style="text-align:center;margin-top:40px">
						<a href="<?php echo esc_url( get_post_type_archive_link( 'produk' ) ?: home_url( '/produk/' ) ); ?>" class="ukm-btn ukm-btn--outline">
							<?php esc_html_e( 'Lihat Semua Produk', 'ukm-toko-theme' ); ?>
						</a>
					</div>
				<?php
				else :
					echo '<p style="text-align:center;color:var(--ukm-color-gray-500)">' . esc_html__( 'Belum ada produk yang tersedia.', 'ukm-toko-theme' ) . '</p>';
				endif;
				?>
			</div>
		</section>

	<?php endif; ?>

</main>

<?php get_footer(); ?>
