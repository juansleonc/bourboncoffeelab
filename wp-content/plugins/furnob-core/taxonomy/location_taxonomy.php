<?php

/*************************************************
## Register Location Taxonomy
*************************************************/ 

function custom_taxonomy_location()  {
$labels = array(
    'name'                       => 'Locations',
    'singular_name'              => 'Location',
    'menu_name'                  => 'Locations',
    'all_items'                  => 'All Locations',
    'parent_item'                => 'Parent Item',
    'parent_item_colon'          => 'Parent Item:',
    'new_item_name'              => 'New Item Name',
    'add_new_item'               => 'Add New Location',
    'edit_item'                  => 'Edit Item',
    'update_item'                => 'Update Item',
    'separate_items_with_commas' => 'Separate Item with commas',
    'search_items'               => 'Search Items',
    'add_or_remove_items'        => 'Add or remove Items',
    'choose_from_most_used'      => 'Choose from the most used Items',
);
$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
);
register_taxonomy( 'location', array( 'product','shop_coupon' ), $args );
register_taxonomy_for_object_type( 'location', array( 'product','shop_coupon' ) );
}
add_action( 'init', 'custom_taxonomy_location' );



/*************************************************
## Furnob Query Vars
*************************************************/ 
function furnob_query_vars( $query_vars ){
    $query_vars[] = 'klb_special_query';
    return $query_vars;
}
add_filter( 'query_vars', 'furnob_query_vars' );

/*************************************************
## Furnob Product Query for Klb Shortcodes
*************************************************/ 
function furnob_location_product_query( $query ){
    if( isset( $query->query_vars['klb_special_query'] ) && furnob_location() != 'all'){
		$tax_query[] = array(
			'taxonomy' => 'location',
			'field'    => 'slug',
			'terms'    => furnob_location(),
		);

		$query->set( 'tax_query', $tax_query );
	}
}
add_action( 'pre_get_posts', 'furnob_location_product_query' );

/*************************************************
## Furnob Location
*************************************************/ 
function furnob_location(){	
	$location  = isset( $_COOKIE['location'] ) ? $_COOKIE['location'] : 'all';
	if($location){
		return $location;
	}
}

/*************************************************
## Furnob Location Output
*************************************************/
add_action('wp_footer', 'furnob_location_output'); 
function furnob_location_output(){
	
	wp_enqueue_script( 'jquery-cookie');
	wp_enqueue_script( 'klb-location-filter');


	$terms = get_terms( array(
		'taxonomy' => 'location',
		'hide_empty' => false,
		'parent'    => 0,
	) );

	$output = '';
	
	$output .= '<div class="site-location">';
	$output .= '<div class="site-location-inner">';
	$output .= '<div class="site-location-header">';
	$output .= '<h3 class="entry-title">'.esc_html__('Choose Your Location', 'furnob-core').'</h3>';
	$output .= '<div class="site-location-close"><i class="klbth-icon-x"></i></div>';
	$output .= '</div><!-- site-location-header -->';
	$output .= '<div class="site-location-body">';
	$output .= '<div class="site-location-items">';
	$output .= '<div class="site-scroll">';
	$output .= '<ul>';
	$output .= '<li><a href="" data-value="all">'.esc_html__('Select a Location','furnob-core').' <span>'.esc_html__('Clear All','furnob-core').'</span></a></li>';

	foreach ( $terms as $term ) {
		if($term->slug == furnob_location()){
			$select = 'selected';
		} else {
			$select = '';
		}
		
		$output .= '<li><a class="'.esc_attr($select).'" href="'.add_query_arg('location', esc_attr($term->slug)).'" data-value="'.esc_attr($term->slug).'">'.esc_html($term->name).' <span>'.esc_html($term->description).'</span></a></li>';
	
	}
			
	$output .= '</ul>';
	$output .= '</div><!-- site-scroll -->';
	$output .= '</div><!-- site-location-items -->';
	$output .= '</div><!-- site-location-body -->';
	$output .= '</div><!-- site-location-inner -->';
	$output .= '</div><!-- site-location -->';
	

	
	echo $output;
}