<?php
/**
 * BP SportsPress Hooks
 *
 * Functions in this file allow this component to hook into BuddyPress so it
 * interacts seamlessly with the interface and existing core components.
 *
 * @package BP_SportsPress
 * @subpackage Hooks
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/** PROFILE FIELD LOOP INJECTION *******************************************************/

/**
 * Inject displayed user player profile in the members profile loop.
 *
 * The Profile tab in the BuddyPress profile also display the user's player profile.
 *
 * Combine BuddyPress and SportsPress profiles.
 *
 */
function bp_sportspress_player_profile_loop() {
	global $bp, $wpdb;

	$player_id = bsp_connected_user_player_id( $bp->displayed_user->id );
	if ( empty( $player_id ) ) return;

	?>
	<div class="bp-widget bp-sportspress-fields">
		<h4><?php _e( 'Player', 'bp-sportspress' ) ?></h4>
		<?php echo do_shortcode( "[player_details {$player_id}]"); //Player details ?>
		<?php echo do_shortcode( "[player_statistics {$player_id}]" ); //Player score statistics ?>
	</div><?php
}

add_action( 'bp_after_profile_loop_content', 'bp_sportspress_player_profile_loop' );

/**
 * Keep other players event out of primary WP queries
 *
 * By catching the query at pre_get_posts, we ensure that all queries are
 * filtered appropriately, whether they originate with BuddySport or not
 * (as in the case of search)
 *
 */
