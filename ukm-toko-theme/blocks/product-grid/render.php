<?php
/**
 * Render template fallback untuk blok Product Grid.
 *
 * @package ukm-toko-theme
 */

defined( 'ABSPATH' ) || exit;

if ( function_exists( 'ukm_render_block_product_grid' ) ) {
	echo ukm_render_block_product_grid( $attributes ?? array(), $content ?? '' );
}
