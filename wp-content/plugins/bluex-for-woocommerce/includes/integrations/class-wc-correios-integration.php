<?php

declare(strict_types=1);

/**
 * Correios integration.
 *
 * @package WooCommerce_Correios/Classes/Integration
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Correios integration class.
 */
class WC_Correios_Integration extends WC_Integration
{
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
	 * Initialize integration actions.
	 */
	public function __construct()
	{
		$this->id           = 'correios-integration';
		$this->method_title = __('Blue Express', 'woocommerce-correios');
		$this->method_description = __('Página de configuración para integrar tu tienda WooCommerce con <a href="https://ecommerce.blue.cl/" target="_blank">Blue Express</a>.', 'woocommerce-correios');

		// Initialize API client first
		$this->api_client = new BlueX_API_Client();

		// Load the form fields.
		$this->init_form_fields();

		// Load the settings (this uses the settings handler which is now safe to call).
		$this->init_settings();

		// Load settings into properties (consider removing if only used via handler)
		$this->load_settings_from_handler();

		// Actions.
		add_action('woocommerce_update_options_integration_' . $this->id, array($this, 'process_admin_options'));
		add_action('wp_ajax_test_correios_integration', array($this, 'ajax_test_correios_integration')); // Changed method name for clarity

		// Tracking history actions.
		add_filter('woocommerce_correios_enable_tracking_history', array($this, 'setup_tracking_history'), 10);
		add_filter('woocommerce_correios_enable_tracking_debug', array($this, 'setup_tracking_debug'), 10);

		// Autofill address actions.
		add_filter('woocommerce_correios_enable_autofill_addresses', array($this, 'setup_autofill_addresses'), 10);
		add_filter('woocommerce_correios_enable_autofill_addresses_debug', array($this, 'setup_autofill_addressesDebug'), 10);
		add_filter('woocommerce_correios_autofill_addresses_validity_time', array($this, 'setup_autofill_addressesValidityTime'), 10);
		add_filter('woocommerce_correios_autofill_addresses_force_autofill', array($this, 'setup_autofill_addressesForceAutofill'), 10);
		add_action('wp_ajax_correios_autofill_addresses_empty_database', array($this, 'ajax_empty_database'));

		// Register AJAX actions
		add_action('wp_ajax_validate_integration_is_active', array($this, 'ajax_validate_integration_is_active'));
		add_action('wp_ajax_nopriv_validate_integration_is_active', array($this, 'ajax_validate_integration_is_active'));

		add_action('wp_ajax_update_integration_credentials', array($this, 'ajax_update_integration_credentials'));
		add_action('wp_ajax_nopriv_update_integration_credentials', array($this, 'ajax_update_integration_credentials'));

		add_action('wp_ajax_save_integration_settings', array($this, 'ajax_save_integration_settings'));

		add_action('wp_ajax_get_integration_settings', array($this, 'ajax_get_integration_settings')); // Need to implement this AJAX handler

		add_action('wp_ajax_save_developer_settings', array($this, 'ajax_save_developer_settings'));
	}

	/**
	 * Load settings from the handler into class properties.
	 * Consider if these properties are truly needed or if using the handler directly is better.
	 */
	private function load_settings_from_handler()
	{
		$settings_handler = $this->get_settings_handler();
		$this->tracking_bxkey          = $settings_handler->get_tracking_bxkey(); // Needed?
		$this->noBlueStatus          	= $settings_handler->get_setting('noBlueStatus');
		$this->districtCode          	= $settings_handler->get_setting('districtCode');
		$this->pudoEnable          = $settings_handler->get_setting('pudoEnable');
		$this->devOptions          = $settings_handler->get_setting('devOptions');
		$this->alternativeBasePath        = $settings_handler->get_setting('alternativeBasePath'); // Needed?
		$this->districtsEnable          = $settings_handler->get_setting('districtsEnable');
		$this->account_name          = $settings_handler->get_account_name(); // Needed?
		$this->active_logs          = $settings_handler->get_setting('active_logs');

		$this->tracking_enable         = $settings_handler->get_setting('tracking_enable');
		$this->tracking_debug          = $settings_handler->get_setting('tracking_debug');
		$this->autofill_enable         = $settings_handler->get_setting('autofill_enable');
		$this->autofill_validity       = $settings_handler->get_setting('autofill_validity');
		$this->autofill_force          = $settings_handler->get_setting('autofill_force');
		$this->autofill_empty_database = $settings_handler->get_setting('autofill_empty_database');
		$this->autofill_debug          = $settings_handler->get_setting('autofill_debug');
	}

