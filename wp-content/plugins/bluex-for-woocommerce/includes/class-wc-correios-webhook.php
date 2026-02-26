<?php

declare(strict_types=1);

/**
 * Correios Webhook.
 *
 * @package WooCommerce_Correios/Classes/webhook
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Correios webhook class
 */
class WC_Correios_Webhook
{


	/**
	 * Addresses webservice URL.
	 *
	 * @var string
	 */
	protected $_basePathUrl;
	protected $_configData;
	protected $_blueStatus;
	protected $_blueApikey;
	protected $_devMode;

	/**
	 * Settings handler.
	 *
	 * @var WC_Correios_Settings
	 */
	protected $settings_handler = null;

	/**
	 * API Client instance.
	 *
	 * @var BlueX_API_Client|null
	 */
	private $api_client = null;

	/**
	 * Get settings handler instance
	 *
	 * @return WC_Correios_Settings
	 */
	protected function get_settings_handler()
	{
		if ($this->settings_handler === null) {
			$this->settings_handler = WC_Correios_Settings::get_instance();
		}
		return $this->settings_handler;
	}


	/**
	 * Constructor for the webhook class.
	 *
	 * Initializes the webhook by setting up the configuration and adding necessary actions based on the status check.
	 */
	public function __construct()
	{
		$this->setupConfig();
		// Initialize API client
		$this->api_client = new BlueX_API_Client();
		add_action('init', array($this, 'init'));
	}
	/**
	 * Sets up the configuration from WooCommerce settings.
	 */
	private function setupConfig()
	{
		// Fetch configuration data from WooCommerce settings
		$this->_configData = $this->get_settings_handler()->get_settings();
		$this->_blueStatus = $this->_configData['noBlueStatus'] ?? 'wc-shipping-progress';
		$this->_devMode = ($this->_configData['devOptions'] ?? 'no') === "yes";

		// API Key and Base Path are now handled by the API Client.
		// $this->_blueApikey = $this->_configData['tracking_bxkey'];
		// $this->_basePathUrl = $this->get_settings_handler()->get_base_path(); 
	}
	/**
	 * init configuration.
	 */
	public function init()
	{
		add_action('woocommerce_order_status_changed', array($this, 'order_status_change'), 10, 3);
	}

