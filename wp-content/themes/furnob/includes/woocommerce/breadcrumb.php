<div class="klb-shop-banner page-header">
	<div class="container">
		<?php $banner_title = get_theme_mod('furnob_shop_banner_title'); ?>
		<?php if($banner_title){ ?>
			<h1 class="entry-title"><?php echo esc_html($banner_title); ?></h1>
		<?php } else { ?>
			<h1 class="entry-title"><?php echo esc_html_e('Shop','furnob'); ?></h1>
		<?php } ?>
	</div><!-- container -->
</div><!-- page-header -->
