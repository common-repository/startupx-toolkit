<?php

namespace StartupxToolkit\Core\Elementor;

use StartupxToolkit\Traits\Singleton;

class Elementor{

    use Singleton;

    public function __construct() {

        add_action('wp_footer', [ $this, 'register_styles' ]);
        add_action('elementor/editor/before_enqueue_styles', [ $this, 'elementor_custom_style'] );

    }

    public function register_styles(){

        wp_register_style( 'swiper', \StartupxToolkit::plugin_url().'assets/vendor/swiper/css/swiper-bundle.min.css', array(), '7.0.1', 'all' );

    }

    public function elementor_custom_style() { ?>
        <style>
          #elementor-panel-category-pro-elements,
          #elementor-panel-category-theme-elements,
          #elementor-panel-category-woocommerce-elements{
              display: none !important;
          }
        </style>
    <?php  
    }

}