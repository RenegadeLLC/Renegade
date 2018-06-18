<?php

function get_tags_func($atts, $content = null){
/*	
	shortcode_atts( array('taxonomy' => '', 'show_count' => 0), $atts);
	
	
	$taxonomy = $atts['taxonomy'];
	$title_li = $atts['title_li'];
	$show_count = $atts['show_count'];
	
	$cat_args = array(
			'title_li' => '',
			'echo' => 0
	);
	
	
	$tags = '<ul>';
	$tags .= get_the_tag_list();
	$tags .= '</ul>';
	*/
	
	$tag_args = array(
			'smallest'                  => 10,
			'largest'                   => 24,
			'unit'                      => 'pt',
			'number'                    => 45,
			'format'                    => 'flat',
			'separator'                 => ",\n",
			'orderby'                   => 'name',
			'order'                     => 'ASC',
			'exclude'                   => null,
			'include'                   => null,
//			'topic_count_text_callback' => default_topic_count_text,
			'link'                      => 'view',
			'taxonomy'                  => 'post_tag',
			'echo'                      => false,
			'child_of'                  => null, // see Note!
	);
	
	$tags = wp_tag_cloud($tag_args);
	
	return $tags;

	// Reset Post Data
	



}

?>