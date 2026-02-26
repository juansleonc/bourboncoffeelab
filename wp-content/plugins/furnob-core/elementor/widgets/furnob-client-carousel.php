<?php

namespace Elementor;

class Furnob_Client_Carousel_Widget extends Widget_Base {

    public function get_name() {
        return 'furnob-client-carousel';
    }
    public function get_title() {
        return 'Client Carousel (K)';
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
				'default' => '6',
				'options' => [
					'0' => esc_html__( 'Select Column', 'furnob-core' ),
					'2' 	  => esc_html__( '2 Columns', 'furnob-core' ),
					'3'		  => esc_html__( '3 Columns', 'furnob-core' ),
					'4'		  => esc_html__( '4 Columns', 'furnob-core' ),
					'5'		  => esc_html__( '5 Columns', 'furnob-core' ),
					'6'		  => esc_html__( '6 Columns', 'furnob-core' ),
					'7'		  => esc_html__( '7 Columns', 'furnob-core' ),
					'8'		  => esc_html__( '8 Columns', 'furnob-core' ),
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
				'default' => 'false',
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
		
		$defaultbg = plugins_url( 'images/client-carousel.png', __DIR__ );
		
		$repeater = new Repeater();
        $repeater->add_control( 'image',
            [
                'label' => esc_html__( 'Image', 'furnob' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control( 'btn_link',
            [
                'label' => esc_html__( 'Image Link', 'furnob-core' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'placeholder' => esc_html__( 'Place URL here', 'furnob-core' )
            ]
        );
		
        $this->add_control( 'client_items',
            [
                'label' => esc_html__( 'Icon Items', 'furnob-core' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
						'image' => ['url' => $defaultbg],
						'btn_link' => '#',
                    ],
                    [
						'image' => ['url' => $defaultbg],
						'btn_link' => '#',
                    ],
                    [
						'image' => ['url' => $defaultbg],
						'btn_link' => '#',
                    ],
                    [
						'image' => ['url' => $defaultbg],
						'btn_link' => '#',
                    ],
                    [
						'image' => ['url' => $defaultbg],
						'btn_link' => '#',
                    ],
                    [
						'image' => ['url' => $defaultbg],
						'btn_link' => '#',
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
				'selector' => '{{WRAPPER}} .module-body a img',
			]
		);
		
		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'label' => esc_html__( 'Border', 'furnob-core' ),
                'selector' => '{{WRAPPER}} .module-logos .module-body a img ',
            ]
        );
        
		$this->add_responsive_control( 'image_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'furnob-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .module-logos .module-body a img ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'],
            ]
        );
		
		$this->add_responsive_control( 'image_padding',
            [
                'label' => esc_html__( 'Padding', 'furnob-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .module-logos .module-body a img ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],              
            ]
        );
		
		$this->end_controls_section();
		/*****   END CONTROLS SECTION   ******/

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		
		$output = '';
		
		if ( $settings['client_items'] ) {
			echo '<div class="site-module module-logos">';
			echo '<div class="module-body">';
			echo '<div class="site-slider owl-carousel" data-desktop="'.esc_attr($settings['column']).'" data-tablet="3" data-mobile="'.esc_attr($settings['mobile_column']).'" data-speed="600" data-loop="true" data-gutter="0" data-dots="'.esc_attr($settings['dots']).'" data-nav="'.esc_attr($settings['arrows']).'" data-autoplay="'.esc_attr($settings['auto_play']).'" data-autospeed="'.esc_attr($settings['auto_speed']).'" data-autostop="false">';



			foreach($settings['client_items'] as $item){
				$target = $item['btn_link']['is_external'] ? ' target="_blank"' : '';
				$nofollow = $item['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
				
				echo '<div class="item">';
				echo '<a href="'.esc_url($item['btn_link']['url']).'" '.esc_attr($target.$nofollow).'><img src="'.esc_url($item['image']['url']).'"></a>';
				echo '</div><!-- item -->';

			}

			echo '</div><!-- site-slider -->';
			echo '</div><!-- module-body -->';
			echo '</div><!-- site-module -->';
		}
		
	}

}
