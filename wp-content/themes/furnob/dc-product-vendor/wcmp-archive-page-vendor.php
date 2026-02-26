<?php
defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: wcmp_before_main_content.
 *
 */

do_action( 'wcmp_before_main_content' );

global $WCMp;

?>

<div class="empty-klb"></div>
		
<div class="shop-content vendor-store">
	<div class="container">

		<div class="row content-wrapper sidebar-left">
			<div class="col col-12 col-lg-9 content-primary">
	
				<header class="woocommerce-products-header">
					<?php if ( apply_filters( 'wcmp_show_page_title', true ) ) : ?>
						<div class="woocommerce-products-header__title page-title"><?php is_tax($WCMp->taxonomy->taxonomy_name) ? woocommerce_page_title() : print(get_user_meta( wcmp_find_shop_page_vendor(), '_vendor_page_title', true )); ?></div>
					<?php endif; ?>

					<?php
					/**
					 * Hook: wcmp_archive_description.
					 *
					 */
					do_action( 'wcmp_archive_description' );
					?>
				</header>
				<?php

				/**
				 * Hook: wcmp_store_tab_contents.
				 *
				 * Output wcmp store widget
				 */

				do_action( 'wcmp_store_tab_widget_contents' );
				
				?>
			</div>

			<div id="sidebar" class="col col-12 col-lg-3 content-secondary site-sidebar filtered-sidebar sticky">
				<div class="site-scroll">
					<div class="sidebar-inner">
					
						<div class="sidebar-mobile-header">
							<h3 class="entry-title"><?php esc_html_e('Filter Products','furnob'); ?></h3>

							<div class="close-sidebar">
								<i class="klbth-icon-cancel"></i>
							</div>
						</div>
						
						<?php if ( is_active_sidebar( 'shop-sidebar' ) ) { ?>
							<?php dynamic_sidebar( 'shop-sidebar' ); ?>
						<?php } ?>
						
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>


<?php

	/**
	 * Hook: wcmp_after_main_content.
	 *
	 */
	do_action( 'wcmp_after_main_content' );

/**
 * Hook: wcmp_sidebar.
 *
 */
// deprecated since version 3.0.0 with no alternative available
// do_action( 'wcmp_sidebar' );

get_footer( 'shop' );