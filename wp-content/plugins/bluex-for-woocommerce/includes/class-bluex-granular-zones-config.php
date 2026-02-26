<?php

/**
 * BlueX Granular Zones Configuration
 * 
 * Herramienta para configurar zonas de envío granulares de BlueExpress
 * permitiendo seleccionar métodos específicos y ubicaciones detalladas.
 * 
 * @package WooCommerce_Correios/GranularConfig
 * @author Blue Express 
 * @version 1.0.0
 * @since 3.1.1
 */

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

/**
 * BlueX Granular Zones Configuration Class
 */
class WC_BlueX_Granular_Zones_Config
{
    /**
     * Initialize the granular configuration
     */
    public static function init()
    {
        // Add AJAX handler for granular zone creation
        add_action('wp_ajax_bluex_create_granular_zones', array(__CLASS__, 'ajax_create_granular_zones'));



        // Add debug action to verify initialization
        add_action('init', function () {
            if (defined('WP_DEBUG') && WP_DEBUG) {
                error_log('BlueX Granular Zones Config initialized');
            }
        });
    }

    /**
     * Get available BlueX shipping methods
     * 
     * @return array Array of available BlueX methods with details
     */
    public static function get_available_bluex_methods()
    {
        $methods = array(
            'bluex-ex' => array(
                'id' => 'bluex-ex',
                'name' => 'BlueX Express',
                'description' => 'Entrega rápida y segura para envíos urgentes',
                'class' => 'WC_BlueX_EX',
                'code' => 'EX'
            ),
            'bluex-py' => array(
                'id' => 'bluex-py',
                'name' => 'BlueX Prioritario',
                'description' => 'Envío prioritario con tiempos de entrega optimizados',
                'class' => 'WC_BlueX_PY',
                'code' => 'PY'
            ),
            'bluex-md' => array(
                'id' => 'bluex-md',
                'name' => 'BlueX SameDay',
                'description' => 'Entrega el mismo día para máxima urgencia',
                'class' => 'WC_BlueX_MD',
                'code' => 'MD'
            )
        );

        // Validate that all method classes are available
        foreach ($methods as $method_id => &$method_data) {
            $method_data['class_exists'] = class_exists($method_data['class']);
            $method_data['registered'] = self::is_shipping_method_registered($method_id);
        }

        return $methods;
    }

    /**
     * Check if a shipping method is properly registered with WooCommerce
     * 
     * @param string $method_id The method ID to check
     * @return bool True if registered, false otherwise
     */
    public static function is_shipping_method_registered($method_id)
    {
        if (!function_exists('WC')) {
            return false;
        }

        $wc_shipping = WC()->shipping();
        if (!$wc_shipping) {
            return false;
        }

        $shipping_methods = $wc_shipping->get_shipping_methods();
        return isset($shipping_methods[$method_id]);
    }

    /**
     * Validate BlueX shipping methods setup
     * 
     * @return array Validation results
     */
    public static function validate_bluex_methods_setup()
    {
        $validation_results = array(
            'all_valid' => true,
            'issues' => array(),
            'methods_status' => array()
        );

        $available_methods = self::get_available_bluex_methods();

        foreach ($available_methods as $method_id => $method_data) {
            $method_status = array(
                'id' => $method_id,
                'name' => $method_data['name'],
                'class_exists' => $method_data['class_exists'],
                'registered' => $method_data['registered'],
                'valid' => true,
                'errors' => array()
            );

            // Check if class exists
            if (!$method_data['class_exists']) {
                $method_status['valid'] = false;
                $method_status['errors'][] = "Clase {$method_data['class']} no encontrada";
                $validation_results['all_valid'] = false;
                $validation_results['issues'][] = "Método {$method_id}: clase {$method_data['class']} no existe";
            }

            // Check if method is registered
            if (!$method_data['registered']) {
                $method_status['valid'] = false;
                $method_status['errors'][] = "Método no registrado en WooCommerce";
                $validation_results['all_valid'] = false;
                $validation_results['issues'][] = "Método {$method_id}: no registrado en WooCommerce";
            }

            // Additional validation for method class
            if ($method_data['class_exists']) {
                $class_name = $method_data['class'];
                if (class_exists($class_name)) {
                    // Check if the class extends the correct parent
                    if (!is_subclass_of($class_name, 'WC_Correios_Shipping')) {
                        $method_status['errors'][] = "La clase no extiende WC_Correios_Shipping correctamente";
                        $validation_results['issues'][] = "Método {$method_id}: herencia de clase incorrecta";
                    }
                }
            }

            $validation_results['methods_status'][$method_id] = $method_status;
        }

        return $validation_results;
    }

