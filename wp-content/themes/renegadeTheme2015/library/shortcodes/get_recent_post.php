<?php

function get_recent_func($atts, $content = null){
	
	shortcode_atts( array('excerpts' => '', 'numberposts' => 0, 'post_type' => ''), $atts);
	
	
	$excerpts = $atts['excerpts'];
	$numberposts = $atts['numberposts'];
	$postType = $atts['post_type'];
	
	$rp_args = array(
			'posts_per_page' => $numberposts,
			'post_type' => $postType
			
	);
	
	$the_query = new WP_Query( $rp_args );
	while ( $the_query->have_posts() ) : $the_query->the_post();
	
	$permalink = get_permalink();
	$postTitle = '<a href="' . $permalink . '">' . the_title('<h5>', '</h5>', false) . '</a>';
	
	
	if($excerpts == 'yes' || $excerpts == 'Yes'){
		$postExcerpt = get_the_excerpt();
		$recentPost .= $postExcerpt;
	}


	$recentPost .= $postTitle;

	
	
	endwhile;

	return $recentPost;

	// Reset Post Data
	wp_reset_postdata();



}

?>