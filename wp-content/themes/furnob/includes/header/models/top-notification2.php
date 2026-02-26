<?php
if ( ! function_exists( 'furnob_top_notification2' ) ) {
	function furnob_top_notification2(){
		$topnotification2 = get_theme_mod('furnob_top_notification2_toggle','0'); 
		if($topnotification2 == '1'){ ?>
	
			<div class="header-notification">
				<p><?php echo furnob_sanitize_data(get_theme_mod('furnob_top_notification2_content')); ?></p>
			</div><!-- header-notification -->

		<?php  }
	}
}