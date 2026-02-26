<?php

/**
 * BlueX Shipping Zones Configuration Validator
 * 
 * Herramienta de validación para verificar la configuración de zonas de envío
 * y asegurar la correcta convivencia entre métodos Blue Express y otros couriers.
 * 
 * CORRECCIONES APLICADAS:
 * - Agregadas validaciones null/isset para prevenir errores críticos
 * - Implementados try-catch en métodos que crean objetos WC_Shipping_Zone
 * - Verificaciones de existencia de propiedades de objetos antes de acceder
 * - Validación de arrays y objetos antes de iterar sobre ellos
 * - Manejo de errores para evitar fatal errors cuando las zonas están mal configuradas
 * - CORREGIDA detección de métodos Blue Express usando tanto ID como título del método
 *   (fix para cuando get_id() retorna 'unknown' pero el título contiene 'BlueX')
 * 
 * @package WooCommerce_Correios/Validator
 * @author Blue Express 
 * @version 1.0.2
 * @since 3.1.1
 */

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

/**
 * BlueX Zones Configuration Validator Class
 */
class WC_BlueX_Zones_Validator
{

    /**
     * Resultados de validación
     * @var array
     */
    private static $validation_results = array();

    /**
     * Initialize the validator
     */
    public static function init()
    {
        // Add AJAX handler for zone validation
        add_action('wp_ajax_bluex_validate_zones', array(__CLASS__, 'ajax_validate_zones'));
    }

    /**
     * Función principal de validación
     * Desarrollada para optimizar la experiencia de configuración de zonas
     * 
     * @return array Resultados de la validación
     */
    public static function validate_configuration()
    {
        self::$validation_results = array();

        // Verificar compatibilidad con WooCommerce y soporte para shipping zones
        if (! self::check_woocommerce_compatibility()) {
            return self::$validation_results;
        }

        // Validar configuración de zonas de envío existentes
        self::validate_shipping_zones();

        // Validar registro correcto de métodos Blue Express
        self::validate_bluex_methods();

        // Detectar posibles conflictos entre zonas
        self::check_zone_conflicts();

        // Validar configuración de instancias por zona
        self::validate_instance_settings();

        return self::$validation_results;
    }

    /**
     * Verificar compatibilidad con WooCommerce
     * Implementado para asegurar el correcto funcionamiento en diferentes versiones
     * 
     * @return bool
     */
    private static function check_woocommerce_compatibility()
    {
        if (! class_exists('WooCommerce')) {
            self::add_result('error', 'WooCommerce', 'WooCommerce no encontrado o no está activo');
            return false;
        }

        if (! defined('WC_VERSION')) {
            self::add_result('error', 'WooCommerce', 'Constante WC_VERSION no definida');
            return false;
        }

        if (version_compare(WC_VERSION, '2.6.0', '<')) {
            self::add_result('error', 'WooCommerce', 'WooCommerce versión ' . WC_VERSION . ' es muy antigua. Zonas de envío requieren 2.6.0+');
            return false;
        }

        self::add_result('success', 'WooCommerce', 'WooCommerce ' . WC_VERSION . ' es compatible con zonas de envío');
        return true;
    }

    /**
     * Validar configuración de zonas de envío
     * Desarrollado para detectar configuraciones que impiden la convivencia de métodos
     */
    private static function validate_shipping_zones()
    {
        if (! class_exists('WC_Shipping_Zones')) {
            self::add_result('error', 'Zonas de Envío', 'Clase WC_Shipping_Zones no encontrada');
            return;
        }

        $zones = WC_Shipping_Zones::get_zones();

        if (empty($zones)) {
            self::add_result('warning', 'Zonas de Envío', 'No hay zonas de envío configuradas');
            return;
        }

        self::add_result('info', 'Zonas de Envío', count($zones) . ' zonas de envío encontradas');

        foreach ($zones as $zone_data) {
            self::validate_individual_zone($zone_data);
        }

        // Verificar zona "resto del mundo"
        self::validate_rest_of_world_zone();
    }

    /**
     * Helper method to safely get shipping method properties
     * Basado en las mejores prácticas de WooCommerce para manejo de instancias
     * 
     * @param object $method Shipping method instance
     * @return array Method information
     */
    private static function get_method_info($method)
    {
        if (!is_object($method)) {
            return array(
                'id' => 'unknown',
                'title' => 'Invalid Method',
                'enabled' => false,
                'instance_id' => null,
                'is_bluex' => false
            );
        }

        // Acceso directo a propiedades según documentación WooCommerce
        $method_id = isset($method->id) ? $method->id : 'unknown';
        $method_title = isset($method->title) ? $method->title : (method_exists($method, 'get_method_title') ? $method->get_method_title() : 'Unknown Method');
        $method_enabled = isset($method->enabled) ? ('yes' === $method->enabled) : false;
        $instance_id = isset($method->instance_id) ? $method->instance_id : null;

        // Detectar métodos Blue Express
        $is_bluex_method = (strpos($method_id, 'bluex') !== false) ||
            (strpos(strtolower($method_title), 'bluex') !== false) ||
            (strpos(strtolower($method_title), 'blue express') !== false);

        return array(
            'id' => $method_id,
            'title' => $method_title,
            'enabled' => $method_enabled,
            'instance_id' => $instance_id,
            'is_bluex' => $is_bluex_method
        );
    }

