<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * MonsterInsights PPC Tracking Provider base class.
 *
 * @access public
 * @since 9.7.0
 *
 * @package MonsterInsights_Ads_Tracking
 * @subpackage Ad_Providers
 * @author  David Paternina
 */
abstract class MonsterInsights_Ads_Tracking_Provider
{
	/**
	 * The server handler instance
	 * @var MonsterInsights_PPC_Server
	 */
	protected $server_handler;

	/**
	 * Provider constructor
	 */
	public function __construct()
	{
		$this->init();
	}

	/**
	 * Initialize Provider
	 *
	 * @since 9.7.0
	 * @return void
	 */
	protected function init()
	{
		if ( !$this->is_active() ) {
			return;
		}
		
		//  Add instance frontend hooks
		$this->add_frontend_hooks();
	}

	/**
	 * Check if the provider has an API token
	 * @return bool
	 */
	public function has_api_token()
	{
		return ! empty( $this->get_api_token() );
	}

	/**
	 * Check if the provider is tracking server-side
	 * @return bool
	 */
	public function is_tracking_server_side()
	{
		return $this->get_server_handler() instanceof MonsterInsights_PPC_Server && $this->has_api_token();
	}

	/**
	 * Get the server handler instance
	 *
	 * @return MonsterInsights_PPC_Server|null
	 * @since 9.7.0
	 */
	public function get_server_handler() {
		if ( ! $this->server_handler ) {
			$this->server_handler = $this->init_server_handler();
		}

		return $this->server_handler;
	}

	/**
	 * Use server handler instance to send a server-side event using the API, if any.
	 *
	 * @param string $event_name
	 * @param array $data
	 * @param MonsterInsights_PPC_Tracking_Ecommerce_Tracking $ecommerce_provider
	 *
	 * @return void
	 */
	public function send_server_event( $event_name, $data, $ecommerce_provider ) {
		// If the api token is not set, bail early.
		if ( !$this->has_api_token() ) {
			return;
		}

		$server_handler = $this->get_server_handler();

		if ( $server_handler ) {
			$server_handler->send_event( $event_name, $data, $ecommerce_provider );
		}
	}

	/**
	 * Get the extra order data for the provider.
	 *
	 * @return array
	 */
	public function get_extra_order_data()
	{
		$server_handler = $this->get_server_handler();

		if ( empty($server_handler) ) {
			return [];
		}

		return $server_handler->get_extra_order_data();
	}

	/**
	 * Hash a value with sha256.
	 *
	 * @param string $value The value to hash,
	 *
	 * @return string
	 */
	public function hash( $value ) {
		if ( empty( $value ) ) {
			return '';
		}

		return hash( 'sha256', $value );
	}

	/**
	 * Checks if the provider is active from MI settings panel
	 *
	 * @since 9.7.0
	 * @return string
	 */
	abstract public function is_active();

	/**
	 * Get the tracking id.
	 * Provides a unified way of getting the basic tracking Id for each provider.
	 *
	 * @since 9.7.0
	 * @return mixed
	 */
	abstract public function get_tracking_id();

	/**
	 * Get the API token, if any.
	 * @return mixed
	 */
	abstract public function get_api_token();

	/**
	 * Get the provider id
	 *
	 * @since 9.7.0
	 * @return string
	 */
	abstract public function get_provider_id();

	/**
	 * Register the Provider's frontend hooks
	 *
	 * This function is used to load the required scripts in the frontend
	 *
	 * @since 9.7.0
	 * @return void
	 */
	abstract protected function add_frontend_hooks();

	/**
	 * Init the Provider's server hooks
	 *
	 * This function is used to load the required scripts in the server
	 *
	 * @since 9.7.0
	 * @return MonsterInsights_PPC_Server|null
	 */
	abstract protected function init_server_handler();

	/**
	 * Prints the necessary script for conversion tracking.
	 * This should be agnostic to ecommerce platforms.
	 *
	 * Returns true if conversion code is print in the page, false otherwise
	 *
	 * @param array $conversion_data
	 * @param array $customer_info
	 *
	 * @since 9.7.0 Added $customer_info parameter
	 *
	 * @return boolean
	 */
	abstract public function maybe_print_conversion_code( $conversion_data, $customer_info = [] );
}

// Class alias for backwards compatibility.
if ( !class_exists('MonsterInsights_PPC_Tracking_Provider') ) {
	// class_alias( 'MonsterInsights_Ads_Tracking_Provider', 'MonsterInsights_PPC_Tracking_Provider' );
}