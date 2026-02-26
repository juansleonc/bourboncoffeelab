<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * MonsterInsights PPC Tracking - WooCommerce tracking class.
 *
 * @access public
 * @since 9.7.0
 *
 * @package MonsterInsights_PPC_Tracking
 * @subpackage Ecommerce_Providers
 * @author  David Paternina
 */

class MonsterInsights_Ads_Tracking_Ecommerce_Woo extends MonsterInsights_Ads_Tracking_Ecommerce_Tracking {
	/**
	 * WooCommerce order
	 *
	 * @var $order WC_Order
	 */
	protected $order;

	/**
	 * Tracks cart item keys that have already had add_to_cart events sent
	 * in the current request to prevent duplicate tracking.
	 *
	 * @var array
	 */
	private $tracked_add_to_cart_items = array();

	/**
	 * @inheritdoc
	 */
	public function do_conversion_checks() {
		return function_exists( 'is_order_received_page' ) && is_order_received_page();
	}

	/**
	 * @inheritdoc
	 */
	public function is_active() {
		return class_exists( 'WooCommerce' ) && apply_filters( 'monsterinsights_ppc_tracking_track_conversion_woocommerce', true );
	}

	/**
	 * @inheritdoc
	 */
	public function try_to_get_order() {
		$order_id = absint( get_query_var( 'order-received' ) );

		if ( empty( $order_id ) ) {
			return false;
		}

		$this->order = wc_get_order( $order_id );
		return true;
	}

	/**
	 * @inheritDoc
	 */
	function get_order_total() {
		return empty( $this->order ) ? null : $this->order->get_total();
	}

	/**
	 * @inheritDoc
	 */
	function get_order_currency() {
		return empty( $this->order ) ? null : $this->order->get_currency();
	}

	/**
	 * @inheritDoc
	 */
	function get_order_number() {
		return empty( $this->order ) ? null : $this->order->get_id();
	}

	/**
	 * @inheritDoc
	 */
	public function already_tracked_frontend( $provider_id ) {
		if ( empty( $this->order ) ) {
			return true;
		}

		$tracked = $this->order->get_meta( "_monsterinsights_ppc_tracking_conversion_tracked_{$provider_id}" );

		return ! empty( $tracked ) && 'yes' === $tracked;
	}

	/**
	 * @inheritDoc
	 */
	public function mark_order_tracked_frontend( $provider_id ) {
		if ( empty( $this->order ) ) {
			return;
		}

		$this->order->add_meta_data( "_monsterinsights_ppc_tracking_conversion_tracked_{$provider_id}", 'yes', true );
		$this->order->save_meta_data();
	}

	/**
	 * @inheritdoc
	 */
	public function get_name() {
		return 'WooCommerce';
	}

	/**
	 * Get order meta specific to WooCommerce.
	 * Improved compatibility by not calling get_post_meta directly.
	 *
	 * @param int    $order_id The order to get meta for.
	 * @param string $key The key to get meta by.
	 *
	 * @return array|mixed|string
	 */
	public function get_order_meta( $order_id, $key ) {
		$order = wc_get_order( $order_id );

		return $order->get_meta( $key );
	}

	/**
	 * Store extra order data specific for WooCommerce.
	 *
	 * @param int   $order_id The order id to add meta to.
	 * @param array $data The array of key > value pairs to store.
	 *
	 * @return void
	 */
	public function store_extra_data( $order_id, $data ) {
		$order = wc_get_order( $order_id );

		foreach ( $data as $key => $value ) {
			$order->update_meta_data( $key, $value );
		}

		$order->save();
	}

	/**
	 * @return void
	 */
	public function add_server_hooks() {
		add_action( 'woocommerce_add_to_cart', [ $this, 'server_event_add_to_cart' ], 10, 6 );
		add_action( 'woocommerce_after_single_product_summary', [ $this, 'server_event_view_content' ] );
		add_action( 'woocommerce_after_checkout_form', [ $this, 'server_event_begin_checkout' ] );

		add_action('woocommerce_order_status_processing', [$this, 'server_event_purchase'], 10, 2);
		add_action('woocommerce_order_status_completed', [$this, 'server_event_purchase'], 10, 2);

		add_action('woocommerce_checkout_update_order_meta', [$this, 'server_order_saved'], 10, 2);
	}

