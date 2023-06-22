<?php
/**
 * BP SportsPress Notifications
 *
 * @package BP-SportsPress
 * @subpackage Notifications
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/** NOTIFICATIONS API ***************************************************/


/**
 * Format on screen notifications into something readable by users.
 *
 * @global $bp The global BuddyPress settings variable created in bp_core_setup_globals()
 */
function bp_sportspress_format_notifications( $action, $item_id, $secondary_item_id, $total_items, $format = 'string' ) {
	global $bp;

	do_action( 'bp_sportspress_format_notifications', $action, $item_id, $secondary_item_id, $total_items, $format );

	switch ( $action ) {
		//Player added in event
		case 'new_event':
			$link = $text = false;

			if ( 1 == $total_items ) {
				$text = sprintf( __( 'You have been added to event %s', 'bp-sportspress' ), get_post_field( 'post_title', $item_id ) );
				$link = esc_url_raw( add_query_arg( array( 'bsp_read' => 'new_event', 'event_id' => $item_id ), get_permalink( $item_id ) ) );

			} else {
				$text = sprintf( __( 'You have been added in %d new events', 'bp-sportspress' ), $total_items );

				if ( bp_is_active( 'notifications' ) ) {
					$link = bp_get_notifications_permalink();
				}
			}

			break;
		//Player added in players list
		case 'new_player_list':
			$link = $text = false;

			if ( 1 == $total_items ) {
				$text = sprintf( __( 'You have been added to players list %s', 'bp-sportspress' ), get_post_field( 'post_title', $item_id ) );
				$link = esc_url_raw( add_query_arg( array( 'bsp_read' => 'new_player_list', 'list_id' => $item_id ), get_permalink( $item_id ) ) );

			} else {
				$text = sprintf( __( 'You have been added in %d new players list', 'bp-sportspress' ), $total_items );

				if ( bp_is_active( 'notifications' ) ) {
					$link = bp_get_notifications_permalink();
				}
			}

			break;

		//Player added in event
		case 'scoreboard_update':
			$link = $text = false;

			if ( 1 == $total_items ) {
				$text = sprintf( __( 'Your score have been updated for event %s', 'bp-sportspress' ), get_post_field( 'post_title', $item_id ) );
				$link = esc_url_raw( add_query_arg( array( 'bsp_read' => 'scoreboard_update', 'event_id' => $item_id ), get_permalink( $item_id ) ) );

			} else {
				$text = sprintf( __( 'You score have been added in %d events', 'bp-sportspress' ), $total_items );

				if ( bp_is_active( 'notifications' ) ) {
					$link = bp_get_notifications_permalink();
				}
			}

			break;

		default :
			$link = apply_filters( 'bp_sportspress_extend_notification_link', false, $action, $item_id, $secondary_item_id, $total_items );
			$text = apply_filters( 'bs_sportspress_extend_notification_text', false, $action, $item_id, $secondary_item_id, $total_items );
			break;
	}

	if ( ! $link || ! $text ) {
		return false;
	}

	if ( 'string' == $format ) {
		return apply_filters( 'bp_sportspress_notification', '<a href="' . $link . '">' . $text . '</a>', $total_items, $link, $text, $item_id, $secondary_item_id );

	} else {
		$array = array(
			'text' => $text,
			'link' => $link
		);

		return apply_filters( 'bp_sportspress_return_notification', $array, $item_id, $secondary_item_id, $total_items );
	}
}

/**
 * Adds notification when a user added into the event.
 *
 * @param object $post The WP_Post object.
 */
