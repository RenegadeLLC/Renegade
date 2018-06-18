<?php
/**
 * AJAX posts filter
 *
 */

global $current_query;
global $order;
global $order_by;
global $meta_key;
global $taxonomy;
global $taxonomy_type;
global $selected_taxonomy;

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
global $ra_loop;
// Enqueue script
function ajax_filter_posts_scripts() {
  // Enqueue script
	$scriptdir = get_template_directory_uri();
	$scriptdir .= '/library/js/';
	
  wp_register_script('afp_script', $scriptdir  . 'ajax-filter-post.js', false, null, false);
  wp_enqueue_script('afp_script');

 
  
  wp_localize_script( 'afp_script', 'afp_vars', array(
        'afp_nonce' => wp_create_nonce( 'afp_nonce' ), // Create nonce which we later will use to verify AJAX request
        'afp_ajax_url' => admin_url( 'admin-ajax.php' ),
        'query_vars' => json_encode( $ra_loop->query )
  //'afp_ajax_url' => FUNCTIONS . 'ajax_filter_posts.php',
      )
  );

}

add_action('wp_enqueue_scripts', 'ajax_filter_posts_scripts', 100);


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

  $filter_args = array(
    $taxonomy_type   => $selected_taxonomy,
 //	'tag'            => 'social-media',
    'post_type'      => 'articles',
    'posts_per_page' => -1,
  );
 

  
  $query_results = query_custom_posts('articles', '', '', $taxonomy_type, $selected_taxonomy );

 
  $articlesHTML = '';

  $articlesHTML .= $query_results;
  
	$articlesHTML = json_encode($articlesHTML);
 
  echo(   $articlesHTML );

  die(); 
}



function sort_posts( ) {
	
	//$test=print_r($GLOBALS);
	$query_vars = json_decode( stripslashes( $_REQUEST['query_vars'] ), true );
	
	$type = $query_vars['post_type'];
	
	if ( isset($_REQUEST) ) {
	$sort = $_REQUEST['sort'];
	}
	
	if($sort):
		$orderby = json_encode($sort);
	endif;
	
	$sort_args=array(
		'post_type'=>'articles',
		'order_by'=>$orderby	
	);
	/*
	$args = array_merge( $ra_loop->query_vars, array( 'order_by' => $orderby ) );
	
	//$query_loop = query_posts( $sort_args );
	$query_loop = new WP_Query( $sort_args );
	$test='hola';
	if ( $query_loop->have_posts() ) :
	
	while ( $query_loop->have_posts() ) : $query_loop->the_post();
	$test .= 'hi';
	$loop_render = 'articles_loop.php';
	require( FUNCTIONS . $loop_render );
	
	endwhile;
	endif;

	
	

	$articlesHTML = '';
	
	$articlesHTML .= $loopHTML;
	
	$articlesHTML = json_encode($articlesHTML);
	
	//echo(   $articlesHTML );
*/

	echo $type;

	 die();
}

add_action('wp_ajax_filter_posts', 'filter_posts');
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts');

add_action('wp_ajax_sort_posts', 'sort_posts');
add_action('wp_ajax_nopriv_sort_posts', 'sort_posts');


