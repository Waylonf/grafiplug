<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Grafiplug
 * @subpackage Grafiplug/admin
 */

// The admin-specific functionality of the plugin.
class Grafiplug_Admin {

	// The ID of this plugin.
	private $plugin_name;
	
	// The options name to be used in this plugin
	private $option_name = 'grafiplug';

	// The version of this plugin.
	private $version;

	// Initialize the class and set its properties.
	 public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
	
	// Register the stylesheets for the admin area.
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/grafiplug-admin.css', array(), $this->version, 'all' );
	}

	// Register the JavaScript for the admin area.
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/grafiplug-admin.js', array( 'jquery' ), $this->version, false );
	}
	
	// Add an options page under the Settings submenu
	public function add_options_page() {
	
		$this->plugin_screen_hook_suffix = add_options_page(
			$page_title		= __( 'Advanced Options', 'grafiplug' ),
			$menu_title		= __( 'Advanced', 'grafiplug' ),
			$capability		= 'manage_options',
			$menu_slug		= $this->plugin_name,
			$function		= array( $this, 'display_options_page' )
		);
	}

	public function add_action_links( $links ) {
		$settings_link = array(
			'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', 'grafiplug') . '</a>',
		);
		return array_merge(  $settings_link, $links );
	}
	
	// Render the options page for plugin
	public function display_options_page() {
		include_once 'partials/grafiplug-admin-display.php';
	}
	
	public function register_setting(){
		
		// Add a General section
		add_settings_section(
			$id			= $this->option_name . '_general',
			$title		= __( 'General', 'grafiplug' ),
			$callback	= array( $this, $this->option_name . '_general_cb' ),
			$page		= $this->plugin_name
		);
		
		/*add_settings_field(
			$id 		= $this->option_name . '_position',
			$title		= __( 'Text position', 'grafiplug' ),
			$callback	= array( $this, $this->option_name . '_position_cb' ),
			$page		= $this->plugin_name,
			$section	= $this->option_name . '_general',
			$args		= array( 'label_for' => $this->option_name . '_position' )
		);*/
		
		/*register_setting( 
			$option_group	= $this->plugin_name, 
			$option_name	= $this->option_name . '_position', 
			$sanitise_cb	= array( $this, $this->option_name . '_sanitize_position' )
		);*/
		
		/*add_settings_field(
			$id			= $this->option_name . '_day',
			$title		= __( 'Post is outdated after', 'grafiplug' ),
			$callback 	= array( $this, $this->option_name . '_day_cb' ),
			$page		= $this->plugin_name,
			$section	= $this->option_name . '_general',
			$args		= array( 'label_for' => $this->option_name . '_day' )
		);*/
		
		/*register_setting(
			$option_group	= $this->plugin_name,
			$option_name	= $this->option_name . '_day', 
			$sanitize_cb	= 'intval'
		);*/
		
		// Cleanup Section
		add_settings_section(
			$id 		= $this->option_name . '_cleanup',
			$title 		= __( 'Cleanup everything', 'grafiplug' ),
			$callback 	= array( $this, $this->option_name . '_cleanup_cb' ),
			$page 		= $this->plugin_name
		);
		
		// Cleanup all setting
		add_settings_field(
			$id 		= $this->option_name . '_cleanup_all',
			$title		= __( 'Cleanup everything', 'grafiplug' ),
			$callback	= array( $this, $this->option_name . '_cleanup_all_cb' ),
			$page		= $this->plugin_name,
			$section	= $this->option_name . '_cleanup',
			$args		= array( 'label_for' => $this->option_name . '_cleanup_all' )
		);
		
		register_setting( 
			$option_group	= $this->plugin_name, 
			$option_name	= $this->option_name . '_cleanup_all', 
			$sanitise_cb	= array( $this, $this->option_name . '_sanitize_checkbox' )
		);

		// Remove remove_generator_meta
		add_settings_field(
			$id 		= $this->option_name . '_remove_generator_meta',
			$title		= __( 'Remove WordPress generator meta tag', 'grafiplug' ),
			$callback	= array( $this, $this->option_name . '_remove_generator_meta_cb' ),
			$page		= $this->plugin_name,
			$section	= $this->option_name . '_cleanup',
			$args		= array( 'label_for' => $this->option_name . '_remove_generator_meta' )
		);
		
		register_setting( 
			$option_group	= $this->plugin_name, 
			$option_name	= $this->option_name . '_remove_generator_meta', 
			$sanitise_cb	= array( $this, $this->option_name . '_sanitize_checkbox' )
		);

		// Remove emojicons
		add_settings_field(
			$id 		= $this->option_name . '_disable_wp_emojicons',
			$title		= __( 'Remove WordPress emojicons', 'grafiplug' ),
			$callback	= array( $this, $this->option_name . '_disable_wp_emojicons_cb' ),
			$page		= $this->plugin_name,
			$section	= $this->option_name . '_cleanup',
			$args		= array( 'label_for' => $this->option_name . '_disable_wp_emojicons' )
		);
		
		register_setting( 
			$option_group	= $this->plugin_name, 
			$option_name	= $this->option_name . '_disable_wp_emojicons', 
			$sanitise_cb	= array( $this, $this->option_name . '_sanitize_checkbox' )
		);

		// Email Section
		add_settings_section(
			$id 		= $this->option_name . '_system_emails',
			$title 		= __( 'System Emails', 'grafiplug' ),
			$callback 	= array( $this, $this->option_name . '_system_emails_cb' ),
			$page 		= $this->plugin_name
		);

		// Email content type
		add_settings_field(
			$id 		= $this->option_name . '_mail_content_type',
			$title		= __( 'Enable HTML email', 'grafiplug' ),
			$callback	= array( $this, $this->option_name . '_mail_content_type_cb' ),
			$page		= $this->plugin_name,
			$section	= $this->option_name . '_system_emails',
			$args		= array( 'label_for' => $this->option_name . '_mail_content_type' )
		);

		register_setting( 
			$option_group	= $this->plugin_name, 
			$option_name	= $this->option_name . '_mail_content_type', 
			$sanitise_cb	= array( $this, $this->option_name . '_sanitize_checkbox' )
		);

		// Email from address
		add_settings_field(
			$id 		= $this->option_name . '_mail_from_address',
			$title		= __( 'From address', 'grafiplug' ),
			$callback	= array( $this, $this->option_name . '_mail_from_address_cb' ),
			$page		= $this->plugin_name,
			$section	= $this->option_name . '_system_emails',
			$args		= array( 'label_for' => $this->option_name . '_mail_from_address' )
		);

		register_setting( 
			$option_group	= $this->plugin_name, 
			$option_name	= $this->option_name . '_mail_from_address', 
			$sanitise_cb	= 'sanitize_email'
		);

		// Email from name		
		add_settings_field(
			$id 		= $this->option_name . '_email_from_name',
			$title		= __( 'From name', 'grafiplug' ),
			$callback	= array( $this, $this->option_name . '_email_from_name_cb' ),
			$page		= $this->plugin_name,
			$section	= $this->option_name . '_system_emails',
			$args		= array( 'label_for' => $this->option_name . '_email_from_name' )
		);

		register_setting( 
			$option_group	= $this->plugin_name, 
			$option_name	= $this->option_name . '_email_from_name', 
			$sanitise_cb	= 'sanitize_text_field'
		);

		// Comments Section
		add_settings_section(
			$id 		= $this->option_name . '_comments',
			$title 		= __( 'Comments', 'grafiplug' ),
			$callback 	= array( $this, $this->option_name . '_comment_system_cb' ),
			$page 		= $this->plugin_name
		);

		// Remove comment system
		add_settings_field(
			$id 		= $this->option_name . '_remove_comment_system',
			$title		= __( 'Disable built in comment sysytem', 'grafiplug' ),
			$callback	= array( $this, $this->option_name . '_remove_comment_system_cb' ),
			$page		= $this->plugin_name,
			$section	= $this->option_name . '_comments',
			$args		= array( 'label_for' => $this->option_name . '_remove_comment_system' )
		);
		
		register_setting( 
			$option_group	= $this->plugin_name, 
			$option_name	= $this->option_name . '_remove_comment_system', 
			$sanitise_cb	= array( $this, $this->option_name . '_sanitize_checkbox' )
		);

		// User Settings
		add_settings_section(
			$id 		= $this->option_name . '_user_settings',
			$title 		= __( 'User Settings', 'grafiplug' ),
			$callback 	= array( $this, $this->option_name . '_user_settings_cb' ),
			$page 		= $this->plugin_name
		);

		// Remove profile fields
		add_settings_field(
			$id 		= $this->option_name . '_hide_profile_fields',
			$title		= __( 'Hide user profile fields', 'grafiplug' ),
			$callback	= array( $this, $this->option_name . '_hide_profile_fields_cb' ),
			$page		= $this->plugin_name,
			$section	= $this->option_name . '_user_settings',
			$args		= array( 'label_for' => $this->option_name . '_hide_profile_fields' )
		);
		
		register_setting( 
			$option_group	= $this->plugin_name, 
			$option_name	= $this->option_name . '_hide_profile_fields', 
			$sanitise_cb	= array( $this, $this->option_name . '_sanitize_checkbox' )
		);
	}
	
	// Render the text for the general section
	public function grafiplug_general_cb() {
		echo '<p>' . __( 'Please change the settings accordingly.', 'grafiplug' ) . '</p>';
	}
	
	// Render the text for the cleanup section
	public function grafiplug_cleanup_cb() {
		echo '<p>' . __( 'This section controls cleanup functions that remove unnesasary markup', 'grafiplug' ) . '</p>';
	}

	// Render the text for the system email section
	public function grafiplug_system_emails_cb() {
		echo '<p>' . __( 'This section deals with taking full advantage of the Wordpress built in email system as well as setting up a few defaults to fully customize this feature.', 'grafiplug' ) . '</p>';
	}

	public function grafiplug_comment_system_cb() {
		echo '<p>' . __( 'Remove the built in WordPress commenting system all together.', 'grafiplug' ) . '</p>';
	}

	public function grafiplug_user_settings_cb() {
		echo '<p>' . __( 'Remove several user profile fields.', 'grafiplug' ) . '</p>';
	}

	
	// Render the radio input field for position option
	/*public function grafiplug_position_cb() {
		$position = get_option( $this->option_name . '_position' ); ?>

		<fieldset>
			<label>
				<input type="radio" name="<?php echo $this->option_name . '_position' ?>" id="<?php echo $this->option_name . '_position' ?>" value="before" <?php checked( $position, 'before' ); ?>>
				<?php _e( 'Before the content', 'grafiplug' ); ?>
			</label>
			<br>
			<label>
				<input type="radio" name="<?php echo $this->option_name . '_position' ?>" value="after" <?php checked( $position, 'after' ); ?>>
				<?php _e( 'After the content', 'grafiplug' ); ?>
			</label>
		</fieldset>
	<?php }*/
	
	// Render the treshold day input for this plugin
	/*public function grafiplug_day_cb() {

		$value 			= get_option( $this->option_name . '_day' );
		$setting_name 	= $this->option_name . '_day';
		$description 	= esc_attr_e( 'days', 'grafiplug' ); ?>		

		<input type="text" name="<?php echo $setting_name ?>" value="<?php echo $value ?>" class="regular-text" />
		<?php if( $description ) : ?>
			<span class="description"><?php echo $description; ?></span><br>
		<?php endif; 
	}*/

	// Render the checkbox field for cleanup all option
	public function grafiplug_cleanup_all_cb() {
		$value 			= get_option( $this->option_name . '_cleanup_all' );
		$setting_name 	= $this->option_name . '_cleanup_all';
		$description 	= /*esc_attr_e( 'Send system emails in HTML format?', 'grafiplug' )*/ ''; ?>

		<fieldset>
			<label>
				<input name="<?php echo $setting_name ?>" type="checkbox" id="<?php echo $setting_name ?>" value="1" <?php checked( $value ); ?>/>
				<span><?php esc_attr_e( $description, 'grafiplug' ); ?></span>
			</label>
		</fieldset>
	<?php }

	// Render the checkbox field remove WordPress generator tag
	public function grafiplug_remove_generator_meta_cb() {
		$value 			= get_option( $this->option_name . '_remove_generator_meta' );
		$setting_name 	= $this->option_name . '_remove_generator_meta';
		$description 	= /*esc_attr_e( 'Send system emails in HTML format?', 'grafiplug' )*/ ''; ?>

		<fieldset>
			<label>
				<input name="<?php echo $setting_name ?>" type="checkbox" id="<?php echo $setting_name ?>" value="1" <?php checked( $value ); ?>/>
				<span><?php esc_attr_e( $description, 'grafiplug' ); ?></span>
			</label>
		</fieldset>
	<?php }

	// Render the checkbox field to remove emojicons
	public function grafiplug_disable_wp_emojicons_cb() {
		$value 			= get_option( $this->option_name . '_disable_wp_emojicons' );
		$setting_name 	= $this->option_name . '_disable_wp_emojicons';
		$description 	= /*esc_attr_e( 'Send system emails in HTML format?', 'grafiplug' )*/ ''; ?>

		<fieldset>
			<label>
				<input name="<?php echo $setting_name ?>" type="checkbox" id="<?php echo $setting_name ?>" value="1" <?php checked( $value ); ?>/>
				<span><?php esc_attr_e( $description, 'grafiplug' ); ?></span>
			</label>
		</fieldset>
	<?php }

	// Render the checkbox field for mail type option
	public function grafiplug_mail_content_type_cb() {
		$value 			= get_option( $this->option_name . '_mail_content_type' );
		$setting_name 	= $this->option_name . '_mail_content_type';
		$description 	= /*esc_attr_e( 'Send system emails in HTML format?', 'grafiplug' )*/ ''; ?>

		<fieldset>
			<label>
				<input name="<?php echo $setting_name ?>" type="checkbox" id="<?php echo $setting_name ?>" value="1" <?php checked( $value ); ?>/>
				<span><?php esc_attr_e( $description, 'grafiplug' ); ?></span>
			</label>
		</fieldset>
	<?php }

	public function grafiplug_mail_from_address_cb() {

		$value 			= get_option( $this->option_name . '_mail_from_address' );
		$setting_name 	= $this->option_name . '_mail_from_address';
		$description 	= /*esc_attr_e( 'Set the default "from" address for all system emails', 'grafiplug' );*/ '';?>		

		<input type="text" name="<?php echo $setting_name ?>" value="<?php echo $value ?>" class="regular-text" />
		<?php if( $description ) : ?>
			<span class="description"><?php echo $description; ?></span><br>
		<?php endif; 
	}

	public function grafiplug_email_from_name_cb() {

		$value 			= get_option( $this->option_name . '_email_from_name' );
		$setting_name 	= $this->option_name . '_email_from_name';
		$description 	= /*esc_attr_e( 'Set the default "from" address for all system emails', 'grafiplug' );*/ '';?>		

		<input type="text" name="<?php echo $setting_name ?>" value="<?php echo $value ?>" class="regular-text" />
		<?php if( $description ) : ?>
			<span class="description"><?php echo $description; ?></span><br>
		<?php endif; 
	}
	
	// Sanitize the text position value before being saved to database
	/*public function grafiplug_sanitize_position( $position ) {
		if ( in_array( $position, array( 'before', 'after' ), true ) ) {
	        return $position;
	    }
	}*/

	public function grafiplug_sanitize_checkbox( $input ) {
		if ( $input == 1 ) :
        	return 1;
    	else :
        	return '';
    	endif;
	}

	// Render the checkbox field for cleanup all option
	public function grafiplug_remove_comment_system_cb() {
		$value 			= get_option( $this->option_name . '_remove_comment_system' );
		$setting_name 	= $this->option_name . '_remove_comment_system';
		$description 	= /*esc_attr_e( 'Send system emails in HTML format?', 'grafiplug' )*/ ''; ?>

		<fieldset>
			<label>
				<input name="<?php echo $setting_name ?>" type="checkbox" id="<?php echo $setting_name ?>" value="1" <?php checked( $value ); ?>/>
				<span><?php esc_attr_e( $description, 'grafiplug' ); ?></span>
			</label>
		</fieldset>
	<?php }

	// Render the checkbox field for cleanup all option
	public function grafiplug_hide_profile_fields_cb() {
		$value 			= get_option( $this->option_name . '_hide_profile_fields' );
		$setting_name 	= $this->option_name . '_hide_profile_fields';
		$description 	= /*esc_attr_e( 'Send system emails in HTML format?', 'grafiplug' )*/ ''; ?>

		<fieldset>
			<label>
				<input name="<?php echo $setting_name ?>" type="checkbox" id="<?php echo $setting_name ?>" value="1" <?php checked( $value ); ?>/>
				<span><?php esc_attr_e( $description, 'grafiplug' ); ?></span>
			</label>
		</fieldset>
	<?php }
}