	protected function get_tracking_log_link()
	{
		return ' <a href="' . esc_url(admin_url('admin.php?page=wc-status&tab=logs&log_file=correios-tracking-history-' . sanitize_file_name(wp_hash('correios-tracking-history')) . '.log')) . '">' . __('View logs.', 'woocommerce-correios') . '</a>';
	}

	public function init_form_fields()
	{
		$this->form_fields = array(
			'check_integration' => array(
				'title'       => __('Probar integración', 'woocommerce-correios'),
				'type'        => 'button',
				'description' => __('Haz clic para probar la integración con Blue Express. Ten en cuenta que es necesario guardar los datos requeridos en la integración antes de proceder con la prueba.', 'woocommerce-correios'),
				'desc_tip'    => true,
				'label'       => __('Probar integración', 'woocommerce-correios'),
			),
			'account_name' => array(
				'title'       => __('Nombre de la cuenta (Account name)', 'woocommerce-correios'),
				'type'        => 'text',
				'description' => __('El nombre de tu cuenta (Account name), que debe coincidir con el configurado en el portal de Blue Express.', 'woocommerce-correios'),
				'desc_tip'    => true,
				'default'     => home_url() . "/",
				'custom_attributes' => array(
					'readonly' => 'readonly',
				),
			),
			'tracking_bxkey' => array(
				'title'       => __('Clave API de Blue Express', 'woocommerce-correios'),
				'type'        => 'text',
				'description' => __('Tu clave API proporcionada por Blue Express.', 'woocommerce-correios'),
				'desc_tip'    => true,
				'default'     => '',
			),
			'districtCode' => array(
				'title'       => __('Código del distrito de la tienda', 'woocommerce-correios'),
				'type'        => 'text',
				'description' => __('El código del distrito de tu tienda. Ejemplo: ARI.', 'woocommerce-correios'),
				'desc_tip'    => true,
				'default'     => '',
			),
			'noBlueStatus' => array(
				'title'       => __('Estado de emisión de OS', 'woocommerce-correios'),
				'type'        => 'select',
				'description' => __('Selecciona el estado en el que el pedido será enviado a Blue Express. Ejemplo: Pendiente.', 'woocommerce-correios'),
				'desc_tip'    => true,
				'default'     => 'wc-shipping-progress',
				'options'     => wc_get_order_statuses(),
			),
			'pudoEnable' => array(
				'title'       => __('Habilitar funcionalidad de puntos de recogida', 'woocommerce-correios'),
				'type'        => 'checkbox',
				'description' => __('Habilita la funcionalidad de puntos de recogida. Marca la casilla para habilitar.', 'woocommerce-correios'),
				'desc_tip'    => true,
				'label'       => __('Marcar para habilitar', 'woocommerce-correios'),
				'default'     => 'no',
			),
			'districtsEnable' => array(
				'title'       => __('Habilitar funcionalidad de distritos', 'woocommerce-correios'),
				'type'        => 'checkbox',
				'description' => __('Habilita la funcionalidad de distritos en el checkout para convertir la región y las ciudades en listas desplegables. Marca la casilla para habilitar.', 'woocommerce-correios'),
				'desc_tip'    => true,
				'label'       => __('Marcar para habilitar', 'woocommerce-correios'),
				'default'     => 'no',
			),
		);


		if (defined('DEV_OPTIONS') && DEV_OPTIONS) {
			$this->form_fields['devOptions'] = array(
				'title'       => __('Habilitar opciones de desarrollo', 'woocommerce-correios'),
				'type'        => 'checkbox',
				'description' => __('Habilita las funcionalidades de opciones de desarrollo. Ej: Marcar = Sí', 'woocommerce-correios'),
				'desc_tip'    => true,
				'label'       => 'Marcar para habilitar',
				'default'     => 'no',
			);

			$this->form_fields['alternativeBasePath'] = array(
				'title'       => __('Ruta base alternativa', 'woocommerce-correios'),
				'type'        => 'text',
				'description' => __('Tu ruta base alternativa.', 'woocommerce-correios'),
				'desc_tip'    => true,
				'default'     => 'https://eplin.api.bluex.cl',
			);
		}
	}

