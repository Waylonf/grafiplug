<?php

/**
 * Fired during plugin activation
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Grafiplug
 * @subpackage Grafiplug/includes
 */

// Fired during plugin activation.
class Grafiplug_Activator {

	// Setup and save default values
	public static function activate() {
		$option_name = 'grafiplug';
		$defaults = array(
			// Mail defaults
			$option_name . '_mail_content_type'			=> intval(1),
			$option_name . '_mail_from_address' 		=> get_option( 'admin_email' ),
			$option_name . '_email_from_name' 			=> get_option('blogname'),
			$option_name . '_remove_generator_meta' 	=> intval(1),
			$option_name . '_remove_comment_system' 	=> intval(1),
			$option_name . '_hide_profile_fields' 		=> intval(1),
		);

		foreach( $defaults as $option => $value ) :
			if ( get_option( $option ) !== false ) :
	    		update_option( $option, $value );
			else :
			    $deprecated = null;
			    $autoload = 'no';
			    add_option( $option, $value, $deprecated, $autoload );
			endif;
		endforeach;
	}
}