    /**
     * Generate granular zone configuration interface
     * 
     * @return string HTML for the configuration interface
     */
    public static function generate_granular_config_interface()
    {
        $available_methods = self::get_available_bluex_methods();

        $html = '<div id="bluex-granular-config-modal" class="bluex-modal" style="display: none;">';
        $html .= '<div class="bluex-modal-content">';
        $html .= '<div class="bluex-modal-header">';
        $html .= '<h3>🚀 Configuración Granular de Zonas BlueExpress</h3>';
        $html .= '<span class="bluex-modal-close">&times;</span>';
        $html .= '</div>';

        $html .= '<div class="bluex-modal-body">';
        $html .= '<p><strong>Selecciona los métodos de envío BlueExpress que deseas configurar en las zonas de envío:</strong></p>';

        $html .= '<div class="bluex-method-selection">';
        foreach ($available_methods as $method) {
            $html .= '<div class="bluex-method-item">';
            $html .= '<label>';
            $html .= '<input type="checkbox" name="bluex_methods[]" value="' . esc_attr($method['id']) . '" checked>';
            $html .= '<strong>' . esc_html($method['name']) . '</strong>';
            $html .= '<br><small>' . esc_html($method['description']) . '</small>';
            $html .= '</label>';
            $html .= '</div>';
        }
        $html .= '</div>';

        $html .= '<div class="bluex-zone-options">';
        $html .= '<h4>🗺️ Configuración de Zonas</h4>';
        $html .= '<label>';
        $html .= '<input type="radio" name="zone_strategy" value="create_new" checked>';
        $html .= ' Crear nuevas zonas específicas para BlueExpress';
        $html .= '</label><br>';
        $html .= '<label>';
        $html .= '<input type="radio" name="zone_strategy" value="add_to_existing">';
        $html .= ' Agregar a zonas existentes (donde sea compatible)';
        $html .= '</label><br>';
        $html .= '<label>';
        $html .= '<input type="radio" name="zone_strategy" value="replace_existing">';
        $html .= ' Reemplazar métodos existentes en zonas compatibles';
        $html .= '</label>';
        $html .= '</div>';

        $html .= '<div class="bluex-location-selection">';
        $html .= '<h4>📍 Ubicaciones de Cobertura</h4>';

        // Chile completo
        $html .= '<div style="margin-bottom: 15px; padding: 10px; background-color: #f0f8ff; border-left: 4px solid #2271b1; border-radius: 4px;">';
        $html .= '<label>';
        $html .= '<input type="checkbox" name="locations[]" value="CL" checked>';
        $html .= ' <strong>🇨🇱 Chile (País completo)</strong>';
        $html .= '</label>';
        $html .= '<br><small style="color: #666; font-style: italic;">⚠️ Si seleccionas Chile completo, las regiones individuales se deseleccionarán automáticamente</small>';
        $html .= '</div>';

        $html .= '<div style="margin-bottom: 10px; padding: 8px; background-color: #fff3cd; border: 1px solid #ffeaa7; border-radius: 4px;">';
        $html .= '<small><strong>💡 Tip:</strong> Selecciona Chile completo para una sola zona nacional, o regiones específicas para zonas granulares</small>';
        $html .= '</div>';

        // Regiones del Norte
        $html .= '<div style="margin-bottom: 10px;"><strong>Zona Norte:</strong></div>';
        $html .= '<label style="display: block; margin: 5px 0; padding-left: 20px;">';
        $html .= '<input type="checkbox" name="locations[]" value="CL:AP">';
        $html .= ' Región de Arica y Parinacota (XV)';
        $html .= '</label>';
        $html .= '<label style="display: block; margin: 5px 0; padding-left: 20px;">';
        $html .= '<input type="checkbox" name="locations[]" value="CL:TA">';
        $html .= ' Región de Tarapacá (I)';
        $html .= '</label>';
        $html .= '<label style="display: block; margin: 5px 0; padding-left: 20px;">';
        $html .= '<input type="checkbox" name="locations[]" value="CL:AN">';
        $html .= ' Región de Antofagasta (II)';
        $html .= '</label>';
        $html .= '<label style="display: block; margin: 5px 0; padding-left: 20px;">';
        $html .= '<input type="checkbox" name="locations[]" value="CL:AT">';
        $html .= ' Región de Atacama (III)';
        $html .= '</label>';
        $html .= '<label style="display: block; margin: 5px 0; padding-left: 20px;">';
        $html .= '<input type="checkbox" name="locations[]" value="CL:CO">';
        $html .= ' Región de Coquimbo (IV)';
        $html .= '</label>';

        // Regiones del Centro
        $html .= '<div style="margin: 15px 0 10px 0;"><strong>Zona Central:</strong></div>';
        $html .= '<label style="display: block; margin: 5px 0; padding-left: 20px;">';
        $html .= '<input type="checkbox" name="locations[]" value="CL:VS">';
        $html .= ' Región de Valparaíso (V)';
        $html .= '</label>';
        $html .= '<label style="display: block; margin: 5px 0; padding-left: 20px;">';
        $html .= '<input type="checkbox" name="locations[]" value="CL:RM">';
        $html .= ' <strong>Región Metropolitana (RM)</strong>';
        $html .= '</label>';
        $html .= '<label style="display: block; margin: 5px 0; padding-left: 20px;">';
        $html .= '<input type="checkbox" name="locations[]" value="CL:LI">';
        $html .= ' Región de O\'Higgins (VI)';
        $html .= '</label>';
        $html .= '<label style="display: block; margin: 5px 0; padding-left: 20px;">';
        $html .= '<input type="checkbox" name="locations[]" value="CL:ML">';
        $html .= ' Región del Maule (VII)';
        $html .= '</label>';
        $html .= '<label style="display: block; margin: 5px 0; padding-left: 20px;">';
        $html .= '<input type="checkbox" name="locations[]" value="CL:NB">';
        $html .= ' Región de Ñuble (XVI)';
        $html .= '</label>';

        // Regiones del Sur
        $html .= '<div style="margin: 15px 0 10px 0;"><strong>Zona Sur:</strong></div>';
        $html .= '<label style="display: block; margin: 5px 0; padding-left: 20px;">';
        $html .= '<input type="checkbox" name="locations[]" value="CL:BI">';
        $html .= ' Región del Biobío (VIII)';
        $html .= '</label>';
        $html .= '<label style="display: block; margin: 5px 0; padding-left: 20px;">';
        $html .= '<input type="checkbox" name="locations[]" value="CL:AR">';
        $html .= ' Región de La Araucanía (IX)';
        $html .= '</label>';
        $html .= '<label style="display: block; margin: 5px 0; padding-left: 20px;">';
        $html .= '<input type="checkbox" name="locations[]" value="CL:LR">';
        $html .= ' Región de Los Ríos (XIV)';
        $html .= '</label>';
        $html .= '<label style="display: block; margin: 5px 0; padding-left: 20px;">';
        $html .= '<input type="checkbox" name="locations[]" value="CL:LL">';
        $html .= ' Región de Los Lagos (X)';
        $html .= '</label>';

        // Regiones del Extremo Sur
        $html .= '<div style="margin: 15px 0 10px 0;"><strong>Zona Austral:</strong></div>';
        $html .= '<label style="display: block; margin: 5px 0; padding-left: 20px;">';
        $html .= '<input type="checkbox" name="locations[]" value="CL:AI">';
        $html .= ' Región de Aysén (XI)';
        $html .= '</label>';
        $html .= '<label style="display: block; margin: 5px 0; padding-left: 20px;">';
        $html .= '<input type="checkbox" name="locations[]" value="CL:MA">';
        $html .= ' Región de Magallanes (XII)';
        $html .= '</label>';

        // Botones de selección rápida
        $html .= '<div style="margin-top: 15px; padding: 10px; background-color: #f9f9f9; border-radius: 4px;">';
        $html .= '<strong>Selección rápida:</strong><br>';
        $html .= '<button type="button" class="button button-small bluex-select-all-locations" style="margin: 5px 5px 5px 0;">Todas las regiones</button>';
        $html .= '<button type="button" class="button button-small bluex-select-north-locations" style="margin: 5px 5px 5px 0;">Solo Norte</button>';
        $html .= '<button type="button" class="button button-small bluex-select-central-locations" style="margin: 5px 5px 5px 0;">Solo Centro</button>';
        $html .= '<button type="button" class="button button-small bluex-select-south-locations" style="margin: 5px 5px 5px 0;">Solo Sur</button>';
        $html .= '<button type="button" class="button button-small bluex-clear-all-locations" style="margin: 5px;">Limpiar todo</button>';
        $html .= '</div>';

        $html .= '</div>';

        $html .= '</div>';

        $html .= '<div class="bluex-modal-footer">';
        $html .= '<button type="button" class="button button-secondary bluex-cancel-config">Cancelar</button>';
        $html .= '<button type="button" class="button button-secondary" id="bluex-test-connection" style="margin-right: 10px;">🔧 Test Conexión</button>';
        $html .= '<button type="button" class="button button-primary bluex-create-zones" id="bluex-create-zones-btn">🚀 Crear Configuración</button>';
        $html .= '</div>';

        $html .= '</div>';
        $html .= '</div>';

        // Add CSS styles with scroll support
        $html .= '<style>
        .bluex-modal {
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            overflow: auto;
        }
        .bluex-modal-content {
            background-color: #fefefe;
            margin: 2% auto;
            padding: 0;
            border: 1px solid #888;
            width: 90%;
            max-width: 700px;
            max-height: 95vh;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }
        .bluex-modal-header {
            padding: 20px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }
        .bluex-modal-header h3 {
            margin: 0;
            color: #2271b1;
        }
        .bluex-modal-close {
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            color: #aaa;
        }
        .bluex-modal-close:hover {
            color: #000;
        }
        .bluex-modal-body {
            padding: 20px;
            overflow-y: auto;
            flex-grow: 1;
            max-height: calc(95vh - 140px);
        }
        .bluex-method-selection {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
            margin: 15px 0;
            background-color: #f9f9f9;
        }
        .bluex-method-item {
            margin: 10px 0;
            padding: 10px;
            background-color: white;
            border-radius: 4px;
            border-left: 4px solid #2271b1;
        }
        .bluex-zone-options, .bluex-location-selection {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
        }
        .bluex-zone-options h4, .bluex-location-selection h4 {
            margin-top: 0;
            color: #2271b1;
        }
        .bluex-modal-footer {
            padding: 15px 20px;
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
            text-align: right;
            border-radius: 0 0 8px 8px;
            flex-shrink: 0;
        }
        .bluex-modal-footer button {
            margin-left: 10px;
        }
        .bluex-create-zones {
            position: relative;
        }
        .bluex-create-zones.loading::after {
            content: "";
            position: absolute;
            width: 16px;
            height: 16px;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 1s ease infinite;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
        @keyframes spin {
            0% { transform: translateY(-50%) rotate(0deg); }
            100% { transform: translateY(-50%) rotate(360deg); }
        }
        
        /* Scroll styles */
        .bluex-modal-body::-webkit-scrollbar {
            width: 8px;
        }
        .bluex-modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        .bluex-modal-body::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        .bluex-modal-body::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .bluex-modal-content {
                width: 95%;
                margin: 1% auto;
                max-height: 98vh;
            }
            .bluex-modal-body {
                max-height: calc(98vh - 120px);
                padding: 15px;
            }
            .bluex-modal-header, .bluex-modal-footer {
                padding: 15px;
            }
        }
        </style>';

        return $html;
    }

