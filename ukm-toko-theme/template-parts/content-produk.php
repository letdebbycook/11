<?php
/**
 * Template Part: Card Produk CPT.
 *
 * Digunakan di: archive-produk.php, front-page.php, blok Product Grid.
 * Variabel global: $post (WordPress loop post saat ini).
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

$post_id = get_the_ID();
$harga   = ukm_get_produk_field( '_ukm_harga', $post_id );
$stok    = ukm_get_produk_field( '_ukm_stok', $post_id, 0 );
$satuan  = ukm_get_produk_field( '_ukm_satuan', $post_id, 'pcs' );
$status  = ukm_get_produk_field( '_ukm_status_produk', $post_id, 'tersedia' );
$terms   = get_the_terms( $post_id, 'kategori-produk' );
?>

<article id="produk-<?php the_ID(); ?>" <?php post_class( 'ukm-product-card' ); ?>>

	<!-- Gambar Produk -->
	<a href="<?php the_permalink(); ?>" class="ukm-product-card__image-wrap" tabindex="-1" aria-hidden="true">
		<?php ukm_product_thumbnail( $post_id, 'ukm-product-thumb', false ); ?>

		<?php if ( 'habis' === $status ) : ?>
			<div class="ukm-product-card__overlay-sold-out">
				<span class="ukm-badge ukm-badge--error"><?php esc_html_e( 'Stok Habis', 'ukm-toko-theme' ); ?></span>
			</div>
		<?php endif; ?>
	</a>

	<!-- Body Kartu -->
	<div class="ukm-product-card__body">

		<!-- Kategori -->
		<?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
			<a href="<?php echo esc_url( get_term_link( $terms[0] ) ); ?>" class="ukm-product-card__category">
				<?php echo esc_html( $terms[0]->name ); ?>
			</a>
		<?php endif; ?>

		<!-- Judul -->
		<h2 class="ukm-product-card__title">
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
		</h2>

		<!-- Harga -->
		<?php if ( $harga ) : ?>
			<div class="ukm-product-card__price">
				<?php echo esc_html( ukm_format_rupiah( $harga ) ); ?>
				<span style="font-size:var(--ukm-font-size-sm);font-weight:400;color:var(--ukm-color-gray-500)">
					/ <?php echo esc_html( $satuan ); ?>
				</span>
			</div>
		<?php endif; ?>

		<!-- Stok -->
		<p class="ukm-product-card__stock <?php echo 'habis' === $status ? 'ukm-product-card__stock--habis' : ''; ?>">
			<?php
			if ( 'habis' === $status ) {
				esc_html_e( 'Stok habis', 'ukm-toko-theme' );
			} elseif ( (int) $stok > 0 ) {
				printf(
					/* translators: %d jumlah stok. */
					esc_html__( 'Stok: %d unit', 'ukm-toko-theme' ),
					absint( $stok )
				);
			} else {
				esc_html_e( 'Hubungi untuk ketersediaan', 'ukm-toko-theme' );
			}
			?>
		</p>

	</div>

	<!-- Footer Kartu -->
	<div class="ukm-product-card__footer">
		<a href="<?php the_permalink(); ?>" class="ukm-btn ukm-btn--secondary ukm-btn--sm ukm-btn--full">
			<?php esc_html_e( 'Lihat Detail', 'ukm-toko-theme' ); ?>
		</a>
	</div>

</article>
