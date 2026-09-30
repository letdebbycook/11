<?php
/**
 * Template fallback index.php.
 * Digunakan saat tidak ada template yang lebih spesifik.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="ukm-site-main" role="main">
	<div class="ukm-container">

		<?php ukm_breadcrumb(); ?>

		<?php if ( have_posts() ) : ?>
			<header class="ukm-archive-header">
				<?php
				if ( is_home() && ! is_front_page() ) {
					echo '<h1>' . esc_html( single_post_title( '', false ) ) . '</h1>';
				} elseif ( is_archive() ) {
					the_archive_title( '<h1>', '</h1>' );
					the_archive_description( '<div class="ukm-archive-desc">', '</div>' );
				}
				?>
			</header>

			<div class="ukm-posts-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', get_post_type() === 'produk' ? 'produk' : '' );
				endwhile;
				?>
			</div>

			<?php ukm_pagination(); ?>

		<?php else : ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>
		<?php endif; ?>

	</div>
</main>

<?php get_footer(); ?>
