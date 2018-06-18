<?php

function ribbon_right($atts, $content = null){

	//<div class="ribbon-right">something longer goes here</div>
	shortcode_atts( array('side' => ''), $atts);
	
	$ribbonCode = '';
	
	$ribbonCode .= '<div class="highlight-ct">';
	
	$side = $atts['side'];
	
	if($side == 'right'){
		$ribbonCode .= '<div class="highlight-cap highlight-cap-left"></div>';
	}
	
	$ribbonCode .= '<div class="highlight-inner">' . do_shortcode($content) .'</div>';
	
	if($side == 'left'){
		$ribbonCode = '<div class="highlight-cap highlight-cap-right"></div>';
	}	
	
	// Get the most recent post
	
	$ribbonCode .= '</div>';
	
	return $ribbonCode;
}

?>