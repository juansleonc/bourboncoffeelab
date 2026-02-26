<?php 
/*************************************************
## Admin style and scripts  
*************************************************/ 
function furnob_product360_admin_scripts() {
    wp_enqueue_script('klb-product360', plugins_url( 'js/product360-admin.js', __FILE__ ), false, '1.0');
    wp_enqueue_style('klb-product360', plugins_url( 'css/product360-admin.css', __FILE__ ), false, '1.0');
}
add_action( 'admin_enqueue_scripts', 'furnob_product360_admin_scripts' );

/*************************************************
## style and scripts  
*************************************************/ 
function furnob_product360_scripts() {
    wp_register_style('klb-product360', plugins_url( 'css/product360.css', __FILE__ ), false, '1.0');
	wp_register_script( 'threeSixty',   plugins_url( 'js/threeSixty.js', __FILE__ ), false, '1.0');
	wp_register_script( 'klb-product360',   plugins_url( 'js/product360.js', __FILE__ ), false, '1.0');
}
add_action( 'wp_enqueue_scripts', 'furnob_product360_scripts' );

/*************************************************
## Add Meta Boxes in product
*************************************************/ 

if( ! function_exists( 'furnob_product_360_view_meta' ) ) {
	function furnob_product_360_view_meta() {
		add_meta_box( 'woocommerce-product360-images', esc_html__( 'Product 360 View', 'furnob-core' ), 'furnob_360_metabox_output', 'product', 'side', 'low' );
	}
	add_action( 'add_meta_boxes', 'furnob_product_360_view_meta', 50 );
}

/*************************************************
## Add 360 product view images option
*************************************************/ 

if( ! function_exists( 'furnob_360_metabox_output' ) ) {
	function furnob_360_metabox_output( $post ) {
		?>
		<div id="product_360_images_container">
			<ul class="product_360_images">
				<?php
					$product_image_gallery = array();

					if ( metadata_exists( 'post', $post->ID, '_product_360_image_gallery' ) ) {
						$product_image_gallery = get_post_meta( $post->ID, '_product_360_image_gallery', true );
					} else {
						// Backwards compat
						$attachment_ids = get_posts( 'post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids&meta_key=_woocommerce_360_image&meta_value=1' );
						$attachment_ids = array_diff( $attachment_ids, array( get_post_thumbnail_id() ) );
						$product_image_gallery = implode( ',', $attachment_ids );
					}

					$attachments         = array_filter( explode( ',', $product_image_gallery ) );
					$update_meta         = false;
					$updated_gallery_ids = array();

					if ( ! empty( $attachments ) ) {
						foreach ( $attachments as $attachment_id ) {
							$attachment = wp_get_attachment_image( $attachment_id, 'thumbnail' );

							// if attachment is empty skip
							if ( empty( $attachment ) ) {
								$update_meta = true;
								continue;
							}

							echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
								' . $attachment . '
								<ul class="actions">
									<li><a href="#" rel="nofollow" class="delete tips" data-tip="' . esc_attr__( 'Delete image', 'furnob-core' ) . '">' . esc_html__( 'Delete', 'furnob-core' ) . '</a></li>
								</ul>
							</li>';

							// rebuild ids to be saved
							$updated_gallery_ids[] = $attachment_id;
						}

						// need to update product meta to set new gallery ids
						if ( $update_meta ) {
							update_post_meta( $post->ID, '_product_360_image_gallery', implode( ',', $updated_gallery_ids ) );
						}
					}
				?>
			</ul>

			<input type="hidden" id="product_360_image_gallery" name="product_360_image_gallery" value="<?php echo esc_attr( $product_image_gallery ); ?>" />

		</div>
		<p class="add_product_360_images hide-if-no-js">
			<a href="#" rel="nofollow" data-choose="<?php esc_attr_e( 'Add Images to Product 360 view Gallery', 'furnob-core' ); ?>" data-update="<?php esc_attr_e( 'Add to gallery', 'furnob-core' ); ?>" data-delete="<?php esc_attr_e( 'Delete image', 'furnob-core' ); ?>" data-text="<?php esc_attr_e( 'Delete', 'furnob-core' ); ?>"><?php esc_html_e( 'Add product 360 view gallery images', 'furnob-core' ); ?></a>
		</p>
		<?php

	}
}

/*************************************************
## Save metaboxes
*************************************************/ 

if( ! function_exists( 'furnob_proccess_360_view_metabox' ) ) {
	add_action( 'woocommerce_process_product_meta', 'furnob_proccess_360_view_metabox', 50, 2 );
	function furnob_proccess_360_view_metabox( $post_id, $post ) {
		$attachment_ids = isset( $_POST['product_360_image_gallery'] ) ? array_filter( explode( ',', wc_clean( $_POST['product_360_image_gallery'] ) ) ) : array();

		update_post_meta( $post_id, '_product_360_image_gallery', implode( ',', $attachment_ids ) );
	}
}

/*************************************************
## Returns the 360 view gallery attachment ids
*************************************************/ 

if( ! function_exists( 'furnob_get_360_gallery_attachment_ids' ) ) {
	function furnob_get_360_gallery_attachment_ids() {
		global $post;

		if( ! $post ) return;

		$product_image_gallery = get_post_meta( $post->ID, '_product_360_image_gallery', true);

		return apply_filters( 'woocommerce_product_360_gallery_attachment_ids', array_filter( array_filter( (array) explode( ',', $product_image_gallery ) ), 'wp_attachment_is_image' ) );
	}
}

/*************************************************
## Product 360 View frontend
*************************************************/ 
if( ! function_exists( 'furnob_product_360_view' ) ) {
	function furnob_product_360_view() {
		$images = furnob_get_360_gallery_attachment_ids();
		if( empty( $images ) ) return;

		$id = rand(100,999);

		$title = '';

		wp_enqueue_style('klb-product360');
		wp_enqueue_script('threeSixty');
		wp_enqueue_script('klb-product360');

		if ( count( $images ) < 1 ) {
			return;
		}
		
		$image_data = wp_get_attachment_image_src( $images[0], 'full' );
		
		$args = [
			'frames_count' => count( $images ),
			'images'       => [],
			'width'        => $image_data[1],
			'height'       => $image_data[2],
		];
		
		foreach ( $images as $key => $image ) {
			$args['images'][] = wp_get_attachment_image_url( $image, 'full' );
		}

		?>
			<div class="klb-product360-btn">
				<a href="#product360-view"><span><?php esc_html_e('360 product view', 'furnob-core'); ?></span></a>
			</div>
			<div id="product360-view" class="white-popup mfp-hide mfp-with-anim">
				<div class="klb-360-view klb-product-360 klb-360-id-<?php echo esc_attr( $id ); ?>" data-args='<?php echo wp_json_encode( $args ); ?>'>
					<ul class="klb-360-view-images"></ul>
				    <div class="spinner">
				        <span>0%</span>
				    </div>
				</div>
			</div>
		<?php
	}
}
add_action('woocommerce_product_thumbnails','furnob_product_360_view',20);
