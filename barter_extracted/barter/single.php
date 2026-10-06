<?php
/**
 * The Template for displaying all single posts.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( post_password_required() ) {
    // Don't use the_content() as it also applies filters we might not need
    echo get_the_content(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
} else {

    get_header();

    // Elementor `single` location
    if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {

        if ( have_posts() ) {
            the_post(); // safely advance the post

            barter_title_bar();
            ?>

            <article id="content" class="clearfix"<?php barter_schema_args('creative'); ?>>
                <div class="content-limiter">
                    <div id="col-mask">

                        <div id="post-<?php the_ID(); ?>" <?php post_class('content-box'); ?>>
                            <div class="formatter">
                                <div class="hentry">
                                    <?php barter_title_bar( 'inside' ); ?>

                                    <div class="real-content entry-content"<?php barter_schema_args('text'); ?>>
                                        <?php the_content(); ?>
                                        <div class="clear"></div>

                                        <?php
                                        // Safe calls: cast arrays inside functions if needed
                                        if ( function_exists('barter_under_post_content') ) {
                                            barter_under_post_content();
                                        }
                                        ?>
                                    </div>
                                </div>

                                <?php
                                if ( function_exists('barter_posts_navigation') ) {
                                    barter_posts_navigation();
                                }

                                if ( function_exists('barter_author_info') ) {
                                    barter_author_info();
                                }
                                ?>

                                <?php
                                // If comments are open or we have at least one comment, load the comment template
                                if ( comments_open() || get_comments_number() ) :
                                    comments_template( '', true );
                                endif;
                                ?>
                            </div>
                        </div>

                        <?php get_sidebar(); ?>

                    </div>
                </div>
            </article>

            <?php
        } // end if have_posts
    }

    get_footer();
}