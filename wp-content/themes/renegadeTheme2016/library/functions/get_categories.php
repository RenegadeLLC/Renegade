<?php

function get_categories_func($atts, $content = null){
	
	shortcode_atts( array('taxonomy' => '', 'show_count' => 1), $atts);
	
	
	if($atts){
		//$taxonomy = $atts['taxonomy'];
		$post_type = $atts['post_type'];
		//$title_li = $atts['title_li'];
		//$show_count = $atts['show_count'];
		
	}

	
	$cat_args = array(
			'title_li' => '',
			'echo' => 0,
			'hide_empty' => 1,
			'post_type' => $post_type
	);
	
	$categories = '<ul>';
	$categories .= wp_list_categories( $cat_args );
	$categories .= '</ul>';
	return $categories;

	// Reset Post Data
	



}
?>