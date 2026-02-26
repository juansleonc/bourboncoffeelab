<?php
/**
 * functions.php
 * @package WordPress
 * @subpackage Furnob
 * @since Furnob 1.1.2
 * 
 */

/*************************************************
## Admin style and scripts  
*************************************************/ 
function furnob_admin_styles() {
	wp_enqueue_style('furnob-klbtheme',     get_template_directory_uri() .'/assets/css/admin/klbtheme.css');
	wp_enqueue_script('furnob-init', 	    get_template_directory_uri() .'/assets/js/init.js', array('jquery','media-upload','thickbox'));
    wp_enqueue_script('furnob-register',    get_template_directory_uri() .'/assets/js/admin/register.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'furnob_admin_styles');

 /*************************************************
## Furnob Fonts
*************************************************/
function furnob_fonts_url_jost() {
	$fonts_url = '';

	$jost = _x( 'on', 'Jost font: on or off', 'furnob' );		

	if ( 'off' !== $jost ) {
		$font_families = array();

		if ( 'off' !== $jost ) {
		$font_families[] = 'Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900';
		}
		
		$query_args = array( 
		'family' => rawurldecode( implode( '|', $font_families ) ), 
		'subset' => rawurldecode( 'latin,latin-ext' ), 
		); 
		 
		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css2' );
	}
 
	return esc_url_raw( $fonts_url );
}

/*************************************************
## Styles and Scripts
*************************************************/ 
define('FURNOB_INDEX_CSS', 	  get_template_directory_uri()  . '/assets/css');
define('FURNOB_INDEX_JS', 	  get_template_directory_uri()  . '/assets/js');

function furnob_scripts() {

	if ( is_admin_bar_showing() ) {
		wp_enqueue_style( 'furnob-klbtheme', FURNOB_INDEX_CSS . '/admin/klbtheme.css', false, '1.0');    
	}	

	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );

	wp_enqueue_style( 'bootstrap', 				FURNOB_INDEX_CSS . '/bootstrap.min.css', false, '1.0');
	wp_enqueue_style( 'furnob-base', 			FURNOB_INDEX_CSS . '/base.css', false, '1.0');
	wp_style_add_data( 'furnob-base', 'rtl', 'replace' );
	wp_enqueue_style( 'furnob-font-jost',  		furnob_fonts_url_jost(), array(), null );
	wp_enqueue_style( 'furnob-style',         	get_stylesheet_uri() );
	wp_style_add_data( 'furnob-style', 'rtl', 'replace' );

	$mapkey = get_theme_mod('furnob_mapapi');

	wp_enqueue_script( 'imagesloaded');
	wp_enqueue_script( 'bootstrap-bundle',    	     FURNOB_INDEX_JS . '/bootstrap.bundle.min.js', array('jquery'), '1.0', true);
	wp_enqueue_script( 'gsap',    	    		     FURNOB_INDEX_JS . '/vendor/gsap.min.js', array('jquery'), '1.0', true);
	wp_enqueue_script( 'jquery-magnific-popup',      FURNOB_INDEX_JS . '/vendor/jquery.magnific-popup.min.js', array('jquery'), '1.0', true);
	wp_enqueue_script( 'owl-carousel',      		 FURNOB_INDEX_JS . '/vendor/owl.carousel.min.js', array('jquery'), '1.0', true);
	wp_enqueue_script( 'perfect-scrolllbar',         FURNOB_INDEX_JS . '/vendor/perfect-scrollbar.min.js', array('jquery'), '1.0', true);
	wp_enqueue_script( 'theia-sticky-sidebar',       FURNOB_INDEX_JS . '/vendor/theia-sticky-sidebar.min.js', array('jquery'), '1.0', true);
	wp_enqueue_script( 'furnob-stickysidebar',       FURNOB_INDEX_JS . '/custom/stickysidebar.js', array('jquery'), '1.0', true);
	wp_enqueue_script( 'furnob-sidebarfilter',       FURNOB_INDEX_JS . '/custom/sidebarfilter.js', array('jquery'), '1.0', true);
	wp_enqueue_script( 'furnob-sitescroll',          FURNOB_INDEX_JS . '/custom/sitescroll.js', array('jquery'), '1.0', true);
	wp_enqueue_script( 'furnob-siteslider',          FURNOB_INDEX_JS . '/custom/siteslider.js', array('jquery'), '1.0', true);
	wp_register_script( 'furnob-flex-thumbs',        FURNOB_INDEX_JS . '/custom/flex-thumbs.js', array('jquery'), '1.0', true);
	wp_register_script( 'furnob-sizemodal',          FURNOB_INDEX_JS . '/custom/sizemodal.js', array('jquery'), '1.0', true);
	wp_register_script( 'furnob-googlemap',          '//maps.googleapis.com/maps/api/js?key='. $mapkey .'', array('jquery'), '1.0', true);
	wp_enqueue_script( 'furnob-bundle',     	     FURNOB_INDEX_JS . '/bundle.js', array('jquery'), '1.0', true);
}
add_action( 'wp_enqueue_scripts', 'furnob_scripts' );

/*************************************************
## Theme Setup
*************************************************/ 

if ( ! isset( $content_width ) ) $content_width = 960;

function furnob_theme_setup() {
	
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'post-formats', array('gallery', 'audio', 'video'));
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'woocommerce', array('gallery_thumbnail_image_width' => 99,'thumbnail_image_width' => 90,) );
	load_theme_textdomain( 'furnob', get_template_directory() . '/languages' );
	remove_theme_support( 'widgets-block-editor' );

}
add_action( 'after_setup_theme', 'furnob_theme_setup' );


