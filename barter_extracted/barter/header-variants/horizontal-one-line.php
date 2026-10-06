<?php
global $barter_a13;

$variant         = $barter_a13->get_option( 'header_horizontal_variant' );

$header_content_width = $barter_a13->get_option( 'header_content_width' );
$header_width = ' ' . $header_content_width;
if($header_content_width === 'narrow' && $barter_a13->get_option( 'header_content_width_narrow_bg') === 'on' ){
	$header_width .= ' narrow-header';
}

$header_classes = 'to-move a13-horizontal header-type-one_line a13-'.barter_horizontal_header_color_variant().'-variant header-variant-' . $variant . $header_width;

$menu_on        = $barter_a13->get_option( 'header_main_menu' ) === 'on';
$socials        = $barter_a13->get_option( 'header_socials' ) === 'on';

$icons_no     = 0;
$header_tools = barter_get_header_toolbar( $icons_no );
if ( ! $icons_no ) {
	$header_classes .= ' no-tools';
} else {
	$header_classes .= ' tools-icons-' . $icons_no; //number of icons
}

//how sticky version will behave
$header_classes .= ' '.$barter_a13->get_option( 'header_horizontal_sticky' );

//hide until it is scrolled to
$show_header_at = $barter_a13->barter_get_meta('_horizontal_header_show_header_at' );

// Fixed PHP 8.1 Error
if (!empty($show_header_at) && $show_header_at > 0) {
    $header_classes .= ' hide-until-scrolled-to';
}

// top bar
$header_topbar     = $barter_a13->get_option( 'header_topbar' ) === 'on';
$header_topbar_left_text1     = $barter_a13->get_option( 'header_topbar_left_text1' );
$header_topbar_left_text2     = $barter_a13->get_option( 'header_topbar_left_text2' );

?>
<header id="header" class="<?php echo esc_attr( $header_classes ); ?>"<?php barter_schema_args( 'header' ); ?>>
<?php if ( $header_topbar ): ?>
<div class="barter-top-bar">
        <div class="content-limiter">
        <div class="topbar-left">
        	<?php echo $header_topbar_left_text1; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <?php if(!empty($header_topbar_left_text2)){echo '<span>'.$header_topbar_left_text2.'</span>';} // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </div>
        <?php echo barter_header_topbar_button(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <div class="clear"></div>
        </div>
    </div>
<?php endif; ?>    
	<div class="head">
		<div class="logo-container"<?php barter_schema_args('logo'); ?>><?php barter_header_logo(); ?></div>
		<!-- #access -->
		<?php
        	$header_search = $barter_a13->get_option( 'header_search' ) === 'on';
			if ( $header_search ) {
				?>
                <div class="top_search_form_area">
				<?php
                echo barter_search_form( '', true ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped	
				?>
				</div>
				<?php
			}
		?>        
		<?php echo wp_kses_post($header_tools );//escaped layout part ?>
		<?php if ( $socials ) {
			//check what color variant we use
			$color_variant = barter_horizontal_header_color_variant();
			$color_variant = $color_variant === 'normal' ? '' : '_'.$color_variant;

			//escaped on creation
			echo barter_social_icons( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				$barter_a13->get_option( 'header'.$color_variant.'_socials_color' ),
				$barter_a13->get_option( 'header'.$color_variant.'_socials_color_hover' ),
				'',
				$barter_a13->get_option( 'header_socials_display_on_mobile' ) === 'off'
			);
		} ?>
	</div>
    <div class="clear"></div>
    <div class="main-menu-area">
    	<center>
        <div id="navigation">
			<div class="toggle">
				<a class="toggleMenu" href="#"><?php esc_html_e('Menu','barter'); ?></a>
			</div><!-- toggle --> 	
			<nav id="main-navigation" class="site-navigation primary-navigation sitenav" role="navigation">		
				<?php wp_nav_menu( array('theme_location' => 'header-menu') ); ?>
			</nav>
		</div><!-- navigation -->
        </center>
    </div>
</header> 