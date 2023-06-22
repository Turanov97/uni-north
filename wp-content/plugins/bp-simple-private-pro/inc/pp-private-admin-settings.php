<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Settings Page class
 */

class PP_Simple_Private_Settings {

	private $settings_message = '';
	private $license_message = '';
	
    public function __construct() {
    
		add_action( 'admin_init', array( $this, 'pp_private_save_license') );
		add_action( 'admin_init', array( $this, 'pp_private_activate_license') );
		add_action( 'admin_init', array( $this, 'pp_private_deactivate_license') );		    
    
		if ( is_multisite() ) {
		
			if ( ! function_exists( 'is_plugin_active_for_network' ) )
			    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
    
        }
        				
        if ( is_multisite() && is_plugin_active_for_network( 'buddypress-simple-events/loader.php' ) )  {
			add_action('network_admin_menu', array( $this, 'multisite_admin_menu' ) );
		} else {
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		}
	}


	function admin_menu() {
		add_options_page(  __( 'BP Simple Private', 'bp-simple-private'), __( 'BP Simple Private', 'bp-simple-private' ), 'manage_options', 'bp-simple-private', array( $this, 'settings_admin_screen' ) );
	}


	function multisite_admin_menu() {
		add_submenu_page( 'settings.php', __( 'BP Simple Private', 'bp-simple-private'), __( 'BP Simple Private', 'bp-simple-private' ), 'manage_options', 'bp-simple-private', array( $this, 'settings_admin_screen' ) );
	}	

	

	function pp_private_save_license() {

		if ( ! empty( $_POST["pp-private-lic-save"] ) ) {

		 	if( ! check_admin_referer( 'pp_private_lic_save_nonce', 'pp_private_lic_save_nonce' ) ) {
				return;
			}
			
			$old = get_option( 'pp_private_license_key' );
			$new = trim( $_POST["pp_private_license_key"] );

			if( $old && $old !=  $new ) {
				delete_option( 'pp_private_license_status' ); // new license has been entered, so must reactivate
			}

			update_option( 'pp_private_license_key', $new );
			
			$this->license_message .=
					"<div class='updated below-h2'>" .  __('License Key has been saved.', 'bp-simple-private') . "</div>";

		}
	}



