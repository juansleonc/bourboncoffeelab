<?php
/**
 * Represents a single tracking event.
 *
 * This class encapsulates the data for a tracking event, manages its state (pending, retry, failed),
 * and handles its persistence in the database.
 */
class MonsterInsights_Tracking_Event implements JsonSerializable {
	
	/**
	 * Pending event, not sent to API yet.
	 */
	const STATUS_PENDING = 'pending';
	
	/**
	 * The event failed at least once, it's currently being retried.
	 */
	const STATUS_RETRY = 'retry';
	
	/**
	 * The event failed after multiple retries.
	 */
	const STATUS_FAILED = 'failed';
	
	/**
	 * Event's unique ID from the database.
	 *
	 * @var int|null
	 */
	private $id = null;
	
	/**
	 * Event Name.
	 *
	 * @var string
	 */
	private $name;
	
	/**
	 * Event status (e.g., pending, retry, failed).
	 *
	 * @var string
	 */
	private $status;
	
	/**
	 * Event payload data.
	 *
	 * @var array
	 */
	private $payload;
	
	/**
	 * Event-related extra data.
	 *
	 * @var array
	 */
	private $extra_data;
	
	/**
	 * Number of times sending this event has been attempted.
	 *
	 * @var int
	 */
	private $attempts = 0;
	
	/**
	 * The last registered error message for the event.
	 *
	 * @var string|null
	 */
	private $last_error = null;
	
	/**
	 * Event creation timestamp (YYYY-MM-DD HH:MI:SS).
	 *
	 * @var string
	 */
	private $created_at;
	
	/**
	 * Creates a new Tracking event and saves it to the database.
	 *
	 * Use this sparingly, as it automatically saves the event in the database upon instantiation.
	 * Event properties like name and payload are final after creation to ensure data integrity.
	 * Events should only be created when they are ready to be sent.
	 *
	 * The payload can be tweaked before being saved to the DB using the `monsterinsights_tracking_event_payload` filter.
	 *
	 * @param string $name       The name of the event.
	 * @param array  $payload    Optional. The payload for the event.
	 * @param array  $extra_data Optional. Extra data associated with the event.
	 */
	public function __construct($name, $payload = [], $extra_data = []) {
		$this->name = $name;
		$this->status = self::STATUS_PENDING;
		$this->payload = $payload;
		$this->extra_data = $extra_data;
		$this->created_at = date( 'Y-m-d H:i:s' ); // phpcs:ignore
		
		$this->save();
	}
	
	/**
	 * Save the event to DB for processing
	 * @return void
	 */
	private function save() {

		// We need at very least the name.
		if ( empty( $this->name ) ) {
			return;
		}

		// Ensure table exists before any DB operations.
		// This is a performant check using static + option caching.
		MonsterInsights_Tracking::maybe_create_table();

		global $wpdb;
		$table_name = MonsterInsights_Tracking::get_db_table_name();
		
		$data = [
			'name'          => $this->name,
			'status'        => $this->status,
			'payload'       => serialize( apply_filters( 'monsterinsights_tracking_event_payload', $this->payload, $this->name ) ),
			'extra_data'    => serialize( apply_filters( 'monsterinsights_tracking_event_extra_data', $this->extra_data, $this->name ) ),
			'attempts'      => $this->attempts,
			'last_error'    => $this->last_error,
			'created_at'    => $this->created_at,
		];
		
		if ( !$this->exists_in_db() ) {
			$wpdb->insert( $table_name, $data );
			$this->id = $wpdb->insert_id;
		} else {
			$wpdb->update( $table_name, $data, array( 'id' => $this->id ) );
		}
	}
	
	/**
	 * Get the id of the event
	 * @return int|null
	 */
	public function get_id() {
		return $this->id;
	}
	
	/**
	 * Updates the last error for the event and saves it.
	 *
	 * @param mixed $error            The error to be serialized and stored.
	 * @param bool  $increaseAttempts Optional. Whether to increment the attempts counter. Defaults to true.
	 *
	 * @return void
	 */
	public function update_error( $error, $increaseAttempts = true ) {
		$this->last_error = serialize($error);
		
		if ( $increaseAttempts ) {
			$this->attempts ++;
		}
		
		$this->save();
	}
	
	/**
	 * Delete event from DB. Should be called after being tracked successfully
	 *
	 * @return void
	 */
	public function delete() {
		// Ensure table exists before any DB operations.
		// This is a performant check using static + option caching.
		MonsterInsights_Tracking::maybe_create_table();

		global $wpdb;
		$table_name = MonsterInsights_Tracking::get_db_table_name();
		$wpdb->delete( $table_name, array( 'id' => $this->id ) );
	}
	
	/**
	 * Whether the event is saved in DB
	 * @return bool
	 */
	public function exists_in_db() {
		return null !== $this->id;
	}
	
	/**
	 * @inheritdoc
	 */
	#[\ReturnTypeWillChange]
	public function jsonSerialize() {
		$json = [
			'client_event_id'   => $this->id,
			'event_name'        => $this->name,
			'timestamp'         => strtotime( $this->created_at ),
			'payload'           => $this->payload,
		];
		
		return array_merge( $json, $this->extra_data );
	}
}