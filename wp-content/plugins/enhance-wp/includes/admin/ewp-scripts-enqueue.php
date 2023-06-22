<?php


// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}


// Load CSS & JS on Plugin Setting Page
function ewp_admin_scripts( $hook )
{	
	// Define EWP_PLUGIN_SLUG as a PHP Constant
	define ( 'EWP_PLUGIN_SLUG', $hook );
	
	if( 'settings_page_ewp' == EWP_PLUGIN_SLUG )
	{
		wp_enqueue_style( 'kp-admin-css', EWP_DIR_URL . 'assets/css/ewp-backend.css', array(), time() );
		wp_enqueue_script( 'kp-admin-js', EWP_DIR_URL . 'assets/js/ewp-backend.js', array(), time() );
	}
}
add_action( 'admin_enqueue_scripts', 'ewp_admin_scripts' );