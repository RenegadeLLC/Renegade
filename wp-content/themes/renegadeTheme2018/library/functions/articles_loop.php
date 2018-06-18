<?php

//GET POST TYPE FIELDS
global $orderby;
$article_title = get_the_title();
$ra_author = get_field('ra_author');
$ra_publication = get_field('ra_publication');
$ra_date = get_field('ra_date');
//$ra_date = new DateTime(get_field('ra_date'));
$ra_year = new DateTime(get_field('ra_date'));
$ra_year = $ra_year->format('Y');
//$ra_year = strtotime($ra_year);
$ra_url = get_field('ra_url');
$ra_blurb = get_field('ra_blurb');
global $prevYear;
global $prevPub;
global $year_arr;
global $pub_arr;


if(!$orderby):
   $orderby = 'date';
endif;

//if($ra_year == $year):

	
if($ra_year != $prevYear && $orderby == 'date' && !in_array($ra_year, $year_arr)):
	
	$loopHTML .=  '<div class="article-item post-grid-item post-grid-item-w-100">';
	$loopHTML .= '<h1 class="article-group">' . $ra_year . '</h1></div>';
	array_push($year_arr, $ra_year);
	
	elseif($orderby != 'date' && $orderby != 'title' &&  $orderby == 'meta_value' && !in_array($ra_publication, $pub_arr)):

    $loopHTML .=  '<div class="article-item post-grid-item post-grid-item-w-100">';
    $loopHTML .= '<h1 class="article-group">' . $ra_publication . '</h1></div>';
    array_push($pub_arr, $ra_publication);
    
else:
	
	$loopHTML .=  '<div class="article-item post-grid-item post-grid-item-w-50">';
	$loopHTML .= '<h3><a href="' . $ra_url . '" target="_blank">' . $article_title . '</a></h3>';
	
		if($ra_url){
			//$loopHTML .=  '</a>';
		}
		
		if($ra_date){
			$loopHTML .=  '<div class="ra-date">' . $ra_date . '</div>';
			
		}
		
		if($ra_author){
			$loopHTML .=  '<div class="ra-author"><span class="semibold">' . $ra_author;
		}
		
		if($ra_publication ){
			$loopHTML .=  '<br> for ' . $ra_publication . '</span></div>';
		}
		
		if($ra_blurb){
			$loopHTML .=  '<div class="ra-blurb">' . $ra_blurb . '</div><div style="clear:both"></div>';
		}
		
	
	
	$loopHTML .=  '<div class="sep"></div></div>';//END ARTICLES ITEM

endif;

	$prevYear = $ra_year;
	$prevPub = $ra_publication;
	return($loopHTML);
//endif;
?>