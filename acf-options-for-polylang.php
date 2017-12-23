<?php

/*
 Plugin Name: BEA - ACF Options for Polylang
 Version: 1.0.2
 Plugin URI: https://github.com/BeAPI/acf-options-for-polylang
 Description: Add ACF options page support for Polylang.
 Author: Be API Technical team
 Author URI: https://beapi.fr
 Contributors: Maxime Culea
 ----
 Copyright 2017 Be API Technical team (human@beapi.fr)
 */

class BEA_ACF_For_Polylang {

	function __construct() {
		// Set Polylang current lang
		add_filter( 'acf/settings/current_language', array( __CLASS__, 'get_current_site_lang' ) );

		// Load default Polylang's option page value
		add_filter( 'acf/load_value', array( __CLASS__, 'set_default_value' ), 10, 3 );
	}

	/**
	 * Get the current Polylang's locale or the wp's one
	 *
	 * @author Maxime CULEA
	 *
	 * @return bool|string
	 */
	public static function get_current_site_lang() {
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
	public static function set_default_value( $value, $post_id, $field ) {
		if ( ! is_admin() || ! function_exists( 'pll_current_language' ) ) {
			return $value;
		}

		$options_pages = self::get_option_page_ids();
		if ( empty( $options_pages ) || ! in_array( $post_id, $options_pages ) ) {
			return;
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
		remove_filter( 'acf/settings/current_language', array( __CLASS__, 'get_current_site_lang' ) );
		remove_filter( 'acf/load_value', array( __CLASS__, 'set_default_value' ) );

		$value = acf_get_metadata( $post_id, $field['name'] );

		/**
		 * Re-add deleted filters
		 */
		add_filter( 'acf/settings/current_language', array( __CLASS__, 'get_current_site_lang' ) );
		add_filter( 'acf/load_value', array( __CLASS__, 'set_default_value' ), 10, 3 );

		return $value;
	}

	/**
	 * Get all registered options pages as array [ post_id => page title ]
	 *
	 * @since  1.0.2
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
}

/**
 * Load at plugins loaded to ensure ACF is used
 *
 * @since  1.0.2
 * @author Maxime CULEA
 */
add_action( 'plugins_loaded', function () {
	if ( ! function_exists( 'get_field' ) ) {
		return;
	}
	new BEA_ACF_For_Polylang();
} );