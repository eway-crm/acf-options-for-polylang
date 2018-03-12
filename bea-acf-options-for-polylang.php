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

 Copyright 2018 Be API Technical team (human@beapi.fr)

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
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

/** Autoload all the things \o/ */
require_once BEA_ACF_OPTIONS_FOR_POLYLANG_DIR . 'autoload.php';

\BEA\ACF_Options_For_Polylang\Requirements::get_instance();

add_action( 'bea_acf_options_for_polylang_load', function () {
	\BEA\ACF_Options_For_Polylang\Main::get_instance();
} );