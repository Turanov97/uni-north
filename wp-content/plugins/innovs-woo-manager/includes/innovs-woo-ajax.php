<?php
use Dompdf\Dompdf;
/*
* Ajax option Saving
*/
function innovs_woo_ajax_save_btn(){ ?>
    <div id="saveResult"></div>
	<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary innovs_woo_save_btn" value="Save Changes"></p>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('#innovs_woo_option_form').submit(function() {
				jQuery(this).ajaxSubmit({
					success: function() {
						jQuery('#saveResult').html("<div id='saveMessage' class='innovs-woo-successModal'></div>");
                        jQuery('#saveMessage').append("<h5 style='color:green;font-size:16px;'><?php echo htmlentities(__('Saved Successfully','wp'),ENT_QUOTES); ?></h5>").show(3000);
                        jQuery('h5').fadeOut(5000);
					},
					beforeSend: function() {
                        jQuery('#saveResult').html("<div id='saveMessage' class='innovs-woo-successModal'><span class='is-active spinner'></span></div>");
					},
					timeout: 10000
				});
				return false;
			});
		});
	</script>
<?php }

/**
 * Billing field
 */
add_action( 'wp_ajax_delete_biling_field', 'delete_biling_field' );
add_action( 'wp_ajax_nopriv_delete_biling_field', 'delete_biling_field' );

function delete_biling_field(){
	global $wpdb;
    $checkout_field = $wpdb->prefix . 'woo_manage_checkout_field';

    $id =	 $_POST['id'];
	$datas = $wpdb->get_results("SELECT * FROM $checkout_field WHERE id='$id'");

	ob_start();
	 ?>
	 <p>Are you sure want to delete?</p>
	 <table  class="table table-bordered">
	 <tr>
		<th>Field Name</th>
		<th>Type</th>
		<th>Field width</th>
		
	 </tr>
		<?php foreach($datas as $field){ ?>
				<tr>
					<td><input type="hidden" name="delete_field_id" value="<?php  echo $field->id; ?>"> 
					<?php  echo $field->field_name; ?></td>
					<td><?php  echo $field->input_type; ?></td>
					<td><?php  echo $field->input_width; ?></td>
				</tr>

			<?php
		}
		?>
	</table>
	<?php
	echo  $obj = ob_get_clean();
	wp_die(); // this is required to terminate immediately and return a proper response
}


add_action( 'wp_ajax_update_biling_field_postion', 'update_biling_field_postion' );
add_action( 'wp_ajax_nopriv_update_biling_field_postion', 'update_biling_field_postion' );

function update_biling_field_postion(){
	global $wpdb;
    $checkout_field = $wpdb->prefix . 'woo_manage_checkout_field';
	if(isset($_POST['update_position'])){
		$positions =	 $_POST['positions'];
		foreach($positions as $position){
			$index = $position[0];
			$newPosition = $position[1];
			$sql = "UPDATE $checkout_field SET position='$newPosition' WHERE id='$index'";
			$wpdb->query($sql);
		}
		
		//print_r($datas);die;
	}
   

	wp_die(); // this is required to terminate immediately and return a proper response
}

/**
 * Shippping field
 */



add_action( 'wp_ajax_delete_shipping_field', 'delete_shipping_field' );
add_action( 'wp_ajax_nopriv_delete_shipping_field', 'delete_shipping_field' );

function delete_shipping_field(){
	global $wpdb;
    $checkout_shipping_field = $wpdb->prefix . 'woo_manage_checkout_shipping_field';

    $id =	 $_POST['id'];
	$datas = $wpdb->get_results("SELECT * FROM $checkout_shipping_field WHERE id='$id'");

	ob_start();
	 ?>
	 <p>Are you sure want to delete?</p>
	 <table  class="table table-bordered">
	 <tr>
		<th>Field Name</th>
		<th>Type</th>
		<th>Field width</th>
		
	 </tr>
		<?php foreach($datas as $field){ ?>
				<tr>
					<td><input type="hidden" name="delete_field_id" value="<?php  echo $field->id; ?>"> 
					<?php  echo $field->s_field_name; ?></td>
					<td><?php  echo $field->s_input_type; ?></td>
					<td><?php  echo $field->s_input_width; ?></td>
				</tr>

			<?php
		}
		?>
	</table>
	<?php
	echo  $obj = ob_get_clean();
	wp_die(); // this is required to terminate immediately and return a proper response
}


add_action( 'wp_ajax_update_shipping_field_postion', 'update_shipping_field_postion' );
add_action( 'wp_ajax_nopriv_update_shipping_field_postion', 'update_shipping_field_postion' );

function update_shipping_field_postion(){
	global $wpdb;
    $checkout_shipping_field = $wpdb->prefix . 'woo_manage_checkout_shipping_field';
	if(isset($_POST['update_position'])){
		$positions =	 $_POST['positions'];
		foreach($positions as $position){
			$index = $position[0];
			$newPosition = $position[1];
			$sql = "UPDATE $checkout_shipping_field SET s_position='$newPosition' WHERE id='$index'";
			$wpdb->query($sql);
		}
		
		//print_r($datas);die;
	}
   

	wp_die(); // this is required to terminate immediately and return a proper response
}


/**
 * Start Review system making ajax
 */

add_action('wp_ajax_review_already_did', 'review_already_did');
add_action('wp_ajax_nopriv_review_already_did', 'review_already_did');

function review_already_did(){

    global $wpdb;
    $tablename = $wpdb->prefix . "options";

    $value = ' ';

    $sql = "UPDATE `$tablename` SET `option_value` = '$value' WHERE option_name = 'iwm_install_time'";

    $wpdb->query($sql);
    //echo $estimateId;

    wp_die(); // this is required to terminate immediately and return a proper response
}

add_action('wp_ajax_maybe_later_will_review', 'maybe_later_will_review');
add_action('wp_ajax_nopriv_maybe_later_will_review', 'maybe_later_will_review');

function maybe_later_will_review() {

    global $wpdb;
    $tablename = $wpdb->prefix . "options";

    $value = strtotime("now");

    $sql = "UPDATE `$tablename` SET `option_value` = '$value' WHERE option_name = 'iwm_install_time'";

    $wpdb->query($sql);
    //echo $estimateId;

    wp_die(); // this is required to terminate immediately and return a proper response
}

add_action('wp_ajax_woo_pro_notice', 'woo_pro_notice');
add_action('wp_ajax_nopriv_woo_pro_notice', 'woo_pro_notice');

function woo_pro_notice() {

    $value = strtotime("now");
	$option = 'woo_pro_notice';

	update_option( $option, $value, $autoload = null );

    wp_die(); // this is required to terminate immediately and return a proper response
}

/**
 * End notice dismis and appear after 7 days woocommece marchent plugin
 */

add_action('wp_ajax_woo_estimate_notice', 'woo_estimate_notice');
add_action('wp_ajax_nopriv_woo_estimate_notice', 'woo_estimate_notice');

function woo_estimate_notice() {

    $value = strtotime("now");
	$option = 'woo_estimate_notice';
	update_option( $option, $value, $autoload = null );
    wp_die(); // this is required to terminate immediately and return a proper response
}

/**
 * End notice dismis and appear after 7 days woocommerce estimate and quote plugin
 */




