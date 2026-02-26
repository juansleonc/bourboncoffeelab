<?php

/**
 * Correios
 *
 * @package WooCommerce_Correios/Classes
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Plugins main class.
 */
class WC_Correios
{

	/**
	 * Initialize the plugin public actions.
	 */
	public static function init()
	{
		add_action('init', array(__CLASS__, 'load_plugin_textdomain'), -1);

		// Registramos los hooks de activación/desactivación
		register_activation_hook(WC_CORREIOS_PLUGIN_FILE, array(__CLASS__, 'bluex_plugin_activate'));
		register_deactivation_hook(WC_CORREIOS_PLUGIN_FILE, array(__CLASS__, 'deactivate_logger'));

		// Checks with WooCommerce is installed.
		if (class_exists('WC_Integration')) {
			self::includes();

			if (is_admin()) {
				self::admin_includes();
			}

			// Inicializar la API
			add_action('rest_api_init', array('WC_Correios_API', 'init'));

			// Inicializar Blue Express Quick Checker
			if (class_exists('WC_Bluex_Quick_Checker')) {
				WC_Bluex_Quick_Checker::init();
			}

			// Inicializar Blue Express Zones Validator
			if (class_exists('WC_BlueX_Zones_Validator')) {
				WC_BlueX_Zones_Validator::init();
			}

			// Inicializar Blue Express Granular Zones Configuration
			if (class_exists('WC_BlueX_Granular_Zones_Config')) {
				WC_BlueX_Granular_Zones_Config::init();
			}

			// Inicializar Blue Express City Zone Matcher
			if (class_exists('WC_BlueX_City_Zone_Matcher')) {
				WC_BlueX_City_Zone_Matcher::init();
			}

			add_filter('woocommerce_integrations', array(__CLASS__, 'include_integrations'));
			add_filter('woocommerce_shipping_methods', array(__CLASS__, 'include_methods'));
			add_filter('woocommerce_email_classes', array(__CLASS__, 'include_emails'));
		} else {
			add_action('admin_notices', array(__CLASS__, 'woocommerce_missing_notice'));
		}
	}

	public static function deactivate_logger()
	{
		require_once(plugin_dir_path(__FILE__) . 'logger/wc-logs-deactive-cron.php');
	}

	public static function bluex_create_logs_table()
	{
		global $wpdb;
		$table_name = $wpdb->prefix . 'bluex_logs';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			log_timestamp datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			log_type varchar(20) NOT NULL,
			log_body text NOT NULL,
			PRIMARY KEY  (id),
			KEY log_timestamp (log_timestamp)
		) $charset_collate;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

	public static function bluex_plugin_activate()
	{
		// Crear la tabla de logs
		self::bluex_create_logs_table();

		// Programar la limpieza de logs
		if (! wp_next_scheduled('bluex_clean_logs')) {
			wp_schedule_event(time(), 'daily', 'bluex_clean_logs');
		}
	}

	/**
	 * Load the plugin text domain for translation.
	 */
	public static function load_plugin_textdomain()
	{
		load_plugin_textdomain('woocommerce-correios', false, dirname(plugin_basename(WC_CORREIOS_PLUGIN_FILE)) . '/languages/');
	}

