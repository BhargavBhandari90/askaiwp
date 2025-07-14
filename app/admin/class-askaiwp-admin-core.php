<?php
/**
 * Admin settings for the plugin.
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
if ( ! class_exists( 'AskaiWP_Admin_Core' ) ) {

	/**
	 * Class for fofc core.
	 */
	class AskaiWP_Admin_Core {

		/**
		 * Constructor for class.
		 */
		public function __construct() {

			// Plugin's setting page.
			add_action( 'admin_menu', array( $this, 'askai_settings_page' ) );

			// Register settings fields.
			add_action( 'admin_init', array( $this, 'askai_register_settings' ) );
		}

		/**
		 * Add settings page.
		 *
		 * @return void
		 */
		public function askai_settings_page() {
			add_submenu_page(
				'options-general.php',
				esc_html__( 'AskaiWP Settings', 'askaiwp' ),
				esc_html__( 'AskaiWP', 'askaiwp' ),
				'manage_options',
				'askaiwp',
				array( $this, 'askai_admin_settings' ),
				80
			);
		}

		/**
		 * Settings fields.
		 *
		 * @return void
		 */
		public function askai_admin_settings() {
			?>
			<div class="wrap">
				<h1><?php esc_html_e( 'AskaiWP Settings', 'askaiwp' ); ?></h1>
				<form method="post" action="options.php" novalidate="novalidate">
					<?php settings_fields( 'askaiwp_settings' ); ?>
					<table class="form-table" role="presentation">
					<?php do_settings_sections( 'askaiwp' ); ?>
					</table>
					<?php submit_button(); ?>
				</form>
			</div>
			<?php
		}

		/**
		 * Register setting fields.
		 *
		 * @return void
		 */
		public function askai_register_settings() {

			register_setting( 'askaiwp_settings', 'askaiwp_setting' );

			// General Section.
			add_settings_section(
				'askaiwp_settings_general_section',
				esc_html__( 'General', 'askaiwp' ),
				array( $this, 'askai_setting_section_cb' ),
				'askaiwp',
				array(
					'description' => esc_html__( 'General Setting for AI Chatbox.', 'askaiwp' ),
				)
			);

			// General section fields.
			add_settings_field(
				'ai_name',
				esc_html__( 'AI Name', 'askaiwp' ),
				array( $this, 'askai_setting_field_callback' ),
				'askaiwp',
				'askaiwp_settings_general_section',
				array(
					'name'        => 'ai_name',
					'class'       => 'regular-text',
					'type'        => 'text',
					'description' => __( 'Give name to your AI', 'askaiwp' ),
				)
			);

			// Gemini AI Section.
			add_settings_section(
				'askaiwp_settings_gemini_section',
				esc_html__( 'Gemini AI', 'askaiwp' ),
				array( $this, 'askai_setting_section_cb' ),
				'askaiwp',
				array(
					'description' => esc_html__( 'Gemini Settings for your AI Chatbox.', 'askaiwp' ),
				)
			);

			// Gemini AI fields.
			add_settings_field(
				'gemini_api_key',
				esc_html__( 'API key', 'askaiwp' ),
				array( $this, 'askai_setting_field_callback' ),
				'askaiwp',
				'askaiwp_settings_gemini_section',
				array(
					'name'        => 'gemini_api_key',
					'class'       => 'regular-text',
					'type'        => 'password',
					'description' => __( 'Get Gemini key from <a href="https://aistudio.google.com/app/apikey" target="_blank">here</a>' ),
				)
			);

			add_settings_field(
				'gemini_model',
				esc_html__( 'Model', 'askaiwp' ),
				array( $this, 'askai_setting_field_callback' ),
				'askaiwp',
				'askaiwp_settings_gemini_section',
				array(
					'name'        => 'gemini_model',
					'class'       => 'regular-text',
					'type'        => 'select',
					'options'     => $this->askai_gemini_models(),
					'description' => esc_html__( 'Select model as per your choice. If you don\'t know what to choose, set "Gemini 1.5 Flash". SAVE API KEY first if you DON\'T see the mode list.', 'askaiwp' ),
				)
			);

			add_settings_field(
				'gemini_prompt',
				esc_html__( 'Prompt', 'askaiwp' ),
				array( $this, 'askai_setting_field_callback' ),
				'askaiwp',
				'askaiwp_settings_gemini_section',
				array(
					'name'        => 'gemini_prompt',
					'class'       => 'large-text',
					'type'        => 'textarea',
					'description' => esc_html__( 'Set prompt for Gemini.', 'askaiwp' ),
				)
			);
		}

		/**
		 * Settings description.
		 *
		 * @param  array $args array of settings parameters.
		 * @return void
		 */
		public function askai_setting_section_cb( $args ) {
			echo wp_sprintf(
				'<p>%1$s</p>',
				wp_kses_post( $args['description'] )
			);
		}

		/**
		 * Display fields.
		 *
		 * @param array $args array of settings.
		 * @return void
		 */
		public function askai_setting_field_callback( $args ) {

			$field_name = $args['name'];
			$settings   = get_option( 'askaiwp_setting' );
			$value      = isset( $settings[ $field_name ] ) ? $settings[ $field_name ] : '';
			$class      = $args['class'];

			switch ( $args['type'] ) {

				case 'text':
				case 'password':
					echo wp_sprintf(
						'<input type="%s" name="askaiwp_setting[%s]" value="%s" class="%s" /><p class="description">%s</p>',
						$args['type'],
						esc_attr( $field_name ),
						esc_attr( $value ),
						esc_attr( $class ),
						wp_kses_post( $args['description'] )
					);
					break;

				case 'textarea':
					echo wp_sprintf(
						'<textarea name="askaiwp_setting[%s]" class="%s" rows="5" cols="50">%s</textarea><p class="description">%s</p>',
						esc_attr( $field_name ),
						esc_attr( $class ),
						esc_textarea( $value ),
						wp_kses_post( $args['description'] )
					);
					break;

				case 'select':
					$options = $args['options'];
					?>
					<select
						id="<?php echo esc_attr( $field_name ); ?>"
						name="askaiwp_setting[<?php echo esc_attr( $field_name ); ?>]"
					>
						<option value="">
							<?php esc_html_e( 'Select Option', 'askaiwp' ); ?>
						</option>
						<?php foreach ( $options as $key => $option ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>"
								<?php echo ! empty( $value ) ? ( selected( $value, $key, false ) ) : ( '' ); ?>
							>
								<?php echo esc_html( $option ); ?>
							</option>
						<?php endforeach; ?>
					</select>
					<p class="description">
						<?php echo esc_html( $args['description'] ); ?>
					</p>
					<?php
					break;
			}
		}

		/**
		 * Retrieves a list of available Gemini AI models from the Google Cloud API.
		 *
		 * @return array|false The list of available Gemini AI models or false if an error occurred.
		 *                     Returns false if the API key is empty.
		 */
		public function askai_gemini_models() {

			$options = get_option( 'askaiwp_setting' );

			$api_key = ! empty( $options['gemini_api_key'] )
				? $options['gemini_api_key']
				: '';

			if ( empty( $api_key ) ) {
				return false;
			}

			$models = get_transient( 'askaiwp_gemini_models' );

			if ( ! empty( $models ) ) {
				return $models;
			}

			$url = 'https://generativelanguage.googleapis.com/v1/models?key=' . $api_key;

			$response = wp_remote_get( $url );

			if ( is_wp_error( $response ) ) {
				return false;
			}

			$body   = json_decode( wp_remote_retrieve_body( $response ), true );
			$models = ! empty( $body['models'] ) ? $body['models'] : false;
			$models = wp_list_pluck( $models, 'displayName', 'name' );

			set_transient( 'askaiwp_gemini_models', $models, 60 * 60 * 24 );

			return $models;
		}
	}

	new AskaiWP_Admin_Core();
}