	/**
	 * Correios options page.
	 */
	public function admin_options()
	{
		echo '<div id="integration-react-form"></div>';
		$GLOBALS['hide_save_button'] = true;

		include WC_Correios::get_plugin_path() . 'includes/admin/views/html-admin-help-message.php';

		// Add BlueX Zones Configuration section
		// $this->display_zones_configuration_section();

		/* if (class_exists('SoapClient')) {
			echo '<div><input type="hidden" name="section" value="' . esc_attr($this->id) . '" /></div>';
			echo '<table class="form-table">' . $this->generate_settings_html($this->get_form_fields(), false) . '</table>'; // WPCS: XSS ok.
		} else {
			$GLOBALS['hide_save_button'] = true; // Hide save button.
			/* translators: %s: SOAP documentation link */
		/*			echo '<div class="notice notice-error inline"><p>' . sprintf(esc_html__('It\'s required have installed the %s on your server in order to integrate with the services of the Correios!', 'woocommerce-correios'), '<a href="https://secure.php.net/manual/book.soap.php" target="_blank" rel="nofollow noopener noreferrer">' . esc_html__('SOAP module', 'woocommerce-correios') . '</a>') . '</p></div>';
		} */

		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		$script_path = plugins_url('assets/js/admin/integration' . $suffix . '.js', WC_Correios::get_main_file());

		// CSS Path
		$css_path = plugins_url('assets/css/admin/bluex-integration.css', WC_Correios::get_main_file());

		// Agregar log para debug
		error_log('Correios Integration Script Path: ' . $script_path);
		error_log('Correios Integration CSS Path: ' . $css_path);
		echo '<script>console.log("Correios Integration Script Path: ' . $script_path . '");</script>';
		echo '<script>console.log("Correios Integration CSS Path: ' . $css_path . '");</script>';

		// Registra el script principal sin dependencias de jQuery
		wp_enqueue_script($this->id . '-admin', $script_path, array(), time(), true);

		// Registra el CSS
		wp_enqueue_style(
			$this->id . '-admin-style',
			$css_path,
			array(), // sin dependencias
			time() // versión dinámica para evitar cache
		);

		// Pasa variables PHP al JavaScript para su uso
		wp_localize_script(
			$this->id . '-admin',
			'WCCorreiosIntegrationAdminParams',
			array(
				'i18n_confirm_message' => __('Are you sure you want to delete all postcodes from the database?', 'woocommerce-correios'),
				'empty_database_nonce' => wp_create_nonce('woocommerce_correios_autofill_addresses_nonce'),
				'ajax_url' => admin_url('admin-ajax.php'), // URL para peticiones AJAX
				'nonce'    => wp_create_nonce('correios_integration_nonce'), // Token de seguridad para AJAX
				'rest_url' => rest_url('wc-bluex/v1/'), // URL base para REST API
				'rest_nonce' => wp_create_nonce('wp_rest') // Token de seguridad para REST API
			)
		);
	}

	/**
	 * Generate Button Input HTML.
	 *
	 * @param string $key  Input key.
	 * @param array  $data Input data.
	 * @return string
	 */
	public function generate_button_html($key, $data)
	{
		$field    = $this->plugin_id . $this->id . '_' . $key;
		$defaults = array(
			'class'             => 'button-secondary',
			'css'               => '',
			'custom_attributes' => array(),
			'desc_tip'          => false,
			'description'       => '',
			'title'             => '',
		);

		$data = wp_parse_args($data, $defaults);

		ob_start();
?>
		<tr valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr($field); ?>"><?php echo wp_kses_post($data['title']); ?></label>
				<?php echo $this->get_tooltip_html($data); ?>
			</th>
			<td class="forminp">
				<fieldset>
					<legend class="screen-reader-text"><span><?php echo wp_kses_post($data['title']); ?></span></legend>
					<button class="<?php echo esc_attr($data['class']); ?>" type="button" name="<?php echo esc_attr($field); ?>" id="<?php echo esc_attr($field); ?>" style="<?php echo esc_attr($data['css']); ?>" <?php echo $this->get_custom_attribute_html($data); ?>><?php echo wp_kses_post($data['title']); ?></button>
					<?php echo $this->get_description_html($data); ?>
					<div id="integration-message" style="display:none; margin-top:10px;"></div>
				</fieldset>
			</td>
		</tr>
	<?php
		return ob_get_clean();
	}

