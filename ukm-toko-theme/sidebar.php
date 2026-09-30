<?php
/**
 * Template untuk menampilkan sidebar tema.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

// Tentukan sidebar mana yang dipanggil berdasarkan konteks halaman.
$sidebar_id = 'ukm-sidebar-blog';

if ( is_post_type_archive( 'produk' ) || is_singular( 'produk' ) || ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) ) {
	$sidebar_id = 'ukm-sidebar-shop';
}

if ( ! is_active_sidebar( $sidebar_id ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area ukm-sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Sidebar', 'ukm-toko-theme' ); ?>">
	<?php dynamic_sidebar( $sidebar_id ); ?>
</aside>
