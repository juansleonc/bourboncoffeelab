<?php

/*************************************************
## Scripts
*************************************************/
function furnob_product_data_video_scripts() {
	wp_register_style( 'klb-product-data-video',   plugins_url( 'css/product-data-video.css', __FILE__ ), false, '1.0');
	wp_register_script( 'klb-product-data-video',   plugins_url( 'js/product-data-video.js', __FILE__ ), false, '1.0');

}
add_action( 'wp_enqueue_scripts', 'furnob_product_data_video_scripts' );

add_filter('woocommerce_product_data_tabs', function($tabs) {
	$tabs['klb_video_info'] = [
		'label' => esc_html__('Video', 'txtdomain'),
		'target' => 'klb_video_product_data',
		'class' => ['hide_if_external'],
		'priority' => 60
	];
	return $tabs;
});

add_action('woocommerce_product_data_panels', function() {
	?><div id="klb_video_product_data" class="panel woocommerce_options_panel hidden"><?php
 
	woocommerce_wp_textarea_input([
		'id' => '_klb_single_video_input',
		'label' => esc_html__('Video URL', 'furnob-core'),
		'wrapper_class' => 'show_if_simple',
		'desc_tip'    => true,
		'description' => esc_html__( 'Enter a youtube or a vimeo video url for the single product.', 'furnob-core' ),
	]);
 
	?></div><?php
});

add_action('woocommerce_process_product_meta', function($post_id) {
	$product = wc_get_product($post_id);
	
	$product->update_meta_data('_klb_single_video_input', sanitize_text_field($_POST['_klb_single_video_input']));
 

	$product->save();
});


add_action('woocommerce_product_thumbnails','klb_product_data_video',20);
function klb_product_data_video(){
	$product = wc_get_product(get_the_ID());
	$videourl = $product->get_meta('_klb_single_video_input');	
	
	if($videourl){
		wp_enqueue_style('klb-product-data-video');
		wp_enqueue_script('klb-product-data-video');

		if (strpos($videourl, 'vimeo') !== false) {
			$videoclass = "popup-vimeo";
		} else{
			$videoclass = "popup-youtube";
		}
		
		echo '<div class="klb-single-video"><a class="'.esc_attr($videoclass).'" href="'.esc_url($videourl).'"><span>'.esc_html__('Watch video','furnob-core').'</span></a></div>';

	}

}