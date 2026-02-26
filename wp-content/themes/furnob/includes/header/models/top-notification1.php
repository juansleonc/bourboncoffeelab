<?php
if ( ! function_exists( 'furnob_top_notification1' ) ) {
	function furnob_top_notification1(){
		$topnotification1 = get_theme_mod('furnob_top_notification1_toggle','0'); 
		if($topnotification1 == '1'){ ?>
	
			<div class="header-message">
				<p><?php echo furnob_sanitize_data(get_theme_mod('furnob_top_notification1_content')); ?></p>
			</div><!-- header-message -->

		<?php  }
	}
}