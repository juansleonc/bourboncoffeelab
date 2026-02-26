<?php

namespace Hostinger;

use Hostinger\Loader;
use Hostinger\Helper;
use Hostinger\Settings;
use Hostinger\I18n;
use Hostinger\Config;
use Hostinger\Cli;
use Hostinger\Admin\Assets as AdminAssets;
use Hostinger\Admin\Hooks as AdminHooks;
use Hostinger\Admin\Menu as AdminMenu;
use Hostinger\Admin\Ajax as AdminAjax;
use Hostinger\Admin\Redirects as AdminRedirects;
use Hostinger\Amplitude\Amplitude;
use Hostinger\Preview\Assets as PreviewAssets;
use Hostinger\Requests\Client;
use Hostinger\Admin\Onboarding\Settings as OnboardingSettings;
use Hostinger\Surveys\Rest\Rest as SurveysRest;
use Hostinger\Surveys\Surveys;
use Hostinger\Surveys\Questions as SurveysQuestions;
use Hostinger\Admin\Onboarding\AutocompleteSteps;

defined( 'ABSPATH' ) || exit;

class Bootstrap {
	protected Loader $loader;

	public function __construct() {
		$this->loader = new Loader();
	}

	public function run(): void {
		$this->load_dependencies();
		$this->set_locale();
		$this->loader->run();
	}

	private function load_dependencies(): void {
		$this->load_onboarding_dependencies();
		$this->load_public_dependencies();
		$this->amplitude_dependencies();

		if ( is_admin() ) {
			$this->load_admin_dependencies();
			if ( ! empty( Helper::get_api_token() ) ) {
				$this->define_admin_surveys();
			}
		}

		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			new Cli();
		}

		if ( get_option( 'hostinger_maintenance_mode', 0 ) ) {
			require_once HOSTINGER_ABSPATH . 'includes/ComingSoon.php';
		}
	}

	private function set_locale() {
		$plugin_i18n = new I18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	private function load_admin_dependencies(): void {
		new AdminAssets();
		new AdminHooks();
		new AdminMenu();
		new AdminAjax();
		new AdminRedirects();
	}

	private function define_admin_surveys(): void {
		$settings         = new Settings();
		$helper           = new Helper();
		$config_handler   = new Config();
		$survey_questions = new SurveysQuestions();
		$client           = new Client(
			$config_handler->get_config_value( 'base_rest_uri', HOSTINGER_REST_URI ),
			array(
				Config::TOKEN_HEADER  => $helper::get_api_token(),
				Config::DOMAIN_HEADER => $helper->get_host_info(),
			)
		);
		$rest             = new SurveysRest( $client );
		$surveys          = new Surveys( $settings, $helper, $config_handler, $survey_questions, $rest );

		switch ( true ) {
			case $surveys->is_woocommerce_survey_enabled():
				$survey_function = 'customer_csat_survey';
				break;

			case $surveys->is_prebuild_website_survey_enabled():
				$survey_function = 'prebuild_website_survey';
				break;

			case $surveys->is_ai_onboarding_survey_enabled():
				$survey_function = 'customer_ai_csat_survey';
				break;

			case $surveys->is_content_generation_survey_enabled():
				$survey_function = 'ai_plugin_survey';
				break;

			case $surveys->is_affiliate_survey_enabled():
				$survey_function = 'affiliate_plugin_survey';
				break;

			default:
				return; // No survey enabled
		}

		$this->loader->add_action( 'admin_footer', $surveys, $survey_function, 10 );
	}

	private function load_public_dependencies(): void {
		new PreviewAssets();
		new Hooks();
	}

	private function load_onboarding_dependencies(): void {
		if ( ! OnboardingSettings::all_steps_completed() ) {
			new AutocompleteSteps();
		}
	}

	private function amplitude_dependencies(): void {
			new Amplitude();
	}
}
