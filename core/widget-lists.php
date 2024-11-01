<?php

namespace StartupxToolkit\Core;

use Elementor\Plugin;
use StartupxToolkit\Traits\Singleton;

if ( !defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly

class Widget_Lists {

    use Singleton;

    public function register_widget( $widgets_manager ) {

        $widgets = [
            'sliderx',
            'clientsx'
        ];

        foreach ( $widgets as $widget ) {
           
            $class_name = str_replace( '-', '_', $widget );
            $class_name = str_replace( ' ', '', ucwords( $class_name ) );
            $class_name = '\\StartupxToolkit\\Widgets\\'.$class_name.'\\'.$class_name;
            
            if( class_exists($class_name) ){
				$widgets_manager->register( new $class_name() );
			}
        }
    }

}
