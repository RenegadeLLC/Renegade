<?php

function article_func($atts, $content = null)
{
	shortcode_atts( array(), $atts);

	//return '<div class="col_one_half" ' . 'style="padding:' . $atts['padding'] . 'px; margin:'  . $atts['margin'] . 'px;">' . do_shortcode($content) . '</div>';

	return '<div class="contentCircCt"><div class="contentCirc_inner">' . do_shortcode($content) . '</div></div>';
}


?>