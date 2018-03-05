<?php

/*
 Plugin Name: BEA - ACF Options for Polylang
 Version: 1.1.0
 Plugin URI: https://github.com/BeAPI/acf-options-for-polylang
 Description: Add ACF options page support for Polylang.
 Author: Be API Technical team
 Author URI: https://beapi.fr
 Contributors: Maxime Culea
 ----
 Copyright 2017 Be API Technical team (human@beapi.fr)
 */


// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Plugin constants
define( 'BEA_ACF_OPTIONS_FOR_POLYLANG_VERSION', '1.1.0' );
define( 'BEA_ACF_OPTIONS_FOR_POLYLANG_MIN_PHP_VERSION', '5.6' );

// Plugin URL and PATH
define( 'BEA_ACF_OPTIONS_FOR_POLYLANG_URL', plugin_dir_url( __FILE__ ) );
define( 'BEA_ACF_OPTIONS_FOR_POLYLANG_DIR', plugin_dir_path( __FILE__ ) );
define( 'BEA_ACF_OPTIONS_MAIN_FILE_DIR', __FILE__ );
define( 'BEA_ACF_OPTIONS_FOR_POLYLANG_PLUGIN_DIRNAME', basename( rtrim( dirname( __FILE__ ), '/' ) ) );

// Check PHP min version
if ( version_compare( PHP_VERSION, BEA_CPT_AGENT_MIN_PHP_VERSION, '<' ) ) {
	require_once( BEA_CPT_AGENT_DIR . 'compat.php' );

	// possibly display a notice, trigger error
	add_action( 'admin_init', array( 'BEA\CPT_Agent\Compatibility', 'admin_init' ) );

	// stop execution of this file
	return;
}

/**
 * Autoload all the things \o/
 */
require_once BEA_ACF_OPTIONS_FOR_POLYLANG_DIR . 'autoload.php';

BEA\ACF_Options_For_Polylang\Plugin::get_instance();

/**
 * Load at plugins loaded to ensure ACF and Polylang are used
 *
 * @since  1.0.2
 * @author Maxime CULEA
 */
add_action( 'plugins_loaded', function () {
	\BEA\ACF_Options_For_Polylang\Main::get_instance();
} );