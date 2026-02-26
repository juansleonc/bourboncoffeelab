<?php

namespace Hostinger\Admin\Onboarding;

use Hostinger\Admin\Onboarding\Steps\AddDescription;
use Hostinger\Admin\Onboarding\Steps\AddHeading;
use Hostinger\Admin\Onboarding\Steps\AddImage;
use Hostinger\Admin\Onboarding\Steps\ConnectAffiliate;
use Hostinger\Admin\Onboarding\Steps\SetupStore;
use Hostinger\Settings;
use Hostinger\Helper;
use Hostinger\Admin\Onboarding\Steps\AddLogo;
use Hostinger\Admin\Onboarding\Steps\AddPost;
use Hostinger\Admin\Onboarding\Steps\AddPage;
use Hostinger\Admin\Onboarding\Steps\ConnectDomain;

defined( 'ABSPATH' ) || exit;

class Onboarding {
	private function load_steps(): array {
		$steps        = array();
		$website_type = Settings::get_setting( 'survey.website.type' );

		if ( get_theme_support( 'custom-logo' ) ) {
			$steps[] = new AddLogo();
		}

		if ( $website_type === Settings::WEBSITE_TYPE_BLOG ) {
			$steps[] = new AddPost();
		} else {
			$steps[] = new AddDescription();
		}

		$steps[] = new AddImage();
		$steps[] = new AddHeading();
		$steps[] = new AddPage();

		if ( Helper::is_plugin_active( 'hostinger-affiliate-plugin' ) ) {
			$steps[] = new ConnectAffiliate();
		}

		if ( class_exists( 'WooCommerce' ) ) {
			$steps[] = new SetupStore();
		}

		$steps[] = new ConnectDomain();

		return $steps;
	}

	public function get_steps(): array {
		return $this->load_steps();
	}

	public function maintenance_mode_enabled(): bool {
		$published = get_option( 'hostinger_maintenance_mode' );

		return (bool) $published;
	}

	public function get_content(): array {
		if ( ! $this->maintenance_mode_enabled() ) {
			return array(
				'title'       => __( 'Website is published', 'hostinger' ),
				'description' => __( 'You can access this guide material any time when updating your website', 'hostinger' ),
				'btn'         => array(
					'text'  => __( 'Preview website', 'hostinger' ),
					'class' => 'hsr-btn hsr-primary-btn hsr-publish-btn',
					'url'   => home_url(),
				),
			);
		}

		return array(
			'title'       => __( 'Set up your website', 'hostinger' ),
			'description' => __( 'Follow our guided checklist to setup your website', 'hostinger' ),
			'btn_text'    => __( 'Publish website', 'hostinger' ),
			'btn'         => array(
				'text'  => __( 'Publish website', 'hostinger' ),
				'class' => 'hsr-btn hsr-primary-btn hsr-publish-btn',
				'url'   => '#',
			),
		);
	}
}