	/**
	 * Includes.
	 */
	private static function includes()
	{
		// Ensure API Client is loaded first as other classes depend on it.
		include_once dirname(__FILE__) . '/class-bluex-api-client.php';

		include_once dirname(__FILE__) . '/wc-correios-functions.php';
		include_once dirname(__FILE__) . '/class-wc-correios-install.php';
		include_once dirname(__FILE__) . '/class-wc-correios-settings.php';
		include_once dirname(__FILE__) . '/logger/helper.php';
		include_once dirname(__FILE__) . '/class-wc-correios-package.php';
		include_once dirname(__FILE__) . '/class-wc-correios-webservice.php';
		include_once dirname(__FILE__) . '/class-wc-correios-webservice-international.php';
		include_once dirname(__FILE__) . '/class-wc-correios-autofill-addresses.php';
		include_once dirname(__FILE__) . '/class-wc-correios-tracking-history.php';
		include_once dirname(__FILE__) . '/class-wc-correios-rest-api.php';
		include_once dirname(__FILE__) . '/class-wc-correios-orders.php';
		include_once dirname(__FILE__) . '/class-wc-correios-cart.php';
		include_once dirname(__FILE__) . '/class-wc-correios-blocks-integration.php';
		include_once dirname(__FILE__) . '/class-wc-correios-pudos-map.php';
		include_once dirname(__FILE__) . '/class-wc-correios-webhook.php'; // Depends on API Client
		include_once dirname(__FILE__) . '/class-wc-correios-custom-order-status.php';
		include_once dirname(__FILE__) . '/api/class-wc-correios-api.php'; // Loads endpoints which depend on API Client

		// Blue Express Data
		include_once dirname(__FILE__) . '/data/bluex-exclusion-profiles.php';

		// Blue Express Shipping Zone Automation
		include_once dirname(__FILE__) . '/class-wc-bluex-shipping-zone-automation.php';

		// Blue Express Quick Checker
		include_once dirname(__FILE__) . '/class-bluex-quick-checker.php';

		// Blue Express Zones Validator
        if (is_admin()) {
            include_once dirname(__FILE__) . '/data/chile-communes.php';
        }
		include_once dirname(__FILE__) . '/class-bluex-zones-validator.php';

		// Blue Express Granular Zones Configuration
		include_once dirname(__FILE__) . '/class-bluex-granular-zones-config.php';

		// Blue Express City Zone Matcher
		include_once dirname(__FILE__) . '/class-wc-bluex-city-zone-matcher.php';

		// Districts
		include_once dirname(__FILE__) . '/districts/class-wc-districts.php';

		// Integration.
		include_once dirname(__FILE__) . '/integrations/class-wc-correios-integration.php'; // Depends on API Client



		// Shipping methods.
		if (defined('WC_VERSION') && version_compare(WC_VERSION, '2.6.0', '>=')) {
			include_once dirname(__FILE__) . '/abstracts/class-wc-correios-shipping.php';
			include_once dirname(__FILE__) . '/abstracts/class-wc-correios-shipping-carta.php';
			include_once dirname(__FILE__) . '/abstracts/class-wc-correios-shipping-impresso.php';
			include_once dirname(__FILE__) . '/abstracts/class-wc-correios-shipping-international.php';
			foreach (glob(plugin_dir_path(__FILE__) . '/shipping/*.php') as $filename) {
				include_once $filename;
			}

			// Update settings to 3.0.0 when using WooCommerce 2.6.0.
			WC_Correios_Install::upgrade_300_fromWc260();
		} else {
			include_once dirname(__FILE__) . '/shipping/class-wc-correios-shipping-legacy.php';
		}

		// Update to 3.0.0.
		WC_Correios_Install::upgrade_300();
	}

	/**
	 * Admin includes.
	 */
	private static function admin_includes()
	{
		include_once dirname(__FILE__) . '/admin/class-wc-correios-admin-orders.php';
	}

	/**
	 * Include Correios integration to WooCommerce.
	 *
	 * @param  array $integrations Default integrations.
	 *
	 * @return array
	 */
	public static function include_integrations($integrations)
	{
		$integrations[] = 'WC_Correios_Integration';

		return $integrations;
	}

	/**
	 * Include Correios shipping methods to WooCommerce.
	 *
	 * @param  array $methods Default shipping methods.
	 *
	 * @return array
	 */
	public static function include_methods($methods)
	{
		// Legacy method.
		$methods['correios-legacy'] = 'WC_Correios_ShippingLegacy';

		// New methods.
		if (defined('WC_VERSION') && version_compare(WC_VERSION, '2.6.0', '>=')) {
			$methods['bluex-ex']					= 'WC_BlueX_EX';
			$methods['bluex-py']					= 'WC_BlueX_PY';
			$methods['bluex-md']					= 'WC_BlueX_MD';
			$old_options = get_option('woocommerce_correios_settings');
			if (empty($old_options)) {
				unset($methods['correios-legacy']);
			}
		}

		return $methods;
	}

	/**
	 * Include emails.
	 *
	 * @param  array $emails Default emails.
	 *
	 * @return array
	 */
	public static function include_emails($emails)
	{
		if (!isset($emails['WC_Correios_TrackingEmail'])) {
			$emails['WC_Correios_TrackingEmail'] = include dirname(__FILE__) . '/emails/class-wc-correios-tracking-email.php';
		}

		return $emails;
	}

	/**
	 * WooCommerce fallback notice.
	 */
	public static function woocommerce_missing_notice()
	{
		include_once dirname(__FILE__) . '/admin/views/html-admin-missing-dependencies.php';
	}

	/**
	 * Get main file.
	 *
	 * @return string
	 */
	public static function get_main_file()
	{
		return WC_CORREIOS_PLUGIN_FILE;
	}

	/**
	 * Get plugin path.
	 *
	 * @return string
	 */
	public static function get_plugin_path()
	{
		return plugin_dir_path(WC_CORREIOS_PLUGIN_FILE);
	}

	/**
	 * Get templates path.
	 *
	 * @return string
	 */
	public static function get_templates_path()
	{
		return self::get_plugin_path() . 'templates/';
	}
}
