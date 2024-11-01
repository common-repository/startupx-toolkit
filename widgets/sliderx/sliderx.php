<?php

namespace StartupxToolkit\Widgets\Sliderx;

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Sliderx extends Widget_Base {

    public function __construct($data = [], $args = null) {
        
        parent::__construct($data, $args);
        if( !wp_script_is('swiper', 'registered') ){
            wp_register_script( 'swiper', \StartupxToolkit::plugin_url().'assets/vendor/swiper/js/swiper-bundle.min.js', ['elementor-frontend'], '7.0.1', true );
        }
        wp_register_script( 'slider', \StartupxToolkit::plugin_url().'widgets/sliderx/assets/slider.js', array('swiper','elementor-frontend'), '1.0.0', true );

    }

    /**
	 * Get widget name.
	 *
	 * Retrieve list widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'sliderx';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve list widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Slider', 'startupx-toolkit' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve list widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon eicon-slider-push';
	}

    /**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return 'mailto: info@codegearthemes.com';
	}
	
    /**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the list widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'startupx-toolkit' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the list widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'slider', 'image', 'gallery', 'carousel' ];
	}

    /**
     * Widget Style.
     * 
     * @return string
     */
    public function get_style_depends() {
        return [ 'swiper' ];
    }

    /**
     * Widget script.
     * 
     * @return string
     */
    public function get_script_depends() {
        return [ 'slider' ];
    }

	
    /**
	 * Register list widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
        $this->start_controls_section(
			'_general_settings',
			[
				'label' => __( 'Slides', 'startupx-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

        $repeater = new Repeater();

		$repeater->add_control( 
			'image',
			[
                'label' => __( 'Image', 'startupx-toolkit' ),
				'type' => Controls_Manager::MEDIA,
                'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				]
			]
		);

        $repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'full',
				'separator' => 'before',
				'exclude' => [
					'custom'
				]
			]
		);

        $repeater->add_control(
			'title',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Title', 'startupx-toolkit' ),
				'placeholder' => __( 'Type title here', 'startupx-toolkit' ),
				'dynamic' => [
					'active' => true,
				]
			]
		);

        $repeater->add_control(
			'title_tag',
			[
				'label' => __( 'Title HTML Tag', 'startupx-toolkit' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div'
				],
				'default' => 'h2',
			]
		);

		$repeater->add_control(
			'subtitle',
			[
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'label' => __( 'Subtitle', 'startupx-toolkit' ),
				'placeholder' => __( 'Type subtitle here', 'startupx-toolkit' ),
				'dynamic' => [
					'active' => true,
				]
			]
		);

        $repeater->add_control(
			'label',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Button label', 'startupx-toolkit' ),
				'placeholder' => __( 'Shop Now', 'startupx-toolkit' ),
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link', 'startupx-toolkit' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => 'https://example.com',
				'dynamic' => [
					'active' => true,
				]
			]
		);

        $this->add_control(
			'slides',
			[
				'show_label' => false,
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '<# print(title || "Slide Item"); #>',
                'default' => array_fill( 0, 2, [
                    'image' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                ])
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'_section_settings',
			[
				'label' => __( 'Settings', 'startupx-toolkit' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'animation_speed',
			[
				'label' => __( 'Animation Speed', 'startupx-toolkit' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 100,
				'step' => 10,
				'max' => 10000,
				'default' => 300,
				'description' => __( 'Slide speed in milliseconds', 'startupx-toolkit' ),
				'frontend_available' => true,
				'render_type' => 'ui',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay?', 'startupx-toolkit' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'startupx-toolkit' ),
				'label_off' => __( 'No', 'startupx-toolkit' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'frontend_available' => true,
				'render_type' => 'ui',
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => __( 'Autoplay Speed', 'startupx-toolkit' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 100,
				'step' => 100,
				'max' => 10000,
				'default' => 3000,
				'description' => __( 'Autoplay speed in milliseconds', 'startupx-toolkit' ),
				'condition' => [
					'autoplay' => 'yes'
				],
				'frontend_available' => true,
				'render_type' => 'ui',
			]
		);

		$this->add_control(
			'loop',
			[
				'label' => __( 'Infinite Loop?', 'startupx-toolkit' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'startupx-toolkit' ),
				'label_off' => __( 'No', 'startupx-toolkit' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'frontend_available' => true,
				'render_type' => 'ui',
			]
		);

		$this->add_control(
			'navigation',
			[
				'label' => __( 'Navigation', 'startupx-toolkit' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => __( 'None', 'startupx-toolkit' ),
					'arrow' => __( 'Arrow', 'startupx-toolkit' ),
					'dots' => __( 'Dots', 'startupx-toolkit' ),
					'both' => __( 'Arrow & Dots', 'startupx-toolkit' ),
				],
				'default' => 'arrow',
				'frontend_available' => true,
				'style_transfer' => true,
				'render_type' => 'ui',
			]
		);

		$this->end_controls_section();
        $this->register_style_controls();
	}

    /**
	 * Register style controls.
	 *
	 * Add input fields to allow the user to customize the widget style.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
    protected function register_style_controls() {
        $this->__slider_item_style_controls();
        $this->__slider_content_style_controls();
        $this->__slider_arrow_style_controls();
        $this->__slider_dot_style_controls();
    }
    
    protected function __slider_item_style_controls() {
    
        $this->start_controls_section(
            '_section_style_item',
            [
                'label' => __( 'Slider', 'startupx-toolkit' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'_unqid',
			[
				'label' => esc_html__( 'Slider selector', 'startupx-toolkit' ),
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => uniqid(),
			]
		);

        $this->add_responsive_control(
            'caption_aligment',
            [
                'label' => __( 'Vertical Alignment', 'startupx-toolkit' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'center',
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Top', 'startupx-toolkit' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'startupx-toolkit' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => __( 'Bottom', 'startupx-toolkit' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .content' => 'align-items: {{VALUE}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'caption_horizontal_alignment',
            [
                'label' => __( 'Horizontal Alignment', 'startupx-toolkit' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'center',
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Left', 'startupx-toolkit' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'startupx-toolkit' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => __( 'Right', 'startupx-toolkit' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .content' => 'justify-content: {{VALUE}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => __( 'Padding', 'startupx-toolkit' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default' => [
                    'size' => 30,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .slider-inner .content' => 'padding: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'slider_caption_radius',
            [
                'label' => __( 'Caption Border Radius', 'startupx-toolkit' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide .content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );
    
        $this->add_responsive_control(
            'slider_border_radius',
            [
                'label' => __( 'Slider Border Radius', 'startupx-toolkit' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );
    
        $this->end_controls_section();
    }
    
    protected function __slider_content_style_controls() {
    
        $this->start_controls_section(
            '_section_style_content',
            [
                'label' => __( 'Slide Content', 'startupx-toolkit' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
    
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'content_background',
                'selector' => '{{WRAPPER}} .swiper-slide .content',
                'exclude' => [
                    'image'
                ]
            ]
        );
    
        $this->add_control(
            '_heading_title',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Title', 'startupx-toolkit' ),
                'separator' => 'before'
            ]
        );
    
        $this->add_responsive_control(
            'title_spacing',
            [
                'label' => __( 'Bottom Spacing', 'startupx-toolkit' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default' => [
                    'size' => 10,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    
        $this->add_control(
            'title_color',
            [
                'label' => __( 'Text Color', 'startupx-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title' => 'color: {{VALUE}}',
                ],
            ]
        );
    
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title',
                'selector' => '{{WRAPPER}} .title',
                'scheme' => Typography::TYPOGRAPHY_2,
            ]
        );
    
        $this->add_control(
            '_heading_subtitle',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Subtitle', 'startupx-toolkit' ),
                'separator' => 'before'
            ]
        );
    
        $this->add_responsive_control(
            'subtitle_spacing',
            [
                'label' => __( 'Bottom Spacing', 'startupx-toolkit' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default' => [
                    'size' => 45,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    
        $this->add_control(
            'subtitle_color',
            [
                'label' => __( 'Text Color', 'startupx-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .subtitle' => 'color: {{VALUE}}',
                ],
            ]
        );
    
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle',
                'selector' => '{{WRAPPER}} .subtitle',
                'scheme' => Typography::TYPOGRAPHY_3,
            ]
        );
    
        $this->end_controls_section();
    }
    
    protected function __slider_arrow_style_controls() {
    
        $this->start_controls_section(
            '_section_style_arrow',
            [
                'label' => __( 'Navigation : Arrow', 'startupx-toolkit' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
    
        $this->add_control(
            'arrow_position_toggle',
            [
                'label' => __( 'Position', 'startupx-toolkit' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __( 'None', 'startupx-toolkit' ),
                'label_on' => __( 'Custom', 'startupx-toolkit' ),
                'return_value' => 'yes',
                'default' => 'yes'
            ]
        );
    
        $this->start_popover();
    
        $this->add_responsive_control(
            'arrow_position_y',
            [
                'label' => __( 'Vertical', 'startupx-toolkit' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'arrow_position_toggle' => 'yes'
                ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => -110,
                        'max' => 110,
                    ],
                ],
                'default'   => [
                    'size' => 50,
                    'unit' => '%'
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'top: {{SIZE}}{{UNIT}};-webkit-transform: translateY(-{{SIZE}}{{UNIT}}); transform: translateY(-{{SIZE}}{{UNIT}});',
                ],
            ]
        );
    
        $this->add_responsive_control(
            'arrow_position_x',
            [
                'label' => __( 'Horizontal', 'startupx-toolkit' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'arrow_position_toggle' => 'yes'
                ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => -110,
                        'max' => 110,
                    ],
                ],
                'default'   => [
                    'size' => 30,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous' => 'left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .slide-next' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    
        $this->end_popover();
    
        $this->add_responsive_control(
            'arrow_size',
            [
                'label' => __( 'Size', 'startupx-toolkit' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default'   => [
                    'size' => 60,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .slide-previous svg, {{WRAPPER}} .slide-next svg' => 'width: calc( {{SIZE}}{{UNIT}} / 2 );height: calc( {{SIZE}}{{UNIT}} / 2 );'
                ],
            ]
            );
    
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'arrow_border',
                'selector' => '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next',
            ]
        );
    
        $this->add_responsive_control(
            'arrow_border_radius',
            [
                'label' => __( 'Border Radius', 'startupx-toolkit' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );
    
        $this->start_controls_tabs( '_tabs_arrow' );
    
        $this->start_controls_tab(
            '_tab_arrow_normal',
            [
                'label' => __( 'Normal', 'startupx-toolkit' ),
            ]
        );
    
        $this->add_control(
            'arrow_color',
            [
                'label' => __( 'Text Color', 'startupx-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#115CFA',
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'color: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_control(
            'arrow_background_color',
            [
                'label' => __( 'Background Color', 'startupx-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'background-color: {{VALUE}};',
                ],
            ]
        );
    
        $this->end_controls_tab();
    
        $this->start_controls_tab(
            '_tab_arrow_hover',
            [
                'label' => __( 'Hover', 'startupx-toolkit' ),
            ]
        );
    
        $this->add_control(
            'arrow_hover_color',
            [
                'label' => __( 'Text Color', 'startupx-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .slide-previous:hover, {{WRAPPER}} .slide-next:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_control(
            'arrow_hover_background_color',
            [
                'label' => __( 'Background Color', 'startupx-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#115CFA',
                'selectors' => [
                    '{{WRAPPER}} .slide-previous:hover, {{WRAPPER}} .slide-next:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_hover_border_color',
            [
                'label' => __( 'Border Hover Color', 'startupx-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#115CFA',
                'selectors' => [
                    '{{WRAPPER}} .slide-previous:hover, {{WRAPPER}} .slide-next:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
    
        $this->end_controls_tab();
        $this->end_controls_tabs();
    
        $this->end_controls_section();
    }
    
    protected function __slider_dot_style_controls() {
        $this->start_controls_section(
            '_section_style_dots',
            [
                'label' => __( 'Navigation : Dots', 'startupx-toolkit' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
    
        $this->add_responsive_control(
            'dots_nav_position_y',
            [
                'label' => __( 'Vertical Position', 'startupx-toolkit' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'rem' => [
                        'min' => -100,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 150,
                    ],
                ],
                'default'   => [
                    'size' => 15,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    
        $this->add_responsive_control(
            'dots_nav_spacing',
            [
                'label' => __( 'Spacing', 'startupx-toolkit' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default'   => [
                    'size' => 10,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    
        $this->add_responsive_control(
            'dots_nav_align',
            [
                'label' => __( 'Alignment', 'startupx-toolkit' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'center',
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Left', 'startupx-toolkit' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'startupx-toolkit' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => __( 'Right', 'startupx-toolkit' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination' => 'justify-content: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'dots_nav_size',
            [
                'label' => __( 'Size', 'startupx-toolkit' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default'   => [
                    'size' => 15,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination span' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_border_radius',
            [
                'label' => __( 'Border Radius', 'startupx-toolkit' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );
    
        $this->start_controls_tabs( '_tabs_dots' );
        $this->start_controls_tab(
            '_tab_dots_normal',
            [
                'label' => __( 'Normal', 'startupx-toolkit' ),
            ]
        );
    
        $this->add_control(
            'dots_nav_color',
            [
                'label' => __( 'Color', 'startupx-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination span' => 'background: {{VALUE}};',
                ],
            ]
        );
    
        $this->end_controls_tab();
    
        $this->start_controls_tab(
            '_tab_dots_hover',
            [
                'label' => __( 'Hover', 'startupx-toolkit' ),
            ]
        );
    
        $this->add_control(
            'dots_nav_hover_color',
            [
                'label' => __( 'Color', 'startupx-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#115CFA',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet-active,{{WRAPPER}} .swiper-pagination span:hover' => 'background: {{VALUE}};',
                ],
            ]
        );
    
        $this->end_controls_tab();
        $this->end_controls_tabs();
    
        $this->end_controls_section();
    }

    /**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
        $settings = $this->get_settings_for_display();

		if ( empty( $settings['slides'] ) ) {
			return;
		}
        $loop = $settings['loop'];
        $autoplay = $settings['autoplay'];
        $this->add_render_attribute(
            'wrapper',
            [
                'class' => [ 'block--image-slider' ],
                'data-selector' => $settings['_unqid'],
                'data-autoplay' => $autoplay,
                'data-loop' => $loop,
            ]
        );
        ?>
        <div <?= $this->get_render_attribute_string( 'wrapper' ); ?> >
            <div id="block_slider_<?php echo esc_attr($settings['_unqid']) ?>" class="swiper">
                <div class="slider-inner slider-wrapper swiper-wrapper">
                    <?php 
                        foreach ( $settings['slides'] as $slide ) : ?>
                            <?php
                                $this->add_render_attribute( 'image', 'src', $slide['image']['url'] );
                                $this->add_render_attribute( 'image', 'alt', \Elementor\Control_Media::get_image_alt( $slide['image'] ) );
                                $this->add_render_attribute( 'image', 'title', \Elementor\Control_Media::get_image_title( $slide['image'] ) );
                                $this->add_render_attribute( 'image', 'class', 'image' );
                            ?>

                            <div class="swiper-slide slider-slide">
                                <div class="slider-image">
                                    <?= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $slide, 'thumbnail', 'image' ); ?>
                                </div>
                                <?php if ( !empty($slide['title']) || !empty($slide['subtitle']) ) : ?>
                                    <div class="content">
                                        <?php
                                            if ( $slide['title'] ) {
                                                printf( '<%1$s class="title h1">%2$s</%1$s>',
                                                    tag_escape( $slide['title_tag'], 'h2' ),
                                                    wp_kses_post( $slide['title'] )
                                                );
                                            }
                                        ?>
                                        <?php if ( $slide['subtitle'] ) : ?>
                                            <p class="subtitle"><?php echo wp_kses_post( $slide['subtitle'] ); ?></p>
                                        <?php endif; ?>
                                        <?php 
                                            if( isset( $slide['link'] ) && ! empty( $slide['link']['url'] ) ) { ?>
                                                <a class="btn btn--primary" href="<?php echo esc_url( $slide['link']['url'] ); ?>">
                                                    <?php echo esc_html($slide['label']) ?>
                                                </a>
                                        <?php } ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                        <?php
                        endforeach;
                    ?>
                </div>
            </div>
            <?php if( $settings['navigation'] == 'arrow' || $settings['navigation'] == 'both' ): ?>
                <div class="slide-previous swiper-button-prev-<?php echo esc_attr($settings['_unqid']) ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="icon icon-chevron-left">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                </div>
                <div class="slide-next swiper-button-next-<?php echo esc_attr($settings['_unqid']) ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="icon icon-chevron-right">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>  
                </div>
            <?php endif; ?>
            <?php if( $settings['navigation'] == 'dots' || $settings['navigation'] == 'both'): ?>
                <div class="swiper-pagination swiper-pagination-<?php echo esc_attr($settings['_unqid']) ?>"></div>
            <?php endif; ?>
        </div>
        <?php
	}

	/**
	 * Render widget output in the editor.
	 *
	 *
	 * @access protected
	 */
    protected function content_template() { ?>
            <#
            view.addRenderAttribute(
                'wrapper',
                {
                    'class': 'block--image-slider',
                    'data-selector': settings._unqid,
                    'data-loop': settings.loop,
                    'data-autoplay': settings.autoplay,
                }
            );
            #>
            <div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
                <div id="block_slider_{{{ settings._unqid }}}" class="swiper">
                    <div class="slider-wrapper swiper-wrapper">
                        <#
                        if ( settings.slides ) {
                            _.each( settings.slides, function( slide, index ) {
                            #>
                            <div class="swiper-slide slider-item">
                                <# if ( slide.image && slide.image.url ) { #>
                                    <img src="{{{ slide.image.url }}}">
                                <# } #>
                            </div>
                            <#
                            } );
                        }
                        #>
                    </div>

                    <# if( settings.navigation == 'arrow' || settings.navigation == 'both' ){ #>
                        <div class="slide-previous swiper-button-prev-{{{ settings._unqid }}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="icon icon-chevron-left">
                                <polyline points="15 18 9 12 15 6"/>
                            </svg> 
                        </div>
                        <div class="slide-next swiper-button-next-{{{ settings._unqid }}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="icon icon-chevron-right">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </div>
                    <# } #>
                    
                    <# if( settings.navigation == 'dots' || settings.navigation == 'both' ){ #>
                        <div class="swiper-pagination swiper-pagination-{{{ settings._unqid }}}"></div>
                    <# } #>

                </div>
            </div>
        <?php
    }

}