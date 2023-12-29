<div class="wrap">
	<h1 class="wp-heading-inline">Services</h1>
	<a href="admin.php?page=mk_services&action=create" class="page-title-action">Add New Service</a>
	<hr>
	<table id="dataTable" class="display">
    	<thead>
    		<tr>
    			<th>SL</th>
    			<th>Image</th>
    			<th>Title</th>
    			<th>Price</th>
    			<th>Discount</th>
    			<th>Action</th>
    		</tr>
    	</thead>
    	<tbody>
    		<?php
    		if(count($mk_service_tables) > 0){
    			foreach($mk_service_tables as $key=>$value){
    				?>
    				<tr>
    					<td><?php echo ($key+1) ?></td>
    					<td><img width="50px" height="50px" src="<?php echo $value->image; ?>" /></td>
    					<td><?php echo $value->title; ?></td>
    					<td><?php echo $value->price; ?></td>
    					<td><?php echo $value->discount; ?></td>
    					<td>
    						<a href="<?php echo admin_url('admin.php?page=mk_services&action=edit&id='.$value->id); ?>" style="text-decoration: none"><span class="dashicons dashicons-edit-page"></span></a> &nbsp;|&nbsp;
    						<a href="<?php echo admin_url('admin.php?page=mk_services&action=delete&id='.$value->id); ?>" style="text-decoration: none" onclick="return confirm('Are you sure to delete it?');"><span class="dashicons dashicons-trash" style="color:red"></span></a>
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
    			<th>Image</th>
    			<th>Title</th>
    			<th>Price</th>
    			<th>Discount</th>
    			<th>Action</th>
    		</tr>
    	</tfoot>
    </table>
</div>
<script>
	let table = new DataTable('#dataTable');
</script>