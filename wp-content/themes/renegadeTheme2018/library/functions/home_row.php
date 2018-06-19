<?php

/**
Plugin Name: WordPress Social Slider Plugin
Version: 1.0
Author: Anne Rothschild
Copyright: 2013 Renegade
**/

function home_row_func($atts, $content = null)
{
	shortcode_atts( array('color' => ''), $atts);
	
	extract( shortcode_atts( array(
	'color' => ''
	), $atts ) );
	
    return '<div class="home_row ' . $atts['color'] . '"'  . $atts['margin'] . do_shortcode($content) . '</div>';
}
add_shortcode('home_row', 'home_row_func);

?>







