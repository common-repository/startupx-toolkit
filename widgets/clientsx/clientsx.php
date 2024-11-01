<?php

namespace StartupxToolkit\Widgets\Clientsx;

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Clientsx extends Widget_Base {

    public function __construct($data = [], $args = null) {
        
        parent::__construct($data, $args);
        
        if( !wp_script_is('swiper', 'registered') ){
            wp_register_script( 'swiper', \StartupxToolkit::plugin_url().'assets/vendor/swiper/js/swiper-bundle.min.js', ['elementor-frontend'], '7.0.1', true );
        }
        wp_register_script( 'client-slider', \StartupxToolkit::plugin_url().'widgets/clientsx/assets/clients.js', ['swiper'], '1.0.0', true );

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
		return 'clientsx';
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
		return esc_html__( 'Clients', 'startupx-toolkit' );
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
		return 'https://developers.elementor.com/docs/widgets/';
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
		return [ 'clients', 'image', 'gallery', 'carousel' ];
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
        return [ 'client-slider' ];
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
				'label' => __( 'Clients', 'startupx-toolkit' ),
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

        $this->add_control(
			'clients',
			[
				'show_label' => false,
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '<# print(title || "Client image"); #>',
                'default' => array_fill( 0, 2, [
                    'image' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                ])
			]
		);

		$this->add_group_control(
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

        $this->end_controls_section();

        $this->start_controls_section(
			'_section_settings',
			[
				'label' => __( 'Settings', 'startupx-toolkit' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'_unqid',
			[
				'label' => esc_html__( 'Client selector', 'startupx-toolkit' ),
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => uniqid(),
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
					'arrow' => __( 'Arrow', 'startupx-toolkit' )
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
        $this->__client_item_style_controls();
        $this->__client_arrow_style_controls();
    }
    
    protected function __client_item_style_controls() {
    
        $this->start_controls_section(
            '_section_style_item',
            [
                'label' => __( 'Client item', 'startupx-toolkit' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_horizontal_spacing',
            [
                'label' => __( 'Horizontal Spacing', 'startupx-toolkit' ),
                'type' => Controls_Manager::NUMBER,
                'placeholder' => '15',
				'min' => 0,
				'max' => 100,
				'step' => 5,
				'default' => 15,
                'frontend_available' => true,
            ]
        );
    
        $this->add_responsive_control(
            'item_border_radius',
            [
                'label' => __( 'Border Radius', 'startupx-toolkit' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );
    
        $this->end_controls_section();
    }
    
    protected function __client_arrow_style_controls() {
    
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
                        'min' => -110,
                        'max' => 110,
                    ],
                    '%' => [
                        'min' => -110,
                        'max' => 110,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 50,
					'unit' => '%',
				],
				'tablet_default' => [
					'size' => 50,
					'unit' => '%',
				],
				'mobile_default' => [
					'size' => 50,
					'unit' => '%',
				],
                'selectors' => [
                    '{{WRAPPER}} .slide-next, {{WRAPPER}} .slide-previous' => 'top: {{SIZE}}{{UNIT}}; transform: translateY({{SIZE}}{{UNIT}}); -webkit-transform: translateY(-{{SIZE}}{{UNIT}})',
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
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 0,
					'unit' => '%',
				],
				'tablet_default' => [
					'size' => 0,
					'unit' => '%',
				],
				'mobile_default' => [
					'size' => 0,
					'unit' => '%',
				],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous' => 'left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .slide-next' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    
        $this->end_popover();

        $this->add_responsive_control(
            'button_size',
            [
                'label' => __( 'Button size', 'startupx-toolkit' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
					'unit' => 'px',
					'size' => 40
				]
            ]
        );
    
        $this->add_responsive_control(
            'arrow_size',
            [
                'label' => __( 'Arrow size', 'startupx-toolkit' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default' => [
					'unit' => 'px',
					'size' => 30
				],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous svg, {{WRAPPER}} .slide-next svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
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
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'color: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_control(
            'arrow_bg_color',
            [
                'label' => __( 'Background Color', 'startupx-toolkit' ),
                'type' => Controls_Manager::COLOR,
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
                'selectors' => [
                    '{{WRAPPER}} .slide-previous:hover, {{WRAPPER}} .slide-next:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_control(
            'arrow_hover_bg_color',
            [
                'label' => __( 'Background Color', 'startupx-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slide-previous:hover, {{WRAPPER}} .slide-next:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_control(
            'arrow_hover_border_color',
            [
                'label' => __( 'Border Color', 'startupx-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'arrow_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous:hover, {{WRAPPER}} .slide-next:hover' => 'border-color: {{VALUE}};',
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
		if ( empty( $settings['clients'] ) ) {
			return;
        }

        $loop = $settings['loop'];
        $autoplay = $settings['autoplay'];
        $spacing = $settings['item_horizontal_spacing'];
        $this->add_render_attribute(
            'wrapper',
            [
                'class' => [ 'block--clients-slider' ],
                'data-selector' => esc_attr( $settings['_unqid'] ),
                'data-autoplay' => esc_attr($settings['_unqid'] ),
                'data-spacing' =>  absint( $spacing ),
                'data-loop' => esc_attr( $loop ),
            ]
        );
        ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div id="clients_slider_<?php echo esc_attr($settings['_unqid']) ?>" class="swiper">
                <div class="clients-inner clients-wrapper swiper-wrapper">
    
                    <?php 
                        foreach ( $settings['clients'] as $client ) : ?>
                            <div class="swiper-slide client-slide">
                                <?php
                                    $this->add_render_attribute( 'image', 'src', $client['image']['url'] );
                                    $this->add_render_attribute( 'image', 'alt', \Elementor\Control_Media::get_image_alt( $client['image'] ) );
                                    $this->add_render_attribute( 'image', 'title', \Elementor\Control_Media::get_image_title( $client['image'] ) );
                                    $this->add_render_attribute( 'image', 'class', 'image' );
                                ?>

                                <?= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $client, 'thumbnail', 'image' ); ?>
                            </div>
                        <?php
                        endforeach;
                    ?>
                
                </div>

            </div>
            <?php if( $settings['navigation'] == 'arrow' ): ?>
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
                    'class': 'block--clients-slider',
                    'data-selector': settings._unqid,
                    'data-loop': settings.loop,
                    'data-spacing': settings.item_horizontal_spacing,
                    'data-autoplay': settings.autoplay,
                }
            );
            #>
            <div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
                <div id="clients_slider_{{{ settings._unqid }}}" class="swiper">
                    <div class="clients-wrapper swiper-wrapper">
                        <#
                        if ( settings.clients ) {
                            _.each( settings.clients, function( client, index ) {
                            #>
                            <div class="swiper-slide client-slide">
                                <# if ( client.image && client.image.url ) { #>
                                    <img src="{{{ client.image.url }}}">
                                <# } #>
                            </div>
                            <#
                            } );
                        }
                        #>
                    </div>

                    <# if( settings.navigation == 'arrow' ){ #>
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
                </div>
            </div>
        <?php
    }

}