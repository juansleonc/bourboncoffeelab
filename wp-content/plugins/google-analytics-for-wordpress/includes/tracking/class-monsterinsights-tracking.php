<?php

/**
 * Main handler for MonsterInsights' tracking.
 *
 * This class is responsible for sending tracking events to the MonsterInsights API.
 * It handles event creation, data population, and communication with the API.
 * It also manages a database table for storing and retrying events that fail to send.
 */
class MonsterInsights_Tracking {

	/**
	 * Option name for tracking table version.
	 *
	 * @var string
	 */
	const TABLE_VERSION_OPTION = 'monsterinsights_tracking_events_table_version';

	/**
	 * Current table schema version.
	 *
	 * Increment this value when the table schema changes to trigger a schema update.
	 *
	 * @var string
	 */
	const TABLE_VERSION = '1.0';

	/**
	 * Tracking API class instance.
	 *
	 * @var MonsterInsights_API_Tracking
	 */
	private $api;

	/**
	 * MonsterInsights Tracking singleton instance.
	 *
	 * @var MonsterInsights_Tracking
	 */
	private static $instance;

	/**
	 * Flag to track if table existence has been verified during current request.
	 *
	 * This prevents multiple option lookups within the same request.
	 *
	 * @var bool
	 */
	private static $table_verified = false;
	
	/**
	 * MonsterInsights_Tracking constructor.
	 */
	public function __construct() {
		$this->api = new MonsterInsights_API_Tracking();
	}

	/**
	 * Ensures the tracking events database table exists.
	 *
	 * This method uses a multi-layer caching strategy for performance:
	 * 1. Static property check (instant, per-request)
	 * 2. WordPress option check (fast, autoloaded)
	 * 3. Schema creation only when needed
	 *
	 * The option stores a version number, allowing for future schema migrations
	 * by incrementing the TABLE_VERSION constant.
	 *
	 * @return void
	 */
	public static function maybe_create_table() {
		// Layer 1: Static property check - fastest, prevents multiple checks per request.
		if ( self::$table_verified ) {
			return;
		}

		// Layer 2: Check stored table version option.
		// This option is autoloaded by default, making it very fast to retrieve.
		$stored_version = get_option( self::TABLE_VERSION_OPTION );

		if ( self::TABLE_VERSION === $stored_version ) {
			// Table exists with correct version, mark as verified for this request.
			self::$table_verified = true;
			return;
		}

		// Layer 3: Table needs to be created or updated.
		self::setup_tracking_schema();

		// Store the current version to prevent future checks.
		update_option( self::TABLE_VERSION_OPTION, self::TABLE_VERSION, true );

		self::$table_verified = true;
	}
	
	/**
	 * Sends an event to the API.
	 *
	 *
	 * @param string $event_name The name of the event to send.
	 * @param array  $payload    Optional. The event payload data.
	 * @param array  $extra      Optional. Extra parameters to include with the event.
	 *
	 * @return array|WP_Error|MonsterInsights_API_Error Returns the API response on success, or a WP_Error/MonsterInsights_API_Error on failure.
	 */
	public function send($event_name, array $payload = [], array $extra = []) {
		
		if ( !MonsterInsights()->auth->is_authed() && !MonsterInsights()->auth->is_network_authed() ) {
			return new WP_Error('401', __('MonsterInsights is not connected.', 'google-analytics-for-wordpress'));
		}
		
		$extra_params = [];
		
		$extra_params = array_merge(
			$extra_params,
			$extra
		);
		
		$sent_event = new MonsterInsights_Tracking_Event($event_name, $payload);
		
		$client_id = $extra_params['client_id'] ?? null;
		
		if ( empty( $client_id ) ) {
			$payment_id = $payload['transaction_id'] ?? null;
			$client_id = $payment_id ?? monsterinsights_get_client_id( $payment_id );
		}
		
		if ( !empty($client_id) ) {
			$extra_params['client_id'] = $client_id;
		}
		
		$result = $this->api->track_events(
			[$sent_event],
			$extra_params
		);

		// Handle WP_Error (network failures, timeouts, etc.)
		if ( is_wp_error( $result ) ) {
			$sent_event->update_error( [
				'error'     => $result->get_error_message(),
				'details'   => $result->get_error_data(),
			] );
			return $result;
		}

		// Handle MonsterInsights API errors
		if ( $result instanceof MonsterInsights_API_Error ) {
			$error_data = $result->get_error_data();
			$sent_event->update_error( $error_data['body'] );
			return $result;
		}

		$data = $result['data'];
		
		$events_submitted = $data['events_submitted'];
		$tracking_errors = $data['tracking_errors'];
		
		if ( in_array( $sent_event->get_id(), $events_submitted ) ) {
			// Delete tracked event from DB
			$sent_event->delete();
		} else {
			// Try to find error for the specific event
			$found_errors = array_filter( $tracking_errors, function( $e ) use ( $sent_event ) {
				return $e['client_event_id'] === $sent_event->get_id();
			});
			
			if ( !empty($found_errors) ) {
				// Grab first one
				$sent_event->update_error($found_errors[0]);
			}
		}
		
		return $result;
	}
	
	/**
	 * Get MonsterInsights' Tracking singleton
	 * @return MonsterInsights_Tracking
	 */
	public static function get_instance(): MonsterInsights_Tracking {
		if ( !empty( self::$instance ) ) {
			return self::$instance;
		}
		
		self::$instance = new self;
		return self::$instance;
	}
	
	/**
	 * Get DB table name for the tracking events
	 * @return string
	 */
	public static function get_db_table_name() {
		global $wpdb;
		return $wpdb->prefix . 'monsterinsights_tracking_events';
	}
	
	/**
	 * Set up the tracking_events db table.
	 * @return void
	 */
	public static function setup_tracking_schema() {
		global $wpdb;
		
		$table_name      = self::get_db_table_name();
		$charset_collate = $wpdb->get_charset_collate();
		
		$sql = "CREATE TABLE $table_name (
	        id mediumint(9) NOT NULL AUTO_INCREMENT,
	        name tinytext NOT NULL,
	        status tinytext NOT NULL,
	        payload text,
	        extra_data text,
	        attempts tinyint DEFAULT 0 NOT NULL,
	        last_error text,
	        created_at datetime DEFAULT NOW() NOT NULL,
	        PRIMARY KEY  (id)
	    ) $charset_collate;";
		
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta($sql);
	}
}

if ( !function_exists('monsterinsights_tracking') ) {
	
	/**
	 * Get the MonsterInsights tracking singleton
	 * @return MonsterInsights_Tracking
	 */
	function monsterinsights_tracking(): MonsterInsights_Tracking {
		return MonsterInsights_Tracking::get_instance();
	}
}