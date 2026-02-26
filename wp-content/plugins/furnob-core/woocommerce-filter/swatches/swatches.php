<?php
/**
* KlbTheme_Swatches
*/
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
if ( ! class_exists( 'KlbTheme_Swatches' ) && class_exists( 'WC_Product' ) ) {
    class KlbTheme_Swatches {
        function __construct()
        {
            add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'backend_scripts' ) );

            add_shortcode( 'klbtheme_swatches', array( $this, 'archive_shortcode' ) );
            // add field for attributes
            add_filter( 'product_attributes_type_selector', array( $this, 'type_selector' ) );

            $attrs = wc_get_attribute_taxonomies();

            foreach ( $attrs as $attr ) {
                $name = $attr->attribute_name;
                add_action( 'pa_' . $name . '_add_form_fields', array($this,'show_field') );
                add_action( 'pa_' . $name . '_edit_form_fields', array( $this,'show_field') );
                add_action( 'create_pa_' . $name, array($this,'save_field') );
                add_action( 'edited_pa_' . $name, array( $this, 'save_field' ) );
                add_filter( "manage_edit-pa_{$name}_columns", array($this,'custom_columns') );
                add_filter( "manage_pa_{$name}_custom_column", array($this,'custom_columns_content'), 10, 3 );
            }

            add_filter( 'woocommerce_dropdown_variation_attribute_options_html', array($this,'variation_attribute_options_html'), 199, 2 );

            // ajax add to cart
            add_action( 'wp_ajax_product_attribute_add_to_cart', array( $this, 'add_to_cart' ) );
            add_action( 'wp_ajax_nopriv_product_attribute_add_to_cart', array( $this, 'add_to_cart' ) );

        }

        public function frontend_scripts()
        {
            wp_enqueue_script( 'wc-add-to-cart-variation' );
            wp_enqueue_style( 'klbtheme-swatches', plugins_url( 'css/swatches.css', __FILE__ ), '1.0' );
            wp_enqueue_script( 'klbtheme-swatches', plugins_url( 'js/swatches.js', __FILE__ ), array( 'jquery' ), '1.0', true );
        }

        public function backend_scripts()
        {
            wp_enqueue_script( 'klbtheme-backend', plugins_url( 'js/backend.js', __FILE__ ), array('jquery','wp-color-picker'), '1.0', true );
            wp_localize_script( 'klbtheme-backend', 'product_attribute_vars', array('placeholder_img' => wc_placeholder_img_src()) );
        }

        public function archive_shortcode( $atts )
        {
            $atts = shortcode_atts( array(
                'id' => null,
            ), $atts, 'klbtheme_swatches' );

            ob_start();
            $this->archive_swatches( $atts['id'] );
            return ob_get_clean();
        }

        public function add_to_cart()
        {
            if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'klbtheme-special-string' ) ) {
                die( esc_html__( 'Permissions check failed', 'furnob-core' ) );
            }

            $product_id   = (int) $_POST['product_id'];
            $variation_id = (int) $_POST['variation_id'];
            $quantity     = (float) $_POST['quantity'];
            $variation    = (array) json_decode( stripslashes( $_POST['attributes'] ) );

            if ( $product_id && $variation_id ) {
                $item_key = WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation );

                if ( ! empty( $item_key ) ) {
                    echo true;
                }
            }
            die();
        }

        public function type_selector( $types )
        {
            global $pagenow;

            if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( $pagenow === 'post-new.php' ) || ( $pagenow === 'post.php' )  ) {
                return $types;
            } else {
                $types['color']  = esc_html__( 'Color', 'furnob-core' );
                $types['image']  = esc_html__( 'Image', 'furnob-core' );
                $types['button']  = esc_html__( 'Button', 'furnob-core' );

                return $types;
            }
        }

        public function show_field( $term_or_tax )
        {
            if ( is_object( $term_or_tax ) ) {
                // is term
                $term_id    = $term_or_tax->term_id;
                $attr_id    = wc_attribute_taxonomy_id_by_name( $term_or_tax->taxonomy );
                $attr_info  = wc_get_attribute( $attr_id );
                $html_start = '<tr class="form-field"><th><label>';
                $html_mid   = '</label></th><td>';
                $html_end   = '</td></tr>';
            } else {
                // is taxonomy
                $term_id    = 0;
                $attr_id    = wc_attribute_taxonomy_id_by_name( $term_or_tax );
                $attr_info  = wc_get_attribute( $attr_id );
                $html_start = '<div class="form-field"><label>';
                $html_mid   = '</label>';
                $html_end   = '</div>';
            }
            $type = $attr_info->type;

            $value   = get_term_meta( $term_id, 'product_attribute_'.$type, true ) ? : '';

            if ( $type == 'color' ) {
                echo $html_start . esc_html__( 'Color', 'furnob-core' ) . $html_mid . '<input class="product_attribute_color" id="product_attribute_color" name="product_attribute_color" value="' . esc_attr( $value ) . '" type="text"/>' . $html_end;
            }
            if ( $type == 'image' ) {
                wp_enqueue_media();
                $image = $value ? wp_get_attachment_thumb_url( $value ) : wc_placeholder_img_src();

                echo $html_start . 'Image' . $html_mid; ?>
                    <div id="product_attribute_image_thumbnail">
                        <img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px"/>
                    </div>
                    <div id="product_attribute_image_wrapper">
                        <input type="hidden" id="product_attribute_image" name="product_attribute_image" value="<?php echo esc_attr( $value ); ?>"/>
                        <button id="product_attribute_upload_image" type="button" class="product_attribute_upload_image button"><?php esc_html_e( 'Upload/Add image', 'furnob-core' ); ?></button>
                        <button id="product_attribute_remove_image" type="button" class="product_attribute_remove_image button"><?php esc_html_e( 'Remove image', 'furnob-core' ); ?></button>
                    </div>
                <?php
                echo $html_end;
            }

            if ( $type == 'button' ) {
                echo $html_start . esc_html__( 'Label', 'furnob-core' ) . $html_mid . '<input id="product_attribute_button" name="product_attribute_button" value="' . esc_attr( $value ) . '" type="text"/>' . $html_end;
            }
        }

        public function save_field( $term_id )
        {
            $terms = [
                'product_attribute_color',
                'product_attribute_image',
                'product_attribute_button'
            ];
            foreach ( $terms as $term ) {
                if ( isset( $_POST[$term] ) ) {
                    update_term_meta( $term_id, $term, sanitize_text_field( $_POST[$term] ) );
                }
            }
        }

        public function variation_attribute_options_html( $html, $args )
        {
            $term_html = '';
            $attr_id   = wc_attribute_taxonomy_id_by_name( $args['attribute'] );
			
			$options               = $args['options'];
			$product               = $args['product'];
			$attribute             = $args['attribute'];

            if ( $attr_id ) {
                $attr_info    = wc_get_attribute( $attr_id );
                $curr['type'] = isset( $attr_info->type ) ? $attr_info->type : '';
                $curr['slug'] = isset( $attr_info->slug ) ? $attr_info->slug : '';
                $curr['name'] = isset( $attr_info->name ) ? $attr_info->name : '';

                if ( $curr['type'] == 'color' || $curr['type'] == 'image' || $curr['type'] == 'button' ) {
                    $term_html .= '<div class="klbtheme-terms klbtheme-type-'.esc_attr( $curr['type'] ).'" data-attribute="'.esc_attr( $args['attribute'] ).'">';
					
					if ( $product && taxonomy_exists( $attribute ) ) {
						$terms = wc_get_product_terms(
							$product->get_id(),
							$attribute,
							array(
								'fields' => 'all',
							)
						);

						foreach ( $terms as $term ) {
							if ( in_array( $term->slug, $options, true ) ) {
								$name    = get_term_meta( $term->term_id, 'product_attribute_'.$curr['type'], true ) ? : '';
								$val     = get_term_meta( $term->term_id, 'product_attribute_'.$curr['type'], true ) ? : '';
								$img     = $val ? wp_get_attachment_thumb_url( $val ) : wc_placeholder_img_src();
								$style   =  $curr['type'] == 'color' && ! empty( $val ) ? ' style="background-color:' . esc_attr( $val ) . '"' : '';

								if ( $curr['type'] == 'color' || $curr['type'] == 'button' ) {
									$term_html .= '<span class="klbtheme-term" data-term="'.esc_attr( $term->slug ).'"'.$style.'>'.esc_html( $term->name ).'</span>';
								}
								if ( $curr['type'] == 'image' ) {
									$term_html .= '<span class="klbtheme-term" data-term="'.esc_attr( $term->slug ).'"><img src="'.esc_url( $img ).'" alt="'.esc_attr( $term->name ).'"/></span>';
								}
									
							}
						}
					}

                    $term_html .= '</div>';
                }
            }
            return $term_html . $html;
        }

        public function custom_columns( $columns )
        {
            $columns['product_attribute_value']   = esc_html__( 'Value', 'furnob-core' );

            return $columns;
        }

        public function custom_columns_content( $columns, $column, $term_id )
        {
            if ( 'product_attribute_value' === $column ) {
                $term = get_term( $term_id );
                $id   = wc_attribute_taxonomy_id_by_name( $term->taxonomy );
                $attr = wc_get_attribute( $id );

                switch ( $attr->type ) {
                    case 'image':
                    $val = get_term_meta( $term_id, 'product_attribute_image', true );
                    echo '<img class="klbtheme-column-item" src="' . esc_url( wp_get_attachment_thumb_url( $val ) ) . '"/>';
                    break;

                    case 'color':
                    $val = get_term_meta( $term_id, 'product_attribute_color', true );
                    echo '<span class="klbtheme-column-item" style="background-color: ' . esc_attr( $val ) . '; display:block; height:20px;"></span>';
                    break;
                }
            }
        }

        public function archive_swatches( $product_id = null )
        {
            if ( $product_id ) {
                $product = wc_get_product( $product_id );
            } else {
                global $product;
            }

            if ( ! $product || ! $product->is_type( 'variable' ) ) {
                return;
            }

            $attributes = $product->get_variation_attributes();
            $var_av     = $product->get_available_variations();
            $var_json   = wp_json_encode( $var_av );
            $var_attr   = function_exists( 'wc_esc_json' ) ? wc_esc_json( $var_json ) : _wp_specialchars( $var_json, ENT_QUOTES, 'UTF-8', true );

            if ( is_array( $attributes ) && ( count( $attributes ) > 0 ) ) {
                echo '<div class="variations_form klbtheme-loop-swatches" data-product_id="' . absint( $product->get_id() ) . '" data-product_variations="' . $var_attr . '">';
                    echo '<div class="klbtheme-variations variations">';

                    foreach ( $attributes as $name => $opts ) { ?>
                        <div class="klbtheme-variations-items klbtheme-flex klbtheme-align-center variation">
                            <div class="klbtheme-small-title label"><?php echo wc_attribute_label( $name ); ?></div>
                            <div class="select">
                                <?php
                                $attr     = 'attribute_' . sanitize_title( $name );
                                $selected = isset( $_REQUEST[ $attr ] ) ? wc_clean( stripslashes( urldecode( $_REQUEST[ $attr ] ) ) ) : $product->get_variation_default_attribute( $name );
                                wc_dropdown_variation_attribute_options( array(
                                    'options'          => $opts,
                                    'attribute'        => $name,
                                    'product'          => $product,
                                    'selected'         => $selected,
                                    'show_option_none' => esc_html__( 'Choose', 'furnob-core' ) . ' ' . wc_attribute_label( $name )
                                ) );
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    echo '<div class="klbtheme-reset-variations">' . apply_filters( 'woocommerce_reset_variations_link', '<a class="klbtheme-btn-reset reset_variations" href="#">' . esc_html__( 'Clear', 'furnob-core' ) . '</a>' ) . '</div>';
                    echo '</div>';
                echo '</div>';
            }
        }
    }
    new KlbTheme_Swatches();
}
