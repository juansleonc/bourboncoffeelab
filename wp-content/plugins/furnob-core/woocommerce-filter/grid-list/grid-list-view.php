<?php 
/*************************************************
* Catalog Ordering
*************************************************/
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 ); 
add_action( 'klb_catalog_ordering', 'woocommerce_catalog_ordering', 30 ); 

add_action( 'woocommerce_before_shop_loop', 'furnob_catalog_ordering_start', 30 );
function furnob_catalog_ordering_start(){
?>

	<div class="before-shop-loop">
		<div class="woocommerce-result-count hide-mobile">
			<?php add_action( 'furnob_result_count', 'woocommerce_result_count', 20 ); ?>
			<?php do_action('furnob_result_count'); ?>
		</div>
		
		<div class="filter-button hide-desktop">
			<a href="#"><i class="klbth-icon-filter"></i> <?php esc_html_e('Filter Products','furnob-core'); ?></a>
		</div><!-- filter-button -->
		
		<div class="filter-wrapper">
			<?php if(get_theme_mod('furnob_grid_list_view','0') == '1'){ ?>
				<div class="product-views-buttons hide-mobile">
					<?php if(furnob_shop_view() == 'list_view') { ?>
						<a href="<?php echo esc_url(add_query_arg('shop_view','grid_view')); ?>" class="grid-view" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_html_e('Grid Products','furnob-core'); ?>"><i class="klbth-icon-view-grid"></i></a>
						<a href="<?php echo esc_url(add_query_arg('shop_view','list_view')); ?>" class="list-view active" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_html_e('List Products','furnob-core'); ?>"><i class="klbth-icon-list"></i></a>
					<?php } else { ?>
						<a href="<?php echo esc_url(add_query_arg('shop_view','grid_view')); ?>" class="grid-view active" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_html_e('Grid Products','furnob-core'); ?>"><i class="klbth-icon-view-grid"></i></a>
						<a href="<?php echo esc_url(add_query_arg('shop_view','list_view')); ?>" class="list-view" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_html_e('List Products','furnob-core'); ?>"><i class="klbth-icon-list"></i></a>
					<?php } ?>
				</div><!-- product-views-buttons -->
			<?php } ?>
			<div class="sorting-products">
				<?php do_action('klb_catalog_ordering'); ?>
			</div><!-- sorting-products -->
		</div><!-- filter-wrapper -->
		
		<?php if( get_theme_mod( 'furnob_shop_layout' ) == 'full-width' || furnob_get_option() == 'full-width') { ?>
              <div class="filter-wide-button dropdown hide-mobile">
                <a href="#" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="klbth-icon-filter"></i>
                 <?php esc_html_e('Filter Products','furnob-core'); ?>
                </a>
                <div class="filter-holder dropdown-menu">
                  <div class="filter-holder-wrapper">
								<?php if ( is_active_sidebar( 'shop-sidebar' ) ) { ?>
									<?php dynamic_sidebar( 'shop-sidebar' ); ?>
								<?php } ?>

                  </div><!-- filter-holder-wrapper -->
                </div><!-- filter-holder -->
              </div><!-- filter-wide-button -->
		<?php } ?>
		<?php echo furnob_remove_klb_filter(); ?>
		<?php wp_enqueue_style( 'klb-remove-filter'); ?>
	</div><!-- before-shop-loop -->
	


<?php

}