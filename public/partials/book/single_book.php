	<?php
  	if(isset($_GET['action']) && $_GET['action']== 'details' && isset($_GET['slug'])){
  		$service_slug = $_GET['slug'];

  		global $wpdb;


  		$get_service = $wpdb->get_row(
			"SELECT * FROM {$wpdb->prefix}mk_service WHERE slug='{$service_slug}' ORDER BY id DESC"
		);
  	}
  	?>

  	<div class="mk_home_service_section">
  		<div class="mk_container">
  			<div class="mk_home_service_title">
  				<h2><?php echo $get_service->title; ?></h2>
  			</div>
  			<div class="mk_home_service_content">

  				<div class="mk_single_service_content">
  					<div class="mk_single_service_details_content">
  						<img src="<?php echo $get_service->image; ?>" alt="<?php echo $get_service->title; ?>">
  						<hr>
  						<?php
  						if(!empty(get_option('currency'))){
							$currency = get_option('currency');
						}else{
							$currency = 'USD';
						}
						if($get_service->discount == '0' || $get_service->discount == null){
							echo "<p class='mk_home_service_price'>$".$get_service->price."</p>";
							$mk_booking_price = $get_service->price;
						}else{

							$discount_price = ($get_service->discount / 100) * $get_service->price;
							$after_discount_price = $get_service->price - $discount_price;
							$mk_booking_price = $after_discount_price;
							?>
							<p class="mk_home_service_price"><del><?php echo $currency.$get_service->price ?></del><small><?php echo $currency.$after_discount_price; ?></small></p>
							<span>Discount: <?php echo $get_service->discount; ?>%</span>
							<?php
						}
						?>
  						<hr>
  						<p><?php echo $get_service->description; ?></p>
  					</div>
  					<div class="mk_single_service_booking_details">
  						<h3 style="text-align: center;color:purple;font-size:24px;margin-top:30px;margin-bottom: 30px;">Booking Your service</h3>
  						<form method="post">
  							<p>
	  							<label>Name</label>
	  							<input type="text" name="customer_name" class="mk_form_control" required>
	  						</p>
	  						<p>
	  							<label>Email</label>
	  							<input type="email" name="customer_email" class="mk_form_control" required>
	  						</p>
	  						<p>
	  							<label>Phone</label>
	  							<input type="text" name="customer_phone" class="mk_form_control" required>
	  						</p>
	  						<p>
	  							<label>address</label>
	  							<input type="text" name="customer_address" class="mk_form_control" required>
	  						</p>
	  						<p>
	  							<label>Date</label>
	  							<input type="date" name="customer_date" class="mk_form_control" required>
	  						</p>
	  						<?php wp_nonce_field('new_booking'); ?>
	  						<button type="submit" class="mk_booking_btn" name="mk_booking_btn">Book Now</button>
  						</form>
  						<?php
						/** 
						 * submit post
						 */
						if(! isset($_POST['mk_booking_btn'])){
						    return;
						}{
							if(! wp_verify_nonce($_POST['_wpnonce'], 'new_booking')){
							    wp_die('<div class="mk_warning">Are you cheating?</div>');
							}

							if(! current_user_can('manage_options')){
							    wp_die('<div class="mk_warning" role="alert">Are you cheating?</div>');
							}

							$data['bookingID'] = "#mk".rand(000000,999999);
							$data['name'] = isset($_POST['customer_name']) ? sanitize_text_field($_POST['customer_name']) : '';
						    $data['email'] = isset($_POST['customer_email']) ? sanitize_textarea_field($_POST['customer_email']) : '';
						    $data['phone'] = isset($_POST['customer_phone']) ? sanitize_text_field($_POST['customer_phone']) : '';
						    $data['address'] = isset($_POST['customer_address']) ? sanitize_text_field($_POST['customer_address']) : '';
						    $data['service'] = $get_service->title;
						    $data['service_date'] = isset($_POST['customer_date']) ? sanitize_text_field($_POST['customer_date']) : '';
						    $data['payment_status'] = "Pending";
						    $data['status'] = "Processing";
						    
						    

							global $wpdb;

							$inserted = $wpdb->insert(
								"{$wpdb->prefix}mk_booking_service",
								$data,
								[
									'%s', '%s','%s','%s','%s', '%s', '%s', '%s', '%s'
								]
							);

							if($inserted){
								// echo '<div class="mk_success" role="alert">Success Your Booking</div>';
								$order_data = array(
									'name'=> $data['name'],
									'email' => $data['email'],
									'phone' => $data['phone'],
									'address' => $data['address']
								);

								if(!empty(get_option('productID'))){
									$productID = get_option('productID');
								}
								if(!empty(get_option('currency'))){
									$currency = get_option('currency');
								}

								$product = wc_get_product($productID,1);
								$product->set_price($mk_booking_price);

								$order = wc_create_order();
								$order->set_billing_address($order_data);
								$order->set_shipping_address($order_data);

								$order->set_currency($currency);

								$order->add_product($product);
								$order->set_customer_note($data['bookingID']);
								$order->calculate_totals();

								echo "<style>.mk_booking_btn{display:none !important;}</style>";
								echo "<a href='".$order->get_checkout_payment_url()."' class='pay_for_confirmation'>Pay for Confirmation</a>";
								echo "<br>";
								echo '<div class="mk_success" role="alert">Success Your Booking</div>';
								echo "<style>.pay_for_confirmation{
										background: purple;
									    display: inline-block;
									    color: #fff;
									    font-size: 16px;
									    padding: 4px 25px;
									    border-radius: 8px;
									    margin-top: 8px;
									    border:2px solid purple;
									    cursor: pointer;
									}</style>";

							}else{
								echo '<div class="mk_warning" role="alert">Data Not Insert</div>';
							}
							
						}
						?>
  					</div>
  				</div>

  			</div>
  		</div>
  	</div>
