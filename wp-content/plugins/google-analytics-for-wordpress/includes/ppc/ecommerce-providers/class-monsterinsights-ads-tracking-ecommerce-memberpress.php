<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * MonsterInsights PPC Tracking - MemberPress tracking class.
 *
 * @access public
 * @since 9.7.0
 *
 * @package MonsterInsights_PPC_Tracking
 * @subpackage Ecommerce_Providers
 * @author  David Paternina
 */

class MonsterInsights_Ads_Tracking_Ecommerce_MemberPress extends MonsterInsights_Ads_Tracking_Ecommerce_Tracking
{
	/**
	 * MemberPress order
	 *
	 * @var $order MeprTransaction|MeprSubscription
	 */
	protected $order;

	/**
	 * MemberPress order/transaction id
	 *
	 * @var $order_id String
	 */
	private $order_id;

	/**
	 * @inheritdoc
	 */
	public function add_server_hooks() {
		add_action('mepr-above-checkout-form', [$this, 'server_event_begin_checkout']);

		// When the order is placed, attempt to save pixel-specific data to assign to the order when it later gets marked as completed.
		add_action( 'mepr-txn-status-pending', [ $this, 'server_order_saved' ], 10, 2 );

		// Order completed event.
		add_action( 'mepr-txn-status-complete', [ $this, 'server_event_purchase' ] );
		add_action( 'mepr-txn-status-confirmed', [ $this, 'server_event_purchase' ] );
	}

	/**
	 * @param MeprTransaction $txn
	 * @param array $data
	 *
	 * @return void
	 */
	public function store_extra_data( $txn, $data ) {
		if ( is_string($txn) || is_int($txn) ) {
			$txn = new MeprTransaction( $txn );
		}

		foreach ( $data as $key => $value ) {
			$txn->update_meta( $key, $value );
		}
	}

	/**
	 * @inheritdoc
	 */
	public function do_conversion_checks() {

		if ( isset( $_GET['trans_num'] ) ) {
			return true;
		}

		if ( isset( $_GET['action'] ) && $_GET['action'] === 'gifts' && isset( $_GET['txn'] ) ) {
			$txn = new MeprTransaction( (int) $_GET['txn'] );
			if ( $txn->id ) {
				$_REQUEST['trans_num'] = $txn->trans_num;
				return true;
			}
		}

		return false;
	}

	/**
	 * @inheritdoc
	 */
	public function is_active() {
		return defined( 'MEPR_VERSION' ) &&
			version_compare( MEPR_VERSION, '1.3.43', '>' ) &&
			apply_filters( 'monsterinsights_ppc_tracking_track_conversion_memberpress', true );
	}

