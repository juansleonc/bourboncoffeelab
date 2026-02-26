<?php

namespace Elementor;

class Furnob_Counter_Box2_Widget extends Widget_Base {

    public function get_name() {
        return 'furnob-counter-box2';
    }
    public function get_title() {
        return 'Counter Box 2 (K)';
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
		
        $this->add_control( 'title',
            [
                'label' => esc_html__( 'Title', 'furnob' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'It\'ll be worth the wait very soon !',
                'description'=> 'Add a title.',
				'label_block' => true,
            ]
        );
		
		$this->add_control(
			'due_date',
			[
				'label' => esc_html__( 'Due Date', 'furnob-core' ),
				'type' => Controls_Manager::DATE_TIME,
				'default' => '2022/07/14',
				'picker_options' => ['enableTime' => false,],
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
               'selectors' => ['{{WRAPPER}} .counter-block > span' => 'color: {{VALUE}};']
			]
        );
		
		$this->add_control( 'title_hvrcolor',
			[
               'label' => esc_html__( 'Title Hover Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .counter-block > span:hover' => 'color: {{VALUE}};']
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
                'selectors' => ['{{WRAPPER}} .counter-block > span ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .counter-block > span',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .counter-block > span',
				
            ]
        );
		
		$this->add_control( 'dua_date_heading',
            [
                'label' => esc_html__( 'DATE', 'furnob-core' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'dua_date_color',
			[
               'label' => esc_html__( 'Dua Date Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .count-item' => 'color: {{VALUE}};']
			]
        );
		
		$this->add_control( 'dua_date_second_color',
			[
               'label' => esc_html__( 'Dua Date Second Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .counter-block .countdown .count-item > *.second' => 'color: {{VALUE}};']
			]
        );
			
		$this->end_controls_section();
		/*****   END CONTROLS SECTION   ******/

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$output = '';		
		
		echo '<div class="counter-block">';
		echo '<span>'.esc_html($settings['title']).'</span>';
		echo '<div class="countdown" data-date="'.esc_attr($settings['due_date']).'" data-text="'.esc_attr__('Expired', 'furnob-core').'">';
		echo '<div class="count-item">';
		echo '<div class="days">00</div>';
		echo '<div class="count-label">'.esc_html__('d','furnob-core').'</div>';
		echo '</div><!-- count-item -->';
		echo '<span>:</span>';
		echo '<div class="count-item">';
		echo '<div class="hours">00</div>';
		echo '<div class="count-label">'.esc_html__('h','furnob-core').'</div>';
		echo '</div><!-- count-item -->';
		echo '<span>:</span>';
		echo '<div class="count-item">';
		echo '<div class="minutes">00</div>';
		echo '<div class="count-label">'.esc_html__('m','furnob-core').'</div>';
		echo '</div><!-- count-item -->';
		echo '<span>:</span>';
		echo '<div class="count-item">';
		echo '<div class="second">00</div>';
		echo '<div class="count-label">'.esc_html__('s','furnob-core').'</div>';
		echo '</div><!-- count-item -->';
		echo '</div><!-- countdown -->';
		echo '</div><!-- counter-block -->';


	}

}
