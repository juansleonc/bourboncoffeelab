<?php

/**
 * Delete Logs Endpoint
 *
 * @package WooCommerce_Correios/API/Endpoints
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * WC_Correios_Delete_Logs_Endpoint Class
 */
class WC_Correios_Delete_Logs_Endpoint
{
    /**
     * Delete logs endpoint
     *
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response
     */
    public static function delete_logs($request)
    {
        try {
            global $wpdb;
            $table_name = $wpdb->prefix . 'bluex_logs';

            // Verificar si la tabla existe
            $table_exists = $wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") === $table_name;

            if (!$table_exists) {
                return new WP_REST_Response(array(
                    'success' => false,
                    'message' => __('La tabla de logs no existe.', 'woocommerce-correios')
                ), 404);
            }

            // Truncate table
            $result = $wpdb->query("TRUNCATE TABLE {$table_name}");

            if ($result === false) {
                throw new Exception($wpdb->last_error);
            }

            bluex_log('info', 'Logs eliminados manualmente por el usuario.');

            return new WP_REST_Response(array(
                'success' => true,
                'message' => __('Logs eliminados correctamente.', 'woocommerce-correios')
            ), 200);
        } catch (Exception $e) {
            bluex_log('error', 'Error deleting logs: ' . $e->getMessage());
            return new WP_REST_Response(array(
                'success' => false,
                'message' => __('Error al eliminar los registros.', 'woocommerce-correios')
            ), 500);
        }
    }
}