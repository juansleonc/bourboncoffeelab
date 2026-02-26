<?php

namespace Elementor;

class Furnob_Home_Slider_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'furnob-home-slider';
    }
    public function get_title() {
        return 'Home Slider (K)';
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
		
		$this->add_control( 'slider_type',
			[
				'label' => esc_html__( 'Slider Type', 'furnob' ),
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

		$this->add_control( 'auto_play',
			[
				'label' => esc_html__( 'Auto Play', 'furnob-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'True', 'furnob-core' ),
				'label_off' => esc_html__( 'False', 'furnob-core' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);

        $this->add_control( 'auto_speed',
            [
                'label' => esc_html__( 'Auto Speed', 'furnob-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => '5000',
                'pleaceholder' => esc_html__( 'Set auto speed.', 'furnob-core' ),
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
				'default' => 'false',
			]
		);

		$defaultbg = plugins_url( 'images/home-slider.jpg', __DIR__ );
		
		$repeater = new Repeater();
        $repeater->add_control( 'slider_image',
            [
                'label' => esc_html__( 'Image', 'furnob' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control( 'slider_title',
            [
                'label' => esc_html__( 'Item Title', 'furnob-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Leave the season in Furnob style',
                'pleaceholder' => esc_html__( 'Enter item title here.', 'furnob-core' )
            ]
        );
		
        $repeater->add_control( 'slider_subtitle',
            [
                'label' => esc_html__( 'Item Subtitle', 'furnob-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => '10% Off All Items',
                'pleaceholder' => esc_html__( 'Enter item subtitle here.', 'furnob-core' )
            ]
        );
		
        $repeater->add_control( 'slider_desc',
            [
                'label' => esc_html__( 'Item Second Subtitle', 'furnob-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => 'Ut lobortis, ex vitae lobortis cursus, elit nisi facilisis urna, at porttitor eros leo ac ex. Nunc molestie turpis varius purus accumsan maximus. Nam ut libero aliquet.',
                'pleaceholder' => esc_html__( 'Enter item subtitle here.', 'furnob-core' )
            ]
        );

        $repeater->add_control( 'slider_btn_title',
            [
                'label' => esc_html__( 'Button Title', 'furnob-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Shop Collection',
                'pleaceholder' => esc_html__( 'Enter button title here', 'furnob-core' )
            ]
        );
        $repeater->add_control( 'slider_btn_link',
            [
                'label' => esc_html__( 'Button Link', 'furnob-core' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'placeholder' => esc_html__( 'Place URL here', 'furnob-core' )
            ]
        );
		
        $this->add_control( 'slider_items',
            [
                'label' => esc_html__( 'Slide Items', 'furnob-core' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
				
                    [
                        'slider_image' => ['url' => $defaultbg],
                        'slider_title' => 'Leave the season in Furnob style',
                        'slider_subtitle' => '10% Off All Items',
                        'slider_desc' => 'Ut lobortis, ex vitae lobortis cursus, elit nisi facilisis urna, at porttitor eros leo ac ex. Nunc molestie turpis varius purus accumsan maximus. Nam ut libero aliquet.',
                        'slider_btn_title' => 'Shop Collection',
                        'slider_btn_link' => '#',
                    ],
                    [
                        'slider_image' => ['url' => $defaultbg],
                        'slider_title' => 'Leave the season in Furnob style',
                        'slider_subtitle' => '10% Off All Items',
                        'slider_desc' => 'Ut lobortis, ex vitae lobortis cursus, elit nisi facilisis urna, at porttitor eros leo ac ex. Nunc molestie turpis varius purus accumsan maximus. Nam ut libero aliquet.',
                        'slider_btn_title' => 'Shop Collection',
                        'slider_btn_link' => '#',
                    ],
                    [
                        'slider_image' => ['url' => $defaultbg],
                        'slider_title' => 'Leave the season in Furnob style',
                        'slider_subtitle' => '10% Off All Items',
                        'slider_desc' => 'Ut lobortis, ex vitae lobortis cursus, elit nisi facilisis urna, at porttitor eros leo ac ex. Nunc molestie turpis varius purus accumsan maximus. Nam ut libero aliquet.',
                        'slider_btn_title' => 'Shop Collection',
                        'slider_btn_link' => '#',
                    ],

                ]
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
		
		$this->add_responsive_control( 'home_slider_alignment',
            [
                'label' => esc_html__( 'Alignment', 'furnob' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => ['{{WRAPPER}} .slider-inner' => 'text-align: {{VALUE}};'],
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
				'selector' => '{{WRAPPER}} .slider-image img',
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
               'selectors' => ['{{WRAPPER}} .entry-title' => 'color: {{VALUE}};']
			]
        );
		
		$this->add_control( 'title_hvrcolor',
			[
               'label' => esc_html__( 'Title Hover Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .entry-title:hover' => 'color: {{VALUE}};']
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
                'selectors' => ['{{WRAPPER}} .entry-title ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .entry-title',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .entry-title',
				
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
               'selectors' => ['{{WRAPPER}} .entry-teaser' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'subtitle_hvrcolor',
           [
               'label' => esc_html__( 'Subtitle Hover Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .entry-teaser:hover' => 'color: {{VALUE}};']
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
                'selectors' => ['{{WRAPPER}} .entry-teaser ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'subtitle_text_shadow',
				'selector' => '{{WRAPPER}} .entry-teaser',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .entry-teaser',
				
            ]
        );
		
		$this->add_control( 'second_subtitle_heading',
            [
                'label' => esc_html__( 'SECOND SUBTITLE', 'furnob-core' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'second_subtitle_color',
			[
               'label' => esc_html__( 'Second Subtitle Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .entry-content' => 'color: {{VALUE}};']
			]
        );
		
		$this->add_control( 'second_subtitle_hvrcolor',
			[
               'label' => esc_html__( 'Second Subtitle Hover Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .entry-content:hover' => 'color: {{VALUE}};']
			]
        );
		
		$this->add_control( 'second_subtitle_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'furnob-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .entry-content ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'second_subtitle_text_shadow',
				'selector' => '{{WRAPPER}} .entry-content',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'second_subtitle_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .entry-content',
				
            ]
        );
		
		$this->end_controls_section();
		/*****   END CONTROLS SECTION   ******/
		
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('btn_styling',
            [
                'label' => esc_html__( ' Button Style', 'furnob' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
		
		$this->add_responsive_control( 'btn_padding',
            [
                'label' => esc_html__( 'Padding', 'furnob-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} a.btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],              
            ]
        );
  	    
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'btn_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} a.btn '
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
                'selectors' => ['{{WRAPPER}} a.btn' => 'opacity: {{VALUE}} ;'],
            ]
        );

		$this->start_controls_tabs('btn_tabs');
        $this->start_controls_tab( 'btn_normal_tab',
            [ 'label' => esc_html__( 'Normal', 'furnob-core' ) ]
        );
		
		$this->add_control( 'btn_color',
            [
                'label' => esc_html__( 'Color', 'furnob-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} a.btn' => 'color: {{VALUE}};']
            ]
        );
       
	    $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'label' => esc_html__( 'Border', 'furnob-core' ),
                'selector' => '{{WRAPPER}} a.btn ',
            ]
        );
        
		$this->add_responsive_control( 'btn_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'furnob-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} a.btn ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'],
            ]
        );
       
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_background',
                'label' => esc_html__( 'Background', 'furnob-core' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} a.btn',
            ]
        );
       
		$this->end_controls_tab(); //btn_normal_tab
		
        $this->start_controls_tab('btn_hover_tab',
            [ 'label' => esc_html__( 'Hover', 'furnob-core' ) ]
        );
       
	    $this->add_control( 'btn_hvrcolor',
            [
                'label' => esc_html__( 'Color', 'furnob-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} a.btn:hover ' => 'color: {{VALUE}};']
            ]
        );
		
		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_hvr_border',
                'label' => esc_html__( 'Border', 'furnob-core' ),
                'selector' => '{{WRAPPER}} a.btn:hover ',
            ]
        );
        
		$this->add_responsive_control( 'btn_hvr_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'furnob-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} a.btn:hover ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'],
            ]
        );
		
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_hvr_background',
                'label' => esc_html__( 'Background', 'furnob-core' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} a.btn:hover',
            ]
        );
		
		$this->end_controls_tab(); //btn_hover_tab
		
        $this->end_controls_tabs(); //btn_tabs
		
		$this->end_controls_section();
		/*****   END CONTROLS SECTION   ******/
		
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( $settings['slider_items'] ) {

			if($settings['slider_type'] == 'type3'){
				$module = 'full-screen header-spacing';
				$alignment = 'content-center';
				$button = 'square';
			}elseif($settings['slider_type'] == 'type2'){
				$module = '';
				$alignment = 'content-center';
				$button = 'square';
			} else {
				$module = 'small';
				$alignment = 'content-left';
				$button = '';
			}


			echo '<div class="site-module module-slider '.$module.'">';
			echo '<div class="module-body">';
			echo '<div class="site-slider owl-carousel" data-desktop="1" data-tablet="1" data-mobile="1" data-speed="600" data-loop="true" data-gutter="0" data-dots="'.esc_attr($settings['dots']).'" data-nav="'.esc_attr($settings['arrows']).'" data-autoplay="'.esc_attr($settings['auto_play']).'" data-autospeed="'.esc_attr($settings['auto_speed']).'" data-autostop="false">';
			
			foreach ( $settings['slider_items'] as $item ) {
				$target = $item['slider_btn_link']['is_external'] ? ' target="_blank"' : '';
				$nofollow = $item['slider_btn_link']['nofollow'] ? ' rel="nofollow"' : '';
			
				echo '<div class="slider-item">';
				echo '<div class="slider-content '.esc_attr($alignment).'">';
				echo '<div class="slider-inner">';
				echo '<h4 class="entry-teaser">'.esc_html($item['slider_subtitle']).'</h4>';
				echo '<h2 class="entry-title">'.esc_html($item['slider_title']).'</h2>';
				echo '<div class="entry-content">';
				echo '<p>'.esc_html($item['slider_desc']).'</p>';
				echo '</div><!-- entry-content -->';
				if($item['slider_btn_title']){
					echo '<div class="content-buttons">';
					echo '<a href="'.esc_url($item['slider_btn_link']['url']).'" '.esc_attr($target.$nofollow).' class="btn btn-white '.esc_attr($button).'">'.esc_html($item['slider_btn_title']).' <i class="klbth-icon-right-arrow"></i></a>';
					echo '</div><!-- content-buttons -->';
				}
				echo '</div><!-- slider-inner -->';
				echo '</div><!-- slider-content -->';
				echo '<div class="slider-image"><img src="'.esc_url($item['slider_image']['url']).'" alt="slide"/></div>';
				echo '</div><!-- slider-item -->';

			}
			
			echo '</div>';
			echo '</div>';
			echo '</div>';

		}
	}

}

