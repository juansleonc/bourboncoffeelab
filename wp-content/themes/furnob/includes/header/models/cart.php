<?php
if ( ! function_exists( 'furnob_cart_icon' ) ) {
	function furnob_cart_icon(){
		$headercart = get_theme_mod('furnob_header_cart','0');
		if($headercart == '1'){
			global $woocommerce;
			$carturl = wc_get_cart_url(); 
			?>
			<div class="header-button">
				<a href="<?php echo esc_url($carturl); ?>" class="cart-button">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
					<span class="cart-count count"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'furnob'), $woocommerce->cart->cart_contents_count);?></span>
				</a>
			</div><!-- header-button -->
		<?php }
	}
}

if ( ! function_exists( 'furnob_mini_cart_side' ) ) {
	function furnob_mini_cart_side(){
		$headercart = get_theme_mod('furnob_header_cart','0');
		if($headercart == '1'){
		?>
			<div class="cart-widget-side">
				<div class="site-scroll">
					<div class="cart-side-header">
						<div class="cart-side-title"><?php esc_html_e('Shopping Cart', 'furnob'); ?></div>
						<div class="cart-side-close"><i class="klbth-icon-x"></i></div>
					</div><!-- cart-side-header -->
					<div class="cart-side-body">
						<div class="fl-mini-cart-content">
							<?php woocommerce_mini_cart(); ?>
						</div>
					</div><!-- cart-side-body -->
				</div><!-- site-scroll -->
			</div><!-- cart-widget-side -->
		<?php  }
	}
}
add_action('wp_footer', 'furnob_mini_cart_side');
