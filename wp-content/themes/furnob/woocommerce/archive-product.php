<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

// Elementor `archive` location
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {

	if ( ! furnob_is_pjax() ) {
	    get_header( 'shop' );
	}
	?>
	
	<?php $breadcrumb = get_theme_mod('furnob_shop_banner_toggle','0'); ?>
	<?php if($breadcrumb == '1'){ ?>
		<?php if(is_product_category()){ ?>
			<?php get_template_part( 'includes/woocommerce/breadcrumb-category' ); ?>
		<?php } elseif(is_search()){ ?>
			<?php get_template_part( 'includes/woocommerce/breadcrumb-search' ); ?>
		<?php } else { ?>
			<?php get_template_part( 'includes/woocommerce/breadcrumb' ); ?>
		<?php } ?>
	
	<?php } else { ?>
		<div class="empty-klb"></div>
	<?php } ?>
	
		<?php furnob_do_action( 'furnob_before_main_shop'); ?>
	
		<div class="container">
	
			<?php do_action( 'woocommerce_before_main_content' ); ?>
	
			<header class="woocommerce-products-header">
				<?php do_action( 'woocommerce_archive_description' ); ?>
			</header>
	
	
			<?php if( get_theme_mod( 'furnob_shop_layout' ) == 'full-width' || furnob_get_option() == 'full-width') { ?>
					<div class="row content-wrapper">
						<div class="col col-12 col-lg-12 content-primary">
							<?php
							if ( woocommerce_product_loop() ) {
	
								/**
								 * Hook: woocommerce_before_shop_loop.
								 *
								 * @hooked woocommerce_output_all_notices - 10
								 * @hooked woocommerce_result_count - 20
								 * @hooked woocommerce_catalog_ordering - 30
								 */
								do_action( 'woocommerce_before_shop_loop' );
							?>
							
							<?php
								woocommerce_product_loop_start();
	
								if ( wc_get_loop_prop( 'total' ) ) {
									while ( have_posts() ) {
										the_post();
	
										/**
										 * Hook: woocommerce_shop_loop.
										 */
										do_action( 'woocommerce_shop_loop' );
	
										wc_get_template_part( 'content', 'product' );
									}
								}
	
								woocommerce_product_loop_end();
								
								do_action( 'woocommerce_after_shop_loop' );
							} else {
								do_action( 'woocommerce_no_products_found' );
							}
							?>
						</div>
						<div class="col col-12 col-lg-3 content-secondary site-sidebar filtered-sidebar sticky hide-desktop">
							<div class="site-scroll">
								<div class="sidebar-inner">
	
									<div class="sidebar-mobile-header">
										<h3 class="entry-title"><?php esc_html_e('Filter Products','furnob'); ?></h3>
	
										<div class="close-sidebar">
											<i class="klbth-icon-x"></i>
										</div><!-- close-sidebar -->
									</div><!-- sidebar-mobile-header -->
									
									<?php if ( is_active_sidebar( 'shop-sidebar' ) ) { ?>
										<?php dynamic_sidebar( 'shop-sidebar' ); ?>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
			<?php } elseif( get_theme_mod( 'furnob_shop_layout' ) == 'right-sidebar' || furnob_get_option() == 'right-sidebar') { ?>
					<div class="row content-wrapper sidebar-right">
						<div class="col col-12 col-lg-9 content-primary">
							<?php
							if ( woocommerce_product_loop() ) {
	
								/**
								 * Hook: woocommerce_before_shop_loop.
								 *
								 * @hooked woocommerce_output_all_notices - 10
								 * @hooked woocommerce_result_count - 20
								 * @hooked woocommerce_catalog_ordering - 30
								 */
								do_action( 'woocommerce_before_shop_loop' );
							?>
							
							<?php
								woocommerce_product_loop_start();
	
								if ( wc_get_loop_prop( 'total' ) ) {
									while ( have_posts() ) {
										the_post();
	
										/**
										 * Hook: woocommerce_shop_loop.
										 */
										do_action( 'woocommerce_shop_loop' );
	
										wc_get_template_part( 'content', 'product' );
									}
								}
	
								woocommerce_product_loop_end();
								
								do_action( 'woocommerce_after_shop_loop' );
							} else {
								do_action( 'woocommerce_no_products_found' );
							}
							?>
						</div>
						<div class="col col-12 col-lg-3 content-secondary site-sidebar filtered-sidebar sticky">
							<div class="site-scroll">
								<div class="sidebar-inner">
	
									<div class="sidebar-mobile-header">
										<h3 class="entry-title"><?php esc_html_e('Filter Products','furnob'); ?></h3>
	
										<div class="close-sidebar">
											<i class="klbth-icon-x"></i>
										</div><!-- close-sidebar -->
									</div><!-- sidebar-mobile-header -->
									
									<?php if ( is_active_sidebar( 'shop-sidebar' ) ) { ?>
										<?php dynamic_sidebar( 'shop-sidebar' ); ?>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
			<?php } else { ?>
				<?php if ( is_active_sidebar( 'shop-sidebar' ) ) { ?>
					<div class="row content-wrapper sidebar-left">
						<div class="col col-12 col-lg-9 content-primary">
							<?php
							if ( woocommerce_product_loop() ) {
	
								/**
								 * Hook: woocommerce_before_shop_loop.
								 *
								 * @hooked woocommerce_output_all_notices - 10
								 * @hooked woocommerce_result_count - 20
								 * @hooked woocommerce_catalog_ordering - 30
								 */
								do_action( 'woocommerce_before_shop_loop' );
							?>
							
							<?php
								woocommerce_product_loop_start();
	
								if ( wc_get_loop_prop( 'total' ) ) {
									while ( have_posts() ) {
										the_post();
	
										/**
										 * Hook: woocommerce_shop_loop.
										 */
										do_action( 'woocommerce_shop_loop' );
	
										wc_get_template_part( 'content', 'product' );
									}
								}
	
								woocommerce_product_loop_end();
								
								do_action( 'woocommerce_after_shop_loop' );
							} else {
								do_action( 'woocommerce_no_products_found' );
							}
							?>
						</div>
						<div class="col col-12 col-lg-3 content-secondary site-sidebar filtered-sidebar sticky">
							<div class="site-scroll">
								<div class="sidebar-inner">
	
									<div class="sidebar-mobile-header">
										<h3 class="entry-title"><?php esc_html_e('Filter Products','furnob'); ?></h3>
	
										<div class="close-sidebar">
											<i class="klbth-icon-x"></i>
										</div><!-- close-sidebar -->
									</div><!-- sidebar-mobile-header -->
									
									<?php if ( is_active_sidebar( 'shop-sidebar' ) ) { ?>
										<?php dynamic_sidebar( 'shop-sidebar' ); ?>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				<?php } else { ?>
					<div class="row content-wrapper">
						<div class="col col-12 col-lg-12 content-primary">
							<?php
							if ( woocommerce_product_loop() ) {
	
								/**
								 * Hook: woocommerce_before_shop_loop.
								 *
								 * @hooked woocommerce_output_all_notices - 10
								 * @hooked woocommerce_result_count - 20
								 * @hooked woocommerce_catalog_ordering - 30
								 */
								do_action( 'woocommerce_before_shop_loop' );
							?>
							
							<?php
								woocommerce_product_loop_start();
	
								if ( wc_get_loop_prop( 'total' ) ) {
									while ( have_posts() ) {
										the_post();
	
										/**
										 * Hook: woocommerce_shop_loop.
										 */
										do_action( 'woocommerce_shop_loop' );
	
										wc_get_template_part( 'content', 'product' );
									}
								}
	
								woocommerce_product_loop_end();
								
								do_action( 'woocommerce_after_shop_loop' );
							} else {
								do_action( 'woocommerce_no_products_found' );
							}
							?>
						</div>
						<div class="col col-12 col-lg-3 content-secondary site-sidebar filtered-sidebar sticky hide-desktop">
							<div class="site-scroll">
								<div class="sidebar-inner">
	
									<div class="sidebar-mobile-header">
										<h3 class="entry-title"><?php esc_html_e('Filter Products','furnob'); ?></h3>
	
										<div class="close-sidebar">
											<i class="klbth-icon-x"></i>
										</div><!-- close-sidebar -->
									</div><!-- sidebar-mobile-header -->
									
									<?php if ( is_active_sidebar( 'shop-sidebar' ) ) { ?>
										<?php dynamic_sidebar( 'shop-sidebar' ); ?>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			
			<?php } ?>
			<?php do_action( 'woocommerce_after_main_content' ); ?>
			
		</div>
		
		<?php furnob_do_action( 'furnob_after_main_shop'); ?>
	
	<?php
	
		if ( ! furnob_is_pjax() ) {
			get_footer( 'shop' );
		}
}