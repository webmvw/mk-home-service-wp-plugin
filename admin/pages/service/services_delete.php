<?php

if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])){

	$delete_id = $_GET['id'];

	global $wpdb;

	$deleted = $wpdb->delete(
		"{$wpdb->prefix}mk_service",
		array( 'ID' => $delete_id )
		);

	if($deleted){
		$message = '<div class="wrap">
						<a href="admin.php?page=mk_services" class="page-title-action">Service</a>
						<hr>
						<div class="mk_success" role="alert">Data Deleted Success</div>
					</div>';
		echo $message;
	}else{
		echo '<div class="mk_warning" role="alert">Data Not Deleted</div>';
	}

}
?>
	