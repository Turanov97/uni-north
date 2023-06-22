<?php
/*
Plugin Name: BP Simple Private Pro
Description: Select whether posts, pages, bbPress, BuddyPress or BuddyBoss sections can be viewed by non-logged-in users. See Settings > BP Simple Private
Version: 3.1
Author: PhiloPress
Author URI: https://philopress.com/
Domain Path: /languages
Copyright (C) 2016-2019  shanebp, PhiloPress
Requires at least: 4.0
Tested up to: 5.4
*/

if ( !defined( 'ABSPATH' ) ) exit;

define( 'PP_PRIVATE_STORE_URL', 'https://www.philopress.com/' );
define( 'PP_SIMPLE_PRIVATE_PRO', 'BP Simple Private Pro' );

function pp_private_bp_check_pro() {
	if ( !class_exists('BuddyPress') ) {
		add_action( 'admin_notices', 'pp_private_install_buddypress_notice_pro' );
	}
}
add_action('plugins_loaded', 'pp_private_bp_check_pro', 999);

function pp_private_install_buddypress_notice_pro() {
	echo '<div id="message" class="error fade"><p style="line-height: 150%">';
	_e('BuddyPress Simple Private requires the BuddyPress plugin. Please install BuddyPress first, or deactivate BuddyPress Simple Private.', 'bp-simple-private');
	echo '</p></div>';
}

function pp_private_load_admin_pro() {

	if ( is_admin() ) {

		load_plugin_textdomain( 'bp-simple-private', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

		require( dirname( __FILE__ ) . '/inc/pp-private-admin-meta-box.php' );
		require( dirname( __FILE__ ) . '/inc/pp-private-admin-settings.php' );
	} else {
		require( dirname( __FILE__ ) . '/inc/pp-private-front.php' );
	}
}
add_action( 'bp_include', 'pp_private_load_admin_pro' );


function pp_private_activation_pro() {

	if( !function_exists('is_plugin_active') ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	if ( is_plugin_active( 'bp-simple-private/loader.php' ) ) {
		deactivate_plugins( '/bp-simple-private/loader.php' );
	}

	if ( ! get_option( 'pp_private_license_key' ) ) {
		add_option( 'pp_private_license_key', '' );
	}

	if ( ! get_option( 'pp_private_license_status' ) ) {
		add_option( 'pp_private_license_status', '' );
	}

}
register_activation_hook(__FILE__, 'pp_private_activation_pro');


function pp_private_add_settings_link_pro( $links ) {

	$link = array();

	if ( is_multisite() && ! is_plugin_active_for_network( "bp-simple-private-pro/bp-simple-private-pro.php" ) ) {
		$link = array( '<a href="' . admin_url( 'options-general.php?page=bp-simple-private' ) . '">Settings</a>', );
	} elseif ( ! is_multisite() ) {
		$link = array( '<a href="' . admin_url( 'options-general.php?page=bp-simple-private' ) . '">Settings</a>', );
	}

	return array_merge( $links, $link );
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'pp_private_add_settings_link_pro' );

function pp_private_add_settings_link_pro_multisite( $links ) {

	$link = array();

	if ( is_multisite() && is_plugin_active_for_network( "bp-simple-private-pro/bp-simple-private-pro.php" ) ) {
		$link = array( '<a href="' . admin_url( 'network/settings.php?page=bp-simple-private' ) . '">Settings</a>', );
	}

	return array_merge( $links, $link );
}
add_filter( 'network_admin_plugin_action_links_' . plugin_basename(__FILE__), 'pp_private_add_settings_link_pro_multisite' );



function pp_private_plugin_updater() {

	if( !class_exists( 'PP_Private_Pro_Plugin_Updater' ) ) {
		include( dirname( __FILE__ ) . '/inc/PP_Private_Pro_Plugin_Updater.php' );
	}

	$license_key = trim( get_option( 'pp_private_license_key' ) );

	$edd_updater = new PP_Private_Pro_Plugin_Updater( PP_PRIVATE_STORE_URL, __FILE__, array(
			'version' 	=> '3.1',
			'license' 	=> $license_key,
			'item_name' => PP_SIMPLE_PRIVATE_PRO,
			'author' 	=> 'PhiloPress'
		)
	);

}
add_action( 'admin_init', 'pp_private_plugin_updater', 0 );
