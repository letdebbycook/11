<?php
/**
 * Template Single Post Blog (single.php).
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="ukm-site-main ukm-single-blog" role="main">
	<div class="ukm-container">
		<div class="ukm-layout-with-sidebar">

			<!-- Konten Utama -->
			<div class="ukm-main-content">
				<?php ukm_breadcrumb(); ?>

				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', 'single' );

					// Navigasi post sebelum/sesudah.
					?>
					<nav class="ukm-post-navigation" aria-label="<?php esc_attr_e( 'Navigasi Post', 'ukm-toko-theme' ); ?>">
						<?php
						$prev_post = get_previous_post();
						$next_post = get_next_post();
						if ( $prev_post ) :
						?>
							<div class="ukm-nav-previous">
								<span class="ukm-nav-label"><?php esc_html_e( 'Sebelumnya', 'ukm-toko-theme' ); ?></span>
								<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="ukm-nav-title">
									<?php echo esc_html( get_the_title( $prev_post->ID ) ); ?>
								</a>
							</div>
						<?php endif; ?>
						<?php if ( $next_post ) : ?>
							<div class="ukm-nav-next">
								<span class="ukm-nav-label"><?php esc_html_e( 'Berikutnya', 'ukm-toko-theme' ); ?></span>
								<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="ukm-nav-title">
									<?php echo esc_html( get_the_title( $next_post->ID ) ); ?>
								</a>
							</div>
						<?php endif; ?>
					</nav>

					<?php
					// Komentar.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile;
				?>
			</div>
			<!-- /Konten Utama -->

			<!-- Sidebar Blog -->
			<?php if ( is_active_sidebar( 'ukm-sidebar-blog' ) ) : ?>
				<aside class="ukm-sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Sidebar Blog', 'ukm-toko-theme' ); ?>">
					<?php dynamic_sidebar( 'ukm-sidebar-blog' ); ?>
				</aside>
			<?php endif; ?>

		</div>
	</div>
</main>

<?php get_footer(); ?>
