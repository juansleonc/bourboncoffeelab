<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * MonsterInsights PPC Tracking Ecommerce tracking base class.
 *
 * @access public
 * @since 9.7.0
 *
 * @package MonsterInsights_PPC_Tracking
 * @subpackage Ecommerce_Providers
 * @author  David Paternina
 */
abstract class MonsterInsights_Ads_Tracking_Ecommerce_Tracking {

	/**
	 * Order object
	 *
	 * @var $order mixed
	 */
	protected $order;

	/**
	 * Add providers
	 *
	 * @var MonsterInsights_Ads_Tracking_Provider[]
	 */
	private $providers;

	/**
	 * @param $ad_providers MonsterInsights_Ads_Tracking_Provider[]
	 */
	public function __construct( $ad_providers ) {
		if ( !$this->is_active() ) { // Check if integration is active
			return;
		}

		$this->providers = $ad_providers;

		$this->add_frontend_hooks();
		$this->add_server_hooks();
	}

	/**
	 * Add frontend hooks
	 *
	 * @since 9.7.0
	 * @return void
	 */
	public function add_frontend_hooks() {
		add_action( 'monsterinsights_frontend_tracking_gtag_after_pageview', [ $this, 'insert_conversion_code' ] );
	}

	/**
	 * Add server hooks
	 *
	 * @since 9.7.0
	 * @return void
	 */
	public function add_server_hooks() {}

	/**
	 * Send server event to all ad providers
	 *
	 * @param string $event_name
	 * @param array $data
	 * @param MonsterInsights_Ads_Tracking_Ecommerce_Tracking $ecommerce_provider
	 *
	 * @return void
	 */
	protected function send_event_to_ad_providers($event_name, $data, $ecommerce_provider)
	{
		foreach ($this->get_ad_providers() as $provider) {
			$provider->send_server_event( $event_name, $data, $ecommerce_provider );
		}
	}

	/**
	 * Ads conversion tracking script
	 *
	 * @return void
	 */
	public function insert_conversion_code() {
		if ( apply_filters( 'monsterinsights_ppp_tracking_is_conversion_page', $this->do_conversion_checks() ) ) {
			
			//  Grab order
			if ( !$this->try_to_get_order() ) {
				//  Bail if we couldn't find the order
				return;
			}

			$conversion_data = $this->get_conversion_data();
			$customer_info = $this->get_order_customer_info( $conversion_data['order_id'] );

			foreach ( $this->providers as $provider ) {
				// Check if order has already been tracked for this provider
				if ( apply_filters( "monsterinsights_ppc_tracking_track_already_tracked_{$provider->get_provider_id()}", $this->already_tracked_frontend( $provider->get_provider_id() ) ) ) {
					continue;
				}

				$conversion_done = $provider->maybe_print_conversion_code( $conversion_data, $customer_info );

				if ( $conversion_done ) {
					$this->mark_order_tracked_frontend( $provider->get_provider_id() );
				}
			}
		}
	}

	/**
	 * Get standard conversion data object
	 *
	 * @return array{
	 *     order_total: float,
	 *     order_id: string|int,
	 *     currency: string,
	 *     ecommerce_platform: string
	 * }
	 */
	public function get_conversion_data() {
		return [
			'order_total'           => $this->get_order_total(),
			'order_id'              => $this->get_order_number(),
			'currency'              => $this->get_order_currency(),
			'ecommerce_platform'    => $this->get_name()
		];
	}

	/**
	 * Get ad providers
	 *
	* @since 9.7.0
	 * @return MonsterInsights_Ads_Tracking_Provider[]
	 */
	public function get_ad_providers() {
		return $this->providers;
	}

	/**
	 * Get order meta data based on the provider.
	 *
	 * @param int    $order_id The order id.
	 * @param string $key The key for the meta.
	 *
	 * @return mixed
	 */
	public function get_order_meta( $order_id, $key ) {
		return get_post_meta( $order_id, $key, true );
	}

	/**
	 * Store extra order data specific from each pixel.
	 *
	 * @param int   $order_id The order id to add meta to.
	 * @param array $data The array of key > value pairs to store.
	 *
	 * @return void
	 */
	public function store_extra_data( $order_id, $data ) {
		foreach ( $data as $key => $value ) {
			update_post_meta( $order_id, $key, $value );
		}
	}