	/**
	 * Display zones configuration section
	 */
	public function display_zones_configuration_section()
	{
		if (!class_exists('WC_BlueX_Zones_Validator')) {
			return;
		}

		echo '<div class="bluex-zones-configuration-section">';
		echo '<h2><span class="dashicons dashicons-admin-site-alt3" style="margin-right: 8px;"></span>Configuración de Zonas de Envío BlueExpress</h2>';

		// Show validation results
		echo '<div id="bluex-zones-validation-results">';
		$validation_results = WC_BlueX_Zones_Validator::validate_configuration();
		echo WC_BlueX_Zones_Validator::generate_html_report($validation_results);
		echo '</div>';

		// Add refresh button
		echo '<div style="margin-top: 15px;">';
		echo '<button type="button" class="button" id="bluex-refresh-validation">';
		echo '<span class="dashicons dashicons-update" style="margin-right: 5px;"></span>';
		echo 'Actualizar Validación';
		echo '</button>';
		echo '</div>';

		echo '</div>';

		// Add JavaScript for refresh functionality
	?>
		<script>
			jQuery(document).ready(function($) {
				// Refresh validation
				$('#bluex-refresh-validation').click(function() {
					var $btn = $(this);
					$btn.prop('disabled', true).find('.dashicons').addClass('fa-spin');

					$.post(ajaxurl, {
							action: 'bluex_validate_zones',
							nonce: '<?php echo wp_create_nonce('bluex_validate_zones'); ?>'
						})
						.done(function(response) {
							if (response.success) {
								$('#bluex-zones-validation-results').html(response.data.html);
							} else {
								alert('Error al actualizar la validación: ' + response.data);
							}
						})
						.fail(function() {
							alert('Error de conexión al actualizar la validación.');
						})
						.always(function() {
							$btn.prop('disabled', false).find('.dashicons').removeClass('fa-spin');
						});
				});
			});
		</script>

		<style>
			.bluex-zones-configuration-section {
				background: white;
				border: 1px solid #ccd0d4;
				border-radius: 4px;
				padding: 20px;
				margin-top: 20px;
			}

			.bluex-zones-configuration-section h2 {
				margin-top: 0;
				color: #2271b1;
				border-bottom: 1px solid #e5e5e5;
				padding-bottom: 10px;
			}

			.fa-spin {
				animation: spin 1s linear infinite;
			}

			@keyframes spin {
				0% {
					transform: rotate(0deg);
				}

				100% {
					transform: rotate(360deg);
				}
			}
		</style>
<?php
	}

	/**
	 * Enable tracking history.
	 *
	 * @return bool
	 */
	public function setup_tracking_history()
	{
		return 'yes' === $this->tracking_enable && class_exists('SoapClient');
	}



	/**
	 * Set up tracking debug.
	 *
	 * @return bool
	 */
	public function setup_tracking_debug()
	{
		return 'yes' === $this->tracking_debug;
	}

	/**
	 * Enable autofill addresses.
	 *
	 * @return bool
	 */
	public function setup_autofill_addresses()
	{
		return 'yes' === $this->autofill_enable && class_exists('SoapClient');
	}

	/**
	 * Set up autofill addresses debug.
	 *
	 * @return bool
	 */
	public function setup_autofill_addressesDebug()
	{
		return 'yes' === $this->autofill_debug;
	}

	/**
	 * Set up autofill addresses validity time.
	 *
	 * @return string
	 */
	public function setup_autofill_addressesValidityTime()
	{
		return $this->autofill_validity;
	}

