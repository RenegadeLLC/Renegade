<?php

function get_feed(){
	
	require_once( FUNCTIONS . 'feed_loops.php' );
	
//SET DEFAULT QUERY VARS
$post_type = get_sub_field('post_type');
$number_posts = get_sub_field('number_posts');
$orderby = get_sub_field('order_by');
$order = get_sub_field('order');
$taxonomy_type = '';
$taxonomy_term = '';
$meta_value = '';


$post_feed = '';
$post_feed .= '<div class="module scroller">';
$post_feed .= '<div class="' . $post_type . '">';
$post_feed .= '<div class="post-list-inner">';
$post_feed .= '<div class="post-list-ct" id="' . $post_type . '-ct">';


	$feed_loop_args = array( 
			'post_type' => $post_type, 
			'posts_per_page' => $number_posts, 
			'orderby' => $orderby, 
			'order' => $order
			
	);
	$i=0;
	$feed_loop = new WP_Query($feed_loop_args);
	
		if ( $feed_loop->have_posts() ) :
		
			while ( $feed_loop->have_posts() ) : $feed_loop->the_post();
			
				switch($post_type){
					
					case 'case_studies':
						//require( FUNCTIONS . 'case_studies_loop.php' );
					break;
					
					case 'articles':
						
						$articles = get_articles_feed($i);
						$i++;
						//echo($articles);
						$post_feed .= $articles;
						
					break;
							
					case 'newsletters':
					//	require( FUNCTIONS . 'newsletter_loop.php' );
					break;
							
					case 'blog':
						//require( FUNCTIONS . 'blog_loop.php' );
					break;
				};//end switch
			
			endwhile;
			
		endif;//end query
	$post_feed .= '</div><!--end-postlist-inner-->';

		if($number_posts> 1){
		
			//$post_feed .= '</div>';//ends posts with nav container
		
			$post_feed .= '<div class="dot-nav-vertical-ct">';
		
			$single_type_left = substr($post_type, 0, -1);
		
			for($i=0; $i< $number_posts; $i++){
				$post_feed .= '<div class="dot-nav" id="bt_' . $single_type_left . '_' . $i .'"></div>';
			}
		
			$post_feed .='</div>';//ends dot-nav container
				
		};

$post_feed .= '</div><!--end-postlist-ct-->';
$post_feed .= '</div></div></div><!--end module->';

wp_reset_postdata();

return($post_feed);

die();
}
