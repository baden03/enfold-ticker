<?php
/**
 * Plugin Name: enfold-ticker
 * Description: Adds a Ticker element to the Enfold theme Advanced Layout Builder.
 * Version: 0.1.0
 * Author: Twinpictures
 * License: GPL-2.0
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: enfold-ticker
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 7.4
 *
 * @package enfold-ticker
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ENFOLD_TICKER_VERSION', '0.1.0' );
define( 'ENFOLD_TICKER_PATH', plugin_dir_path( __FILE__ ) );
define( 'ENFOLD_TICKER_URL', plugin_dir_url( __FILE__ ) );

/**
 * URL of the bundled ALB icon for the Ticker element.
 *
 * Override: `add_filter( 'enfold_ticker_alb_icon_url', function( $url ) { return 'https://.../icon.svg'; } );`
 *
 * @return string
 */
function enfold_ticker_get_alb_icon_url() {
	$url = ENFOLD_TICKER_URL . 'assets/images/ticker.svg';

	return (string) apply_filters( 'enfold_ticker_alb_icon_url', $url );
}

/**
 * Whether the Enfold parent theme (or a child) is active.
 *
 * @return bool
 */
function enfold_ticker_is_enfold_active() {
	$template = (string) wp_get_theme()->get_template();

	return 'enfold' === $template;
}

/**
 * Register frontend stylesheet; shortcode enqueues the handle.
 */
function enfold_ticker_register_styles() {
	$path = ENFOLD_TICKER_PATH . 'assets/css/enfold-ticker.css';
	$ver  = file_exists( $path ) ? (string) filemtime( $path ) : ENFOLD_TICKER_VERSION;

	wp_register_style(
		'enfold-ticker',
		ENFOLD_TICKER_URL . 'assets/css/enfold-ticker.css',
		array(),
		$ver
	);
}

add_action( 'wp_enqueue_scripts', 'enfold_ticker_register_styles' );

/**
 * Load plugin translations.
 */
function enfold_ticker_load_textdomain() {
	load_plugin_textdomain(
		'enfold-ticker',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages'
	);
}

add_action( 'init', 'enfold_ticker_load_textdomain' );

/**
 * Add this plugin’s shortcode directory to Enfold’s scan paths.
 *
 * Enfold discovers ALB elements by loading PHP files from paths provided via
 * the avia_load_shortcodes filter (same pattern as a theme’s /custom-elements/).
 * Relying on avia_builder_init alone is too late; the element will not register.
 *
 * @param array $paths List of absolute filesystem paths to shortcode class directories.
 * @return array
 */
function enfold_ticker_register_shortcode_path( $paths ) {
	if ( ! is_array( $paths ) ) {
		$paths = array();
	}

	$dir = ENFOLD_TICKER_PATH . 'shortcodes/';
	if ( is_dir( $dir ) ) {
		array_unshift( $paths, $dir );
	}

	return $paths;
}

add_filter( 'avia_load_shortcodes', 'enfold_ticker_register_shortcode_path', 15, 1 );

/**
 * Show a notice when the Enfold theme is not the active (parent) theme.
 */
function enfold_ticker_admin_notice_no_enfold() {
	if ( enfold_ticker_is_enfold_active() ) {
		return;
	}

	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	$ok_ids = array( 'dashboard', 'plugins', 'themes' );
	if ( ! $screen || ! in_array( (string) $screen->id, $ok_ids, true ) ) {
		return;
	}

	$message = esc_html__( 'enfold-ticker requires the Enfold theme to be installed and active. The Ticker element will not appear in the layout builder without it.', 'enfold-ticker' );

	printf(
		'<div class="notice notice-warning"><p>%s</p></div>',
		$message
	);
}

add_action( 'admin_notices', 'enfold_ticker_admin_notice_no_enfold' );
