<?php

function dec1_func(){
	return '<div class="dec-ct"><div class="dec1"></div></div>';
}

function ribbon_highlight_func($atts, $content = null){
	return '<div class="highlight-ct"><div class="highlight"><div class="highlight-inner">' .  do_shortcode($content) . '</div></div><div class="highlight-cap"></div></div>';
}

function arrow_highlight_func($atts, $content = null){
	return '<div class="arrow_highlight"><div class="arrow-highlight-inner">' .  do_shortcode($content) . '</div></div>';
}

function circ_func($atts, $content){
	shortcode_atts( array('id' => '', 'link' => '', 'size' =>''), $atts);

	extract( shortcode_atts( array(
	'id' => '', 'link' => '', 'size' =>'' ), $atts ) );
	
	if($atts['link'] != ''){ 
		return '<div class="circ ' . $atts['size'] . '"><div class="circ-inner"><a href="' . $atts['link'] . '">' . do_shortcode($content) . '</a></div></div>' ;
		} else if($atts['id'] != ''){
		return '<div class="circ anchor-link ' . $atts['size'] . '"' . ' id="' . $atts['id'] . '"><div class="circ-inner">' . do_shortcode($content) . '</div></div>' ;
	} else {
		return '<div class="circ ' . $atts['size'] . '"><div class="circ-inner">' . do_shortcode($content) . '</div></div>' ;
	}
	
}

?>