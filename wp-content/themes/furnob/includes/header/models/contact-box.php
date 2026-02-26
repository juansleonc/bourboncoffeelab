<?php
if ( ! function_exists( 'furnob_contact_box' ) ) {
	function furnob_contact_box(){
		$contactbox = get_theme_mod('furnob_header_contact_box_toggle','0'); 
		if($contactbox == '1'){ 
		$phoneurl = str_replace(' ', '', get_theme_mod('furnob_header_contact_box_phone')); ?>
					
			<div class="site-phone-contact">
				<div class="contact-icon"><i class="<?php echo esc_attr(get_theme_mod('furnob_header_contact_box_icon')); ?>"></i></div>
				<div class="contact-detail">
					<p><a href="tel:<?php echo esc_html($phoneurl); ?>"><?php echo esc_html(get_theme_mod('furnob_header_contact_box_phone')); ?></a></p>
					<span><?php echo esc_html(get_theme_mod('furnob_header_contact_box_subtitle')); ?></span>
				</div><!-- contact-detail -->
			</div><!-- site-phone-contact -->
	  
		<?php  }
	}
}