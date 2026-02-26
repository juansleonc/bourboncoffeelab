<?php

declare(strict_types=1);

/**
 * Correios Webservice.
 *
 * @package WooCommerce_Correios/Classes/Webservice
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Correios Webservice integration class.
 */
class WC_Correios_Webservice
{


	/**
	 * Shipping method ID.
	 *
	 * @var string
	 */
	protected $id = '';

	/**
	 * Shipping zone instance ID.
	 *
	 * @var int
	 */
	protected $instance_id = 0;

	/**
	 * ID from Correios service.
	 *
	 * @var string|array
	 */
	protected $service = '';

	/**
	 * WooCommerce package containing the products.
	 *
	 * @var array
	 */
	protected $package = null;

	/**
	 * Origin postcode.
	 *
	 * @var string
	 */
	protected $origin_postcode = '';

	/**
	 * Destination postcode.
	 *
	 * @var string
	 */
	protected $destination_postcode = '';

	/**
	 * Login.
	 *
	 * @var string
	 */
	protected $login = '';

	/**
	 * Password.
	 *
	 * @var string
	 */
	protected $password = '';

	/**
	 * Package height.
	 *
	 * @var float
	 */
	protected $height = 0;

	/**
	 * Package width.
	 *
	 * @var float
	 */
	protected $width = 0;

	/**
	 * Package diameter.
	 *
	 * @var float
	 */
	protected $diameter = 0;

	/**
	 * Package length.
	 *
	 * @var float
	 */
	protected $length = 0;

	/**
	 * Package weight.
	 *
	 * @var float
	 */
	protected $weight = 0;

	/**
	 * Minimum height.
	 *
	 * @var float
	 */
	protected $minimum_height = 0.1;

	/**
	 * Minimum width.
	 *
	 * @var float
	 */
	protected $minimum_width = 0.1;

	/**
	 * Minimum length.
	 *
	 * @var float
	 */
	protected $minimum_length = 0.1;

	/**
	 * Extra weight.
	 *
	 * @var float
	 */
	protected $extra_weight = 0;

	/**
	 * Declared value.
	 *
	 * @var string
	 */
	protected $declared_value = '0';

	/**
	 * Own hands.
	 *
	 * @var string
	 */
	protected $own_hands = 'N';

	/**
	 * Receipt notice.
	 *
	 * @var string
	 */
	protected $receipt_notice = 'N';

	/**
	 * Package format.
	 *
	 * 1 – box/package
	 * 2 – roll/prism
	 * 3 - envelope
	 *
	 * @var string
	 */
	protected $format = '1';

	/**
	 * Debug mode.
	 *
	 * @var string
	 */
	protected $debug = 'no';

	/**
	 * Logger.
	 *
	 * @var WC_Logger
	 */
	protected $log = null;
	protected $_basePathUrl;
	protected $_configData;
	protected $_blueApikey;
	protected $_pudoEnabled;
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
	 * Initialize webservice.
	 *
	 * @param string $id Method ID.
	 * @param int    $instance_id Instance ID.
	 */
	public function __construct($id = 'correios', $instance_id = 0)
	{
		$this->id           = $id;
		$this->instance_id  = $instance_id;
		$this->log          = new WC_Logger();
		$this->setupConfig();
		// Initialize API client
		$this->api_client = new BlueX_API_Client();
	}
	private function setupConfig()
	{
		// Fetch configuration data from WooCommerce settings
		$this->_configData = $this->get_settings_handler()->get_settings();
		// API Key and Base Path are now handled by the API Client, getting them here is redundant.
		// $this->_blueApikey = $this->get_settings_handler()->get_tracking_bxkey();
		$this->_devMode = $this->get_settings_handler()->get_dev_mode();
		// $this->_basePathUrl = $this->get_settings_handler()->get_base_path();
		$this->_pudoEnabled = $this->_configData['pudoEnable'] ?? 'no';
	}

	/**
	 * Set the service
	 *
	 * @param string|array $service Service.
	 */
	public function set_service($service = '')
	{
		if (is_array($service)) {
			$this->service = implode(',', $service);
		} else {
			$this->service = $service;
		}
	}

