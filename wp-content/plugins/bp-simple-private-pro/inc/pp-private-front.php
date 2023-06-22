<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


function pp_private_check() {
	global $bp_unfiltered_uri;

	if ( ! is_admin() && ! is_user_logged_in() ) {

		if ( is_front_page() || is_home() || bp_is_register_page() || bp_is_activation_page() ) {
			return;
		}

		$pp_private_rss = get_option( 'pp-private-rss' );
		if ( $pp_private_rss == '1' )  {
			pp_private_bp_remove_feeds();
		}

		$redirect_url = get_option( 'pp-private-url' );

		if ( $redirect_url == false ) {

			$front_id = get_option('page_on_front');

			if ( $front_id != false ) {
				$redirect_url =  trailingslashit( esc_url( get_permalink( $front_id ) ) );
			} else {
				$redirect_url = trailingslashit( site_url() );
			}
		}


		$pp_private_components = get_option( 'pp-private-components' );
		if ( $pp_private_components == false ) {
			$pp_private_components = array();
		}


		if ( bp_is_user() && in_array( 'member Profile Pages', $pp_private_components ) ) {
			bp_core_redirect( $redirect_url );
		}

		// bbPress
		if ( class_exists( 'bbPress' ) ) {

			if( is_bbpress() && in_array( 'forums', $pp_private_components ) ) {
				bp_core_redirect( $redirect_url );
			}

			if ( bp_is_single_item() && bp_is_groups_component() && bp_is_current_action( 'forum' ) ) {

				if( in_array( 'groupforums', $pp_private_components ) ) {
					bp_core_redirect( $redirect_url );
				}

			}

		}

		$bp_current_component = bp_current_component();  // false if not a bp component

		if ( false != $bp_current_component ) {

			if ( in_array( $bp_current_component, $pp_private_components ) ) {
				bp_core_redirect( $redirect_url );
			}

		}

		// bp_current_component() can return empty for some custom components, so also check the uri
		if ( in_array( $bp_unfiltered_uri[0], $pp_private_components ) ) {
			bp_core_redirect( $redirect_url );
		}

		if ( is_single() || is_page() ) {

			$pp_private_cpts = get_option( 'pp-private-cpts' );
			if ( $pp_private_cpts == false ) {
				$pp_private_cpts = array();
			}

			$post_type = get_post_type( get_the_ID() );

			if ( in_array( $post_type . '-global', $pp_private_cpts ) ) {
				bp_core_redirect( $redirect_url );
			} elseif ( in_array( $post_type, $pp_private_cpts ) ) {

				$pp_private = get_post_meta( get_the_ID(), 'pp-private', true );

				if ( $pp_private == '1' ) {
					bp_core_redirect( $redirect_url );
				}

			}
		}

	}
}
add_action( 'bp_ready', 'pp_private_check' );

function pp_private_bp_remove_feeds() {

	remove_action('bp_actions', 'bp_activity_action_sitewide_feed');
	remove_action('bp_actions', 'bp_activity_action_personal_feed');
	remove_action('bp_actions', 'bp_activity_action_friends_feed');
	remove_action('bp_actions', 'bp_activity_action_my_groups_feed');
	remove_action('bp_actions', 'bp_activity_action_mentions_feed');
	remove_action('bp_actions', 'bp_activity_action_favorites_feed');
	remove_action('bp_actions', 'groups_action_group_feed');

}