	/**
	 * Set up autofill addresses force autofill.
	 *
	 * @return string
	 */
	public function setup_autofill_addressesForceAutofill()
	{
		return $this->autofill_force;
	}

	/**
	 * Ajax empty database.
	 */
	public function ajax_empty_database()
	{
		try {
			global $wpdb;

			if (!isset($_POST['nonce'])) { // WPCS: input var okay, CSRF ok.
				bluex_log('error', 'Missing nonce in ajax_empty_database');
				wp_send_json_error(array('message' => __('Missing parameters!', 'woocommerce-correios')));
				exit;
			}

			if (!wp_verify_nonce(sanitize_key(wp_unslash($_POST['nonce'])), 'woocommerce_correios_autofill_addresses_nonce')) { // WPCS: input var okay, CSRF ok.
				bluex_log('error', 'Invalid nonce in ajax_empty_database');
				wp_send_json_error(array('message' => __('Invalid nonce!', 'woocommerce-correios')));
				exit;
			}

			$table_name = $wpdb->prefix . WC_Correios_AutofillAddresses::$table;
			$wpdb->query("DROP TABLE IF EXISTS $table_name;"); // @codingStandardsIgnoreLine

			WC_Correios_AutofillAddresses::create_database();

			bluex_log('info', 'Database table emptied successfully: ' . $table_name);
			wp_send_json_success(array('message' => __('Postcode database emptied successfully!', 'woocommerce-correios')));
		} catch (Exception $e) {
			bluex_log('error', 'Exception in ajax_empty_database: ' . $e->getMessage());
			wp_send_json_error(array('message' => 'Error interno del servidor: ' . $e->getMessage()));
		}
	}

	/**
	 * AJAX handler for testing the integration via API call.
	 */
	public function ajax_test_correios_integration()
	{
		try {
			check_ajax_referer('correios_integration_nonce', 'nonce');

			if (!$this->api_client) {
				throw new Exception('API Client not initialized.');
			}

			// Prepare test data
			$from = [
				'country'  => 'CL',
				'district' => $this->get_settings_handler()->get_setting('districtCode'),
			];
			$to = [
				'country'  => 'CL',
				'state'    => '13', // Example state (Metropolitana)
				'district' => 'PRO', // Example district (Providencia?)
			];
			$bultos = [
				[
					'largo'       => 10,
					'ancho'       => 10,
					'alto'        => 10,
					'sku'         => 'TEST01',
					'pesoFisico'  => 1,
					'cantidad'    => 1,
				]
			];
			$service_type = 'EX'; // Example service type
			$familia_producto = 'PAQU';
			$declared_value = 10000.0; // Example declared value

			// Make API call using the client
			$response = $this->api_client->get_pricing($from, $to, $service_type, $bultos, $declared_value, $familia_producto);

			// Handle the response
			if (is_wp_error($response)) {
				bluex_log('error', 'Integration test (via API Client) failed: ' . $response->get_error_message());
				$this->get_settings_handler()->update_setting('test_pricing_query', false);
				wp_send_json_error($response->get_error_message());
			} else {
				// Assuming success if no WP_Error and response is an array
				bluex_log('info', 'Integration test (via API Client) successful - Response: ' . json_encode($response));
				$this->get_settings_handler()->update_setting('test_pricing_query', true);
				wp_send_json_success('Integración exitosa.');
				// Note: Original code checked response_code === 200. 
				// The client now handles HTTP errors, returning WP_Error.
				// Success here means the API call itself didn't fail at HTTP level and returned valid JSON.
				// Further checks on $response['code'] or $response['data'] could be added if needed.
			}
		} catch (Exception $e) {
			bluex_log('error', 'Exception in ajax_test_correios_integration: ' . $e->getMessage());
			$this->get_settings_handler()->update_setting('test_pricing_query', false);
			wp_send_json_error('Error interno del servidor: ' . $e->getMessage());
		}
	}