	/**
	 * Send Add To Cart event to all ad providers
	 *
	 * @param $cart_id
	 * @param $product_id
	 * @param $request_quantity
	 * @param $variation_id
	 * @param $variation
	 * @param $cart_item_data
	 *
	 * @return void
	 * @throws Exception
	 */
	public function server_event_add_to_cart( $cart_id = '', $product_id = 0, $request_quantity = 0, $variation_id = 0, $variation = [], $cart_item_data = [] ) {
		// Prevent duplicate tracking for the same cart item in the same request.
		if ( ! empty( $cart_id ) && in_array( $cart_id, $this->tracked_add_to_cart_items, true ) ) {
			return;
		}
		if ( ! empty( $cart_id ) ) {
			$this->tracked_add_to_cart_items[] = $cart_id;
		}

		$product = $this->get_product($product_id, $variation_id);

		if ( empty( $product ) || is_wp_error( $product ) ) {
			return;
		}

		$data = [
			'product_id' => $product->get_id(),
			'quantity'   => $request_quantity,
			'name'       => $product->get_name(),
			'price'      => $product->get_price(),
			'categories' => $this->get_product_categories( $product ),
			'currency'   => $this->get_currency(),
			'user_ip'    => WC_Geolocation::get_ip_address(),
			'user_agent' => $this->get_user_agent()
		];

		$data = array_merge( $data, $this->get_server_user_data() );

		$this->send_event_to_ad_providers( 'add_to_cart', $data, $this );
	}

	/**
	 * Send View Content event to all ad providers
	 *
	 * @return void
	 * @throws Exception
	 */
	public function server_event_view_content() {
		// Don't do it on feeds
		if ( is_feed() ) {
			return;
		}

		$product_id = get_the_ID();

		$product = $this->get_product($product_id);

		$data = [
			'product_id' => $product->get_id(),
			'name'       => $product->get_name(),
			'price'      => $product->get_price(),
			'categories' => $this->get_product_categories( $product ),
			'currency'   => $this->get_currency(),
			'user_ip'    => WC_Geolocation::get_ip_address(),
			'user_agent' => $this->get_user_agent()
		];

		$data = array_merge( $data, $this->get_server_user_data() );

		$this->send_event_to_ad_providers( 'view_content', $data, $this );
	}

	/**
	 * Send Begin Checkout event to all ad providers
	 *
	 * @param $checkout
	 *
	 * @return void
	 * @throws Exception
	 */
	public function server_event_begin_checkout() {
		$data = $this->get_checkout_data();

		$user_data = [
			'user_ip'    => WC_Geolocation::get_ip_address(),
			'user_agent' => $this->get_user_agent()
		];

		$data = array_merge( $data, $user_data );
		$data = array_merge( $data, $this->get_server_user_data() );

		$this->send_event_to_ad_providers( 'begin_checkout', $data, $this );
	}

	/**
	 * Send Purchase event to all ad providers
	 * @param $order_id
	 * @param $order
	 *
	 * @return void
	 */
	public function server_event_purchase( $order_id, $order ) {
		$skip_renewals = apply_filters( 'monsterinsights_ppc_tracking_skip_renewals', true );
		if ( function_exists( 'wcs_order_contains_subscription' ) && wcs_order_contains_subscription( $order_id, 'renewal' ) && $skip_renewals ) {
			return;
		}

		// Build purchase event data from order.
		$data = [
			'order_id'   => $order_id,
			'num_items'  => $order->get_item_count(),
			'currency'   => $order->get_currency(),
			'total'      => $order->get_total(),
			'products'   => [],
			'user_id'    => $order->get_user_id(),
			'user_ip'    => $order->get_customer_ip_address(),
			'phone'      => $order->get_billing_phone(),
			'email'      => $order->get_billing_email(),
			'zip'        => $order->get_billing_postcode(),
			'city'       => $order->get_billing_city(),
			'state'      => $order->get_billing_state(),
			'country'    => $order->get_billing_country(),
			'user_agent' => $order->get_customer_user_agent(),
			'first_name' => $order->get_billing_first_name(),
			'last_name'  => $order->get_billing_last_name(),
		];

		foreach ( $order->get_items() as $item ) {
			$product = $item->get_product();

			if ( empty( $product ) || is_wp_error( $product ) ) {
				continue;
			}

			$data['products'][] = [
				'id'         => $product->get_id(),
				'quantity'   => $item->get_quantity(),
				'name'       => $product->get_name(),
				'discount'   => $item->get_subtotal() - $item->get_total(),
				'price'      => $product->get_price(),
				'categories' => $this->get_product_categories( $product ),
			];
		}

		$this->send_event_to_ad_providers( 'purchase', $data, $this );
	}

