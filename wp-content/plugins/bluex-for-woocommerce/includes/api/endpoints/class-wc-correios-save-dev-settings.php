<?php

/**
 * Save Developer Settings Endpoint
 *
 * @package WooCommerce_Correios/API/Endpoints
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * WC_Correios_Save_Dev_Settings_Endpoint Class
 */
class WC_Correios_Save_Dev_Settings_Endpoint {
    /**
     * Save developer settings endpoint
     *
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response
     */
    public function save_dev_settings($request) {
        try {
            $settings = WC_Correios_Settings::get_instance();
            
            $settings_data = $settings->get_settings();
            
            // Procesa y guarda las opciones de desarrollo
            $settings_data['devOptions'] = $request->get_param('devOptions');
            $settings_data['alternativeBasePath'] = $request->get_param('alternativeBasePath');
            $settings_data['tracking_bxkey'] = $request->get_param('tracking_bxkey');

            $settings->update_settings($settings_data);

            return new WP_REST_Response(array(
                'success' => true,
                'message' => __('Configuración de desarrollo guardada exitosamente.', 'woocommerce-correios')
            ), 200);
        } catch (Exception $e) {
            bluex_log('error', 'Error saving dev settings: ' . $e->getMessage());
            return new WP_REST_Response(array(
                'success' => false,
                'message' => __('Error al guardar la configuración de desarrollo.', 'woocommerce-correios')
            ), 500);
        }
    }
} 