	/**
	 * Whether the order has already been tracked as conversion
	 *
	 * @param $provider_id string
	 * @return boolean
	 */
	public function already_tracked_server( $order_id, $provider_id )
	{
		$tracked = $this->get_order_meta( $order_id, "_monsterinsights_ppc_tracking_conversion_tracked_{$provider_id}" );
		return ! empty( $tracked ) && 'yes' === $tracked;
	}

	/**
	 * Mark order as tracked as conversion
	 * @param $order_id
	 * @param $provider_id
	 *
	 * @return void
	 */
	public function mark_order_tracked_server( $order_id, $provider_id )
	{
		$this->store_extra_data( $order_id, [ "_monsterinsights_ppc_tracking_conversion_tracked_{$provider_id}" => 'yes' ] );
	}

	/**
	 * Store extra data for the order when saved
	 * @param $order_id
	 * @param $data
	 *
	 * @return void
	 */
	public function server_order_saved( $order_id, $data = [] )
	{
		foreach ( $this->get_ad_providers() as $provider ) {
			$ad_provider_data = $provider->get_extra_order_data();
			$this->store_extra_data(
				$order_id,
				array_merge(
					[
						'_monsterinsights_ppc_tracking_user_agent' => $this->get_user_agent(),
						'_monsterinsights_ppc_tracking_user_ip'    => $this->get_user_ip(),
					],
					$ad_provider_data
				)
			);
		}
	}

	/**
	 * Get the user agent.
	 *
	 * @return string
	 */
	public function get_user_agent()
	{
		return isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : ''; // @codingStandardsIgnoreLine
	}

	/**
	 * Get the current user ip.
	 *
	 * @return string
	 */
	public function get_user_ip() {
		if ( isset( $_SERVER['HTTP_X_REAL_IP'] ) ) {
			return sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_REAL_IP'] ) );
		} elseif ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) && function_exists( 'rest_is_ip_address' ) ) { // phpcs:ignore
			return (string) rest_is_ip_address( trim( current( preg_split( '/,/', sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) ) ) ) ); // phpcs:ignore
		} elseif ( isset( $_SERVER['REMOTE_ADDR'] ) ) { // phpcs:ignore
			return sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ); // phpcs:ignore
		}

		return '';
	}

	/**
	 * Get the user data for a logged-in user, if available.
	 *
	 * @return array
	 */
	protected function get_server_user_data()
	{
		return [];
	}

	/**
	 * Whether the integration should print the conversion script
	 *
	 * @return boolean
	 */
	abstract public function do_conversion_checks();

	/**
	 * Whether the integration is active and should run
	 *
	 * @return boolean
	 */
	abstract public function is_active();

	/**
	 * Get the product
	 * @return mixed
	 */
	abstract public function get_product($product_id);

	/**
	 * Try to populate the order attribute
	 * Returns true if order was found successfully, false otherwise
	 *
	 * @return boolean
	 */
	abstract public function try_to_get_order();

	/**
	 * Get Order total
	 *
	 * @return mixed
	 */
	abstract public function get_order_total();

	/**
	 * Get Order currency
	 *
	 * @return mixed
	 */
	abstract public function get_order_currency();

	/**
	 * Get Order number or id
	 *
	 * @return mixed
	 */
	abstract public function get_order_number();

	/**
	 * Whether the order has already been tracked as conversion
	 *
	 * @param $provider_id string
	 * @return boolean
	 */
	abstract public function already_tracked_frontend( $provider_id );

	/**
	 * Mark order as tracked as conversion
	 *
	 * @param $provider_id string
	 * @return void
	 */
	abstract public function mark_order_tracked_frontend( $provider_id );

	/**
	 * Get integration name (pretty)
	 *
	 * @return String
	 */
	abstract function get_name();

	/**
	 * Get customer info for the given order.
	 * We should have at least the email even if the user is not logged in (i.e. checked out as guest)
	 * Used in the conversion tracking page/script
	 *
	 * @param int $order_id
	 *
	 *
	 * @return array{
	 *     email: string,
	 *     phone_number: string,
	 *     first_name: string,
	 *     last_name: string,
	 *     address: array{
	 *          street: string,
	 *          city: string,
	 *          region: string,
	 *          postal_code: string,
	 *          country: string
	 *    }
 *     }
	 */
	abstract function get_order_customer_info( $order_id );
}

// Class alias for backwards compatibility.
if ( !class_exists('MonsterInsights_PPC_Tracking_Ecommerce_Tracking') ) {
	// class_alias( 'MonsterInsights_Ads_Tracking_Ecommerce_Tracking', 'MonsterInsights_PPC_Tracking_Ecommerce_Tracking' );
}