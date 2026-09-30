<?php
/**
 * Description tab override
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package ukm-toko-theme
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $post;

$heading = apply_filters( 'woocommerce_product_description_heading', __( 'Deskripsi Produk', 'ukm-toko-theme' ) );

?>
<?php if ( $heading ) : ?>
	<h2 class="ukm-product-detail__subheading" style="font-size:var(--ukm-text-xl, 1.25rem);font-weight:700;margin-bottom:var(--ukm-space-4, 1rem);">
		<?php echo esc_html( $heading ); ?>
	</h2>
<?php endif; ?>

<div class="ukm-product-description-content ukm-prose" style="line-height:1.7;color:var(--ukm-color-gray-700, #334155);">
	<?php the_content(); ?>
</div>