	/**
	 * Validate if the integration is active using API Client.
	 *
	 * @return array|WP_Error Formatted result array or WP_Error.
	 */
	public function validate_integration_status()
	{
		if (!$this->api_client) {
			return new WP_Error('client_error', 'API Client not initialized.');
		}

		$response = $this->api_client->validate_integration_status();

		if (is_wp_error($response)) {
			bluex_log('error', 'Integration status validation (via API Client) failed: ' . $response->get_error_message());
			return [
				'error'   => true,
				'message' => $response->get_error_message(),
			];
		} else {
			// Process the successful response (already logged by client)
			// Original logic for checking storeId and activeIntegration
			if (!isset($response['storeId'])) {
				return [
					'activeIntegration' => false,
					'errorCode'         => '00',
					'message'           => $response['message'] ?? 'Store ID not found in response.',
				];
			} elseif (!($response['activeIntegration'] ?? false)) {
				return [
					'activeIntegration' => false,
					'errorCode'         => '01',
					'message'           => $response['message'] ?? 'Integration is not active.',
					'storeId'           => $response['storeId'],
				];
			} else {
				return $response; // Return the full successful response
			}
		}
	}

	/**
	 * Update integration credentials using API Client.
	 *
	 * @param string $storeId
	 * @param array $credentials Array containing clientKey and clientSecret.
	 * @return array|WP_Error Result array or WP_Error.
	 */
	public function update_integration_credentials(string $storeId, array $credentials)
	{
		if (!$this->api_client) {
			return new WP_Error('client_error', 'API Client not initialized.');
		}

		$response = $this->api_client->update_integration_credentials($storeId, $credentials);

		if (is_wp_error($response)) {
			bluex_log('error', 'Credentials update (via API Client) failed: ' . $response->get_error_message());
			return [
				'error'   => true,
				'message' => $response->get_error_message(),
			];
		} else {
			// Process successful response (already logged by client)
			if (!($response['activeIntegration'] ?? false)) {
				return [
					'activeIntegration' => false,
					'errorCode'         => '01', // Assuming same error code as validation
					'message'           => $response['message'] ?? 'Credentials update successful, but integration inactive.',
				];
			} else {
				return $response; // Return the full successful response
			}
		}
	}

	/**
	 * AJAX handler for validating integration status.
	 */
	public function ajax_validate_integration_is_active()
	{
		try {
			check_ajax_referer('correios_integration_nonce', 'nonce');

			$result = $this->validate_integration_status();

			// If validation itself failed (WP_Error), send error directly
			if (is_wp_error($result)) {
				wp_send_json_error($result->get_error_message());
				return;
			}

			// Append settings info regardless of validation outcome (unless WP_Error)
			$settings_handler = $this->get_settings_handler();
			$result['settings'] = $settings_handler->get_settings();
			$order_statuses = wc_get_order_statuses();
			$result['optionsEmissionOs'] = array_map(function ($key, $label) {
				return ['value' => $key, 'label' => $label];
			}, array_keys($order_statuses), array_values($order_statuses));
			$result['account_name'] = $settings_handler->get_account_name();
			$result['getBasePath'] = $settings_handler->get_base_path();

			wp_send_json($result);
		} catch (Exception $e) {
			bluex_log('error', 'Exception in ajax_validate_integration_is_active: ' . $e->getMessage());
			wp_send_json_error('Error interno del servidor: ' . $e->getMessage());
		}
	}

	/**
	 * AJAX handler for updating integration credentials.
	 */
	public function ajax_update_integration_credentials()
	{
		try {
			check_ajax_referer('correios_integration_nonce', 'nonce');

			$storeId = isset($_POST['storeId']) ? sanitize_text_field(wp_unslash($_POST['storeId'])) : '';
			// Expecting clientKey and clientSecret within the credentials array
			$credentials_raw = isset($_POST['credentials']) ? wp_unslash($_POST['credentials']) : '';
			$credentials = json_decode($credentials_raw, true);

			if (empty($storeId) || empty($credentials) || !is_array($credentials) || !isset($credentials['clientKey']) || !isset($credentials['clientSecret'])) {
				bluex_log('error', 'Invalid parameters for ajax_update_integration_credentials. StoreID: ' . $storeId . ' Credentials Raw: ' . $credentials_raw);
				wp_send_json_error(['message' => __('Parámetros inválidos o faltantes (storeId, credentials with clientKey/clientSecret).', 'woocommerce-correios')]);
				return;
			}

			$result = $this->update_integration_credentials($storeId, $credentials);

			// Send the result (could be success array or error array/WP_Error)
			if (is_wp_error($result)) {
				wp_send_json_error($result->get_error_message());
			} elseif (isset($result['error']) && $result['error'] === true) {
				wp_send_json_error($result['message']); // Send API client processed error message
			} else {
				wp_send_json_success($result); // Send full success response
			}
		} catch (Exception $e) {
			bluex_log('error', 'Exception in ajax_update_integration_credentials: ' . $e->getMessage());
			wp_send_json_error('Error interno del servidor: ' . $e->getMessage());
		}
	}

