<?php
/**
 * BP SportsPress Screens
 *
 * @package BP_SportsPress
 * @subpackage Screens
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Catches any visits to the "SportsPress (X)" tab on a users profile.
 *
 * @uses bp_core_load_template() Loads a template file.
 */
function bp_sportspress_screen_events() {
	global $bp;

	do_action( 'bp_sportspress_screen_events' );

	// ignore the template referenced here
	// 'members/single/events' is for older themes already using this template
	//
	// view bp_sportspress_load_template_filter() for more info
	bp_core_load_template( 'members/single/events' );
}


/** TEMPLATE LOADER ************************************************/

/**
 * BP SportsPress template loader.
 *
 * This function sets up BP SportsPress to use custom templates.
 *
 * If a template does not exist in the current theme, we will use our own
 * bundled templates.
 *
 * We're doing two things here:
 *  1) Support the older template format for themes that are using them
 *     for backwards-compatibility (the template passed in
 *     {@link bp_core_load_template()}).
 *  2) Route older template names to use our new template locations and
 *     format.
 *
 * View the inline doc for more details.
 *
 */
function bp_sportspress_load_template_filter( $found_template, $templates ) {
	global $bp;

	// Only filter the template location when we're on the sportspress component pages.

	$slug = bp_get_sportspress_slug();
	if ( ! bp_is_current_component( $slug ) )
		return $found_template;

	// $found_template is not empty when the older template files are found in the
	// parent and child theme
	//
	//  /wp-content/themes/YOUR-THEME/members/single/events.php
	//
	//
	// The older template files utilize a full template ( get_header() +
	// get_footer() ), which sucks for themes and theme compat.
	//
	// When the older template files are not found, we use our new template method,
	// which will act more like a template part.
	if ( empty( $found_template ) ) {
		// register our theme compat directory
		//
		// this tells BP to look for templates in our plugin directory last
		// when the template isn't found in the parent / child theme
		bp_register_template_stack( 'bp_sportspress_get_template_directory', 14 );

		// locate_template() will attempt to find the plugins.php template in the
		// child and parent theme and return the located template when found
		//
		// plugins.php is the preferred template to use, since all we'd need to do is
		// inject our content into BP
		//
		// note: this is only really relevant for bp-default themes as theme compat
		// will kick in on its own when this template isn't found
		$found_template = locate_template( 'members/single/plugins.php', false, false );

		// add our hook to inject content into BP
		//
		// note the new template name for our template part

		if( bp_is_current_action( 'events' ) ) {
			add_action( 'bp_template_content', create_function( '', "
			bp_get_template_part( 'members/single/events' );
		" ) );
		}

	}

	return apply_filters( 'bp_sportspress_load_template_filter', $found_template );
}
add_filter( 'bp_located_template', 'bp_sportspress_load_template_filter', 10, 2 );

/** UTILITY ********************************************************/

/**
 * Get the BP SportsPress template directory.
 *
 * @uses apply_filters()
 * @return string
 */
function bp_sportspress_get_template_directory() {
	return apply_filters( 'bp_sportspress_get_template_directory', constant( 'BP_SPORTSPRESS_DIR' ) . '/_inc/templates' );
}