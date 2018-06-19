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
			'post_type' 		=> $post_type,
			'posts_per_page' 	=> -1,
			'orderby' 			=> $orderby,
			'order' 			=> $order,
			'meta_key'			=> $metakey,
			'year'				=> $year,
			//'tax_query' 		=> $tax_query_arr,	
	);

	/*
		$query_args = array(
				'post_type' 		=> $post_type,
				'posts_per_page' 	=> -1,
				'orderby' 			=> 'meta_value',
				'order' 			=> $order,
				'meta_key'			=> 'ra_publication',
				'year'				=> $year,
				//'tax_query' 		=> $tax_query_arr,
		);*/
		
		
	if($tax_query_arr == null || $tax_query_arr == '' || !$tax_query_arr):
		$tax_query_arr = 'nothing';
	endif;


	$loopHTML = '';
	//$loopHTML .= '<div class="article-item post-grid-item post-grid-item-w-100"> tax_query_array:' . $tax_query_arr . '  post type: ' . $post_type . ' year: ' . $year .  '  orderby: ' . $orderby . '  order: ' . $order . '  metakey: ' . $metakey . '  taxonomy: ' . $taxonomy . '  taxonomy term: ' . $taxonomy_term . '</div>';
	
	
	$query_loop = new WP_Query( $query_args );
	if ( $query_loop->have_posts() ) :
	
	while ( $query_loop->have_posts() ) : $query_loop->the_post();
	//echo 'query called';

	$loop_render = $post_type . '_loop.php';
	require( FUNCTIONS . $loop_render );
	
	/*$article_title = get_the_title();
	$ra_author = get_field('ra_author');
	$ra_publication = get_field('ra_publication');
	$ra_date = get_field('ra_date');
	$ra_url = get_field('ra_url');
	$ra_blurb = get_field('ra_blurb');
	
	$loopHTML .=  '<div class="article-item">';
	
	if($ra_date){
	 $loopHTML .=  '<div class="ra-date">' . $ra_date . $taxonomy_type . '</div>';
	 }
	
	if($ra_date){
		$loopHTML .=  '<div class="ra-date">' . $ra_date . '</div>';
	}
	
	if($ra_author){
		$loopHTML .=  '<div class="ra-author">' . $ra_author;
	}
	
	if($ra_publication ){
		$loopHTML .=  ' for ' . $ra_publication . '</div>';
	}
	
	if($ra_url){
		$loopHTML .=  '<a href="' . $ra_url . '" target=_blank>';
	}
	
	$loopHTML .= '<h3>' .  $article_title . '</h3>';
	
	if($ra_url){
		$loopHTML .=  '</a>';
	}
	if($ra_blurb){
		$loopHTML .=  '<div class="ra-blurb">' . $ra_blurb . '</div><div style="clear:both"></div>';
	}
	
	$loopHTML .=  '</div>';
	*/
	//END ARTICLES ITEM
	//var_dump($loopHTML);
	
	endwhile;
		
	endif;
	
	return($loopHTML);
}
