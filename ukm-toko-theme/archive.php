<?php
/**
 * Template Arsip Blog (archive.php).
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="ukm-site-main ukm-archive" role="main">
	<div class="ukm-container">
		<?php ukm_breadcrumb(); ?>

		<header class="ukm-archive-header">
			<?php the_archive_title( '<h1 class="ukm-archive-title">', '</h1>' ); ?>
			<?php the_archive_description( '<p class="ukm-archive-desc">', '</p>' ); ?>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="ukm-posts-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content' );
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
