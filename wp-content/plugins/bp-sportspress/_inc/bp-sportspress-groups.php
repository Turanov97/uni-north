<?php
/**
 * BP SportsPress Groups
 *
 * @package BP_SportsPress
 * @subpackage Groups
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * BuddyPress groups for sportspress team
 */
class BP_SportsPress_Groups {

        /**
         * empty constructor function to ensure a single instance
         */
        public function __construct() {
            // leave empty, see singleton below
        }

        public static function instance() {
            static $instance = null;

            if ( null === $instance ) {
                $instance = new BP_SportsPress_Groups;
                $instance->setup();
            }
            return $instance;
        }

        /**
         * setup all
         */
        public function setup() {

            add_action( 'add_meta_boxes',                   array( $this, 'team_group_meta_box' ), 1 );
            add_action( 'save_post_sp_team',                array( $this, 'save_team_group_meta_box' ) );
            add_action( 'body_class',                       array( $this, 'group_body_class' ) );

            /***** Add player into group on player list update *******************************/
            add_action( 'sportspress_process_sp_list_meta', 'bsp_add_players_into_group', 100 );
        }

        /**
         * Team's group metabox
         */
        public function team_group_meta_box() {

            if ( isset( $_GET[ 'post' ] ) ) {
                $post_id = $_GET[ 'post' ];
            } elseif ( isset( $_POST[ 'post_ID' ] ) ) {
                $post_id = $_POST[ 'post_ID' ];
            }
            add_meta_box( 'bps_team_group', __( 'Team Group', 'bp-sportspress' ), array( $this, 'team_group_metabox_function' ), 'sp_team', 'side', 'core' );
        }

        /**
         * Team's group metabox html
         * @param type $post
         */
        public function team_group_metabox_function( $post ) {
            wp_nonce_field( plugin_basename( __FILE__ ), $post->post_type . '_noncename' );
            $team_group = get_post_meta( $post->ID, 'bsp_team_group', true );

            $groups_arr = BP_Groups_Group::get( array(
                'type' => 'alphabetical',
                'per_page' => 999
            ) );
            ?>

            <p><?php _e( 'Add this team to a buddypress group.', 'bp-sportspress' ); ?></p>

            <select name="team_group_id" id="bsp-team-group">
                <option value="-1"><?php _e( '--Select--', 'bp-sportspress' ); ?></option>
                <?php
                foreach ( $groups_arr[ 'groups' ] as $group ) {
                    $group_status = groups_get_groupmeta( $group->id, 'bsp_group_team', true );

                    if ( !empty($group_status) && $team_group != $group->id ) {
                        continue;
                    } ?>

                    <option value="<?php echo $group->id; ?>" <?php echo (( $team_group == $group->id )) ? 'selected' : ''; ?>><?php _e( $group->name, '' ); ?></option><?php
                }
                ?>
            </select>

            <h4><a href="<?php echo ( home_url() .'/'. buddypress()->{'groups'}->root_slug .'/create' ); ?>" target="_blank"><?php _e( '&#43; Create New Group', 'bp-sportspress' ); ?></a></h4><?php
        }

        /**
         * Team save postadata
         * @param type $post_id
         */
        public function save_team_group_meta_box( $post_id ) {
         
            // verify if this is an auto save routine.
            // If it is our form has not been submitted, so we dont want to do anything
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
                return;

            // verify this came from the our screen and with proper authorization,
            // because save_post can be triggered at other times

            if ( ! wp_verify_nonce( @$_POST[ $_POST[ 'post_type' ] . '_noncename' ], plugin_basename( __FILE__ ) ) )
                return;

            // Check permissions
            if ( ! current_user_can( 'edit_post', $post_id ) )
                return;
            // OK, we're authenticated: we need to find and save the data
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return;
            } else {
                $old_group_id = get_post_meta( $post_id, 'bsp_team_group', true );

                //Do not go proceed if no group has been selected
                if ( $_POST[ 'bsp_team_group' ] == '-1' ) return;

                //Ensure we proceed only if team group change from dropdown
                if ( empty( $old_group_id )
                    || $old_group_id != $_POST['team_group_id'] ) {

                    //Replace old group id with new one
                    groups_delete_groupmeta( $old_group_id, 'bsp_group_team' );
                    update_post_meta( $post_id, 'bsp_team_group', $_POST[ 'team_group_id' ] );

                    //Add all player from team into the buddypress group
                    $sp_list_id     = get_post_meta( $post_id, 'sp_list', true );
                    bsp_add_players_into_group( $sp_list_id );

                    groups_add_groupmeta( $_POST[ 'team_group_id' ], 'bsp_group_team', $post_id );
                    bsp_update_group_visibility( $_POST[ 'team_group_id' ] );
                }

            }
        }

        /**
         * Group class
         * @param string $classes
         * @return string
         */
        public function group_body_class( $classes = '' ) {

            if ( in_array( 'group-settings', $classes ) ) {
                $group = groups_get_current_group();
                $course_attached = groups_get_groupmeta( $group->id, 'bsp_',true );
                if ( !  empty( $course_attached ) ) {
                    $classes[] = 'bp-hidepublic';
                }

            }
            return $classes;
        }

} // End of class

BP_SportsPress_Groups::instance();

