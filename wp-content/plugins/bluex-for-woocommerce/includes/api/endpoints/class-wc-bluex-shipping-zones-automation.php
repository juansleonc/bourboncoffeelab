<?php
/**
 * BlueX Shipping Zones Automation API Endpoint
 *
 * @package WooCommerce_BlueX/API
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * API Endpoint para automatización de zonas de envío
 */
class WC_BlueX_Shipping_Zones_Automation_Endpoint extends WC_REST_Controller {

    /**
     * Ruta base del endpoint
     */
    protected $rest_base = 'shipping-zones-automation';

    /**
     * Namespace del endpoint
     */
    protected $namespace = 'wc-bluex/v1';

    /**
     * Registrar las rutas
     */
    public function register_routes() {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/create',
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'create_zones'],
                'permission_callback' => [$this, 'get_permissions_check'],
                'args' => $this->get_create_zones_args()
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/status',
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_status'],
                'permission_callback' => [$this, 'get_permissions_check']
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/backup',
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'create_backup'],
                'permission_callback' => [$this, 'get_permissions_check']
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/communes',
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_available_communes'],
                'permission_callback' => [$this, 'get_permissions_check'],
                'args' => $this->get_communes_args(),
            ]
        );
    }

    /**
     * Crear zonas de envío automáticamente
     *
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response
     */
    public function create_zones($request) {
        try {
            // Log received parameters for debugging
            if (function_exists('bluex_log')) {
                bluex_log('info', 'API create_zones received params: ' . wp_json_encode($request->get_params()));
            }

            $automation = WC_BlueX_Shipping_Zone_Automation();
            // Forzar saneo de "methods" y normalizar booleanos provenientes del frontend
            $options = [
                'strategy' => $request->get_param('strategy'),
                'methods' => $this->sanitize_methods_param($request->get_param('methods'), $request, 'methods'),
                'regions' => $request->get_param('regions'),
                'communes' => $request->get_param('communes'),
                'mode' => $request->get_param('mode'),
                'include_pudos' => function_exists('wc_string_to_bool') ? wc_string_to_bool((string) $request->get_param('include_pudos')) : (bool) $request->get_param('include_pudos'),
                'dry_run' => function_exists('wc_string_to_bool') ? wc_string_to_bool((string) $request->get_param('dry_run')) : (bool) $request->get_param('dry_run'),
                'backup_existing' => function_exists('wc_string_to_bool') ? wc_string_to_bool((string) $request->get_param('backup_existing')) : (bool) $request->get_param('backup_existing'),
                'exclude_islands' => function_exists('wc_string_to_bool') ? wc_string_to_bool((string) $request->get_param('exclude_islands')) : (bool) $request->get_param('exclude_islands'),
                'fee' => $request->get_param('vat'), // Mapear 'vat' del frontend a 'fee' (puede ser null, string vacío o valor)
            ];

            $result = $automation->create_zones($options);

            if ($result['success']) {
                return new WP_REST_Response($result, 200);
            } else {
                return new WP_Error('automation_failed', $result['error'], ['status' => 400]);
            }
        } catch (Exception $e) {
            return new WP_Error('server_error', $e->getMessage(), ['status' => 500]);
        }
    }

    /**
     * Obtener estado actual de zonas
     *
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response
     */
    public function get_status($request) {
        try {
            $automation = WC_BlueX_Shipping_Zone_Automation();
            $status = $automation->get_zones_status();

            // Agregar información adicional usando el nuevo getter público
            $status['chilean_regions'] = $automation->get_chilean_regions();
            $status['available_strategies'] = $automation->get_available_strategies();
            $status['available_methods'] = ['bluex-ex', 'bluex-py', 'bluex-md'];

            return new WP_REST_Response($status, 200);

        } catch (Exception $e) {
            return new WP_Error('server_error', $e->getMessage(), ['status' => 500]);
        }
    }

    /**
     * Crear backup de zonas existentes
     *
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response
     */
    public function create_backup($request) {
        try {
            $automation = WC_BlueX_Shipping_Zone_Automation();
            $backup_info = $automation->create_backup();

            return new WP_REST_Response([
                'success' => true,
                'message' => 'Backup creado exitosamente',
                'backup_info' => $backup_info
            ], 200);

        } catch (Exception $e) {
            return new WP_Error('backup_failed', $e->getMessage(), ['status' => 500]);
        }
    }

    /**
     * Verificar permisos
     *
     * @return bool
     */
    public function get_permissions_check($request = null) {
        return current_user_can('manage_woocommerce');
    }

    /**
     * Definir argumentos para crear zonas
     */
    private function get_create_zones_args() {
        return [
            'strategy' => [
                'required' => true,
                'type' => 'string',
                'enum' => ['national', 'by_region', 'by_commune', 'hybrid'],
                'description' => 'Estrategia de creación de zonas'
            ],
            'methods' => [
                'required' => false,
                'type' => 'array',
                'items' => [
                    'type' => 'string',
                    'enum' => ['bluex-ex', 'bluex-py', 'bluex-md'],
                ],
                'default' => ['bluex-ex', 'bluex-py', 'bluex-md'],
                'sanitize_callback' => [$this, 'sanitize_methods_param'],
                'validate_callback' => [$this, 'validate_methods_param'],
                'description' => 'Métodos de envío a incluir'
            ],
            'regions' => [
                'required' => false,
                'type' => 'array',
                'description' => 'Regiones específicas a incluir (códigos como CL-RM, CL-VS). Si se omite, se usan todas las regiones según la estrategia.'
            ],
            'communes' => [
                'required' => false,
                'type' => 'array',
                'description' => 'Comunas específicas a incluir. Usadas solo con strategy=by_commune.'
            ],
            'mode' => [
                'required' => false,
                'type' => 'string',
                'enum' => ['create_new', 'add_to_existing', 'replace_existing'],
                'default' => 'create_new',
                'description' => 'Modo de operación: create_new (crear nuevas zonas), add_to_existing (agregar a zonas existentes), replace_existing (editar zonas existentes)'
            ],
            'include_pudos' => [
                'required' => false,
                'type' => 'boolean',
                'default' => true,
                'description' => 'Incluir puntos de recogida'
            ],
            'dry_run' => [
                'required' => false,
                'type' => 'boolean',
                'default' => false,
                'description' => 'Solo simular sin crear zonas'
            ],
            'backup_existing' => [
                'required' => false,
                'type' => 'boolean',
                'default' => true,
                'description' => 'Crear backup antes de modificar'
            ],
            'exclude_islands' => [
                'required' => false,
                'type' => 'boolean',
                'default' => false,
                'description' => 'Excluir islas de Valparaíso (Isla de Pascua, Juan Fernández) creando zona de exclusión'
            ],
            'vat' => [
                'required' => false,
                'type' => 'string',
                'description' => 'Valor del IVA (Handling Fee) a aplicar a los métodos de envío'
            ]
        ];
    }
    public function get_communes_args() {
        return [
            'region' => [
                'description' => 'Region code to filter communes',
                'type' => 'string',
                'validate_callback' => 'rest_validate_request_arg',
            ],
        ];
    }

    /**
     * Sanitiza la lista de métodos recibidos desde el frontend.
     * Acepta:
     * - Array de slugs válidos ['bluex-ex', 'bluex-py']
     * - Cadena separada por comas 'bluex-ex,bluex-py'
     * - Valores inválidos como ['on','on'] serán reemplazados por el default
     *
     * @param mixed            $value    Valor recibido.
     * @param WP_REST_Request  $request  Request.
     * @param string           $param    Nombre del parámetro.
     * @return array Lista de métodos saneada.
     */
    public function sanitize_methods_param( $value, $request, $param ) {
        $allowed = ['bluex-ex', 'bluex-py', 'bluex-md'];
        $default = ['bluex-ex'];

        // Si viene vacío o null, usar por defecto (solo Express).
        if ($value === null || $value === '' ) {
            return $default;
        }

        // Convertir string "a,b,c" a array.
        if (is_string($value)) {
            $value = array_filter(array_map('trim', explode(',', $value)));
        }

        // Si no es array a este punto, devolver por defecto.
        if (!is_array($value)) {
            return $default;
        }

        // Normalizar a strings válidos o mapear checkboxes "on" por índice.
        $normalized = [];
        $toggle_values = ['on', '1', 1, true, 'true'];

        foreach ($value as $index => $v) {
            // Ignorar booleanos puros
            if (is_bool($v)) {
                continue;
            }

            // Slug válido directo
            if (is_string($v)) {
                $slug = trim($v);
                if (in_array($slug, $allowed, true)) {
                    $normalized[] = $slug;
                    continue;
                }
            }

            // Checkbox sin value => "on" (o equivalentes): mapear por posición al listado permitido
            if (in_array($v, $toggle_values, true)) {
                if (isset($allowed[$index])) {
                    $normalized[] = $allowed[$index];
                }
            }
        }

        // Si después de normalizar no hay nada, caer en un fallback razonable:
        // - Si el cliente envió exactamente ["on"], asumir el primer método (bluex-ex).
        if (empty($normalized)) {
            if (count($value) === 1 && in_array($value[0], $toggle_values, true)) {
                return [$allowed[0]];
            }
            return $default;
        }

        // Quitar duplicados y regresar.
        return array_values(array_unique($normalized));
    }

    /**
     * Valida que la lista de métodos contenga slugs válidos.
     *
     * @param mixed            $value
     * @param WP_REST_Request  $request
     * @param string           $param
     * @return bool
     */
    public function validate_methods_param( $value, $request, $param ) {
        $sanitized = $this->sanitize_methods_param($value, $request, $param);
        return is_array($sanitized) && count($sanitized) > 0;
    }
    
    public function get_available_communes( $request ) {
        if (!function_exists('bluex_get_communes_by_region')) {
            include_once dirname(__FILE__) . '/../../data/chile-communes.php';
        }
    
        $region_code = $request->get_param('region');
    
        if ($region_code) {
            $communes = bluex_get_communes_by_region($region_code);
        } else {
            $communes = bluex_get_all_communes();
        }
    
        return rest_ensure_response([
            'success' => true,
            'communes' => $communes
        ]);
    }
}

// Método helper para obtener regiones chilenas
function get_chilean_regions() {
    $automation = WC_BlueX_Shipping_Zone_Automation();
    return $automation->get_chilean_regions();
}