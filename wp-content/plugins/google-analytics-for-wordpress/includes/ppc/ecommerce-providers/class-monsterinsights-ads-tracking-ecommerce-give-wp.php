<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * MonsterInsights PPC Tracking - GiveWP tracking class.
 *
 * @access public
 * @since 9.7.0
 *
 * @package MonsterInsights_PPC_Tracking
 * @subpackage Ecommerce_Providers
 * @author  David Paternina
 */

class MonsterInsights_Ads_Tracking_Ecommerce_GiveWP extends MonsterInsights_Ads_Tracking_Ecommerce_Tracking
{
	/**
	 * Give WP Donation
	 *
	 * @var $donation array
	 */
	protected $donation;

	/**
	 * @inheritdoc
	 */
	public function do_conversion_checks() {
		global $post;

		$current_page_id      = $post->ID;
		$success_page_id = give_get_option( 'success_page' );

		if ( absint( $current_page_id ) !== absint( $success_page_id ) ) {
			return false;
		}

		return true;
	}

	/**
	 * @inheritdoc
	 */
	public function is_active() {
		return function_exists( 'Give' ) && apply_filters( 'monsterinsights_ppc_tracking_track_conversion_give', true );
	}

	/**
	 * @inheritdoc
	 */
	public function try_to_get_order() {

		$donation = give_get_purchase_session();

		if ( empty( $donation ) ) {
			return false;
		}

		$this->donation = $donation;
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function get_order_total() {
		return empty( $this->donation ) ? null : $this->donation['price'];
	}

	/**
	 * @inheritDoc
	 */
	public function get_order_currency() {

		return empty( $this->donation ) ? null : give_get_option( 'currency' );
	}

	/**
	 * @inheritDoc
	 */
	public function get_order_number() {
		return empty( $this->donation ) ? null : $this->donation['donation_id'];
	}

	/**
	 * @inheritDoc
	 */
	public function already_tracked_frontend( $provider_id ) {

		if ( empty( $this->donation ) ) {
			return true;
		}

		$tracked = Give()->payment_meta->get_meta(
			$this->get_order_number(),
			"_monsterinsights_ppc_tracking_conversion_tracked_{$provider_id}",
			true
		);

		return ! empty( $tracked ) && 'yes' === $tracked;
	}

	/**
	 * @inheritDoc
	 */
	public function mark_order_tracked_frontend( $provider_id ) {
		if ( empty( $this->donation ) ) {
			return;
		}

		Give()->payment_meta->update_meta(
			$this->get_order_number(),
			"_monsterinsights_ppc_tracking_conversion_tracked_{$provider_id}",
			true
		);
	}

	/**
	 * @inheritdoc
	 */
	public function add_server_hooks() {
		add_action( 'give_insert_payment', [$this, 'server_order_saved'], 10, 2 );
		add_action( 'give_complete_donation', [$this, 'server_event_purchase'] );
	}

	/**
	 * Send the order data to the ad providers.
	 * @param $payment_id
	 *
	 * @return void
	 */
	public function server_event_purchase( $payment_id ) {
		$donor_id = ( give_is_guest_payment( $payment_id ) ) ? absint( give_get_payment_donor_id( $payment_id ) ) : give_get_payment_user_id( $payment_id );

		$donor_address = give_get_donor_address( $donor_id );
		
		$data = [
			'order_id'   => $payment_id,
			'num_items'  => 1,
			'currency'   => give_get_payment_currency_code( $payment_id ),
			'total'      => give_get_payment_total( $payment_id ),
			'products'   => [
				[
					'id'         => give_get_payment_form_id( $payment_id ),
					'quantity'   => 1,
					'name'       => give_get_meta( $payment_id, '_give_payment_form_title', true ),
					'discount'   => 0,
					'price'      => give_get_payment_total( $payment_id ),
					'categories' => []
				]
			],
			'user_id'    => $donor_id,
			'user_ip'    => give_get_payment_user_ip( $payment_id ),
			'phone'      => '',
			'email'      => give_get_donation_donor_email( $payment_id ),
			'zip'        => $donor_address['zip'],
			'city'       => $donor_address['city'],
			'state'      => $donor_address['state'],
			'country'    => $donor_address['country'],
			'user_agent' => $this->get_order_meta( $payment_id, '_monsterinsights_ppc_tracking_user_agent' ),
			'first_name' => give_get_meta( $payment_id, '_give_donor_billing_first_name', true ),
			'last_name'  => give_get_meta( $payment_id, '_give_donor_billing_last_name', true )
		];
		
		$this->send_event_to_ad_providers( 'purchase', $data, $this );
	}

	/**
	 * @inheritdoc
	 */
	public function get_name() {
		return 'GiveWP';
	}

	/**
	 * @inheritdoc
	 */
	public function store_extra_data( $order_id, $data ) {
		foreach ( $data as $key => $value ) {
			give_update_payment_meta( $order_id, $key, $value );
		}
	}

	/**
	 * @inheritdoc
	 */
	public function get_order_meta( $order_id, $key ) {
		return give_get_payment_meta( $order_id, $key );
	}

	/**
	 * @inheritDoc
	 */
	function get_product( $product_id ) {
		return get_post( $product_id );
	}

	/**
	 * @inheritDoc
	 */
	public function get_currency() {
		return give_get_currency();
	}

	/**
	 * @inheritDoc
	 */
	function get_order_customer_info( $order_id ) {
		return [];
	}
}
