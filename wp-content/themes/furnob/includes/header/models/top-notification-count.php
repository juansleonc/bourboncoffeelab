<?php
if ( ! function_exists( 'furnob_top_notification_count' ) ) {
	function furnob_top_notification_count(){
		$topnotification = get_theme_mod('furnob_top_notification_count_toggle','0'); 
		if($topnotification == '1'){ ?>
	
			<div class="header-notification with-count second-color">
				<p><?php echo esc_html(get_theme_mod('furnob_top_notification_count_text')); ?></p>
				<div class="countdown" data-date="<?php echo esc_attr(get_theme_mod('furnob_top_notification_count_date')); ?>" data-text="<?php esc_attr_e('Expired', 'furnob'); ?>">
					<div class="count-item">
						<div class="days"><?php esc_html_e('00', 'furnob'); ?></div>
						<div class="count-label"><?php esc_html_e('d', 'furnob'); ?></div>
					</div><!-- count-item -->
					<span>:</span>
					<div class="count-item">
						<div class="hours"><?php esc_html_e('00', 'furnob'); ?></div>
						<div class="count-label"><?php esc_html_e('h', 'furnob'); ?></div>
					</div><!-- count-item -->
					<span>:</span>
					<div class="count-item">
						<div class="minutes"><?php esc_html_e('00', 'furnob'); ?></div>
						<div class="count-label"><?php esc_html_e('m', 'furnob'); ?></div>
					</div><!-- count-item -->
					<span>:</span>
					<div class="count-item">
						<div class="second"><?php esc_html_e('00', 'furnob'); ?></div>
						<div class="count-label"><?php esc_html_e('s', 'furnob'); ?></div>
					</div><!-- count-item -->
				</div><!-- countdown -->
			</div><!-- header-notification -->

		<?php  }
	}
}