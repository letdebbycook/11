<?php
/**
 * Related Products override
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     ukm-toko-theme
 * @version     3.9.0
 */

defined( 'ABSPATH' ) || exit;

if ( $related_products ) : ?>

	<section class="related products ukm-section" style="padding-top:var(--ukm-space-12, 3rem);border-top:1px solid var(--ukm-color-gray-200, #E2E8F0);margin-top:var(--ukm-space-12, 3rem);">
		<?php
		$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Produk Terkait', 'ukm-toko-theme' ) );

		if ( $heading ) :
			?>
			<div class="ukm-section-heading" style="text-align:left;margin-bottom:var(--ukm-space-6, 1.5rem);">
				<span class="ukm-section-heading__label"><?php esc_html_e( 'Rekomendasi', 'ukm-toko-theme' ); ?></span>
				<h2 class="ukm-section-heading__title" style="font-size:var(--ukm-text-2xl, 1.5rem);"><?php echo esc_html( $heading ); ?></h2>
			</div>
		<?php endif; ?>

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $related_products as $related_product ) : ?>

				<?php
				$post_object = get_post( $related_product->get_id() );

				setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

				wc_get_template_part( 'content', 'product' );
				?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</section>
	<?php
endif;

wp_reset_postdata();
