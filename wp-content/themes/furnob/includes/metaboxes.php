<?php

/*************************************************
## furnob Metabox
*************************************************/

if ( ! function_exists( 'rwmb_meta' ) ) {
  function rwmb_meta( $key, $args = '', $post_id = null ) {
   return false;
  }
 }

add_filter( 'rwmb_meta_boxes', 'furnob_register_page_meta_boxes' );

function furnob_register_page_meta_boxes( $meta_boxes ) {
	
$prefix = 'klb_';
$meta_boxes = array();


/* ----------------------------------------------------- */
// Product Data
/* ----------------------------------------------------- */

$meta_boxes[] = array(
	'id' => 'klb_product_settings',
	'title' => esc_html__('Product Data','furnob'),
	'pages' => array( 'product' ),
	'context' => 'side',
	'priority' => 'high',

	// List of meta fields
	'fields' => array(
		
		array(
			'name'		=> esc_html__('Badge if on sale','furnob'),
			'id'		=> $prefix . 'product_badge',
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> ''
		),
				
	)
);

/* ----------------------------------------------------- */
// Product Specification Tab
/* ----------------------------------------------------- */

$meta_boxes[] = [
	'id'      => 'klb_product_size_chart_tab',
	'title'   => esc_html__( 'Product Size Chart', 'furnob' ),
	'pages' => array( 'product' ),
	'context' => 'normal',
	'priority' => 'low',
	'fields'  => [
		[
			'type'    => 'wysiwyg',
			'id'      => $prefix . 'product_size_chart',
		],
	],
];

/* ----------------------------------------------------- */
// Blog Post Slides Metabox
/* ----------------------------------------------------- */

$meta_boxes[] = array(
	'id'		=> 'klb-blogmeta-gallery',
	'title'		=> esc_html__('Blog Post Image Slides','furnob'),
	'pages'		=> array( 'post' ),
	'context' => 'normal',

	'fields'	=> array(
		array(
			'name'	=> esc_html__('Blog Post Slider Images','furnob'),
			'desc'	=> esc_html__('Upload unlimited images for a slideshow - or only one to display a single image.','furnob'),
			'id'	=> $prefix . 'blogitemslides',
			'type'	=> 'image_advanced',
		)
		
	)
);

/* ----------------------------------------------------- */
// Blog Audio Post Settings
/* ----------------------------------------------------- */
$meta_boxes[] = array(
	'id' => 'klb-blogmeta-audio',
	'title' => esc_html('Audio Settings','furnob'),
	'pages' => array( 'post'),
	'context' => 'normal',

	// List of meta fields
	'fields' => array(	
		array(
			'name'		=> esc_html('Audio Code','furnob'),
			'id'		=> $prefix . 'blogaudiourl',
			'desc'		=> esc_html__('Enter your Audio URL(Oembed) or Embed Code.','furnob'),
			'clone'		=> false,
			'type'		=> 'textarea',
			'std'		=> '',
			'sanitize_callback' => 'none'
		),
	)
);



/* ----------------------------------------------------- */
// Blog Video Metabox
/* ----------------------------------------------------- */
$meta_boxes[] = array(
	'id'		=> 'klb-blogmeta-video',
	'title'		=> esc_html__('Blog Video Settings','furnob'),
	'pages'		=> array( 'post' ),
	'context' => 'normal',

	'fields'	=> array(
		array(
			'name'		=> esc_html__('Video Type','furnob'),
			'id'		=> $prefix . 'blog_video_type',
			'type'		=> 'select',
			'options'	=> array(
				'youtube'		=> esc_html__('Youtube','furnob'),
				'vimeo'			=> esc_html__('Vimeo','furnob'),
				'own'			=> esc_html__('Own Embed Code','furnob'),
			),
			'multiple'	=> false,
			'std'		=> array( 'no' ),
			'sanitize_callback' => 'none'
		),
		array(
			'name'	=> furnob_sanitize_data(__('Embed Code<br />(Audio Embed Code is possible, too)','furnob')),
			'id'	=> $prefix . 'blog_video_embed',
			'desc'	=> furnob_sanitize_data(__('Just paste the ID of the video (E.g. http://www.youtube.com/watch?v=<strong>GUEZCxBcM78</strong>) you want to show, or insert own Embed Code. <br />This will show the Video <strong>INSTEAD</strong> of the Image Slider.<br /><strong>Of course you can also insert your Audio Embedd Code!</strong>','furnob')),
			'type' 	=> 'textarea',
			'std' 	=> "",
			'cols' 	=> "40",
			'rows' 	=> "8"
		)
	)
);

return $meta_boxes;
}
