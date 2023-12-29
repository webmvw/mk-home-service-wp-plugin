<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://webmkit.com
 * @since      1.0.0
 *
 * @package    Home_service
 * @subpackage Home_service/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Home_service
 * @subpackage Home_service/admin
 * @author     webmk <masudrana.bbpi@gmail.com>
 */
class Home_service_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Home_service_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Home_service_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/home_service-admin.css', array(), $this->version, 'all' );

		wp_enqueue_style( "dataTables", plugin_dir_url( __FILE__ ) . 'css/jquery.dataTables.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Home_service_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Home_service_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */


		wp_enqueue_media();
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/home_service-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( "dataTables", plugin_dir_url( __FILE__ ) . 'js/jquery.dataTables.min.js', array( 'jquery' ), $this->version, false );

	}


	public function home_service_admin_menu(){
		add_menu_page( "Home Service", "Home Service", "manage_options", "mk_home_service", array($this, 'home_service_dashboard') );
		add_submenu_page( "mk_home_service", "Dashboard", "Dashboard", "manage_options", "mk_home_service", array($this, 'home_service_dashboard') );
		add_submenu_page( "mk_home_service", "Booking", "Booking", "manage_options", "mk_booking", array($this, 'callback_mk_booking') );
		add_submenu_page( "mk_home_service", "Services", "Services", "manage_options", "mk_services", array($this, 'callback_mk_services') );
		add_submenu_page( "mk_home_service", "Settings", "Settings", "manage_options", "mk_settings", array($this, 'callback_mk_settings') );
	}

	public function home_service_dashboard(){
		include(plugin_dir_path(__FILE__).'pages/dashboard/dashboard.php');
	}

	public function callback_mk_booking(){
		global $wpdb;
		$mk_booking_tables = $wpdb->get_results(
			"SELECT * FROM {$wpdb->prefix}mk_booking_service ORDER BY id DESC"
		);

		$action = isset($_GET['action']) ? $_GET['action'] : 'list';
		switch($action){

			case 'edit':
				$template = plugin_dir_path(__FILE__). 'pages/booking/booking_edit.php';
				break;

			default:
				$template = plugin_dir_path( __FILE__ ). 'pages/booking/booking_list.php';
				break;
		}

		if(file_exists($template)){
			include $template;
		}
	}

	public function callback_mk_services(){
		global $wpdb;
		$mk_service_tables = $wpdb->get_results(
			"SELECT * FROM {$wpdb->prefix}mk_service ORDER BY id DESC"
		);

		$action = isset($_GET['action']) ? $_GET['action'] : 'list';
		switch($action){
			case 'create':
				$template = plugin_dir_path(__FILE__). 'pages/service/services_create.php';
				break;

			case 'edit':
				$template = plugin_dir_path(__FILE__). 'pages/service/services_edit.php';
				break;

			case 'delete':
				$template = plugin_dir_path( __FILE__ ). 'pages/service/services_delete.php';
				break;

			default:
				$template = plugin_dir_path( __FILE__ ). 'pages/service/services_list.php';
				break;
		}

		if(file_exists($template)){
			include $template;
		}
	}

	public function callback_mk_settings(){
		?>
		<div class="wrap">
			<?php settings_errors(); ?>
			<form action="options.php" method="post">
				<?php
				settings_fields( 'primary_settings_group' );
				do_settings_sections( 'primary_settings_page' );
				submit_button( 'Save Changes');
				?>
			</form>
			<hr>
			<p><b>Note:</b> When you install this plugin it creates a <b>"Home Service"</b> page by default. Also, you can set the booking section anywhere by using this <mark>[render_home_service_page]</mark> shortcode.</p>
			<p>Also, you can do anything booking section by using the action hook.</p>
			<h4>Hook List</h4>
			<ul>
				<li>-> mk_home_service_before_page</li>
				<li>-> mk_home_service_after_page</li>
			</ul>
		</div>
		<?php
	}


	public function mk_home_service_settings(){
		/**
		 * ================================================================================
		 *	Settings API Section
		 * ================================================================================ 
		 */

		// Section for primary settings
		add_settings_section( 
			'primary_settings_id', // ID
			"MK Home Service Settings page", // Title
			array($this, "mk_home_service_primary_settings"), // Callback 
			"primary_settings_page" // page
		);


		/**
		 * ================================================================================
		 *	Settings API add settings field
		 * ================================================================================ 
		 */
		// settings field for primary settings
		add_settings_field( 
			"productID", // ID
			"Product ID", // Title
			array($this, 'product_id_callback'), // callback
			'primary_settings_page', //page
			'primary_settings_id' // section
		);
		add_settings_field( 
			"currency", // ID
			"Currency", // Title
			array($this, 'currency_callback'), // callback
			'primary_settings_page', //page
			'primary_settings_id' // section
		);


		/**
		 * ================================================================================
		 *	Settings API register settings
		 * ================================================================================ 
		 */
		// register settings for primary settings
		register_setting(
			"primary_settings_group", // option group
			"productID", // option name
			array('sanitize_callback'=>'esc_attr') // args 
		);
		register_setting(
			"primary_settings_group", // option group
			"currency", // option name
			array('sanitize_callback'=>'esc_attr') // args 
		);

	}

	public function mk_home_service_primary_settings(){
		echo "Here you can set all the options by using the Settings API";
	}
	public function product_id_callback(){
		$setting = get_option('productID');
		?>
		<input type="text" name="productID" value="<?php echo isset($setting)? esc_attr($setting):''; ?>">
		<label>Please input product ID. It's important for payment gateway.</label><hr>
		<p>Create a woocommerce product by using the title "MK Home Service" or anything. Then you will able to see this product ID. Copy this product ID and past here.</p>
		<?php
	}
	public function currency_callback(){
		$setting = get_option('currency');
		?>
		<input type="text" name="currency" value="<?php echo isset($setting)? esc_attr($setting):''; ?>">
		<label>Please input Currency. Otherwise, it will use woo-commerce default currency.</label>
		<?php
	}




	public function mk_home_service_order_status_processing($order_id){
		global $wpdb;
		$order = wc_get_order($order_id);
		$bookingId = $order->get_customer_note();

		if($bookingId){
			$wpdb->update(
				"{$wpdb->prefix}mk_booking_service",
				array('payment_status' => 'Paid'),
				array('bookingID' => $bookingId)
			);
		}
	}



	public function mk_home_service_activated_plugin(){
		if(plugin_basename( __FILE__ ) == $plugin){
			wp_redirect( admin_url('admin.php?page=mk_settings') );
			die();
		}
	}

	public function mk_home_service_plugin_action_link($link){
		$setting = sprintf("<a href='%s'>%s</a>",admin_url('admin.php?page=mk_settings'),'Settings');
		array_push( $link, $setting );
		return $link;
	}


}