	function pp_private_activate_license() {

		if( isset( $_POST['pp_private_license_activate'] ) ) {

		 	if( ! check_admin_referer( 'pp_private_lic_nonce', 'pp_private_lic_nonce' ) ) {
				return;
			}
			
			$license = trim( get_option( 'pp_private_license_key' ) );

			$api_params = array(
				'edd_action'=> 'activate_license',
				'license' 	=> $license,
				'item_name' => urlencode( PP_SIMPLE_PRIVATE_PRO ), 
				'url'       => home_url()
			);

			$response = wp_remote_post( PP_PRIVATE_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

			if ( is_wp_error( $response ) ) {
				//var_dump( $response );
				return false;
			}

			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// $license_data->license will be either "valid" or "invalid"

			update_option( 'pp_private_license_status', $license_data->license );
			
			$this->license_message .=
					"<div class='updated below-h2'>" .  __('License has been activated.', 'bp-simple-private') . "</div>";

		}
	}


	function pp_private_deactivate_license() {

		if( isset( $_POST['pp_private_license_deactivate'] ) ) {

		 	if( ! check_admin_referer( 'pp_private_lic_nonce', 'pp_private_lic_nonce' ) ) {
			}
				return;

			$license = trim( get_option( 'pp_private_license_key' ) );

			$api_params = array(
				'edd_action'=> 'deactivate_license',
				'license' 	=> $license,
				'item_name' => urlencode( PP_SIMPLE_PRIVATE_PRO ), // the name of our product in EDD
				'url'       => home_url()
			);

			$response = wp_remote_post( PP_PRIVATE_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

			if ( is_wp_error( $response ) ) {
				return false;
			}

			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// $license_data->license will be either "deactivated" or "failed"
			if( $license_data->license == 'deactivated' ) {
				delete_option( 'pp_private_license_status' );
				$this->license_message .=
					"<div class='updated below-h2'>" .  __('License has been deactivated.', 'bp-simple-private') . "</div>";
			} else {
				$this->license_message .=
					"<div class='error below-h2'>" .  __('License has NOT been deactivated.', 'bp-simple-private') . "</div>";
			}
		}
	}	
	
	
	function settings_admin_screen(){

		if ( !is_super_admin() ) {
			return;
		}

		$this->settings_update();

		// redirection url
		$pp_private_url = get_option( 'pp-private-url' );

		if ( $pp_private_url == false ) {

			$pp_private_url = '';

			$front_id = get_option('page_on_front');

			if ( $front_id != false ) {
				$pp_private_url_placeholder = trailingslashit( esc_url( get_permalink( $front_id ) ) );
			} else {
				$pp_private_url_placeholder = trailingslashit( site_url() );
			}

		} else {
			$pp_private_url_placeholder = '';
		}


		// components
		$bp = buddypress();

		$active_components = array( 'member Profile Pages' => 1 );

		$skip_these_bp = array( 'friends', 'messages', 'notifications', 'settings', 'xprofile' );

		foreach( $bp->active_components as $key => $value ) {

			if ( ! in_array( $key, $skip_these_bp ) )
				$active_components[ $key ] = 1;
		}

		if ( class_exists( 'bbPress' ) ) {

			$active_components['forums'] = 1;

			$active_components['groupforums'] = 1;
		}


		ksort( $active_components );

		$pp_private_components = get_option( 'pp-private-components' );
		if ( $pp_private_components == false )
			$pp_private_components = array();

		// custom post types
		$args = array( 'public' => true, '_builtin' => false );
		$output = 'names';
		$operator = 'and';

		$post_types = get_post_types( $args, $output, $operator );

		$skip_these_bbPress = array( 'forum', 'topic', 'reply' );

		$private_post_types = array( 'page' => 1, 'post' => 1 );

		foreach( $post_types as $key => $value ) {

			if ( ! in_array( $key, $skip_these_bbPress ) ) {
				$private_post_types[ $key ] = 1;
			}
		}

		ksort( $private_post_types );

		$pp_private_cpts = get_option( 'pp-private-cpts' );
		if ( $pp_private_cpts == false ) {
			$pp_private_cpts = array();
		}
		
		$license 	= get_option( 'pp_private_license_key' );
		$status 	= get_option( 'pp_private_license_status' );

		?>

		<h3>BuddyPress Simple Private Pro Settings</h3>

		<table class="wp-list-table widefat fixed striped">
		
		<tr>
		<td style="vertical-align:top; border: 1px solid #ccc;" >
		
			<div class="wrap">
			<strong><?php _e('License Options'); ?></strong>
			
			<?php echo $this->license_message; ?>
			
			<form method="post" action="">

				<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row" valign="top">
								<?php _e('License Key', 'bp-simple-private'); ?>
							</th>
							<td>
								<input id="pp_private_license_key" name="pp_private_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
								<label class="description" for="pp_private_license_key"><em><?php _e('Enter your license key', 'bp-simple-private'); ?></em></label>
							</td>
						</tr>

						<?php if( false !== $license ) { ?>
							<tr valign="top">
								<th scope="row" valign="top">
									<?php _e('Activate License'); ?>
								</th>
								<td>
									<?php if( $status !== false && $status == 'valid' ) { ?>
										<span style="color:#32cd32;"><?php _e('Your License is Active', 'bp-simple-private' ); ?></span>
										<?php wp_nonce_field( 'pp_private_lic_nonce', 'pp_private_lic_nonce' ); ?>
										&nbsp;&nbsp;<input type="submit" class="button-secondary" name="pp_private_license_deactivate" value="<?php _e('Deactivate License', 'bp-simple-private'); ?>"/>
									<?php } else {
										wp_nonce_field( 'pp_private_lic_nonce', 'pp_private_lic_nonce' ); ?>
										<input type="submit" class="button-secondary" name="pp_private_license_activate" value="<?php _e('Activate License', 'bp-simple-private'); ?>"/>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>

						<tr valign="top">
							<td>
								<?php wp_nonce_field( 'pp_private_lic_save_nonce', 'pp_private_lic_save_nonce' ); ?>
								<input type="submit" class="button button-primary" name="pp-private-lic-save" value="<?php _e("Save License Key", "bp-simple-private");?>" />
							</td>
							<td>&nbsp;<em><?php _e("You must Save your Key before you can Activate your License", "bp-simple-private");?></em></td>
						</tr>
					</tbody>
				</table>

			</form>
			<hr>
		</div>				
		
			<br/>
			<strong>Settings</strong><br/>
			<?php echo $this->settings_message . '<br/>'; ?>

			<form action="" name="settings-form" id="settings-form"  method="post" class="standard-form">

				<?php wp_nonce_field('settings-action', 'settings-field'); ?>

				<p>
					<?php echo __('When a non-logged-in user tries to access Private content, where will they be sent?', 'bp-simple-private'); ?>
					<br/>
					<?php echo __('Enter the full URL:', 'bp-simple-private'); ?>
					<br/>
					&nbsp;<input type="text" id="pp-private-url" name="pp-private-url" placeholder="<?php echo $pp_private_url_placeholder; ?>" value="<?php echo $pp_private_url; ?>" size="50" />
					<br/>
					<?php echo __('<em>Leave empty to use Home or Front page.</em>', 'bp-simple-private'); ?>
				</p>

				<hr/>

				<p>
					<br/>
					<?php echo __('Select which BuddyPress sections are NOT viewable by non-logged-in users:', 'bp-simple-private'); ?>

					<br/>

					<ul id="pp-comp-fields">

						<?php
						foreach( $active_components as $key => $value ) {
							if ( $key != 'blogs' ) {
							?>
								<li>&nbsp;<label><input type="checkbox" name="pp-private-components[]" value="<?php echo $key; ?>" <?php checked( in_array( $key, $pp_private_components ) ); ?> />
								<?php
								if ( $key == 'forums' )
									$key = 'Forums ( bbPress )';

								if ( $key == 'groupforums' )
									$key = 'Group Forums ( bbPress )';

								echo ucfirst( $key );
								?></label></li>
							<?php
							}
						}
						?>

					</ul>
				</p>

				<hr/>

				<p>
					<?php //echo 'saved cpts: '; var_dump($pp_private_cpts); echo '<br>'; ?>
					<br/>
					<?php echo __('Make these Post Types PRIVATE - regardless of any other setting. Every instance of a selected Post Type will be Private throughout your site - excluding the Front or Home Page.', 'bp-simple-private'); ?>
					<br/>

	 				<ul id="pp-cpt-fields-global">

						<?php
						foreach ( $private_post_types as $key => $value ) {
						?>
							<li>&nbsp;<label><input type="checkbox" name="pp-private-cpts[]" value="<?php echo $key . '-global'; ?>" <?php checked( in_array( $key . '-global', $pp_private_cpts ) ); ?> /> <?php echo ucfirst( $key); ?> - Site-wide</label></li>
						<?php
						}
						?>

					</ul>
				</p>				
				
				
				<p>
					<br/>
					<?php echo __('If you want to control Privacy on a per-Post basis, for these selected Post Types, a Public or Private checkbox will appear in the upper right corner of their wp-admin Create and Edit screens.<br>In Gutenberg, the checkbox will appear at the bottom of the right column.', 'bp-simple-private'); ?>
					<br/>

	 				<ul id="pp-cpt-fields">

						<?php
						foreach ( $private_post_types as $key => $value ) {
						?>
							<li>&nbsp;<label><input type="checkbox" name="pp-private-cpts[]" value="<?php echo $key; ?>" <?php checked( in_array( $key, $pp_private_cpts ) ); ?> /> <?php echo ucfirst( $key); ?></label></li>
						<?php
						}
						?>

					</ul>
				</p>
				
				<p>
					<br/>
					<?php echo __('For Post Types selected above, default the checkbox to Private ( checked ) in the upper right corner of their wp-admin Create screen.<br>In Gutenberg, the checkbox will appear at the bottom of the right column.', 'bp-simple-private'); ?>
					<br/>
					<?php
					$pp_private_default = get_option( 'pp-private-default' );
					if ( $pp_private_default == false )
						$pp_private_default = 0;
					?>
					<ul>
						<input type="checkbox" id="pp-private-default" name="pp-private-default" value="1" <?php checked( $pp_private_default, 1 ); ?> /> 
						Default the checkbox to Private 
					</ul>	
				</p>

				<hr/>

				<p>
					<br/>
					<?php echo __('RSS Feeds - Disable if user is not logged in:', 'bp-simple-private'); ?>
					<br/>
					<?php
					$pp_private_rss = get_option( 'pp-private-rss' );
					if ( $pp_private_rss == false )
						$pp_private_rss = 0;
					?>
					<ul>
						<input type="checkbox" id="pp-private-rss" name="pp-private-rss" value="1" <?php checked( $pp_private_rss, 1 ); ?> /> BuddyPress
					</ul>	
				</p>

				<hr/>				
				
				<p>
					<br/>
					<input type="hidden" name="settings-access" value="1"/>
					<input type="submit" name="submit" class="button button-primary" value="<?php echo __('Save Settings', 'bp-simple-private'); ?>"/>
				</p>
			</form>

		</td></tr></table>
	<?php
	}


	//  save any changes to settings options
	private function settings_update() {

		if ( isset( $_POST['settings-access'] ) ) {

			if ( !wp_verify_nonce($_POST['settings-field'],'settings-action') ) {
				die('Security check');
			}

			if ( !is_super_admin() ) {
				return;
			}


			if ( ! empty( $_POST['pp-private-url'] ) ) {
				$pp_private_url = esc_url_raw( $_POST['pp-private-url'] );
				$pp_private_url = trailingslashit( $pp_private_url );
				update_option( 'pp-private-url', $pp_private_url, true );
			} else {
				delete_option( 'pp-private-url' );
			}

			delete_option( 'pp-private-components' );
			$pp_private_components = array();
			if ( ! empty( $_POST['pp-private-components'] ) ) {
				foreach ( $_POST['pp-private-components'] as $value ) {
					$pp_private_components[] = $value;
				}
			}
			update_option( 'pp-private-components', $pp_private_components, true );


			delete_option( 'pp-private-cpts' );
			$pp_private_cpts = array();
			
			//var_dump($_POST['pp-private-cpts']);
			
			if ( ! empty( $_POST['pp-private-cpts'] ) ) {
				foreach ( $_POST['pp-private-cpts'] as $value ) {
					$pp_private_cpts[] = $value;
				}
			}
			update_option( 'pp-private-cpts', $pp_private_cpts, true );
			

			if ( ! empty( $_POST['pp-private-default'] ) ) {
				update_option( 'pp-private-default', '1', true );
			} else {
				delete_option( 'pp-private-default' );	
			}
			
			if ( ! empty( $_POST['pp-private-rss'] ) ) {
				update_option( 'pp-private-rss', '1', true );
			} else {
				delete_option( 'pp-private-rss' );				
			}

			$this->settings_message .=
				"<div class='updated below-h2'>" .
				__('Settings have been updated.', 'bp-simple-private') .
				"</div>";
		}
	}

} // end of PP_Simple_Privacy_Settings class

$pp_simple_private_settings_instance = new PP_Simple_Private_Settings();