	/**
	 * Get the product object.
	 * @param $product_id
	 * @param $variation_id
	 *
	 * @return false|WC_Product|null
	 */
	public function get_product($product_id = 0, $variation_id = 0) {
		if ( ! empty( $variation_id ) ) {
			$product = wc_get_product( $variation_id );
		} else {
			$product = wc_get_product( $product_id );
		}

		return $product;
	}

	/**
	 * Get checkout data specific to WooCommerce.
	 *
	 * @return array
	 */
	public function get_checkout_data() {
		if ( ! function_exists( 'wc_get_product' ) ) {
			return [];
		}

		$data = [
			'num_items' => WC()->cart->get_cart_contents_count(),
			'currency'  => $this->get_currency(),
			'total'     => WC()->cart->get_cart_contents_total(),
			'products'  => [],
		];

		$coupon = WC()->cart->get_applied_coupons();
		if ( ! empty( $coupon ) && ! empty( $coupon[0] ) ) {
			$data['coupon'] = $coupon[0];
		}

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			/**
			 * @var WC_Product $product
			 */
			$product = $cart_item['data'];

			$data['products'][] = [
				'id'         => $product->get_id(),
				'quantity'   => $cart_item['quantity'],
				'name'       => $product->get_name(),
				'discount'   => $cart_item['line_subtotal'] - $cart_item['line_total'],
				'price'      => $product->get_price(),
				'categories' => $this->get_product_categories( $product ),
			];
		}

		return $data;
	}

	/**
	 * Get the product categories.
	 *
	 * @param WC_Product $product The product to grab the categories from.
	 *
	 * @return array
	 */
	public function get_product_categories( $product ) {
		$product_categories = $product->get_category_ids();

		if ( empty( $product_categories ) ) {
			return [];
		}

		$categories = [];
		foreach ( $product_categories as $category_id ) {
			$category = get_term( $category_id );
			if ( ! empty( $category ) && ! is_wp_error( $category ) ) {
				$categories[] = $category->name;
			}
		}

		return $categories;
	}

	/**
	 * Get the WOO currency.
	 *
	 * @return string
	 */
	public function get_currency() {
		return get_woocommerce_currency();
	}

	/**
	 * @inheritdoc
	 */
	public function get_user_agent() {
		return wc_get_user_agent();
	}

	/**
	 * @inheritdoc
	 * @throws Exception
	 */
	public function get_server_user_data() {
		$data = [];

		if ( is_user_logged_in() ) {
			$customer           = new WC_Customer( get_current_user_id() );

			if ( empty( $customer ) || is_wp_error( $customer ) ) {
				return [];
			}

			$data['user_id']    = get_current_user_id();
			$data['email']      = $customer->get_billing_email();
			$data['city']       = $customer->get_billing_city();
			$data['state']      = $customer->get_billing_state();
			$data['country']    = $customer->get_billing_country();
			$data['zip']        = $customer->get_billing_postcode();
			$data['first_name'] = $customer->get_billing_first_name();
			$data['last_name']  = $customer->get_billing_last_name();
			$data['phone']      = $customer->get_billing_phone();
		}

		return $data;
	}

	/**
	 * @inheritDoc
	 */
	public function get_order_customer_info( $order_id ) {
		if ( empty( $this->order ) || ! $this->try_to_get_order() || ! method_exists($this->order, 'get_billing_email') ) {
			return [];
		}

		//  Order was loaded, or we were able to load just above.

		//  We need at least the email even if the user is not logged in (i.e. checked out as guest)
		$email = $this->order->get_billing_email();

		if ( empty( $email ) ) {
			return [];
		}

		$data = [
			'email'         => $email,
			'first_name'    => $this->order->get_billing_first_name(),
			'last_name'     => $this->order->get_billing_last_name(),
			'phone_number'  => $this->order->get_billing_phone(),
			'address'       => [
				'street'        => $this->order->get_billing_address_1(),
				'city'          => $this->order->get_billing_city(),
				'region'        => $this->order->get_billing_state(),
				'postal_code'   => $this->order->get_billing_postcode(),
				'country'       => $this->order->get_billing_country(),
			]
		];

		return $data;
	}
}
