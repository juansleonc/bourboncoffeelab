<?php
/**
 * Ads API Client class for MonsterInsights.
 *
 * @since 8.0.0
 *
 * @package MonsterInsights
 */

class MonsterInsights_API_Ads extends MonsterInsights_API_Client {
	
	/**
	 * Get common request parameters.
	 * @deprecated
	 * @return array
	 */
	private function get_auth_params() {
		$params = array(
			'token'     => $this->token,
			'key'       => $this->key,
			'miversion' => $this->miversion,
			'site_url'  => $this->site_url,
		);
		
		if ( ! empty( $this->license ) ) {
			$params['license'] = $this->license;
		}
		
		return $params;
	}
	
	/**
	 * Get the access token for the Google Ads API.
	 *
	 * @return string|WP_Error The access token or a WP_Error if there was an error.
	 */
	public function get_access_token() {
		$params = $this->get_auth_params();
		return $this->request( 'google-ads/token', $params, 'GET');
	}

	/**
	 * Get conversions for a Google Ads customer.
	 *
	 * @param string $customer_id The Google Ads customer ID.
	 * @param string $campaign_id The Google Ads campaign ID.
	 *
	 * @return array|WP_Error The conversions data or a WP_Error if there was an error.
	 */
	public function get_conversions( $customer_id, $campaign_id ) {
		return $this->request( 'google-ads/conversions', array(
			'customer_id' => $customer_id,
			'campaign_id' => $campaign_id,
		), 'GET' );
	}
}
