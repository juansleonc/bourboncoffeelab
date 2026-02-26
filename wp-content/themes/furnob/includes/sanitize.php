<?php

/*************************************************
## Furnob Sanitize
*************************************************/ 

function furnob_sanitize_data( $string ) {
	$klb_allowed_tags = array(
			'a' => array(
				'href' => array(),
				'title' => array(),
				'class' => array(),
				'style' => array(),
				'data-image' => array(),
				'data-zoom-image' => array(),
				'productid' => array(),
				'data-tinv-wl-list' => array(),
				'data-tinv-wl-product' => array(),
				'data-tinv-wl-productvariation' => array(),
				'data-tinv-wl-action' => array(),
				'data-tinv-wl-producttype' => array(),
				'target' => array('_blank', '_top'),
				'id' => array(),
				'rel' => array(),

			),
			'br' => array(),
			'em' => array(),
			'strong' => array(
				'class' => array(),
				'style' => array(),
			 ),
			'div' => array(		
				  'class' => array(),
				  'id' => array(),
				  'tabindex' => array(),
				  'role' => array(),
				  'style' => array('display'),
			 ),
			'figcaption' => array(),
			'p' => array(
				'class' => array(),
			 ),
			'li' => array(
				'class' => array(),
			 ),
			'ul' => array(
				'class' => array(),
			 ),
			 'ol' => array(
				'class' => array(),
				'id' => array(),
			 ),
			'span' => array(
				'class' => array(),
				'data-countdown' => array(),
				'style' => array(),
			 ),
			'h1' => array(
				'class' => array(),
			 ),
			'h2' => array(
				'class' => array(),
			 ),
			'h3' => array(
				'class' => array(),
			 ),
			'h4' => array(
				'class' => array(),
			 ),
			'h5' => array(
				'class' => array(),
			 ),			 
			'h6' => array(
				'class' => array(),
			 ),
			'i' => array(
				'class' => array(),
			 ),
			'img' => array(
				'id' => array(),
				'class' => array(),
				'src' => array(),
				'width' => array(),
				'height' => array(),
				'alt' => array(),
				'data-zoom-image' => array(),
				'data-image' => array(),
				'srcset' => array(),
			 ),

			 'figure' => array(
				'class' => array(),
				'data-bg-img' => array(),
			 ),
			 'del' => array(),
			 'ins' => array(),
			 'bdi' => array(),
			 'script' => array(),
			 'input' => array(
				'type' => array(),
				'name' => array(),
				'placeholder' => array(),
				'required' => array(),
				'value' => array(),
				'class' => array(),
				'id' => array(),
				'tabindex' => array(),
				'autocomplete' => array(),
				'max' => array(),
			 ),
			 'button' => array(
				'class' => array(),
				'data-toggle' => array(),
				'data-target' => array(),
				'onclick' => array(),
				'aria-label' => array(),
				'data-dismiss' => array(),
				'type' => array(),
				'name' => array(),
				'value' => array(),
			 ),
			 'form' => array(
				'class' => array(),
				'id' => array(),
				'method' => array(),
				'data-id' => array(),
				'data-name' => array(),
				'action' => array(),
				'enctype' => array(),
			 ),
			 'label' => array(
				'style' => array(),
			 ),
			 'nav' => array(
				'class' => array(),
			 ),
			'table' => array(
				'class' => array(),
			),
			'tbody' => array(),
			'tr' => array(),
			'td' => array(),
			'th' => array(),

		);

	return wp_kses( $string, $klb_allowed_tags );
}

add_filter( 'safe_style_css', function( $styles ) {
    $styles[] = 'display';
    return $styles;
} );

?>