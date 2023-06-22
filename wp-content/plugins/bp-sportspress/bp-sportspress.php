<?php
/*
Plugin Name: BuddyPress for SportsPress
Plugin URI: https://www.themeboy.com/sportspress-extensions/buddypress/
Description: This plugin integrated SportsPress into your BuddyPress user profiles. This plugin needs BuddyPress and SportsPress to be installed.
Author: WPDrift
Author URI: http://wpdrift.com
Version: 1.0.2
Requires at least: WordPress 3.8, BuddyPress 2.1.1, SportsPress 2.0.8
Tested up to: WordPress 4.7.3 , BuddyPress 2.8.2, SportsPress 2.2.11
Text Domain: bp-sportspress
Domain Path: /languages/

Copyright: 2017 WPDrift
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
 * BP SportsPress
 *
 * @package BP_SportsPress
 * @subpackage Loader
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// some pertinent defines
define( 'BP_SPORTSPRESS_FILE', __FILE__ );
define( 'BP_SPORTSPRESS_DIR', dirname( __FILE__ ) );
define( 'BP_SPORTSPRESS_URL', plugin_dir_url( __FILE__ ) );
define( 'BP_SPORTSPRESS_VERSION', '1.0.2' );

/**
 * Only load the plugin code if BuddyPress is activated.
 */
function bp_sportspress_init() {

	// only supported when BuddyPress and SportsPress are active
	if ( defined( 'SP_VERSION' ) || defined( 'SP_PRO_VERSION' ) ) {
		require( constant( 'BP_SPORTSPRESS_DIR' ) . '/bp-sportspress-core.php' );
	// show admin notice for users
	} else {

	add_action( 'admin_notices', function() {
		$older_version_notice = sprintf( __( "Hey! BuddyPress for SportsPress requires <a href='%s'>SportsPress</a> activated", 'bp-sportspress' ),
			'https://wordpress.org/plugins/sportspress/' );
		echo '<div class="error"><p>' . $older_version_notice . '</p></div>';
	});

	return;
	}
}

add_action( 'bp_include', 'bp_sportspress_init' );

/**
 * Custom textdomain loader.
 *
 * Checks WP_LANG_DIR for the .mo file first, then the plugin's language folder.
 * Allows for a custom language file other than those packaged with the plugin.
 *
 * @uses load_textdomain() Loads a .mo file into WP
 */
function bp_sportspress_localization() {
	$mofile		= sprintf( 'bp-sportspress-%s.mo', get_locale() );
	$mofile_global	= trailingslashit( WP_LANG_DIR ) . $mofile;
	$mofile_local	= plugin_dir_path( __FILE__ ) . 'languages/' . $mofile;

	if ( is_readable( $mofile_global ) )
		return load_textdomain( 'bp-sportspress', $mofile_global );
	elseif ( is_readable( $mofile_local ) )
		return load_textdomain( 'bp-sportspress', $mofile_local );
	else
		return false;
}

add_action( 'plugins_loaded', 'bp_sportspress_localization' );

/**
 * Install/Activation stuff
 *
 * Runs on plugin install/update
 */
function bp_sportspress_activated() {
	global $wpdb;

	// Add Upgraded From Option
	$bsp_version = get_option( 'bp_sportspress_version' );

	//1.0.0 Migrate player wp user id to player post's post_author field from `_bsp_user_player_id` usermeta
	if ( empty( $bsp_version )
		|| version_compare( $bsp_version, '1.0.1', '<' ) ) {

		//Set the Player post author from Profile > Player field for BP SPORTSPRESS < 1.0.1
		$results = $wpdb->get_results("SELECT user_id, meta_value FROM {$wpdb->usermeta} WHERE meta_key = '_bsp_user_player_id'");
		foreach ( $results as $data ) {
			wp_update_post( array('ID' => $data->meta_value, 'post_author' => $data->user_id) );
		}
	}

	//Update OR Add plugin version in wp_options table
	update_option( 'bp_sportspress_version', BP_SPORTSPRESS_VERSION );

}

register_activation_hook( __FILE__, 'bp_sportspress_activated' );