    /**
     * Validate individual shipping zone
     * 
     * @param array $zone_data Zone data
     */
    private static function validate_individual_zone($zone_data)
    {
        // Verificar que $zone_data sea un array válido y tenga 'id'
        if (!is_array($zone_data) || !isset($zone_data['id'])) {
            self::add_result('error', 'Validación de Zona', 'Datos de zona inválidos o faltantes');
            return;
        }

        try {
            $zone = new WC_Shipping_Zone($zone_data['id']);
            $zone_name = $zone->get_zone_name();
            $methods = $zone->get_shipping_methods();
        } catch (Exception $e) {
            self::add_result('error', 'Validación de Zona', 'Error al crear zona: ' . $e->getMessage());
            return;
        }

        if (empty($methods)) {
            self::add_result('warning', 'Zone: ' . $zone_name, 'No hay métodos de envío configurados');
            return;
        }

        $bluex_methods = 0;
        $other_methods = 0;
        $method_details = array();

        foreach ($methods as $instance_id => $method) {
            // Verificar que $method sea un objeto válido antes de usar sus métodos
            if (!is_object($method)) {
                continue;
            }

            try {
                // Para métodos en instancias de zona, acceder a propiedades directamente
                $method_id = isset($method->id) ? $method->id : 'unknown';
                $method_enabled = isset($method->enabled) ? ('yes' === $method->enabled) : false;
                $method_title = isset($method->title) ? $method->title : (method_exists($method, 'get_method_title') ? $method->get_method_title() : 'Unknown Method');

                // Detectar si es un método Blue Express tanto por ID como por título
                $is_bluex_method = false;
                if (strpos($method_id, 'bluex') !== false) {
                    $is_bluex_method = true;
                } elseif (
                    strpos(strtolower($method_title), 'bluex') !== false ||
                    strpos(strtolower($method_title), 'blue express') !== false
                ) {
                    $is_bluex_method = true;
                }

                if ($is_bluex_method) {
                    $bluex_methods++;
                } else {
                    $other_methods++;
                }

                // Agregar información adicional de la instancia si está disponible
                $instance_info = '';
                if (isset($method->instance_id) && $method->instance_id > 0) {
                    $instance_info = sprintf(' [Instancia: %d]', $method->instance_id);
                }

                $method_details[] = sprintf(
                    '%s (%s)%s - %s',
                    $method_title,
                    $method_id,
                    $instance_info,
                    $method_enabled ? 'Habilitado' : 'Deshabilitado'
                );
            } catch (Exception $e) {
                // Log del error y continuar con el siguiente método
                error_log('Error processing shipping method: ' . $e->getMessage());
                continue;
            }
        }

        // Contar métodos habilitados para análisis más detallado
        $enabled_bluex = 0;
        $disabled_bluex = 0;
        $enabled_other = 0;
        $disabled_other = 0;

        foreach ($methods as $method) {
            if (!is_object($method)) continue;

            $method_id = isset($method->id) ? $method->id : 'unknown';
            $method_enabled = isset($method->enabled) ? ('yes' === $method->enabled) : false;
            $method_title = isset($method->title) ? $method->title : '';

            $is_bluex_method = (strpos($method_id, 'bluex') !== false) ||
                (strpos(strtolower($method_title), 'bluex') !== false) ||
                (strpos(strtolower($method_title), 'blue express') !== false);

            if ($is_bluex_method) {
                if ($method_enabled) {
                    $enabled_bluex++;
                } else {
                    $disabled_bluex++;
                }
            } else {
                if ($method_enabled) {
                    $enabled_other++;
                } else {
                    $disabled_other++;
                }
            }
        }

        // Determine result based on method configuration
        if ($bluex_methods > 0 && $other_methods > 0) {
            $status = 'success';
            $message = sprintf(
                'Zona configurada correctamente con %d métodos Blue Express (%d activos) y %d otros métodos (%d activos): %s',
                $bluex_methods,
                $enabled_bluex,
                $other_methods,
                $enabled_other,
                implode(', ', $method_details)
            );
        } elseif ($bluex_methods > 0 && $other_methods == 0) {
            if ($enabled_bluex > 0) {
                // Cambiado de 'info' a 'success' - una zona con solo métodos BlueX activos es perfectamente válida
                $status = 'success';
                $message = sprintf(
                    'Zona Blue Express configurada correctamente (%d métodos, %d activos): %s',
                    $bluex_methods,
                    $enabled_bluex,
                    implode(', ', $method_details)
                );
            } else {
                $status = 'warning';
                $message = sprintf(
                    'Zona tiene %d métodos Blue Express pero todos están deshabilitados: %s',
                    $bluex_methods,
                    implode(', ', $method_details)
                );
            }
        } elseif ($bluex_methods == 0 && $other_methods > 0) {
            $status = 'info';
            $message = sprintf(
                'Zona sin métodos Blue Express (%d otros métodos, %d activos): %s',
                $other_methods,
                $enabled_other,
                implode(', ', $method_details)
            );
        } else {
            $status = 'warning';
            $message = 'Zona no tiene métodos habilitados';
        }

        self::add_result($status, 'Zona: ' . $zone_name, $message);

        // Validate zone locations
        self::validate_zone_locations($zone, $zone_name);
    }

