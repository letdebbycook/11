<?php
/**
 * Functions that operates in themes footer element
 */

if(!function_exists('barter_theme_footer')){
	function barter_theme_footer(){
		global $barter_a13;

		//Header Footer Elementor Plugin support
		if ( function_exists( 'hfe_render_footer' ) ) {
			hfe_render_footer();
		}

		if( $barter_a13->get_option( 'footer_switch', 'on' ) === 'off' ){
			//no theme footer
			return;
		}

		if ( function_exists( 'elementor_location_exits' ) && elementor_location_exits( 'footer', true ) ) {
			echo '<div class="container-elementor-footer">';
		}


		if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {


			$html = '';

			ob_start();
			barter_footer_widgets();
			barter_footer_items();

			$output = ob_get_contents();
			ob_end_clean();
			
			$footer_logo = $barter_a13->get_option( 'footer_logo' );
			$footer_logo_link = $barter_a13->get_option( 'footer_logo_link' );

			if(strlen($output)){
				$header_type = $barter_a13->get_option( 'header_type' );
				$to_move     = $header_type === 'vertical' ? '' : 'to-move';
				$width       = ' ' . $barter_a13->get_option( 'footer_content_width' );
				$style       = ' ' . $barter_a13->get_option( 'footer_content_style' );

				$footer_class = $to_move.$width.$style;
				$html = '<footer id="footer" class="'.esc_attr($footer_class).'"'.barter_get_schema_args('footer').'>';
				if(!empty($footer_logo)){
					$html .= '<div class="footer-logo">';
					if(!empty($footer_logo_link)){
						$html .= '<a href="'.esc_url($footer_logo_link).'">';
					}
					$html .= '<img src="'.esc_url($footer_logo['url']).'"/>';
					if(!empty($footer_logo_link)){
					$html .= '</a>';
					}
					$html .= '</div>';
				}
				$html .= $output.'</footer>';
			}
			//escaped on creation
			print $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}


		if ( function_exists( 'elementor_location_exits' ) && elementor_location_exits( 'footer', true ) ) {
			echo '</div>';//.container-elementor-footer
		}
	}
}

if (!function_exists('barter_footer_css')) {
function barter_footer_css() {
	global $barter_a13;

	$css = '';

	if ( $barter_a13->get_option( 'footer_switch' ) === 'on' ) {
		$footer_bg_color          = barter_make_css_rule( 'background-color', $barter_a13->get_option_color_rgba( 'footer_bg_color' ) );
		$footer_lower_bg_color    = barter_make_css_rule( 'background-color', $barter_a13->get_option_color_rgba( 'footer_lower_bg_color' ) );
		$footer_font_size         = barter_make_css_rule( 'font-size', $barter_a13->get_option( 'footer_font_size' ), '%spx' );
		$footer_widgets_font_size = barter_make_css_rule( 'font-size', $barter_a13->get_option( 'footer_widgets_font_size' ), '%spx' );
		$footer_font_color        = barter_make_css_rule( 'color', $barter_a13->get_option_color_rgba( 'footer_font_color' ) );
		$footer_link_color        = barter_make_css_rule( 'color', $barter_a13->get_option_color_rgba( 'footer_link_color' ) );
		$footer_hover_color       = barter_make_css_rule( 'color', $barter_a13->get_option_color_rgba( 'footer_hover_color' ) );

		$css .= "
/* ==================
   FOOTER
   ==================*/
#footer{
    $footer_bg_color
    $footer_font_size
}
#footer .widget,
#footer .widget .search-form input[type=\"search\"]{
    $footer_widgets_font_size
}
.foot-items{
    $footer_lower_bg_color
}
.foot-items{
    $footer_font_color
}
.foot-items .foot-text a{
    $footer_link_color
}
.foot-items .foot-text a:hover{
    $footer_hover_color
}";
	}

	return $css;
}
}

if (!function_exists('barter_footer_partial_css')) {
function barter_footer_partial_css($response) {
	return barter_prepare_partial_css($response, 'footer_switch', 'barter_footer_css');
}
}
add_filter( 'customize_render_partials_response', 'barter_footer_partial_css' );


