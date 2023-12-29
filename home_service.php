<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://webmkit.com
 * @since             1.0.0
 * @package           Home_service
 *
 * @wordpress-plugin
 * Plugin Name:       MK Home Service
 * Plugin URI:        https://webmkit.com/mk_home_service
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            webmk
 * Author URI:        https://webmkit.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mk_home_service
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'HOME_SERVICE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-home_service-activator.php
 */
function activate_home_service() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-home_service-activator.php';
	Home_service_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-home_service-deactivator.php
 */
function deactivate_home_service() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-home_service-deactivator.php';
	Home_service_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_home_service' );
register_deactivation_hook( __FILE__, 'deactivate_home_service' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-home_service.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_home_service() {

	$plugin = new Home_service();
	$plugin->run();

}
run_home_service();
