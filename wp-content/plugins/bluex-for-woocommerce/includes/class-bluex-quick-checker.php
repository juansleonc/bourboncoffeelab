<?php

/**
 * Verificador Rápido de Configuración Blue Express
 * 
 * Sistema de monitoreo y notificación automática para detectar problemas
 * en la configuración de zonas de envío que afecten la convivencia con otros couriers.
 * 
 * @package WooCommerce_Correios/QuickChecker
 * @author Blue Express 
 * @version 1.0.0
 * @since 3.1.1
 */

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

/**
 * Blue Express Quick Checker Class
 */
class WC_Bluex_Quick_Checker
{

    /**
     * Initialize the quick checker.
     */
    public static function init()
    {
        add_action('admin_notices', array(__CLASS__, 'show_admin_notices'));
        add_action('wp_ajax_bluex_dismiss_zone_notice', array(__CLASS__, 'dismiss_notice_handler'));
        add_action('rest_api_init', array(__CLASS__, 'register_rest_routes'));
        // DESHABILITADO: No mostrar menú de zones validator
        // add_action('admin_menu', array(__CLASS__, 'add_admin_menu'));

        // Add WP-CLI command if available
        if (defined('WP_CLI') && WP_CLI) {
            self::register_cli_command();
        }
    }

    /**
     * Función de diagnóstico rápido desarrollada para facilitar la detección de problemas
     */
    public static function quick_zone_check()
    {
        // Si está disponible el validador avanzado, usar su resumen
        if (class_exists('WC_BlueX_Zones_Validator')) {
            $validator_summary = WC_BlueX_Zones_Validator::get_validation_summary();

            // Convertir el resumen del validador al formato esperado por el Quick Checker
            $results = self::convert_validator_summary_to_quick_check($validator_summary);

            if (! empty($results)) {
                return $results;
            }
        }

        // Fallback al método original si el validador no está disponible
        return self::quick_zone_check_legacy();
    }

    /**
     * Convert validator summary to quick check format
     */
    private static function convert_validator_summary_to_quick_check($summary)
    {
        $results = array();

        // 1. Verificar si hay errores críticos
        if ($summary['errors'] > 0) {
            return array('error' => 'Se encontraron ' . $summary['errors'] . ' errores en la configuración de zonas');
        }

        // 2. Obtener información básica de zonas (usando método legacy como respaldo)
        if (! class_exists('WC_Shipping_Zones')) {
            return array('error' => 'WooCommerce shipping zones no disponibles');
        }

        $shipping_methods = WC()->shipping->get_shipping_methods();
        $bluex_methods = array();
        foreach (array('bluex-ex', 'bluex-py', 'bluex-md') as $method_id) {
            if (isset($shipping_methods[$method_id])) {
                $bluex_methods[] = $method_id;
            }
        }

        if (empty($bluex_methods)) {
            return array('error' => 'No se encontraron métodos Blue Express registrados');
        }

        $results['bluex_methods'] = $bluex_methods;

        // 3. Usar análisis básico pero interpretar según el validador
        $zones = WC_Shipping_Zones::get_zones();
        $zones_with_bluex = 0;
        $zones_with_others = 0;
        $zones_with_both = 0;
        $total_zones = count($zones);

        foreach ($zones as $zone_data) {
            $zone = new WC_Shipping_Zone($zone_data['id']);
            $methods = $zone->get_shipping_methods();

            $has_bluex = false;
            $has_others = false;

            foreach ($methods as $method) {
                if (strpos($method->id, 'bluex') !== false) {
                    $has_bluex = true;
                } else {
                    $has_others = true;
                }
            }

            if ($has_bluex) $zones_with_bluex++;
            if ($has_others) $zones_with_others++;
            if ($has_bluex && $has_others) $zones_with_both++;
        }

        $results['zones_summary'] = array(
            'total' => $total_zones,
            'with_bluex' => $zones_with_bluex,
            'with_others' => $zones_with_others,
            'with_both' => $zones_with_both
        );

        // 4. Soporte para zonas
        $zone_support = array();
        foreach ($bluex_methods as $method_id) {
            $method_class = $shipping_methods[$method_id];
            $test_instance = new $method_class(999);
            $zone_support[$method_id] = in_array('shipping-zones', $test_instance->supports);
        }

        $results['zone_support'] = $zone_support;

        // 5. Generar mensaje basado en el validador y análisis propio
        $results['validator_summary'] = $summary;

        if ($summary['status'] === 'success' && $zones_with_both > 0) {
            $results['status'] = 'success';
            $results['message'] = "✅ ¡Excelente! Configuración validada correctamente. Tienes {$zones_with_both} zonas con múltiples métodos de envío.";
        } elseif ($summary['status'] === 'warning') {
            $results['status'] = 'partial';
            $results['message'] = "⚠️ Configuración funcional con {$summary['warnings']} advertencias. Revisa el análisis detallado para optimizar.";
        } elseif ($zones_with_bluex > 0 && $zones_with_others > 0) {
            $results['status'] = 'partial';
            $results['message'] = "⚠️ Blue Express y otros métodos están en zonas separadas. Considera agregar Blue Express a zonas con otros métodos.";
        } elseif ($zones_with_bluex > 0) {
            $results['status'] = 'bluex_only';
            $results['message'] = "ℹ️ Solo hay métodos Blue Express configurados en las zonas.";
        } else {
            $results['status'] = 'no_bluex';
            $results['message'] = "❌ No se encontraron métodos Blue Express en ninguna zona.";
        }

        return $results;
    }

