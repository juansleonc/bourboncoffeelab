<?php

namespace Elementor;

class Furnob_Image_Points_Widget extends Widget_Base {

    public function get_name() {
        return 'furnob-image-points';
    }
    public function get_title() {
        return 'Image Points (K)';
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
				'label' => esc_html__( 'Content', 'plugin-name' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$defaultimage = plugins_url( 'images/image-point.jpg', __DIR__ );
		
        $this->add_control( 'image',
            [
                'label' => esc_html__( 'Image', 'furnob' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => $defaultimage],
            ]
        );
		
        $this->add_control( 'title',
            [
                'label' => esc_html__( 'Title', 'furnob' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Make room for more friends, more family, more fun',
                'description'=> 'Add a title.',
				'label_block' => true,
            ]
        );
		
        $this->add_control( 'subtitle',
            [
                'label' => esc_html__( 'Subtitle', 'furnob' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Room For More',
                'description'=> 'Add a subtitle.',
				'label_block' => true,
            ]
        );
		
        $this->add_control( 'desc',
            [
                'label' => esc_html__( 'Description', 'furnob' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'In hac habitasse platea dictumst. Aenean lectus diam, tempus nec luctus vel, ultricies non augue. Nulla ac libero sit amet orci laoreet lobortis tristique quis.',
                'description'=> 'Add a subtitle.',
				'label_block' => true,
            ]
        );

		
        $this->add_control( 'btn_title',
            [
                'label' => esc_html__( 'Button Title', 'furnob-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Shop Collection',
                'pleaceholder' => esc_html__( 'Enter button title here', 'furnob-core' ),
            ]
        );
		
        $this->add_control( 'btn_link',
            [
                'label' => esc_html__( 'Button Link', 'furnob-core' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'placeholder' => esc_html__( 'Place URL here', 'furnob-core' )
            ]
        );
		
		$repeater = new Repeater();
		
		$repeater->add_control(
			'point_position_left',
			[
				'label' => esc_html__( 'Point Position Left', 'plugin-name' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 61,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$repeater->add_control(
			'point_position_top',
			[
				'label' => esc_html__( 'Point Position Top', 'plugin-name' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 57,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
        $repeater->add_control( 'point_title',
            [
                'label' => esc_html__( 'Title', 'furnob' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Title Here',
                'description'=> 'Add a title.',
				'label_block' => true,
            ]
        );
		
        $repeater->add_control( 'point_desc',
            [
                'label' => esc_html__( 'Description', 'furnob' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Description Here',
                'description'=> 'Add a subtitle.',
				'label_block' => true,
            ]
        );

		
        $repeater->add_control( 'point_btn_title',
            [
                'label' => esc_html__( 'Button Title', 'furnob-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Shop Collection',
                'pleaceholder' => esc_html__( 'Enter button title here', 'furnob-core' ),
            ]
        );
		
        $repeater->add_control( 'point_btn_link',
            [
                'label' => esc_html__( 'Button Link', 'furnob-core' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'placeholder' => esc_html__( 'Place URL here', 'furnob-core' )
            ]
        );
		
        $repeater->add_control( 'point_image',
            [
                'label' => esc_html__( 'Image', 'furnob' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );
		
        $this->add_control( 'image_point_items',
            [
                'label' => esc_html__( 'Points', 'furnob-core' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
						'point_position_left' => '61%',
						'point_position_top' => '57%',
                    ],

                ]
            ]
        );
		
		$this->end_controls_section();
		/*****   END CONTROLS SECTION   ******/
		
        /*****   START CONTROLS SECTION   ******/
		
		$this->start_controls_section('furnob_styling',
            [
                'label' => esc_html__( ' Content Style', 'furnob' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
		
		$this->add_responsive_control( 'image_points_alignment',
            [
                'label' => esc_html__( 'Alignment', 'furnob' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => ['{{WRAPPER}} .text-inner' => 'text-align: {{VALUE}};'],
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'furnob' ),
                        'icon' => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'furnob' ),
                        'icon' => 'eicon-text-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'furnob' ),
                        'icon' => 'eicon-text-align-right'
                    ]
                ],
                'toggle' => true,
                
            ]
        );
		
		$this->add_control( 'image_heading',
            [
                'label' => esc_html__( 'IMAGE', 'furnob-core' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .image-wrapper img',
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
               'selectors' => ['{{WRAPPER}} .text-block .entry-title' => 'color: {{VALUE}};']
			]
        );
		
		$this->add_control( 'title_hvrcolor',
			[
               'label' => esc_html__( 'Title Hover Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .text-block .entry-title:hover' => 'color: {{VALUE}};']
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
                'selectors' => ['{{WRAPPER}} .text-block .entry-title ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .text-block .entry-title',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .text-block .entry-title',
				
            ]
        );
		
		$this->add_control( 'subtitle_heading',
            [
                'label' => esc_html__( 'SUBTITLE', 'furnob-core' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'subtitle_color',
           [
               'label' => esc_html__( 'Subtitle Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .text-block .entry-subtitle' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'subtitle_hvrcolor',
           [
               'label' => esc_html__( 'Subtitle Hover Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .text-block .entry-subtitle:hover' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'subtitle_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'furnob-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .text-block .entry-subtitle ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'subtitle_text_shadow',
				'selector' => '{{WRAPPER}} .text-block .entry-subtitle',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .text-block .entry-subtitle',
				
            ]
        );
		
		$this->add_control( 'desc_heading',
            [
                'label' => esc_html__( 'DESCRIPTION', 'furnob-core' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'desc_color',
           [
               'label' => esc_html__( 'Description Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .text-block .entry-content' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'desc_hvrcolor',
           [
               'label' => esc_html__( 'Description Hover Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .text-block .entry-content:hover' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'desc_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'furnob-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .text-block .entry-content ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'desc_text_shadow',
				'selector' => '{{WRAPPER}} .text-block .entry-content',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .text-block .entry-content',
				
            ]
        );
		
		$this->add_control( 'btn_heading',
            [
                'label' => esc_html__( 'BUTTON', 'furnob-core' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'btn_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .text-block a.btn '
            ]
        );
		
		$this->add_control( 'btn_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'furnob-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .text-block a.btn' => 'opacity: {{VALUE}} ;'],
            ]
        );
		
		$this->add_control( 'btn_color',
            [
                'label' => esc_html__( 'Color', 'furnob-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .text-block a.btn' => 'color: {{VALUE}};']
            ]
        );
       
	    $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'label' => esc_html__( 'Border', 'furnob-core' ),
                'selector' => '{{WRAPPER}} .text-block a.btn ',
            ]
        );
        
		$this->add_responsive_control( 'btn_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'furnob-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .text-block a.btn ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'],
            ]
        );
		
		$this->add_responsive_control( 'btn_padding',
            [
                'label' => esc_html__( 'Padding', 'furnob-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .text-block a.btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],              
            ]
        );
       
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_background',
                'label' => esc_html__( 'Background', 'furnob-core' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .text-block a.btn',
            ]
        );
		
		$this->end_controls_section();
		/*****   END CONTROLS SECTION   ******/
		
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('points_styling',
            [
                'label' => esc_html__( ' Points Style', 'furnob' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
		
		$this->add_control( 'points_background_color',
           [
               'label' => esc_html__( 'Circle Background Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .point .point-circle' => 'background-color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'points_color',
            [
                'label' => esc_html__( 'Color', 'furnob-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .point .point-circle' => 'color: {{VALUE}};']
            ]
        );
		
		$this->add_control( 'content_background_color',
           [
               'label' => esc_html__( 'Content Background Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .point .point-content' => 'background-color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'points_title_heading',
            [
                'label' => esc_html__( 'TITLE', 'furnob-core' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'points_title_color',
			[
               'label' => esc_html__( 'Title Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .point-content .entry-title' => 'color: {{VALUE}};']
			]
        );
		
		$this->add_control( 'points_title_hvrcolor',
			[
               'label' => esc_html__( 'Title Hover Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .point-content .entry-title:hover' => 'color: {{VALUE}};']
			]
        );
		
		$this->add_control( 'points_title_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'furnob-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .point-content .entry-title ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'points_title_text_shadow',
				'selector' => '{{WRAPPER}} .point-content .entry-title',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'points_title_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .point-content .entry-title',
				
            ]
        );
		
		$this->add_control( 'points_desc_heading',
            [
                'label' => esc_html__( 'DESCRIPTION', 'furnob-core' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'points_desc_color',
           [
               'label' => esc_html__( 'Description Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .point-content .entry-description' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'points_desc_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'furnob-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .point-content .entry-description ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'points_desc_text_shadow',
				'selector' => '{{WRAPPER}} .point-content .entry-description',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'points_desc_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .point-content .entry-description',
				
            ]
        );
		
		$this->add_control( 'points_btn_heading',
            [
                'label' => esc_html__( 'BUTTON', 'furnob-core' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'points_btn_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .point-content a.btn '
            ]
        );
		
		$this->add_control( 'points_btn_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'furnob-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .point-content a.btn' => 'opacity: {{VALUE}} ;'],
            ]
        );
		
		$this->add_control( 'points_btn_color',
            [
                'label' => esc_html__( 'Color', 'furnob-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .point-content a.btn' => 'color: {{VALUE}};']
            ]
        );
       
	    $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'points_btn_border',
                'label' => esc_html__( 'Border', 'furnob-core' ),
                'selector' => '{{WRAPPER}} .point-content a.btn ',
            ]
        );
        
		$this->add_responsive_control( 'points_btn_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'furnob-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .point-content a.btn ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'],
            ]
        );
		
		$this->add_responsive_control( 'points_btn_padding',
            [
                'label' => esc_html__( 'Padding', 'furnob-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .point-content a.btn ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],              
            ]
        );
       
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'points_btn_background',
                'label' => esc_html__( 'Background', 'furnob-core' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .point-content a.btn ',
            ]
        );
		
			
		$this->end_controls_section();
		/*****   END CONTROLS SECTION   ******/

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$target = $settings['btn_link']['is_external'] ? ' target="_blank"' : '';
		$nofollow = $settings['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
		
		$output = '';


		echo '<div class="site-module module-image-points">';
		echo '<div class="module-body">';
		echo '<div class="text-content">';
		echo '<div class="text-inner">';
		echo '<div class="text-block style-1">';
		echo '<h4 class="entry-subtitle">'.esc_html($settings['subtitle']).'</h4>';
		echo '<h2 class="entry-title">'.esc_html($settings['title']).'</h2>';
		echo '<div class="entry-content">';
		echo '<p>'.esc_html($settings['desc']).'</p>';
		echo '</div><!-- entry-content -->';
		if($settings['btn_title']){
		echo '<a href="'.esc_url($settings['btn_link']['url']).'" '.esc_attr($target.$nofollow).' class="btn link">'.esc_html($settings['btn_title']).' <i class="klbth-icon-right-arrow"></i></a>';
		}
		echo '</div>';
		echo '</div><!-- text-inner -->';
		echo '</div><!-- text-content -->';
		
		if ( $settings['image_point_items'] ) {
			echo '<div class="point-wrapper">';
			echo '<div class="image-points">';
				  
			foreach($settings['image_point_items'] as $point){
				$point_target = $point['point_btn_link']['is_external'] ? ' target="_blank"' : '';
				$point_nofollow = $point['point_btn_link']['nofollow'] ? ' rel="nofollow"' : '';
				
				echo '<div class="point dropdown elementor-repeater-item-'.esc_attr($point['_id']).'">';
				echo '<span class="point-circle dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="klbth-icon-plus"></i></span>';
				echo '<div class="point-content dropdown-menu">';
				if($point['point_image']['url']){
				echo '<div class="image"><a href="'.esc_url($point['point_btn_link']['url']).'"><img src="'.esc_url($point['point_image']['url']).'" alt="point"></a></div>';
				}
				echo '<div class="detail">';
				echo '<h4 class="entry-title">'.esc_attr($point['point_title']).'</h4>';
				echo '<div class="entry-description">';
				echo '<p>'.esc_attr($point['point_desc']).'</p>';
				echo '</div><!-- entry-description -->';
				echo '<a href="'.esc_url($point['point_btn_link']['url']).'" '.esc_attr($point_target.$point_nofollow).' class="btn link">'.esc_html($point['point_btn_title']).' <i class="klbth-icon-right-arrow"></i></a>';
				echo '</div><!-- detail -->';
				echo '</div><!-- point-content -->';
				echo '</div><!-- point -->';
			}

					
			echo '</div><!-- image-points -->';
			echo '<div class="image-wrapper"><img src="'.esc_url($settings['image']['url']).'" alt="points"></div>';
			echo '</div><!-- point-wrapper -->';
		}
			
		echo '</div><!-- module-body -->';
		echo '</div><!-- site-module -->';


	}

}
