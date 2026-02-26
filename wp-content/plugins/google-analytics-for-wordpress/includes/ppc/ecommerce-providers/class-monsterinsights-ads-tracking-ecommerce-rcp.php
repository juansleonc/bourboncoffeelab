<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * MonsterInsights PPC Tracking - Restrict Content Pro tracking class.
 *
 * @access public
 * @since 9.7.0
 *
 * @package MonsterInsights_PPC_Tracking
 * @subpackage Ecommerce_Providers
 * @author  David Paternina
 */

class MonsterInsights_Ads_Tracking_Ecommerce_RCP extends MonsterInsights_Ads_Tracking_Ecommerce_Tracking
{
	/**
	 * RCP Payment
	 *
	 * @var $payment RCP_Payments
	 */
	protected $payment;

	/**
	 * Whether the checkout has been tracked or not.
	 * RCP Fires the rcp_setup_registration action multiple times, so we need to track this.
	 * @var bool
	 */
	private $tracked_checkout = false;

	/**
	 * @inheritdoc
	 */
	public function do_conversion_checks() {
		global $post;
		global $rcp_options;

		$current_page_id      = $post->ID;
		$rcp_welcome_page_id = $rcp_options['redirect'];

		if ( absint( $current_page_id ) !== absint( $rcp_welcome_page_id ) ) {
			return false;
		}

		return true;
	}

	/**
	 * @inheritdoc
	 */
	public function is_active() {
		return class_exists( 'Restrict_Content_Pro' ) &&
			version_compare( RCP_PLUGIN_VERSION, '3.5.4', '>=' ) &&
			apply_filters( 'monsterinsights_ppc_tracking_track_conversion_rcp', true );
	}

	/**
	 * @inheritdoc
	 */
	public function try_to_get_order() {
		$customer = rcp_get_customer();

		if ( empty($customer) ) {
			return false;
		}

		//  Get the latest payment
		$payments = $customer->get_payments([
			'order'     => 'DESC',
			'orderby'   => 'id',
		]);

		if ( empty( $payments ) ) {
			return false;
		}

		$payment = $payments[0];

		if ( $payment->transaction_type === 'renewal' ) {
			return false;
		}

		$this->payment = $payment;
		return true;
	}

	/**
	 * @inheritDoc
	 */
	function get_order_total() {
		return empty( $this->payment ) ? null : $this->payment->amount;
	}

	/**
	 * @inheritDoc
	 */
	function get_order_currency() {
		return empty( $this->payment ) || !function_exists('rcp_get_currency') ? null : rcp_get_currency();
	}

	/**
	 * @inheritDoc
	 */
	function get_order_number() {
		return empty( $this->payment ) ? null : $this->payment->id;
	}

	/**
	 * @inheritDoc
	 */
	function already_tracked_frontend( $provider_id ) {
		if ( empty( $this->payment ) ) {
			return true;
		}

		$rcp_payments = new RCP_Payments();

		$tracked = $rcp_payments->get_meta(
			$this->get_order_number(),
			"_monsterinsights_ppc_tracking_conversion_tracked_{$provider_id}",
			true
		);

		return ! empty( $tracked ) && 'yes' === $tracked;
	}

	/**
	 * @inheritDoc
	 */
	function mark_order_tracked_frontend( $provider_id ) {
		if ( empty( $this->payment ) ) {
			return;
		}

		$rcp_payments = new RCP_Payments();

		$rcp_payments->update_meta(
			$this->get_order_number(),
			"_monsterinsights_ppc_tracking_conversion_tracked_{$provider_id}",
			'yes'
		);
	}

	/**
	 * @inheritdoc
	 */
	public function add_server_hooks() {
		add_action('template_redirect', [$this, 'server_event_begin_checkout']);
		add_action('rcp_create_payment', [$this, 'server_order_saved'], 10, 2);
		add_action('rcp_update_payment_status_complete', [$this, 'server_event_purchase']);
	}

	/**
	 * @inheritdoc
	 */
	public function get_name() {
		return 'RCP';
	}

