<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://profiles.wordpress.org/innovs/
 * @since      1.0.0
 *
 * @package    Innovs_Woo_Manager
 * @subpackage Innovs_Woo_Manager/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Innovs_Woo_Manager
 * @subpackage Innovs_Woo_Manager/includes
 * @author     TheInnovs <theinnovs@gmail.com>
 */


define('IWM_FILE_DIR', plugin_dir_path(__FILE__));
class Innovs_Woo_Manager {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Innovs_Woo_Manager_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'INNOVS_WOO_MANAGER_VERSION' ) ) {
			$this->version = INNOVS_WOO_MANAGER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'innovs-woo-manager';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->innovs_woo_manager_admin_action();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Innovs_Woo_Manager_Loader. Orchestrates the hooks of the plugin.
	 * - Innovs_Woo_Manager_i18n. Defines internationalization functionality.
	 * - Innovs_Woo_Manager_Admin. Defines all hooks for the admin area.
	 * - Innovs_Woo_Manager_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-innovs-woo-manager-loader.php';
		require_once plugin_dir_path( dirname(__FILE__ ) ) . 'includes/class-innovs-woo-manager-checkout-field.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-innovs-woo-manager-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-innovs-woo-manager-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-innovs-woo-manager-public.php';
		
		/**
		 * The class responsible for defining Ajax
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/innovs-woo-ajax.php';

		/**
		 * The class responsible for defining CSS
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/innovs-woo-css.php';


		$this->loader = new Innovs_Woo_Manager_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Innovs_Woo_Manager_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Innovs_Woo_Manager_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Innovs_Woo_Manager_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Innovs_Woo_Manager_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Innovs_Woo_Manager_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public function innovs_woo_manager_admin_action(){
		add_action('admin_menu', array($this,'innovs_woo_manager_menu'));

		// Woocommerce add to cart button label hook
		add_filter( 'woocommerce_product_add_to_cart_text' , array($this , 'innovs_woo_manager_add_to_cart_label' ));
		add_filter( 'woocommerce_product_single_add_to_cart_text', array($this , 'innovs_woo_manager_add_to_cart_label' ));
		add_filter( 'woocommerce_booking_single_add_to_cart_text', array($this , 'innovs_woo_manager_add_to_cart_label' ));


		add_action('woocommerce_before_cart',array($this ,'woocommerce_before_cart'));
		add_action('woocommerce_before_cart_table',array($this ,'woocommerce_before_cart_table'));
		add_action('woocommerce_before_cart_contents',array($this ,'woocommerce_before_cart_contents'));
		add_action('woocommerce_cart_coupon',array($this ,'woocommerce_cart_coupon'));
		add_action('woocommerce_after_cart_contents',array($this ,'woocommerce_after_cart_contents'));
		add_action('woocommerce_after_cart_totals',array($this ,'woocommerce_after_cart_total'));
	}

	public function innovs_woo_manager_menu() {
		/**
		 * create new top-level menu
		 */
			add_menu_page(
				'innovs_woo_manager_menu', // Page title
				'Woo Manager', // Menu title
				'manage_options', // capability
				'parent_menu_slug', // menu slug
				array($this , 'innovs_woo_manager_main_menu_callback'), // callback function
				plugins_url( '../admin/img/', __FILE__ ).'icon-2.png', // Menu Icon
				15 ); // Position
		
			  /**
			   *  Product title and price page sub menu
			   */
			  add_submenu_page(
				'parent_menu_slug', // parent menu slug
				'innovs woo manager submenu', // submenu page title
				'Product title price', // submenu title
				'manage_options', // capability
				'slug_product_title_price', // submenu slug
				array($this , 'innovs_woo_product_title_price_callback')); // call back function
		
			 add_submenu_page(
				'parent_menu_slug', // parent menu slug
				'innovs woo manager submenu', // submenu page title
				'Single Product', // submenu title
				'manage_options', // capability
				'slug_single_product', // submenu slug
				array($this,'innovs_woo_single_product_callback')); // call back function
		
			/**
			 * Checkout Page submenu
			 */
			// add_submenu_page(
			// 	'parent_menu_slug', // parent menu slug
			// 	'innovs woo manager submenu', // submenu page title
			// 	'Add cart page text', // submenu title
			// 	'manage_options', // capability
			// 	'slug_cart_page', // submenu slug
			// 	array($this ,'innovs_woo_cart_page_callback')); // call back function
			
