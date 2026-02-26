<?php

/*************************************************
## Woocommerce 
*************************************************/

function furnob_product_image(){
	if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {
		$att=get_post_thumbnail_id();
		$image_src = wp_get_attachment_image_src( $att, 'full' );
		$image_src = $image_src[0];

		$size = get_theme_mod( 'furnob_product_image_size', array( 'width' => '', 'height' => '') );

		if($size['width'] && $size['height']){
			$image = furnob_resize( $image_src, $size['width'], $size['height'], true, true, true );  
		} else {
			$image = $image_src;
		}
		
		return esc_url($image);
	} else {
		return wc_placeholder_img_src('');
	}
}

function furnob_product_second_image(){
	global $product;
	
	$product_image_ids = $product->get_gallery_image_ids();
	
	if($product_image_ids){
		$gallery_count = 1;
		foreach( $product_image_ids as $product_image_id ){
			if($gallery_count == 1){
				$image_url = wp_get_attachment_url( $product_image_id );
				return esc_url($image_url);
			}
			$gallery_count++;
		}
	}
}

function furnob_sale_percentage(){
	global $product;

	$output = '';

	$badge = get_post_meta( get_the_ID(), 'klb_product_badge', true );

	if ( $product->is_on_sale() && $product->is_type( 'variable' ) ) {
		$percentage = '-'.ceil(100 - ($product->get_variation_sale_price() / $product->get_variation_regular_price( 'min' )) * 100);
		$output .= '<div class="product-badges"><span class="badge onsale">'.$percentage.'%</span></div>';
	} elseif( $product->is_on_sale() && $product->get_regular_price()  && !$product->is_type( 'grouped' )) {
		$percentage = '-'.ceil(100 - ($product->get_sale_price() / $product->get_regular_price()) * 100);
		$output .= '<div class="product-badges">';
		if($badge){
		$output .= '<span class="badge trending">'.esc_html($badge).'</span>';
		} else {
		$output .= '<span class="badge onsale">'.$percentage.'%</span>';
		}
		$output .= '</div>';
	}
	
	return $output;

}

function furnob_vendor_name(){
	if (function_exists('get_wcmp_vendor_settings')) {
		global $post;
		$vendor = get_wcmp_product_vendors($post->ID);
		if (isset($vendor->page_title)) {
			$store_name = $vendor->page_title;
			return '<div class="product-store"><span>'.esc_html__('Store:', 'furnob').'</span><a href="'.esc_url($vendor->permalink).'"> '.esc_html($store_name).'</a></div>';
		}
	}elseif(class_exists('WeDevs_Dokan')){
		// Get the author ID (the vendor ID)
		$vendor_id = get_post_field( 'post_author', get_the_id() );

		$store_info  = dokan_get_store_info( $vendor_id ); // Get the store data
		$store_name  = $store_info['store_name'];          // Get the store name
		$store_url   = dokan_get_store_url( $vendor_id );  // Get the store URL

		if (isset($store_name)) {
			return '<div class="product-store"><span>'.esc_html__('Store:', 'furnob').'</span><a href="'.esc_url($store_url).'"> '.esc_html($store_name).'</a></div>';
		}
	}
}

if ( class_exists( 'woocommerce' ) ) {
add_theme_support( 'woocommerce' );
add_image_size('furnob-woo-product', 450, 450, true);

// Remove woocommerce defauly styles
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

// hide default shop title anasayfadaki title gizlemek için
add_filter('woocommerce_show_page_title', 'furnob_override_page_title');
function furnob_override_page_title() {
return false;
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 ); /*remove result count above products*/
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 ); //remove rating
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 ); //remove rating
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title',10);

add_action( 'woocommerce_before_shop_loop_item', 'furnob_shop_box', 10);
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 ); /*remove breadcrumb*/

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price',10); /*remove price*/
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price',25); /*add price after excerpt*/

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products',20);
remove_action( 'woocommerce_after_single_product', 'woocommerce_output_related_products',10);
add_action( 'woocommerce_after_single_product_summary', 'furnob_related_products', 20);
function furnob_related_products(){
	$related_column = get_theme_mod('furnob_shop_related_post_column') ? get_theme_mod('furnob_shop_related_post_column') : '4';
    woocommerce_related_products( array('posts_per_page' => $related_column, 'columns' => $related_column));
}

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display', 20);
add_filter( 'woocommerce_cross_sells_columns', 'furnob_change_cross_sells_columns' );
function furnob_change_cross_sells_columns( $columns ) {
	return 4;
}

/*************************************************
## Single Gallery Columns
*************************************************/

add_filter ( 'woocommerce_product_thumbnails_columns', 'furnob_product_thumbnails_columns', 10, 1 );
function furnob_product_thumbnails_columns( $columns ) {
    return get_theme_mod('furnob_shop_single_gallery_columns', 6);
}

