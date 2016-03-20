<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Grafiplug
 * @subpackage Grafiplug/public
 */

// The public-facing functionality of the plugin.
class Grafiplug_Public {

	// The ID of this plugin.
	private $plugin_name;

	// The version of this plugin.
	private $version;

	// Initialize the class and set its properties.
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	// Register the stylesheets for the public-facing side of the site.	
	public function enqueue_styles() {
		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/grafiplug-public.css', array(), $this->version, 'all' );
		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/grafiplug-login.css', array(), $this->version, 'all' );
	}

	// Register the JavaScript for the public-facing side of the site.
	public function enqueue_scripts() {
		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/grafiplug-public.js', array( 'jquery' ), $this->version, false );
	}

	// General optionless or mandatory addons
	public function grafiplug_web_author_meta_tag(){
		echo '<meta name="author" content="Waylon Fourie, waylon@grafika.co.za">' . PHP_EOL;
	}

	// Cleanup functions
	public function grafiplug_cleanup() {
		$cleanup_all 								= get_option( $this->plugin_name . '_cleanup_all' );
		$remove_generator_meta 						= get_option( $this->plugin_name . '_remove_generator_meta' );
		$remove_feed_links_extra 					= get_option( $this->plugin_name . '_remove_feed_links_extra' );
		$remove_feed_links 							= get_option( $this->plugin_name . '_remove_feed_links' );
		$remove_rsd_link 							= get_option( $this->plugin_name . '_remove_rsd_link' );
		$remove_wlwmanifest_link 					= get_option( $this->plugin_name . '_remove_wlwmanifest_link' );
		$remove_index_rel_link 						= get_option( $this->plugin_name . '_remove_index_rel_link' );
		$remove_parent_post_rel_link				= get_option( $this->plugin_name . '_remove_parent_post_rel_link' );
		$remove_start_post_rel_link					= get_option( $this->plugin_name . '_remove_start_post_rel_link' );
		$remove_adjacent_posts_rel_link				= get_option( $this->plugin_name . '_remove_adjacent_posts_rel_link' );
		$remove_start_post_rel_link					= get_option( $this->plugin_name . '_remove_start_post_rel_link' );
		$remove_adjacent_posts_rel_link_wp_head 	= get_option( $this->plugin_name . '_remove_adjacent_posts_rel_link_wp_head' );
		$remove_rel_canonical 						= get_option( $this->plugin_name . '_remove_rel_canonical' );
		$remove_wp_shortlink_wp_head				= get_option( $this->plugin_name . '_remove_wp_shortlink_wp_head' );

		// Remove Wordpress generator meta tag
		if( ( isset( $cleanup_all ) && !empty( $cleanup_all ) ) || ( isset( $remove_generator_meta ) && !empty(  $remove_generator_meta ) ) ) :
			remove_action( 'wp_head', 'wp_generator' );
		elseif ( ( isset( $cleanup_all ) && !empty( $cleanup_all ) ) || ( isset( $remove_feed_links_extra ) && !empty(  $remove_feed_links_extra ) ) ) :
			remove_action( 'wp_head', 'feed_links_extra', 3 );
		elseif ( ( isset( $cleanup_all ) && !empty( $cleanup_all ) ) || ( isset( $remove_feed_links ) && !empty(  $remove_feed_links ) ) ) :
			remove_action( 'wp_head', 'feed_links', 2 );
		elseif ( ( isset( $cleanup_all ) && !empty( $cleanup_all ) ) || ( isset( $remove_rsd_link ) && !empty(  $remove_rsd_link ) ) ) :
			remove_action( 'wp_head', 'rsd_link' );
		elseif ( ( isset( $cleanup_all ) && !empty( $cleanup_all ) ) || ( isset( $remove_wlwmanifest_link ) && !empty(  $remove_wlwmanifest_link ) ) ) :
			remove_action( 'wp_head', 'wlwmanifest_link' );
		elseif ( ( isset( $cleanup_all ) && !empty( $cleanup_all ) ) || ( isset( $remove_index_rel_link ) && !empty(  $remove_index_rel_link ) ) ) :
			remove_action( 'wp_head', 'index_rel_link' );
		elseif ( ( isset( $cleanup_all ) && !empty( $cleanup_all ) ) || ( isset( $remove_parent_post_rel_link ) && !empty(  $remove_parent_post_rel_link ) ) ) :
			remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
		elseif ( ( isset( $cleanup_all ) && !empty( $cleanup_all ) ) || ( isset( $remove_start_post_rel_link ) && !empty(  $remove_start_post_rel_link ) ) ) :
			remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
		elseif ( ( isset( $cleanup_all ) && !empty( $cleanup_all ) ) || ( isset( $remove_adjacent_posts_rel_link ) && !empty(  $remove_adjacent_posts_rel_link ) ) ) :
			remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
		elseif ( ( isset( $cleanup_all ) && !empty( $cleanup_all ) ) || ( isset( $remove_start_post_rel_link ) && !empty(  $remove_start_post_rel_link ) ) ) :
			remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
		elseif ( ( isset( $cleanup_all ) && !empty( $cleanup_all ) ) || ( isset( $remove_adjacent_posts_rel_link_wp_head ) && !empty(  $remove_adjacent_posts_rel_link_wp_head ) ) ) :
			remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		elseif ( ( isset( $cleanup_all ) && !empty( $cleanup_all ) ) || ( isset( $remove_rel_canonical ) && !empty(  $remove_rel_canonical ) ) ) :
			remove_action( 'wp_head', 'rel_canonical' );
		elseif ( ( isset( $cleanup_all ) && !empty( $cleanup_all ) ) || ( isset( $remove_wp_shortlink_wp_head ) && !empty(  $remove_wp_shortlink_wp_head ) ) ) :
			remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
		endif;
	}

