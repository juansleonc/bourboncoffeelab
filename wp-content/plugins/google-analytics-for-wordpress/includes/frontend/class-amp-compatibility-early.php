<?php
/**
 * Early AMP Compatibility Handler for MonsterInsights
 * This runs before MonsterInsights initializes to prevent any scripts from loading
 * 
 * @package MonsterInsights
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class MonsterInsights_AMP_Compatibility_Early
 */
class MonsterInsights_AMP_Compatibility_Early {

	/**
	 * Constructor
	 */
	public function __construct() {
		// Run as early as possible
		add_action( 'init', array( $this, 'init' ), 1 );
		add_action( 'wp', array( $this, 'init' ), 1 );
		add_action( 'template_redirect', array( $this, 'init' ), 1 );
		
		// Intercept very early
		add_action( 'plugins_loaded', array( $this, 'intercept_early' ), 1 );
	}

	/**
	 * Initialize early AMP compatibility
	 */
	public function init() {
		// Only run if we're in AMP context
		if ( ! $this->is_amp() ) {
			return;
		}

		// Remove ALL MonsterInsights hooks before they can execute
		$this->remove_all_monsterinsights_hooks();
		
		// Prevent any MonsterInsights functions from executing
		$this->disable_monsterinsights_functions();
	}

	/**
	 * Intercept very early in the loading process
	 */
	public function intercept_early() {
		// Only run if we're in AMP context
		if ( ! $this->is_amp() ) {
			return;
		}

		// Remove the specific function that's causing the problem
		if ( function_exists( 'monsterinsights_tracking_script' ) ) {
			// Replace the function with a no-op
			$this->replace_monsterinsights_function( 'monsterinsights_tracking_script' );
		}

		// Remove any other MonsterInsights functions
		$this->replace_monsterinsights_function( 'monsterinsights_frontend_tracking' );
		$this->replace_monsterinsights_function( 'monsterinsights_gtag_tracking' );
	}

	/**
	 * Remove MonsterInsights hooks only (not all hooks)
	 */
	private function remove_all_monsterinsights_hooks() {
		// Remove the specific hook that's causing the problem
		remove_action( 'cmplz_before_statistics_script', 'monsterinsights_tracking_script', 10 );

		// Remove MonsterInsights specific hooks only
		// DO NOT use remove_all_actions - it breaks other plugins and themes
		remove_action( 'wp_head', 'monsterinsights_tracking_script' );
		remove_action( 'wp_footer', 'monsterinsights_tracking_script' );
		remove_action( 'wp_enqueue_scripts', array( 'MonsterInsights_Gtag_Events', 'output_javascript' ), 9 );

		// Remove additional MonsterInsights hooks that might be registered
		global $wp_filter;

		// List of hooks to check for MonsterInsights callbacks
		$hooks_to_check = array( 'wp_head', 'wp_footer', 'wp_body_open', 'wp_enqueue_scripts', 'template_redirect' );

		foreach ( $hooks_to_check as $hook ) {
			if ( isset( $wp_filter[ $hook ] ) ) {
				foreach ( $wp_filter[ $hook ]->callbacks as $priority => $callbacks ) {
					foreach ( $callbacks as $callback_id => $callback ) {
						// Check if this is a MonsterInsights callback
						if ( $this->is_monsterinsights_callback( $callback['function'] ) ) {
							remove_action( $hook, $callback['function'], $priority );
						}
					}
				}
			}
		}
	}

	/**
	 * Check if a callback is from MonsterInsights
	 *
	 * @param mixed $callback The callback to check
	 * @return bool
	 */
	private function is_monsterinsights_callback( $callback ) {
		// Check for function names containing 'monsterinsights'
		if ( is_string( $callback ) && stripos( $callback, 'monsterinsights' ) !== false ) {
			return true;
		}

		// Check for class methods
		if ( is_array( $callback ) && isset( $callback[0] ) ) {
			// Object or class name
			$class = is_object( $callback[0] ) ? get_class( $callback[0] ) : $callback[0];
			if ( is_string( $class ) && stripos( $class, 'MonsterInsights' ) !== false ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Disable MonsterInsights functions
	 */
	private function disable_monsterinsights_functions() {
		// Add filters to prevent any MonsterInsights output
		add_filter( 'monsterinsights_tracking_script', '__return_false', 999999 );
		add_filter( 'monsterinsights_frontend_tracking_options', '__return_false', 999999 );
		add_filter( 'monsterinsights_gtag_tracking', '__return_false', 999999 );
		add_filter( 'monsterinsights_dual_tracking', '__return_false', 999999 );
		
		// Disable any MonsterInsights output
		add_filter( 'monsterinsights_output_tracking', '__return_false', 999999 );
		add_filter( 'monsterinsights_output_gtag', '__return_false', 999999 );
	}

	/**
	 * Replace a MonsterInsights function with a no-op
	 */
	private function replace_monsterinsights_function( $function_name ) {
		if ( function_exists( $function_name ) ) {
			// Instead of redefining, we'll use filters to prevent output
			// The function will still exist but won't produce any output
			add_filter( 'monsterinsights_' . $function_name . '_output', '__return_false', 999999 );
		}
	}

	/**
	 * Check if we are in an AMP context
	 *
	 * @return bool
	 */
	private function is_amp() {
		// Check for AMP plugin
		if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
			return true;
		}
		
		// Check for AMP theme
		if ( function_exists( 'amp_is_request' ) && amp_is_request() ) {
			return true;
		}
		
		// Check for AMP query parameter
		if ( isset( $_GET['amp'] ) && '1' === $_GET['amp'] ) {
			return true;
		}
		
		// Check for AMP in URL path
		if ( isset( $_SERVER['REQUEST_URI'] ) && false !== strpos( $_SERVER['REQUEST_URI'], '/amp/' ) ) {
			return true;
		}
		
		// Check for AMP in theme
		if ( function_exists( 'amp_is_canonical' ) && amp_is_canonical() ) {
			return true;
		}
		
		return false;
	}
}

// Initialize early AMP compatibility
new MonsterInsights_AMP_Compatibility_Early();