/*************************************************
## Wishlist Shortcode
*************************************************/
function furnob_wishlist_shortcode(){
	$output = '';
	
	$wishlist = get_theme_mod( 'furnob_wishlist_button', '0' );
	
	if($wishlist == '1' && function_exists('run_tinv_wishlist')){
	$output .= do_shortcode('[ti_wishlists_addtowishlist]');
	}

	return $output;
}

/*************************************************
## Compare Shortcode
*************************************************/
function furnob_compare_shortcode(){
	$output = '';
	
	$compare = get_theme_mod( 'furnob_compare_button', '0' );
	
	if($compare == '1' && function_exists('woosc_init')){
	$output .= do_shortcode('[woosc type="link"]');
	}

	return $output;
}

/*----------------------------
  Single Wishlist - Compare - Extra
 ----------------------------*/
add_action( 'woocommerce_single_product_summary', 'furnob_single_extra_options', 35);
function furnob_single_extra_options(){
	$wishlist = get_theme_mod( 'furnob_wishlist_button', '0' );
	$compare = get_theme_mod( 'furnob_compare_button', '0' );
	$sizechart = get_post_meta( get_the_ID(), 'klb_product_size_chart', true );
	
	if($wishlist || $compare || $sizechart){
		echo '<div class="extra-options">';
		
		if($sizechart){
			echo '<a href="#" class="size-button"><i class="klbth-icon-ruler-combine"></i> '.esc_html__('Size Chart', 'furnob').'</a>';
		}
		
		if($wishlist == '1' && function_exists('run_tinv_wishlist')){
			echo do_shortcode('[ti_wishlists_addtowishlist]');
		}
		
		if($compare == '1' && function_exists('woosc_init')){
			echo do_shortcode('[woosc type="link"]');
		}
		
		echo '</div><!-- extra-options -->';
	}

}

/*************************************************
## Shipping Class Name
*************************************************/

function furnob_shipping_class_name($type = 'name') {
	global $product;
	$class_id = $product->get_shipping_class_id();
	if ( $class_id ) {
		$term = get_term_by( 'id', $class_id, 'product_shipping_class' );
		if($type == 'desc'){
			if ( $term && ! is_wp_error( $term ) ) {
				return $term->description;
			}
		} else {
			if ( $term && ! is_wp_error( $term ) ) {
				return $term->name;
			}
		}

	}
	return '';
}

/*************************************************
## Re-order WooCommerce Single Product Summary
*************************************************/
$reorder_single = get_theme_mod( 'furnob_shop_single_reorder', 
	array( 
		'woocommerce_template_single_title', 
		'woocommerce_template_single_rating',
		'woocommerce_template_single_excerpt',		
		'woocommerce_template_single_price', 
		'woocommerce_template_single_add_to_cart', 
		'furnob_single_extra_options', 
		'woocommerce_template_single_meta', 
		'furnob_social_share'		
		
	) 
);

