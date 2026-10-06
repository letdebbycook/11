<?php
/**
 * Template Halaman Depan (front-page.php).
 * Layout Barter: Hero full-width + Services strip + Product Grid + Testimonials.
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
	 * tampilkan konten halaman tersebut.
	 */
	$has_custom_page_content = false;

	if ( is_page() && have_posts() ) :
		while ( have_posts() ) :
			the_post();
			if ( ! empty( trim( get_the_content() ) ) ) :
				$has_custom_page_content = true;
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'ukm-front-page-content' ); ?>>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</article>
				<?php
			endif;
		endwhile;
	endif;

	if ( ! $has_custom_page_content ) :
		// Fallback layout bergaya Barter — penuh, rapi, siap pakai
		$nama_toko  = ukm_get_option( 'ukm_nama_toko', get_bloginfo( 'name' ) );
		$wa_nomor   = ukm_get_option( 'ukm_whatsapp_toko', '' );
		$alamat     = ukm_get_option( 'ukm_alamat_toko', '' );
	?>

	<!-- ============================================================ -->
	<!-- HERO SECTION — Full width, teks kiri + gambar kanan          -->
	<!-- ============================================================ -->
	<section class="ukm-hero" aria-label="<?php esc_attr_e( 'Selamat datang', 'ukm-toko-theme' ); ?>">
		<div class="ukm-hero__inner">
			<div class="ukm-hero__content">
				<p class="ukm-hero__eyebrow"><?php esc_html_e( 'Toko Sembako Terpercaya', 'ukm-toko-theme' ); ?></p>
				<h1 class="ukm-hero__title">
					<?php
					printf(
						/* translators: %s: nama toko */
						esc_html__( 'Belanja Kebutuhan Pokok di %s', 'ukm-toko-theme' ),
						'<span class="ukm-hero__title-highlight">' . esc_html( $nama_toko ) . '</span>'
					);
					?>
				</h1>
				<p class="ukm-hero__desc">
					<?php echo esc_html( get_bloginfo( 'description' ) ?: __( 'Menyediakan sembako berkualitas dengan harga terjangkau untuk kebutuhan sehari-hari masyarakat sekitar.', 'ukm-toko-theme' ) ); ?>
				</p>
				<div class="ukm-hero__actions">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'produk' ) ?: home_url( '/produk/' ) ); ?>" class="ukm-btn ukm-btn--primary ukm-btn--lg">
						<?php esc_html_e( 'Lihat Katalog', 'ukm-toko-theme' ); ?>
					</a>
					<?php if ( $wa_nomor ) : ?>
						<a
							href="https://wa.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $wa_nomor ) ); ?>"
							class="ukm-btn ukm-btn--outline-white ukm-btn--lg"
							target="_blank"
							rel="noopener noreferrer"
						>
							<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
							<?php esc_html_e( 'WhatsApp', 'ukm-toko-theme' ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>

			<div class="ukm-hero__visual">
				<div class="ukm-hero__image-wrap">
					<?php
					// Cek apakah ada gambar hero dari customizer
					$hero_img_id = get_theme_mod( 'ukm_hero_image', 0 );
					if ( $hero_img_id ) :
						echo wp_get_attachment_image( $hero_img_id, 'large', false, array(
							'class'   => 'ukm-hero__image',
							'loading' => 'eager',
							'alt'     => esc_attr( $nama_toko ),
						) );
					else :
					?>
						<div class="ukm-hero__image-placeholder">
							<svg viewBox="0 0 480 320" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
								<rect width="480" height="320" fill="#D1FAE5"/>
								<rect x="60" y="60" width="360" height="200" rx="16" fill="#A7F3D0"/>
								<rect x="140" y="100" width="200" height="120" rx="8" fill="#6EE7B7"/>
								<!-- Ikon keranjang belanja -->
								<path d="M200 145 L220 145 L230 175 L270 175 L280 145 L300 145" stroke="#065F46" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
								<circle cx="238" cy="185" r="6" fill="#065F46"/>
								<circle cx="268" cy="185" r="6" fill="#065F46"/>
								<path d="M200 145 L190 125" stroke="#065F46" stroke-width="6" stroke-linecap="round"/>
								<path d="M190 120 L170 120" stroke="#065F46" stroke-width="6" stroke-linecap="round"/>
								<!-- Teks -->
								<text x="240" y="225" text-anchor="middle" font-family="sans-serif" font-size="14" fill="#065F46" font-weight="600"><?php echo esc_html( $nama_toko ); ?></text>
							</svg>
						</div>
					<?php endif; ?>
				</div>

				<!-- Floating badge -->
				<div class="ukm-hero__badge">
					<div class="ukm-hero__badge-icon">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
							<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
						</svg>
					</div>
					<div>
						<div class="ukm-hero__badge-title"><?php esc_html_e( 'Terpercaya', 'ukm-toko-theme' ); ?></div>
						<div class="ukm-hero__badge-desc"><?php esc_html_e( 'Kualitas Terjamin', 'ukm-toko-theme' ); ?></div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- /HERO -->

	<!-- ============================================================ -->
	<!-- SERVICES STRIP — 4 keunggulan seperti barter feature strip   -->
	<!-- ============================================================ -->
	<section class="ukm-services-strip">
		<div class="ukm-container">
			<div class="ukm-services-grid">
				<div class="ukm-service-item">
					<div class="ukm-service-icon">
						<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
					</div>
					<div class="ukm-service-text">
						<h3 class="ukm-service-title"><?php esc_html_e( 'Pengiriman Cepat', 'ukm-toko-theme' ); ?></h3>
						<p class="ukm-service-desc"><?php esc_html_e( 'Antar ke rumah Anda', 'ukm-toko-theme' ); ?></p>
					</div>
				</div>
				<div class="ukm-service-item">
					<div class="ukm-service-icon">
						<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg>
					</div>
					<div class="ukm-service-text">
						<h3 class="ukm-service-title"><?php esc_html_e( 'Produk Pilihan', 'ukm-toko-theme' ); ?></h3>
						<p class="ukm-service-desc"><?php esc_html_e( 'Kualitas terbaik untukmu', 'ukm-toko-theme' ); ?></p>
					</div>
				</div>
				<div class="ukm-service-item">
					<div class="ukm-service-icon">
						<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
					</div>
					<div class="ukm-service-text">
						<h3 class="ukm-service-title"><?php esc_html_e( 'Transaksi Aman', 'ukm-toko-theme' ); ?></h3>
						<p class="ukm-service-desc"><?php esc_html_e( 'Pembayaran terjamin', 'ukm-toko-theme' ); ?></p>
					</div>
				</div>
				<div class="ukm-service-item">
					<div class="ukm-service-icon">
						<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.52"/></svg>
					</div>
					<div class="ukm-service-text">
						<h3 class="ukm-service-title"><?php esc_html_e( 'Mudah Dikembalikan', 'ukm-toko-theme' ); ?></h3>
						<p class="ukm-service-desc"><?php esc_html_e( 'Garansi kepuasan pelanggan', 'ukm-toko-theme' ); ?></p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- /SERVICES STRIP -->

	<!-- ============================================================ -->
	<!-- KATEGORI PRODUK                                               -->
	<!-- ============================================================ -->
	<?php
	$kategori_list = get_terms( array(
		'taxonomy'   => 'kategori-produk',
		'hide_empty' => true,
		'number'     => 6,
	) );

	if ( $kategori_list && ! is_wp_error( $kategori_list ) ) :
	?>
	<section class="ukm-section ukm-categories-section">
		<div class="ukm-container">
			<div class="ukm-section-head">
				<span class="ukm-section-eyebrow"><?php esc_html_e( 'Jelajahi', 'ukm-toko-theme' ); ?></span>
				<h2 class="ukm-section-title"><?php esc_html_e( 'Kategori Produk', 'ukm-toko-theme' ); ?></h2>
			</div>
			<div class="ukm-categories-grid">
				<?php foreach ( $kategori_list as $term ) : ?>
					<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="ukm-category-card">
						<div class="ukm-category-card__icon">
							<?php
							// Coba ambil gambar term (jika ada plugin seperti ACF atau term-meta)
							$term_icon = get_term_meta( $term->term_id, 'ukm_category_icon', true );
							if ( $term_icon ) :
								echo '<img src="' . esc_url( $term_icon ) . '" alt="' . esc_attr( $term->name ) . '" width="48" height="48" loading="lazy">';
							else :
							?>
								<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
									<path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
									<line x1="3" y1="6" x2="21" y2="6"/>
									<path d="M16 10a4 4 0 01-8 0"/>
								</svg>
							<?php endif; ?>
						</div>
						<span class="ukm-category-card__name"><?php echo esc_html( $term->name ); ?></span>
						<span class="ukm-category-card__count"><?php printf( esc_html__( '%d produk', 'ukm-toko-theme' ), absint( $term->count ) ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>
	<!-- /KATEGORI -->

	<!-- ============================================================ -->
	<!-- PRODUK TERBARU / UNGGULAN                                     -->
	<!-- ============================================================ -->
	<section class="ukm-section ukm-products-section">
		<div class="ukm-container">
			<div class="ukm-section-head">
				<span class="ukm-section-eyebrow"><?php esc_html_e( 'Katalog', 'ukm-toko-theme' ); ?></span>
				<h2 class="ukm-section-title"><?php esc_html_e( 'Produk Tersedia', 'ukm-toko-theme' ); ?></h2>
				<p class="ukm-section-desc">
					<?php esc_html_e( 'Pilih dari berbagai produk sembako dan kebutuhan sehari-hari dengan harga terjangkau.', 'ukm-toko-theme' ); ?>
				</p>
			</div>

			<?php
			$produk_args = array(
				'post_type'      => 'produk',
				'posts_per_page' => 8,
				'post_status'    => 'publish',
				'orderby'        => 'date',
				'order'          => 'DESC',
				'no_found_rows'  => true,
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

				<div class="ukm-section-cta">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'produk' ) ?: home_url( '/produk/' ) ); ?>" class="ukm-btn ukm-btn--outline">
						<?php esc_html_e( 'Lihat Semua Produk', 'ukm-toko-theme' ); ?>
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
					</a>
				</div>

			<?php else : ?>
				<div class="ukm-empty-state">
					<svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
					<h3><?php esc_html_e( 'Produk segera hadir', 'ukm-toko-theme' ); ?></h3>
					<p><?php esc_html_e( 'Belum ada produk yang ditambahkan. Silakan kembali lagi nanti.', 'ukm-toko-theme' ); ?></p>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<!-- /PRODUK -->

	<!-- ============================================================ -->
	<!-- CTA WHATSAPP                                                  -->
	<!-- ============================================================ -->
	<?php if ( $wa_nomor || $alamat ) : ?>
	<section class="ukm-section ukm-cta-section">
		<div class="ukm-container">
			<div class="ukm-cta-box">
				<div class="ukm-cta-box__content">
					<h2 class="ukm-cta-box__title"><?php esc_html_e( 'Ada yang ingin ditanyakan?', 'ukm-toko-theme' ); ?></h2>
					<p class="ukm-cta-box__desc">
						<?php
						if ( $alamat ) {
							printf(
								/* translators: %s: alamat toko */
								esc_html__( 'Kunjungi kami di %s atau hubungi langsung via WhatsApp.', 'ukm-toko-theme' ),
								esc_html( $alamat )
							);
						} else {
							esc_html_e( 'Hubungi kami langsung via WhatsApp untuk pertanyaan produk dan pemesanan.', 'ukm-toko-theme' );
						}
						?>
					</p>
				</div>
				<?php if ( $wa_nomor ) : ?>
					<a
						href="https://wa.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $wa_nomor ) ); ?>?text=<?php echo rawurlencode( __( 'Halo, saya ingin bertanya tentang produk.', 'ukm-toko-theme' ) ); ?>"
						class="ukm-btn ukm-btn--primary ukm-btn--lg"
						target="_blank"
						rel="noopener noreferrer"
					>
						<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
						<?php esc_html_e( 'Hubungi via WhatsApp', 'ukm-toko-theme' ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>
	<!-- /CTA -->

	<?php endif; // end if ! $has_custom_page_content ?>

</main>

<?php get_footer(); ?>
