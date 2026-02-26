<?php

namespace Elementor;

class Furnob_Testimonial_Widget extends Widget_Base {

    public function get_name() {
        return 'furnob-testimonial';
    }
    public function get_title() {
        return 'Testimonial (K)';
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
		
        $this->add_control( 'name',
            [
                'label' => esc_html__( 'Name', 'furnob' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Taniyah Miles',
                'description'=> 'Add a title.',
				'label_block' => true,
            ]
        );
		
        $this->add_control( 'position',
            [
                'label' => esc_html__( 'Position', 'furnob' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Danish Modern LA',
                'description'=> 'Add a subtitle.',
				'label_block' => true,
            ]
        );
		
        $this->add_control( 'rating',
            [
                'label' => esc_html__( 'Rating', 'furnob' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '4.5',
                'description'=> 'Add a title.',
				'label_block' => true,
            ]
        );
		
        $this->add_control( 'comment',
            [
                'label' => esc_html__( 'Comment', 'furnob' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'I would also like to say thank you to all your staff. I made back the purchase price in just 48 hours! Absolutely wonderful',
                'description'=> 'Add a subtitle.',
				'label_block' => true,
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
		
		$this->add_control( 'position_heading',
            [
                'label' => esc_html__( 'POSITION', 'furnob-core' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'position_color',
           [
               'label' => esc_html__( 'Position Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .desc' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'position_hvrcolor',
           [
               'label' => esc_html__( 'Position Hover Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .desc:hover' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'position_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'furnob-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .desc ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'position_text_shadow',
				'selector' => '{{WRAPPER}} .desc',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'position_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .desc',
				
            ]
        );
		
		$this->add_control( 'rating_heading',
            [
                'label' => esc_html__( 'RATING', 'furnob-core' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'rating_color',
           [
               'label' => esc_html__( 'Rating Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .rating' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'rating_hvrcolor',
           [
               'label' => esc_html__( 'Rating Hover Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .rating:hover' => 'color: {{VALUE}};']
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
               'selectors' => ['{{WRAPPER}} .customer-message p' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'comment_hvrcolor',
           [
               'label' => esc_html__( 'Comment Hover Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .customer-message p:hover' => 'color: {{VALUE}};']
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
                'selectors' => ['{{WRAPPER}} .customer-message p ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'comment_text_shadow',
				'selector' => '{{WRAPPER}} .customer-message p',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'comment_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .customer-message p',
				
            ]
        );
			
		$this->end_controls_section();
		/*****   END CONTROLS SECTION   ******/

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$output = '';		
		
		echo '<div class="site-module module-customer">';
		echo '<div class="module-body">';
		echo '<div class="customer-card">';
		echo '<div class="customer-rating">';
		echo '<span class="rating">'.esc_html($settings['rating']).'</span>';
		echo '<div class="customer-info">';
		echo '<h4 class="entry-name">'.esc_html($settings['name']).'</h4>';
		echo '<span class="desc">'.esc_html($settings['position']).'</span>';
		echo '<div class="stars">';
		echo '<i class="klbth-icon-star"></i>';
		echo '<i class="klbth-icon-star"></i>';
		echo '<i class="klbth-icon-star"></i>';
		echo '<i class="klbth-icon-star"></i>';
		echo '<i class="klbth-icon-star"></i>';
		echo '</div><!-- stars -->';
		echo '</div><!-- customer-info -->';
		echo '</div><!-- customer-rating -->';
		echo '<div class="customer-message">';
		echo '<p>'.esc_html($settings['comment']).'</p>';
		echo '</div><!-- customer-message -->';
		echo '</div><!-- customer-card -->';
		echo '</div><!-- module-body -->';
		echo '</div><!-- site-module -->';



	}

}
