<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
class Furnob_Contact_Form_7_Widget extends Widget_Base {
    use Furnob_Helper;
    public function get_name() {
        return 'furnob-contact-form-7';
    }
    public function get_title() {
        return 'Contact Form 7 (K)';
    }
    public function get_icon() {
        return 'eicon-form-horizontal';
    }
    public function get_categories() {
        return [ 'furnob' ];
    }

    // Registering Controls
    protected function register_controls() {
        $this->start_controls_section( 'furnob_cf7_global_controls',
            [
                'label'=> esc_html__( 'Form Data', 'furnob-core' ),
                'tab'=> Controls_Manager::TAB_CONTENT
            ]
        );
		
        $this->add_control('furnob_cf7_form_id_control',
            [
                'label'=> esc_html__( 'Select Form', 'furnob-core' ),
                'type'=> Controls_Manager::SELECT2,
                'multiple'=> false,
                'options'=> $this->furnob_get_cf7(),
                'description'=> 'Select Form to Embed',
				'label_block' => true,
            ]
        );
		
        $this->add_control( 'title',
            [
                'label' => esc_html__( 'Title', 'furnob-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Get in Touch',
                'pleaceholder' => esc_html__( 'Set a title.', 'furnob-core' ),
            ]
        );

        $this->add_control( 'subtitle',
            [
                'label' => esc_html__( 'Subtitle', 'furnob-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'pleaceholder' => esc_html__( 'Set a text.', 'furnob-core' ),
            ]
        );
				
        $this->end_controls_section();

        /***** Button Style ******/
        $this->start_controls_section('cf7_form_style_section',
            [
                'label'=> esc_html__( 'Form Style', 'furnob-core' ),
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
				'separator' => 'before',
            ]
        );
		
		$this->add_control( 'subtitle_color',
           [
               'label' => esc_html__( 'Subtitle Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .contact-form p ' => 'color: {{VALUE}};'],
           ]
        );
		
		$this->add_control( 'subtitle_hvrcolor',
           [
               'label' => esc_html__( 'Subtitle Hover Color', 'furnob-core' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .contact-form p:hover' => 'color: {{VALUE}};'],
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
                'selectors' => ['{{WRAPPER}} .contact-form p' => 'opacity: {{VALUE}};'],
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'subtitle_text_shadow',
				'selector' => '{{WRAPPER}} .contact-form p',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .contact-form p',
				
            ]
        );
		
        $this->add_responsive_control( 'alignment',
            [
                'label' => esc_html__( 'Alignment', 'furnob-core' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => ['{{WRAPPER}} form .footer_newsletter_form, {{WRAPPER}} form .newsletter2_form' => 'justify-content: {{VALUE}};'],
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'furnob-core' ),
                        'icon' => 'fa fa-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'furnob-core' ),
                        'icon' => 'fa fa-align-center'
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'furnob-core' ),
                        'icon' => 'fa fa-align-right'
                    ]
                ],
                'toggle' => true,
                'default' => 'flex-start',
				'separator' => 'before',
            ]
        );
		
        $this->add_responsive_control( 'cf7_form_custom_width',
            [
                'label' => esc_html__( 'Form Max Width', 'furnob-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000
                    ]
                ],
                'selectors' => [ '{{WRAPPER}} form.wpcf7-form'  => 'width: {{SIZE}}px;max-width: {{SIZE}}px;margin:0 auto;display:block;positon:relative;' ]
            ]
        );
        $this->add_responsive_control( 'cf7_form_input_height',
            [
                'label' => esc_html__( 'Input Height', 'furnob-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000
                    ]
                ],
                'selectors' => [ '{{WRAPPER}} input:not(.wpcf7-submit)'  => 'height: {{SIZE}}px;' ]
            ]
        );
        $this->start_controls_tabs( 'cf7_form_tabs');
        $this->start_controls_tab( 'cf7_form_normal_tab',
            [ 'label'  => esc_html__( 'Normal', 'furnob-core' ) ]
        );
        // Style function
        $this->furnob_style_controls($hide=array(),$id='cf7_form_normal_style',$selector='input:not(.wpcf7-submit),{{WRAPPER}} textarea');
        $this->add_control( 'cf7_form_opacity_important_normal_style',
            [
                'label' => esc_html__( 'Opacity', 'furnob-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'separator' => 'before',
                'selectors' => ['{{WRAPPER}} input:not(.wpcf7-submit),{{WRAPPER}} textarea' => 'opacity: {{VALUE}} !important;']
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab( 'cf7_form_hover_tab',
            [ 'label' => esc_html__( 'Hover', 'furnob-core' ) ]
        );
        // Style function
        $this->furnob_style_controls($hide=array('typo','margin'),$id='cf7_form_hover_style',$selector='input:not(.wpcf7-submit):hover,{{WRAPPER}} textarea:hover');
        $this->add_control( 'cf7_form_opacity_important_hover_style',
            [
                'label' => esc_html__( 'Opacity', 'furnob-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'separator' => 'before',
                'selectors' => ['{{WRAPPER}} input:not(.wpcf7-submit):hover,{{WRAPPER}} textarea:hover' => 'opacity: {{VALUE}} !important;']
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab( 'cf7_form_focus_tab',
            [ 'label'  => esc_html__( 'Focus', 'furnob-core' ) ]
        );
        // Style function
        $this->furnob_style_controls($hide=array('typo','margin'),$id='cf7_form_focus_style',$selector='input:not(.wpcf7-submit):focus,{{WRAPPER}} textarea:focus');
        $this->add_control( 'cf7_form_opacity_important_focus_style',
            [
                'label' => esc_html__( 'Opacity', 'furnob-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'separator' => 'before',
                'selectors' => ['{{WRAPPER}} input:not(.wpcf7-submit):focus,{{WRAPPER}} textarea:focus' => 'opacity: {{VALUE}} !important;']
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /***** Button Style ******/
        $this->start_controls_section('cf7_formbtn_style_section',
            [
                'label' => esc_html__( 'Form Button Style', 'furnob-core' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_responsive_control( 'cf7_form_btn_custom_width',
            [
                'label' => esc_html__( 'Form Max Width', 'furnob-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000
                    ]
                ],
                'selectors' => [ '{{WRAPPER}} input.wpcf7-submit'  => 'width: {{SIZE}}px;max-width: {{SIZE}}px;margin:0 auto;display:block;positon:relative;' ]
            ]
        );
        $this->add_responsive_control( 'cf7_form_btn_input_height',
            [
                'label' => esc_html__( 'Input Height', 'furnob-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000
                    ]
                ],
                'selectors' => [ '{{WRAPPER}} input.wpcf7-submit'  => 'height: {{SIZE}}px;' ]
            ]
        );
        $this->start_controls_tabs( 'cf7_formbtn_tabs');
        $this->start_controls_tab( 'cf7_formbtn_normal_tab',
            [ 'label'  => esc_html__( 'Normal', 'furnob-core' ) ]
        );
        // Style function
        $this->furnob_style_controls($hide=array(),$id='cf7_formbtn_normal_style',$selector='.wpcf7-submit');
        $this->add_control( 'cf7_formbtn_opacity_important_normal_style',
            [
                'label' => esc_html__( 'Opacity', 'furnob-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'separator' => 'before',
                'selectors' => ['{{WRAPPER}} .wpcf7-submit' => 'opacity: {{VALUE}} !important;']
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab( 'cf7_formbtn_hover_tab',
            [ 'label' => esc_html__( 'Hover', 'furnob-core' ) ]
        );
        // Style function
        $this->furnob_style_controls($hide=array('typo','margin'),$id='cf7_formbtn_hover_style',$selector='.wpcf7-submit:hover');
        $this->add_control( 'cf7_formbtn_opacity_important_hover_style',
            [
                'label' => esc_html__( 'Opacity', 'furnob-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'separator' => 'before',
                'selectors' => ['{{WRAPPER}} .wpcf7-submit:hover' => 'opacity: {{VALUE}} !important;']
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render() {
        $settings  = $this->get_settings_for_display();
        if (!empty($settings['furnob_cf7_form_id_control'])){
			echo '<div class="contact-form-wrapper">';
			echo '<div class="form-header">';
			echo '<h3 class="entry-title">'.esc_html($settings['title']).'</h3>';
			echo '<div class="entry-content">';
			echo '<p>'.esc_html($settings['subtitle']).' </p>';
			echo '</div><!-- entry-content -->';
			echo '<div class="contact-form">';
			echo do_shortcode( '[contact-form-7 id="'.$settings['furnob_cf7_form_id_control'].'"]' );
			echo '</div><!-- contact-form -->';
			echo '</div><!-- form-header -->';
			echo '</div><!-- contact-form-wrapper -->';
        } else {
            esc_html_e('Please Select a Form','furnob-core');
        }
    }
}
