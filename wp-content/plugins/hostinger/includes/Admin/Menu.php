<?php

namespace Hostinger\Admin;

use Hostinger\Admin\Onboarding\Onboarding;

defined( 'ABSPATH' ) || exit;

class Menu {

	public const WEBSITE_LIST_URL = 'https://hpanel.hostinger.com/websites';
	public const WEBSITE_BILLINGS_URL = 'https://hpanel.hostinger.com/billing/subscriptions';
	public const AI_ASSISTANT_URL = '/wp-admin/admin.php?page=hostinger#ai-assistant';

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_bar_menu', array( $this, 'admin_bar' ), 999 );
	}

	public function admin_menu(): void {
		$icon = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjEiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyMSAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0wLjAwMDE5OTY1MyAxMS4yMzY4VjAuMDAwMzk4MjM1TDUuNjcxMzMgMy4wMjQzNlY4LjA4NjkxTDEzLjE3ODggOC4wOTA1M0wxOC45NDE5IDExLjIzNjhIMC4wMDAxOTk2NTNaTTE0LjcxNCA3LjE2MDQ3VjBMMjAuNTM4IDIuOTQ4NzJWMTAuNTQzN0wxNC43MTQgNy4xNjA0N1pNMTQuNzE0IDIwLjg5NDJWMTUuODc1M0w3LjE0ODYyIDE1Ljg3QzcuMTU1NjggMTUuOTAzNCAxLjI4OTg0IDEyLjY3MzUgMS4yODk4NCAxMi42NzM1TDIwLjUzOCAxMi43NjM4VjI0TDE0LjcxNCAyMC44OTQyWk0wIDIwLjg5NDFMMC4wMDAyMDE3NjkgMTMuNTUxNEw1LjY3MTMzIDE2Ljg1NDZWMjMuODQyN0wwIDIwLjg5NDFaIiBmaWxsPSJ3aGl0ZSIvPgo8L3N2Zz4K';
		add_menu_page(
			__( 'Hostinger', 'hostinger' ),
			__( 'Hostinger', 'hostinger' ),
			'manage_options',
			'hostinger',
			array( $this, 'render' ),
			$icon,
			1
		);

		add_submenu_page(
			'hostinger',
			__( 'Get started', 'hostinger' ),
			__( 'Get started', 'hostinger' ),
			'manage_options',
			'hostinger&#home',
			'__return_empty_string',
			2
		);

		add_submenu_page(
			'hostinger',
			__( 'Learn', 'hostinger' ),
			__( 'Learn', 'hostinger' ),
			'manage_options',
			'hostinger&#learn',
			'__return_empty_string',
			3
		);

		if ( has_action( 'hostinger_ai_assistant_tab_view' ) && current_user_can( 'edit_posts' ) ) {
			add_submenu_page(
				'hostinger',
				__( 'AI Content Creator', 'hostinger' ),
				__( 'AI Content Creator', 'hostinger' ),
				'manage_options',
				'hostinger&#ai-assistant',
				'__return_empty_string',
				4
			);
		}

		remove_submenu_page( 'hostinger', 'hostinger' );
	}

	public function admin_bar( \WP_Admin_Bar $bar ): void {
		$hostinger_icon = '<svg width="28" height="29" viewBox="0 0 28 29" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd" clip-rule="evenodd" d="M1.8669 13.6096V0.500465L8.48322 4.02842V9.93472L17.2419 9.93895L23.9655 13.6096H1.8669ZM19.033 8.85388V0.5L25.8277 3.94018V12.801L19.033 8.85388ZM19.033 24.8765V19.0211L10.2067 19.015C10.215 19.054 3.37149 15.2857 3.37149 15.2857L25.8277 15.3911V28.5L19.033 24.8765ZM1.86667 24.8765L1.8669 16.31L8.48322 20.1637V28.3164L1.86667 24.8765Z" fill=""/>
		</svg>';

		$external_icon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M5 21C4.45 21 3.97917 20.8042 3.5875 20.4125C3.19583 20.0208 3 19.55 3 19V5C3 4.45 3.19583 3.97917 3.5875 3.5875C3.97917 3.19583 4.45 3 5 3H11C11.2833 3 11.5208 3.09583 11.7125 3.2875C11.9042 3.47917 12 3.71667 12 4C12 4.28333 11.9042 4.52083 11.7125 4.7125C11.5208 4.90417 11.2833 5 11 5H5V19H19V13C19 12.7167 19.0958 12.4792 19.2875 12.2875C19.4792 12.0958 19.7167 12 20 12C20.2833 12 20.5208 12.0958 20.7125 12.2875C20.9042 12.4792 21 12.7167 21 13V19C21 19.55 20.8042 20.0208 20.4125 20.4125C20.0208 20.8042 19.55 21 19 21H5ZM19 6.4L10.4 15C10.2167 15.1833 9.98333 15.275 9.7 15.275C9.41667 15.275 9.18333 15.1833 9 15C8.81667 14.8167 8.725 14.5833 8.725 14.3C8.725 14.0167 8.81667 13.7833 9 13.6L17.6 5H15C14.7167 5 14.4792 4.90417 14.2875 4.7125C14.0958 4.52083 14 4.28333 14 4C14 3.71667 14.0958 3.47917 14.2875 3.2875C14.4792 3.09583 14.7167 3 15 3H21V9C21 9.28333 20.9042 9.52083 20.7125 9.7125C20.5208 9.90417 20.2833 10 20 10C19.7167 10 19.4792 9.90417 19.2875 9.7125C19.0958 9.52083 19 9.28333 19 9V6.4Z" fill=""/>
		</svg>';

		$bar->add_menu( array(
			'id'     => 'hostinger_admin_bar',
			'parent' => null,
			'group'  => null,
			'title'  => $hostinger_icon . esc_html__( 'Hostinger', 'hostinger' ),
		) );

		$bar->add_menu( array(
			'id'     => 'website_list',
			'parent' => 'hostinger_admin_bar',
			'title'  => esc_html__( 'Website list', 'hostinger' ) . $external_icon,
			'href'   => self::WEBSITE_LIST_URL,
			'meta'   => array(
				'target'  => '_blank',
			),
		) );

		$bar->add_menu( array(
			'id'     => 'billings',
			'parent' => 'hostinger_admin_bar',
			'title'  => esc_html__( 'Billings', 'hostinger' ) . $external_icon,
			'href'   => self::WEBSITE_BILLINGS_URL,
			'meta'   => array(
				'target'  => '_blank',
			),
		) );
		if ( has_action( 'hostinger_ai_assistant_tab_view' ) && current_user_can( 'edit_posts' ) ) {
			$bar->add_menu( array(
				'id'     => 'create_content_with_ai',
				'parent' => 'hostinger_admin_bar',
				'title'  => esc_html__( 'Create content with AI', 'hostinger' ),
				'href'   => self::AI_ASSISTANT_URL,
			) );
		}
	}

	public function render(): void {
		$onboarding = new Onboarding();
		include_once __DIR__ . '/Views/Onboarding.php';
	}
}
