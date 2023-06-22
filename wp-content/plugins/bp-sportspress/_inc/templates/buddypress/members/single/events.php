<?php
/**
 * BuddySports - Members events
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $bp;

$displayed_user_id = $bp->displayed_user->id;
$user_player_id = bsp_connected_user_player_id( $displayed_user_id );

if ( ! empty( $user_player_id ) ) {

    $args = array(
        'posts_per_page' => - 1,
        'post_type' => 'sp_calendar',
        'post_status' => 'publish',
    );

    $the_query = get_posts( $args );

    foreach ( $the_query as $key => $value ) {
        echo do_shortcode( '[event_list id="' . $value->ID . '" player="' . $user_player_id . '" ]' );
    }
}