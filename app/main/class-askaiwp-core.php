<?php
/**
 * Class for custom work.
 *
 * @package Askai
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If class is exist, then don't execute this.
if ( ! class_exists( 'AskaiWP_Core' ) ) {

	/**
	 * Class for fofc core.
	 */
	class AskaiWP_Core {

		/**
		 * Constructor for class.
		 */
		public function __construct() {

			$files = array(
				'app/main/class-custom-actions-filters',
			);

			foreach ( $files as $file ) {
				// Include functions file.
				if ( file_exists( ASKAI_PATH . $file . '.php' ) ) {
					require ASKAI_PATH . $file . '.php';
				}
			}

			// Add custom style and script.
			add_action( 'wp_enqueue_scripts', array( $this, 'askai_enqueue_style_script' ) );

			add_action( 'wp_footer', array( $this, 'askaiwp_add_chat_container' ) );
		}


		public function askai_enqueue_style_script() {

			$css_file = 'plugin.min.css';

			if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
				$css_file = 'plugin.css';
			}

			// Custom plugin script.
			wp_enqueue_style(
				'askaiwp-style',
				ASKAI_URL . 'assets/css/' . $css_file,
				'',
				ASKAI_VERSION
			);

			// Automatically load imported dependencies and assets version.
			$asset_file = include trailingslashit( ASKAI_PATH ) . 'build/index.asset.php';

			// Custom plugin script.
			wp_enqueue_script(
				'askaiwp-script',
				ASKAI_URL . 'build/index.js',
				$asset_file['dependencies'],
				$asset_file['version'],
				true
			);

			$args = array(
				'settings' => get_option( 'askaiwp_setting' ),
			);

			wp_localize_script(
				'askaiwp-script',
				'AskaiWP',
				$args
			);
		}

		/**
		 * Container for AI Chatbox.
		 *
		 * @return void
		 */
		public function askaiwp_add_chat_container() {
			echo '<div id="askaiwp-root"></div>';
		}
	}

	new AskaiWP_Core();
}