function bsp_user_events_query_arg( $query ) {
	global $bp, $wpdb;

	// Access is unlimited when viewing a user page
	if ( ! bp_is_current_component( 'sportspress' )
	|| ! bp_is_current_action( 'events' ) ) return;

	// We only need to filter when Event could possibly show up in the
	// results, so we check the post type, and bail if the post_type rules
	// out Events to begin with
	$queried_post_type = $query->get( 'post_type' );
	$pt = 'sp_event';
	$is_event_query = is_array( $queried_post_type ) ? in_array( $pt, $queried_post_type ) : $pt == $queried_post_type;

	if ( ! $queried_post_type ||
	     'any' == $queried_post_type ||
	     $is_event_query
	) {
		//Player id
		$displayed_user_id = $bp->displayed_user->id;

		$events_ids = $wpdb->get_col( "SELECT DISTINCT ID FROM {$wpdb->posts} p INNER JOIN {$wpdb->postmeta} m ON p.id = m.post_id
  				  	WHERE p.post_type = 'sp_event' AND m.meta_key = 'sp_player' AND m.meta_value IN ( SELECT ID FROM
  				  	$wpdb->posts WHERE post_author = $displayed_user_id AND post_type = 'sp_player' ) " );

		// Search by found events
		$query->set( 'post__in', array_merge( $events_ids, array( 0 ) ) );
	}
}

//add_action( 'pre_get_posts', 'bsp_user_events_query_arg', 999999 );

/** PROFILE FIELD FUNCTIONS **********************************************************/

/**
 * Output player meta edit fields(inputs) in Profile > Edit
 * @return bool|void
 */
function bsp_player_profile_edit_fields() {

	global $group, $bp, $wpdb;

	//Bail if it is not user profile edit
	if ( ! bp_is_current_component( 'profile' ) || ! bp_is_current_action( 'edit' ) ) return false;

	//Bail if it is not Base profile field group
	if ( 'Base' !== $group->name ) return;

	//Player id
	$displayed_user_id = $bp->displayed_user->id;
	$player_id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_author = $displayed_user_id AND post_type = 'sp_player' LIMIT 0,1" );

	if ( ! $player_id ||  empty( $player_id ) && sizeof( $player_id ) < 1 ) return;

	//Output the player fields(input)
	$post = get_post( $player_id );
	SP_Meta_Box_Player_Details::output( $post );
	SP_Meta_Box_Player_Metrics::output( $post );
}

add_action( 'bp_after_profile_field_content', 'bsp_player_profile_edit_fields' );

/**
 * Saves player meta from Profile > Edit
 */
function bsp_update_user_player_id( $profile_data ) {
	global $wpdb;

	//Fetch Player id
	$displayed_user_id 	= bp_displayed_user_id();

	if ( empty( $displayed_user_id ) ) {
		return;
	}

	$player_id 			= $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_author = $displayed_user_id AND post_type = 'sp_player' LIMIT 0,1" );

	$post = get_post( $player_id );
	SP_Meta_Box_Player_Details::save( $player_id, $post );
	SP_Meta_Box_Player_Metrics::save( $player_id, $post );
}

add_action( 'xprofile_data_before_save', 'bsp_update_user_player_id', 10, 1 );

/** BP PROFILE AND PLAYER POST DATA SYNC *********************************************/

/**
 * Sync the player images for BuddyPress from their SportsPress player profiles instead of gravatar
 * @param $post_id
 * @param $post
 */
function bsp_change_members_profile_photo( $post_id, $post ) {

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
	// Return if no user connected
	if ( ! $user_id = bsp_connected_player_user_id( $post_id ) )
		return;

	// Return if has no post thumbnail attached
	if ( ! $thumb_id = get_post_thumbnail_id( $post_id ) ) {
		return;
	} else {

		//Fetch post thumbnail
		$filemeta = get_post_meta( $thumb_id, '_wp_attachment_metadata', true );
		$filename = get_post_meta( $thumb_id, '_wp_attached_file', true );
		$file =  substr( $filename, 0, 8 ) . $filemeta['sizes']['thumbnail']['file'];

		// If the file is relative, prepend upload dir.
		if ( $file && 0 !== strpos( $file, '/' ) && ! preg_match( '|^.:\\\|', $file ) && ( ( $uploads = wp_get_upload_dir() ) && false === $uploads['error'] ) ) {
			$thumb_path = $uploads['basedir'] . "/$file";
		}
	}
	//Return if post thumbnail has not been chnaged
	if ( $thumb_id == get_user_meta( $user_id, '_bsp_player_avatar_thumb', true ) )
		return;
	
	$bp_params =  array(
		'object'  	=> 'user',
		'item_id' 	=> $user_id,
		'component' => 'xprofile',
		'image'     => $thumb_path 
	);

	//Store player post thumbnail in user mate
	update_user_meta( $user_id, '_bsp_player_avatar_thumb', $thumb_id );

	//Set members profile picture
	bp_attachments_create_item_type( 'avatar', $bp_params );
}

add_action( 'save_post_sp_player', 'bsp_change_members_profile_photo', 20, 2 );

/**
 * Sync member's profile picture for SportsPress player from their buddypress profiles
 * @param $item_id
 * @param $type
 */
function bsp_set_player_thumbnail( $item_id, $type ) {

	//Return if post thumbnail has not been chnaged
	if ( ! $player_id = bsp_connected_user_player_id( $item_id ) )
		return;
	
	//Fetch an avatar for a BuddyPress member.
	$avatar_url = bp_core_fetch_avatar( array(
		'object'  => 'user',
		'item_id' => $item_id,
		'html'    => false,
		'type'    => 'full',
	) );

	//Set a featured image (thumbnail) by image URL for player post
	bsp_generate_featured_image( $avatar_url, $player_id );
}

add_action( 'xprofile_avatar_uploaded', 'bsp_set_player_thumbnail', 10, 2 );

/** MISC HOOKS ************************************************************/

/**
 * Redirect player page to BP Profiles, if they are set to any players/users
 */
function bsp_player_profile_redirect() {
	global $post, $wpdb;

	if ( is_singular('sp_player') ) {

		if ( $user_id = $wpdb->get_var( "SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key = '_bsp_user_player_id' AND meta_value = '{$post->ID}' LIMIT 0,1" ) ) {
			$profile_link = trailingslashit( bp_core_get_user_domain( $user_id ) . bp_get_profile_slug() );
			wp_redirect( $profile_link );
			exit();
		}
	}
}

add_action( 'template_redirect', 'bsp_player_profile_redirect' );

/**
 * Save fields and add player during user registration.
 * @param $user
 * @return bool
 */
function bsp_user_register( $user ) {

	if ( empty( $user ) ) {
		return false;
	}

	if ( is_array( $user ) ) {
		$user_id = $user['user_id'];
	} else {
		$user_id = $user;
	}

	if ( empty( $user_id ) ) {
		return false;
	}
	
	// Add player
	if ( 'yes' === get_option( 'sportspress_registration_add_player', 'no' ) ) {

		$fullname = xprofile_get_field_data( bp_xprofile_fullname_field_id(), $user_id );
		
		if ( empty( $fullname ) ) {
			$user_data 	= get_userdata( $user_id );
			$fullname 	= $user_data->user_login;
		}

		$post['post_type'] 		= 'sp_player';
		$post['post_title'] 	= trim( $fullname );
		$post['post_author'] 	= $user_id;
		$post['post_status'] 	= 'publish';
		$id 					= wp_insert_post( $post );
	}
}

add_action( 'bp_core_activated_user', 'bsp_user_register', 21 );