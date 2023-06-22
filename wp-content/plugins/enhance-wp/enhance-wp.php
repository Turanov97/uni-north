<?php
/**
 * Plugin Name: Enhance WP
 * Description: This plugin is to improve performance of your Wordpress.
 * Author: Habib
 * Version: 3.0
 * Text Domain: enhance-wp
 */


// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}


// Define Constants
define('EWP_VERSION', '3.0');
define('EWP_FILE_BASENAME', basename(__FILE__) );
define( 'EWP_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'EWP_PLUGIN_BASENAME', plugin_basename(__FILE__) );


//Register Plugin Activation/Deactivation Hook
register_activation_hook( __FILE__, 'ewp_admin_notice_transient' );
register_uninstall_hook( __FILE__, 'ewp_delete_settings' );


//include Pluggable File
if( !function_exists('is_user_logged_in') )
{
	include_once(ABSPATH . 'wp-includes/pluggable.php');
}


//include Frontend Plugin Files
include('includes/ewp-init-config.php');
include('includes/ewp-load-files.php');
include('includes/library/dom-parser.php');
include('includes/ewp-html-rewrite.php');
include('includes/ewp-shortcuts.php');
include('includes/ewp-optimizations.php');


//include Backend Plugin Files
include('includes/admin/ewp-admin-settings-init.php');