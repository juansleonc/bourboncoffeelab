<?php

class UserFeedback_Connect {


	public function __construct() {
		 add_action( 'wp_ajax_userfeedback_connect_url', array( $this, 'generate_connect_url' ) );
		add_action( 'wp_ajax_nopriv_userfeedback_connect_process', array( $this, 'process' ) );
	}

	/**
	 * Generates and returns UserFeedback connect URL
	 */
	public function generate_connect_url() {
		check_ajax_referer( 'uf-admin-nonce', 'nonce' );
		$post_data = sanitize_post( $_POST, 'raw' );
		// Check for permissions.
		if ( ! userfeedback_can_install_plugins() ) {
			wp_send_json_error( array( 'message' => esc_html__( 'You are not allowed to install plugins.', 'userfeedback-lite' ) ) );
		}

		if ( userfeedback_is_dev_url( home_url() ) ) {
			wp_send_json_success(
				array(
					'url' => 'https://www.userfeedback.com/docs/go-lite-pro/#manual-upgrade',
				)
			);
		}

		$key = ! empty( $post_data['key'] ) ? sanitize_text_field( wp_unslash( $post_data['key'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification

		if ( empty( $key ) ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Please enter your license key to connect.', 'userfeedback-lite' ),
				)
			);
		}

		// Verify pro version is not installed.
		$active = activate_plugin( 'userfeedback/userfeedback-premium.php', false, false, true );
		if ( ! is_wp_error( $active ) ) {
			// Deactivate plugin.
			deactivate_plugins( plugin_basename( USERFEEDBACK_PLUGIN_FILE ), false, false );
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Pro version is already installed.', 'userfeedback-lite' ),
					'reload'  => true,
				)
			);
		}

		// Network?
		$network = ! empty( $post_data['network'] ) && $post_data['network'];

		// Redirect.
		$oth = hash( 'sha512', wp_rand() );
		update_option(
			'userfeedback_connect',
			array(
				'key'     => $key,
				'time'    => time(),
				'network' => $network,
			)
		);
		update_option( 'userfeedback_connect_token', $oth );
		$version  = UserFeedback()->version;
		$siteurl  = admin_url();
		$endpoint = admin_url( 'admin-ajax.php' );
		$redirect = admin_url( 'admin.php?page=userfeedback_settings' );

		$url = add_query_arg(
			array(
				'key'      => $key,
				'oth'      => $oth,
				'endpoint' => $endpoint,
				'version'  => $version,
				'siteurl'  => $siteurl,
				'homeurl'  => home_url(),
				'redirect' => rawurldecode( base64_encode( $redirect ) ),
				'v'        => 2,
			),
			'https://upgrade.userfeedback.com'
		);

