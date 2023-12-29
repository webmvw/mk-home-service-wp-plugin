<?php

/**
 * Fired during plugin activation
 *
 * @link       https://webmkit.com
 * @since      1.0.0
 *
 * @package    Home_service
 * @subpackage Home_service/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Home_service
 * @subpackage Home_service/includes
 * @author     webmk <masudrana.bbpi@gmail.com>
 */
class Home_service_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		if( ! function_exists('dbDelta') ){
			require_once(ABSPATH. 'wp-admin/includes/upgrade.php');
		}

		$mk_service_table_query = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}mk_service`(
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`title` varchar(250) DEFAULT NULL,
			`slug` varchar(250) DEFAULT NULL,
			`description` text DEFAULT NULL,
			`price` int(11) DEFAULT NULL,
			`discount` int(11) DEFAULT NULL,
			`image` varchar(250) DEFAULT NULL,
			`created_at` timestamp NOT NULL DEFAULT current_timestamp(),
			PRIMARY KEY (`id`)
		) $charset_collate";
		
		dbDelta( $mk_service_table_query );

		$mk_booking_service_table_query = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}mk_booking_service`(
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`bookingID` varchar(200) NOT NULL,
			`name` varchar(200) NOT NULL,
			`email` varchar(200) NOT NULL,
			`phone` varchar(200) NOT NULL,
			`address` varchar(200) NOT NULL,
			`service` varchar(200) NOT NULL,
			`service_date` DATE NOT NULL,
			`payment_status` varchar(200) NOT NULL,
			`status` varchar(200) NOT NULL,
			`created_at` timestamp NOT NULL DEFAULT current_timestamp(),
			PRIMARY KEY (`id`)
		) $charset_collate";

		dbDelta( $mk_booking_service_table_query );

		$insert_mk_service_table_query = "INSERT INTO {$wpdb->prefix}mk_service(title, description, price, discount) VALUES ('Kitchen Deep Cleaning', 'kitchen-deep-cleanig', 'dummy description', 111, 5)";
		$wpdb->query($insert_mk_service_table_query);



		/**
		 * Create page when plugin active
		 *
		 */
		$post_arr_data = array(
			'post_title' => 'Home Service',
			'post_name' => 'mk_home_service',
			'post_content' => '',
			'post_status' => 'publish',
			'post_author' => 1,
			'post_type' => 'page'
		);
		wp_insert_post( $post_arr_data );
	}

}
