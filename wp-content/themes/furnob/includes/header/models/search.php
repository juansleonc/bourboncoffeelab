<?php

if ( ! function_exists( 'furnob_search_icon' ) ) {
	function furnob_search_icon(){
		$headersearch = get_theme_mod('furnob_header_search','0');
		if($headersearch == 1){
		?>

		<div class="header-button">
			<a href="#" class="search-button">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
			</a>
		</div><!-- header-button -->
	  
	<?php  }
	}
}

if ( ! function_exists( 'furnob_search_holder' ) ) {
	function furnob_search_holder(){
		$headersearch = get_theme_mod('furnob_header_search','0');
		if($headersearch == 1){
		
		?>
	
		<div class="search-holder">
			<div class="container">
				<div class="search-holder-close search-item"><i class="klbth-icon-x"></i></div>
				<div class="search-holder-header search-item"><span><?php esc_html_e('What are you looking for in Furnob?', 'furnob'); ?></span></div>
				<?php echo furnob_header_product_search(); ?>
				<div class="search-holder-message search-item"><span><?php esc_html_e('Please type the word you want to search and press "enter"', 'furnob'); ?></span></div>
			</div><!-- container -->
		</div><!-- search-holder -->
	  
		<?php  }
	}
}
add_action('wp_footer', 'furnob_search_holder');
