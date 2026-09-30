<?php
/**
 * Registrasi Custom Gutenberg Blocks.
 *
 * Semua blok menggunakan server-side render via render_callback.
 * Pola ini memungkinkan blok menampilkan data dinamis (produk terbaru,
 * term categories, dll.) tanpa harus rebuild JS saat konten berubah.
 *
 * Editor script menggunakan wp.element.createElement (tanpa JSX/build step)
 * agar bisa dijalankan langsung di browser tanpa transpilasi.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Daftarkan semua blok custom.
 *
 * @since 1.0.0
 */
function ukm_register_blocks() {

	// Daftar blok yang didaftarkan.
	$blocks = array(
		'hero-banner',
		'product-grid',
		'testimonial-slider',
	);

	foreach ( $blocks as $block_name ) {
		$block_dir = UKM_THEME_DIR . 'blocks/' . $block_name;

		if ( ! file_exists( $block_dir . '/block.json' ) ) {
			continue;
		}

		register_block_type(
			$block_dir . '/block.json',
			array(
				'render_callback' => 'ukm_render_block_' . str_replace( '-', '_', $block_name ),
			)
		);
	}
}
add_action( 'init', 'ukm_register_blocks' );

/**
 * Enqueue style dan script blok di editor.
 *
 * @since 1.0.0
 */
function ukm_enqueue_custom_blocks_editor_assets() {

	$blocks = array( 'hero-banner', 'product-grid', 'testimonial-slider' );

	foreach ( $blocks as $block_name ) {
		$editor_js  = UKM_THEME_URI . 'blocks/' . $block_name . '/editor.js';
		$editor_css = UKM_THEME_URI . 'blocks/' . $block_name . '/editor.css';
		$style_css  = UKM_THEME_URI . 'blocks/' . $block_name . '/style.css';

		$editor_js_path  = UKM_THEME_DIR . 'blocks/' . $block_name . '/editor.js';
		$editor_css_path = UKM_THEME_DIR . 'blocks/' . $block_name . '/editor.css';
		$style_css_path  = UKM_THEME_DIR . 'blocks/' . $block_name . '/style.css';

		$handle = 'ukm-block-' . $block_name;

		if ( file_exists( $editor_js_path ) ) {
			wp_enqueue_script(
				$handle . '-editor',
				$editor_js,
				array(
					'wp-blocks',
					'wp-element',
					'wp-editor',
					'wp-components',
					'wp-i18n',
					'wp-block-editor',
					'wp-data',
					'wp-api-fetch',
				),
				UKM_THEME_VERSION,
				true
			);
		}

		if ( file_exists( $editor_css_path ) ) {
			wp_enqueue_style(
				$handle . '-editor-style',
				$editor_css,
				array( 'wp-edit-blocks' ),
				UKM_THEME_VERSION
			);
		}

		if ( file_exists( $style_css_path ) ) {
			wp_enqueue_style(
				$handle . '-style',
				$style_css,
				array(),
				UKM_THEME_VERSION
			);
		}
	}

	// Kirim data PHP ke editor JS.
	wp_localize_script(
		'ukm-block-hero-banner-editor',
		'ukmBlocksData',
		array(
			'themeUri'    => UKM_THEME_URI,
			'restUrl'     => esc_url_raw( rest_url() ),
			'nonce'       => wp_create_nonce( 'wp_rest' ),
			'namaToko'    => esc_html( ukm_get_option( 'ukm_nama_toko', get_bloginfo( 'name' ) ) ),
			'waNomor'     => esc_html( ukm_get_option( 'ukm_whatsapp_toko', '' ) ),
			'colorPrimary' => esc_html( get_theme_mod( 'ukm_color_primary', '#2D6A4F' ) ),
			'i18n'        => array(
				'editLabel'   => esc_html__( 'Klik untuk mengedit', 'ukm-toko-theme' ),
				'noProducts'  => esc_html__( 'Belum ada produk', 'ukm-toko-theme' ),
			),
		)
	);
}
add_action( 'enqueue_block_editor_assets', 'ukm_enqueue_custom_blocks_editor_assets' );

// ============================================================
// Render Callbacks (Server-Side Render)
// ============================================================

