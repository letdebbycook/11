<?php
/**
 * Template used for displaying password protected page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


global $barter_a13;


//custom template
if($barter_a13->get_option( 'page_password_template_type' ) === 'custom' ){
	$_page = $barter_a13->get_option( 'page_password_template' );

	define('BARTER_CUSTOM_PASSWORD_PROTECTED', true );

	//make query
	$query = new WP_Query( array('page_id' => $_page ) );

	//add password form to content
	add_filter( 'the_content', 'barter_add_password_form_to_template' );

	//show
	barter_page_like_content($query);

	// Reset Post Data
	wp_reset_postdata();

	return;
}

//default template
else{
	define('BARTER_PASSWORD_PROTECTED', true); //to get proper class in body

	$_title = '<span class="fa fa-lock emblem"></span>' . esc_html__( 'This content is password protected.', 'barter' )
	         .'<br />'
	         .esc_html__( 'To view it please enter your password below', 'barter' );

	get_header();

	barter_title_bar( 'outside', $_title );

	echo barter_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	get_footer();
}