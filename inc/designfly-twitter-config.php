<?php
class DESIGNfly_Twitter_Configuration {
	/**
	 * Twitter Oauth URL with return url.
	 *
	 * @var string
	 */
	private $twitter_oauth_url = 'https://api.smashballoon.com/twitter-login.php?return_uri=';

	/**
	 * Constructor, registering hooks.
	 */
	public function __construct() {
		// Setting default global consumer key and secret.
		global $designfly_consumer_key, $designfly_consumer_secret;
		$designfly_consumer_key    = 'FPYSYWIdyUIQ76Yz5hdYo5r7y';
		$designfly_consumer_secret = 'GqPj9BPgJXjRKIGXCULJljocGPC62wN2eeMSnmZpVelWreFk9z';

		// Adds menu item on top level menu.
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		// Registers settings, sections and fields.
		add_action( 'admin_init', array( $this, 'options_page_init' ) );
	}

	/**
	 * Add top level menu on wp-admin.
	 */
	public function add_menu() {
		add_menu_page(
			'DESIGNfly Twitter',
			'DESIGNfly Twitter',
			'manage_options',
			'designfly-twitter-configuration',
			array( $this, 'create_options_page' ),
			'',
			99
		);
	}

	/**
	 * Content for settings page.
	 */
	public function create_options_page() {
		// Stop if the user doesn't have this capability.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// To correct notice bar.
		echo '<div class="wrap">';
        // phpcs:disable
        // PHPCS is disabled because it gives nonce verification error.
        // The settings section/field already adds a nonce so there's no point of adding another one.

		if ( isset( $_GET['settings-updated'] ) ) {
			// Add settings saved message with the class of "updated".
			add_settings_error( 'designfly_messages', 'designfly_messages', __( 'Settings Saved', 'designfly' ), 'updated' );
		}

		// Show error/update messages.
		settings_errors( 'designfly_messages' );

        
		?>
		<form action="options.php" method="post">
            <?php
			// output security fields for the registered setting "wporg".
			settings_fields( 'designfly-twitter-configuration' );
			// output setting sections and their fields.
			// (sections are registered for "wporg", each field is registered to a specific section).
			do_settings_sections( 'designfly-twitter-configuration' );
			// output save settings button.
			submit_button( __( 'Save Settings', 'designfly' ) );
			?>
        </form>
        <?php
		// phpcs:enable
		echo '</div>';
	}

	/**
	 * Hooked to admin_init action hook.
	 * Registers settings, sections and setting fields.
	 */
	public function options_page_init() {
		// Manually redirecting to designfly-twitter-configuration page to remove query string when
		// Returning from twitter auth page.
		$page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );
		if ( 'designfly-twitter-configuration' === $page ) {
			$oauth_token        = filter_input( INPUT_GET, 'oauth_token', FILTER_SANITIZE_STRING );
			$oauth_token_secret = filter_input( INPUT_GET, 'oauth_token_secret', FILTER_SANITIZE_STRING );

			if ( ! empty( $oauth_token_secret ) && ! empty( $oauth_token ) ) {
				// If saved option is same as returned token and secret, then redirect.
				if ( get_option( 'designfly_oauth_token' ) === $oauth_token && get_option( 'designfly_oauth_token_secret' ) === $oauth_token_secret ) {
					wp_safe_redirect( admin_url( 'admin.php?page=designfly-twitter-configuration' ) );
					exit;
				}
			}
		}