    /**
     * Validate zone locations
     * 
     * @param WC_Shipping_Zone $zone
     * @param string $zone_name
     */
    private static function validate_zone_locations($zone, $zone_name)
    {
        try {
            $locations = $zone->get_zone_locations();
        } catch (Exception $e) {
            self::add_result('error', 'Zona: ' . $zone_name, 'Error al obtener ubicaciones: ' . $e->getMessage());
            return;
        }

        if (empty($locations)) {
            self::add_result('warning', 'Zona: ' . $zone_name, 'No hay ubicaciones configuradas - la zona nunca coincidirá con clientes');
            return;
        }

        $location_details = array();
        foreach ($locations as $location) {
            // Verificar que el objeto location tenga las propiedades necesarias
            if (isset($location->type) && isset($location->code)) {
                $location_details[] = $location->type . ':' . $location->code;
            }
        }

        if (!empty($location_details)) {
            self::add_result('info', 'Zona: ' . $zone_name, 'Ubicaciones: ' . implode(', ', $location_details));
        } else {
            self::add_result('warning', 'Zona: ' . $zone_name, 'Ubicaciones encontradas pero con formato inválido');
        }
    }

    /**
     * Validate rest of the world zone
     */
    private static function validate_rest_of_world_zone()
    {
        try {
            $rest_of_world = new WC_Shipping_Zone(0);
            $methods = $rest_of_world->get_shipping_methods();
        } catch (Exception $e) {
            self::add_result('error', 'Resto del Mundo', 'Error al validar zona resto del mundo: ' . $e->getMessage());
            return;
        }

        if (empty($methods)) {
            self::add_result('info', 'Resto del Mundo', 'No hay métodos configurados');
            return;
        }

        $bluex_count = 0;
        $other_count = 0;

        foreach ($methods as $method) {
            // Verificar que $method sea un objeto válido
            if (!is_object($method)) {
                continue;
            }

            try {
                // Para métodos en instancias de zona, acceder a propiedades directamente
                $method_id = isset($method->id) ? $method->id : 'unknown';
                $method_title = isset($method->title) ? $method->title : (method_exists($method, 'get_method_title') ? $method->get_method_title() : 'Unknown Method');

                // Detectar si es un método Blue Express tanto por ID como por título
                $is_bluex_method = false;
                if (strpos($method_id, 'bluex') !== false) {
                    $is_bluex_method = true;
                } elseif (
                    strpos(strtolower($method_title), 'bluex') !== false ||
                    strpos(strtolower($method_title), 'blue express') !== false
                ) {
                    $is_bluex_method = true;
                }

                if ($is_bluex_method) {
                    $bluex_count++;
                } else {
                    $other_count++;
                }
            } catch (Exception $e) {
                // Log del error y continuar con el siguiente método
                error_log('Error processing rest of world method: ' . $e->getMessage());
                continue;
            }
        }

        $message = sprintf(
            'Zona "Resto del Mundo" tiene %d métodos Blue Express y %d otros métodos',
            $bluex_count,
            $other_count
        );

        self::add_result('info', 'Resto del Mundo', $message);
    }

