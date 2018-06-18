<?php

function query_custom_posts($post_type, $order_by, $order, $taxonomy, $taxonomy_term ){
	
	//post_type
	//taxonomy filters
	//order ASC or DESC
	//order_by  - date / title/ meta_key
	
	$query_args = array( 
			'post_type' 		=> $post_type, 
			'posts_per_page' 	=> -1 , 
			'orderby' 			=> $order_by, 
			'order' 			=> $order,
			$taxonomy   		=> $taxonomy_term,
	);
	
	$query_loop = new WP_Query( $query_args );
	$loopHTML = '';
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

function testFunction($blah){
	return($blah);
}