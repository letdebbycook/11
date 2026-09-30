<?php
/**
 * Render template fallback untuk blok Hero Banner.
 *
 * @package ukm-toko-theme
 */

defined( 'ABSPATH' ) || exit;

if ( function_exists( 'ukm_render_block_hero_banner' ) ) {
	echo ukm_render_block_hero_banner( $attributes ?? array(), $content ?? '' );
}
