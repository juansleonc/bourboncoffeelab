<?php

/**
 * Empty Autofill Database Endpoint
 *
 * @package WooCommerce_Correios/API/Endpoints
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * WC_Correios_Empty_Autofill_DB_Endpoint Class
 */
class WC_Correios_Empty_Autofill_DB_Endpoint {
    /**
     * Empty autofill database endpoint
     *
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response
     */
    public function empty_autofill_database($request) {
        try {
            global $wpdb;

            $table_name = $wpdb->prefix . WC_Correios_AutofillAddresses::$table;
            $wpdb->query("DROP TABLE IF EXISTS $table_name;"); // @codingStandardsIgnoreLine

            WC_Correios_AutofillAddresses::create_database();

            return new WP_REST_Response(array(
                'success' => true,
                'message' => __('Base de datos de códigos postales vaciada exitosamente!', 'woocommerce-correios')
            ), 200);
        } catch (Exception $e) {
            bluex_log('error', 'Error emptying autofill database: ' . $e->getMessage());
            return new WP_REST_Response(array(
                'success' => false,
                'message' => __('Error al vaciar la base de datos de códigos postales.', 'woocommerce-correios')
            ), 500);
        }
    }
} 