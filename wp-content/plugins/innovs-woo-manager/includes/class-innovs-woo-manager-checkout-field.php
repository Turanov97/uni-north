<?php

class innovs_woo_manager_checkout_field{

    

	public function __construct() {
		if ( defined( 'INNOVS_WOO_MANAGER_VERSION' ) ) {
			$this->version = INNOVS_WOO_MANAGER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'innovs-woo-manager';

        $this->iwm_checkout_fields_action_filter_hook();
        
    }
    

    function iwm_checkout_fields_action_filter_hook(){

        //add_filter( 'woocommerce_checkout_fields', array( $this , 'iwm_remove_billing_shipping_checkout_fields' ));
        add_filter( 'woocommerce_billing_fields', array( $this , 'iwm_remove_billing_shipping_checkout_fields' ),9999);
        add_filter( 'woocommerce_shipping_fields ', array( $this , 'iwm_remove_shipping_checkout_fields'),9999);

        //add_filter( 'woocommerce_checkout_fields', array( $this , 'order_comment'),9999);

        //add_filter( 'woocommerce_default_address_fields' , array( $this , 'iwm_override_default_billing_fields' ));

        add_filter( 'woocommerce_billing_fields' , array( $this , 'iwm_override_default_billing_fields' ));

        add_filter( 'woocommerce_shipping_fields' , array( $this , 'iwm_override_default_shipping_fields' ));

        //add_filter( 'woocommerce_enable_order_notes_field' , array( $this , 'iwm_override_default_order_fields' ));

        //add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
        


    }

 

    


    // Our hooked in function - $address_fields is passed via the filter!
    function iwm_override_default_billing_fields( $fields ) {

        global $wpdb;
        $checkout_field = $wpdb->prefix . 'woo_manage_checkout_field';
        $data = $wpdb->get_results("SELECT * FROM $checkout_field ORDER BY position asc");
      
    
        foreach($data as $datas):
    
            $required = $datas->input_required;
            if( $required === 'on'){
                $required = true;
            }else{
                $required = false;
            }
         
            $field_name = strtolower(str_replace(' ', '_', $datas->field_name));
            $fields['billing_'. $field_name] = array(
                'label'        => __( $datas->input_label ),
                'type'        => $datas->input_type,
                'class'        => array( $datas->input_width ),
                'priority'     => $datas->position,
                'placeholder'  => __( $datas->placeholder ),
                'required'     => $required,
            );
    
            $remove = $datas->input_remove;
            if($remove === 'on'){
                unset( $fields['billing_'. $field_name] );
            }else{
                $fields['billing_'. $field_name];
            }
            
    
        endforeach;
    
        return $fields;
        
    
    }

     // Our hooked in function - $address_fields is passed via the filter!
      public function iwm_override_default_shipping_fields( $fields ) {

        global $wpdb;
        $checkout_shipping_field = $wpdb->prefix . 'woo_manage_checkout_shipping_field';
        $data = $wpdb->get_results("SELECT * FROM $checkout_shipping_field ORDER BY s_position asc");
      
    
        foreach($data as $datas):
    
            $required = $datas->s_input_required;
            if( $required === 'on'){
                $required = true;
            }else{
                $required = false;
            }
         
            $field_name = strtolower(str_replace(' ', '_', $datas->s_field_name));
            $fields['shipping_'. $field_name] = array(
                'label'        => __( $datas->s_input_label ),
                'type'        => $datas->s_input_type,
                'class'        => array( $datas->s_input_width ),
                'priority'     => $datas->s_position,
                'placeholder'  => __( $datas->s_placeholder ),
                'required'     => $required,
            );

            $remove = $datas->s_input_remove;
            if($remove === 'on'){
                unset( $fields['shipping_'. $field_name] );
            }else{
                $fields['_'. $field_name];
            }
            
        endforeach;
    
        return $fields;
    }

    // Our hooked in function - $address_fields is passed via the filter!
    // public function iwm_override_default_order_fields( $fields ) {

    //     global $wpdb;
    //     $checkout_order_note_field = $wpdb->prefix . 'woo_manage_checkout_order_note';
    //     $data = $wpdb->get_results("SELECT * FROM $checkout_order_note_field ORDER BY o_position asc");
      
    
    //     foreach($data as $datas):
    
    //         $required = $datas->o_input_required;
    //         if( $required === 'on'){
    //             $required = true;
    //         }else{
    //             $required = false;
    //         }
         
    //         $field_name = strtolower(str_replace(' ', '_', $datas->o_field_name));
    //         $fields['order_'. $field_name] = array(
    //             'label'        => __( $datas->o_input_label ),
    //             'type'        => $datas->o_input_type,
    //             'class'        => array( $datas->o_input_width ),
    //             'priority'     => $datas->o_position,
    //             'placeholder'  => __( $datas->o_placeholder ),
    //             'required'     => $required,
    //         );

    //         $remove = $datas->o_input_remove;
    //         if($remove === 'on'){
    //             //unset( $fields['order_'. $field_name] );
    //             unset( $fields['order']['order_comments'] );
    //         }else{
    //             //$fields['_'. $field_name];
    //             $fields['order']['order_comments'];
    //         }
            
    //     endforeach;
    
    //     return $fields;
    // }


 

    function iwm_remove_billing_shipping_checkout_fields( $fields ) {

        
        unset( $fields['billing']['billing_email'] );

        unset( $fields['billing']['billing_company'] );

        unset( $fields['billing']['billing_country'] );

        unset( $fields['billing']['billing_phone'] );

        unset( $fields['billing']['billing_state'] );
       
        unset( $fields['billing']['billing_first_name'] );

        unset( $fields['billing']['billing_last_name'] );
        
        unset( $fields['billing']['billing_address_1'] );

        unset( $fields['billing']['billing_address_2'] );
       
        unset( $fields['billing']['billing_city'] );

        unset( $fields['billing']['billing_postcode'] );
        // End Billing fields ==================
        return $fields;
    }

    function iwm_remove_shipping_checkout_fields( $fields ){
        // Shipping fields ===============
      
            unset( $fields['shipping']['shipping_company'] );
    

     
            unset( $fields['shipping']['shipping_phone'] );
        

   
            unset( $fields['shipping']['shipping_state'] );
        

      
            unset( $fields['shipping']['shipping_first_name'] );
        

    
            unset( $fields['shipping']['shipping_last_name'] );
        
       
            unset( $fields['shipping']['shipping_address_1'] );
        
      
            unset( $fields['shipping']['shipping_address_2'] );
        
      
            unset( $fields['shipping']['shipping_city'] );
        
      
            unset( $fields['shipping']['shipping_postcode'] );

        
        return $fields;
    }

    // function order_comment( $fields ){
    //     // Order fields
    //     unset( $fields['order']['order_comments'] );
    //     add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
    //     return $fields;
    // }

   
    
    
   
    


}

new innovs_woo_manager_checkout_field();






?>