<?php
/**
 * AJAX posts filter
 *
 */



function wtf( ) {
	

	if ( isset($_POST) ) {
	$sort = $_POST['sort'];
	}
	
	if($sort):
		$orderby = json_encode($sort);
	endif;

	 die();
}

add_action('wp_ajax_wtf', 'wtf');
add_action('wp_ajax_nopriv_wtf', 'wtf');


