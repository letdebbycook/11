<?php
/**
 * Template Halaman Statis (page.php).
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="ukm-site-main ukm-page" role="main">
	<div class="ukm-container">
		<?php ukm_breadcrumb(); ?>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'ukm-page-content' ); ?>>
				<header class="ukm-page-header">
					<h1 class="ukm-page-title"><?php the_title(); ?></h1>
				</header>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="ukm-page-featured-image">
						<?php the_post_thumbnail( 'large', array( 'loading' => 'eager', 'fetchpriority' => 'high' ) ); ?>
					</div>
				<?php endif; ?>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
			<?php if ( comments_open() || get_comments_number() ) comments_template(); ?>
		<?php endwhile; ?>
	</div>
</main>

<?php get_footer(); ?>