    /**
     * Validate Blue Express methods registration
     */
    private static function validate_bluex_methods()
    {
        // Verificar que WooCommerce esté disponible
        if (!function_exists('WC') || !WC()->shipping) {
            self::add_result('error', 'Métodos Blue Express', 'WooCommerce o sistema de shipping no disponible');
            return;
        }

        try {
            $shipping_methods = WC()->shipping->get_shipping_methods();
        } catch (Exception $e) {
            self::add_result('error', 'Métodos Blue Express', 'Error al obtener métodos de shipping: ' . $e->getMessage());
            return;
        }

        $expected_bluex_methods = array(
            'bluex-ex' => 'WC_BlueX_EX',
            'bluex-py' => 'WC_BlueX_PY',
            'bluex-md' => 'WC_BlueX_MD'
        );

        foreach ($expected_bluex_methods as $method_id => $class_name) {
            if (isset($shipping_methods[$method_id])) {
                self::add_result('success', 'Métodos Blue Express', $method_id . ' está registrado');

                // Check if class exists and has correct inheritance
                if (class_exists($class_name)) {
                    try {
                        $reflection = new ReflectionClass($class_name);
                        if ($reflection->isSubclassOf('WC_Correios_Shipping')) {
                            self::add_result('success', 'Métodos Blue Express', $class_name . ' extiende correctamente WC_Correios_Shipping');
                        } else {
                            self::add_result('error', 'Métodos Blue Express', $class_name . ' no extiende WC_Correios_Shipping');
                        }
                    } catch (ReflectionException $e) {
                        self::add_result('error', 'Métodos Blue Express', 'Error al verificar herencia de ' . $class_name . ': ' . $e->getMessage());
                    }
                } else {
                    self::add_result('error', 'Métodos Blue Express', 'Clase ' . $class_name . ' no encontrada');
                }
            } else {
                self::add_result('error', 'Métodos Blue Express', $method_id . ' no está registrado');
            }
        }
    }

