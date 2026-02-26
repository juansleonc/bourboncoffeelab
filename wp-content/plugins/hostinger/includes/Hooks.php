<?php

namespace Hostinger;

defined( 'ABSPATH' ) || exit;

class Hooks {

	public function __construct() {
		add_action( 'init', array( $this, 'check_url_and_flush_rules' ) );
	}

	public function check_url_and_flush_rules() {
		if ( defined( 'DOING_AJAX' ) && \DOING_AJAX ) {
			return false;
		}

		$current_url    = home_url( add_query_arg( null, null ) );
		$url_components = wp_parse_url( $current_url );

		if ( isset( $url_components['query'] ) ) {
			parse_str( $url_components['query'], $params );

			if ( isset( $params['app_name'] ) ) {
				$app_name = sanitize_text_field( $params['app_name'] );

				if ( $app_name === 'Omnisend App' ) {
					if ( function_exists( 'flush_rewrite_rules' ) ) {
						flush_rewrite_rules();
					}

					if ( has_action( 'litespeed_purge_all' ) ) {
						do_action( 'litespeed_purge_all' );
					}
				}
			}
		}
	}

}
