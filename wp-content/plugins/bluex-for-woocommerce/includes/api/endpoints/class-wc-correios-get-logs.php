<?php

/**
 * Get Settings Endpoint
 *
 * @package WooCommerce_Correios/API/Endpoints
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * WC_Correios_Get_Settings_Endpoint Class
 */
class WC_Correios_Get_Logs_Endpoint
{
    /**
     * Get integration settings endpoint
     *
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response
     */
    public static function get_logs($request)
    {
        try {
            global $wpdb;
            $table_name = $wpdb->prefix . 'bluex_logs';

            // Verificar si la tabla existe
            $table_exists = $wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") === $table_name;

            // Si no existe, crearla
            if (!$table_exists) {
                if (method_exists('WC_Correios', 'bluex_create_logs_table')) {
                    WC_Correios::bluex_create_logs_table();
                    bluex_log('info', 'Tabla de logs creada porque no existía');
                } else {
                    // Crear la tabla manualmente si el método no está disponible
                    $charset_collate = $wpdb->get_charset_collate();
                    $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
                        id bigint(20) NOT NULL AUTO_INCREMENT,
                        log_timestamp datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        log_type varchar(20) NOT NULL,
                        log_body text NOT NULL,
                        PRIMARY KEY  (id),
                        KEY log_timestamp (log_timestamp)
                    ) $charset_collate;";

                    if (defined('ABSPATH')) {
                        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                        if (function_exists('dbDelta')) {
                            dbDelta($sql);
                            bluex_log('info', 'Tabla de logs creada manualmente porque no existía');
                        } else {
                            // Si dbDelta no está disponible, ejecutar la consulta directamente
                            $wpdb->query($sql);
                            bluex_log('info', 'Tabla de logs creada con query directa porque no existía');
                        }
                    } else {
                        // Si ABSPATH no está definido, ejecutar la consulta directamente
                        $wpdb->query($sql);
                        bluex_log('info', 'Tabla de logs creada con query directa porque no existía ABSPATH');
                    }
                }
            }

            // Build query
            $where = array('1=1');
            $values = array();

            if (!empty($request['type'])) {
                $where[] = 'log_type = %s';
                $values[] = $request['type'];
            }

            if (!empty($request['start_date'])) {
                $where[] = 'log_timestamp >= %s';
                $values[] = $request['start_date'];
            }

            if (!empty($request['end_date'])) {
                $where[] = 'log_timestamp <= %s';
                $values[] = $request['end_date'];
            }

            $where_clause = implode(' AND ', $where);

            // Get total count
            $count_query = "SELECT COUNT(*) FROM {$table_name} WHERE {$where_clause}";
            $total_items = (int) $wpdb->get_var($wpdb->prepare($count_query, $values));

            // Get paginated results
            $page = !empty($request['page']) ? (int) $request['page'] : 1;
            $per_page = !empty($request['per_page']) ? (int) $request['per_page'] : 10;
            $offset = ($page - 1) * $per_page;

            $query = "SELECT * FROM {$table_name} WHERE {$where_clause} ORDER BY log_timestamp DESC LIMIT %d OFFSET %d";
            $prepared_values = array_merge($values, array($per_page, $offset));

            $results = $wpdb->get_results($wpdb->prepare($query, $prepared_values));

            return new WP_REST_Response(array(
                'total_items' => $total_items,
                'total_pages' => ceil($total_items / $per_page),
                'current_page' => $page,
                'per_page' => $per_page,
                'items' => $results
            ), 200);
        } catch (Exception $e) {
            bluex_log('error', 'Error retrieving logs: ' . $e->getMessage());
            return new WP_REST_Response(array(
                'success' => false,
                'message' => __('Error al obtener los registros.', 'woocommerce-correios')
            ), 500);
        }
    }
}