	/**
	 * Set shipping package.
	 *
	 * @param array $package Shipping package.
	 */
	public function set_package($package = array())
	{
		$this->package = $package;
		$correios_package = new WC_Correios_Package($package);

		if (!is_null($correios_package)) {
			$data = $correios_package->get_data();

			$this->set_height($data['height']);
			$this->set_width($data['width']);
			$this->set_length($data['length']);
			$this->set_weight($data['weight']);
		}

		if ('yes' === $this->debug) {
			if (!empty($data)) {
				$data = array(
					'weight' => $this->get_weight(),
					'height' => $this->get_height(),
					'width'  => $this->get_width(),
					'length' => $this->get_length(),
				);
			}

			$this->log->add($this->id, 'Weight and cubage of the order: ' . print_r($data, true));
		}
	}

	/**
	 * Set origin postcode.
	 *
	 * @param string $postcode Origin postcode.
	 */
	public function set_origin_postcode($postcode = '')
	{
		$this->origin_postcode = $postcode;
	}

	/**
	 * Set destination postcode.
	 *
	 * @param string $postcode Destination postcode.
	 */
	public function set_destination_postcode($postcode = '')
	{
		$this->destination_postcode = $postcode;
	}

	/**
	 * Set login.
	 *
	 * @param string $login User login.
	 */
	public function set_login($login = '')
	{
		$this->login = $login;
	}

	/**
	 * Set password.
	 *
	 * @param string $password User login.
	 */
	public function set_password($password = '')
	{
		$this->password = $password;
	}

	/**
	 * Set shipping package height.
	 *
	 * @param float $height Package height.
	 */
	public function set_height($height = 0)
	{
		$this->height = (float) $height;
	}

	/**
	 * Set shipping package width.
	 *
	 * @param float $width Package width.
	 */
	public function set_width($width = 0)
	{
		$this->width = (float) $width;
	}

	/**
	 * Set shipping package diameter.
	 *
	 * @param float $diameter Package diameter.
	 */
	public function set_diameter($diameter = 0)
	{
		$this->diameter = (float) $diameter;
	}

	/**
	 * Set shipping package length.
	 *
	 * @param float $length Package length.
	 */
	public function set_length($length = 0)
	{
		$this->length = (float) $length;
	}

	/**
	 * Set shipping package weight.
	 *
	 * @param float $weight Package weight.
	 */
	public function set_weight($weight = 0)
	{
		$this->weight = (float) $weight;
	}

	/**
	 * Set minimum height.
	 *
	 * @param float $minimum_height Package minimum height.
	 */
	public function set_minimum_height($minimum_height = 1)
	{
		$this->minimum_height = 1 <= $minimum_height ? $minimum_height : 1;
	}

	/**
	 * Set minimum width.
	 *
	 * @param float $minimum_width Package minimum width.
	 */
	public function set_minimum_width($minimum_width = 1)
	{
		$this->minimum_width = 1 <= $minimum_width ? $minimum_width : 1;
	}

	/**
	 * Set minimum length.
	 *
	 * @param float $minimum_length Package minimum length.
	 */
	public function set_minimum_length($minimum_length = 1)
	{
		$this->minimum_length = 1 <= $minimum_length ? $minimum_length : 1;
	}

	/**
	 * Set extra weight.
	 *
	 * @param float $extra_weight Package extra weight.
	 */
	public function set_extra_weight($extra_weight = 0)
	{
		$this->extra_weight = (float) wc_format_decimal($extra_weight);
	}

	/**
	 * Set declared value.
	 *
	 * @param string $declared_value Declared value.
	 */
	public function set_declared_value($declared_value = '0')
	{
		$this->declared_value = $declared_value;
	}

