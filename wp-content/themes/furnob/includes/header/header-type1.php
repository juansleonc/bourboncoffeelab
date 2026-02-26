<header id="masthead" class="site-header header-type1">

	<?php if(get_theme_mod('furnob_secondary_menu','0') == 1 || get_theme_mod('furnob_top_notification1_toggle','0') == 1){ ?>
		<div class="header-top header-row border-full hide-mobile">
			<div class="container">
				<div class="header-wrapper">
					<div class="row align-items-center">
						<div class="col col-sm-12 col-lg-6 column left">
							<?php furnob_top_notification1(); ?>
						</div><!-- col -->
						<div class="col col-sm-12 col-lg-6 column right">
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
						</div><!-- col -->
					</div><!-- row -->
				</div><!-- header-wrapper -->
			</div><!-- container -->
		</div><!-- header-top -->
	<?php } ?>

    <div class="header-main header-row border-container height small hide-mobile">
		<div class="container">
			<div class="header-wrapper">
				<div class="row align-items-center">
					<div class="col column left align-center col-md-auto">
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
					<div class="col column right align-center">
						<?php furnob_search_icon(); ?>

						<?php furnob_wishlist_icon(); ?>

						<?php furnob_cart_icon(); ?>
					</div><!-- col -->
				</div><!-- row -->
			</div><!-- header-wrapper -->
		</div><!-- container -->
	</div><!-- header-main -->

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
