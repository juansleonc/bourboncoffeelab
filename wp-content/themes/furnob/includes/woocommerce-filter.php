<?php
/*************************************************
## Furnob Shop View Grid-List
*************************************************/ 
function furnob_shop_view(){
	$getview  = isset( $_GET['shop_view'] ) ? $_GET['shop_view'] : '';
	if($getview){
		return $getview;
	}
}

/*************************************************
## Get Body Class
*************************************************/ 
function furnob_get_body_class( $class ) {
	if(is_shop() || is_product_category()){
		$bodyclasses = get_body_class();
		
		if(in_array($class,$bodyclasses)){
			return true;
		}
	}
}

/*************************************************
## is pjax request
*************************************************/ 

if( ! function_exists( 'furnob_is_pjax' ) ) {
	function furnob_is_pjax(){
		if(is_shop() || is_product_category()){
			$request_headers = function_exists( 'getallheaders') ? getallheaders() : array();

			return isset( $_REQUEST['_pjax'] ) && ( ( isset( $request_headers['X-Requested-With'] ) && 'xmlhttprequest' === strtolower( $request_headers['X-Requested-With'] ) ) || ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && 'xmlhttprequest' === strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) );
		}
	}
}