<?php

/**
 * Blue Express API REST endpoints
 *
 * @package WooCommerce_Correios/API
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * WC_Correios_API Class
 */
class WC_Correios_API {
    /**
     * Initialize the API endpoints
     */
    public function __construct() {
        // Include endpoint files
        $this->include_endpoints();
        
        $this->register_routes();
    }

    public static function init() {
        new WC_Correios_API();
    }

    /**
     * Include endpoint files
     */
    private function include_endpoints() {
        require_once WC_Correios::get_plugin_path() . 'includes/api/endpoints/class-wc-correios-test-integration.php';
        require_once WC_Correios::get_plugin_path() . 'includes/api/endpoints/class-wc-correios-validate-integration.php';
        require_once WC_Correios::get_plugin_path() . 'includes/api/endpoints/class-wc-correios-update-credentials.php';
        require_once WC_Correios::get_plugin_path() . 'includes/api/endpoints/class-wc-correios-save-settings.php';
        require_once WC_Correios::get_plugin_path() . 'includes/api/endpoints/class-wc-correios-get-settings.php';
        require_once WC_Correios::get_plugin_path() . 'includes/api/endpoints/class-wc-correios-save-dev-settings.php';
        require_once WC_Correios::get_plugin_path() . 'includes/api/endpoints/class-wc-correios-empty-autofill-db.php';
        require_once WC_Correios::get_plugin_path() . 'includes/api/endpoints/class-wc-correios-get-logs.php';
        require_once WC_Correios::get_plugin_path() . 'includes/api/endpoints/class-wc-correios-delete-logs.php';
        require_once WC_Correios::get_plugin_path() . 'includes/api/endpoints/class-wc-bluex-shipping-zones-automation.php';
    }

    /**
     * Register REST API routes
     */
    public function register_routes() {
        // Test integration
        register_rest_route('wc-bluex/v1', '/test-integration', array(
            'methods' => 'POST',
            'callback' => array(new WC_Correios_Test_Integration_Endpoint(), 'test_integration'),
            'permission_callback' => array($this, 'check_permission'),
        ));

        // Validate integration status
        register_rest_route('wc-bluex/v1', '/validate-integration', array(
            'methods' => 'GET',
            'callback' => array(new WC_Correios_Validate_Integration_Endpoint(), 'validate_integration'),
            'permission_callback' => '__return_true',
        ));

        // Update integration credentials
        register_rest_route('wc-bluex/v1', '/update-credentials', array(
            'methods' => 'POST',
            'callback' => array(new WC_Correios_Update_Credentials_Endpoint(), 'update_credentials'),
            'permission_callback' => '__return_true',
        ));

        // Save integration settings
        register_rest_route('wc-bluex/v1', '/save-settings', array(
            'methods' => 'POST',
            'callback' => array(new WC_Correios_Save_Settings_Endpoint(), 'save_settings'),
            'permission_callback' => array($this, 'check_permission'),
        ));

        // Get integration settings
        register_rest_route('wc-bluex/v1', '/get-settings', array(
            'methods' => 'GET',
            'callback' => array(new WC_Correios_Get_Settings_Endpoint(), 'get_settings'),
            'permission_callback' => array($this, 'check_permission'),
        ));

        // Save developer settings
        register_rest_route('wc-bluex/v1', '/save-dev-settings', array(
            'methods' => 'POST',
            'callback' => array(new WC_Correios_Save_Dev_Settings_Endpoint(), 'save_dev_settings'),
            'permission_callback' => array($this, 'check_permission'),
        ));

        // Empty autofill database
        register_rest_route('wc-bluex/v1', '/empty-autofill-db', array(
            'methods' => 'POST',
            'callback' => array(new WC_Correios_Empty_Autofill_DB_Endpoint(), 'empty_autofill_database'),
            'permission_callback' => array($this, 'check_permission'),
        ));

        // Get logs
        register_rest_route('wc-bluex/v1', '/get-logs', array(
            'methods' => 'GET',
            'callback' => array(new WC_Correios_Get_Logs_Endpoint(), 'get_logs'),
            'permission_callback' => array($this, 'check_permission'),
            'args' => array(
    'page' => array(
     'default' => 1,
     'sanitize_callback' => 'absint'
    ),
    'per_page' => array(
     'default' => 10,
     'sanitize_callback' => 'absint'
    ),
    'type' => array(
     'default' => '',
     'sanitize_callback' => 'sanitize_text_field'
    ),
    'start_date' => array(
     'default' => '',
     'sanitize_callback' => 'sanitize_text_field'
    ),
    'end_date' => array(
     'default' => '',
     'sanitize_callback' => 'sanitize_text_field'
    )
   )
        ));

        // Delete logs
        register_rest_route('wc-bluex/v1', '/delete-logs', array(
            'methods' => 'DELETE',
            'callback' => array(new WC_Correios_Delete_Logs_Endpoint(), 'delete_logs'),
            'permission_callback' => array($this, 'check_permission'),
        ));

        // Shipping zones automation endpoints
        $automation_endpoint = new WC_BlueX_Shipping_Zones_Automation_Endpoint();
        $automation_endpoint->register_routes();
    }

    /**
     * Check if user has permission to access the API
     *
     * @return bool
     */
    public function check_permission() {
        // return current_user_can('manage_woocommerce');
        return true;
    }
} 