<?php
/*************************************************
* Mobile Filter
*************************************************/
add_action('wp_footer', 'furnob_mobile_filter'); 
function furnob_mobile_filter() { 

	$mobilebottommenu = get_theme_mod('furnob_mobile_bottom_menu','0');
	if($mobilebottommenu == '1'){

?>

	<?php $edittoggle = get_theme_mod('furnob_mobile_bottom_menu_edit_toggle','0'); ?>
	<?php if($edittoggle == '1'){ ?>
		<div class="mobile-bottom-menu hide-desktop">
			<div class="mobile-bottom-menu-wrapper">
				<nav class="mobile-menu">
					<ul>
						<?php $editrepeater = get_theme_mod('furnob_mobile_bottom_menu_edit'); ?>
						
						<?php foreach($editrepeater as $e){ ?>
							<?php if($e['mobile_menu_type'] == 'filter'){ ?>
								<?php if(is_shop()){ ?>
									<li>
										<a href="#" class="filter-toggle">
											<i class="klbth-icon-<?php echo esc_attr($e['mobile_menu_icon']); ?>"></i>
											<span><?php echo esc_html($e['mobile_menu_text']); ?></span>
										</a>
									</li>
								<?php } ?>
							<?php } elseif($e['mobile_menu_type'] == 'search'){ ?>
								<li>
									<a href="#" class="search-button">
										<i class="klbth-icon-<?php echo esc_attr($e['mobile_menu_icon']); ?>"></i>
										<span><?php echo esc_html($e['mobile_menu_text']); ?></span>
									</a>
								</li>
							<?php } elseif($e['mobile_menu_type'] == 'category'){ ?>
								<?php if(!is_shop()){ ?>
									<li class="menu-item">
										<a href="#" class="categories">
											<i class="klbth-icon-<?php echo esc_attr($e['mobile_menu_icon']); ?>"></i>
											<span><?php echo esc_html($e['mobile_menu_text']); ?></span>
										</a>
									</li>
								<?php } ?>
							<?php } else { ?>
								<li>
									<a href="<?php echo esc_url($e['mobile_menu_url']); ?>" class="user">
										<i class="klbth-icon-<?php echo esc_attr($e['mobile_menu_icon']); ?>"></i>
										<span><?php echo esc_html($e['mobile_menu_text']); ?></span>
									</a>
								</li>
							<?php } ?>
						<?php } ?>
					</ul>
				</nav><!-- header-mobile-nav -->
			</div><!-- mobile-nav-wrapper -->
		</div><!-- mobile-nav-wrapper -->
	<?php } else { ?>
		<div class="mobile-bottom-menu hide-desktop">
			<nav class="mobile-menu">
				<ul>
					<li>
						<?php if(!is_shop()){ ?>
							<a href="<?php echo wc_get_page_permalink( 'shop' ); ?>" class="store">
								<i class="klbth-icon-shopping-bag"></i>
								<span><?php esc_html_e('Store','furnob-core'); ?></span>
							</a>
						<?php } else { ?>
							<a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="store">
								<i class="klbth-icon-package"></i>
								<span><?php esc_html_e('Home','furnob-core'); ?></span>
							</a>
						<?php } ?>
					</li>

					<?php if(is_shop()){ ?>
						<li>
							<a href="#" class="filter-button">
								<i class="klbth-icon-filter"></i>
								<span><?php esc_html_e('Filter','furnob-core'); ?></span>
							</a>
						</li>
					<?php } ?>

					<li>
						<a href="#" class="search-button">
							<i class="klbth-icon-search"></i>
							<span><?php esc_html_e('Search','furnob-core'); ?></span>
						</a>
					</li>
					
					<?php if ( function_exists( 'tinv_url_wishlist_default' ) ) { ?>
						<li>
							<a href="<?php echo tinv_url_wishlist_default(); ?>" class="wishlist">
								<i class="klbth-icon-heart-empty"></i>
								<span><?php esc_html_e('Wishlist','furnob-core'); ?></span>
							</a>
						</li>
					<?php } ?>
					
					<li>
						<a href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>" class="user">
							<i class="klbth-icon-profile-circled"></i>
							<?php if(is_user_logged_in()){ ?>
								<?php $current_user = wp_get_current_user(); ?>
								<span><?php echo esc_html($current_user->user_login); ?></span>
							<?php } else { ?>
								<span><?php esc_html_e('Account','furnob-core'); ?></span>
							<?php } ?>
						</a>
					</li>

					<?php $sidebarmenu = get_theme_mod('furnob_header_sidebar','0'); ?>
					<?php if($sidebarmenu == '1'){ ?>
						<?php if(!is_shop()){ ?>
							<li class="menu-item">
								<a href="#" class="categories">
									<i class="klbth-icon-menu"></i>
									<span><?php esc_html_e('Categories','furnob-core'); ?></span>
								</a>
							</li>
						<?php } ?>
					<?php } ?>
				</ul>
			</nav><!-- header-mobile-nav -->
		</div><!-- mobile-nav-wrapper -->
	<?php } ?>
	
<?php }

    
}