/*************************************************
## Include the TGM_Plugin_Activation class.
*************************************************/ 

require_once get_template_directory() . '/includes/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'furnob_register_required_plugins' );

function furnob_register_required_plugins() {

	$url = 'http://klbtheme.com/furnob/plugins/';
	$mainurl = 'http://klbtheme.com/plugins/';

	$plugins = array(
		
        array(
            'name'                  => esc_html__('Meta Box','furnob'),
            'slug'                  => 'meta-box',
        ),

        array(
            'name'                  => esc_html__('Contact Form 7','furnob'),
            'slug'                  => 'contact-form-7',
        ),
		
		array(
            'name'                  => esc_html__('WooCommerce Wishlist','furnob'),
            'slug'                  => 'ti-woocommerce-wishlist',
        ),
		
		array(
            'name'                  => esc_html__('WooCommerce Compare','furnob'),
            'slug'                  => 'woo-smart-compare',
        ),
		
        array(
            'name'                  => esc_html__('Kirki','furnob'),
            'slug'                  => 'kirki',
        ),
		
		array(
            'name'                  => esc_html__('MailChimp Subscribe','furnob'),
            'slug'                  => 'mailchimp-for-wp',
        ),
		
        array(
            'name'                  => esc_html__('Elementor','furnob'),
            'slug'                  => 'elementor',
            'required'              => true,
        ),
		
        array(
            'name'                  => esc_html__('WooCommerce','furnob'),
            'slug'                  => 'woocommerce',
            'required'              => true,
        ),

		array(
            'name'                  => esc_html__('WP Ajax Search','furnob'),
            'slug'                  => 'ajax-search-for-woocommerce',
        ),

        array(
            'name'                  => esc_html__('Furnob Core','furnob'),
            'slug'                  => 'furnob-core',
            'source'                => $url . 'furnob-core.zip',
            'required'              => true,
            'version'               => '1.1.0',
            'force_activation'      => false,
            'force_deactivation'    => false,
            'external_url'          => '',
        ),

        array(
            'name'                  => esc_html__('Envato Market','furnob'),
            'slug'                  => 'envato-market',
            'source'                => $mainurl . 'envato-market.zip',
            'required'              => true,
            'version'               => '2.0.7',
            'force_activation'      => false,
            'force_deactivation'    => false,
            'external_url'          => '',
        ),


	);

	$config = array(
		'id'           => 'furnob',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}

/*************************************************
## Furnob Register Menu 
*************************************************/

function furnob_register_menus() {
	register_nav_menus( array( 'main-menu' 	   => esc_html__('Primary Navigation Menu','furnob')) );
	
	$secondarymenu = get_theme_mod('furnob_secondary_menu','0');
	$sidebarmenu = get_theme_mod('furnob_header_sidebar','0');
	$type3right = get_theme_mod('furnob_type3_right_menu','0');
	$footermenu = get_theme_mod('furnob_footer_menu','0');

	if($secondarymenu == '1'){
		register_nav_menus( array( 'secondary-menu'     => esc_html__('Secondary Menu','furnob')) );
	}

	if($sidebarmenu == '1'){
		register_nav_menus( array( 'sidebar-menu'       => esc_html__('Sidebar Menu','furnob')) );
	}
	
	if($type3right == '1'){
		register_nav_menus( array( 'type3-right-menu'   => esc_html__('Type3 Right Menu','furnob')) );
	}
	
	if($footermenu == '1'){
		register_nav_menus( array( 'footer-menu'        => esc_html__('Footer Menu','furnob')) );
	}
}
add_action('init', 'furnob_register_menus');

/*************************************************
## Excerpt More
*************************************************/ 

function furnob_excerpt_more($more) {
  global $post;
  return '<div class="klb-readmore entry-button"><a class="btn link" href="'. esc_url(get_permalink($post->ID)) . '">' . esc_html__('Read More', 'furnob') . ' <i class="klbth-icon-right-arrow"></i></a></div>';
  }
 add_filter('excerpt_more', 'furnob_excerpt_more');
 
/*************************************************
## Word Limiter
*************************************************/ 
function furnob_limit_words($string, $limit) {
	$words = explode(' ', $string);
	return implode(' ', array_slice($words, 0, $limit));
}

/*************************************************
## Widgets
*************************************************/ 

function furnob_widgets_init() {
	register_sidebar( array(
	  'name' => esc_html__( 'Blog Sidebar', 'furnob' ),
	  'id' => 'blog-sidebar',
	  'description'   => esc_html__( 'These are widgets for the Blog page.','furnob' ),
	  'before_widget' => '<div class="widget %2$s">',
	  'after_widget'  => '</div>',
	  'before_title'  => '<h4 class="widget-title">',
	  'after_title'   => '</h4>'
	) );

	register_sidebar( array(
	  'name' => esc_html__( 'Shop Sidebar', 'furnob' ),
	  'id' => 'shop-sidebar',
	  'description'   => esc_html__( 'These are widgets for the Shop.','furnob' ),
	  'before_widget' => '<div class="widget %2$s">',
	  'after_widget'  => '</div>',
	  'before_title'  => '<h4 class="widget-title">',
	  'after_title'   => '</h4>'
	) );

	register_sidebar( array(
	  'name' => esc_html__( 'Footer First Column', 'furnob' ),
	  'id' => 'footer-1',
	  'description'   => esc_html__( 'These are widgets for the Footer.','furnob' ),
	  'before_widget' => '<div class="klbfooterwidget widget %2$s">',
	  'after_widget'  => '</div>',
	  'before_title'  => '<h4 class="widget-title">',
	  'after_title'   => '</h4>'
	) );

	register_sidebar( array(
	  'name' => esc_html__( 'Footer Second Column', 'furnob' ),
	  'id' => 'footer-2',
	  'description'   => esc_html__( 'These are widgets for the Footer.','furnob' ),
	  'before_widget' => '<div class="klbfooterwidget widget %2$s">',
	  'after_widget'  => '</div>',
	  'before_title'  => '<h4 class="widget-title">',
	  'after_title'   => '</h4>'
	) );

	register_sidebar( array(
	  'name' => esc_html__( 'Footer Third Column', 'furnob' ),
	  'id' => 'footer-3',
	  'description'   => esc_html__( 'These are widgets for the Footer.','furnob' ),
	  'before_widget' => '<div class="klbfooterwidget widget %2$s">',
	  'after_widget'  => '</div>',
	  'before_title'  => '<h4 class="widget-title">',
	  'after_title'   => '</h4>'
	) );

	register_sidebar( array(
	  'name' => esc_html__( 'Footer Fourth Column', 'furnob' ),
	  'id' => 'footer-4',
	  'description'   => esc_html__( 'These are widgets for the Footer.','furnob' ),
	  'before_widget' => '<div class="klbfooterwidget widget %2$s">',
	  'after_widget'  => '</div>',
	  'before_title'  => '<h4 class="widget-title">',
	  'after_title'   => '</h4>'
	) );
}
add_action( 'widgets_init', 'furnob_widgets_init' );
 
/*************************************************
## Furnob Comment
*************************************************/

if ( ! function_exists( 'furnob_comment' ) ) :
 function furnob_comment( $comment, $args, $depth ) {
  $GLOBALS['comment'] = $comment;
  switch ( $comment->comment_type ) :
   case 'pingback' :
   case 'trackback' :
  ?>

   <article class="post pingback">
   <p><?php esc_html_e( 'Pingback:', 'furnob' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( '(Edit)', 'furnob' ), ' ' ); ?></p>
  <?php
    break;
   default :
  ?>
  
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment-avatar">
				<div class="comment-author vcard">
					<img src="<?php echo get_avatar_url( $comment, 90 ); ?>" alt="<?php comment_author(); ?>" class="avatar">
				</div>
			</div>
			<div class="comment-content">
				<div class="comment-meta">
					<b class="fn"><a class="url"><?php comment_author(); ?></a></b>
					<div class="comment-metadata">
						<time><?php comment_date(); ?></time>
					</div>
				</div>
				<div class="klb-post">
					<?php comment_text(); ?>
					<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php esc_html_e( 'Your comment is awaiting moderation.', 'furnob' ); ?></em>
					<?php endif; ?>
				</div>
				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div>
			</div>

		</div>
	</li>


  <?php
    break;
  endswitch;
 }
endif;

/*************************************************
## Furnob Widget Count Filter
 *************************************************/

function furnob_cat_count_span($links) {
  $links = str_replace('</a> (', '</a> <span class="catcount">(', $links);
  $links = str_replace(')', ')</span>', $links);
  return furnob_sanitize_data($links);
}
add_filter('wp_list_categories', 'furnob_cat_count_span');
 
function furnob_archive_count_span( $links ) {
	$links = str_replace( '</a>&nbsp;(', '</a><span class="catcount">(', $links );
	$links = str_replace( ')', ')</span>', $links );
	return furnob_sanitize_data($links);
}
add_filter( 'get_archives_link', 'furnob_archive_count_span' );


/*************************************************
## Pingback url auto-discovery header for single posts, pages, or attachments
 *************************************************/
function furnob_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'furnob_pingback_header' );

