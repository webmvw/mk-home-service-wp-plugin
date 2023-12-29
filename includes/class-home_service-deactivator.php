<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://webmkit.com
 * @since      1.0.0
 *
 * @package    Home_service
 * @subpackage Home_service/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Home_service
 * @subpackage Home_service/includes
 * @author     webmk <masudrana.bbpi@gmail.com>
 */
class Home_service_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		
		global $wpdb;

		// delete table when plugin deactivate
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}mk_service");
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}mk_booking_service");


		// delete page when plugin deactivate
		$get_data = $wpdb->get_row(
			$wpdb->prepare("SELECT ID FROM {$wpdb->prefix}posts WHERE post_name = %s", 'mk_home_service')
		); 
		$page_id = $get_data->ID;
		if($page_id > 0){
			wp_delete_post($page_id, true);
		}
	}

}
