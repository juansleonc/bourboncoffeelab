<?php

/**
 * Class MonsterInsights_Google_Ads
 *
 */
class MonsterInsights_Google_Ads
{

	/**
	 * The cache key for the access token.
	 */
	const TOKEN_CACHE_KEY = 'monsterinsights_google_ads_access_token_data';

	/**
	 * The cache key for the settings.
	 */
	const SETTINGS_KEY = 'monsterinsights_google_ads_settings';

	/**
	 * The instance of the class.
	 */
	private static $instance;

	/**
	 * The API instance.
	 */
	private $api;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		/**
		 * This class is initialized for both admin and frontend.
		 * Let's make sure we register admin-related actions only when in admin.
		 */

		if (is_admin()) {
			//  Load API
			$this->api = new MonsterInsights_API_Ads();

			//  Register AJAX Actions
			add_action('wp_ajax_monsterinsights_ads_get_token', array($this, 'get_ads_access_token'));
			add_action('wp_ajax_monsterinsights_ads_update_setting', array($this, 'update_ads_setting'));
			add_action('wp_ajax_monsterinsights_ads_get_settings', array($this, 'get_ads_settings'));
			add_action('wp_ajax_monsterinsights_ads_reset_experience', array($this, 'reset_experience'));
			add_action('wp_ajax_monsterinsights_ads_check_conversions', array($this, 'check_conversions'));
		}
	}

	/**
	 * Get the instance of the class.
	 *
	 * @return MonsterInsights_Google_Ads
	 */
	public static function get_instance()
	{
		if (! isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Get the settings for the Google Ads API.
	 *
	 * @return mixed The settings for the Google Ads API.
	 */
	public static function get_settings($key = null)
	{
		$settings = monsterinsights_get_option(self::SETTINGS_KEY, []);

		if (!self::is_woogle_active()) {
			// If Google For WooCommerce is not active, set physical_products to false.
			// $settings['physical_products'] = false;
		} else {
			$settings['is_woogle_active'] = true;
			$settings['woogle_url'] = admin_url('admin.php?page=wc-admin&path=%2Fgoogle%2Fstart');
			$settings['physical_products'] = true;
		}

		if ($key) {
			return $settings[$key] ?? null;
		}

		$settings = array_merge($settings, array(
			'is_woo_active' => self::is_woocommerce_active(),
		));

		return $settings;
	}

	/**
	 * Update a setting for the Google Ads API.
	 *
	 * @param string $key The key of the setting to update.
	 * @param mixed $value The value to update the setting to.
	 */
	public static function update_setting($key, $value)
	{
		$settings = self::get_settings();
		$settings[$key] = $value;
		monsterinsights_update_option(self::SETTINGS_KEY, $settings);
	}

	/**
	 * Clear the Ads settings and cached data.
	 */
	public static function clear_data()
	{
		delete_transient(self::TOKEN_CACHE_KEY);
		monsterinsights_delete_option(self::SETTINGS_KEY);
	}

	/**
	 * Get the access token for the Google Ads API.
	 *
	 * @return string|WP_Error The access token or a WP_Error if there was an error.
	 */
	public function get_access_token()
	{

		if (! monsterinsights_is_authed()) {
			return new WP_Error(
				'not_authed',
				sprintf(
					__('To use this feature, please connect to MonsterInsights. <a href="%s">Click here to connect.</a>', 'google-analytics-for-wordpress'),
					admin_url('admin.php?page=monsterinsights_settings')
				)
			);
		}

		// Get cached token.
		$cached_token_data = get_transient(self::TOKEN_CACHE_KEY);

		if ($cached_token_data) {
			$expires_at = $cached_token_data['expires_at'];
			$expires_at = strtotime($expires_at);

			// Calculate the time to refresh the token.
			$time_to_refresh = $expires_at - time();

			// If the token is valid, return it.
			if ($time_to_refresh > 0) {
				return $cached_token_data['token'];
			}
		}

		$response = $this->api->get_access_token();

		if (is_wp_error($response)) {
			return $response;
		}

		// Cache the token.
		$transient_expiration = strtotime($response['expires_at']) - time();
		set_transient('monsterinsights_google_ads_access_token_data', $response, $transient_expiration);

		return $response['token'];
	}

	/**
	 * Reset the Google Ads experience.
	 */
	public function reset_experience() {
		check_ajax_referer('mi-admin-nonce', 'nonce');

		self::clear_data();

		wp_send_json_success(array(
			'message' => __('Google Ads experience reset successfully.', 'google-analytics-for-wordpress'),
		));
	}

	/**
	 * ------------------------------
	 * Helper Functions
	 * ------------------------------
	 */

	/**
	 * Get the conversion tracking id for the Google Ads API.
	 *
	 * @return mixed|WP_Error The conversion tracking id or a WP_Error if there was an error.
	 */
	public function get_conversion_tracking_id()
	{
		$conversion_tracking_id = self::get_settings('conversion_tracking_id');

		if ($conversion_tracking_id) {
			return $conversion_tracking_id;
		}

		return new WP_Error('conversion_tracking_id_not_found', __('Conversion tracking id not found.', 'google-analytics-for-wordpress'));
	}

	/**
	 * Check if the conversion tracking id is set and valid.
	 *
	 * @return bool True if the conversion tracking id is set and valid, false otherwise.
	 */
	public function should_track_conversion()
	{
		$conversion_tracking_id = $this->get_conversion_tracking_id();

		if (is_wp_error($conversion_tracking_id)) {
			return false;
		}

		return true;
	}

	/**
	 * Check if Google For WooCommerce is installed and active.
	 *
	 * @return bool True if Google For WooCommerce is active, false otherwise.
	 */
	public static function is_woogle_active() {
		return defined( 'WC_GLA_VERSION' );
	}

	/**
	 * Check if WooCommerce is installed and active.
	 *
	 * @return bool True if WooCommerce is active, false otherwise.
	 */
	public static function is_woocommerce_active()
	{
		return class_exists('WooCommerce');
	}

	/**
	 * ------------------------------
	 * AJAX Functions
	 * ------------------------------
	 */
	/**
	 * Returns the access token for the Google Ads API.
	 * @return void
	 */
	public function get_ads_access_token()
	{
		check_ajax_referer('mi-admin-nonce', 'nonce');

		$access_token_result = $this->get_access_token();

		if (is_wp_error($access_token_result)) {
			wp_send_json_error(array(
				'message' => $access_token_result->get_error_message(),
				'code'    => $access_token_result->get_error_code(),
				'details' => $access_token_result->get_error_data(),
			));
		}

		wp_send_json_success(array(
			'access_token' => $access_token_result,
		));
	}

	/**
	 * Ajax handler for updating the Google Ads setting.
	 */
	public function update_ads_setting()
	{
		check_ajax_referer('mi-admin-nonce', 'nonce');

		if (! current_user_can('monsterinsights_save_settings')) {
			wp_send_json_error(array(
				'message' => __('You do not have permission to update this setting.', 'google-analytics-for-wordpress'),
			));
		}

		if (! isset($_POST['key']) || ! isset($_POST['value'])) {
			wp_send_json_error(array(
				'message' => __('Invalid request.', 'google-analytics-for-wordpress'),
			));
		}

		$key = sanitize_text_field($_POST['key']);
		$value = $_POST['value'];

		// Convert '1'/'0' strings to boolean for physical_products
		if ($key === 'physical_products' || $key === 'user_onboarded') {
			$value = ($value === '1' || $value === 'true' || $value === true);
		}

		self::update_setting($key, $value);

		wp_send_json_success();
	}

	/**
	 * Ajax handler for fetching the Google Ads settings.
	 */
	public function get_ads_settings() {
		check_ajax_referer('mi-admin-nonce', 'nonce');

		if (! current_user_can('monsterinsights_save_settings')) {
			wp_send_json_error(array(
				'message' => __('You do not have permission to view these settings.', 'google-analytics-for-wordpress'),
			));
		}

		$settings = self::get_settings();
		wp_send_json_success($settings);
	}

	/**
	 * Ajax handler for checking Google Ads conversions.
	 */
	public function check_conversions() {
		check_ajax_referer('mi-admin-nonce', 'nonce');

		if (! current_user_can('monsterinsights_save_settings')) {
			wp_send_json_error(array(
				'message' => __('You do not have permission to check conversions.', 'google-analytics-for-wordpress'),
			));
		}

		$customer_id = self::get_settings('external_customer_id');
		$campaign_id = self::get_settings('campaign_id');

		// Need both customer_id and campaign_id to check conversions
		if (empty($customer_id) || empty($campaign_id)) {
			// Return success with no conversions - notice will show
			wp_send_json_success(array(
				'has_conversions' => false,
				'conversions'     => array(),
			));
			return;
		}

		$response = $this->api->get_conversions($customer_id, $campaign_id);

		if (is_wp_error($response)) {
			wp_send_json_error(array(
				'message' => $response->get_error_message(),
				'code'    => $response->get_error_code(),
			));
		}

		$response = array(
			'has_conversions' => ! empty($response['conversions']),
			'conversions'     => $response['conversions'] ?? array(),
		);
		
		$response = apply_filters('monsterinsights_pax_get_conversions_response', $response);
		
		wp_send_json_success($response);
	}

}

new MonsterInsights_Google_Ads();