	/**
	 * @inheritdoc
	 */
	public function try_to_get_order() {
		if ( empty( $_REQUEST['trans_num'] ) ) {
			return false;
		}

		if ( empty( $_REQUEST['subscr_id'] ) ) {
			$txn  = new MeprTransaction();
			$data = MeprTransaction::get_one_by_trans_num( sanitize_key( $_REQUEST['trans_num'] ) );
			$txn->load_data( $data );

			if ( ! $txn->id || ! $txn->product_id ) {
				return false;
			}

			$this->order    = $txn;
			$this->order_id = 'charge_' . $txn->id;

			return true;
		}

		$sub = MeprSubscription::get_one_by_subscr_id( sanitize_key( $_REQUEST['subscr_id'] ) );
		if ( $sub === false || ! $sub->id || ! $sub->product_id ) {
			return false;
		}
		$this->order    = $sub;
		$this->order_id = 'sub_' . $sub->id;

		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function get_order_total() {

		if ( empty( $this->order ) ) {
			return null;
		}

		if ( $this->order instanceof MeprSubscription ) {
			return $this->order->trial ? $this->order->trial_total : $this->order->total;
		} else {
			return $this->order->total;
		}
	}

	/**
	 * @inheritDoc
	 */
	public function get_order_currency() {
		$mepr_options = MeprOptions::fetch();

		return $mepr_options->currency_code;
	}

	/**
	 * @inheritDoc
	 */
	public function get_order_number() {
		return empty( $this->order_id ) ? null : $this->order_id;
	}

	/**
	 * @inheritDoc
	 */
	public function already_tracked_frontend( $provider_id ) {
		if ( empty( $this->order ) ) {
			return true;
		}

		$tracked = $this->order->get_meta( "_monsterinsights_ppc_tracking_conversion_tracked_{$provider_id}", true );

		return ! empty( $tracked ) && 'yes' === $tracked;
	}

	/**
	 * @inheritDoc
	 */
	public function mark_order_tracked_frontend( $provider_id ) {
		if ( empty( $this->order ) ) {
			return;
		}

		$this->order->update_meta( "_monsterinsights_ppc_tracking_conversion_tracked_{$provider_id}", 'yes' );
	}

	/**
	 * Send a server event when the checkout page is viewed.
	 *
	 * @param MeprProduct $product The product for which the checkout is being viewed.
	 *
	 * @return void
	 * @throws Exception
	 */
	public function server_event_begin_checkout( $product ) {

		$data = $this->get_checkout_data();

		$user_data = [
			'user_ip'    => $this->get_user_ip(),
			'user_agent' => $this->get_user_agent(),
		];

		$data = array_merge( $data, $user_data );
		$data = array_merge( $data, $this->get_server_user_data() );

		$this->send_event_to_ad_providers( 'begin_checkout', $data, $this );
	}

	/**
	 * Track a server purchase event specific to MemberPress.
	 *
	 * @param MeprTransaction $txn The transaction object.
	 *
	 * @return void
	 */
	public function server_event_purchase( $txn ) {
		if ( ! is_object( $txn ) ) {
			return;
		}

		// Don't report transactions that are not payments.
		if ( ! empty( $txn->txn_type ) && MeprTransaction::$payment_str !== $txn->txn_type ) {
			return;
		}

		$skip_renewals = apply_filters( 'monsterinsights_ppc_tracking_skip_renewals', true );
		if ( $skip_renewals && $txn->is_rebill() ) {
			return;
		}

		$user = $txn->user();

		// Build purchase event data from order.
		$data = [
			'order_id'   => $txn->id,
			'num_items'  => 1,
			'currency'   => $this->get_currency(),
			'total'      => $txn->total,
			'products'   => [],
			'user_id'    => $user->ID,
			'user_ip'    => $txn->get_meta( '_monsterinsights_ppc_tracking_user_ip', true ),
			'email'      => $user->user_email,
			'zip'        => get_user_meta( $user->ID, 'mepr-address-zip', true ),
			'city'       => get_user_meta( $user->ID, 'mepr-address-city', true ),
			'state'      => get_user_meta( $user->ID, 'mepr-address-state', true ),
			'country'    => get_user_meta( $user->ID, 'mepr-address-country', true ),
			'user_agent' => $txn->get_meta( '_monsterinsights_ppc_tracking_user_agent', true ),
			'first_name' => $user->first_name,
			'last_name'  => $user->last_name,
		];

		if ( ! empty( $txn->coupon_id ) ) {
			$data['coupon'] = get_the_title( $txn->coupon_id );
		}

		$product            = new MeprProduct( $txn->product_id );
		$data['products'][] = [
			'id'       => $txn->product_id,
			'quantity' => 1,
			'name'     => $product->post_title,
			'discount' => $product->price - $txn->amount,
			'price'    => $txn->amount,
		];

		$this->send_event_to_ad_providers( 'purchase', $data, $this );
	}

	/**
	 * Get checkout data specific to MemberPress.
	 *
	 * @return array
	 */
	public function get_checkout_data() {
		if ( ! class_exists( 'MeprProduct' ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return [];
		}

		$current_post = MeprUtils::get_current_post();
		$product      = $this->get_product( $current_post->ID );

		// Let's check if the current user already has a subscription.
		$user = MeprUtils::get_currentuserinfo();
		if ( false !== $user ) {
			$enabled_prd_ids = $user->get_enabled_product_ids( $product->ID );
			if ( ! empty( $enabled_prd_ids ) && ! $product->simultaneous_subscriptions ) {
				// User already has a subscription for this product and the checkout form will be hidden don't track this.
				return [];
			}
		}

		$data = [
			'num_items' => 1,
			'currency'  => $this->get_currency(),
			'total'     => $product->price,
			'products'  => [
				[
					'id'         => $product->ID,
					'quantity'   => 1,
					'name'       => $product->post_title,
					'price'      => $product->price,
					'discount'   => 0,
					'categories' => [],
				],
			],
		];

		return $data;
	}

	/**
	 * Get the user data for a logged-in user, if available.
	 *
	 * @return array
	 * @throws Exception
	 */
	public function get_server_user_data() {
		$data = [];

		if ( is_user_logged_in() ) {
			$user               = new MeprUser( get_current_user_id() );
			$data['user_id']    = get_current_user_id();
			$data['email']      = $user->user_email;
			$data['city']       = get_user_meta( $user->ID, 'mepr-address-city', true );
			$data['state']      = get_user_meta( $user->ID, 'mepr-address-state', true );
			$data['country']    = get_user_meta( $user->ID, 'mepr-address-country', true );
			$data['zip']        = get_user_meta( $user->ID, 'mepr-address-zip', true );
			$data['first_name'] = $user->first_name;
			$data['last_name']  = $user->last_name;
		}

		return $data;
	}

	/**
	 * @inheritdoc
	 */
	public function get_name() {
		return 'MemberPress';
	}

	/**
	 * @inheritDoc
	 */
	public function get_product( $product_id ) {
		return new MeprProduct( $product_id );
	}

	/**
	 * @inheritDoc
	 */
	public function get_currency() {
		$mepr_options = MeprOptions::fetch();

		return ! empty( $mepr_options->currency_code ) ? $mepr_options->currency_code : 'USD';
	}

	/**
	 * @inheritDoc
	 */
	function get_order_customer_info( $order_id ) {
		if ( empty( $this->order ) && !$this->try_to_get_order() ) {
			return [];
		}

		//  Order was loaded, or we were able to load just above.

		$user = $this->order->user();
		$email = $user->user_email;

		if ( empty( $email ) ) {
			return [];
		}

		$data = [
			'email'         => $email,
			'first_name'    => $user->first_name,
			'last_name'     => $user->last_name,
			'address'       => [
				'street'        => $user->address('one'),
				'city'          => $user->address('city'),
				'region'        => $user->address('state'),
				'postal_code'   => $user->address('zip'),
				'country'       => $user->address('country'),
			]
		];

		return $data;
	}
}
