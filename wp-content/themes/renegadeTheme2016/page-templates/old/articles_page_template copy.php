<?php
/**
 * Template Name: BKArticles Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2014
 */

get_header(); 
?>

<script>

</script>
<div class="news-page">

<div class="content-wrapper" style="background:#fff; overflow:hidden; padding-bottom:64px;">
<?php

global $current_query;
global $order;
global $order_by;
global $meta_key;

//SET DEFAULT ORDER AND ORDER BY VARS

$order = 'ASC';
$order_by = 'date';


$header = get_field('header');
$subheader = get_field('subheader');
//$meta_key = $ra_date;

$sidebar_content = get_field('sidebar_content');
//$sidebar_items = implode(', ', get_field('sidebar_items'));
$sidebar_items = get_field('sidebar_items');
//print_r($sidebar_items);
// the query
$sidebar = get_field('sidebar');
$ra_args = array( 'post_type' => 'articles', 'posts_per_page' => -1 , 'orderby' => $order_by, 'order' => $order);
$ra_loop = new WP_Query( $ra_args );

$current_query = $ra_loop;

$articlesHTML = '';

$articlesHTML .= '<div class="content-left">';

$articlesHTML .= '<div class="headline-ct">';

if($header){
	$articlesHTML .= '<h1>'. $header . '</h1>';
}

if($subheader){
	$articlesHTML .= '<h2>'. $subheader . '</h2>';
}

$articlesHTML .= '</div>';

$articlesHTML .= '<div class="content-diag" id="articles-list"  style="clear:both;">';
while ( $ra_loop->have_posts() ) : $ra_loop->the_post();

require( FUNCTIONS . 'articles_loop.php' );


/*$article_title = get_the_title();
$ra_author = get_field('ra_author');
$ra_publication = get_field('ra_publication');
$ra_date = get_field('ra_date');
$ra_url = get_field('ra_url');
$ra_blurb = get_field('ra_blurb');


$articlesHTML .=  '<div class="article-item">';

if($ra_date){
	$articlesHTML .=  '<div class="ra-date">' . $ra_date . '</div>';
}

if($ra_author){
	$articlesHTML .=  '<div class="ra-author">' . $ra_author;
}

if($ra_publication ){
	$articlesHTML .=  ' for ' . $ra_publication . '</div>';
}

if($ra_url){
	$articlesHTML .=  '<a href="' . $ra_url . '" target=_blank>';
}

$articlesHTML .= '<h3>' .  $article_title . '</h3>';

if($ra_url){
	$articlesHTML .=  '</a>';
}
if($ra_blurb){
	$articlesHTML .=  '<div class="ra-blurb">' . $ra_blurb . '</div><div style="clear:both"></div>';
}

$articlesHTML .=  '</div>';//END ARTICLES ITEM
*/
endwhile;

$articlesHTML .= '</div>';//END CONTENT DIAG

$articlesHTML .=  '</div>';//END LEFT CONTENT COLUMN

	if($sidebar == 'Yes'):
	$articlesHTML .= '<div class="sidebar-right"><div class="news">';
	$articlesHTML .= '<div class="saw-small-inv"></div>';
	
	$articlesHTML .= '<div class="ribbon-right clearfix sidebar-nav">Sort</div><div class="sidebar-item sidebar-closed"><div class="sort-list clearfix sidebar-content">';
	
	$articlesHTML .= '<div class="sort-option" title="date">By Date</div><div class="sort-option" title="title">By Title </div></div></div>';
	
	if( in_array( 'archives', $sidebar_items ) ):
	
	//GET POST ARCHIVES
	$articlesHTML .= '<div class="ribbon-right clearfix sidebar-nav">Archives</div><div class="sidebar-item sidebar-closed"><div class="archive-list clearfix sidebar-content">';
	
	$archives = do_shortcode( '[list_archives type="monthly" format="custom" post_type="articles"]' );
	
	$articlesHTML .= $archives . '</div></div>';
	
	endif;
	
	//define shortcode directory
	//define('FUNCTIONS', TEMPLATEPATH . '/library/functions/');
//require_once( FUNCTIONS . 'ajax_filter_posts.php' );
//		require_once( FUNCTIONS . 'wtf.php' );
	if( in_array( 'categories', $sidebar_items ) ):

	//GET POST CATEGORIES
	$articlesHTML .= '<div class="ribbon-right clearfix sidebar-nav">Categories</div><div class="sidebar-item sidebar-closed"><div class="categories-list sidebar-content">';
	$categories=tags_filter('article_categories');
	//$categories = do_shortcode( '[list_categories]' );
	//$categories = do_shortcode( '[wpajaxfilter cat=1 tag=0 month=0 author=0 format=0]');
	
	$articlesHTML .= $categories . '</div></div>';
	
	endif;
	
	if( in_array( 'tags', $sidebar_items ) ):
	
	//GET POST CATEGORIES
	$articlesHTML .= '<div class="ribbon-right clearfix sidebar-nav">Tags</div><div class="sidebar-item sidebar-closed"><div class="tags-list sidebar-content">';
	
	$tags = do_shortcode( '[list_tags post_type="articles"]' );
	$tags=tags_filter('article_tags');
	$articlesHTML .= $tags . '</div></div>';
	
	endif;
		
		if($sidebar_content):
		$articlesHTML .=  $sidebar_content;
		endif;
		$articlesHTML .= '</div></div>';
	endif;
echo $articlesHTML;
 ?>


</div><!-- .content-wrapper -->
</div><!-- .company -->
<script type="text/javascript">

$(function() {
	$(".free-wall2").each(function() {
		var wall = new freewall(this);
		wall.reset({
			selector: '.brick',
			cellW: 'auto',
			cellH: 'auto',
			//fixSize: 0,
			gutterY: 32,
			gutterX: 32,
			onResize: function() {
				wall.fitWidth();
			}
		});
		wall.fitWidth();
	});
	$(window).trigger("resize");
	//alert(cellWidth);
});
		</script>
<?php get_footer(); ?>