    /**
     * AJAX handler for granular zone creation
     */
    public static function ajax_create_granular_zones()
    {
        // Set error handling and increase memory/time limits for large operations
        @ini_set('memory_limit', '256M');
        @set_time_limit(120);

        // Debug: Log function call
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('BlueX AJAX handler called: ajax_create_granular_zones');
            error_log('POST data: ' . print_r($_POST, true));
        }

        // Enhanced security checks
        try {
            // Verify AJAX request
            if (!wp_doing_ajax()) {
                wp_send_json_error('Solicitud inválida: no es una petición AJAX');
                return;
            }

            // Verify nonce exists
            if (!isset($_POST['nonce']) || empty($_POST['nonce'])) {
                wp_send_json_error('Token de seguridad requerido');
                return;
            }

            // Verify nonce with proper action
            if (!wp_verify_nonce(sanitize_text_field($_POST['nonce']), 'bluex_granular_zones')) {
                wp_send_json_error('Token de seguridad inválido. Por favor, recarga la página e intenta nuevamente.');
                return;
            }

            // Enhanced capability check
            if (!current_user_can('manage_woocommerce') || !current_user_can('manage_options')) {
                wp_send_json_error('Permisos insuficientes para realizar esta operación');
                return;
            }

            // Verify WooCommerce is active and required classes exist
            if (!class_exists('WooCommerce') || !class_exists('WC_Shipping_Zones')) {
                wp_send_json_error('WooCommerce no está activo o no se encontraron las clases requeridas');
                return;
            }

            // Sanitize and validate input data
            $selected_methods = isset($_POST['methods']) ? array_map('sanitize_text_field', (array) $_POST['methods']) : array();
            $zone_strategy = isset($_POST['zone_strategy']) ? sanitize_text_field($_POST['zone_strategy']) : 'create_new';
            $selected_locations = isset($_POST['locations']) ? array_map('sanitize_text_field', (array) $_POST['locations']) : array();

            // Additional validation
            $valid_strategies = array('create_new', 'add_to_existing', 'replace_existing', 'test');
            if (!in_array($zone_strategy, $valid_strategies, true)) {
                wp_send_json_error('Estrategia de zona inválida');
                return;
            }

            // Handle test connection
            if ($zone_strategy === 'test' && in_array('test', $selected_methods, true)) {
                $validation_results = self::validate_bluex_methods_setup();

                wp_send_json_success(array(
                    'message' => 'Conexión AJAX funcionando correctamente',
                    'timestamp' => current_time('mysql'),
                    'user_id' => get_current_user_id(),
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'woocommerce_active' => class_exists('WooCommerce'),
                    'shipping_zones_available' => class_exists('WC_Shipping_Zones'),
                    'bluex_methods_validation' => $validation_results,
                    'test' => true
                ));
                return;
            }

            // Validate required data
            if (empty($selected_methods)) {
                wp_send_json_error('Debe seleccionar al menos un método de envío');
                return;
            }

            if (empty($selected_locations)) {
                wp_send_json_error('Debe seleccionar al menos una ubicación');
                return;
            }

            // Fix location selection conflicts - if "CL" (Chile completo) is selected, remove specific regions
            if (in_array('CL', $selected_locations)) {
                // Filter out specific regions if the whole country is selected
                $selected_locations = array_filter($selected_locations, function ($location) {
                    return $location === 'CL' || strpos($location, 'CL:') !== 0;
                });
                // If Chile complete is selected, just use that
                $selected_locations = array('CL');
            } else {
                // Remove duplicates if any
                $selected_locations = array_unique($selected_locations);
            }

            // Check for existing BlueX zones to prevent duplicates
            $existing_bluex_zones = self::get_existing_bluex_zones();
            if (!empty($existing_bluex_zones)) {
                // Check if any selected locations would conflict
                $conflicting_locations = array();
                foreach ($selected_locations as $location_code) {
                    if (self::location_has_bluex_zone($location_code, $existing_bluex_zones)) {
                        $conflicting_locations[] = self::get_location_name($location_code);
                    }
                }

                if (!empty($conflicting_locations) && $zone_strategy === 'create_new') {
                    wp_send_json_error('Ya existen zonas BlueExpress para: ' . implode(', ', $conflicting_locations) . '. Use la opción "Agregar a zonas existentes" o elimine las zonas existentes primero.');
                    return;
                }
            }

            // Validate selected methods exist
            $available_methods = self::get_available_bluex_methods();
            foreach ($selected_methods as $method_id) {
                if (!isset($available_methods[$method_id])) {
                    wp_send_json_error("Método de envío inválido: {$method_id}");
                    return;
                }
            }

            // Limit the number of operations to prevent timeouts (reduced limit for better performance)
            if (count($selected_locations) * count($selected_methods) > 30) {
                wp_send_json_error('Demasiadas operaciones. Por favor, reduce el número de ubicaciones o métodos seleccionados (máximo 30 operaciones).');
                return;
            }

            // Execute zone creation with enhanced error handling
            $result = self::create_granular_zones($selected_methods, $zone_strategy, $selected_locations);

            if (is_wp_error($result)) {
                wp_send_json_error('Error: ' . $result->get_error_message());
                return;
            }

            // Check if result contains errors but some success
            if (is_array($result) && isset($result['errors']) && !empty($result['errors'])) {
                // Partial success - inform user of both successes and failures
                $message = sprintf(
                    'Operación completada con advertencias. Zonas creadas: %d, Métodos añadidos: %d, Errores: %d',
                    $result['summary']['zones_created'] ?? 0,
                    $result['summary']['methods_added'] ?? 0,
                    $result['summary']['errors_count'] ?? 0
                );

                $result['partial_success'] = true;
                $result['message'] = $message;
            }

            wp_send_json_success($result);
        } catch (Exception $e) {
            // Log the full error for debugging
            if (defined('WP_DEBUG') && WP_DEBUG) {
                error_log('BlueX Critical Error: ' . $e->getMessage());
                error_log('File: ' . $e->getFile() . ' Line: ' . $e->getLine());
                error_log('Stack trace: ' . $e->getTraceAsString());
            }

            // Send user-friendly error message
            $user_message = 'Error crítico al procesar la solicitud. ';
            if (defined('WP_DEBUG') && WP_DEBUG) {
                $user_message .= 'Detalles: ' . $e->getMessage();
            } else {
                $user_message .= 'Por favor, revisa los logs de error o contacta al administrador.';
            }

            wp_send_json_error($user_message);
        } catch (Error $e) {
            // Handle fatal errors (PHP 7+)
            if (defined('WP_DEBUG') && WP_DEBUG) {
                error_log('BlueX Fatal Error: ' . $e->getMessage());
                error_log('File: ' . $e->getFile() . ' Line: ' . $e->getLine());
            }

            wp_send_json_error('Error fatal del sistema. Consulta los logs del servidor.');
        }
    }

    /**
     * Create granular shipping zones based on selected methods and strategy
     * 
     * @param array $selected_methods Array of method IDs
     * @param string $zone_strategy Strategy for zone creation
     * @param array $selected_locations Array of location codes
     * @return array|WP_Error Results of the operation or error
     */
    private static function create_granular_zones($selected_methods, $zone_strategy, $selected_locations)
    {
        // Enhanced validation
        if (!class_exists('WC_Shipping_Zones') || !class_exists('WC_Shipping_Zone')) {
            return new WP_Error('missing_classes', 'Clases de WooCommerce requeridas no encontradas');
        }

        // Verify WooCommerce functions exist
        if (!function_exists('WC') || !WC()) {
            return new WP_Error('woocommerce_not_ready', 'WooCommerce no está completamente inicializado');
        }

        $available_methods = self::get_available_bluex_methods();
        $results = array();
        $zones_created = 0;
        $methods_added = 0;
        $errors = array();
        $failed_methods = array();

        try {
            foreach ($selected_locations as $location_code) {
                $location_parts = explode(':', $location_code);
                $location_type = $location_parts[0] === 'CL' && count($location_parts) === 1 ? 'country' : 'state';
                $location_name = self::get_location_name($location_code);

                if ($zone_strategy === 'create_new') {
                    try {
                        // Create new zone for each location
                        $zone_name = 'BlueExpress - ' . $location_name;
                        $zone = new WC_Shipping_Zone();

                        if (!is_object($zone)) {
                            throw new Exception("No se pudo crear la zona de envío para {$location_name}");
                        }

                        $zone->set_zone_name($zone_name);
                        $zone_id = $zone->save();

                        if (!$zone_id || is_wp_error($zone_id)) {
                            throw new Exception("Error al guardar la zona: {$zone_name}");
                        }

                        // Add location to zone with validation
                        $location_result = $zone->add_location($location_code, $location_type);
                        $zone->save();

                        $zones_created++;

                        // Add selected methods to the zone with detailed error handling
                        $zone_methods_added = 0;
                        $zone_method_errors = array();

                        foreach ($selected_methods as $method_id) {
                            if (isset($available_methods[$method_id])) {
                                try {
                                    // Verify the shipping method class exists
                                    $method_class = $available_methods[$method_id]['class'];
                                    if (!class_exists($method_class)) {
                                        $zone_method_errors[] = "Clase no encontrada: {$method_class} para {$method_id}";
                                        continue;
                                    }

                                    $method_instance = $zone->add_shipping_method($method_id);

                                    if (!$method_instance || is_wp_error($method_instance)) {
                                        $error_msg = is_wp_error($method_instance) ? $method_instance->get_error_message() : 'Unknown error';
                                        $zone_method_errors[] = "Error añadiendo {$method_id}: {$error_msg}";
                                        $failed_methods[] = $method_id;
                                        continue;
                                    }

                                    if (is_object($method_instance) && method_exists($method_instance, 'set_method_option')) {
                                        // Configure method instance with default settings
                                        $method_instance->set_method_option('enabled', 'yes');
                                        $method_instance->set_method_option('title', $available_methods[$method_id]['name']);
                                        $method_instance->save();
                                    }

                                    $methods_added++;
                                    $zone_methods_added++;
                                } catch (Exception $method_error) {
                                    $zone_method_errors[] = "Excepción añadiendo {$method_id}: " . $method_error->getMessage();
                                    $failed_methods[] = $method_id;
                                }
                            } else {
                                $zone_method_errors[] = "Método no disponible: {$method_id}";
                            }
                        }

                        $results[] = array(
                            'action' => 'created',
                            'zone_name' => $zone_name,
                            'zone_id' => $zone->get_id(),
                            'location' => $location_name,
                            'methods_requested' => count($selected_methods),
                            'methods_added' => $zone_methods_added,
                            'method_errors' => $zone_method_errors
                        );
                    } catch (Exception $zone_error) {
                        $errors[] = "Error creando zona para {$location_name}: " . $zone_error->getMessage();
                        continue;
                    }
                } elseif ($zone_strategy === 'add_to_existing') {
                    try {
                        // Find existing zones that cover this location
                        $existing_zones = self::find_zones_for_location($location_code);

                        foreach ($existing_zones as $zone_data) {
                            try {
                                $zone = new WC_Shipping_Zone($zone_data['id']);

                                if (!is_object($zone) || !$zone->get_id()) {
                                    $errors[] = "No se pudo cargar la zona existente ID: {$zone_data['id']}";
                                    continue;
                                }

                                $existing_methods = $zone->get_shipping_methods();
                                $zone_methods_added = 0;
                                $zone_method_errors = array();

                                // Add methods that don't already exist
                                foreach ($selected_methods as $method_id) {
                                    $method_exists = false;

                                    // Check if method already exists
                                    if (is_array($existing_methods)) {
                                        foreach ($existing_methods as $existing_method) {
                                            if (is_object($existing_method) && property_exists($existing_method, 'id') && $existing_method->id === $method_id) {
                                                $method_exists = true;
                                                break;
                                            }
                                        }
                                    }

                                    if (!$method_exists && isset($available_methods[$method_id])) {
                                        try {
                                            $method_instance = $zone->add_shipping_method($method_id);

                                            if (!$method_instance || is_wp_error($method_instance)) {
                                                $error_msg = is_wp_error($method_instance) ? $method_instance->get_error_message() : 'Unknown error';
                                                $zone_method_errors[] = "Error añadiendo {$method_id} a zona existente: {$error_msg}";
                                                continue;
                                            }

                                            if (is_object($method_instance) && method_exists($method_instance, 'set_method_option')) {
                                                $method_instance->set_method_option('enabled', 'yes');
                                                $method_instance->set_method_option('title', $available_methods[$method_id]['name']);
                                                $method_instance->save();
                                            }

                                            $methods_added++;
                                            $zone_methods_added++;
                                        } catch (Exception $method_error) {
                                            $zone_method_errors[] = "Excepción añadiendo {$method_id}: " . $method_error->getMessage();
                                        }
                                    }
                                }

                                $results[] = array(
                                    'action' => 'updated',
                                    'zone_name' => $zone->get_zone_name(),
                                    'zone_id' => $zone->get_id(),
                                    'location' => $location_name,
                                    'methods_requested' => count($selected_methods),
                                    'methods_added' => $zone_methods_added,
                                    'method_errors' => $zone_method_errors
                                );
                            } catch (Exception $existing_zone_error) {
                                $errors[] = "Error actualizando zona existente {$zone_data['id']}: " . $existing_zone_error->getMessage();
                            }
                        }

                        // Create new zone if no existing zones found
                        if (empty($existing_zones)) {
                            $zone_name = 'BlueExpress - ' . $location_name;
                            $zone = new WC_Shipping_Zone();
                            $zone->set_zone_name($zone_name);
                            $zone->save();

                            $zone->add_location($location_code, $location_type);
                            $zone->save();

                            $zones_created++;
                            $zone_methods_added = 0;

                            foreach ($selected_methods as $method_id) {
                                if (isset($available_methods[$method_id])) {
                                    $method_instance = $zone->add_shipping_method($method_id);
                                    if ($method_instance && !is_wp_error($method_instance)) {
                                        $methods_added++;
                                        $zone_methods_added++;

                                        if (is_object($method_instance) && method_exists($method_instance, 'set_method_option')) {
                                            $method_instance->set_method_option('enabled', 'yes');
                                            $method_instance->set_method_option('title', $available_methods[$method_id]['name']);
                                            $method_instance->save();
                                        }
                                    }
                                }
                            }

                            $results[] = array(
                                'action' => 'created_fallback',
                                'zone_name' => $zone_name,
                                'zone_id' => $zone->get_id(),
                                'location' => $location_name,
                                'methods_requested' => count($selected_methods),
                                'methods_added' => $zone_methods_added
                            );
                        }
                    } catch (Exception $add_existing_error) {
                        $errors[] = "Error procesando ubicación {$location_name}: " . $add_existing_error->getMessage();
                    }
                }
            }

            // Compile final results
            $final_result = array(
                'summary' => array(
                    'zones_created' => $zones_created,
                    'methods_added' => $methods_added,
                    'locations_processed' => count($selected_locations),
                    'errors_count' => count($errors),
                    'failed_methods_count' => count(array_unique($failed_methods))
                ),
                'details' => $results,
                'errors' => $errors,
                'failed_methods' => array_unique($failed_methods)
            );

            // Return error if critical failures occurred
            if (!empty($errors) && $zones_created === 0 && $methods_added === 0) {
                return new WP_Error('zone_creation_failed', 'No se pudieron crear zonas ni añadir métodos', $final_result);
            }

            return $final_result;
        } catch (Exception $e) {
            return new WP_Error('critical_error', 'Error crítico en la creación de zonas: ' . $e->getMessage());
        }
    }

    /**
     * Get existing BlueX shipping zones
     * 
     * @return array Array of existing BlueX zones
     */
    private static function get_existing_bluex_zones()
    {
        $zones = WC_Shipping_Zones::get_zones();
        $bluex_zones = array();

        foreach ($zones as $zone_data) {
            try {
                // Check if zone name contains "BlueExpress" or "BlueX"
                if (
                    stripos($zone_data['zone_name'], 'BlueExpress') !== false ||
                    stripos($zone_data['zone_name'], 'BlueX') !== false
                ) {
                    $bluex_zones[] = $zone_data;
                }
            } catch (Exception $e) {
                // Skip invalid zones
                continue;
            }
        }

        return $bluex_zones;
    }

    /**
     * Check if a location already has a BlueX zone
     * 
     * @param string $location_code Location code to check
     * @param array $existing_zones Array of existing BlueX zones
     * @return bool True if location has BlueX zone
     */
    private static function location_has_bluex_zone($location_code, $existing_zones)
    {
        foreach ($existing_zones as $zone_data) {
            try {
                $zone = new WC_Shipping_Zone($zone_data['id']);
                $locations = $zone->get_zone_locations();

                foreach ($locations as $location) {
                    // Check for exact match or if country-wide zone exists when checking regions
                    if ($location->code === $location_code) {
                        return true;
                    }

                    // If checking a region and Chile (CL) zone exists, there's a conflict
                    if (strpos($location_code, 'CL:') === 0 && $location->code === 'CL') {
                        return true;
                    }

                    // If checking Chile and any region exists, there's a conflict
                    if ($location_code === 'CL' && strpos($location->code, 'CL:') === 0) {
                        return true;
                    }
                }
            } catch (Exception $e) {
                // Skip invalid zones
                continue;
            }
        }

        return false;
    }

    /**
     * Find existing zones that cover a specific location
     * 
     * @param string $location_code Location code to search for
     * @return array Array of zone data
     */
    private static function find_zones_for_location($location_code)
    {
        $zones = WC_Shipping_Zones::get_zones();
        $matching_zones = array();

        foreach ($zones as $zone_data) {
            try {
                $zone = new WC_Shipping_Zone($zone_data['id']);
                $locations = $zone->get_zone_locations();

                foreach ($locations as $location) {
                    if ($location->code === $location_code) {
                        $matching_zones[] = $zone_data;
                        break;
                    }
                }
            } catch (Exception $e) {
                // Skip invalid zones
                continue;
            }
        }

        return $matching_zones;
    }

    /**
     * Get human-readable location name
     * 
     * @param string $location_code Location code
     * @return string Location name
     */
    private static function get_location_name($location_code)
    {
        $location_names = array(
            'CL' => 'Chile',
            // Zona Norte
            'CL:AP' => 'Región de Arica y Parinacota',
            'CL:TA' => 'Región de Tarapacá',
            'CL:AN' => 'Región de Antofagasta',
            'CL:AT' => 'Región de Atacama',
            'CL:CO' => 'Región de Coquimbo',
            // Zona Central
            'CL:VS' => 'Región de Valparaíso',
            'CL:RM' => 'Región Metropolitana',
            'CL:LI' => 'Región de O\'Higgins',
            'CL:ML' => 'Región del Maule',
            'CL:NB' => 'Región de Ñuble',
            // Zona Sur
            'CL:BI' => 'Región del Biobío',
            'CL:AR' => 'Región de La Araucanía',
            'CL:LR' => 'Región de Los Ríos',
            'CL:LL' => 'Región de Los Lagos',
            // Zona Austral
            'CL:AI' => 'Región de Aysén',
            'CL:MA' => 'Región de Magallanes'
        );

        return isset($location_names[$location_code]) ? $location_names[$location_code] : $location_code;
    }

    /**
     * Generate JavaScript for modal functionality
     * 
     * @return string JavaScript code
     */
    public static function generate_modal_javascript()
    {
        $nonce = wp_create_nonce('bluex_granular_zones');

        return "
        <script>
        // Ensure ajaxurl is available
        if (typeof ajaxurl === 'undefined') {
            var ajaxurl = '" . admin_url('admin-ajax.php') . "';
        }
        
        jQuery(document).ready(function($) {
            // Show modal
            $(document).on('click', '#bluex-show-granular-config', function() {
                $('#bluex-granular-config-modal').show();
            });
            
            // Close modal
            $(document).on('click', '.bluex-modal-close, .bluex-cancel-config', function() {
                $('#bluex-granular-config-modal').hide();
            });
            
            // Close modal when clicking outside
            $(window).click(function(event) {
                if (event.target.id === 'bluex-granular-config-modal') {
                    $('#bluex-granular-config-modal').hide();
                }
            });
            
            // Test connection button
            $(document).on('click', '#bluex-test-connection', function() {
                console.log('Testing AJAX connection...');
                console.log('ajaxurl:', ajaxurl);
                console.log('nonce:', '" . $nonce . "');
                var btn = $(this);
                btn.prop('disabled', true).text('🔄 Probando...');
                
                $.post(ajaxurl, {
                    action: 'bluex_create_granular_zones',
                    methods: ['test'],
                    zone_strategy: 'test',
                    locations: ['test'],
                    nonce: '" . $nonce . "'
                })
                .done(function(response) {
                    console.log('Test response:', response);
                    var message = '✅ Conexión AJAX exitosa!' + String.fromCharCode(10);
                    
                    if (response.success && response.data) {
                        var data = response.data;
                        message += 'WooCommerce activo: ' + (data.woocommerce_active ? 'Sí' : 'No') + String.fromCharCode(10);
                        message += 'Zonas de envío disponibles: ' + (data.shipping_zones_available ? 'Sí' : 'No') + String.fromCharCode(10);
                        
                        if (data.bluex_methods_validation) {
                            var validation = data.bluex_methods_validation;
                            message += 'Métodos BlueX válidos: ' + (validation.all_valid ? 'Sí' : 'No') + String.fromCharCode(10);
                            
                            if (validation.issues && validation.issues.length > 0) {
                                message += String.fromCharCode(10) + '⚠️ Problemas encontrados:' + String.fromCharCode(10);
                                for (var i = 0; i < Math.min(validation.issues.length, 3); i++) {
                                    message += '- ' + validation.issues[i] + String.fromCharCode(10);
                                }
                                if (validation.issues.length > 3) {
                                    message += '... y ' + (validation.issues.length - 3) + ' más.';
                                }
                            } else {
                                message += '✅ Todos los métodos BlueX están correctamente configurados.';
                            }
                        }
                    }
                    
                    alert(message);
                })
                .fail(function(xhr, status, error) {
                    console.error('Test failed:', {xhr: xhr, status: status, error: error});
                    alert('❌ Error en test: ' + status + ' - ' + error + String.fromCharCode(10) + 'Response: ' + xhr.responseText);
                })
                .always(function() {
                    btn.prop('disabled', false).text('🔧 Test Conexión');
                });
            });

            // Handle Chile complete selection - when selected, uncheck all regions
            $(document).on('change', 'input[value=\"CL\"]', function() {
                if ($(this).is(':checked')) {
                    console.log('Chile complete selected, unchecking all regions');
                    $('input[name=\"locations[]\"]').not('[value=\"CL\"]').prop('checked', false);
                }
            });
            
            // Handle individual region selection - when any region is selected, uncheck Chile complete
            $(document).on('change', 'input[name=\"locations[]\"]', function() {
                var value = $(this).val();
                if (value !== 'CL' && value.indexOf('CL:') === 0 && $(this).is(':checked')) {
                    console.log('Region selected, unchecking Chile complete');
                    $('input[value=\"CL\"]').prop('checked', false);
                }
            });

            // Botones de selección rápida
            $(document).on('click', '.bluex-select-all-locations', function(e) {
                e.preventDefault();
                console.log('Selecting all locations - using Chile complete');
                var modal = $('#bluex-granular-config-modal');
                modal.find('input[name=\"locations[]\"]').prop('checked', false);
                modal.find('input[value=\"CL\"]').prop('checked', true);
            });
            
            $(document).on('click', '.bluex-select-north-locations', function(e) {
                e.preventDefault();
                console.log('Selecting north locations');
                var modal = $('#bluex-granular-config-modal');
                modal.find('input[name=\"locations[]\"]').prop('checked', false);
                modal.find('input[value=\"CL:AP\"], input[value=\"CL:TA\"], input[value=\"CL:AN\"], input[value=\"CL:AT\"], input[value=\"CL:CO\"]').prop('checked', true);
            });
            
            $(document).on('click', '.bluex-select-central-locations', function(e) {
                e.preventDefault();
                console.log('Selecting central locations');
                var modal = $('#bluex-granular-config-modal');
                modal.find('input[name=\"locations[]\"]').prop('checked', false);
                modal.find('input[value=\"CL:VS\"], input[value=\"CL:RM\"], input[value=\"CL:LI\"], input[value=\"CL:ML\"], input[value=\"CL:NB\"]').prop('checked', true);
            });
            
            $(document).on('click', '.bluex-select-south-locations', function(e) {
                e.preventDefault();
                console.log('Selecting south locations');
                var modal = $('#bluex-granular-config-modal');
                modal.find('input[name=\"locations[]\"]').prop('checked', false);
                modal.find('input[value=\"CL:BI\"], input[value=\"CL:AR\"], input[value=\"CL:LR\"], input[value=\"CL:LL\"], input[value=\"CL:AI\"], input[value=\"CL:MA\"]').prop('checked', true);
            });
            
            $(document).on('click', '.bluex-clear-all-locations', function(e) {
                e.preventDefault();
                console.log('Clearing all locations');
                $('#bluex-granular-config-modal input[name=\"locations[]\"]').prop('checked', false);
            });
            
            // Prevent multiple submissions
            var isProcessing = false;
            
            // Handle zone creation
            $(document).on('click', '#bluex-create-zones-btn, .bluex-create-zones', function() {
                console.log('Create zones button clicked');
                
                // Prevent multiple clicks
                if (isProcessing) {
                    console.log('Already processing, ignoring click');
                    return;
                }
                
                var btn = $(this);
                var selectedMethods = [];
                var zoneStrategy = $('input[name=\"zone_strategy\"]:checked').val();
                var selectedLocations = [];
                
                // Get selected methods
                $('input[name=\"bluex_methods[]\"]:checked').each(function() {
                    selectedMethods.push($(this).val());
                });
                
                // Get selected locations
                $('input[name=\"locations[]\"]:checked').each(function() {
                    selectedLocations.push($(this).val());
                });
                
                console.log('Selected methods:', selectedMethods);
                console.log('Zone strategy:', zoneStrategy);
                console.log('Selected locations:', selectedLocations);
                
                if (selectedMethods.length === 0) {
                    alert('Por favor, selecciona al menos un método de envío.');
                    return;
                }
                
                if (selectedLocations.length === 0) {
                    alert('Por favor, selecciona al menos una ubicación.');
                    return;
                }
                
                // Warn about high number of operations
                var totalOperations = selectedLocations.length * selectedMethods.length;
                if (totalOperations > 15) {
                    var confirmMessage = 'Vas a crear ' + totalOperations + ' operaciones. ';
                    confirmMessage += 'Esto podría tomar varios minutos. ¿Continuar?';
                    if (!confirm(confirmMessage)) {
                        return;
                    }
                }
                
                // Set processing state
                isProcessing = true;
                btn.addClass('loading').prop('disabled', true);
                btn.text('Creando configuración...');
                
                // Disable other buttons to prevent conflicts
                $('.bluex-modal button').not(btn).prop('disabled', true);
                
                // Send AJAX request
                $.post(ajaxurl, {
                    action: 'bluex_create_granular_zones',
                    methods: selectedMethods,
                    zone_strategy: zoneStrategy,
                    locations: selectedLocations,
                    nonce: '" . $nonce . "'
                })
                .done(function(response) {
                    console.log('AJAX Response:', response);
                    if (response && response.success) {
                        var result = response.data;
                        var isPartialSuccess = result.partial_success || false;
                        var icon = isPartialSuccess ? '⚠️' : '✅';
                        var title = isPartialSuccess ? 'Configuración completada con advertencias' : 'Configuración creada exitosamente';
                        
                        var message = icon + ' ' + title + ':' + String.fromCharCode(10);
                        message += '• Zonas creadas: ' + (result.summary ? result.summary.zones_created : 'N/A') + String.fromCharCode(10);
                        message += '• Métodos agregados: ' + (result.summary ? result.summary.methods_added : 'N/A') + String.fromCharCode(10);
                        message += '• Ubicaciones procesadas: ' + (result.summary ? result.summary.locations_processed : 'N/A');
                        
                        // Show error details if any
                        if (result.summary && result.summary.errors_count > 0) {
                            message += String.fromCharCode(10) + '• Errores encontrados: ' + result.summary.errors_count;
                        }
                        
                        if (result.summary && result.summary.failed_methods_count > 0) {
                            message += String.fromCharCode(10) + '• Métodos que fallaron: ' + result.summary.failed_methods_count;
                        }
                        
                        // Add custom message if provided
                        if (result.message) {
                            message += String.fromCharCode(10) + String.fromCharCode(10) + result.message;
                        }
                        
                        // Show detailed errors if in debug mode or if critical errors occurred
                        if (result.errors && result.errors.length > 0 && 
                            (window.console || (result.summary && result.summary.methods_added === 0))) {
                            message += String.fromCharCode(10) + String.fromCharCode(10) + 'Detalles de errores:';
                            var maxErrors = Math.min(result.errors.length, 5); // Show max 5 errors
                            for (var i = 0; i < maxErrors; i++) {
                                message += String.fromCharCode(10) + '- ' + result.errors[i];
                            }
                            if (result.errors.length > maxErrors) {
                                message += String.fromCharCode(10) + '... y ' + (result.errors.length - maxErrors) + ' errores más.';
                            }
                        }
                        
                        alert(message);
                        $('#bluex-granular-config-modal').hide();
                        
                        // Log successful operations for console monitoring
                        if (result.summary) {
                            var hasSuccessfulOperations = (result.summary.zones_created > 0 || result.summary.methods_added > 0);
                            if (hasSuccessfulOperations) {
                                console.log('✅ Operación completada exitosamente. Para ver los cambios, navega a WooCommerce > Configuración > Envío.');
                            }
                            
                            if (result.summary.errors_count > 2) {
                                console.warn('Multiple errors occurred during zone creation. Check the configuration and try again.');
                            }
                        }
                    } else {
                        var errorMsg = 'Error desconocido';
                        if (response && response.data) {
                            errorMsg = response.data;
                        } else if (response && response.message) {
                            errorMsg = response.message;
                        }
                        alert('❌ Error: ' + errorMsg);
                        console.error('Error response:', response);
                    }
                })
                .fail(function(xhr, status, error) {
                    console.error('AJAX Error Details:', {
                        xhr: xhr,
                        status: status,
                        error: error,
                        responseText: xhr.responseText,
                        readyState: xhr.readyState
                    });
                    var errorMessage = 'Error de conexión';
                    if (error && error.length > 0) {
                        errorMessage += ': ' + error;
                    } else if (xhr.responseText && xhr.responseText.length > 0) {
                        errorMessage += ': ' + xhr.responseText;
                    } else {
                        errorMessage += ': No se pudo establecer conexión con el servidor.';
                    }
                    alert(errorMessage + ' Por favor, inténtalo de nuevo.');
                })
                .always(function() {
                    // Reset processing state
                    isProcessing = false;
                    
                    // Re-enable buttons
                    btn.removeClass('loading').prop('disabled', false);
                    btn.text('🚀 Crear Configuración');
                    $('.bluex-modal button').prop('disabled', false);
                });
            });
        });
        
        </script>";
    }
}
