<?php

declare(strict_types=1);

/**
 * Test Integration Endpoint
 *
 * @package WooCommerce_Correios/API/Endpoints
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * WC_Correios_Test_Integration_Endpoint Class
 */
class WC_Correios_Test_Integration_Endpoint
{
    /**
     * Test integration endpoint using API Client.
     *
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response
     */
    public function test_integration(WP_REST_Request $request): WP_REST_Response
    {
        try {
            $settings = WC_Correios_Settings::get_instance();
            $api_client = new BlueX_API_Client(); // Instantiate the client

            // Prepare test data
            $from = [
                'country'  => 'CL',
                'district' => $settings->get_setting('districtCode'),
            ];
            $to = [
                'country'  => 'CL',
                'state'    => '13', // Example state (Metropolitana)
                'district' => 'PRO', // Example district (Providencia?)
            ];
            $bultos = [
                [
                    'largo'       => 10,
                    'ancho'       => 10,
                    'alto'        => 10,
                    'sku'         => 'TEST01',
                    'pesoFisico'  => 1,
                    'cantidad'    => 1,
                ]
            ];
            $service_type = 'EX'; // Example service type
            $familia_producto = 'PAQU';
            $declared_value = 10000.0; // Example declared value

            // Make API call using the client
            $response = $api_client->get_pricing($from, $to, $service_type, $bultos, $declared_value, $familia_producto);

            // Handle the response
            if (is_wp_error($response)) {
                // Error already logged by API Client
                $settings->update_setting('test_pricing_query', false);
                $error_message = $response->get_error_message();
                $status_code = $response->get_error_data()['status'] ?? 500;
                return new WP_REST_Response(['success' => false, 'message' => $error_message], $status_code);
            } else {
                // Success means API call was technically successful (2xx status, valid JSON)
                // We assume this endpoint considers any successful call as a successful test.
                $settings->update_setting('test_pricing_query', true);
                return new WP_REST_Response(['success' => true, 'message' => 'Integración exitosa.'], 200);
                // Optionally, you could add checks here for specific codes in the $response array
                // if $response['code'] !== '00' && $response['code'] !== '01', treat as failure?
            }
        } catch (Exception $e) {
            bluex_log('error', 'Exception testing integration endpoint: ' . $e->getMessage());
            $settings->update_setting('test_pricing_query', false); // Ensure flag is set to false on exception
            return new WP_REST_Response([
                'success' => false,
                'message' => __('Error interno al probar la integración.', 'woocommerce-correios')
            ], 500);
        }
    }
}
