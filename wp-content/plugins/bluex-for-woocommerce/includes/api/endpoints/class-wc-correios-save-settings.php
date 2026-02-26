<?php

/**
 * Save Settings Endpoint
 *
 * @package WooCommerce_Correios/API/Endpoints
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * WC_Correios_Save_Settings_Endpoint Class
 */
class WC_Correios_Save_Settings_Endpoint
{
    /**
     * Save integration settings endpoint
     *
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response
     */
    public function save_settings($request)
    {
        try {
            $settings = WC_Correios_Settings::get_instance();

            $settings_data = $settings->get_settings();

            // Procesa y guarda cada opción individualmente
            $settings_data['noBlueStatus'] = $request->get_param('noBlueStatus');
            $settings_data['districtCode'] = $request->get_param('districtCode');
            $settings_data['pudoEnable'] = $request->get_param('pudoEnable');
            $settings_data['districtsEnable'] = $request->get_param('districtsEnable');
            $settings_data['active_logs'] = $request->get_param('active_logs');

            $settings->update_settings($settings_data);

            // Test integration after saving settings
            $test_result = $this->test_correios_integration();

            return new WP_REST_Response(array(
                'success' => true,
                'message' => __('Configuración guardada exitosamente.', 'woocommerce-correios'),
                'test_result' => $test_result
            ), 200);
        } catch (Exception $e) {
            bluex_log('error', 'Error saving settings: ' . $e->getMessage());
            return new WP_REST_Response(array(
                'success' => false,
                'message' => __('Error al guardar la configuración.', 'woocommerce-correios')
            ), 500);
        }
    }
}
