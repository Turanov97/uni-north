<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://profiles.wordpress.org/innovs/
 * @since      1.0.0
 *
 * @package    Innovs_Woo_Manager
 * @subpackage Innovs_Woo_Manager/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Innovs_Woo_Manager
 * @subpackage Innovs_Woo_Manager/includes
 * @author     TheInnovs <theinnovs@gmail.com>
 */
class Innovs_Woo_Manager_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'innovs-woo-manager',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
