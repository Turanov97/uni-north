
<?php
/**
 * Main menu file
 * @package innovs main menu
 */
?>

<!-- Start main menu text filed area function -->
 
<div class="panel innovs-panel-primary" style="margin-top:10px;">
  <div class="panel-heading innovs-panel-heading">INNOVS WOO MANAGER SETTINGS</div>
  <form method="post" action="options.php" id="innovs_woo_option_form">
    <div class="panel-body innovs-panel-body">
        <!-- Start tab menu -->
        <ul class="nav nav-tabs innovs-nav-tabs" id="myTab">
            <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#tab1">Default Button Settings</a></li>
            <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tab2">Several Button settings</a></li>
            <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tab3">Add button custom label</a></li>
            <!-- <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tab4">Product Title & Price</a></li> -->
        </ul>
       
        <!-- Start tab content -->
        <div class="tab-content">
            <div id="tab1" class="tab-pane active">
                <?php settings_fields( 'innovs-woo-manager-settings-group' ); ?>
                <?php do_settings_sections( 'innovs-woo-manager-settings-group' ); ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-info innovs-panel-mt">
                            <div class="panel-heading text-center">General Button Settings</div>
                            <div class="panel-body">
                                <table class="innovs-table">
                                    <tr>
                                        <td>Text Color</Button></td>
                                        <td>
                                            <div>
                                                <input class="innovs-color-picker" name="button_text_color" value="<?php echo esc_attr( get_option('button_text_color') ); ?>" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Background Color</td>
                                        <td> 
                                            <div>
                                                <input class="innovs-color-picker" name="background_color" value="<?php echo esc_attr( get_option('background_color') ); ?>" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Font Size</Button></td>
                                        <td><input type="number" class="btc" name="font_size" value="<?php echo esc_attr( get_option('font_size') ); ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Border Radius</td>
                                        <td><input type="number" placeholder="5px" name="border_radius" value="<?php echo esc_attr( get_option('border_radius') ); ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Padding Top Bottom</td>
                                        <td><input type="number" placeholder="5px" name="padding_top_bottom" value="<?php echo esc_attr( get_option('padding_top_bottom') ); ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Padding left Right</td>
                                        <td><input type="number" placeholder="5px" name="padding_left_right" value="<?php echo esc_attr( get_option('padding_left_right') ); ?>" /></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                          
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-info innovs-panel-mt">
                        <div class="panel-heading text-center">General Button Hover setting</div>
                            <div class="panel-body">
                                <table class="innovs-table">
                                    <tr>
                                        <td>Hover Color</td>
                                        <td><input class="innovs-color-picker" name="hover_text_color" value="<?php echo esc_attr( get_option('hover_text_color') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                    <tr>
                                        <td>Hover Background</td>
                                        <td><input class="innovs-color-picker" name="hover_background_color" value="<?php echo esc_attr( get_option('hover_background_color') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div> <!--End 2nd col-4 -->
                    <div class="col-md-4">

                    </div> <!--End 3rd col-4 -->
                </div>
            </div>

            <!-- start tab 2 -->
            <div id="tab2" class="tab-pane fade">
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-info innovs-panel-mt">
                            <div class="panel-heading text-center">Grouped Button Settings</div>
                            <div class="panel-body">
                                <table class="innovs-table">
                                    <tr>
                                        <td>Text Color</td>
                                        <td><input class="innovs-color-picker" name="group_text_color" value="<?php echo esc_attr( get_option('group_text_color') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                    <tr>
                                        <td>Background Color</td>
                                        <td><input class="innovs-color-picker" name="group_background" value="<?php echo esc_attr( get_option('group_background') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                    <tr>
                                        <td>Font Size</td>
                                        <td><input type="number" name="group_font_size" value="<?php echo esc_attr( get_option('group_font_size') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                    <tr>
                                        <td>Padding</td>
                                        <td><input type="number" name="group_padding" value="<?php echo esc_attr( get_option('group_padding') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                    <tr>
                                        <td>Border Radius</td>
                                        <td><input type="number" name="group_border_radius" value="<?php echo esc_attr( get_option('group_border_radius') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                    <tr>
                                        <td>Hover Color</td>
                                        <td><input class="innovs-color-picker" name="group_text_hover" value="<?php echo esc_attr( get_option('group_text_hover') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                    <tr>
                                        <td>Hover Background</td>
                                        <td><input class="innovs-color-picker" name="group_background_hover" value="<?php echo esc_attr( get_option('group_background_hover') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-info innovs-panel-mt">
                            <div class="panel-heading text-center">Variable Button Settings</div>
                            <div class="panel-body">
                                <table class="innovs-table">
                                    <tr>
                                        <td>Text Color</td>
                                        <td><input class="innovs-color-picker" name="vari_text_color" value="<?php echo esc_attr( get_option('vari_text_color') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                    <tr>
                                        <td>Background Color</td>
                                        <td><input class="innovs-color-picker" name="vari_background" value="<?php echo esc_attr( get_option('vari_background') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                    <tr>
                                        <td>Font Size</td>
                                        <td><input type="number" name="vari_font_size" value="<?php echo esc_attr( get_option('vari_font_size') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                    <tr>
                                        <td>Padding</td>
                                        <td><input type="number" name="vari_padding" value="<?php echo esc_attr( get_option('vari_padding') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                    <tr>
                                        <td>Border Radius</td>
                                        <td><input type="number" name="vari_border_radius" value="<?php echo esc_attr( get_option('vari_border_radius') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                    <tr>
                                        <td>Hover Color</td>
                                        <td><input class="innovs-color-picker" name="vari_text_hover" value="<?php echo esc_attr( get_option('vari_text_hover') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                    <tr>
                                        <td>Hover Background</td>
                                        <td><input class="innovs-color-picker" name="vari_background_hover" value="<?php echo esc_attr( get_option('vari_background_hover') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-info innovs-panel-mt">
                            <div class="panel-heading text-center">Subscriptions button Settings</div>
                            <div class="panel-body">
                                <table class="innovs-table">
                                    <tr>
                                        <td>Text Color</td>
                                        <td><input class="innovs-color-picker" name="subs_text_color" value="<?php echo esc_attr( get_option('subs_text_color') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                    <tr>
                                        <td>Background Color</td>
                                        <td><input class="innovs-color-picker" name="subs_background" value="<?php echo esc_attr( get_option('subs_background') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                    <tr>
                                        <td>Font Size</td>
                                        <td><input type="number" name="subs_font_size" value="<?php echo esc_attr( get_option('subs_font_size') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                    <tr>
                                        <td>Padding</td>
                                        <td><input type="number" name="subs_padding" value="<?php echo esc_attr( get_option('subs_padding') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                    <tr>
                                        <td>Border Radius</td>
                                        <td><input type="number" name="subs_border_radius" value="<?php echo esc_attr( get_option('subs_border_radius') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                    <tr>
                                        <td>Hover Color</td>
                                        <td><input class="innovs-color-picker" name="subs_text_hover" value="<?php echo esc_attr( get_option('subs_text_hover') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                    <tr>
                                        <td>Hover Background</td>
                                        <td><input class="innovs-color-picker" name="subs_background_hover" value="<?php echo esc_attr( get_option('subs_background_hover') ); ?>" class="my-color-field" /><td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- start tab 3 -->
            <div id="tab3" class="tab-pane fade"> 
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-info innovs-panel-mt">
                            <div class="panel-heading text-center">Add Custom text on cart button</div>
                            <div class="panel-body">
                                <table class="innovs-table">
                                    <tr>
                                        <td>Simple button text</td>
                                        <td><input type="text" name="simple_button_text" value="<?php if(empty(esc_attr( get_option('simple_button_text')))){
                                            echo "Add to cart";
                                        }else{echo esc_attr( get_option('simple_button_text'));}  ?>"/><td>
                                    </tr>
                                    <tr >
                                        <td>Group button text</td>
                                        <td><input type="text" name="grouped_button_text" value="<?php if(empty( esc_attr( get_option('grouped_button_text')))){
                                            echo 'Grouped Product';
                                        }else{
                                            echo esc_attr( get_option('grouped_button_text'));} ?>" /><td>
                                    </tr>
                                    <tr>
                                        <td>External button text</td>
                                        <td><input type="text" name="external_button_text" value="<?php if(empty(esc_attr( get_option('external_button_text')))){
                                            echo "External button";
                                        }else{ echo esc_attr( get_option('external_button_text'));} ?>" /><td>
                                    </tr>
                                    <tr>
                                        <td>Variable button text</td>
                                        <td><input type="text" name="variable_button_text" value="<?php if(empty(esc_attr( get_option('variable_button_text')))){
                                            echo "Varibale button";
                                        }else{ echo esc_attr( get_option('variable_button_text'));} ?>" /><td>
                                    </tr>
                                    <tr>
                                        <td>Booking button text</td>
                                        <td><input type="text" name="booking_button_text" value="<?php if(empty(esc_attr( get_option('booking_button_text')))){
                                            echo "Booking Now";
                                        }else{echo esc_attr( get_option('booking_button_text'));} ?>" /><td>
                                    </tr>
                                    <tr>
                                        <td>Subscriptions button text</td>
                                        <td><input type="text" name="subs_button_text" value="<?php if(empty(esc_attr( get_option('subs_button_text')))){
                                            echo "Subscription now";
                                        }else{ echo esc_attr( get_option('subs_button_text')); } ?>" /><td>
                                    </tr>
                                </table>
                            </div>                  
                        </div>
                    </div>
                </div>
            </div>

            <!-- Start tab 4 -->

            <?php innovs_woo_ajax_save_btn(); ?>
            </form>
        </div>
  </div>
</div>


<!-- End main menu text filed area function  -->