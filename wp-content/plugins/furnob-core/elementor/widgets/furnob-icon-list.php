<?php

namespace Elementor;

class Furnob_Icon_List_Widget extends Widget_Base {

    public function get_name() {
        return 'furnob-icon-list';
    }
    public function get_title() {
        return 'Icon List (K)';
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
		
		$repeater = new Repeater();
		
		$repeater->add_control(
			'switcher_icon',
			[
				'label' => esc_html__( 'Use Custom Icon', 'furnob-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'furnob-core' ),
				'label_off' => esc_html__( 'No', 'furnob-core' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
		
		$repeater->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'furnob-core' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fab fa-facebook-f',
					'library' => 'fa-brands',
				],
                'label_block' => true,
				'condition' => ['switcher_icon' => '']
			]
		);
		
        $repeater->add_control( 'custom_icon',
            [
                'label' => esc_html__( 'Custom Icon', 'furnob-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'klbth-icon-facebook',
                'description'=> 'You can add icon code. for example: klbth-icon-facebook',
				'condition' => ['switcher_icon' => 'yes']
            ]
        );
		
        $repeater->add_control( 'btn_link',
            [
                'label' => esc_html__( 'Button Link', 'furnob-core' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'placeholder' => esc_html__( 'Place URL here', 'furnob-core' )
            ]
        );
		
        $this->add_control( 'icon_items',
            [
                'label' => esc_html__( 'Icon Items', 'furnob-core' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
						'switcher_icon' => 'yes',
						'custom_icon' => 'klbth-icon-facebook',
						'btn_link' => '#',
                    ],
                    [
						'switcher_icon' => 'yes',
						'custom_icon' => 'klbth-icon-twitter',
						'btn_link' => '#',
                    ],
                    [
						'switcher_icon' => 'yes',
						'custom_icon' => 'klbth-icon-linkedin',
						'btn_link' => '#',
                    ],
                    [
						'switcher_icon' => 'yes',
						'custom_icon' => 'klbth-icon-pinterest',
						'btn_link' => '#',
                    ],


                ]
            ]
        );
		
		
		$this->end_controls_section();
		/*****   END CONTROLS SECTION   ******/

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		
		$output = '';
		
		if ( $settings['icon_items'] ) {
			echo '<div class="site-social colored-text">';
			echo '<ul>';
			foreach($settings['icon_items'] as $item){
				$target = $item['btn_link']['is_external'] ? ' target="_blank"' : '';
				$nofollow = $item['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
				
				echo '<li>';
				echo '<a href="'.esc_url($item['btn_link']['url']).'" '.esc_attr($target.$nofollow).'>';
				
				if($item['switcher_icon'] == 'yes'){
					echo '<i class="'.esc_attr($item['custom_icon']).'"></i>';
				} else {
					Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'false' ] );						
				}  
				
				echo '</a>';
				echo '</li>';
			}
			echo '</ul>';
			echo '</div><!-- site-social -->';
		}
		
	}

}
