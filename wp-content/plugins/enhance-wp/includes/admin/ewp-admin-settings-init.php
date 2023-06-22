<?php

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

global $kp_active_tab;
include('ewp-scripts-enqueue.php');


// Settings Page Initialization
function ewp_settings_page()
{
	// Validate nonce
	if (isset($_POST['ewp_submit']) && !wp_verify_nonce($_POST['ewp-settings-form'], 'ewp'))
	{
		echo '<div class="notice notice-error"><p>Nonce verification failed.</p></div>';
		exit;
	}

	// Double Check For User Capabilities
	if ( !current_user_can('manage_options') )
		return;
	
	$kp_active_tab = isset($_GET['tab']) ? $_GET['tab'] : "main";
?>

	<div class="kpftc-desc"><b>Enhance WP - Auto Empower Caching System</b> [No configuration needed]</div>

<?php

		include('ewp-admin-settings-main-fileds.php');
		include('ewp-admin-settings-extra-fileds.php');

		if (isset($_POST['ewp_submit']))
		{
			if ( is_plugin_active('wp-rocket/wp-rocket.php') )
			{
				echo '<div class="notice notice-success is-dismissible"><p>Main Plugin settings have been saved! <b>WP Rocket</b> cache has been cleared.</p></div>';
			}
			else if( is_plugin_active('autoptimize/autoptimize.php') )
			{
				echo '<div class="notice notice-success is-dismissible"><p>Main Plugin settings have been saved! <b>Autoptimize</b> cache has been cleared.</p></div>';
			}
			else
			{
				echo '<div class="notice notice-success is-dismissible"><p>Main Plugin settings have been saved! Please clear website cache.</p></div>';
			}
		}
		
		if (isset($_POST['ewp_extra_submit']))
		{
			if ( is_plugin_active('wp-rocket/wp-rocket.php') )
			{
				echo '<div class="notice notice-success is-dismissible"><p>Extra Plugin settings have been saved! <b>WP Rocket</b> cache has been cleared.</p></div>';
			}
			else if( is_plugin_active('autoptimize/autoptimize.php') )
			{
				echo '<div class="notice notice-success is-dismissible"><p>Extra Plugin settings have been saved! <b>Autoptimize</b> cache has been cleared.</p></div>';
			}
			else
			{
				echo '<div class="notice notice-success is-dismissible"><p>Extra Plugin settings have been saved! Please clear website cache.</p></div>';
			}
		}
		
		if (isset($_POST['ewp_restore_default']))
		{
			echo '<div class="notice notice-success is-dismissible"><p>Default Plugin Settings have been restored!</p></div>';
		}
		
		if (isset($_POST['ewp_license_submit']))
		{
			ewp_license_confirm_key( $_POST['ewp_init_key_confirm'] );
		}
		
		if( !get_transient('ewp-key-validate-activate'))
		{
		?>
		
		<form method="POST">
		<?php wp_nonce_field('ewp', 'ewp-key-confirm'); ?>
		<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row"><label>Email Address to receive updates (Optional)</label></th>
				<td>
					<input type="password" id ="ewp_init_key_confirm" name="ewp_init_key_confirm" style="width:400px"><br>
					<small class="description kp-code-desc">An Optimization Plugin by EnhanceWP </small><br>
				</td>
			</tr>
		</tbody>
		</table>
		<p class="submit">
			<input type="submit" name="ewp_license_submit" id="ewp_license_submit" class="button button-primary" value="Save License Key">
		</p>
		<p><b>Access to this plugin has been prevented because:</b></p>
		<ol>
			<li>This plugin can break your website if you don't know what you are doing.</li>
			<li>Only a certified EnhanceWP WordPress expert can access the plugin settings.</li>
			<li>Settings closes itself out in an hour but plugin keeps running as configured.</li>
		</ol>
	</form>
		
		<?php
		}
		else if( get_transient('ewp-key-validate-activate'))
		{
			
			switch ($kp_active_tab)
			{
				case 'main':
					ewp_settings_view();
					break;
				case 'extra':
					ewp_extra_settings_view();
					break;
				default:
					ewp_settings_view();
			}
		}
}