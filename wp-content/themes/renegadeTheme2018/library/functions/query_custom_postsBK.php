<?php
global $ra_publication;
global $meta_value;
global $metakey;
//function query_custom_posts($post_type, $order_by, $order, $taxonomy, $taxonomy_term, $selected_metakey  ){
	function query_custom_posts($post_type, $orderby, $order, $taxonomy_term, $taxonomy, $tax_query_arr, $metakey, $year){
/*
	if($taxonomy == 'categories'):
		$taxonomy = 'category_name';
	elseif($taxonomy == 'tags'):
		$taxonomy = 'tag';
	elseif(!$taxonomy):
		$taxonomy='';
	endif;
*/

	$query_args = array(
			'post_type' 		    => $post_type,
			'posts_per_page' 	=> -1,
			'orderby' 			=> $orderby,
			'order' 			    => $order,
			'meta_key'			=> $metakey,
			'year'				=> $year,
	        
		//	'tax_query' 		=> $tax_query_arr,	
	);


	/*	
	if($tax_query_arr == null || $tax_query_arr == '' || !$tax_query_arr):
		$tax_query_arr = 'nothing';
	endif;
*/

	$loopHTML = '';
	//$loopHTML .= '<div class="article-item post-grid-item post-grid-item-w-100"> tax_query_array:' . $tax_query_arr . '  post type: ' . $post_type . ' year: ' . $year .  '  orderby: ' . $orderby . '  order: ' . $order . '  metakey: ' . $metakey . '  taxonomy: ' . $taxonomy . '  taxonomy term: ' . $taxonomy_term . '</div>';
	
	
	$query_loop = new WP_Query( $query_args );
	
if ( $query_loop->have_posts() ) :
	
	while ( $query_loop->have_posts() ) : $query_loop->the_post();
        
        	$loop_render = $post_type . '_loop.php';
        	require( FUNCTIONS . $loop_render );
	
	endwhile;
		
endif;
	
return($loopHTML);

}