function bps_event_notifications_add_on_event( $post_id, $post ) {
	global $wpdb;

	// Add a screen notification
	//
	// BP 1.9+
	if ( bp_is_active( 'notifications' ) ) {

		// Get results for all players in the event
		$players_ids =  get_post_meta( $post->ID, 'sp_player' );

		//Get $wp_users from player ids
		$players_ids_in = implode( ',', array_unique( $players_ids ) );

		//post_author NOT IN query part: Make sure to not send the notification multiple times to same player
		$players_user_ids = $wpdb->get_col("SELECT DISTINCT post_author FROM $wpdb->posts WHERE id IN ({$players_ids_in})
 		AND post_author NOT IN ( SELECT user_id FROM {$wpdb->base_prefix}bp_notifications WHERE item_id = {$post_id} AND
 		component_name = 'sportspress' AND component_action = 'new_event' )");

		foreach ( $players_user_ids as $wp_user_id ) {
			bp_notifications_add_notification( array(
				'item_id'           => $post_id,
				'user_id'           => $wp_user_id,
				'component_name'    => 'sportspress',
				'component_action'  => 'new_event'
			) );
		}

	}
}

add_action( 'sportspress_process_sp_event_meta', 'bps_event_notifications_add_on_event', 99, 2 );

/**
 * Adds notification when a scoreboard update into the event.
 * @param $post_id
 * @param $post
 */
function bps_event_notifications_add_on_scoreboard_update( $post_id, $post ) {
	global $_old_sp_player_meta, $wpdb;

	$performance = get_post_meta( $post_id, 'sp_players', true );

	foreach ( $performance as $team => $players ) {
		foreach ( $players as $player => $pp ) {
			if ( 0 >= $player ) continue;
			foreach ( $pp as $pk => $pv ) {
				if ( is_array( $pv ) ) continue;

				$pv = trim( $pv );
				if ( '' == $pv ) continue;
				if ( ! ctype_digit( $pv ) ) continue;

				// determine whether score has been updated or not for player in loop
				if( ! isset( $_old_sp_player_meta[$team][$player] )
				    || $_old_sp_player_meta[$team][$player] != $pp ) {

					$wp_user_id = bsp_connected_player_user_id( $player );

					//post_author NOT IN query part: Make sure to not send the notification multiple times to same player
					$player_user_id = $wpdb->get_var("SELECT id FROM {$wpdb->base_prefix}bp_notifications WHERE item_id = {$post_id} AND
 					component_name = 'sportspress' AND component_action = 'scoreboard_update' AND is_new = 1 AND user_id = {$wp_user_id}");

					if ( absint( $player_user_id ) <= 0 && $wp_user_id > 0 ) {
						bp_notifications_add_notification( array(
							'item_id' => $post_id,
							'user_id' => $wp_user_id,
							'secondary_item_id' => $player,
							'component_name' => 'sportspress',
							'component_action' => 'scoreboard_update'
						) );
					}
				}
			}
		}
	}
}

add_action( 'sportspress_process_sp_event_meta', 'bps_event_notifications_add_on_scoreboard_update', 99, 2 );

/**
 * Add a temporary event meta 'sp_players' in to global variable.
 * We later use it to compute diff for scoreboard update notification.
 *
 * @see bps_event_notifications_add_on_scoreboard_update()
 * @param $post_id
 * @param $post
 */
function bps_event_preserve_old_sp_player_meta( $post_id, $post ) {
	global $_old_sp_player_meta;
	$_old_sp_player_meta = get_post_meta( $post_id, 'sp_players', true );
}

add_action( 'save_post_sp_event' , 'bps_event_preserve_old_sp_player_meta', 10, 2 );

/**
 * Mark notification as read when a logged-in user visits their event single page for score update.
 *
 * This is a new feature in BuddyPress 1.9.
 */
function bsp_scoreboard_update_notifications_mark_as_read() {
	if ( ! isset( $_GET['bsp_read'] ) || 'scoreboard_update' != $_GET['bsp_read'] ) {
		return;
	}

	// mark notification as read
	if ( bp_is_active( 'notifications' ) ) {
		bp_notifications_mark_notifications_by_item_id( bp_loggedin_user_id(), $_GET['list_id'], 'sportspress', 'scoreboard_update' );
	}
}
add_action( 'init', 'bsp_scoreboard_update_notifications_mark_as_read' );

/**
 * Mark notification as read when a logged-in user visits their event single page.
 *
 * This is a new feature in BuddyPress 1.9.
 */
function bsp_event_notifications_mark_as_read() {
	if ( ! isset( $_GET['bsp_read'] ) || 'new_event' != $_GET['bsp_read'] ) {
		return;
	}

	// mark notification as read
	if ( bp_is_active( 'notifications' ) ) {
		bp_notifications_mark_notifications_by_item_id( bp_loggedin_user_id(), $_GET['event_id'], 'sportspress', 'new_event' );
	}
}
add_action( 'init', 'bsp_event_notifications_mark_as_read' );


/**
 * Adds notification when a user follows another user.
 *
 * @param object $post The WP_Post object.
 */
function bps_player_notifications_add_on_list( $post_id, $post ) {
	global $wpdb;

	// Add a screen notification
	//
	// BP 1.9+
	if ( bp_is_active( 'notifications' ) ) {

		// Get results for all players in list
		$players_ids = get_post_meta( $post->ID, 'sp_player' );

		//Get $wp_users from player ids
		$players_ids_in = implode( ',', array_unique( $players_ids ) );

		//post_author NOT IN query part: Make sure to not send notification multiple times to the same player
		$players_user_ids = $wpdb->get_col("SELECT DISTINCT post_author FROM $wpdb->posts WHERE id IN ({$players_ids_in})
 		AND post_author NOT IN ( SELECT user_id FROM {$wpdb->base_prefix}bp_notifications WHERE item_id = {$post_id} AND
 		component_name = 'sportspress' AND component_action = 'new_player_list' )");

		foreach ( $players_user_ids as $wp_user_id ) {
			bp_notifications_add_notification( array(
				'item_id'           => $post_id,
				'user_id'           => $wp_user_id,
				'component_name'    => 'sportspress',
				'component_action'  => 'new_player_list'
			) );
		}

	}
}

add_action( 'sportspress_process_sp_list_meta', 'bps_player_notifications_add_on_list', 99, 2 );

/**
 * Mark notification as read when a logged-in user visits their players list single page.
 *
 * This is a new feature in BuddyPress 1.9.
 */
function bsp_player_list_notifications_mark_as_read() {
	if ( ! isset( $_GET['bsp_read'] ) || 'new_player_list' != $_GET['bsp_read'] ) {
		return;
	}

	// mark notification as read
	if ( bp_is_active( 'notifications' ) ) {
		bp_notifications_mark_notifications_by_item_id( bp_loggedin_user_id(), $_GET['list_id'], 'sportspress', 'new_player_list' );
	}
}
add_action( 'init', 'bsp_player_list_notifications_mark_as_read' );
