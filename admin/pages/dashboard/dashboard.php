<div class="wrap">
	<h1 class="wp-heading-inline">MK Home Service Dashboard</h1>
	<hr>
    <p><mark>MK Home Service</mark> plugin support payment method via woocommerce. If the woocommerce plugin is not installed, install the plugin now. <a href="<?php echo site_url();?>/wp-admin/plugins.php">woocommerce</a></p>

    <div class="mk_home_service_dashboard">
        <div class="mk_home_service_dashboard_info_box">
            <div class="mk_info_box_icon">
                <span class="dashicons dashicons-groups"></span>
            </div>
            <div class="mk_info_box_content">
                <h1>
                <?php
                global $wpdb;
                $wpdb->get_results("
                                    SELECT * FROM " . $wpdb->prefix . "mk_booking_service 
                                        WHERE 
                                        status = 'Complete'
                                    "); 
                echo $wpdb->num_rows;
                ?>
                </h1>
                <p>Complete Order</p>
            </div>
        </div>
        <div class="mk_home_service_dashboard_info_box">
            <div class="mk_info_box_icon">
                <span class="dashicons dashicons-list-view"></span>
            </div>
            <div class="mk_info_box_content">
                <h1>
                <?php
                global $wpdb;
                $wpdb->get_results("
                                    SELECT * FROM " . $wpdb->prefix . "mk_booking_service 
                                        WHERE 
                                        status = 'Processing'
                                    "); 
                echo $wpdb->num_rows;
                ?>
                </h1>
                <p>Processing Order</p>
            </div>
        </div>
        <div class="mk_home_service_dashboard_info_box">
            <div class="mk_info_box_icon">
                <span class="dashicons dashicons-table-col-delete"></span>
            </div>
            <div class="mk_info_box_content">
                <h1>
                <?php
                global $wpdb;
                $wpdb->get_results("
                                    SELECT * FROM " . $wpdb->prefix . "mk_booking_service 
                                        WHERE 
                                        status = 'Cancelled'
                                    "); 
                echo $wpdb->num_rows;
                ?>
                </h1>
                <p>Cancelled Order</p>
            </div>
        </div>
        <div class="mk_home_service_dashboard_info_box">
            <div class="mk_info_box_icon">
                <span class="dashicons dashicons-admin-generic"></span>
            </div>
            <div class="mk_info_box_content">
                <h1>
                <?php
                global $wpdb;
                $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "mk_service "); 
                echo $wpdb->num_rows;
                ?>
                </h1>
                <p>Total Service</p>
            </div>
        </div>
    </div>

</div>