    /**
     * Check for potential zone conflicts
     */
    private static function check_zone_conflicts()
    {
        try {
            $zones = WC_Shipping_Zones::get_zones();
        } catch (Exception $e) {
            self::add_result('error', 'Conflictos de Zonas', 'Error al obtener zonas: ' . $e->getMessage());
            return;
        }

        // Check for overlapping zones that might cause issues
        $location_coverage = array();
        $zone_details = array();

        foreach ($zones as $zone_data) {
            // Verificar que $zone_data sea válido y tenga las claves necesarias
            if (!is_array($zone_data) || !isset($zone_data['id'])) {
                self::add_result('warning', 'Conflictos de Zonas', 'Datos de zona inválidos encontrados, omitiendo...');
                continue;
            }

            try {
                $zone = new WC_Shipping_Zone($zone_data['id']);
                $zone_name = $zone->get_zone_name();
                $zone_id = $zone_data['id'];
                $locations = $zone->get_zone_locations();
                $methods = $zone->get_shipping_methods();

                // Recopilar información detallada de cada zona
                $zone_info = array(
                    'id' => $zone_id,
                    'name' => $zone_name,
                    'order' => isset($zone_data['zone_order']) ? $zone_data['zone_order'] : 0,
                    'methods' => array(),
                    'bluex_methods' => 0,
                    'other_methods' => 0,
                    'enabled_methods' => 0
                );
            } catch (Exception $e) {
                self::add_result('error', 'Conflictos de Zonas', 'Error al procesar zona ID ' . $zone_data['id'] . ': ' . $e->getMessage());
                continue;
            }

            foreach ($methods as $method) {
                // Verificar que $method sea un objeto válido antes de usar sus métodos
                if (!is_object($method)) {
                    continue;
                }

                try {
                    $method_info = array(
                        'id' => isset($method->id) ? $method->id : 'unknown',
                        'title' => isset($method->title) ? $method->title : (method_exists($method, 'get_method_title') ? $method->get_method_title() : 'Unknown Method'),
                        'enabled' => isset($method->enabled) ? ('yes' === $method->enabled) : false
                    );

                    $zone_info['methods'][] = $method_info;

                    if ($method_info['enabled']) {
                        $zone_info['enabled_methods']++;
                    }

                    // Detectar si es un método Blue Express tanto por ID como por título
                    $is_bluex_method = false;
                    if (strpos($method_info['id'], 'bluex') !== false) {
                        $is_bluex_method = true;
                    } elseif (
                        strpos(strtolower($method_info['title']), 'bluex') !== false ||
                        strpos(strtolower($method_info['title']), 'blue express') !== false
                    ) {
                        $is_bluex_method = true;
                    }

                    if ($is_bluex_method) {
                        $zone_info['bluex_methods']++;
                    } else {
                        $zone_info['other_methods']++;
                    }
                } catch (Exception $e) {
                    // Log del error y continuar con el siguiente método
                    error_log('Error processing shipping method in zone ' . $zone_id . ': ' . $e->getMessage());
                    continue;
                }
            }

            foreach ($locations as $location) {
                // Verificar que $location sea un objeto válido y tenga las propiedades necesarias
                if (!is_object($location) || !isset($location->type) || !isset($location->code)) {
                    continue;
                }

                try {
                    $key = $location->type . ':' . $location->code;

                    if (isset($location_coverage[$key])) {
                        $location_coverage[$key][] = $zone_info;
                    } else {
                        $location_coverage[$key] = array($zone_info);
                    }
                } catch (Exception $e) {
                    // Log del error y continuar con la siguiente ubicación
                    error_log('Error processing location in zone ' . $zone_id . ': ' . $e->getMessage());
                    continue;
                }
            }

            $zone_details[$zone_id] = $zone_info;
        }

        // Report overlapping locations with detailed zone information
        foreach ($location_coverage as $location => $zones_list) {
            if (count($zones_list) > 1) {
                // Ordenar zonas por orden de prioridad
                usort($zones_list, function ($a, $b) {
                    return $a['order'] - $b['order'];
                });

                $conflict_details = array();
                $location_parts = explode(':', $location);
                $location_type = $location_parts[0];
                $location_code = $location_parts[1];

                // Traducir tipos de ubicación
                $location_types = array(
                    'country' => 'País',
                    'state' => 'Estado/Provincia',
                    'postcode' => 'Código Postal',
                    'continent' => 'Continente'
                );

                $location_name = isset($location_types[$location_type]) ? $location_types[$location_type] : $location_type;

                foreach ($zones_list as $index => $zone_info) {
                    $priority_note = ($index === 0) ? ' (🥇 ACTIVA - Mayor prioridad)' : ' (⚠️ Inactiva por conflicto)';

                    $methods_summary = sprintf(
                        'Blue Express: %d, Otros: %d, Habilitados: %d',
                        $zone_info['bluex_methods'],
                        $zone_info['other_methods'],
                        $zone_info['enabled_methods']
                    );

                    $conflict_details[] = sprintf(
                        '"%s" (ID: %d, Orden: %d)%s - Métodos: %s',
                        $zone_info['name'],
                        $zone_info['id'],
                        $zone_info['order'],
                        $priority_note,
                        $methods_summary
                    );
                }

                // Determinar nivel de severidad del conflicto
                $has_bluex_in_winner = $zones_list[0]['bluex_methods'] > 0;
                $has_bluex_in_losers = false;

                for ($i = 1; $i < count($zones_list); $i++) {
                    if ($zones_list[$i]['bluex_methods'] > 0) {
                        $has_bluex_in_losers = true;
                        break;
                    }
                }

                $status = 'warning';
                if ($has_bluex_in_losers && !$has_bluex_in_winner) {
                    $status = 'error'; // Blue Express está en zona de menor prioridad
                }

                $message = sprintf(
                    '🚨 CONFLICTO DETECTADO: %s "%s" está cubierta por %d zonas. Solo la primera zona será efectiva. Detalles: %s',
                    $location_name,
                    $location_code,
                    count($zones_list),
                    implode(' | ', $conflict_details)
                );

                self::add_result($status, 'Conflictos de Zonas', $message);

                // Agregar recomendación específica para el conflicto
                if ($has_bluex_in_losers && !$has_bluex_in_winner) {
                    self::add_result(
                        'error',
                        'Conflictos de Zonas - Recomendación Crítica',
                        sprintf(
                            '❌ PROBLEMA CRÍTICO: Blue Express está configurado en zonas de menor prioridad para %s "%s". Los clientes no verán opciones de Blue Express. ACCIÓN REQUERIDA: Mueve Blue Express a la zona "%s" (ID: %d) o reorganiza el orden de las zonas.',
                            $location_name,
                            $location_code,
                            $zones_list[0]['name'],
                            $zones_list[0]['id']
                        )
                    );
                } elseif ($has_bluex_in_losers && $has_bluex_in_winner) {
                    self::add_result(
                        'info',
                        'Conflictos de Zonas - Optimización',
                        sprintf(
                            '💡 OPTIMIZACIÓN: Blue Express está duplicado en múltiples zonas para %s "%s". Considera consolidar métodos en la zona activa "%s" (ID: %d) para simplificar gestión.',
                            $location_name,
                            $location_code,
                            $zones_list[0]['name'],
                            $zones_list[0]['id']
                        )
                    );
                }
            }
        }

        // Verificar zonas sin ubicaciones configuradas
        foreach ($zone_details as $zone_info) {
            if (empty($zone_info['methods'])) {
                continue; // Ya se reporta en otra validación
            }

            // Buscar si esta zona tiene ubicaciones
            $has_locations = false;
            foreach ($location_coverage as $zones_in_location) {
                foreach ($zones_in_location as $zone_in_location) {
                    if ($zone_in_location['id'] === $zone_info['id']) {
                        $has_locations = true;
                        break 2;
                    }
                }
            }

            if (!$has_locations && $zone_info['enabled_methods'] > 0) {
                self::add_result(
                    'warning',
                    'Configuración de Zonas',
                    sprintf(
                        '⚠️ ZONA INACCESIBLE: La zona "%s" (ID: %d) tiene %d métodos habilitados pero no tiene ubicaciones configuradas. Los clientes nunca verán estos métodos.',
                        $zone_info['name'],
                        $zone_info['id'],
                        $zone_info['enabled_methods']
                    )
                );
            }
        }
    }

