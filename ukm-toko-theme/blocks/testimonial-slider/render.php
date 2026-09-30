<?php
/**
 * Render template fallback untuk blok Testimonial Slider.
 *
 * @package ukm-toko-theme
 */

defined( 'ABSPATH' ) || exit;

if ( function_exists( 'ukm_render_block_testimonial_slider' ) ) {
	echo ukm_render_block_testimonial_slider( $attributes ?? array(), $content ?? '' );
}
