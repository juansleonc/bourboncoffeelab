<?php

namespace Elementor;

class Furnob_Product_Categories_Widget extends Widget_Base {
    use Furnob_Helper;
	
    public function get_name() {
        return 'furnob-product-categories';
    }
    public function get_title() {
        return 'Product Categories (K)';
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
				'label' => esc_html__( 'Content', 'furnob-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control( 'category_type',
			[
				'label' => esc_html__( 'Category Type', 'furnob' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'image',
				'options' => [
					'select-type' => esc_html__( 'Select Type', 'furnob' ),
					'image'	  => esc_html__( 'Image', 'furnob' ),
					'icon'	  => esc_html__( 'Icon', 'furnob' ),
				],
			]
		);		
		
		$this->start_controls_tabs('cat_exclude_include_tabs');
        $this->start_controls_tab( 'cat_exclude_tab',
            [ 'label' => esc_html__( 'Exclude Category', 'furnob-core' ) ]
        );
		
        $this->add_control( 'cat_filter',
            [
                'label' => esc_html__( 'Exclude Category', 'furnob-core' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->furnob_cpt_taxonomies('product_cat'),
                'description' => 'Select Category(s)',
                'default' => '',
                'label_block' => true,
            ]
        );
       
		$this->end_controls_tab(); // cat_exclude_tab
		
        $this->start_controls_tab('cat_include_tab',
            [ 'label' => esc_html__( 'Include Category', 'furnob-core' ) ]
        );
       
        $this->add_control( 'include_category',
            [
                'label' => esc_html__( 'Include Category', 'furnob-core' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->furnob_cpt_taxonomies('product_cat'),
                'description' => 'Select Category(s)',
                'default' => '',
                'label_block' => true,
            ]
        );
		
		$this->end_controls_tab(); // cat_include_tab 

		$this->end_controls_tabs(); // cat_exclude_include_tabs
		
		$this->add_control( 'column',
			[
				'label' => esc_html__( 'Column', 'shopwise' ),
				'type' => Controls_Manager::SELECT,
				'default' => '6',
				'options' => [
					'0' => esc_html__( 'Select Column', 'shopwise' ),
					'2' 	  => esc_html__( '2 Columns', 'shopwise' ),
					'3'		  => esc_html__( '3 Columns', 'shopwise' ),
					'4'		  => esc_html__( '4 Columns', 'shopwise' ),
					'5'		  => esc_html__( '5 Columns', 'shopwise' ),
					'6'		  => esc_html__( '6 Columns', 'shopwise' ),
					'7'		  => esc_html__( '7 Columns', 'shopwise' ),
					'8'		  => esc_html__( '8 Columns', 'shopwise' ),
					'9'		  => esc_html__( '9 Columns', 'shopwise' ),
					'10'	  => esc_html__( '10 Columns', 'shopwise' ),
				],
			]
		);
		
		$this->add_control( 'mobile_column',
			[
				'label' => esc_html__( 'Mobile Column', 'shopwise' ),
				'type' => Controls_Manager::SELECT,
				'default' => '2',
				'options' => [
					'0' => esc_html__( 'Select Column', 'shopwise' ),
					'1' 	  => esc_html__( '1 Columns', 'shopwise' ),
					'2' 	  => esc_html__( '2 Columns', 'shopwise' ),
					'3'		  => esc_html__( '3 Columns', 'shopwise' ),
					'4'		  => esc_html__( '4 Columns', 'shopwise' ),
				],
			]
		);

		$this->add_control( 'auto_play',
			[
				'label' => esc_html__( 'Auto Play', 'furnob-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'True', 'furnob-core' ),
				'label_off' => esc_html__( 'False', 'furnob-core' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);
		
        $this->add_control( 'auto_speed',
            [
                'label' => esc_html__( 'Auto Speed', 'chakta' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => '1600',
                'pleaceholder' => esc_html__( 'Set auto speed.', 'chakta' ),
				'condition' => ['auto_play' => 'true']
            ]
        );
		
		$this->add_control( 'dots',
			[
				'label' => esc_html__( 'Dots', 'furnob-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'True', 'furnob-core' ),
				'label_off' => esc_html__( 'False', 'furnob-core' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
		
		$this->add_control( 'arrows',
			[
				'label' => esc_html__( 'Arrows', 'furnob-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'True', 'furnob-core' ),
				'label_off' => esc_html__( 'False', 'furnob-core' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);

        $this->add_control( 'slide_speed',
            [
                'label' => esc_html__( 'Slide Speed', 'furnob-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => '600',
                'pleaceholder' => esc_html__( 'Set slide speed.', 'furnob-core' ),
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
                'default' => 'ASC'
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
                'default' => 'menu_order',
            ]
        );
		
		$this->end_controls_section();
		/*****   END CONTROLS SECTION   ******/
		
        /*****   START CONTROLS SECTION   ******/
		
		$this->start_controls_section('furnob_styling',
            [
                'label' => esc_html__( ' Style', 'furnob' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
		
		$this->add_control( 'image_heading',
            [
                'label' => esc_html__( 'IMAGE', 'furnob-core' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => ['category_type' => ['image','select-type']],
            ]
        );
		
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .category-image img',
				'condition' => ['category_type' => ['image','select-type']],
			]
		);
		
		$this->add_control( 'icon_heading',
            [
                'label' => esc_html__( 'ICON', 'furnob-core' ),
                'type' => Controls_Manager::HEADING,
				'condition' => ['category_type' => ['icon']],
            ]
        );
		
		$this->add_responsive_control( 'icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'furnob-core' ),
                'type' => Controls_Manager::SLIDER,
                'min' => 0,
                'max' => 100,
                'selectors' => [ '{{WRAPPER}} .module-categories.icon .category-image i' => 'font-size: {{SIZE}}px;' ],
				'condition' => ['category_type' => ['icon']],
            ]
        );
		
		$this->add_control( 'icon_color',
           [
               'label' => esc_html__( 'Icon Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .module-categories.icon .category-image i' => 'color: {{VALUE}};'],
			   'condition' => ['category_type' => ['icon']],
           ]
        );
		
		$this->add_control( 'icon_hvrcolor',
           [
               'label' => esc_html__( 'Icon Hover Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .module-categories.icon .category-image i:hover' => 'color: {{VALUE}};'],
			   'condition' => ['category_type' => ['icon']],
           ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'icon_text_shadow',
				'selector' => '{{WRAPPER}} .module-categories.icon .category-image i',
				'condition' => ['category_type' => ['icon']],
			]
		);
		
		$this->add_control( 'icon_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'furnob-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}}  .module-categories.icon .category-image i' => 'opacity: {{VALUE}};'],
				'condition' => ['category_type' => ['icon']],
				
            ]
        );
		
		$this->add_control( 'title_heading',
            [
                'label' => esc_html__( 'TITLE', 'furnob-core' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'title_color',
			[
               'label' => esc_html__( 'Title Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .entry-category a ' => 'color: {{VALUE}};']
			]
        );
		
		$this->add_control( 'title_hvrcolor',
			[
               'label' => esc_html__( 'Title Hover Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .module-categories.image .category-item:hover .entry-category a , {{WRAPPER}} .entry-category a:hover ' => 'color: {{VALUE}};']
			]
        );
		
		$this->add_control( 'title_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'furnob-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .entry-category a ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .entry-category a ',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .entry-category a ',
				
            ]
        );
		
		$this->add_control( 'count_heading',
            [
                'label' => esc_html__( 'COUNT', 'furnob-core' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'count_color',
           [
               'label' => esc_html__( 'Count Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .category-item .count' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'count_hvrcolor',
           [
               'label' => esc_html__( 'Count Hover Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .category-item .count:hover' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'count_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'furnob-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .category-item .count ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'count_text_shadow',
				'selector' => '{{WRAPPER}} .category-item .count',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'count_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .category-item .count',
				
            ]
        );
		
		$this->end_controls_section();
		/*****   END CONTROLS SECTION   ******/

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if($settings['cat_filter'] || $settings['include_category']){
			$terms = get_terms( array(
				'taxonomy' => 'product_cat',
				'hide_empty' => true,
				'parent'    => 0,
				'exclude'   => $settings['cat_filter'],
				'include'   => $settings['include_category'],
				'order'          => $settings['order'],
				'orderby'        => $settings['orderby']
			) );
		} else {
			$terms = get_terms( array(
				'taxonomy' => 'product_cat',
				'hide_empty' => true,
				'parent'    => 0,
				'order'          => $settings['order'],
				'orderby'        => $settings['orderby']
			) );
		}
		
		if($settings['category_type'] == 'icon'){
			echo '<div class="site-module module-categories icon">';
			echo '<div class="module-body">';
			echo '<div class="site-slider carousel owl-carousel" data-desktop="'.esc_attr($settings['column']).'" data-tablet="4" data-mobile="'.esc_attr($settings['mobile_column']).'" data-speed="'.esc_attr($settings['slide_speed']).'" data-loop="true" data-gutter="30" data-dots="'.esc_attr($settings['dots']).'" data-nav="'.esc_attr($settings['arrows']).'" data-autoplay="'.esc_attr($settings['auto_play']).'" data-autospeed="'.esc_attr($settings['auto_speed']).'" data-autostop="true">';

			foreach ( $terms as $term ) {
				$term_data = get_option('taxonomy_'.$term->term_id);
				$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
				$image = wp_get_attachment_url( $thumbnail_id );
				$term_children = get_term_children( $term->term_id, 'product_cat' );

				echo '<div class="category-item">';
				if(isset($term_data['product_cat_icon'])){
				echo '<div class="category-image color-third"><a href="'.esc_url(get_term_link( $term )).'"><i class="'.esc_attr($term_data['product_cat_icon']).'"></i></a></div>';
				}
				echo '<div class="category-detail">';
				echo '<h3 class="entry-category"><a href="'.esc_url(get_term_link( $term )).'">'.esc_html($term->name).'</a></h3>';
				echo '<span class="count">'.esc_html($term->count).' '.esc_html__('Items','furnob-core').'</span>';
				echo '</div><!-- category-detail -->';
				echo '</div><!-- category-item -->';

			}
		
			echo '</div>';
			echo '</div>';
			echo '</div>';
		} else {
			echo '<div class="site-module module-categories image">';
			echo '<div class="module-body">';
			echo '<div class="site-slider carousel owl-carousel" data-desktop="'.esc_attr($settings['column']).'" data-tablet="4" data-mobile="'.esc_attr($settings['mobile_column']).'" data-speed="'.esc_attr($settings['slide_speed']).'" data-loop="true" data-gutter="30" data-dots="'.esc_attr($settings['dots']).'" data-nav="'.esc_attr($settings['arrows']).'" data-autoplay="'.esc_attr($settings['auto_play']).'" data-autospeed="'.esc_attr($settings['auto_speed']).'" data-autostop="true">';

			foreach ( $terms as $term ) {
				$term_data = get_option('taxonomy_'.$term->term_id);
				$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
				$image = wp_get_attachment_url( $thumbnail_id );
				$term_children = get_term_children( $term->term_id, 'product_cat' );

				echo '<div class="category-item">';
				if($image){
				echo '<div class="category-image"><a href="'.esc_url(get_term_link( $term )).'"><img src="'.esc_url($image).'" alt="'.esc_attr($term->name).'"></a></div>';
				}
				echo '<div class="category-detail">';
				echo '<h3 class="entry-category"><a href="'.esc_url(get_term_link( $term )).'">'.esc_html($term->name).'</a></h3>';
				echo '<span class="count">'.esc_html($term->count).' '.esc_html__('Items','furnob-core').'</span>';
				echo '</div><!-- category-detail -->';
				echo '</div>';

			}
		
			echo '</div>';
			echo '</div>';
			echo '</div>';
		}

		
	}

}