		wp_send_json_success(
			array(
				'url' => $url,
			)
		);
	}

	/**
	 * Process UserFeedback Connect.
	 */
	public function process() {
		 $error       = esc_html__( 'Could not install upgrade. Please download from userfeedback.com and install manually.', 'userfeedback-lite' );
		$request_data = sanitize_post( $_REQUEST, 'raw' );
		// verify params present (oth & download link).
		$post_oth = ! empty( $request_data['oth'] ) ? sanitize_text_field( $request_data['oth'] ) : '';
		$post_url = ! empty( $request_data['file'] ) ? esc_url_raw( $request_data['file'] ) : '';
		$license  = get_option( 'userfeedback_connect', false );
		$network  = ! empty( $license['network'] ) ? (bool) $license['network'] : false;
		if ( empty( $post_oth ) || empty( $post_url ) ) {
			wp_send_json_error( $error );
		}
		// Verify oth.
		$oth = get_option( 'userfeedback_connect_token' );
		if ( empty( $oth ) ) {
			wp_send_json_error( $error );
		}
		if ( ! hash_equals( $oth, $post_oth ) ) {
			wp_send_json_error( $error );
		}
		// Delete so cannot replay.
		delete_option( 'userfeedback_connect_token' );

		// Set the current screen to avoid undefined notices.
		set_current_screen( 'toplevel_page_userfeedback_surveys' );
		// Prepare variables.
		$url = esc_url_raw(
			add_query_arg(
				array(
					'page' => 'userfeedback-settings',
				),
				admin_url( 'admin.php' )
			)
		);
		// Verify pro not activated.
		if ( userfeedback_is_pro_version() ) {
			wp_send_json_success( esc_html__( 'Plugin installed & activated.', 'userfeedback-lite' ) );
		}
		// Verify pro not installed.
		$active = activate_plugin( 'userfeedback/userfeedback-premium.php', $url, $network, true );
		if ( ! is_wp_error( $active ) ) {
			deactivate_plugins( plugin_basename( USERFEEDBACK_PLUGIN_FILE ), false, $network );
			wp_send_json_success( esc_html__( 'Plugin installed & activated.', 'userfeedback-lite' ) );
		}
		$creds = request_filesystem_credentials( $url, '', false, false, null );
		// Check for file system permissions.
		if ( false === $creds ) {
			wp_send_json_error( $error );
		}
		if ( ! WP_Filesystem( $creds ) ) {
			wp_send_json_error( $error );
		}
		// We do not need any extra credentials if we have gotten this far, so let's install the plugin.
		userfeedback_require_upgrader();
		// Do not allow WordPress to search/download translations, as this will break JS output.
		remove_action( 'upgrader_process_complete', array( 'Language_Pack_Upgrader', 'async_upgrade' ), 20 );
		// Create the plugin upgrader with our custom skin.
		$installer = new UserFeedback_Plugin_Upgrader( new UserFeedback_Skin() );
		// Error check.
		if ( ! method_exists( $installer, 'install' ) ) {
			wp_send_json_error( $error );
		}

		// Check license key.
		if ( empty( $license['key'] ) ) {
			wp_send_json_error( new WP_Error( '403', esc_html__( 'You are not licensed.', 'userfeedback-lite' ) ) );
		}

		$installer->install($post_url); // phpcs:ignore
		// Flush the cache and return the newly installed plugin basename.
		wp_cache_flush();

		if ( $installer->plugin_info() ) {
			$plugin_basename = $installer->plugin_info();

			// Deactivate the lite version first.
			deactivate_plugins( plugin_basename( USERFEEDBACK_PLUGIN_FILE ), false, $network );

			// Activate the plugin silently.
			$activated = activate_plugin( $plugin_basename, '', $network, true );
			if ( ! is_wp_error( $activated ) ) {
				$this->verify_key( $license['key'] );
				// Pro upgrade successful.
				$over_time = get_option( 'userfeedback_over_time', array() );

				if ( empty( $over_time['installed_pro'] ) ) {
					$over_time['installed_pro'] = time();
					update_option( 'userfeedback_over_time', $over_time );
				}

				wp_send_json_success( esc_html__( 'Plugin installed & activated.', 'userfeedback-lite' ) );
			} else {
				// Reactivate the lite plugin if pro activation failed.
				activate_plugin( plugin_basename( USERFEEDBACK_PLUGIN_FILE ), '', $network, true );
				wp_send_json_error( esc_html__( 'Pro version installed but needs to be activated from the Plugins page inside your WordPress admin.', 'userfeedback-lite' ) );
			}
		}
		wp_send_json_error( $error );
	}

	private function verify_key( $key ) {
		// Perform a request to verify the key.
		$verify = $this->verify_license_remote_request( 'verify-key', $key );

		// If it returns false, send back a generic error message and return.
		if ( ! $verify ) {
			return false;
		}

		// If an error is returned, set the error and return.
		if ( ! empty( $verify->error ) ) {
			return false;
		}

		// Otherwise, our request has been done successfully. Update the option and set the success message.
		$option                = UserFeedback()->license->get_site_license();
		$option['key']         = trim( $key );
		$option['type']        = isset( $verify->type ) ? $verify->type : $option['type'];
		$option['is_expired']  = false;
		$option['is_disabled'] = false;
		$option['is_invalid']  = false;
		
		UserFeedback()->license->set_site_license( $option );
		delete_transient( '_userfeedback_addons' );
		wp_clean_plugins_cache( true );
	}

	private function verify_license_remote_request( $action, $key ) {
		// Build the body of the request.
		$body = wp_parse_args(
			array(
				'tgm-updater-action'     => $action,
				'tgm-updater-key'        => $key,
				'tgm-updater-wp-version' => get_bloginfo( 'version' ),
				'tgm-updater-referer'    => site_url(),
				'tgm-updater-uf-version' => USERFEEDBACK_VERSION,
				'tgm-updater-is-pro'     => userfeedback_is_pro_version(),
			)
		);
		$body = http_build_query( $body, '', '&' );

		// Build the headers of the request.
		$headers = wp_parse_args(
			array(
				'Content-Type'   => 'application/x-www-form-urlencoded',
				'Content-Length' => strlen( $body ),
			)
		);

		// Setup variable for wp_remote_post.
		$post = array(
			'headers' => $headers,
			'body'    => $body,
		);
		// Perform the query and retrieve the response.
		$response      = wp_remote_post( userfeedback_get_licensing_url(), $post );
		$response_code = wp_remote_retrieve_response_code( $response );
		$response_body = wp_remote_retrieve_body( $response );

		// Bail out early if there are any errors.
		if ( 200 != $response_code || is_wp_error( $response_body ) ) {
			return false;
		}

		// Return the json decoded content.
		return json_decode( $response_body );
	}
}

new UserFeedback_Connect();
