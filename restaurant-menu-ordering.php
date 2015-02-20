<?php
/*
Plugin Name: Restaurant Menu Ordering
Plugin URI: http://topher1kenobe.com
Plugin Group: Utilities
Author: Topher
Author URI: //topher1kenobe.com
Description: Makes the Restaurant plugin allow hierarchical ordering of items.  WARNING: could make things slow if you have more than 100 items.
Version: 1.0
*/

function restaurant_item_hierarchical( $post_type, $args ) {
	// Make sure we're only editing the post type we want
	if ( 'restaurant_item' != $post_type )
		return;

	// Set menu icon
	$args->hierarchical = true;

	// Modify post type object
	$wp_post_types[$post_type] = $args;
}
add_action( 'registered_post_type', 'restaurant_item_hierarchical', 10, 2 );

function t1k_order_main_menu( $query ) {

	// check to see if we're editing the main query on the page.
	if( $query->is_main_query() ){

		// Check to make sure I'm on the proper archive page AND I'm not in the admin area
		if ( ( $query->is_post_type_archive( 'restaurant_item' ) OR $query->is_tax( 'restaurant_tag' ) ) AND ! is_admin() ) {

			// now I want to order by the menu_order field, ascending
			$query->set( 'orderby', 'menu_order' );
			$query->set( 'order', 'ASC' );

		}

	}
	return $query;

}
// now I apply my function to pre_get_posts and Bob's your uncle
add_filter( 'pre_get_posts', 't1k_order_main_menu' );
