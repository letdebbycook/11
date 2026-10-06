<?php
/**
 * Template used for displaying content of post/page on archive page.
 * It is used only on page with posts list: blog, archive, search
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

global $barter_a13, $post;

?>

<div class="formatter">
    <div class="real-content<?php echo 'post' === get_post_type()? ' hentry' : ''; ?>">

        <?php
        barter_post_meta_data();

        the_title('<h2 class="post-title entry-title"'.barter_get_schema_args('headline').'><a href="'. esc_url(get_permalink()) . '"'.barter_get_schema_args('url').'>', '</a></h2>');
        ?>

        <div class="entry-summary"<?php barter_schema_args('text'); ?>>
        <?php
        $add_read_more = $barter_a13->get_option( 'blog_read_more', 'on' ) === 'on';

        if($barter_a13->get_option( 'blog_excerpt_type') == 'auto'){
		// Fixed PHP 8.1 Error 
		global $post;
		
		if (!empty($post) && !empty($post->post_content) && strpos($post->post_content, '<!--more-->') !== false) {
			the_content( $add_read_more ? esc_html__( 'Read more', 'barter' ) : '' );
		}
		else{
			the_excerpt();
		}
        }
        //manual post cutting
        else{
            the_content( $add_read_more ? esc_html__( 'Read more', 'barter' ) : '' );
        }
        ?>
        </div>

        <div class="clear"></div>

        <?php barter_under_post_content(); ?>
        
    </div>
</div>