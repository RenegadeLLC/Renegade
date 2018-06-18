<?php
/**
 * AJAX posts filter
 *
 */

global $post_type;
global $tax_query_arr;
global $tax_queries;
global $taxonomy;
global $taxonomy_type;
global $taxonomy_term;
global $order;
global $orderB;
global $orderby;
global $orderbyB;
global $ra_publication; 
global $ra_date;
global $meta_value;
global $metakey;
global $post_type;
global $ra_loop;
global $loopHTML;
global $year;

$year_arr;
$pub_arr;

if ( isset($_REQUEST['orderby']) ) {
    $orderby = $_REQUEST['orderby'];
} else{
   $orderby = 'date';
}

if ( isset($_REQUEST['order']) ) {
    $orderby = $_REQUEST['order'];
}

if ( isset($_REQUEST['meta_value']) ) {
    $orderby = $_REQUEST['meta_value'];
}

$order = 'ASC';
$tax_query_arr = array();

$post_type = '';
$publication = '';


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
	
			foreach ( $terms as $term ){
			
				$term_link = get_term_link( $term, $tax );
				$listHTML .= '<div class="' . $tax . '"><a href="' . $term_link . '" class="tax-filter" title="' . $term->slug . '">' . $term->name . '</a></div> ';
			}
	
		$listHTML .= '</div>';
		 
		endif;

	return $listHTML;
}

// Script for sorting posts
function sort_posts( ) {
	
	$tax_query_arr = array(
	);
	
	if ( isset($_REQUEST) ) {
		$taxonomy_term = (isset($_REQUEST['taxonomy_term']) ? $_REQUEST['taxonomy_term'] : null);
		$taxonomy = (isset($_REQUEST['taxonomy']) ? $_REQUEST['taxonomy'] : null);
		$orderby = $_REQUEST['orderby'];
		$order = $_REQUEST['order'];
		$post_type = (isset($_REQUEST['post_type']) ? $_REQUEST['post_type'] : null);
		$publication = (isset($_REQUEST['publication']) ? $_REQUEST['publication'] : null);
		$metakey = (isset($_REQUEST['metakey']) ? $_REQUEST['metakey'] : null);
		$year = (isset($_REQUEST['year']) ? $_REQUEST['year'] : '');
	}


	if($taxonomy == 'post_tag'){
		$taxonomy = 'article_tags';
	} elseif($taxonomy == 'category'){
		$taxonomy = 'article_categories';
	}
	
	$tax_queries = 
			array(
			'taxonomy' => $taxonomy ,
			'field'    => 'slug',
			'terms'    => $taxonomy_term,
	);
	
	
	if($tax_queries){
		array_push($tax_query_arr, $tax_queries);
	}
	
	
	if(!$orderby):
        	$orderby = 'date';
	endif;
	
	if($orderby == 'meta_value'):
	   $metakey = 'ra_publication';
	   $orderbyB = 'date';
	   $orderB = 'DESC';
	endif;


	$articlesHTML .= '<div class="post-grid-gutter"></div>';
	
	$query_results = query_custom_posts($post_type, $orderby, $orderbyB, $orderB, $order, $taxonomy_term, $taxonomy, $tax_query_arr, $metakey);
	$articlesHTML .= $query_results;


	echo(   $articlesHTML );
	die();
}


// Script for filtering posts
function filter_posts( ) {
	$tax_query_arr = array(
	);
if ( isset($_REQUEST) ) {
		$taxonomy_term = (isset($_REQUEST['taxonomy_term']) ? $_REQUEST['taxonomy_term'] : null);
		$taxonomy = (isset($_REQUEST['taxonomy']) ? $_REQUEST['taxonomy'] : null);
		$orderby = $_REQUEST['orderby'];
		$order = $_REQUEST['order'];
		$post_type = (isset($_REQUEST['post_type']) ? $_REQUEST['post_type'] : null);
		$publication = (isset($_REQUEST['publication']) ? $_REQUEST['publication'] : null);
		$metakey = (isset($_REQUEST['metakey']) ? $_REQUEST['metakey'] : null);
		$year = (isset($_REQUEST['year']) ? $_REQUEST['year'] : '');
	}
 
if($taxonomy == 'post_tag'){
	$taxonomy = 'article_tags';
} elseif($taxonomy == 'category'){
	$taxonomy = 'article_categories';
}

if(!$orderby){
	$orderby = null;
}

if(!$order){
	$order = null;
}

if(!$publication){
	$publication = null;
}

if($taxonomy != null && $taxonomy_term != null):
$tax_queries =

	array(
			'taxonomy' => $taxonomy ,
			'field'    => 'slug',
			'terms'    => $taxonomy_term,
	);

endif;

if($tax_queries){
	array_push($tax_query_arr, $tax_queries);
}else{
	if(!is_array($tax_query_arr)):
		$tax_query_arr = 'nothing';
	endif;
}

if(isset($_POST['selected_metakey'])){$selected_metakey = $_POST['selected_metakey'];}else{
	$selected_metakey  = null;
}

$articlesHTML = '';

$articlesHTML .= '<div class="post-grid-gutter">' .  $year . '</div>';

  $query_results = query_custom_posts('articles', $orderby, $order, $taxonomy_term, $taxonomy, $tax_query_arr, $metakey, $year);
$articlesHTML .= $query_results;
	
 echo(   $articlesHTML );
  
  die(); 
}


add_action('wp_ajax_filter_posts', 'filter_posts');
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts');

add_action('wp_ajax_sort_posts', 'sort_posts');
add_action('wp_ajax_nopriv_sort_posts', 'sort_posts');


