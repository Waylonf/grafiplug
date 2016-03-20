<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Grafiplug
 * @subpackage Grafiplug/admin/partials
 */
?>

<?php 
//$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'display_options'; 
// Variable tester
//$html_email = get_option( $this->plugin_name . '_mail_content_type' );
?>

<div class="wrap">
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>    
    
    <form action="options.php" method="post">
        <?php echo $html_email; ?>
	   	<?php settings_fields( $this->plugin_name); ?>
        <?php do_settings_sections( $this->plugin_name ); ?>         
        
        <?php submit_button( 'Save changed options' ); ?>
        <?php //submit_button( 'Reset', 'secondary' ); ?>
    </form>
</div>