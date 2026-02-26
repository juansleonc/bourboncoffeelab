<?php

namespace Elementor;

class Furnob_Product_Grid_Widget extends Widget_Base {
    use Furnob_Helper;

    public function get_name() {
        return 'furnob-product-grid';
    }
    public function get_title() {
        return 'Product Grid (K)';
    }
    public function get_icon() {
        return 'eicon-slider-push';
    }
    public function get_categories() {
        return [ 'furnob' ];
    }

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'furnob' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control( 'product_type',
			[
				'label' => esc_html__( 'Product Type', 'furnob' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'type1',
				'options' => [
					'select-type' => esc_html__( 'Select Type', 'furnob' ),
					'type1'	  => esc_html__( 'Type 1', 'furnob' ),
					'type2'	  => esc_html__( 'Type 2', 'furnob' ),
					'type3'	  => esc_html__( 'Type 3', 'furnob' ),
				],
			]
		);
		
		$this->add_control( 'column',
			[
				'label' => esc_html__( 'Column', 'furnob-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '4',
				'options' => [
					'0' => esc_html__( 'Select Column', 'furnob-core' ),
					'2' 	  => esc_html__( '2 Columns', 'furnob-core' ),
					'3'		  => esc_html__( '3 Columns', 'furnob-core' ),
					'4'		  => esc_html__( '4 Columns', 'furnob-core' ),
					'5'		  => esc_html__( '5 Columns', 'furnob-core' ),
					'6'		  => esc_html__( '6 Columns', 'furnob-core' ),
				],
			]
		);
		
		$this->add_control( 'mobile_column',
			[
				'label' => esc_html__( 'Mobile Column', 'furnob-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '2',
				'options' => [
					'0' => esc_html__( 'Select Column', 'furnob-core' ),
					'1' 	  => esc_html__( '1 Column', 'furnob-core' ),
					'2'		  => esc_html__( '2 Columns', 'furnob-core' ),
				],
			]
		);

        // Posts Per Page
        $this->add_control( 'post_count',
            [
                'label' => esc_html__( 'Posts Per Page', 'furnob-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => count( get_posts( array('post_type' => 'product', 'post_status' => 'publish', 'fields' => 'ids', 'posts_per_page' => '-1') ) ),
                'default' => 8
            ]
        );
		
        $this->add_control( 'cat_filter',
            [
                'label' => esc_html__( 'Filter Category', 'furnob-core' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->furnob_cpt_taxonomies('product_cat'),
                'description' => 'Select Category(s)',
                'default' => '',
				'label_block' => true,
            ]
        );
		
        $this->add_control( 'post_include_filter',
            [
                'label' => esc_html__( 'Include Post', 'furnob-core' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->furnob_cpt_get_post_title('product'),
                'description' => 'Select Post(s) to Include',
				'label_block' => true,
            ]
        );
		
        $this->add_control( 'order',
            [
                'label' => esc_html__( 'Select Order', 'furnob-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ASC' => esc_html__( 'Ascending', 'furnob-core' ),
                    'DESC' => esc_html__( 'Descending', 'furnob-core' )
                ],
                'default' => 'DESC'
            ]
        );
		
        $this->add_control( 'orderby',
            [
                'label' => esc_html__( 'Order By', 'furnob-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'id' => esc_html__( 'Post ID', 'furnob-core' ),
                    'menu_order' => esc_html__( 'Menu Order', 'furnob-core' ),
                    'rand' => esc_html__( 'Random', 'furnob-core' ),
                    'date' => esc_html__( 'Date', 'furnob-core' ),
                    'title' => esc_html__( 'Title', 'furnob-core' ),
                ],
                'default' => 'date',
            ]
        );

		$this->add_control( 'on_sale',
			[
				'label' => esc_html__( 'On Sale Products?', 'furnob-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'True', 'furnob-core' ),
				'label_off' => esc_html__( 'False', 'furnob-core' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);

		$this->add_control( 'hide_out_of_stock_items',
			[
				'label' => esc_html__( 'Hide Out of Stock?', 'furnob-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'True', 'furnob-core' ),
				'label_off' => esc_html__( 'False', 'furnob-core' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);
		
		$this->add_control( 'featured',
			[
				'label' => esc_html__( 'Featured Products?', 'furnob-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'True', 'furnob-core' ),
				'label_off' => esc_html__( 'False', 'furnob-core' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);
		
		$this->add_control( 'best_selling',
			[
				'label' => esc_html__( 'Best Selling Products?', 'furnob-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'True', 'furnob-core' ),
				'label_off' => esc_html__( 'False', 'furnob-core' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);
		
		$this->end_controls_section();
		/*****   END CONTROLS SECTION   ******/

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$output = '';

		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}
	
		$args = array(
			'post_type' => 'product',
			'posts_per_page' => $settings['post_count'],
			'order'          => 'DESC',
			'post_status'    => 'publish',
			'paged' 			=> $paged,
            'post__in'       => $settings['post_include_filter'],
            'order'          => $settings['order'],
			'orderby'        => $settings['orderby']
		);
	
		$args['klb_special_query'] = true;
	
		if($settings['hide_out_of_stock_items']== 'true'){
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'outofstock',
					'operator' => 'NOT IN',
				),
			); // WPCS: slow query ok.
		}

		if($settings['cat_filter']){
			$args['tax_query'][] = array(
				'taxonomy' 	=> 'product_cat',
				'field' 	=> 'term_id',
				'terms' 	=> $settings['cat_filter']
			);
		}

		if($settings['best_selling']== 'true'){
			$args['meta_key'] = 'total_sales';
			$args['orderby'] = 'meta_value_num';
		}

		if($settings['featured'] == 'true'){
			$args['tax_query'] = array( array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => array( 'featured' ),
					'operator' => 'IN',
			) );
		}
		
		if($settings['on_sale'] == 'true'){
			$args['meta_key'] = '_sale_price';
			$args['meta_value'] = array('');
			$args['meta_compare'] = 'NOT IN';
		}
		

		$output .= '<ul class="products spacing grid-views mobile-'.esc_attr($settings['mobile_column']).' column-'.esc_attr($settings['column']).'">';
		
		$loop = new \WP_Query( $args );
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();
				global $product;
				global $post;
				global $woocommerce;
				
				$output .= '<li class="product">';

				if($settings['product_type'] == 'type3'){
				$output .= furnob_product_type3();
				} elseif($settings['product_type'] == 'type2'){
				$output .= furnob_product_type2();
				} else {
				$output .= furnob_product_type1();
				}
				$output .= '</li>';
			
			endwhile;
		}
		wp_reset_postdata();
		
		$output .= '</ul>';



		echo $output;
	}

}
