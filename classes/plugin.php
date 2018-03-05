<?php namespace BEA\ACF_Options_For_Polylang;

/**
 * The purpose of the plugin class is to have the methods for
 *  - activation actions
 *  - deactivation actions
 *  - uninstall actions
 *
 * Class Plugin
 * @package test
 */
class Plugin {
	/** Use the trait */
	use Singleton;

	public function init() {
		// Plugin activate/deactivate hooks
		register_activation_hook( BEA_ACF_OPTIONS_MAIN_FILE_DIR, [ $this, 'activate' ] );
		register_deactivation_hook( BEA_ACF_OPTIONS_MAIN_FILE_DIR, [ $this, 'deactivate' ] );
	}

	public static function activate() { die('activate');
		if ( ! function_exists( 'acf' ) || ! function_exists( 'pll_current_language' ) ) {
			self::display_error( __( 'Advanced Custom Fields and Polylang are required plugins.', 'bea-acf-options-for-polylang') );
			return false;
		}

		if ( '5.6.0' > acf()->version ) {
			self::display_error( __( 'Advanced Custom Fields should be on version 5.6.0 or above.', 'bea-acf-options-for-polylang' ) );
			return false;
		};

		return true;
	}

	public static function deactivate() {}

	public static function display_error( $message ) {
		printf( '<div class="error"><p>%s</p></div>', $message );
	}
}