	/**
	 * AJAX handler for saving integration settings.
	 * Note: This doesn't directly call the external API, but updates local settings.
	 * It calls the test integration function AFTER saving.
	 */
	public function ajax_save_integration_settings()
	{
		try {
			check_ajax_referer('correios_integration_nonce', 'nonce');

			if (!current_user_can('manage_woocommerce')) {
				bluex_log('error', 'Unauthorized attempt to save integration settings');
				wp_send_json_error(['message' => __('No tienes permiso para realizar esta acción.', 'woocommerce-correios')]);
				return;
			}

			$settings_handler = $this->get_settings_handler();
			$settings = $settings_handler->get_settings();

			// Sanitize and update settings from POST data
			$settings['noBlueStatus'] = isset($_POST['noBlueStatus']) ? sanitize_text_field(wp_unslash($_POST['noBlueStatus'])) : $settings['noBlueStatus'];
			$settings['districtCode'] = isset($_POST['districtCode']) ? sanitize_text_field(wp_unslash($_POST['districtCode'])) : $settings['districtCode'];
			$settings['pudoEnable'] = isset($_POST['pudoEnable']) ? sanitize_key(wp_unslash($_POST['pudoEnable'])) : $settings['pudoEnable']; // Should be 'yes' or 'no'
			$settings['districtsEnable'] = isset($_POST['districtsEnable']) ? sanitize_key(wp_unslash($_POST['districtsEnable'])) : $settings['districtsEnable']; // Should be 'yes' or 'no'
			$settings['active_logs'] = isset($_POST['active_logs']) ? sanitize_key(wp_unslash($_POST['active_logs'])) : $settings['active_logs']; // Should be 'yes' or 'no'

			bluex_log('info', 'Saving integration settings: ' . json_encode($settings));

			$settings_handler->update_settings($settings);
			$this->load_settings_from_handler(); // Reload properties if needed

			// Run the integration test *after* saving settings successfully
			// We don't send the test result back directly here anymore, 
			// the test runs and logs its outcome. Frontend can trigger test separately if needed.
			$this->run_integration_test_silently();

			wp_send_json_success(['message' => __('Configuración guardada exitosamente.', 'woocommerce-correios')]);
		} catch (Exception $e) {
			bluex_log('error', 'Exception in ajax_save_integration_settings: ' . $e->getMessage());
			wp_send_json_error(['message' => 'Error interno del servidor: ' . $e->getMessage()]);
		}
	}

	/**
	 * Runs the integration test without sending JSON response (for use after saving settings).
	 */
	private function run_integration_test_silently()
	{
		try {
			if (!$this->api_client) {
				throw new Exception('API Client not initialized.');
			}

			// Prepare test data (same as in ajax_test_correios_integration)
			$from = ['country' => 'CL', 'district' => $this->get_settings_handler()->get_setting('districtCode')];
			$to = ['country' => 'CL', 'state' => '13', 'district' => 'PRO'];
			$bultos = [['largo' => 10, 'ancho' => 10, 'alto' => 10, 'sku' => 'TEST01', 'pesoFisico' => 1, 'cantidad' => 1]];
			$service_type = 'EX';
			$familia_producto = 'PAQU';
			$declared_value = 10000.0;

			$response = $this->api_client->get_pricing($from, $to, $service_type, $bultos, $declared_value, $familia_producto);

			if (is_wp_error($response)) {
				bluex_log('error', 'Post-save integration test failed: ' . $response->get_error_message());
				$this->get_settings_handler()->update_setting('test_pricing_query', false);
			} else {
				bluex_log('info', 'Post-save integration test successful - Response: ' . json_encode($response));
				$this->get_settings_handler()->update_setting('test_pricing_query', true);
			}
		} catch (Exception $e) {
			bluex_log('error', 'Exception in run_integration_test_silently: ' . $e->getMessage());
			$this->get_settings_handler()->update_setting('test_pricing_query', false);
		}
	}


