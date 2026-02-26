<?php
/**
* Plugin Name: Furnob Core
* Description: Premium & Advanced Essential Elements for Elementor
* Plugin URI:  http://themeforest.net/user/KlbTheme
* Version:     1.1.0
* Author:      KlbTheme
* Author URI:  http://themeforest.net/user/KlbTheme
*/


/*
* Exit if accessed directly.
*/

if ( ! defined( 'ABSPATH' ) ) exit;

final class Furnob_Elementor_Addons
{
    /**
    * Plugin Version
    *
    * @since 1.0
    *
    * @var string The plugin version.
    */
    const VERSION = '1.0.0';

    /**
    * Minimum Elementor Version
    *
    * @since 1.0
    *
    * @var string Minimum Elementor version required to run the plugin.
    */
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    /**
    * Minimum PHP Version
    *
    * @since 1.0
    *
    * @var string Minimum PHP version required to run the plugin.
    */
    const MINIMUM_PHP_VERSION = '7.0';

    /**
    * Instance
    *
    * @since 1.0
    *
    * @access private
    * @static
    *
    * @var Furnob_Elementor_Addons The single instance of the class.
    */
    private static $_instance = null;

    /**
    * Instance
    *
    * Ensures only one instance of the class is loaded or can be loaded.
    *
    * @since 1.0
    *
    * @access public
    * @static
    *
    * @return Furnob_Elementor_Addons An instance of the class.
    */
    public static function instance()
    {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
    * Constructor
    *
    * @since 1.0
    *
    * @access public
    */
    public function __construct()
    {
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ] );
    }

    /**
    * Load Textdomain
    *
    * Load plugin localization files.
    *
    * Fired by `init` action hook.
    *
    * @since 1.0
    *
    * @access public
    */
    public function i18n()
    {
        load_plugin_textdomain( 'furnob-core' );
    }
	
   /**
    * Initialize the plugin
    *
    * Load the plugin only after Elementor (and other plugins) are loaded.
    * Checks for basic plugin requirements, if one check fail don't continue,
    * if all check have passed load the files required to run the plugin.
    *
    * Fired by `plugins_loaded` action hook.
    *
    * @since 1.0
    *
    * @access public
    */
    public function init()
    {
        // Check if Elementor is installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'furnob_admin_notice_missing_main_plugin' ] );
            return;
        }
        // Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'furnob_admin_notice_minimum_elementor_version' ] );
            return;
        }
        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'furnob_admin_notice_minimum_php_version' ] );
            return;
        }
		
		// Categories registered
        add_action( 'elementor/elements/categories_registered', [ $this, 'furnob_add_widget_category' ] );

		/* Init Include */
        require_once( __DIR__ . '/init.php' );

        /* Customizer Kirki */
        require_once( __DIR__ . '/inc/customizer.php' );

        /* Style php */
        require_once( __DIR__ . '/inc/style.php' );
		
		/* Aq Resizer Image Resize */
        require_once( __DIR__ . '/inc/aq_resizer.php' );
		
		/* Breadcrumb */
        require_once( __DIR__ . '/inc/breadcrumb.php' );
		
		/* Menu Endpoints */
        require_once( __DIR__ . '/inc/menu-endpoints.php' );

		/* Location Taxonomy */
		if(get_theme_mod('furnob_location_filter',0) == 1){
			require_once( __DIR__ . '/taxonomy/location_taxonomy.php' );
		}

		/* Post view for popular posts widget */
        require_once( __DIR__ . '/inc/post_view.php' );

        /* Popular Posts Widget */
        require_once( __DIR__ . '/widgets/widget-popular-posts.php' );
		
		/* WooCommerce Filter */
        require_once( __DIR__ . '/woocommerce-filter/woocommerce-filter.php' );
		
        /* Custom plugin helper functions */
        require_once( __DIR__ . '/elementor/classes/class-helpers-functions.php' );
		
        /* Custom plugin helper functions */
        require_once( __DIR__ . '/elementor/classes/class-customizing-page-settings.php' );

        // Register Widget Styles
        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );
		
        // Register Widget Scripts
        add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'widget_scripts' ] );
		
		// Register Widget Editor Style
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'widget_editor_style' ] );

        // Register Widget Editor Scripts
        add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'widget_editor_scripts' ] );
		
        // Widgets registered
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
    }
	
    /**
    * Register Widgets Category
    *
    */
    public function furnob_add_widget_category( $elements_manager )
    {
        $elements_manager->add_category( 'furnob', ['title' => esc_html__( 'Furnob Core', 'furnob' )]);
    }	
	
    /**
    * Init Widgets
    *
    * Include widgets files and register them
    *
    * @since 1.0
    *
    * @access public
    */
    public function init_widgets()
    {

		// Home Slider
		require_once( __DIR__ . '/elementor/widgets/furnob-home-slider.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Home_Slider_Widget() );
		
		// Home Image
		require_once( __DIR__ . '/elementor/widgets/furnob-home-image.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Home_Image_Widget() );
		
		// Banner Slider
		require_once( __DIR__ . '/elementor/widgets/furnob-banner-slider.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Banner_Slider_Widget() );

		
		// Icon Box
		require_once( __DIR__ . '/elementor/widgets/furnob-icon-box.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Icon_Box_Widget() );
		
		// Custom Title
		require_once( __DIR__ . '/elementor/widgets/furnob-custom-title.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Custom_Title_Widget() );
		
		// Product Categories
		require_once( __DIR__ . '/elementor/widgets/furnob-product-categories.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Product_Categories_Widget() );
		
		// Banner Box
		require_once( __DIR__ . '/elementor/widgets/furnob-banner-box.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Banner_Box_Widget() );
		
		// Banner Box 2
		require_once( __DIR__ . '/elementor/widgets/furnob-banner-box2.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Banner_Box2_Widget() );
		
		// Banner Box 3
		require_once( __DIR__ . '/elementor/widgets/furnob-banner-box3.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Banner_Box3_Widget() );
		
		// Banner Carousel
		require_once( __DIR__ . '/elementor/widgets/furnob-banner-carousel.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Banner_Carousel_Widget() );
		
		// Product Carousel
		require_once( __DIR__ . '/elementor/widgets/furnob-product-carousel.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Product_Carousel_Widget() );
		
		// Product Grid
		require_once( __DIR__ . '/elementor/widgets/furnob-product-grid.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Product_Grid_Widget() );
		
		// Image Points
		require_once( __DIR__ . '/elementor/widgets/furnob-image-points.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Image_Points_Widget() );
		
		// Counter Box
		require_once( __DIR__ . '/elementor/widgets/furnob-counter-box.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Counter_Box_Widget() );
		
		// Counter Box2
		require_once( __DIR__ . '/elementor/widgets/furnob-counter-box2.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Counter_Box2_Widget() );
		
		// Testimonial
		require_once( __DIR__ . '/elementor/widgets/furnob-testimonial.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Testimonial_Widget() );
		
		// Testimonial Carousel
		require_once( __DIR__ . '/elementor/widgets/furnob-testimonial-carousel.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Testimonial_Carousel_Widget() );
		
		// Latest Blog
		require_once( __DIR__ . '/elementor/widgets/furnob-latest-blog.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Latest_Blog_Widget() );
		
		// Client Carousel
		require_once( __DIR__ . '/elementor/widgets/furnob-client-carousel.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Client_Carousel_Widget() );
		
		// Client Carousel
		require_once( __DIR__ . '/elementor/widgets/furnob-subscribe-box.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Subscribe_Box_Widget() );
		
		// Image Block
		require_once( __DIR__ . '/elementor/widgets/furnob-image-block.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Image_Block_Widget() );
		
		// Comment Block
		require_once( __DIR__ . '/elementor/widgets/furnob-comment-block.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Comment_Block_Widget() );
		
		// Button
		require_once( __DIR__ . '/elementor/widgets/furnob-button.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Button_Widget() );
		
		// Page Banner
		require_once( __DIR__ . '/elementor/widgets/furnob-page-banner.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Page_Banner_Widget() );
		
		// Contact Form 7
		require_once( __DIR__ . '/elementor/widgets/furnob-contact-form-7.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Contact_Form_7_Widget() );
		
		// Address Box
		require_once( __DIR__ . '/elementor/widgets/furnob-address-box.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Address_Box_Widget() );
		
		// Icon List
		require_once( __DIR__ . '/elementor/widgets/furnob-icon-list.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Furnob_Icon_List_Widget() );

	}
	
	
    /**
    * Admin notice
    *
    * Warning when the site doesn't have Elementor installed or activated.
    *
    * @since 1.0
    *
    * @access public
    */
    public function furnob_admin_notice_missing_main_plugin()
    {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__( '%1$s requires %2$s to be installed and activated.', 'furnob' ),
            '<strong>' . esc_html__( 'Furnob Core', 'furnob' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'furnob' ) . '</strong>'
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
    * Admin notice
    *
    * Warning when the site doesn't have a minimum required Elementor version.
    *
    * @since 1.0
    *
    * @access public
    */
    public function furnob_admin_notice_minimum_elementor_version()
    {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__( '%1$s requires %2$s version %3$s or greater.', 'furnob' ),
            '<strong>' . esc_html__( 'Furnob Core', 'furnob' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'furnob' ) . '</strong>',
             self::MINIMUM_ELEMENTOR_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
    * Admin notice
    *
    * Warning when the site doesn't have a minimum required PHP version.
    *
    * @since 1.0
    *
    * @access public
    */
    public function furnob_admin_notice_minimum_php_version()
    {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__( '%1$s requires %2$s version %3$s or greater.', 'furnob' ),
            '<strong>' . esc_html__( 'Furnob Core', 'furnob' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'furnob' ) . '</strong>',
             self::MINIMUM_PHP_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }
	
    public function widget_styles()
    {
    }

    public function widget_scripts(){

		if (is_admin ()){
			wp_enqueue_media ();
			wp_enqueue_script( 'widget-image', plugins_url( 'js/widget-image.js', __FILE__ ));
		}

        // custom-scripts
		if ( is_rtl() ) {
			wp_enqueue_script( 'furnob-core-custom-scripts-rtl', plugins_url( 'elementor/custom-scripts-rtl.js', __FILE__ ), true );
		} else {
			wp_enqueue_script( 'furnob-core-custom-scripts', plugins_url( 'elementor/custom-scripts.js', __FILE__ ), true );
		}
    }
	
    public function widget_editor_style(){
		wp_enqueue_style( 'klb-editor-style', plugins_url( 'elementor/editor-style.css', __FILE__ ), true );
    }

    public function widget_editor_scripts(){
		wp_enqueue_script( 'klb-editor-scripts', plugins_url( 'elementor/editor-scripts.js', __FILE__ ), true );
    }


} 
Furnob_Elementor_Addons::instance();