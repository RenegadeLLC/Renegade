<?php
/**
 * Partial template for content 
 *
 * @package understrap
 */


	$title = get_the_title( $post -> ID);
	$date = get_the_date('F j, Y', $post -> ID);
	$excerpt= get_the_excerpt();
	$link = get_permalink($post -> ID);
	$post_edit_link = get_edit_post_link();

	    
	$post_html = '';
	

	//$post_html .= '<div class="feed-item post-item col-lg-4 col-md-6 col-sm-12 newsletter-excerpt resource-excerpt">';	
	
	$post_html .= '<a href="' . $link . '">';
	$post_html .= '<div class="post-label-ct">BLOG</div>';
	$post_html .= '<h3>' . $title . '</h3>';
	$post_html .= '<div class="date">' . $date . '</div>';
	$post_html .= '<div class="excerpt">' . $excerpt . '</div>';
	$post_html .= '</a>';	
	$post_html .= '<div><a href="' . $post_edit_link  . '">' . 'Edit'  . '</a></div>';
	//$post_html .= '</div><!-- .post-item -->';
		
    echo($post_html);
		
		/*wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
			'after'  => '</div>',
		) );*/
		?>




