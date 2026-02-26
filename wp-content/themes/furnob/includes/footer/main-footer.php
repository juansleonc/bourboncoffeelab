<?php
if ( ! function_exists( 'furnob_main_footer_function' ) ) {
	function furnob_main_footer_function(){
	?>
		<footer class="site-footer">

			<?php $featured_box = get_theme_mod('furnob_footer_featured_box'); ?>
			<?php if($featured_box){ ?>
				<div class="footer-row footer-iconboxes bordered">
					<div class="container">
						<div class="footer-row-inner">
							<div class="row">
								<?php foreach($featured_box as $featured){ ?>
									<div class="col col-12 col-md-4">
										<div class="iconbox">
											<div class="icon"><i class="<?php echo esc_attr($featured['featured_icon']); ?>"></i></div>
											<div class="detail">
												<h4 class="entry-title"><?php echo esc_html($featured['featured_title']); ?></h4>
												<div class="entry-description">
													<p><?php echo esc_html($featured['featured_content']); ?></p>
												</div><!-- entry-description -->
											</div><!-- detail -->
										</div><!-- iconbox -->
									</div><!-- col -->
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			

			<?php $subscribe = get_theme_mod('furnob_footer_subscribe_area',0); ?>
			<?php if($subscribe == 1){ ?>
				<div class="footer-row footer-newsletter custom-color gray">
					<div class="container">
						<div class="footer-row-inner">

							<div class="newsletter-content">
								<h4 class="entry-subtitle"><?php echo furnob_sanitize_data(get_theme_mod('furnob_footer_subscribe_subtitle')); ?></h4>
								<h3 class="entry-title"><?php echo furnob_sanitize_data(get_theme_mod('furnob_footer_subscribe_title')); ?> </h3>
								<div class="entry-description">
									<p><?php echo furnob_sanitize_data(get_theme_mod('furnob_footer_subscribe_desc')); ?></p>
								</div><!-- entry-description -->
							</div><!-- newsletter-content -->
							<div class="newsletter-form">
								<?php echo do_shortcode('[mc4wp_form id="'.get_theme_mod('furnob_footer_subscribe_formid').'"]'); ?>
							</div><!-- newsletter-form -->

						</div><!-- footer-row-inner -->
					</div><!-- container -->
				</div><!-- footer-row -->
			<?php } ?>

			<?php if(get_theme_mod('furnob_footer_extra_left_content') || get_theme_mod('furnob_footer_extra_right_content')){ ?>
				<div class="footer-row footer-extra">
					<div class="container">
						<div class="footer-row-inner">
							<div class="opened-hours">
								<p><?php echo furnob_sanitize_data(get_theme_mod('furnob_footer_extra_left_content')); ?></p>
							</div><!-- opened-hours -->
							<div class="footer-message">
								<img src="<?php echo esc_url( wp_get_attachment_url(get_theme_mod('furnob_footer_extra_image'))); ?>" alt="<?php esc_attr_e('msg', 'furnob'); ?>">
								<p><?php echo furnob_sanitize_data(get_theme_mod('furnob_footer_extra_right_content')); ?></p>
							</div><!-- footer-message -->
						</div><!-- footer-row-inner -->
					</div><!-- container -->
				</div><!-- footer-row -->
			<?php } ?>
			
			
			<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) || is_active_sidebar( 'footer-4' )) { ?>
				<div class="footer-row footer-widgets bordered">
					<div class="container">
						<div class="footer-row-inner">

							<div class="row">


								<?php if(get_theme_mod('furnob_footer_column') == '3columns'){ ?>
									<div class="col col-12 col-lg-4">
										<?php dynamic_sidebar( 'footer-1' ); ?>
									</div><!-- col -->
									<div class="col col-12 col-lg-4">
										<?php dynamic_sidebar( 'footer-2' ); ?>
									</div><!-- col -->
									<div class="col col-12 col-lg-4">
										<?php dynamic_sidebar( 'footer-3' ); ?>
									</div><!-- col -->
								<?php }elseif(get_theme_mod('furnob_footer_column') == '5columns'){ ?>
									<div class="col col-12 col-lg-4">
										<?php dynamic_sidebar( 'footer-1' ); ?>
									</div><!-- col -->
									<div class="col col-12 col-lg-2">
										<?php dynamic_sidebar( 'footer-2' ); ?>
									</div><!-- col -->
									<div class="col col-12 col-lg-2">
										<?php dynamic_sidebar( 'footer-3' ); ?>
									</div><!-- col -->
									<div class="col col-12 col-lg-2">
										<?php dynamic_sidebar( 'footer-4' ); ?>
									</div><!-- col -->
									<div class="col col-12 col-lg-2">
										<?php dynamic_sidebar( 'footer-5' ); ?>
									</div><!-- col -->
								<?php } else { ?>
									<div class="col col-12 col-md-3">
										<div class="widget-column first">
											<?php dynamic_sidebar( 'footer-1' ); ?>
										</div><!-- widget-column -->
									</div><!--  -->
									<div class="col col-12 col-md-9">
										<div class="widget-column second">
											<div class="row">
												<div class="col col-12 col-md-4">
													<?php dynamic_sidebar( 'footer-2' ); ?>
												</div><!--  -->
												<div class="col col-12 col-md-4">
													<?php dynamic_sidebar( 'footer-3' ); ?>
												</div><!--  -->
												<div class="col col-12 col-md-4">
													<?php dynamic_sidebar( 'footer-4' ); ?>
												</div><!--  -->
											</div><!-- row -->
										</div><!-- widget-column -->
									</div><!--  -->
								<?php } ?>

							</div><!-- row -->

						</div><!-- footer-row-inner -->
					</div><!-- container -->
				</div><!-- footer-row -->
			<?php } ?>
			
			<div class="footer-row footer-copyright bordered">
				<div class="container">
					<div class="footer-row-inner">

						<div class="copyright-column">
							<div class="site-brand">
								<a href="<?php echo esc_url( home_url( "/" ) ); ?>" title="<?php bloginfo("name"); ?>">
									<?php if (get_theme_mod( 'furnob_logo' )) { ?>
										<img src="<?php echo esc_url( wp_get_attachment_url(get_theme_mod( 'furnob_logo' )) ); ?>" class="dark" alt="<?php bloginfo("name"); ?>">
									<?php } else { ?>
										<img src="<?php echo get_template_directory_uri(); ?>/assets/images/furnob-logo-dark.png" alt="<?php bloginfo("name"); ?>">
									<?php } ?>
								</a>
							</div><!-- site-brand -->
						</div><!-- copyright-column -->
						<div class="copyright-column">
							<div class="site-copyright">
								<?php if(get_theme_mod( 'furnob_copyright' )){ ?>
									<p><?php echo furnob_sanitize_data(get_theme_mod( 'furnob_copyright' )); ?></p>
								<?php } else { ?>
									<p><?php esc_html_e('Copyright 2022.KlbTheme . All rights reserved','furnob'); ?></p>
								<?php } ?>
							</div>

							<?php $payment_icons = get_theme_mod('furnob_footer_payment_icons'); ?>
							<?php if($payment_icons){ ?>
								<div class="site-cards">
									<ul>
										<?php foreach($payment_icons as $p){ ?>
											<li><a href="<?php echo esc_url($p['payment_icon_url']); ?>"><i class="<?php echo esc_attr($p['payment_icon']); ?>"></i></a></li>
										<?php } ?>
									</ul>
								</div><!-- site-cards -->
							<?php } ?>
						</div><!-- copyright-column -->
						<div class="copyright-column">
							<nav class="site-menu horizontal footer-menu">
								<?php 
								wp_nav_menu(array(
								'theme_location' => 'footer-menu',
								'container' => '',
								'fallback_cb' => 'show_top_menu',
								'menu_id' => '',
								'menu_class' => 'menu',
								'echo' => true,
								"walker" => '',
								'depth' => 0 
								));
								?>
							</nav><!-- footer-menu -->
						</div><!-- copyright-column -->

					</div><!-- footer-row-inner -->
				</div><!-- container -->
			</div><!-- footer-row -->

		</footer><!-- site-footer -->
	<?php }
}

add_action('furnob_main_footer','furnob_main_footer_function', 10);