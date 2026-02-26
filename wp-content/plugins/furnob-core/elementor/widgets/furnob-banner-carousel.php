<?php

namespace Elementor;

class Furnob_Banner_Carousel_Widget extends Widget_Base {

    public function get_name() {
        return 'furnob-banner-carousel';
    }
    public function get_title() {
        return 'Banner Carousel (K)';
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

		$repeater = new Repeater();

		$defaultimage = plugins_url( 'images/banner-carousel.jpg', __DIR__ );
		
        $repeater->add_control( 'image',
            [
                'label' => esc_html__( 'Image', 'furnob' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => $defaultimage],
            ]
        );
		
        $repeater->add_control( 'title',
            [
                'label' => esc_html__( 'Title', 'furnob' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Britney Cooper',
                'description'=> 'Add a title.',
				'label_block' => true,
            ]
        );
		
        $repeater->add_control( 'subtitle',
            [
                'label' => esc_html__( 'Subtitle', 'furnob' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Italian Interior Designer',
                'description'=> 'Add a subtitle.',
				'label_block' => true,
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
		
        $this->add_control( 'banner_items',
            [
                'label' => esc_html__( 'Banners', 'furnob-core' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
						'image' => ['url' => $defaultimage],
						'title' => 'Britney Cooper',
						'subtitle' => 'Italian Interior Designer',
						'btn_link' => '#',
                    ],
                    [
						'image' => ['url' => $defaultimage],
						'title' => 'Raymond Atkins',
						'subtitle' => 'Italian Interior Designer',
						'btn_link' => '#',
                    ],
                    [
						'image' => ['url' => $defaultimage],
						'title' => 'Monique Greer',
						'subtitle' => 'Italian Interior Designer',
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
               'selectors' => ['{{WRAPPER}} .entry-name' => 'color: {{VALUE}};']
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
                'selectors' => ['{{WRAPPER}} .entry-name ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .entry-name',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .entry-name',
				
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
               'selectors' => ['{{WRAPPER}} .description' => 'color: {{VALUE}};']
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
                'selectors' => ['{{WRAPPER}} .description ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'subtitle_text_shadow',
				'selector' => '{{WRAPPER}} .description',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typo',
                'label' => esc_html__( 'Typography', 'furnob-core' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .description',
				
            ]
        );
			
		$this->end_controls_section();
		/*****   END CONTROLS SECTION   ******/

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		
		$output = '';		
		
		if($settings['banner_items']){
			echo '<div class="site-module module-designers">';
			echo '<div class="module-body">';
			echo '<div class="site-slider carousel owl-carousel" data-desktop="3" data-tablet="2" data-mobile="1" data-speed="600" data-loop="true" data-gutter="30" data-dots="true" data-nav="true" data-autoplay="false" data-autospeed="1000" data-autostop="true">';

				foreach($settings['banner_items'] as $item){
					$target = $item['btn_link']['is_external'] ? ' target="_blank"' : '';
					$nofollow = $item['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
					
					echo '<div class="designer-card dark">';
					echo '<div class="designer-info">';
					echo '<h3 class="entry-name">'.esc_html($item['title']).'</h3>';
					echo '<span class="description">'.esc_html($item['subtitle']).'</span>';
					echo '</div><!-- designer-info -->';
					echo '<div class="designer-image"><img src="'.esc_url($item['image']['url']).'" alt="banner"></div>';
					echo '<a href="'.esc_url($item['btn_link']['url']).'" '.esc_attr($target.$nofollow).' class="mask-link"></a>';
					echo '</div><!-- designer-card -->';
				}

			echo '</div><!-- site-slider -->';
			echo '</div><!-- module-body -->';
			echo '</div><!-- site-module -->';
		}


	}

}
