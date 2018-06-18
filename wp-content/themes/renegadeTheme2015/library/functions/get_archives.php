<?php

function get_archives_func($atts, $content = null){
	
	shortcode_atts( array('type' => '', 'format' => 0, 'post_type' => ''), $atts);
	
	
	$type = $atts['type'];
	$format = $atts['format'];
	$post_type = $atts['post_type'];
	
	/*
	$rarch_args = array(
		'type'            => $type,
		'limit'           => '',
		'format'          => $format, 
		'before'          => '<h5>',
		'after'           => '</h5>',
		'show_post_count' => false,
		'echo'            => 0,
		'order'           => 'DESC'
	);
	
	
	$archives = wp_get_archives( $rarch_args );
	
	return $archives;

	// Reset Post Data
	


*/
	
	global $wpdb;
	$limit = 0;
	$year_prev = null;
	$archiveHTML;
	
	$months = $wpdb->get_results("SELECT DISTINCT MONTH( post_date ) AS month ,	YEAR( post_date ) AS year, COUNT( id ) as post_count FROM $wpdb->posts WHERE post_status = 'publish' and post_date <= now( ) and post_type = '$post_type' GROUP BY month , year ORDER BY post_date DESC");
	$archiveHTML = '';
	$archiveHTML .= '<ul>';

	foreach($months as $month) :
	$year_current = $month->year;
	if ($year_current != $year_prev){
			if ($year_prev != null){
			
			} 
		
		$archiveHTML .=	'<li class="archive-year"><a href="' . get_bloginfo('url') . '/' .  $month->year . '/">' .   $month->year . '</a></li>';
		
		 } 
	$archiveHTML .=	'<li><a href=' . get_bloginfo('url') . '/' .  $month->year .  '/' .  date("m", mktime(0, 0, 0, $month->month, 1, $month->year)) . ">" . '<span class="archive-month">'. date_i18n("F", mktime(0, 0, 0, $month->month, 1, $month->year)) . '</span></a></li>';
 	
 	$year_prev = $year_current;
	
	if(++$limit >= 18) { break; }
	
	endforeach;
	
	$archiveHTML .= '</ul>';
	
	return $archiveHTML;
}


?>