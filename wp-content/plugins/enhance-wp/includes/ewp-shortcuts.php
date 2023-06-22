<?php


// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}


// Rearrange Settings Links
function ewp_rearrange_settings_links($links)
{
    $plugin_shortcuts = array(
        '<a href="'.admin_url("options-general.php?page=ewp").'">Settings</a>'
    );
    return array_merge($links, $plugin_shortcuts);
}
add_filter('plugin_action_links_' . EWP_PLUGIN_BASENAME, 'ewp_rearrange_settings_links');