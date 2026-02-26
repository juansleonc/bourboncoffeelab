<?php

/*************************************************
## Furnob Theme options
*************************************************/

require_once get_template_directory() . '/includes/header/models/canvas-menu.php';
require_once get_template_directory() . '/includes/header/models/top-notification-count.php';
require_once get_template_directory() . '/includes/header/models/top-notification1.php';
require_once get_template_directory() . '/includes/header/models/top-notification2.php';
require_once get_template_directory() . '/includes/header/models/search.php';
require_once get_template_directory() . '/includes/header/models/wishlist-icon.php';
require_once get_template_directory() . '/includes/header/models/cart.php';
require_once get_template_directory() . '/includes/header/models/contact-box.php';
require_once get_template_directory() . '/includes/header/models/sidebar-menu.php';

/*************************************************
## Main Header Function
*************************************************/

add_action('furnob_main_header','furnob_main_header_function',10);

if ( ! function_exists( 'furnob_main_header_function' ) ) {
	function furnob_main_header_function(){

		if(furnob_page_settings('page_header_type') == 'type5') {
			
			get_template_part( 'includes/header/header-type5' );

		}elseif(furnob_page_settings('page_header_type') == 'type4') {
			
			get_template_part( 'includes/header/header-type4' );
		
		}elseif(furnob_page_settings('page_header_type') == 'type3') {
			
			get_template_part( 'includes/header/header-type3' );
			
		}elseif(furnob_page_settings('page_header_type') == 'type2') {
			
			get_template_part( 'includes/header/header-type2' );
			
		} elseif(furnob_page_settings('page_header_type') == 'type1') {
			
			get_template_part( 'includes/header/header-type1' );
		} elseif(get_theme_mod('furnob_header_type') == 'type5'){
			
			get_template_part( 'includes/header/header-type5' );
			
		} elseif(get_theme_mod('furnob_header_type') == 'type4'){
			
			get_template_part( 'includes/header/header-type4' );
			
		} elseif(get_theme_mod('furnob_header_type') == 'type3'){
			
			get_template_part( 'includes/header/header-type3' );
			
		} elseif(get_theme_mod('furnob_header_type') == 'type2'){
			
			get_template_part( 'includes/header/header-type2' );
			
		} else {
			
			get_template_part( 'includes/header/header-type1' );
			
		}
		
	}
}
