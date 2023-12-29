<div class="mk_home_service_section">
	<div class="mk_container">
		<div class="mk_home_service_title">
			<h2>Home Service</h2>
		</div>
		<div class="mk_home_service_content">

			<?php
			global $wpdb;
			$mk_services = $wpdb->get_results(
				"SELECT * FROM {$wpdb->prefix}mk_service ORDER BY id DESC"
			);

			if(!empty(get_option('currency'))){
				$currency = get_option('currency');
			}else{
				$currency = 'USD';
			}

			if(count($mk_services) > 0){
				foreach($mk_services as $key=>$value){
			?>

			<div class="single_mk_home_service">
				<img src="<?php echo $value->image; ?>" alt="<?php echo $value->title; ?>">
				<div class="mk_home_service_text">
					<h2><?php echo $value->title; ?></h2>
					<?php
					if($value->discount == '0' || $value->discount == null){
						echo "<p class='mk_home_service_price'>".$currency.$value->price."</p>";
					}else{

						$discount_price = ($value->discount / 100) * $value->price;
						$after_discount_price = $value->price - $discount_price;

						?>
						<p class="mk_home_service_price"><del><?php echo $currency.$value->price ?></del><small><?php echo $currency.$after_discount_price; ?></small></p>
						<span>Discount: <?php echo $value->discount; ?>%</span>
						<?php
					}
					?>
					<a href="<?php echo get_permalink(); ?>?action=details&slug=<?php echo $value->slug; ?>" class="mk_booking_btn" id="mk_booking_btn">View Details</a>
				</div>
			</div>
			<?php
				}
			}	
			?>
		</div>
	</div>
</div>
