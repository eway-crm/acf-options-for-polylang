<?php namespace BEA\ACF_Options_For_Polylang;

class Helpers {
	/**
	 * Get the original option id without language attributes
	 *
	 * @param $post_id
	 *
	 * @author Maxime CULEA
	 *
	 * @since  next
	 *
	 * @return string
	 */
	public static function original_option_id( $post_id ) {
		return str_replace( sprintf( '_%s', pll_current_language( 'locale' ) ), '', $post_id );
	}
}
