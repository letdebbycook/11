<?php
/**
 * Template Hasil Pencarian (search.php).
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="ukm-site-main ukm-search-results" role="main">
	<div class="ukm-container">

		<header class="ukm-archive-header">
			<h1 class="ukm-archive-title">
				<?php
				printf(
					/* translators: %s: istilah pencarian. */
					esc_html__( 'Hasil pencarian: "%s"', 'ukm-toko-theme' ),
					'<em>' . esc_html( get_search_query() ) . '</em>'
				);
				?>
			</h1>
		</header>

		<!-- Form Pencarian Ulang -->
		<form role="search" method="get" class="ukm-search-form-inline" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="display:flex;gap:8px;margin-bottom:32px">
			<input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" class="ukm-form-input" placeholder="<?php esc_attr_e( 'Cari lagi...', 'ukm-toko-theme' ); ?>" />
			<button type="submit" class="ukm-btn ukm-btn--primary"><?php esc_html_e( 'Cari', 'ukm-toko-theme' ); ?></button>
		</form>

		<?php if ( have_posts() ) : ?>

			<?php ukm_search_results_count(); ?>

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
