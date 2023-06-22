<?php
/**
 * BP SportsPress License
 *
 * @package BP_SportsPress
 * @subpackage License
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'BP_SportsPress_Updater' ) )
    include( 'bp-sportspress-updater.php' );

/**
 * Add the license option.
 */
function bp_sportspress_license_option( $options ) {
	$options['buddypress'] = array(
        'name'  => 'BuddyPress for SportsPress',
        'url'   => 'https://account.themeboy.com',
    );
    
    return $options;
}
add_filter( 'sportspress_licenses', 'bp_sportspress_license_option' );

/**
 * Check for updates.
 */
function bp_sportspress_check_for_updates() {
    // retrieve our license key from the DB
    $license_key = trim( get_site_option( 'sportspress_buddypress_license_key' ) );

    // setup the updater
    $edd_updater = new BP_SportsPress_Updater( 'https://account.themeboy.com', BP_SPORTSPRESS_FILE, array(
            'version'   => BP_SPORTSPRESS_VERSION,
            'license'   => $license_key,
            'item_name' => 'BuddyPress for SportsPress',
            'author'    => 'OpenTute+'
        )
    );
}
add_action( 'admin_init', 'bp_sportspress_check_for_updates', 0 );