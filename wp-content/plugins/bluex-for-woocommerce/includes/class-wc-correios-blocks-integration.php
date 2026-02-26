<?php
/**
 * WooCommerce Blocks Integration
 *
 * Adds support for displaying delivery forecast in WooCommerce Block-based checkout.
 *
 * @package WooCommerce_Correios/Classes/Blocks
 * @since   4.0.0
 */

defined('ABSPATH') || exit;

/**
 * WooCommerce Blocks Integration Class
 */
class WC_Correios_Blocks_Integration
{
	/**
	 * Version of the script.
	 *
	 * @var string
	 */
	private $script_version = '1.0.8';

	/**
	 * Constructor
	 */
	public function __construct()
	{
		// Only initialize if WooCommerce Blocks is active
		if (!$this->is_blocks_active()) {
			return;
		}

		// Expose delivery forecast data to Store API
		add_filter('woocommerce_store_api_shipping_rate_data', array($this, 'add_delivery_forecast_data'), 10, 2);

		// Enqueue frontend scripts for blocks checkout
		add_action('wp_enqueue_scripts', array($this, 'enqueue_blocks_scripts'));
	}

	/**
	 * Check if WooCommerce Blocks is active
	 *
	 * @return bool
	 */
	private function is_blocks_active()
	{
		return class_exists('Automattic\WooCommerce\Blocks\Package');
	}

	/**
	 * Add delivery forecast data to Store API shipping rate response
	 *
	 * This makes the delivery forecast metadata available to the frontend blocks.
	 *
	 * @param array            $rate_data Shipping rate data.
	 * @param WC_Shipping_Rate $rate      Shipping rate object.
	 * @return array Modified shipping rate data.
	 */
	public function add_delivery_forecast_data($rate_data, $rate)
	{
		// Skip if not a Blue Express method
		if (!$this->is_bluex_method($rate->get_method_id())) {
			return $rate_data;
		}

		// Get metadata
		$meta_data = $rate->get_meta_data();

		// Add delivery forecast if available
		if (!empty($meta_data['_delivery_forecast'])) {
			$rate_data['delivery_forecast'] = sanitize_text_field($meta_data['_delivery_forecast']);
		}

		return $rate_data;
	}

	/**
	 * Check if shipping method is a Blue Express method
	 *
	 * @param string $method_id Method ID.
	 * @return bool
	 */
	private function is_bluex_method($method_id)
	{
		return strpos($method_id, 'bluex-') !== false;
	}

	/**
	 * Enqueue scripts for blocks-based checkout
	 */
	public function enqueue_blocks_scripts()
	{
		// Only load on checkout page with blocks
		if (!is_checkout() || !has_block('woocommerce/checkout')) {
			return;
		}

		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		$script_path = 'assets/js/frontend/blocks-delivery-forecast' . $suffix . '.js';
		$script_url = plugins_url($script_path, WC_Correios::get_main_file());
		$script_file = WC_Correios::get_plugin_path() . $script_path;

		// Check if file exists
		if (!file_exists($script_file)) {
			$script_path = 'assets/js/frontend/blocks-delivery-forecast.js';
			$script_url = plugins_url($script_path, WC_Correios::get_main_file());
		}

		// Enqueue script
		wp_enqueue_script(
			'wc-correios-blocks-delivery',
			$script_url,
			array('wp-data', 'wp-element', 'wp-hooks'),
			$this->script_version,
			true
		);

		// Enqueue PUDO integration script
		$this->enqueue_pudo_script();

		// Enqueue City Select integration script
		$this->enqueue_city_select_script();

		// Add inline script for debugging (only if WP_DEBUG is enabled)
		if (defined('WP_DEBUG') && WP_DEBUG) {
			wp_add_inline_script(
				'wc-correios-blocks-delivery',
				'console.log("BlueX Blocks Integration loaded");',
				'after'
			);
		}
	}