	/**
	 * Set own hands.
	 *
	 * @param string $own_hands Use 'N' for no and 'S' for yes.
	 */
	public function set_own_hands($own_hands = 'N')
	{
		$this->own_hands = $own_hands;
	}
	public function set_receipt_notice($receipt_notice = 'N')
	{
		$this->receipt_notice = $receipt_notice;
	}
	public function set_format($format = '1')
	{
		$this->format = $format;
	}
	public function set_debug($debug = 'no')
	{
		$this->debug = $debug;
	}
	public function get_origin_postcode()
	{
		return apply_filters('woocommerce_correios_origin_postcode', $this->origin_postcode, $this->id, $this->instance_id, $this->package);
	}
	public function get_height()
	{
		return $this->float_to_string($this->minimum_height <= $this->height ? $this->height : $this->minimum_height);
	}
	public function get_width()
	{
		return $this->float_to_string($this->minimum_width <= $this->width ? $this->width : $this->minimum_width);
	}
	public function get_diameter()
	{
		return $this->float_to_string($this->diameter);
	}
	public function get_length()
	{
		return $this->float_to_string($this->minimum_length <= $this->length ? $this->length : $this->minimum_length);
	}
	public function get_weight()
	{
		return $this->float_to_string($this->weight + $this->extra_weight);
	}
	protected function float_to_string($value)
	{
		try {
			if (!is_string($value)) {
				$value = (string) $value;
			}
			$value = str_replace('.', ',', $value);
			return $value;
		} catch (\Throwable $e) {
			if (function_exists('bluex_log')) {
				bluex_log('error', 'float_to_string error: ' . $e->getMessage());
			} elseif ($this->log instanceof WC_Logger) {
				$this->log->error('float_to_string error: ' . $e->getMessage(), array('source' => $this->id));
			}
			return (string) $value;
		}
	}
	/**
	 * Get the shipping details.
	 * 
	 * @return object|null The shipping details or null if an error occurs.
	 */
	public function get_shipping()
	{
		global $wp;
		// Convert POST data string into an associative array.
		if (isset($_POST['post_data'])) {
			parse_str($_POST['post_data'], $output);
		}

		// Extract the 'agencyId' value if present.
		$agencyId = (isset($output['agencyId']) && $output['agencyId'] != "") ? sanitize_text_field($output['agencyId']) : null;

		// Default fallback response structure
		$default_shipping = (
			(object) [
				'Codigo'           => $this->service,
				'Valor'            => '0,00',
				'PrazoEntrega'     => '0',
				'Erro'             => '-888',
				'MsgErro'          => 'Erro ao calcular tarifa. Tente novamente mais tarde. Servidores indisponíveis.',
				'nameService'      => '', // Add default for nameService
				'isShipmentFree'   => false, // Add default for isShipmentFree
			]
		);

		// Check if package contents exist
		if (!isset($this->package['contents'])) {
			return $default_shipping;
		}

		$bultos = [];
		$price = 0.0;
		foreach ($this->package['contents'] as $indice => $items) {
			$data = $items['data'];
			if (!$data instanceof WC_Product) continue; // Skip if not a product

			$ancho = (float) $data->get_width();
			$largo = (float) $data->get_length();
			$alto = (float) $data->get_height();
			$peso = (float) $data->get_weight();
			$price += (float) $data->get_price('edit') * (int) $items['quantity']; // Use get_price for accuracy

			$ancho = $this->isEmptyOrZero($ancho) ? 10.0 : $ancho;
			$largo = $this->isEmptyOrZero($largo) ? 10.0 : $largo;
			$alto = $this->isEmptyOrZero($alto) ? 10.0 : $alto;
			$pesoFisico = $this->isEmptyOrZero($peso) ? 0.010 : $peso;

			$bultos[] = [
				"ancho"      => (int) $ancho, // API expects integer?
				"largo"      => (int) $largo,
				"alto"       => (int) $alto,
				"pesoFisico" => (float) $pesoFisico,
				"cantidad"   => (int) $items['quantity']
			];
		}

		// Get user data (origin info mainly)
		$userData = $this->get_settings_handler()->get_settings();
		if (empty($userData['districtCode'])) {
			bluex_log('error', 'Origin districtCode not configured in settings.');
			return $default_shipping;
		}

		// Destination details
		$destination = $this->package['destination'] ?? [];
		$regionCodeToFormat = $destination['state'] ?? '';
		$city_normalized = $this->normalizeString($destination['city'] ?? '');

		if (empty($regionCodeToFormat) || empty($city_normalized)) {
			bluex_log('error', 'Destination state or city is missing in the package.');
			return $default_shipping;
		}

		$regionCode = '';
		$siglas = 'CL-';
		if (strpos($regionCodeToFormat, $siglas) === 0) {
			$regionCode = substr($regionCodeToFormat, strlen($siglas));
		} else {
			$regionCode = $regionCodeToFormat;
		}

		// Get Geolocation data
		$bxGeoResult = $this->getComunasGeo($city_normalized, $regionCode, $agencyId);

		if (is_wp_error($bxGeoResult) || empty($bxGeoResult)) {
			bluex_log('error', 'Failed to get geolocation data or bxGeo data is empty. Error: ' . (is_wp_error($bxGeoResult) ? $bxGeoResult->get_error_message() : 'Empty response'));
			return $default_shipping;
		}

		if (isset($bxGeoResult["porcentageDeExito"])) {
			$percentage = (int) rtrim($bxGeoResult["porcentageDeExito"], "%");
			if ($percentage < 80) {
				bluex_log('warning', 'Geolocation match percentage too low ({$percentage}%). Aborting calculation.');
				return $default_shipping;
			}
		}

		$dadosGeo = [
			'regionCode'   => $bxGeoResult['regionCode'] ?? null,
			'cidadeName'   => $bxGeoResult['cidadeName'] ?? null,
			'cidadeCode'   => $bxGeoResult['cidadeCode'] ?? null,
			'districtCode' => $bxGeoResult['districtCode'] ?? null,
		];

		if (empty($dadosGeo['regionCode']) || empty($dadosGeo['districtCode'])) {
			bluex_log('error', 'Geolocation data missing regionCode or districtCode after processing bxGeo response.');
			return $default_shipping;
		}

		// Fetch the price
		$familiaProducto = $agencyId ? 'PUDO' : 'PAQU';
		$nameService = "";
		if ($agencyId) {
			if (empty($bxGeoResult['pickupInfo']['agency_name'])) {
				bluex_log('warning', 'PUDO selected but agency name is missing in geolocation response.');
				// Continue without agency name or return default? For now, continue.
			} else {
				$nameService = $bxGeoResult['pickupInfo']['agency_name'];
			}
		}

		if (WC()->cart) {
			$total_descuento = WC()->cart->get_discount_total();
			$price = $price - $total_descuento;
		}
		bluex_log('info', "Log de precio enviado al pricing" . $price);

		$pricingResponse = $this->fetchPrice($userData, $dadosGeo, $bultos, $familiaProducto, $price);

		bluex_log('info', 'Pricing API response: ' . print_r($pricingResponse, true));

		if (is_wp_error($pricingResponse) || empty($pricingResponse['data'])) {
			bluex_log('error', 'Failed to fetch pricing. Error: ' . (is_wp_error($pricingResponse) ? $pricingResponse->get_error_message() : 'Empty data in response'));
			return $default_shipping;
		}

		$pricingData = $pricingResponse['data'];

		// Update shipping details based on response
		if (($pricingResponse['code'] ?? null) == "00" || ($pricingResponse['code'] ?? null) == "01") {
			$shipping = $default_shipping; // Start with default structure
			$shipping->Codigo = $this->service;
			$shipping->Valor = (int) ($pricingData['total'] ?? 0);
			$shipping->PrazoEntrega = (string) ($pricingData['promiseDay'] ?? '0');
			$shipping->nameService = empty($nameService) ? ($pricingData['nameService'] ?? '') : $nameService;
			$shipping->isShipmentFree = (bool) ($pricingData['isShipmentFree'] ?? false);
			$shipping->Erro = 0;
			$shipping->MsgErro = '';

			if ($shipping->isShipmentFree) {
				$shipping->nameService .= " - Envío gratis";
			}
		} else {
			// Use default error if API response code is not 00 or 01
			bluex_log('error', 'Pricing API returned non-success code: ' . ($pricingResponse['code'] ?? 'N/A') . ' - Message: ' . ($pricingResponse['message'] ?? 'N/A'));
			$shipping = $default_shipping;
			$shipping->MsgErro = $pricingResponse['message'] ?? $default_shipping->MsgErro;
			$shipping->Erro = $pricingResponse['code'] ?? $default_shipping->Erro;
		}

		// Cleanup unnecessary properties from default structure (they are not used by WC)
		unset(
			$shipping->EntregaDomiciliar, // These were from the old hardcoded json
			$shipping->EntregaSabado,
			$shipping->obsFim,
			$shipping->ValorSemAdicionais,
			$shipping->ValorMaoPropria,
			$shipping->ValorAvisoRecebimento,
			$shipping->ValorValorDeclarado
		);

		return $shipping;
	}
	/**
	 * Normalize a string by replacing specific characters.
	 * 
	 * @param string $string The original string.
	 * @return string The normalized string.
	 */
	private function normalizeString($string)
	{
		$from = ['Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª', 'É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê', 'Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î', 'Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô', 'Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û', 'Ñ', 'ñ', 'Ç', 'ç'];
		$to = ['A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a', 'E', 'E', 'E', 'E', 'e', 'e', 'e', 'e', 'I', 'I', 'I', 'I', 'i', 'i', 'i', 'i', 'O', 'O', 'O', 'O', 'o', 'o', 'o', 'o', 'U', 'U', 'U', 'U', 'u', 'u', 'u', 'u', 'N', 'n', 'C', 'c'];
		return str_replace($from, $to, $string);
	}

