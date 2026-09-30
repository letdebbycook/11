<?php
/**
 * Template Part: Konten Single Post.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ukm-single-post' ); ?>>

	<!-- Header Post -->
	<header class="ukm-single-post__header">
		<?php
		$categories = get_the_category();
		if ( $categories ) :
		?>
			<div class="ukm-single-post__categories">
				<?php foreach ( $categories as $cat ) : ?>
					<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="ukm-badge ukm-badge--primary">
						<?php echo esc_html( $cat->name ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<h1 class="ukm-single-post__title"><?php the_title(); ?></h1>

		<div class="ukm-single-post__meta">
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
				<?php echo esc_html( get_the_date() ); ?>
			</time>
			<span><?php esc_html_e( 'oleh', 'ukm-toko-theme' ); ?> <?php the_author_posts_link(); ?></span>
			<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
				<a href="#comments"><?php comments_number( esc_html__( 'Belum ada komentar', 'ukm-toko-theme' ), esc_html__( '1 komentar', 'ukm-toko-theme' ), esc_html__( '% komentar', 'ukm-toko-theme' ) ); ?></a>
			<?php endif; ?>
		</div>
	</header>

	<!-- Gambar Featured (LCP — eager load) -->
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="ukm-single-post__featured-image">
			<?php
			the_post_thumbnail(
				'large',
				array(
					'loading'       => 'eager',
					'fetchpriority' => 'high',
					'decoding'      => 'sync',
					'alt'           => esc_attr( get_the_title() ),
				)
			);
			?>
		</div>
	<?php endif; ?>

	<!-- Konten -->
	<div class="ukm-single-post__content entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s judul post. */
					__( 'Lanjutkan membaca<span class="sr-only"> "%s"</span>', 'ukm-toko-theme' ),
					array( 'span' => array( 'class' => array() ) )
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Halaman:', 'ukm-toko-theme' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

	<!-- Footer Post: Tag -->
	<?php
	$tags = get_the_tags();
	if ( $tags ) :
	?>
		<footer class="ukm-single-post__footer">
			<div class="ukm-post-tags">
				<strong><?php esc_html_e( 'Tag:', 'ukm-toko-theme' ); ?></strong>
				<?php
				foreach ( $tags as $tag ) :
					printf(
						'<a href="%s" class="ukm-badge ukm-badge--gray" rel="tag">%s</a>',
						esc_url( get_tag_link( $tag->term_id ) ),
						esc_html( $tag->name )
					);
				endforeach;
				?>
			</div>
		</footer>
	<?php endif; ?>

</article>
