
<?php
    if(isset($_GET['action']) && $_GET['action']== 'edit' && isset($_GET['id'])){
        $edit_id = $_GET['id'];

        global $wpdb;

        $get_booking = $wpdb->get_row(
            "SELECT * FROM {$wpdb->prefix}mk_booking_service WHERE id={$edit_id} ORDER BY id DESC"
        );
    }
    ?>

<div class="wrap">
	<h1 class="wp-heading-inline">Edit Booking</h1>
    <a href="admin.php?page=mk_booking" class="page-title-action">Booking</a>
	<hr>
    <div class="mk_customer_booking_details">
        <h2><?php echo $get_booking->bookingID; ?> Details</h2>
        <small>Created_at: <?php echo $get_booking->created_at ?></small>
        <hr>
        <div class="mk_customer_booking_content">
            <div class="mk_customer_booking_status">
                <h3>Booking Status</h3>
                <hr>
                <form method="post">
                    <select name="status" class="mk_form_control">
                        <option value="Processing" <?php echo ($get_booking->status == "Processing")?'selected':'' ?>>Processing</option>
                        <option value="Complete" <?php echo ($get_booking->status == "Complete")?'selected':'' ?>>Complete</option>
                        <option value="Cancelled" <?php echo ($get_booking->status == "Cancelled")?'selected':'' ?>>Cancelled</option>
                    </select>
                    <?php wp_nonce_field('update_booking'); ?>
                    <br><br>
                    <button type="submit" class="page-title-action" name="update_booking">Update</button>
                </form>
            </div>
            <div class="mk_customer_booking_details_content">
                <h3>Booking Details</h3>
                <hr>
                <p><b>Booking ID</b>: <?php echo $get_booking->bookingID; ?></p>
                <p><b>Payment Status</b>: <?php echo $get_booking->payment_status; ?></p>
                <p><b>Service</b>: <?php echo $get_booking->service; ?></p>
                <p><b>Customer Info</b>:<br>
                 Name: <small> <?php echo $get_booking->name; ?></small><br>
                 Phone: <small> <?php echo $get_booking->phone; ?></small><br>
                 Email: <small> <?php echo $get_booking->email; ?></small><br>
                 Address: <small> <?php echo $get_booking->address; ?></small><br>
                 Booking Date: <small> <?php echo $get_booking->service_date; ?></small>
                </p>

            </div>
        </div>

        <?php
        /** 
         * submit post
         */
        if(! isset($_POST['update_booking'])){
            return;
        }{
            if(! wp_verify_nonce($_POST['_wpnonce'], 'update_booking')){
                wp_die('<div class="mk_warning">Are you cheating?</div>');
            }

            if(! current_user_can('manage_options')){
                wp_die('<div class="mk_warning" role="alert">Are you cheating?</div>');
            }

            $data['status'] = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : '';
            
            global $wpdb;

            $booking_updated = $wpdb->update( 
                    "{$wpdb->prefix}mk_booking_service",
                    array('status'=>$data['status']),
                    array( 'ID' => $edit_id ) 
                );

            if($booking_updated){
                echo '<div class="mk_success" role="alert">Booking Update Success</div>';
            }else{
                echo '<div class="mk_warning" role="alert">Booking Not Update</div>';
            }
            
        }
        ?>
        
    </div>
</div>
