<?php

function get_archives_func($atts, $content = null){
	$archivesHTML = '';
	shortcode_atts( array('type' => '', 'format' => 0, 'post_type' => ''), $atts);
	
	$type = $atts['type'];
	$format = $atts['format'];
	$post_type = $atts['post_type'];
	$before = '<div class="archive-link">';
	$after = '</div>';

	$posts_per_page = 200;
	$start = 0;
	$paged = get_query_var( 'paged') ? get_query_var( 'paged', 1 ) : 1; // Current page number
	$start = ($paged-1)*$posts_per_page;
	
	global $wpdb;
	$limit = 0;
	$year_prev = null;
	$months = $wpdb->get_results("SELECT DISTINCT MONTH( post_date ) AS month ,	YEAR( post_date ) AS year, COUNT( id ) as post_count FROM $wpdb->posts WHERE post_status = 'publish' and post_date <= now( ) and post_type = '$post_type' GROUP BY month , year ORDER BY post_date DESC");
	
	foreach($months as $month) :
		$year_current = $month->year;
	
		if ($year_current != $year_prev){
			if ($year_prev != null){
				if($type == 'monthly'):
				$archivesHTML.= '</div></div><div style="height:8px;"></div>';
				endif;
			} 
			
		
			
				if($type == 'yearly'):
					$archivesHTML.= '<li class="archive-year">';
					$yearly_url = get_bloginfo('url') ;
					$archivesHTML.= '<a href="' . $yearly_url . '/';
					$archivesHTML.= $month->year;
					
							if($post_type != 'post'):
								$archivesHTML.='/?post_type=' . $post_type;
							endif;
							
					$archivesHTML.= '">';
				
				elseif($type == 'monthly'):
				
					$archivesHTML.= '<div class="expander archive-year">';
				
				endif;
				
			$archivesHTML.=  $month->year;
				
				if($type == 'yearly'):
					$archivesHTML.=  '</a></li>';
			 	elseif($type == 'monthly'):
					$archivesHTML.= '</div><div class="expanded-ct"><div class="expanded">';
				endif;	 
		 } 
		
		 if($type == 'monthly'):
		 
			$url = get_bloginfo('url');	
			$archivesHTML.=  '<li><a href="' . $url . '/';
			$archivesHTML.= $month->year;
			$archivesHTML.=  '/';
			$month_string = date("m", mktime(0, 0, 0, $month->month, 1, $month->year)) ;
			$archivesHTML.= $month_string . '/';
			
			if($post_type != 'post'):
				$archivesHTML.='?post_type=' . $post_type;
			endif;
			
			$archivesHTML.='"><span class="archive-month">';
			$date_string = date_i18n("F", mktime(0, 0, 0, $month->month, 1, $month->year));
			$archivesHTML.=  $date_string . '</span></a></li>';		
			
		endif; 
		
		$year_prev = $year_current;
	
		if(++$limit >= 800) { break; }
	
	endforeach;
	

	
	return $archivesHTML;
	
	/*
	$args = array(
			'type'            => $type,
			'limit'           => '',
			'format'          => 'html',
			//'before'          => $before,
		//	'after'           => $after,
			//'before'          => 'hi',
			//'after'           => 'bye',
			'show_post_count' => false,
			'echo'            => 0,
			'order'           => 'DESC',
			'post_type'     => $post_type
	);
	$archives = wp_get_archives( $args );
	return($archives);

	global $wpdb;
	$sidebarHTML = '';
	//Grab the earliest year available
	$yearliest_year = $wpdb->get_results(
	
			"SELECT YEAR(post_date) AS year
			FROM $wpdb->posts
			WHERE post_status = 'publish'
			AND post_type = '$post_type'
			ORDER BY post_date
			ASC LIMIT 1
			");
	
	
	//If there are any posts
	if($yearliest_year){
	
		//This year
		$this_year = date('Y');
	
			if($type == 'monthly'):
			//Setup months
				$months = array(1 => "January", 2 => "February", 3 => "March" , 4 => "April", 5 => "May", 6 => "June", 7 => "July", 8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "December");
			endif;
		
			$current_year = $yearliest_year[0]->year;
		$last_year = '';
		 
		var_dump($yearliest_year[0]->year);
		//Loop through every year and check each monnth of each year for posts
		while($current_year <= $this_year){
	
			//echo "<h3>" . $current_year . "</h3>";
			
			if($type == 'yearly'):
			//	$sidebarHTML .= "<h3><a href='" . get_bloginfo('url') . '/' . $current_year . "/?post_type=" . $post_type . "'>" . $current_year . "</a></h3>";
				if($current_year != $last_year):
					$sidebarHTML .=  "<a class='archive-link' href='" . get_bloginfo('url') . '/' . $current_year . "/?post_type=". $post_type . "'><span class='archive-year'>" . $current_year . "</span></a>";
					$last_year = $current_year;
				endif;
			else:
				$sidebarHTML .= "<h3 class='year-link'>" . $current_year . "</h3>";
			endif;
			
			$sidebarHTML .=  "<ul>";
			
			if($type == 'monthly'):
	
			foreach($months as $month_num => $month){
	
	
				//Checks to see if a month a has posts
				if($search_month = $wpdb->query(
	
						"SELECT MONTHNAME(post_date) as month
	
						FROM $wpdb->posts
						WHERE MONTHNAME(post_date) = '$month'
						AND YEAR(post_date) = $current_year
						AND post_type = '$post_type'
						AND post_status = 'publish'
						ORDER BY post_date
						ASC LIMIT 1
	
						")){
	
						//Month has post -> link it
				$sidebarHTML .=  "<li>
	
                            <a href='" . get_bloginfo('url') . '/' . $current_year . "/" . $month_num . "/?post_type=". $post_type . "'><span class='archive-month'>" . $month . "</span></a>
	
                          </li>";
	
	
				}else{
	
					//Month does not have post -> just print it
	
					$sidebarHTML .=  "<li>
	
                            <span class='archive-month'></span>
	
                          </li>";
				}
	
	
	
			}
			endif;
	
			$sidebarHTML .=  "</ul>";
	
			$current_year++;
	
	
		}
	
	}else{
	
		$sidebarHTML .=  "No Posts Found.";
	
	}
	return $sidebarHTML;*/
}


?>