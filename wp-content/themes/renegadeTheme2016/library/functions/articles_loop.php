<?php

//GET POST TYPE FIELDS
global $orderby;
$article_title = get_the_title();
$ra_author = get_field('ra_author');
$ra_publication = get_field('ra_publication');
$ra_date = get_field('ra_date');
$ra_url = get_field('ra_url');
$ra_blurb = get_field('ra_blurb');

if(!$orderby):
$orderby = 'date';
endif;

$loopHTML .=  '<div class="article-item post-grid-item post-grid-item-w-25">';



$loopHTML .= '<h3><a href="' . $ra_url . '" target="_blank">' .  $article_title . '</a></h3>';

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

return($loopHTML);
?>