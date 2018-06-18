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


//require( FUNCTIONS . 'ajax_filter_posts.php' );
global $post_type;
global $taxonomy_type;
global $taxonomy_term;
global $order;
global $orderby;
global $meta_value;
global $post_type;
global $ra_loop;
global $loopHTML;

//SET DEFAULT QUERY VARS
$post_type = 'articles';
$taxonomy_type = '';
$taxonomy_term = '';
$orderby = 'date';
$order = 'ASC';
$meta_value = '';

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
$ra_loop = my_custom_query( $post_type, $taxonomy_type, $taxonomy_term, $orderby, $order, $meta_value);



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


if ( $ra_loop->have_posts() ) :

	while ( $ra_loop->have_posts() ) : $ra_loop->the_post();
//	$loop_render = $post_type . '_loop.php';
	require( FUNCTIONS . 'articles_loop.php' );
	endwhile;
endif;
//$query_results = query_custom_posts('articles', '', '', '', '' );

$articlesHTML .= $loopHTML;

$articlesHTML .= '</div>';//END CONTENT DIAG

$articlesHTML .=  '</div>';//END LEFT CONTENT COLUMN


//BUILD SIDEBAR

if($sidebar == 'Yes'):
	$articlesHTML .= '<div class="sidebar-right"><div class="news">';
	$articlesHTML .= '<div class="saw-small-inv"></div>';
	
	$articlesHTML .= '<div class="ribbon-right clearfix sidebar-nav">Sort</div><div class="sidebar-item sidebar-closed"><div class="sort-list clearfix sidebar-content">';
	
	$articlesHTML .= '<div class="sort-option" orderby="date">By Date</div><div class="article_categories"><div class="sort-option" orderby="title" id="title">By Title </div></div></div></div>';
	
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

/*
// Enqueue script
function ajax_filter_posts_scripts() {
	// Enqueue script
	$scriptdir = get_template_directory_uri();
	$scriptdir .= '/library/js/';

	wp_register_script('afp_script', $scriptdir  . 'ajax-filter-post.js', false, null, false);
	wp_enqueue_script('afp_script');

	$ajax_vars = array(
		//	'af_nonce' => wp_create_nonce( 'afp_nonce' ), // Create nonce which we later will use to verify AJAX request
			//'afp_ajax_url' => admin_url( 'admin-ajax.php' ),
			'query' => $ra_loop->query,
	);
	
	//wp_localize_script('my_script', 'my_script_data', array('query' => $qv) );
	wp_localize_script( 'afp_script', 'afp_vars', $ajax_vars);

}

add_action('wp_enqueue_scripts', 'ajax_filter_posts_scripts', 100);

function load_external_jQuery() { 
	echo('I am going to cry now.');// load external file
	// wp_deregister_script( 'jquery' ); // deregisters the default WordPress jQuery
	//  wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"), false);
	//  wp_enqueue_script('jquery');
	wp_register_script('wtf', $scriptdir . 'wtf.js' );
	wp_enqueue_script('wtf');
}
//add_action('wp_enqueue_scripts', 'load_external_jQuery');
*/
global $ajax_vars;

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