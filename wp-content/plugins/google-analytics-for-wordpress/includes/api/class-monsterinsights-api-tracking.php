<?php
/**
 * Tracking API Client class for MonsterInsights.
 *
 * This class is responsible for sending tracking events to the MonsterInsights API.
 * It extends the MonsterInsights_API_Client to handle the actual requests.
 *
 * @package MonsterInsights
 */
class MonsterInsights_API_Tracking extends MonsterInsights_API_Client {

	/**
	 * Send multiple events (batched) to the API.
	 *
	 * This method takes an array of tracking events and sends them to the tracking endpoint.
	 * It also supports sending additional data, such as user information.
	 *
	 *
	 * @param MonsterInsights_Tracking_Event[] $events An array of event objects to be tracked.
	 * @param array                            $extra {
	 *     Optional. Extra data to send with the request.
	 *
	 *     @type array $user_data Optional. User-specific data.
	 * }
	 *
	 * @return array|MonsterInsights_API_Error The API response or an error object.
	 */
	public function track_events( array $events, array $extra = [] ) {

		// Handle user data if present
		$user_data = $extra['user_data'] ?? [];
		unset( $extra['user_data'] );

		$body = [
			'events'    => $events,
		];

		if ( !empty( $user_data ) ) {
			$body['user_data'] = $user_data;
		}

		$body = array_merge( $body, $extra );

		return $this->request('tracking', $body);
	}
}