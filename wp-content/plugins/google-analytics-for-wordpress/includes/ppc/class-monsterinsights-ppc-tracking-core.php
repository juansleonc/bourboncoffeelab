<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main ads tracking and conversions class
 *
 * @access public
 * @since 9.7.0
 *
 * @package MonsterInsights_PPC_Tracking
 * @author  David Paternina
 */
class MonsterInsights_PPC_Tracking_Core {

	/**
	 * @var MonsterInsights_Ads_Tracking_Provider[]
	 */
	private $ad_providers;

	public function __construct() {
		$this->init_tracking();
	}

	/**
	 * Initialize tracking
	 *
	 * @return void
	 */
	public function init_tracking() {
		$this->require_files();
		$this->init_ad_providers();
		$this->init_ecommerce_providers();
		$this->init_forms();
	}

	/**
	 * Initialize ad providers
	 *
	 * @return void
	 */
	private function init_ad_providers() {
		$core_providers = [
			new MonsterInsights_Google_Ads_Pax()
		];
		
		$this->ad_providers = apply_filters( 'monsterinsights_ppc_ad_providers_register', $core_providers );
	}

	/**
	 * Initialize ecommerce providers
	 *
	 * @return void
	 */
	private function init_ecommerce_providers() {
		new MonsterInsights_Ads_Tracking_Ecommerce_Woo( $this->ad_providers );
		new MonsterInsights_Ads_Tracking_Ecommerce_EDD( $this->ad_providers );
		new MonsterInsights_Ads_Tracking_Ecommerce_MemberPress( $this->ad_providers );
		new MonsterInsights_Ads_Tracking_Ecommerce_RCP( $this->ad_providers );
		new MonsterInsights_Ads_Tracking_Ecommerce_GiveWP( $this->ad_providers );
		new MonsterInsights_Ads_Tracking_Ecommerce_Lifter_LMS( $this->ad_providers );
		
		do_action( 'monsterinsights_ppc_ecommerce_providers_register', $this->ad_providers );
	}

	/**
	 * Initialize forms
	 *
	 * @return void
	 */
	private function init_forms() {
		new MonsterInsights_Ads_Forms();
	}

	/**
	 * Load integration classes
	 *
	 * @return void
	 */
	private function require_files() {

		//  Load forms class
		require_once MONSTERINSIGHTS_PLUGIN_DIR . 'includes/ppc/class-monsterinsights-ads-forms.php';
		
		//  Load parent classes
		if ( !class_exists('MonsterInsights_Ads_Tracking_Provider') ) {
			require_once MONSTERINSIGHTS_PLUGIN_DIR . 'includes/ppc/class-monsterinsights-ads-tracking-provider.php';
		}
		
		if ( !class_exists('MonsterInsights_Ads_Tracking_Ecommerce_Tracking') ) {
			require_once MONSTERINSIGHTS_PLUGIN_DIR . 'includes/ppc/ecommerce-providers/class-monsterinsights-ads-tracking-ecommerce-tracking.php';
		}
		
		//  Load Google PAX Tracking class
		require_once MONSTERINSIGHTS_PLUGIN_DIR . 'includes/ppc/google/class-monsterinsights-google-ads-pax.php';

		//  Allow PPC addon to load its own things
		do_action('monsterinsights_ppc_tracking_require_files');
		
		//  WooCommerce
		if ( !class_exists('MonsterInsights_Ads_Tracking_Ecommerce_Woo') ) {
			require_once MONSTERINSIGHTS_PLUGIN_DIR . 'includes/ppc/ecommerce-providers/class-monsterinsights-ads-tracking-ecommerce-woo.php';
		}

		//  EDD
		if ( !class_exists('MonsterInsights_Ads_Tracking_Ecommerce_EDD') ) {
			require_once MONSTERINSIGHTS_PLUGIN_DIR . 'includes/ppc/ecommerce-providers/class-monsterinsights-ads-tracking-ecommerce-edd.php';
		}

		//  MemberPress
		if ( !class_exists('MonsterInsights_Ads_Tracking_Ecommerce_MemberPress') ) {
			require_once MONSTERINSIGHTS_PLUGIN_DIR . 'includes/ppc/ecommerce-providers/class-monsterinsights-ads-tracking-ecommerce-memberpress.php';
		}

		//  RCP
		if ( !class_exists('MonsterInsights_Ads_Tracking_Ecommerce_RCP') ) {
			require_once MONSTERINSIGHTS_PLUGIN_DIR . 'includes/ppc/ecommerce-providers/class-monsterinsights-ads-tracking-ecommerce-rcp.php';
		}

		//  GiveWP
		if ( !class_exists('MonsterInsights_Ads_Tracking_Ecommerce_GiveWP') ) {
			require_once MONSTERINSIGHTS_PLUGIN_DIR . 'includes/ppc/ecommerce-providers/class-monsterinsights-ads-tracking-ecommerce-give-wp.php';
		}

		//  LifterLMS
		if ( !class_exists('MonsterInsights_Ads_Tracking_Ecommerce_Lifter_LMS') ) {
			require_once MONSTERINSIGHTS_PLUGIN_DIR . 'includes/ppc/ecommerce-providers/class-monsterinsights-ads-tracking-ecommerce-lifter-lms.php';
		}
	}
}

new MonsterInsights_PPC_Tracking_Core();