if(!function_exists('barter_footer_widgets')) {
	/**
	 * Prints out HTML for footer widgets in columns
	 */
	function barter_footer_widgets() {
		global $barter_a13;

		//is there any widgets
		if ( is_active_sidebar( 'footer-widget-area' ) ) {
			//class for widgets
			$_class = '';
			$columns = (int)$barter_a13->get_option( 'footer_widgets_columns' );
			if ( $columns === 1 ) {
				$_class = ' one-col';
			} elseif ( $columns === 2 ) {
				$_class = ' two-col';
			} elseif ( $columns === 3 ) {
				$_class = ' three-col';
			} elseif ( $columns === 4 ) {
				$_class = ' four-col';
			} elseif ( $columns === 5 ) {
				$_class = ' five-col';
			}

			//color of sidebar
			$_class .= ' '.$barter_a13->get_option( 'footer_widgets_color' );

			echo '<div class="foot-widgets' . esc_attr( $_class ) . '">';
                echo '<div class="foot-content clearfix">';

			dynamic_sidebar( 'footer-widget-area' );

			echo '</div>
                </div>';
		}
	}
}


if(!function_exists('barter_footer_items')) {
	/**
	 * Prints out HTML for footer items
	 */
	function barter_footer_items() {
		global $barter_a13; ?>
			<div class="foot-items">
				<div class="foot-content clearfix">
	                <?php
	                footer_socials();
	                //footer text
	                $ft = do_shortcode( $barter_a13->get_option( 'footer_text' ) );
	                $privacy = $barter_a13->get_option( 'footer_privacy_link' ) === 'on';

					if(!empty($ft)){
		                echo '<div class="foot-text">';
		                echo nl2br( wp_kses_post( balanceTags( $ft, true ) ) );
		                if ( $privacy && function_exists( 'the_privacy_policy_link' ) ) {
			                the_privacy_policy_link( '<div class="test">', '</div>');
		                }
		                echo '</div>';
	                }
	                ?>
					<div class="credtext">
                        <a href="<?php echo esc_url('https://www.sktthemes.org/shop/free-shopping-ecommerce-wordpress-theme/');?>" rel="noopener" target="_blank">
                        <?php esc_html_e('Barter','barter'); ?>
                        </a>
                    </div>
				</div>
			</div>
		<?php
	}
}


if (!function_exists('footer_socials')) {
function footer_socials(){
	global $barter_a13;
	if( $barter_a13->get_option( 'footer_socials' ) === 'on' ){
		echo '<div class="f-links">';
		//barter_social_icons() produces escaped content
		echo barter_social_icons($barter_a13->get_option( 'footer_socials_color' ), $barter_a13->get_option( 'footer_socials_color_hover' )); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</div>';
	}
}
}

if(!function_exists('barter_footer_for_site_modules')) {
	/**
	 * Prints out HTML for elements needed to be printed after whole site
	 */
	function barter_footer_for_site_modules() {
		global $barter_a13;

		$to_top_off = $barter_a13->get_option( 'to_top' ) === 'off';

		if( $to_top_off ){
			return;
		}

		$to_top_icon = $barter_a13->get_option( 'to_top_icon' );
		$to_top_icon = 'fa-'.(strlen($to_top_icon)? $to_top_icon : 'chevron-up');

		//top top and overlay for various things ?>
		<a href="#top" id="to-top" class="to-top fa <?php echo esc_attr($to_top_icon); ?>"></a>
		<div id="content-overlay" class="to-move"></div>
		<?php
	}
}


if(!function_exists('barter_footer_for_header_modules')) {
	/**
	 * Prints out HTML for elements used in header
	 */
	function barter_footer_for_header_modules() {
		global $barter_a13;

		//hidden sidebar
		if( is_active_sidebar( 'side-widget-area' ) ){
			$hidden_sb_classes = ' '.$barter_a13->get_option( 'hidden_sidebar_widgets_color' );
			$hidden_sb_classes .= ' at-'.$barter_a13->get_option( 'hidden_sidebar_side' );
		?>
		<nav id="side-menu" class="side-widget-menu<?php echo esc_attr($hidden_sb_classes) ?>">
			<div class="scroll-wrap">
				<?php dynamic_sidebar( 'side-widget-area' ); ?>
			</div>
			<span class="a13icon-cross close-sidebar"></span>
		</nav>
		<?php
		}


		//basket sidebar
		if( barter_is_woocommerce_activated() && is_active_sidebar( 'basket-widget-area' ) ){
		?>
		<nav id="basket-menu" class="basket-sidebar">
			<?php dynamic_sidebar( 'basket-widget-area' ); ?>
			<span class="a13icon-cross close-sidebar"></span>
		</nav>
		<?php
		}
	}
}

