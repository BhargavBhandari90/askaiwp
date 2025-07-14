<?php // phpcs:ignore
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
if ( ! class_exists( 'Askai_Actions_Filters' ) ) {

	/**
	 * Class for custom actions and filters.
	 */
	class Askai_Actions_Filters {

		/**
		 * Constructor for class.
		 */
		public function __construct() {
			// Hook goes here.
		}
	}

	new Askai_Actions_Filters();
}