	// Set WordPress mail content type to html
	public function grafiplug_mail_content_type_filter() {
		$mail_content_type = get_option( $this->plugin_name . '_mail_content_type' );
		if( isset( $mail_content_type ) && !empty(  $mail_content_type ) ) :
			return "text/html";
		endif;
	}

	// Filter Wordpress from email address and replace with custom value
	public function grafiplug_mail_from_address() {
		$mail_from_address = get_option( $this->plugin_name . '_mail_from_address' );
		if( isset( $mail_from_address ) && !empty( $mail_from_address ) ) :
			return $mail_from_address;
		endif;
	}
	
	// Filter Wordpress from email address and replace with custom value
	public function grafiplug_email_from_name() {
		$email_from_name = get_option( $this->plugin_name . '_email_from_name' );
		if( isset( $email_from_name ) && !empty(  $email_from_name ) ) :
			return $email_from_name;
		endif;
	}

	// Disable all emoticon features and scripts
	public function grafiplug_disable_emoticon_functionlity() {
		$disable_emoticon_functionlity = get_option( $this->plugin_name . '_disable_emoticon_functionlity' );
		if( isset( $disable_emoticon_functionlity ) && !empty(  $disable_emoticon_functionlity ) ) :
			remove_action( 'admin_print_styles', 'print_emoji_styles' );
			remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
			remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
			remove_action( 'wp_print_styles', 'print_emoji_styles' );
			remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
			remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
			remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		endif;
	}

	public function grafiplug_admin_login_css() {
        $args = array (
            'echo'              => FALSE,
            'redirect'          => site_url( $_SERVER[ 'REQUEST_URI' ] ),       
            'form_id'           => 'loginform',
            'label_username'    => __( 'Usernamer', 'gws' ),
            'label_password'    => __( 'Password', 'gws' ),
            'label_remember'    => __( 'Remember Me', 'gws' ),
            'label_log_in'      => __( 'Log In', 'gws' ),
            'id_username'       => 'user_login',
            'id_password'       => 'user_pass',
            'id_remember'       => 'rememberme',
            'id_submit'         => 'wp-submit',
            'remember'          => TRUE,
            'value_username'    => NULL,
            'value_remember'    => TRUE,
        );
        wp_login_form( $args );
    }