		// Settings arguments.
		$args = array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => '',
		);

		// Registering individual settings.
		register_setting( 'designfly-twitter-configuration', 'designfly_consumer_key', $args );
		register_setting( 'designfly-twitter-configuration', 'designfly_consumer_secret', $args );
		register_setting( 'designfly-twitter-configuration', 'designfly_oauth_token', $args );
		register_setting( 'designfly-twitter-configuration', 'designfly_oauth_token_secret', $args );
		register_setting( 'designfly-twitter-configuration', 'designfly_screen_name', $args );

		// All settings are under this section.
		add_settings_section( 'designfly-twitter-configuration', __( 'Twitter Configuration', 'designfly' ), array( $this, 'section_callback' ), 'designfly-twitter-configuration' );

		// Defining settings fields.
		$setting = 'designfly_consumer_key';
		add_settings_field( $setting, __( 'Consumer Key', 'designfly' ), array( $this, 'field_callback' ), 'designfly-twitter-configuration', 'designfly-twitter-configuration', array( 'setting' => $setting ) );
		$setting = 'designfly_consumer_secret';
		add_settings_field( $setting, __( 'Consumer Secret', 'designfly' ), array( $this, 'field_callback' ), 'designfly-twitter-configuration', 'designfly-twitter-configuration', array( 'setting' => $setting ) );
		$setting = 'designfly_oauth_token';
		add_settings_field( $setting, __( 'Access Token', 'designfly' ), array( $this, 'field_callback' ), 'designfly-twitter-configuration', 'designfly-twitter-configuration', array( 'setting' => $setting ) );
		$setting = 'designfly_oauth_token_secret';
		add_settings_field( $setting, __( 'Access Token Secret', 'designfly' ), array( $this, 'field_callback' ), 'designfly-twitter-configuration', 'designfly-twitter-configuration', array( 'setting' => $setting ) );
		$setting = 'designfly_screen_name';
		add_settings_field( $setting, __( 'Screen Name', 'designfly' ), array( $this, 'field_callback' ), 'designfly-twitter-configuration', 'designfly-twitter-configuration', array( 'setting' => $setting ) );
	}

	/**
	 * Callback function for registered section - designfly-twitter-configuration.
	 */
	public function section_callback() {
		// Show retrieve access token button for automatic retrieval.
		$this->retrive_access_token_secret();
	}

	/**
	 * HTML for automatic access token and secret retrieval button.
	 */
	private function retrive_access_token_secret() {
		$oauth_token = filter_input( INPUT_GET, 'oauth_token', FILTER_SANITIZE_STRING );
		$error       = filter_input( INPUT_GET, 'error', FILTER_SANITIZE_STRING );

		?>
		<div id="designfly-twitter-token-generation">

			<?php if ( ! empty( $error ) && empty( $oauth_token ) ) : ?>
				<p class="ctf_notice"><?php esc_html_e( 'There was an error with retrieving your access tokens. Please <a href="https://smashballoon.com/custom-twitter-feeds/token/" target="_blank">use this tool</a> to get your access token and secret.', 'designfly' ); ?></p><br>
			<?php endif; ?>
			<a target="_blank" href="<?php echo esc_url( $this->twitter_oauth_url . admin_url( 'admin.php?page=designfly-twitter-configuration' ) ); ?>" id="ctf-get-token">
				<span class="dashicons dashicons-twitter"></span>
				<?php esc_html_e( 'Log in to Twitter and get Access Token and Secret', 'designfly' ); ?>
				<h3 class="designfly-hidden-notice"><?php echo esc_html__( '  (This will overwrite existing configurations.)', 'designfly' ); ?></h3>
			</a>

		</div>
		<?php

		if ( ! empty( $oauth_token ) ) {
			?>
			<h3 class="designfly-config-warning"><?php echo esc_html__( 'Please save the settings.', 'designfly' ); ?></h3>
			<?php
		}
	}

	/**
	 * Callback function for all setting fields.
	 *
	 * @param Array $args Arguments passed while registering settings field.
	 */
	public function field_callback( $args ) {
		// Remove designfly_ from setting name to get match query string data.
		$setting = filter_input( INPUT_GET, explode( 'designfly_', $args['setting'] )[1], FILTER_SANITIZE_STRING );

		if ( empty( $setting ) ) {
			$setting = get_option( $args['setting'] );
		}

		$placeholder = 'placeholder="';

		// Show placeholder for consumer key and secret.
		if ( 'designfly_consumer_key' === $args['setting'] || 'designfly_consumer_secret' === $args['setting'] ) {
			$placeholder .= esc_attr__( 'Keep empty to use default.', 'designfly' );
		}

		$placeholder .= '"';

		?>
		<input <?php echo $placeholder; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> size="57" type="text" name="<?php echo esc_attr( $args['setting'] ); ?>" value="<?php echo ( empty( $setting ) ? '' : esc_attr( $setting ) ); ?>">
		<?php
	}


}