/**
 * Render blok Hero Banner.
 *
 * @since  1.0.0
 * @param  array  $attributes Atribut blok.
 * @param  string $content    Konten inner blok.
 * @return string HTML output blok.
 */
function ukm_render_block_hero_banner( $attributes, $content ) {
	$judul        = isset( $attributes['judul'] ) ? $attributes['judul'] : ukm_get_option( 'ukm_nama_toko', get_bloginfo( 'name' ) );
	$subjudul     = isset( $attributes['subjudul'] ) ? $attributes['subjudul'] : get_bloginfo( 'description' );
	$label        = isset( $attributes['label'] ) ? $attributes['label'] : __( 'Belanja Mudah', 'ukm-toko-theme' );
	$cta_label    = isset( $attributes['ctaLabel'] ) ? $attributes['ctaLabel'] : __( 'Lihat Produk', 'ukm-toko-theme' );
	$cta_url      = isset( $attributes['ctaUrl'] ) ? $attributes['ctaUrl'] : get_post_type_archive_link( 'produk' );
	$cta2_label   = isset( $attributes['cta2Label'] ) ? $attributes['cta2Label'] : '';
	$cta2_url     = isset( $attributes['cta2Url'] ) ? $attributes['cta2Url'] : '';
	$bg_image_url = isset( $attributes['bgImageUrl'] ) ? $attributes['bgImageUrl'] : '';
	$alignment    = isset( $attributes['alignment'] ) ? $attributes['alignment'] : 'center';
	$overlay      = isset( $attributes['overlayOpacity'] ) ? (int) $attributes['overlayOpacity'] : 50;

	// Bangun style latar belakang.
	$bg_style = '';
	if ( $bg_image_url ) {
		$overlay_decimal = $overlay / 100;
		$bg_style = sprintf(
			'background-image: linear-gradient(rgba(0,0,0,%s), rgba(0,0,0,%s)), url(%s); background-size: cover; background-position: center;',
			$overlay_decimal,
			$overlay_decimal,
			esc_url( $bg_image_url )
		);
	}

	ob_start();
	?>
	<section
		class="ukm-block-hero ukm-block-hero--align-<?php echo esc_attr( $alignment ); ?> <?php echo $bg_image_url ? 'ukm-block-hero--has-image' : 'ukm-block-hero--no-image'; ?>"
		style="<?php echo esc_attr( $bg_style ); ?>"
		aria-label="<?php esc_attr_e( 'Seksi hero', 'ukm-toko-theme' ); ?>"
	>
		<div class="ukm-container">
			<div class="ukm-block-hero__content">
				<?php if ( $label ) : ?>
					<span class="ukm-block-hero__label"><?php echo esc_html( $label ); ?></span>
				<?php endif; ?>

				<h1 class="ukm-block-hero__title">
					<?php
					// Warna aksen pada kata pertama.
					$kata_judul = explode( ' ', esc_html( $judul ), 2 );
					echo '<span>' . esc_html( $kata_judul[0] ) . '</span>';
					if ( isset( $kata_judul[1] ) ) {
						echo ' ' . esc_html( $kata_judul[1] );
					}
					?>
				</h1>

				<?php if ( $subjudul ) : ?>
					<p class="ukm-block-hero__subtitle"><?php echo esc_html( $subjudul ); ?></p>
				<?php endif; ?>

				<div class="ukm-block-hero__cta">
					<?php if ( $cta_label && $cta_url ) : ?>
						<a href="<?php echo esc_url( $cta_url ); ?>" class="ukm-btn ukm-btn--primary ukm-btn--lg">
							<?php echo esc_html( $cta_label ); ?>
						</a>
					<?php endif; ?>

					<?php if ( $cta2_label && $cta2_url ) : ?>
						<a href="<?php echo esc_url( $cta2_url ); ?>" class="ukm-btn ukm-btn--outline ukm-btn--lg <?php echo $bg_image_url ? 'ukm-btn--outline-white' : ''; ?>">
							<?php echo esc_html( $cta2_label ); ?>
						</a>
					<?php elseif ( ! $cta2_label ) :
						// CTA 2 default: tombol WhatsApp.
						$wa = ukm_get_option( 'ukm_whatsapp_toko', '' );
						if ( $wa ) :
					?>
						<a href="https://wa.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $wa ) ); ?>"
						   class="ukm-btn ukm-btn--outline ukm-btn--lg <?php echo $bg_image_url ? 'ukm-btn--outline-white' : ''; ?>"
						   target="_blank" rel="noopener noreferrer">
							<?php esc_html_e( 'Hubungi Kami', 'ukm-toko-theme' ); ?>
						</a>
					<?php
						endif;
					endif;
					?>
				</div>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

/**
 * Render blok Product Grid.
 *
 * @since  1.0.0
 * @param  array  $attributes Atribut blok.
 * @param  string $content    Konten inner blok.
 * @return string HTML output blok.
 */
function ukm_render_block_product_grid( $attributes, $content ) {
	$judul         = isset( $attributes['judul'] ) ? $attributes['judul'] : __( 'Produk Tersedia', 'ukm-toko-theme' );
	$label         = isset( $attributes['label'] ) ? $attributes['label'] : __( 'Katalog', 'ukm-toko-theme' );
	$deskripsi     = isset( $attributes['deskripsi'] ) ? $attributes['deskripsi'] : '';
	$jumlah        = isset( $attributes['jumlah'] ) ? (int) $attributes['jumlah'] : 8;
	$kategori_slug = isset( $attributes['kategoriSlug'] ) ? $attributes['kategoriSlug'] : '';
	$kolom         = isset( $attributes['kolom'] ) ? (int) $attributes['kolom'] : 4;
	$tampil_lihat  = isset( $attributes['tampilTombolLihatSemua'] ) ? (bool) $attributes['tampilTombolLihatSemua'] : true;
	$tampil_filter = isset( $attributes['tampilFilter'] ) ? (bool) $attributes['tampilFilter'] : false;

	// Query produk.
	$query_args = array(
		'post_type'      => 'produk',
		'posts_per_page' => max( 1, min( 24, $jumlah ) ),
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
		'no_found_rows'  => true,
	);

	if ( $kategori_slug ) {
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'kategori-produk',
				'field'    => 'slug',
				'terms'    => sanitize_text_field( $kategori_slug ),
			),
		);
	}

	$query = new WP_Query( $query_args );

	$archive_url = get_post_type_archive_link( 'produk' ) ?: home_url( '/produk/' );

	ob_start();
	?>
	<section class="ukm-block-product-grid ukm-section">
		<div class="ukm-container">

			<div class="ukm-section-heading">
				<?php if ( $label ) : ?>
					<span class="ukm-section-heading__label"><?php echo esc_html( $label ); ?></span>
				<?php endif; ?>
				<h2 class="ukm-section-heading__title"><?php echo esc_html( $judul ); ?></h2>
				<?php if ( $deskripsi ) : ?>
					<p class="ukm-section-heading__desc"><?php echo esc_html( $deskripsi ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( $tampil_filter ) : ?>
				<nav class="ukm-category-filter" aria-label="<?php esc_attr_e( 'Filter Kategori', 'ukm-toko-theme' ); ?>">
					<a href="<?php echo esc_url( $archive_url ); ?>" class="ukm-category-filter__item is-active">
						<?php esc_html_e( 'Semua', 'ukm-toko-theme' ); ?>
					</a>
					<?php
					$terms = get_terms( array( 'taxonomy' => 'kategori-produk', 'hide_empty' => true ) );
					if ( $terms && ! is_wp_error( $terms ) ) :
						foreach ( $terms as $term ) :
					?>
						<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="ukm-category-filter__item">
							<?php echo esc_html( $term->name ); ?>
						</a>
					<?php
						endforeach;
					endif;
					?>
				</nav>
			<?php endif; ?>

			<?php if ( $query->have_posts() ) : ?>
				<div class="ukm-product-grid ukm-product-grid--col-<?php echo esc_attr( $kolom ); ?>">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						get_template_part( 'template-parts/content', 'produk' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>

				<?php if ( $tampil_lihat ) : ?>
					<div style="text-align:center;margin-top:var(--ukm-space-10)">
						<a href="<?php echo esc_url( $archive_url ); ?>" class="ukm-btn ukm-btn--outline">
							<?php esc_html_e( 'Lihat Semua Produk', 'ukm-toko-theme' ); ?>
						</a>
					</div>
				<?php endif; ?>

			<?php else : ?>
				<p style="text-align:center;color:var(--ukm-color-gray-500);padding:var(--ukm-space-12) 0">
					<?php esc_html_e( 'Belum ada produk yang tersedia.', 'ukm-toko-theme' ); ?>
				</p>
			<?php endif; ?>

		</div>
	</section>
	<?php
	return ob_get_clean();
}

/**
 * Render blok Testimonial Slider.
 *
 * @since  1.0.0
 * @param  array  $attributes Atribut blok.
 * @param  string $content    Konten inner blok.
 * @return string HTML output blok.
 */
function ukm_render_block_testimonial_slider( $attributes, $content ) {
	$judul       = isset( $attributes['judul'] ) ? $attributes['judul'] : __( 'Kata Pelanggan', 'ukm-toko-theme' );
	$label       = isset( $attributes['label'] ) ? $attributes['label'] : __( 'Testimoni', 'ukm-toko-theme' );
	$deskripsi   = isset( $attributes['deskripsi'] ) ? $attributes['deskripsi'] : '';
	$testimoni   = isset( $attributes['testimoni'] ) ? $attributes['testimoni'] : array();
	$autoplay    = isset( $attributes['autoplay'] ) ? (bool) $attributes['autoplay'] : true;
	$delay       = isset( $attributes['delayDetik'] ) ? (int) $attributes['delayDetik'] : 5;

	// Testimoni default jika kosong.
	if ( empty( $testimoni ) ) {
		$testimoni = array(
			array(
				'nama'     => 'Bu Sari',
				'peran'    => 'Pelanggan Setia',
				'ulasan'   => 'Belanja di sini sangat mudah dan harganya terjangkau. Barang selalu fresh dan pengiriman cepat. Sangat direkomendasikan!',
				'bintang'  => 5,
				'inisial'  => 'BS',
			),
			array(
				'nama'     => 'Pak Bambang',
				'peran'    => 'Pemilik Warung',
				'ulasan'   => 'Saya sudah langganan kulakan di sini sejak 2 tahun. Stok lengkap, harga grosir, dan pelayanan ramah.',
				'bintang'  => 5,
				'inisial'  => 'PB',
			),
			array(
				'nama'     => 'Ibu Dewi',
				'peran'    => 'Ibu Rumah Tangga',
				'ulasan'   => 'Kualitas produk bagus sekali, terutama berasnya. Harga wajar dan bisa pesan via WhatsApp, sangat praktis!',
				'bintang'  => 5,
				'inisial'  => 'ID',
			),
		);
	}

	$block_id = 'ukm-testimonial-' . wp_unique_id();

	ob_start();
	?>
	<section class="ukm-block-testimonial ukm-section" id="<?php echo esc_attr( $block_id ); ?>">
		<div class="ukm-container">

			<div class="ukm-section-heading">
				<?php if ( $label ) : ?>
					<span class="ukm-section-heading__label"><?php echo esc_html( $label ); ?></span>
				<?php endif; ?>
				<h2 class="ukm-section-heading__title"><?php echo esc_html( $judul ); ?></h2>
				<?php if ( $deskripsi ) : ?>
					<p class="ukm-section-heading__desc"><?php echo esc_html( $deskripsi ); ?></p>
				<?php endif; ?>
			</div>

			<!-- Slider Testimoni -->
			<div class="ukm-testimonial-slider"
				data-autoplay="<?php echo $autoplay ? 'true' : 'false'; ?>"
				data-delay="<?php echo esc_attr( $delay * 1000 ); ?>"
				role="region"
				aria-label="<?php esc_attr_e( 'Testimoni pelanggan', 'ukm-toko-theme' ); ?>"
				aria-roledescription="carousel"
			>
				<!-- Track (slides) -->
				<div class="ukm-testimonial-slider__track" aria-live="polite">
					<?php foreach ( $testimoni as $index => $item ) : ?>
						<div
							class="ukm-testimonial-card <?php echo 0 === $index ? 'is-active' : ''; ?>"
							role="group"
							aria-roledescription="slide"
							aria-label="<?php echo esc_attr( sprintf( __( 'Slide %d dari %d', 'ukm-toko-theme' ), $index + 1, count( $testimoni ) ) ); ?>"
							aria-hidden="<?php echo 0 === $index ? 'false' : 'true'; ?>"
						>
							<!-- Bintang -->
							<div class="ukm-testimonial-card__stars" aria-label="<?php echo esc_attr( sprintf( __( '%d dari 5 bintang', 'ukm-toko-theme' ), isset( $item['bintang'] ) ? (int) $item['bintang'] : 5 ) ); ?>">
								<?php
								$bintang = isset( $item['bintang'] ) ? min( 5, max( 1, (int) $item['bintang'] ) ) : 5;
								for ( $i = 1; $i <= 5; $i++ ) :
								?>
									<svg class="ukm-star <?php echo $i <= $bintang ? 'ukm-star--filled' : 'ukm-star--empty'; ?>"
										width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
										<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
									</svg>
								<?php endfor; ?>
							</div>

							<!-- Ulasan -->
							<blockquote class="ukm-testimonial-card__quote">
								<p class="ukm-testimonial-card__text">
									"<?php echo esc_html( isset( $item['ulasan'] ) ? $item['ulasan'] : '' ); ?>"
								</p>
							</blockquote>

							<!-- Profil -->
							<footer class="ukm-testimonial-card__profile">
								<div class="ukm-testimonial-card__avatar" aria-hidden="true">
									<?php
									if ( ! empty( $item['fotoUrl'] ) ) :
									?>
										<img src="<?php echo esc_url( $item['fotoUrl'] ); ?>" alt="<?php echo esc_attr( isset( $item['nama'] ) ? $item['nama'] : '' ); ?>" loading="lazy" width="48" height="48" />
									<?php else : ?>
										<span><?php echo esc_html( isset( $item['inisial'] ) ? strtoupper( substr( $item['inisial'], 0, 2 ) ) : 'US' ); ?></span>
									<?php endif; ?>
								</div>
								<div class="ukm-testimonial-card__info">
									<strong class="ukm-testimonial-card__name"><?php echo esc_html( isset( $item['nama'] ) ? $item['nama'] : '' ); ?></strong>
									<span class="ukm-testimonial-card__role"><?php echo esc_html( isset( $item['peran'] ) ? $item['peran'] : '' ); ?></span>
								</div>
							</footer>
						</div>
					<?php endforeach; ?>
				</div>

				<!-- Kontrol Slider -->
				<?php if ( count( $testimoni ) > 1 ) : ?>
					<div class="ukm-testimonial-slider__controls">
						<!-- Tombol Prev -->
						<button
							class="ukm-testimonial-slider__btn ukm-testimonial-slider__btn--prev"
							aria-label="<?php esc_attr_e( 'Slide sebelumnya', 'ukm-toko-theme' ); ?>"
						>
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
								<path d="M15 18l-6-6 6-6"/>
							</svg>
						</button>

						<!-- Indikator Dots -->
						<div class="ukm-testimonial-slider__dots" role="tablist" aria-label="<?php esc_attr_e( 'Slide', 'ukm-toko-theme' ); ?>">
							<?php foreach ( $testimoni as $index => $item ) : ?>
								<button
									class="ukm-testimonial-slider__dot <?php echo 0 === $index ? 'is-active' : ''; ?>"
									role="tab"
									aria-label="<?php echo esc_attr( sprintf( __( 'Slide %d', 'ukm-toko-theme' ), $index + 1 ) ); ?>"
									aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>"
									data-slide="<?php echo esc_attr( $index ); ?>"
								></button>
							<?php endforeach; ?>
						</div>

						<!-- Tombol Next -->
						<button
							class="ukm-testimonial-slider__btn ukm-testimonial-slider__btn--next"
							aria-label="<?php esc_attr_e( 'Slide berikutnya', 'ukm-toko-theme' ); ?>"
						>
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
								<path d="M9 18l6-6-6-6"/>
							</svg>
						</button>
					</div>
				<?php endif; ?>

			</div>
			<!-- /Slider Testimoni -->

		</div>
	</section>

	<?php
	// Enqueue slider JS hanya jika ada lebih dari 1 testimoni.
	if ( count( $testimoni ) > 1 ) :
		wp_enqueue_script(
			'ukm-block-testimonial-slider-frontend',
			UKM_THEME_URI . 'blocks/testimonial-slider/frontend.js',
			array(),
			UKM_THEME_VERSION,
			true
		);
	endif;

	return ob_get_clean();
}
