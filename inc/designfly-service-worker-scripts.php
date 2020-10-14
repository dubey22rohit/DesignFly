<?php
/**
 * Custom settings page for twitter widget's configurations.
 * */
class DESIGNfly_Service_Worker_Scripts {
	public function __construct() {
		// Register for the frontend service worker.
		add_action( 'wp_front_service_worker', array( $this, 'register_frontend_service_worker_script' ) );
	}

	/**
	 * Registers custom service worker script on front-end.
	 *
	 * @param object $scripts Scripts object through which we register the script.
	 */
	public function register_frontend_service_worker_script( $scripts ) {

		// Register custom service worker script.
		$scripts->register(
			'designfly-frontend-sw', // Handle.
			array(
				'src' => get_template_directory_uri() . '/service-worker.js', // Source.
			)
		);

	}

}
