<?php

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

function ewp_format_list($list)
{
    $list = trim($list);
    $list = $list ? array_map('trim', explode("\n", str_replace("\r", "", sanitize_textarea_field($list)))) : [];
    return $list;
}

function ewp_settings_view()
{
	$kp_active_tab = isset($_GET['tab']) ? $_GET['tab'] : "main";
?>

<h2 class="nav-tab-wrapper">
    <a href="?page=ewp&tab=main" class="nav-tab <?php echo $kp_active_tab == 'main' ? 'nav-tab-active' : ''; ?>">Main Settings</a>
    <a href="?page=ewp&tab=extra" class="nav-tab <?php echo $kp_active_tab == 'extra' ? 'nav-tab-active' : ''; ?>">Extra Settings</a>
</h2>

<?php

    if (isset($_POST['ewp_submit'])) {
        update_option('ewp_css_include_list', ewp_format_list($_POST['ewp_css_include_list']));
		update_option('ewp_js_include_list', ewp_format_list($_POST['ewp_js_include_list']));
        update_option('ewp_disabled_pages', ewp_format_list($_POST['ewp_disabled_pages']));
		update_option('ewp_css_mobile_disabled', $_POST['ewp_css_mobile_disabled']);
		update_option('ewp_js_mobile_disabled', $_POST['ewp_js_mobile_disabled']);
		update_option('ewp_wp_rocket_support', $_POST['ewp_wp_rocket_support']);
		
		if ( is_plugin_active('wp-rocket/wp-rocket.php') )
		{
			rocket_clean_minify();
			rocket_clean_domain();
		}
		
		if( is_plugin_active('autoptimize/autoptimize.php') )
		{
			autoptimizeCache::clearall();
		}
    }
	
	if (isset($_POST['ewp_restore_default'])) {
        ewp_restore_default_settings();
    }
	
	if (isset($_POST['ewp_close_settings'])) {
        ewp_close_settings();
    }

    $ewp_css_include_list = get_option('ewp_css_include_list');
	if($ewp_css_include_list)
	{
		$ewp_css_include_list = implode("\n", $ewp_css_include_list);
		$ewp_css_include_list = esc_textarea($ewp_css_include_list);
	} else
	{
		$ewp_css_include_list = "";
	}
	
	$ewp_js_include_list = get_option('ewp_js_include_list');
	if($ewp_js_include_list)
	{
		$ewp_js_include_list = implode("\n", $ewp_js_include_list);
		$ewp_js_include_list = esc_textarea($ewp_js_include_list);
	} else
	{
		$ewp_js_include_list = "";
	}

    $ewp_disabled_pages = get_option('ewp_disabled_pages');
    $ewp_disabled_pages = implode("\n", $ewp_disabled_pages);
    $ewp_disabled_pages = esc_textarea($ewp_disabled_pages);
	
	
	$ewp_css_mobile_disabled = get_option('ewp_css_mobile_disabled');
	$ewp_js_mobile_disabled = get_option('ewp_js_mobile_disabled');
	
	$ewp_wp_rocket_support = get_option('ewp_wp_rocket_support');

    ?>
	<form method="POST">
		<?php wp_nonce_field('ewp', 'ewp-settings-form'); ?>
		<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row"><label>Delay JS Support </label></th>
				<td>
					<input type="hidden" name="ewp_wp_rocket_support" value="no">
					<input type="checkbox" id="ewp_wp_rocket_support" name="ewp_wp_rocket_support" <?php if($ewp_wp_rocket_support == "yes") { echo "checked"; } ?> value="<?php if($ewp_wp_rocket_support == "yes") { echo "yes"; } else { echo "no"; } ?>"><label for="ewp_wp_rocket_support">Execute delayed JS of <b>WP Rocket (3.12.6.1)</b></label>
					<br>
				</td>
			</tr>
			<tr>
				<th scope="row"><label>CSS Keywords</label></th>
				<td>
					<textarea name="ewp_css_include_list" rows="2" cols="50"><?php echo $ewp_css_include_list ?></textarea><br>
					<small class="description kp-code-desc">Keywords to identify styles for user interaction.</small><br><br>
					<small>
					<input type="hidden" name="ewp_css_mobile_disabled" value="no">
					<input type="checkbox" id="ewp_css_mobile_disabled" name="ewp_css_mobile_disabled" <?php if($ewp_css_mobile_disabled == "yes") { echo "checked"; } ?> value="<?php if($ewp_css_mobile_disabled == "yes") { echo "yes"; } else { echo "no"; } ?>"><label for="ewp_css_mobile_disabled">Disable CSS Optimization in Mobile</label>
					</small><br>
				</td>
			</tr>
			<tr>
				<th scope="row"><label>JS Keywords</label></th>
				<td>
					<textarea name="ewp_js_include_list" rows="2" cols="50"><?php echo $ewp_js_include_list ?></textarea><br>
					<small class="description">Keywords to identify scripts for user interaction.</small><br><br>
					<small>
					<input type="hidden" name="ewp_js_mobile_disabled" value="no">
					<input type="checkbox" id="ewp_js_mobile_disabled" name="ewp_js_mobile_disabled" <?php if($ewp_js_mobile_disabled == "yes") { echo "checked"; } ?> value="<?php if($ewp_js_mobile_disabled == "yes") { echo "yes"; } else { echo "no"; } ?>"><label for="ewp_js_mobile_disabled">Disable JS Optimization in Mobile</label>
					</small><br>
				</td>
			</tr>
			<tr>
				<th scope="row"><label>Disable on Pages</label></th>
				<td>
					<textarea name="ewp_disabled_pages" rows="2" cols="50"><?php echo $ewp_disabled_pages; ?></textarea><br>
					<small class="description">Page Slug Keywords to disable this plugin on specific pages.</small>
				</td>
			</tr>
			<tr>
				<th scope="row"><label>Restore Defaults</label></th>
				<td>
					<input type="submit" name="ewp_restore_default" id="ewp_restore_default" class="button button-primary" value="Restore Default Settings">
					<input type="submit" name="ewp_close_settings" id="ewp_close_settings" class="button button-primary" value="Close Plugin Settings">
				</td>
			</tr>
		</tbody>
		</table>
		<p class="submit">
			<input type="submit" name="ewp_submit" id="ewp_submit" class="button button-primary" value="Save Changes">
		</p>
	</form>
	<?php
}