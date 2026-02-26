<?php
/**
 * BlueX Shipping Zone Automation
 *
 * Automatiza la configuración de zonas de envío para métodos Blue Express
 *
 * @package WooCommerce_BlueX/Classes
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Clase principal para automatización de zonas de envío
 */
class WC_BlueX_Shipping_Zone_Automation {

    /**
     * Instancia única de la clase
     */
    private static $instance = null;

    /**
     * Configuración de regiones de Chile
     */
    private $chilean_regions = [
        'CL-RM' => 'Región Metropolitana',
        'CL-VS' => 'Valparaíso',
        'CL-BI' => 'Biobío',
        'CL-CO' => 'Coquimbo',
        'CL-LI' => 'Libertador General Bernardo O\'Higgins',
        'CL-ML' => 'Maule',
        'CL-NB' => 'Ñuble',
        'CL-AR' => 'La Araucanía',
        'CL-LR' => 'Los Ríos',
        'CL-LL' => 'Los Lagos',
        'CL-AI' => 'Aysén del General Carlos Ibáñez del Campo',
        'CL-MA' => 'Magallanes y de la Antártica Chilena',
        'CL-AP' => 'Arica y Parinacota',
        'CL-TA' => 'Tarapacá',
        'CL-AN' => 'Antofagasta',
        'CL-AT' => 'Atacama'
    ];

    /**
     * Estrategias disponibles para zonificación
     */
    private $available_strategies = [
        'national' => 'Zona nacional (todo Chile)',
        'by_region' => 'Por región administrativa (16 zonas)',
        'by_commune' => 'Por comunas principales',
        'hybrid' => 'Híbrida (metropolitana + regional)'
    ];

    /**
     * Obtener instancia única
     */
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor privado
     */
    private function __construct() {
        // Constructor privado para patrón singleton
    }

