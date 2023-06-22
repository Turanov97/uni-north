<?php
/**
 * BP SportsPress Template Tags
 *
 * @package BP_SportsPress
 * @subpackage Template
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Output the sportspress component slug.
 */
function bp_sportspress_slug() {
	echo bp_get_sportspress_slug();
}
/**
 * Return the sportspress component slug.
 *
 * @return string
 */
function bp_get_sportspress_slug() {

	/**
	 * Filters the sportspress component slug.
	 *
	 * @param string $slug SportsPress component slug.
	 */
	return apply_filters( 'bp_get_sportspress_slug', buddypress()->sportspress->slug );
}
