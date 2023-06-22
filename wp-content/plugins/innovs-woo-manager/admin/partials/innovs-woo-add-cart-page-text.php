

<?php
/**
 * Submenu file
 * @package innovs woo single product page
 */
?>

<?php 

    global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM wp_cart_table" );
    foreach($results as $result);

if(isset($_POST['submit'])){
    $before_cart            = $_POST['before_cart'];
    $before_cart_table      = $_POST['before_cart_table'];
    $before_cart_contents   = $_POST['before_cart_contents'];
    $cart_coupon            = $_POST['cart_coupon'];
    $after_cart_contents    = $_POST['after_cart_contents'];
    $after_cart_totals          = $_POST['after_cart_totals'];
    $wpdb->update(
        'wp_cart_table', 
        array( 
            'before_cart' => $before_cart,
            'before_cart_table' => $before_cart_table,
            'before_cart_contents' => $before_cart_contents,	
            'cart_coupon' => $cart_coupon,
            'after_cart_contents' => $after_cart_contents,
            'after_cart_totals' => $after_cart_totals
        ), 
        array( 'id' => 1 )
        
    );
}
   

?> 
    <div class="panel innovs-panel-primary" style="margin-top:10px;">
    <form method="POST" action="#" id="innovs_woo_option_form">
        <div class="panel-heading innovs-panel-heading" >
            INNOVS WOO CART PAGE SETTINGS
            <input type="submit" name="submit" id="submit" class="button button-primary innovs_woo_save_btn" value="Save Changes" style="
                float: right;
                position: absolute;
                right: 24px;
                top: 11px;
                ackground: #540054 !important;
                border: none;
            ">
        </div>
       
            <div class="panel-body innovs-panel-body">
                <!-- Start tab menu -->
                <ul class="nav nav-tabs innovs-nav-tabs">
                    <!-- <li class="active"><a data-toggle="tab" href="#tab1">Default Button Settings</a></li>
                    <li><a data-toggle="tab" href="#tab2">Several Button settings</a></li> -->
                </ul>
            
                <!-- Start tab content -->
                <div class="tab-content">
                    <div id="tab1" class="tab-pane active">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-info innovs-panel-mt">
                                    <!-- <div class="panel-heading text-center">Product title settings</div> -->
                                    <div class="panel-body">
                                        <table class="innovs-table">
                                            <tr>
                                                <td> Add Text Before Cart</td>
                                                <td>
                                                     <textarea name="before_cart" id="" cols="50" rows="2"> <?php if(isset( $result->before_cart)){echo $result->before_cart;} ?></textarea>
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Add text before cart table</td>
                                                <td>
                                                    <textarea name="before_cart_table" id="" cols="50" rows="2"> <?php if(isset($result->before_cart_table)){echo $result->before_cart_table;} ?> </textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Add text before cart contents</td>
                                                <td>
                                                    <textarea name="before_cart_contents" id="" cols="50" rows="2"> <?php if(isset($result->before_cart_contents)){echo $result->before_cart_contents;} ?></textarea>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td> Add Text cart after coupon box</td>
                                                <td>
                                                    <textarea name="cart_coupon" id="" cols="50" rows="2"><?php if(isset( $result->cart_coupon)){echo $result->cart_coupon;} ?> </textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Add Text  after cart contents</td>
                                                <td>
                                                    <textarea name="after_cart_contents" id="" cols="50" rows="2"><?php if(isset($result->after_cart_contents)){echo $result->after_cart_contents;} ?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Add text after cart totals</td>
                                                <td>
                                                    <textarea name="after_cart_totals" id="" cols="50" rows="2"> <?php if(isset($result->after_cart_totals)){echo $result->after_cart_totals;} ?> </textarea>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>     <!--end col-md-12-->
                        </div>
                    </div>
                        <input type="submit" name="submit" id="submit" class="button button-primary innovs_woo_save_btn" value="Save Changes">
                    </form>
            </div>
        </div>
    </div>

   

