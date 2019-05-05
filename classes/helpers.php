<?php

namespace BEA\ACF_Options_For_Polylang;

class Helpers {
	/**
	 * Get the original option id without language attributes
	 *
	 * @param $post_id
	 *
	 * @return string
	 * @since  1.0.4
	 *
	 * @author Maxime CULEA
	 */
	public static function original_option_id( $post_id ) {
		// Check if is an object.
		// Todo user case.
		if ( is_object( $post_id ) ) {
			// Apply for all cases.
			switch ( get_class( $post_id ) ) {
				case 'WP_Term':
					$post_id = $post_id->taxonomy . '_' . $post_id->term_id;
					break;
				case 'WP_Comment':
					$post_id = 'comment_' . $post_id->comment_ID;
					break;
				case 'WP_Post':
					$post_id = $post_id->ID;
					break;
			}
		}

		return str_replace( sprintf( '_%s', pll_current_language( 'locale' ) ), '', $post_id );
	}


	/**
	 * Check if the given post id is from an options page or not
	 *
	 * @param string $post_id
	 *
	 * @return bool
	 * @author Maxime CULEA
	 *
	 * @since  1.0.2
	 */
	public static function is_option_page( $post_id ) {
		$post_id = self::original_option_id( $post_id );
		if ( false !== strpos( $post_id, 'option' ) ) {
			return true;
		}

		$options_pages = self::get_option_page_ids();

		return ! empty( $options_pages ) && in_array( $post_id, $options_pages );
	}

	/**
	 * Get all registered options pages as array [ post_id => page title ]
	 *
	 * @return array
	 * @author Maxime CULEA
	 *
	 * @since  1.0.2
	 */
	public static function get_option_page_ids() {
		return wp_list_pluck( acf_options_page()->get_pages(), 'post_id' );
	}
}