    /**
     * Validate instance settings support
     */
    private static function validate_instance_settings()
    {
        // Verificar que WooCommerce esté disponible
        if (!function_exists('WC') || !WC()->shipping) {
            self::add_result('error', 'Configuración de Instancias', 'WooCommerce o sistema de shipping no disponible');
            return;
        }

        $expected_methods = array('bluex-ex', 'bluex-py', 'bluex-md');

        foreach ($expected_methods as $method_id) {
            try {
                $shipping_methods = WC()->shipping->get_shipping_methods();
            } catch (Exception $e) {
                self::add_result('error', 'Configuración de Instancias', 'Error al obtener métodos de shipping: ' . $e->getMessage());
                continue;
            }

            if (isset($shipping_methods[$method_id])) {
                $method = $shipping_methods[$method_id];

                try {
                    // Create a test instance
                    $test_instance = new $method(999);

                    // Check if supports shipping-zones
                    if (isset($test_instance->supports) && in_array('shipping-zones', $test_instance->supports)) {
                        self::add_result('success', 'Configuración de Instancias', $method_id . ' soporta shipping-zones');
                    } else {
                        self::add_result('error', 'Configuración de Instancias', $method_id . ' no soporta shipping-zones');
                    }

                    // Check if supports instance-settings
                    if (isset($test_instance->supports) && in_array('instance-settings', $test_instance->supports)) {
                        self::add_result('success', 'Configuración de Instancias', $method_id . ' soporta instance-settings');
                    } else {
                        self::add_result('error', 'Configuración de Instancias', $method_id . ' no soporta instance-settings');
                    }

                    // Check if instance_form_fields are configured
                    if (isset($test_instance->instance_form_fields) && !empty($test_instance->instance_form_fields)) {
                        self::add_result('success', 'Configuración de Instancias', $method_id . ' tiene campos de formulario de instancia configurados');
                    } else {
                        self::add_result('warning', 'Configuración de Instancias', $method_id . ' no tiene campos de formulario de instancia');
                    }
                } catch (Exception $e) {
                    self::add_result('error', 'Configuración de Instancias', 'Error al crear instancia de ' . $method_id . ': ' . $e->getMessage());
                }
            }
        }
    }

    /**
     * Add result to validation results
     * 
     * @param string $status
     * @param string $category
     * @param string $message
     */
    private static function add_result($status, $category, $message)
    {
        self::$validation_results[] = array(
            'status' => $status,
            'category' => $category,
            'message' => $message,
            'timestamp' => current_time('mysql')
        );
    }

