<?php

function create_search_form($atts, $content = null){

	
	shortcode_atts( array('side' => '', 'numPosts' => ''), $atts);
	//define('IMAGES', TEMPLATEPATH .'/images/');
	//return '<div class="homeRow" ' . 'style="background:url(' . IMAGES . $atts['bk_img'] . '' . 'px; margin:'  . $atts['margin'] . 'px;">' . do_shortcode($content) . '</div>';
	$searchCode ='<div class="highlight-ct">';
	
	$side = $atts['side'];
	
	if($side = 'right'){
		$searchCode = '<div class="hightlight-cap-left"></div>';
	}
	
	$searchCode ='<div class="highlight-inner">';
	
	if($side = 'right'){
		$searchCode = '<div class="hightlight-cap-left"></div>';
	}
	
	get_search_form( );
	
	// Get the most recent post
	
	$searchCode .= do_shortcode($content) . '</div></div>';
	
	return $searchCode;


}

?>