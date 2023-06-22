<?php
/**
 * BP SportsPress Functions
 *
 * @package BP_SportPress
 * @subpackage Functions
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


/**
 * Get the player id for a given user.
 *
 * Fetch post id of 'sp_player' post type either from _bsp_user_player_id user meta
 * or from post_author field for a given user id
 *
 */
function bsp_connected_user_player_id( $user_id ) {
	global $wpdb;

	$player_id = get_user_meta( $user_id, '_bsp_user_player_id', true );

	if ( empty( $player_id ) )
		$player_id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_author = $user_id AND post_type = 'sp_player' LIMIT 0,1" );

	return absint( $player_id );
}


/**
 * Get the player id for a given user.
 *
 * Fetch post id of 'sp_player' post type either from _bsp_user_player_id user meta
 * or from post_author field for a given user id
 *
 */
function bsp_connected_player_user_id( $player_id ) {
	global $wpdb;

	$user_id = $wpdb->get_var( "SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key = '_bsp_user_player_id' AND meta_value = '{$player_id}' LIMIT 0,1" );

	if ( empty( $user_id ) )
		$user_id = $wpdb->get_var( "SELECT post_author FROM $wpdb->posts WHERE id = {$player_id} AND post_type = 'sp_player' LIMIT 0,1" );

	return absint( $user_id );
}

/**
 * Set a featured image (thumbnail) by image URL for post
 *
 * @param $image_url
 * @param $post_id
 */
function bsp_generate_featured_image( $image_url, $post_id  ) {

	$upload_dir = wp_upload_dir();
	$image_data = file_get_contents($image_url);
	$filename = basename($image_url);
	if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $filename;
	else                                    $file = $upload_dir['basedir'] . '/' . $filename;
	file_put_contents($file, $image_data);

	$wp_filetype = wp_check_filetype($filename, null );
	$attachment = array(
		'post_mime_type' => $wp_filetype['type'],
		'post_title' => sanitize_file_name($filename),
		'post_content' => '',
		'post_status' => 'inherit'
	);
	$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
	$res1= wp_update_attachment_metadata( $attach_id, $attach_data );
	$res2= set_post_thumbnail( $post_id, $attach_id );
}

/**
 * Add team members to a group
 */
function bsp_add_players_into_group( $sp_list_id ) {
	global $wpdb;

	//Team connected with current player list
	$team_id = get_post_meta( $sp_list_id, 'sp_team', true );

	//Group connected with current Team
	//e.g Group > Team > Player List
	$group_id = get_post_meta( $team_id, 'bsp_team_group', true );

	//post_author NOT IN query part: Make sure to not add player/members only if he already has not been added into group
	$players_user_ids = $wpdb->get_col("SELECT DISTINCT meta_value FROM {$wpdb->postmeta} WHERE meta_key = 'sp_player'
    AND post_id = {$sp_list_id} AND meta_value NOT IN (SELECT ID FROM {$wpdb->posts} WHERE post_type = 'sp_player' AND post_author 
    IN ( SELECT user_id FROM {$wpdb->base_prefix}bp_groups_members WHERE group_id = {$group_id} ) )");

	foreach ( $players_user_ids as $player_id ) {

		$wp_user_id = bsp_connected_player_user_id( $player_id ); //Player > User
		groups_join_group( $group_id, $wp_user_id );
	}
}

/**
 * Set team's group visibility to private/hidden
 * @param $group_id
 */
function bsp_update_group_visibility( $group_id ) {
	$group = groups_get_group( array( 'group_id' => $group_id ) );

	if ( 'public' == $group->status ) {
		$group->status = 'private';

	} elseif ( 'hidden' == $group->status ) {
		$group->status = 'hidden';
	}
	$group->save();

}