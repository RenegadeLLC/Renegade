<?php

    /*
        Template Name: Archives Getter
    */

//$year = htmlspecialchars(trim($_POST['year']));
//$month = htmlspecialchars(trim($_POST['month']));
//$cat = htmlspecialchars(trim($_POST['post_type']));


    
   // $querystring = "year=$year&monthnum=$month&post_type=$post_type&posts_per_page=-1";
    /*
function ajax_archive_posts_scripts() {
	// Enqueue script
	$scriptdir = get_template_directory_uri();
	$scriptdir .= '/library/js/';

	wp_register_script('archive_script', $scriptdir  . 'archive_getter.js', false, null, false);
	wp_enqueue_script('archive_script');

	wp_localize_script( 'archive_script', 'arc_vars', array(
			'arc_nonce' => wp_create_nonce( 'arc_nonce' ), // Create nonce which we later will use to verify AJAX request
			'arc_ajax_url' => admin_url( 'admin-ajax.php' ),
	)
			);
}

add_action('wp_enqueue_scripts', 'ajax_archive_posts_scripts', 100);

*/
global $month;
global $year;
global $post_type;
function load_archives(){
	//if(isset($_REQUEST)):
    	$year = $_REQUEST['year'];
    	$month = $_REQUEST['month'];
    	$post_type = $_REQUEST['post_type'];
    	//$year = json_encode($year);
   	//	$month = json_encode($month);
    	 //$post_type = json_encode($post_type);
   // endif;
 // echo($year . ' ' . $month . ' ' . $post_type);
    	die();
    }
    
    add_action('wp_ajax_load_archives', 'load_archives');
    add_action('wp_ajax_nopriv_load_archives', 'load_archives');
    
    $arc_args = array( 'post_type' => $post_type, 'posts_per_page' => -1 , 'orderby' => $order_by, 'order' => $order);
    $arc_loop = my_custom_query( $post_type, $taxonomy_type, $taxonomy_term, $orderby, $order, $meta_value);
    
  if ( $arc_loop->have_posts() ) :

	while ( $arc_loop->have_posts() ) : $arc_loop->the_post();
		if($post_type == 'articles'):
		  require( FUNCTIONS . 'articles_loop.php' );
		endif;
		
	endwhile;
	
endif;
    
?>