    public function grafiplug_admin_login_logo_url() {
        return '//www.grafika.co.za';
    }
    
    public function grafiplug_admin_login_title() {
        return 'Design through inspiration';
    }

    public function grafiplug_login_stylesheet() { 
        wp_register_style( 
            $handle     = 'login-styles', 
            $src        = plugin_dir_url( __FILE__ ) . 'css/grafiplug-login.css', 
            $deps       = NULL, 
            $ver        = '1.0.0', 
            $media      = 'screen'
        );
        wp_enqueue_style( $handle = 'login-styles' ); 
    }

    public function grafiplug_login_remove_scripts() {
        wp_dequeue_style( 'login' );
        wp_deregister_style( 'login' );
    }

    public function grafiplug_login_page_links() { 

        $login_link  = '<div class="login-link-nav">';

        // Clientzone link
        $login_link .= '<a class="login_link" rel="nofollow" title="' . esc_attr__( 'Login to your billing account', 'gws' ) . '" href="' . esc_url( trailingslashit( GWS_URL ) . GWS_CLIENTZONE ) . '">' . __( 'ClientZone', 'gws' ) . '</a>';
        
        // cPanel
        $login_link .= '<a class="login_link" rel="nofollow" title="' . esc_attr__( 'Log in to your cPanel account', 'gws' ) . '" href="' . esc_url( 'https://cpanel.' . $_SERVER['HTTP_HOST'] ) . '">' . __( 'cPanel', 'gws' ) . '</a>';
        
        // Knowledgbase
        $login_link .= '<a class="login_link" rel="nofollow" title="' . esc_attr__( 'View our Knowledgebase articles', 'gws' ) . '" href="' . esc_url( trailingslashit( GWS_URL ) . GWS_KNOWLEDGEBASE ) . '">' . __( 'Knowledgebase', 'gws' ) . '</a>';
        
        // Webmail
        $login_link .= '<a class="login_link" rel="nofollow" title="' . esc_attr__( 'Access your emails via the Webmail interface', 'gws' ) . '" href="' . esc_url( 'https://webmail.' . $_SERVER['HTTP_HOST'] ) . '">' . __( 'Webmail', 'gws' ) . '</a>';

        echo $login_link . '</div>';
    }

     /**
	 * Add vCard mime type
	 * This function allows the upload of a vCard
	 * of the value.
	 * 
	 * @since 1.0.0
	 * @author Waylon Fourie
	 * @uses
	 */
	public function grafiplug_vcard_upload_mimes ( $existing_mimes=array() ) {
		$existing_mimes['vcf'] = 'text/x-vcard';
		return $existing_mimes;
	}
		
	/**
	 * Add vCard mime type
	 *
	 * This function allows the upload of a vCard
	 * of the value.
	 * 
	 * @since 1.0.0
	 * @author Waylon Fourie
	 * @uses
	 */
	public function grafiplug_svg_upload_mimes ( $existing_mimes=array() ) {
		$existing_mimes['svg'] = 'image/svg+xml';
		return $existing_mimes;
	}	

	/**
	 * Add vCard mime type
	 *
	 * This function allows the upload of a vCard
	 * of the value.
	 * 
	 * @since 1.0.0
	 * @author Waylon Fourie
	 * @uses
	 */
	public function grafiplug_cdr_upload_mimes ( $existing_mimes=array() ) {
		$existing_mimes['cdr'] = 'image/x-coreldraw';
		return $existing_mimes;
	}

	/**
	 * Remove IE link borders
	 * 
	 * Remove the stippled borders around links for IE
	 * 
	 * @since 1.0.0
	 * @author Waylon Fourie
	 * @uses get_permalink()
	 */
	public function grafiplug_ie_link_border_removal() {
		echo '<meta http-equiv="X-UA-Compatible" content="IE=9" />' . "\n";
	}

