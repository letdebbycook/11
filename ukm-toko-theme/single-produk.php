<?php
/**
 * Template Single CPT Produk (single-produk.php).
 *
 * Menampilkan detail produk: gambar, harga, stok, varian,
 * deskripsi, dan produk terkait.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="ukm-site-main ukm-single-produk" role="main">
	<div class="ukm-container">

		<?php
		while ( have_posts() ) :
			the_post();

			$post_id       = get_the_ID();
			$harga         = ukm_get_produk_field( '_ukm_harga', $post_id );
			$harga_modal   = ukm_get_produk_field( '_ukm_harga_modal', $post_id );
			$stok          = ukm_get_produk_field( '_ukm_stok', $post_id, 0 );
			$satuan        = ukm_get_produk_field( '_ukm_satuan', $post_id, 'pcs' );
			$berat         = ukm_get_produk_field( '_ukm_berat', $post_id );
			$sku           = ukm_get_produk_field( '_ukm_sku', $post_id );
			$status        = ukm_get_produk_field( '_ukm_status_produk', $post_id, 'tersedia' );
			$wa_pesan      = ukm_get_produk_field( '_ukm_wa_pesan', $post_id ) ?: ukm_get_option( 'ukm_whatsapp_toko', '' );
			$varian        = get_post_meta( $post_id, '_ukm_varian_produk', true );
			$terms         = get_the_terms( $post_id, 'kategori-produk' );
		?>

		<!-- Breadcrumb -->
		<?php ukm_breadcrumb(); ?>

		<!-- Layout Detail Produk -->
		<div class="ukm-produk-detail">

			<!-- Kolom Gambar -->
			<div class="ukm-produk-gallery">
				<?php
				if ( has_post_thumbnail() ) {
					// Gambar utama — ini adalah elemen LCP, jadi $is_lcp = true.
					echo '<div class="ukm-produk-gallery__main">';
					echo get_the_post_thumbnail(
						$post_id,
						'ukm-product-featured',
						array(
							'loading'  => 'eager',      // LCP tidak lazy-load.
							'decoding' => 'sync',
							'fetchpriority' => 'high',   // Beri prioritas loading tertinggi.
							'class'    => 'ukm-produk-gallery__img',
							'alt'      => esc_attr( get_the_title() ),
						)
					);
					echo '</div>';
				} else {
					echo '<div class="ukm-produk-gallery__main ukm-produk-gallery__placeholder">';
					echo '<svg viewBox="0 0 200 150" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">';
					echo '<rect width="200" height="150" fill="#F3F4F6"/>';
					echo '<text x="100" y="80" text-anchor="middle" fill="#D1D5DB" font-size="14" font-family="sans-serif">Belum ada gambar</text>';
					echo '</svg>';
					echo '</div>';
				}
				?>
			</div>
			<!-- /Kolom Gambar -->

			<!-- Kolom Informasi Produk -->
			<div class="ukm-produk-info">

				<!-- Kategori -->
				<?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
					<div class="ukm-produk-info__categories">
						<?php foreach ( $terms as $term ) : ?>
							<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="ukm-badge ukm-badge--primary">
								<?php echo esc_html( $term->name ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<!-- Nama Produk -->
				<h1 class="ukm-produk-info__title"><?php the_title(); ?></h1>

				<!-- Status & SKU -->
				<div class="ukm-produk-info__meta">
					<?php ukm_produk_status_badge( $post_id ); ?>
					<?php if ( $sku ) : ?>
						<span class="ukm-produk-info__sku" style="font-size:var(--ukm-font-size-sm);color:var(--ukm-color-gray-500)">
							<?php
							/* translators: %s adalah kode SKU produk. */
							printf( esc_html__( 'SKU: %s', 'ukm-toko-theme' ), '<strong>' . esc_html( $sku ) . '</strong>' );
							?>
						</span>
					<?php endif; ?>
				</div>

				<!-- Harga -->
				<?php if ( $harga ) : ?>
					<div class="ukm-produk-info__price">
						<span class="ukm-produk-info__price-value"><?php echo esc_html( ukm_format_rupiah( $harga ) ); ?></span>
						<span class="ukm-produk-info__price-satuan">/ <?php echo esc_html( $satuan ); ?></span>
					</div>
				<?php endif; ?>

				<!-- Stok -->
				<div class="ukm-produk-info__stok">
					<?php if ( (int) $stok > 0 ) : ?>
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--ukm-color-success)" stroke-width="2.5" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg>
						<span style="color:var(--ukm-color-success)">
							<?php
							printf(
								/* translators: %d jumlah stok tersedia. */
								esc_html( _n( 'Stok: %d unit tersedia', 'Stok: %d unit tersedia', (int) $stok, 'ukm-toko-theme' ) ),
								absint( $stok )
							);
							?>
						</span>
					<?php else : ?>
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--ukm-color-error)" stroke-width="2.5" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
						<span style="color:var(--ukm-color-error)"><?php esc_html_e( 'Stok habis', 'ukm-toko-theme' ); ?></span>
					<?php endif; ?>
				</div>

				<!-- Varian Produk (jika ada) -->
				<?php if ( is_array( $varian ) && ! empty( $varian ) ) : ?>
					<div class="ukm-produk-info__varian">
						<h3 class="ukm-produk-info__varian-title"><?php esc_html_e( 'Pilih Ukuran:', 'ukm-toko-theme' ); ?></h3>
						<div class="ukm-varian-list" role="radiogroup" aria-label="<?php esc_attr_e( 'Ukuran produk', 'ukm-toko-theme' ); ?>">
							<?php foreach ( $varian as $index => $item ) : ?>
								<?php if ( empty( $item['ukuran'] ) ) continue; ?>
								<label class="ukm-varian-item">
									<input
										type="radio"
										name="ukm_varian_pilihan"
										value="<?php echo esc_attr( $item['ukuran'] ); ?>"
										data-harga="<?php echo esc_attr( isset( $item['harga'] ) ? $item['harga'] : '' ); ?>"
										data-stok="<?php echo esc_attr( isset( $item['stok'] ) ? $item['stok'] : '' ); ?>"
										<?php checked( $index, 0 ); ?>
									/>
									<span class="ukm-varian-item__label">
										<?php echo esc_html( $item['ukuran'] ); ?>
										<?php if ( isset( $item['harga'] ) && $item['harga'] ) : ?>
											<span class="ukm-varian-item__price"><?php echo esc_html( ukm_format_rupiah( $item['harga'] ) ); ?></span>
										<?php endif; ?>
									</span>
								</label>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<!-- Info Berat -->
				<?php if ( $berat ) : ?>
					<p class="ukm-produk-info__berat" style="font-size:var(--ukm-font-size-sm);color:var(--ukm-color-gray-500)">
						<?php
						printf(
							/* translators: %s berat produk dalam gram atau kg. */
							esc_html__( 'Berat: %s', 'ukm-toko-theme' ),
							$berat >= 1000
								? esc_html( number_format( $berat / 1000, 1 ) . ' kg' )
								: esc_html( $berat . ' gram' )
						);
						?>
					</p>
				<?php endif; ?>

				<!-- CTA Pemesanan -->
				<div class="ukm-produk-info__cta">
					<?php
					// Tombol WooCommerce (jika produk WC ada yang cocok).
					if ( ukm_is_woocommerce_active() ) :
						$wc_product_query = new WP_Query( array(
							'post_type'      => 'product',
							'posts_per_page' => 1,
							'meta_query'     => array(
								array(
									'key'   => '_ukm_cpt_produk_id',
									'value' => $post_id,
								),
							),
							'no_found_rows'  => true,
						) );

						if ( $wc_product_query->have_posts() ) :
							$wc_product_query->the_post();
							$wc_url = get_permalink();
							wp_reset_postdata();
						?>
							<a href="<?php echo esc_url( $wc_url ); ?>" class="ukm-btn ukm-btn--primary ukm-btn--lg">
								<?php esc_html_e( 'Beli Sekarang', 'ukm-toko-theme' ); ?>
							</a>
						<?php
						endif;
					endif;

					// Tombol WhatsApp.
					if ( $wa_pesan && 'habis' !== $status ) :
						$pesan_wa = sprintf(
							/* translators: 1: nama produk, 2: harga. */
							__( 'Halo, saya ingin memesan %1$s seharga %2$s. Apakah stok tersedia?', 'ukm-toko-theme' ),
							get_the_title(),
							$harga ? ukm_format_rupiah( $harga ) : ''
						);
						ukm_whatsapp_button( $wa_pesan, $pesan_wa, __( 'Pesan via WhatsApp', 'ukm-toko-theme' ), 'ukm-btn--lg' );
					endif;
					?>
				</div>
				<!-- /CTA -->

			</div>
			<!-- /Kolom Informasi Produk -->

		</div>
		<!-- /Layout Detail Produk -->

		<!-- Deskripsi Produk -->
		<?php if ( get_the_content() ) : ?>
			<div class="ukm-produk-description">
				<h2><?php esc_html_e( 'Deskripsi Produk', 'ukm-toko-theme' ); ?></h2>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</div>
		<?php endif; ?>

		<!-- Produk Terkait (sama kategori) -->
		<?php
		$related_args = array(
			'post_type'      => 'produk',
			'posts_per_page' => 4,
			'post_status'    => 'publish',
			'post__not_in'   => array( $post_id ),
			'no_found_rows'  => true,
		);

		// Filter berdasarkan kategori yang sama.
		if ( $terms && ! is_wp_error( $terms ) ) {
			$term_ids = wp_list_pluck( $terms, 'term_id' );
			$related_args['tax_query'] = array(
				array(
					'taxonomy' => 'kategori-produk',
					'field'    => 'term_id',
					'terms'    => $term_ids,
				),
			);
		}

		$related_query = new WP_Query( $related_args );

		if ( $related_query->have_posts() ) :
		?>
			<section class="ukm-related-products ukm-section--sm">
				<h2><?php esc_html_e( 'Produk Serupa', 'ukm-toko-theme' ); ?></h2>
				<div class="ukm-product-grid">
					<?php
					while ( $related_query->have_posts() ) :
						$related_query->the_post();
						get_template_part( 'template-parts/content', 'produk' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</section>
		<?php endif; ?>

		<?php endwhile; ?>

	</div>
</main>

<?php get_footer(); ?>