	/**
	 * Send the begin_checkout event to the ad providers.
	 * @return void
	 */
	public function server_event_begin_checkout() {

		if ( ! rcp_is_registration_page() ) {
			return;
		}

		$registration = rcp_get_registration();

		$rcp_levels = rcp_get_paid_levels();

		if ( empty($rcp_levels) || $this->tracked_checkout ) {
			return;
		}

		$default_level = $rcp_levels[0];
		$level = apply_filters('monsterinsights_ppc_checkout_tracking_rcp_level', $default_level, $rcp_levels);

		$this->tracked_checkout = true;

		$data = [
			'num_items' => 1,
			'currency'  => $this->get_currency(),
			'total'     => $level->get_price(),
			'products'  => [
				[
					'id'         => $level->get_id(),
					'quantity'   => 1,
					'name'       => $level->get_name(),
					'discount'   => $registration->get_total_discounts(),
					'price'      => $level->get_price(),
					'categories' => [],
				]
			]
		];

		$user_data = [
			'user_ip'    => $this->get_user_ip(),
			'user_agent' => $this->get_user_agent(),
		];

		$data = array_merge( $data, $user_data );
		$data = array_merge( $data, $this->get_server_user_data() );

		$this->send_event_to_ad_providers( 'begin_checkout', $data, $this );
	}

	/**
	 * Send the purchase event to the ad providers.
	 * @param $payment_id
	 *
	 * @return void
	 */
	public function server_event_purchase($payment_id) {
		global $rcp_payments_db;
		$payment = $rcp_payments_db->get_payment($payment_id);

		if ( empty($payment) ) {
			return;
		}

		$user = get_user_by('id', $payment->user_id);

		$membership = rcp_get_membership($payment->membership_id);
		$level = rcp_get_membership_level($membership->get_object_id());

		// Build purchase event data from order.
		$data = [
			'order_id'   => $payment->id,
			'num_items'  => 1,
			'currency'   => $this->get_currency(),
			'total'      => $payment->amount,
			'products'   => [
				[
					'id'         => $level->get_id(),
					'quantity'   => 1,
					'name'       => $level->get_name(),
					'discount'   => $payment->discount_amount,
					'price'      => $level->get_price(),
					'categories' => [],
				]
			],
			'user_id'    => $payment->user_id,
			'user_ip'    => $this->get_order_meta( $payment_id, '_monsterinsights_ppc_tracking_user_ip' ),
			'phone'      => '',
			'email'      => $user->user_email,
			'zip'        => '',
			'city'       => '',
			'state'      => '',
			'country'    => '',
			'user_agent' => $this->get_order_meta( $payment_id, '_monsterinsights_ppc_tracking_user_agent' ),
			'first_name' => $user->first_name,
			'last_name'  => $user->last_name,
		];

		//
		$this->send_event_to_ad_providers( 'purchase', $data, $this );
	}

	/**
	 * @inheritdoc
	 * @param $order_id - RCP Payment Id
	 * @param $data
	 *
	 * @return void
	 */
	public function store_extra_data( $order_id, $data ) {
		global $rcp_payments_db;

		foreach ( $data as $key => $value ) {
			$rcp_payments_db->add_meta( $order_id, $key, $value, true );
		}
	}

	/**
	 * @inheritdoc
	 * @param $order_id - RCP Payment Id
	 * @param $key
	 *
	 * @return mixed
	 */
	public function get_order_meta( $order_id, $key ) {
		global $rcp_payments_db;
		return $rcp_payments_db->get_meta( $order_id, $key, true);
	}

	/**
	 * @inheritDoc
	 * Returns the membership level with the given ID.
	 */
	function get_product( $product_id ) {
		return rcp_get_membership_level($product_id);
	}

	/**
	 * @inheritDoc
	 */
	public function get_currency() {
		return rcp_get_currency();
	}

	/**
	 * @inheritDoc
	 */
	function get_order_customer_info( $order_id ) {

		if ( empty( $this->payment ) && !$this->try_to_get_order() ) {
			return [];
		}

		//  Order was loaded, or we were able to load just above.

		//  We need at least the email even if the user is not logged in (i.e. checked out as guest)
		$customer = rcp_get_customer( $this->payment->customer_id );

		if ( empty($customer) ) {
			return [];
		}

		$user = get_user_by('id', $customer->get_user_id());

		$email = $user->user_email;

		if ( empty( $email ) ) {
			return [];
		}

		$data = [
			'email'         => $email,
			'first_name'    => $user->first_name,
			'last_name'     => $user->last_name
		];

		return $data;
	}
}
