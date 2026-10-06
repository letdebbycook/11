<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * In this theme we use it as home.php, archive.php and search.php to reduce number of templates
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $barter_a13;

$ajax_call = !empty($_REQUEST['a13-ajax-get']);

if ( $ajax_call ) {
    if ( function_exists('barter_display_items_from_query_post_list') ) {
        barter_display_items_from_query_post_list();
    }

    the_posts_pagination();

    if ( function_exists('barter_result_count') ) {
        barter_result_count();
    }

} else {

    $_title = '';

    // Determine page title
    if ( is_search() ) {
        $search_term = (string) get_search_query();
        $all_search  = new WP_Query( [ 's' => $search_term, 'posts_per_page' => -1 ] );
        $count       = $all_search->post_count;

        $_title = sprintf(
            esc_html( _n( '%1$d search result for "%2$s"', '%1$d search results for "%2$s"', $count, 'barter' ) ),
            $count,
            $search_term
        );

    } elseif ( is_archive() ) {
        if ( is_author() ) {
            $_title = sprintf(
                esc_html__( 'Author Archives: %s', 'barter' ),
                "<span class='vcard'>" . get_the_author() . "</span>"
            );
        } elseif ( is_category() ) {
            $_title = sprintf(
                esc_html__( 'Category Archives: %s', 'barter' ),
                '<span>' . single_cat_title( '', false ) . '</span>'
            );
        } elseif ( is_tag() ) {
            $_title = sprintf(
                esc_html__( 'Tag Archives: %s', 'barter' ),
                '<span>' . single_tag_title( '', false ) . '</span>'
            );
        } elseif ( is_day() ) {
            $_title = sprintf(
                esc_html__( 'Daily Archives: %s', 'barter' ),
                '<span>' . get_the_date() . '</span>'
            );
        } elseif ( is_month() ) {
            $_title = sprintf(
                esc_html__( 'Monthly Archives: %s', 'barter' ),
                '<span>' . get_the_date( 'F Y' ) . '</span>'
            );
        } elseif ( is_year() ) {
            $_title = sprintf(
                esc_html__( 'Yearly Archives: %s', 'barter' ),
                '<span>' . get_the_date( 'Y' ) . '</span>'
            );
        } else {
            $_title = esc_html__( 'Blog Archives', 'barter' );
        }
    }

    $lazy_load        = $barter_a13->get_option('blog_lazy_load') === 'on';
    $pagination_class = $lazy_load ? ' lazy-load-on' : '';

    get_header();

    if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {

        barter_title_bar( 'outside', $_title );
        ?>
        <article id="content" class="clearfix">
            <div class="content-limiter">
                <div id="col-mask">
                    <div class="content-box<?php echo esc_attr( $pagination_class ); ?>">
                        <?php
                        // Safe display of posts
                        global $post;
                        if ( function_exists('barter_display_items_from_query_post_list') ) {
                            barter_display_items_from_query_post_list();
                        }
                        ?>
                        <div class="clear"></div>

                        <?php
                        the_posts_pagination();

                        if ( function_exists('barter_result_count') ) {
                            barter_result_count();
                        }
                        ?>
                    </div>
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </article>
        <?php
    }

    get_footer();
}