			 /**
			 * Increase Variable product submenu
			 */
			add_submenu_page(
				'parent_menu_slug', // parent menu slug
				'innovs woo manager submenu', // submenu page title
				'Increase Variation', // submenu title
				'manage_options', // capability
				'slug_increase_product_variation', // submenu slug
				array($this , 'innovs_woo_increase_product_variation_callback')); // call back function
			 /**
			 * Checkout fields submenu
			 */
			add_submenu_page(
				'parent_menu_slug', // parent menu slug
				'innovs woo manager submenu', // submenu page title
				'Checkout Fileds', // submenu title
				'manage_options', // capability
				'slug_checkout_field', // submenu slug
				array($this , 'innovs_woo_checkout_field_callback')); // call back function

			add_submenu_page(
				'parent_menu_slug', // parent menu slug
				null, // submenu page title
				null, // submenu title
				'manage_options', // capability
				'slug_checkout_shipping_field', // submenu slug
				array($this , 'innovs_woo_checkout_shipping_field_callback')); // call back function

			add_submenu_page(
				'parent_menu_slug', // parent menu slug
				'', // submenu page title
				'', // submenu title
				null, // capability
				'slug_checkout_order_field', // submenu slug
				array($this , 'innovs_woo_checkout_order_field_callback')); // call back function
		
		  
			//call register settings function
			add_action( 'admin_init', array($this , 'register_innovs_woo_main_menu_page_settings' )); //Woo Manager
			add_action( 'admin_init' , array($this , 'register_innovs_woo_submenu_product_title_price_page_setting' )); //
			add_action( 'admin_init', array($this , 'register_innovs_submenu_single_product_page_setting' )); //Single Product
			add_action( 'admin_init', array($this , 'register_innovs_submenu_increase_product_variation_page_setting' )); //incrase product variation
			//add_action( 'init', 'innovs_woo_cart_page' ); //Cart page
		}
		


/**
 * start Main menu page =========================================================
 */

//main menu callback function
function innovs_woo_manager_main_menu_callback() { 
	// include_once IWM_FILE_DIR . 'views/innovs-woo-mainmenu.php';
	require_once IWM_FILE_DIR . '../admin/partials/innovs-woo-mainmenu.php';
 }

function register_innovs_woo_main_menu_page_settings(){
    //register our settings
    register_setting( 'innovs-woo-manager-settings-group', 'button_text_color' );
	register_setting( 'innovs-woo-manager-settings-group', 'background_color' );
    register_setting( 'innovs-woo-manager-settings-group', 'font_size' );
    register_setting( 'innovs-woo-manager-settings-group', 'border_radius' );
    register_setting( 'innovs-woo-manager-settings-group', 'padding_top_bottom' );
    register_setting( 'innovs-woo-manager-settings-group', 'padding_left_right' );
    
    // Button Hover effect
    register_setting( 'innovs-woo-manager-settings-group', 'hover_text_color' ); 
    register_setting( 'innovs-woo-manager-settings-group', 'hover_background_color' );

    // Change grouped add to cart button style
    register_setting( 'innovs-woo-manager-settings-group', 'group_text_color');
    register_setting( 'innovs-woo-manager-settings-group', 'group_background');
    register_setting( 'innovs-woo-manager-settings-group', 'group_font_size');
    register_setting( 'innovs-woo-manager-settings-group', 'group_padding');
    register_setting( 'innovs-woo-manager-settings-group', 'group_border_radius');
    register_setting( 'innovs-woo-manager-settings-group', 'group_text_hover');
    register_setting( 'innovs-woo-manager-settings-group', 'group_background_hover');

    // Change Variable add to cart button style
    register_setting( 'innovs-woo-manager-settings-group', 'vari_text_color');
    register_setting( 'innovs-woo-manager-settings-group', 'vari_background');
    register_setting( 'innovs-woo-manager-settings-group', 'vari_font_size');
    register_setting( 'innovs-woo-manager-settings-group', 'vari_padding');
    register_setting( 'innovs-woo-manager-settings-group', 'vari_border_radius');
    register_setting( 'innovs-woo-manager-settings-group', 'vari_text_hover');
    register_setting( 'innovs-woo-manager-settings-group', 'vari_background_hover');

    // Change add to cart button label text 
    register_setting( 'innovs-woo-manager-settings-group', 'simple_button_text' );
    register_setting( 'innovs-woo-manager-settings-group', 'grouped_button_text' );
    register_setting( 'innovs-woo-manager-settings-group', 'external_button_text' );
    register_setting( 'innovs-woo-manager-settings-group', 'variable_button_text' );
    register_setting( 'innovs-woo-manager-settings-group', 'booking_button_text' );
    register_setting( 'innovs-woo-manager-settings-group', 'subs_button_text' );

    // Onsale label
    register_setting( 'innovs-woo-manager-settings-group', 'onsale_font_size' );
    register_setting( 'innovs-woo-manager-settings-group', 'onsale_color');
    register_setting( 'innovs-woo-manager-settings-group', 'onsale_background' );
    register_setting( 'innovs-woo-manager-settings-group', 'onsale_border_radius' );
    register_setting( 'innovs-woo-manager-settings-group', 'onsale_border_style' );
    register_setting( 'innovs-woo-manager-settings-group', 'onsale_border_color' );
        
}



