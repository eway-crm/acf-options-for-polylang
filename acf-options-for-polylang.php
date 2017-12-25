<?php

/*
 Plugin Name: BEA - Polylang's ACF Option page
 Version: 1.0.1
 Plugin URI: http://www.beapi.fr
 Description: Add ACF options page support for Polylang
 Author: BE API Technical team
 Author URI: http://www.beapi.fr
 Domain Path: languages
 Text Domain: acf-options-for-polylang
 
 ----
 
 Copyright 2016 BE API Technical team (human@beapi.fr)
 
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

class BEA_ACF_For_Polylang {

	function __construct() {
		// Set Polylang current lang
		add_filter( 'acf/settings/current_language', [ $this, 'get_current_site_lang' ] );

		// Load default Polylang's option page value
		add_filter( 'acf/load_value', [ $this, 'set_default_value' ], 10, 3 );
	}

	/**
	 * Get the current Polylang's locale or the wp's one
	 *
	 * @author Maxime CULEA
	 *
	 * @return bool|string
	 */
	public function get_current_site_lang() {
		return function_exists( 'pll_current_language' ) ? pll_current_language( 'locale' ) : get_locale();
	}

	/**
	 * Load default value in front, if none found for an acf option
	 *
	 * @author Maxime CULEA
	 *
	 * @param $value
	 * @param $post_id
	 * @param $field
	 *
	 * @return mixed|string|void
	 */
	public function set_default_value( $value, $post_id, $field ) {
		if ( is_admin() || ! self::is_option_page( $post_id ) ) {
			return $value;
		}

		/**
		 * According to his type, check the value to be not an empty string.
		 * While false or 0 could be returned, so "empty" method could not be here useful.
		 *
		 * @see   https://github.com/atomicorange : Thx to atomicorange for the issue
		 *
		 * @since 1.0.1
		 */
		if ( ! is_null( $value ) ) {
			if ( is_array( $value ) ) {
				// Get from array all the not empty strings
				$is_empty = array_filter( $value, function ( $value_c ) {
					return "" !== $value_c;
				} );

				if ( ! empty( $is_empty ) ) {
					// Not an array of empty values
					return $value;
				}
			} else {
				if ( "" !== $value ) {
					// Not an empty string
					return $value;
				}
			}
		}

		/**
		 * Delete filters for loading "default" Polylang saved value
		 * and for avoiding infinite looping on current filter
		 */
		remove_filter( 'acf/settings/current_language', [ $this, 'get_current_site_lang' ] );
		remove_filter( 'acf/load_value', [ $this, 'set_default_value' ] );

		/**
		 * Generate the all language option's post_id key
		 *
		 * @since  1.0.2
		 * @author Maxime CULEA
		 */
		$all_language_post_id = str_replace( sprintf( '_%s', pll_current_language( 'locale' ) ), '', $post_id );

		// Get the "All language" value
		$value = acf_get_metadata( $all_language_post_id, $field['name'] );

		/**
		 * Re-add deleted filters
		 */
		add_filter( 'acf/settings/current_language', [ $this, 'get_current_site_lang' ] );
		add_filter( 'acf/load_value', [ $this, 'set_default_value' ], 10, 3 );

		return $value;
	}

	/**
	 * Get all registered options pages as array [ post_id => page title ]
	 *
	 * @since  1.0.3
	 * @author Maxime CULEA
	 *
	 * @return array|mixed|void
	 */
	function get_option_page_ids() {
		$rule          = [
			'param'    => 'options_page',
			'operator' => '==',
			'value'    => 'acf-options',
			'id'       => 'rule_0',
			'group'    => 'group_0',
		];
		$rule          = acf_get_valid_location_rule( $rule );
		$options_pages = acf_get_location_rule_values( $rule );

		return empty( $options_pages ) ? [] : array_keys( $options_pages );
	}

	/**
	 * Check if the given post id is from an options page or not
	 *
	 * @param string $post_id
	 *
	 * @since 1.0.2
	 * @author Maxime CULEA
	 *
	 * @return bool
	 */
	function is_option_page( $post_id ) {
		if ( false !== strpos( $post_id, 'options' ) ) {
			return true;
		}

		$options_pages = $this->get_option_page_ids();
		if ( ! empty( $options_pages ) && in_array( $post_id, $options_pages ) ) {
			return true;
		}

		return false;
	}
}

/**
 * Load at plugins loaded to ensure ACF is used
 *
 * @since  1.0.2
 * @author Maxime CULEA
 */
add_action( 'plugins_loaded', function () {
	if ( ! function_exists( 'get_field' ) || ! function_exists( 'pll_current_language' ) ) {
		return;
	}
	new BEA_ACF_For_Polylang();
} );