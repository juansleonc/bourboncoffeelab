<?php

/*************************************************
## Scripts
*************************************************/
function furnob_single_ajax_scripts() {
	wp_enqueue_script( 'klb-single-ajax',   plugins_url( 'js/single-ajax.js', __FILE__ ), false, '1.0');
	wp_enqueue_style( 'klb-single-ajax',   plugins_url( 'css/single-ajax.css', __FILE__ ), false, '1.0');
}
add_action( 'wp_enqueue_scripts', 'furnob_single_ajax_scripts' );


/*************************************************
## AJax Handler Function
*************************************************/
if ( !function_exists( 'furnob_ajax_add_to_cart_handler' ) ) {
    /**
    * Add to cart handler.
    */
    function furnob_ajax_add_to_cart_handler() {
        WC_Form_Handler::add_to_cart_action();
        WC_AJAX::get_refreshed_fragments();
    }
    add_action( 'wc_ajax_furnob_add_to_cart', 'furnob_ajax_add_to_cart_handler' );
    add_action( 'wc_ajax_nopriv_furnob_add_to_cart', 'furnob_ajax_add_to_cart_handler' );
    
    // Remove WC Core add to cart handler to prevent double-add
    remove_action( 'wp_loaded', array( 'WC_Form_Handler', 'add_to_cart_action' ), 20 );
    
    /**
    * Add fragments for notices.
    */
    function furnob_ajax_add_to_cart_add_fragments( $fragments ) {
        $all_notices  = WC()->session->get( 'wc_notices', array() );
        $notice_types = apply_filters( 'woocommerce_notice_types', array( 'error', 'success', 'notice' ) );
        
        ob_start();
        foreach ( $notice_types as $notice_type ) {
            if ( wc_notice_count( $notice_type ) > 0 ) {
                wc_get_template( "notices/{$notice_type}.php", array(
                    'notices' => array_filter( $all_notices[ $notice_type ] ),
                ) );
            }
        }
        $fragments['notices_html'] = ob_get_clean();
        
        wc_clear_notices();
        
        return $fragments;
    }
    add_filter( 'woocommerce_add_to_cart_fragments', 'furnob_ajax_add_to_cart_add_fragments' );
    
}