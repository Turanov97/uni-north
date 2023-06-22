
<?php
    $page = 'Shipping';

?>

<div class="container-fluid iwm-checkout-filed mt-4">
<ul class="checkout-field-menu">
    <li  class="<?php if($page == 'Billing'){echo 'iwm-menu-active';}?>"><a href="<?php echo admin_url().'admin.php?page=slug_checkout_field'?>">Billing</a></li>
    <li class="<?php if($page == 'Shipping'){echo 'iwm-menu-active';}?>"><a href="<?php echo admin_url().'admin.php?page=slug_checkout_shipping_field'?>">Shipping</a></li>
    <!-- <li class="<?php //if($page == 'Additional'){echo 'iwm-menu-active';}?>"><a href="<?php //echo admin_url().'admin.php?page=slug_checkout_order_field'?>">Additional</a></li> -->
</ul>
<span class='data'></span>
<form action="" method="post">
    <?php

        $type = array('text','url','radio','email','number','checkbox','state','country');
        $input_row = array('form-row-first','form-row-last','form-row-wide');
        global $wpdb;
        $checkout_shipping_field = $wpdb->prefix . 'woo_manage_checkout_shipping_field';

        
        
        /**
         * Insert New field
         */

        if(isset($_POST['insert_field_shipping'])){
    
            $field_name         =   strtolower(sanitize_text_field($_POST['iwm_field_name']));
            $input_type         =   sanitize_text_field($_POST['iwm_input_type']);
            $input_label       =   sanitize_text_field($_POST['input_label']);
            $input_width        =   sanitize_text_field($_POST['iwm_input_width']);
            $placeholder        =   sanitize_text_field($_POST['placeholder']);
            $required           =   sanitize_text_field($_POST['required']);

            $field = $wpdb->get_results("SELECT * FROM $checkout_shipping_field ORDER BY s_position ASC");
            foreach($field as $field);
            $positon = $field->s_position + 1;

            $sql = "INSERT INTO $checkout_shipping_field (`s_field_name`, `s_input_type`, `s_input_label`, `s_input_width`, `s_placeholder`, `s_input_required`, `s_input_remove`, `s_position`) VALUES ('$field_name', '$input_type', '$input_label', '$input_width', '$placeholder', '$required', '', '$positon')";
            $data = $wpdb->query($sql);
            $this_insert = $wpdb->insert_id;
        
        }

        /**
         * Update field
         */
        if(isset($_POST['update_field'])){
            $field_id       =   $_POST['field_id'];
            $input_type     =   $_POST['input_type'];
            $input_label    =   $_POST['input_label'];
            $input_width    =   $_POST['input_width'];
            $placeholder    =   $_POST['placeholder'];
            $required       =   $_POST['required'];
            $remove         =   $_POST['remove'];

           foreach($field_id as $key=>$id){
            $sql = "UPDATE $checkout_shipping_field SET s_input_type='$input_type[$id]', s_input_label='$input_label[$id]', s_input_width='$input_width[$id]', s_placeholder='$placeholder[$id]', s_input_required='$required[$id]', s_input_remove='$remove[$id]'  WHERE id='$id'";

            $data  = $wpdb->query($sql);
           }

        }

        /**
         * Delete data
         */
        if(isset($_POST['delete_biling_field'])){
            $id = $_POST['delete_field_id'];
            $sql = "DELETE FROM $checkout_shipping_field WHERE id='$id'";

            $data = $wpdb->query($sql);
        }
        
        /**
         * Select or show field
         */
        $show_field = $wpdb->get_results("SELECT * FROM $checkout_shipping_field ORDER BY s_position ASC");

       

    ?>


    <div class="panel">
        <div class="panel-heading "><h4>Shipping Feild Settings</h4><span class="top-submit-btn"><button type="submit" class="billing-update-btn" name="update_field">Update</button></span></div>
        <div class="panel-body">
            <table class="table table-reponsive">
                <thead>
                    <tr>
                        <th><i class="fas fa-bars"></i> Field Name</th>
                        <th>Type</th>
                        <th>Label Text</th>
                        <th>Input Width</th>
                        <th>Placeholder</th>
                        <th>Required</th>
                        <th>Hide</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th><i class="fas fa-bars"></i> Field Name</th>
                        <th>Type</th>
                        <th>Label Text</th>
                        <th>Input Width</th>
                        <th>Placeholder</th>
                        <th>Required</th>
                        <th>Hide</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody class="short-shipping">
                    <?php 
                        foreach($show_field as $key=>$field):
                        $disable = $field->s_input_remove;
                        $disable == 'on' ? $disable = 'disabled' : $disable = '';
                    ?>
                    <tr data-index="<?php echo $field->id; ?>" data-position="<?php echo $field->s_position; ?>" class="ui-state-default sorted-field">
                        
                        <input type="hidden" id="field_id" name="field_id[]" value="<?php echo $id = esc_attr($field->id);?>">
                        <td><i class="fas fa-arrows-alt"></i> <label for=""><?php echo esc_attr(strtolower(str_replace(' ', '_', $field->s_field_name)));?></label></td>
                        <td <?php echo $disable; ?>> 
                            <select name="input_type[<?php echo $id; ?>]" style="width: 90px;">
                                <option value="<?php echo esc_attr($field->s_input_type);?>"><?php echo esc_attr($field->s_input_type);?></option>
                                <option value="text">Text</option>
                                <option value="url">URL</option>
                                <option value="radio">Radio</option>
                                <option value="email">Email</option>
                                <option value="number">Number</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="state">State</option>
                                <option value="country">Country</option>
                            </select>
                        </td>
                        <td <?php echo $disable; ?>><input type="text" name="input_label[<?php echo $id; ?>]" value="<?php echo esc_attr($field->s_input_label);?>"></td>
                        <td <?php echo $disable; ?>>
                            <select name="input_width[<?php echo $id; ?>]" style="min-width:85%">
                                <option value="<?php echo esc_attr($field->s_input_width);?>"><?php echo esc_attr($field->s_input_width);?></option>
                               <option value="form-row-first">form-row-first</option>
                               <option value="form-row-last">form-row-last</option>
                               <option value="form-row-wide">form-row-wide</option>
                            </select>
                        </td>
                        <td <?php echo $disable; ?>><input type="text" name="placeholder[<?php echo $id; ?>]" value="<?php echo esc_attr($field->s_placeholder);?>"></td>
                        <td <?php echo $disable; ?>>
                            <?php $req = esc_attr($field->s_input_required);
                                $req =='on' ? ($check_req = 'checked') : ($check_req = '');
                            ?>
                            <input type="checkbox" <?php echo $check_req; ?> name="required[<?php echo $id; ?>]">
                        </td>
                        
                        <td>
                            <?php $on = esc_attr($field->s_input_remove);
                                $on =='on' ? ($check_remove = 'checked') : ($check_remove = '');
                            ?>
                            <input type="checkbox" <?php echo $check_remove; ?> name="remove[<?php echo $id; ?>]">
                        </td>
                        <td>
                            <?php if($id <= 9): ?>
                                <a href="#" data-id="<?php echo $field->id;?>" class="modal-open-delete-field">Default</a> <span title="Default fields are recommended to HIDE" class="question">?</span>
                            <?php else: ?>
                                <a href="#" data-id="<?php echo $field->id;?>" class="modal-open-delete-field shipping">Remove</a> <span title="Permanently delete from database" class="question">?</span>
                            <?php endif; ?>
                        </td>
                        
                    </tr>

                    <?php endforeach; ?>

               
            
                </tbody>
            </table>
        </div>

        <ul class="buttons">
            <li><button type="submit" class="billing-update-btn" name="update_field">Update</button></li>
            <li><p class="add-row-btn" data-toggle="modal" data-target="#exampleModalCenter">Add New</p></li>
        </ul>
    </div>
