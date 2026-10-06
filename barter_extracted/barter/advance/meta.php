<?php
if (!function_exists('barter_meta_boxes_post')) {
function barter_meta_boxes_post() {
	$meta = array(
		/*
		 *
		 * Tab: Posts list
		 *
		 */
		'posts_list' => array(
			array(
				'name' => __('Posts list', 'barter'),
				'type' => 'fieldset',
				'tab'   => true,
				'icon'  => 'fa fa-list'
			),
			array(
				'name'        => __( 'Size of brick', 'barter' ),
				'description' => __( 'What should be the width of this post on the Posts list?', 'barter' ),
				'id'          => 'brick_ratio_x',
				'default'     => 1,
				'unit'        => '',
				'min'         => 1,
				'max'         => 4,
				'type'        => 'slider'
			),
		),


		/*
		 *
		 * Tab: Featured media
		 *
		 */
		'featured_media' => array(
			array(
				'name' => __('Featured media', 'barter'),
				'type' => 'fieldset',
				'tab'   => true,
				'icon'  => 'fa fa-star'
			),
			array(
				'name'        => __( 'Post media', 'barter' ),
				'id'          => 'image_or_video',
				'default'     => 'post_image',
				'options'     => array(
					'post_image'  => __( 'Image', 'barter' ),
				),
				'type'        => 'radio',
			),
			array(
				'name'        => __( 'Featured Image ', 'barter' ). ' : ' . __( 'Parallax', 'barter' ),
				'id'          => 'image_parallax',
				'default'     => 'off',
				'type'        => 'radio',
				'options'     => array(
					'on'  => __( 'Enable', 'barter' ),
					'off' => __( 'Disable', 'barter' ),
				),
				'required'    => array( 'image_or_video', '=', 'post_image' ),
			),
			array(
				'name'     => esc_html__( 'Parallax', 'barter' ). ' : ' . esc_html__( 'Area height', 'barter' ),
				'description' => __( 'This limits the height of the image so that the parallax can work.', 'barter' ),
				'id'       => 'image_parallax_height',
				'default'  => '260',
				'unit'     => 'px',
				'min'      => 100,
				'max'      => 600,
				'type'     => 'slider',
				'required' => array(
					array( 'image_or_video', '=', 'post_image' ),
					array( 'image_parallax', '=', 'on' ),
				)
			),
		),

		/*
		 *
		 * Tab: Header
		 *
		 */
		'header' => array(
			array(
				'name' => __('Header', 'barter'),
				'type' => 'fieldset',
				'tab'   => true,
				'icon'  => 'fa fa-cogs'
			),
			array(
				'name'          => __( 'Hide content under the header', 'barter' ),
				'description'   => __( 'Works only with the horizontal header.', 'barter' ),
				'id'            => 'content_under_header',
				'global_value'  => 'G',
				'default'       => 'G',
				'parent_option' => 'post_content_under_header',
				'type'          => 'select',
				'options'       => array(
					'G'       => __( 'Global settings', 'barter' ),
					'content' => __( 'Yes, hide the content', 'barter' ),
					'title'   => __( 'Yes, hide the content and add top padding to the outside title bar.', 'barter' ),
					'off'     => __( 'Turn it off', 'barter' ),
				),
			),
		),

		/*
		 *
		 * Tab: Title bar
		 *
		 */
		'title_bar' => array(
			array(
				'name' => __('Title bar', 'barter'),
				'type' => 'fieldset',
				'tab'   => true,
				'icon'  => 'fa fa-text-width'
			),
			array(
				'name'        => __( 'Title bar', 'barter' ),
				'description' => __( 'You can use global settings or override them here', 'barter' ),
				'id'          => 'title_bar_settings',
				'default'     => 'global',
				'type'        => 'radio',
				'options'     => array(
					'global' => __( 'Global settings', 'barter' ),
					'custom' => __( 'Use custom settings', 'barter' ),
					'off'    => __( 'Turn it off', 'barter' ),
				),
			),
			array(
				'name'        => __( 'Position', 'barter' ),
				'id'          => 'title_bar_position',
				'default'     => 'outside',
				'type'        => 'radio',
				'options'     => array(
					'outside' => __( 'Before the content', 'barter' ),
					'inside'  => __( 'Inside the content', 'barter' ),
				),
				'description' => __( 'To set the background image for the "Before the content" option, use the <strong>featured image</strong>.', 'barter' ),
				'required'    => array( 'title_bar_settings', '=', 'custom' ),
			),
			array(
				'name'        => __( 'Variant', 'barter' ),
				'description' => '',
				'id'          => 'title_bar_variant',
				'default'     => 'classic',
				'options'     => array(
					'classic'  => __( 'Classic(to side)', 'barter' ),
					'centered' => __( 'Centered', 'barter' ),
				),
				'type'        => 'radio',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'        => __( 'Width', 'barter' ),
				'description' => '',
				'id'          => 'title_bar_width',
				'default'     => 'full',
				'options'     => array(
					'full'  => __( 'Full', 'barter' ),
					'boxed' => __( 'Boxed', 'barter' ),
				),
				'type'        => 'radio',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'     => __( 'How to fit the background image', 'barter' ),
				'id'       => 'title_bar_image_fit',
				'default'  => 'repeat',
				'options'  => array(
					'cover'    => __( 'Cover', 'barter' ),
					'contain'  => __( 'Contain', 'barter' ),
					'fitV'     => __( 'Fit Vertically', 'barter' ),
					'fitH'     => __( 'Fit Horizontally', 'barter' ),
					'center'   => __( 'Just center', 'barter' ),
					'repeat'   => __( 'Repeat', 'barter' ),
					'repeat-x' => __( 'Repeat X', 'barter' ),
					'repeat-y' => __( 'Repeat Y', 'barter' ),
				),
				'type'     => 'select',
				'required' => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'        => __( 'Parallax', 'barter' ),
				'description' => '',
				'id'          => 'title_bar_parallax',
				'default'     => 'off',
				'options'     => array(
					'on'  => __( 'Enable', 'barter' ),
					'off' => __( 'Disable', 'barter' ),
				),
				'type'        => 'radio',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'        => __( 'Parallax', 'barter' ). ' : ' . __( 'Type', 'barter' ),
				'description' => __( 'It defines how the image will scroll in the background while the page is scrolled down.', 'barter' ),
				'id'          => 'title_bar_parallax_type',
				'default'     => 'tb',
				'options'     => array(
					"tb"   => __( 'top to bottom', 'barter' ),
					"bt"   => __( 'bottom to top', 'barter' ),
					"lr"   => __( 'left to right', 'barter' ),
					"rl"   => __( 'right to left', 'barter' ),
					"tlbr" => __( 'top-left to bottom-right', 'barter' ),
					"trbl" => __( 'top-right to bottom-left', 'barter' ),
					"bltr" => __( 'bottom-left to top-right', 'barter' ),
					"brtl" => __( 'bottom-right to top-left', 'barter' ),
				),
				'type'        => 'select',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
					array( 'title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'name'        => __( 'Parallax', 'barter' ). ' : ' . __( 'Speed', 'barter' ),
				'description' => __( 'It will be only used for the background that is repeated. If the background is set to not repeat this value will be ignored.', 'barter' ),
				'id'          => 'title_bar_parallax_speed',
				'default'     => '1.00',
				'type'        => 'text',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
					array( 'title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'name'        => __( 'Overlay color', 'barter' ),
				'description' => __( 'Will be placed above the image(if used)', 'barter' ),
				'id'          => 'title_bar_bg_color',
				'default'     => '',
				'type'        => 'color',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'     => esc_html__( 'Titles', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'id'       => 'title_bar_title_color',
				'default'  => '',
				'type'     => 'color',
				'required' => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'        => __( 'Top/bottom padding', 'barter' ),
				'description' => '',
				'id'          => 'title_bar_space_width',
				'default'     => '40px',
				'unit'        => 'px',
				'min'         => 0,
				'max'         => 600,
				'type'        => 'slider',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
		),

	);

	return apply_filters( 'barter_meta_boxes_post', $meta );
}
}


if (!function_exists('barter_meta_boxes_page')) {
function barter_meta_boxes_page() {
	$sidebars = array_merge(
		array(
			'default' => __( 'Default for pages', 'barter' ),
		),
		barter_meta_get_user_sidebars()
	);

	$meta = array(
		/*
		 *
		 * Tab: Layout &amp; Sidebar
		 *
		 */
		'layout' => array(
			array(
				'name' => __('Layout &amp; Sidebar', 'barter'),
				'type' => 'fieldset',
				'tab'   => true,
				'icon'  => 'fa fa-wrench'
			),
			array(
				'name'          => __( 'Content Layout', 'barter' ),
				'id'            => 'content_layout',
				'default'       => 'global',
				'global_value'  => 'global',
				'parent_option' => 'page_content_layout',
				'type'          => 'select',
				'options'       => array(
					'global'        => __( 'Global settings', 'barter' ),
					'center'        => __( 'Center fixed width', 'barter' ),
					'left'          => __( 'Left fixed width', 'barter' ),
					'left_padding'  => __( 'Left fixed width + padding', 'barter' ),
					'right'         => __( 'Right fixed width', 'barter' ),
					'right_padding' => __( 'Right fixed width + padding', 'barter' ),
					'full_fixed'    => __( 'Full width + fixed content', 'barter' ),
					'full_padding'  => __( 'Full width + padding', 'barter' ),
					'full'          => __( 'Full width', 'barter' ),
				),
			),
			array(
				'name'        => esc_html__( 'Content', 'barter' ). ' : ' .esc_html__( 'Top/bottom padding', 'barter' ),
				'id'          => 'content_padding',
				'default'     => 'both',
				'type'        => 'select',
				'options'     => array(
					'both'   => __( 'Both on', 'barter' ),
					'top'    => __( 'Only top', 'barter' ),
					'bottom' => __( 'Only bottom', 'barter' ),
					'off'    => __( 'Both off', 'barter' ),
				),
			),
			array(
				'name'        => __( 'Content', 'barter' ). ' : ' .esc_html__( 'Left/right padding', 'barter' ),
				'id'          => 'content_side_padding',
				'default'     => 'both',
				'type'        => 'radio',
				'options'     => array(
					'both'   => __( 'Both on', 'barter' ),
					'off'    => __( 'Both off', 'barter' ),
				),
			),
			array(
				'name'          => __( 'Sidebar', 'barter' ),
				'id'            => 'widget_area',
				'global_value'  => 'G',
				'default'       => 'G',
				'parent_option' => 'page_sidebar',
				'options'       => array(
					'G'                     => __( 'Global settings', 'barter' ),
					'left-sidebar'          => __( 'Sidebar on the left', 'barter' ),
					'left-sidebar_and_nav'  => __( 'Children Navigation', 'barter' ) . ' + ' . __( 'Sidebar on the left', 'barter' ),
					/* translators: %s: Children Navigation */
					'left-nav'             => sprintf( __( 'Only %s on the left', 'barter' ), __( 'Children Navigation', 'barter' ) ),
					'right-sidebar'         => __( 'Sidebar on the right', 'barter' ),
					'right-sidebar_and_nav' => __( 'Children Navigation', 'barter' ) . ' + ' . __( 'Sidebar on the right', 'barter' ),
					/* translators: %s: Children Navigation */
					'right-nav'             => sprintf( __( 'Only %s on the right', 'barter' ), __( 'Children Navigation', 'barter' ) ),
					'off'                   => __( 'Off', 'barter' ),
				),
				'type'          => 'select',
			),
			array(
				'name'     => __( 'Sidebar to show', 'barter' ),
				'id'       => 'sidebar_to_show',
				'default'  => 'default',
				'options'  => $sidebars,
				'type'     => 'select',
				'required' => array( 'widget_area', '!=', 'off' ),
			),
		),

		/*
		 *
		 * Tab: Header
		 *
		 */
		'header' => array(
			array(
				'name' => __('Header', 'barter'),
				'type' => 'fieldset',
				'tab'   => true,
				'icon'  => 'fa fa-cogs'
			),
			array(
				'name'          => __( 'Hide content under the header', 'barter' ),
				'description'   => __( 'Works only with the horizontal header.', 'barter' ),
				'id'            => 'content_under_header',
				'global_value'  => 'G',
				'default'       => 'G',
				'parent_option' => 'page_content_under_header',
				'type'          => 'select',
				'options'       => array(
					'G'       => __( 'Global settings', 'barter' ),
					'content' => __( 'Yes, hide the content', 'barter' ),
					'title'   => __( 'Yes, hide the content and add top padding to the outside title bar.', 'barter' ),
					'off'     => __( 'Turn it off', 'barter' ),
				),
			),
			array(
				'name'          => __( 'Show header from the Nth row', 'barter' ),
				'description'   => __( 'Works only with the horizontal header.', 'barter' ). '<br />' . __( 'If you use Elementor or WPBakery Page Builder, then you can decide to show header after the content is scrolled to Nth row. Thanks to that you can have a clean welcome screen.', 'barter' ),
				'id'            => 'horizontal_header_show_header_at',
				'default'       => '0',
				'type'          => 'select',
				'options'       => array(
					'0' => __( 'Show always', 'barter' ),
					'1' => __( 'from 1st row', 'barter' ),
					'2' => __( 'from 2nd row', 'barter' ),
					'3' => __( 'from 3rd row', 'barter' ),
					'4' => __( 'from 4th row', 'barter' ),
					'5' => __( 'from 5th row', 'barter' ),
				),
			),
		),

		/*
		 *
		 * Tab: Title bar
		 *
		 */
		'title_bar' => array(
			array(
				'name' => __('Title bar', 'barter'),
				'type' => 'fieldset',
				'tab'   => true,
				'icon'  => 'fa fa-text-width'
			),
			array(
				'name'        => __( 'Title bar', 'barter' ),
				'description' => __( 'You can use global settings or override them here', 'barter' ),
				'id'          => 'title_bar_settings',
				'default'     => 'global',
				'type'        => 'radio',
				'options'     => array(
					'global' => __( 'Global settings', 'barter' ),
					'custom' => __( 'Use custom settings', 'barter' ),
					'off'    => __( 'Turn it off', 'barter' ),
				),
			),
			array(
				'name'        => __( 'Position', 'barter' ),
				'id'          => 'title_bar_position',
				'default'     => 'outside',
				'type'        => 'radio',
				'options'     => array(
					'outside' => __( 'Before the content', 'barter' ),
					'inside'  => __( 'Inside the content', 'barter' ),
				),
				'description' => __( 'To set the background image for the "Before the content" option, use the <strong>featured image</strong>.', 'barter' ),
				'required'    => array( 'title_bar_settings', '=', 'custom' ),
			),
			array(
				'name'        => __( 'Variant', 'barter' ),
				'description' => '',
				'id'          => 'title_bar_variant',
				'default'     => 'classic',
				'options'     => array(
					'classic'  => __( 'Classic(to side)', 'barter' ),
					'centered' => __( 'Centered', 'barter' ),
				),
				'type'        => 'radio',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'        => __( 'Width', 'barter' ),
				'description' => '',
				'id'          => 'title_bar_width',
				'default'     => 'full',
				'options'     => array(
					'full'  => __( 'Full', 'barter' ),
					'boxed' => __( 'Boxed', 'barter' ),
				),
				'type'        => 'radio',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'     => __( 'How to fit the background image', 'barter' ),
				'id'       => 'title_bar_image_fit',
				'default'  => 'repeat',
				'options'  => array(
					'cover'    => __( 'Cover', 'barter' ),
					'contain'  => __( 'Contain', 'barter' ),
					'fitV'     => __( 'Fit Vertically', 'barter' ),
					'fitH'     => __( 'Fit Horizontally', 'barter' ),
					'center'   => __( 'Just center', 'barter' ),
					'repeat'   => __( 'Repeat', 'barter' ),
					'repeat-x' => __( 'Repeat X', 'barter' ),
					'repeat-y' => __( 'Repeat Y', 'barter' ),
				),
				'type'     => 'select',
				'required' => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'        => __( 'Parallax', 'barter' ),
				'description' => '',
				'id'          => 'title_bar_parallax',
				'default'     => 'off',
				'options'     => array(
					'on'  => __( 'Enable', 'barter' ),
					'off' => __( 'Disable', 'barter' ),
				),
				'type'        => 'radio',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'        => __( 'Parallax', 'barter' ). ' : ' . __( 'Type', 'barter' ),
				'description' => __( 'It defines how the image will scroll in the background while the page is scrolled down.', 'barter' ),
				'id'          => 'title_bar_parallax_type',
				'default'     => 'tb',
				'options'     => array(
					"tb"   => __( 'top to bottom', 'barter' ),
					"bt"   => __( 'bottom to top', 'barter' ),
					"lr"   => __( 'left to right', 'barter' ),
					"rl"   => __( 'right to left', 'barter' ),
					"tlbr" => __( 'top-left to bottom-right', 'barter' ),
					"trbl" => __( 'top-right to bottom-left', 'barter' ),
					"bltr" => __( 'bottom-left to top-right', 'barter' ),
					"brtl" => __( 'bottom-right to top-left', 'barter' ),
				),
				'type'        => 'select',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
					array( 'title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'name'        => __( 'Parallax', 'barter' ). ' : ' . __( 'Speed', 'barter' ),
				'description' => __( 'It will be only used for the background that is repeated. If the background is set to not repeat this value will be ignored.', 'barter' ),
				'id'          => 'title_bar_parallax_speed',
				'default'     => '1.00',
				'type'        => 'text',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
					array( 'title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'name'        => __( 'Overlay color', 'barter' ),
				'description' => __( 'Will be placed above the image(if used)', 'barter' ),
				'id'          => 'title_bar_bg_color',
				'default'     => '',
				'type'        => 'color',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'     => esc_html__( 'Titles', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'id'       => 'title_bar_title_color',
				'default'  => '',
				'type'     => 'color',
				'required' => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'        => esc_html__( 'Other elements', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
				'id'          => 'title_bar_color_1',
				'default'     => '',
				'type'        => 'color',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'        => __( 'Top/bottom padding', 'barter' ),
				'description' => '',
				'id'          => 'title_bar_space_width',
				'default'     => '40px',
				'unit'        => 'px',
				'min'         => 0,
				'max'         => 600,
				'type'        => 'slider',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
		),

		/*
		 *
		 * Tab: Featured media
		 *
		 */
		'featured_media' => array(
			array(
				'name' => __('Featured media', 'barter'),
				'type' => 'fieldset',
				'tab'   => true,
				'icon'  => 'fa fa-star'
			),
			array(
				'name'        => __( 'Post media', 'barter' ),
				'id'          => 'image_or_video',
				'default'     => 'post_image',
				'options'     => array(
					'post_image'  => __( 'Image', 'barter' ),
				),
				'type'        => 'radio',
			),
			array(
				'name'        => __( 'Featured Image ', 'barter' ). ' : ' . __( 'Parallax', 'barter' ),
				'id'          => 'image_parallax',
				'default'     => 'off',
				'type'        => 'radio',
				'options'     => array(
					'on'  => __( 'Enable', 'barter' ),
					'off' => __( 'Disable', 'barter' ),
				),
				'required'    => array( 'image_or_video', '=', 'post_image' ),
			),
			array(
				'name'     => esc_html__( 'Parallax', 'barter' ). ' : ' . esc_html__( 'Area height', 'barter' ),
				'description' => __( 'This limits the height of the image so that the parallax can work.', 'barter' ),
				'id'       => 'image_parallax_height',
				'default'  => '260',
				'unit'     => 'px',
				'min'      => 100,
				'max'      => 600,
				'type'     => 'slider',
				'required' => array(
					array( 'image_or_video', '=', 'post_image' ),
					array( 'image_parallax', '=', 'on' ),
				)
			),
		),

		/*
		 *
		 * Tab: Sticky one page mode
		 *
		 */
		'sticky_one_page' => array(
			array(
				'name' => __('Sticky One Page mode', 'barter'),
				'type' => 'fieldset',
				'tab'   => true,
				'icon'  => 'fa fa-anchor'
			),
			array(
				'name'        => __( 'Sticky One Page mode', 'barter' ),
				'description' => __( 'This works only when page is designed with WPBakery Page Builder. With this option enabled, the page will turn into a vertical slider to the full height of the browser window, and each row created in the WPBakery Page Builder is a single slide.', 'barter' ),
				'id'          => 'content_sticky_one_page',
				'default'     => 'off',
				'type'        => 'radio',
				'options'     => array(
					'on'  => __( 'Enable', 'barter' ),
					'off' => __( 'Disable', 'barter' ),
				),
			),
			array(
				'name'     => __( 'Color of navigation bullets', 'barter' ),
				'id'       => 'content_sticky_one_page_bullet_color',
				'default'  => 'rgba(0,0,0,1)',
				'type'     => 'color',
				'required' => array(
					array( 'content_sticky_one_page', '=', 'on' )
				)
			),
			array(
				'name'        => __( 'Default bullets icon', 'barter' ),
				'id'          => 'content_sticky_one_page_bullet_icon',
				'default'     => '',
				'type'        => 'text',
				'input_class' => 'a13-fa-icon a13-full-class',
				'required'    => array(
					array( 'content_sticky_one_page', '=', 'on' )
				)
			),
		),
	);

	return apply_filters( 'barter_meta_boxes_page', $meta );
}
}

if (!function_exists('barter_meta_boxes_images_manager')) {
function barter_meta_boxes_images_manager() {
	return apply_filters( 'barter_meta_boxes_images_manager', array('images_manager' => array()) );
}
}


if (!function_exists('barter_get_socials_array')) {
function barter_get_socials_array() {
	global $barter_a13;

	$tmp_arr = array();
	$socials = $barter_a13->barter_get_social_icons_list();
	foreach ( $socials as $id => $social ) {
		array_push( $tmp_arr, array( 'name' => $social, 'id' => $id, 'type' => 'text' ) );
	}
	return $tmp_arr;
}
}

if (!function_exists('barter_meta_boxes_people')) {
function barter_meta_boxes_people() {
	$meta =
		array(
			/*
			 *
			 * Tab: General
			 *
			 */
			'general' => array(
				array(
					'name' => __('General', 'barter'),
					'type' => 'fieldset',
					'tab'   => true,
					'icon'  => 'fa fa-wrench'
				),
				array(
						'name'        => __( 'Subtitle', 'barter' ),
						'description' => __( 'You can use HTML here.', 'barter' ),
						'id'          => 'subtitle',
						'default'     => '',
						'type'        => 'text'
				),
				array(
						'name'    => __( 'Testimonial', 'barter' ),
						'desc'    => '',
						'id'      => 'testimonial',
						'default' => '',
						'type'    => 'textarea'
				),
				array(
						'name'        => __( 'Overlay color', 'barter' ),
						'id'          => 'overlay_bg_color',
						'default'     => 'rgba(0,0,0,0.5)',
						'type'        => 'color'
				),
				array(
						'name'        => __( 'Overlay', 'barter' ). ' : ' .esc_html__( 'Text color', 'barter' ),
						'id'          => 'overlay_font_color',
						'default'     => 'rgba(255,255,255,1)',
						'type'        => 'color'
				),
			),

			/*
			 *
			 * Tab: Socials
			 *
			 */
			'socials' => array_merge(
				array(
					array(
						'name' => __('Social icons', 'barter'),
						'type' => 'fieldset',
						'tab'   => true,
						'icon'  => 'fa fa-facebook-official'
					),
				),
				barter_get_socials_array()
			),
		);

	return $meta;
}
}