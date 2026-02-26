<?php

declare(strict_types=1);

/**
 * Update Credentials Endpoint
 *
 * @package WooCommerce_Correios/API/Endpoints
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * WC_Correios_Update_Credentials_Endpoint Class
 */
class WC_Correios_Update_Credentials_Endpoint
{
    /**
     * Update integration credentials endpoint using API Client.
     *
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response
     */
    public function update_credentials(WP_REST_Request $request): WP_REST_Response
    {
        try {
            // Settings instance only needed for logging exceptions
            // $settings = WC_Correios_Settings::get_instance(); 
            $api_client = new BlueX_API_Client();

            $store_id = $request->get_param('storeId');
            $credentials = $request->get_param('credentials'); // Expecting an array with clientKey and clientSecret

            // Validate input parameters
            if (empty($store_id) || !is_string($store_id) || empty($credentials) || !is_array($credentials) || !isset($credentials['clientKey']) || !isset($credentials['clientSecret'])) {
                bluex_log('error', 'Invalid parameters for update_credentials endpoint. StoreID: ' . print_r($store_id, true) . ' Credentials: ' . print_r($credentials, true));
                return new WP_REST_Response([
                    'success' => false,
                    'message' => __('Parámetros inválidos o faltantes (storeId, credentials with clientKey/clientSecret).', 'woocommerce-correios')
                ], 400);
            }

            // Call the API client method
            $response = $api_client->update_integration_credentials($store_id, $credentials);

            if (is_wp_error($response)) {
                // Error already logged by API Client
                $error_message = $response->get_error_message();
                $status_code = $response->get_error_data()['status'] ?? 500;
                return new WP_REST_Response(['error' => true, 'message' => $error_message], $status_code);
            }

            // Process successful response (already logged by client)
            if (!($response['activeIntegration'] ?? false)) {
                bluex_log('error', 'Credentials update successful, but integration inactive: ' . ($response['message'] ?? 'N/A'));
                // Return success but indicate inactive integration
                return new WP_REST_Response([
                    'activeIntegration' => false,
                    'errorCode' => '01', // Consistent error code
                    'message' => $response['message'] ?? 'Credenciales actualizadas, pero la integración está inactiva.',
                ], 200);
            }

            // Return the full successful response data
            return new WP_REST_Response($response, 200);
        } catch (Exception $e) {
            bluex_log('error', 'Exception updating credentials endpoint: ' . $e->getMessage());
            return new WP_REST_Response([
                'success' => false, // Consistent naming?
                'message' => __('Error interno al actualizar las credenciales.', 'woocommerce-correios')
            ], 500);
        }
    }
}