    /**
     * Legacy quick zone check method
     */
    private static function quick_zone_check_legacy()
    {
        $results = array();

        // 1. Verificar si WooCommerce soporta shipping zones
        if (! class_exists('WC_Shipping_Zones')) {
            return array('error' => 'WooCommerce shipping zones no disponibles');
        }

        // 2. Verificar si los métodos Blue Express están correctamente registrados
        $shipping_methods = WC()->shipping->get_shipping_methods();
        $bluex_methods = array();
        foreach (array('bluex-ex', 'bluex-py', 'bluex-md') as $method_id) {
            if (isset($shipping_methods[$method_id])) {
                $bluex_methods[] = $method_id;
            }
        }

        if (empty($bluex_methods)) {
            return array('error' => 'No se encontraron métodos Blue Express registrados');
        }

        $results['bluex_methods'] = $bluex_methods;

        // 3. Analizar configuración actual de zonas de envío
        $zones = WC_Shipping_Zones::get_zones();
        $zones_with_bluex = 0;
        $zones_with_others = 0;
        $zones_with_both = 0;
        $total_zones = count($zones);

        foreach ($zones as $zone_data) {
            $zone = new WC_Shipping_Zone($zone_data['id']);
            $methods = $zone->get_shipping_methods();

            $has_bluex = false;
            $has_others = false;

            foreach ($methods as $method) {
                if (strpos($method->id, 'bluex') !== false) {
                    $has_bluex = true;
                } else {
                    $has_others = true;
                }
            }

            if ($has_bluex) $zones_with_bluex++;
            if ($has_others) $zones_with_others++;
            if ($has_bluex && $has_others) $zones_with_both++;
        }

        $results['zones_summary'] = array(
            'total' => $total_zones,
            'with_bluex' => $zones_with_bluex,
            'with_others' => $zones_with_others,
            'with_both' => $zones_with_both
        );

        // 4. Check if Blue Express classes support shipping zones
        $zone_support = array();
        foreach ($bluex_methods as $method_id) {
            $method_class = $shipping_methods[$method_id];
            $test_instance = new $method_class(999);
            $zone_support[$method_id] = in_array('shipping-zones', $test_instance->supports);
        }

        $results['zone_support'] = $zone_support;

        // 5. Generar recomendación basada en el análisis
        if ($zones_with_both > 0) {
            $results['status'] = 'success';
            $results['message'] = "✅ ¡Excelente! Tienes {$zones_with_both} zonas con métodos Blue Express y otros couriers";
        } elseif ($zones_with_bluex > 0 && $zones_with_others > 0) {
            $results['status'] = 'partial';
            $results['message'] = "⚠️ Blue Express y otros métodos están en zonas separadas. Considera agregar Blue Express a zonas con otros métodos.";
        } elseif ($zones_with_bluex > 0) {
            $results['status'] = 'bluex_only';
            $results['message'] = "ℹ️ Solo hay métodos Blue Express configurados en las zonas.";
        } else {
            $results['status'] = 'no_bluex';
            $results['message'] = "❌ No se encontraron métodos Blue Express en ninguna zona.";
        }

        return $results;
    }

