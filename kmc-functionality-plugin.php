<?php
/**
 * 
 * The file responsible for starting the KayMozCeramics Functionality plugin
 * 
 * This plugin adds a bunch of functionality to a WordPress install.
 * This particular file is responsible for including the necessary dependencies and starting the plugin.
 * 
 * @package     KayMozCeramics
 *
 * @wordpress-plugin
 * Plugin Name:       KayMozCeramics Functionality
 * Plugin URI:        https://github.com/davemoz/WP-functionality-plugin
 * Description:       Custom WordPress functionality plugin.
 * Version:           1.0.0
 * Author:            Dave Mozdzanowski
 * Author URI:        http://davemoz.dev
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:				kmc-functionality-locale
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

// Defines the encompassing main class of the plugin
if( !class_exists( 'KayMozCeramics_Functionality' ) ) {
	class KayMozCeramics_Functionality {

		/**
		 * A reference to the admin loader class that coordinates the hooks and callbacks for the admin portion of the plugin
		 * 
		 * @access	protected
		 * @var			KayMozCeramics_Admin_Loader $adminloader Manages hooks between the WordPress admin hooks and the callback functions.
		 */
		protected $adminloader;

		/**
		 * Instance of the class
		 *
		 * @since 1.0.0
		 * @var Instance of KayMozCeramics_Functionality class
		 */
		private static $instance;

		/**
		 * Instance of the plugin
		 *
		 * @since 1.0.0
		 * @static
		 * @staticvar array $instance
		 * @return Instance
		 */
		public static function instance() {
			if ( !isset( self::$instance ) && ! ( self::$instance instanceof KayMozCeramics_Functionality ) ) {
				self::$instance = new KayMozCeramics_Functionality;
				self::$instance->define_constants();
				add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
				self::$instance->includes();
				self::$instance->define_admin_hooks();
				self::$instance->init = new KayMozCeramics_Init();
			}
		return self::$instance;
		}

		/**
		 * Define the plugin constants
		 *
		 * @since  1.0.0
		 * @access private
		 * @return void
		 */
		private function define_constants() {
			// Plugin Version
			if ( ! defined( 'KMC_VERSION' ) ) {
				define( 'KMC_VERSION', '1.0.0' );
			}
			// Prefix
			if ( ! defined( 'KMC_PREFIX' ) ) {
				define( 'KMC_PREFIX', 'kmc_' );
			}
			// Textdomain
			if ( ! defined( 'KMC_TEXTDOMAIN' ) ) {
				define( 'KMC_TEXTDOMAIN', 'kmc' );
			}
			// Plugin Options
			if ( ! defined( 'KMC_OPTIONS' ) ) {
				define( 'KMC_OPTIONS', 'kmc-options' );
			}
			// Plugin Directory
			if ( ! defined( 'KMC_PLUGIN_DIR' ) ) {
				define( 'KMC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}
			// Plugin URL
			if ( ! defined( 'KMC_PLUGIN_URL' ) ) {
				define( 'KMC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}
			// Plugin Root File
			if ( ! defined( 'KMC_PLUGIN_FILE' ) ) {
				define( 'KMC_PLUGIN_FILE', __FILE__ );
			}
		}

		/**
		 * Load the required files
		 *
		 * @since  1.0.0
		 * @access private
		 * @return void
		 */
		private function includes() {
			$includes_path = plugin_dir_path( __FILE__ ) . 'includes/';
			require_once KMC_PLUGIN_DIR . 'includes/admin/class-kmc-admin.php';
			require_once KMC_PLUGIN_DIR . 'includes/admin/class-kmc-admin-loader.php';
			$this->adminloader = new KayMozCeramics_Admin_Loader();

			require_once KMC_PLUGIN_DIR . 'includes/class-kmc-custom-nav-walker.php';
			require_once KMC_PLUGIN_DIR . 'includes/class-kmc-woocommerce.php';
			require_once KMC_PLUGIN_DIR . 'includes/class-kmc-register-post-types.php';
			require_once KMC_PLUGIN_DIR . 'includes/class-kmc-register-taxonomies.php';
			require_once KMC_PLUGIN_DIR . 'includes/class-kmc-remove-admin-bar.php';
			require_once KMC_PLUGIN_DIR . 'includes/class-kmc-clean-up-head.php';
			require_once KMC_PLUGIN_DIR . 'includes/class-kmc-insert-figure.php';
			require_once KMC_PLUGIN_DIR . 'includes/class-kmc-long-url-spam.php';
			require_once KMC_PLUGIN_DIR . 'includes/class-kmc-remove-jetpack-bar.php';
			require_once KMC_PLUGIN_DIR . 'includes/class-kmc-remove-unwanted-assets.php';
			require_once KMC_PLUGIN_DIR . 'includes/class-kmc-remove-post-author-url.php';
			require_once KMC_PLUGIN_DIR . 'includes/class-kmc-custom-pagi.php';
			require_once KMC_PLUGIN_DIR . 'includes/class-kmc-sharing.php';
			require_once KMC_PLUGIN_DIR . 'includes/class-kmc-remove-wp-version.php';


			require_once KMC_PLUGIN_DIR . 'includes/class-kmc-init.php';
		}

		/**
		 * Defines the hooks and callback functions that are used for setting up the plugin's stylesheets
		 * 
		 * This function relies on the KayMozCeramics_Admin class and the KayMozCeramics_Admin_Loader class property.
		 * 
		 * @access private
		 */
		private function define_admin_hooks() {

			$admin = new KayMozCeramics_Admin();
			$this->adminloader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_styles');

		}

		/**
		 * Load the plugin text domain for translation.
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function load_textdomain() {
			$kmc_lang_dir = dirname( plugin_basename( KMC_PLUGIN_FILE ) ) . '/languages/';
			$kmc_lang_dir = apply_filters( 'KayMozCeramics_lang_dir', $kmc_lang_dir );

			$locale = apply_filters( 'plugin_locale',  get_locale(), KMC_TEXTDOMAIN );
			$mofile = sprintf( '%1$s-%2$s.mo', KMC_TEXTDOMAIN, $locale );

			$mofile_local  = $kmc_lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/edd/' . $mofile;

			if ( file_exists( $mofile_local ) ) {
				load_textdomain( KMC_TEXTDOMAIN, $mofile_local );
			} else {
				load_plugin_textdomain( KMC_TEXTDOMAIN, false, $kmc_lang_dir );
			}
		}

		/**
		 * Throw error on object clone
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', KMC_TEXTDOMAIN ), '1.6' );
		}

		/**
		 * Disable unserializing of the class
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', KMC_TEXTDOMAIN ), '1.6' );
		}

	}
}
/**
 * Return the instance
 *
 * @since 1.0.0
 * @return object The Safety Links instance
 */
function KayMozCeramics_Functionality_Run() {
	return KayMozCeramics_Functionality::instance();
}
KayMozCeramics_Functionality_Run();