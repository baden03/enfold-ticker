<?php
/**
 * Plugin Name: Enfold Ticker
 * Plugin URI:  https://twinpictures.de
 * Description: Adds a Ticker element to the Enfold Advanced Layout Builder.
 * Version:     0.0.1
 * Author:      Twinpictures
 * Author URI:  https://twinpictures.de
 * License:     GPL-2.0
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: enfold-ticker
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ENFOLD_TICKER_VERSION', '0.0.1' );
define( 'ENFOLD_TICKER_PATH', plugin_dir_path( __FILE__ ) );
define( 'ENFOLD_TICKER_URL', plugin_dir_url( __FILE__ ) );

add_action( 'init', 'enfold_ticker_load_textdomain' );
function enfold_ticker_load_textdomain() {
	load_plugin_textdomain( 'enfold-ticker', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

// Tell Enfold's ALB loader to scan our includes/ directory for element files.
add_filter( 'avia_load_shortcodes', 'enfold_ticker_add_shortcode_path' );
function enfold_ticker_add_shortcode_path( $paths ) {
	$paths[] = ENFOLD_TICKER_PATH . 'includes/';
	return $paths;
}

add_action( 'wp_enqueue_scripts', 'enfold_ticker_register_assets' );
function enfold_ticker_register_assets() {
	wp_register_style(
		'enfold-ticker',
		ENFOLD_TICKER_URL . 'assets/css/enfold-ticker.css',
		array(),
		ENFOLD_TICKER_VERSION
	);
}