	private function get_tracking_bxkey($userData)
	{
		return $this->get_settings_handler()->get_tracking_bxkey();
	}

	/**
	 * Fetch the price for a given shipping using BlueX_API_Client.
	 * 
	 * @param array $userData Origin user settings.
	 * @param array $dadosGeo Destination geographical details.
	 * @param array $bultos Package contents.
	 * @param string $familiaProducto Product family type ('PAQU' or 'PUDO').
	 * @param float $price Declared value (total price of items).
	 * @return array|WP_Error API response array or WP_Error on failure.
	 */
	private function fetchPrice(array $userData, array $dadosGeo, array $bultos, string $familiaProducto, float $price)
	{
		if (!$this->api_client) {
			bluex_log('error', 'API Client not initialized in fetchPrice');
			return new WP_Error('client_error', 'API Client not initialized.');
		}

		$from = [
			"country" => "CL",
			"district" => $userData['districtCode'] ?? 'SCL' // Default to SCL if not set
		];

		$to = [
			"country" => "CL",
			"state" => $dadosGeo['regionCode'] ?? null,
			"district" => $dadosGeo['districtCode'] ?? null
		];

		if (empty($to['state']) || empty($to['district'])) {
			bluex_log('error', 'Missing state or district code in destination for pricing request.');
			return new WP_Error('param_error', 'Missing destination state or district.');
		}

		// Pass $userData to get_pricing for potential user-specific API key logic
		return $this->api_client->get_pricing($from, $to, $this->service, $bultos, $price, $familiaProducto, $userData);
	}

	/**
	 * Get geographical details for a 'comuna' using BlueX_API_Client.
	 * 
	 * @param string $city_normalized Normalized city name.
	 * @param string $regionCode Region code.
	 * @param string|null $agencyId Agency ID (optional, for PUDO).
	 * @return array|WP_Error API response array or WP_Error on failure.
	 */
	private function getComunasGeo(string $city_normalized, string $regionCode, ?string $agencyId)
	{
		if (!$this->api_client) {
			bluex_log('error', 'API Client not initialized in getComunasGeo');
			return new WP_Error('client_error', 'API Client not initialized.');
		}

		$is_pudo = ($this->_pudoEnabled === 'yes');

		return $this->api_client->get_geolocation($city_normalized, $regionCode, $agencyId, $is_pudo);
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
	function get_url()
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
	 * Checks if a given value is empty or equivalent to zero.
	 * This includes checks for "0", "0.0", "0.000", etc., in both string and float formats.
	 * 
	 * @param mixed $value The value to check.
	 * @return bool True if the value is empty or equivalent to zero, false otherwise.
	 */
	function isEmptyOrZero($value)
	{
		return empty($value) || floatval($value) == 0;
	}
}
