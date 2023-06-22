<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/innovs/
 * @since      1.0.0
 *
 * @package    Innovs_Woo_Manager
 * @subpackage Innovs_Woo_Manager/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Innovs_Woo_Manager
 * @subpackage Innovs_Woo_Manager/admin
 * @author     TheInnovs <theinnovs@gmail.com>
 */
class Innovs_Woo_Manager_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Innovs_Woo_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Innovs_Woo_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( 'wp-color-picker');
		wp_enqueue_style( $this->plugin_name . '_innovs-woo-bootstrap', plugin_dir_url( __FILE__ ) . 'css/innovs-woo-bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '_innovs-woo-font-awosome', plugin_dir_url( __FILE__ ) . 'css/innovs-woo-font-awosome.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/innovs-woo-manager-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Innovs_Woo_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Innovs_Woo_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'wp-color-picker'); // wp color picker js file
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-accordion');
		wp_enqueue_script( 'jquery-form' );
		wp_enqueue_script( $this->plugin_name . 'innovs-woo-bootstrap', plugin_dir_url( __FILE__ ) . 'js/innovs-woo-bootstrap.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/innovs-woo-manager-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name .'innovs_ajax' , plugin_dir_url( __FILE__ ) . 'js/innovs-woo-manager-ajax.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name . 'innovs_ajax', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ))); 

	}

}
