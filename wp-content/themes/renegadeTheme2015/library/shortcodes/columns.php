<?php

function one_half_func($atts, $content = null)
{
	shortcode_atts( array(), $atts);
	
 //return '<div class="col_one_half" ' . 'style="padding:' . $atts['padding'] . 'px; margin:'  . $atts['margin'] . 'px;">' . do_shortcode($content) . '</div>';
    
    return '<div class="col_one_half"">' . do_shortcode($content) . '</div>';
}

function one_half_last_func($atts, $content = null)
{
	shortcode_atts( array(), $atts);
	
	return '<div class="col_one_half"">' . do_shortcode($content) . '</div>'.'<div style="clear:both"></div>';
}

function home_row($atts, $content = null)
{
	shortcode_atts( array('bk_color' => '#ffffff', 'bk_img' => ''), $atts);
	define('IMAGES', TEMPLATEPATH .'/images/');
	return '<div class="homeRow" ' . 'style="background:url(' . IMAGES . $atts['bk_img'] . '' . 'px; margin:'  . $atts['margin'] . 'px;">' . do_shortcode($content) . '</div>';
}


function col_inner_func($atts, $content){
	shortcode_atts( array('more_css' => '', 'more_class' => ''), $atts);
	
	extract( shortcode_atts( array(
	'more_css' => '',
	'more_class' => ''
	), $atts ) );
	
	$html = '<div class="col_inner';
	
	if($atts['more_class'] != ''){
		$html .= ' ' . $atts['more_class'] . '"';
	} else{
		$html .= '"';
	}
	if($atts['more_css'] != ''){
		$html .= 'style="' . $atts['more_css'] . '">';
	} else{
		$html .='>';
	}
	
	$html .= do_shortcode($content) . '</div>';
	
	return $html;
	
	//return '<div class="col_inner ' .  $atts['more_class'] . '" ' . 'style="' . $atts['more_css'] . '">' . do_shortcode($content) . '</div>';
}

function three_cols_func($atts, $content){
	shortcode_atts( array('more_css' => '', 'more_class' => ''), $atts);
	
	extract( shortcode_atts( array(
	'more_css' => '',
	'more_class' => ''
			), $atts ) );
	
	//return '<div class="three_cols' .  $atts['more_class'] . '" ' . 'style="' . $atts['more_css'] . '">' . do_shortcode($content) . '</div>';
	
	$html = '<div class="three_cols';
	
	if($atts['more_class'] != ''){
		$html .= ' ' . $atts['more_class'] . '"';
	} else{
		$html .= '"';
	}
	if($atts['more_css'] != ''){
		$html .= 'style="' . $atts['more_css'] . '">';
	} else{
		$html .='>';
	}

	$html .= do_shortcode($content) . '</div>';
	
	return $html;
	
}

function three_cols_inner_func($atts, $content){
	
	shortcode_atts( array('inner_more_css' => '', 'inner_more_class' => ''), $atts);

	extract( shortcode_atts( array(
	'more_css' => '',
	'more_class' => ''
			), $atts ) );

	$html = '<div class="three_cols_inner';
	
	if($atts['inner_more_class'] != ''){
		$html .= ' ' . $atts['inner_more_class'] . '"';
	} else{
		$html .= '"';
	}
	if($atts['inner_more_css'] != ''){
		$html .= 'style="' . $atts['inner_more_css'] . '">';
	} else{
		$html .='>';
	}
	
	$html .= do_shortcode($content) . '</div>';
	
	return $html;
	
	
	//return '<div class="three_cols_inner' .  $atts['inner_more_class'] . '" ' . 'style="' . $atts['inner_more_css'] . '">' . do_shortcode($content) . '</div>';

}

?>