<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/himanshudhakan
 * @since      1.0.0
 *
 * @package    Bulk_Products_To_Cart_For_Edd
 * @subpackage Bulk_Products_To_Cart_For_Edd/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Bulk_Products_To_Cart_For_Edd
 * @subpackage Bulk_Products_To_Cart_For_Edd/includes
 * @author     Himanshu Dhakan <himanshudhakan9@gmail.com>
 */
class Bulk_Products_To_Cart_For_Edd {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Bulk_Products_To_Cart_For_Edd_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The instances of classes.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $classes    The instances of all classes.
	 */
	protected $classes;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'BPTCFEDD_VERSION' ) ) {
			$this->version = BPTCFEDD_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'bulk-products-to-cart-for-edd';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Bulk_Products_To_Cart_For_Edd_Loader. Orchestrates the hooks of the plugin.
	 * - Bulk_Products_To_Cart_For_Edd_i18n. Defines internationalization functionality.
	 * - Bulk_Products_To_Cart_For_Edd_Admin. Defines all hooks for the admin area.
	 * - Bulk_Products_To_Cart_For_Edd_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once BPTCFEDD_INC_DIR_PATH . 'class-bptcfedd-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once BPTCFEDD_INC_DIR_PATH . 'class-bptcfedd-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once BPTCFEDD_ADMIN_DIR_PATH . 'class-bptcfedd-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once BPTCFEDD_PUBLIC_DIR_PATH . 'class-bptcfedd-public.php';

		$this->loader = new Bptcfedd_Loader();

		$plugin_admin = new Bptcfedd_Admin( $this->get_plugin_name(), $this->get_version() );
		$plugin_public = new Bptcfedd_Public( $this->get_plugin_name(), $this->get_version() );

		$this->classes['admin'] = $plugin_admin;
		$this->classes['public'] = $plugin_public;

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Bulk_Products_To_Cart_For_Edd_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Bptcfedd_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_hooks() {

		if ( !empty( $this->classes ) ) {
			
			foreach ($this->classes as $key => $object) {
				
				if ( method_exists($object, 'add_hooks') ) {
					
					$object->add_hooks();

				}

			}

		}

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Bulk_Products_To_Cart_For_Edd_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
