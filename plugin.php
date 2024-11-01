<?php

namespace StartupxToolkit;

final class Plugin {

    /**
	 * Instance of the class.
	 *
	 * @since   1.0.0
	 *
	 * @var   object
	 */
	protected static $instance = null;

	public function init(){
        new \StartupxToolkit\Core\Loader;
		new \StartupxToolkit\Core\Elementor\Elementor;
    }

    /**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	public static function instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
}