<?php


/*************************************************
## Add  New Field to the Store Taxonomy Page
*************************************************/ 

add_action( 'category_add_form_fields', 'furnob_product_cat_add_new_meta_field', 10, 2 );
function furnob_product_cat_add_new_meta_field() {
    ?>
		<?php wp_enqueue_media(); ?>

    <div class="form-field">
        <label for="term_meta[product_cat_icon]"><?php esc_html_e( 'Category Icon', 'furnob' ); ?></label>
		<input type='text' name='term_meta[product_cat_icon]' id='image_attachment_id'>
	</div>
<?php
}
// Add fields on custom taxonomies
add_action( 'product_cat_add_form_fields', 'furnob_product_cat_add_new_meta_field');


/*************************************************
## Add  New Field to the Store Edit Taxonomy Page
*************************************************/ 

add_action( 'category_edit_form_fields', 'furnob_product_cat_edit_meta_field', 10, 2 );
function furnob_product_cat_edit_meta_field($term) {
 
    // put the term ID into a variable
    $t_id = $term->term_id;
 
    // retrieve the existing value(s) for this meta field. This returns an array
    $term_meta = get_option( "taxonomy_$t_id" ); ?>
	
	<?php wp_enqueue_media(); ?>
		
    <tr class="form-field">
		<th scope="row" valign="top">
			<label for="term_meta[product_cat_icon]"><?php esc_html_e( 'Category Icon', 'furnob' ); ?></label>
		</th>
		<td>
			<input type='text' name='term_meta[product_cat_icon]' id='image_attachment_id' value='<?php if(isset($term_meta['product_cat_icon'])) { ?><?php echo esc_attr( $term_meta['product_cat_icon'] ) ? esc_attr( $term_meta['product_cat_icon'] ) : ''; ?><?php } ?>'>
		</td>
    </tr>
<?php
}
add_action( 'product_cat_edit_form_fields', 'furnob_product_cat_edit_meta_field');



/*************************************************
## Save extra taxonomy fields callback function.
*************************************************/ 

add_action( 'edited_category', 'furnob_save_product_cat_custom_meta', 10, 2 );
add_action( 'create_category', 'furnob_save_product_cat_custom_meta', 10, 2 );
 
function furnob_save_product_cat_custom_meta( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $t_id = $term_id;
        $term_meta = get_option( "taxonomy_$t_id" );
        $cat_keys = array_keys( $_POST['term_meta'] );
        foreach ( $cat_keys as $key ) {
            if ( isset ( $_POST['term_meta'][$key] ) ) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        // Save the option array.
        update_option( "taxonomy_$t_id", $term_meta );
	

    }
}

// Add fields on custom taxonomies
add_action( 'create_product_cat', 'furnob_save_product_cat_custom_meta');
add_action( 'edited_product_cat', 'furnob_save_product_cat_custom_meta');

/*************************************************
## Add Product Categories in Coupon Page.
*************************************************/ 
add_action('init','furnob_coupon_product_category');
function furnob_coupon_product_category(){
    register_taxonomy_for_object_type('product_cat', 'shop_coupon');
}