<?php
/*======
*
* Kirki Settings
*
======*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki' ) ) {
	return;
}

Kirki::add_config(
	'furnob_customizer', array(
		'capability'  => 'edit_theme_options',
		'option_type' => 'theme_mod',
	)
);

/*======
*
* Sections
*
======*/
$sections = array(
	'shop_settings' => array (
		esc_attr__( 'Shop Settings', 'furnob' ),
		esc_attr__( 'You can customize the shop settings.', 'furnob' ),
	),
	
	'blog_settings' => array (
		esc_attr__( 'Blog Settings', 'furnob' ),
		esc_attr__( 'You can customize the blog settings.', 'furnob' ),
	),

	'header_settings' => array (
		esc_attr__( 'Header Settings', 'furnob' ),
		esc_attr__( 'You can customize the header settings.', 'furnob' ),
	),

	'main_color' => array (
		esc_attr__( 'Main Color', 'furnob' ),
		esc_attr__( 'You can customize the main color.', 'furnob' ),
	),

	'elementor_templates' => array (
		esc_attr__( 'Elementor Templates', 'furnob-core' ),
		esc_attr__( 'You can customize the elementor templates.', 'furnob-core' ),
	),
	
	'map_settings' => array (
		esc_attr__( 'Map Settings', 'furnob' ),
		esc_attr__( 'You can customize the map settings.', 'furnob' ),
	),

	'footer_settings' => array (
		esc_attr__( 'Footer Settings', 'furnob' ),
		esc_attr__( 'You can customize the footer settings.', 'furnob' ),
	),

);

foreach ( $sections as $section_id => $section ) {
	$section_args = array(
		'title' => $section[0],
		'description' => $section[1],
	);

	if ( isset( $section[2] ) ) {
		$section_args['type'] = $section[2];
	}

	if( $section_id == "colors" ) {
		Kirki::add_section( str_replace( '-', '_', $section_id ), $section_args );
	} else {
		Kirki::add_section( 'furnob_' . str_replace( '-', '_', $section_id ) . '_section', $section_args );
	}
}


