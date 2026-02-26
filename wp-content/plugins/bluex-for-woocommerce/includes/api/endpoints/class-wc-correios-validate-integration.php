<?php

declare(strict_types=1);

/**
 * Validate Integration Endpoint
 *
 * @package WooCommerce_Correios/API/Endpoints
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * WC_Correios_Validate_Integration_Endpoint Class
 */
class WC_Correios_Validate_Integration_Endpoint
{
    /**
     * Validate integration status endpoint using API Client.
     *
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response
     */
    public function validate_integration(WP_REST_Request $request): WP_REST_Response
    {
        try {
            // Settings instance is needed only for logging exceptions, API client handles settings now.
            $settings = WC_Correios_Settings::get_instance();
            $api_client = new BlueX_API_Client();

            $response = $api_client->validate_integration_status();

            if (is_wp_error($response)) {
                // Error already logged by API Client
                $error_message = $response->get_error_message();
                $status_code = $response->get_error_data()['status'] ?? 500;
                // Return a generic error for security, or the specific one?
                // Let's return the specific error message but with a controlled status code.
                return new WP_REST_Response(['error' => true, 'message' => $error_message], $status_code);
            }

            // Process successful response (already logged by client)
            // Check for specific conditions based on the original logic
            if (!isset($response['storeId'])) {
                bluex_log('error', 'Store ID not found in validate_integration response: ' . ($response['message'] ?? 'N/A'));
                return new WP_REST_Response([
                    'activeIntegration' => false,
                    'errorCode' => '00',
                    'message' => $response['message'] ?? 'Store ID no encontrado en la respuesta.',
                ], 200); // Still 200 OK as the API call succeeded, but logical error
            } elseif (!($response['activeIntegration'] ?? false)) {
                bluex_log('error', 'Integration not active in validate_integration: ' . ($response['message'] ?? 'N/A'));
                return new WP_REST_Response([
                    'activeIntegration' => false,
                    'errorCode' => '01',
                    'message' => $response['message'] ?? 'La integración no está activa.',
                    'storeId' => $response['storeId'],
                ], 200); // Still 200 OK
            }

            // Log successful validation explicitly here if needed (client logs the raw response)
            bluex_log('info', 'Integration validated successfully via endpoint: ' . json_encode($response));

            // Return the full successful response data
            return new WP_REST_Response($response, 200);
        } catch (Exception $e) {
            // Log exception using the settings instance or directly
            bluex_log('error', 'Exception validating integration endpoint: ' . $e->getMessage());
            return new WP_REST_Response([
                'success' => false, // Keep consistent naming? 'error' => true ?
                'message' => __('Error interno al validar la integración.', 'woocommerce-correios')
            ], 500);
        }
    }
}