</form>
</div>



<div class="modal fade insert-field-modal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="width:80%">
    <form action="" method="post">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add New Shipping Field</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="insert-new-field-table">
            <tr>
                <td>Field Name</td>
                <td><input name="iwm_field_name" type="text"></td>
            </tr>
            <tr>
                <td>Field Type</td>
                <td> 
                    <select name="iwm_input_type" style="width:100%">
                        <?php foreach($type as $type){
                            echo "<option value='$type'>$type</option>" ;
                        } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Label</td>
                <td><input name="input_label" type="text"></td>
            </tr>
            <tr>
                <td>Field width</td>
                <td>
                    <select name="iwm_input_width" style="width:100%">
                        <?php foreach($input_row as $row){
                            echo "<option value='$row'>$row</option>" ;
                        } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Placeholder</td>
                <td><input name="placeholder" type="text"></td>
            </tr>
            <tr>
                <td>Required</td>
                <td><input name="required" type="checkbox"></td>
            </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="submit" name="insert_field_shipping" class="add-row-btn">Add Field</button>
      </div>
      </form>
    </div>
  </div>
</div>





<div class="modal fade bd-example-modal-sm" id="delete_shipping_field_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form action="" method="post">
    <div class="modal-content">
        <div class="modal-header" style="padding:10px">
            <h5 class="modal-title" id="exampleModalLabel">Delete Field</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body delete-field-data-modal-shipping">
            <!-- show data from ajax -->
        </div>
        <div class="modal-footer" style="padding:8px 10px">
            <button type="submit" name="delete_biling_field" class="btn btn-danger">Delete</button>
        </div>
    </div>
    </form>
  </div>
</div>
