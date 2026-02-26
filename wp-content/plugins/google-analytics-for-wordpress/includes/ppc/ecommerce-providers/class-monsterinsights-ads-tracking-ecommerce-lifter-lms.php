<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * MonsterInsights PPC Tracking - LifterLMS tracking class.
 *
 * @access public
 * @since 9.7.0
 *
 * @package MonsterInsights_PPC_Tracking
 * @subpackage Ecommerce_Providers
 * @author  David Paternina
 */

class MonsterInsights_Ads_Tracking_Ecommerce_Lifter_LMS extends MonsterInsights_Ads_Tracking_Ecommerce_Tracking
{
	/**
	 * LifterLMS order
	 *
	 * @var $order LLMS_Order
	 */
	protected $order;

	public function add_server_hooks() {
		add_action( 'lifterlms_after_checkout_form', [$this, 'server_event_begin_checkout'] );
		add_action( 'lifterlms_new_pending_order', [$this, 'on_order_saved'] );
		add_action( 'lifterlms_transaction_status_succeeded', [$this, 'server_event_purchase'] );
	}

	/**
	 * @inheritdoc
	 */
	public function do_conversion_checks() {
		global $wp;
		return is_llms_account_page() && !empty( $wp->query_vars['orders'] );
	}

	/**
	 * @inheritdoc
	 */
	public function is_active() {
		return function_exists( 'LLMS' ) &&
			version_compare( LLMS()->version, '3.32.0', '>=' ) &&
			apply_filters( 'monsterinsights_ppc_tracking_track_conversion_lifterlms', true );
	}

