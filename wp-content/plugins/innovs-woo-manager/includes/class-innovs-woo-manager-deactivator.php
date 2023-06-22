<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://profiles.wordpress.org/innovs/
 * @since      1.0.0
 *
 * @package    Innovs_Woo_Manager
 * @subpackage Innovs_Woo_Manager/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Innovs_Woo_Manager
 * @subpackage Innovs_Woo_Manager/includes
 * @author     TheInnovs <theinnovs@gmail.com>
 */
class Innovs_Woo_Manager_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		self::drop_table();
	}

	public static function drop_table(){
		global $wpdb;
		$checkout_field = $wpdb->prefix . 'woo_manage_checkout_field';
		$checkout_shipping_field = $wpdb->prefix . 'woo_manage_checkout_shipping_field';
		$checkout_order_note_field = $wpdb->prefix . 'woo_manage_checkout_order_note';

		// drop the table from the database.
		$wpdb->query( "DROP TABLE IF EXISTS $checkout_field" );
		$wpdb->query( "DROP TABLE IF EXISTS $checkout_shipping_field" );
		$wpdb->query( "DROP TABLE IF EXISTS $checkout_order_note_field" );
	}

}