	/**
		* Enqueue PUDO integration script
		*/
	private function enqueue_pudo_script()
	{
		$configData = get_option('woocommerce_correios-integration_settings');
		
		// Only if PUDO is enabled
		if (!isset($configData['pudoEnable']) || $configData['pudoEnable'] !== "yes") {
			return;
		}

		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		$script_path = 'assets/js/frontend/blocks-pudo-integration.js'; // No min version yet
		$script_url = plugins_url($script_path, WC_Correios::get_main_file());

		wp_enqueue_script(
			'bluex-blocks-pudo-integration',
			$script_url,
			array('wp-data', 'wp-element', 'wp-hooks', 'wc-blocks-checkout'),
			$this->script_version,
			true
		);

		// Prepare params
		$devMode = isset($configData['devOptions']) && $configData['devOptions'] === "yes";
		$basePathUrl = ($devMode && !empty($configData['alternativeBasePath'])) ? $configData['alternativeBasePath'] : 'https://eplin.api.blue.cl';

		$params = array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('bluex_checkout_nonce'),
			'widget_base_urls' => array(
				'prod' => 'https://widget-pudo.blue.cl',
				'qa' => 'https://widget-pudo.qa.blue.cl',
				'dev' => 'https://widget-pudo.dev.blue.cl'
			),
			'base_path_url' => $basePathUrl
		);

		wp_localize_script('bluex-blocks-pudo-integration', 'bluex_checkout_params', $params);
	}

	/**
		* Enqueue City Select integration script
		*/
	private function enqueue_city_select_script()
	{
		$configData = get_option('woocommerce_correios-integration_settings');
		
		// Only if Districts are enabled
		if (!isset($configData['districtsEnable']) || $configData['districtsEnable'] !== "yes") {
			return;
		}

		$script_path = 'assets/js/frontend/blocks-city-select.js';
		$script_url = plugins_url($script_path, WC_Correios::get_main_file());

		wp_enqueue_script(
			'bluex-blocks-city-select',
			$script_url,
			array('wp-data', 'wp-element', 'wp-hooks', 'wc-blocks-checkout'),
			$this->script_version,
			true
		);

		// Get places
		// We need to instantiate WC_States_Places_Bx to get places easily, or replicate logic.
		// Since the class is available, let's try to use it if possible, or just replicate the loading logic.
		// Replicating is safer to avoid side effects of __construct.
		
		$places = array();
		
		// Use the clean list of communes for Chile
		if (!function_exists('bluex_get_communes_by_region')) {
			$communes_file = WC_Correios::get_plugin_path() . '/includes/data/chile-communes.php';
			if (file_exists($communes_file)) {
				require_once $communes_file;
			}
		}

		if (function_exists('bluex_get_communes_by_region')) {
			$communes_by_region = bluex_get_communes_by_region();
			$cl_places = array();
			
			foreach ($communes_by_region as $region_code => $communes) {
				$cl_places[$region_code] = array_map(function($commune) {
					return $commune['name'];
				}, $communes);
			}
		} else {
			// Fallback to old method if new file not found
			$places_file = WC_Correios::get_plugin_path() . '/includes/districts/places/CL.php';
			
			if (file_exists($places_file)) {
				global $places; // Ensure we capture it
				include $places_file;
				// $places should now be populated for CL
				$cl_places = isset($places['CL']) ? $places['CL'] : $places;
			} else {
				$cl_places = array();
			}
		}

		$params = array(
			'cities' => json_encode(array('CL' => $cl_places)),
			'i18n_select_city_text' => esc_attr__('Select an option&hellip;', 'woocommerce')
		);

		wp_localize_script('bluex-blocks-city-select', 'wc_city_select_params', $params);
	}

	/**
	 * Get script version
	 *
	 * @return string
	 */
	public function get_script_version()
	{
		return $this->script_version;
	}
}

// Initialize the integration
new WC_Correios_Blocks_Integration();