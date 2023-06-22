<?php
/**
 * BP SportsPress Core
 *
 * @package BP_SportsPress
 * @subpackage Core
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Core class for BP SportsPress.
 *
 * Extends the {@link BP_Component} class.
 *
 * @package BP_SportsPress
 * @subpackage Classes
 *
 * @since 1.2
 */
class BP_SportsPress_Component extends BP_Component {

	/**
	 * Constructor.
	 *
	 * @global obj $bp BuddyPress instance
	 */
	public function __construct() {
		global $bp;

		// setup misc parameters
		$this->params = array(
			'adminbar_myaccount_order' => apply_filters( 'bp_sp_events_nav_position', 61 )
		);

		// let's start the show!
		parent::start(
			'sportspress',
			__( 'sportspress', 'bp-sportspress' ),
			constant( 'BP_SPORTSPRESS_DIR' ) . '/_inc',
			$this->params
		);

		// include our files
		$this->includes();

		// setup hooks
		$this->setup_hooks();

		// register our component as an active component in BP
		$bp->active_components[$this->id] = '1';
	}

	/**
	 * Includes.
	 */
	public function includes( $includes = array() ) {

		require( $this->path . '/bp-sportspress-functions.php' );
		require( $this->path . '/bp-sportspress-screens.php' );
		require( $this->path . '/bp-sportspress-templates.php' );
		require( $this->path . '/bp-sportspress-hooks.php' );
		//Check whether a activity component (or feature of a component) is active.
		if ( bp_is_active( 'activity' ) ) {
			require( $this->path . '/bp-sportspress-activity.php' );
		}
		require( $this->path . '/bp-sportspress-notifications.php' );
		require( $this->path . '/bp-sportspress-license.php' );
		//Check whether a groups component (or feature of a component) is active.
		if ( bp_is_active('groups' ) ) {
			require( $this->path . '/bp-sportspress-groups.php' );
			require( $this->path . '/bp-sportspress-groups-extension.php' );
		}
		
	}

	/**
	 * Setup globals.
	 *
	 * @global obj $bp BuddyPress instance
	 */
	public function setup_globals( $args = array() ) {
		global $bp;

		// Set up the $globals array
		$globals = array(
			'notification_callback' => 'bp_sportspress_format_notifications',
		);

		// Let BP_Component::setup_globals() do its work.
		parent::setup_globals( $globals );
	}

	/**
	 * Setup hooks.
	 */
	public function setup_hooks() {
		// javascript hook
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 11 );
	}

	/**
	 * Enqueue scripts and styles
	 */
	public function enqueue_scripts() {

		//Chosen
		wp_enqueue_style( 'jquery-chosen', SP()->plugin_url() . '/assets/css/chosen.css', array(), '1.0.1' );
		wp_register_script( 'chosen', SP()->plugin_url() . '/assets/js/chosen.jquery.min.js', array( 'jquery' ), '1.0.1', true );

		//BP SportsPress Main
		wp_register_script( 'bp-sportspress-main', BP_SPORTSPRESS_URL . '/_inc/bp-sportspress.js', array('jquery'), BP_SPORTSPRESS_VERSION, true );

		//Enqueuing
		wp_enqueue_script('chosen');
		wp_enqueue_script('bp-sportspress-main');
	}

	/**
	 * Setup profile / BuddyBar navigation
	 */
	public function setup_nav( $main_nav = array(), $sub_nav = array() ) {
		global $bp;

		// Determine user to use.
		if ( bp_displayed_user_domain() ) {
			$user_domain = bp_displayed_user_domain();
		} elseif ( bp_loggedin_user_domain() ) {
			$user_domain = bp_loggedin_user_domain();
		} else {
			return;
		}

		$access        = bp_core_can_edit_settings();
		$slug          = bp_get_sportspress_slug();
		$sportspress_link = trailingslashit( $user_domain . $slug );

		/** SPORTSPRESS NAV ************************************************/

		bp_core_new_nav_item( array(
			'name'                => __( 'SportsPress', 'bp-sportspresss' ),
			'slug'                => $slug,
			'position'            => $this->params['adminbar_myaccount_order'],
			'screen_function'     => 'bp_sportspress_screen_events',
			'default_subnav_slug' => 'events',
			'item_css_id'         => 'members-sportspress-events'
		) );


		/** SPORTSPRESS SUBNAV **********************************************/

		// Add activity sub nav item
		if ( apply_filters( 'bp_sportspress_events_subnav', true ) ) {

			bp_core_new_subnav_item( array(
				'name'            => _x( 'Events', 'Activity subnav tab', 'bp-sportspress' ),
				'slug'            => 'events',
				'parent_url'      => $sportspress_link,
				'parent_slug'     => $slug,
				'screen_function' => 'bp_sportspress_screen_events',
				'position'        => 21,
				'item_css_id'     => 'bp-sportspress-events'
			) );
		}

	}

	/**
	 * Set up WP Toolbar / Admin Bar.
	 *
	 * @global obj $bp BuddyPress instance
	 */
	public function setup_admin_bar( $wp_admin_nav = array() ) {

		// Menus for logged in user
		if ( is_user_logged_in() ) {
			global $bp;

			// Setup the logged in user variables.
			$sportspress_link = trailingslashit( bp_loggedin_user_domain() . bp_get_sportspress_slug() );

			// "Sportspress" parent nav menu
			$wp_admin_nav[] = array(
				'parent' => $bp->my_account_menu_id,
				'id'     => 'my-account-' . $this->id,
				'title'  => _x( 'SportsPress', 'Adminbar main nav', 'bp-sportspress' ),
				'href'   => $sportspress_link
			);

			// "Events" subnav item
			$wp_admin_nav[] = array(
				'parent' => 'my-account-' . $this->id,
				'id'     => 'my-account-' . $this->id . '-events',
				'title'  => _x( 'Events', 'Adminbar events subnav', 'bp-sportspress' ),
				'href'   => $sportspress_link
			);

		}

		parent::setup_admin_bar( apply_filters( 'bp_sportspress_toolbar', $wp_admin_nav ) );
	}

}

/**
 * Loads the SportsPress component into the $bp global
 *
 * @package BP_SportsPress
 * @global obj $bp BuddyPress instance
 * @since 1.2
 */
function bp_sportspress_setup_component() {
	global $bp;

	$bp->sportspress = new BP_SportsPress_Component;
}
add_action( 'bp_loaded', 'bp_sportspress_setup_component' );
