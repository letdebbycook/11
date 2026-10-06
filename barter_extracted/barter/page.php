<?php
/**
 * The template for displaying all pages.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! barter_check_for_renamed_templates() ) {
    // we are moving to a different template
    return;
}

if ( post_password_required() ) {
    // Don't use the_content() as it also applies filters we might not need
    echo get_the_content(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
} else {

    global $barter_a13;
    get_header();

    // Elementor `single` location
    if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {

        if ( have_posts() ) {
            the_post();

            barter_title_bar();

            $add_class       = 'content-box';
            $sticky_one_page = $barter_a13->barter_get_meta( '_content_sticky_one_page' ) === 'on';
            if ( $sticky_one_page ) {
                $add_class .= ' a13-sticky-one-page';
            }
            ?>

            <article id="content" class="clearfix"<?php barter_schema_args('creative'); ?>>
                <div class="content-limiter">
                    <div id="col-mask">

                        <div id="post-<?php the_ID(); ?>" <?php
                        post_class( $add_class );

                        if ( $sticky_one_page ) {
                            $bullet_color = esc_attr( (string) $barter_a13->barter_get_meta( '_content_sticky_one_page_bullet_color' ) );
                            $bullet_icon  = esc_attr( (string) $barter_a13->barter_get_meta( '_content_sticky_one_page_bullet_icon' ) );

                            echo ' data-a13-sticky-one-page-icon-global-color="' . $bullet_color . '"';
                            echo ' data-a13-sticky-one-page-icon-global-icon="' . $bullet_icon . '"';
                        }
                        ?>>

                            <div class="formatter">
                                <?php barter_title_bar( 'inside' ); ?>

                                <div class="real-content"<?php barter_schema_args('text'); ?>>
                                    <?php the_content(); ?>
                                    <div class="clear"></div>

                                    <?php
                                    wp_link_pages( array(
                                        'before' => '<div id="page-links">' . esc_html__( 'Pages: ', 'barter' ),
                                        'after'  => '</div>',
                                    ) );
                                    ?>
                                </div>

                                <?php
                                $comments_on_pages = $barter_a13->get_option( 'page_comments' ) === 'on';

                                if ( $comments_on_pages && ( comments_open() || get_comments_number() ) ) :
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
} // end if password protected