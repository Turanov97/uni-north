<?php
/*
 * Plugin Name: WooCommerce for SportsPress
 * Plugin URI: https://wordpay.org
 * Description: Integrates WooCommerce with SportsPress.
 * Author: WordPay
 * Author URI: https://wordpay.org
 * Version: 1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'WooCommerce_SportsPress' ) ) :

/**
 * Main WooCommerce SportsPress Class
 *
 * @class WooCommerce_SportsPress
 * @version	1.0
 */
class WooCommerce_SportsPress {

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Define constants
		$this->define_constants();

		// Include required files
		$this->includes();

		// Output generator tag
		add_action( 'get_the_generator_html', array( $this, 'generator_tag' ), 10, 2 );
		add_action( 'get_the_generator_xhtml', array( $this, 'generator_tag' ), 10, 2 );

		// Require SportsPress core
		add_action( 'tgmpa_register', array( $this, 'require_core' ) );

		add_filter( 'sportspress_team_templates', array( $this, 'team_templates' ) );
		add_filter( 'sportspress_screen_ids', array( $this, 'screen_ids' ) );
		add_filter( 'sportspress_text', array( $this, 'add_text_options' ) );
		add_filter( 'sportspress_enqueue_styles', array( $this, 'add_styles' ) );
		add_filter( 'sportspress_licenses', array( $this, 'licenses' ) );
		add_action( 'admin_init', array( $this, 'check_for_updates' ), 0 );
	}

	/**
	 * Define constants.
	*/
	private function define_constants() {
		if ( !defined( 'WOOCOMMERCE_SPORTSPRESS_VERSION' ) )
			define( 'WOOCOMMERCE_SPORTSPRESS_VERSION', '1.0' );

		if ( !defined( 'WOOCOMMERCE_SPORTSPRESS_URL' ) )
			define( 'WOOCOMMERCE_SPORTSPRESS_URL', plugin_dir_url( __FILE__ ) );

		if ( !defined( 'WOOCOMMERCE_SPORTSPRESS_DIR' ) )
			define( 'WOOCOMMERCE_SPORTSPRESS_DIR', plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Include required files.
	*/
	private function includes() {
		require_once dirname( __FILE__ ) . '/includes/class-tgm-plugin-activation.php';
		require_once dirname( __FILE__ ) . '/includes/class-wc-sp-meta-boxes.php';
		require_once dirname( __FILE__ ) . '/includes/class-wc-sp-updater.php';
	}

	/**
	 * Output generator tag to aid debugging.
	 */
	function generator_tag( $gen, $type ) {
		switch ( $type ) {
			case 'html':
				$gen .= "\n" . '<meta name="generator" content="WooCommerce for SportsPress ' . esc_attr( WOOCOMMERCE_SPORTSPRESS_VERSION ) . '">';
				break;
			case 'xhtml':
				$gen .= "\n" . '<meta name="generator" content="WooCommerce for SportsPress ' . esc_attr( WOOCOMMERCE_SPORTSPRESS_VERSION ) . '" />';
				break;
		}
		return $gen;
	}

	/**
	 * Require SportsPress core.
	*/
	public static function require_core() {
		$plugins = array(
			array(
				'name'        => 'SportsPress',
				'slug'        => 'sportspress',
				'required'    => true,
				'version'     => '2.3',
				'is_callable' => array( 'SportsPress', 'instance' ),
			),
			array(
				'name'        => 'WooCommerce',
				'slug'        => 'woocommerce',
				'required'    => true,
			),
		);

		$config = array(
			'default_path' => '',
			'menu'         => 'tgmpa-install-plugins',
			'has_notices'  => true,
			'dismissable'  => true,
			'is_automatic' => true,
			'message'      => '',
			'strings'      => array(
				'nag_type' => 'updated'
			)
		);

		tgmpa( $plugins, $config );
	}

	/**
	 * Add templates to team layout.
	 *
	 * @return array
	 */
	public function team_templates( $templates = array() ) {
		$templates['products'] = array(
			'title' => __( 'Products', 'sportspress' ),
			'label' => __( 'Store', 'sportspress' ),
			'option' => 'sportspress_team_show_directories',
			'action' => array( $this, 'output_team_products' ),
			'default' => 'yes',
		);
		
		return $templates;
	}

	/**
	 * Add screen IDs.
	 *
	 * @return array
	 */
	public function screen_ids( $ids = array() ) {
		$ids[] = 'edit-product';
		$ids[] = 'product';

		return $ids;
	}

	/**
	 * Add text options 
	 */
	public function add_text_options( $options = array() ) {
		return array_merge( $options, array(
			__( 'Store', 'sportspress' ),
		) );
	}

	/**
	 * Output the team store.
	 *
	 * @access public
	 * @subpackage	Staff
	 * @return void
	 */
	public function output_team_products() {
		sp_get_template( 'team-products.php', array(), '', WOOCOMMERCE_SPORTSPRESS_DIR . 'templates/' );
	}

	/**
	 * Add stylesheet.
	*/
	public static function add_styles( $styles = array() ) {
		$styles['woocommerce-for-sportspress'] = array(
			'src'     => str_replace( array( 'http:', 'https:' ), '', WOOCOMMERCE_SPORTSPRESS_URL ) . '/css/woocommerce-for-sportspress.css',
			'deps'    => '',
			'version' => WOOCOMMERCE_SPORTSPRESS_VERSION,
			'media'   => 'all'
		);
		return $styles;
	}

	/**
	 * Add the license option.
	 */
	public static function licenses( $options ) {
		$options['woocommerce'] = array(
	        'name'  => 'WooCommerce for SportsPress',
	        'url'   => 'https://account.themeboy.com',
	    );
	    
	    return $options;
	}

	/**
	 * Check for updates.
	 */
	public static function check_for_updates() {
	    // retrieve our license key from the DB
	    $license_key = trim( get_site_option( 'sportspress_woocommerce_license_key' ) );

	    // setup the updater
	    $edd_updater = new WC_SP_Updater( 'https://account.themeboy.com', __FILE__, array(
	            'version'   => WOOCOMMERCE_SPORTSPRESS_VERSION,
	            'license'   => $license_key,
	            'item_name' => 'WooCommerce for SportsPress',
	            'author'    => 'WordPay'
	        )
	    );
	}
}

endif;

new WooCommerce_SportsPress();

