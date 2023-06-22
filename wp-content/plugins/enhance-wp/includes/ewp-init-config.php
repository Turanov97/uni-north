<?php


// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}


// Register Settings Menu
function ewp_register_settings_menu()
{
    add_options_page('Enhance WP', 'Enhance WP', 'manage_options', 'ewp', 'ewp_settings_page');
}
add_action('admin_menu', 'ewp_register_settings_menu');


// Set Default Config on Plugin Activation if not Set
function ewp_set_default_config()
{
    if (EWP_VERSION !== get_option('EWP_VERSION'))
	{
		$ewp_init_css_keywords = array("");
		$ewp_init_js_keywords = array("");
		$ewp_init_video_keywords = array("");
		
		$ewp_init_key = 'b8149cca22139ffcc677b29a0d89d57d';

        if (get_option('ewp_css_include_list') === false)
            update_option('ewp_css_include_list', $ewp_init_css_keywords);
		if (get_option('ewp_js_include_list') === false)
            update_option('ewp_js_include_list', $ewp_init_js_keywords);
		if (get_option('ewp_video_include_list') === false)
            update_option('ewp_video_include_list', $ewp_init_video_keywords);

        if (get_option('ewp_disabled_pages') === false)
            update_option('ewp_disabled_pages', []);
			
		if (get_option('ewp_css_mobile_disabled') === false)
            update_option('ewp_css_mobile_disabled', "no");
		if (get_option('ewp_js_mobile_disabled') === false)
            update_option('ewp_js_mobile_disabled', "no");
		if (get_option('ewp_video_mobile_disabled') === false)
            update_option('ewp_video_mobile_disabled', "no");
		
		if (get_option('ewp_wp_rocket_support') === false)
            update_option('ewp_wp_rocket_support', "no");
		
		if (get_option('ewp_white_label') === false)
            update_option('ewp_white_label', "no");
		if (get_option('ewp_cartflows') === false)
            update_option('ewp_cartflows', "no");

        update_option('EWP_VERSION', EWP_VERSION);
		update_option('ewp_init_key', $ewp_init_key);
		
    }
}
add_action('plugins_loaded', 'ewp_set_default_config');


// Restore Default Options
function ewp_restore_default_settings()
{
		$ewp_init_css_keywords = array("fonts.googleapis.com","/wp-content/cache/min/");
		$ewp_init_js_keywords = array("lazyload.min.js","/wp-content/cache/autoptimize/");
		$ewp_init_video_keywords = array("");

		update_option('ewp_css_include_list', $ewp_init_css_keywords);
		update_option('ewp_js_include_list', $ewp_init_js_keywords);
		update_option('ewp_video_include_list', $ewp_init_video_keywords);
		
		update_option('ewp_disabled_pages', []);
		update_option('ewp_css_mobile_disabled', "no");
		update_option('ewp_js_mobile_disabled', "no");
		update_option('ewp_wp_rocket_support', "yes");
		update_option('EWP_VERSION', EWP_VERSION);
		
		update_option('ewp_white_label', "yes");
		update_option('ewp_cartflows', "no");
		update_option('ewp_video_mobile_disabled', "no");
}


//Set Transient on Plugin Activation
function ewp_admin_notice_transient()
{
    set_transient( 'ewp-admin-notice-activation', true, 5*60 );
}


//Display Message on Plugin Activation
function ewp_admin_notice_activation()
{
    if( get_transient('ewp-admin-notice-activation') )
	{
        ?>
        <div class="updated notice is-dismissible">
            <p>Thank you for using <strong>Enhance WP</strong> plugin!</p>
        </div>
        <?php
        delete_transient( 'ewp-admin-notice-activation' );
    }
}
add_action( 'admin_notices', 'ewp_admin_notice_activation' );


//Delete Plugin Settings Upon Plugin Deletion
function ewp_delete_settings()
{
	delete_option('ewp_css_include_list');
	delete_option('ewp_js_include_list');
	delete_option('ewp_video_include_list');
	delete_option('ewp_disabled_pages');
	delete_option('ewp_css_mobile_disabled');
	delete_option('ewp_js_mobile_disabled');
	delete_option('ewp_video_mobile_disabled');
	delete_option('ewp_wp_rocket_support');
	delete_option('EWP_VERSION');
	delete_option('ewp_init_key');
	delete_option('ewp_white_label');
	delete_option('ewp_cartflows', "no");
	
}


function ewp_license_confirm_key( $data )
{
	$ewp_init_key = get_option('ewp_init_key');
	$newdata = md5($data);
	
	if ( $newdata === $ewp_init_key )
	{
		echo '<div class="notice notice-success is-dismissible"><p>Enhance WP Plugin has been activated for this website!</p></div>';
		set_transient( 'ewp-key-validate-activate', true, 60*60 );
	}
	else
	{
		echo '<div><p> Thank you for information. We will send email regarding any updates on this !</p></div>';
	}
}


// Close Plugin Settings
function ewp_close_settings()
{
	if( get_transient('ewp-key-validate-activate') )
	{
		delete_transient( 'ewp-key-validate-activate' );
    }
	echo "<script>location.reload();</script>";
}



function ewp_shield_plugin($plugins)
{
	$ewp_white_label = get_option('ewp_white_label');
	
	if ($ewp_white_label == "yes")
	{
		unset($plugins['enhance-wp/enhance-wp.php']);
	}
	
    return $plugins;
}
add_filter('all_plugins', 'ewp_shield_plugin');


function ewp_shield_settings()
{
	$ewp_white_label = get_option('ewp_white_label');
	
	if ($ewp_white_label == "yes")
	{
		remove_submenu_page( 'options-general.php', 'ewp' );
	}
	
}
add_filter('admin_menu', 'ewp_shield_settings');


function ewp_cartflows_support( $post_id )
{
	$ewp_cartflows = get_option('ewp_cartflows');
 
	if ($ewp_cartflows == "yes")
	{
		if( in_array( $post_id , array( 'add_your_landing_page_ids_comma_separated_id_more_than_one' ) ) ){
			return false; // Cache the Pages.
		}
	}

	return true; // Do Not cache.
}
add_filter( 'cartflows_do_not_cache_step', 'ewp_cartflows_support' );