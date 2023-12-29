<div class="wrap">
	<h1 class="wp-heading-inline">Booking</h1>
	<hr>
	<table id="dataTable" class="display">
    	<thead>
    		<tr>
    			<th>SL</th>
    			<th>BookingID</th>
    			<th>Service</th>
    			<th>Booking Date</th>
    			<th>Payment Status</th>
                <th>Booking Status</th>
    			<th>Action</th>
    		</tr>
    	</thead>
    	<tbody>
    		<?php
    		if(count($mk_booking_tables) > 0){
    			foreach($mk_booking_tables as $key=>$value){
    				?>
    				<tr>
    					<td><?php echo ($key+1) ?></td>
    					<td><?php echo $value->bookingID; ?></td>
    					<td><?php echo $value->service; ?></td>
                        <td><?php echo $value->service_date; ?></td>
    					<td><?php echo $value->payment_status; ?></td>
                        <td><?php echo $value->status; ?></td>
    					<td>
    						<a href="<?php echo admin_url('admin.php?page=mk_booking&action=edit&id='.$value->id); ?>" style="text-decoration: none"><span class="dashicons dashicons-welcome-view-site"></span></a> 
    					</td>
    				</tr>
    				<?php
    			}
    		}
    		?>
    	</tbody>
    	<tfoot>
    		<tr>
		        <th>SL</th>
                <th>BookingID</th>
                <th>Service</th>
                <th>Booking Date</th>
                <th>Payment Status</th>
                <th>Booking Status</th>
                <th>Action</th>
    		</tr>
    	</tfoot>
    </table>
</div>
<script>
	let table = new DataTable('#dataTable');
</script>