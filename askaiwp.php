<?php
/**
 * Plugin Name:     AskaiWP
 * Description:     Summarize, explain, and chat — directly on your WordPress site.
 * Author:          Bili Plugins
 * Author URI:      https://example.com/
 * Text Domain:     askaiwp
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         Askai
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main file, contains the plugin metadata and activation processes
 *
 * @package    Askai
 */
if ( ! defined( 'ASKAI_VERSION' ) ) {
	/**
	 * The version of the plugin.
	 */
	define( 'ASKAI_VERSION', '1.0.0' );
}

if ( ! defined( 'ASKAI_PATH' ) ) {
	/**
	 *  The server file system path to the plugin directory.
	 */
	define( 'ASKAI_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'ASKAI_URL' ) ) {
	/**
	 * The url to the plugin directory.
	 */
	define( 'ASKAI_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'ASKAI_BASE_NAME' ) ) {
	/**
	 * The url to the plugin directory.
	 */
	define( 'ASKAI_BASE_NAME', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'ASKAI_MAIN_FILE' ) ) {
	/**
	 * The url to the plugin directory.
	 */
	define( 'ASKAI_MAIN_FILE', __FILE__ );
}

/**
 * Include files.
 */
$files = array(
	'app/includes/common-functions',
	'app/main/class-askaiwp-core',
	'app/admin/class-askaiwp-admin-core',
);

if ( ! empty( $files ) ) {

	foreach ( $files as $file ) {

		// Include functions file.
		if ( file_exists( ASKAI_PATH . $file . '.php' ) ) {
			require ASKAI_PATH . $file . '.php';
		}
	}
}

/**
 * Plugin Setting page.
 *
 * @param array $links Array of plugin links.
 * @return array Array of plugin links.
 */
function askai_settings_link( $links ) {

	$settings_link = sprintf(
		'<a href="%1$s">%2$s</a>',
		'admin.php?page=askaiwp',
		esc_html__( 'Settings', 'askaiwp' )
	);

	array_unshift( $links, $settings_link );

	return $links;
}

add_filter( 'plugin_action_links_' . ASKAI_BASE_NAME, 'askai_settings_link' );

/**
 * Apply translation file as per WP language.
 */
function askai_text_domain_loader() {

	// Get mo file as per current locale.
	$mofile = ASKAI_PATH . 'languages/askaiwp-' . get_locale() . '.mo';

	// If file does not exists, then apply default mo.
	if ( ! file_exists( $mofile ) ) {
		$mofile = ASKAI_PATH . 'languages/askaiwp-default.mo';
	}

	if ( file_exists( $mofile ) ) {
		load_textdomain( 'askaiwp', $mofile );
	}
}

add_action( 'plugins_loaded', 'askai_text_domain_loader' );
