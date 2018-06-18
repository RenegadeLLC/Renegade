<?php
/**
 * Template Name: Articles Page Template
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
//require( FUNCTIONS . 'ajax_filter_posts.php' );

global $order;
global $order_by;
global $meta_key;
global $loopHTML;
global $ra_loop;


//require( FUNCTIONS . 'ajax_filter_posts.php' );
// Script for getting posts

//SET DEFAULT ORDER AND ORDER BY VARS

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

$query_results = query_custom_posts('articles', '', '', '', '' );

$articlesHTML .= $query_results;

$articlesHTML .= '</div>';//END CONTENT DIAG

$articlesHTML .=  '</div>';//END LEFT CONTENT COLUMN


//BUILD SIDEBAR

if($sidebar == 'Yes'):
	$articlesHTML .= '<div class="sidebar-right"><div class="news">';
	$articlesHTML .= '<div class="saw-small-inv"></div>';
	
	$articlesHTML .= '<div class="ribbon-right clearfix sidebar-nav">Sort</div><div class="sidebar-item sidebar-closed"><div class="sort-list clearfix sidebar-content">';
	
	$articlesHTML .= '<div class="sort-option" title="date">By Date</div><div class="article_categories"><div class="sort-option" title="title" id="title">By Title </div></div></div></div>';
	
		if( in_array( 'archives', $sidebar_items ) ):
		
			//GET POST ARCHIVES
			$articlesHTML .= '<div class="ribbon-right clearfix sidebar-nav">Archives</div><div class="sidebar-item sidebar-closed"><div class="archive-list clearfix sidebar-content">';
			
			$archives = do_shortcode( '[list_archives type="monthly" format="custom" post_type="articles"]' );
			
			$articlesHTML .= $archives . '</div></div>';
		
		endif;

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