/*======
*
* Fields
*
======*/
function furnob_customizer_add_field ( $args ) {
	Kirki::add_field(
		'furnob_customizer',
		$args
	);
}

	/*====== Header ==================================================================================*/
		/*====== Header Panels ======*/
		Kirki::add_panel (
			'furnob_header_panel',
			array(
				'title' => esc_html__( 'Header Settings', 'furnob' ),
				'description' => esc_html__( 'You can customize the header from this panel.', 'furnob' ),
			)
		);

		$sections = array (
			'header_logo' => array(
				esc_attr__( 'Logo', 'furnob' ),
				esc_attr__( 'You can customize the logo which is on header..', 'furnob' )
			),
		
			'header_general' => array(
				esc_attr__( 'Header General', 'furnob' ),
				esc_attr__( 'You can customize the header.', 'furnob' )
			),
			
			'header_notification' => array(
				esc_attr__( 'Header Notification', 'furnob' ),
				esc_attr__( 'You can customize the header notification.', 'furnob' )
			),

			'header_preloader' => array(
				esc_attr__( 'Preloader', 'furnob' ),
				esc_attr__( 'You can customize the loader.', 'furnob' )
			),
			
			'header1_style' => array(
				esc_attr__( 'Header 1 Style', 'furnob' ),
				esc_attr__( 'You can customize the style.', 'furnob' )
			),
			
			'header2_style' => array(
				esc_attr__( 'Header 2 Style', 'furnob' ),
				esc_attr__( 'You can customize the style.', 'furnob' )
			),
			
			'header3_style' => array(
				esc_attr__( 'Header 3 Style', 'furnob' ),
				esc_attr__( 'You can customize the style.', 'furnob' )
			),
			
			'header4_style' => array(
				esc_attr__( 'Header 4 Style', 'furnob' ),
				esc_attr__( 'You can customize the style.', 'furnob' )
			),
			
			'header5_style' => array(
				esc_attr__( 'Header 5 Style', 'furnob' ),
				esc_attr__( 'You can customize the style.', 'furnob' )
			),
			
			'sidebar_menu_style' => array(
				esc_attr__( 'Sidebar Menu Style', 'furnob' ),
				esc_attr__( 'You can customize the style.', 'furnob' )
			),
			
			'mobile_menu_style' => array(
				esc_attr__( 'Mobile Menu Style', 'furnob' ),
				esc_attr__( 'You can customize the style.', 'furnob' )
			),
			
			'mobile_bottom_menu_style' => array(
				esc_attr__( 'Mobile Bottom Menu Style', 'furnob' ),
				esc_attr__( 'You can customize the style.', 'furnob' )
			),

		);

		foreach ( $sections as $section_id => $section ) {
			$section_args = array(
				'title' => $section[0],
				'description' => $section[1],
				'panel' => 'furnob_header_panel',
			);

			if ( isset( $section[2] ) ) {
				$section_args['type'] = $section[2];
			}

			Kirki::add_section( 'furnob_' . str_replace( '-', '_', $section_id ) . '_section', $section_args );
		}
		
		/*====== Logo ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'image',
				'settings' => 'furnob_logo',
				'label' => esc_attr__( 'Logo', 'furnob' ),
				'description' => esc_attr__( 'You can upload a logo.', 'furnob' ),
				'section' => 'furnob_header_logo_section',
				'choices' => array(
					'save_as' => 'id',
				),
			)
		);

		/*====== Mobile Logo ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'image',
				'settings' => 'furnob_mobile_logo',
				'label' => esc_attr__( 'Mobile Logo', 'furnob' ),
				'description' => esc_attr__( 'You can upload a logo for mobile.', 'furnob' ),
				'section' => 'furnob_header_logo_section',
				'choices' => array(
					'save_as' => 'id',
				),
			)
		);
		
		/*====== Logo Text ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'text',
				'settings' => 'furnob_logo_text',
				'label' => esc_attr__( 'Set Logo Text', 'furnob' ),
				'description' => esc_attr__( 'You can set logo as text.', 'furnob' ),
				'section' => 'furnob_header_logo_section',
				'default' => 'Furnob',
			)
		);
		
		/*====== Logo Size ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'slider',
				'settings'    => 'furnob_logo_size',
				'label'       => esc_html__( 'Logo Size', 'furnob-core' ),
				'description' => esc_attr__( 'You can set size of the logo.', 'furnob-core' ),
				'section'     => 'furnob_header_logo_section',
				'default'     => 160,
				'transport'   => 'auto',
				'choices'     => [
					'min'  => 20,
					'max'  => 400,
					'step' => 1,
				],
				'output' => [
				[
					'element' => '.site-header .site-brand img',
					'property'    => 'width',
					'units' => 'px',
				], ],
			)
		);
		
		/*====== Mobil Logo Size ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'slider',
				'settings'    => 'furnob_mobil_logo_size',
				'label'       => esc_html__( 'Mobile Logo Size', 'furnob-core' ),
				'description' => esc_attr__( 'You can set size of the mobil logo.', 'furnob-core' ),
				'section'     => 'furnob_header_logo_section',
				'default'     => 144,
				'transport'   => 'auto',
				'choices'     => [
					'min'  => 20,
					'max'  => 300,
					'step' => 1,
				],
				'output' => [
				[
					'element' => '.site-header .header-mobile .site-brand img',
					'property'    => 'width',
					'units' => 'px',
				], ],
			)
		);
		
		/*====== Sidebar Logo Size ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'slider',
				'settings'    => 'furnob_sidebar_logo_size',
				'label'       => esc_html__( 'Sidebar Logo Size', 'furnob-core' ),
				'description' => esc_attr__( 'You can set size of the sidebar logo.', 'furnob-core' ),
				'section'     => 'furnob_header_logo_section',
				'default'     => 160,
				'transport'   => 'auto',
				'choices'     => [
					'min'  => 20,
					'max'  => 300,
					'step' => 1,
				],
				'output' => [
				[
					'element' => '.site-offcanvas-header .site-brand img',
					'property'    => 'width',
					'units' => 'px',
				], ],
			)
		);
		
		furnob_customizer_add_field(
			array (
			'type'        => 'select',
			'settings'    => 'furnob_header_type',
			'label'       => esc_html__( 'Header Type', 'furnob-core' ),
			'section'     => 'furnob_header_general_section',
			'default'     => 'type-1',
			'priority'    => 10,
			'choices'     => array(
				'type1' => esc_attr__( 'Type 1', 'furnob-core' ),
				'type2' => esc_attr__( 'Type 2', 'furnob-core' ),
				'type3' => esc_attr__( 'Type 3', 'furnob-core' ),
				'type4' => esc_attr__( 'Type 4', 'furnob-core' ),
				'type5' => esc_attr__( 'Type 5', 'furnob-core' ),
			),
			) 
		);

		/*====== Mobile Sticky Header Toggle ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_mobile_sticky_header',
				'label' => esc_attr__( 'Mobile Sticky Header', 'furnob-core' ),
				'description' => esc_attr__( 'You can choose status of the header on the mobile.', 'furnob-core' ),
				'section' => 'furnob_header_general_section',
				'default' => '0',
			)
		);
		
		/*====== Header Search Toggle ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_header_search',
				'label' => esc_attr__( 'Header Search', 'furnob' ),
				'description' => esc_attr__( 'You can choose status of the search on the header.', 'furnob' ),
				'section' => 'furnob_header_general_section',
				'default' => '0',
			)
		);
		
		/*====== Ajax Search Form ======*/
		if ( class_exists( 'DGWT_WC_Ajax_Search' )){
			furnob_customizer_add_field (
				array(
					'type' => 'toggle',
					'settings' => 'furnob_ajax_search_form',
					'label' => esc_attr__( 'Ajax Search Form Search Holder', 'furnob' ),
					'description' => esc_attr__( 'Replace the search bar which is on the search holder.', 'furnob' ),
					'section' => 'furnob_header_general_section',
					'default' => '0',
					'required' => array(
						array(
						  'setting'  => 'furnob_header_search',
						  'operator' => '==',
						  'value'    => '1',
						),
					),
				)
			);
		}
		
		/*====== Header Cart Toggle ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_header_cart',
				'label' => esc_attr__( 'Header Cart', 'furnob' ),
				'description' => esc_attr__( 'You can choose status of the mini cart on the header.', 'furnob' ),
				'section' => 'furnob_header_general_section',
				'default' => '0',
			)
		);
		
		/*====== Header Wishlist  ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_header_wishlist',
				'label' => esc_attr__( 'Wishlist', 'furnob-core' ),
				'description' => esc_attr__( 'Disable or Enable wishlist on the header.', 'furnob-core' ),
				'section' => 'furnob_header_general_section',
				'default' => '0',
			)
		);
		
		/*====== Location Filter Toggle ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_location_filter',
				'label' => esc_attr__( 'Location Filter', 'furnob-core' ),
				'description' => esc_attr__( 'You can choose status of the location feature.', 'furnob-core' ),
				'section' => 'furnob_header_general_section',
				'default' => '0',
			)
		);
		
		/*====== Header Sidebar ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_header_sidebar',
				'label' => esc_attr__( 'Sidebar Menu', 'furnob' ),
				'description' => esc_attr__( 'Disable or Enable Sidebar Menu', 'furnob' ),
				'section' => 'furnob_header_general_section',
				'default' => '0',
			)
		);

		/*====== Header Sidebar Collapse ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_header_sidebar_collapse',
				'label' => esc_attr__( 'Disable Collapse on Frontpage', 'furnob' ),
				'description' => esc_attr__( 'Disable or Enable Sidebar Collapse on Home Page.', 'furnob' ),
				'section' => 'furnob_header_general_section',
				'default' => '0',
				'required' => array(
					array(
					  'setting'  => 'furnob_header_sidebar',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Secondary Menu Toggle ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_secondary_menu',
				'label' => esc_attr__( 'Secondary Menu', 'furnob' ),
				'description' => esc_attr__( 'Disable or Enable secondary menu.', 'furnob' ),
				'section' => 'furnob_header_general_section',
				'default' => '0',
			)
		);
		
		/*====== Type3 Right Menu Toggle ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_type3_right_menu',
				'label' => esc_attr__( 'Header Type3 Right Menu', 'furnob' ),
				'description' => esc_attr__( 'Disable or Enable right menu for header type3.', 'furnob' ),
				'section' => 'furnob_header_general_section',
				'default' => '0',
			)
		);
		
		/*====== Top Notification Count Toggle======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_top_notification_count_toggle',
				'label' => esc_attr__( 'Top Notification Count', 'furnob-core' ),
				'description' => esc_attr__( 'You can choose status of the notification count on the header.', 'furnob-core' ),
				'section' => 'furnob_header_notification_section',
				'default' => '0',
			)
		);
		
		/*====== Top Notification Count Text ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'text',
				'settings' => 'furnob_top_notification_count_text',
				'label' => esc_attr__( 'Top Notification Count Text', 'furnob-core' ),
				'description' => esc_attr__( 'You can add a text for the notification count.', 'furnob-core' ),
				'section' => 'furnob_header_notification_section',
				'default' => '',
				'required' => array(
					array(
					  'setting'  => 'furnob_top_notification_count_toggle',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Top Notification Count Date ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'date',
				'settings' => 'furnob_top_notification_count_date',
				'label' => esc_attr__( 'Top Notification Count Date', 'furnob-core' ),
				'description' => esc_attr__( 'You can add a date for the notification count.', 'furnob-core' ),
				'section' => 'furnob_header_notification_section',
				'default' => '',
				'required' => array(
					array(
					  'setting'  => 'furnob_top_notification_count_toggle',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Top Notification Text1 Toggle======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_top_notification1_toggle',
				'label' => esc_attr__( 'Top Notification 1', 'furnob-core' ),
				'description' => esc_attr__( 'You can choose status of the notification 1 on the header.', 'furnob-core' ),
				'section' => 'furnob_header_notification_section',
				'default' => '0',
			)
		);
		
		/*====== Top Notification 1 Content ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'textarea',
				'settings' => 'furnob_top_notification1_content',
				'label' => esc_attr__( 'Top Notification 1 Content', 'furnob-core' ),
				'description' => esc_attr__( 'You can add a text for the notification 1 content.', 'furnob-core' ),
				'section' => 'furnob_header_notification_section',
				'default' => '',
				'required' => array(
					array(
					  'setting'  => 'furnob_top_notification1_toggle',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Top Notification Text2 Toggle======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_top_notification2_toggle',
				'label' => esc_attr__( 'Top Notification 2', 'furnob-core' ),
				'description' => esc_attr__( 'You can choose status of the notification 2 on the header.', 'furnob-core' ),
				'section' => 'furnob_header_notification_section',
				'default' => '0',
			)
		);
		
		/*====== Top Notification 2 Content ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'textarea',
				'settings' => 'furnob_top_notification2_content',
				'label' => esc_attr__( 'Top Notification 2 Content', 'furnob-core' ),
				'description' => esc_attr__( 'You can add a text for the notification 2 content.', 'furnob-core' ),
				'section' => 'furnob_header_notification_section',
				'default' => '',
				'required' => array(
					array(
					  'setting'  => 'furnob_top_notification2_toggle',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Header Contact Box Toggle======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_header_contact_box_toggle',
				'label' => esc_attr__( 'Contact Box', 'furnob-core' ),
				'description' => esc_attr__( 'You can choose status of the contact box on the header type2.', 'furnob-core' ),
				'section' => 'furnob_header_general_section',
				'default' => '0',
			)
		);
		
		/*====== Header Contact Box Phone ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'text',
				'settings' => 'furnob_header_contact_box_phone',
				'label' => esc_attr__( 'Contact Box Phone', 'furnob-core' ),
				'description' => esc_attr__( 'You can add a phone number.', 'furnob-core' ),
				'section' => 'furnob_header_general_section',
				'default' => '',
				'required' => array(
					array(
					  'setting'  => 'furnob_header_contact_box_toggle',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Header Contact Box Subtitle ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'text',
				'settings' => 'furnob_header_contact_box_subtitle',
				'label' => esc_attr__( 'Contact Box Subtitle', 'furnob-core' ),
				'description' => esc_attr__( 'You can add a subtitle for contact Box.', 'furnob-core' ),
				'section' => 'furnob_header_general_section',
				'default' => '',
				'required' => array(
					array(
					  'setting'  => 'furnob_header_contact_box_toggle',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Header Contact Icon ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'text',
				'settings' => 'furnob_header_contact_box_icon',
				'label' => esc_attr__( 'Contact Box Icon', 'furnob-core' ),
				'description' => esc_attr__( 'You can add an icon for the contact box. for example: klbth-icon-telephone', 'furnob-core' ),
				'section' => 'furnob_header_general_section',
				'default' => '',
				'required' => array(
					array(
					  'setting'  => 'furnob_header_contact_box_toggle',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Header Button Toggle======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_header_button_toggle',
				'label' => esc_attr__( 'Header Button', 'furnob-core' ),
				'description' => esc_attr__( 'You can choose status of the button on the header type5.', 'furnob-core' ),
				'section' => 'furnob_header_general_section',
				'default' => '0',
			)
		);
		
		/*====== Header Button Text ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'text',
				'settings' => 'furnob_header_button_text',
				'label' => esc_attr__( 'Button Text', 'furnob-core' ),
				'description' => esc_attr__( 'You can add a text for the button.', 'furnob-core' ),
				'section' => 'furnob_header_general_section',
				'default' => '',
				'required' => array(
					array(
					  'setting'  => 'furnob_header_button_toggle',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Header Button URL ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'text',
				'settings' => 'furnob_header_button_url',
				'label' => esc_attr__( 'Button URL', 'furnob-core' ),
				'description' => esc_attr__( 'You can add an url for the button.', 'furnob-core' ),
				'section' => 'furnob_header_general_section',
				'default' => '',
				'required' => array(
					array(
					  'setting'  => 'furnob_header_button_toggle',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);

		/*====== PreLoader Toggle ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_preloader',
				'label' => esc_attr__( 'Enable Loader', 'furnob' ),
				'description' => esc_attr__( 'Disable or Enable the loader.', 'furnob' ),
				'section' => 'furnob_header_preloader_section',
				'default' => '0',
			)
		);
		
	/*====== Header 1 Style ================*/
	
		/*====== Header 1 Top Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_header1_top_bg_color',
				'label' => esc_attr__( 'Header Top Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  background.', 'furnob-core' ),
				'section' => 'furnob_header1_style_section',
			)
		);
		
		/*====== Header 1 Top Border Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#e5e5e5',
				'settings' => 'furnob_header1_top_border_color',
				'label' => esc_attr__( 'Header Top Border Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  border.', 'furnob-core' ),
				'section' => 'furnob_header1_style_section',
			)
		);
		
		/*====== Header1 Top Notification Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header1_top_notification_color',
				'label' => esc_attr__( 'Header Top Notification Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header1_style_section',
			)
		);
		
		/*====== Header1 Top Notification Button Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#eb7700',
				'settings' => 'furnob_header1_top_notification_button_color',
				'label' => esc_attr__( 'Header Top Notification Button Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header1_style_section',
			)
		);
		
		/*====== Header1 Top Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header1_top_font_color',
				'label' => esc_attr__( 'Header Top Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header1_style_section',
			)
		);
		
		/*====== Header1 Top Font Hover Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header1_top_font_hvrcolor',
				'label' => esc_attr__( 'Header Top Font Hover Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header1_style_section',
			)
		);
		
		/*====== Header 1 Main Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_header1_main_bg_color',
				'label' => esc_attr__( 'Header Main Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  background.', 'furnob-core' ),
				'section' => 'furnob_header1_style_section',
			)
		);
		
		/*====== Header1 Main Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header1_main_font_color',
				'label' => esc_attr__( 'Header Main Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header1_style_section',
			)
		);
		
		/*====== Header1 Main Font Hover Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header1_main_font_hvrcolor',
				'label' => esc_attr__( 'Header Main Font Hover Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header1_style_section',
			)
		);
		
		/*====== Header1 Main Submenu Header Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#eb7700',
				'settings' => 'furnob_header1_main_submenu_header_font_color',
				'label' => esc_attr__( 'Header Main Submenu Header Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header1_style_section',
			)
		);
		
		/*====== Header1 Top Notification  Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header1_top_notification_size',
				'label'       => esc_attr__( 'Top Header Notification Typography', 'furnob-core' ),
				'section'     => 'furnob_header1_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '13px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .header-type1 .header-message p ',
					],
				],
			)
		);
		
		/*====== Header1 Top Font Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header1_top_font_size',
				'label'       => esc_attr__( 'Top Header Font Typography', 'furnob-core' ),
				'section'     => 'furnob_header1_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '13px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .header-type1 .header-top .site-nav a ',
					],
				],
			)
		);
		
		/*====== Header1 Main Font Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header1_main_font_size',
				'label'       => esc_attr__( 'Header Main Font Typography', 'furnob-core' ),
				'section'     => 'furnob_header1_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '16px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .site-header.header-type1 .site-nav.large .menu > li > a ',
					],
				],
			)
		);
		
		/*====== Header1 Main Submenu Font Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header1_main_submenu_font_size',
				'label'       => esc_attr__( 'Header Main Submenu Font Typography', 'furnob-core' ),
				'section'     => 'furnob_header1_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '15px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .header-type1 .site-nav.large .sub-menu li a ',
					],
				],
			)
		);
		
	/*====== Header 2 Style ================*/	
	
		/*====== Header 2 Top Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#016a78',
				'settings' => 'furnob_header2_top_bg_color',
				'label' => esc_attr__( 'Header Top Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  background.', 'furnob-core' ),
				'section' => 'furnob_header2_style_section',
			)
		);
		
		/*====== Header 2 Top Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_header2_top_font_color',
				'label' => esc_attr__( 'Header Top Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header2_style_section',
			)
		);
		
		/*====== Header 2 Top Count Date Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_header2_top_date_bg_color',
				'label' => esc_attr__( 'Header Top Count Date Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  background.', 'furnob-core' ),
				'section' => 'furnob_header2_style_section',
			)
		);
		
		/*====== Header 2 Top Count Date Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header2_top_date_font_color',
				'label' => esc_attr__( 'Header Top Count Date Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header2_style_section',
			)
		);
		
		/*====== Header 2 Main Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_header2_main_bg_color',
				'label' => esc_attr__( 'Header Main Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  background.', 'furnob-core' ),
				'section' => 'furnob_header2_style_section',
			)
		);
		
		/*====== Header 2 Main Border Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#e5e5e5',
				'settings' => 'furnob_header2_main_border_color',
				'label' => esc_attr__( 'Header Main Border Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  border.', 'furnob-core' ),
				'section' => 'furnob_header2_style_section',
			)
		);
		
		/*====== Header2 Main Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header2_main_font_color',
				'label' => esc_attr__( 'Header Main Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header2_style_section',
			)
		);
		
		/*====== Header 2 Bottom Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_header2_bottom_bg_color',
				'label' => esc_attr__( 'Header Bottom Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  background.', 'furnob-core' ),
				'section' => 'furnob_header2_style_section',
			)
		);
		
		/*====== Header2 Bottom Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header2_bottom_font_color',
				'label' => esc_attr__( 'Header Bottom Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header2_style_section',
			)
		);
		
		/*====== Header2 Bottom Font Hover Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header2_bottom_font_hvrcolor',
				'label' => esc_attr__( 'Header Bottom Font Hover Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header2_style_section',
			)
		);
		
		/*====== Header2 Bottom Submenu Header Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#eb7700',
				'settings' => 'furnob_header2_bottom_submenu_header_font_color',
				'label' => esc_attr__( 'Header Bottom Submenu Header Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header2_style_section',
			)
		);
		
		/*====== Header2 Top Font Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header2_top_font_size',
				'label'       => esc_attr__( 'Top Header Font Typography', 'furnob-core' ),
				'section'     => 'furnob_header2_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '13px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .header-type2 .header-notification p ',
					],
				],
			)
		);
		
		/*====== Header2 Main Menu Font Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header2_main_menu_font_size',
				'label'       => esc_attr__( 'Header Main Menu Font Typography', 'furnob-core' ),
				'section'     => 'furnob_header2_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '14px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .header-type2 .header-main .site-nav a ',
					],
				],
			)
		);
		
		/*====== Header2 Bottom Font Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header2_bottom_font_size',
				'label'       => esc_attr__( 'Header Bottom Font Typography', 'furnob-core' ),
				'section'     => 'furnob_header2_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '16px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .site-header.header-type2 .site-nav.large .menu > li > a ',
					],
				],
			)
		);
		
		/*====== Header2 Bottom Submenu Font Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header2_bottom_submenu_font_size',
				'label'       => esc_attr__( 'Header Bottom Submenu Font Typography', 'furnob-core' ),
				'section'     => 'furnob_header2_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '15px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .site-header.header-type2 .site-nav.large .sub-menu li a ',
					],
				],
			)
		);
		
		
	/*====== Header 3 Style ================*/	
		
		/*====== Header 3 Top Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_header3_top_bg_color',
				'label' => esc_attr__( 'Header Top Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  background.', 'furnob-core' ),
				'section' => 'furnob_header3_style_section',
			)
		);
		
		/*====== Header 3 Top Border Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#e5e5e5',
				'settings' => 'furnob_header3_top_border_color',
				'label' => esc_attr__( 'Header Top Border Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  border.', 'furnob-core' ),
				'section' => 'furnob_header3_style_section',
			)
		);
		
		/*====== Header3 Top Notification Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header3_top_notification_color',
				'label' => esc_attr__( 'Header Top Notification Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header3_style_section',
			)
		);
		
		/*====== Header3 Top Notification Button Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#eb7700',
				'settings' => 'furnob_header3_top_notification_button_color',
				'label' => esc_attr__( 'Header Top Notification Button Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header3_style_section',
			)
		);
		
		/*====== Header3 Top Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header3_top_font_color',
				'label' => esc_attr__( 'Header Top Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header3_style_section',
			)
		);
		
		/*====== Header3 Top Font Hover Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header3_top_font_hvrcolor',
				'label' => esc_attr__( 'Header Top Font Hover Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header3_style_section',
			)
		);
		
		/*====== Header 3  Notification Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#848484',
				'settings' => 'furnob_header3_notification_bg_color',
				'label' => esc_attr__( 'Header Notification Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  background.', 'furnob-core' ),
				'section' => 'furnob_header3_style_section',
			)
		);
		
		/*====== Header3 Notification Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_header3_notification_font_color',
				'label' => esc_attr__( 'Header Notification Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header3_style_section',
			)
		);
		
		/*====== Header3 Notification Hover Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_header3_notification_font_hvrcolor',
				'label' => esc_attr__( 'Header Notification Hover Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header3_style_section',
			)
		);
		
		/*====== Header 3 Main Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_header3_main_bg_color',
				'label' => esc_attr__( 'Header Main Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  background.', 'furnob-core' ),
				'section' => 'furnob_header3_style_section',
			)
		);
		
		/*====== Header3 Main Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header3_main_font_color',
				'label' => esc_attr__( 'Header Main Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header3_style_section',
			)
		);
		
		/*====== Header3 Main Font Hover Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header3_main_font_hvrcolor',
				'label' => esc_attr__( 'Header Main Font Hover Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header3_style_section',
			)
		);
		
		/*====== Header3 Main Submenu Header Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#eb7700',
				'settings' => 'furnob_header3_main_submenu_header_font_color',
				'label' => esc_attr__( 'Header Main Submenu Header Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header3_style_section',
			)
		);
		
		/*====== Header3 Top Notification  Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header3_top_notification_size',
				'label'       => esc_attr__( 'Top Header Notification Typography', 'furnob-core' ),
				'section'     => 'furnob_header3_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '13px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .header-type3 .header-top .header-message p ',
					],
				],
			)
		);
		
		/*====== Header3 Top Font Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header3_top_font_size',
				'label'       => esc_attr__( 'Top Header Font Typography', 'furnob-core' ),
				'section'     => 'furnob_header3_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '13px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .header-type3 .header-top .site-nav a ',
					],
				],
			)
		);
		
		/*====== Header3 Notification  Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header3_notification_size',
				'label'       => esc_attr__( 'Header Notification Typography', 'furnob-core' ),
				'section'     => 'furnob_header3_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '13px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .header-type3 .header-notification ',
					],
				],
			)
		);
		
		/*====== Header3 Main  Font Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header3_main_font_size',
				'label'       => esc_attr__( 'Header Main Font Typography', 'furnob-core' ),
				'section'     => 'furnob_header3_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '16px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .header-type3 .site-nav.large .menu>li>a ',
					],
				],
			)
		);
		
		/*====== Header3 Main Submenu Font Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header3_main_submenu_font_size',
				'label'       => esc_attr__( 'Header Main Submenu Font Typography', 'furnob-core' ),
				'section'     => 'furnob_header3_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '15px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .site-header.header-type3 .site-nav.large .sub-menu li a ',
					],
				],
			)
		);
		
	/*====== Header 4 Style ================*/	

		/*====== Header 4 Top Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_header4_top_bg_color',
				'label' => esc_attr__( 'Header Top Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  background.', 'furnob-core' ),
				'section' => 'furnob_header4_style_section',
			)
		);
		
		/*====== Header 4 Top Border Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#e5e5e5',
				'settings' => 'furnob_header4_top_border_color',
				'label' => esc_attr__( 'Header Top Border Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  border.', 'furnob-core' ),
				'section' => 'furnob_header4_style_section',
			)
		);
		
		/*====== Header4 Top Notification Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header4_top_notification_color',
				'label' => esc_attr__( 'Header Top Notification Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header4_style_section',
			)
		);
		
		/*====== Header4 Top Notification Button Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#eb7700',
				'settings' => 'furnob_header4_top_notification_button_color',
				'label' => esc_attr__( 'Header Top Notification Button Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header4_style_section',
			)
		);
		
		/*====== Header4 Top Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header4_top_font_color',
				'label' => esc_attr__( 'Header Top Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header4_style_section',
			)
		);
		
		/*====== Header4 Top Font Hover Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header4_top_font_hvrcolor',
				'label' => esc_attr__( 'Header Top Font Hover Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header4_style_section',
			)
		);
		
		/*====== Header 4  Notification Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#3e516a',
				'settings' => 'furnob_header4_notification_bg_color',
				'label' => esc_attr__( 'Header Notification Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  background.', 'furnob-core' ),
				'section' => 'furnob_header4_style_section',
			)
		);
		
		/*====== Header4 Notification Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_header4_notification_font_color',
				'label' => esc_attr__( 'Header Notification Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header4_style_section',
			)
		);
		
		/*====== Header4 Notification Hover Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_header4_notification_font_hvrcolor',
				'label' => esc_attr__( 'Header Notification Hover Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header4_style_section',
			)
		);
		
		/*====== Header 4 Main Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_header4_main_bg_color',
				'label' => esc_attr__( 'Header Main Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  background.', 'furnob-core' ),
				'section' => 'furnob_header4_style_section',
			)
		);
		
		/*====== Header4 Main Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header4_main_font_color',
				'label' => esc_attr__( 'Header Main Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header4_style_section',
			)
		);
		
		/*====== Header4 Main Font Hover Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header4_main_font_hvrcolor',
				'label' => esc_attr__( 'Header Main Font Hover Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header4_style_section',
			)
		);
		
		/*====== Header4 Main Submenu Header Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#eb7700',
				'settings' => 'furnob_header4_main_submenu_header_font_color',
				'label' => esc_attr__( 'Header Main Submenu Header Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header4_style_section',
			)
		);
		
		/*====== Header4 Top Notification  Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header4_top_notification_size',
				'label'       => esc_attr__( 'Top Header Notification Typography', 'furnob-core' ),
				'section'     => 'furnob_header4_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '13px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .header-type4 .header-top .header-message p ',
					],
				],
			)
		);
		
		/*====== Header4 Top Font Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header4_top_font_size',
				'label'       => esc_attr__( 'Top Header Font Typography', 'furnob-core' ),
				'section'     => 'furnob_header4_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '13px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .header-type4 .header-top .site-nav a ',
					],
				],
			)
		);
		
		/*====== Header4 Notification  Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header4_notification_size',
				'label'       => esc_attr__( 'Header Notification Typography', 'furnob-core' ),
				'section'     => 'furnob_header4_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '13px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .header-type4 .header-notification p ',
					],
				],
			)
		);
		
		/*====== Header4 Main  Font Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header4_main_font_size',
				'label'       => esc_attr__( 'Header Main Font Typography', 'furnob-core' ),
				'section'     => 'furnob_header4_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '16px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .header-type4 .site-nav.large .menu>li>a ',
					],
				],
			)
		);
		
		/*====== Header4 Main Submenu Font Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header4_main_submenu_font_size',
				'label'       => esc_attr__( 'Header Main Submenu Font Typography', 'furnob-core' ),
				'section'     => 'furnob_header4_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '15px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .site-header.header-type4 .site-nav.large .sub-menu li a ',
					],
				],
			)
		);
		
	/*====== Header 5 Style ================*/	
	
		/*====== Header 5 Top Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#016a78',
				'settings' => 'furnob_header5_top_bg_color',
				'label' => esc_attr__( 'Header Top Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  background.', 'furnob-core' ),
				'section' => 'furnob_header5_style_section',
			)
		);
		
		/*====== Header 5 Top Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_header5_top_font_color',
				'label' => esc_attr__( 'Header Top Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header5_style_section',
			)
		);
		
		/*====== Header 5 Top Count Date Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_header5_top_date_bg_color',
				'label' => esc_attr__( 'Header Top Count Date Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  background.', 'furnob-core' ),
				'section' => 'furnob_header5_style_section',
			)
		);
		
		/*====== Header 5 Top Count Date Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header5_top_date_font_color',
				'label' => esc_attr__( 'Header Top Count Date Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header5_style_section',
			)
		);
		
		/*====== Header 5 Main Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_header5_main_bg_color',
				'label' => esc_attr__( 'Header Main Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  background.', 'furnob-core' ),
				'section' => 'furnob_header5_style_section',
			)
		);
		
		/*====== Header 5 Main Border Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#e5e5e5',
				'settings' => 'furnob_header5_main_border_color',
				'label' => esc_attr__( 'Header Main Border Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  border.', 'furnob-core' ),
				'section' => 'furnob_header5_style_section',
			)
		);
		
		/*====== Header5 Main Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header5_main_font_color',
				'label' => esc_attr__( 'Header Main Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header5_style_section',
			)
		);
		
		/*====== Header 5 Bottom Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_header5_bottom_bg_color',
				'label' => esc_attr__( 'Header Bottom Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  background.', 'furnob-core' ),
				'section' => 'furnob_header5_style_section',
			)
		);
		
		/*====== Header5 Bottom Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header5_bottom_font_color',
				'label' => esc_attr__( 'Header Bottom Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header5_style_section',
			)
		);
		
		/*====== Header5 Bottom Font Hover Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_header5_bottom_font_hvrcolor',
				'label' => esc_attr__( 'Header Bottom Font Hover Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header5_style_section',
			)
		);
		
		/*====== Header5 Bottom Submenu Header Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#eb7700',
				'settings' => 'furnob_header5_bottom_submenu_header_font_color',
				'label' => esc_attr__( 'Header Bottom Submenu Header Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_header5_style_section',
			)
		);
		
		/*====== Header5 Top Font Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header5_top_font_size',
				'label'       => esc_attr__( 'Top Header Font Typography', 'furnob-core' ),
				'section'     => 'furnob_header5_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '13px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .header-type5 .header-notification p ',
					],
				],
			)
		);
		
		/*====== Header5 Main Menu Font Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header5_main_menu_font_size',
				'label'       => esc_attr__( 'Header Main Menu Font Typography', 'furnob-core' ),
				'section'     => 'furnob_header5_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '14px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .header-type5 .header-main .site-nav a ',
					],
				],
			)
		);
		
		/*====== Header5 Bottom Font Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header5_bottom_font_size',
				'label'       => esc_attr__( 'Header Bottom Font Typography', 'furnob-core' ),
				'section'     => 'furnob_header5_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '16px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .site-header.header-type5 .site-nav.large .menu > li > a ',
					],
				],
			)
		);
		
		/*====== Header5 Bottom Submenu Font Typography ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'furnob_header5_bottom_submenu_font_size',
				'label'       => esc_attr__( 'Header Bottom Submenu Font Typography', 'furnob-core' ),
				'section'     => 'furnob_header5_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '15px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => ' .site-header.header-type5 .site-nav.large .sub-menu li a ',
					],
				],
			)
		);
		
	/*====== Sidebar Menu Style ========*/	
	
		/*====== Sidebar Menu Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#016a78',
				'settings' => 'furnob_sidebar_menu_bg_color',
				'label' => esc_attr__( 'Sidebar Menu Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  background.', 'furnob-core' ),
				'section' => 'furnob_sidebar_menu_style_section',
			)
		);
		
		/*====== Sidebar Menu Border Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#e5e5e5',
				'settings' => 'furnob_sidebar_menu_border_color',
				'label' => esc_attr__( 'Sidebar Menu Border Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for border.', 'furnob-core' ),
				'section' => 'furnob_sidebar_menu_style_section',
			)
		);
		
		/*====== Sidebar Menu Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_sidebar_menu_font_color',
				'label' => esc_attr__( 'Sidebar Menu Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for color.', 'furnob-core' ),
				'section' => 'furnob_sidebar_menu_style_section',
			)
		);
		
		/*====== Sidebar Menu Content Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_sidebar_menu_content_bg_color',
				'label' => esc_attr__( 'Sidebar Menu Content Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  background.', 'furnob-core' ),
				'section' => 'furnob_sidebar_menu_style_section',
			)
		);
		
		/*====== Sidebar Menu Content Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#212529',
				'settings' => 'furnob_sidebar_menu_content_font_color',
				'label' => esc_attr__( 'Sidebar Menu Content Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for color.', 'furnob-core' ),
				'section' => 'furnob_sidebar_menu_style_section',
			)
		);
		
		/*====== Sidebar Menu Content Font Hover Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#eb7700',
				'settings' => 'furnob_sidebar_menu_content_font_hvrcolor',
				'label' => esc_attr__( 'Sidebar Menu Content Font Hover Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for color.', 'furnob-core' ),
				'section' => 'furnob_sidebar_menu_style_section',
			)
		);
	
	/*====== Mobile Menu Style ========*/
		
		/*====== Mobile Menu Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_mobile_menu_bg_color',
				'label' => esc_attr__( 'Mobile Menu Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  background.', 'furnob-core' ),
				'section' => 'furnob_mobile_menu_style_section',
			)
		);
		
		/*====== Mobile Menu Border Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#e5e5e5',
				'settings' => 'furnob_mobile_menu_border_color',
				'label' => esc_attr__( 'Mobile Menu Border Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  border.', 'furnob-core' ),
				'section' => 'furnob_mobile_menu_style_section',
			)
		);
		
		/*====== Mobile Menu Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_mobile_menu_font_color',
				'label' => esc_attr__( 'Mobile Menu Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_mobile_menu_style_section',
			)
		);
		
		/*====== Mobile Menu Bottom Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_mobile_menu_bottom_bg_color',
				'label' => esc_attr__( 'Mobile Menu Bottom Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  background.', 'furnob-core' ),
				'section' => 'furnob_mobile_menu_style_section',
			)
		);
		
		/*====== Mobile Menu Copyright Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_mobile_menu_copyright_font_color',
				'label' => esc_attr__( 'Mobile Menu Copyright Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_mobile_menu_style_section',
			)
		);
	
	/*====== Mobile Bottom Menu Style ========*/	
		
		/*====== Mobile Bottom Menu Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_mobile_bottom_menu_bg_color',
				'label' => esc_attr__( 'Mobile Bottom Menu Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for  color.', 'furnob-core' ),
				'section' => 'furnob_mobile_bottom_menu_style_section',
			)
		);
		
		/*====== Mobile Bottom Menu Icon Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#8a8b8e',
				'settings' => 'furnob_mobile_bottom_menu_icon_color',
				'label' => esc_attr__( 'Mobile Bottom Menu Icon Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for color.', 'furnob-core' ),
				'section' => 'furnob_mobile_bottom_menu_style_section',
			)
		);
		
		/*====== Mobile Bottom Menu Font Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#8a8b8e',
				'settings' => 'furnob_mobile_bottom_menu_font_color',
				'label' => esc_attr__( 'Mobile Bottom Menu Font Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for color.', 'furnob-core' ),
				'section' => 'furnob_mobile_bottom_menu_style_section',
			)
		);
		
	/*====== SHOP ====================================================================================*/
		/*====== Shop Panels ======*/
		Kirki::add_panel (
			'furnob_shop_panel',
			array(
				'title' => esc_html__( 'Shop Settings', 'furnob-core' ),
				'description' => esc_html__( 'You can customize the shop from this panel.', 'furnob-core' ),
			)
		);

		$sections = array (
			'shop_general' => array(
				esc_attr__( 'General', 'furnob-core' ),
				esc_attr__( 'You can customize shop settings.', 'furnob-core' )
			),
			
			'shop_single' => array(
				esc_attr__( 'Product Detail', 'furnob-core' ),
				esc_attr__( 'You can customize the product single settings.', 'furnob-core' )
			),
			
			'shop_banner' => array(
				esc_attr__( 'Banner', 'furnob-core' ),
				esc_attr__( 'You can customize the banner.', 'furnob-core' )
			),

			'free_shipping_bar' => array(
				esc_attr__( 'Free Shipping Bar ', 'furnob-core' ),
				esc_attr__( 'You can customize the free shipping bar settings.', 'furnob-core' )
			),
			
		);

		foreach ( $sections as $section_id => $section ) {
			$section_args = array(
				'title' => $section[0],
				'description' => $section[1],
				'panel' => 'furnob_shop_panel',
			);

			if ( isset( $section[2] ) ) {
				$section_args['type'] = $section[2];
			}

			Kirki::add_section( 'furnob_' . str_replace( '-', '_', $section_id ) . '_section', $section_args );
		}
		
		/*====== Shop Layouts ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'radio-buttonset',
				'settings' => 'furnob_shop_layout',
				'label' => esc_attr__( 'Layout', 'furnob' ),
				'description' => esc_attr__( 'You can choose a layout for the shop.', 'furnob' ),
				'section' => 'furnob_shop_general_section',
				'default' => 'left-sidebar',
				'choices' => array(
					'left-sidebar' => esc_attr__( 'Left Sidebar', 'furnob' ),
					'full-width' => esc_attr__( 'Full Width', 'furnob' ),
					'right-sidebar' => esc_attr__( 'Right Sidebar', 'furnob' ),
				),
			)
		);

		/*====== Shop Width ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'radio-buttonset',
				'settings' => 'furnob_shop_width',
				'label' => esc_attr__( 'Shop Page Width', 'furnob' ),
				'description' => esc_attr__( 'You can choose a layout for the shop page.', 'furnob' ),
				'section' => 'furnob_shop_general_section',
				'default' => 'boxed',
				'choices' => array(
					'boxed' => esc_attr__( 'Boxed', 'furnob' ),
					'wide' => esc_attr__( 'Wide', 'furnob' ),
				),
			)
		);

		furnob_customizer_add_field(
			array (
			'type'        => 'radio-buttonset',
			'settings'    => 'furnob_product_box_type',
			'label'       => esc_html__( 'Shop Product Box Type', 'furnob-core' ),
			'section'     => 'furnob_shop_general_section',
			'default'     => 'type1',
			'priority'    => 10,
			'choices'     => array(
				'type1' => esc_attr__( 'Type 1', 'furnob-core' ),
				'type2' => esc_attr__( 'Type 2', 'furnob-core' ),
				'type3' => esc_attr__( 'Type 3', 'furnob-core' ),
			),
			) 
		);

		furnob_customizer_add_field(
			array (
			'type'        => 'radio-buttonset',
			'settings'    => 'furnob_paginate_type',
			'label'       => esc_html__( 'Pagination Type', 'furnob-core' ),
			'section'     => 'furnob_shop_general_section',
			'default'     => 'default',
			'priority'    => 10,
			'choices'     => array(
				'default' => esc_attr__( 'Default', 'furnob-core' ),
				'loadmore' => esc_attr__( 'Load More', 'furnob-core' ),
				'infinite' => esc_attr__( 'Infinite', 'furnob-core' ),
			),
			) 
		);

		/*====== Ajax on Shop Page ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_ajax_on_shop',
				'label' => esc_attr__( 'Ajax on Shop Page', 'furnob-core' ),
				'description' => esc_attr__( 'Disable or Enable Ajax for the shop page.', 'furnob-core' ),
				'section' => 'furnob_shop_general_section',
				'default' => '0',
			)
		);

		/*====== Recently Viewed Products ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_recently_viewed_products',
				'label' => esc_attr__( 'Recently Viewed Products', 'furnob-core' ),
				'description' => esc_attr__( 'Disable or Enable Recently Viewed Products.', 'furnob-core' ),
				'section' => 'furnob_shop_general_section',
				'default' => '0',
			)
		);
		
		/*====== Grid-List Toggle ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_grid_list_view',
				'label' => esc_attr__( 'Grid List View', 'furnob-core' ),
				'description' => esc_attr__( 'Disable or Enable grid list view on shop page.', 'furnob-core' ),
				'section' => 'furnob_shop_general_section',
				'default' => '0',
			)
		);
		
		/*====== Atrribute Swatches ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_attribute_swatches',
				'label' => esc_attr__( 'Attribute Swatches', 'furnob-core' ),
				'description' => esc_attr__( 'Disable or Enable the attribute types (Color - Button - Images).', 'furnob-core' ),
				'section' => 'furnob_shop_general_section',
				'default' => '0',
			)
		);

		/*====== Quick View Toggle ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_quick_view_button',
				'label' => esc_attr__( 'Quick View Button', 'furnob' ),
				'description' => esc_attr__( 'You can choose status of the quick view button.', 'furnob' ),
				'section' => 'furnob_shop_general_section',
				'default' => '0',
			)
		);
		
		/*====== Wishlist Toggle ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_wishlist_button',
				'label' => esc_attr__( 'Custom Wishlist Button', 'furnob-core' ),
				'description' => esc_attr__( 'You can choose status of the wishlist button.', 'furnob-core' ),
				'section' => 'furnob_shop_general_section',
				'default' => '0',
			)
		);
		
		/*====== Shop Compare Toggle  ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_compare_button',
				'label' => esc_attr__( 'Compare', 'furnob' ),
				'description' => esc_attr__( 'You can choose status of the compare button.', 'furnob' ),
				'section' => 'furnob_shop_general_section',
				'default' => '0',
			)
		);

		/*====== Ajax Notice Shop ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_shop_notice_ajax_addtocart',
				'label' => esc_attr__( 'Ajax Notice', 'furnob' ),
				'description' => esc_attr__( 'You can choose status of the ajax notice feature.', 'furnob' ),
				'section' => 'furnob_shop_general_section',
				'default' => '0',
			)
		);

		/*====== Mobile Bottom Menu======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_mobile_bottom_menu',
				'label' => esc_attr__( 'Mobile Bottom Menu', 'furnob-core' ),
				'description' => esc_attr__( 'Disable or Enable the bottom menu on mobile.', 'furnob-core' ),
				'section' => 'furnob_shop_general_section',
				'default' => '0',
			)
		);

		/*====== Mobile Bottom Menu Edit Toggle======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_mobile_bottom_menu_edit_toggle',
				'label' => esc_attr__( 'Mobile Bottom Menu Edit', 'furnob' ),
				'description' => esc_attr__( 'Edit the mobile bottom menu.', 'furnob' ),
				'section' => 'furnob_shop_general_section',
				'default' => '0',
				'required' => array(
					array(
					  'setting'  => 'furnob_mobile_bottom_menu',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
				
			)
			
		);
		
		/*====== Mobile Menu Repeater ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'repeater',
				'settings' => 'furnob_mobile_bottom_menu_edit',
				'label' => esc_attr__( 'Mobile Bottom Menu Edit', 'furnob-core' ),
				'description' => esc_attr__( 'Edit the mobile bottom menu.', 'furnob-core' ),
				'section' => 'furnob_shop_general_section',
				'required' => array(
					array(
					  'setting'  => 'furnob_mobile_bottom_menu_edit_toggle',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
				'fields' => array(
					'mobile_menu_type' => array(
						'type' => 'select',
						'label' => esc_attr__( 'Select Type', 'furnob' ),
						'description' => esc_attr__( 'You can select a type', 'furnob' ),
						'default' => 'default',
						'choices' => array(
							'default' => esc_attr__( 'Default', 'furnob-core' ),
							'search' => esc_attr__( 'Search', 'furnob-core' ),
							'filter' => esc_attr__( 'Filter', 'furnob-core' ),
							'category' => esc_attr__( 'category', 'furnob-core' ),
						),
					),
				
					'mobile_menu_icon' => array(
						'type' => 'text',
						'label' => esc_attr__( 'Icon', 'furnob' ),
						'description' => esc_attr__( 'You can set an icon. for example; "store"', 'furnob' ),
					),
					'mobile_menu_text' => array(
						'type' => 'text',
						'label' => esc_attr__( ' Text', 'furnob' ),
						'description' => esc_attr__( 'You can enter a text.', 'furnob' ),
					),
					'mobile_menu_url' => array(
						'type' => 'text',
						'label' => esc_attr__( 'URL', 'furnob-core' ),
						'description' => esc_attr__( 'You can set url for the item.', 'furnob-core' ),
					),
				),
				
			)
		);
		
		/*====== Catalog Mode - Disable Add to Cart ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_catalog_mode',
				'label' => esc_attr__( 'Catalog Mode', 'furnob-core' ),
				'description' => esc_attr__( 'Disable Add to Cart button on the shop page.', 'furnob-core' ),
				'section' => 'furnob_shop_general_section',
				'default' => '0',
			)
		);

		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_stock_quantity',
				'label' => esc_attr__( 'Stock Quantity', 'furnob' ),
				'description' => esc_attr__( 'Show stock quantity on the label.', 'furnob' ),
				'section' => 'furnob_shop_general_section',
				'default' => '0',
			)
		);

		/*====== Product Image Size ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'dimensions',
				'settings' => 'furnob_product_image_size',
				'label' => esc_attr__( 'Product Image Size', 'furnob-core' ),
				'description' => esc_attr__( 'You can set size of the product image for the shop page.', 'furnob-core' ),
				'section' => 'furnob_shop_general_section',
				'default' => array(
					'width' => '',
					'height' => '',
				),
			)
		);

		/*====== Shop Single Image Column ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'slider',
				'settings'    => 'furnob_shop_single_image_column',
				'label'       => esc_html__( 'Image Column', 'furnob-core' ),
				'section'     => 'furnob_shop_single_section',
				'default'     => 6,
				'transport'   => 'auto',
				'choices'     => [
					'min'  => 3,
					'max'  => 12,
					'step' => 1,
				],
			)
		);

		/*====== Shop Single Image Zoom  ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_single_image_zoom',
				'label' => esc_attr__( 'Image Zoom', 'furnob-core' ),
				'section' => 'furnob_shop_single_section',
				'default' => '0',
			)
		);

		/*====== Shop Single Ajax Add To Cart ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_shop_single_ajax_addtocart',
				'label' => esc_attr__( 'Ajax Add to Cart', 'furnob' ),
				'section' => 'furnob_shop_single_section',
				'default' => '0',
			)
		);

		/*====== Product360 View ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_shop_single_product360',
				'label' => esc_attr__( 'Product360 View', 'furnob' ),
				'section' => 'furnob_shop_single_section',
				'default' => '0',
			)
		);
		
		/*====== Mobile Sticky Single Cart ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_mobile_single_sticky_cart',
				'label' => esc_attr__( 'Mobile Sticky Add to Cart', 'furnob-core' ),
				'description' => esc_attr__( 'Disable or Enable sticky cart button on mobile.', 'furnob-core' ),
				'section' => 'furnob_shop_single_section',
				'default' => '0',
			)
		);

		/*====== Shop Single Social Share ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_shop_social_share',
				'label' => esc_attr__( 'Social Share (Product Detail)', 'furnob' ),
				'section' => 'furnob_shop_single_section',
				'default' => '0',
			)
		);
		
		/*====== Shop Single Social Share ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'multicheck',
				'settings'    => 'furnob_shop_single_share',
				'section'     => 'furnob_shop_single_section',
				'default'     => array('facebook','twitter', 'pinterest', 'linkedin', 'whatsapp'  ),
				'priority'    => 10,
				'choices'     => [
					'facebook'  => esc_html__( 'Facebook', 	'furnob-core' ),
					'twitter' 	=> esc_html__( 'Twitter', 	'furnob-core' ),
					'pinterest' => esc_html__( 'Pinterest', 'furnob-core' ),
					'linkedin'  => esc_html__( 'Linkedin', 	'furnob-core' ),
					'whatsapp'  => esc_html__( 'Whatsapp', 	'furnob-core' ),
				],
				'required' => array(
					array(
					  'setting'  => 'furnob_shop_social_share',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);

		/*====== Product Gallery Columns ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'select',
				'settings' => 'furnob_shop_single_gallery_columns',
				'label' => esc_attr__( 'Gallery Columns', 'furnob' ),
				'section' => 'furnob_shop_single_section',
				'default' => '7',
				'choices' => array(
					'8' => esc_attr__( '8 Columns', 'furnob' ),
					'7' => esc_attr__( '7 Columns', 'furnob' ),
					'6' => esc_attr__( '6 Columns', 'furnob' ),
					'5' => esc_attr__( '5 Columns', 'furnob' ),
					'4' => esc_attr__( '4 Columns', 'furnob' ),
					'3' => esc_attr__( '3 Columns', 'furnob' ),
					'2' => esc_attr__( '2 Columns', 'furnob' ),
				),
			)
		);

		/*====== Product Related Post Column ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'select',
				'settings' => 'furnob_shop_related_post_column',
				'label' => esc_attr__( 'Related Post Column', 'furnob' ),
				'description' => esc_attr__( 'You can control related post column with this option.', 'furnob' ),
				'section' => 'furnob_shop_single_section',
				'default' => '4',
				'choices' => array(
					'6' => esc_attr__( '6 Columns', 'furnob' ),
					'5' => esc_attr__( '5 Columns', 'furnob' ),
					'4' => esc_attr__( '4 Columns', 'furnob' ),
					'3' => esc_attr__( '3 Columns', 'furnob' ),
					'2' => esc_attr__( '2 Columns', 'furnob' ),
				),
			)
		);
		
		/*====== Related By Tags ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_related_by_tags',
				'label' => esc_attr__( 'Related Products with Tags', 'furnob-core' ),
				'description' => esc_attr__( 'Display the related products by tags.', 'furnob-core' ),
				'section' => 'furnob_shop_single_section',
				'default' => '0',
			)
		);
		
		/*====== Re-Order Product Detail ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'sortable',
				'settings' => 'furnob_shop_single_reorder',
				'label' => esc_attr__( 'Re-order Product Summary', 'furnob' ),
				'description' => esc_attr__( 'Please save the changes and refresh the page once. Live preview is not available for the option.', 'furnob' ),
				'section' => 'furnob_shop_single_section',
				'default'     => [
					'woocommerce_template_single_title',
					'woocommerce_template_single_rating',
					'woocommerce_template_single_excerpt',
					'woocommerce_template_single_price',
					'woocommerce_template_single_add_to_cart',
					'furnob_single_extra_options',
					'woocommerce_template_single_meta',
					'furnob_social_share',
				],
				'choices'     => [
					'woocommerce_template_single_title' 		=> esc_html__( 'Title',  		'furnob' ),
					'woocommerce_template_single_rating' 		=> esc_html__( 'Rating', 		'furnob' ),
					'woocommerce_template_single_excerpt' 		=> esc_html__( 'Excerpt', 		'furnob' ),
					'woocommerce_template_single_price' 		=> esc_html__( 'Price', 		'furnob' ),
					'woocommerce_template_single_add_to_cart' 	=> esc_html__( 'Add to Cart', 	'furnob' ),
					'furnob_single_extra_options' 				=> esc_html__( 'Extra Options', 'furnob' ),
					'woocommerce_template_single_meta' 			=> esc_html__( 'Meta', 			'furnob' ),
					'furnob_social_share' 						=> esc_html__( 'Share', 		'furnob' ),
				],
			)
		);
		
		/*====== Shop Banner Toggle ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_shop_banner_toggle',
				'label' => esc_attr__( 'Shop Banner', 'furnob' ),
				'description' => esc_attr__( 'Disable or Enable shop banner.', 'furnob' ),
				'section' => 'furnob_shop_banner_section',
				'default' => '0',
			)
		);
		
		/*====== Shop Banner Image ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'image',
				'settings' => 'furnob_shop_banner_image',
				'label' => esc_attr__( 'Image', 'furnob-core' ),
				'description' => esc_attr__( 'You can upload an image.', 'furnob-core' ),
				'section' => 'furnob_shop_banner_section',
				'choices' => array(
					'save_as' => 'id',
				),
				'required' => array(
					array(
					  'setting'  => 'furnob_shop_banner_toggle',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Banner Repeater For each category ======*/
		add_action( 'init', function() {
			furnob_customizer_add_field (
				array(
					'type' => 'repeater',
					'settings' => 'furnob_shop_banner_each_category',
					'label' => esc_attr__( 'Banner For Categories', 'furnob-core' ),
					'description' => esc_attr__( 'You can set banner for each category.', 'furnob-core' ),
					'section' => 'furnob_shop_banner_section',
					'fields' => array(
						
						'category_id' => array(
							'type'        => 'select',
							'label'       => esc_html__( 'Select Category', 'furnob-core' ),
							'description' => esc_html__( 'Set a category', 'furnob-core' ),
							'priority'    => 10,
							'choices'     => Kirki_Helper::get_terms( array('taxonomy' => 'product_cat') )
						),
						
						'category_image' =>  array(
							'type' => 'image',
							'label' => esc_attr__( 'Image', 'furnob-core' ),
							'description' => esc_attr__( 'You can upload an image.', 'furnob-core' ),
						),
					),
				)
			);
		} );
		
		/*====== Shop Banner Title ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'textarea',
				'settings' => 'furnob_shop_banner_title',
				'label' => esc_attr__( 'Set Title', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a title.', 'furnob-core' ),
				'section' => 'furnob_shop_banner_section',
				'default' => '',
				'required' => array(
					array(
					  'setting'  => 'furnob_shop_banner_toggle',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);

	/*====== Free Shipping Settings =======================================================*/
	
		/*====== Free Shipping ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_free_shipping',
				'label' => esc_attr__( 'Free shipping bar', 'furnob-core' ),
				'section' => 'furnob_free_shipping_bar_section',
				'default' => '0',
			)
		);
		
		/*====== Free Shipping Goal Amount ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'text',
				'settings' => 'shipping_progress_bar_amount',
				'label' => esc_attr__( 'Goal Amount', 'furnob-core' ),
				'description' => esc_attr__( 'Amount to reach 100% defined in your currency absolute value. For example: 300', 'furnob-core' ),
				'section' => 'furnob_free_shipping_bar_section',
				'default' => '100',
				'required' => array(
					array(
					  'setting'  => 'furnob_free_shipping',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Free Shipping Location Cart Page ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'shipping_progress_bar_location_card_page',
				'label' => esc_attr__( 'Cart page', 'furnob-core' ),
				'section' => 'furnob_free_shipping_bar_section',
				'default' => '0',
				'required' => array(
					array(
					  'setting'  => 'furnob_free_shipping',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Free Shipping Location Mini cart ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'shipping_progress_bar_location_mini_cart',
				'label' => esc_attr__( 'Mini cart', 'furnob-core' ),
				'section' => 'furnob_free_shipping_bar_section',
				'default' => '0',
				'required' => array(
					array(
					  'setting'  => 'furnob_free_shipping',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Free Shipping Location Checkout page ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'shipping_progress_bar_location_checkout',
				'label' => esc_attr__( 'Checkout page', 'furnob-core' ),
				'section' => 'furnob_free_shipping_bar_section',
				'default' => '0',
				'required' => array(
					array(
					  'setting'  => 'furnob_free_shipping',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Free Shipping Message Initial ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'textarea',
				'settings' => 'shipping_progress_bar_message_initial',
				'label' => esc_attr__( 'Initial Message', 'furnob-core' ),
				'description' => esc_attr__( 'Message to show before reaching the goal. Use shortcode [remainder] to display the amount left to reach the minimum.', 'furnob-core' ),
				'section' => 'furnob_free_shipping_bar_section',
				'default' => 'Add [remainder] to cart and get free shipping!',
				'required' => array(
					array(
					  'setting'  => 'furnob_free_shipping',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Free Shipping Message Success ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'textarea',
				'settings' => 'shipping_progress_bar_message_success',
				'label' => esc_attr__( 'Success message', 'furnob-core' ),
				'description' => esc_attr__( 'Message to show after reaching 100%.', 'furnob-core' ),
				'section' => 'furnob_free_shipping_bar_section',
				'default' => 'Your order qualifies for free shipping!',
				'required' => array(
					array(
					  'setting'  => 'furnob_free_shipping',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		

	/*====== Blog Settings =======================================================*/
		/*====== Layouts ======*/
		
		furnob_customizer_add_field (
			array(
				'type' => 'radio-buttonset',
				'settings' => 'furnob_blog_layout',
				'label' => esc_attr__( 'Layout', 'furnob' ),
				'description' => esc_attr__( 'You can choose a layout.', 'furnob' ),
				'section' => 'furnob_blog_settings_section',
				'default' => 'right-sidebar',
				'choices' => array(
					'left-sidebar' => esc_attr__( 'Left Sidebar', 'furnob' ),
					'full-width' => esc_attr__( 'Full Width', 'furnob' ),
					'right-sidebar' => esc_attr__( 'Right Sidebar', 'furnob' ),
				),
			)
		);
		
		/*====== Main color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#eb7700',
				'settings' => 'furnob_main_color',
				'label' => esc_attr__( 'Main Color', 'furnob' ),
				'description' => esc_attr__( 'You can customize the main color.', 'furnob' ),
				'section' => 'furnob_main_color_section',
			)
		);

		/*====== Secondary color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#016a78',
				'settings' => 'furnob_second_color',
				'label' => esc_attr__( 'Second Color', 'furnob' ),
				'description' => esc_attr__( 'You can customize the secondary color.', 'furnob' ),
				'section' => 'furnob_main_color_section',
			)
		);
		
		/*======  Color Success ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#47b486',
				'settings' => 'furnob_success_color',
				'label' => esc_attr__( 'Color Success', 'furnob' ),
				'description' => esc_attr__( 'You can customize the Success color.', 'furnob' ),
				'section' => 'furnob_main_color_section',
			)
		);
		
		/*======  Color Success Dark ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#287c58',
				'settings' => 'furnob_success_dark_color',
				'label' => esc_attr__( 'Color Success Dark', 'furnob' ),
				'description' => esc_attr__( 'You can customize the success dark color.', 'furnob' ),
				'section' => 'furnob_main_color_section',
			)
		);
		
		/*======  Color Success Light ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#c9e3d8',
				'settings' => 'furnob_success_light_color',
				'label' => esc_attr__( 'Color Success Light', 'furnob' ),
				'description' => esc_attr__( 'You can customize the success light color.', 'furnob' ),
				'section' => 'furnob_main_color_section',
			)
		);
		
		/*====== Color Danger ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#f4344f',
				'settings' => 'furnob_danger_color',
				'label' => esc_attr__( 'Color Danger', 'furnob-core' ),
				'description' => esc_attr__( 'You can customize the color danger.', 'furnob-core' ),
				'section' => 'furnob_main_color_section',
			)
		);
		
		/*====== Color Warning ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#f5af28',
				'settings' => 'furnob_warning_color',
				'label' => esc_attr__( 'Color Warning', 'furnob-core' ),
				'description' => esc_attr__( 'You can customize the color warning.', 'furnob-core' ),
				'section' => 'furnob_main_color_section',
			)
		);
		
		/*====== Color Warning Light======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#f4e3d1',
				'settings' => 'furnob_warning_light_color',
				'label' => esc_attr__( 'Color Warning Light', 'furnob-core' ),
				'description' => esc_attr__( 'You can customize the color warning light.', 'furnob-core' ),
				'section' => 'furnob_main_color_section',
			)
		);
		
		/*====== Color Light======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#bbb',
				'settings' => 'furnob_light_color',
				'label' => esc_attr__( 'Color Light', 'furnob-core' ),
				'description' => esc_attr__( 'You can customize the color light.', 'furnob-core' ),
				'section' => 'furnob_main_color_section',
			)
		);

	/*====== Elementor Templates =======================================================*/
		/*====== Before Shop Elementor Templates ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'select',
				'settings'    => 'furnob_before_main_shop_elementor_template',
				'label'       => esc_html__( 'Before Shop Elementor Template', 'furnob-core' ),
				'section'     => 'furnob_elementor_templates_section',
				'default'     => '',
				'placeholder' => esc_html__( 'Select a template from elementor templates ', 'furnob-core' ),
				'choices'     => furnob_get_elementorTemplates('section'),
				
			)
		);
		
		/*====== After Shop Elementor Templates ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'select',
				'settings'    => 'furnob_after_main_shop_elementor_template',
				'label'       => esc_html__( 'After Shop Elementor Template', 'furnob-core' ),
				'section'     => 'furnob_elementor_templates_section',
				'default'     => '',
				'placeholder' => esc_html__( 'Select a template from elementor templates ', 'furnob-core' ),
				'choices'     => furnob_get_elementorTemplates('section'),
				
			)
		);
		
		/*====== Before Header Elementor Templates ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'select',
				'settings'    => 'furnob_before_main_header_elementor_template',
				'label'       => esc_html__( 'Before Header Elementor Template', 'furnob-core' ),
				'section'     => 'furnob_elementor_templates_section',
				'default'     => '',
				'placeholder' => esc_html__( 'Select a template from elementor templates, If you want to show any content before products ', 'furnob-core' ),
				'choices'     => furnob_get_elementorTemplates('section'),
				
			)
		);
	
		/*====== After Header Elementor Templates ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'select',
				'settings'    => 'furnob_after_main_header_elementor_template',
				'label'       => esc_html__( 'After Header Elementor Template', 'furnob-core' ),
				'section'     => 'furnob_elementor_templates_section',
				'default'     => '',
				'placeholder' => esc_html__( 'Select a template from elementor templates ', 'furnob-core' ),
				'choices'     => furnob_get_elementorTemplates('section'),
				
			)
		);
		
		/*====== Before Footer Elementor Template ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'select',
				'settings'    => 'furnob_before_main_footer_elementor_template',
				'label'       => esc_html__( 'Before Footer Elementor Template', 'furnob-core' ),
				'section'     => 'furnob_elementor_templates_section',
				'default'     => '',
				'placeholder' => esc_html__( 'Select a template from elementor templates, If you want to show any content before products ', 'furnob-core' ),
				'choices'     => furnob_get_elementorTemplates('section'),
				
			)
		);
		
		/*====== After Footer Elementor  Template ======*/
		furnob_customizer_add_field (
			array(
				'type'        => 'select',
				'settings'    => 'furnob_after_main_footer_elementor_template',
				'label'       => esc_html__( 'After Footer Elementor Templates', 'furnob-core' ),
				'section'     => 'furnob_elementor_templates_section',
				'default'     => '',
				'placeholder' => esc_html__( 'Select a template from elementor templates, If you want to show any content before products ', 'furnob-core' ),
				'choices'     => furnob_get_elementorTemplates('section'),
				
			)
		);

		/*====== Templates Repeater For each category ======*/
		add_action( 'init', function() {
			furnob_customizer_add_field (
				array(
					'type' => 'repeater',
					'settings' => 'furnob_elementor_template_each_shop_category',
					'label' => esc_attr__( 'Template For Categories', 'furnob-core' ),
					'description' => esc_attr__( 'You can set template for each category.', 'furnob-core' ),
					'section' => 'furnob_elementor_templates_section',
					'fields' => array(
						
						'category_id' => array(
							'type'        => 'select',
							'label'       => esc_html__( 'Select Category', 'furnob-core' ),
							'description' => esc_html__( 'Set a category', 'furnob-core' ),
							'priority'    => 10,
							'default'     => '',
							'choices'     => Kirki_Helper::get_terms( array('taxonomy' => 'product_cat') )
						),
						
						'furnob_before_main_shop_elementor_template_category' => array(
							'type'        => 'select',
							'label'       => esc_html__( 'Before Shop Elementor Template', 'furnob-core' ),
							'choices'     => furnob_get_elementorTemplates('section'),
							'default'     => '',
							'placeholder' => esc_html__( 'Select a template from elementor templates, If you want to show any content before products ', 'furnob-core' ),
						),
						
						'furnob_after_main_shop_elementor_template_category' => array(
							'type'        => 'select',
							'label'       => esc_html__( 'After Shop Elementor Template', 'furnob-core' ),
							'choices'     => furnob_get_elementorTemplates('section'),
						),
						
						'furnob_before_main_header_elementor_template_category' => array(
							'type'        => 'select',
							'label'       => esc_html__( 'Before Header Elementor Template', 'furnob-core' ),
							'choices'     => furnob_get_elementorTemplates('section'),
						),
						
						'furnob_after_main_header_elementor_template_category' => array(
							'type'        => 'select',
							'label'       => esc_html__( 'After Header Elementor Template', 'furnob-core' ),
							'choices'     => furnob_get_elementorTemplates('section'),
						),
						
						'furnob_before_main_footer_elementor_template_category' => array(
							'type'        => 'select',
							'label'       => esc_html__( 'Before Footer Elementor Template', 'furnob-core' ),
							'choices'     => furnob_get_elementorTemplates('section'),
						),
						
						'furnob_after_main_footer_elementor_template_category' => array(
							'type'        => 'select',
							'label'       => esc_html__( 'After Footer Elementor Template', 'furnob-core' ),
							'choices'     => furnob_get_elementorTemplates('section'),
						),
						

					),
				)
			);
		} );

		/*====== Map Settings ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'text',
				'settings' => 'furnob_mapapi',
				'label' => esc_attr__( 'Google Map Api key', 'furnob' ),
				'description' => esc_attr__( 'Add your google map api key', 'furnob' ),
				'section' => 'furnob_map_settings_section',
				'default' => '',
			)
		);
		
	/*====== Footer ======*/
		/*====== Footer Panels ======*/
		Kirki::add_panel (
			'furnob_footer_panel',
			array(
				'title' => esc_html__( 'Footer Settings', 'furnob' ),
				'description' => esc_html__( 'You can customize the footer from this panel.', 'furnob' ),
			)
		);

		$sections = array (
			'footer_featured_box' => array(
				esc_attr__( 'Featured Box', 'furnob-core' ),
				esc_attr__( 'You can customize the featured box section.', 'furnob-core' )
			),
			'footer_subscribe' => array(
				esc_attr__( 'Subscribe', 'furnob' ),
				esc_attr__( 'You can customize the subscribe area.', 'furnob' )
			),
			'footer_extra' => array(
				esc_attr__( 'Footer Extra', 'furnob' ),
				esc_attr__( 'You can customize the footer extra section.', 'furnob' )
			),
			'footer_general' => array(
				esc_attr__( 'Footer General', 'furnob' ),
				esc_attr__( 'You can customize the footer settings.', 'furnob-core' )
			),
			'footer_style' => array(
				esc_attr__( 'Footer Style', 'furnob' ),
				esc_attr__( 'You can customize the footer settings.', 'furnob-core' )
			),
		);

		foreach ( $sections as $section_id => $section ) {
			$section_args = array(
				'title' => $section[0],
				'description' => $section[1],
				'panel' => 'furnob_footer_panel',
			);

			if ( isset( $section[2] ) ) {
				$section_args['type'] = $section[2];
			}

			Kirki::add_section( 'furnob_' . str_replace( '-', '_', $section_id ) . '_section', $section_args );
		}
		
		
		/*====== Featured Box ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'repeater',
				'settings' => 'furnob_footer_featured_box',
				'label' => esc_attr__( 'Featured Box', 'furnob-core' ),
				'description' => esc_attr__( 'You can create featured box.', 'furnob-core' ),
				'section' => 'furnob_footer_featured_box_section',
				'fields' => array(
					'featured_icon' => array(
						'type' => 'text',
						'label' => esc_attr__( 'Featured Icon', 'furnob-core' ),
						'description' => esc_attr__( 'set an icon. for example: klbth-icon-screen', 'furnob-core' ),
					),
					'featured_title' => array(
						'type' => 'text',
						'label' => esc_attr__( 'Featured Title', 'furnob-core' ),
						'description' => esc_attr__( 'You can enter a text.', 'furnob-core' ),
					),
					
					'featured_content' => array(
						'type' => 'textarea',
						'label' => esc_attr__( 'Featured Content', 'furnob-core' ),
						'description' => esc_attr__( 'You can enter a text.', 'furnob-core' ),
					),
				),
			)
		);
		
		/*====== Featured Box Icon Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_featured_box_icon_color',
				'label' => esc_attr__( 'Featured Box Icon Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for color.', 'furnob-core' ),
				'section' => 'furnob_footer_featured_box_section',
			)
		);
		
		/*====== Featured Box Title Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_featured_box_title_color',
				'label' => esc_attr__( 'Featured Box Title Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for color.', 'furnob-core' ),
				'section' => 'furnob_footer_featured_box_section',
			)
		);
		
		/*====== Featured Box Description Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#8a8b8e',
				'settings' => 'furnob_featured_box_desc_color',
				'label' => esc_attr__( 'Featured Box Description Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for color.', 'furnob-core' ),
				'section' => 'furnob_footer_featured_box_section',
			)
		);

		
		/*====== Subcribe Toggle ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_footer_subscribe_area',
				'label' => esc_attr__( 'Subcribe', 'furnob' ),
				'description' => esc_attr__( 'Disable or Enable subscribe section.', 'furnob' ),
				'section' => 'furnob_footer_subscribe_section',
				'default' => '0',
			)
		);
		
		/*====== Subcribe FORM ID======*/
		furnob_customizer_add_field (
			array(
				'type' => 'text',
				'settings' => 'furnob_footer_subscribe_formid',
				'label' => esc_attr__( 'Subscribe Form Id.', 'furnob' ),
				'description' => esc_attr__( 'You can find the form id in Dashboard > Mailchimp For Wp > Form.', 'furnob' ),
				'section' => 'furnob_footer_subscribe_section',
				'default' => '',
				'required' => array(
					array(
					  'setting'  => 'furnob_footer_subscribe_area',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Subscribe Title ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'text',
				'settings' => 'furnob_footer_subscribe_title',
				'label' => esc_attr__( 'Title', 'furnob' ),
				'section' => 'furnob_footer_subscribe_section',
				'default' => '',
				'required' => array(
					array(
					  'setting'  => 'furnob_footer_subscribe_area',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Subscribe Subtitle ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'textarea',
				'settings' => 'furnob_footer_subscribe_subtitle',
				'label' => esc_attr__( 'Subtitle', 'furnob' ),
				'section' => 'furnob_footer_subscribe_section',
				'default' => '',
				'required' => array(
					array(
					  'setting'  => 'furnob_footer_subscribe_area',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Subscribe Desc ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'textarea',
				'settings' => 'furnob_footer_subscribe_desc',
				'label' => esc_attr__( 'Description', 'furnob' ),
				'section' => 'furnob_footer_subscribe_section',
				'default' => '',
				'required' => array(
					array(
					  'setting'  => 'furnob_footer_subscribe_area',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Footer Subscribe Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#faf8f4',
				'settings' => 'furnob_footer_subscribe_bg_color',
				'label' => esc_attr__( 'Subscribe Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for background.', 'furnob-core' ),
				'section' => 'furnob_footer_subscribe_section',
			)
		);
		
		
		/*====== Footer Subscribe Title Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_footer_subscribe_title_color',
				'label' => esc_attr__( 'Subscribe Title Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for color.', 'furnob-core' ),
				'section' => 'furnob_footer_subscribe_section',
			)
		);
		
		/*====== Footer Subscribe Subtitle Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#eb7700',
				'settings' => 'furnob_footer_subscribe_subtitle_color',
				'label' => esc_attr__( 'Subscribe Subtitle Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for color.', 'furnob-core' ),
				'section' => 'furnob_footer_subscribe_section',
			)
		);
		
		/*====== Footer Subscribe Description Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_footer_subscribe_desc_color',
				'label' => esc_attr__( 'Subscribe Description Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for color.', 'furnob-core' ),
				'section' => 'furnob_footer_subscribe_section',
			)
		);
		
		
		/*====== Footer Extra Left Text ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'textarea',
				'settings' => 'furnob_footer_extra_left_content',
				'label' => esc_attr__( 'Left Content', 'furnob-core' ),
				'section' => 'furnob_footer_extra_section',
				'default' => '',
			)
		);
		
		/*====== Footer Extra Image ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'image',
				'settings' => 'furnob_footer_extra_image',
				'label' => esc_attr__( 'Right Image', 'furnob-core' ),
				'description' => esc_attr__( 'You can upload an image.', 'furnob-core' ),
				'section' => 'furnob_footer_extra_section',
				'choices' => array(
					'save_as' => 'id',
				),
			)
		);
		
		/*====== Footer Extra Right Text ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'textarea',
				'settings' => 'furnob_footer_extra_right_content',
				'label' => esc_attr__( 'Right Content', 'furnob' ),
				'section' => 'furnob_footer_extra_section',
				'default' => '',
			)
		);
		
		/*====== Footer Extra Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_footer_extra_bg_color',
				'label' => esc_attr__( 'Footer Extra Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for background.', 'furnob-core' ),
				'section' => 'furnob_footer_extra_section',
			)
		);
		
		/*====== Footer Extra Title Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_footer_extra_title_color',
				'label' => esc_attr__( 'Footer Extra Title Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for color.', 'furnob-core' ),
				'section' => 'furnob_footer_extra_section',
			)
		);
		
		/*====== Footer Extra Subtitle Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_footer_extra_subtitle_color',
				'label' => esc_attr__( 'Footer Extra Subtitle Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for color.', 'furnob-core' ),
				'section' => 'furnob_footer_extra_section',
			)
		);
		
		/*====== Copyright ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'textarea',
				'settings' => 'furnob_copyright',
				'label' => esc_attr__( 'Copyright', 'furnob' ),
				'description' => esc_attr__( 'You can set a copyright text for the footer.', 'furnob' ),
				'section' => 'furnob_footer_general_section',
				'default' => '',
			)
		);
		
		/*====== Payment Icons ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'repeater',
				'settings' => 'furnob_footer_payment_icons',
				'label' => esc_attr__( 'Payment Icons', 'furnob-core' ),
				'description' => esc_attr__( 'Edit the payment icons.', 'furnob-core' ),
				'section' => 'furnob_footer_general_section',
				'fields' => array(
					'payment_icon' => array(
						'type' => 'text',
						'label' => esc_attr__( 'Icon', 'furnob' ),
						'description' => esc_attr__( 'You can set an icon. for example; "klbth-icon-cc-stripe"', 'furnob' ),
					),
					'payment_icon_url' => array(
						'type' => 'text',
						'label' => esc_attr__( 'URL', 'furnob-core' ),
						'description' => esc_attr__( 'You can set url for the item.', 'furnob-core' ),
					),
				),
				
			)
		);
		
		/*====== Secondary Menu Toggle ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_footer_menu',
				'label' => esc_attr__( 'Footer Menu', 'furnob' ),
				'description' => esc_attr__( 'Disable or Enable footer menu.', 'furnob' ),
				'section' => 'furnob_footer_general_section',
				'default' => '0',
			)
		);
		
		/*====== Back to top  ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'furnob_scroll_to_top',
				'label' => esc_attr__( 'Back To Top Button', 'furnob' ),
				'section' => 'furnob_footer_general_section',
				'default' => '0',
			)
		);
		
		/*====== Footer Column ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'select',
				'settings' => 'furnob_footer_column',
				'label' => esc_attr__( 'Footer Column', 'furnob' ),
				'description' => esc_attr__( 'You can set footer column.', 'furnob' ),
				'section' => 'furnob_footer_general_section',
				'default' => '5columns',
				'choices' => array(
					'5columns' => esc_attr__( '5 Columns', 'furnob' ),
					'4columns' => esc_attr__( '4 Columns', 'furnob' ),
					'3columns' => esc_attr__( '3 Columns', 'furnob' ),
				),
			)
		);
		
	/*====== Footer Style =============================*/	
		
		/*====== Footer Top Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_footer_top_bg_color',
				'label' => esc_attr__( 'Footer Top Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for background.', 'furnob-core' ),
				'section' => 'furnob_footer_style_section',
			)
		);
		
		/*====== Footer Top Border Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#e5e5e5',
				'settings' => 'furnob_footer_top_border_color',
				'label' => esc_attr__( 'Footer Top Border Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for border.', 'furnob-core' ),
				'section' => 'furnob_footer_style_section',
			)
		);
		
		/*====== Footer Title Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_footer_title_color',
				'label' => esc_attr__( 'Footer Title Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for color.', 'furnob-core' ),
				'section' => 'furnob_footer_style_section',
			)
		);
		
		/*====== Footer Subtitle Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#737373',
				'settings' => 'furnob_footer_subtitle_color',
				'label' => esc_attr__( 'Footer Subtitle Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for color.', 'furnob-core' ),
				'section' => 'furnob_footer_style_section',
			)
		);
		
		/*====== Footer Bottom Background Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'furnob_footer_bottom_bg_color',
				'label' => esc_attr__( 'Footer Bottom Background Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for background.', 'furnob-core' ),
				'section' => 'furnob_footer_style_section',
			)
		);
		
		/*====== Footer Bottom Border Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#e5e5e5',
				'settings' => 'furnob_footer_bottom_border_color',
				'label' => esc_attr__( 'Footer Bottom Border Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for border.', 'furnob-core' ),
				'section' => 'furnob_footer_style_section',
			)
		);
		
		/*====== Footer Copyright Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_footer_copyright_color',
				'label' => esc_attr__( 'Footer Copyright Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for color.', 'furnob-core' ),
				'section' => 'furnob_footer_style_section',
			)
		);
		
		/*====== Footer Payment Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#bbb',
				'settings' => 'furnob_footer_payment_color',
				'label' => esc_attr__( 'Footer Payment Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for color.', 'furnob-core' ),
				'section' => 'furnob_footer_style_section',
			)
		);
		
		/*====== Footer Bottom Menu Color ======*/
		furnob_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#000',
				'settings' => 'furnob_footer_bottom_menu_color',
				'label' => esc_attr__( 'Footer Menu Color', 'furnob-core' ),
				'description' => esc_attr__( 'You can set a color for color.', 'furnob-core' ),
				'section' => 'furnob_footer_style_section',
			)
		);