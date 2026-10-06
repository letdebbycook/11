<?php
if(!function_exists( 'barter_post_meta_above_content' )){
	/**
	 *
	 * @deprecated 2.3.0 Now barter_get_post_meta_data() displays content of this function
	 * @see astra_deprecated_color_palette()
	 *
	 */
    function barter_post_meta_above_content() {
	    _deprecated_function( __FUNCTION__, '2.3.0' );
    }
}



if(!function_exists( 'barter_post_meta_under_content' )){
    /**
     * Returns some elements after post content
     *
     * @deprecated 2.3.0 Now barter_get_post_meta_data() displays content of this function
     *
     * @return string post meta data
     */
    function barter_post_meta_under_content() {
	    _deprecated_function( __FUNCTION__, '2.3.0', 'barter_get_post_meta_data()' );

	    return barter_get_post_meta_data();
    }
}



if(!function_exists( 'woo_custom_breadcrumbs_trail_add_product_categories' )){
    /**
     * @deprecated 2.3.0 renamed to barter_custom_breadcrumbs_trail_add_product_categories
     *
     * @param $trail
     *
     * @return array
     */
    function woo_custom_breadcrumbs_trail_add_product_categories( $trail ) {
	    _deprecated_function( __FUNCTION__, '2.3.0', 'barter_custom_breadcrumbs_trail_add_product_categories()' );

	    return barter_custom_breadcrumbs_trail_add_product_categories( $trail );
    }
}



if(!function_exists( 'woo_get_term_parents' )){
    /**
     * @deprecated 2.3.0 renamed to barter_wc_get_term_parents
     *
     * @param        $id
     * @param        $taxonomy
     * @param bool   $link
     * @param string $separator
     * @param bool   $nice_name
     * @param array  $visited
     *
     * @return string
     */
    function woo_get_term_parents( $id, $taxonomy, $link = false, $separator = '/', $nice_name = false, $visited = array() ) {
	    _deprecated_function( __FUNCTION__, '2.3.0', 'barter_wc_get_term_parents()' );

	    return barter_wc_get_term_parents( $id, $taxonomy, $link, $separator, $nice_name, $visited );
    }
}