    /**
     * Generate HTML report
     * 
     * @param array $results
     * @return string
     */
    public static function generate_html_report($results = null)
    {
        if ($results === null) {
            $results = self::validate_configuration();
        }

        $html = '<div class="bluex-validation-report">';
        $html .= '<h2>🔍 Reporte de Configuración de Zonas de Envío Blue Express</h2>';

        $counts = array(
            'success' => 0,
            'warning' => 0,
            'error' => 0,
            'info' => 0
        );

        foreach ($results as $result) {
            if (isset($counts[$result['status']])) {
                $counts[$result['status']]++;
            }
        }

        // Summary
        $html .= '<div class="summary">';
        $html .= '<h3>📊 Resumen</h3>';
        $html .= '<ul>';
        $html .= '<li><span class="status-success">✅ Exitosos: ' . $counts['success'] . '</span></li>';
        $html .= '<li><span class="status-warning">⚠️ Advertencias: ' . $counts['warning'] . '</span></li>';
        $html .= '<li><span class="status-error">❌ Errores: ' . $counts['error'] . '</span></li>';
        $html .= '<li><span class="status-info">ℹ️ Información: ' . $counts['info'] . '</span></li>';
        $html .= '</ul>';
        $html .= '</div>';

        // Detailed results
        $html .= '<div class="detailed-results">';
        $html .= '<h3>📋 Resultados Detallados</h3>';

        $current_category = '';
        foreach ($results as $result) {
            if ($result['category'] !== $current_category) {
                if ($current_category !== '') {
                    $html .= '</ul></div>';
                }
                $html .= '<div class="category-section">';
                $html .= '<h4>' . esc_html($result['category']) . '</h4>';
                $html .= '<ul>';
                $current_category = $result['category'];
            }

            $icons = array(
                'success' => '✅',
                'warning' => '⚠️',
                'error' => '❌',
                'info' => 'ℹ️'
            );

            $icon = isset($icons[$result['status']]) ? $icons[$result['status']] : 'ℹ️';

            $html .= '<li class="status-' . esc_attr($result['status']) . '">';
            $html .= $icon . ' ' . esc_html($result['message']);
            $html .= '</li>';
        }

        if ($current_category !== '') {
            $html .= '</ul></div>';
        }

        $html .= '</div>';

        // Recommendations
        $html .= self::generate_recommendations($results);

        // Add granular configuration section for BlueX Granular Zones Config class
        if (class_exists('WC_BlueX_Granular_Zones_Config')) {
            $html .= '<div class="bluex-granular-section">';
            $html .= '<h3>🚀 Configuración Automática de Zonas</h3>';
            $html .= '<p>¿Necesitas configurar zonas de envío BlueExpress rápidamente? Usa nuestra herramienta de configuración granular:</p>';
            $html .= '<button type="button" class="button button-primary" id="bluex-show-granular-config">';
            $html .= '<span class="dashicons dashicons-admin-settings" style="margin-right: 5px;"></span>';
            $html .= 'Configurar Zonas BlueExpress';
            $html .= '</button>';
            $html .= '<p><small>Esta herramienta te permitirá crear zonas de envío automáticamente seleccionando qué métodos BlueExpress deseas habilitar y para qué ubicaciones.</small></p>';
            $html .= '</div>';

            // Add the granular configuration modal
            $html .= WC_BlueX_Granular_Zones_Config::generate_granular_config_interface();

            // Add JavaScript for modal functionality
            $html .= WC_BlueX_Granular_Zones_Config::generate_modal_javascript();
        }

        $html .= '<style>
        .bluex-validation-report { 
            font-family: Arial, sans-serif; 
            max-width: 800px; 
            margin: 20px 0; 
        }
        .summary { 
            background: #f9f9f9; 
            padding: 15px; 
            border-radius: 5px; 
            margin-bottom: 20px; 
        }
        .category-section { 
            margin-bottom: 20px; 
        }
        .category-section h4 { 
            background: #e7e7e7; 
            padding: 10px; 
            margin: 0 0 10px 0; 
            border-radius: 3px; 
        }
        .status-success { color: #28a745; }
        .status-warning { color: #ffc107; }
        .status-error { color: #dc3545; }
        .status-info { color: #17a2b8; }
        .recommendations { 
            background: #fff3cd; 
            padding: 15px; 
            border-radius: 5px; 
            margin-top: 20px; 
        }
        .bluex-granular-section {
            background: #e7f3ff;
            border: 1px solid #2271b1;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }
        .bluex-granular-section h3 {
            margin-top: 0;
            color: #2271b1;
        }
        .bluex-granular-section button {
            font-size: 14px;
            height: auto;
            padding: 10px 15px;
        }
        </style>';

        $html .= '</div>';

        return $html;
    }

    /**
     * Generate recommendations based on results
     * 
     * @param array $results
     * @return string
     */
    private static function generate_recommendations($results)
    {
        $recommendations = array();

        // Análisis detallado de los resultados
        $has_errors = false;
        $has_zone_conflicts = false;
        $has_critical_bluex_conflicts = false;
        $has_zones_without_bluex = false;
        $has_zones_without_methods = false;
        $has_inaccessible_zones = false;
        $conflict_details = array();
        $critical_conflicts = array();

        foreach ($results as $result) {
            $message = $result['message'];

            if ($result['status'] === 'error') {
                $has_errors = true;

                // Detectar conflictos críticos específicos de Blue Express
                if (strpos($message, 'PROBLEMA CRÍTICO: Blue Express') !== false) {
                    $has_critical_bluex_conflicts = true;
                    $critical_conflicts[] = $message;
                }
            }

            // Detectar diferentes tipos de problemas
            if (strpos($message, 'CONFLICTO DETECTADO') !== false) {
                $has_zone_conflicts = true;
                // Extraer detalles del conflicto
                if (preg_match('/está cubierta por (\d+) zonas/', $message, $matches)) {
                    $conflict_details[] = 'Conflicto con ' . $matches[1] . ' zonas';
                }
            }

            if (strpos($message, 'no tiene métodos Blue Express') !== false) {
                $has_zones_without_bluex = true;
            }

            if (strpos($message, 'No hay métodos de envío') !== false) {
                $has_zones_without_methods = true;
            }

            if (strpos($message, 'ZONA INACCESIBLE') !== false) {
                $has_inaccessible_zones = true;
            }
        }

        // Recomendaciones específicas basadas en análisis detallado
        if ($has_critical_bluex_conflicts) {
            $recommendations[] = '🚨 <strong>ACCIÓN INMEDIATA REQUERIDA:</strong> Se detectaron conflictos críticos que impiden que los clientes vean opciones de Blue Express. Revisa los conflictos marcados como "PROBLEMA CRÍTICO" y reorganiza las zonas inmediatamente.';

            $recommendations[] = '🔧 <strong>Pasos para resolver conflictos críticos:</strong><br>' .
                '1. Ve a <a href="' . admin_url('admin.php?page=wc-settings&tab=shipping') . '" target="_blank">WooCommerce > Ajustes > Envío</a><br>' .
                '2. Arrastra las zonas con Blue Express hacia arriba en la lista<br>' .
                '3. O agrega métodos Blue Express a las zonas de mayor prioridad<br>' .
                '4. Ejecuta una nueva validación para confirmar la corrección';
        }

        if ($has_errors && !$has_critical_bluex_conflicts) {
            $recommendations[] = '🔧 <strong>Errores Críticos:</strong> Corrige los errores listados arriba antes de proceder con la configuración de zonas.';
        }

        if ($has_zone_conflicts && count($conflict_details) > 0) {
            $recommendations[] = '⚠️ <strong>Conflictos de Zonas Detectados (' . count($conflict_details) . '):</strong> ' .
                'Las zonas se procesan en orden de prioridad. Asegúrate de que las zonas más específicas (códigos postales, ciudades) estén antes que las más generales (países, continentes). ' .
                '<a href="' . admin_url('admin.php?page=wc-settings&tab=shipping') . '" target="_blank">Reorganizar zonas</a>';
        }

        if ($has_inaccessible_zones) {
            $recommendations[] = '🗺️ <strong>Zonas Inaccesibles:</strong> Algunas zonas tienen métodos configurados pero no tienen ubicaciones geográficas asignadas. Los clientes nunca verán estos métodos de envío. Agrega ubicaciones a estas zonas o desactiva sus métodos.';
        }

        if ($has_zones_without_bluex) {
            $recommendations[] = '💡 <strong>Oportunidad de Expansión:</strong> Considera agregar métodos Blue Express a las zonas que actualmente solo tienen otros couriers para ofrecer más opciones a tus clientes.';
        }

        if ($has_zones_without_methods) {
            $recommendations[] = '⚙️ <strong>Zonas Vacías:</strong> Agrega métodos de envío a las zonas que no tienen métodos configurados, o elimina las zonas innecesarias.';
        }

        // Recomendaciones generales mejoradas
        if (!$has_critical_bluex_conflicts && !$has_errors) {
            $recommendations[] = '✅ <strong>Configuración Funcional:</strong> Tu configuración básica está operativa, pero revisa las recomendaciones de optimización abajo.';
        }

        $recommendations[] = '📚 <strong>Mejores Prácticas de Ordenamiento:</strong><br>' .
            '• Códigos postales específicos (mayor prioridad)<br>' .
            '• Estados/Provincias<br>' .
            '• Países<br>' .
            '• Continentes (menor prioridad)<br>' .
            '• Resto del mundo (última opción)';

        $recommendations[] = '🔄 <strong>Pruebas Recomendadas:</strong> Simula el checkout con direcciones de diferentes zonas para verificar que aparezcan las opciones correctas de envío. Usa herramientas como "Vista previa de pedido" de WooCommerce.';

        $recommendations[] = '📊 <strong>Monitoreo Continuo:</strong> Revisa periódicamente las estadísticas de métodos de envío seleccionados en tus pedidos para identificar patrones y optimizar la configuración.';

        // Agregar botón de acción si hay problemas críticos
        if ($has_critical_bluex_conflicts || $has_zone_conflicts) {
            $recommendations[] = '🚀 <strong>Herramientas de Ayuda:</strong> ' .
                '<a href="' . admin_url('admin.php?page=wc-settings&tab=shipping') . '" class="button button-primary" target="_blank">Configurar Zonas de Envío</a> ' .
                '<button onclick="bluexRevalidateZones()" class="button">🔄 Validar Nuevamente</button>';
        }

        if (empty($recommendations)) {
            return '';
        }

        $html = '<div class="recommendations">';
        $html .= '<h3>💡 Recomendaciones</h3>';
        $html .= '<ul>';
        foreach ($recommendations as $rec) {
            $html .= '<li>' . wp_kses_post($rec) . '</li>';
        }
        $html .= '</ul>';
        $html .= '</div>';

        return $html;
    }

    /**
     * AJAX handler for zone validation
     */
    public static function ajax_validate_zones()
    {
        check_ajax_referer('bluex_validate_zones', 'nonce');

        if (! current_user_can('manage_woocommerce')) {
            wp_die('Permisos insuficientes');
        }

        $results = self::validate_configuration();

        wp_send_json_success(array(
            'results' => $results,
            'html' => self::generate_html_report($results)
        ));
    }

    /**
     * Get validation summary for Quick Checker integration
     * 
     * @return array
     */
    public static function get_validation_summary()
    {
        $results = self::validate_configuration();

        $summary = array(
            'total_checks' => count($results),
            'errors' => 0,
            'warnings' => 0,
            'success' => 0,
            'info' => 0,
            'status' => 'unknown'
        );

        foreach ($results as $result) {
            if (isset($summary[$result['status']])) {
                $summary[$result['status']]++;
            }
        }

        // Determine overall status
        if ($summary['errors'] > 0) {
            $summary['status'] = 'error';
        } elseif ($summary['warnings'] > 0) {
            $summary['status'] = 'warning';
        } else {
            $summary['status'] = 'success';
        }

        return $summary;
    }
}
