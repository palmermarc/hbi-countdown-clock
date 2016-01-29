<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           HBI_Countdown_Clock
 *
 * @wordpress-plugin
 * Plugin Name:       HBI Countdown Clock
 * Plugin URI:        http://example.com/hbi-countdown-clock-uri/
 * Description:       HBI Countdown Clock allows sites to add responsive countdown clocks to their site for advertisement purposes.
 * Version:           1.0.0
 * Author:            Marc Palmer
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       hbi-countdown-clock
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-hbi-countdown-clock-activator.php
 */
function activate_hbi_countdown_clock() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-hbi-countdown-clock-activator.php';
	HBI_Countdown_Clock_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-hbi-countdown-clock-deactivator.php
 */
function deactivate_hbi_countdown_clock() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-hbi-countdown-clock-deactivator.php';
	HBI_Countdown_Clock_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_hbi_countdown_clock' );
register_deactivation_hook( __FILE__, 'deactivate_hbi_countdown_clock' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-hbi-countdown-clock.php';

require_once( 'github-plugin-updater.php' );
if( is_admin() ) {
    new GitHubPluginUpdater( __FILE__, 'palmermarc', "hbi-countdown-clock" );
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_hbi_countdown_clock() {

	$plugin = new HBI_Countdown_Clock();
	$plugin->run();

}
run_hbi_countdown_clock();