	/**
	 * Maps the WooCommerce order to the required format for the external service.
	 *
	 * @param int $order_id The order ID.
	 * @return string|null JSON encoded string representing the mapped order, or null on failure.
	 */
	public function map_order($order_id): ?string
	{
		if ($this->_devMode) {
			bluex_log('info', "Webhook: Start mapping order ID: {$order_id}");
		}

		$order = wc_get_order($order_id);

		if (!$order) {
			bluex_log('error', "Webhook: wc_get_order failed for order ID: {$order_id}");
			return null;
		}

		$order_data = $order->get_data();
		$shipping_lines = $order->get_items('shipping');
		$method_id = "";
		foreach ($shipping_lines as $shipping_line) {
			$shipping_data = $shipping_line->get_data();
			$method_id = $shipping_data['method_id'];
		}

		$product_ids = array();
		foreach ($order->get_items() as $item) {
			$productMetadata = $item->get_product();
			$product = $item->get_data();

			// Acceder a los atributos
			$productMetadata->attributes = $productMetadata->get_attributes();
			// Acceder a las dimensiones
			$productMetadata->dimensions = array(
				'length' => $productMetadata->get_length(),
				'width' => $productMetadata->get_width(),
				'height' => $productMetadata->get_height(),
			);
			// Acceder al peso
			$productMetadata->weight = $productMetadata->get_weight();
			$product['medatada'] = $productMetadata;
			$product_ids[] = $product;
		}

		$agencyId = $order->get_meta('agencyId');
		if ($agencyId) {
			$order_data['agencyId'] = $agencyId;
		}

		$order_data['shipping_lines'] = $method_id;
		$order_data['line_items'] = $product_ids;
		$order_data['seller'] = $this->_configData;
		$order_data['storeId'] = home_url() . '/';

		$order_json = json_encode([$order_data]);

		if ($this->_devMode) {
			bluex_log('info', "Webhook: Mapped Order JSON for order {$order_id}: " . $order_json);
		}

		return $order_json;
	}
	/**
	 * Retrieves the current URL details.
	 * 
	 * This function extracts various components of the current URL, such as
	 * the HTTP/HTTPS method, home folder path, full URL, and domain name.
	 * It also considers different server configurations to determine if 
	 * the current connection is secure (HTTPS).
	 * 
	 * Additionally, this function utilizes a static memory cache to 
	 * store and return the parsed URL details, ensuring efficient 
	 * subsequent calls without re-parsing the URL.
	 * 
	 * @return array Associative array containing:
	 *               - 'method'    => HTTP/HTTPS method
	 *               - 'home_fold' => Relative path of the home directory
	 *               - 'url'       => Full current URL
	 *               - 'domain'    => Domain of the current URL
	 */
	public function get_url()
	{
		// Start memory cache
		static $parse_url;
		// Return cache
		if ($parse_url) {
			return $parse_url;
		}
		// Check is SSL
		$is_ssl = (
			(is_admin() && defined('FORCE_SSL_ADMIN') && FORCE_SSL_ADMIN === true)
			|| (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
			|| (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
			|| (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on')
			|| (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
			|| (isset($_SERVER['HTTP_X_FORWARDED_PORT']) && $_SERVER['HTTP_X_FORWARDED_PORT'] == 443)
			|| (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https')
		);
		// Get protocol HTTP or HTTPS
		$http = 'http' . ($is_ssl ? 's' : '');
		// Get domain
		$domain = preg_replace('%:/{3,}%i', '://', rtrim($http, '/') . '://' . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ''));
		$domain = rtrim($domain, '/');
		// Combine all and get full URL
		$url = preg_replace('%:/{3,}%i', '://', $domain . '/' . (isset($_SERVER['REQUEST_URI']) && !empty($_SERVER['REQUEST_URI']) ? ltrim($_SERVER['REQUEST_URI'], '/') : ''));
		//Save to cache
		$parse_url = array(
			'method'    =>  $http,
			'home_fold' =>  str_replace($domain, '', home_url()),
			'url'       =>  $url,
			'domain'    =>  $domain,
		);
		// Return
		return $parse_url;
	}

	/**
	 * Sends the mapped order data to the external service using API Client.
	 *
	 * @param string $mappedOrderJson JSON encoded string of the mapped order array.
	 */
	private function send_order(string $mappedOrderJson): void
	{
		if (!$this->api_client) {
			bluex_log('error', 'API Client not initialized in send_order');
			return;
		}

		$order_data_array = json_decode($mappedOrderJson, true);

		// Check if decoding was successful and if it's an array with at least one element
		if (json_last_error() !== JSON_ERROR_NONE || !is_array($order_data_array) || empty($order_data_array[0])) {
			$order_id_for_log = 'Unknown Order ID'; // Fallback if decoding fails early
			if (is_array($order_data_array) && isset($order_data_array[0]['id'])) {
				$order_id_for_log = $order_data_array[0]['id'];
			}
			bluex_log('error', "Failed to decode mapped order JSON for order ID {$order_id_for_log} before sending webhook. JSON: " . $mappedOrderJson);
			// Optionally send a log about the decoding failure itself? 
			// $this->send_log_if_error('JSON Decode Error', ['raw_json' => $mappedOrderJson]); 
			return;
		}

		// The webhook endpoint expects the first element of the decoded array.
		$payload = $order_data_array[0];
		$order_id = $payload['id'] ?? 'Unknown Order ID'; // Get order ID for logging

		try {
			$response = $this->api_client->send_order_webhook(array($payload));

			if (is_wp_error($response)) {
				// Error is already logged by the API client, but we might want to send it to the log webhook too.
				$this->send_log_if_error($response->get_error_message(), $payload);
				return;
			}
			// Optionally log success? The API client already logs the response.
			// bluex_log('info', "Order webhook sent successfully for order ID {$order_id}. Response: " . json_encode($response));

		} catch (Exception $e) { // Catch potential exceptions from API client or other issues
			bluex_log('error', "Exception sending order webhook for order ID {$order_id}: " . $e->getMessage());
			// Send log about the exception
			$this->send_log_if_error('Exception: ' . $e->getMessage(), $payload);
			return;
		}
	}

	/**
	 * Sends log data if an error occurs, using API Client.
	 *
	 * @param string $error The error message.
	 * @param array|string $payload The payload associated with the error (can be array or JSON string).
	 */
	public function send_log_if_error(string $error, $payload): void
	{
		if (!$this->api_client) {
			// Cannot send log if client is not available, maybe log to local error_log?
			error_log("BlueX Webhook Error (API Client N/A): {$error}");
			return;
		}

		// Attempt to decode payload if it's a JSON string
		$payload_array = is_string($payload) ? json_decode($payload, true) : $payload;
		if (!is_array($payload_array)) {
			// If decoding fails or it wasn't a string, create a simple array
			$payload_array = ['original_payload' => $payload];
		}

		try {
			$response = $this->api_client->send_log_webhook($error, $payload_array);

			if (is_wp_error($response)) {
				// Log the failure to send the log webhook itself to the local error log
				error_log("BlueX: Failed to send error log via webhook. Original Error: {$error}. Webhook Error: " . $response->get_error_message());
			}
			// No need to throw exception here, just log the failure locally.
		} catch (Exception $e) {
			// Log exception during log sending to local error log
			error_log("BlueX: Exception while sending error log via webhook. Original Error: {$error}. Exception: " . $e->getMessage());
		}
	}

	/**
	 * Handles the order status change event.
	 *
	 * Sends the mapped order to the external service when the order status changes.
	 *
	 * @param int $order_id The order ID.
	 * @param string $old_status The old order status.
	 * @param string $new_status The new order status.
	 */
	public function order_status_change($order_id, $old_status, $new_status)
	{
		if ($this->_devMode) {
			bluex_log('info', "Webhook: Status change hook for order ID {$order_id}. Old: {$old_status}, New: {$new_status}. Target status: {$this->_blueStatus}");
		}

		$formatedStatus = "wc-" . $new_status;
		if (($old_status !== $new_status) && ($formatedStatus === $this->_blueStatus)) {
			bluex_log('info', "Webhook: Matched status for order ID {$order_id}. Sending to BlueX.");
			$mappedOrder = $this->map_order($order_id);

			if (null === $mappedOrder) {
				bluex_log('error', "Webhook: Failed to map order ID {$order_id}, not sending.");
				return;
			}

			$this->send_order($mappedOrder);
		}
	}
}

new WC_Correios_Webhook();
