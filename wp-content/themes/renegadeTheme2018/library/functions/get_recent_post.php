<?php

function get_recent_func($atts, $content = null){
	
	shortcode_atts( array('excerpt' => '', 'numberposts' => 0, 'post_type' => ''), $atts);
	
	$excerpt = $atts['excerpt'];
	$numberposts = $atts['numberposts'];
	$post_type = $atts['post_type'];
	$post_content = '';
	$rp_args = array(
			'posts_per_page' => $numberposts,
			'post_type' => $post_type,
			'order' => 'DESC',
			'orderby' => 'date'
	);
	
	$recent_post;
	$post_content;
	
	$i = 0;
	
	$single_type = substr($post_type, 0, -1);
	
	$the_query = new WP_Query( $rp_args );
	
	while ( $the_query->have_posts() ) : $the_query->the_post();
		
		$post_content .= '<div class="' . $single_type . ' post" id="' . $single_type . '_' . $i. '">';
		
		$permalink = get_permalink();
		
		$post_id = get_the_ID();
		
		if($post_type == 'post' || $post_type ==''){
			
			$post_content .= '<h2><a href="' . $permalink . '">' . the_title('', '', false) . '</a></h2>';
		
		} else if($post_type == 'articles') {
	
			$ra_title = the_title('', '', false);
			$ra_date = get_field('ra_date');
			$ra_author = get_field('ra_author');
			$ra_publication = get_field('ra_publication');
			$ra_url = get_field('ra_url', $post_id);
			
			
			$post_content .= '<h2><a href="' . $ra_url . '" target="_blank">' . $ra_title . '</h2></a>';
		
			$post_content .= '<div class="credits"><div class="ra-author">' . $ra_author . ' for</div> ';
			$post_content .= '<div class="ra-publication"> ' . $ra_publication . '</div></div>';
			$post_content .= '<div class="ra-date">' . $ra_date .  '</div>';
			
		} else if($post_type == 'newsletters'){
			
			$rn_date = '<div class="mod-newsletter-date"><div class="cut">THE CUT</div><div class="cut-date"> ' . get_field('rn_date') . '</div></div>';
			$rn_header = '<h2><a href="' . $permalink . '">' . the_title('', '', false) . '</a></h2>';	
			$post_content .= $rn_date . $rn_header;
		}
	
		if($excerpt == 'yes' || $excerpt == 'Yes'){
			
			if($post_type == 'post' || $post_type == ''){
				$post_date = get_the_date('j F Y | g:i a');
				$post_excerpt = get_the_excerpt();
				$post_content .= '<div class="post-date">';
				$post_content .= $post_date . '</div>';
				$post_content .= '<div class="excerpt">' . $post_excerpt . '</div><a href="' . $permalink . '"><div class="bt-black">Read It</div></a>';
		
			} else if($post_type =='articles') {
			
				$ra_url = get_field('ra_url', $post_id);
				$post_excerpt = get_field('ra_blurb', $post_id);
				$trimmed_excerpt = wp_trim_words( $post_excerpt, 55, '...' );
				
				$post_content  .= '<div class="excerpt">' . $trimmed_excerpt . '</div>';
				$post_content  .= '<a href="' . $ra_url . '" target="_blank"><div class="bt-black">READ IT</div></a>';

			} else if($post_type =='newsletters') {
				
				$post_excerpt = get_field('rn_introduction', $post_id);
				$post_content .= '<div class="excerpt">' . $post_excerpt . '</div>';
				$post_content .= '<a href="' . $permalink . '"><div class="bt-black">' . 'READ IT' . '</div></a>';
			}
		}
		
		$post_content .= '</div>';//ends post item div
		
		$i++;
		
		//$recent_post .= '</div>';//ends post item div
	endwhile;
	//$recent_post .= $post_content;
	wp_reset_postdata();
	
	return $post_content;

	// Reset Post Data
	



}

?>