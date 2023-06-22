<?php
/**
 * BP SportsPress Activity posts
 *
 * Functionality related to bp-activity
 *
 * @package BP_SportsPress
 * @subpackage Activity
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Post an activity item on event save.
 *
 * @return int $activity_id The id number of the activity created
 */
function bsp_event_post_activity( $post_id, $post ) {
	global $post, $wpdb;

	// Autosave, do nothing
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;
	// AJAX? Not used here
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		return;
	// Check user permissions
	if ( ! current_user_can( 'edit_post', $post_id ) )
		return;
	// Return if it's a post revision
	if ( false !== wp_is_post_revision( $post_id ) )
		return;
	// Return if the post title is empty
	if ( empty( $post->post_title ) )
		return;

	$update = $wpdb->get_var("SELECT id FROM {$wpdb->base_prefix}bp_activity WHERE type='bps_event_added' AND item_id = {$post_id}");

	$user_link  = bp_core_get_userlink( $post->post_author );
	$even_url   = get_permalink( $post_id );
	$event_link = '<a href="' . $even_url . '">' . $post->post_title . '</a>';

	if ( $update ) {
		$type   = 'bps_event_updated';
		$action = sprintf( __( '%1$s updated the event %2$s', 'bp-sportspress' ), $user_link, $event_link );
	} else {
		$type   = 'bps_event_added';
		$action = sprintf( __( '%1$s created the event %2$s', 'bp-sportspress' ), $user_link, $event_link );
	}

	$args = array(
		'user_id'		=> $post->post_author,
		'action'		=> $action,
		'component'     => 'bsp_sportspress',
		'primary_link'	=> $even_url,
		'type'			=> $type, // Set the type, to be used in activity filtering
		'item_id'		=> $post_id, // Set to the group/user/etc id, for better consistency with other BP components
		'secondary_item_id'	=> get_current_user_id(), // The id of the current user itself
	);

	$activity_id = bp_activity_add( $args );

	return $activity_id;
}

add_action( 'save_post_sp_event', 'bsp_event_post_activity', 10, 2 );

/**
 * Post an activity item on team save.
 *
 * @return int $activity_id The id number of the activity created
 */
function bsp_team_added_activity( $post_id, $post ) {
	global $post, $wpdb;

	// Autosave, do nothing
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;
	// AJAX? Not used here
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		return;
	// Check user permissions
	if ( ! current_user_can( 'edit_post', $post_id ) )
		return;
	// Return if it's a post revision
	if ( false !== wp_is_post_revision( $post_id ) )
		return;
	// Return if the post title is empty
	if ( empty( $post->post_title ) )
		return;

	$update = $wpdb->get_var("SELECT id FROM {$wpdb->base_prefix}bp_activity WHERE type='bps_team_added' AND item_id = {$post_id}");

	$user_link  = bp_core_get_userlink( $post->post_author );
	$even_url   = get_permalink( $post_id );
	$event_link = '<a href="' . $even_url . '">' . $post->post_title . '</a>';

	if ( $update ) {
		$type   = 'bps_team_updated';
		$action = sprintf( __( '%1$s updated the team %2$s', 'bp-sportspress' ), $user_link, $event_link );
	} else {
		$type   = 'bps_team_added';
		$action = sprintf( __( '%1$s created the team %2$s', 'bp-sportspress' ), $user_link, $event_link );
	}

	$args = array(
		'user_id'		=> $post->post_author,
		'action'		=> $action,
		'component'     => 'bsp_sportspress',
		'primary_link'	=> $even_url,
		'type'			=> $type, // Set the type, to be used in activity filtering
		'item_id'		=> $post_id, // Set to the group/user/etc id, for better consistency with other BP components
		'secondary_item_id'	=> get_current_user_id(), // The id of the current user itself
	);

	$activity_id = bp_activity_add( $args );

	return $activity_id;
}

add_action( 'save_post_sp_team', 'bsp_team_added_activity', 10, 2 );

/**
 * Post an activity item on player save.
 *
 * @return int $activity_id The id number of the activity created
 */
function bsp_player_added_activity( $post_id, $post ) {
	global $post, $wpdb;

	// Autosave, do nothing
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;
	// AJAX? Not used here
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		return;
	// Check user permissions
	if ( ! current_user_can( 'edit_post', $post_id ) )
		return;
	// Return if it's a post revision
	if ( false !== wp_is_post_revision( $post_id ) )
		return;
	// Return if the post title is empty
	if ( empty( $post->post_title ) )
		return;

	$update = $wpdb->get_var("SELECT id FROM {$wpdb->base_prefix}bp_activity WHERE type='bps_player_added' AND item_id = {$post_id}");

	$user_link  = bp_core_get_userlink( $post->post_author );
	$even_url   = get_permalink( $post_id );
	$event_link = '<a href="' . $even_url . '">' . $post->post_title . '</a>';

	if ( $update ) {
		$type   = 'bps_player_updated';
		$action = sprintf( __( '%1$s updated the player %2$s', 'bp-sportspress' ), $user_link, $event_link );
	} else {
		$type   = 'bps_player_added';
		$action = sprintf( __( '%1$s added the player %2$s', 'bp-sportspress' ), $user_link, $event_link );
	}

	$args = array(
		'user_id'		=> $post->post_author,
		'action'		=> $action,
		'component'     => 'bsp_sportspress',
		'primary_link'	=> $even_url,
		'type'			=> $type, // Set the type, to be used in activity filtering
		'item_id'		=> $post_id, // Set to the group/user/etc id, for better consistency with other BP components
		'secondary_item_id'	=> get_current_user_id(), // The id of the current user itself
	);

	$activity_id = bp_activity_add( $args );

	return $activity_id;
}

add_action( 'save_post_sp_player', 'bsp_player_added_activity', 10, 2 );

/**
 * Post an activity item on staff save.
 *
 * @return int $activity_id The id number of the activity created
 */
function bsp_staff_added_activity( $post_id, $post ) {
	global $post, $wpdb;

	// Autosave, do nothing
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;
	// AJAX? Not used here
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		return;
	// Check user permissions
	if ( ! current_user_can( 'edit_post', $post_id ) )
		return;
	// Return if it's a post revision
	if ( false !== wp_is_post_revision( $post_id ) )
		return;
	// Return if the post title is empty
	if ( empty( $post->post_title ) )
		return;

	$update = $wpdb->get_var("SELECT id FROM {$wpdb->base_prefix}bp_activity WHERE type='bps_staff_added' AND item_id = {$post_id}");

	$user_link  = bp_core_get_userlink( $post->post_author );
	$even_url   = get_permalink( $post_id );
	$event_link = '<a href="' . $even_url . '">' . $post->post_title . '</a>';

	if ( $update ) {
		$type   = 'bps_staff_updated';
		$action = sprintf( __( '%1$s updated the staff %2$s', 'bp-sportspress' ), $user_link, $event_link );
	} else {
		$type   = 'bps_staff_added';
		$action = sprintf( __( '%1$s added the staff %2$s', 'bp-sportspress' ), $user_link, $event_link );
	}

	$args = array(
		'user_id'		=> $post->post_author,
		'action'		=> $action,
		'component'     => 'bsp_sportspress',
		'primary_link'	=> $even_url,
		'type'			=> $type, // Set the type, to be used in activity filtering
		'item_id'		=> $post_id, // Set to the group/user/etc id, for better consistency with other BP components
		'secondary_item_id'	=> get_current_user_id(), // The id of the current user itself
	);

	$activity_id = bp_activity_add( $args );

	return $activity_id;
}

add_action( 'save_post_sp_staff', 'bsp_staff_added_activity', 10, 2 );