if($reorder_single){
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	remove_action( 'woocommerce_single_product_summary', 'furnob_single_extra_options', 35 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	remove_action( 'woocommerce_single_product_summary', 'furnob_social_share', 70);
	
	$count = 8;
	
	foreach ( $reorder_single as $single_part ) {
		
		add_action( 'woocommerce_single_product_summary', $single_part, $count );
		
		$count+=8;
	}
}

/*----------------------------
  Product Type 1
 ----------------------------*/
function furnob_product_type1(){
	global $product;
	global $post;
	global $woocommerce;
	
	$output = '';
	
	$id = get_the_ID();
	$allproduct = wc_get_product( get_the_ID() );

	$cart_url = wc_get_cart_url();
	$price = $allproduct->get_price_html();
	$weight = $product->get_weight();
	$stock_status = $product->get_stock_status();
	$stock_text = $product->get_availability();
	$short_desc = $product->get_short_description();
	$rating = wc_get_rating_html($product->get_average_rating());
	$ratingcount = $product->get_review_count();
	$wishlist = get_theme_mod( 'furnob_wishlist_button', '0' );
	$compare = get_theme_mod( 'furnob_compare_button', '0' );
	$quickview = get_theme_mod( 'furnob_quick_view_button', '0' );

	$managestock = $product->managing_stock();
	$stock_quantity = $product->get_stock_quantity();
	$stock_format = esc_html__('Only %s left in stock','furnob');
	$stock_poor = '';
	if($managestock && $stock_quantity < 10) {
		$stock_poor .= '<div class="product-message color-danger">'.sprintf($stock_format, $stock_quantity).'</div>';
	}

	$postview  = isset( $_POST['shop_view'] ) ? $_POST['shop_view'] : '';

	if(furnob_shop_view() == 'list_view' || $postview == 'list_view') {
		$output .= '<div class="product-content">';
		$output .= '<div class="thumbnail-wrapper">';
		$output .= furnob_sale_percentage();
		$output .= '<div class="product-buttons">';
		
		$output .= furnob_wishlist_shortcode();
		
		$output .= furnob_compare_shortcode();
		
		if($quickview == '1'){
		$output .= '<a href="'.$product->get_id().'" class="detail-bnt quick-view-button"><i class="klbth-icon-resize"></i></a>';
		}
		
		$output .= '</div><!-- product-buttons -->';
		$output .= '<a href="'.get_permalink().'" class="hover-thumbnail">';
		if(furnob_product_second_image()){
		$output .= '<span class="second-thumbnail" style="background-image: url('.furnob_product_second_image().');"></span>';
		}
		$output .= '<img src="'.furnob_product_image().'" alt="'.the_title_attribute( 'echo=0' ).'">';
		$output .= '</a>';
					
		$output .= '</div><!-- thumbnail-wrapper -->';
		$output .= '<div class="content-wrapper">';
		$output .= '<h3 class="product-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
		$output .= '<span class="price">';
		$output .= $price;
		$output .= '</span><!-- price -->';
					
		if($ratingcount){
		$output .= '<div class="product-rating">';
		$output .= $rating;
		$output .= '<div class="count-rating">'.esc_html($product->get_average_rating()).' <span class="rating-text">'.esc_html('Rating', 'furnob').'</span></div>';
		$output .= '</div><!-- product-rating -->';
		}
					
		if(furnob_shipping_class_name()){
		$output .= '<div class="product-info success">'.furnob_shipping_class_name().'</div>';
		}

		$output .= '<div class="product-list-content">';
		$output .= '<div class="product-list-buttons">';
		ob_start();
		woocommerce_template_loop_add_to_cart();
		$output .= ob_get_clean();

		$output .= '</div><!-- product-list-buttons -->';
		$output .= '<div class="entry-content">';
		$output .= '<p>'.furnob_limit_words(get_the_excerpt(), '20').'</p>';
		$output .= '</div><!-- entry-content -->';
		$output .= '</div><!-- product-list-content -->';
		$output .= '</div><!-- content-wrapper -->';
		$output .= '</div><!-- product-content -->';
	} else {
		$output .= '<div class="product-content product-type-1">';
		$output .= '<div class="thumbnail-wrapper">';
		$output .= furnob_sale_percentage();
		$output .= '<div class="product-buttons">';
		
		$output .= furnob_wishlist_shortcode();
		
		$output .= furnob_compare_shortcode();
		
		if($quickview == '1'){
		$output .= '<a href="'.$product->get_id().'" class="detail-bnt quick-view-button"><i class="klbth-icon-resize"></i></a>';
		}
		
		$output .= '</div><!-- product-buttons -->';
		$output .= '<a href="'.get_permalink().'" class="hover-thumbnail">';
		if(furnob_product_second_image()){
		$output .= '<span class="second-thumbnail" style="background-image: url('.furnob_product_second_image().');"></span>';
		}
		$output .= '<img src="'.furnob_product_image().'" alt="'.the_title_attribute( 'echo=0' ).'">';
		$output .= '</a>';
		
		ob_start();
		woocommerce_template_loop_add_to_cart();
		$output .= ob_get_clean();
		
		$output .= '</div><!-- thumbnail-wrapper -->';
		$output .= '<div class="content-wrapper">';
		$output .= '<h3 class="product-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
		$output .= '<span class="price">';
		$output .= $price;
		$output .= '</span><!-- price -->';
		if($ratingcount){
		$output .= '<div class="product-rating">';
		$output .= $rating;
		$output .= '<div class="count-rating">'.esc_html($product->get_average_rating()).' <span class="rating-text">'.esc_html('Rating', 'furnob').'</span></div>';
		$output .= '</div><!-- product-rating -->';
		}

		$output .= furnob_vendor_name();

		if(furnob_shipping_class_name()){
		$output .= '<div class="product-info success">'.furnob_shipping_class_name().'</div>';
		}
		$output .= '</div><!-- content-wrapper -->';
		$output .= '</div><!-- product-content -->';

	}
	
	return $output;
}

/*----------------------------
  Product Type 2
 ----------------------------*/
function furnob_product_type2(){
	global $product;
	global $post;
	global $woocommerce;
	
	$output = '';
	
	$id = get_the_ID();
	$allproduct = wc_get_product( get_the_ID() );

	$cart_url = wc_get_cart_url();
	$price = $allproduct->get_price_html();
	$weight = $product->get_weight();
	$stock_status = $product->get_stock_status();
	$stock_text = $product->get_availability();
	$short_desc = $product->get_short_description();
	$rating = wc_get_rating_html($product->get_average_rating());
	$ratingcount = $product->get_review_count();
	$wishlist = get_theme_mod( 'furnob_wishlist_button', '0' );
	$compare = get_theme_mod( 'furnob_compare_button', '0' );
	$quickview = get_theme_mod( 'furnob_quick_view_button', '0' );

	$managestock = $product->managing_stock();
	$stock_quantity = $product->get_stock_quantity();
	$stock_format = esc_html__('Only %s left in stock','furnob');
	$stock_poor = '';
	if($managestock && $stock_quantity < 10) {
		$stock_poor .= '<div class="product-message color-danger">'.sprintf($stock_format, $stock_quantity).'</div>';
	}

	$postview  = isset( $_POST['shop_view'] ) ? $_POST['shop_view'] : '';

	if(furnob_shop_view() == 'list_view' || $postview == 'list_view') {
		$output .= '<div class="product-content">';
		$output .= '<div class="thumbnail-wrapper">';
		$output .= furnob_sale_percentage();
		$output .= '<div class="product-buttons">';
		
		$output .= furnob_wishlist_shortcode();
		
		$output .= furnob_compare_shortcode();
		
		if($quickview == '1'){
		$output .= '<a href="'.$product->get_id().'" class="detail-bnt quick-view-button"><i class="klbth-icon-resize"></i></a>';
		}
		
		$output .= '</div><!-- product-buttons -->';
		$output .= '<a href="'.get_permalink().'" class="hover-thumbnail">';
		if(furnob_product_second_image()){
		$output .= '<span class="second-thumbnail" style="background-image: url('.furnob_product_second_image().');"></span>';
		}
		$output .= '<img src="'.furnob_product_image().'" alt="'.the_title_attribute( 'echo=0' ).'">';
		$output .= '</a>';
					
		$output .= '</div><!-- thumbnail-wrapper -->';
		$output .= '<div class="content-wrapper">';
		$output .= '<h3 class="product-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
		$output .= '<span class="price">';
		$output .= $price;
		$output .= '</span><!-- price -->';
					
		if($ratingcount){
		$output .= '<div class="product-rating">';
		$output .= $rating;
		$output .= '<div class="count-rating">'.esc_html($product->get_average_rating()).' <span class="rating-text">'.esc_html('Rating', 'furnob').'</span></div>';
		$output .= '</div><!-- product-rating -->';
		}

		$output .= furnob_vendor_name();
					
		if(furnob_shipping_class_name()){
		$output .= '<div class="product-info success">'.furnob_shipping_class_name().'</div>';
		}

		$output .= '<div class="product-list-content">';
		$output .= '<div class="product-list-buttons">';
		ob_start();
		woocommerce_template_loop_add_to_cart();
		$output .= ob_get_clean();

		$output .= '</div><!-- product-list-buttons -->';
		$output .= '<div class="entry-content">';
		$output .= '<p>'.furnob_limit_words(get_the_excerpt(), '20').'</p>';
		$output .= '</div><!-- entry-content -->';
		$output .= '</div><!-- product-list-content -->';
		$output .= '</div><!-- content-wrapper -->';
		$output .= '</div><!-- product-content -->';

	} else {
		$output .= '<div class="product-content product-type-2">';
		$output .= '<div class="thumbnail-wrapper">';
		$output .= furnob_sale_percentage();
		$output .= '<div class="product-buttons">';
		$output .= furnob_wishlist_shortcode();
		
		$output .= furnob_compare_shortcode();
		
		if($quickview == '1'){
		$output .= '<a href="'.$product->get_id().'" class="detail-bnt quick-view-button"><i class="klbth-icon-resize"></i></a>';
		}
		
		$output .= '</div><!-- product-buttons -->';
		$output .= '<a href="'.get_permalink().'" class="hover-thumbnail">';
		if(furnob_product_second_image()){
		$output .= '<span class="second-thumbnail" style="background-image: url('.furnob_product_second_image().');"></span>';
		}
		$output .= '<img src="'.furnob_product_image().'" alt="'.the_title_attribute( 'echo=0' ).'">';
		$output .= '</a>';
		
		$output .= '</div><!-- thumbnail-wrapper -->';
		$output .= '<div class="content-wrapper">';
		$output .= '<h3 class="product-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
		
		$output .= '<div class="product-switcher">';
		$output .= '<div class="switcher-wrapper">';
		ob_start();
		woocommerce_template_loop_add_to_cart();
		$output .= ob_get_clean();
		
		$output .= '<span class="price">';
		$output .= $price;
		$output .= '</span><!-- price -->';
		$output .= '</div><!-- switcher-wrapper -->';
		$output .= '</div><!-- product-switcher -->';

		if($ratingcount){
		$output .= '<div class="product-rating">';
		$output .= $rating;
		$output .= '<div class="count-rating">'.esc_html($product->get_average_rating()).' <span class="rating-text">'.esc_html('Rating', 'furnob').'</span></div>';
		$output .= '</div><!-- product-rating -->';
		}

		$output .= furnob_vendor_name();

		if(furnob_shipping_class_name()){
		$output .= '<div class="product-info success">'.furnob_shipping_class_name().'</div>';
		}
		$output .= '</div><!-- content-wrapper -->';
		$output .= '</div><!-- product-content -->';

	}
	
	return $output;
}

/*----------------------------------
  Product Type 3 with progress bar
 -----------------------------------*/
function furnob_product_type3(){
	global $product;
	global $post;
	global $woocommerce;
	
	$output = '';
	
	$id = get_the_ID();
	$allproduct = wc_get_product( get_the_ID() );

	$cart_url = wc_get_cart_url();
	$price = $allproduct->get_price_html();
	$weight = $product->get_weight();
	$stock_status = $product->get_stock_status();
	$stock_text = $product->get_availability();
	$short_desc = $product->get_short_description();
	$rating = wc_get_rating_html($product->get_average_rating());
	$ratingcount = $product->get_review_count();
	$wishlist = get_theme_mod( 'furnob_wishlist_button', '0' );
	$compare = get_theme_mod( 'furnob_compare_button', '0' );
	$quickview = get_theme_mod( 'furnob_quick_view_button', '0' );

	$managestock = $product->managing_stock();
	$stock_quantity = $product->get_stock_quantity();
	$stock_format = esc_html__('Only %s left in stock','furnob');
	$stock_poor = '';
	if($managestock && $stock_quantity < 10) {
		$stock_poor .= '<div class="product-message color-danger">'.sprintf($stock_format, $stock_quantity).'</div>';
	}
	
	$total_sales = $product->get_total_sales();
	$total_stock = $total_sales + $stock_quantity;
	
	if($managestock) {
	$progress_percentage = floor($total_sales / (($total_sales + $stock_quantity) / 100)); // yuvarlama
	}

	$postview  = isset( $_POST['shop_view'] ) ? $_POST['shop_view'] : '';

	if(furnob_shop_view() == 'list_view' || $postview == 'list_view') {
		$output .= '<div class="product-content">';
		$output .= '<div class="thumbnail-wrapper">';
		$output .= furnob_sale_percentage();
		$output .= '<div class="product-buttons">';
		
		$output .= furnob_wishlist_shortcode();
		
		$output .= furnob_compare_shortcode();
		
		if($quickview == '1'){
		$output .= '<a href="'.$product->get_id().'" class="detail-bnt quick-view-button"><i class="klbth-icon-resize"></i></a>';
		}
		
		$output .= '</div><!-- product-buttons -->';
		$output .= '<a href="'.get_permalink().'" class="hover-thumbnail">';
		if(furnob_product_second_image()){
		$output .= '<span class="second-thumbnail" style="background-image: url('.furnob_product_second_image().');"></span>';
		}
		$output .= '<img src="'.furnob_product_image().'" alt="'.the_title_attribute( 'echo=0' ).'">';
		$output .= '</a>';
					
		$output .= '</div><!-- thumbnail-wrapper -->';
		$output .= '<div class="content-wrapper">';
		$output .= '<h3 class="product-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
		$output .= '<span class="price">';
		$output .= $price;
		$output .= '</span><!-- price -->';
					
		if($ratingcount){
		$output .= '<div class="product-rating">';
		$output .= $rating;
		$output .= '<div class="count-rating">'.esc_html($product->get_average_rating()).' <span class="rating-text">'.esc_html('Rating', 'furnob').'</span></div>';
		$output .= '</div><!-- product-rating -->';
		}

		$output .= furnob_vendor_name();
					
		if(furnob_shipping_class_name()){
		$output .= '<div class="product-info success">'.furnob_shipping_class_name().'</div>';
		}

		$output .= '<div class="product-list-content">';
		$output .= '<div class="product-list-buttons">';
		ob_start();
		woocommerce_template_loop_add_to_cart();
		$output .= ob_get_clean();

		$output .= '</div><!-- product-list-buttons -->';
		$output .= '<div class="entry-content">';
		$output .= '<p>'.furnob_limit_words(get_the_excerpt(), '20').'</p>';
		$output .= '</div><!-- entry-content -->';
		$output .= '</div><!-- product-list-content -->';
		$output .= '</div><!-- content-wrapper -->';
		$output .= '</div><!-- product-content -->';

	} else {

		$output .= '<div class="product-content product-type-3">';
		$output .= '<div class="thumbnail-wrapper">';
        $output .= furnob_sale_percentage();
		$output .= '<div class="product-buttons">';
					  
        $output .= furnob_wishlist_shortcode();
		
		$output .= furnob_compare_shortcode();
		
		if($quickview == '1'){
		$output .= '<a href="'.$product->get_id().'" class="detail-bnt quick-view-button"><i class="klbth-icon-resize"></i></a>';
		}
		$output .= '</div><!-- product-buttons -->';
		$output .= '<a href="'.get_permalink().'" class="hover-thumbnail">';
		if(furnob_product_second_image()){
		$output .= '<span class="second-thumbnail" style="background-image: url('.furnob_product_second_image().');"></span>';
		}
		$output .= '<img src="'.furnob_product_image().'" alt="'.the_title_attribute( 'echo=0' ).'">';
		$output .= '</a>';

		ob_start();
		woocommerce_template_loop_add_to_cart();
		$output .= ob_get_clean();
		
		$output .= '</div><!-- thumbnail-wrapper -->';
		$output .= '<div class="content-wrapper">';
		$output .= '<h3 class="product-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
		$output .= '<span class="price">';
		$output .= $price;
		$output .= '</span><!-- price -->';
                      
		if($ratingcount){
		$output .= '<div class="product-rating">';
		$output .= $rating;
		$output .= '<div class="count-rating">'.esc_html($product->get_average_rating()).' <span class="rating-text">'.esc_html('Rating', 'furnob').'</span></div>';
		$output .= '</div><!-- product-rating -->';
		}

		$output .= furnob_vendor_name();
                  
		if($managestock && $stock_quantity > 0) {
			$output .= '<div class="product-sold">';
			$output .= '<div class="product-progress"><span style="width: '.esc_attr($progress_percentage).'%;"></span></div>';
			$output .= '<div class="sold-detail">';
			$output .= '<span class="sold">'.esc_html__('Sold:','furnob').' '.esc_html($total_sales).' /</span>';
			$output .= '<span class="total">'.esc_html($total_stock).'</span>';
			$output .= '</div><!-- sold-detail -->';
			$output .= '</div><!-- product-sold -->';
		}
		if(furnob_shipping_class_name()){
		$output .= '<div class="product-info success">'.furnob_shipping_class_name().'</div>';
		}
		$output .= '</div><!-- content-wrapper -->';
		$output .= '</div><!-- product-content -->';


	}
	
	return $output;
}

/*----------------------------
  Add my owns Product Box
 ----------------------------*/
function furnob_shop_box () {
	if(get_theme_mod('furnob_product_box_type') == 'type3'){
		echo furnob_product_type3();
	} elseif (get_theme_mod('furnob_product_box_type') == 'type2'){
		echo furnob_product_type2();
	} else {
		echo furnob_product_type1();
	}
}

/*************************************************
## Woo Cart Ajax
*************************************************/ 

add_filter('woocommerce_add_to_cart_fragments', 'furnob_header_add_to_cart_fragment');
function furnob_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	?>
	
	<span class="cart-count count"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'furnob'), $woocommerce->cart->cart_contents_count);?></span>
	

	<?php
	$fragments['span.cart-count'] = ob_get_clean();

	return $fragments;
}

