<?php 
/*************************************************
## Furnob Typography
*************************************************/

function furnob_custom_styling() { ?>

<style type="text/css">

<?php if (get_theme_mod( 'furnob_shop_banner_toggle',0 ) == 1) { ?>
.klb-shop-banner{
	background-image: url(<?php echo esc_url( wp_get_attachment_url(get_theme_mod( 'furnob_shop_banner_image' )) ); ?>);
}
<?php } ?>

<?php $categoryimage = get_theme_mod('furnob_shop_banner_each_category'); ?>
<?php if($categoryimage && array_search(get_queried_object()->term_id, array_column($categoryimage, 'category_id')) !== false){ ?>
	<?php foreach($categoryimage as $c){ ?>
		<?php if($c['category_id'] == get_queried_object()->term_id){ ?>
			.klb-shop-banner{
				background-image: url(<?php echo esc_url(furnob_get_image($c['category_image'])); ?>);
			}
		<?php } ?>
	<?php } ?>
<?php } ?>

<?php if (get_theme_mod( 'furnob_mobile_sticky_header',0 ) == 1) { ?>
@media(max-width:64rem){
	header.sticky-header {
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		background: #fff;
		z-index: 99;
	}	
}
<?php } ?>

<?php if (get_theme_mod( 'furnob_mobile_single_sticky_cart',0 ) == 1) { ?>
@media(max-width:64rem){
	.single .single-product-wrapper .product-type-simple form.cart {
	    position: fixed;
	    bottom: 0;
	    right: 0;
	    z-index: 9999;
	    background: #fff;
	    margin-bottom: 0;
	    padding: 15px;
	    -webkit-box-shadow: 0 -2px 5px rgb(0 0 0 / 7%);
	    box-shadow: 0 -2px 5px rgb(0 0 0 / 7%);
	    justify-content: space-between;
		width: 100%;
		display: flex;
	}

	.single .woocommerce-variation-add-to-cart {
	    display: -webkit-box;
	    display: -ms-flexbox;
	    display: flex;
	    position: fixed;
	    bottom: 0;
	    right: 0;
	    z-index: 9999;
	    background: #fff;
	    margin-bottom: 0;
	    padding: 15px;
	    -webkit-box-shadow: 0 -2px 5px rgb(0 0 0 / 7%);
	    box-shadow: 0 -2px 5px rgb(0 0 0 / 7%);
	    justify-content: space-between;
    	width: 100%;
	}
}
<?php } ?>

<?php if (get_theme_mod( 'furnob_main_color' )) { ?>
:root {
    --color-primary: <?php echo esc_attr(get_theme_mod( 'furnob_main_color' ) ); ?>;
}
<?php } ?>

<?php if (get_theme_mod( 'furnob_second_color' )) { ?>
:root {
    --color-secondary: <?php echo esc_attr(get_theme_mod( 'furnob_second_color' ) ); ?>;
}
<?php } ?>

<?php if (get_theme_mod( 'furnob_success_color' )) { ?>
:root {
	--color-success: <?php echo esc_attr(get_theme_mod( 'furnob_success_color' ) ); ?>;
}
<?php } ?>

<?php if (get_theme_mod( 'furnob_success_dark_color' )) { ?>
:root {
    --color-success-dark: <?php echo esc_attr(get_theme_mod( 'furnob_success_dark_color' ) ); ?>;
}
<?php } ?>

<?php if (get_theme_mod( 'furnob_success_light_color' )) { ?>
:root {
    --color-success-light: <?php echo esc_attr(get_theme_mod( 'furnob_success_light_color' ) ); ?>;
}
<?php } ?>

<?php if (get_theme_mod( 'furnob_danger_color' )) { ?>
:root {
    --color-danger: <?php echo esc_attr(get_theme_mod( 'furnob_danger_color' ) ); ?>;
}
<?php } ?>

<?php if (get_theme_mod( 'furnob_warning_color' )) { ?>
:root {
    --color-warning: <?php echo esc_attr(get_theme_mod( 'furnob_warning_color' ) ); ?>;
}
<?php } ?>

<?php if (get_theme_mod( 'furnob_warning_light_color' )) { ?>
:root {
   --color-warning-light: <?php echo esc_attr(get_theme_mod( 'furnob_warning_light_color' ) ); ?>;
}
<?php } ?>

<?php if (get_theme_mod( 'furnob_light_color' )) { ?>
:root {
   --color-light: <?php echo esc_attr(get_theme_mod( 'furnob_light_color' ) ); ?>;
}
<?php } ?>

.site-header.header-type1 .header-top  {
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_header1_top_bg_color' ) ); ?>;
	border-bottom-color: <?php echo esc_attr(get_theme_mod( 'furnob_header1_top_border_color' ) ); ?>;
}

.header-type1 .header-message p{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header1_top_notification_color' ) ); ?>;
}

.header-type1 .header-message p a{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header1_top_notification_button_color' ) ); ?>;
}

.header-type1 .header-top .site-nav a{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header1_top_font_color' ) ); ?>;
}

.header-type1 .header-top .site-nav a:hover{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header1_top_font_hvrcolor' ) ); ?>;
}

.header-type1 .header-main , .header-type1 .header-mobile {
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_header1_main_bg_color' ) ); ?>;
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header1_main_font_color' ) ); ?>;
}

.site-header.header-type1 .site-nav.large .sub-menu li a{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header1_main_font_color' ) ); ?>;
}

.site-header.header-type1 .header-main .site-nav a:hover , .site-header.header-type1 .site-nav.large .sub-menu li a:hover{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header1_main_font_hvrcolor' ) ); ?>;
}

.site-header.header-type1 .site-nav.large .menu > li.mega-menu > .sub-menu > li.menu-item-has-children > a{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header1_main_submenu_header_font_color' ) ); ?>;
}

.site-header.header-type2 .header-notification{
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_header2_top_bg_color' ) ); ?>;
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header2_top_font_color' ) ); ?>;
}

.header-type2 .header-notification .countdown .count-item{
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_header2_top_date_bg_color' ) ); ?>;
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header2_top_date_font_color' ) ); ?>;
}

.header-type2 .header-main , .header-type2 .header-mobile{
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_header2_main_bg_color' ) ); ?>;
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header2_main_font_color' ) ); ?>;
}

.header-type2 .header-row.border-full{
	border-bottom-color: <?php echo esc_attr(get_theme_mod( 'furnob_header2_main_border_color' ) ); ?>;
}

.header-type2 .header-nav{
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_header2_bottom_bg_color' ) ); ?>;
}

.header-type2 .header-nav , .site-header.header-type2 .site-nav.large .sub-menu li a{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header2_bottom_font_color' ) ); ?>;
}

.header-type2 .site-nav.large .menu > li > a:hover , .site-header.header-type2 .site-nav.large .sub-menu li a:hover{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header2_bottom_font_hvrcolor' ) ); ?>;
}

.site-header.header-type2 .site-nav.large .menu>li.mega-menu>.sub-menu>li.menu-item-has-children>a{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header2_bottom_submenu_header_font_color' ) ); ?>;
}

.site-header.header-type3 .header-top  {
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_header3_top_bg_color' ) ); ?>;
	border-bottom-color: <?php echo esc_attr(get_theme_mod( 'furnob_header3_top_border_color' ) ); ?>;
}

.header-type3 .header-message p{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header3_top_notification_color' ) ); ?>;
}

.header-type3 .header-message p a{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header3_top_notification_button_color' ) ); ?>;
}

.header-type3 .header-top .site-nav a{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header3_top_font_color' ) ); ?>;
}

.header-type3 .header-top .site-nav a:hover{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header3_top_font_hvrcolor' ) ); ?>;
}

.header-type3 .header-notification{
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_header3_notification_bg_color' ) ); ?>;
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header3_notification_font_color' ) ); ?>;
}

.header-type3 .header-notification p:hover{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header3_notification_font_hvrcolor' ) ); ?>;
}

.header-type3 .header-main , .header-type3 .header-mobile{
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_header3_main_bg_color' ) ); ?>;
}

.header-type3 .header-main , .header-type3 .site-nav.large .sub-menu li a , .header-type3 .header-mobile{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header3_main_font_color' ) ); ?>;
}

.header-type3 .site-nav.large .menu>li>a:hover , .header-type3 .site-nav.large .sub-menu li a:hover{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header3_main_font_hvrcolor' ) ); ?>;
}

.header-type3 .site-nav.large .menu>li.mega-menu>.sub-menu>li.menu-item-has-children>a{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header3_main_submenu_header_font_color' ) ); ?>;
}


.site-header.header-type4 .header-top  {
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_header4_top_bg_color' ) ); ?>;
	border-bottom-color: <?php echo esc_attr(get_theme_mod( 'furnob_header4_top_border_color' ) ); ?>;
}

.header-type4 .header-message p{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header4_top_notification_color' ) ); ?>;
}

.header-type4 .header-message p a{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header4_top_notification_button_color' ) ); ?>;
}

.header-type4 .header-top .site-nav a{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header4_top_font_color' ) ); ?>;
}

.header-type4 .header-top .site-nav a:hover{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header4_top_font_hvrcolor' ) ); ?>;
}

.site-header.header-type4 .header-notification{
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_header4_notification_bg_color' ) ); ?>;
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header4_notification_font_color' ) ); ?>;
}

.site-header.header-type4 .header-notification p:hover{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header4_notification_font_hvrcolor' ) ); ?>;
}

.site-header.header-type4 .header-main , .header-type4 .header-mobile{
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_header4_main_bg_color' ) ); ?>;
}

.site-header.header-type4 .header-main , .site-header.header-type4 .site-nav.large .sub-menu li a , .header-type4 .header-mobile {
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header4_main_font_color' ) ); ?>;
}

.header-type4 .site-nav.large .menu>li>a:hover , .header-type4 .site-nav.large .sub-menu li a:hover{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header4_main_font_hvrcolor' ) ); ?>;
}

.header-type4 .site-nav.large .menu>li.mega-menu>.sub-menu>li.menu-item-has-children>a{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header4_main_submenu_header_font_color' ) ); ?>;
}

.site-header.header-type5 .header-notification{
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_header5_top_bg_color' ) ); ?>;
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header5_top_font_color' ) ); ?>;
}

.header-type5 .header-notification .countdown .count-item{
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_header5_top_date_bg_color' ) ); ?>;
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header5_top_date_font_color' ) ); ?>;
}

.header-type5 .header-main , .header-type5 .header-mobile{
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_header5_main_bg_color' ) ); ?>;
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header5_main_font_color' ) ); ?>;
}

.header-type5 .header-row.border-container .header-wrapper{
	border-bottom-color: <?php echo esc_attr(get_theme_mod( 'furnob_header5_main_border_color' ) ); ?>;
}

.header-type5 .header-nav{
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_header5_bottom_bg_color' ) ); ?>;
}

.header-type5 .header-nav , .site-header.header-type5 .site-nav.large .sub-menu li a{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header5_bottom_font_color' ) ); ?>;
}

.header-type5 .site-nav.large .menu > li > a:hover , .site-header.header-type5 .site-nav.large .sub-menu li a:hover{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header5_bottom_font_hvrcolor' ) ); ?>;
}

.site-header.header-type5 .site-nav.large .menu>li.mega-menu>.sub-menu>li.menu-item-has-children>a{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_header5_bottom_submenu_header_font_color' ) ); ?>;
}

.site-offcanvas{
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_mobile_menu_bg_color' ) ); ?>;
	color: <?php echo esc_attr(get_theme_mod( 'furnob_mobile_menu_font_color' ) ); ?>;
}

.site-offcanvas .site-offcanvas-header{
	border-bottom-color: <?php echo esc_attr(get_theme_mod( 'furnob_mobile_menu_border_color' ) ); ?>;
}

.site-offcanvas .site-offcanvas-footer{
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_mobile_menu_bottom_bg_color' ) ); ?>;
}

.site-offcanvas .site-copyright p{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_mobile_menu_copyright_font_color' ) ); ?>;
}

.mobile-bottom-menu{
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_mobile_bottom_menu_bg_color' ) ); ?>;
}

.mobile-bottom-menu .mobile-menu ul li a i {
	color: <?php echo esc_attr(get_theme_mod( 'furnob_mobile_bottom_menu_icon_color' ) ); ?>;
}

.mobile-bottom-menu .mobile-menu ul li a span {
	color: <?php echo esc_attr(get_theme_mod( 'furnob_mobile_bottom_menu_font_color' ) ); ?>;
}

.site-departments>a{
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_sidebar_menu_bg_color' ) ); ?>;
	color: <?php echo esc_attr(get_theme_mod( 'furnob_sidebar_menu_font_color' ) ); ?>;
}

.site-departments .dropdown-menu {
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_sidebar_menu_content_bg_color' ) ); ?>;
	color: <?php echo esc_attr(get_theme_mod( 'furnob_sidebar_menu_content_font_color' ) ); ?>;
}

.site-departments .departments-menu > ul li a:hover , .site-departments .departments-menu>ul li.menu-item-has-children:hover>a ,
.site-departments .departments-menu>ul .sub-menu li a:hover{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_sidebar_menu_content_font_hvrcolor' ) ); ?>;
}

.site-departments .departments-menu>ul>li.separator{
	border-top-color: <?php echo esc_attr(get_theme_mod( 'furnob_sidebar_menu_border_color' ) ); ?>;
}

.site-footer .footer-iconboxes .iconbox .icon{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_featured_box_icon_color' ) ); ?>;
}

.site-footer .footer-iconboxes .iconbox .detail .entry-title{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_featured_box_title_color' ) ); ?>;
}

.site-footer .footer-iconboxes .iconbox .detail .entry-description{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_featured_box_desc_color' ) ); ?>;
}

.site-footer .footer-row.custom-color.gray{
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_footer_subscribe_bg_color' ) ); ?>;
}

.site-footer .footer-newsletter .newsletter-content .entry-title{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_footer_subscribe_title_color' ) ); ?>;
}

.site-footer .footer-newsletter .newsletter-content .entry-subtitle{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_footer_subscribe_subtitle_color' ) ); ?>;
}

.site-footer .footer-newsletter .newsletter-content .entry-description p{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_footer_subscribe_desc_color' ) ); ?>;
}

.site-footer .footer-extra{
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_footer_extra_bg_color' ) ); ?>;
}

.site-footer .footer-extra p strong{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_footer_extra_title_color' ) ); ?>;
}

.site-footer .footer-extra p{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_footer_extra_subtitle_color' ) ); ?>;
}

.site-footer .footer-widgets {
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_footer_top_bg_color' ) ); ?>;
}

.site-footer .footer-widgets.bordered .footer-row-inner{
	border-top-color: <?php echo esc_attr(get_theme_mod( 'furnob_footer_top_border_color' ) ); ?>;
}

.site-footer .widget .widget-title{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_footer_title_color' ) ); ?>;
}

.site-footer .widget p , .site-footer .widget .menu li a{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_footer_subtitle_color' ) ); ?>;
}

.site-footer .footer-copyright{
	background-color: <?php echo esc_attr(get_theme_mod( 'furnob_footer_bottom_bg_color' ) ); ?>;
}

.site-footer .footer-copyright.bordered .footer-row-inner{
	border-top-color: <?php echo esc_attr(get_theme_mod( 'furnob_footer_bottom_border_color' ) ); ?>;
}

.site-footer .footer-copyright .site-copyright p{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_footer_copyright_color' ) ); ?>;
}

.site-footer .footer-copyright .site-cards ul li a{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_footer_payment_color' ) ); ?>;
}

.site-footer .footer-copyright .site-menu .menu li a{
	color: <?php echo esc_attr(get_theme_mod( 'furnob_footer_bottom_menu_color' ) ); ?>;
}

<?php if(function_exists('dokan')){ ?>

	input[type='submit'].dokan-btn-theme,
	a.dokan-btn-theme,
	.dokan-btn-theme {
		background-color: <?php echo esc_attr(get_theme_mod( 'furnob_main_color' ) ); ?>;
		border-color: <?php echo esc_attr(get_theme_mod( 'furnob_main_color' ) ); ?>;
	}
	input[type='submit'].dokan-btn-theme .badge,
	a.dokan-btn-theme .badge,
	.dokan-btn-theme .badge {
		color: <?php echo esc_attr(get_theme_mod( 'furnob_main_color' ) ); ?>;
	}
	.dokan-announcement-uread {
		border: 1px solid <?php echo esc_attr(get_theme_mod( 'furnob_main_color' ) ); ?> !important;
	}
	.dokan-announcement-uread .dokan-annnouncement-date {
		background-color: <?php echo esc_attr(get_theme_mod( 'furnob_main_color' ) ); ?> !important;
	}
	.dokan-announcement-bg-uread {
		background-color: <?php echo esc_attr(get_theme_mod( 'furnob_main_color' ) ); ?>;
	}
	.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li:hover {
		background: <?php echo esc_attr(get_theme_mod( 'furnob_main_color' ) ); ?>;
	}
	.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.dokan-common-links a:hover {
		background: <?php echo esc_attr(get_theme_mod( 'furnob_main_color' ) ); ?>;
	}
	.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.active {
		background: <?php echo esc_attr(get_theme_mod( 'furnob_main_color' ) ); ?>;
	}
	.dokan-product-listing .dokan-product-listing-area table.product-listing-table td.post-status label.pending {
		background: <?php echo esc_attr(get_theme_mod( 'furnob_main_color' ) ); ?>;
	}
	.product-edit-container .dokan-product-title-alert,
	.product-edit-container .dokan-product-cat-alert {
		color: <?php echo esc_attr(get_theme_mod( 'furnob_main_color' ) ); ?>;
	}
	.product-edit-container .dokan-product-less-price-alert {
		color: <?php echo esc_attr(get_theme_mod( 'furnob_main_color' ) ); ?>;
	}
	.dokan-store-wrap {
	    margin-top: 3.5rem;
	}
	.dokan-widget-area ul {
	    list-style: none;
	    padding-left: 0;
	    font-size: .875rem;
	    font-weight: 400;
	}
	.dokan-widget-area ul li a {
	    text-decoration: none;
	    color: var(--color-text-lighter);
	    margin-bottom: .625rem;
	    display: inline-block;
	}
	form.dokan-store-products-ordeby:before, 
	form.dokan-store-products-ordeby:after {
		content: '';
		display: table;
		clear: both;
	}
	.dokan-store-products-filter-area .orderby-search {
	    width: auto;
	}
	input.search-store-products.dokan-btn-theme {
	    border-top-left-radius: 0;
	    border-bottom-left-radius: 0;
	}
	.dokan-pagination-container .dokan-pagination li a {
	    display: -webkit-inline-box;
	    display: -ms-inline-flexbox;
	    display: inline-flex;
	    -webkit-box-align: center;
	    -ms-flex-align: center;
	    align-items: center;
	    -webkit-box-pack: center;
	    -ms-flex-pack: center;
	    justify-content: center;
	    font-size: .875rem;
	    font-weight: 600;
	    width: 2.25rem;
	    height: 2.25rem;
	    border-radius: 50%;
	    color: currentColor;
	    text-decoration: none;
	    border: none;
	}
	.dokan-pagination-container .dokan-pagination li.active a {
	    color: #fff;
	    background-color: var(--color-secondary) !important;
	}
	.dokan-pagination-container .dokan-pagination li:last-child a, 
	.dokan-pagination-container .dokan-pagination li:first-child a {
	    width: auto;
	}

	.vendor-customer-registration label {
	    margin-right: 10px;
	}

	.woocommerce-mini-cart dl.variation {
	    display: none;
	}

	.product-name dl.variation {
	    display: none;
	}
	
	@media screen and (max-width: 64rem){
		.dokan-store-products-filter-area .orderby-search {
			width: 100% !important;
			margin-top: 10px;
		}
		
		body .dokan-store-products-filter-area {
			margin-bottom: 15px;
		}
	}
	
	@media screen and (max-width: 64rem){
		div#dokan-content .filter-button {
			display: block;
			border: solid 1px #eee;
			padding: 5px 15px;
			border-radius: 4px;
			margin-bottom: 15px;
		}
	}
	
	.seller-rating .star-rating span.width + span {
		display: none;
	}

	.seller-rating .star-rating {
		display: block;
	}

<?php } ?>
</style>
<?php }
add_action('wp_head','furnob_custom_styling');

?>