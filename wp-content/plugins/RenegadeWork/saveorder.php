<?php

function my_save_item_order() {
	
 global $wpdb;
 //	$order = $_POST['order'];
    $order = explode(',', $_POST['order']);
    $counter = 0;
    
  foreach ($order as $item_id) {
        $wpdb->update($wpdb->posts, array( 'menu_order' => $counter ), array( 'ID' => $item_id) );
        $counter++;
    }
    die(1);
}
add_action('wp_ajax_item_sort', 'my_save_item_order');
add_action('wp_ajax_nopriv_item_sort', 'my_save_item_order');
/*
function reorder_posts( $order = array() ) {
	global $wpdb;
	$list = join(', ', $order);
	$wpdb->query( 'SELECT @i:=-1' );
	$result = $wpdb->query(
			"UPDATE wp_posts SET menu_order = ( @i:= @i+1 )
			WHERE ID IN ( $list ) ORDER BY FIELD( ID, $list );"
	);
	return $result;
}
*/
?>