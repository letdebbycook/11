<?php
/**
 * Template Part: Loop Post Standar (Blog).
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'ukm-post-card' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" class="ukm-post-card__image-wrap" tabindex="-1" aria-hidden="true">
			<?php
			the_post_thumbnail(
				'ukm-blog-thumb',
				array(
					'class'   => 'ukm-post-card__image',
					'loading' => 'lazy',
					'alt'     => esc_attr( get_the_title() ),
				)
			);
			?>
		</a>
	<?php endif; ?>

	<div class="ukm-post-card__body">

		<!-- Kategori -->
		<?php
		$categories = get_the_category();
		if ( $categories ) :
		?>
			<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="ukm-post-card__category">
				<?php echo esc_html( $categories[0]->name ); ?>
			</a>
		<?php endif; ?>

		<!-- Judul -->
		<h2 class="ukm-post-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>

		<!-- Excerpt -->
		<p class="ukm-post-card__excerpt">
			<?php echo esc_html( get_the_excerpt() ); ?>
		</p>

		<!-- Meta -->
		<div class="ukm-post-card__meta">
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="ukm-post-card__date">
				<?php echo esc_html( get_the_date() ); ?>
			</time>
			<span class="ukm-post-card__author">
				<?php
				printf(
					/* translators: %s nama penulis. */
					esc_html__( 'oleh %s', 'ukm-toko-theme' ),
					esc_html( get_the_author() )
				);
				?>
			</span>
		</div>

		<a href="<?php the_permalink(); ?>" class="ukm-btn ukm-btn--outline ukm-btn--sm">
			<?php esc_html_e( 'Baca Selengkapnya', 'ukm-toko-theme' ); ?>
		</a>

	</div>
</article>
