<header id="masthead" class="site-header header-type2">

	<?php furnob_top_notification_count(); ?>

	<div class="header-main header-row border-full height small hide-mobile">
		<div class="container">
			<div class="header-wrapper">
				<div class="row align-items-center">
					<div class="col column left align-center">
						<div class="site-brand">
							<a href="<?php echo esc_url( home_url( "/" ) ); ?>" title="<?php bloginfo("name"); ?>">
								<?php if (get_theme_mod( 'furnob_logo' )) { ?>
									<img src="<?php echo esc_url( wp_get_attachment_url(get_theme_mod( 'furnob_logo' )) ); ?>" class="dark" alt="<?php bloginfo("name"); ?>">
								<?php } elseif (get_theme_mod( 'furnob_logo_text' )) { ?>
									<span class="brand-text"><?php echo esc_html(get_theme_mod( 'furnob_logo_text' )); ?></span>
								<?php } else { ?>
									<img src="<?php echo get_template_directory_uri(); ?>/assets/images/furnob-logo-dark.png" alt="<?php bloginfo("name"); ?>">
								<?php } ?>
							</a>
						</div><!-- site-brand -->

						<div class="header-top-block">
							<?php if(get_theme_mod('furnob_secondary_menu','0') == 1){ ?>
								<nav class="site-nav horizontal">
									<?php 
										wp_nav_menu(array(
										'theme_location' => 'secondary-menu',
										'container' => '',
										'fallback_cb' => 'show_top_menu',
										'menu_id' => '',
										'menu_class' => 'menu',
										'echo' => true,
										"walker" => '',
										'depth' => 0 
										));
									?>
								</nav><!-- site-nav -->
							<?php } ?>
						</div><!-- header-top-block -->
					</div><!-- col -->
					<div class="col column right align-center col-md-auto">

						<?php furnob_contact_box(); ?>

						<?php furnob_search_icon(); ?>

						<?php furnob_wishlist_icon(); ?>

						<?php furnob_cart_icon(); ?>

					</div><!-- col -->
				</div><!-- row -->
			</div><!-- header-wrapper -->
		</div><!-- container -->
	</div><!-- header-main -->

	<div class="header-nav header-row border-container hide-mobile">
		<div class="container">
			<div class="header-wrapper">
				<div class="row align-items-center">
					<div class="col column left align-center">
						<?php furnob_sidebar_menu(); ?>
					</div><!-- col -->
					<div class="col column right align-center col-md-auto">
						<nav class="site-nav horizontal large">
							<?php 
								wp_nav_menu(array(
								'theme_location' => 'main-menu',
								'container' => '',
								'fallback_cb' => 'show_top_menu',
								'menu_id' => '',
								'menu_class' => 'menu',
								'echo' => true,
								"walker" => '',
								'depth' => 0 
								));
							?>
						</nav><!-- site-nav -->
					</div><!-- col -->
				</div><!-- row -->
			</div><!-- header-wrapper -->
		</div><!-- container -->
	</div><!-- header-nav -->

	<div class="header-mobile hide-desktop">
		<div class="container">
			<div class="row align-items-center">
				<div class="col column left align-center col-md-auto">
					<div class="header-button">
						<a href="#" class="toggle-menu">
							<i class="klbth-icon-menu"></i>
						</a>
					</div><!-- header-button -->
					<div class="site-brand">
						<a href="<?php echo esc_url( home_url( "/" ) ); ?>" title="<?php bloginfo("name"); ?>">
							<?php if (get_theme_mod( 'furnob_mobile_logo' )) { ?>
								<img src="<?php echo esc_url( wp_get_attachment_url(get_theme_mod( 'furnob_mobile_logo' )) ); ?>" class="dark mobile-logo" alt="<?php bloginfo("name"); ?>">
							<?php } elseif (get_theme_mod( 'furnob_logo' )) { ?>
								<img src="<?php echo esc_url( wp_get_attachment_url(get_theme_mod( 'furnob_logo' )) ); ?>" class="dark" alt="<?php bloginfo("name"); ?>">
							<?php } elseif (get_theme_mod( 'furnob_logo_text' )) { ?>
								<span class="brand-text"><?php echo esc_html(get_theme_mod( 'furnob_logo_text' )); ?></span>
							<?php } else { ?>
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/furnob-logo-dark.png" alt="<?php bloginfo("name"); ?>">
							<?php } ?>
						</a>
					</div><!-- site-brand -->
				</div><!-- col -->
				<div class="col column right align-center">

					<?php furnob_search_icon(); ?>

					<?php furnob_cart_icon(); ?>

				</div><!-- col -->
			</div><!-- row -->
		</div><!-- container -->
	</div><!-- header-mobile -->

</header><!-- site-header -->