    /**
     * Crear zonas de envío automáticamente
     *
     * @param array $options Opciones de configuración
     * @return array Resultado de la operación
     */
    public function create_zones($options = []) {
        // Asegurar que el tipo de ubicación 'city' esté registrado
        if (class_exists('WC_BlueX_City_Zone_Matcher')) {
            add_filter('woocommerce_location_types', array('WC_BlueX_City_Zone_Matcher', 'add_location_type'));
        }


        $default_options = [
            'strategy' => 'national',
            'methods' => ['bluex-ex', 'bluex-py', 'bluex-md'],
            'regions' => null,
            'communes' => null,
            'mode' => 'create_new',
            'include_pudos' => true,
            'dry_run' => false,
            'backup_existing' => false,  // Deshabilitado por defecto
            'exclude_islands' => true,
            'fee' => null // IVA / Handling Fee (null = no cambiar, '' = borrar, valor = setear)
        ];

        $options = array_merge($default_options, $options);

        try {
            // Validar prerrequisitos
            $this->validate_prerequisites();

            // Backup deshabilitado para evitar errores
            // if ($options['backup_existing'] && !$options['dry_run']) {
            //     $this->create_backup();
            // }

            $results = [];
            $summary = [
                'zones_created' => 0,
                'zones_skipped' => 0,
                'zones_updated' => 0,
                'methods_added' => 0,
                'errors_count' => 0
            ];
            $duplicates = [];
            $conflicts = [];

            switch ($options['strategy']) {
                case 'national':
                    $result = $this->create_zones_national($options);
                    break;
                case 'by_region':
                    $result = $this->create_zones_by_region($options);
                    break;
                case 'by_commune':
                    $result = $this->create_zones_by_commune($options);
                    break;
                case 'hybrid':
                    $result = $this->create_zones_hybrid($options);
                    break;
                default:
                    throw new Exception('Estrategia de zonificación no válida. Opciones disponibles: ' . implode(', ', array_keys($this->available_strategies)));
            }

            $results = $result['details'];
            $summary = $result['summary'];
            $duplicates = $result['duplicates'];
            $conflicts = $result['conflicts'];

            // Log de resultados
            $this->log_operation('create_zones', [
                'strategy' => $options['strategy'],
                'mode' => $options['mode'],
                'dry_run' => $options['dry_run'],
                'summary' => $summary,
                'options' => $options
            ]);

            return [
                'success' => true,
                'message' => $this->build_success_message($summary, $options),
                'summary' => $summary,
                'details' => $results,
                'duplicates' => $duplicates,
                'conflicts' => $conflicts
            ];

        } catch (Exception $e) {
            $this->log_operation('create_zones_error', [
                'error' => $e->getMessage(),
                'options' => $options
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Crear zona nacional (todo Chile)
     */
    private function create_zones_national($options) {
        $summary = [
            'zones_created' => 0,
            'zones_skipped' => 0,
            'zones_updated' => 0,
            'methods_added' => 0,
            'errors_count' => 0
        ];
        $details = [];
        $duplicates = [];
        $conflicts = [];

        $zone_name = 'Todo Chile - Blue Express';
        
        // Verificar si ya existe una zona nacional BlueX
        $existing_zone = null;
        $zones = WC_Shipping_Zones::get_zones();
        
        foreach ($zones as $zone_data) {
            $zone = new WC_Shipping_Zone($zone_data['id']);
            $name = $zone->get_zone_name();
            
            if (stripos($name, 'todo chile') !== false && (stripos($name, 'blue') !== false || stripos($name, 'bluex') !== false)) {
                $existing_zone = [
                    'zone_id' => $zone->get_id(),
                    'zone_name' => $name
                ];
                break;
            }
        }

        // Manejar según el modo
    if ($existing_zone && $options['mode'] === 'create_new') {
        // Zona duplicada - skip
        $summary['zones_skipped']++;
        $duplicates[] = $existing_zone['zone_name'];
        
        $details[] = [
            'zone_name' => $zone_name,
            'coverage' => 'Todo Chile (' . count($this->chilean_regions) . ' regiones)',
            'zone_id' => $existing_zone['zone_id'],
            'action' => 'skipped',
            'reason' => 'Ya existe una zona nacional BlueX',
            'status' => 'skipped'
        ];
    } elseif ($existing_zone && ($options['mode'] === 'add_to_existing' || $options['mode'] === 'replace_existing')) {
        // Actualizar zona existente
        if (!$options['dry_run']) {
            $methods_added = $this->update_methods_in_zone($existing_zone['zone_id'], $options['methods'], $options['mode'], $options['fee']);
            $summary['methods_added'] += $methods_added;
            $summary['zones_updated']++;
        } else {
            $summary['zones_updated']++;
            $summary['methods_added'] += count($options['methods']);
        }
        
        $details[] = [
            'zone_name' => $existing_zone['zone_name'],
            'coverage' => 'Todo Chile (' . count($this->chilean_regions) . ' regiones)',
            'zone_id' => $existing_zone['zone_id'],
            'action' => $options['mode'],
            'methods_added' => $options['dry_run'] ? count($options['methods']) : $methods_added,
            'status' => $options['dry_run'] ? 'simulated' : 'updated',
            'fee_updated' => !empty($options['fee'])
        ];
    } else {
        // Crear nueva zona
        $zone_id = null;
        
        if (!$options['dry_run']) {
            $zone_data = [
                'zone_name' => $zone_name,
                'zone_order' => $this->get_next_zone_order()
            ];
            
            $zone_id = $this->create_woocommerce_zone($zone_data);

            // Agregar todas las regiones de Chile a la zona
            foreach (array_keys($this->chilean_regions) as $region_code) {
                // add_region_to_zone ya maneja el prefijo CL:
                $this->add_region_to_zone($zone_id, $region_code);
            }

            $this->add_shipping_methods_to_zone($zone_id, $options['methods'], $options['fee']);
            $summary['methods_added'] += count($options['methods']);
        } else {
            $summary['methods_added'] += count($options['methods']);
        }
        
        $summary['zones_created']++;
        
        $details[] = [
            'zone_name' => $zone_name,
            'coverage' => 'Todo Chile (' . count($this->chilean_regions) . ' regiones)',
            'zone_id' => $zone_id,
            'action' => 'created',
            'methods_added' => count($options['methods']),
            'status' => $options['dry_run'] ? 'simulated' : 'created',
            'fee_set' => !empty($options['fee'])
        ];
    }

        return [
            'summary' => $summary,
            'details' => $details,
            'duplicates' => $duplicates,
            'conflicts' => $conflicts
        ];
    }

    /**
     * Crear zonas por región administrativa
     */
    private function create_zones_by_region($options) {
        $summary = [
            'zones_created' => 0,
            'zones_skipped' => 0,
            'zones_updated' => 0,
            'methods_added' => 0,
            'errors_count' => 0
        ];
        $details = [];
        $duplicates = [];
        $conflicts = [];

        // Determinar qué regiones procesar
        $regions_to_process = $options['regions'] ?? array_keys($this->chilean_regions);
        
        foreach ($regions_to_process as $region_code) {
            // Validar que la región exista
            if (!isset($this->chilean_regions[$region_code])) {
                $summary['errors_count']++;
                continue;
            }
            
            // Si es Valparaíso y exclude_islands está activo, crear zona de exclusión primero
            if ($region_code === 'CL-VS' && $options['exclude_islands']) {
                $exclusion_result = $this->create_exclusion_zone($region_code, $options);
                
                if ($exclusion_result) {
                    if ($exclusion_result['action'] === 'created') {
                        $summary['zones_created']++;
                    }
                    
                    $details[] = [
                        'type' => 'exclusion_zone',
                        'region_code' => $region_code,
                        'zone_name' => $exclusion_result['zone_name'],
                        'zone_id' => $exclusion_result['zone_id'] ?? null,
                        'action' => $exclusion_result['action'],
                        'postcodes_count' => $exclusion_result['postcodes_count'],
                        'status' => $options['dry_run'] ? 'simulated' : $exclusion_result['action'],
                        'note' => 'Zona de exclusión sin métodos BlueX (islas remotas)'
                    ];
                }
            }
            
            $region_name = $this->chilean_regions[$region_code];
            $zone_name = $region_name . ' - Blue Express';
            
            // Verificar si ya existe una zona BlueX para esta región
            // WooCommerce usa formato Country:State (CL:CL-RM)
            $location_code = 'CL:' . $region_code;
            $existing_zone = $this->find_existing_bluex_zone($location_code, 'state');
            
            if ($existing_zone && $options['mode'] === 'create_new') {
                // Zona duplicada - skip
                $summary['zones_skipped']++;
                $duplicates[] = $existing_zone['zone_name'];
                
                $details[] = [
                    'region_code' => $region_code,
                    'region_name' => $region_name,
                    'zone_id' => $existing_zone['zone_id'],
                    'action' => 'skipped',
                    'reason' => 'Ya existe una zona BlueX para esta región',
                    'status' => 'skipped'
                ];
            } elseif ($existing_zone && ($options['mode'] === 'add_to_existing' || $options['mode'] === 'replace_existing')) {
                // Actualizar zona existente
                if (!$options['dry_run']) {
                    $methods_added = $this->update_methods_in_zone($existing_zone['zone_id'], $options['methods'], $options['mode'], $options['fee']);
                    $summary['methods_added'] += $methods_added;
                    $summary['zones_updated']++;
                } else {
                    $summary['zones_updated']++;
                    $summary['methods_added'] += count($options['methods']);
                }
                
                $details[] = [
                    'region_code' => $region_code,
                    'region_name' => $region_name,
                    'zone_id' => $existing_zone['zone_id'],
                    'zone_name' => $existing_zone['zone_name'],
                    'action' => $options['mode'],
                    'methods_added' => $options['dry_run'] ? count($options['methods']) : $methods_added,
                    'status' => $options['dry_run'] ? 'simulated' : 'updated',
                    'fee_updated' => !empty($options['fee'])
                ];
            } else {
                // Crear nueva zona
                $zone_id = null;
                
                if (!$options['dry_run']) {
                    $zone_data = [
                        'zone_name' => $zone_name,
                        'zone_order' => $this->get_next_zone_order()
                    ];
                    
                    $zone_id = $this->create_woocommerce_zone($zone_data);
                    $this->add_region_to_zone($zone_id, $region_code);
                    $this->add_shipping_methods_to_zone($zone_id, $options['methods'], $options['fee']);
                    $summary['methods_added'] += count($options['methods']);
                } else {
                    $summary['methods_added'] += count($options['methods']);
                }
                
                $summary['zones_created']++;
                
                $details[] = [
                    'region_code' => $region_code,
                    'region_name' => $region_name,
                    'zone_name' => $zone_name,
                    'zone_id' => $zone_id,
                    'action' => 'created',
                    'methods_added' => count($options['methods']),
                    'status' => $options['dry_run'] ? 'simulated' : 'created',
                    'fee_set' => !empty($options['fee'])
                ];
            }
        }

        return [
            'summary' => $summary,
            'details' => $details,
            'duplicates' => $duplicates,
            'conflicts' => $conflicts
        ];
    }

    /**
     * Crear zonas por comuna (estrategia granular)
     * TODO: Cuando esté disponible WC_BlueX_Commune_Postcodes, usar códigos postales reales
     */
    private function create_zones_by_commune($options) {
        $summary = [
            'zones_created' => 0,
            'zones_skipped' => 0,
            'zones_updated' => 0,
            'methods_added' => 0,
            'errors_count' => 0
        ];
        $details = [];
        $duplicates = [];
        $conflicts = [];

        // Determinar qué comunas procesar
        $communes_to_process = $options['communes'] ?? $this->get_main_communes();
        
        // Si se pasó un array plano de comunas, convertirlo al formato esperado
        if (isset($communes_to_process[0]) && is_string($communes_to_process[0])) {
            $communes_by_region = [];
            foreach ($communes_to_process as $commune) {
                $communes_by_region['CL-RM'][] = $commune; // Default a RM
            }
            $communes_to_process = $communes_by_region;
        }

        foreach ($communes_to_process as $region_code => $communes) {
            foreach ($communes as $commune_name) {
                $zone_name = $commune_name . ' - Blue Express';
                
                // Por ahora, buscar por nombre de zona ya que no tenemos postcodes
                $existing_zone = $this->find_zone_by_name($zone_name);
                
                if ($existing_zone && $options['mode'] === 'create_new') {
                    $summary['zones_skipped']++;
                    $duplicates[] = $existing_zone['zone_name'];
                    
                    $details[] = [
                        'commune_name' => $commune_name,
                        'region_code' => $region_code,
                        'zone_id' => $existing_zone['zone_id'],
                        'action' => 'skipped',
                        'reason' => 'Ya existe una zona para esta comuna',
                        'status' => 'skipped'
                    ];
                } elseif ($existing_zone && ($options['mode'] === 'add_to_existing' || $options['mode'] === 'replace_existing')) {
                    if (!$options['dry_run']) {
                        $methods_added = $this->update_methods_in_zone($existing_zone['zone_id'], $options['methods'], $options['mode'], $options['fee']);
                        $summary['methods_added'] += $methods_added;
                        $summary['zones_updated']++;
                    } else {
                        $summary['zones_updated']++;
                        $summary['methods_added'] += count($options['methods']);
                    }
                    
                    $details[] = [
                        'commune_name' => $commune_name,
                        'region_code' => $region_code,
                        'zone_id' => $existing_zone['zone_id'],
                        'zone_name' => $existing_zone['zone_name'],
                        'action' => $options['mode'],
                        'methods_added' => $options['dry_run'] ? count($options['methods']) : $methods_added,
                        'status' => $options['dry_run'] ? 'simulated' : 'updated',
                        'fee_updated' => !empty($options['fee'])
                    ];
                } else {
                    $zone_id = null;
                    
                    if (!$options['dry_run']) {
                        $zone_data = [
                            'zone_name' => $zone_name,
                            'zone_order' => $this->get_next_zone_order()
                        ];
                        
                        $zone_id = $this->create_woocommerce_zone($zone_data);
                        
                        // Usar el nuevo tipo de ubicación 'city' implementado en WC_BlueX_City_Zone_Matcher
                        $zone = WC_Shipping_Zones::get_zone($zone_id);
                        
                        // CAMBIO ESTRATEGIA: Usar 'postcode' en lugar de 'city'
                        // WooCommerce filtra tipos desconocidos al cargar la zona, por eso 'city' desaparecía.
                        // Usaremos el nombre de la comuna como un "código postal" para aprovechar la validación nativa.
                        
                        $zone->add_location($commune_name, 'postcode');
                        $zone->save();

                        // Verificar si se guardó correctamente
                        $zone = new WC_Shipping_Zone($zone_id);
                        $final_locations = $zone->get_zone_locations();
                        
                        $location_saved = false;
                        foreach ($final_locations as $loc) {
                            if ($loc->type === 'postcode' && $loc->code === $commune_name) {
                                $location_saved = true;
                                break;
                            }
                        }

                        // Log para depuración
                        $this->log_operation('zone_location_added', [
                            'zone_id' => $zone_id,
                            'commune' => $commune_name,
                            'type_used' => 'postcode',
                            'success' => $location_saved,
                            'locations_count' => count($final_locations)
                        ]);

                        $this->add_shipping_methods_to_zone($zone_id, $options['methods'], $options['fee']);
                        $summary['methods_added'] += count($options['methods']);
                    } else {
                        $summary['methods_added'] += count($options['methods']);
                    }
                    
                    $summary['zones_created']++;
                    
                    $details[] = [
                        'commune_name' => $commune_name,
                        'region_code' => $region_code,
                        'zone_name' => $zone_name,
                        'zone_id' => $zone_id,
                        'action' => 'created',
                        'methods_added' => count($options['methods']),
                        'status' => $options['dry_run'] ? 'simulated' : 'created',
                        'fee_set' => !empty($options['fee'])
                    ];
                }
            }
        }

        return [
            'summary' => $summary,
            'details' => $details,
            'duplicates' => $duplicates,
            'conflicts' => $conflicts
        ];
    }

    /**
     * Crear zonas usando estrategia híbrida
     */
    private function create_zones_hybrid($options) {
        $summary = [
            'zones_created' => 0,
            'zones_skipped' => 0,
            'zones_updated' => 0,
            'methods_added' => 0,
            'errors_count' => 0
        ];
        $details = [];
        $duplicates = [];
        $conflicts = [];

        // Crear zonas metropolitanas para regiones densas
        $metro_regions = ['CL-RM', 'CL-VS', 'CL-BI'];
        
        foreach ($metro_regions as $region_code) {
            $region_name = $this->chilean_regions[$region_code];
            $zone_name = $region_name . ' (Metro) - Blue Express';
            
            // WooCommerce usa formato Country:State (CL:CL-RM)
            $location_code = 'CL:' . $region_code;
            $existing_zone = $this->find_existing_bluex_zone($location_code, 'state');
            
            if ($existing_zone && $options['mode'] === 'create_new') {
                $summary['zones_skipped']++;
                $duplicates[] = $existing_zone['zone_name'];
                
                $details[] = [
                    'type' => 'metro_zone',
                    'region_code' => $region_code,
                    'region_name' => $region_name,
                    'zone_id' => $existing_zone['zone_id'],
                    'action' => 'skipped',
                    'status' => 'skipped'
                ];
            } elseif ($existing_zone && ($options['mode'] === 'add_to_existing' || $options['mode'] === 'replace_existing')) {
                if (!$options['dry_run']) {
                    $methods_added = $this->update_methods_in_zone($existing_zone['zone_id'], $options['methods'], $options['mode'], $options['fee']);
                    $summary['methods_added'] += $methods_added;
                    $summary['zones_updated']++;
                } else {
                    $summary['zones_updated']++;
                    $summary['methods_added'] += count($options['methods']);
                }
                
                $details[] = [
                    'type' => 'metro_zone',
                    'region_code' => $region_code,
                    'region_name' => $region_name,
                    'zone_id' => $existing_zone['zone_id'],
                    'action' => $options['mode'],
                    'methods_added' => $options['dry_run'] ? count($options['methods']) : $methods_added,
                    'status' => $options['dry_run'] ? 'simulated' : 'updated',
                    'fee_updated' => !empty($options['fee'])
                ];
            } else {
                $zone_id = null;
                
                if (!$options['dry_run']) {
                    $zone_data = [
                        'zone_name' => $zone_name,
                        'zone_order' => $this->get_next_zone_order()
                    ];
                    
                    $zone_id = $this->create_woocommerce_zone($zone_data);
                    $this->add_region_to_zone($zone_id, $region_code);
                    $this->add_shipping_methods_to_zone($zone_id, $options['methods'], $options['fee']);
                    $summary['methods_added'] += count($options['methods']);
                } else {
                    $summary['methods_added'] += count($options['methods']);
                }
                
                $summary['zones_created']++;
                
                $details[] = [
                    'type' => 'metro_zone',
                    'region_code' => $region_code,
                    'region_name' => $region_name,
                    'zone_name' => $zone_name,
                    'zone_id' => $zone_id,
                    'action' => 'created',
                    'methods_added' => count($options['methods']),
                    'status' => $options['dry_run'] ? 'simulated' : 'created',
                    'fee_set' => !empty($options['fee'])
                ];
            }
        }

        // Crear zonas regionales para el resto
        $regional_regions = array_diff(array_keys($this->chilean_regions), $metro_regions);
        
        foreach ($regional_regions as $region_code) {
            $region_name = $this->chilean_regions[$region_code];
            $zone_name = $region_name . ' (Regional) - Blue Express';
            
            // WooCommerce usa formato Country:State (CL:CL-RM)
            $location_code = 'CL:' . $region_code;
            $existing_zone = $this->find_existing_bluex_zone($location_code, 'state');
            
            if ($existing_zone && $options['mode'] === 'create_new') {
                $summary['zones_skipped']++;
                $duplicates[] = $existing_zone['zone_name'];
                
                $details[] = [
                    'type' => 'regional_zone',
                    'region_code' => $region_code,
                    'region_name' => $region_name,
                    'zone_id' => $existing_zone['zone_id'],
                    'action' => 'skipped',
                    'status' => 'skipped'
                ];
            } elseif ($existing_zone && ($options['mode'] === 'add_to_existing' || $options['mode'] === 'replace_existing')) {
                if (!$options['dry_run']) {
                    $methods_added = $this->update_methods_in_zone($existing_zone['zone_id'], $options['methods'], $options['mode'], $options['fee']);
                    $summary['methods_added'] += $methods_added;
                    $summary['zones_updated']++;
                } else {
                    $summary['zones_updated']++;
                    $summary['methods_added'] += count($options['methods']);
                }
                
                $details[] = [
                    'type' => 'regional_zone',
                    'region_code' => $region_code,
                    'region_name' => $region_name,
                    'zone_id' => $existing_zone['zone_id'],
                    'action' => $options['mode'],
                    'methods_added' => $options['dry_run'] ? count($options['methods']) : $methods_added,
                    'status' => $options['dry_run'] ? 'simulated' : 'updated',
                    'fee_updated' => !empty($options['fee'])
                ];
            } else {
                $zone_id = null;
                
                if (!$options['dry_run']) {
                    $zone_data = [
                        'zone_name' => $zone_name,
                        'zone_order' => $this->get_next_zone_order()
                    ];
                    
                    $zone_id = $this->create_woocommerce_zone($zone_data);
                    $this->add_region_to_zone($zone_id, $region_code);
                    $this->add_shipping_methods_to_zone($zone_id, $options['methods'], $options['fee']);
                    $summary['methods_added'] += count($options['methods']);
                } else {
                    $summary['methods_added'] += count($options['methods']);
                }
                
                $summary['zones_created']++;
                
                $details[] = [
                    'type' => 'regional_zone',
                    'region_code' => $region_code,
                    'region_name' => $region_name,
                    'zone_name' => $zone_name,
                    'zone_id' => $zone_id,
                    'action' => 'created',
                    'methods_added' => count($options['methods']),
                    'status' => $options['dry_run'] ? 'simulated' : 'created',
                    'fee_set' => !empty($options['fee'])
                ];
            }
        }

        return [
            'summary' => $summary,
            'details' => $details,
            'duplicates' => $duplicates,
            'conflicts' => $conflicts
        ];
    }

    /**
     * Buscar zona por nombre
     *
     * @param string $zone_name Nombre de la zona a buscar
     * @return array|null Información de la zona encontrada o null
     */
    private function find_zone_by_name($zone_name) {
        $zones = WC_Shipping_Zones::get_zones();
        
        foreach ($zones as $zone_data) {
            $zone = new WC_Shipping_Zone($zone_data['id']);
            $name = $zone->get_zone_name();
            
            if (stripos($name, $zone_name) !== false || stripos($zone_name, $name) !== false) {
                return [
                    'zone_id' => $zone->get_id(),
                    'zone_name' => $name,
                    'methods' => $zone->get_shipping_methods()
                ];
            }
        }
        
        return null;
    }

    /**
     * Validar prerrequisitos antes de crear zonas
     */
    private function validate_prerequisites() {
        // Verificar que WooCommerce esté activo
        if (!function_exists('WC')) {
            throw new Exception('WooCommerce no está activo');
        }

        // Verificar que los métodos Blue Express estén disponibles
        $available_methods = WC()->shipping->get_shipping_methods();
        $required_methods = ['bluex-ex', 'bluex-py', 'bluex-md'];

        foreach ($required_methods as $method_id) {
            if (!isset($available_methods[$method_id])) {
                throw new Exception("Método de envío {$method_id} no está disponible");
            }
        }

        // Verificar permisos
        if (!current_user_can('manage_woocommerce')) {
            throw new Exception('Permisos insuficientes para gestionar zonas de envío');
        }
    }

    /**
     * Crear zona en WooCommerce
     */
    private function create_woocommerce_zone($zone_data) {
        $zone = new WC_Shipping_Zone();
        $zone->set_zone_name($zone_data['zone_name']);
        $zone->set_zone_order($zone_data['zone_order']);
        $zone->save();

        return $zone->get_id();
    }

    /**
     * Agregar región a zona
     */
    private function add_region_to_zone($zone_id, $region_code) {
        $zone = WC_Shipping_Zones::get_zone($zone_id);
        // WooCommerce espera el formato Country:State (ej: CL:CL-RM)
        $location_code = 'CL:' . $region_code;
        $zone->add_location($location_code, 'state');
        $zone->save();
    }

    /**
     * Agregar métodos de envío a zona
     */
    private function add_shipping_methods_to_zone($zone_id, $methods, $fee = '') {
        $zone = WC_Shipping_Zones::get_zone($zone_id);
        
        foreach ($methods as $method_id) {
            // Verificar si el método ya está en la zona
            $zone_methods = $zone->get_shipping_methods();
            $method_exists = false;
            $instance_id = 0;

            foreach ($zone_methods as $zone_method) {
                if ($zone_method->id === $method_id) {
                    $method_exists = true;
                    $instance_id = $zone_method->instance_id;
                    break;
                }
            }

            if (!$method_exists) {
                $instance_id = $zone->add_shipping_method($method_id);
                $this->log_operation('method_added', ['method_id' => $method_id, 'instance_id' => $instance_id]);
            }
            
            // Actualizar fee si se proporcionó (null significa no cambiar)
            if ($instance_id && $fee !== null) {
                $this->update_method_fee($instance_id, $method_id, $fee);
            }
        }

        $zone->save();
    }

    /**
     * Obtener siguiente orden de zona
     */
    private function get_next_zone_order() {
        $zones = WC_Shipping_Zones::get_zones();
        $max_order = 0;

        foreach ($zones as $zone) {
            $order = $zone->zone_order;
            if ($order > $max_order) {
                $max_order = $order;
            }
        }

        return $max_order + 1;
    }

    /**
     * Construir mensaje de éxito basado en el resumen
     * 
     * @param array $summary Resumen de la operación
     * @param array $options Opciones usadas
     * @return string Mensaje descriptivo
     */
    private function build_success_message($summary, $options) {
        $parts = [];
        
        if ($options['dry_run']) {
            $parts[] = 'Simulación completada';
        } else {
            $parts[] = 'Operación completada';
        }
        
        if ($summary['zones_created'] > 0) {
            $parts[] = sprintf('%d zona(s) creada(s)', $summary['zones_created']);
        }
        
        if ($summary['zones_updated'] > 0) {
            $parts[] = sprintf('%d zona(s) actualizada(s)', $summary['zones_updated']);
        }
        
        if ($summary['zones_skipped'] > 0) {
            $parts[] = sprintf('%d zona(s) omitida(s) por duplicación', $summary['zones_skipped']);
        }
        
        if ($summary['methods_added'] > 0) {
            $parts[] = sprintf('%d método(s) agregado(s)', $summary['methods_added']);
        }
        
        if ($summary['errors_count'] > 0) {
            $parts[] = sprintf('%d error(es)', $summary['errors_count']);
        }
        
        return implode(', ', $parts) . ' usando estrategia: ' . $options['strategy'];
    }

    /**
     * Verificar si existe una zona BlueX para una ubicación específica
     * 
     * @param string $location_code Código de ubicación (ej: CL-RM)
     * @param string $location_type Tipo de ubicación (state, postcode, country)
     * @return array|null Información de la zona existente o null
     */
    private function find_existing_bluex_zone($location_code, $location_type = 'state') {
        $zones = WC_Shipping_Zones::get_zones();
        
        foreach ($zones as $zone_data) {
            $zone = new WC_Shipping_Zone($zone_data['id']);
            $zone_name = $zone->get_zone_name();
            
            // Verificar si es una zona BlueX por nombre
            if (stripos($zone_name, 'blue') === false && stripos($zone_name, 'bluex') === false) {
                continue;
            }
            
            // Verificar si la zona contiene la ubicación
            $locations = $zone->get_zone_locations();
            foreach ($locations as $location) {
                if ($location->type === $location_type && $location->code === $location_code) {
                    return [
                        'zone_id' => $zone->get_id(),
                        'zone_name' => $zone_name,
                        'methods' => $zone->get_shipping_methods()
                    ];
                }
            }
        }
        
        return null;
    }

    /**
     * Agregar o actualizar métodos en zona existente
     * 
     * @param int $zone_id ID de la zona
     * @param array $methods Métodos a agregar
     * @param string $mode Modo de operación
     * @return int Cantidad de métodos agregados
     */
    private function update_methods_in_zone($zone_id, $methods, $mode = 'add_to_existing', $fee = '') {
        $zone = WC_Shipping_Zones::get_zone($zone_id);
        $existing_methods = $zone->get_shipping_methods();
        $methods_added = 0;
        
        // Si es replace_existing, deshabilitar métodos BlueX existentes
        if ($mode === 'replace_existing') {
            foreach ($existing_methods as $instance_id => $method) {
                if (strpos($method->id, 'bluex') === 0) {
                    $zone->delete_shipping_method($instance_id);
                }
            }
            // Recargar métodos después de borrar
            $zone->save();
            $existing_methods = $zone->get_shipping_methods();
        }
        
        // Agregar métodos solicitados
        foreach ($methods as $method_id) {
            $method_exists = false;
            $instance_id = 0;
            
            // Verificar si el método ya existe
            foreach ($existing_methods as $existing_method) {
                if ($existing_method->id === $method_id) {
                    $method_exists = true;
                    $instance_id = $existing_method->instance_id;
                    break;
                }
            }
            
            if (!$method_exists) {
                $instance_id = $zone->add_shipping_method($method_id);
                $methods_added++;
            }

            // Actualizar fee si se proporcionó y tenemos un instance_id válido
            if ($instance_id && $fee !== null) {
                $this->update_method_fee($instance_id, $method_id, $fee);
            }
        }
        
        $zone->save();
        return $methods_added;
    }

    /**
     * Obtener comunas principales por región
     */
    private function get_main_communes() {
        return [
            'CL-RM' => [
                'Santiago', 'Providencia', 'Las Condes', 'Vitacura', 'Ñuñoa',
                'La Florida', 'Maipú', 'Puente Alto', 'San Bernardo'
            ],
            'CL-VS' => [
                'Valparaíso', 'Viña del Mar', 'Quilpué', 'Villa Alemana'
            ],
            'CL-BI' => [
                'Concepción', 'Talcahuano', 'Chillán', 'Los Ángeles'
            ]
        ];
    }

    /**
     * Crear backup de zonas existentes
     *
     * @return array Información del backup creado
     */
    public function create_backup() {
        $zones_data = WC_Shipping_Zones::get_zones();
        $backup_data = [];

        foreach ($zones_data as $zone_data) {
            if (!isset($zone_data['id'])) {
                continue;
            }

            $zone = new WC_Shipping_Zone((int) $zone_data['id']);

            $backup_data[] = [
                'zone_id' => $zone->get_id(),
                'zone_name' => $zone->get_zone_name(),
                'zone_order' => $zone->get_zone_order(),
                'locations' => $zone->get_zone_locations(),
                'methods' => $zone->get_shipping_methods(),
            ];
        }

        // Incluir la zona "rest of the world" (ID 0) si tiene métodos configurados.
        $rest_of_world = new WC_Shipping_Zone(0);
        $rest_methods = $rest_of_world->get_shipping_methods();

        if (!empty($rest_methods)) {
            $backup_data[] = [
                'zone_id' => 0,
                'zone_name' => $rest_of_world->get_zone_name(),
                'zone_order' => $rest_of_world->get_zone_order(),
                'locations' => $rest_of_world->get_zone_locations(),
                'methods' => $rest_methods,
            ];
        }

        $backup_file = WP_CONTENT_DIR . '/bluex-zones-backup-' . date('Y-m-d-H-i-s') . '.json';
        file_put_contents($backup_file, wp_json_encode($backup_data));

        $backup_info = [
            'backup_file' => $backup_file,
            'zones_backed_up' => count($backup_data),
            'timestamp' => current_time('mysql')
        ];

        $this->log_operation('backup_created', $backup_info);

        return $backup_info;
    }

    /**
     * Log de operaciones
     */
    private function log_operation($operation, $data) {
        $log_entry = [
            'timestamp' => current_time('mysql'),
            'operation' => $operation,
            'data' => $data,
            'user_id' => get_current_user_id()
        ];

        // Usar el sistema de logging existente de Blue Express
        bluex_log('info', 'Shipping Zone Automation: ' . wp_json_encode($log_entry));
    }

    /**
     * Obtener regiones chilenas disponibles
     *
     * @return array Array de regiones con código => nombre
     */
    public function get_chilean_regions() {
        return $this->chilean_regions;
    }

    /**
     * Obtener estrategias disponibles
     */
    public function get_available_strategies() {
        return $this->available_strategies;
    }

    /**
     * Obtener estadísticas de zonas actuales
     */
    /**
     * Crear zona de exclusión para áreas sin cobertura BlueX
     * 
     * @param string $region_code Código de región
     * @param array $options Opciones de configuración
     * @return array|null Información de la zona de exclusión creada o null
     */
    private function create_exclusion_zone($region_code, $options) {
        if (!function_exists('bluex_region_has_exclusions')) {
            return null;
        }
        
        if (!bluex_region_has_exclusions($region_code)) {
            return null;
        }
        
        $zone_name = bluex_get_exclusion_zone_name($region_code);
        $excluded_postcodes = bluex_get_excluded_postcodes($region_code);
        
        if (empty($excluded_postcodes)) {
            return null;
        }
        
        // Verificar si ya existe una zona de exclusión
        $existing_zone = $this->find_zone_by_name($zone_name);
        
        if ($existing_zone) {
            return [
                'zone_id' => $existing_zone['zone_id'],
                'zone_name' => $existing_zone['zone_name'],
                'action' => 'existing',
                'postcodes_count' => count($excluded_postcodes)
            ];
        }
        
        if ($options['dry_run']) {
            return [
                'zone_name' => $zone_name,
                'action' => 'simulated',
                'postcodes_count' => count($excluded_postcodes)
            ];
        }
        
        // Crear zona de exclusión con mayor prioridad (menor zone_order)
        $zone = new WC_Shipping_Zone();
        $zone->set_zone_name($zone_name);
        $zone->set_zone_order(0); // Mayor prioridad
        $zone_id = $zone->save();
        
        // Agregar códigos postales excluidos
        foreach ($excluded_postcodes as $postcode) {
            $zone->add_location($postcode, 'postcode');
        }
        
        $zone->save();
        
        // NO agregar métodos BlueX a esta zona - es para excluir
        
        return [
            'zone_id' => $zone_id,
            'zone_name' => $zone_name,
            'action' => 'created',
            'postcodes_count' => count($excluded_postcodes)
        ];
    }

    /**
     * Actualizar el fee (IVA) de un método de envío
     * 
     * IMPORTANTE: WooCommerce guarda los settings de instancias de métodos de envío
     * con el formato: woocommerce_{method_id}_{instance_id}_settings
     * 
     * El método get_option_key() de WC_Settings_API retorna el key global (sin instance_id),
     * por lo que debemos construir el key correcto manualmente.
     * 
     * @param int $instance_id ID de la instancia del método de envío
     * @param string $method_id ID del método de envío (ej: bluex-ex)
     * @param string $fee Valor del fee a establecer
     */
    private function update_method_fee($instance_id, $method_id, $fee) {
        // Construir el option_key correcto para instance settings
        // Formato: woocommerce_{method_id}_{instance_id}_settings
        $option_key = 'woocommerce_' . $method_id . '_' . $instance_id . '_settings';
        
        // Leer settings actuales de la instancia
        $current_settings = get_option($option_key, []);
        if (!is_array($current_settings)) {
            $current_settings = [];
        }
        
        $current_settings['fee'] = $fee;
        
        update_option($option_key, $current_settings);
    }

    public function get_zones_status() {
        $zones_data = WC_Shipping_Zones::get_zones();
        $stats = [
            'total_zones' => count($zones_data),
            'zones_with_bluex' => 0,
            'zones_without_vat' => 0,
            'bluex_methods_count' => []
        ];

        foreach ($zones_data as $zone_data) {
            if (!isset($zone_data['id'])) {
                continue;
            }

            $zone = new WC_Shipping_Zone((int) $zone_data['id']);
            $methods = $zone->get_shipping_methods();
            $has_bluex = false;
            $bluex_without_vat = false;

            foreach ($methods as $method) {
                if (strpos($method->id, 'bluex') === 0) {
                    $has_bluex = true;
                    $method_id = $method->id;

                    // Check for fee
                    $fee_configured = !empty($method->fee);
                    
                    // Double check directly from options if property is empty
                    if (!$fee_configured) {
                        $option_key = $method->get_option_key();
                        $settings = get_option($option_key);
                        if (!empty($settings['fee'])) {
                            $fee_configured = true;
                        }
                    }

                    if (!$fee_configured) {
                        $bluex_without_vat = true;
                    }

                    if (!isset($stats['bluex_methods_count'][$method_id])) {
                        $stats['bluex_methods_count'][$method_id] = 0;
                    }

                    $stats['bluex_methods_count'][$method_id]++;
                }
            }

            if ($has_bluex) {
                $stats['zones_with_bluex']++;
                if ($bluex_without_vat) {
                    $stats['zones_without_vat']++;
                }
            }
        }

        // Incluir la zona "rest of the world" (ID 0) en el conteo
        $rest_of_world_zone = new WC_Shipping_Zone(0);
        $rest_methods = $rest_of_world_zone->get_shipping_methods();

        if (!empty($rest_methods)) {
            $stats['total_zones']++;
            $has_bluex = false;
            $bluex_without_vat = false;

            foreach ($rest_methods as $method) {
                if (strpos($method->id, 'bluex') === 0) {
                    $has_bluex = true;
                    $method_id = $method->id;

                    // Check for fee
                    $fee_configured = !empty($method->fee);
                    
                    // Double check directly from options if property is empty
                    if (!$fee_configured) {
                        $option_key = $method->get_option_key();
                        $settings = get_option($option_key);
                        if (!empty($settings['fee'])) {
                            $fee_configured = true;
                        }
                    }

                    if (!$fee_configured) {
                        $bluex_without_vat = true;
                    }

                    if (!isset($stats['bluex_methods_count'][$method_id])) {
                        $stats['bluex_methods_count'][$method_id] = 0;
                    }

                    $stats['bluex_methods_count'][$method_id]++;
                }
            }

            if ($has_bluex) {
                $stats['zones_with_bluex']++;
                if ($bluex_without_vat) {
                    $stats['zones_without_vat']++;
                }
            }
        }

        return $stats;
    }
}

// Función helper para acceder a la instancia
function WC_BlueX_Shipping_Zone_Automation() {
    return WC_BlueX_Shipping_Zone_Automation::get_instance();
}