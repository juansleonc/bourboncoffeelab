<?php

namespace Elementor;

class Furnob_Home_Image_Widget extends Widget_Base {

    public function get_name() {
        return 'furnob-home-image';
    }
    public function get_title() {
        return 'Home Image (K)';
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
		
		$this->add_control( 'image_type',
			[
				'label' => esc_html__( 'Image Type', 'furnob' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'type1',
				'options' => [
					'select-type' => esc_html__( 'Select Type', 'furnob' ),
					'type1'	  => esc_html__( 'Type 1', 'furnob' ),
					'type2'	  => esc_html__( 'Type 2', 'furnob' ),
				],
			]
		);	

		$defaultimage = plugins_url( 'images/home-image.jpg', __DIR__ );
		$titleimage = plugins_url( 'images/title-image.png', __DIR__ );
		
		
        $this->add_control( 'image',
            [
                'label' => esc_html__( 'Image', 'furnob' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => $defaultimage],
            ]
        );
		
        $this->add_control( 'title_first',
            [
                'label' => esc_html__( 'Title First', 'furnob' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Leave the',
                'description'=> 'Add a title.',
				'label_block' => true,
            ]
        );
		
        $this->add_control( 'title_image',
            [
                'label' => esc_html__( 'Title Image', 'furnob' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => $titleimage],
				'condition' => ['image_type' => ['type1','select-type']],
            ]
        );
		
        $this->add_control( 'title_second',
            [
                'label' => esc_html__( 'Title Second', 'furnob' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'in Furnob style',
                'description'=> 'Add a title.',
				'label_block' => true,
				'condition' => ['image_type' => ['type1','select-type']],
            ]
        );
		
        $this->add_control( 'subtitle',
            [
                'label' => esc_html__( 'Subtitle', 'furnob' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '2021 Top Quality Award',
                'description'=> 'Add a subtitle.',
				'label_block' => true,
            ]
        );
		
        $this->add_control( 'desc',
            [
                'label' => esc_html__( 'Description', 'furnob' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Ut lobortis, ex vitae lobortis cursus, elit nisi facilisis urna, at porttitor eros leo ac ex. 
                    Nunc molestie turpis varius purus accumsan maximus. Nam ut libero aliquet, 
                    consequat ipsum sit amet, aliquet odio.',
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
		
		$this->end_controls_section();
		/*****   END CONTROLS SECTION   ******/
		
        /*****   START CONTROLS SECTION   ******/
		
		$this->start_controls_section('furnob_styling',
            [
                'label' => esc_html__( ' Style', 'furnob' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
		
		$this->add_control( 'background_color',
           [
               'label' => esc_html__( 'Background Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '#f6f6f6',
               'selectors' => ['{{WRAPPER}} .klb-home-image' => 'background-color: {{VALUE}};']
           ]
        );
		
		$this->add_responsive_control( 'home_image_alignment',
            [
                'label' => esc_html__( 'Alignment', 'furnob' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => ['{{WRAPPER}} .text-block' => 'text-align: {{VALUE}};'],
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
				'selector' => '{{WRAPPER}} .image-block img',
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
               'selectors' => ['{{WRAPPER}} .entry-subtitle' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'subtitle_hvrcolor',
           [
               'label' => esc_html__( 'Subtitle Hover Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .entry-subtitle:hover' => 'color: {{VALUE}};']
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
                'selectors' => ['{{WRAPPER}} .entry-subtitle ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'subtitle_text_shadow',
				'selector' => '{{WRAPPER}} .entry-subtitle',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .entry-subtitle',
				
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
               'selectors' => ['{{WRAPPER}} .entry-content' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'desc_hvrcolor',
           [
               'label' => esc_html__( 'Description Hover Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .entry-content:hover' => 'color: {{VALUE}};']
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
                'selectors' => ['{{WRAPPER}} .entry-content ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'desc_text_shadow',
				'selector' => '{{WRAPPER}} .entry-content',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typo',
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
		$target = $settings['btn_link']['is_external'] ? ' target="_blank"' : '';
		$nofollow = $settings['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
		$starimage = plugins_url( 'images/star.png', __DIR__ );
		
		$output = '';		
		
		if($settings['image_type'] == 'type2'){
			echo '<div class="klb-home-image pt-30 d-pt-120 pb-30 d-pb-120">';
			echo '<div class="container">';
			echo '<div class="row align-items-center">';
			echo '<div class="col col-12 col-md-6">';
			echo '<div class="text-block style-2">';
			echo '<h4 class="entry-subtitle">'.furnob_sanitize_data($settings['subtitle']).'</h4>';
			echo '<h2 class="entry-title large color-third">'.esc_html($settings['title_first']).' </h2>';
			echo '<div class="entry-content">';
			echo '<p>'.esc_html($settings['desc']).'</p>';
			echo '</div><!-- entry-content -->';
			echo '<a href="'.esc_url($settings['btn_link']['url']).'" '.esc_attr($target.$nofollow).' class="btn transparent btn-white square">'.esc_html($settings['btn_title']).' <i class="klbth-icon-right-arrow"></i></a>';
			echo '</div><!-- text-block -->';
			echo '</div><!-- col -->';
			echo '<div class="col col-12 col-md-6">';
			echo '<div class="image-block"><img src="'.esc_url($settings['image']['url']).'" alt="banner"></div>';
			echo '</div><!-- col -->';
			echo '</div><!-- row -->';
			echo '</div><!-- container -->';
			echo '</div><!-- background-cream -->';
		} else {
			echo '<div class="klb-home-image background-dark-gray  pt-30 d-pt-80 pb-30 d-pb-80">';
			echo '<div class="container">';
			echo '<div class="row align-items-center reverse">';
			echo '<div class="col col-12 col-md-6">';
			echo '<div class="image-block"><img src="'.esc_url($settings['image']['url']).'" alt="banner"></div>';
			echo '</div><!-- col -->';
			echo '<div class="col col-12 col-md-6">';
			echo '<div class="text-block style-1">';
			echo '<h4 class="entry-subtitle"><img src="'.esc_url($starimage).'"> '.esc_html($settings['subtitle']).'</h4>';
			echo '<h2 class="entry-title">'.esc_html($settings['title_first']);
			if($settings['title_image']['url']){
			echo ' <img src="'.esc_url($settings['title_image']['url']).'"> '; 
			}
			echo esc_html($settings['title_second']);
			
			echo '</h2>';
			echo '<div class="entry-content">';
			echo '<p>'.esc_html($settings['desc']).'</p>';
			echo '</div><!-- entry-content -->';
			echo '<a href="'.esc_url($settings['btn_link']['url']).'" '.esc_attr($target.$nofollow).' class="btn transparent btn-white square">'.esc_html($settings['btn_title']).' <i class="klbth-icon-right-arrow"></i></a>';
			echo '</div><!-- text-block -->';
			echo '</div><!-- col -->';
			echo '</div><!-- row -->';
			echo '</div><!-- container -->';
			echo '</div><!-- background-gray -->';
		}


	}

}
