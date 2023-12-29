	<?php
  	if(isset($_GET['action']) && $_GET['action']== 'edit' && isset($_GET['id'])){
  		$edit_id = $_GET['id'];

  		global $wpdb;

  		$get_service = $wpdb->get_row(
			"SELECT * FROM {$wpdb->prefix}mk_service WHERE id={$edit_id} ORDER BY id DESC"
		);
  	}
  	?>

<div class="wrap">
	<h1 class="wp-heading-inline">Edit Service - <?php echo $get_service->title; ?></h1>
	<a href="admin.php?page=mk_services" class="page-title-action">Service</a>
	<hr>
	<h3>Edit Service</h3>
	<form method="post" enctype="multipart/form-data">

		<table cellpadding="10" width="50%">
			<colgroup>
			    <col style="width:15%">
			    <col style="width:85%">
			</colgroup> 
			<tr>
				<td>Title</td>
				<td><input type="text" name="title" value="<?php echo $get_service->title; ?>" class="mk_form_control" required /></td>
			</tr>
			<tr>
				<td>Description</td>
				<td><textarea name="description" class="mk_form_control" required ><?php echo $get_service->description; ?></textarea></td>
			</tr>
			<tr>
				<td>Price</td>
				<td><input type="number" name="price" class="mk_form_control" value="<?php echo $get_service->price; ?>" required /></td>
			</tr>
			<tr>
				<td>Discount</td>
				<td><input type="number" name="discount" class="mk_form_control" value="<?php echo $get_service->discount; ?>" /></td>
			</tr>
			<tr>
				<td>Service Image</td>
				<td>
					<span class="" id="txt_image" style="cursor: pointer;background: #ddd;border: 1px solid #2271B1;padding: 5px;border-radius: 5px;color: #2271B1;">Select Image</span><br><br>
		    		<img width="150px" height="150px" src="<?php echo $get_service->image; ?>" id="service_cover_image" />
		    		<input type="hidden" name="service_image" value="<?php echo $get_service->image; ?>" id="service_image">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<?php wp_nonce_field('update_service'); ?>
					<button type="submit" class="page-title-action" name="update_service">Update</button>
				</td>
			</tr>
		</table>
	</form>
</div>

<script type="text/javascript">
	jQuery(document).on("click", "#txt_image", function(){
		var image = wp.media({
			title:"Upload Service Image",
			multiple: false
		}).open().on("select", function(e){
			var upload_image = image.state().get("selection").first();
			var imagejson = upload_image.toJSON();
			jQuery("#service_cover_image").attr("src", imagejson.url);
			jQuery("#service_image").val(imagejson.url);
		});
	});
</script>

<?php
/** 
 * submit post
 */
if(! isset($_POST['update_service'])){
    return;
}{
	if(! wp_verify_nonce($_POST['_wpnonce'], 'update_service')){
	    wp_die('<div class="mk_warning">Are you cheating?</div>');
	}

	if(! current_user_can('manage_options')){
	    wp_die('<div class="mk_warning" role="alert">Are you cheating?</div>');
	}

	$data['title'] = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';

	$data['slug'] = sanitize_title($data['title']);

    $data['description'] = isset($_POST['description']) ? sanitize_textarea_field($_POST['description']) : '';
    $data['price'] = isset($_POST['price']) ? sanitize_text_field($_POST['price']) : '';
    $data['discount'] = isset($_POST['discount']) ? sanitize_text_field($_POST['discount']) : '';
    $data['image'] = isset($_POST['service_image']) ? sanitize_text_field($_POST['service_image']) : '';
    
	global $wpdb;

	$service_updated = $wpdb->update( 
			"{$wpdb->prefix}mk_service",
			array('title'=>$data['title'] ,'slug'=>$data['slug'], 'description'=>$data['description'], 'price'=>$data['price'], 'discount'=>$data['discount'], 'image'=>$data['image']),
			array( 'ID' => $edit_id ) 
		);

	if($service_updated){
		echo '<div class="mk_success" role="alert">Data Update Success</div>';
		$redirected_to = admin_url('admin.php?page=mk_services');
		wp_redirect($redirected_to);
	}else{
		echo '<div class="mk_warning" role="alert">Data Not Update</div>';
	}
	
}
?>