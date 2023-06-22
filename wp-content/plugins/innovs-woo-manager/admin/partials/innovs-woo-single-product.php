<?php
/**
 * Submenu file
 * @package innovs woo single product page
 */
?>



    <div class="panel innovs-panel-primary" style="margin-top:10px;">
        <div class="panel-heading innovs-panel-heading" >INNOVS WOO SINGLE PRODUCT PAGE SETTINGS</div>
        <form method="post" action="options.php" id="innovs_woo_option_form">
            <div class="panel-body innovs-panel-body">
                <!-- Start tab menu -->
                <ul class="nav nav-tabs innovs-nav-tabs">
                    <!-- <li class="active"><a data-toggle="tab" href="#tab1">Default Button Settings</a></li>
                    <li><a data-toggle="tab" href="#tab2">Several Button settings</a></li> -->
                </ul>
            
                <!-- Start tab content -->
                <div class="tab-content">
                    <div id="tab1" class="tab-pane active">
                        <?php settings_fields( 'innovs-woo-single-product-page' ); ?>
                        <?php do_settings_sections( 'innovs-woo-single-product-page' ); ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="panel panel-info innovs-panel-mt">
                                    <div class="panel-heading text-center">Product title settings</div>
                                    <div class="panel-body">
                                        <table class="innovs-table">
                                            <tr>
                                                <td>Title text Color</td>
                                                <td>
                                                    <div>
                                                        <input class="innovs-color-picker" name="single_product_color" value="<?php echo esc_attr( get_option('single_product_color') ); ?>" />
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Font Size</Button></td>
                                                <td><input type="number" class="btc" name="single_product_title_size" value="<?php echo esc_attr( get_option('single_product_title_size') ); ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td>Text Transform</td>
                                                <td><select class="innovs-woo-single-product-select" name="single_product_title_text_transform">
                                                    <option value="<?php echo esc_attr(get_option('single_product_title_text_transform'));?>"><?php echo esc_attr(get_option('single_product_title_text_transform'));?></option>
                                                    <option value="Uppercase">Uppercase</option>
                                                    <option value="Lowercase">Lowercase</option>
                                                    <option value="Capitalize">Capitalize</option>
                                                    <option value="Unset">Unset</option>
                                                </select><td>
                                            </tr>
                                            <tr>
                                                <td>Letter Spacing</td>
                                                <td><input type="number" placeholder="5px" name="single_product_letter_spacing" value="<?php echo esc_attr( get_option('single_product_letter_spacing') ); ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td>Text Decoration</td>
                                                <td><select class="innovs-woo-single-product-select" name="single_product_title_text_decoration">
                                                    <option value="<?php echo esc_attr(get_option('single_product_title_text_decoration'));?>"><?php echo esc_attr(get_option('single_product_title_text_decoration'));?></option>
                                                    <option value="overline">overline</option>
                                                    <option value="line-through">line-through</option>
                                                    <option value="underline">underline</option>
                                                    <option value="underline overline">underline overline</option>
                                                    <option value="none">None</option>
                                                </select><td>
                                            </tr>
                                            <tr>
                                                <td>Decoration Color</td>
                                                <td> 
                                                    <div>
                                                        <input class="innovs-color-picker" name="single_product_dec_color" value="<?php echo esc_attr( get_option('single_product_dec_color') ); ?>" />
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-md-4">
                                <div class="panel panel-info innovs-panel-mt">
                                <div class="panel-heading text-center">Product Short Description</div>
                                    <div class="panel-body">
                                        <table class="innovs-table">
                                            <tr>
                                                <td>Font size</td>
                                                <td><input type="number" name="desc_font_size" value="<?php echo esc_attr( get_option('desc_font_size') ); ?>" class="my-color-field" /><td>
                                            </tr>
                                            <tr>
                                                <td>Text Color</td>
                                                <td><input class="innovs-color-picker" name="desc_text_color" value="<?php echo esc_attr( get_option('desc_text_color') ); ?>" class="my-color-field" /><td>
                                            </tr>
                                            <tr>
                                                <td>Border Style</td>
                                                <td><select class="innovs-woo-single-product-select" name="short_description_border">
                                                    <option value="<?php echo esc_attr(get_option('short_description_border'));?>"><?php echo esc_attr(get_option('short_description_border'));?></option>
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
                                                <td>Padding</td>
                                                <td><input type="number" name="desc_padding" value="<?php echo esc_attr( get_option('desc_padding') ); ?>" class="my-color-field" /><td>
                                            </tr>
                                            <tr>
                                                <td>Border Color</td>
                                                <td><input class="innovs-color-picker" name="desc_border_color" value="<?php echo esc_attr( get_option('desc_border_color') ); ?>" class="my-color-field" /><td>
                                            </tr>
                                            <tr>
                                                <td>Background Color</td>
                                                <td><input class="innovs-color-picker" name="desc_background_color" value="<?php echo esc_attr( get_option('desc_background_color') ); ?>" class="my-color-field" /><td>
                                            </tr>
                                            <!-- <tr>
                                                <td>Font family</td>
                                                <td><select class="innovs-woo-single-product-select" name="desc_font_family">
                                                    <option value="<?php //echo esc_attr(get_option('desc_font_family'));?>"><?php //echo esc_attr(get_option('desc_font_family'));?></option>
                                                    <option value="'Times New Roman', Times, serif">Serif</option>
                                                    <option value="'Arial Black', Gadget, sans-serif">Arial Black</option>
                                                    <option value="'Courier New', Courier, monospace">Courier New</option>
                                                    <option value="'Lucida Console', Monaco, monospace">Lucida Console</option>
                                                    <option value="sans-serif">sans-serif</option>
                                                    <option value="monospace">monospace</option>
                                                    <option value="cursive">cursive</option>
                                                    <option value="fantasy">fantasy</option>
                                                </select><td>
                                            </tr> -->
                                        </table>
                                    </div>
                                </div>
                            </div> <!--End 2nd col-4 -->

                            <div class="col-md-4">
                                <div class="panel panel-info innovs-panel-mt">
                                <div class="panel-heading text-center">Add to cart button settings</div>
                                    <div class="panel-body">
                                        <table class="innovs-table">
                                            <tr>
                                                <td>Button Text Color</Button></td>
                                                <td>
                                                    <div> <!-- atc = add to cart -->
                                                        <input  class="innovs-color-picker" name="single_atc_btn_color" value="<?php echo esc_attr( get_option('single_atc_btn_color') ); ?>" />
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Background Color</td>
                                                <td> 
                                                    <div>
                                                        <input class="innovs-color-picker" name="single_atc_btn_bg" value="<?php echo esc_attr( get_option('single_atc_btn_bg') ); ?>" />
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Font Size</Button></td>
                                                <td><input type="number" class="btc" name="single_atc_btn_font_size" value="<?php echo esc_attr( get_option('single_atc_btn_font_size') ); ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td>Border Radius</td>
                                                <td><input type="number" placeholder="5px" name="single_atc_btn_border_radius" value="<?php echo esc_attr( get_option('single_atc_btn_border_radius') ); ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td>Padding Top Bottom</td>
                                                <td><input type="number" placeholder="5px" name="single_atc_btn_padding_top_bottom" value="<?php echo esc_attr( get_option('single_atc_btn_padding_top_bottom') ); ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td>Padding left Right</td>
                                                <td><input type="number" placeholder="5px" name="single_atc_btn_padding_left_right" value="<?php echo esc_attr( get_option('single_atc_btn_padding_left_right') ); ?>" /></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div> <!--End 3rd col-4 -->

                        </div>
                    </div>
                    <?php innovs_woo_ajax_save_btn(); ?>
                    </form>
            </div>
        </div>
    </div>

   

