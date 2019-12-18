<?php

/**
 * Plugin Name:       Woo Variation Grid
 * Plugin URI:        https://insigniacreative.co.uk
 * Description:       Display Woocommerce variations in a grid or table on any page using the shortcode.
 * Version:           1.0.0
 * Author:            Insignia Creative
 * Author URI:        https://insigniacreative.co.uk
 * Text Domain:       woo-variation-grid
 * Domain Path:       /languages
 * 
 * @package           Woo_Variation_Grid
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) { 
    exit; 
}

/**
 * Plugin Version
 */
define( 'WOO_VARIATION_GRID_VERSION', '1.0.0' );

/**
 * Runs during plugin activation
 */
function activate_woo_variation_grid() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-variation-grid-activator.php';
	Woo_Variation_Grid_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-variation-grid-deactivator.php
 */
function deactivate_woo_variation_grid() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-variation-grid-deactivator.php';
	Woo_Variation_Grid_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo_variation_grid' );
register_deactivation_hook( __FILE__, 'deactivate_woo_variation_grid' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-variation-grid.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 */
function run_woo_variation_grid() {

	$plugin = new Woo_Variation_Grid();
	$plugin->run();

}
run_woo_variation_grid();
