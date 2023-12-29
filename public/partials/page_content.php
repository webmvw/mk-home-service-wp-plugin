<?php 

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
switch($action){
	case 'details':
		$template = plugin_dir_path(__FILE__). 'book/single_book.php';
		break;

	default:
		$template = plugin_dir_path( __FILE__ ). 'book/book_list.php';
		break;
}

if(file_exists($template)){
	include $template;
}

?>
