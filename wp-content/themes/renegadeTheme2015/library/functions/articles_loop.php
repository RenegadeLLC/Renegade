<?php

//GET POST TYPE FIELDS
$article_title = get_the_title();
$ra_author = get_field('ra_author');
$ra_publication = get_field('ra_publication');
$ra_date = get_field('ra_date');
$ra_url = get_field('ra_url');
$ra_blurb = get_field('ra_blurb');


$loopHTML .=  '<div class="article-item post-grid-item post-grid-item-w-25">';

	/*if($ra_date){
		$loopHTML .=  '<div class="ra-date">' . $ra_date . $taxonomy_type . '</div>';
	}*/


	
	
	
	if($ra_url){
		$loopHTML .=  '<a href="' . $ra_url . '" target=_blank>';
	}


$loopHTML .= '<h3>' .  $article_title . '</h3>';

	if($ra_url){
		$loopHTML .=  '</a>';
	}
	
	if($ra_date){
		$loopHTML .=  '<div class="ra-date">' . $ra_date . '</div>';
	}
	
	if($ra_author){
		$loopHTML .=  '<div class="ra-author">' . $ra_author;
	}
	
	if($ra_publication ){
		$loopHTML .=  ' for <span class="bold">' . $ra_publication . '</span></div>';
	}
	
	if($ra_blurb){
		$loopHTML .=  '<div class="ra-blurb">' . $ra_blurb . '</div><div style="clear:both"></div>';
	}

$loopHTML .=  '<div class="sep"></div></div>';//END ARTICLES ITEM

?>