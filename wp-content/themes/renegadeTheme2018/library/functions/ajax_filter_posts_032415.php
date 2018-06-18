<?php
/**
 * AJAX posts filter
 *
 */

global $post_type;
global $taxonomy_type;
global $taxonomy_term;
global $order;
global $orderby;
global $meta_value;
global $post_type;
global $ra_loop;
global $loopHTML;

$order = 'ASC';
$order_by = 'date';
$taxonomy_type = '';
$selected_taxonomy = '';


function tags_filter($taxType){
	
	$taxargs = array(
			'orderby'           => 'name',
			'order'             => 'DESC',
			'hide_empty'        => 1,
	);
	
	$tax = $taxType;
	$terms = get_terms( $tax, $taxargs );
	$count = count( $terms );

	if ( $count > 0 ):
	 
	$listHTML = '<div class="post-tags">';

	foreach ( $terms as $term ) {
	
		$term_link = get_term_link( $term, $tax );
		$listHTML .= '<div class="' . $tax . '"><a href="' . $term_link . '" class="tax-filter" title="' . $term->slug . '">' . $term->name . '</a></div> ';
	}

	$listHTML .= '</div>';
	 
	endif;

	return $listHTML;
}




// Script for getting posts
function filter_posts( ) {

//if ( isset($_REQUEST) ) {
	$taxonomy = $_REQUEST['taxonomy'];
	$taxonomy_type = $_REQUEST['taxonomy_type'];
//}

$selected_taxonomy = json_encode($taxonomy);

if($taxonomy_type == 'post_tag'){
	$taxonomy_type = 'tag';
} elseif($taxonomy_type == 'category'){
	$taxonomy_type = 'category_name';
	 
}



  
  $query_results = query_custom_posts('articles', '', '', $taxonomy_type, $selected_taxonomy );

 
  $articlesHTML = '';

  $articlesHTML .= $query_results;
  
	$articlesHTML = json_encode($articlesHTML);
 
  echo(   $articlesHTML );

  die(); 
}



function sort_posts( ) {
	
	
	//if ( isset($_POST) ) {
	//$sort = $_POST['orderby'];
	$taxonomy = $_POST['taxonomy'];
	$taxonomy_term = $_POST['taxonomy_term'];
	$order = $_POST['order'];
	$orderby = $_POST['orderby'];
	//$query = $_POST['query'];
	//}
	
	if($orderby):
		$orderby = json_encode($orderby);
	endif;
	
	if($taxonomy_term):
	$taxonomy_term = json_encode($taxonomy_term);
	endif;
	
	if($taxonomy):
	$taxonomy = json_encode($taxonomy);
	endif;
	
	
	/*
	if($query):
	$query = json_encode($query);
	endif;
	
	var_dump($query);
	
		
  
	$ra_loop = my_custom_query( $args);
   if ( $query->have_posts() ) :
   
   while ( $query->have_posts() ) : $query->the_post();
   
   $loop_render = 'articles_loop.php';
   require( FUNCTIONS . $loop_render );
   
   endwhile;
   endif;
    
   
	
	
*/

	echo( $taxonomy_term);

	 die();
}

add_action('wp_ajax_filter_posts', 'filter_posts');
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts');

add_action('wp_ajax_sort_posts', 'sort_posts');
add_action('wp_ajax_nopriv_sort_posts', 'sort_posts');