    /**
     * Sistema de notificaciones en admin para alertar sobre problemas de configuración
     */
    public static function show_admin_notices()
    {
        // Solo mostrar en páginas relevantes del admin
        $screen = get_current_screen();
        if (! in_array($screen->id, array('woocommerce_page_wc-settings', 'edit-shop_order', 'woocommerce_page_wc-admin'))) {
            return;
        }

        // Solo mostrar a usuarios con permisos de gestión de WooCommerce
        if (! current_user_can('manage_woocommerce')) {
            return;
        }

        // Verificar si el usuario ya desestimó esta notificación
        if (get_user_meta(get_current_user_id(), 'bluex_zone_check_dismissed', true)) {
            return;
        }

        $check_results = self::quick_zone_check();

        if (isset($check_results['error'])) {
?>
            <div class="notice notice-error is-dismissible" data-bluex-notice="zone-check">
                <h3>🔴 Problema en Configuración Blue Express</h3>
                <p><strong>Error:</strong> <?php echo esc_html($check_results['error']); ?></p>
                <p>Los métodos de envío Blue Express pueden no funcionar correctamente.</p>
                <p><a href="mailto:soporte@bluex.cl">Contactar Soporte Técnico</a></p>
            </div>
        <?php
            return;
        }

        $status = $check_results['status'];
        $message = $check_results['message'];

        $notice_classes = array(
            'success' => 'notice-success',
            'partial' => 'notice-warning',
            'bluex_only' => 'notice-info',
            'no_bluex' => 'notice-error'
        );

        $notice_class = isset($notice_classes[$status]) ? $notice_classes[$status] : 'notice-info';

        // Only show non-success notices
        if ($status === 'success') {
            return;
        }

        ?>
        <div class="notice <?php echo esc_attr($notice_class); ?> is-dismissible" data-bluex-notice="zone-check">
            <h3>📦 Estado de Configuración Blue Express</h3>
            <p><?php echo wp_kses_post($message); ?></p>

            <?php if ($status === 'partial' || $status === 'no_bluex'): ?>
                <p>
                    <strong>Recomendación:</strong>
                    <a href="<?php echo esc_url(admin_url('admin.php?page=wc-settings&tab=shipping')); ?>">Configurar zonas de envío</a>
                    para agregar métodos Blue Express junto con otros couriers y mejorar la experiencia del cliente.
                </p>
            <?php endif; ?>

            <p>
                <em>Zonas con ambos: <?php echo intval($check_results['zones_summary']['with_both']); ?> |
                    Solo Blue Express: <?php echo intval($check_results['zones_summary']['with_bluex'] - $check_results['zones_summary']['with_both']); ?> |
                    Solo otros: <?php echo intval($check_results['zones_summary']['with_others'] - $check_results['zones_summary']['with_both']); ?></em>
            </p>

            <p>
                <a href="<?php echo esc_url(admin_url('admin.php?page=wc-settings&tab=integration&section=correios')); ?>" class="button">Ver Análisis Detallado</a>
                <button type="button" class="button-link" onclick="bluexDismissNotice(this)">Descartar notificación</button>
            </p>
        </div>

        <script>
            function bluexDismissNotice(button) {
                const notice = button.closest('.notice');
                notice.style.display = 'none';

                // Send AJAX request to dismiss
                fetch(ajaxurl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=bluex_dismiss_zone_notice&nonce=<?php echo esc_js(wp_create_nonce('bluex_dismiss_notice')); ?>'
                });
            }
        </script>
    <?php
    }

    /**
     * AJAX handler for dismissing notice
     */
    public static function dismiss_notice_handler()
    {
        check_ajax_referer('bluex_dismiss_notice', 'nonce');

        if (current_user_can('manage_woocommerce')) {
            update_user_meta(get_current_user_id(), 'bluex_zone_check_dismissed', true);
            wp_send_json_success();
        }

        wp_send_json_error();
    }

    /**
     * Función de debug desarrollada para facilitar el troubleshooting
     */
    public static function debug_zones()
    {
        if (! current_user_can('manage_options')) {
            return 'Acceso denegado: Se requieren permisos de administrador';
        }

        $results = self::quick_zone_check();

        echo '<pre>';
        echo "=== DEBUG ZONAS BLUE EXPRESS ===\n\n";

        if (isset($results['error'])) {
            echo "❌ ERROR: " . $results['error'] . "\n";
            echo '</pre>';
            return;
        }

        echo "📊 RESUMEN GENERAL\n";
        echo "Estado: " . $results['status'] . "\n";
        echo "Mensaje: " . strip_tags($results['message']) . "\n\n";

        echo "🔧 MÉTODOS BLUE EXPRESS DETECTADOS\n";
        foreach ($results['bluex_methods'] as $method) {
            $support_status = $results['zone_support'][$method] ? '✅ Compatible' : '❌ Incompatible';
            echo "{$support_status} {$method}\n";
        }
        echo "\n";

        echo "🗺️ ZONES BREAKDOWN\n";
        $summary = $results['zones_summary'];
        echo "Total zones: {$summary['total']}\n";
        echo "Zones with Blue Express: {$summary['with_bluex']}\n";
        echo "Zones with other methods: {$summary['with_others']}\n";
        echo "Zones with BOTH: {$summary['with_both']}\n\n";

        // Detailed zone analysis
        echo "📋 DETAILED ZONE ANALYSIS\n";
        $zones = WC_Shipping_Zones::get_zones();

        foreach ($zones as $zone_data) {
            $zone = new WC_Shipping_Zone($zone_data['id']);
            $methods = $zone->get_shipping_methods();

            echo "\n🔹 Zone: " . $zone->get_zone_name() . "\n";

            $locations = $zone->get_zone_locations();
            if (! empty($locations)) {
                $location_list = array();
                foreach ($locations as $location) {
                    $location_list[] = $location->type . ':' . $location->code;
                }
                echo "   📍 Locations: " . implode(', ', $location_list) . "\n";
            }

            if (empty($methods)) {
                echo "   ⚠️ No methods configured\n";
                continue;
            }

            $bluex_methods = array();
            $other_methods = array();

            foreach ($methods as $method) {
                $method_name = $method->get_method_title();
                $enabled = $method->is_enabled() ? '✅' : '❌';

                if (strpos($method->id, 'bluex') !== false) {
                    $bluex_methods[] = "{$enabled} {$method_name}";
                } else {
                    $other_methods[] = "{$enabled} {$method_name}";
                }
            }

            if (! empty($bluex_methods)) {
                echo "   🔵 Blue Express: " . implode(', ', $bluex_methods) . "\n";
            }

            if (! empty($other_methods)) {
                echo "   🔴 Other methods: " . implode(', ', $other_methods) . "\n";
            }

            // Status for this zone
            if (! empty($bluex_methods) && ! empty($other_methods)) {
                echo "   ✅ GOOD: Multi-courier zone\n";
            } elseif (! empty($bluex_methods)) {
                echo "   ℹ️ Blue Express only\n";
            } else {
                echo "   ⚠️ No Blue Express methods\n";
            }
        }

        echo "\n=== END DEBUG ===\n";
        echo '</pre>';
    }

    /**
     * REST API endpoint for external monitoring
     */
    public static function register_rest_routes()
    {
        register_rest_route('bluex/v1', '/zones-status', array(
            'methods' => 'GET',
            'callback' => array(__CLASS__, 'rest_zones_status'),
            'permission_callback' => array(__CLASS__, 'rest_permissions_check')
        ));
    }

    /**
     * REST API callback
     */
    public static function rest_zones_status()
    {
        return self::quick_zone_check();
    }

    /**
     * REST API permissions check
     */
    public static function rest_permissions_check()
    {
        return current_user_can('manage_woocommerce');
    }

    /**
     * Add admin menu page - DESHABILITADO
     */
    public static function add_admin_menu()
    {
        // DESHABILITADO: No mostrar en el menú de WooCommerce
        /*
        add_submenu_page(
            'woocommerce',
            __('Blue Express - Validador de Zonas', 'woocommerce-correios'),
            __('Blue Express Zones', 'woocommerce-correios'),
            'manage_woocommerce',
            'bluex-zones-validator',
            array(__CLASS__, 'admin_page_content')
        );
        */
    }

    /**
     * Admin page content
     */
    public static function admin_page_content()
    {
    ?>
        <div class="wrap">
            <h1>🔍 Blue Express - Validador de Zonas</h1>
            <p>Análisis detallado de la configuración de zonas de envío para Blue Express.</p>

            <?php if (class_exists('WC_BlueX_Zones_Validator')): ?>
                <div class="bluex-zones-validation">
                    <?php echo WC_BlueX_Zones_Validator::generate_html_report(); ?>
                </div>

                <div class="bluex-quick-actions" style="margin-top: 30px; padding: 15px; background: #f0f0f1; border-radius: 5px;">
                    <h3>🚀 Acciones Rápidas</h3>
                    <p>
                        <button type="button" class="button button-primary" onclick="bluexRevalidateZones()">
                            🔄 Ejecutar Nueva Validación
                        </button>
                        <a href="<?php echo esc_url(admin_url('admin.php?page=wc-settings&tab=shipping')); ?>" class="button">
                            ⚙️ Configurar Zonas de Envío
                        </a>
                    </p>
                </div>

                <script>
                    function bluexRevalidateZones() {
                        const button = event.target;
                        button.disabled = true;
                        button.textContent = '🔄 Validando...';

                        fetch(ajaxurl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: 'action=bluex_validate_zones&nonce=<?php echo wp_create_nonce('bluex_validate_zones'); ?>'
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    document.querySelector('.bluex-zones-validation').innerHTML = data.data.html;
                                }
                                button.disabled = false;
                                button.textContent = '🔄 Ejecutar Nueva Validación';
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                button.disabled = false;
                                button.textContent = '🔄 Ejecutar Nueva Validación';
                            });
                    }
                </script>
            <?php else: ?>
                <div class="notice notice-error">
                    <p><strong>Error:</strong> El validador de zonas no está disponible. Asegúrate de que todos los archivos del plugin estén correctamente instalados.</p>
                </div>

                <div class="bluex-zones-analysis">
                    <h3>📋 Análisis Básico</h3>
                    <?php self::debug_zones(); ?>
                </div>

                <style>
                    .bluex-zones-analysis pre {
                        background: #f1f1f1;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                        padding: 15px;
                        font-family: 'Courier New', Courier, monospace;
                        font-size: 12px;
                        line-height: 1.4;
                        white-space: pre-wrap;
                        max-height: 600px;
                        overflow-y: auto;
                    }

                    .bluex-zones-analysis h1 {
                        color: #0073aa;
                        margin-bottom: 20px;
                    }
                </style>
            <?php endif; ?>
        </div>
