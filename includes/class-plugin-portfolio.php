<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://thierrycharriot.github.io
 * @since      1.0.0
 *
 * @package    Plugin_Portfolio
 * @subpackage Plugin_Portfolio/includes
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
 * @package    Plugin_Portfolio
 * @subpackage Plugin_Portfolio/includes
 * @author     Thierry Charriot <thierrycharriot@chez.lui>
 */
class Plugin_Portfolio {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Plugin_Portfolio_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

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
		if ( defined( 'PLUGIN_PORTFOLIO_VERSION' ) ) {
			$this->version = PLUGIN_PORTFOLIO_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'plugin-portfolio';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Plugin_Portfolio_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_Portfolio_i18n. Defines internationalization functionality.
	 * - Plugin_Portfolio_Admin. Defines all hooks for the admin area.
	 * - Plugin_Portfolio_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-plugin-portfolio-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-plugin-portfolio-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-plugin-portfolio-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-plugin-portfolio-public.php';

		/**
		 * Load the custom post-types
		 * Thierry Charriot@chez.lui
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'post-types/formation.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'post-types/realisation.php';	

		$this->loader = new Plugin_Portfolio_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_Portfolio_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Plugin_Portfolio_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Plugin_Portfolio_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// https://developer.wordpress.org/reference/hooks/show_user_profile/
		// do_action( 'show_user_profile', WP_User $profile_user )
		// Fires after the ‘About Yourself’ settings table on the ‘Profile’ editing screen.
		$this->loader->add_action( 'show_user_profile', $plugin_admin, 'portfolio_settings_add', 10, 1 );
		// https://developer.wordpress.org/reference/hooks/edit_user_profile/
		// do_action( 'edit_user_profile', WP_User $profile_user )
		// Fires after the ‘About the User’ settings table on the ‘Edit User’ screen.
		$this->loader->add_action( 'edit_user_profile', $plugin_admin, 'portfolio_settings_add', 10, 1 );
		// https://developer.wordpress.org/reference/hooks/personal_options_update/
		// do_action( 'personal_options_update', int $user_id )
		// Fires before the page loads on the ‘Profile’ editing screen.
		$this->loader->add_action( 'personal_options_update', $plugin_admin, 'portfolio_settings_register', 10, 1 );
		// https://developer.wordpress.org/reference/hooks/edit_user_profile_update/
		// do_action( 'edit_user_profile_update', int $user_id )
		// Fires before the page loads on the ‘Edit User’ screen.
		$this->loader->add_action( 'edit_user_profile_update', $plugin_admin, 'portfolio_settings_register', 10, 1 );
		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Plugin_Portfolio_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );


		// https://developer.wordpress.org/reference/functions/add_filter/
		// add_filter( string $hook_name, callable $callback, int $priority = 10, int $accepted_args = 1 ): true
		// Adds a callback function to a filter hook.
		$this->loader->add_filter( 'theme_page_templates', $plugin_public, 'plugin_templates_register', 10, 3 );
		$this->loader->add_filter( 'template_include', $plugin_public, 'plugin_templates_select', 99 );

		// https://developer.wordpress.org/reference/functions/add_shortcode/
		// add_shortcode( string $tag, callable $callback )
		// Adds a new shortcode.
		add_shortcode( 'shortcode-portfolio', array( $plugin_public, 'plugin_load_shortcode') );

		// https://developer.wordpress.org/reference/hooks/template_redirect/
		// do_action( 'template_redirect' )
		// Fires before determining which template to load.
		$this->loader->add_action( 'template_redirect', $plugin_public, 'redirect_home' );

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
	 * @return    Plugin_Portfolio_Loader    Orchestrates the hooks of the plugin.
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
