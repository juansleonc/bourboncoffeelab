<?php

/**
 * Correios Pudos Map.
 *
 * @package WooCommerce_Correios/Classes/pudos
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Correios pudos map class
 */
class WC_Correios_PudosMap
{
	// Global flag to prevent multiple renders across all instances
	private static $widget_rendered = false;

	protected $_basePathUrl;
	protected $_devMode;

	/**
	 * Initialize actions.
	 */
	public function __construct()
	{
		
		$configData = get_option('woocommerce_correios-integration_settings');
		
		if (isset($configData['pudoEnable']) && $configData['pudoEnable'] == "yes") {
			add_action('init', array($this, 'init'));
		} else {
			bluex_log('warning', 'PUDOS: PUDO NOT enabled. pudoEnable = ' . ($configData['pudoEnable'] ?? 'not set'));
		}
		
		// Comprobación con isset para evitar el error:
		$this->_devMode = isset($configData['devOptions']) && $configData['devOptions'] === "yes";

		// Decide the base path URL based on the devMode status
		if ($this->_devMode && !empty($configData['alternativeBasePath'])) {
			$this->_basePathUrl = $configData['alternativeBasePath'];
		} else {
			$this->_basePathUrl = 'https://eplin.api.blue.cl';
		}
		
	}

	/**
	 * Hook into various actions for frontend functionalities.
	 * Updated for modern WooCommerce compatibility.
	 */
	public function init()
	{		
		// Enqueue scripts and styles
		add_action('wp_enqueue_scripts', array($this, 'frontend_scripts'));
		
		// Use WooCommerce standard hooks according to official documentation
		// https://developer.woocommerce.com/docs/
		
		// Primary hook - after order review (right sidebar)
		add_action('woocommerce_review_order_after_order_total', array($this, 'render_shipping_selector_native'), 10);
		
		// Fallback for themes that don't follow WooCommerce standards (only if native doesn't render)
		add_action('wp_footer', array($this, 'render_shipping_selector_optimized'), 10);
		
		// Render hidden inputs
		add_action('woocommerce_checkout_after_order_review', array($this, 'render_custom_input'), 10);
		
		// Handle form processing
		add_action('woocommerce_checkout_update_order_meta', array($this, 'save_custom_input_to_order_meta'), 10);
		
		// AJAX handlers
		add_action('wp_ajax_clear_shipping_cache', array($this, 'clear_shipping_cache'));
		add_action('wp_ajax_nopriv_clear_shipping_cache', array($this, 'clear_shipping_cache'));
		
		// Add checkout validation
		add_action('woocommerce_checkout_process', array($this, 'validate_checkout_fields'));
		
		// Add custom checkout fields to order review
		add_action('woocommerce_checkout_update_order_review', array($this, 'update_order_review_callback'));
		
	}

