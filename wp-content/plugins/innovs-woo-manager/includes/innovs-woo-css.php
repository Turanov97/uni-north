<?php

/**
 * Start Main menu style function===================================
 */
function innovs_woo_mainmenu_style(){
    ob_start();
    ?> 
    <style>
    .add_to_cart_button{
        color: <?php echo get_option('button_text_color'); ?> !important;
        background-color: <?php echo get_option('background_color'); ?> !important;
        font-size: <?php echo get_option('font_size'); ?>px !important;
        text-decoration: none !important;
        border: 0px !important;
        padding: <?php echo get_option('padding_top_bottom');?>px <?php echo get_option('padding_left_right'); ?> !important; 
        border-radius: <?php echo get_option('border_radius'); ?>px !important;
    }
    .add_to_cart_button:hover{
        color: <?php echo get_option('hover_text_color'); ?> !important;
        background-color: <?php echo get_option('hover_background_color'); ?> !important;
        text-decoration: none !important;
        border: 0px !important;
        border-radius: <?php echo get_option('border_radius'); ?>px !important;
    }

    /* Grouped button style */
    a.button.product_type_grouped {
       color: <?php echo get_option('group_text_color'); ?> !important;
       background: <?php echo get_option('group_background'); ?> !important;
       font-size: <?php echo get_option('group_font_size'); ?>px !important;
       padding: <?php echo get_option('group_padding'); ?>px !important;
       border-radius: <?php echo get_option('group_border_radius'); ?>px !important;
    }
    a.button.product_type_grouped:hover{
        color:<?php echo get_option('group_text_hover'); ?> !important;
        background: <?php echo get_option('group_background_hover'); ?> !important;
        text-decoration:none;
    }
    

    /*Variable button style */
    a.product_type_variable{
       color: <?php echo get_option('vari_text_color'); ?> !important;
       background-color:<?php echo get_option('vari_background'); ?> !important;
       font-size: <?php echo get_option('vari_font_size'); ?>px !important;
       padding: <?php echo get_option('vari_padding'); ?>px !important;
       border-radius: <?php echo get_option('vari_border_radius'); ?>px !important;
    }
    a.product_type_variable:hover{
        color:<?php echo get_option('vari_text_hover'); ?> !important;
        background-color:<?php echo get_option('vari_background_hover'); ?> !important;
        text-decoration:none;
    }

    /* Product title style */
    h2.innovs_woo_product_title{
        font-size: <?php echo get_option('product_title_size'); ?>px !important;
        color: <?php echo get_option('product_title_color'); ?> !important;
        text-align: <?php echo get_option('title_text_align'); ?> !important;
        text-transform: <?php echo get_option('title_text_transform'); ?> !important;
    }
    .innovs_woo_product_price{
        font-size: <?php echo get_option('price_title_size'); ?>px !important;
        color: <?php echo get_option('price_title_color'); ?> !important;
        
    }
    span.price{
        text-align: <?php echo get_option('price_text_align'); ?> !important;
    }
    .innovs_woo_product_price:hover{
        color: <?php echo get_option('price_hover_color'); ?> !important;
    }

    /* Onsale label */
    .innovs_woo_onsale {
        color: <?php echo get_option('onsale_color'); ?> !important;
        font-size: <?php echo get_option('onsale_font_size'); ?>px !important;
        background: <?php echo get_option('onsale_background'); ?> !important;
        border-radius: <?php echo get_option('onsale_border_radius'); ?>px !important;
        border-style: <?php echo get_option('onsale_border_style'); ?> !important;
        border-color: <?php echo get_option('onsale_border_color'); ?> !important;

    }

    </style> 
    <?php  } 
    
    add_action('wp_head','innovs_woo_mainmenu_style');
/**
 * End main menu style ===========================================================
 */


 /**
  * Start Single product page style function =================================================
  */
 function innovs_woo_single_product_page_style(){
    ob_start();
    ?>
      <style>
          /** Single product page Product title style code **/
         .innovs_woo_single_product_title {
            color: <?php echo get_option('single_product_color');?> !important;
            font-size: <?php echo get_option('single_product_title_size');?>px !important;
            text-transform: <?php echo get_option('single_product_title_text_transform');?> !important;
            letter-spacing: <?php echo get_option('single_product_letter_spacing');?>px !important;
            text-decoration: <?php echo get_option('single_product_title_text_decoration');?> !important;
            text-decoration-color:<?php echo get_option('single_product_dec_color');?> !important;
            text-align: <?php echo get_option('title_text_align');?> !important ;
         }

        /** Single product page Product description style code **/
         .woocommerce-product-details__short-description {
            font-size: <?php echo get_option('desc_font_size'); ?>px !important;
            color: <?php echo get_option('desc_text_color'); ?> !important;
            border-style: <?php echo get_option('short_description_border'); ?> !important; 
            padding: <?php echo get_option('desc_padding'); ?>px !important; 
            border-color: <?php echo get_option('desc_border_color'); ?> !important; 
            background: <?php echo get_option('desc_background_color'); ?> !important; 
            font-family: <?php echo get_option('desc_font_family'); ?> !important;

         }

         /** Single product page Product cart button style code **/
         .innovs_woo_single_product_cart_button {
            color: <?php echo get_option('single_atc_btn_color'); ?> !important;
            background: <?php echo get_option('single_atc_btn_bg'); ?> !important;
            font-size: <?php echo get_option('single_atc_btn_font_size'); ?>px !important;
            border-radius: <?php echo get_option('single_atc_btn_border_radius'); ?>px !important;
            padding: <?php echo get_option('single_atc_btn_padding_top_bottom'); ?>px <?php echo get_option('single_atc_btn_padding_left_right'); ?>px !important;

         }
         
      </style>
     
    <?php }
 
 add_action('wp_head','innovs_woo_single_product_page_style');
 /**
  * End submenu single product page =====================================================
  */