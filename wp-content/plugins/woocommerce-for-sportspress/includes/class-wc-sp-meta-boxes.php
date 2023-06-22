<?php
/**
 * WooCommerce SportsPress Meta Boxes
 *
 * @author    WordPay
 * @category  Admin
 * @package   WooCommerce_SportsPress
 * @version   1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Meta_Box_WC_SP_Teams
 */
class Meta_Box_WC_SP_Teams {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save' ), 10, 2 );
	}

	/**
	 * Add Meta boxes
	 */
	public function add_meta_boxes() {
		if ( class_exists( 'SportsPress' ) ) {
			global $post;
			add_meta_box( 'sp_teamsdiv', __( 'SportsPress', 'sportspress' ), array( $this, 'teams' ), 'product', 'side', 'default' );
		}
	}

	/**
	 * Teams meta box
	 */
	public static function teams( $post ) {
		if ( class_exists( 'SportsPress' ) ) {
			$teams = array_filter( get_post_meta( $post->ID, 'sp_team', false ) );
			?>
			<p><strong><?php _e( 'Teams', 'sportspress' ); ?></strong></p>
			<p><?php
			$args = array(
				'post_type' => 'sp_team',
				'name' => 'sp_team[]',
				'selected' => $teams,
				'values' => 'ID',
				'placeholder' => __( 'None', 'sportspress' ),
				'class' => 'sp-teams widefat',
				'property' => 'multiple',
				'chosen' => true,
			);
			sp_dropdown_pages( $args );
			?></p>
			<?php
		}
	}

	/**
	 * Save team meta box
	 */
	public static function save( $post_id, $post ) {
		if ( class_exists( 'SportsPress' ) ) {
	    if ( $post->post_status !== 'publish' || $post->post_type !== 'product' )
	      return;

			sp_update_post_meta_recursive( $post_id, 'sp_team', sp_array_value( $_POST, 'sp_team', array() ) );
		}
	}
}

new Meta_Box_WC_SP_Teams();