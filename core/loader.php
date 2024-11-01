<?php

namespace StartupxToolkit\Core;

use StartupxToolkit\Traits\Singleton;
use StartupxToolkit\Core\Widget_Lists;

class Loader{

    use Singleton;

   /**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public function __construct() {
        add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );
        add_action( 'elementor/widgets/register', [ $this, 'register_elementor_widgets'] );
        add_action( 'elementor/widgets/register', [ $this, 'unregister_widgets' ] );

        add_action('wp_footer', [ $this, 'register_styles' ]);
    }

    /**
	 * Elementor Categories
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public function add_elementor_widget_categories( $elements_manager ) {
        
        $elements_manager->add_category(
            'startupx-toolkit',
            [
                'title' => esc_html__( 'Startupx Toolkit', 'startupx-toolkit' ),
                'icon' => 'fa fa-cube',
            ]
        );
    
    }

    public function register_styles(){

        wp_register_style( 'startupx-toolkit-style', \StartupxToolkit::plugin_url().'assets/public/css/main.css', array(), '1.0.0', 'all' );
        wp_enqueue_style('startupx-toolkit-style');
    }


    /**
	 * Elementor Widgets
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public function register_elementor_widgets( $widgets_manager ) {

        Widget_Lists::instance()->register_widget( $widgets_manager );

    }


    /**
     * Unregister Elementor widgets.
     *
     * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
     * @return void
     */
    function unregister_widgets( $widgets_manager ) {

        $widgets_manager->unregister( 'element--promotion' );

    }
}