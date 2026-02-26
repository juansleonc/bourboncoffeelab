<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * MonsterInsights PPC Tracking - EDD tracking class.
 *
 * @access public
 * @since 9.7.0
 *
 * @package MonsterInsights_PPC_Tracking
 * @subpackage Ecommerce_Providers
 * @author  David Paternina
 */

class MonsterInsights_Ads_Tracking_Ecommerce_EDD extends MonsterInsights_Ads_Tracking_Ecommerce_Tracking
{
	/**
	 * EDD Payment/order
	 *
	 * @var $payment EDD_Payment
	 */
	protected $payment;

	/**
	 * @inheritdoc
	 */
	public function do_conversion_checks() {

		$confirmation_page = edd_get_option( 'confirmation_page', false );

		/*
		 * AKA "Receipt Page"
		 */
		$success_page = edd_get_option( 'success_page', false );

		$possible_pages = [$confirmation_page, $success_page];

		return is_page( $possible_pages );
	}

	/**
	 * @inheritdoc
	 */
	public function is_active() {
		return class_exists( 'Easy_Digital_Downloads' ) && apply_filters( 'monsterinsights_ppc_tracking_track_conversion_edd', true );
	}

	/**
	 * @inheritdoc
	 */
	public function try_to_get_order() {

		$session = edd_get_purchase_session();

		if ( empty( $session['purchase_key'] ) ) {
			return false;
		}

		$payment_key = $session['purchase_key'];
		$payment_id    = edd_get_purchase_id_by_key( $payment_key );

		if ( empty( $payment_id ) ) {
			return false;
		}

		$this->payment = edd_get_payment( $payment_id );

		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function get_order_total() {
		return empty( $this->payment ) ? null : edd_get_payment_amount( $this->get_order_number() );
	}

	/**
	 * @inheritDoc
	 */
	public function get_order_currency() {
		return empty( $this->payment ) ? null : edd_get_payment_currency_code( $this->get_order_number() );
	}

	/**
	 * @inheritDoc
	 */
	public function get_order_number() {
		return empty( $this->payment ) ? null : $this->payment->ID;
	}

	/**
	 * @inheritDoc
	 */
	public function already_tracked_frontend( $provider_id ) {
		if ( empty( $this->payment ) ) {
			return true;
		}

		$tracked = $this->payment->get_meta( "_monsterinsights_ppc_tracking_conversion_tracked_{$provider_id}", true );

		return ! empty( $tracked ) && 'yes' === $tracked;
	}

	/**
	 * @inheritDoc
	 */
	public function mark_order_tracked_frontend( $provider_id ) {
		if ( empty( $this->payment ) ) {
			return;
		}
		$this->payment->update_meta("_monsterinsights_ppc_tracking_conversion_tracked_{$provider_id}", 'yes' );
	}

	/**
	 * @inheritdoc
	 */
	public function get_name() {
		return 'EDD';
	}

	/**
	 * @inheritdoc
	 */
	public function add_server_hooks() {
		add_action('edd_post_add_to_cart', [$this, 'server_event_add_to_cart'], 10, 3);

		// When the checkout cart is loaded, send a server event if the Token is set.
		add_action( 'edd_before_checkout_cart', [$this, 'server_event_begin_checkout'] );

		// When the order is placed, attempt to save pixel-specific data to assign to the order when it later gets marked as completed.
		add_action( 'edd_insert_payment', [$this, 'server_order_saved'], 10, 2 );

		// Order paid event.
		add_action( 'edd_update_payment_status', [$this, 'server_event_purchase'], 10, 3 );
	}

	/**
	 * Send View Content event to all ad providers
	 *
	 * @return void
	 * @throws Exception
	 */
	public function server_event_add_to_cart( $download_id, $options, $items ) {
		$download = new EDD_Download( $download_id );

		$quantity = isset( $options['quantity'] ) ? absint( $options['quantity'] ) : 1;
		$price_id = isset( $options['price_id'] ) ? $options['price_id'] : 0;

		$data = [
			'product_id' => $download_id,
			'quantity'   => $quantity,
			'name'       => $download->get_name(),
			'price'      => $this->edd_get_price( $download_id, $price_id ),
			'categories' => $this->get_product_categories( $download ),
			'currency'   => $this->get_currency(),
			'user_ip'    => edd_get_ip(),
			'user_agent' => $this->get_user_agent()
		];

		$data = array_merge( $data, $this->get_server_user_data() );

		$this->send_event_to_ad_providers( 'add_to_cart', $data, $this );
	}

	/**
	 * Send Begin Checkout event to all ad providers
	 * @return void
	 */
	public function server_event_begin_checkout() {
		$data = $this->get_checkout_data();

		$user_data = [
			'user_ip'    => edd_get_ip(),
			'user_agent' => $this->get_user_agent(),
		];

		$data = array_merge( $data, $user_data );
		$data = array_merge( $data, $this->get_server_user_data() );

		$this->send_event_to_ad_providers( 'begin_checkout', $data, $this );
	}

	/**
	 * @param int    $order_id
	 * @param string $old_status The old order status.
	 * @param string $new_status The new order status.
	 *
	 * @return void
	 */
	public function server_event_purchase( $order_id, $new_status, $old_status ) {

		if ( 'publish' !== $new_status && 'edd_subscription' !== $new_status && 'complete' !== $new_status ) {
			return;
		}

		$skip_renewals = apply_filters( 'monsterinsights_ppc_tracking_skip_renewals', true );
		if ( 'edd_subscription' === $new_status && $skip_renewals ) {
			return;
		}

		$order = new EDD_Payment( $order_id );

		$address = $order->address;

		// Build purchase event data from order.
		$data = [
			'order_id'   => $order_id,
			'num_items'  => count( $order->cart_details ),
			'currency'   => $order->currency,
			'total'      => $order->total,
			'products'   => [],
			'user_id'    => $order->user_id,
			'user_ip'    => $order->ip,
			'phone'      => '',
			'email'      => $order->email,
			'zip'        => $address['zip'],
			'city'       => $address['city'],
			'state'      => $address['state'],
			'country'    => $address['country'],
			'user_agent' => $this->get_order_meta( $order_id, '_monsterinsights_ppc_tracking_user_agent' ),
			'first_name' => $order->first_name,
			'last_name'  => $order->last_name,
		];

		foreach ( $order->cart_details as $item ) {
			$product            = new EDD_Download( $item['id'] );
			$data['products'][] = [
				'id'         => $item['id'],
				'quantity'   => $item['quantity'],
				'name'       => $item['name'],
				'discount'   => $item['discount'],
				'price'      => $item['price'],
				'categories' => $this->get_product_categories( $product ),
			];
		}

		//
		$this->send_event_to_ad_providers( 'purchase', $data, $this );
	}

	/**
	 * @inheritdoc
	 */
	public function get_order_meta( $order_id, $key ) {
		if ( !function_exists('edd_get_order_meta') ) {
			//  EDD 2 fallback
			return parent::get_order_meta( $order_id, $key );
		}

		return edd_get_order_meta( $order_id, $key, true );
	}

	/**
	 * Store extra order data specific for EDD.
	 *
	 * @param int   $order_id The order id to add meta to.
	 * @param array $data The array of key > value pairs to store.
	 *
	 * @return void
	 */
	public function store_extra_data( $order_id, $data ) {
		if ( !function_exists('edd_update_order_meta') ) {
			//  EDD 2 fallback
			parent::store_extra_data( $order_id, $data );
		}

		foreach ( $data as $key => $value ) {
			edd_update_order_meta( $order_id, $key, $value );
		}
	}

	/**
	 * Get checkout data specific to EDD.
	 *
	 * @return array
	 */
	public function get_checkout_data() {
		if ( ! function_exists( 'edd_get_download' ) ) {
			return [];
		}

		// Get edd cart data.
		$data = [
			'num_items' => edd_get_cart_quantity(),
			'currency'  => $this->get_currency(),
			'total'     => edd_get_cart_total(),
			'products'  => [],
		];

		$coupon = EDD()->cart->get_discounts();
		if ( ! empty( $coupon ) && ! empty( $coupon[0] ) ) {
			$data['coupon'] = $coupon[0];
		}

		$cart_contents = edd_get_cart_content_details();
		foreach ( $cart_contents as $item ) {

			$download = edd_get_download( $item['id'] );

			$data['products'][] = [
				'id'         => $item['id'],
				'quantity'   => $item['quantity'],
				'name'       => $item['name'],
				'discount'   => $item['discount'],
				'price'      => $item['price'],
				'categories' => $this->get_product_categories( $download ),
			];
		}

		return $data;
	}

	/**
	 * Get the user data for a logged-in user, if available.
	 *
	 * @return array
	 */
	public function get_server_user_data() {
		$data = [];

		if ( is_user_logged_in() ) {
			$user_id            = get_current_user_id();
			$user               = wp_get_current_user();
			$address            = edd_get_customer_address( $user_id );
			$data['user_id']    = get_current_user_id();
			$data['email']      = $user->user_email;
			$data['city']       = $address['city'];
			$data['state']      = $address['state'];
			$data['country']    = $address['country'];
			$data['zip']        = $address['zip'];
			$data['first_name'] = $user->first_name;
			$data['last_name']  = $user->last_name;
		}

		return $data;
	}

	/**
	 * Get the price of a product.
	 * @param $download_id
	 * @param $price_id
	 *
	 * @return mixed|null
	 */
	public function edd_get_price( $download_id = 0, $price_id = 0 ) {
		$prices = edd_get_variable_prices( $download_id );
		$amount = 0.00;
		if ( is_array( $prices ) && ! empty( $prices ) ) {
			if ( isset( $prices[ $price_id ] ) ) {
				$amount = $prices[ $price_id ]['amount'];
			} else {
				$amount = edd_get_download_price( $download_id );
			}
		} else {
			$amount = edd_get_download_price( $download_id );
		}

		return apply_filters( 'edd_get_price_option_amount', edd_sanitize_amount( $amount ), $download_id, $price_id );
	}

	/**
	 * Get the Edd currency.
	 *
	 * @return string
	 */
	public function get_currency()
	{
		return edd_get_currency();
	}

	/**
	 * Get the product categories.
	 *
	 * @param EDD_Download $product The product to grab the categories from.
	 *
	 * @return array
	 */
	public function get_product_categories( $product ) {
		$product_categories = wp_get_post_terms( $product->get_ID(), 'download_category' );

		if ( is_wp_error( $product_categories ) ) {
			return [];
		}

		$categories = [];
		foreach ( $product_categories as $category ) {
			if ( ! empty( $category ) && ! is_wp_error( $category ) ) {
				$categories[] = $category->name;
			}
		}

		return $categories;
	}

	/**
	 * @param $product_id
	 * @param $price_id
	 * @param $quantity
	 *
	 * @return array
	 */
	public function get_product( $product_id, $price_id = false, $quantity = 1 ) {
		$download       = new EDD_Download( $product_id );
		$categories     = get_the_terms( $download->ID, 'download_category' );
		$category_names = is_array( $categories ) ? wp_list_pluck( $categories, 'name' ) : [];
		$first_category = reset( $category_names );
		$price_options  = $download->get_prices();
		$price_id       = ( $price_id === false || $price_id === null ) ? $price_id : '';
		$variation      = isset( $price_options[ $price_id ] ) ? $price_options[ $price_id ]['name'] : '';

		$data = [
			'id'       => $download->ID,
			'name'     => $download->post_title,
			'quantity' => $quantity,
			'brand'    => '', // @todo: use this for FES
			'category' => $first_category, // @todo: Possible  hierarchy the cats in the future
			'variant'  => $variation,
			'position' => '',
			'price'    => 0,// $this->edd_get_price( $download->ID, $variation ),
		];

		return $data;
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
		$email = $this->payment->email;

		if ( empty( $email ) ) {
			return [];
		}

		$data = [
			'email'         => $email,
			'first_name'    => $this->payment->first_name,
			'last_name'     => $this->payment->last_name,
			'address'       => [
				'street'        => $this->payment->address['line1'],
				'city'          => $this->payment->address['city'],
				'region'        => $this->payment->address['state'],
				'postal_code'   => $this->payment->address['zip'],
				'country'       => $this->payment->address['country']
			]
		];

		return $data;
	}
}
