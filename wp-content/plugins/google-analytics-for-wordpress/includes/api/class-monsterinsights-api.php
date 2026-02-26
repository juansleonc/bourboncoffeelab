<?php
/**
 * Base API Client class for MonsterInsights.
 *
 * This abstract class provides the foundational structure for making API requests
 * to the MonsterInsights service. It handles authentication, request setup,
 * and response processing.
 *
 * @package MonsterInsights
 */
abstract class MonsterInsights_API_Client {
	/**
	 * Base URL for the MonsterInsights API.
	 *
	 * @var string
	 */
	protected $base_url = 'https://app.monsterinsights.com/api/v3';

	/**
	 * The site-specific token for API authentication.
	 *
	 * @var string
	 */
	protected $token;

	/**
	 * The site-specific key for API authentication.
	 *
	 * @var string
	 */
	protected $key;

	/**
	 * The license key for premium features.
	 *
	 * @var string
	 */
	protected $license;

	/**
	 * The URL of the WordPress site.
	 *
	 * @var string
	 */
	protected $site_url;

	/**
	 * The current version of the MonsterInsights plugin.
	 *
	 * @var string
	 */
	protected $miversion;

	/**
	 * Constructor.
	 *
	 * Initializes the API client by setting up the necessary authentication
	 * and site information.
	 *
	 */
	public function __construct() {
		$this->token     = $this->get_token();
		$this->key       = $this->get_key();
		$this->license   = $this->get_license();
		$this->site_url  = $this->get_site_url();
		$this->miversion = MONSTERINSIGHTS_VERSION;
	}

	/**
	 * Get the Site token for API authentication.
	 *
	 * Retrieves the token for the current site or network.
	 *
	 * @return string The site or network token.
	 */
	protected function get_token() {
		return is_network_admin() ? MonsterInsights()->auth->get_network_token() : MonsterInsights()->auth->get_token();
	}

	/**
	 * Get the Site key for API authentication.
	 *
	 * Retrieves the key for the current site or network.
	 *
	 * @return string The site or network key.
	 */
	protected function get_key() {
		return is_network_admin() ? MonsterInsights()->auth->get_network_key() : MonsterInsights()->auth->get_key();
	}

	/**
	 * Get the license key for the plugin.
	 *
	 * Retrieves the license key for Pro versions of the plugin.
	 *
	 * @return string The site or network license key, or an empty string for Lite version.
	 */
	protected function get_license() {
		if ( ! monsterinsights_is_pro_version() ) {
			return '';
		}

		return is_network_admin() ? MonsterInsights()->license->get_network_license_key() : MonsterInsights()->license->get_site_license_key();
	}

	/**
	 * Get the site URL.
	 *
	 * Returns the appropriate admin URL based on whether it's a network or single site.
	 *
	 * @return string The site URL.
	 */
	protected function get_site_url() {
		return is_network_admin() ? network_admin_url() : home_url();
	}

	/**
	 * Get the base URL for the API.
	 *
	 * This can be filtered to allow for different API endpoints.
	 *
	 * @return string The base URL for API requests.
	 */
	protected function get_base_url() {
		return trailingslashit(
			apply_filters( 'monsterinsights_api_url', $this->base_url )
		);
	}

	/**
	 * Make an API request.
	 *
	 * This method sends a request to the specified API endpoint and handles the response.
	 *
	 *
	 * @param string $endpoint The API endpoint to call.
	 * @param array  $params   The parameters to send with the request.
	 * @param string $method   The HTTP method to use (e.g., 'POST', 'GET').
	 *
	 * @return array|MonsterInsights_API_Error|WP_Error The decoded JSON response as an array,
	 *                                                  or a WP_Error/MonsterInsights_API_Error on failure.
	 */
	protected function request( $endpoint, $params = array(), $method = 'POST' ) {
		$url = $this->get_base_url() . $endpoint;

		$args = array(
			'method'      => $method,
			'timeout'     => 3,
			'redirection' => 5,
			'httpversion' => '1.1',
			'blocking'    => true,
			'headers'     => array(
				'Content-Type'  => 'application/json',
				'Accept'        => 'application/json',
				'MIAPI-Sender'  => 'WordPress',
				'MIAPI-Referer' => $this->site_url,
				// Authentication headers
				'X-Relay-Site-Key'  => $this->key,
				'X-Relay-Token'     => $this->token,
				'X-Relay-Site-Url'  => $this->site_url,
				'X-Relay-License'   => $this->license
			),
			
			'cookies'     => array(),
		);
		
		if ( $method === 'GET' ) {
			$url = add_query_arg($params, $url);
		} else {
			$args['body'] = json_encode($params);
		}

		$response = wp_remote_request( $url, $args );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$response_code = wp_remote_retrieve_response_code( $response );
		$response_body = wp_remote_retrieve_body( $response );
		$decoded_body  = json_decode( $response_body, true );

		// Accept any 2xx code as success
		if ( $response_code >= 200 && $response_code < 300 ) {
			return $decoded_body;
		}

		// If the response is not valid JSON or doesn't have an error structure, create a generic error array
		if ( ! is_array( $decoded_body ) || ! isset( $decoded_body['error'] ) ) {
			$decoded_body = array(
				'error' => array(
					'code'    => 'monsterinsights_api_unexpected_response',
					'message' => 'Unexpected API response.',
					'details' => array(
						'code'     => $response_code,
						'body'     => $response_body,
						'endpoint' => $endpoint,
					),
				),
			);
		}

		return new MonsterInsights_API_Error( $decoded_body );
	}
}