add_filter( 'woocommerce_add_to_cart_fragments', function($fragments) {

    ob_start();
    ?>

    <div class="fl-mini-cart-content">
        <?php woocommerce_mini_cart(); ?>
    </div>

    <?php $fragments['div.fl-mini-cart-content'] = ob_get_clean();

    return $fragments;

} );


/*************************************************
## Furnob Woo Search Form
*************************************************/ 

add_filter( 'get_product_search_form' , 'furnob_custom_product_searchform' );

function furnob_custom_product_searchform( $form ) {

	$form = '<form class="product-search-form" action="' . esc_url( home_url( '/'  ) ) . '" role="search" method="get" id="searchform">
				<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr__('Search','furnob').'">
				<button type="submit"><i class="klb-right"></i></button>
                <input type="hidden" name="post_type" value="product" />
			</form>';

	return $form;
}

function furnob_header_product_search() {
	$terms = get_terms( array(
		'taxonomy' => 'product_cat',
		'hide_empty' => true,
		'parent'    => 0,
	) );

	$form = '';
	
	if(get_theme_mod('furnob_ajax_search_form',0) == 1 && class_exists( 'DGWT_WC_Ajax_Search' )){
		$form .= do_shortcode('[wcas-search-form]');
	} else {
		$form .= '<form action="' . esc_url( home_url( '/'  ) ) . '" class="search-form search-item" role="search" method="get">';
		$form .= '<input type="search" value="' . get_search_query() . '" name="s" class="form-control line" autocomplete="off" placeholder="'.esc_attr__('Search your favorite product...','furnob').'">';
		$form .= '<button type="submit" class="btn"><i class="klbth-icon-search"></i></button>';
		$form .= '<input type="hidden" name="post_type" value="product" />';
		$form .= '</form><!-- search-form -->';
	}

	return $form;
}

