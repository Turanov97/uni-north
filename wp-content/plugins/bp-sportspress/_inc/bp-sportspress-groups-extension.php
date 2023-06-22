<?php
/**
 * The bp_is_active( 'groups' ) check is recommended, to prevent problems
 * during upgrade or when the Groups component is disabled
 */
if ( bp_is_active( 'groups' ) ) :

    class Group_Extension_SportsPress extends BP_Group_Extension {

        /**
         * Here you can see more customization of the config options
         */
        function __construct() {
            $args = array(
                'slug' => 'team',
                'name' => __( 'Team', 'bp-sportspress' ),
                'nav_item_position' => 10,
            );
            parent::init( $args );
        }

        /**
         * Single team content
         * @param null $group_id
         */
        function display( $group_id = NULL ) {
            global $post;

            $group_id   = bp_get_group_id();
            $team_id    = groups_get_groupmeta( $group_id, 'bsp_group_team', true );

            if ( empty ( $team_id ) ) {

                $edit_group_team_url = bp_get_group_permalink() . 'admin/team';

                ?>
                    <div id="message" class="info">
                        <?php printf( __('<span>This group has not connected with team, <a href="%s">Click</a> to connect group with the team</span>', 'bp-sportspress' ), $edit_group_team_url ); ?>
                    </div>
                <?php

            } else {

                $post = get_post( $team_id, OBJECT );
                setup_postdata( $post );

                sportspress_output_team_details();
                sportspress_output_team_staff();
                sportspress_output_team_lists();
                sportspress_output_team_tables();
                sportspress_output_team_events();

                wp_reset_postdata();
            }


        }

        function settings_screen( $group_id = NULL ) {

            $team_id    = groups_get_groupmeta( $group_id, 'bsp_group_team', true );

            $teams = get_posts( array(
                'post_type' => 'sp_team',
                'posts_per_page' => -1,
                'post_status'	=> 'publish'
            ) );

            if ( !empty( $teams ) ) { ?>
                <div class="bp-sportspress-group-team">
                    <h4><?php _e('Group Team', 'bp-sportspress')?></h4>
                    <select name="bp_group_team" id="bp-group-team">
                        <option value="-1"><?php _e( '--Select--', 'bp-sportspress' ); ?></option>
                        <?php
                        foreach ( $teams as $team ) {
                            $group_attached = get_post_meta( $team->ID, 'bsp_team_group', true );

                            //lets skip the team connected with other groups
                            if ( !empty( $group_attached ) && ( '-1' != $group_attached ) && $team->ID != $team_id ) {
                                continue;
                            } ?>

                            <option value="<?php echo $team->ID; ?>" <?php echo (( $team->ID == $team_id )) ? 'selected' : ''; ?>><?php echo $team->post_title; ?></option>

                    <?php } ?>
                    </select>
                </div><br><br/><br/><?php
            }
        }

        function settings_screen_save( $group_id = NULL ) {

            $old_team_id = groups_get_groupmeta( $group_id, 'bsp_group_team', true );

            if ( isset( $_POST[ 'bp_group_team' ] ) &&
                '-1' == $_POST['bp_group_team'] ) {

                //Delete group meta and post meta > Connection data
                groups_delete_groupmeta( $group_id, 'bsp_group_team' );
                delete_post_meta( $old_team_id, 'bsp_team_group', $group_id );

            } elseif ( isset( $_POST[ 'bp_group_team' ] ) &&
                 $_POST[ 'bp_group_team' ] != '-1' &&
                 $old_team_id != $_POST[ 'bp_group_team' ] ) {

                $team_id = $_POST[ 'bp_group_team' ];

                //Update group meta and post meta > Connection data
                groups_update_groupmeta( $group_id, 'bsp_group_team', $team_id );
                update_post_meta( $team_id, 'bsp_team_group', $group_id );

                //Add all player from team into the buddypress group Team > Player List
                $sp_list_id     = get_post_meta( $team_id, 'sp_list', true );
                bsp_add_players_into_group( $sp_list_id );

                //Make group private or hidden
                bsp_update_group_visibility( $group_id );
            }
        }

    }
    bp_register_group_extension( 'Group_Extension_SportsPress' );

endif;