function innovs_woo_manager_add_to_cart_label() {
    global $product;

    $product_type = $product->get_type(); 

    switch ( $product_type ) {
        case 'simple':
            return esc_attr( get_option('simple_button_text'));  

        break;
        case 'grouped':
            return esc_attr( get_option('grouped_button_text'));
        break;
        case 'external':
            return esc_attr( get_option('external_button_text'));
        break;
        case 'variable':
            return esc_attr( get_option('variable_button_text'));
        break;
        case 'booking':
            return esc_attr( get_option('booking_button_text'));
        break;
        case 'subscription':
            return esc_attr( get_option('subs_button_text'));
        break;
        default:
            return __( 'Read more', 'woocommerce' );
        } 
}

/**
 * End Main menu function ==============================================
 */

 /**
 * start submenu product title and price page =====================================
 */
function innovs_woo_product_title_price_callback(){
	require_once IWM_FILE_DIR . '../admin/partials/innovs-woo-product-title-price.php';
}
function register_innovs_woo_submenu_product_title_price_page_setting(){
    // Change product title style
    register_setting( 'innovs-woo-manager-product-title-price-settings', 'product_title_size' );
    register_setting( 'innovs-woo-manager-product-title-price-settings', 'product_title_color');
    register_setting( 'innovs-woo-manager-product-title-price-settings', 'title_text_align' );
    register_setting( 'innovs-woo-manager-product-title-price-settings', 'title_text_transform' );
    register_setting( 'innovs-woo-manager-product-title-price-settings', 'title_hover_color' );
    

    // Change product price
    register_setting( 'innovs-woo-manager-product-title-price-settings', 'price_title_size' );
    register_setting( 'innovs-woo-manager-product-title-price-settings', 'price_title_color');
    register_setting( 'innovs-woo-manager-product-title-price-settings', 'price_text_align' );
    register_setting( 'innovs-woo-manager-product-title-price-settings', 'price_hover_color' );
}
/**
 * End submenu product title and price page =====================================
 */

/**
 * start submenu sigle product page =====================================
 */

function innovs_woo_single_product_callback(){ // submenu callback function

	require_once IWM_FILE_DIR . '../admin/partials/innovs-woo-single-product.php';
}

//
function register_innovs_submenu_single_product_page_setting(){
    // Product title 
    register_setting('innovs-woo-single-product-page','single_product_color');
    register_setting('innovs-woo-single-product-page','single_product_title_size');
    register_setting('innovs-woo-single-product-page','single_product_title_text_transform');
    register_setting('innovs-woo-single-product-page','single_product_letter_spacing');
    register_setting('innovs-woo-single-product-page','single_product_title_text_decoration');
    register_setting('innovs-woo-single-product-page','single_product_dec_color');
    register_setting('innovs-woo-single-product-page','title_text_align');
    
    // Product short description
    register_setting('innovs-woo-single-product-page','desc_font_size');
    register_setting('innovs-woo-single-product-page','desc_text_color');
    register_setting('innovs-woo-single-product-page','short_description_border');
    register_setting('innovs-woo-single-product-page','desc_padding');
    register_setting('innovs-woo-single-product-page','desc_border_color');
    register_setting('innovs-woo-single-product-page','desc_background_color');
    register_setting('innovs-woo-single-product-page','desc_font_family');

    // Single product page single add to cart button
    register_setting('innovs-woo-single-product-page','single_atc_btn_color');
    register_setting('innovs-woo-single-product-page','single_atc_btn_bg');
    register_setting('innovs-woo-single-product-page','single_atc_btn_font_size');
    register_setting('innovs-woo-single-product-page','single_atc_btn_border_radius');
    register_setting('innovs-woo-single-product-page','single_atc_btn_padding_top_bottom');
    register_setting('innovs-woo-single-product-page','single_atc_btn_padding_left_right');
    
    
}
/**
 * End submenu sigle product page ====================================================
 */


/**
 * Start submenu add text cart page =======================================================
 */
function innovs_woo_cart_page_callback(){ // Checkout submenu callback function
	
	require_once IWM_FILE_DIR . '../admin/partials/innovs-woo-add-cart-page-text.php';
     
}

