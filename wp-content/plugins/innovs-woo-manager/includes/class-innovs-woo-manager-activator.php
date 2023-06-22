<?php

/**
 * Fired during plugin activation
 *
 * @link       https://profiles.wordpress.org/innovs/
 * @since      1.0.0
 *
 * @package    Innovs_Woo_Manager
 * @subpackage Innovs_Woo_Manager/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Innovs_Woo_Manager
 * @subpackage Innovs_Woo_Manager/includes
 * @author     TheInnovs <theinnovs@gmail.com>
 */
class Innovs_Woo_Manager_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		self::create_table();
		self::insert_data();
		self::updateOoption();
		self::installation_time();
	}

	private static function installation_time() {
		$get_installation_time = strtotime("now");
		update_option( 'iwm_install_time', $get_installation_time );
	}

	private static function updateOoption(){
		update_option('simple_button_text','Add to cart');
		update_option('grouped_button_text','Grouped Product');
		update_option('external_button_text','External button');
		update_option('variable_button_text','Varibale button');
		update_option('booking_button_text','Booking Now');
		update_option('subs_button_text','Subscription now');
		update_option('increase_variable_pro','50');
		update_option('woo_pro_notice','01');
		update_option('woo_estimate_notice','01');
	}

	public static function create_table(){
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$checkout_field = $wpdb->prefix . "woo_manage_checkout_field";
		$checkout_shipping_field = $wpdb->prefix . 'woo_manage_checkout_shipping_field';
		$checkout_order_note_field = $wpdb->prefix . 'woo_manage_checkout_order_note';

		$sql1 = "CREATE TABLE IF NOT EXISTS $checkout_field (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`field_name` varchar(250) NOT NULL,
			`input_type` varchar(250) NOT NULL,
			`input_label` varchar(250) NOT NULL,
			`input_width` varchar(250) NOT NULL,
			`placeholder` varchar(250) NOT NULL,
			`input_required` varchar(250) NOT NULL,
			`input_remove` varchar(250) NOT NULL,
			`position` int(11) NOT NULL,
			`created_at` timestamp NOT NULL DEFAULT current_timestamp(),
			`updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
			PRIMARY KEY (`id`)
		   ) $charset_collate";

		$sql2 = "CREATE TABLE IF NOT EXISTS $checkout_shipping_field (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`s_field_name` varchar(250) NOT NULL,
			`s_input_type` varchar(250) NOT NULL,
			`s_input_label` varchar(250) NOT NULL,
			`s_input_width` varchar(250) NOT NULL,
			`s_placeholder` varchar(250) NOT NULL,
			`s_input_required` varchar(250) NOT NULL,
			`s_input_remove` varchar(250) NOT NULL,
			`s_position` int(11) NOT NULL,
			`created_at` timestamp NOT NULL DEFAULT current_timestamp(),
			`updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
			PRIMARY KEY (`id`)
		) $charset_collate";

		$sql3 = "CREATE TABLE IF NOT EXISTS $checkout_order_note_field (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`o_field_name` varchar(250) NOT NULL,
			`o_input_type` varchar(250) NOT NULL,
			`o_input_label` varchar(250) NOT NULL,
			`o_input_width` varchar(250) NOT NULL,
			`o_placeholder` varchar(250) NOT NULL,
			`o_input_required` varchar(250) NOT NULL,
			`o_input_remove` varchar(250) NOT NULL,
			`o_position` int(11) NOT NULL,
			`created_at` timestamp NOT NULL DEFAULT current_timestamp(),
			`updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
			PRIMARY KEY (`id`)
		) $charset_collate";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql1 );
		dbDelta( $sql2 );
		dbDelta( $sql3 );
	}


	public static function insert_data() {
		global $wpdb;
		$first = "form-row-first";
		$last = "form-row-last";
		$full = "form-row-wide";

		$checkout_field = $wpdb->prefix . "woo_manage_checkout_field";
		


		$field_name = ['first name','last name','company','country','address 1','address 2','state','city','postcode','phone','email'];
		$input_type = ['text','text','text','country','text','text','state','text','text','text','email'];
		$input_label = ['First Name','Last Name','Company','Country','address','','State','City/Town','Postcode','Phone','Email'];
		$input_width = [$first, $last, $full, $full, $full, $full, $full, $full, $full, $full, $full];
		$placeholder = ['First Name','Last Name','Company','Country','Street address 1','Street address 2','State','City/Town','Postcode','Phone','Email'];
		$input_required = ['on','on','','on','on','','on','','on','','on'];
		$remove = ['','','','','','','','','','',''];
		$position = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
		 
		foreach($field_name as $key=>$field ){
			$sql = "INSERT INTO $checkout_field (`field_name`, `input_type`, `input_label`, `input_width`, `placeholder`, `input_required`, `input_remove`, `position`) VALUES ('$field', '$input_type[$key]', '$input_label[$key]', '$input_width[$key]', '$placeholder[$key]', '$input_required[$key]', '$remove[$key]', '$position[$key]')";

			$wpdb->query($sql);
		}	

		/**
		 * Shipping field table name
		 */
		$checkout_shipping_field = $wpdb->prefix . 'woo_manage_checkout_shipping_field';

		/**
		 * shipping field name
		 */
		$s_field_name = ['first name','last name','company','country','address 1','address 2','state','city','postcode'];
		$s_input_type = ['text','text','text','country','text','text','state','text','text',];
		$s_input_label = ['First Name','Last Name','Company','Country','Street address','','State','City/Town','Postcode'];
		$s_input_width = [$first, $last, $full, $full, $full, $full, $full, $full, $full];
		$s_placeholder = ['First Name','Last Name','Company','Country','Street address 1','Street address 2','State','City/Town','Postcode'];
		$s_input_required = ['on','on','','on','on','','on','','on'];
		$s_remove = ['','','','','','','','',''];
		$s_position = [1, 2, 3, 4, 5, 6, 7, 8, 9];
		foreach($s_field_name as $key=>$s_field ){

			$sql = "INSERT INTO $checkout_shipping_field (`s_field_name`, `s_input_type`, `s_input_label`, `s_input_width`, `s_placeholder`, `s_input_required`, `s_input_remove`, `s_position`) VALUES ('$s_field', '$s_input_type[$key]', '$s_input_label[$key]', '$s_input_width[$key]', '$s_placeholder[$key]', '$s_input_required[$key]', '$s_remove[$key]', '$s_position[$key]')";

			$wpdb->query($sql);

		}

		/**
		 * Order Note table name
		 */
		$checkout_order_note_field = $wpdb->prefix . 'woo_manage_checkout_order_note';

		/**
		 * Order note field name
		 */
		$o_field_name = ['comments'];
		$o_input_type = ['textarea'];
		$o_input_label = ['Order Notes'];
		$o_input_width = [$full];
		$o_placeholder = ['Notes About your order e.g. espicial notes for delivery'];
		$o_input_required = [''];
		$o_remove = [''];
		$o_position = [1];
		foreach($o_field_name as $key=>$o_field ){

			$sql = "INSERT INTO $checkout_order_note_field (`o_field_name`, `o_input_type`, `o_input_label`, `o_input_width`, `o_placeholder`, `o_input_required`, `o_input_remove`, `o_position`) VALUES ('$o_field', '$o_input_type[$key]', '$o_input_label[$key]', '$o_input_width[$key]', '$o_placeholder[$key]', '$o_input_required[$key]', '$o_remove[$key]', '$o_position[$key]')";

			$wpdb->query($sql);

		}
	}



}
