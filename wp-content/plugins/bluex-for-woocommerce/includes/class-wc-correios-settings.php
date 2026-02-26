<?php

/**
 * Correios Settings Handler
 *
 * @package WooCommerce_Correios/Classes
 * @since   1.0.0
 * @version 1.0.0
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * WC_Correios_Settings Class.
 */
class WC_Correios_Settings
{

	/**
	 * Settings key in wp_options table.
	 *
	 * @var string
	 */
	private $settings_key = 'woocommerce_correios-integration_settings';

	/**
	 * Settings cache.
	 *
	 * @var array
	 */
	private $settings = null;

	/**
	 * Instance of this class.
	 *
	 * @var WC_Correios_Settings
	 */
	protected static $instance = null;

	/**
	 * Get singleton instance.
	 *
	 * @return WC_Correios_Settings
	 */
	public static function get_instance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Get all settings.
	 *
	 * @return array
	 */
	public function get_settings()
	{
		if (is_null($this->settings)) {
			$this->settings = get_option($this->settings_key, array());
			// Set default values for required settings if not present
			$defaults = array(
				'noBlueStatus' => NULL,
				'devOptions' => 'no',
				'tracking_bxkey' => NULL,
				'alternativeBasePath' => NULL,
				'districtCode' => "SCL",
				'districtsEnable' => 'yes',
				'pudoEnable' => 'no',
				'active_logs' => 'no',
			);

			$this->settings = array_merge($defaults, $this->settings);
		}
		return $this->settings;
	}

	/**
	 * Get a specific setting.
	 *
	 * @param string $key Setting key.
	 * @param mixed $default Default value if setting doesn't exist.
	 * @return mixed
	 */
	public function get_setting($key, $default = '')
	{
		$settings = $this->get_settings();
		return isset($settings[$key]) ? $settings[$key] : $default;
	}

	public function get_account_name()
	{
		return home_url() . "/";
	}

	/**
	 * Update settings by merging with existing ones.
	 * Only updates the keys that are provided in the $new_settings parameter.
	 * Existing keys that are not in $new_settings remain unchanged.
	 *
	 * @param array $new_settings New settings array to merge.
	 * @return bool Whether the settings were updated successfully.
	 */
	public function update_settings($new_settings)
	{
		try {
			// Get current settings
			$current_settings = $this->get_settings();

			// Merge new settings with current settings
			// array_merge maintains existing keys if they no están en $new_settings
			$merged_settings = array_merge($current_settings, $new_settings);

			// Update cache
			$this->settings = $merged_settings;

			// Save to database
			$result = update_option($this->settings_key, $merged_settings);
			bluex_log('info', 'Settings updated: ' . json_encode($merged_settings));
			return $result;
		} catch (Exception $e) {
			bluex_log('error', $e->getMessage());
			return false;
		}
	}

	/**
	 * Update a specific setting.
	 *
	 * @param string $key Setting key.
	 * @param mixed $value Setting value.
	 * @return bool
	 */
	public function update_setting($key, $value)
	{
		try {
			$settings = $this->get_settings();
			$settings[$key] = $value;
			$result = $this->update_settings($settings);
			bluex_log('info', 'Setting updated: ' . $key . ' = ' . $value);
			return $result;
		} catch (Exception $e) {
			bluex_log('error', $e->getMessage());
			return false;
		}
	}

	/**
	 * Delete a specific setting.
	 *
	 * @param string $key Setting key.
	 * @return bool
	 */
	public function delete_setting($key)
	{
		try {
			$settings = $this->get_settings();
			if (isset($settings[$key])) {
				unset($settings[$key]);
				$result = $this->update_settings($settings);
				bluex_log('info', 'Setting deleted: ' . $key);
				return $result;
			}
			return false;
		} catch (Exception $e) {
			bluex_log('error', $e->getMessage());
			return false;
		}
	}

	// Dev mode controlado por flag de build y setting almacenado
	/**
	 * Get development mode.
	 *
	 * Retorna true solo si:
	 * - El build fue realizado con --debug (define('BLUEX_DEBUG', true)), y
	 * - En ajustes, devOptions está habilitado ("yes").
	 *
	 * @return bool
	 */
	public function get_dev_mode()
	{
		$settings = $this->get_settings();
		$dev_options = isset($settings['devOptions']) ? $settings['devOptions'] : 'no';

		return (defined('BLUEX_DEBUG') && BLUEX_DEBUG === true) && ($dev_options === 'yes');
	}

	/**
	 * Get tracking bxkey.
	 *
	 * @return string
	 */
	public function get_tracking_bxkey()
	{
		$apiKeyBase = "QUoO07ZRZ12tzkkF8yJM9am7uhxUJCbR7f6kU5Dz";
		// $apiKeyBaseOld = "W6FGzkovqEQaklVLCgzXKNt5UPJiqWml";
		$dev_mode = $this->get_dev_mode();
		$key = $dev_mode ? $this->get_setting('tracking_bxkey') : $apiKeyBase;
		return $key ? $key : $apiKeyBase;
	}

	/**
	 * Get base path for API.
	 *
	 * @return string
	 */
	public function get_base_path()
	{
		$baseUrl = "https://eplin.api.blue.cl";
		// $baseUrlOld = "https://apigw.bluex.cl";
		$dev_mode = $this->get_dev_mode();
		$alternative_base_path = $this->get_setting('alternativeBasePath');
		return ($dev_mode && !empty($alternative_base_path))
			? $alternative_base_path
			: $baseUrl;
	}

	// Añade aquí más métodos específicos para obtener configuraciones comunes
}