	/**
	 * Enqueue scripts on checkout page.
	 * Updated for modern WooCommerce compatibility.
	 */
	public function frontend_scripts()
	{
		// Skip if using Blocks Checkout
		if (has_block('woocommerce/checkout')) {
			return;
		}

		if (is_checkout()) {
			$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
			
			// Enqueue the main script with proper dependencies
			wp_enqueue_script(
				'bluex-checkout-pudo', 
				plugins_url('assets/js/frontend/custom-checkout-map' . $suffix . '.js', WC_Correios::get_main_file()), 
				array('jquery', 'wc-checkout'), 
				WC_CORREIOS_VERSION ?? '1.0.0', 
				true
			);
			
			// Localize script with AJAX URL and nonce for security
			wp_localize_script('bluex-checkout-pudo', 'bluex_checkout_params', array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('bluex_checkout_nonce'),
				'widget_base_urls' => array(
					'prod' => 'https://widget-pudo.blue.cl',
					'qa' => 'https://widget-pudo.qa.blue.cl',
					'dev' => 'https://widget-pudo.dev.blue.cl'
				),
				'base_path_url' => $this->_basePathUrl
			));
			
		}
	}
	/**
	 * Render custom hidden input fields.
	 */
	function render_custom_input()
	{
?>
		<input type="hidden" name="agencyId" id="agencyId" placeholder="" value='' />
		<input type="hidden" name="isPudoSelected" id="isPudoSelected" placeholder="" value='' />
	<?php
	}
	/**
	 * Save custom input values to order meta.
	 *
	 * @param int $order_id The order ID.
	 */

	function save_custom_input_to_order_meta($order_id)
	{
		// Retrieve the order object using WooCommerce function
		$order = wc_get_order($order_id);
		// Define the fields you want to check and update
		$fields_to_update = ['agencyId', 'isPudoSelected'];

		foreach ($fields_to_update as $field) {
			// Check if the field exists in the POST request
			if (isset($_POST[$field])) {
				// Sanitize the 'agencyId' field to ensure clean data; other fields are directly used
				$value = $field === 'agencyId' ? sanitize_text_field($_POST[$field]) : $_POST[$field];
				// Check if the order object has the 'update_meta_data' method for compatibility
				if (method_exists($order, 'update_meta_data')) {
					// Update the order meta data with the field value
					$order->update_meta_data($field, $value);
					// Save the changes to the order
					$order->save();
				} else {
					// Fallback for older WooCommerce versions: directly update post meta
					update_post_meta($order_id, $field, $value);
				}
			}
		}
	}

	/**
	 * Native WooCommerce hook-based renderer following official documentation
	 * https://developer.woocommerce.com/docs/
	 */
	public function render_shipping_selector_native()
	{
		// Skip if using Blocks Checkout
		if (has_block('woocommerce/checkout')) {
			return;
		}
		
		// CRITICAL: Check global flag to prevent ANY duplicate rendering
		if (self::$widget_rendered) {
			bluex_log('warning', 'PUDOS: Widget already rendered globally, preventing duplicate');
			return;
		}
		
		// Set global flag immediately to prevent race conditions
		self::$widget_rendered = true;
		
		// CRITICAL: Remove this action immediately to prevent WooCommerce AJAX from calling it again
		remove_action('woocommerce_review_order_after_order_total', array($this, 'render_shipping_selector_native'), 10);
		
		// Get current values from session or POST data
		$isPudoSelected = false;
		$agencyId = null;
		
		if (WC()->session) {
			$isPudoSelected = WC()->session->get('bluex_pudo_selected', false);
			$agencyId = WC()->session->get('bluex_agency_id', null);
		}
		
		// Check POST data for updates
		if (!empty($_POST['post_data'])) {
		$output = [];
			parse_str($_POST['post_data'], $output);
		$isPudoSelected = isset($output['isPudoSelected']) && $output['isPudoSelected'] == "pudoShipping";
			$agencyId = !empty($output['agencyId']) ? sanitize_text_field($output['agencyId']) : null;
		}
		
		// Render the widget using WooCommerce-compatible markup
		?>
		<div id="bluex-shipping-selector-native" class="woocommerce-checkout-section" style="margin: 20px 0; padding: 15px; border: 1px solid #e0e0e0; border-radius: 4px; background-color: #fff;">
			<h3 style="margin-top: 0; font-size: 16px; margin-bottom: 10px;">
				<?php _e('Método de Entrega', 'woocommerce-correios'); ?>
			</h3>
			
			<div class="bluex-shipping-options" style="margin: 10px 0;">
				<label class="bluex-shipping-option" style="display: flex !important; flex-direction: row !important; align-items: center !important; margin: 10px 0; cursor: pointer;">
					<input type="radio"
						   id="normalShipping_native"
						   name="shippingBlue"
						   value="normalShipping"
						   <?php checked(!$isPudoSelected); ?>
						   style="margin-right: 10px; width: auto !important;"
						   onchange="selectShipping('normalShipping')">
					<span style="font-size: 14px;">Envío a Domicilio</span>
				</label>

				<label class="bluex-shipping-option" style="display: flex !important; flex-direction: row !important; align-items: center !important; margin: 10px 0; cursor: pointer;">
					<input type="radio"
						   id="pudoShipping_native"
						   name="shippingBlue"
						   value="pudoShipping"
						   <?php checked($isPudoSelected); ?>
						   style="margin-right: 10px; width: auto !important;"
						   onchange="selectShipping('pudoShipping')">
					<span style="font-size: 14px;">Retiro en Punto Blue Express</span>
				</label>
			</div>

			<div id="bluex-pudo-widget-container-native" style="<?php echo $isPudoSelected ? 'display: block;' : 'display: none;'; ?> margin-top: 15px; border: 1px solid #e0e0e0; border-radius: 4px; overflow: hidden; background-color: white;">
				<div id="widget-content-native" style="min-height: 500px; position: relative;">
					<?php if ($isPudoSelected): ?>
						<?php $this->render_pudo_widget_native($agencyId); ?>
					<?php else: ?>
						<p style="padding: 20px; text-align: center; color: #666; font-style: italic;">
							<?php _e('Cargando mapa de puntos Blue Express...', 'woocommerce-correios'); ?>
						</p>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<script type="text/javascript">
		// CRITICAL: Aggressive duplicate prevention for AJAX contexts
		(function() {
			// Mark document that widget has been rendered
			if (!document.bluexWidgetRendered) {
				document.bluexWidgetRendered = true;
				console.log('BlueX PUDOS: First widget marked in document');
			}
			
			// Immediate duplicate check and removal
			var removeDuplicates = function() {
				var nativeWidgets = document.querySelectorAll('#bluex-shipping-selector-native');
				if (nativeWidgets.length > 1) {
					console.warn('BlueX PUDOS: Found ' + nativeWidgets.length + ' native widgets, removing duplicates...');
					// Keep first, remove all others
					for (var i = 1; i < nativeWidgets.length; i++) {
						nativeWidgets[i].remove();
						console.log('BlueX PUDOS: Removed duplicate widget #' + i);
					}
				}
			};
			
			// Run immediately
			removeDuplicates();
			
			// Setup MutationObserver to catch AJAX-added duplicates
			var observer = new MutationObserver(function(mutations) {
				mutations.forEach(function(mutation) {
					if (mutation.addedNodes.length > 0) {
						mutation.addedNodes.forEach(function(node) {
							if (node.nodeType === 1 && (node.id === 'bluex-shipping-selector-native' ||
								(node.querySelector && node.querySelector('#bluex-shipping-selector-native')))) {
								console.warn('BlueX PUDOS: Detected duplicate widget being added via AJAX, removing...');
								setTimeout(removeDuplicates, 10);
							}
						});
					}
				});
			});
			
			// Observe the order review section for changes
			var orderReview = document.querySelector('#order_review, .woocommerce-checkout-review-order');
			if (orderReview) {
				observer.observe(orderReview.parentElement || document.body, {
					childList: true,
					subtree: true
				});
				console.log('BlueX PUDOS: MutationObserver active to prevent AJAX duplicates');
			}
			
			// jQuery enhancement after DOM ready
			jQuery(document).ready(function($) {
				// Final cleanup
				removeDuplicates();
				
				// Add hover effects for native widget
				// Removed hover effects for cleaner look
			});
		})();
		</script>
		<?php
		
	}

	/**
	 * Optimized render method for better placement in checkout (fallback only)
	 */
	public function render_shipping_selector_optimized()
	{
		// Only render on checkout page
		if (!is_checkout()) {
			return;
		}

		// Skip if using Blocks Checkout
		if (has_block('woocommerce/checkout')) {
			return;
		}
		
		// Check if we already rendered via normal hooks
		static $optimized_rendered = false;
		if ($optimized_rendered) {
			return;
		}
		$optimized_rendered = true;

		// Use JavaScript to inject the widget ONLY if native widget doesn't exist
		?>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			// Check if native widget already exists
			if ($('#bluex-shipping-selector-native').length > 0) {
				console.log('BlueX PUDOS: Native widget found, skipping optimized render');
				return;
			}
			
			console.log('BlueX PUDOS: Native widget NOT found, using optimized fallback render');
			
			// Target selectors for right sidebar placement (after order summary)
			var targetSelectors = [
				'#order_review', // Order review section - right sidebar
				'.woocommerce-checkout-review-order', // Order review wrapper
				'.shop_table.woocommerce-checkout-review-order-table', // Order table
				'.woocommerce-checkout-review-order-table', // Order table fallback
				'#order_review_heading', // Order review heading
				'.checkout-review-order-table', // Some themes
				'[id*="order_review"]', // Any element with order_review in ID
				'.woocommerce-checkout .col-2', // Right column in checkout
				'form.checkout .col-2' // Right column fallback
			];
			
			var injected = false;
			for (var i = 0; i < targetSelectors.length; i++) {
				var target = $(targetSelectors[i]);
				if (target.length > 0 && !injected) {
					console.log('BlueX PUDOS: Found optimized target:', targetSelectors[i]);
					
					// Insert after the order review section in right sidebar
					target.after(`
						<div id="bluex-shipping-selector-optimized" class="woocommerce-checkout-section" style="margin: 20px 0; padding: 15px; border: 1px solid #e0e0e0; border-radius: 4px; background-color: #fff;">
							<h3 style="margin-top: 0; font-size: 16px; margin-bottom: 10px;">
								Método de Entrega
							</h3>
							
							<div class="bluex-shipping-options" style="margin: 10px 0;">
								<label class="bluex-shipping-option" style="display: flex !important; flex-direction: row !important; align-items: center !important; margin: 10px 0; cursor: pointer;">
									<input type="radio" id="normalShipping_opt" name="shippingBlue" value="normalShipping" checked style="margin-right: 10px; width: auto !important;" onchange="selectShipping('normalShipping')">
									<span style="font-size: 14px;">Envío a Domicilio</span>
								</label>

								<label class="bluex-shipping-option" style="display: flex !important; flex-direction: row !important; align-items: center !important; margin: 10px 0; cursor: pointer;">
									<input type="radio" id="pudoShipping_opt" name="shippingBlue" value="pudoShipping" style="margin-right: 10px; width: auto !important;" onchange="selectShipping('pudoShipping')">
									<span style="font-size: 14px;">Retiro en Punto Blue Express</span>
								</label>
							</div>

							<div id="bluex-pudo-widget-container-optimized" style="display: none; margin-top: 15px; border: 1px solid #e0e0e0; border-radius: 4px; overflow: hidden; background-color: white;">
								<div id="widget-content-optimized" style="min-height: 500px; position: relative;">
									<p style="padding: 20px; text-align: center; color: #666; font-style: italic;">
										Cargando mapa de puntos Blue Express...
									</p>
								</div>
							</div>
						</div>
						<!-- Hidden inputs required by JavaScript -->
						<input type="hidden" name="agencyId" id="agencyId" value="" />
						<input type="hidden" name="isPudoSelected" id="isPudoSelected" value="" />
					`);
					
					// Add hover effects
					// Removed hover effects for cleaner look
					
					injected = true;
					break;
				}
			}
			
			if (!injected) {
				console.warn('BlueX PUDOS: No suitable target found for optimized render');
				
				// Try alternative approach - find right column and append
				var rightColumn = $('.woocommerce-checkout .col-2, form.checkout .col-2, .checkout-review-order');
				if (rightColumn.length > 0) {
					console.log('BlueX PUDOS: Found right column, appending widget');
					rightColumn.append(`
						<div id="bluex-shipping-selector-optimized" class="woocommerce-checkout-section" style="margin: 20px 0; padding: 15px; border: 1px solid #e0e0e0; border-radius: 4px; background-color: #fff;">
							<h3 style="margin-top: 0; font-size: 16px; margin-bottom: 10px;">
								Método de Entrega
							</h3>
							
							<div class="bluex-shipping-options" style="margin: 10px 0;">
								<label class="bluex-shipping-option" style="display: flex !important; flex-direction: row !important; align-items: center !important; margin: 10px 0; cursor: pointer;">
									<input type="radio" id="normalShipping_opt2" name="shippingBlue" value="normalShipping" checked style="margin-right: 10px; width: auto !important;" onchange="selectShipping('normalShipping')">
									<span style="font-size: 14px;">Envío a Domicilio</span>
								</label>

								<label class="bluex-shipping-option" style="display: flex !important; flex-direction: row !important; align-items: center !important; margin: 10px 0; cursor: pointer;">
									<input type="radio" id="pudoShipping_opt2" name="shippingBlue" value="pudoShipping" style="margin-right: 10px; width: auto !important;" onchange="selectShipping('pudoShipping')">
									<span style="font-size: 14px;">Retiro en Punto Blue Express</span>
								</label>
							</div>

							<div id="bluex-pudo-widget-container-optimized" style="display: none; margin-top: 15px; border: 1px solid #e0e0e0; border-radius: 4px; overflow: hidden; background-color: white;">
								<div id="widget-content-optimized" style="min-height: 500px; position: relative;">
									<p style="padding: 20px; text-align: center; color: #666; font-style: italic;">
										Cargando mapa de puntos Blue Express...
									</p>
								</div>
							</div>
						</div>
						<!-- Hidden inputs required by JavaScript -->
						<input type="hidden" name="agencyId" id="agencyId" value="" />
						<input type="hidden" name="isPudoSelected" id="isPudoSelected" value="" />
					`);
					injected = true;
				}
			}
			
			if (injected) {
				console.log('BlueX PUDOS: Optimized widget injected successfully');
			} else {
				console.error('BlueX PUDOS: Failed to inject optimized widget anywhere');
			}
		});
		</script>
		<?php
		
	}

	/**
	 * Native PUDO widget renderer for WooCommerce hooks
	 *
	 * @param string|null $agencyId Selected agency ID.
	 */
	public function render_pudo_widget_native($agencyId = null)
	{
		
		$widgetUrl = $this->getWidgetURL($this->_basePathUrl, $agencyId);
		?>
		<iframe 
			id="bluex-pudo-iframe-native" 
			src="<?php echo esc_url($widgetUrl); ?>" 
			frameborder="0" 
			style="width: 100%; height: 500px; border: none; background-color: white;"
			title="<?php _e('Selector de Punto Blue Express', 'woocommerce-correios'); ?>"
			onload="console.log('BlueX PUDO native iframe loaded successfully');"
			onerror="console.error('BlueX PUDO native iframe failed to load');">
			<p style="padding: 20px; text-align: center; color: #666;">
				<?php _e('Tu navegador no soporta iframes.', 'woocommerce-correios'); ?>
				<a href="<?php echo esc_url($widgetUrl); ?>" target="_blank">
					<?php _e('Abrir widget en nueva ventana', 'woocommerce-correios'); ?>
				</a>
			</p>
		</iframe>
<?php
	}

	/**
	 * Handle checkout field validation.
	 */
	public function validate_checkout_fields()
	{
		if (isset($_POST['shippingBlue']) && $_POST['shippingBlue'] === 'pudoShipping') {
			if (empty($_POST['agencyId'])) {
				wc_add_notice(__('Por favor selecciona un punto Blue Express.', 'woocommerce-correios'), 'error');
			}
		}
	}

	/**
	 * Handle order review updates via AJAX.
	 */
	public function update_order_review_callback($post_data)
	{
		if (!wp_verify_nonce($_POST['security'] ?? '', 'update-order-review')) {
			return;
		}

		parse_str($post_data, $data);
		
		if (WC()->session) {
			// Store PUDO selection in session
			$isPudoSelected = isset($data['shippingBlue']) && $data['shippingBlue'] === 'pudoShipping';
			WC()->session->set('bluex_pudo_selected', $isPudoSelected);
			
			if ($isPudoSelected && !empty($data['agencyId'])) {
				WC()->session->set('bluex_agency_id', sanitize_text_field($data['agencyId']));
			} else {
				WC()->session->__unset('bluex_agency_id');
			}
		}
	}

	/**
	 * Clear the shipping cache - updated for modern WooCommerce.
	 */
	public function clear_shipping_cache()
	{
		// Verify nonce for security
		if (!wp_verify_nonce($_POST['nonce'] ?? '', 'bluex_checkout_nonce')) {
			wp_send_json_error('Invalid nonce');
			return;
		}

		if (WC()->cart && WC()->session) {
		$packages = WC()->cart->get_shipping_packages();

		foreach ($packages as $package_key => $package) {
			WC()->session->__unset('shipping_for_package_' . $package_key);
			}
			
			// Clear WooCommerce transients
			wc_delete_shop_order_transients();
		}

		wp_send_json_success('Shipping cache cleared.');
	}


	/**
	 * Retrieves the widget URL based on the provided domain, appending additional parameters if present.
	 * 
	 * The function analyzes the domain to determine if it belongs to the 'qa' or 'dev' environments.
	 * It also appends the Google key and/or agency ID as query parameters if they are not empty.
	 *
	 * @param string $domain The domain to analyze.
	 * @param string|null $agencyId The agency ID to append to the URL as a parameter.
	 * @return string The URL of the widget corresponding to the environment with additional parameters if applicable.
	 */
	function getWidgetURL($domain, $agencyId = null)
	{
		// Define a regular expression to detect 'qa' or 'dev' in the domain
		// Pattern matches: https://eplin.api.blue.cl (prod), https://eplin.api.qa.blue.cl (qa), https://eplin.api.dev.blue.cl (dev)
		$pattern = '/https:\/\/eplin\.api\.(?:(qa|dev)\.)?blue\.cl/';

		// Use preg_match to extract the environment part if it matches the pattern
		preg_match($pattern, $domain, $matches);

		// Determine the environment; default to production if not 'qa' or 'dev'
		$environment = $matches[1] ?? '';

		// Map environment to respective base URL
		$urls = [
			'qa'  => 'https://widget-pudo.qa.blue.cl',
			'dev' => 'https://widget-pudo.dev.blue.cl',
			''    => 'https://widget-pudo.blue.cl', // Default case (production)
		];

		// Start with the base URL
		$url = $urls[$environment];

		// Initialize query parameters array
		$queryParams = [];


		// Append the agency ID if it is not null or empty
		if (!empty($agencyId)) {
			$queryParams['id'] = $agencyId;
		}

		// Append query parameters to the URL if any exist
		if (!empty($queryParams)) {
			$url .= '?' . http_build_query($queryParams);
		}

		return $url;
	}
}

new WC_Correios_PudosMap();