/************************************************************
## DATA CONTROL FROM PAGE METABOX OR ELEMENTOR PAGE SETTINGS
*************************************************************/
function furnob_page_settings( $opt_id){
	
	if ( class_exists( '\Elementor\Core\Settings\Manager' ) ) {
		// Get the current post id
		$post_id = get_the_ID();

		// Get the page settings manager
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );

		// Get the settings model for current post
		$page_settings_model = $page_settings_manager->get_model( $post_id );

		// Retrieve the color we added before
		$output = $page_settings_model->get_settings( 'furnob_elementor_'.$opt_id );
		
		return $output;
	}
}

/************************************************************
## Elementor Register Location
*************************************************************/
function furnob_register_elementor_locations( $elementor_theme_manager ) {

    $elementor_theme_manager->register_location( 'header' );
    $elementor_theme_manager->register_location( 'footer' );
    $elementor_theme_manager->register_location( 'single' );
	$elementor_theme_manager->register_location( 'archive' );

}
add_action( 'elementor/theme/register_locations', 'furnob_register_elementor_locations' );

/************************************************************
## Elementor Get Templates
*************************************************************/
function furnob_get_elementor_template($template_id){
	if($template_id){

	    $frontend = new \Elementor\Frontend;
	    printf( '<div class="furnob-elementor-template template-'.esc_attr($template_id).'">%1$s</div>', $frontend->get_builder_content_for_display( $template_id, true ) );
	
	    if ( class_exists( '\Elementor\Plugin' ) ) {
	        $elementor = \Elementor\Plugin::instance();
	        $elementor->frontend->enqueue_styles();
			$elementor->frontend->enqueue_scripts();
	    }
	
	    if ( class_exists( '\ElementorPro\Plugin' ) ) {
	        $elementor_pro = \ElementorPro\Plugin::instance();
	        $elementor_pro->enqueue_styles();
	    }

	}

}
add_action( 'furnob_before_main_shop', 'furnob_get_elementor_template', 10);
add_action( 'furnob_after_main_shop', 'furnob_get_elementor_template', 10);
add_action( 'furnob_before_main_footer', 'furnob_get_elementor_template', 10);
add_action( 'furnob_after_main_footer', 'furnob_get_elementor_template', 10);
add_action( 'furnob_before_main_header', 'furnob_get_elementor_template', 10);
add_action( 'furnob_after_main_header', 'furnob_get_elementor_template', 10);

