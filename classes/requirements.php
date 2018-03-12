<?php namespace BEA\ACF_Options_For_Polylang;

class Requirements {

	use Singleton;

	public $satsify_requiremeents = true;

	/**
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'admin_init', [ $this, 'check_requirements' ] );
	}

	/**
	 * All about requirements checks
	 *
	 * @return bool
	 */
	public function check_requirements() {
		// Not on ajax
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			do_action( 'bea_acf_options_for_polylang_load' );
			return true;
		}

		// Check activation
		if ( ! current_user_can( 'activate_plugins' ) ) {
			do_action( 'bea_acf_options_for_polylang_load' );
			return true;
		}

		if ( version_compare( PHP_VERSION, BEA_ACF_OPTIONS_FOR_POLYLANG_MIN_PHP_VERSION, '<' ) ) {
			$this->display_error( sprintf( __( 'Plugin Boilerplate require PHP version %s or greater to be activated. Your server is currently running PHP version %s.', 'bea-acf-options-for-polylang' ), BEA_ACF_OPTIONS_FOR_POLYLANG_MIN_PHP_VERSION, PHP_VERSION ) );
			return false;
		}

		if ( ! function_exists( 'acf' ) || ! function_exists( 'pll_current_language' ) ) {
			$this->display_error( __( 'Advanced Custom Fields and Polylang are required plugins.', 'bea-acf-options-for-polylang') );
			return false;
		}

		if ( '5.6.0' > acf()->version ) {
			$this->display_error( __( 'Advanced Custom Fields should be on version 5.6.0 or above.', 'bea-acf-options-for-polylang' ) );
			return false;
		};

		do_action( 'bea_acf_options_for_polylang_load' );
		return true;
	}

	// Display message and handle errors
	public function display_error( $message ) {
		$this->satsify_requiremeents = false;

		trigger_error( $message );

		add_action( 'admin_notices', function () use ($message) {
			printf('<div class="notice error is-dismissible"><p>%s</p></div>', $message );
		} );

		// Deactive self
		deactivate_plugins( BEA_ACF_OPTIONS_MAIN_FILE_DIR );
		unset( $_GET['activate'] );
	}
}