<?php
/**
 * Plugin Name: Startupx Toolkit
 * Plugin URI:  https://codegearthemes.com/products/startupx
 * Description: StartupxToolkit is the most-complete addon for Elementor.
 * Version: 1.0.1
 * Author: CodeGearThemes
 * Author URI:  https://codegearthemes.com
 * Text Domain: startupx-toolkit
 * Domain Path: /languages
 * License:  GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('ABSPATH') || exit;

final class StartupxToolkit{

	/**
	 * Instance of the class.
	 *
	 * @since   1.0.0
	 *
	 * @var   object
	 */
	protected static $instance = null;

    /**
	 * Plugin Version
	 *
	 * @return string
	 * @since 1.0.0
	 *
	 */
	public static function version() {
		return '1.0.1';
	}

    /**
	 * Plugin url
	 *
	 * @return mixed
	 * @since 1.0.0
	 */
	public static function plugin_url() {
		return trailingslashit(plugin_dir_url(__FILE__));
	}


	/**
	 * Plugin dir
	 *
	 * @return mixed
	 * @since 1.0.0
	 */
	public static function plugin_dir() {
		return trailingslashit(plugin_dir_path(__FILE__));
	}


    /**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		require_once __DIR__ . '/autoloader.php';

		add_action('init', [$this, 'i18n']);
		add_action('plugins_loaded', [$this, 'init'], 100);
	}

    /**
	 * Load text domain
	 *
	 * Load plugin localization files.
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain('startupx-toolkit', false, self::plugin_dir() . 'languages/');
	}

    public function init() {

		// Check if Startupx theme is installed and activated
		if( !$this->theme_check_default() ){
			add_action( 'admin_notices', array( $this, 'theme_support_missing_notice' ) );
		}

		// Check if Elementor installed and activated
		if ( !did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'required_plugins_notice' ) );
			return;
		}


		do_action('startupx-toolkit/before_loaded');
		StartupxToolkit\Plugin::instance()->init();
		do_action('startupx-toolkit/after_loaded');
	}

	/**
	 * Load theme config files
	 */
	public function theme_check_default() {

		$theme  = wp_get_theme();
		$theme  = $theme->name;
		$theme_list = [ 'Startupx' ];

		if ( get_template_directory() !== get_stylesheet_directory() ) {
			$parent = wp_get_theme()->parent();
			$theme = $parent->name;
		}

		if ( !in_array( $theme, $theme_list ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Show recommended themes notice.
	 *
	 * @return void
	 */
	/**
	 * Theme support fallback notice.
	 */
	public function theme_support_missing_notice() {
		$themes_url = admin_url( 'theme-install.php?search=startupx' ); ?>
		<div class="error notice is-dismissible">
			<p>
				<strong>
					<?php echo esc_html__( 'Startupx Toolkit', 'startupx-toolkit' ); ?>
					&#58;
				</strong>
				<?php echo sprintf( esc_html__( 'This plugin requires %s theme to be installed and activated.', 'startupx-toolkit' ), '<a href="' . esc_url( $themes_url ) . '">' . esc_html__( 'Startupx', 'startupx-toolkit' ) . '</a>' ); ?>
			</p>
		</div>
		<?php
	}

	/**
	 * Show recommended plugins notice.
	 *
	 * @return void
	 */
	public function required_plugins_notice() {
		$screen = get_current_screen();
		if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
			return;
		}

		$plugin = 'elementor/elementor.php';

		if ( $this->elementor_installed() ) {
			if ( !current_user_can( 'activate_plugins' ) ) {
				return;
			}

			$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
			$admin_message = '<p>' . esc_html__( 'Startupx Toolkit - Requires elementor plugin to be installed.', 'startupx-toolkit' ) . '</p>';
			$admin_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__( 'Activate Elementor', 'startupx-toolkit' ) ) . '</p>';
		} else {
			if ( !current_user_can( 'install_plugins' ) ) {
				return;
			}

			$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
			$admin_message = '<p>' . esc_html__( 'Startupx Toolkit - Requires elementor plugin to be installed.', 'startupx-toolkit' ) . '</p>';
			$admin_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Install Elementor', 'startupx-toolkit' ) ) . '</p>';
		} ?>
		<div class="error">
			<?php echo wp_kses_post($admin_message); ?>
		</div>
		<?php
	}


	/**
	 * Check if theme has elementor installed
	 *
	 * @return boolean
	 */
	public function elementor_installed() {
		$file_path = 'elementor/elementor.php';
		$installed_plugins = get_plugins();

		return isset( $installed_plugins[ $file_path ] );
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

/**
 * Returns the instance.
 *
 * @since  1.0.0
 * @return object
 */
StartupxToolkit::instance();
