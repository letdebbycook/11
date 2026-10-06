<?php
if (!function_exists('barter_setup_theme_options')) {
function barter_setup_theme_options() {
	global $barter_a13;

	//get all cursors
	$cursors = array(
		'christmas.png'         => 'christmas.png',
		'empty_black.png'       => 'empty_black.png',
		'empty_black_white.png' => 'empty_black_white.png',
		'superior_cursor.png'   => 'superior_cursor.png'
	);
	$barter_a13->barter_set_settings_set( 'cursors', $cursors );

	//get all menu effects
	$menu_effects = array(
		'none'      => esc_html__( 'None', 'barter' ),
		'ferdinand' => 'ferdinand'
	);
	$barter_a13->barter_set_settings_set( 'menu_effects', $menu_effects );

	//get all custom sidebars
	$header_sidebars = $barter_a13->get_option( 'custom_sidebars' );
	if ( ! is_array( $header_sidebars ) ) {
		$header_sidebars = array();
	}
	//create 2 arrays for different purpose
	$header_sidebars            = array_merge( array( 'off' => esc_html__( 'Off', 'barter' ) ), $header_sidebars );
	$header_sidebars_off_global = array_merge( array( 'G' => esc_html__( 'Global settings', 'barter' ) ), $header_sidebars );
	//re-indexing these arrays
	array_unshift( $header_sidebars, null );
	unset( $header_sidebars[0] );
	array_unshift( $header_sidebars_off_global, null );
	unset( $header_sidebars_off_global[0] );
	$barter_a13->barter_set_settings_set( 'header_sidebars', $header_sidebars );
	$barter_a13->barter_set_settings_set( 'header_sidebars_off_global', $header_sidebars_off_global );

	$on_off = array(
		'on'  => esc_html__( 'Enable', 'barter' ),
		'off' => esc_html__( 'Disable', 'barter' ),
	);
	$barter_a13->barter_set_settings_set( 'on_off', $on_off );

	$font_weights = array(
		'100'    => esc_html__( '100', 'barter' ),
		'200'    => esc_html__( '200', 'barter' ),
		'300'    => esc_html__( '300', 'barter' ),
		'normal' => esc_html__( 'Normal 400', 'barter' ),
		'500'    => esc_html__( '500', 'barter' ),
		'600'    => esc_html__( '600', 'barter' ),
		'bold'   => esc_html__( 'Bold 700', 'barter' ),
		'800'    => esc_html__( '800', 'barter' ),
		'900'    => esc_html__( '900', 'barter' ),
	);
	$barter_a13->barter_set_settings_set( 'font_weights', $font_weights );

	$font_transforms = array(
		'none'      => esc_html__( 'None', 'barter' ),
		'uppercase' => esc_html__( 'Uppercase', 'barter' ),
	);
	$barter_a13->barter_set_settings_set( 'font_transforms', $font_transforms );

	$text_align = array(
		'left'   => esc_html__( 'Left', 'barter' ),
		'center' => esc_html__( 'Center', 'barter' ),
		'right'  => esc_html__( 'Right', 'barter' ),
	);
	$barter_a13->barter_set_settings_set( 'text_align', $text_align );

	$image_fit = array(
		'cover'    => esc_html__( 'Cover', 'barter' ),
		'contain'  => esc_html__( 'Contain', 'barter' ),
		'fitV'     => esc_html__( 'Fit Vertically', 'barter' ),
		'fitH'     => esc_html__( 'Fit Horizontally', 'barter' ),
		'center'   => esc_html__( 'Just center', 'barter' ),
		'repeat'   => esc_html__( 'Repeat', 'barter' ),
		'repeat-x' => esc_html__( 'Repeat X', 'barter' ),
		'repeat-y' => esc_html__( 'Repeat Y', 'barter' ),
	);
	$barter_a13->barter_set_settings_set( 'image_fit', $image_fit );

	$content_layouts = array(
		'center'        => esc_html__( 'Center fixed width', 'barter' ),
		'left'          => esc_html__( 'Left fixed width', 'barter' ),
		'left_padding'  => esc_html__( 'Left fixed width + padding', 'barter' ),
		'right'         => esc_html__( 'Right fixed width', 'barter' ),
		'right_padding' => esc_html__( 'Right fixed width + padding', 'barter' ),
		'full_fixed'    => esc_html__( 'Full width + fixed content', 'barter' ),
		'full_padding'  => esc_html__( 'Full width + padding', 'barter' ),
		'full'          => esc_html__( 'Full width', 'barter' ),
	);
	$barter_a13->barter_set_settings_set( 'content_layouts', $content_layouts );

	$parallax_types = array(
		"tb"   => esc_html__( 'top to bottom', 'barter' ),
		"bt"   => esc_html__( 'bottom to top', 'barter' ),
		"lr"   => esc_html__( 'left to right', 'barter' ),
		"rl"   => esc_html__( 'right to left', 'barter' ),
		"tlbr" => esc_html__( 'top-left to bottom-right', 'barter' ),
		"trbl" => esc_html__( 'top-right to bottom-left', 'barter' ),
		"bltr" => esc_html__( 'bottom-left to top-right', 'barter' ),
		"brtl" => esc_html__( 'bottom-right to top-left', 'barter' ),
	);

	$content_under_header = array(
		'content' => esc_html__( 'Yes, hide the content', 'barter' ),
		'title'   => esc_html__( 'Yes, hide the content and add top padding to the outside title bar.', 'barter' ),
		'off'     => esc_html__( 'Turn it off', 'barter' ),
	);
	$barter_a13->barter_set_settings_set( 'content_under_header', $content_under_header );

	$social_colors = array(
		'black'            => esc_html__( 'Black', 'barter' ),
		'color'            => esc_html__( 'Color', 'barter' ),
		'white'            => esc_html__( 'White', 'barter' ),
		'semi-transparent' => esc_html__( 'Semi transparent', 'barter' ),
	);
	$barter_a13->barter_set_settings_set( 'social_colors', $social_colors );

	$bricks_hover = array(
		'cross'      => esc_html__( 'Show cross', 'barter' ),
		'drop'       => esc_html__( 'Drop', 'barter' ),
		'shift'      => esc_html__( 'Shift', 'barter' ),
		'pop'        => esc_html__( 'Pop text', 'barter' ),
		'border'     => esc_html__( 'Border', 'barter' ),
		'scale-down' => esc_html__( 'Scale down', 'barter' ),
		'none'       => esc_html__( 'None', 'barter' ),
	);
	$barter_a13->barter_set_settings_set( 'bricks_hover', $bricks_hover );

	//tags allowed in descriptions
	$valid_tags = array(
		'a'      => array(
			'href' => array(),
		),
		'br'     => array(),
		'code'   => array(),
		'em'     => array(),
		'strong' => array(),
	);
	$barter_a13->barter_set_settings_set( 'valid_tags', $valid_tags );
	/*
	 *
	 * ---> START SECTIONS
	 *
	 */

//GENERAL SETTINGS
	$barter_a13->barter_set_sections( array(
		'title'    => esc_html__( 'General settings', 'barter' ),
		'desc'     => '',
		'id'       => 'section_general_settings',
		'icon'     => 'el el-adjust-alt',
		'priority' => 3,
		'fields'   => array()
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Front page', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_general_front_page',
		'icon'       => 'fa fa-home',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'fp_variant',
				'type'        => 'select',
				'title'       => esc_html__( 'What to show on the front page?', 'barter' ),
				/* translators: %s: URL */
				'description' => sprintf( wp_kses( __( 'If you choose <strong>Page</strong> then make sure that in <a href="%s">WordPress Homepage Settings</a> you have selected <strong>A static page</strong>, that you wish to use as the front page.', 'barter' ), $valid_tags ), 'javascript:wp.customize.section( \'static_front_page\' ).focus();' ),
				'options'     => array(
					'page'         => esc_html__( 'Page', 'barter' ),
					'blog'         => esc_html__( 'Blog', 'barter' ),
				),
				'default'     => 'page',

			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'General layout', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_main_settings',
		'icon'       => 'fa fa-wrench',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'appearance_body_image',
				'type'    => 'image',
				'title'   => esc_html__( 'Background image', 'barter' ),
				'partial' => array(
					'selector'            => '.page-background',
					'container_inclusive' => true,
					'settings'            => array(
						'appearance_body_image',
						'appearance_body_image_fit',
						'appearance_body_bg_color',
					),
					'render_callback'     => 'barter_page_background',
				),
			),
			array(
				'id'      => 'appearance_body_image_fit',
				'type'    => 'select',
				'title'   => esc_html__( 'How to fit the background image', 'barter' ),
				'options' => $image_fit,
				'default' => 'cover',
				'partial' => true,
			),
			array(
				'id'      => 'appearance_body_bg_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Background color', 'barter' ),
				'default' => '#999999',
				'partial' => true,
			),
			array(
				'id'          => 'layout_type',
				'type'        => 'radio',
				'title'       => esc_html__( 'Layout', 'barter' ),
				'options'     => array(
					'full' => esc_html__( 'Full width', 'barter' ),
				),
				'default'     => 'full',
			),
			array(
				'id'      => 'custom_cursor',
				'type'    => 'radio',
				'title'   => esc_html__( 'Mouse cursor', 'barter' ),
				'options' => array(
					'default' => esc_html__( 'Normal', 'barter' ),
					'select'  => esc_html__( 'Predefined', 'barter' ),
					'custom'  => esc_html__( 'Custom', 'barter' ),
				),
				'default' => 'default',
				'js'      => true,
			),
			array(
				'id'       => 'cursor_select',
				'type'     => 'select',
				'title'    => esc_html__( 'Cursor', 'barter' ),
				'options'  => $cursors,
				'default'  => 'empty_black_white.png',
				'required' => array( 'custom_cursor', '=', 'select' ),
				'js'       => true,
			),
			array(
				'id'       => 'cursor_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Custom cursor image', 'barter' ),
				'required' => array( 'custom_cursor', '=', 'custom' ),
				'js'       => true,
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Page preloader', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_page_preloader',
		'icon'       => 'fa fa-spinner',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'preloader',
				'type'        => 'radio',
				'title'       => esc_html__( 'Page preloader', 'barter' ),
				'options'     => $on_off,
				'default'     => 'on',
				'js'          => true,
			),
			array(
				'id'          => 'preloader_hide_event',
				'type'        => 'radio',
				'title'       => esc_html__( 'Hide event', 'barter' ),
				'description' => wp_kses( __( '<strong>On load</strong> is called when the whole site, with all the images, is loaded, which can take a lot of time on heavier sites, and even more time on mobile devices. Also,  it can sometimes hang and never hide the preloader, when there is a problem with some resource. <br /><strong>On DOM ready</strong> is called when the whole HTML with CSS is loaded, so after the preloader is hidden, you can still see the loading of images. This is a much safer option.', 'barter' ), $valid_tags ),
				'options'     => array(
					'ready' => esc_html__( 'On DOM ready', 'barter' ),
					'load'  => esc_html__( 'On load', 'barter' ),
				),
				'default'     => 'ready',
				'required'    => array( 'preloader', '=', 'on' ),
				'js'          => true,
			),
			array(
				'id'       => 'preloader_bg_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Background image', 'barter' ),
				'required' => array( 'preloader', '=', 'on' ),
				'partial'  => array(
					'selector'            => '#preloader',
					'container_inclusive' => true,
					'settings'            => array(
						'preloader_bg_image',
						'preloader_bg_image_fit',
						'preloader_bg_color',
						'preloader_type',
						'preloader_color',
					),
					'render_callback'     => 'barter_page_preloader',
				),
			),
			array(
				'id'       => 'preloader_bg_image_fit',
				'type'     => 'select',
				'title'    => esc_html__( 'How to fit the background image', 'barter' ),
				'options'  => $image_fit,
				'default'  => 'cover',
				'required' => array( 'preloader', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'       => 'preloader_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Background color', 'barter' ),
				'default'  => '',
				'required' => array( 'preloader', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'       => 'preloader_type',
				'type'     => 'select',
				'title'    => esc_html__( 'Type', 'barter' ),
				'options'  => array(
					'none'              => esc_html__( 'none', 'barter' ),
					'atom'              => esc_html__( 'Atom', 'barter' ),
					'flash'             => esc_html__( 'Flash', 'barter' ),
					'indicator'         => esc_html__( 'Indicator', 'barter' ),
					'radar'             => esc_html__( 'Radar', 'barter' ),
					'circle_illusion'   => esc_html__( 'Circle Illusion', 'barter' ),
					'square_of_squares' => esc_html__( 'Square of squares', 'barter' ),
					'plus_minus'        => esc_html__( 'Plus minus', 'barter' ),
					'hand'              => esc_html__( 'Hand', 'barter' ),
					'blurry'            => esc_html__( 'Blurry', 'barter' ),
					'arcs'              => esc_html__( 'Arcs', 'barter' ),
					'tetromino'         => esc_html__( 'Tetromino', 'barter' ),
					'infinity'          => esc_html__( 'Infinity', 'barter' ),
					'cloud_circle'      => esc_html__( 'Cloud circle', 'barter' ),
					'dots'              => esc_html__( 'Dots', 'barter' ),
					'jet_pack_man'      => esc_html__( 'Jet-Pack-Man', 'barter' ),
					'circle'            => 'Circle'
				),
				'default'  => 'flash',
				'required' => array( 'preloader', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'       => 'preloader_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Animation color', 'barter' ),
				'required' => array(
					array( 'preloader', '=', 'on' ),
					array( 'preloader_type', '!=', 'tetromino' ),
					array( 'preloader_type', '!=', 'blurry' ),
					array( 'preloader_type', '!=', 'square_of_squares' ),
					array( 'preloader_type', '!=', 'circle_illusion' ),
				),
				'default'  => '',
				'partial'  => true,
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Theme Header', 'barter' ),
		'desc'       => esc_html__( 'Theme header is a place where you usually find the logo of your site, main menu, and a few other elements.', 'barter' ),
		'id'         => 'subsection_header',
		'icon'       => 'fa fa-ellipsis-h',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'header_switch',
				'type'    => 'radio',
				'title'   => esc_html__( 'Theme Header', 'barter' ),
				'description' => esc_html__( 'If you do not plan to use theme header or want to replace it with something else, just disable it here.', 'barter' ),
				'options' => $on_off,
				'default' => 'on',
			)
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Footer', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_footer',
		'icon'       => 'fa fa-ellipsis-h',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'footer_switch',
				'type'    => 'radio',
				'title'   => esc_html__( 'Footer', 'barter' ),
				'options' => $on_off,
				'default' => 'on',
				'partial'     => array(
					'selector'            => '#footer',
					'container_inclusive' => true,
					'settings'            => array(
						'footer_switch',
						'footer_widgets_columns',
						'footer_text',
						'footer_privacy_link',
						'footer_content_width',
						'footer_content_style',
						'footer_bg_color',
						'footer_lower_bg_color',
						'footer_lower_bg_color',
						'footer_widgets_color',
						'footer_font_size',
						'footer_widgets_font_size',
						'footer_font_color',
						'footer_link_color',
						'footer_hover_color',
					),
					'render_callback'     => 'barter_theme_footer',
				),
			),
			array(
				'id'          => 'footer_logo',
				'type'        => 'image',
				'title'       => esc_html__( 'Footer Logo', 'barter' ),
				'default'     => '',
				'required'    => array( 'footer_switch', '=', 'on' ),
				'partial'     => true,
			),
			array(
				'id'          => 'footer_logo_link',
				'type'        => 'text',
				'title'       => esc_html__( 'Footer Logo Link', 'barter' ),
				'default'     => '',
				'required'    => array( 'footer_switch', '=', 'on' ),
				'partial'     => true,
			),
			array(
				'id'       => 'footer_widgets_columns',
				'type'     => 'select',
				'title'    => esc_html__( 'Widgets columns number', 'barter' ),
				'options'  => array(
					'1' => esc_html__( '1', 'barter' ),
					'2' => esc_html__( '2', 'barter' ),
					'3' => esc_html__( '3', 'barter' ),
					'4' => esc_html__( '4', 'barter' ),
					'5' => esc_html__( '5', 'barter' ),
				),
				'default'  => '4',
				'required' => array( 'footer_switch', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'          => 'footer_text',
				'type'        => 'textarea',
				'title'       => esc_html__( 'Content', 'barter' ),
				'description' => esc_html__( 'You can use HTML here.', 'barter' ),
				'default'     => '',
				'required'    => array( 'footer_switch', '=', 'on' ),
				'partial'     => true,
			),
			array(
				'id'          => 'footer_privacy_link',
				'type'        => 'radio',
				'title'       => esc_html__( 'Privacy Policy Link', 'barter' ),
				'description' => esc_html__( 'Since WordPress 4.9.6 there is an option to set Privacy Policy page. If you enable this option it will display a link to it in the footer after footer content.', 'barter' ).' <a href="'.esc_url( admin_url( 'options-privacy.php' ) ).'">'.esc_html__( 'Here you can set your Privacy Policy page', 'barter' ).'</a>',
				'options'     => $on_off,
				'default'     => 'off',
				'required'    => array( 'footer_switch', '=', 'on' ),
				'partial'     => true,
			),
			array(
				'id'          => 'footer_socials',
				'type'        => 'radio',
				'title'       => esc_html__( 'Social icons', 'barter' ),
				/* translators: %s: URL */
				'description' => sprintf( wp_kses( __( 'If you need to edit social links go to <a href="%s">Social icons</a> settings.', 'barter' ), $valid_tags ), 'javascript:wp.customize.section( \'section_social\' ).focus();' ),
				'options'     => $on_off,
				'default'     => 'off',
				'required'    => array( 'footer_switch', '=', 'on' ),
				'partial'     => array(
					'selector'            => '.f-links',
					'container_inclusive' => true,
					'settings'            => array(
						'footer_socials',
						'footer_socials_color',
						'footer_socials_color_hover',
					),
					'render_callback'     => 'footer_socials'
				),
			),
			array(
				'id'       => 'footer_socials_color',
				'type'     => 'select',
				'title'    => esc_html__( 'Social icons', 'barter' ). ' : ' .esc_html__( 'Color', 'barter' ),
				'options'  => $social_colors,
				'default'  => 'black',
				'required' => array(
					array( 'footer_switch', '=', 'on' ),
					array( 'footer_socials', '=', 'on' ),
				),
				'partial'  => true,
			),
			array(
				'id'       => 'footer_socials_color_hover',
				'type'     => 'select',
				'title'    => esc_html__( 'Social icons', 'barter' ). ' : ' .esc_html__( 'Color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'options'  => $social_colors,
				'default'  => 'semi-transparent',
				'required' => array(
					array( 'footer_switch', '=', 'on' ),
					array( 'footer_socials', '=', 'on' ),
				),
				'partial'  => true,
			),
			array(
				'id'       => 'footer_content_width',
				'type'     => 'radio',
				'title'    => esc_html__( 'Content', 'barter' ). ' : ' .esc_html__( 'Width', 'barter' ),
				'options'  => array(
					'narrow' => esc_html__( 'Narrow', 'barter' ),
					'full'   => esc_html__( 'Full width', 'barter' ),
				),
				'default'  => 'narrow',
				'required' => array( 'footer_switch', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'       => 'footer_content_style',
				'type'     => 'radio',
				'title'    => esc_html__( 'Content', 'barter' ). ' : ' .esc_html__( 'Style', 'barter' ),
				'options'  => array(
					'classic'  => esc_html__( 'Classic', 'barter' ),
					'centered' => esc_html__( 'Centered', 'barter' ),
				),
				'default'  => 'classic',
				'required' => array( 'footer_switch', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'       => 'footer_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Background color', 'barter' ),
				'default'  => '',
				'required' => array( 'footer_switch', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'       => 'footer_lower_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Lower part', 'barter' ). ' : ' .esc_html__( 'Background color', 'barter' ),
				'desc'     => esc_html__( 'If you want to have a different color in the lower part than in the footer widgets.', 'barter' ),
				'default'  => '',
				'required' => array( 'footer_switch', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'       => 'footer_widgets_color',
				'type'     => 'radio',
				'title'    => esc_html__( 'Widgets colors', 'barter' ),
				'desc'     => esc_html__( 'Depending on what background you have set up, choose proper option.', 'barter' ),
				'options'  => array(
					'dark-sidebar'  => esc_html__( 'On dark', 'barter' ),
					'light-sidebar' => esc_html__( 'On light', 'barter' ),
				),
				'default'  => 'dark-sidebar',
				'required' => array( 'footer_switch', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'       => 'footer_font_size',
				'type'     => 'slider',
				'title'    => esc_html__( 'Lower part', 'barter' ). ' : ' .esc_html__( 'Font size', 'barter' ),
				'default'  => 10,
				'min'      => 10,
				'max'      => 30,
				'step'     => 1,
				'unit'     => 'px',
				'required' => array( 'footer_switch', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'       => 'footer_widgets_font_size',
				'type'     => 'slider',
				'title'    => esc_html__( 'Widgets part', 'barter' ). ' : ' .esc_html__( 'Font size', 'barter' ),
				'default'  => 10,
				'min'      => 10,
				'max'      => 30,
				'step'     => 1,
				'unit'     => 'px',
				'required' => array( 'footer_switch', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'          => 'footer_font_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Lower part', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'description' => esc_html__( 'Does not work for footer widgets.', 'barter' ),
				'default'     => '',
				'required'    => array( 'footer_switch', '=', 'on' ),
				'partial'     => true,
			),
			array(
				'id'          => 'footer_link_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Lower part', 'barter' ). ' : ' .esc_html__( 'Links', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'description' => esc_html__( 'Does not work for footer widgets.', 'barter' ),
				'default'     => '',
				'required'    => array( 'footer_switch', '=', 'on' ),
				'partial'     => true,
			),
			array(
				'id'          => 'footer_hover_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Lower part', 'barter' ). ' : ' .esc_html__( 'Links', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'description' => esc_html__( 'Does not work for footer widgets.', 'barter' ),
				'default'     => '',
				'required'    => array( 'footer_switch', '=', 'on' ),
				'partial'     => true,
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Hidden sidebar', 'barter' ),
		'desc'       => esc_html__( 'It is active only if it contains active widgets. After activation, displays the opening button in the header.', 'barter' ),
		'id'         => 'subsection_hidden_sidebar',
		'icon'       => 'fa fa-columns',
		'subsection' => true,
		'fields'     => array(

			array(
				'id'      => 'hidden_sidebar_bg_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Background color', 'barter' ),
				'default' => '',
			),
			array(
				'id'      => 'hidden_sidebar_font_size',
				'type'    => 'slider',
				'title'   => esc_html__( 'Font size', 'barter' ),
				'default' => 10,
				'min'     => 5,
				'max'     => 30,
				'step'    => 1,
				'unit'    => 'px',
			),
			array(
				'id'          => 'hidden_sidebar_widgets_color',
				'type'        => 'radio',
				'title'       => esc_html__( 'Widgets colors', 'barter' ),
				'description' => esc_html__( 'Depending on what background you have set up, choose proper option.', 'barter' ),
				'options'     => array(
					'dark-sidebar'  => esc_html__( 'On dark', 'barter' ),
					'light-sidebar' => esc_html__( 'On light', 'barter' ),
				),
				'default'     => 'dark-sidebar',
			),
			array(
				'id'      => 'hidden_sidebar_side',
				'type'    => 'radio',
				'title'   => esc_html__( 'Side', 'barter' ),
				'options' => array(
					'left'  => esc_html__( 'Left', 'barter' ),
					'right' => esc_html__( 'Right', 'barter' ),
				),
				'default' => 'left',
			),
			array(
				'id'      => 'hidden_sidebar_effect',
				'type'    => 'select',
				'title'   => esc_html__( 'Opening effect', 'barter' ),
				'options' => array(
					'1' => esc_html__( 'Slide in on top', 'barter' ),
					'2' => esc_html__( 'Reveal', 'barter' ),
					'3' => esc_html__( 'Push', 'barter' ),
					'4' => esc_html__( 'Slide along', 'barter' ),
					'5' => esc_html__( 'Reverse slide out', 'barter' ),
					'6' => esc_html__( 'Fall down', 'barter' ),
				),
				'default' => '2',
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Fonts settings', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_fonts_settings',
		'icon'       => 'fa fa-font',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'nav_menu_fonts',
				'type'        => 'font',
				'title'       => esc_html__( 'Font for main navigation menu and overlay menu:', 'barter' ),
				'default'     => array(
					'font-family'    => 'Poppins',
					'word-spacing'   => 'normal',
					'letter-spacing' => 'normal'
				),
			),
			array(
				'id'          => 'titles_fonts',
				'type'        => 'font',
				'title'       => esc_html__( 'Font for Titles/Headings:', 'barter' ),
				'default'     => array(
					'font-family'    => 'Poppins',
					'word-spacing'   => 'normal',
					'letter-spacing' => 'normal'
				),
			),
			array(
				'id'          => 'normal_fonts',
				'type'        => 'font',
				'title'       => esc_html__( 'Font for normal(content) text:', 'barter' ),
				'default'     => array(
					'font-family'    => 'Poppins',
					'word-spacing'   => 'normal',
					'letter-spacing' => 'normal'
				),
			),
			array(
				'id'      => 'logo_fonts',
				'type'    => 'font',
				'title'   => esc_html__( 'Font for text logo:', 'barter' ),
				'default' => array(
					'font-family'    => 'Poppins',
					'word-spacing'   => 'normal',
					'letter-spacing' => 'normal'
				),
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Headings', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_heading_styles',
		'icon'       => 'fa fa-header',
		'subsection' => true,
		'fields'     => array(

			array(
				'id'      => 'headings_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Text color', 'barter' ),
				'default' => '',
			),
			array(
				'id'      => 'headings_color_hover',
				'type'    => 'color',
				'title'   => esc_html__( 'Text color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'default' => '',
			),
			array(
				'id'      => 'headings_weight',
				'type'    => 'select',
				'title'   => esc_html__( 'Font weight', 'barter' ),
				'options' => $font_weights,
				'default' => 'bold',
			),
			array(
				'id'      => 'headings_transform',
				'type'    => 'radio',
				'title'   => esc_html__( 'Text transform', 'barter' ),
				'options' => $font_transforms,
				'default' => 'none',
			),
			array(
				'id'      => 'page_title_font_size',
				'type'    => 'slider',
				'title'   => esc_html__( 'Main titles', 'barter' ). ' : ' .esc_html__( 'Font size', 'barter' ),
				'default' => 36,
				'min'     => 10,
				'step'    => 1,
				'max'     => 60,
				'unit'    => 'px',
			),
			array(
				'id'          => 'page_title_font_size_768',
				'type'        => 'slider',
				'title'       => esc_html__( 'Main titles', 'barter' ). ' : ' .esc_html__( 'Font size', 'barter' ). ' - ' .esc_html__( 'on mobile devices', 'barter' ),
				'description' => esc_html__( 'It will be used on devices less than 768 pixels wide.', 'barter' ),
				'min'         => 10,
				'max'         => 60,
				'step'        => 1,
				'unit'        => 'px',
				'default'     => 32,
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Content', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_content_styles',
		'icon'       => 'fa fa-align-left',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'content_bg_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Background color', 'barter' ),
				'description' => esc_html__( 'It will change the default white background color that is set under content on pages, blog, posts', 'barter' ),
				'default'     => '#ffffff',
			),
			array(
				'id'      => 'content_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Text color', 'barter' ),
				'default' => '#000000',
			),
			array(
				'id'      => 'content_link_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Links', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'default' => '',
			),
			array(
				'id'      => 'content_link_color_hover',
				'type'    => 'color',
				'title'   => esc_html__( 'Links', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'default' => '',
			),
			array(
				'id'      => 'content_font_size',
				'type'    => 'slider',
				'title'   => esc_html__( 'Font size', 'barter' ),
				'default' => 16,
				'min'     => 10,
				'step'    => 1,
				'max'     => 30,
				'unit'    => 'px',
			),
			array(
				'id'          => 'first_paragraph',
				'type'        => 'radio',
				'title'       => esc_html__( 'First paragraph', 'barter' ). ' : ' .esc_html__( 'Highlight', 'barter' ),
				'description' => esc_html__( 'If enabled, it highlights(font size and color) the first paragraph in the content(blog, post, page).', 'barter' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
			array(
				'id'       => 'first_paragraph_color',
				'type'     => 'color',
				'title'    => esc_html__( 'First paragraph', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'default'  => '',
				'required' => array( 'first_paragraph', '=', 'on' ),
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Social icons', 'barter' ),
		'desc'       => esc_html__( 'These icons will be used in various places across theme if you decide to activate them.', 'barter' ),
		'id'         => 'section_social',
		'icon'       => 'fa fa-facebook-official',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'socials_variant',
				'type'    => 'radio',
				'title'   => esc_html__( 'Type of icons', 'barter' ),
				'options' => array(
					'squares'    => esc_html__( 'Squares', 'barter' ),
					'circles'    => esc_html__( 'Circles', 'barter' ),
					'icons-only' => esc_html__( 'Only icons', 'barter' ),
				),
				'default' => 'squares',
			),
			array(
				'id'          => 'social_services',
				'type'        => 'socials',
				'title'       => esc_html__( 'Links', 'barter' ),
				'description' => esc_html__( 'Drag and drop to change order of icons. Only filled links will show up as social icons.', 'barter' ),
				'label'       => false,
				'options'     => $barter_a13->barter_get_social_icons_list( 'names' ),
				'default'     => $barter_a13->barter_get_social_icons_list( 'empty' )
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Lightbox settings', 'barter' ),
		'desc'       => esc_html__( 'If you wish to use some other plugin/script for images and items, you can switch off default theme lightbox. If you are planning to use different lightbox script instead, then you will have to do some extra work with scripting to make it work in every theme place.', 'barter' ),
		'id'         => 'subsection_lightbox',
		'icon'       => 'fa fa-picture-o',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'skt_lightbox',
				'type'        => 'radio',
				'title'       => esc_html__( 'Theme lightbox', 'barter' ),
				'options'     => array(
					'lightGallery' => esc_html__( 'Light Gallery', 'barter' ),
					'off'          => esc_html__( 'Disable', 'barter' ),
				),
				'default'     => 'lightGallery',
			),
			array(
				'id'          => 'lightbox_single_post',
				'type'        => 'radio',
				'title'       => esc_html__( 'Use theme lightbox for images in posts', 'barter' ),
				'description' => esc_html__( 'If enabled, the theme will use a lightbox to display images in the post content. To work properly, Images should link to "Media File".', 'barter' ),
				'options'     => $on_off,
				'default'     => 'off',
				'required'    => array( 'skt_lightbox', '=', 'lightGallery' ),
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Widgets', 'barter' ),
		'id'         => 'subsection_widgets',
		'icon'       => 'fa fa-puzzle-piece',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'widgets_top_margin',
				'type'        => 'radio',
				'title'       => esc_html__( 'Top margin', 'barter' ),
				'description' => esc_html__( 'It only affects the widgets in the vertical sidebars.', 'barter' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
			array(
				'id'      => 'widget_title_font_size',
				'type'    => 'slider',
				'title'   => esc_html__( 'Main titles', 'barter' ). ' : ' .esc_html__( 'Font size', 'barter' ),
				'min'     => 10,
				'max'     => 60,
				'step'    => 1,
				'unit'    => 'px',
				'default' => 26,
			),
			array(
				'id'          => 'widget_font_size',
				'type'        => 'slider',
				'title'       => esc_html__( 'Content', 'barter' ). ' : ' .esc_html__( 'Font size', 'barter' ),
				'description' => esc_html__( 'It only affects the widgets in the vertical sidebars.', 'barter' ),
				'min'         => 5,
				'max'         => 30,
				'step'        => 1,
				'unit'        => 'px',
				'default'     => 16,
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'To top button', 'barter' ),
		'id'         => 'subsection_to_top',
		'icon'       => 'fa fa-chevron-up',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'to_top',
				'type'        => 'radio',
				'title'       => esc_html__( 'To top button', 'barter' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
			array(
				'id'      => 'to_top_bg_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Background color', 'barter' ),
				'default' => '#524F51',
				'required' => array( 'to_top', '=', 'on' ),
			),
			array(
				'id'      => 'to_top_bg_hover_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Background color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'default' => '#a88057',
				'required' => array( 'to_top', '=', 'on' ),
			),
			array(
				'id'      => 'to_top_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Icon', 'barter' ). ' : ' .esc_html__( 'Color', 'barter' ),
				'default' => '#cccccc',
				'required' => array( 'to_top', '=', 'on' ),
			),
			array(
				'id'      => 'to_top_hover_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Icon', 'barter' ). ' : ' .esc_html__( 'Color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'default' => '#ffffff',
				'required' => array( 'to_top', '=', 'on' ),
			),
			array(
				'id'      => 'to_top_font_size',
				'type'    => 'slider',
				'title'   => esc_html__( 'Icon', 'barter' ). ' : ' .esc_html__( 'Font size', 'barter' ),
				'min'     => 10,
				'step'    => 1,
				'max'     => 60,
				'unit'    => 'px',
				'default' => 13,
				'required' => array( 'to_top', '=', 'on' ),
			),
			array(
				'id'          => 'to_top_icon',
				'type'        => 'text',
				'title'       => esc_html__( 'Icon', 'barter' ),
				'default'     => 'chevron-up',
				'input_attrs' => array(
					'class' => 'a13-fa-icon',
				),
				'required' => array( 'to_top', '=', 'on' ),
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Buttons', 'barter' ),
		'desc'       => esc_html__( 'You can change here colors of buttons that submit forms. For shop buttons, go to the shop settings.', 'barter' ),
		'id'         => 'subsection_buttons',
		'icon'       => 'fa fa-arrow-down',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'button_submit_bg_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Background color', 'barter' ),
				'default' => '#524F51',
			),
			array(
				'id'      => 'button_submit_bg_hover_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Background color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'default' => '#000000',
			),
			array(
				'id'      => 'button_submit_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Text color', 'barter' ),
				'default' => '#cccccc'
			),
			array(
				'id'      => 'button_submit_hover_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Text color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'default' => '#ffffff'
			),
			array(
				'id'      => 'button_submit_font_size',
				'type'    => 'slider',
				'title'   => esc_html__( 'Font size', 'barter' ),
				'min'     => 10,
				'max'     => 60,
				'step'    => 1,
				'unit'    => 'px',
				'default' => 13,
			),
			array(
				'id'      => 'button_submit_weight',
				'type'    => 'select',
				'title'   => esc_html__( 'Font weight', 'barter' ),
				'options' => $font_weights,
				'default' => 'bold',
			),
			array(
				'id'      => 'button_submit_transform',
				'type'    => 'radio',
				'title'   => esc_html__( 'Text transform', 'barter' ),
				'options' => $font_transforms,
				'default' => 'uppercase',
			),
			array(
				'id'      => 'button_submit_padding',
				'type'    => 'spacing',
				'title'   => esc_html__( 'Padding', 'barter' ),
				'mode'    => 'padding',
				'sides'   => array( 'left', 'right' ),
				'units'   => array( 'px', 'em' ),
				'default' => array(
					'padding-left'  => '30px',
					'padding-right' => '30px',
					'units'         => 'px'
				),
			),
			array(
				'id'          => 'button_submit_radius',
				'type'        => 'slider',
				'title'       => esc_html__( 'Border radius', 'barter' ),
				'min'         => 0,
				'max'         => 20,
				'step'        => 1,
				'unit'        => 'px',
				'default'     => 20,
			),
		)
	) );

//HEADER SETTINGS
	$barter_a13->barter_set_sections( array(
		'title'    => esc_html__( 'Header settings', 'barter' ),
		'desc'     => '',
		'id'       => 'section_header_settings',
		'icon'     => 'el el-magic',
		'priority' => 6,
		'fields'   => array()
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Type, variant, background', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_header_type',
		'icon'       => 'fa fa-cogs',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'header_type',
				'type'        => 'radio',
				'title'       => esc_html__( 'Type', 'barter' ),
				'options'     => array(
					'horizontal' => esc_html__( 'Horizontal', 'barter' ),
				),
				'default'     => 'horizontal',
			),
			array(
				'id'       => 'header_horizontal_sticky',
				'type'     => 'select',
				'title'    => esc_html__( 'Sticky version', 'barter' ),
				'options'  => array(
					'sticky-no-hiding'   => esc_html__( 'No hiding sticky', 'barter' ),
					'no-sticky no-fixed' => esc_html__( 'Disabled, show only default header(not fixed)', 'barter' ),
					'no-sticky'          => esc_html__( 'Disabled, show only default header fixed', 'barter' )
				),
				'default'  => 'sticky-no-hiding',
				'required' => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'          => 'header_horizontal_variant',
				'type'        => 'select',
				'title'       => esc_html__( 'Variant', 'barter' ),
				'options'     => array(
					'one_line'               => esc_html__( 'One line, logo on side', 'barter' ),
					'one_line_menu_centered' => esc_html__( 'One line, menu centered', 'barter' ),
				),
				'default'     => 'one_line',
				'required'    => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'          => 'header_color_variants',
				'type'        => 'select',
				'title'       => esc_html__( 'Header color variants', 'barter' ),
				'description' => esc_html__( 'If you want to use theme header color variants(light and dark variants) or the sticky header variant, then enable this option. Some settings of the header can then be overridden in color & sticky variants.', 'barter' ),
				'options'     => array(
					'sticky' => esc_html__( 'Turn on only for a sticky variant', 'barter' ),
					'off'    => esc_html__( 'Disable', 'barter' ),
				),
				'default'     => 'sticky',
				'required'    => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'       => 'header_content_width',
				'type'     => 'radio',
				'title'    => esc_html__( 'Content width', 'barter' ),
				'options'  => array(
					'narrow' => esc_html__( 'Narrow', 'barter' ),
					'full'   => esc_html__( 'Full width', 'barter' ),
				),
				'default'  => 'full',
				'required' => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'       => 'header_content_width_narrow_bg',
				'type'     => 'radio',
				'title'    => esc_html__( 'Narrow the entire header as well', 'barter' ),
				'options'  => $on_off,
				'default'  => 'off',
				'required' => array(
					array( 'header_type', '=', 'horizontal' ),
					array( 'header_content_width', '=', 'narrow' )
				),
			),
			array(
				'id'      => 'header_bg_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Background color', 'barter' ),
				'default' => '#ffffff',
			),
			array(
				'id'          => 'header_bg_hover_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Background color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'description' => esc_html__( 'Useful in special cases, like when you make a transparent header.', 'barter' ),
				'default'     => '',
			),
			array(
				'id'       => 'header_border',
				'type'     => 'radio',
				'title'    => esc_html__( 'Bottom border', 'barter' ),
				'options'  => $on_off,
				'default'  => 'on',
				'required' => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'      => 'header_shadow',
				'type'    => 'radio',
				'title'   => esc_html__( 'Shadow', 'barter' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'       => 'header_separators_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Separator and lines color', 'barter' ),
				'default'  => '',
				'required' => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'          => 'header_socials',
				'type'        => 'radio',
				'title'       => esc_html__( 'Social icons', 'barter' ),
				/* translators: %s: URL */
				'description' => sprintf( wp_kses( __( 'If you need to edit social links go to <a href="%s">Social icons</a> settings.', 'barter' ), $valid_tags ), 'javascript:wp.customize.section( \'section_social\' ).focus();' ),
				'options'     => $on_off,
				'default'     => 'off',
				'required'    => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'       => 'header_socials_color',
				'type'     => 'select',
				'title'    => esc_html__( 'Social icons', 'barter' ). ' : ' .esc_html__( 'Color', 'barter' ),
				'options'  => $social_colors,
				'default'  => 'white',
				'required' => array(
					array( 'header_type', '=', 'horizontal' ),
					array( 'header_socials', '=', 'on' ),
				)
			),
			array(
				'id'       => 'header_socials_color_hover',
				'type'     => 'select',
				'title'    => esc_html__( 'Social icons', 'barter' ). ' : ' .esc_html__( 'Color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'options'  => $social_colors,
				'default'  => 'color',
				'required' => array(
					array( 'header_type', '=', 'horizontal' ),
					array( 'header_socials', '=', 'on' ),
				)
			),
			array(
				'id'          => 'header_socials_display_on_mobile',
				'type'        => 'radio',
				'title'       => esc_html__( 'Social icons', 'barter' ). ' - ' .esc_html__( 'Display it on mobiles', 'barter' ),
				'description' => esc_html__( 'Should it be displayed on devices less than 600 pixels wide.', 'barter' ),
				'options'     => $on_off,
				'default'     => 'on',
				'required'    => array(
					array( 'header_type', '=', 'horizontal' ),
					array( 'header_socials', '=', 'on' ),
				)
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Logo', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_logo',
		'icon'       => 'fa fa-picture-o',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'logo_from_variants',
				'type'        => 'radio',
				'title'       => esc_html__( 'Use logos from header variants', 'barter' ),
				'description' => esc_html__( 'If you want to be able to change the logo in header color variants (light and dark variants) or in the sticky header variant, then enable this option.', 'barter' ),
				'options'     => $on_off,
				'default'     => 'off',
				'required'    => array(
					array( 'header_type', '=', 'horizontal' ),
					array( 'header_color_variants', '!=', 'off' ),
				)
			),
			array(
				'id'      => 'logo_type',
				'type'    => 'radio',
				'title'   => esc_html__( 'Type', 'barter' ),
				'options' => array(
					'image' => esc_html__( 'Image', 'barter' ),
					'text'  => esc_html__( 'Text', 'barter' ),
				),
				'default' => 'image',
			),
			array(
				'id'          => 'logo_image',
				'type'        => 'image',
				'title'       => esc_html__( 'Image', 'barter' ),
				'description' => esc_html__( 'Upload an image for logo.', 'barter' ),
				'default'     => '',
				'required'    => array( 'logo_type', '=', 'image' ),
			),
			array(
				'id'          => 'logo_image_high_dpi',
				'type'        => 'image',
				'title'       => esc_html__( 'Image for HIGH DPI screen', 'barter' ),
				'description' => esc_html__( 'For example Retina(iPhone/iPad) screen has HIGH DPI screen.', 'barter' ) . ' ' . esc_html__( 'Upload an image for logo.', 'barter' ),
				'default'     => '',
				'required'    => array( 'logo_type', '=', 'image' ),
			),
			array(
				'id'          => 'logo_image_max_desktop_width',
				'type'        => 'slider',
				'title'       => esc_html__( 'Max width', 'barter' ). ' - ' .esc_html__( 'on desktop', 'barter' ),
				'description' => esc_html__( 'Works only with the horizontal header.', 'barter' ) .' '. esc_html__( 'It works only on large screens(1025px wide or more).', 'barter' ),
				'min'         => 25,
				'step'        => 1,
				'max'         => 400,
				'unit'        => 'px',
				'default'     => 200,
				'required'    => array(
					array( 'logo_type', '=', 'image' ),
					array( 'header_type', '=', 'horizontal' ),
				)
			),
			array(
				'id'          => 'logo_image_max_mobile_width',
				'type'        => 'slider',
				'title'       => esc_html__( 'Max width', 'barter' ). ' - ' .esc_html__( 'on mobile devices', 'barter' ),
				'description' => esc_html__( 'It works only on mobile devices(1024px wide or less).', 'barter' ),
				'min'         => 25,
				'max'         => 250,
				'step'        => 1,
				'unit'        => 'px',
				'default'     => 200,
				'required'    => array(
					array( 'logo_type', '=', 'image' ),
				)
			),
			array(
				'id'          => 'logo_image_height',
				'type'        => 'slider',
				'title'       => esc_html__( 'Height', 'barter' ),
				'description' => esc_html__( 'Leave empty if you do not need anything fancy', 'barter' ),
				'min'         => 0,
				'max'         => 100,
				'step'        => 1,
				'unit'        => 'px',
				'default'     => '',
				'required'    => array( 'logo_type', '=', 'image' ),
			),
			array(
				'id'       => 'logo_image_normal_opacity',
				'type'     => 'slider',
				'title'    => esc_html__( 'Opacity', 'barter' ),
				'min'      => 0,
				'max'      => 1,
				'step'     => 0.01,
				'default'  => '1.00',
				'required' => array( 'logo_type', '=', 'image' ),
			),
			array(
				'id'       => 'logo_image_hover_opacity',
				'type'     => 'slider',
				'title'    => esc_html__( 'Opacity', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'min'      => 0,
				'max'      => 1,
				'step'     => 0.01,
				'default'  => '0.50',
				'required' => array( 'logo_type', '=', 'image' ),
			),
			array(
				'id'          => 'logo_text',
				'type'        => 'text',
				'title'       => esc_html__( 'Text', 'barter' ),
				'description' => wp_kses( __( 'If you use more than one word in the logo, you can use <code>&amp;nbsp;</code> instead of a white space, so the words will not break into many lines.', 'barter' ), $valid_tags ).
				                 /* translators: %s: Customizer JS URL */
				                 '<br />'.sprintf( wp_kses( __( 'If you want to change the font for logo go to <a href="%s">Font settings</a>.', 'barter' ), $valid_tags ), 'javascript:wp.customize.control( \''.BARTER_OPTIONS_NAME.'[logo_fonts]\' ).focus();' ),
				'default'     => get_bloginfo( 'name' ),
				'required'    => array( 'logo_type', '=', 'text' ),
			),
			array(
				'id'       => 'logo_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Text color', 'barter' ),
				'default'  => '',
				'required' => array( 'logo_type', '=', 'text' ),
			),
			array(
				'id'       => 'logo_color_hover',
				'type'     => 'color',
				'title'    => esc_html__( 'Text color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'default'  => '',
				'required' => array( 'logo_type', '=', 'text' ),
			),
			array(
				'id'       => 'logo_font_size',
				'type'     => 'slider',
				'title'    => esc_html__( 'Font size', 'barter' ),
				'min'      => 10,
				'max'      => 60,
				'step'     => 1,
				'unit'     => 'px',
				'default'  => 26,
				'required' => array( 'logo_type', '=', 'text' ),
			),
			array(
				'id'       => 'logo_weight',
				'type'     => 'select',
				'title'    => esc_html__( 'Font weight', 'barter' ),
				'options'  => $font_weights,
				'default'  => 'normal',
				'required' => array( 'logo_type', '=', 'text' ),
			),
			array(
				'id'          => 'logo_padding',
				'type'        => 'spacing',
				'title'       => esc_html__( 'Padding', 'barter' ). ' - ' .esc_html__( 'on desktop', 'barter' ),
				'description' => esc_html__( 'It works only on large screens(1025px wide or more).', 'barter' ),
				'mode'        => 'padding',
				'sides'       => array( 'top', 'bottom' ),
				'units'       => array( 'px', 'em' ),
				'default'     => array(
					'padding-top'    => '10px',
					'padding-bottom' => '10px',
					'units'          => 'px'
				)
			),
			array(
				'id'          => 'logo_padding_mobile',
				'type'        => 'spacing',
				'title'       => esc_html__( 'Padding', 'barter' ). ' - ' .esc_html__( 'on mobile devices', 'barter' ),
				'description' => esc_html__( 'It works only on mobile devices(1024px wide or less).', 'barter' ),
				'mode'        => 'padding',
				'sides'       => array( 'top', 'bottom' ),
				'units'       => array( 'px', 'em' ),
				'default'     => array(
					'padding-top'    => '10px',
					'padding-bottom' => '10px',
					'units'          => 'px'
				)
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Main Menu', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_header_menu',
		'icon'       => 'fa fa-bars',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'       => 'menu_font_size',
				'type'     => 'slider',
				'title'    => esc_html__( 'Font size', 'barter' ),
				'min'      => 10,
				'max'      => 30,
				'step'     => 1,
				'unit'     => 'px',
				'default'  => 16,
				'required' => array( 'header_main_menu', '=', 'on' ),
			),
			array(
				'id'       => 'menu_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Links', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'default'  => '#222222',
				'required' => array( 'header_main_menu', '=', 'on' ),
			),
			array(
				'id'       => 'menu_hover_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Links', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ). ' - ' .esc_html__( 'on hover/active', 'barter' ),
				'default'  => '#a88057',
				'required' => array( 'header_main_menu', '=', 'on' ),
			),
			array(
				'id'       => 'menu_weight',
				'type'     => 'select',
				'title'    => esc_html__( 'Font weight', 'barter' ),
				'options'  => $font_weights,
				'default'  => 'normal',
				'required' => array( 'header_main_menu', '=', 'on' ),
			),
			array(
				'id'       => 'menu_transform',
				'type'     => 'radio',
				'title'    => esc_html__( 'Text transform', 'barter' ),
				'options'  => $font_transforms,
				'default'  => 'uppercase',
				'required' => array( 'header_main_menu', '=', 'on' ),
			),
			array(
				'id'       => 'submenu_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Submenu/Mega-Menu', 'barter' ). ' : ' .esc_html__( 'Background color', 'barter' ),
				'default'  => '#ffffff',
				'required' => array( 'header_main_menu', '=', 'on' ),
			),
			array(
				'id'       => 'submenu_weight',
				'type'     => 'select',
				'title'    => esc_html__( 'Submenu/Mega-Menu', 'barter' ). ' : ' .esc_html__( 'Font weight', 'barter' ),
				'options'  => $font_weights,
				'default'  => 'normal',
				'required' => array( 'header_main_menu', '=', 'on' ),
			),
			array(
				'id'       => 'submenu_transform',
				'type'     => 'radio',
				'title'    => esc_html__( 'Submenu/Mega-Menu', 'barter' ). ' : ' .esc_html__( 'Text transform', 'barter' ),
				'options'  => $font_transforms,
				'default'  => 'uppercase',
				'required' => array( 'header_main_menu', '=', 'on' ),
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Sticky header', 'barter' ). ' - ' .esc_html__( 'Override normal settings', 'barter' ),
		'desc'       => esc_html__( 'Works only with the horizontal header.', 'barter' ) .' '. esc_html__( 'You can change some options here to modify the appearance of the sticky header(if it is enabled).', 'barter' ),
		'id'         => 'subsection_header_sticky',
		'icon'       => 'fa fa-thumb-tack',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'header_sticky_logo_image',
				'type'        => 'image',
				'title'       => esc_html__( 'Logo', 'barter' ). ' : ' .esc_html__( 'Image', 'barter' ),
				'description' => esc_html__( 'Upload an image for logo.', 'barter' ),
				'default'     => '',
				'required'    => array(
					array( 'logo_type', '=', 'image' ),
					array( 'logo_from_variants', '=', 'on' ),
				)
			),
			array(
				'id'          => 'header_sticky_logo_image_high_dpi',
				'type'        => 'image',
				'title'       => esc_html__( 'Logo', 'barter' ). ' : ' .esc_html__( 'Image for HIGH DPI screen', 'barter' ),
				'description' => esc_html__( 'For example Retina(iPhone/iPad) screen has HIGH DPI screen.', 'barter' ) . ' ' . esc_html__( 'Upload an image for logo.', 'barter' ),
				'default'     => '',
				'required'    => array(
					array( 'logo_type', '=', 'image' ),
					array( 'logo_from_variants', '=', 'on' ),
				)
			),
			array(
				'id'          => 'header_sticky_logo_image_max_desktop_width',
				'type'        => 'slider',
				'title'       => esc_html__( 'Logo', 'barter' ). ' : ' .esc_html__( 'Max width', 'barter' ). ' - ' .esc_html__( 'on desktop', 'barter' ),
				'description' => esc_html__( 'It works only on large screens(1025px wide or more).', 'barter' ),
				'min'         => 25,
				'step'        => 1,
				'max'         => 400,
				'unit'        => 'px',
				'default'     => 200,
				'required'    => array(
					array( 'logo_type', '=', 'image' ),
					array( 'header_type', '=', 'horizontal' ),
				)
			),
			array(
				'id'          => 'header_sticky_logo_image_max_mobile_width',
				'type'        => 'slider',
				'title'       => esc_html__( 'Logo', 'barter' ). ' : ' .esc_html__( 'Max width', 'barter' ). ' - ' .esc_html__( 'on mobile devices', 'barter' ),
				'description' => esc_html__( 'It works only on mobile devices(1024px wide or less).', 'barter' ),
				'min'         => 25,
				'max'         => 250,
				'step'        => 1,
				'unit'        => 'px',
				'default'     => 200,
				'required'    => array(
					array( 'logo_type', '=', 'image' ),
					array( 'header_type', '=', 'horizontal' ),
				)
			),
			array(
				'id'      => 'header_sticky_logo_padding',
				'type'    => 'spacing',
				'title'   => esc_html__( 'Logo', 'barter' ). ' : ' .esc_html__( 'Padding', 'barter' ). ' - ' .esc_html__( 'on desktop', 'barter' ),
				'description' => esc_html__( 'It works only on large screens(1025px wide or more).', 'barter' ),
				'mode'    => 'padding',
				'sides'   => array( 'top', 'bottom' ),
				'units'   => array( 'px', 'em' ),
				'default' => array(
					'padding-top'    => '10px',
					'padding-bottom' => '10px',
					'units'          => 'px'
				),
			),
			array(
				'id'          => 'header_sticky_logo_padding_mobile',
				'type'        => 'spacing',
				'title'       => esc_html__( 'Logo', 'barter' ). ' : ' .esc_html__( 'Padding', 'barter' ). ' - ' .esc_html__( 'on mobile devices', 'barter' ),
				'description' => esc_html__( 'It works only on mobile devices(1024px wide or less).', 'barter' ),
				'mode'        => 'padding',
				'sides'       => array( 'top', 'bottom' ),
				'units'       => array( 'px', 'em' ),
				'default'     => array(
					'padding-top'    => '10px',
					'padding-bottom' => '10px',
					'units'          => 'px'
				),
			),
			array(
				'id'       => 'header_sticky_logo_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Logo', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'default'  => '',
				'required' => array(
					array( 'logo_type', '=', 'text' ),
					array( 'logo_from_variants', '=', 'on' ),
				)
			),
			array(
				'id'       => 'header_sticky_logo_color_hover',
				'type'     => 'color',
				'title'    => esc_html__( 'Logo', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'default'  => '',
				'required' => array(
					array( 'logo_type', '=', 'text' ),
					array( 'logo_from_variants', '=', 'on' ),
				)
			),
			array(
				'id'      => 'header_sticky_menu_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Main Menu', 'barter' ). ' : ' .esc_html__( 'Links', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'default' => '',
			),
			array(
				'id'      => 'header_sticky_menu_hover_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Main Menu', 'barter' ). ' : ' .esc_html__( 'Links', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ). ' - ' .esc_html__( 'on hover/active', 'barter' ),
				'default' => '',
			),
			array(
				'id'          => 'header_sticky_menu_hover_bg_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Main Menu', 'barter' ). ' : ' .esc_html__( 'Links', 'barter' ). ' : ' .esc_html__( 'Background color', 'barter' ). ' - ' .esc_html__( 'on hover/active', 'barter' ),
				'description' => esc_html__( 'It works only for first level links.', 'barter' ),
				'default'     => 'rgba(0,0,0,0)',
			),
			array(
				'id'      => 'header_sticky_bg_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Background color', 'barter' ),
				'default' => '',
			),
			array(
				'id'      => 'header_sticky_mobile_menu_bg_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Mobile menu', 'barter' ). ' : ' .esc_html__( 'Background color', 'barter' ),
				'default' => '#ffffff',
			),
			array(
				'id'      => 'header_sticky_shadow',
				'type'    => 'radio',
				'title'   => esc_html__( 'Shadow', 'barter' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'      => 'header_sticky_separators_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Header', 'barter' ). ' : ' .esc_html__( 'Separator and lines color', 'barter' ),
				'default' => '',
			),
			array(
				'id'          => 'header_sticky_tools_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Tools icons', 'barter' ). ' : ' .esc_html__( 'Color', 'barter' ),
				'description' => esc_html__( 'Basket, sidebar, menu and search icons. It is also color for the text of "Tools button".', 'barter' ),
				'default'     => '',
			),
			array(
				'id'          => 'header_sticky_tools_color_hover',
				'type'        => 'color',
				'title'       => esc_html__( 'Tools icons', 'barter' ). ' : ' .esc_html__( 'Color', 'barter' ). ' - ' .esc_html__( 'on hover/active', 'barter' ),
				'description' => esc_html__( 'Basket, sidebar, menu and search icons. It is also color for the text of "Tools button".', 'barter' ),
				'default'     => '',
			),
			array(
				'id'       => 'header_sticky_button_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Tools button', 'barter' ). ' : ' .esc_html__( 'Background color', 'barter' ),
				'default'  => 'rgba(0,0,0,0)',
				'required' => array( 'header_button', '!=', '' ),
			),
			array(
				'id'       => 'header_sticky_button_bg_color_hover',
				'type'     => 'color',
				'title'    => esc_html__( 'Tools button', 'barter' ). ' : ' .esc_html__( 'Background color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'default'  => 'rgba(0,0,0,0)',
				'required' => array( 'header_button', '!=', '' ),
			),
			array(
				'id'       => 'header_sticky_button_border_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Tools button', 'barter' ). ' : ' .esc_html__( 'Border color', 'barter' ),
				'default'  => 'rgba(0,0,0,0.2)',
				'required' => array( 'header_button', '!=', '' ),
			),
			array(
				'id'       => 'header_sticky_button_border_color_hover',
				'type'     => 'color',
				'title'    => esc_html__( 'Tools button', 'barter' ). ' : ' .esc_html__( 'Border color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'default'  => 'rgba(0,0,0,0.4)',
				'required' => array( 'header_button', '!=', '' ),
			),
			array(
				'id'       => 'header_sticky_socials_color',
				'type'     => 'select',
				'title'    => esc_html__( 'Social icons', 'barter' ). ' : ' .esc_html__( 'Color', 'barter' ),
				'options'  => $social_colors,
				'default'  => 'semi-transparent',
				'required' => array(
					array( 'header_type', '=', 'horizontal' ),
					array( 'header_socials', '=', 'on' ),
				)
			),
			array(
				'id'       => 'header_sticky_socials_color_hover',
				'type'     => 'select',
				'title'    => esc_html__( 'Social icons', 'barter' ). ' : ' .esc_html__( 'Color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'options'  => $social_colors,
				'default'  => 'color',
				'required' => array(
					array( 'header_type', '=', 'horizontal' ),
					array( 'header_socials', '=', 'on' ),
				)
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Tools icons', 'barter' ). ' - ' .esc_html__( 'General settings', 'barter' ),
		'id'         => 'subsection_header_tools',
		'icon'       => 'fa fa-ellipsis-h',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'header_tools_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Tools icons', 'barter' ). ' : ' .esc_html__( 'Color', 'barter' ),
				'description' => esc_html__( 'Basket, sidebar, menu and search icons. It is also color for the text of "Tools button".', 'barter' ),
				'default'     => '#000000',
			),
			array(
				'id'          => 'header_tools_color_hover',
				'type'        => 'color',
				'title'       => esc_html__( 'Tools icons', 'barter' ). ' : ' .esc_html__( 'Color', 'barter' ). ' - ' .esc_html__( 'on hover/active', 'barter' ),
				'description' => esc_html__( 'Basket, sidebar, menu and search icons. It is also color for the text of "Tools button".', 'barter' ),
				'default'     => '#a88057',
			),
			array(
				'id'      => 'header_search',
				'type'    => 'radio',
				'title'   => esc_html_x( 'Search', 'tool', 'barter' ),
				'options' => $on_off,
				'default' => 'off',
			),			
			array(
				'id'          => 'header_button',
				'type'        => 'text',
				'title'       => esc_html__( 'Tools button', 'barter' ). ' : ' .esc_html__( 'Text', 'barter' ),
				'description' => esc_html__( 'If left empty then the text will not be displayed.', 'barter' ),
				'default'     => '',
				'partial' => array(
					'selector' => '.tools_button',
					'container_inclusive' => true,
					'settings' => array(
						'header_button',
						'header_button_link',
						'header_button_link_target',
						'header_button_font_size',
						'header_button_weight',
						'header_button_bg_color',
						'header_button_bg_color_hover',
						'header_button_display_on_mobile',
					),
					'render_callback' => 'barter_header_button',
				)
			),
			array(
				'id'       => 'header_button_link',
				'type'     => 'text',
				'title'    => esc_html__( 'Tools button', 'barter' ). ' : ' .esc_html__( 'Link', 'barter' ),
				'default'  => '',
				'required' => array( 'header_button', '!=', '' ),
				'partial'  => true,
			),
			array(
				'id'          => 'header_button_link_target',
				'type'        => 'radio',
				'title'       => esc_html__( 'Tools button', 'barter' ). ' : ' .esc_html__( 'Open link in new tab', 'barter' ),
				'options'     => $on_off,
				'default'     => 'off',
				'required'    => array( 'header_button', '!=', '' ),
				'partial'  => true,
			),
			array(
				'id'       => 'header_button_font_size',
				'type'     => 'slider',
				'title'    => esc_html__( 'Tools button', 'barter' ). ' : ' .esc_html__( 'Font size', 'barter' ),
				'min'      => 5,
				'max'      => 30,
				'step'     => 1,
				'unit'     => 'px',
				'default'  => '12',
				'required' => array( 'header_button', '!=', '' ),
				'partial'  => true,
			),
			array(
				'id'       => 'header_button_weight',
				'type'     => 'select',
				'title'    => esc_html__( 'Tools button', 'barter' ). ' : ' .esc_html__( 'Font weight', 'barter' ),
				'options'  => $font_weights,
				'default'  => 'normal',
				'required' => array( 'header_button', '!=', '' ),
				'partial'  => true,
			),
			array(
				'id'       => 'header_button_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Tools button', 'barter' ). ' : ' .esc_html__( 'Background color', 'barter' ),
				'default'  => 'rgba(0,0,0,0)',
				'required' => array( 'header_button', '!=', '' ),
				'partial'  => true,
			),
			array(
				'id'       => 'header_button_bg_color_hover',
				'type'     => 'color',
				'title'    => esc_html__( 'Tools button', 'barter' ). ' : ' .esc_html__( 'Background color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'default'  => 'rgba(0,0,0,0)',
				'required' => array( 'header_button', '!=', '' ),
				'partial'  => true,
			),
			array(
				'id'          => 'header_button_display_on_mobile',
				'type'        => 'radio',
				'title'       => esc_html__( 'Tools button', 'barter' ). ' - ' .esc_html__( 'Display it on mobiles', 'barter' ),
				'description' => esc_html__( 'Should it be displayed on devices less than 600 pixels wide.', 'barter' ),
				'options'     => $on_off,
				'default'     => 'on',
				'required'    => array( 'header_button', '!=', '' ),
				'partial'  => true,
			),				
		)
	) );
	
// TOP BAR

$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Top bar', 'barter' ),
		'id'         => 'subsection_header_topbar',
		'icon'       => 'fa fa-ellipsis-h',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'header_topbar',
				'type'    => 'radio',
				'title'   => esc_html__('Top Bar', 'barter' ),
				'options' => $on_off,
				'default' => 'off',
			),
			array(
				'id'          => 'header_topbar_bgcolor',
				'type'        => 'color',
				'title'       => esc_html__( 'Top bar', 'barter' ). ' : ' .esc_html__( 'Background Color', 'barter' ),
				'default'     => '#a88057',
			),
			array(
				'id'          => 'header_topbar_button',
				'type'        => 'text',
				'title'       => esc_html__( 'Topbar button', 'barter' ). ' : ' .esc_html__( 'Text', 'barter' ),
				'description' => esc_html__( 'If left empty then the text will not be displayed.', 'barter' ),
				'default'     => '',
				'partial' => array(
					'selector' => '.topbar_tools_button',
					'container_inclusive' => true,
					'settings' => array(
						'header_topbar_button',
						'header_topbar_button_link',
						'header_topbar_button_link_target',
						'header_topbar_button_font_size',
						'header_topbar_button_weight',
						'header_topbar_button_bg_color',
						'header_topbar_button_bg_color_hover',
						'header_topbar_button_color',
						'header_topbar_button_color_hover',						
						'header_topbar_button_display_on_mobile',
					),
					'render_callback' => 'barter_header_topbar_button',
				)
			),
			array(
				'id'       => 'header_topbar_button_link',
				'type'     => 'text',
				'title'    => esc_html__( 'Topbar button', 'barter' ). ' : ' .esc_html__( 'Link', 'barter' ),
				'default'  => '',
				'required' => array( 'header_topbar_button', '!=', '' ),
				'partial'  => true,
			),
			array(
				'id'          => 'header_topbar_button_link_target',
				'type'        => 'radio',
				'title'       => esc_html__( 'Topbar button', 'barter' ). ' : ' .esc_html__( 'Open link in new tab', 'barter' ),
				'options'     => $on_off,
				'default'     => 'off',
				'required'    => array( 'header_topbar_button', '!=', '' ),
				'partial'  => true,
			),
			array(
				'id'       => 'header_topbar_button_font_size',
				'type'     => 'slider',
				'title'    => esc_html__( 'Topbar button', 'barter' ). ' : ' .esc_html__( 'Font size', 'barter' ),
				'min'      => 5,
				'max'      => 30,
				'step'     => 1,
				'unit'     => 'px',
				'default'  => '15',
				'required' => array( 'header_topbar_button', '!=', '' ),
				'partial'  => true,
			),
			array(
				'id'       => 'header_topbar_button_weight',
				'type'     => 'select',
				'title'    => esc_html__( 'Topbar button', 'barter' ). ' : ' .esc_html__( 'Font weight', 'barter' ),
				'options'  => $font_weights,
				'default'  => '600',
				'required' => array( 'header_topbar_button', '!=', '' ),
				'partial'  => true,
			),
			array(
				'id'       => 'header_topbar_button_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Topbar button', 'barter' ). ' : ' .esc_html__( 'Background color', 'barter' ),
				'default'  => 'rgba(0,0,0,0)',
				'required' => array( 'header_topbar_button', '!=', '' ),
				'partial'  => true,
			),
			array(
				'id'       => 'header_topbar_button_bg_color_hover',
				'type'     => 'color',
				'title'    => esc_html__( 'Topbar button', 'barter' ). ' : ' .esc_html__( 'Background color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'default'  => 'rgba(40,35,31,1)',
				'required' => array( 'header_topbar_button', '!=', '' ),
				'partial'  => true,
			),
			array(
				'id'       => 'header_topbar_button_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Topbar button', 'barter' ). ' : ' .esc_html__( 'Color', 'barter' ),
				'default'  => 'rgba(255,255,255,1)',
				'required' => array( 'header_topbar_button', '!=', '' ),
				'partial'  => true,
			),
			array(
				'id'       => 'header_topbar_button_color_hover',
				'type'     => 'color',
				'title'    => esc_html__( 'Topbar button', 'barter' ). ' : ' .esc_html__( 'Color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'default'  => 'rgba(202,174,144,1)',
				'required' => array( 'header_topbar_button', '!=', '' ),
				'partial'  => true,
			),			
			array(
				'id'          => 'header_topbar_button_display_on_mobile',
				'type'        => 'radio',
				'title'       => esc_html__( 'Topbar button', 'barter' ). ' - ' .esc_html__( 'Display it on mobiles', 'barter' ),
				'description' => esc_html__( 'Should it be displayed on devices less than 600 pixels wide.', 'barter' ),
				'options'     => $on_off,
				'default'     => 'on',
				'required'    => array( 'header_topbar_button', '!=', '' ),
				'partial'  => true,
			),	
			array(
				'id'       => 'header_topbar_left_text1',
				'type'     => 'text',
				'title'    => esc_html__( 'Topbar Left Text', 'barter' ). ' : ' .esc_html__( '1', 'barter' ),
				'default'  => '',
			),
			array(
				'id'       => 'header_topbar_left_text1_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Topbar Left Text 1', 'barter' ). ' : ' .esc_html__( 'Color', 'barter' ),
				'default'  => 'rgba(254,254,254,1)',
			),			
			array(
				'id'       => 'header_topbar_left_text2',
				'type'     => 'text',
				'title'    => esc_html__( 'Topbar Left Text', 'barter' ). ' : ' .esc_html__( '2', 'barter' ),
				'default'  => '',
			),	
			array(
				'id'       => 'header_topbar_left_text2_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Topbar Left Text 2', 'barter' ). ' : ' .esc_html__( 'Color', 'barter' ),
				'default'  => 'rgba(254,254,254,1)',
			),					
		)
	) );	


//BLOG SETTINGS
	$barter_a13->barter_set_sections( array(
		'title'    => esc_html__( 'Blog settings', 'barter' ),
		'desc'     => esc_html__( 'Posts list refers to Blog, Search and Archives pages', 'barter' ),
		'id'       => 'section_blog_layout',
		'icon'     => 'fa fa-pencil',
		'priority' => 9,
		'fields'   => array()
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Background', 'barter' ),
		'id'         => 'subsection_blog_bg',
		'desc'       => esc_html__( 'This will be the default background for pages related to the blog.', 'barter' ),
		'icon'       => 'fa fa-picture-o',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'blog_custom_background',
				'type'    => 'radio',
				'title'   => esc_html__( 'Custom background', 'barter' ),
				'options' => $on_off,
				'default' => 'off',
			),
			array(
				'id'       => 'blog_body_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Background image', 'barter' ),
				'required' => array( 'blog_custom_background', '=', 'on' ),
			),
			array(
				'id'       => 'blog_body_image_fit',
				'type'     => 'select',
				'title'    => esc_html__( 'How to fit the background image', 'barter' ),
				'options'  => $image_fit,
				'default'  => 'cover',
				'required' => array( 'blog_custom_background', '=', 'on' ),
			),
			array(
				'id'       => 'blog_body_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Background color', 'barter' ),
				'default'  => '',
				'required' => array( 'blog_custom_background', '=', 'on' ),
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Posts list', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_blog',
		'icon'       => 'fa fa-list',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'blog_content_under_header',
				'type'        => 'select',
				'title'       => esc_html__( 'Hide content under the header', 'barter' ),
				'description' => esc_html__( 'Works only with the horizontal header.', 'barter' ),
				'options'     => $content_under_header,
				'default'     => 'off',
				'required'    => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'      => 'blog_content_layout',
				'type'    => 'select',
				'title'   => esc_html__( 'Content Layout', 'barter' ),
				'options' => $content_layouts,
				'default' => 'center',
			),
			array(
				'id'      => 'blog_content_padding',
				'type'    => 'select',
				'title'   => esc_html__( 'Content', 'barter' ). ' : ' .esc_html__( 'Top/bottom padding', 'barter' ),
				'options' => array(
					'both'   => esc_html__( 'Both on', 'barter' ),
					'top'    => esc_html__( 'Only top', 'barter' ),
					'bottom' => esc_html__( 'Only bottom', 'barter' ),
					'off'    => esc_html__( 'Both off', 'barter' ),
				),
				'default' => 'off',
			),
			array(
				'id'      => 'blog_sidebar',
				'type'    => 'select',
				'title'   => esc_html__( 'Sidebar', 'barter' ),
				'options' => array(
					'left-sidebar'  => esc_html__( 'Left', 'barter' ),
					'right-sidebar' => esc_html__( 'Right', 'barter' ),
					'off'           => esc_html__( 'Off', 'barter' ),
				),
				'default' => 'off',
			),
			array(
				'id'      => 'blog_post_look',
				'type'    => 'select',
				'title'   => esc_html__( 'Post look', 'barter' ),
				'options' => array(
					'vertical_no_padding' => esc_html__( 'Vertical no padding', 'barter' ),
					'vertical_padding'    => esc_html__( 'Vertical with padding', 'barter' ),
					'vertical_centered'   => esc_html__( 'Vertical centered', 'barter' ),
					'horizontal'          => esc_html__( 'Horizontal', 'barter' ),
				),
				'default' => 'vertical_padding',
			),
			array(
				'id'          => 'blog_layout_mode',
				'type'        => 'radio',
				'title'       => esc_html__( 'How to place items in rows', 'barter' ),
				'description' => esc_html__( 'If your items have different heights, you can start each row of items from a new line instead of the masonry style.', 'barter' ),
				'options'     => array(
					'packery' => esc_html__( 'Masonry', 'barter' ),
					'fitRows' => esc_html__( 'Each row from new line', 'barter' ),
				),
				'default'     => 'packery',
			),
			array(
				'id'          => 'blog_brick_columns',
				'type'        => 'slider',
				'title'       => esc_html__( 'Bricks columns', 'barter' ),
				'description' => esc_html__( 'It is a maximum number of columns displayed on larger devices. On smaller devices, it can be a lower number of columns.', 'barter' ),
				'min'         => 1,
				'max'         => 4,
				'step'        => 1,
				'unit'        => '',
				'default'     => 2,
				'required'    => array( 'blog_post_look', '!=', 'horizontal' ),
			),
			array(
				'id'          => 'blog_bricks_max_width',
				'type'        => 'slider',
				'title'       => esc_html__( 'The maximum width of the brick layout', 'barter' ),
				'description' => esc_html__( 'Depending on the actual width of the screen, the available space for bricks may be smaller, but never greater than this number.', 'barter' ),
				'min'         => 200,
				'max'         => 2500,
				'step'        => 1,
				'unit'        => 'px',
				'default'     => 1920,
				'required'    => array( 'blog_post_look', '!=', 'horizontal' ),
			),
			array(
				'id'      => 'blog_brick_margin',
				'type'    => 'slider',
				'title'   => esc_html__( 'Brick margin', 'barter' ),
				'min'     => 0,
				'max'     => 100,
				'step'    => 1,
				'unit'    => 'px',
				'default' => 10,
			),
			array(
				'id'      => 'blog_lazy_load',
				'type'    => 'radio',
				'title'   => esc_html__( 'Lazy load', 'barter' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'       => 'blog_lazy_load_mode',
				'type'     => 'radio',
				'title'    => esc_html__( 'Lazy load', 'barter' ). ' : ' . esc_html__( 'Type', 'barter' ),
				'options'  => array(
					'button' => esc_html__( 'By clicking button', 'barter' ),
					'auto'   => esc_html__( 'On scroll', 'barter' ),
				),
				'default'  => 'button',
				'required' => array( 'blog_lazy_load', '=', 'on' ),
			),
			array(
				'id'          => 'blog_read_more',
				'type'        => 'radio',
				'title'       => esc_html__( 'Display "Read more" link', 'barter' ),
				'description' => esc_html__( 'Should "Read more" link be displayed after excerpts on blog list/search results.', 'barter' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
			array(
				'id'          => 'blog_excerpt_type',
				'type'        => 'radio',
				'title'       => esc_html__( 'Type of post excerpts', 'barter' ),
				'description' => wp_kses( __(
					'In the Manual mode, excerpts are used only if you add the "Read More Tag" (&lt;!--more--&gt;).<br /> In the Automatic mode, if you will not provide the "Read More Tag" or explicit excerpt, the content of the post will be truncated automatically.<br /> This setting only concerns blog list, archive list, search results.', 'barter' ), $valid_tags ),
				'options'     => array(
					'auto'   => esc_html__( 'Automatic', 'barter' ),
					'manual' => esc_html__( 'Manual', 'barter' ),
				),
				'default'     => 'auto',
			),
			array(
				'id'          => 'blog_excerpt_length',
				'type'        => 'slider',
				'title'       => esc_html__( 'Number of words to cut post', 'barter' ),
				'description' => esc_html__( 'After this many words post will be cut in the automatic mode.', 'barter' ),
				'min'         => 3,
				'max'         => 200,
				'step'        => 1,
				'unit'        => '',
				'default'     => 40,
				'required'    => array( 'blog_excerpt_type', '=', 'auto' ),
			),
			array(
				'id'          => 'blog_media',
				'type'        => 'radio',
				'title'       => esc_html__( 'Display post Media', 'barter' ),
				'description' => esc_html__( 'You can set to not display post media(featured image/video/slider) inside of the post brick.', 'barter' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
			array(
				'id'          => 'blog_videos',
				'type'        => 'radio',
				'title'       => esc_html__( 'Display of posts video', 'barter' ),
				'description' => esc_html__( 'You can set to display videos as featured image on posts list. This can speed up loading of pages with many posts(blog, archive, search results) when the videos are used.', 'barter' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
			array(
				'id'          => 'blog_date',
				'type'        => 'radio',
				'title'       => esc_html__( 'Post info', 'barter' ). ' : ' .esc_html__( 'Date of publish or last update', 'barter' ),
				'description' => esc_html__( 'You can\'t use both dates, because the Search Engine will not know which date is correct.', 'barter' ),
				'options'     => array(
					'on'      => esc_html__( 'Published', 'barter' ),
					'updated' => esc_html__( 'Updated', 'barter' ),
					'off'     => esc_html__( 'Disable', 'barter' ),
				),
				'default'     => 'on',
			),
			array(
				'id'      => 'blog_author',
				'type'    => 'radio',
				'title'   => esc_html__( 'Post info', 'barter' ). ' : ' .esc_html__( 'Author', 'barter' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'      => 'blog_comments',
				'type'    => 'radio',
				'title'   => esc_html__( 'Post info', 'barter' ). ' : ' .esc_html__( 'Comments number', 'barter' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'      => 'blog_cats',
				'type'    => 'radio',
				'title'   => esc_html__( 'Post info', 'barter' ). ' : ' .esc_html__( 'Categories', 'barter' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'          => 'blog_tags',
				'type'        => 'radio',
				'title'       => esc_html__( 'Tags', 'barter' ),
				'description' => esc_html__( 'Displays list of post tags under a post content.', 'barter' ),
				'options'     => $on_off,
				'default'     => 'off',
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Posts list', 'barter' ). ' - ' .esc_html__( 'Title bar', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_blog_title',
		'icon'       => 'fa fa-text-width',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'blog_title',
				'type'    => 'radio',
				'title'   => esc_html__( 'Title', 'barter' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'       => 'blog_title_bar_variant',
				'type'     => 'radio',
				'title'    => esc_html__( 'Variant', 'barter' ),
				'options'  => array(
					'classic'  => esc_html__( 'Classic(to side)', 'barter' ),
					'centered' => esc_html__( 'Centered', 'barter' ),
				),
				'default'  => 'centered',
				'required' => array( 'blog_title', '=', 'on' ),
			),
			array(
				'id'       => 'blog_title_bar_width',
				'type'     => 'radio',
				'title'    => esc_html__( 'Width', 'barter' ),
				'options'  => array(
					'full'  => esc_html__( 'Full', 'barter' ),
					'boxed' => esc_html__( 'Boxed', 'barter' ),
				),
				'default'  => 'full',
				'required' => array( 'blog_title', '=', 'on' ),
			),
			array(
				'id'       => 'blog_title_bar_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Background image', 'barter' ),
				'default'  => '',
				'required' => array( 'blog_title', '=', 'on' ),
			),
			array(
				'id'       => 'blog_title_bar_image_fit',
				'type'     => 'select',
				'title'    => esc_html__( 'How to fit the background image', 'barter' ),
				'options'  => $image_fit,
				'default'  => 'repeat',
				'required' => array( 'blog_title', '=', 'on' ),
			),
			array(
				'id'       => 'blog_title_bar_parallax',
				'type'     => 'radio',
				'title'    => esc_html__( 'Parallax', 'barter' ),
				'options'  => $on_off,
				'default'  => 'off',
				'required' => array( 'blog_title', '=', 'on' ),
			),
			array(
				'id'          => 'blog_title_bar_parallax_type',
				'type'        => 'select',
				'title'       => esc_html__( 'Parallax', 'barter' ). ' : ' . esc_html__( 'Type', 'barter' ),
				'description' => esc_html__( 'It defines how the image will scroll in the background while the page is scrolled down.', 'barter' ),
				'options'     => $parallax_types,
				'default'     => 'tb',
				'required'    => array(
					array( 'blog_title', '=', 'on' ),
					array( 'blog_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'blog_title_bar_parallax_speed',
				'type'        => 'slider',
				'title'       => esc_html__( 'Parallax', 'barter' ). ' : ' . esc_html__( 'Speed', 'barter' ),
				'description' => esc_html__( 'It will be only used for the background that is repeated. If the background is set to not repeat this value will be ignored.', 'barter' ),
				'min'         => 0,
				'max'         => 1,
				'step'        => 0.01,
				'default'     => '1.00',
				'required'    => array(
					array( 'blog_title', '=', 'on' ),
					array( 'blog_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'blog_title_bar_bg_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Overlay color', 'barter' ),
				'description' => esc_html__( 'Will be placed above the image(if used)', 'barter' ),
				'default'     => '#ffffff',
				'required'    => array( 'blog_title', '=', 'on' ),
			),
			array(
				'id'       => 'blog_title_bar_title_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Titles', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'default'  => '',
				'required' => array( 'blog_title', '=', 'on' ),
			),
			array(
				'id'          => 'blog_title_bar_color_1',
				'type'        => 'color',
				'title'       => esc_html__( 'Other elements', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'default'     => '',
				'required'    => array( 'blog_title', '=', 'on' ),
			),
			array(
				'id'       => 'blog_title_bar_space_width',
				'type'     => 'slider',
				'title'    => esc_html__( 'Top/bottom padding', 'barter' ),
				'min'      => 0,
				'max'      => 600,
				'step'     => 1,
				'unit'     => 'px',
				'default'  => '40',
				'required' => array( 'blog_title', '=', 'on' ),
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Single post', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_post',
		'icon'       => 'fa fa-pencil-square',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'post_content_under_header',
				'type'        => 'select',
				'title'       => esc_html__( 'Hide content under the header', 'barter' ),
				'description' => esc_html__( 'Works only with the horizontal header.', 'barter' ),
				'options'     => $content_under_header,
				'default'     => 'off',
				'required'    => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'      => 'post_content_layout',
				'type'    => 'select',
				'title'   => esc_html__( 'Content Layout', 'barter' ),
				'options' => $content_layouts,
				'default' => 'center',
			),
			array(
				'id'      => 'post_sidebar',
				'type'    => 'select',
				'title'   => esc_html__( 'Sidebar', 'barter' ),
				'options' => array(
					'left-sidebar'  => esc_html__( 'Left', 'barter' ),
					'right-sidebar' => esc_html__( 'Right', 'barter' ),
					'off'           => esc_html__( 'Off', 'barter' ),
				),
				'default' => 'right-sidebar',
			),
			array(
				'id'          => 'post_media',
				'type'        => 'radio',
				'title'       => esc_html__( 'Display post Media', 'barter' ),
				'description' => esc_html__( 'You can set to not display post media(featured image/video/slider) inside of the post.', 'barter' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
			array(
				'id'          => 'post_author_info',
				'type'        => 'radio',
				'title'       => esc_html__( 'Author info', 'barter' ),
				'description' => esc_html__( 'Will show information about author below post content.', 'barter' ),
				'options'     => $on_off,
				'default'     => 'off',
			),
			array(
				'id'          => 'post_date',
				'type'        => 'radio',
				'title'       => esc_html__( 'Post info', 'barter' ). ' : ' .esc_html__( 'Date of publish or last update', 'barter' ),
				'description' => esc_html__( 'You can\'t use both dates, because the Search Engine will not know which date is correct.', 'barter' ),
				'options'     => array(
					'on'      => esc_html__( 'Published', 'barter' ),
					'updated' => esc_html__( 'Updated', 'barter' ),
					'off'     => esc_html__( 'Disable', 'barter' ),
				),
				'default'     => 'on',
			),
			array(
				'id'      => 'post_author',
				'type'    => 'radio',
				'title'   => esc_html__( 'Post info', 'barter' ). ' : ' .esc_html__( 'Author', 'barter' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'      => 'post_comments',
				'type'    => 'radio',
				'title'   => esc_html__( 'Post info', 'barter' ). ' : ' .esc_html__( 'Comments number', 'barter' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'      => 'post_cats',
				'type'    => 'radio',
				'title'   => esc_html__( 'Post info', 'barter' ). ' : ' .esc_html__( 'Categories', 'barter' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'          => 'post_tags',
				'type'        => 'radio',
				'title'       => esc_html__( 'Tags', 'barter' ),
				'description' => esc_html__( 'Displays list of post tags under a post content.', 'barter' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
			array(
				'id'          => 'post_navigation',
				'type'        => 'radio',
				'title'       => esc_html__( 'Posts navigation', 'barter' ),
				'description' => esc_html__( 'Links to next and prev post.', 'barter' ),
				'options'     => $on_off,
				'default'     => 'on',
			),

		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Single post', 'barter' ). ' - ' .esc_html__( 'Title bar', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_post_title',
		'icon'       => 'fa fa-text-width',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'post_title',
				'type'    => 'radio',
				'title'   => esc_html__( 'Title', 'barter' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'       => 'post_title_bar_position',
				'type'     => 'radio',
				'title'    => esc_html__( 'Title position', 'barter' ),
				'options'  => array(
					'outside' => esc_html__( 'Before the content', 'barter' ),
					'inside'  => esc_html__( 'Inside the content', 'barter' ),
				),
				'default'  => 'inside',
				'required' => array( 'post_title', '=', 'on' ),
			),
			array(
				'id'       => 'post_title_bar_variant',
				'type'     => 'radio',
				'title'    => esc_html__( 'Variant', 'barter' ),
				'options'  => array(
					'classic'  => esc_html__( 'Classic(to side)', 'barter' ),
					'centered' => esc_html__( 'Centered', 'barter' ),
				),
				'default'  => 'classic',
				'required' => array(
					array( 'post_title', '=', 'on' ),
					array( 'post_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'post_title_bar_width',
				'type'     => 'radio',
				'title'    => esc_html__( 'Width', 'barter' ),
				'options'  => array(
					'full'  => esc_html__( 'Full', 'barter' ),
					'boxed' => esc_html__( 'Boxed', 'barter' ),
				),
				'default'  => 'full',
				'required' => array(
					array( 'post_title', '=', 'on' ),
					array( 'post_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'post_title_bar_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Background image', 'barter' ),
				'default'  => '',
				'required' => array(
					array( 'post_title', '=', 'on' ),
					array( 'post_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'post_title_bar_image_fit',
				'type'     => 'select',
				'title'    => esc_html__( 'How to fit the background image', 'barter' ),
				'options'  => $image_fit,
				'default'  => 'repeat',
				'required' => array(
					array( 'post_title', '=', 'on' ),
					array( 'post_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'post_title_bar_parallax',
				'type'     => 'radio',
				'title'    => esc_html__( 'Parallax', 'barter' ),
				'default'  => 'off',
				'options'  => $on_off,
				'required' => array(
					array( 'post_title', '=', 'on' ),
					array( 'post_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'          => 'post_title_bar_parallax_type',
				'type'        => 'select',
				'title'       => esc_html__( 'Parallax', 'barter' ). ' : ' . esc_html__( 'Type', 'barter' ),
				'description' => esc_html__( 'It defines how the image will scroll in the background while the page is scrolled down.', 'barter' ),
				'options'     => $parallax_types,
				'default'     => 'tb',
				'required'    => array(
					array( 'post_title', '=', 'on' ),
					array( 'post_title_bar_position', '!=', 'inside' ),
					array( 'post_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'post_title_bar_parallax_speed',
				'type'        => 'slider',
				'title'       => esc_html__( 'Parallax', 'barter' ). ' : ' . esc_html__( 'Speed', 'barter' ),
				'description' => esc_html__( 'It will be only used for the background that is repeated. If the background is set to not repeat this value will be ignored.', 'barter' ),
				'min'         => 0,
				'max'         => 1,
				'step'        => 0.01,
				'default'     => '1.00',
				'required'    => array(
					array( 'post_title', '=', 'on' ),
					array( 'post_title_bar_position', '!=', 'inside' ),
					array( 'post_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'post_title_bar_bg_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Overlay color', 'barter' ),
				'description' => esc_html__( 'Will be placed above the image(if used)', 'barter' ),
				'default'     => '',
				'required'    => array( 'post_title', '=', 'on' ),
			),
			array(
				'id'       => 'post_title_bar_title_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Titles', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'default'  => '',
				'required' => array(
					array( 'post_title', '=', 'on' ),
					array( 'post_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'          => 'post_title_bar_color_1',
				'type'        => 'color',
				'title'       => esc_html__( 'Other elements', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'default'     => '',
				'required'    => array(
					array( 'post_title', '=', 'on' ),
					array( 'post_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'post_title_bar_space_width',
				'type'     => 'slider',
				'title'    => esc_html__( 'Top/bottom padding', 'barter' ),
				'min'      => 0,
				'max'      => 600,
				'step'     => 1,
				'unit'     => 'px',
				'default'  => '40',
				'required' => array(
					array( 'post_title', '=', 'on' ),
					array( 'post_title_bar_position', '!=', 'inside' ),
				)
			),
		)
	) );

//SHOP SETTINGS
	$barter_a13->barter_set_sections( array(
		'title'    => esc_html__( 'Shop(WooCommerce) settings', 'barter' ),
		'desc'     => '',
		'id'       => 'section_shop_general',
		'icon'     => 'fa fa-shopping-cart',
		'priority' => 12,
		'woocommerce_required' => true,//only visible with WooCommerce plugin being available
		'fields'   => array()
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Background', 'barter' ),
		'desc'       => esc_html__( 'These options will work for all shop pages - product list, single product and other.', 'barter' ),
		'id'         => 'subsection_shop_general',
		'icon'       => 'fa fa-picture-o',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'shop_custom_background',
				'type'    => 'radio',
				'title'   => esc_html__( 'Custom background', 'barter' ),
				'options' => $on_off,
				'default' => 'off',
			),
			array(
				'id'       => 'shop_body_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Background image', 'barter' ),
				'required' => array( 'shop_custom_background', '=', 'on' ),
			),
			array(
				'id'       => 'shop_body_image_fit',
				'type'     => 'select',
				'title'    => esc_html__( 'How to fit the background image', 'barter' ),
				'options'  => $image_fit,
				'default'  => 'cover',
				'required' => array( 'shop_custom_background', '=', 'on' ),
			),
			array(
				'id'       => 'shop_body_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Background color', 'barter' ),
				'required' => array( 'shop_custom_background', '=', 'on' ),
				'default'  => '',
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Products list', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_shop',
		'icon'       => 'fa fa-list',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'shop_search',
				'type'        => 'radio',
				'title'       => esc_html__( 'Search in products instead of pages', 'barter' ),
				'description' => esc_html__( 'It will change WordPress default search function to make shop search. So when this is activated search function in header or search widget will act as WooCommerece search widget.', 'barter' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
			array(
				'id'          => 'shop_content_under_header',
				'type'        => 'select',
				'title'       => esc_html__( 'Hide content under the header', 'barter' ),
				'description' => esc_html__( 'Works only with the horizontal header.', 'barter' ),
				'options'     => $content_under_header,
				'default'     => 'off',
				'required'    => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'      => 'shop_content_layout',
				'type'    => 'select',
				'title'   => esc_html__( 'Content Layout', 'barter' ),
				'options' => $content_layouts,
				'default' => 'full',
			),
			array(
				'id'      => 'shop_sidebar',
				'type'    => 'select',
				'title'   => esc_html__( 'Sidebar', 'barter' ),
				'options' => array(
					'left-sidebar'  => esc_html__( 'Left', 'barter' ),
					'right-sidebar' => esc_html__( 'Right', 'barter' ),
					'off'           => esc_html__( 'Off', 'barter' ),
				),
				'default' => 'left-sidebar',
			),
			array(
				'id'      => 'shop_products_variant',
				'type'    => 'radio',
				'title'   => esc_html__( 'Look of products on list', 'barter' ),
				'options' => array(
					'overlay' => esc_html__( 'Text as overlay', 'barter' ),
					'under'   => esc_html__( 'Text under photo', 'barter' ),
				),
				'default' => 'overlay',
			),
			array(
				'id'       => 'shop_products_subvariant',
				'type'     => 'select',
				'title'    => esc_html__( 'Look of products on list', 'barter' ),
				'options'  => array(
					'left'   => esc_html__( 'Texts to left', 'barter' ),
					'center' => esc_html__( 'Texts to center', 'barter' ),
					'right'  => esc_html__( 'Texts to right', 'barter' ),
				),
				'default'  => 'center',
				'required' => array( 'shop_products_variant', '=', 'under' ),
			),
			array(
				'id'      => 'shop_products_second_image',
				'type'    => 'radio',
				'title'   => esc_html__( 'Show second image of product on hover', 'barter' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'          => 'shop_products_layout_mode',
				'type'        => 'radio',
				'title'       => esc_html__( 'How to place items in rows', 'barter' ),
				'description' => esc_html__( 'If your items have different heights, you can start each row of items from a new line instead of the masonry style.', 'barter' ),
				'options'     => array(
					'packery' => esc_html__( 'Masonry', 'barter' ),
					'fitRows' => esc_html__( 'Each row from new line', 'barter' ),
				),
				'default'     => 'packery',
			),
			array(
				'id'          => 'shop_products_columns',
				'type'        => 'slider',
				'title'       => esc_html__( 'Bricks columns', 'barter' ),
				'description' => esc_html__( 'It is a maximum number of columns displayed on larger devices. On smaller devices, it can be a lower number of columns.', 'barter' ),
				'min'         => 1,
				'max'         => 4,
				'step'        => 1,
				'unit'        => '',
				'default'     => 4,
			),
			array(
				'id'      => 'shop_products_per_page',
				'type'    => 'slider',
				'title'   => esc_html__( 'Items per page', 'barter' ),
				'min'     => 1,
				'max'     => 30,
				'step'    => 1,
				'unit'    => 'products',
				'default' => 12,
			),
			array(
				'id'      => 'shop_brick_margin',
				'type'    => 'slider',
				'title'   => esc_html__( 'Brick margin', 'barter' ),
				'min'     => 0,
				'max'     => 100,
				'step'    => 1,
				'unit'    => 'px',
				'default' => 20,
			),
			array(
				'id'      => 'shop_lazy_load',
				'type'    => 'radio',
				'title'   => esc_html__( 'Lazy load', 'barter' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'       => 'shop_lazy_load_mode',
				'type'     => 'radio',
				'title'    => esc_html__( 'Lazy load', 'barter' ). ' : ' . esc_html__( 'Type', 'barter' ),
				'options'  => array(
					'button' => esc_html__( 'By clicking button', 'barter' ),
					'auto'   => esc_html__( 'On scroll', 'barter' ),
				),
				'default'  => 'auto',
				'required' => array( 'shop_lazy_load', '=', 'on' ),
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Products list', 'barter' ). ' - ' .esc_html__( 'Title bar', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_shop_title',
		'icon'       => 'fa fa-text-width',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'shop_title',
				'type'    => 'radio',
				'title'   => esc_html__( 'Title', 'barter' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'       => 'shop_title_bar_variant',
				'type'     => 'radio',
				'title'    => esc_html__( 'Variant', 'barter' ),
				'options'  => array(
					'classic'  => esc_html__( 'Classic(to side)', 'barter' ),
					'centered' => esc_html__( 'Centered', 'barter' ),
				),
				'default'  => 'classic',
				'required' => array( 'shop_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_title_bar_width',
				'type'     => 'radio',
				'title'    => esc_html__( 'Width', 'barter' ),
				'options'  => array(
					'full'  => esc_html__( 'Full', 'barter' ),
					'boxed' => esc_html__( 'Boxed', 'barter' ),
				),
				'default'  => 'full',
				'required' => array( 'shop_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_title_bar_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Background image', 'barter' ),
				'default'  => '',
				'required' => array( 'shop_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_title_bar_image_fit',
				'type'     => 'select',
				'title'    => esc_html__( 'How to fit the background image', 'barter' ),
				'options'  => $image_fit,
				'default'  => 'repeat',
				'required' => array( 'shop_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_title_bar_parallax',
				'type'     => 'radio',
				'title'    => esc_html__( 'Parallax', 'barter' ),
				'options'  => $on_off,
				'default'  => 'off',
				'required' => array( 'shop_title', '=', 'on' ),
			),
			array(
				'id'          => 'shop_title_bar_parallax_type',
				'type'        => 'select',
				'title'       => esc_html__( 'Parallax', 'barter' ). ' : ' . esc_html__( 'Type', 'barter' ),
				'description' => esc_html__( 'It defines how the image will scroll in the background while the page is scrolled down.', 'barter' ),
				'options'     => $parallax_types,
				'default'     => 'tb',
				'required'    => array(
					array( 'shop_title', '=', 'on' ),
					array( 'shop_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'shop_title_bar_parallax_speed',
				'type'        => 'slider',
				'title'       => esc_html__( 'Parallax', 'barter' ). ' : ' . esc_html__( 'Speed', 'barter' ),
				'description' => esc_html__( 'It will be only used for the background that is repeated. If the background is set to not repeat this value will be ignored.', 'barter' ),
				'min'         => 0,
				'max'         => 1,
				'step'        => 0.01,
				'default'     => '1.00',
				'required'    => array(
					array( 'shop_title', '=', 'on' ),
					array( 'shop_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'shop_title_bar_bg_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Overlay color', 'barter' ),
				'description' => esc_html__( 'Will be placed above the image(if used)', 'barter' ),
				'default'     => '',
				'required'    => array( 'shop_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_title_bar_title_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Titles', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'default'  => '',
				'required' => array( 'shop_title', '=', 'on' ),
			),
			array(
				'id'          => 'shop_title_bar_color_1',
				'type'        => 'color',
				'title'       => esc_html__( 'Other elements', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'default'     => '',
				'required'    => array( 'shop_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_title_bar_space_width',
				'type'     => 'slider',
				'title'    => esc_html__( 'Top/bottom padding', 'barter' ),
				'min'      => 0,
				'max'      => 600,
				'step'     => 1,
				'unit'     => 'px',
				'default'  => '40',
				'required' => array( 'shop_title', '=', 'on' ),
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Single product', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_product',
		'icon'       => 'fa fa-pencil-square',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'product_content_under_header',
				'type'        => 'select',
				'title'       => esc_html__( 'Hide content under the header', 'barter' ),
				'description' => esc_html__( 'Works only with the horizontal header.', 'barter' ),
				'options'     => $content_under_header,
				'default'     => 'off',
				'required'    => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'      => 'product_content_layout',
				'type'    => 'select',
				'title'   => esc_html__( 'Content Layout', 'barter' ),
				'options' => $content_layouts,
				'default' => 'full_fixed',
			),
			array(
				'id'      => 'product_sidebar',
				'type'    => 'select',
				'title'   => esc_html__( 'Sidebar', 'barter' ),
				'options' => array(
					'left-sidebar'  => esc_html__( 'Left', 'barter' ),
					'right-sidebar' => esc_html__( 'Right', 'barter' ),
					'off'           => esc_html__( 'Off', 'barter' ),
				),
				'default' => 'left-sidebar',
			),
			array(
				'id'          => 'product_custom_thumbs',
				'type'        => 'radio',
				'title'       => esc_html__( 'Theme thumbnails', 'barter' ),
				'description' => esc_html__( 'If disabled it will display standard WooCommerce thumbnails.', 'barter' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
			array(
				'id'          => 'product_related_products',
				'type'        => 'radio',
				'title'       => esc_html__( 'Related products', 'barter' ),
				'description' => esc_html__( 'Should related products be displayed on single product page.', 'barter' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Single product', 'barter' ). ' - ' .esc_html__( 'Title bar', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_product_title',
		'icon'       => 'fa fa-text-width',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'product_title',
				'type'    => 'radio',
				'title'   => esc_html__( 'Title', 'barter' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'       => 'product_title_bar_position',
				'type'     => 'radio',
				'title'    => esc_html__( 'Title position', 'barter' ),
				'options'  => array(
					'outside' => esc_html__( 'Before the content', 'barter' ),
					'inside'  => esc_html__( 'Inside the content', 'barter' ),
				),
				'default'  => 'inside',
				'required' => array( 'product_title', '=', 'on' ),
			),
			array(
				'id'       => 'product_title_bar_variant',
				'type'     => 'radio',
				'title'    => esc_html__( 'Variant', 'barter' ),
				'options'  => array(
					'classic'  => esc_html__( 'Classic(to side)', 'barter' ),
					'centered' => esc_html__( 'Centered', 'barter' ),
				),
				'default'  => 'classic',
				'required' => array(
					array( 'product_title', '=', 'on' ),
					array( 'product_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'product_title_bar_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Background image', 'barter' ),
				'default'  => '',
				'required' => array(
					array( 'product_title', '=', 'on' ),
					array( 'product_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'product_title_bar_image_fit',
				'type'     => 'select',
				'title'    => esc_html__( 'How to fit the background image', 'barter' ),
				'options'  => $image_fit,
				'default'  => 'repeat',
				'required' => array(
					array( 'product_title', '=', 'on' ),
					array( 'product_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'product_title_bar_parallax',
				'type'     => 'radio',
				'title'    => esc_html__( 'Parallax', 'barter' ),
				'options'  => $on_off,
				'default'  => 'off',
				'required' => array(
					array( 'product_title', '=', 'on' ),
					array( 'product_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'          => 'product_title_bar_parallax_type',
				'type'        => 'select',
				'title'       => esc_html__( 'Parallax', 'barter' ). ' : ' . esc_html__( 'Type', 'barter' ),
				'description' => esc_html__( 'It defines how the image will scroll in the background while the page is scrolled down.', 'barter' ),
				'options'     => $parallax_types,
				'default'     => 'tb',
				'required'    => array(
					array( 'product_title', '=', 'on' ),
					array( 'product_title_bar_position', '!=', 'inside' ),
					array( 'product_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'product_title_bar_parallax_speed',
				'type'        => 'slider',
				'title'       => esc_html__( 'Parallax', 'barter' ). ' : ' . esc_html__( 'Speed', 'barter' ),
				'description' => esc_html__( 'It will be only used for the background that is repeated. If the background is set to not repeat this value will be ignored.', 'barter' ),
				'min'         => 0,
				'max'         => 1,
				'step'        => 0.01,
				'default'     => '1.00',
				'required'    => array(
					array( 'product_title', '=', 'on' ),
					array( 'product_title_bar_position', '!=', 'inside' ),
					array( 'product_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'product_title_bar_bg_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Overlay color', 'barter' ),
				'description' => esc_html__( 'Will be placed above the image(if used)', 'barter' ),
				'default'     => '',
				'required'    => array(
					array( 'product_title', '=', 'on' ),
					array( 'product_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'product_title_bar_title_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Titles', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'default'  => '',
				'required' => array(
					array( 'product_title', '=', 'on' ),
					array( 'product_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'          => 'product_title_bar_color_1',
				'type'        => 'color',
				'title'       => esc_html__( 'Other elements', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'default'     => '',
				'required'    => array(
					array( 'product_title', '=', 'on' ),
					array( 'product_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'product_title_bar_space_width',
				'type'     => 'slider',
				'title'    => esc_html__( 'Top/bottom padding', 'barter' ),
				'min'      => 0,
				'max'      => 600,
				'step'     => 1,
				'unit'     => 'px',
				'default'  => '40',
				'required' => array(
					array( 'product_title', '=', 'on' ),
					array( 'product_title_bar_position', '!=', 'inside' ),
				)
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Other shop pages', 'barter' ),
		'desc'       => esc_html__( 'Settings for cart, checkout, order received and my account pages.', 'barter' ),
		'id'         => 'subsection_shop_no_major_pages',
		'icon'       => 'fa fa-cog',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'shop_no_major_pages_content_under_header',
				'type'        => 'select',
				'title'       => esc_html__( 'Hide content under the header', 'barter' ),
				'description' => esc_html__( 'Works only with the horizontal header.', 'barter' ),
				'options'     => $content_under_header,
				'default'     => 'off',
				'required'    => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'      => 'shop_no_major_pages_content_layout',
				'type'    => 'select',
				'title'   => esc_html__( 'Content Layout', 'barter' ),
				'options' => $content_layouts,
				'default' => 'full_fixed',
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'desc'       => esc_html__( 'Settings for cart, checkout, order received and my account pages.', 'barter' ),
		'title'      => esc_html__( 'Other shop pages', 'barter' ). ' - ' .esc_html__( 'Title bar', 'barter' ),
		'id'         => 'subsection_shop_no_major_pages_title',
		'icon'       => 'fa fa-text-width',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'shop_no_major_pages_title',
				'type'    => 'radio',
				'title'   => esc_html__( 'Title', 'barter' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'       => 'shop_no_major_pages_title_bar_variant',
				'type'     => 'radio',
				'title'    => esc_html__( 'Variant', 'barter' ),
				'options'  => array(
					'classic'  => esc_html__( 'Classic(to side)', 'barter' ),
					'centered' => esc_html__( 'Centered', 'barter' ),
				),
				'default'  => 'classic',
				'required' => array( 'shop_no_major_pages_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_no_major_pages_title_bar_width',
				'type'     => 'radio',
				'title'    => esc_html__( 'Width', 'barter' ),
				'options'  => array(
					'full'  => esc_html__( 'Full', 'barter' ),
					'boxed' => esc_html__( 'Boxed', 'barter' ),
				),
				'default'  => 'full',
				'required' => array( 'shop_no_major_pages_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_no_major_pages_title_bar_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Background image', 'barter' ),
				'default'  => '',
				'required' => array( 'shop_no_major_pages_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_no_major_pages_title_bar_image_fit',
				'type'     => 'select',
				'title'    => esc_html__( 'How to fit the background image', 'barter' ),
				'options'  => $image_fit,
				'default'  => 'repeat',
				'required' => array( 'shop_no_major_pages_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_no_major_pages_title_bar_parallax',
				'type'     => 'radio',
				'title'    => esc_html__( 'Parallax', 'barter' ),
				'options'  => $on_off,
				'default'  => 'off',
				'required' => array( 'shop_no_major_pages_title', '=', 'on' ),
			),
			array(
				'id'          => 'shop_no_major_pages_title_bar_parallax_type',
				'type'        => 'select',
				'title'       => esc_html__( 'Parallax', 'barter' ). ' : ' . esc_html__( 'Type', 'barter' ),
				'description' => esc_html__( 'It defines how the image will scroll in the background while the page is scrolled down.', 'barter' ),
				'options'     => $parallax_types,
				'default'     => 'tb',
				'required'    => array(
					array( 'shop_no_major_pages_title', '=', 'on' ),
					array( 'shop_no_major_pages_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'shop_no_major_pages_title_bar_parallax_speed',
				'type'        => 'slider',
				'title'       => esc_html__( 'Parallax', 'barter' ). ' : ' . esc_html__( 'Speed', 'barter' ),
				'description' => esc_html__( 'It will be only used for the background that is repeated. If the background is set to not repeat this value will be ignored.', 'barter' ),
				'min'         => 0,
				'max'         => 1,
				'step'        => 0.01,
				'default'     => '1.00',
				'required'    => array(
					array( 'shop_no_major_pages_title', '=', 'on' ),
					array( 'shop_no_major_pages_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'shop_no_major_pages_title_bar_bg_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Overlay color', 'barter' ),
				'description' => esc_html__( 'Will be placed above the image(if used)', 'barter' ),
				'default'     => '',
				'required'    => array( 'shop_no_major_pages_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_no_major_pages_title_bar_title_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Titles', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'default'  => '',
				'required' => array( 'shop_no_major_pages_title', '=', 'on' ),
			),
			array(
				'id'          => 'shop_no_major_pages_title_bar_color_1',
				'type'        => 'color',
				'title'       => esc_html__( 'Other elements', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'default'     => '',
				'required'    => array( 'shop_no_major_pages_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_no_major_pages_title_bar_space_width',
				'type'     => 'slider',
				'title'    => esc_html__( 'Top/bottom padding', 'barter' ),
				'min'      => 0,
				'max'      => 600,
				'step'     => 1,
				'unit'     => 'px',
				'default'  => '40',
				'required' => array( 'shop_no_major_pages_title', '=', 'on' ),
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Pop up basket', 'barter' ),
		'desc'       => esc_html__( 'When WooCommerce is activated, button opening this basket will appear in the header. There also have to be some active widgets in "Basket sidebar" for this.', 'barter' ),
		'id'         => 'subsection_basket_sidebars',
		'icon'       => 'fa fa-shopping-basket',
		'subsection' => true,
		'fields'     => array(

			array(
				'id'      => 'basket_sidebar_bg_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Background color', 'barter' ),
				'default' => '',
			),
			array(
				'id'      => 'basket_sidebar_font_size',
				'type'    => 'slider',
				'title'   => esc_html__( 'Font size', 'barter' ),
				'min'     => 5,
				'max'     => 30,
				'step'    => 1,
				'unit'    => 'px',
				'default' => '',
			),
			array(
				'id'          => 'basket_sidebar_widgets_color',
				'type'        => 'radio',
				'title'       => esc_html__( 'Widgets colors', 'barter' ),
				'description' => esc_html__( 'Depending on what background you have set up, choose proper option.', 'barter' ),
				'options'     => array(
					'dark-sidebar'  => esc_html__( 'On dark', 'barter' ),
					'light-sidebar' => esc_html__( 'On light', 'barter' ),
				),
				'default'     => 'light-sidebar',
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Buttons', 'barter' ),
		'desc'       => esc_html__( 'You can change here the colors of buttons used in the shop. Alternative buttons colors are used in various places in the shop.', 'barter' ),
		'id'         => 'subsection_buttons_shop',
		'icon'       => 'fa fa-arrow-down',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'button_shop_bg_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Background color', 'barter' ),
				'default' => '#524F51',
			),
			array(
				'id'      => 'button_shop_bg_hover_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Background color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'default' => '#000000',
			),
			array(
				'id'      => 'button_shop_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Text color', 'barter' ),
				'default' => '#cccccc'
			),
			array(
				'id'      => 'button_shop_hover_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Text color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'default' => '#ffffff'
			),
			array(
				'id'      => 'button_shop_alt_bg_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Alternative button', 'barter' ). ' : ' .esc_html__( 'Background color', 'barter' ),
				'default' => '#524F51',
			),
			array(
				'id'      => 'button_shop_alt_bg_hover_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Alternative button', 'barter' ). ' : ' .esc_html__( 'Background color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'default' => '#000000',
			),
			array(
				'id'      => 'button_shop_alt_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Alternative button', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'default' => '#cccccc'
			),
			array(
				'id'      => 'button_shop_alt_hover_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Alternative button', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ). ' - ' .esc_html__( 'on hover', 'barter' ),
				'default' => '#ffffff'
			),
			array(
				'id'      => 'button_shop_font_size',
				'type'    => 'slider',
				'title'   => esc_html__( 'Font size', 'barter' ),
				'min'     => 10,
				'max'     => 60,
				'step'    => 1,
				'unit'    => 'px',
				'default' => 13,
			),
			array(
				'id'      => 'button_shop_weight',
				'type'    => 'select',
				'title'   => esc_html__( 'Font weight', 'barter' ),
				'options' => $font_weights,
				'default' => 'bold',
			),
			array(
				'id'      => 'button_shop_transform',
				'type'    => 'radio',
				'title'   => esc_html__( 'Text transform', 'barter' ),
				'options' => $font_transforms,
				'default' => 'uppercase',
			),
			array(
				'id'      => 'button_shop_padding',
				'type'    => 'spacing',
				'title'   => esc_html__( 'Padding', 'barter' ),
				'mode'    => 'padding',
				'sides'   => array( 'left', 'right' ),
				'units'   => array( 'px', 'em' ),
				'default' => array(
					'padding-left'  => '30px',
					'padding-right' => '30px',
					'units'         => 'px'
				),
			),
		)
	) );

//PAGE SETTINGS
	$barter_a13->barter_set_sections( array(
		'title'    => esc_html__( 'Page settings', 'barter' ),
		'desc'     => '',
		'id'       => 'section_page',
		'icon'     => 'el el-file-edit',
		'priority' => 15,
		'fields'   => array()
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Single page', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_page',
		'icon'       => 'el el-file-edit',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'page_comments',
				'type'    => 'radio',
				'title'   => esc_html__( 'Comments', 'barter' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'          => 'page_content_under_header',
				'type'        => 'select',
				'title'       => esc_html__( 'Hide content under the header', 'barter' ),
				'description' => esc_html__( 'Works only with the horizontal header.', 'barter' ),
				'options'     => $content_under_header,
				'default'     => 'off',
				'required'    => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'      => 'page_content_layout',
				'type'    => 'select',
				'title'   => esc_html__( 'Content Layout', 'barter' ),
				'options' => $content_layouts,
				'default' => 'center',
			),
			array(
				'id'          => 'page_sidebar',
				'type'        => 'select',
				'title'       => esc_html__( 'Sidebar', 'barter' ),
				'description' => esc_html__( 'You can change it in each page settings.', 'barter' ),
				'options'     => array(
					'left-sidebar'          => esc_html__( 'Sidebar on the left', 'barter' ),
					'left-sidebar_and_nav'  => esc_html__( 'Children Navigation + sidebar on the left', 'barter' ),
					'left-nav'              => esc_html__( 'Only children Navigation on the left', 'barter' ),
					'right-sidebar'         => esc_html__( 'Sidebar on the right', 'barter' ),
					'right-sidebar_and_nav' => esc_html__( 'Children Navigation + sidebar on the right', 'barter' ),
					'right-nav'             => esc_html__( 'Only children Navigation on the right', 'barter' ),
					'off'                   => esc_html__( 'Off', 'barter' ),
				),
				'default'     => 'off',
			),
			array(
				'id'      => 'page_custom_background',
				'type'    => 'radio',
				'title'   => esc_html__( 'Custom background', 'barter' ),
				'options' => $on_off,
				'default' => 'off',
			),
			array(
				'id'       => 'page_body_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Background image', 'barter' ),
				'required' => array( 'page_custom_background', '=', 'on' ),
			),
			array(
				'id'       => 'page_body_image_fit',
				'type'     => 'select',
				'title'    => esc_html__( 'How to fit the background image', 'barter' ),
				'options'  => $image_fit,
				'default'  => 'cover',
				'required' => array( 'page_custom_background', '=', 'on' ),
			),
			array(
				'id'       => 'page_body_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Background color', 'barter' ),
				'required' => array( 'page_custom_background', '=', 'on' ),
				'default'  => '',
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Single page', 'barter' ). ' - ' .esc_html__( 'Title bar', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_page_title',
		'icon'       => 'fa fa-text-width',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'page_title',
				'type'    => 'radio',
				'title'   => esc_html__( 'Title', 'barter' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'       => 'page_title_bar_position',
				'type'     => 'radio',
				'title'    => esc_html__( 'Title position', 'barter' ),
				'options'  => array(
					'outside' => esc_html__( 'Before the content', 'barter' ),
					'inside'  => esc_html__( 'Inside the content', 'barter' ),
				),
				'default'  => 'outside',
				'required' => array( 'page_title', '=', 'on' ),
			),
			array(
				'id'       => 'page_title_bar_variant',
				'type'     => 'radio',
				'title'    => esc_html__( 'Variant', 'barter' ),
				'options'  => array(
					'classic'  => esc_html__( 'Classic(to side)', 'barter' ),
					'centered' => esc_html__( 'Centered', 'barter' ),
				),
				'default'  => 'classic',
				'required' => array(
					array( 'page_title', '=', 'on' ),
					array( 'page_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'page_title_bar_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Background image', 'barter' ),
				'default'  => '',
				'required' => array(
					array( 'page_title', '=', 'on' ),
					array( 'page_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'page_title_bar_image_fit',
				'type'     => 'select',
				'title'    => esc_html__( 'How to fit the background image', 'barter' ),
				'options'  => $image_fit,
				'default'  => 'repeat',
				'required' => array(
					array( 'page_title', '=', 'on' ),
					array( 'page_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'page_title_bar_parallax',
				'type'     => 'radio',
				'title'    => esc_html__( 'Parallax', 'barter' ),
				'options'  => $on_off,
				'default'  => 'off',
				'required' => array(
					array( 'page_title', '=', 'on' ),
					array( 'page_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'          => 'page_title_bar_parallax_type',
				'type'        => 'select',
				'title'       => esc_html__( 'Parallax', 'barter' ). ' : ' . esc_html__( 'Type', 'barter' ),
				'description' => esc_html__( 'It defines how the image will scroll in the background while the page is scrolled down.', 'barter' ),
				'options'     => $parallax_types,
				'default'     => 'tb',
				'required'    => array(
					array( 'page_title', '=', 'on' ),
					array( 'page_title_bar_position', '!=', 'inside' ),
					array( 'page_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'page_title_bar_parallax_speed',
				'type'        => 'slider',
				'title'       => esc_html__( 'Parallax', 'barter' ). ' : ' . esc_html__( 'Speed', 'barter' ),
				'description' => esc_html__( 'It will be only used for the background that is repeated. If the background is set to not repeat this value will be ignored.', 'barter' ),
				'min'         => 0,
				'max'         => 1,
				'step'        => 0.01,
				'default'     => '1.00',
				'required'    => array(
					array( 'page_title', '=', 'on' ),
					array( 'page_title_bar_position', '!=', 'inside' ),
					array( 'page_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'page_title_bar_bg_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Overlay color', 'barter' ),
				'description' => esc_html__( 'Will be placed above the image(if used)', 'barter' ),
				'default'     => '',
				'required'    => array( 'page_title', '=', 'on' ),
			),
			array(
				'id'       => 'page_title_bar_title_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Titles', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'default'  => '',
				'required' => array(
					array( 'page_title', '=', 'on' ),
					array( 'page_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'          => 'page_title_bar_color_1',
				'type'        => 'color',
				'title'       => esc_html__( 'Other elements', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'description' => esc_html__( 'Used in breadcrumbs.', 'barter' ),
				'default'     => '',
				'required'    => array(
					array( 'page_title', '=', 'on' ),
					array( 'page_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'page_title_bar_space_width',
				'type'     => 'slider',
				'title'    => esc_html__( 'Top/bottom padding', 'barter' ),
				'min'      => 0,
				'max'      => 600,
				'step'     => 1,
				'unit'     => 'px',
				'default'  => '40',
				'required' => array(
					array( 'page_title', '=', 'on' ),
					array( 'page_title_bar_position', '!=', 'inside' ),
				)
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( '404 page template', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_404_page',
		'icon'       => 'fa fa-exclamation-triangle',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'page_404_template_type',
				'type'        => 'radio',
				'title'       => esc_html__( 'Type', 'barter' ),
				'options'     => array(
					'default' => esc_html__( 'Default', 'barter' ),
				),
				'default'     => 'default',
			),
			array(
				'id'       => 'page_404_bg_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Default but I want to change the background image', 'barter' ),
				'required' => array( 'page_404_template_type', '=', 'default' ),
			),
		)
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Password protected page template', 'barter' ),
		'id'         => 'subsection_password_page',
		'icon'       => 'fa fa-lock',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'page_password_template_type',
				'type'        => 'radio',
				'title'       => esc_html__( 'Type', 'barter' ),
				'options'     => array(
					'default' => esc_html__( 'Default', 'barter' ),
				),
				'default'     => 'default',
			),
			array(
				'id'       => 'page_password_bg_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Default but I want to change the background image', 'barter' ),
				'required' => array( 'page_password_template_type', '=', 'default' ),
			),
		)
	) );

//MISCELLANEOUS
	$barter_a13->barter_set_sections( array(
		'title'    => esc_html__( 'Miscellaneous', 'barter' ),
		'desc'     => '',
		'id'       => 'section_miscellaneous',
		'icon'     => 'fa fa-question',
		'priority' => 24,
		'fields'   => array(),
	) );

	$barter_a13->barter_set_sections( array(
		'title'      => esc_html__( 'Anchors', 'barter' ),
		'desc'       => '',
		'id'         => 'subsection_anchors',
		'icon'       => 'fa fa-external-link',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'anchors_in_bar',
				'type'        => 'radio',
				'title'       => esc_html__( 'Display anchors in address bar', 'barter' ),
				'options'     => $on_off,
				'default'     => 'off',
			),
			array(
				'id'          => 'scroll_to_anchor',
				'type'        => 'radio',
				'title'       => esc_html__( 'Scroll to anchor handling', 'barter' ),
				'description' => esc_html__( 'If enabled it will scroll to anchor after it is clicked on the same page. It can, however, conflict with plugins that uses the same mechanism, and the page can scroll in a weird way. In such case disable this feature.', 'barter' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
		)
	) );

	/*
 * <--- END SECTIONS
 */

	do_action( 'barter_additional_theme_options' );
}
}
barter_setup_theme_options();