	/**
	 * AJAX handler for getting integration settings.
	 * This is called by the React frontend.
	 */
	public function ajax_get_integration_settings()
	{
		try {
			check_ajax_referer('correios_integration_nonce', 'nonce'); // Add nonce check

			if (!current_user_can('manage_woocommerce')) {
				bluex_log('error', 'Unauthorized attempt to get integration settings');
				wp_send_json_error(['message' => __('No tienes permiso para realizar esta acción.', 'woocommerce-correios')]);
				return;
			}

			$settings_handler = $this->get_settings_handler();
			$settings_data = $settings_handler->get_settings();
			$options_emission_os_raw = wc_get_order_statuses();
			$options_emission_os = array_map(function ($key, $label) {
				return ['value' => $key, 'label' => $label];
			}, array_keys($options_emission_os_raw), array_values($options_emission_os_raw));
			$account_name = $settings_handler->get_account_name();
			$base_path = $settings_handler->get_base_path();

			wp_send_json_success([
				'settings' => $settings_data,
				'optionsEmissionOs' => $options_emission_os,
				'account_name' => $account_name,
				'getBasePath' => $base_path
			]);
		} catch (Exception $e) {
			bluex_log('error', 'Exception in ajax_get_integration_settings: ' . $e->getMessage());
			wp_send_json_error(['message' => 'Error interno del servidor: ' . $e->getMessage()]);
		}
	}

	/**
	 * AJAX handler for saving developer settings.
	 */
	public function ajax_save_developer_settings()
	{
		try {
			check_ajax_referer('correios_integration_nonce', 'nonce');

			// Verifica los permisos del usuario
			if (!current_user_can('manage_woocommerce')) {
				bluex_log('error', 'Unauthorized attempt to save developer settings');
				wp_send_json_error(array('message' => __('No tienes permiso para realizar esta acción.', 'woocommerce-correios')));
				return;
			}

			// Procesa y guarda las opciones de desarrollo
			$devOptions = isset($_POST['devOptions']) ? wp_unslash($_POST['devOptions']) : 'no';
			$alternativeBasePath = isset($_POST['alternativeBasePath']) ? esc_url_raw(wp_unslash($_POST['alternativeBasePath'])) : '';
			$tracking_bxkey = isset($_POST['tracking_bxkey']) ? $_POST['tracking_bxkey'] : '';

			$settings = $this->get_settings_handler()->get_settings();
			$settings['devOptions'] = $devOptions;
			$settings['alternativeBasePath'] = $alternativeBasePath;
			$settings['tracking_bxkey'] = $tracking_bxkey;

			bluex_log('info', 'Saving developer settings: ' . json_encode($settings));

			$this->get_settings_handler()->update_settings($settings);

			wp_send_json_success(array('message' => __('Configuración de desarrollo guardada exitosamente.', 'woocommerce-correios')));
		} catch (Exception $e) {
			bluex_log('error', 'Exception in ajax_save_developer_settings: ' . $e->getMessage());
			wp_send_json_error(array('message' => 'Error interno del servidor: ' . $e->getMessage()));
		}
	}

	/**
	 * Process admin options.
	 */
	public function process_admin_options()
	{
		try {
			parent::process_admin_options();

			// Actualizar las configuraciones en el handler
			bluex_log('info', 'Processing admin options and updating settings: ' . json_encode($this->settings));
			$this->get_settings_handler()->update_settings($this->settings);
		} catch (Exception $e) {
			bluex_log('error', 'Exception in process_admin_options: ' . $e->getMessage());
			throw $e; // Re-throw para mantener el comportamiento original de WooCommerce
		}
	}
}