	/**
	 * Embed Analytics
	 * 
	 * Include analytics code into each page in theme
	 * 
	 * @since 1.0.0
	 * @author Waylon Fourie
	 * @uses get_permalink()
	 */
	public function grafiplug_google_analytics() {
		if ( !current_user_can( 'manage_options' ) && get_theme_mod( 'include_analytics', '' ) && get_theme_mod( 'analytics_code', '') ) : ?>
		    <script>
		        (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
		        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
		        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
		        e.src='//www.google-analytics.com/analytics.js';
		        r.parentNode.insertBefore(e,r)}(window,document,'script','ga' ) );
		        ga( 'create','<?php echo get_theme_mod( 'analytics_code', '') ?>' );ga( 'send','pageview' );
		    </script>
		<?php endif; 
	}

	/**
	 * Clean navigation classes
	 * 
	 * This function removes native WordPress CSS classes
	 * that are injected into the navigation menus leaving
	 * only the "current-menu-item" class.
	 * 
	 * @since 1.0.0
	 * @author Waylon Fourie
	 */
	public function grafiplug_clean_nav_classes( $var ) {
        return is_array( $var ) ? array_intersect( $var, array( 'current-menu-item', 'current-menu-parent', 'current-menu-ancestor' ) ) : '';
    }
    

	/**
	 * Clean navigation id's
	 * 
	 * This function removes native WordPress CSS ID's
	 * that are injected into the navigation menus.
	 * 
	 * @since 1.0.0
	 * @author Waylon Fourie
	 */
	public function grafiplug_clean_nav_ids( $id, $item ) {
	    return '';
	}

	/**
	 * Enable Hidden Buttons
	 *
	 * Enable certain buttons disabled by wordpress
	 *
	 * @since 4.0.0
	 * @see http://www.tinymce.com/wiki.php/TinyMCE3x:Buttons/controls
	 * @link http://www.grafipress.co.za
	 */
	public function grafiplug_enable_core_buttons( $buttons ) { 
	    
	    $buttons[] = 'superscript';
	    $buttons[] = 'subscript';
	    $buttons[] = 'spellchecker';

	    return $buttons;
	}

	/**
	 * Removes 'Help' tab.
	 *
	 * This removes the 'Help' tab for all users.
	 *
	 * @since 1.0.0
	 * @link http://www.grafipress.co.za
	 */
	function grafiplug_remove_help_tab() {
	    $screen = get_current_screen();
	    $screen->remove_help_tabs();
	}

	/**
	 * Removes admin page links.
	 *
	 * This removes several links from the WordPress main menu
	 * located to the right of the admin pages.
	 *
	 * @since 1.0.0
	 * @link http://www.grafipress.co.za
	 *
	 */
	public function grafiplug_remove_admin_menus() {
		if( !current_user_can('manage_options') ) :
	    	remove_menu_page( 'tools.php' );
	    	remove_menu_page( 'index.php' );
		endif;
	}

	/**
	 * Removes adminbar links.
	 *
	 * This removes several links from the WordPress adminbar menu
	 * located right at the top of the admin pages.
	 *
	 * @since 1.0.0
	 * @link http://www.grafipress.co.za
	 *
	 */
	function grafiplug_remove_admin_bar_links() {

	    global $wp_admin_bar;

	    $wp_admin_bar->remove_menu( 'wp-logo' );
	    //$wp_admin_bar->remove_menu( 'about' );
	    $wp_admin_bar->remove_menu( 'wporg' );
	    $wp_admin_bar->remove_menu( 'documentation' );
	    $wp_admin_bar->remove_menu( 'support-forums' );
	    $wp_admin_bar->remove_menu( 'feedback' );
	    $wp_admin_bar->remove_menu( 'site-name' );
	    $wp_admin_bar->remove_menu( 'view-site' );
	    
	    if ( ! current_user_can( 'update_core' ) ) :
		    $wp_admin_bar->remove_menu( 'updates' );
		    $wp_admin_bar->remove_menu( 'comments' );
		    $wp_admin_bar->remove_menu( 'new-content' );
		    $wp_admin_bar->remove_menu( 'w3tc' );
		    //$wp_admin_bar->remove_menu( 'my-account' );
		    $wp_admin_bar->remove_menu( 'wpseo-menu' );
		    $wp_admin_bar->remove_menu( 'wpseo-kwresearch' );
		    $wp_admin_bar->remove_menu( 'wpseo-adwordsexternal' );
		    $wp_admin_bar->remove_menu( 'wpseo-googleinsights' );
		    $wp_admin_bar->remove_menu( 'wpseo-wordtracker' );
	    endif;
	}

	/**
	 * Removes dashboard widgets.
	 *
	 * This removes several widgets from the WordPress dashboard 
	 * for all users.
	 *
	 * @since 1.0.0
	 * @link http://www.grafipress.co.za
	 *
	 */
	function grafiplug_remove_dashboard_widgets( ) {

	    // WordPress core meta boxes
	    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	    remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
	    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );

	    // Third party meta boxes
	    remove_meta_box( 'yoast_db_widget', 'dashboard', 'normal' );
	}

	/**
	 * Removes pages from admin menu.
	 *
	 * This removes several pages from the WordPress admin menu 
	 * for any user without 'administrator' rights.
	 *
	 * @since 1.0.0
	 * @link http://www.grafipress.co.za
	 *
	 */
	public function grafiplug_admin_menu_items_remove() {
	    if ( ! current_user_can( 'update_core' ) && '/wp-admin/admin-ajax.php' != $_SERVER[ 'PHP_SELF' ] ) :        
	        remove_menu_page( 'tools.php' );
	    endif;
	}

	/**
	 * Add custom adminbar dropdown menu.
	 *
	 * This adds a custom dropdown menu to the WordPress admin menu 
	 * for any user.
	 *
	 * @since 4.0.0 *
	 * @link http://www.grafipress.co.za
	 */
	public function grafiplug_admin_bar() {

	    global $wp_admin_bar;

	    $wp_admin_bar->add_menu( array (
	        'id'        => 'gws-custom-menu',
	        'title'     => '<img src="' . esc_attr( trailingslashit( get_template_directory_uri() ) . '/img/defaults/gws_logo.svg' ) . '" style="padding: 5px; max-width:74px!important; height:auto!important;" alt="' .  esc_attr__( GWS_CREATOR, 'gws' ) . '">',
	        'href'      => FALSE
	    ) );

	    /* Add "View Site" link */
        $wp_admin_bar->add_menu( array (
            'id'        => 'gws-view',
            'title'     => esc_attr__( 'View Site', 'gws' ),
            'href'      => home_url(),
            'meta'      => array ( 'target'=>'_blank', 'class' => 'wp-admin-bar-view' )
        ) );

	    /* Add "maintenance mode" message */
	    if ( get_theme_mod( 'enable_maintenance_mode', '') ) :
	        $wp_admin_bar->add_menu( array (
	            'id'        => 'gws-under-construction-notice',
	            'title'     => esc_attr__( 'MAINTENANCE MODE ENABLED ', 'gws' ),
	            'href'      => FALSE,
	            'meta'      => array ( 'target'=>'_blank', 'class' => 'wp-admin-bar-underconstruction' )
	        ) );
	    endif;

	    /* Add "coming soon enabled" message */
	    if ( get_theme_mod( 'enable_coming_soon_mode', '') ) :
	        $wp_admin_bar->add_menu( array (
	            'id'        => 'gws-under-construction-notice',
	            'title'     => esc_attr__( 'COMING SOON MODE ENABLED ', 'gws' ),
	            'href'      => FALSE,
	            'meta'      => array ( 'target'=>'_blank', 'class' => 'wp-admin-bar-coming-soon' )
	        ) );
	    endif;

	    /* Sub menu to open one of my plugins page */
	    $wp_admin_bar->add_menu( array (
	        'id'        => 'gws-website',
	        'parent'    => 'gws-custom-menu',
	        'title'     => sprintf( esc_attr__( 'Visit %s', 'gws' ), GWS_CREATOR ),
	        'href'      => GWS_URL,
	        'meta'      => array ( 'target'=>'_blank', 'class' => 'wp-admin-bar-grafikawebsite' )
	    ) );

	    /* Sub menu to open facebook (external link) in new window */
	    $wp_admin_bar->add_menu( array (
	        'id'        => 'facebook-page',
	        'parent'    => 'gws-custom-menu',
	        'title'     => esc_attr__( 'Catch us on Facebook', 'gws' ),
	        'href'      => 'https://www.facebook.com/' . GWS_FACEBOOK,
	        'meta'      => array ( 'target'=>'_blank', 'class' => 'wp-admin-bar-facebook' )
	    ) );

	    /* Sub menu to open twitter (external link) in new window */
	    $wp_admin_bar->add_menu( array (
	        'id'        => 'twitter-page',
	        'parent'    => 'gws-custom-menu',
	        'title'     => esc_attr__( 'Catch us on Twitter', 'gws' ),
	        'href'      => 'https://www.twitter.com/' .GWS_TWITTER,
	        'meta'      => array ( 'target'=>'_blank', 'class' => 'wp-admin-bar-twitter' )
	    ) );

	    /* Sub menu to open twitter (external link) in new window */
	    $wp_admin_bar->add_menu( array (
	        'id'        => 'clientzone-page',
	        'parent'    => 'gws-custom-menu',
	        'title'     => esc_attr__( 'Login to your ClientZone', 'gws' ),
	        'href'      => GWS_URL .'/'. GWS_CLIENTZONE,
	        'meta'      => array ( 'target'=>'_blank', 'class' => 'wp-admin-bar-clientzone' )
	    ) );

	    /* Sub menu to open cpanel (external link) in new window */
	    $wp_admin_bar->add_menu( array (
	        'id'        => 'cpanel-page',
	        'parent'    => 'gws-custom-menu',
	        'title'     => esc_attr__( 'Login to your cPanel', 'gws' ),
	        'href'      => 'https://cpanel.' . $_SERVER['HTTP_HOST'],
	        'meta'      => array ( 'target'=>'_blank', 'class' => 'wp-admin-bar-cpanel' )
	    ) );

	    /* Sub menu to open twitter (external link) in new window */
	    $wp_admin_bar->add_menu( array (
	        'id'        => 'knowledgebase-page',
	        'parent'    => 'gws-custom-menu',
	        'title'     => esc_attr__( 'Knowledgebase Articles', 'gws' ),
	        'href'      => GWS_URL . '/' . GWS_KNOWLEDGEBASE,
	        'meta'      => array ( 'target'=>'_blank', 'class' => 'wp-admin-bar-knowledgebase' )
	    ) );
	}

	/**
	 * Remove contact methods.
	 *
	 * This removes contact methods in the user profile area.
	 *
	 * @since 1.0.0
	 * @link http://www.grafipress.co.za
	 */
	function grafiplug_hide_profile_fields( $contactmethods ) {
		unset( $contactmethods['aim']);
		unset( $contactmethods['jabber']);
		unset( $contactmethods['yim']);
		return $contactmethods;
	}

	/**
	 * Disable comment system.
	 *
	 * This removes all comment links, functions and view from the installation.
	 *
	 * @since 1.0.0
	 * @link http://www.grafipress.co.za
	 *
	 */
	// Disable support for comments and trackbacks in post types
	public function grafiplug_disable_comments_post_types_support() {
		$post_types = get_post_types();
		foreach ( $post_types as $post_type ) :
			if( post_type_supports( $post_type, 'comments' ) ) :
				remove_post_type_support( $post_type, 'comments' );
				remove_post_type_support( $post_type, 'trackbacks' );
			endif;
		endforeach;
	}

	// Close comments on the front-end
	public function grafiplug_disable_comments_status() {
		return false;
	}

	// Hide existing comments
	public function grafiplug_disable_comments_hide_existing_comments( $comments ) {
		$comments = array();
		return $comments;
	}

	// Remove comments page in menu
	public function grafiplug_disable_comments_admin_menu() {

		remove_menu_page( 'edit-comments.php' );
		remove_submenu_page( 'options-general.php', 'options-discussion.php' );
	}

	// Redirect any user trying to access comments page
	public function grafiplug_disable_comments_admin_menu_redirect() {
		global $pagenow;
		if ( $pagenow === 'edit-comments.php' ) :
			wp_redirect(admin_url() ); exit;
		endif;
	}

	// Remove comments metabox from dashboard
	public function grafiplug_disable_comments_dashboard() {
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	}

	/**
	 * Disable emojicons.
	 *
	 * remove emojicons and files injected into document.
	 *
	 * @since 1.0.0
	 * @link http://www.grafipress.co.za
	 */
	/*public function grafiplug_disable_emojicons_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) :
			return array_diff( $plugins, array( 'wpemoji' ) );
		else :
			return array();
		endif;
	}*/

	// Remove comments links from admin bar
	public function grafiplug_disable_comments_admin_bar() {
		if ( is_admin_bar_showing() ) :
			remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
		endif;
	}

	// Remove comments link in admin bar
	public function grafiplug_remove_comments_admin_bar_links() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu( 'comments' );
	}	

	// Remove meta boxes for comments, reviews and trackbacks in post types
	public function grafiplug_remove_comments_metabox_post_types() {
		$post_types = get_post_types();
		foreach ( $post_types as $post_type ) :
			remove_meta_box( 'commentsdiv', $post_type,  'normal');
			remove_meta_box( 'commentsstatusdiv', $post_type,  'normal');
			remove_meta_box( 'trackbacksdiv', $post_type,  'normal');
		endforeach;
	}


	/**
	 * Check WordPress installation for suggested alterations.
	 *
	 * This function check the current installation for several suggested issues and
	 * return a list in a notification block within the admin section.
	 *
	 * @since 1.0.0
	 * @link http://www.grafipress.co.za
	 */
	public function grafiplug_mandatory_settings() {

	    $gws_error = '';
	    $gws_before_error = '';
	    $gws_after_error = '';
	    
	    // Create and setup variable
	    $gws_setting_notices = array();

	    // Check to see if tagline is set
	    if ( get_option( 'blogdescription' ) === 'Just another WordPress site' ) :
	        $gws_setting_notices[] .= sprintf(__( 'Please update your <a href="%s">site tagline</a>', 'gws' ), admin_url( 'options-general.php' ) );
	    endif;

	    // Check for deafault Uncatogorized category in posts    
	    if ( category_exists ( 'uncategorized' ) || category_exists ( 'uncategorised' ) ) :
	        $gws_setting_notices[] .= sprintf(__( 'For better <abbr title="search engine optimization">SEO</abbr> please rename the <a href="%s" title="Click here to rename the Uncategorized category">"Uncategorized"</a> category name and slug fields', 'gws' ), admin_url( 'edit-tags.php?taxonomy=category' ) );    
	    endif;

	    // Check for default Hello World post
	    if( get_page_by_title ( 'Hello World', ARRAY_A, 'post' ) ) :
	        $gws_error .= '<li>' . sprintf(__( 'We recommend that you either rename or delete the <a href="%s">%s</a> default post', 'gws' ), admin_url( 'edit.php' ) , $post_title ) . '</li>';    
	    endif;

	    // Check for default Sample Page page
	    if( get_page_by_title ( 'Sample Page', ARRAY_A, 'page' ) ) :
	        $gws_error .= '<li>' . sprintf(__( 'We recommend that you either rename or delete the <a href="%s">%s</a> default post', 'gws' ), admin_url( 'edit.php?post_type=page' ) , $page_title ) . '</li>';    
	    endif;

	    // Check that blank index.php file exists in themes folder
	    if (! file_exists ( get_theme_root() . '/index.php' ) ) :
	        $gws_error .= '<li>' . sprintf(__( 'There is no blank index.php in the theme directory. This could allow people to browse your %s folder structure','gws' ), 'WordPress' ) . '.' . '</li>';    
	    endif;

	    // Check to see if .htaccess file is writable
	    if ( is_writable( get_home_path() . '.htaccess' )) :
	        add_action( 'admin_notices', create_function( '', "echo '<div class=\"error\"><p>" . sprintf(__( 'Please make sure your <a href="%s">.htaccess</a> file is not writeable ', 'basis' ), admin_url( 'options-permalink.php' )) . "</p></div>';"));
	    endif;

	    // Collect all errors and mark them up within 'li' tags
	    foreach ( $gws_setting_notices as $gws_notice ) :
	        $gws_error .= '<li>' . $gws_notice . '</li>';
	    endforeach; 

	    if( $gws_error ) :
	        $gws_before_error .= '<div class="notice notice-warning is-dismissible">';
	        $gws_before_error .= '<p><strong>' . __( 'Before you begin editing your content we recommend that you address the following issues', 'gws' ) . ':</strong></p>'; 
	        $gws_before_error .= '<ol>';
	        $gws_after_error  .= '</ol></div>';
	        echo $gws_before_error . $gws_error . $gws_after_error;
	    endif;
	}

	/**
	 * Adds a link of all available options.
	 *
	 * Adds a link to the main options page within the WordPress admin
	 * dashboard that is only available to users with the 'administrator' role.
	 *
	 * @since 1.0.0
	 * @link http://www.grafipress.co.za
	 */
	public function grafiplug_all_options_link() {
	    add_theme_page(
	    	$page_title = __( 'All Options',  'gws' ),
	    	$menu_title = __( 'All Options',  'gws' ),
	    	$capability = 'administrator',
	    	$menu_slug 	= 'options.php',
	    	$function 	= ''
    	);
	}

	/**
	 * Removes default WordPress version number in footer.
	 *
	 * This removes the standard footer version number that appears
	 * at the bottom right of the dashboard.
	 *
	 * @since 1.0.0
	 * @link http://www.grafipress.co.za
	 */ 
	public function grafiplug_remove_footer_version() {
	    return '';
	}
	
	/**
	 * Filter the dashboard footer text.
	 *
	 * This removes the standard footer text in the dashboard and adds a string
	 * that contains the theme author name and log in svg, WordPress version as 
	 * well as the theme version.
	 *
	 * @since 4.0.0
	 * @link http://www.grafipress.co.za
	 */
	public function grafiplug_remove_footer_admin() {
	    $gws_theme_data = wp_get_theme();
	    echo '<small>' . __( 'Designed by', 'gws' ) . ' <a href="' . GWS_URL . '" target="_blank"><img src="' . get_template_directory_uri() . '/img/defaults/gws_logo_gray.svg" style="fill:#000!important; color: #000; line-height: 57px; vertical-align: bottom; max-width:200px!important; height:auto!important;" alt="' . GWS_CREATOR . '"></a> | ' . __( 'Fueled by WordPress ', 'gws' ) . get_bloginfo( 'version' ) . ' | ' . $gws_theme_data->get( 'Name' ) . ' ' . $gws_theme_data->get( 'Version' ) . '</small>';
	}

	/**
	 * Add additional fields to the user management page.
	 *
	 * Adds additional fields to the user management screen that can
	 * be called in a template by '$curauth->fieldname'.
	 *
	 * @since 1.0.0
	 * @link http://www.grafipress.co.za
	 */
	public function grafiplug_add_contactmethods( $contactmethods ) {
		$contactmethods['twitter']     = 'Twitter';
	    $contactmethods['linkedin']    = 'Linkedin';
	    $contactmethods['pinterest']   = 'Pinterest';
		$contactmethods['facebook']    = 'Facebook';
	    $contactmethods['telephone']   = 'Telephone';
	    $contactmethods['mobile']      = 'Mobile';
		return $contactmethods;
	}

	public function grafiplug_disable_wp_emojicons() {
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		//add_filter( 'tiny_mce_plugins', 'grafiplug_disable_emojicons_tinymce' );
	}
	
}


