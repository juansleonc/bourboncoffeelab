<?php

namespace Elementor;

class Furnob_Testimonial_Carousel_Widget extends Widget_Base {

    public function get_name() {
        return 'furnob-testimonial-carousel';
    }
    public function get_title() {
        return 'Testimonial Carousel (K)';
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
		
		$this->add_control( 'column',
			[
				'label' => esc_html__( 'Column', 'furnob-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
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
				'default' => '1',
				'options' => [
					'0' => esc_html__( 'Select Column', 'furnob-core' ),
					'1' 	  => esc_html__( '1 Column', 'furnob-core' ),
					'2'		  => esc_html__( '2 Columns', 'furnob-core' ),
					'3'		  => esc_html__( '3 Columns', 'furnob-core' ),
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
		
		$defaultbg = plugins_url( 'images/testimonial-carousel.jpg', __DIR__ );
		
		$repeater = new Repeater();
        $repeater->add_control( 'image',
            [
                'label' => esc_html__( 'Image', 'furnob' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );
		
        $repeater->add_control( 'name',
            [
                'label' => esc_html__( 'Name', 'furnob' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Taniyah Miles',
                'description'=> 'Add a title.',
				'label_block' => true,
            ]
        );
		
        $repeater->add_control( 'comment',
            [
                'label' => esc_html__( 'Comment', 'furnob' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'I would also like to say thank you to all your staff. I made back the purchase price in just 48 hours! Absolutely wonderful',
                'description'=> 'Add a subtitle.',
				'label_block' => true,
            ]
        );
		
        $this->add_control( 'testimonial_items',
            [
                'label' => esc_html__( 'Testimonial Items', 'furnob-core' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
						'image' => ['url' => $defaultbg],
						'name' => 'Teresa Holland',
						'comment' => 'Vestibulum ut maximus magna. Duis neque risus, varius nec efficitur ut, interdum vel risus. Fusce rutrum purus leo, a imperdiet erat sagittis ac.',

                    ],
                    [
						'image' => ['url' => $defaultbg],
						'name' => 'Teresa Holland',
						'comment' => 'Vestibulum ut maximus magna. Duis neque risus, varius nec efficitur ut, interdum vel risus. Fusce rutrum purus leo, a imperdiet erat sagittis ac.',

                    ],
                    [
						'image' => ['url' => $defaultbg],
						'name' => 'Teresa Holland',
						'comment' => 'Vestibulum ut maximus magna. Duis neque risus, varius nec efficitur ut, interdum vel risus. Fusce rutrum purus leo, a imperdiet erat sagittis ac.',

                    ],
                    [
						'image' => ['url' => $defaultbg],
						'name' => 'Teresa Holland',
						'comment' => 'Vestibulum ut maximus magna. Duis neque risus, varius nec efficitur ut, interdum vel risus. Fusce rutrum purus leo, a imperdiet erat sagittis ac.',

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
		
		$this->add_control( 'background_color',
           [
               'label' => esc_html__( 'Background Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .customer-inner' => 'background-color: {{VALUE}};']
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
				'selector' => '{{WRAPPER}} .testimonial-avatar img',
			]
		);
		
		$this->add_control( 'name_heading',
            [
                'label' => esc_html__( 'NAME', 'furnob-core' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'name_color',
			[
               'label' => esc_html__( 'Name Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .entry-name' => 'color: {{VALUE}};']
			]
        );
		
		$this->add_control( 'name_hvrcolor',
			[
               'label' => esc_html__( 'Name Hover Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .entry-name:hover' => 'color: {{VALUE}};']
			]
        );
		
		$this->add_control( 'name_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'furnob-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .entry-name ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'name_text_shadow',
				'selector' => '{{WRAPPER}} .entry-name',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .entry-name',
				
            ]
        );
		
		$this->add_control( 'comment_heading',
            [
                'label' => esc_html__( 'COMMENT', 'furnob-core' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'comment_color',
           [
               'label' => esc_html__( 'Comment Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .entry-comment p' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'comment_hvrcolor',
           [
               'label' => esc_html__( 'Comment Hover Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .entry-comment p:hover' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'comment_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'furnob-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .entry-comment p ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'comment_text_shadow',
				'selector' => '{{WRAPPER}} .entry-comment p',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'comment_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .entry-comment p',
				
            ]
        );
		
		$this->end_controls_section();
		/*****   END CONTROLS SECTION   ******/

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		
		$output = '';
		
		if ( $settings['testimonial_items'] ) {
			echo '<div class="site-module module-testimonials style-1">';
			echo '<div class="module-body">';
			echo '<div class="site-slider carousel owl-carousel" data-desktop="'.esc_attr($settings['column']).'" data-tablet="3" data-mobile="'.esc_attr($settings['mobile_column']).'" data-speed="600" data-loop="true" data-gutter="30" data-dots="'.esc_attr($settings['dots']).'" data-nav="'.esc_attr($settings['arrows']).'" data-autoplay="'.esc_attr($settings['auto_play']).'" data-autospeed="'.esc_attr($settings['auto_speed']).'" data-autostop="false">';



			foreach($settings['testimonial_items'] as $item){

				echo '<div class="customer">';
				echo '<div class="customer-inner">';
				echo '<div class="testimonial-avatar"><img src="'.esc_url($item['image']['url']).'"></div>';
				echo '<div class="testimonial-detail">';
				echo '<h4 class="entry-name">'.esc_html($item['name']).'</h4>';
				echo '<div class="stars">';
				echo '<i class="klbth-icon-star"></i>';
				echo '<i class="klbth-icon-star"></i>';
				echo '<i class="klbth-icon-star"></i>';
				echo '<i class="klbth-icon-star"></i>';
				echo '<i class="klbth-icon-star"></i>';
				echo '</div><!-- stars -->';
				echo '<div class="entry-comment">';
				echo '<p>'.esc_html($item['comment']).'</p>';
				echo '</div><!-- entry-comment -->';
				echo '</div><!-- testimonial-detail -->';
				echo '</div><!-- customer-inner -->';
				echo '</div><!-- customer -->';

			}

			echo '</div><!-- site-slider -->';
			echo '</div><!-- module-body -->';
			echo '</div><!-- site-module -->';
		}
		
	}

}
