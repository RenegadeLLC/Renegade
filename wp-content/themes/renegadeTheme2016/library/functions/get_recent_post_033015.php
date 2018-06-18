<?php

function get_recent_func($atts, $content = null){
	
	shortcode_atts( array('excerpt' => '', 'numberposts' => 0, 'post_type' => ''), $atts);
	
	$excerpt = $atts['excerpt'];
	$numberposts = $atts['numberposts'];
	$post_type = $atts['post_type'];
	
	$rp_args = array(
			'posts_per_page' => $numberposts,
			'post_type' => $post_type
	);
	
	$the_query = new WP_Query( $rp_args );
	while ( $the_query->have_posts() ) : $the_query->the_post();
	
	$permalink = get_permalink();
	
	$post_id = get_the_ID();
	
	$post_content = '';
	
	if($post_type == 'post' || $post_type ==''){
		
	$post_content = '<a href="' . $permalink . '">' . the_title('<h5>', '</h5>', false) . '</a>';
	
	} else if($post_type =='articles') {
		
		$ra_title = the_title('<h2>', '</h2>', false);
		$ra_date = get_field('ra_date');
		$ra_author = get_field('ra_author');
		$ra_publication = get_field('ra_publication');
		$ra_url = get_field('ra_url', $post_id);
		//$ra_blurb = get_field('ra_blurb');
		
		$post_content = '<div class="articles-ct post-list-ct">';
		$post_content .= '<div class="ra-date">' . $ra_date . '</div>';
		$post_content .= '<a href="' . $ra_url . '" target="_blank">' . $ra_title . '</a>';
		$post_content .= '<div class="credits"><div class="ra-author">' . $ra_author . '</div> ';
		$post_content .= '<div class="ra-publication">' . $ra_publication . '</div></div>';
		
		
	} else if($post_type =='newsletters'){
		$post_content = '<div class="newsletters-ct post-list-ct">';
		$rn_date = '<div class="cut">THE CUT</div><div class="cut-date"> ' . get_field('rn_date') . '</div>';
		//$rn_header = get_field('rn_header');
		$rn_header = the_title('<h1>', '</h1>', false);
		//$rn_introduction = get_field('rn_introduction');
		
		$post_content .= $rn_date . $rn_header;
		
	}
	$recent_post = '';
	$recent_post .= $post_content;

	if($excerpt == 'yes' || $excerpt == 'Yes'){
		
		if($post_type == 'post' || $post_type == ''){
		
			$post_excerpt = get_the_excerpt();
			$recent_post .= '<div class="excerpt">' . $post_excerpt . '</div>';
	
		} else if($post_type =='articles') {
			$ra_url = get_field('ra_url', $post_id);
			$post_excerpt = get_field('ra_blurb', $post_id);
			$trimmed_excerpt = wp_trim_words( $post_excerpt, 55, '...' );
			$recent_post .= '<div class="excerpt">' . $trimmed_excerpt . '</div>';
			//$recent_post .= '<div class="bt-black">' . 'READ IT' . '</div>';
			$recent_post .= '<p><a href="' . $ra_url . '" target="_blank"><div class="bt-black">' . 'READ IT' . '</div></a>';
			$recent_post .= '</div>';//ends article container
			
		} else if($post_type =='newsletters') {
			
			$post_excerpt = get_field('rn_introduction', $post_id);
			$recent_post .= '<div class="excerpt">' . $post_excerpt . '</div>';
			$recent_post .= '<p><div class="bt-black">' . 'READ IT' . '</div>';
			$recent_post .= '</div>';//ends newsletter container
		}
		

		
	}
	
	endwhile;

	wp_reset_postdata();
	
	return $recent_post;

	// Reset Post Data
	



}

?>