/*************************************************
## Furnob Gallery Thumbnail Size
*************************************************/ 
add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
    return array(
        'width' => 90,
        'height' => 54,
        'crop' => 0,
    );
} );


/*************************************************
## Quick View Scripts
*************************************************/ 

function furnob_quick_view_scripts() {
  	wp_enqueue_script( 'furnob-quick-ajax', get_template_directory_uri() . '/assets/js/custom/quick_ajax.js', array('jquery'), '1.0.0', true );
	wp_localize_script( 'furnob-quick-ajax', 'MyAjax', array(
		'ajaxurl' => esc_url(admin_url( 'admin-ajax.php' )),
	));
  	wp_enqueue_script( 'furnob-variationform', get_template_directory_uri() . '/assets/js/custom/variationform.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'wc-add-to-cart-variation' );
}
add_action( 'wp_enqueue_scripts', 'furnob_quick_view_scripts' );

/*************************************************
## Quick View CallBack
*************************************************/ 

add_action( 'wp_ajax_nopriv_quick_view', 'furnob_quick_view_callback' );
add_action( 'wp_ajax_quick_view', 'furnob_quick_view_callback' );
function furnob_quick_view_callback() {

	$id = intval( $_POST['id'] );
	$loop = new WP_Query( array(
		'post_type' => 'product',
		'p' => $id,
	  )
	);
	
	while ( $loop->have_posts() ) : $loop->the_post(); 
	$product = new WC_Product(get_the_ID());
	
	$rating = wc_get_rating_html($product->get_average_rating());
	$price = $product->get_price_html();
	$rating_count = $product->get_rating_count();
	$review_count = $product->get_review_count();
	$average      = $product->get_average_rating();
	$product_image_ids = $product->get_gallery_attachment_ids();

	$output = '';
	
		$output .= '<div class="quickview-product single-product-wrapper product white-popup">';
		$output .= '<div class="quick-product-wrapper">';
		$output .= '<button title="'.esc_attr__('Close (Esc)', 'furnob').'" type="button" class="mfp-close">×</button>';
		
		$output .= '<article class="product single-product">';
		$output .= '<div class="row">';
		$output .= '<div class="col col-12 col-md-6">';
		$output .= '<div class="single-thumbnails">';
		
		if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {
			$att=get_post_thumbnail_id();
			$image_src = wp_get_attachment_image_src( $att, 'full' );
			$image_src = $image_src[0];
			
			$output .= '<div id="product-gallery" class="site-slider owl-carousel" data-desktop="1" data-tablet="1" data-mobile="1" data-speed="600" data-loop="false" data-gutter="0" data-dots="true" data-nav="true" data-autoplay="false" data-autospeed="1000" data-autostop="true" data-dotsdata="true">';
			$output .= '<div class="gallery-item" data-dot="<button><img src='.esc_url($image_src).'></button>"><a href="'.esc_url($image_src).'"><img src="'.esc_url($image_src).'"></a></div>';
			
			foreach( $product_image_ids as $product_image_id ){
				$image_url = wp_get_attachment_url( $product_image_id );
				$output .= '<div class="gallery-item" data-dot="<button><img src='.esc_url($image_url).'></button>"><a href="'.esc_url($image_url).'"><img src="'.esc_url($image_url).'"></a></div>';
			}
			$output .= '</div><!-- product-gallery -->';
		}
		
		$output .= '</div><!-- single-thumbnails -->';
		$output .= '</div><!-- col -->';
		$output .= '<div class="col col-12 col-md-6">';
		$output .= '<div class="single-details">';
		
		ob_start();
		do_action( 'woocommerce_single_product_summary' );
		$output .= ob_get_clean();
		
		$output .= '</div><!-- single-details -->';
		$output .= '</div><!-- col -->';
		$output .= '</div><!-- row -->';
		$output .= '</article><!-- single-product -->';

		$output .= '</div><!-- quick-product-wrapper -->';

		$sizechart = get_post_meta( get_the_ID(), 'klb_product_size_chart', true );

		if($sizechart ){
						
			$output  .= '<div class="size-holder">';
			$output .= '<div class="size-holder-wrapper">';
			$output .= '<div class="size-holder-header">';
			$output .= '<div class="size-holder-close"><i class="klbth-icon-x"></i></div>';
			$output .= '</div><!-- size-holder-header -->';
			$output .= '<div class="size-holder-body">';
			$output .= $sizechart;
			$output .= '</div><!-- size-holder-body -->';
			$output .= '</div><!-- size-holder-wrapper -->';
			$output .= '</div><!-- size-holder -->';
			  
		}

		$output .= '</div><!-- quickview-product -->';

		endwhile; 
		wp_reset_postdata();

	 	$output_escaped = $output;
	 	echo $output_escaped;
		
		wp_die();

}


/*************************************************
## Furnob Filter by Attribute
*************************************************/ 
function furnob_woocommerce_layered_nav_term_html( $term_html, $term, $link, $count ) { 

	$attribute_label_name = wc_attribute_label($term->taxonomy);;
	$attribute_id = wc_attribute_taxonomy_id_by_name($attribute_label_name);
	$attr  = wc_get_attribute($attribute_id);
	$array = json_decode(json_encode($attr), true);

	$type = isset($array['type']) ? $array['type'] : '';

	if($array['type'] == 'color'){
		$color = get_term_meta( $term->term_id, 'product_attribute_color', true );
		$term_html = '<div class="type-color"><span class="color-box" style="background-color:'.esc_attr($color).';"></span>'.$term_html.'</div>';
	}
	
	if($array['type'] == 'button'){
		$term_html = '<div class="type-button"><span class="button-box"></span>'.$term_html.'</div>';
	}

    return $term_html; 
}; 
         
add_filter( 'woocommerce_layered_nav_term_html', 'furnob_woocommerce_layered_nav_term_html', 10, 4 ); 


/*************************************************
## Shop Width Body Classes
*************************************************/

function furnob_body_classes( $classes ) {

	if( get_theme_mod('furnob_shop_width') == 'wide' || furnob_get_option() == 'wide' && is_shop()) { 
		$classes[] = 'shop-wide';
	} else {
		$classes[] = '';
	}
	
	return $classes;
}
add_filter( 'body_class', 'furnob_body_classes' );

/*************************************************
## Stock Availability Translation
*************************************************/ 

if(get_theme_mod('furnob_stock_quantity',0) != 1){
add_filter( 'woocommerce_get_availability', 'furnob_custom_get_availability', 1, 2);
function furnob_custom_get_availability( $availability, $_product ) {
    
    // Change In Stock Text
    if ( $_product->is_in_stock() ) {
        $availability['availability'] = esc_html__('In Stock', 'furnob');
    }
    // Change Out of Stock Text
    if ( ! $_product->is_in_stock() ) {
        $availability['availability'] = esc_html__('Out of stock', 'furnob');
    }
    return $availability;
}
}

/*************************************************
## Catalog Mode - Disable Add to cart Button
*************************************************/
if(get_theme_mod('furnob_catalog_mode', 0) == 1){ 
	add_filter( 'woocommerce_loop_add_to_cart_link', 'furnob_remove_add_to_cart_buttons', 1 );
	function furnob_remove_add_to_cart_buttons() {
		return false;
	}
}

/*************************************************
## Single Gallery Options
*************************************************/ 

add_filter( 'woocommerce_single_product_carousel_options', 'furnob_single_gallery_options' );
function furnob_single_gallery_options( $options ) {

    $options['directionNav'] = true;

    return $options;
}

/*************************************************
## Size Chart Modal
*************************************************/ 
function furnob_size_chart_modal(){
	$sizechart = get_post_meta( get_the_ID(), 'klb_product_size_chart', true );
	
	if($sizechart && is_product()){
		
		wp_enqueue_script( 'furnob-sizemodal');
		
		$chart  = '<div class="size-holder">';
		$chart .= '<div class="size-holder-wrapper">';
		$chart .= '<div class="size-holder-header">';
		$chart .= '<div class="size-holder-close"><i class="klbth-icon-x"></i></div>';
		$chart .= '</div><!-- size-holder-header -->';
		$chart .= '<div class="size-holder-body">';
		$chart .= $sizechart;
		$chart .= '</div><!-- size-holder-body -->';
		$chart .= '</div><!-- size-holder-wrapper -->';
		$chart .= '</div><!-- size-holder -->';
		  
		echo furnob_sanitize_data($chart);
	}
}
add_action('wp_footer','furnob_size_chart_modal');

/*************************************************
## Related Products with Tags
*************************************************/
if(get_theme_mod('furnob_related_by_tags',0) == 1){
	add_filter( 'woocommerce_product_related_posts_relate_by_category', '__return_false' );
}

/*************************************************
## Woo Smart Compare Disable
*************************************************/ 
add_filter( 'woosc_button_position_archive', '__return_false' );
add_filter( 'woosc_button_position_single', '__return_false' );

} // is woocommerce activated

?>