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
class WC_Correios_Get_Settings_Endpoint
{
    /**
     * Get integration settings endpoint
     *
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response
     */
    public function get_settings($request)
    {
        try {
            $settings = WC_Correios_Settings::get_instance();

            $settings_data = $settings->get_settings();
            $options_emission_os_raw = wc_get_order_statuses();
            $options_emission_os = array_map(function ($key, $label) {
                return ['value' => $key, 'label' => $label];
            }, array_keys($options_emission_os_raw), array_values($options_emission_os_raw));
            $account_name = $settings->get_account_name();
            $base_path = $settings->get_base_path();

            return new WP_REST_Response(array(
                'settings' => $settings_data,
                'optionsEmissionOs' => $options_emission_os,
                'account_name' => $account_name,
                'getBasePath' => $base_path,
                'debug' => (defined('BLUEX_DEBUG') && BLUEX_DEBUG),
                'plugin_version' => WC_CORREIOS_VERSION
            ), 200);
        } catch (Exception $e) {
            bluex_log('error', 'Error retrieving settings: ' . $e->getMessage());
            return new WP_REST_Response(array(
                'success' => false,
                'message' => __('Error al obtener la configuración.', 'woocommerce-correios')
            ), 500);
        }
    }
}
