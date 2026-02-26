<?php

class MonsterInsights_Google_Ads_Pax extends MonsterInsights_Ads_Tracking_Provider {

	/**
	 * The instance of the class.
	 */
	private static $instance;

	/**
	 * The conversion tracking id.
	 */
	protected $conversionTrackingId;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		
		// Little sanity check to make sure the class is loaded.
		if ( !class_exists('MonsterInsights_Google_Ads') ) {
			require_once MONSTERINSIGHTS_PLUGIN_DIR . 'includes/ppc/google/class-monsterinsights-google-ads.php';
		}

		if ( !$this->is_google_ads_enabled() ) {
			return;
		}
		
		$this->conversionTrackingId = MonsterInsights_Google_Ads::get_settings('conversion_tracking_id');
		
		parent::__construct();
	}

	/**
	 * Get instance
	 *
	 * @return MonsterInsights_Google_Ads_Pax
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Insert conversion code
	 */
	public function insert_conversion_code() {
		printf(
			"\t\t__gtagTracker( 'config', '%s' );\n",
			esc_js($this->conversionTrackingId)
		);
	}

	/**
	 * Check if Google Ads is enabled
	 *
	 * @return bool
	 */
	public function is_google_ads_enabled() {
		$settings = MonsterInsights_Google_Ads::get_settings();
		
		if ( ! $settings ) {
			return false;
		}

		if ( empty($settings['conversion_tracking_id']) ) {
			return false;
		}

		return true;
	}
	
	/**
	 * @inheritdoc
	 */
	public function is_active() {
		return $this->is_google_ads_enabled();
	}
	
	/**
	 * @inheritdoc
	 */
	public function get_tracking_id() {
		return $this->conversionTrackingId;
	}
	
	/**
	 * @inheritdoc
	 */
	public function get_api_token() {
		return null;
	}
	
	/**
	 * @inheritdoc
	 */
	public function get_provider_id() {
		return 'google_pax';
	}
	
	/**
	 * @inheritdoc
	 */
	protected function add_frontend_hooks() {
		//  Inject conversion id
		add_action( 'monsterinsights_frontend_tracking_gtag_after_pageview', [$this, 'insert_conversion_code'] );
	}
	
	/**
	 * @inheritdoc
	 */
	protected function init_server_handler() {
		return null;
	}
	
	/**
	 * @inheritdoc
	 */
	public function maybe_print_conversion_code( $conversion_data, $customer_info = [] ) {
		
		//  Conversions require both conversion id and label
		if ( empty( $this->conversionTrackingId ) ) {
			return false;
		}
		
		$data_for_google = [
			'send_to'           => $this->conversionTrackingId,
			'value'             => $conversion_data['order_total'],
			'currency'          => $conversion_data['currency'],
			'transaction_id'    => $conversion_data['order_id'],
		];
		
		printf(
			"\n\t\t__gtagTracker( 'event', 'purchase', %s );\n",
			json_encode( $data_for_google, JSON_UNESCAPED_SLASHES ) // phpcs:ignore WordPress.WP.AlternativeFunctions.json_encode_json_encode -- We need to use json_encode here to avoid double escaping
		);
		
		return true;
	}
}
