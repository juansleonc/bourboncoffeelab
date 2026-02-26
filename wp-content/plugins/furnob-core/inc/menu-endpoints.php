<?php 

/*************************************************
## Furnob Nav Menu Endpoints
*************************************************/ 

function furnob_add_nav_menu_meta_boxes() {
	add_meta_box( 'furnob_endpoints_nav_link', esc_html__( 'Furnob endpoints', 'furnob-core' ), 'furnob_nav_menu_links' , 'nav-menus', 'side', 'low' );
}
add_action( 'admin_head-nav-menus.php', 'furnob_add_nav_menu_meta_boxes');

function furnob_nav_menu_links() {
	?>
	<div id="posttype-furnob-endpoints" class="posttypediv">
		<div id="tabs-panel-furnob-endpoints" class="tabs-panel tabs-panel-active">
			<ul id="furnob-endpoints-checklist" class="categorychecklist form-no-clear">

				<!-- Location -->
				<?php if(get_theme_mod('furnob_location_filter',0) == 1){ ?>
				<li>
					<label class="menu-item-title">
						<input type="checkbox" class="menu-item-checkbox" name="menu-item[-1][menu-item-object-id]" value="0" /> <?php esc_html_e('Choose Location', 'furnob-core'); ?>
					</label>
					<input type="hidden" class="menu-item-type" name="menu-item[-1][menu-item-type]" value="custom" />
					<input type="hidden" class="menu-item-title" name="menu-item[-1][menu-item-title]" value="Choose Location" />
					<input type="hidden" class="menu-item-url" name="menu-item[-1][menu-item-url]" value="#" />
					<input type="hidden" class="menu-item-classes" name="menu-item[-1][menu-item-classes]" value="select-location" />
				</li>
				<?php } ?>
				
				<!-- My Account -->
				<?php if ( class_exists( 'woocommerce' ) ) { ?>
				<li>
					<label class="menu-item-title">
						<input type="checkbox" class="menu-item-checkbox" name="menu-item[-2][menu-item-object-id]" value="0" /> <?php esc_html_e('My Account', 'furnob-core'); ?>
					</label>
					<input type="hidden" class="menu-item-type" name="menu-item[-2][menu-item-type]" value="custom" />
					<input type="hidden" class="menu-item-title" name="menu-item[-2][menu-item-title]" value="My Account" />
					<input type="hidden" class="menu-item-url" name="menu-item[-2][menu-item-url]" value="#" />
					<input type="hidden" class="menu-item-classes" name="menu-item[-2][menu-item-classes]" value="klb-myaccount" />
				</li>
				<?php } ?>

			</ul>
		</div>
		<p class="button-controls">
			<span class="list-controls">
				<a href="<?php echo esc_url( admin_url( 'nav-menus.php?page-tab=all&selectall=1#posttype-furnob-endpoints' ) ); ?>" class="select-all"><?php esc_html_e( 'Select all', 'woocommerce' ); ?></a>
			</span>
			<span class="add-to-menu">
				<button type="submit" class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to menu', 'furnob-core' ); ?>" name="add-post-type-menu-item" id="submit-posttype-furnob-endpoints"><?php esc_html_e( 'Add to menu', 'woocommerce' ); ?></button>
				<span class="spinner"></span>
			</span>
		</p>
	</div>
	<?php
}

/*************************************************
## Furnob Nav Menu Endpoints Output
*************************************************/ 
function furnob_nav_menu_links_output( $itemOutput, $item ) {
	
	if (! empty( $itemOutput )&& is_string( $itemOutput )&& strpos( $item->classes[0], 'klb-location' ) !== false) {
		if(get_theme_mod('furnob_location_filter',0) == 1){
			if( furnob_location() != 'all'){
				$term = get_term_by('slug', furnob_location(), 'location');
				
				$itemOutput = '<a href="#" class="select-location"><i class="klbth-icon-pin-alt"></i> '.esc_html($term->name).'</a>';
			} else {
				$itemOutput = '<a href="#" class="select-location"><i class="klbth-icon-pin-alt"></i> '.esc_html($item->title).'</a>';
			}
		}
	}
	
	if (! empty( $itemOutput )&& is_string( $itemOutput )&& strpos( $item->classes[0], 'klb-myaccount' ) !== false) {
		if ( class_exists( 'woocommerce' ) ) {
			if(is_user_logged_in()){
				$current_user = wp_get_current_user();
				$itemOutput = '<a href="'.wc_get_page_permalink( 'myaccount' ).'"><i class="klbth-icon-profile-circled"></i> '.esc_html($current_user->user_login).'</a>';
			} else {
				$itemOutput = '<a href="'.wc_get_page_permalink( 'myaccount' ).'"><i class="klbth-icon-profile-circled"></i> '.esc_html($item->title).'</a>';
			}
		}
	}

	return $itemOutput;
}
	
if ( !is_admin() ) {
	add_filter( 'walker_nav_menu_start_el','furnob_nav_menu_links_output' , 50, 2 );
	add_filter( 'megamenu_walker_nav_menu_start_el', 'furnob_nav_menu_links_output', 50, 2 );
}