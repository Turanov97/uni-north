
<?php
/**
 * Submenu file
 * @package innovs submenu product title and price
 */
?>

<!-- Start product title and price -->
 
<div class="panel innovs-panel-primary" style="margin-top:10px;">
  <div class="panel-heading innovs-panel-heading">INNOVS WOO MANAGER PRODUCT TITLE AND PRICE SETTINGS</div>
  <form method="post" action="options.php" id="innovs_woo_option_form">
    <div class="panel-body innovs-panel-body">
        <!-- Start tab menu -->
        <ul class="nav nav-tabs innovs-nav-tabs" id="myTab">
            <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#tab4">Product Title & Price</a></li>
        </ul>
       
            
       
       
        <!-- Start tab content -->
        <div class="tab-content">
                <?php settings_fields( 'innovs-woo-manager-product-title-price-settings' ); ?>
                <?php do_settings_sections( 'innovs-woo-manager-product-title-price-settings' ); ?>

            <!-- Start tab 4 -->
            <div id="tab4" class="tab-pane active"> 
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-info innovs-panel-mt">
                            <div class="panel-heading text-center">Product title style</div>
                            <div class="panel-body">
                                <table class="innovs-table">
                                    <tr>
                                        <td>Title font size</td>
                                        <td><input type="number" name="product_title_size" value="<?php echo esc_attr( get_option('product_title_size') ); ?>"/><td>
                                    </tr>
                                    <tr >
                                        <td>Title Color</td>
                                        <td><input class="innovs-color-picker" name="product_title_color" value="<?php echo esc_attr( get_option('product_title_color') ); ?>" /><td>
                                    </tr>
                                    <tr>
                                        <td>Title text align</td>
                                        <td><select class="innovs-woo-cart-select" name="title_text_align">
                                            <option value="<?php echo esc_attr( get_option('title_text_align') ); ?>"><?php echo esc_attr( get_option('title_text_align') ); ?></option>
                                            <option value="Left">Left</option>
                                            <option value="Right">Right</option>
                                            <option value="Center">Center</option>
                                        </select><td>
                                    </tr>
                                    <tr>
                                        <td>Text Transform</td>
                                        <td><select class="innovs-woo-cart-select" name="title_text_transform">
                                            <option value="<?php echo esc_attr(get_option('title_text_transform'));?>"><?php echo esc_attr(get_option('title_text_transform'));?></option>
                                            <option value="Uppercase">Uppercase</option>
                                            <option value="Lowercase">Lowercase</option>
                                            <option value="Capitalize">Capitalize</option>
                                            <option value="Unset">Unset</option>
                                        </select><td>
                                    </tr>
                                </table>
                            </div>                  
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-info innovs-panel-mt">
                            <div class="panel-heading text-center">Product Price style</div>
                            <div class="panel-body">
                                <table class="innovs-table">
                                <tr>
                                        <td>Title font size</td>
                                        <td><input type="number" name="price_title_size" value="<?php echo esc_attr( get_option('price_title_size') ); ?>"/><td>
                                    </tr>
                                    <tr >
                                        <td>Title Color</td>
                                        <td><input class="innovs-color-picker" name="price_title_color" value="<?php echo esc_attr( get_option('price_title_color') ); ?>" /><td>
                                    </tr>
                                    <tr>
                                        <td>Price text align</td>
                                        <td><select class="innovs-woo-cart-select" name="price_text_align">
                                            <option value="<?php echo esc_attr( get_option('price_text_align') ); ?>"><?php echo esc_attr( get_option('price_text_align') ); ?></option>
                                            <option value="Left">Left</option>
                                            <option value="Right">Right</option>
                                            <option value="Center">Center</option>
                                        </select><td>
                                    </tr>
                                    <tr>
                                        <td>Hover Color</td>
                                        <td><input class="innovs-color-picker" name="price_hover_color" value="<?php echo esc_attr( get_option('price_hover_color') ); ?>"/><td>
                                    </tr>
                                </table>
                            </div>                  
                        </div>
                    </div> <!--End col md 4 -->

                    <div class="col-md-4">
                        <div class="panel panel-info innovs-panel-mt">
                            <div class="panel-heading text-center">Style onsale badge</div>
                            <div class="panel-body comming-soon">
                                <table class="innovs-table">
                                    <tr>
                                        <td> font size</td>
                                        <td><input type="number" name="onsale_font_size" value="<?php echo esc_attr( get_option('onsale_font_size') ); ?>"/><td>
                                    </tr>
                                    <tr >
                                        <td>Text Color</td>
                                        <td><input class="innovs-color-picker" name="onsale_color" value="<?php echo esc_attr( get_option('onsale_color') ); ?>" /><td>
                                    </tr>
                                    <tr>
                                        <td>Backgound</td>
                                        <td><input class="innovs-color-picker" name="onsale_background" value="<?php echo esc_attr( get_option('onsale_background') ); ?>"/><td>
                                    </tr>
                                    <tr>
                                        <td>Border Radius</td>
                                        <td><input type="number" name="onsale_border_radius" value="<?php echo esc_attr( get_option('onsale_border_radius') ); ?>"/><td>
                                    </tr>
                                    <tr>
                                        <td>Border style</td>
                                        <td><select class="innovs-woo-cart-select" name="onsale_border_style">
                                            <option value="<?php echo esc_attr( get_option('onsale_border_style') ); ?>"><?php echo esc_attr( get_option('onsale_border_style') ); ?></option>
                                                <option value="solid">solid</option>
                                                <option value="dotted">dotted</option>
                                                <option value="dashed">dashed</option>
                                                <option value="double">double</option>
                                                <option value="groove">groove</option>
                                                <option value="ridge">ridge</option>
                                                <option value="inset">inset</option>
                                                <option value="outset">outset</option>
                                                <option value="none">none</option>
                                        </select><td>
                                    </tr>
                                    <tr>
                                        <td>Border Color</td>
                                        <td><input class="innovs-color-picker" name="onsale_border_color" value="<?php echo esc_attr( get_option('onsale_border_color') ); ?>"/><td>
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