<?php
    }

    /**
     * Register WP-CLI command if WP-CLI is available
     */
    public static function register_cli_command()
    {
        WP_CLI::add_command('bluex zones-check', array(__CLASS__, 'cli_zones_check'));
    }

    /**
     * WP-CLI command callback
     */
    public static function cli_zones_check()
    {
        $results = self::quick_zone_check();

        if (isset($results['error'])) {
            WP_CLI::error($results['error']);
            return;
        }

        WP_CLI::line('Blue Express Zones Status: ' . $results['status']);
        WP_CLI::line($results['message']);

        $summary = $results['zones_summary'];
        WP_CLI::line("Total zones: {$summary['total']}");
        WP_CLI::line("Zones with both Blue Express and others: {$summary['with_both']}");

        if ($results['status'] === 'success') {
            WP_CLI::success('Zone configuration looks good!');
        } else {
            WP_CLI::warning('Zone configuration could be improved.');
        }
    }
}

// Backward compatibility functions
if (! function_exists('bluex_quick_zone_check')) {
    /**
     * Wrapper function for backward compatibility
     */
    function bluex_quick_zone_check()
    {
        return WC_Bluex_Quick_Checker::quick_zone_check();
    }
}

if (! function_exists('bluex_debug_zones')) {
    /**
     * Wrapper function for backward compatibility
     */
    function bluex_debug_zones()
    {
        return WC_Bluex_Quick_Checker::debug_zones();
    }
}
