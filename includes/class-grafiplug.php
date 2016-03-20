<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Grafiplug
 * @subpackage Grafiplug/includes
 */

// The core plugin class.
class Grafiplug {

	// The loader that's responsible for maintaining and registering all hooks that power the plugin.
	protected $loader;

	// The unique identifier of this plugin.
	protected $plugin_name;

	// The current version of the plugin.
	protected $version;
	
	// The options name to be used in this plugin
	private $option_name = 'grafiplug ';
	
	// Define the core functionality of the plugin.
	public function __construct() {
		$this->plugin_name = 'grafiplug';
		$this->version = '1.0.0';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	// Load the required dependencies for this plugin.
	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-grafiplug-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-grafiplug-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-grafiplug-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-grafiplug-public.php';
		$this->loader = new Grafiplug_Loader();
	}

	// Define the locale for this plugin for internationalization.
	private function set_locale() {
		$plugin_i18n = new Grafiplug_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	// Register all of the hooks related to the admin area functionality of the plugin.
	private function define_admin_hooks() {

		$plugin_admin = new Grafiplug_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		// Add options page
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_options_page' );

		// Add menu item
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );
		$this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_setting' );		

		// Cleanup filters and actions

		
		
	}

	// Register all of the hooks related to the public-facing functionality of the plugin.
	private function define_public_hooks() {

		$plugin_public = new Grafiplug_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Optionless mandatory filters and actions
		$this->loader->add_action( 'wp_head', $plugin_public, 'grafiplug_web_author_meta_tag' );

		// Cleanup actions and filters
		$this->loader->add_action( 'init', $plugin_public, 'grafiplug_cleanup' );
		$this->loader->add_filter( 'nav_menu_css_class', $plugin_public, 'grafiplug_clean_nav_classes', 100, 1 );
		$this->loader->add_filter( 'nav_menu_item_id', $plugin_public, 'grafiplug_clean_nav_ids', 10, 2 );

		$disable_wp_emojicons = get_option( $this->plugin_name . '_disable_wp_emojicons' );
		if( ( isset( $cleanup_all ) && !empty( $cleanup_all ) ) || ( isset( $disable_wp_emojicons ) && !empty(  $disable_wp_emojicons ) ) ) :
			$this->loader->add_action( 'init', $plugin_public, 'grafiplug_disable_wp_emojicons' );
		endif;

		// Disable Emoji functions and resources
		$this->loader->add_action( 'init', $plugin_public, 'grafiplug_disable_emoticon_functionlity' );

		// WordPress mail filters
		$this->loader->add_filter( 'wp_mail_content_type', $plugin_public, 'grafiplug_mail_content_type_filter' );
		$this->loader->add_filter( 'wp_mail_from', $plugin_public, 'grafiplug_mail_from_address' );
		$this->loader->add_filter( 'wp_mail_from_name', $plugin_public, 'grafiplug_mail_from_name' );

		// Custom login functionality
		$this->loader->add_action( 'login_enqueue_scripts', $plugin_public, 'grafiplug_admin_login_css' );
		$this->loader->add_filter( 'login_headerurl', $plugin_public, 'grafiplug_admin_login_logo_url' );
		$this->loader->add_filter( 'login_headertitle', $plugin_public, 'grafiplug_admin_login_title' );
		$this->loader->add_action( 'login_init', $plugin_public, 'grafiplug_login_stylesheet' );
		$this->loader->add_action( 'login_init', $plugin_public, 'grafiplug_login_remove_scripts' );
		//$this->loader->add_action( 'login_footer', $plugin_public, 'grafiplug_login_page_links' );
		//$this->loader->add_action( 'login_enqueue_scripts', $plugin_public, 'wp_print_styles', 11 );
		
		// Additional file types
		$this->loader->add_filter( 'upload_mimes', $plugin_public, 'grafiplug_cdr_upload_mimes' );
		$this->loader->add_filter( 'upload_mimes', $plugin_public, 'grafiplug_svg_upload_mimes' );
		$this->loader->add_filter( 'upload_mimes', $plugin_public, 'grafiplug_vcard_upload_mimes' );

		// Misc
		$this->loader->add_action( 'wp_head', $plugin_public, 'grafiplug_ie_link_border_removal');
		$this->loader->add_action( 'wp_footer', $plugin_public, 'grafiplug_google_analytics', 20 );
		$this->loader->add_filter( 'mce_buttons_2', $plugin_public, 'grafiplug_enable_core_buttons' );

		// Admin
		$this->loader->add_action( 'admin_head', $plugin_public, 'grafiplug_remove_help_tab' );
		$this->loader->add_action( 'admin_menu', $plugin_public, 'grafiplug_remove_admin_menus', 99 );
		$this->loader->add_action( 'wp_before_admin_bar_render', $plugin_public, 'grafiplug_remove_admin_bar_links' );
		$this->loader->add_action( 'wp_dashboard_setup', $plugin_public, 'grafiplug_remove_dashboard_widgets' );
		$this->loader->add_action( 'admin_menu', $plugin_public, 'grafiplug_admin_menu_items_remove' );
		$this->loader->add_action( 'admin_bar_menu', $plugin_public, 'grafiplug_admin_bar' );
		$this->loader->add_action( 'admin_notices', $plugin_public, 'grafiplug_mandatory_settings' );
		$this->loader->add_action( 'admin_menu', $plugin_public, 'grafiplug_all_options_link' );
		$this->loader->add_filter( 'update_footer', $plugin_public, 'grafiplug_remove_footer_version', 11 );
		$this->loader->add_filter( 'admin_footer_text', $plugin_public, 'grafiplug_remove_footer_admin' );
		$this->loader->add_filter( 'user_contactmethods', $plugin_public, 'grafiplug_add_contactmethods', 10, 1 );

		// Comment system
		$remove_comment_system = get_option( $this->plugin_name . '_remove_comment_system' );
		if( $remove_comment_system ) :
			$this->loader->add_action( 'admin_init', $plugin_public, 'grafiplug_disable_comments_post_types_support' );
			$this->loader->add_filter( 'comments_open', $plugin_public, 'grafiplug_disable_comments_status', 20, 2 );
			$this->loader->add_filter( 'pings_open', $plugin_public, 'grafiplug_disable_comments_status', 20, 2 );
			$this->loader->add_filter( 'comments_array', $plugin_public, 'grafiplug_disable_comments_hide_existing_comments', 10, 2 );
			$this->loader->add_action( 'admin_menu', $plugin_public, 'grafiplug_disable_comments_admin_menu' );
			$this->loader->add_action( 'admin_init', $plugin_public, 'grafiplug_disable_comments_admin_menu_redirect' );
			$this->loader->add_action( 'admin_init', $plugin_public, 'grafiplug_disable_comments_dashboard' );
			$this->loader->add_action( 'init', $plugin_public, 'grafiplug_disable_comments_admin_bar' );
			$this->loader->add_action( 'wp_before_admin_bar_render', $plugin_public, 'grafiplug_remove_comments_admin_bar_links');
			$this->loader->add_action( 'admin_menu', $plugin_public, 'grafiplug_disable_comments_admin_menu');
			$this->loader->add_action( 'admin_init', $plugin_public, 'grafiplug_disable_comments_admin_menu_redirect' );
			$this->loader->add_action( 'add_meta_boxes', $plugin_public, 'grafiplug_remove_comments_metabox_post_types', 99 );
		endif;

		$hide_profile_fields = get_option( $this->plugin_name . '_hide_profile_fields' );
		if( $hide_profile_fields ) :
			$this->loader->add_filter( 'user_contactmethods', $plugin_public, 'grafiplug_hide_profile_fields', 10, 1 );
		endif;


	}

	// Run the loader to execute all of the hooks with WordPress.
	public function run() {
		$this->loader->run();
	}

	// The name of the plugin used to uniquely identify it within the context of WordPress and to define internationalization functionality.
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	//The reference to the class that orchestrates the hooks with the plugin.
	public function get_loader() {
		return $this->loader;
	}

	// Retrieve the version number of the plugin.
	public function get_version() {
		return $this->version;
	}

}