/************************************************************
## Do Action for Templates and Product Categories
*************************************************************/
function furnob_do_action($hook){
	
	if ( !class_exists( 'woocommerce' ) ) {
		return;
	}

	$categorytemplate = get_theme_mod('furnob_elementor_template_each_shop_category');
	if(is_product_category()){
		if($categorytemplate && array_search(get_queried_object()->term_id, array_column($categorytemplate, 'category_id')) !== false){
			foreach($categorytemplate as $c){
				if($c['category_id'] == get_queried_object()->term_id){
					do_action( $hook, $c[$hook.'_elementor_template_category']);
				}
			}
		} else {
			do_action( $hook, get_theme_mod($hook.'_elementor_template'));
		}
	} else {
		do_action( $hook, get_theme_mod($hook.'_elementor_template'));
	}
	
}

/*************************************************
## Furnob Get Image
*************************************************/
function furnob_get_image($image){
	$app_image = ! wp_attachment_is_image($image) ? $image : wp_get_attachment_url($image);
	
	return esc_html($app_image);
}

/*************************************************
## Furnob Get options
*************************************************/
function furnob_get_option(){	
	$getopt  = isset( $_GET['opt'] ) ? $_GET['opt'] : '';

	return esc_html($getopt);
}

/*************************************************
## Furnob Theme options
*************************************************/

	require_once get_template_directory() . '/includes/metaboxes.php';
	require_once get_template_directory() . '/includes/woocommerce.php';
	require_once get_template_directory() . '/includes/woocommerce-filter.php';
	require_once get_template_directory() . '/includes/merlin/theme-register.php';
	require_once get_template_directory() . '/includes/merlin/setup-wizard.php';
	require_once get_template_directory() . '/includes/pjax/filter-functions.php';
	require_once get_template_directory() . '/includes/sanitize.php';
	require_once get_template_directory() . '/includes/header/main-header.php';
	require_once get_template_directory() . '/includes/footer/main-footer.php';