	/**
	 * @inheritdoc
	 */
	public function try_to_get_order() {

		global $wp;

		$order_id = $wp->query_vars['orders'];

		if ( empty( $order_id ) ) {
			return false;
		}

		$this->order = new LLMS_Order( $order_id );
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function get_order_total() {
		return empty( $this->order ) ? null : $this->order->total;
	}

	/**
	 * @inheritDoc
	 */
	public function get_order_currency() {
		return empty( $this->order ) ? null : $this->order->currency;
	}

	/**
	 * @inheritDoc
	 */
	public function get_order_number() {
		return empty( $this->order ) ? null : $this->order->id;
	}

	/**
	 * @inheritDoc
	 */
	public function already_tracked_frontend( $provider_id ) {
		if ( empty( $this->order ) ) {
			return true;
		}

		$tracked = get_post_meta( $this->order->id, "_monsterinsights_ppc_tracking_conversion_tracked_{$provider_id}", true );

		return ! empty( $tracked ) && 'yes' === $tracked;
	}

	/**
	 * @inheritDoc
	 */
	public function mark_order_tracked_frontend( $provider_id ) {
		if ( empty( $this->order ) ) {
			return;
		}

		update_post_meta( $this->order->id, "_monsterinsights_ppc_tracking_conversion_tracked_{$provider_id}", 'yes' );
	}

	/**
	 * @inheritdoc
	 */
	public function get_name() {
		return 'LifterLMS';
	}

	/**
	 * Send the begin_checkout event to the ad providers
	 * @return void
	 */
	public function server_event_begin_checkout() {

		if ( ! function_exists( 'llms_filter_input' ) ) {
			return;
		}

		// "Cart" is empty.
		$plan_id = llms_filter_input( INPUT_GET, 'plan', FILTER_SANITIZE_NUMBER_INT );
		if ( ! $plan_id ) {
			return;
		}

		// Invalid Access Plan.
		$plan = llms_get_post( $plan_id );
		if ( ! $plan ) {
			return;
		}

		$data = $this->get_checkout_data( $plan );

		$user_data = [
			'user_ip'    => $this->get_user_ip(),
			'user_agent' => $this->get_user_agent()
		];

		$data = array_merge( $data, $user_data );
		$data = array_merge( $data, $this->get_server_user_data() );

		$this->send_event_to_ad_providers( 'begin_checkout', $data, $this );
	}

	/**
	 * @param LLMS_Transaction $transaction
	 *
	 * @return void
	 */
	public function server_event_purchase( $transaction ) {
		$order    = $transaction->get_order();
		$order_id = $order->get( 'id' );

		// Build purchase event data from order.
		$data = [
			'order_id'   => $order_id,
			'num_items'  => 1,
			'currency'   => $order->currency,
			'total'      => $order->total,
			'products'   => [],
			'user_id'    => $order->user_id,
			'user_ip'    => $order->user_ip_address,
			'phone'      => $order->billing_phone,
			'email'      => $order->billing_email,
			'zip'        => $order->billing_zip,
			'city'       => $order->billing_city,
			'state'      => $order->billing_state,
			'country'    => $order->billing_country,
			'user_agent' => $this->get_order_meta( $order_id, '_monsterinsights_ppc_tracking_user_agent' ),
			'first_name' => $order->billing_first_name,
			'last_name'  => $order->billing_first_name,
		];

		$this->send_event_to_ad_providers( 'purchase', $data, $this );
	}

	/**
	 *
	 * @param $order
	 *
	 * @return void
	 */
	public function on_order_saved($order) {
		$order_id = $order->get( 'id' );
		$this->server_order_saved( $order_id );
	}

	/**
	 * Get the checkout data for the given plan
	 * @param $plan
	 *
	 * @return array
	 */
	private function get_checkout_data( $plan ) {
		$plan       = is_numeric( $plan ) ? llms_get_post( $plan ) : $plan;
		$product_id = $plan->get( 'product_id' );

		if ( $plan->is_free() ) {
			$price = 0;
		} else {
			$price_key = 'price';
			if ( $plan->has_trial() ) {
				$price_key = 'trial_price';
			} else if ( $plan->is_on_sale() ) {
				$price_key = 'sale_price';
			}

			$price = $plan->get( $price_key );
		}

		$data = [
			'num_items' => 1,
			'currency'  => $this->get_currency(),
			'total'     => $price,
			'products'  => [
				[
					'id'       => $product_id,
					'name'     => get_the_title( $product_id ),
					'category' => $this->get_product_category( $product_id ),
					'price'    => $price,
					'quantity' => 1,
					'position' => 1,
				]
			],
		];

		return $data;
	}

	/**
	 * @inheritDoc
	 */
	public function get_product( $product_id ) {
		return llms_get_product( $product_id );
	}

	/**
	 * Retrieve the first category term for a given product
	 *
	 * @param int $product_id WP_Post ID.
	 *
	 * @return string
	 * @since [version]
	 */
	protected function get_product_category( $product_id ) {

		$cat = '';

		$tax = $this->get_product_category_tax( $product_id );
		if ( $tax ) {
			$terms = (array) get_the_terms( $product_id, $tax );
			$terms = wp_list_pluck( $terms, 'name' );
			if ( $terms ) {
				$cat = $terms[0];
			}
		}

		return $cat;
	}

	/**
	 * Get Taxonomy name for a given product.
	 *
	 * @param int $product_id WP_Post ID.
	 *
	 * @return string|false
	 * @since [version]
	 */
	protected function get_product_category_tax( $product_id ) {

		$post_type = get_post_type( $product_id );
		if ( 'course' === $post_type ) {
			return 'course_cat';
		} else if ( 'llms_membership' === $post_type ) {
			return 'membership_cat';
		}

		return false;
	}

	/**
	 * @inheritDoc
	 */
	public function get_currency() {
		return get_lifterlms_currency();
	}

	/**
	 * @inheritDoc
	 */
	function get_order_customer_info( $order_id ) {
		if ( empty( $this->order ) && !$this->try_to_get_order() ) {
			return [];
		}

		//  Order was loaded, or we were able to load just above.

		//  We need at least the email even if the user is not logged in (i.e. checked out as guest)
		$email = $this->order->billing_email;

		if ( empty( $email ) ) {
			return [];
		}

		$data = [
			'email'         => $email,
			'first_name'    => $this->order->billing_first_name,
			'last_name'     => $this->order->billing_last_name,
			'phone_number'  => $this->order->billing_phone,
			'address'       => [
				'street'        => $this->order->billing_address_1,
				'city'          => $this->order->billing_city,
				'region'        => $this->order->billing_state,
				'postal_code'   => $this->order->billing_zip,
				'country'       => $this->order->billing_country
			]
		];

		return $data;
	}
}
