<?php

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

/*function ewp_format_list($list)
{
    $list = trim($list);
    $list = $list ? array_map('trim', explode("\n", str_replace("\r", "", sanitize_textarea_field($list)))) : [];
    return $list;
}*/

function ewp_extra_settings_view()
{
	$kp_active_tab = isset($_GET['tab']) ? $_GET['tab'] : "main";
?>

<h2 class="nav-tab-wrapper">
    <a href="?page=ewp&tab=main" class="nav-tab <?php echo $kp_active_tab == 'main' ? 'nav-tab-active' : ''; ?>">Main Settings</a>
    <a href="?page=ewp&tab=extra" class="nav-tab <?php echo $kp_active_tab == 'extra' ? 'nav-tab-active' : ''; ?>">Extra Settings</a>
</h2>

<?php

    if (isset($_POST['ewp_extra_submit']))
	{
        update_option('ewp_white_label', $_POST['ewp_white_label']);
		update_option('ewp_cartflows', $_POST['ewp_cartflows']);
		update_option('ewp_video_include_list', ewp_format_list($_POST['ewp_video_include_list']));
		update_option('ewp_video_mobile_disabled', $_POST['ewp_video_mobile_disabled']);
		
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
	
	$ewp_white_label = get_option('ewp_white_label');
	$ewp_cartflows = get_option('ewp_cartflows');
	$ewp_video_mobile_disabled = get_option('ewp_video_mobile_disabled');
	
	$ewp_video_include_list = get_option('ewp_video_include_list');
	if($ewp_video_include_list){
		$ewp_video_include_list = implode("\n", $ewp_video_include_list);
		$ewp_video_include_list = esc_textarea($ewp_video_include_list);
	} else
	{
		$ewp_video_include_list = "";
	}

    ?>
	<form method="POST">
		<?php wp_nonce_field('ewp', 'ewp-settings-form'); ?>
		<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row"><label>White-Label</label></th>
				<td>
					<input type="hidden" name="ewp_white_label" value="no">
					<input type="checkbox" id="ewp_white_label" name="ewp_white_label" <?php  if($ewp_white_label == 'yes') { echo 'checked'; } ?> value="<?php if($ewp_white_label == 'yes') { echo 'yes'; } else { echo 'no'; } ?>"><label for="ewp_white_label">Hide Plugin from Plugins List and Settings.</label>
					<br>
				</td>
			</tr>
			<tr>
				<th scope="row"><label>CartFlows Support</label></th>
				<td>
					<input type="hidden" name="ewp_cartflows" value="no">
					<input type="checkbox" id="ewp_cartflows" name="ewp_cartflows" <?php  if($ewp_cartflows == 'yes') { echo 'checked'; } ?> value="<?php if($ewp_cartflows == 'yes') { echo 'yes'; } else { echo 'no'; } ?>"><label for="ewp_cartflows">Force Caching on CartFlows Pages.</label>
					<br>
				</td>
			</tr>
			<tr>
				<th scope="row"><label>Video Keywords</label></th>
				<td>
					<textarea name="ewp_video_include_list" rows="2" cols="50"><?php echo $ewp_video_include_list ?></textarea><br>
					<small class="description kp-code-desc">Keywords to identify videos for user interaction.</small><br><br>
					<small>
					<input type="hidden" name="ewp_video_mobile_disabled" value="no">
					<input type="checkbox" id="ewp_video_mobile_disabled" name="ewp_video_mobile_disabled" <?php if($ewp_video_mobile_disabled == "yes") { echo "checked"; } ?> value="<?php if($ewp_video_mobile_disabled == "yes") { echo "yes"; } else { echo "no"; } ?>"><label for="ewp_video_mobile_disabled">Disable Video Delay in Mobile</label>
					</small><br>
				</td>
			</tr>
		</tbody>
		</table>
		<p class="submit">
			<input type="submit" name="ewp_extra_submit" id="ewp_extra_submit" class="button button-primary" value="Save Changes">
		</p>
	</form>
	<?php
}