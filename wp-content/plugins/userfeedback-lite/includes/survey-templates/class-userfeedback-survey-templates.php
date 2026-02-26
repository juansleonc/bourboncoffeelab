<?php

class UserFeedback_Survey_Templates {

	/**
	 * Array of registered templates
	 *
	 * @var array
	 */
	private $templates = array();

	/**
	 * Class instance
	 *
	 * @var UserFeedback_Survey_Templates
	 */
	public static $instance;

	/**
	 * Get class instance
	 *
	 * @return UserFeedback_Survey_Templates|static
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new static();
		}

		return self::$instance;
	}

	/**
	 * Loads template files and registers them
	 */
	public function __construct() {
		// Load included templates

		require_once USERFEEDBACK_PLUGIN_DIR . 'includes/survey-templates/class-userfeedback-survey-template-website-feedback.php';
		require_once USERFEEDBACK_PLUGIN_DIR . 'includes/survey-templates/class-userfeedback-survey-template-website-experience.php';
		require_once USERFEEDBACK_PLUGIN_DIR . 'includes/survey-templates/class-userfeedback-survey-template-content-engagement.php';
		require_once USERFEEDBACK_PLUGIN_DIR . 'includes/survey-templates/class-userfeedback-survey-template-restaurant-menu.php';
		require_once USERFEEDBACK_PLUGIN_DIR . 'includes/survey-templates/class-userfeedback-survey-template-phone-lead.php';

		// Register templates

		// Website Feedback
		$webTemplate = new UserFeedback_Survey_Template_Web_Feedback();
		$this->register_template( $webTemplate->get_key(), $webTemplate );

		// Website Experience
		$webExperience = new UserFeedback_Survey_Template_Web_Experience();
		$this->register_template( $webExperience->get_key(), $webExperience );

		// Content Engagement
		$contentEngagement = new UserFeedback_Survey_Template_Content_Engagement();
		$this->register_template( $contentEngagement->get_key(), $contentEngagement );

		// Restaurant Menu
		$restaurantMenu = new UserFeedback_Survey_Template_Restaurant_Menu();
		$this->register_template( $restaurantMenu->get_key(), $restaurantMenu );

		// Phone Lead
		$phoneLead = new UserFeedback_Survey_Template_Phone_Lead();
		$this->register_template( $phoneLead->get_key(), $phoneLead );

		// Register Pro templates with name and descriptions only

		// Ecommerce
		$this->register_template(
			'ecommerce',
			array(
				'key'         => 'ecommerce',
				'name'        => __( 'eCommerce Store Survey (PRO)', 'userfeedback-lite' ),
				'categories' => array(
					'ecommerce', 'ui-ux'
				),
				'tags' => array(
					'most-popular',
				),
				'feature_image' => plugins_url( '/assets/img', USERFEEDBACK_PLUGIN_FILE ) . '/template-feature-images/ecommerce-store-survey.svg',
				'description' => array(
					'title' => __( 'Uncover why your visitors purchased from your store.', 'userfeedback-lite' )
				),
			)
		);

		// B2B
		$this->register_template(
			'b2b',
			array(
				'key'         => 'b2b',
				'name'        => __( 'B2B Satisfaction Survey (PRO)', 'userfeedback-lite' ),
				'description' => array(
					'title' => __( 'See what customers think about your product or service and find ways to improve.', 'userfeedback-lite' )
				),
				'categories' => array(
					'experience', 'engagement'
				),
				'feature_image' => plugins_url( '/assets/img', USERFEEDBACK_PLUGIN_FILE ) . '/template-feature-images/b2b-satisfaction-survey.svg'
			)
		);

		// NPS
		$this->register_template(
			'nps',
			array(
				'key'         => 'nps',
				'name'        => __( 'NPS Survey (PRO)', 'userfeedback-lite' ),
				'description' => array(
					'title' => __( 'See how likely a customer is to refer a friend or colleague.', 'userfeedback-lite' ),
					'list' => array(
						__( 'Launch your NPS® survey in just a few clicks', 'userfeedback-lite' ),
						__( 'No coding - Ready-to-Use Templates', 'userfeedback-lite' ),
						__( 'Gather Detailed Feedback', 'userfeedback-lite' ),
						__( 'Fully Customizable Design', 'userfeedback-lite' ),
					),
				),
				'categories' => array(
					'experience'
				),
				'feature_image' => plugins_url( '/assets/img', USERFEEDBACK_PLUGIN_FILE ) . '/template-feature-images/nps-survey.svg'
			),
		);

		// Ecommerce experience
		$this->register_template(
			'ecommerce-experience',
			array(
				'key'         => 'ecommerce-experience',
				'name'        => __( 'eCommerce Store Experience (PRO)', 'userfeedback-lite' ),
				'categories' => array(
					'ecommerce', 'experience'
				),
				'feature_image' => plugins_url( '/assets/img', USERFEEDBACK_PLUGIN_FILE ) . '/template-feature-images/ecommerce-store-experience.svg',
				'description' => array(
					'title' => __( 'Quickly see how customers rate your store with a 1-5 scale.', 'userfeedback-lite' )
				),
			),
		);

		$this->register_template(
			'website-design',
			array(
				'key'         => 'website-design',
				'name'        => __( 'Website Design Feedback (PRO)', 'userfeedback-lite' ),
				'categories' => array(
					'experience', 'ui-ux', 'engagement'
				),
				'feature_image' => plugins_url( '/assets/img', USERFEEDBACK_PLUGIN_FILE ) . '/template-feature-images/website-design-feedback.svg',
				'description' => array(
					'title' => __( 'Find out how much your website users enjoy using your website. Get feedback on how to improve.', 'userfeedback-lite' )
				),
			),
		);

		$this->register_template(
			'ecommerce-conversion-optimization',
			array(
				'key'         => 'ecommerce-conversion-optimization',
				'name'        => __( 'eCommerce Conversion Optimization (PRO)', 'userfeedback-lite' ),
				'categories' => array(
					'ecommerce', 'experience', 'ui-ux'
				),
				'feature_image' => plugins_url( '/assets/img', USERFEEDBACK_PLUGIN_FILE ) . '/template-feature-images/ecommerce-conversion-optimization.svg',
				'description' => array(
					'title' => __( 'Understand why users are not making purchases, and collect their email address.', 'userfeedback-lite' )
				),
			),
		);

		$this->register_template(
			'nps-product-feedback',
			array(
				'key'         => 'nps-product-feedback',
				'name'        => __( 'NPS (R) Product Feedback (PRO)', 'userfeedback-lite' ),
				'categories' => array(
					'experience'
				),
				'tags' => array(
					'most-popular',
				),
				'feature_image' => plugins_url( '/assets/img', USERFEEDBACK_PLUGIN_FILE ) . '/template-feature-images/nps-product-feedback.svg',
				'description' => array(
					'title' => __( 'Find out how likely customers are likely to refer your product, and what can be improved.', 'userfeedback-lite' )
				)
			),
		);

		$this->register_template(
			'b2b-buyer-survey',
			array(
				'key'         => 'b2b-buyer-survey',
				'name'        => __( 'B2B Buyer Persona Survey (PRO)', 'userfeedback-lite' ),
				'categories' => array(
					'ui-ux'
				),
				'feature_image' => plugins_url( '/assets/img', USERFEEDBACK_PLUGIN_FILE ) . '/template-feature-images/b2b-buyer-persona-survey.svg',
				'description' => array(
					'title' => __( 'Learn more about the buyers shopping at your eCommerce store.', 'userfeedback-lite' )
				)
			),
		);

		$this->register_template(
			'post-purchase',
			array(
				'key'         => 'post-purchase',
				'name'        => __( 'Post Purchase Review (PRO)', 'userfeedback-lite' ),
				'categories' => array(
					'ecommerce'
				),
				'feature_image' => plugins_url( '/assets/img', USERFEEDBACK_PLUGIN_FILE ) . '/template-feature-images/post-purchase-review.svg',
				'description' => array(
					'title' => __( 'Increase conversions by understanding how easy your checkout process is to complete.', 'userfeedback-lite' )
				)
			),
		);

		$this->register_template(
			'product-usage',
			array(
				'key'         => 'product-usage',
				'name'        => __( 'Product Usage Survey (PRO)', 'userfeedback-lite' ),
				'categories' => array(
					'ecommerce', 'ui-ux'
				),
				'feature_image' => plugins_url( '/assets/img', USERFEEDBACK_PLUGIN_FILE ) . '/template-feature-images/product-usage-survey.svg',
				'description' => array(
					'title' => __( 'Uncover how often your product or service is actually used.', 'userfeedback-lite' ),
					'list' => array(
						__( 'Discover usage frequency and patterns.', 'userfeedback-lite' ),
						__( 'Gauge product\'s regular user engagement.', 'userfeedback-lite' ),
						__( 'Uncover what features are used.', 'userfeedback-lite' ),
						__( 'Learn how product helps users.', 'userfeedback-lite' ),
					)
				)
			),
		);

		$this->register_template(
			'pricing-page-info',
			array(
				'key'         => 'pricing-page-info',
				'name'        => __( 'Pricing Page Information (PRO)', 'userfeedback-lite' ),
				'categories' => array(
					'ecommerce', 'ui-ux'
				),
				'feature_image' => plugins_url( '/assets/img', USERFEEDBACK_PLUGIN_FILE ) . '/template-feature-images/pricing-page-information.svg',
				'description' => array(
					'title' => __( 'Determine what questions can be answered from your pricing page to maximize conversions.', 'userfeedback-lite' )
				)
			),
		);

		$this->register_template(
			'buyer-journey',
			array(
				'key'         => 'buyer-journey',
				'name'        => __( 'Buyer Journey Research (PRO)', 'userfeedback-lite' ),
				'categories' => array(
					'ecommerce', 'ui-ux'
				),
				'feature_image' => plugins_url( '/assets/img', USERFEEDBACK_PLUGIN_FILE ) . '/template-feature-images/buyer-journey-research.svg',
				'description' => array(
					'title' => __( 'Learn how users find your website, so you can maximize your marketing budget.', 'userfeedback-lite' )
				)
			),
		);

		$this->register_template(
			'beta-opt-in',
			array(
				'key'         => 'beta-opt-in',
				'name'        => __( 'User Beta Testing Opt-in (PRO)', 'userfeedback-lite' ),
				'description' => array(
					'title' => __( 'Easily find users for your latest feature or beta testing period.', 'userfeedback-lite' )
				),
				'categories' => array(
					'experience', 'ui-ux'
				),
				'feature_image' => plugins_url( '/assets/img', USERFEEDBACK_PLUGIN_FILE ) . '/template-feature-images/user-beta-testing-opt-in.svg'
			),
		);

		$this->register_template(
			'product-offering',
			array(
				'key'         => 'product-offering',
				'name'        => __( 'Product Offering Intelligence (PRO)', 'userfeedback-lite' ),
				'description' => array(
					'title' => __( "Find out why someone didn't purchase from you, and collect their email address.", 'userfeedback-lite' )
				),
				'categories' => array(
					'ecommerce'
				),
				'feature_image' => plugins_url( '/assets/img', USERFEEDBACK_PLUGIN_FILE ) . '/template-feature-images/product-offering-intelligence.svg'
			),
		);

		$this->register_template(
			'feature-research',
			array(
				'key'         => 'feature-research',
				'name'        => __( 'Website Feature Research (PRO)', 'userfeedback-lite' ),
				'categories' => array(
					'ecommerce', 'engagement'
				),
				'feature_image' => plugins_url( '/assets/img', USERFEEDBACK_PLUGIN_FILE ) . '/template-feature-images/website-feature-research.svg',
				'description' => array(
					'title' => __( 'Target website features to add to maximize your conversion rates.', 'userfeedback-lite' ),
					'list' => array(
						__('Optimize features to maximize conversion rates.', 'userfeedback-lite' ),
						__('Identify key features boosting conversions.', 'userfeedback-lite' ),
						__('Research impactful website additions for growth.', 'userfeedback-lite' ),
						__('Discover features that drive user action.', 'userfeedback-lite' ),
					)
				)
			),
		);

		$this->register_template(
			'competitive-research',
			array(
				'key'         => 'competitive-research',
				'name'        => __( 'Competitive Research (PRO)', 'userfeedback-lite' ),
				'categories' => array(
					'experience', 'ui-ux', 'engagement'
				),
				'feature_image' => plugins_url( '/assets/img', USERFEEDBACK_PLUGIN_FILE ) . '/template-feature-images/competitive-research.svg',
				'description' => array(
					'title' => __( 'Find out why customers choose your brand over another.', 'userfeedback-lite' )
				)
			),
		);

		$this->register_template(
			'content-research',
			array(
				'key'         => 'content-research',
				'name'        => __( 'Content Research (PRO)', 'userfeedback-lite' ),
				'categories' => array(
					'ui-ux', 'engagement'
				),
				'feature_image' => plugins_url( '/assets/img', USERFEEDBACK_PLUGIN_FILE ) . '/template-feature-images/content-research.svg',
				'description' => array(
					'title' => __( 'Learn which content is engaging, and what content to create.', 'userfeedback-lite' ),
					'list' => array(
						__('Find engaging content to create.', 'userfeedback-lite' ),
						__('Discover content that resonates best.', 'userfeedback-lite' ),
						__('Learn what content captures audience.', 'userfeedback-lite' ),
						__('Identify top-performing content themes.', 'userfeedback-lite' ),
					)
				)
			),
		);

		$this->register_template(
			'product-research',
			array(
				'key'         => 'product-research',
				'name'        => __( 'Product Research (PRO)', 'userfeedback-lite' ),
				'categories' => array(
					'ui-ux', 'engagement'
				),
				'feature_image' => plugins_url( '/assets/img', USERFEEDBACK_PLUGIN_FILE ) . '/template-feature-images/product-research.svg',
				'description' => array(
					'title' => __( 'Determine what features you should stop advertising.', 'userfeedback-lite' )
				)
			),
		);

		$this->register_template(
			'saas-feedback',
			array(
				'key'         => 'saas-feedback',
				'name'        => __( 'SAAS Feature Feedback (PRO)', 'userfeedback-lite' ),
				'categories' => array(
					'ui-ux', 'engagement'
				),
				'feature_image' => plugins_url( '/assets/img', USERFEEDBACK_PLUGIN_FILE ) . '/template-feature-images/saas-feature-feedback.svg',
				'description' => array(
					'title' => __( 'Uncover which features are missing from your offering so that you can attract more customers.', 'userfeedback-lite' )
				)
			),
		);
	}

	/**
	 * Registers template in $templates array
	 * Template data is passed through the userfeedback_register_template_{template_key} before registering
	 *
	 * @param UserFeedback_Survey_Template|array $template
	 * @return void
	 */
	public function register_template( $key, $template ) {

		if ( $template instanceof UserFeedback_Survey_Template ) {
			$this->templates[ $key ] = $template->get_data();
		} elseif ( is_array( $template ) ) {
			$this->templates[ $key ] = $template;
		}
	}

	/**
	 * Returns the registered templates
	 *
	 * @return array
	 */
	public function get_available_templates() {
		return $this->templates;
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'userfeedback-lite' ), '1.0.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'userfeedback-lite' ), '1.0.0' );
	}
}
