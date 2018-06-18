<?php



/*********************  ARTICLES LOOP *********************/

function get_articles_feed($i){

//GET POST TYPE FIELDS
$article_title = get_the_title();
$ra_author = get_field('ra_author');
$ra_publication = get_field('ra_publication');
$ra_date = get_field('ra_date');
$ra_url = get_field('ra_url');
$ra_blurb = get_field('ra_blurb');
$link_color = get_sub_field('link_color');
$article_loopHTML = '';


$article_loopHTML .=  '<div class="article post" id="article_' . $i. '">';

/*if($ra_date){
 $article_loopHTML .=  '<div class="ra-date">' . $ra_date . $taxonomy_type . '</div>';
 }*/

if($ra_date){
	$article_loopHTML .=  '<div class="md-ra-date">' . $ra_date . '</div>';
}

if($ra_author){
	$article_loopHTML .=  '<div class="md-ra-author">' . $ra_author;
}

if($ra_publication ){
	$article_loopHTML .=  ' for ' . $ra_publication . '</div>';
}

if($ra_url){
	$article_loopHTML .=  '<a href="' . $ra_url . '" target=_blank>';
}


$article_loopHTML .= '<h3><a href="" style="text-decoration:none; color:' . $link_color . ';">' . $article_title . '</a></h3>';

if($ra_url){
	$article_loopHTML .=  '</a>';
}
if($ra_blurb){
	$article_loopHTML .=  '<div class="md-ra-blurb">' . $ra_blurb . '</div><div style="clear:both"></div>';
}

$article_loopHTML .=  '</div>';//END ARTICLES ITEM
$i++;
return($article_loopHTML);
}

/*********************  NEWSLETTER LOOP *********************/

$rn_title = get_the_title( );
$rn_date = get_field('rn_date');
$rn_introduction= get_field('rn_introduction');