// // Cart page table =============================
// function cart_page_table () {
//     global $wpdb;
 
//     $table_name = $wpdb->prefix . "cart_table";

//     $charset_collate = $wpdb->get_charset_collate();

// $sql = "CREATE TABLE $table_name (
//   `id` int(11) NOT NULL,
//   `before_cart` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
//   `before_cart_table` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
//   `before_cart_contents` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
//   `cart_coupon` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
//   `after_cart_contents` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
//   `after_cart_totals` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

//     require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
//     dbDelta( $sql );

//     $wpdb->insert( 
//         $table_name, 
//         array( 
//             'id'        =>  1,
//             'before_cart' => 'before cart', 
//             'before_cart_table' => 'before cart table',
//             'before_cart_contents' => 'before cart contents',
//             'cart_coupon' => 'cart coupon',
//             'after_cart_contents' => 'after cart contents',
//             'after_cart_totals' => 'after cart totals'
//         ) 
//     );
//  }
//  register_activation_hook( __FILE__, 'cart_page_table' );
 
// function cart_table_delete(){
//     global $wpdb;
//     $wpdb->query("DROP TABLE IF EXISTS cart_table");
// }
// register_uninstall_hook(__FILE__, 'cart_table_delete');

// // End cart page table ============================
    function woocommerce_before_cart(){
        global $wpdb;
        $results = $wpdb->get_results( "SELECT * FROM wp_cart_table" );
        foreach($results as $result);
        ?>
        <tr><td><?php echo $result->before_cart; ?></td></tr>
        <?php
    }
    

    function woocommerce_before_cart_table(){
        global $wpdb;
        $results = $wpdb->get_results( "SELECT * FROM wp_cart_table" );
        foreach($results as $result);
        
        ?>
            <tr><td><?php echo $result->before_cart_table; ?></td></tr>
        <?php
    }
    

    function woocommerce_before_cart_contents(){
        global $wpdb;
        $results = $wpdb->get_results( "SELECT * FROM wp_cart_table" );
        foreach($results as $result);
        
        ?>
            <tr><td><?php echo $result->before_cart_contents; ?></td></tr>
        <?php
    }
    


    function woocommerce_cart_coupon(){
        global $wpdb;
        $results = $wpdb->get_results( "SELECT * FROM wp_cart_table" );
        foreach($results as $result);
        ?>
            <tr><td><?php echo $result->cart_coupon; ?></td></tr>
        <?php
    }
    

    function woocommerce_after_cart_contents(){
        global $wpdb;
        $results = $wpdb->get_results( "SELECT * FROM wp_cart_table" );
        foreach($results as $result);
        ?>
            <tr><td><?php echo $result->after_cart_contents; ?></td></tr>
        <?php
    }
    

    function woocommerce_after_cart_total(){
        global $wpdb;
        $results = $wpdb->get_results( "SELECT * FROM wp_cart_table" );
        foreach($results as $result);
        echo $result->after_cart_totals;
        ?>
            <tr><td><?php  echo $result->after_cart_totals; ?></td></tr>
        <?php
    }
    

	/**
	 * End submenu add text cart page =======================================================
	 */

	/**
	 * Increase variable product amount =====================================================
	 */
	function innovs_woo_increase_product_variation_callback(){ // increase product variation submenu callback function

		require_once IWM_FILE_DIR . '../admin/partials/innovs-woo-increase-product-variation.php';
		
	}

	function register_innovs_submenu_increase_product_variation_page_setting(){
		register_setting( 'innovs-woo-manager-product-variation-settings', 'increase_variable_pro' );
		$limit = get_option('increase_variable_pro');
		if ( ! defined( 'WC_MAX_LINKED_VARIATIONS' ) ) {
			define( 'WC_MAX_LINKED_VARIATIONS', $limit );
		}
	}
	/**
	 * Increase variable product amount =====================================================
	 */


	/**
	 * Checkout field input change =====================================================
	 */
	function innovs_woo_checkout_field_callback(){ // increase product variation submenu callback function

		require_once IWM_FILE_DIR . '../admin/partials/innovs-woo-checkout-fields.php';
		
	}
	/**
	 * Checkout field input change =====================================================
	 */

	 function innovs_woo_checkout_shipping_field_callback(){
		require_once IWM_FILE_DIR . '../admin/partials/innovs-woo-checkout-shipping-fields.php';
	 }

	 function innovs_woo_checkout_order_field_callback(){
		require_once IWM_FILE_DIR . '../admin/partials/innovs-woo-checkout-order-fields.php';
	 }

	
	

}
