
<?php
/**
 * Submenu file
 * @package innovs submenu increase product variation number
 */
?>

<!-- Start product title and price -->
 
<div class="panel innovs-panel-primary" style="margin-top:10px;">
  <div class="panel-heading innovs-panel-heading">INNOVS WOO INCREASE VARIABLE PRODUCT VARIATION</div>
  <form method="post" action="options.php" id="innovs_woo_option_form">
    <?php settings_fields( 'innovs-woo-manager-product-variation-settings' ); ?>
    <?php do_settings_sections( 'innovs-woo-manager-product-variation-settings' ); ?>
    <div class="panel-body innovs-panel-body">
        <!-- Start tab menu -->
        <ul class="nav nav-tabs innovs-nav-tabs" id="myTab">
            <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#tab">Increase Variable Product</a></li>
        </ul>
       
            
        <!-- Start tab content -->
        <div class="tab-content active">
            <div id="tab" class="tab-panel"> 
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-info innovs-panel-mt">
                            <div class="panel-heading text-center">Increase Variation Number</div>
                            <div class="panel-body" style="min-height:150px !important">
                                <table class="innovs-table">
                                    <tr>
                                        <td>Variation Limit</td>
                                        <td><input type="text" placeholder="50" name="increase_variable_pro" value="<?php echo esc_attr( get_option('increase_variable_pro') ); ?>"/><td>
                                    </tr>
                                    
                                </table>
                            </div>                  
                        </div>
                    </div>
                  
                </div>
            </div>

            <?php innovs_woo_ajax_save_btn(); ?>
        </form>
        </div>
  </div>
</div>


<!-- End main menu text filed area function  -->