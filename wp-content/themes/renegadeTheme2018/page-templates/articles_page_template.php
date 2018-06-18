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
 * @since 2016
 */

get_header(); 
$scriptdir = get_template_directory_uri();
$scriptdir .= '/library/js/';
//AJAX SCRIPT FOR SORTING POSTS
wp_register_script('afp_script', $scriptdir . 'ajax-filter-post.js');
wp_enqueue_script('afp_script');
?>


<div class="articles-page">

<?php

$articlesHTML = '';

$pageTopHTML = require_once (FUNCTIONS . '/standard_page_top.php');


global $post_type;
global $taxonomy_type;
global $taxonomy_term;
global $taxonomy;
global $tax_query_arr;
global $order;
global $orderby;
global $meta_value;
global $metakey;
global $ra_loop;
global $loopHTML;
global $current_query;
global $year;

//SET DEFAULT QUERY VARS
$post_type = 'articles';
$taxonomy_type = '';
$taxonomy_term = '';
$taxonomy = '';
$publication = '';
$orderby = 'date';
$order = 'DESC';
$meta_value = '';
$post_type = 'articles';
$archive_type = 'yearly';
$cat_taxonomy = 'article_categories';
$cat_tax_terms = get_terms($cat_taxonomy);
$year = current_time('Y');
$ra_date = get_field('ra_date');
$ra_year = new DateTime(get_field('ra_date'));
$ra_year = $ra_year->format('Y');
$year_arr = array();
$pub_arr = array();

//$year = '';

 // set the "paged" parameter (use 'page' if the query is on a static front page)
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    // the query
  //  $the_query = new WP_Query( 'cat=1&paged=' . $paged ); 

//$year = get_the_date( _x( 'Y', 'yearly archives date format', 'rmg' ) ) ;

$ra_args = array( 
	'post_type' => 'articles', 
	'posts_per_page' => -1, 
	'orderby' => $orderby, 
	//'orderby'  => 'meta_value_num',  
	'order' => $order, 
	//'year' => $ra_year, 
	'paged' => $paged, 
	'post_status' => 'publish',
	'max_num_pages' => 20,
	'meta_key' => 'ra_publication',
	'meta_query' => array(
			
		//	'key'		=> $ra_year,
		//	'compare'	=> '!=',
		//	'value'		=> $year,
		
),
	
);
if($ra_year == $year):

endif;
//$ra_loop = my_custom_query( $post_type, $taxonomy_type, $taxonomy_term, $orderby, $order, $meta_value, $year);

$ra_loop = new WP_Query( $ra_args );
//SET DEFAULT ORDER AND ORDER BY VARS

//var_dump($cat_tax_terms);

$articlesHTML .= $pageTopHTML;
$articlesHTML .= '<div class="outer-wrapper" style="background:#E6E7E8;"><div class="wrapper"><div class="year" id="' . $year . '"></div>';
$articlesHTML .= '<div class="posts-ct float-left grid-item-w-75">';

//	$articlesHTML .= '<div class="outer-wrapper" style="background-color:#E6E7E8;"><div class="wrapper">';
//	$articlesHTML .= '<div style="background-color:#333; overflow:hidden;" class="articles post-list" year="' . $year . '">';
$articlesHTML .= '<div class="sort-bar"  year="' . $year . '"><div class="sort-head">SORT BY: </div><div class="sort-option sort-on" title="date" type="articles">DATE</div>';
$articlesHTML .= '<div class="sort-option sort-off" title="title" type="articles">TITLE </div>';
$articlesHTML .= '<div class="sort-option sort-off" title="publication" type="articles">PUBLICATION</div>';
$articlesHTML .= '<div class="article_categories">';
foreach($cat_tax_terms as $cat_tax_term):
//	$url = get_term_link($cat_tax_term, $cat_taxonomy);
//$articlesHTML .=$url;
//$articlesHTML .= '<div class="filter-option" title="' . $cat_tax_term->slug . '" type="articles">' . $cat_tax_term->name . '</div>';
endforeach;
$articlesHTML .= '</div></div>';
//$articlesHTML .= '</div></div></div>';
//$articlesHTML .= '<div class="categories-list" style="background-color:#1AC3EC;">' . do_shortcode('[list_archives post_type="articles" format="" type="yearly"]') . '</div>';

$articlesHTML .= '<div id="container" style="background:#fff;">';

//$articlesHTML .= '<div class="wrapper">';
$articlesHTML .= '<div class="post-grid" id="post-grid"><div class="post-grid-gutter"></div>';

if ( $ra_loop->have_posts() ) :

	while ( $ra_loop->have_posts() ) : $ra_loop->the_post();

		require( FUNCTIONS . 'articles_loop.php' );
		
	endwhile;
	// clean up after our query
	wp_reset_postdata();
endif;

$articlesHTML .= $loopHTML;
//$articlesHTML .= '<div class="article-item post-grid-item post-grid-item-w-100">';

$articlesHTML .= '</div>';//END post-grid div

$next_posts = get_next_posts_link('Older Articles', $ra_loop->max_num_pages);
$prev_posts = get_previous_posts_link('Newer Articles');

$articlesHTML .= '<div class="outer-wrapper"><div class="wrapper" style="overflow:hidden; background:#fff; padding-bottom:12px;">';
$articlesHTML .= '<nav class="paging-navigation"><div class="nav-links">';

$max_pages = $ra_loop->max_num_pages;

	if($paged != $max_pages):
		//$articlesHTML .= '<div class="nav-previous">' . $next_posts . '</div>';
	endif;
	
	if($paged !=1):
		//$articlesHTML .= '<div class="nav-next">' . $prev_posts . '</div>';
	endif;
	
$articlesHTML .= '</div></nav>';
$articlesHTML .= '</div></div>';

$articlesHTML .=  '</div><!-- .articles-list --></div><!-- .float-left -->';

//BUILD SIDEBAR

$articlesHTML .= '<div class="float-right grid-item-w-25">';

//$articlesHTML .= do_shortcode('[ajax_load_more post_type="articles" post_format="standard" posts_per_page="9"]');
echo $articlesHTML;

global $ajax_vars;

wp_localize_script( 'afp_script', 'afp_vars', array(
		'afp_nonce' => wp_create_nonce( 'afp_nonce' ), // Create nonce which we later will use to verify AJAX request
		'afp_ajax_url' => admin_url( 'admin-ajax.php' ),
		'orderby' => $orderby,
		'order' => $order,
		/*'pageNum' => parseInt(pbd_alp.startPage) + 1,
		'max' => parseInt(pbd_alp.maxPages),
		'nextLink' => afp.next_link,
		'num_posts' => afp.num_posts,
		'container' => afp.container,
		'selector' => afp.selector,*/
		'publication' => $publication,
		'post_type' => $post_type
)
		);
 ?>

</div><!-- .company -->

	<script type="text/javascript">
	jQuery(document).ready(function($) {
	
$( function() {
	  
	  $('.post-grid').isotope({
		 percentPosition: true,
		 layoutMode: 'packery',
		//  layoutMode: 'masonry',
	    itemSelector: '.post-grid-item',
	   packery: {
		//   masonry: {
	      gutter: '.post-grid-gutter'
	      }
	  });
	  
	});
});
</script>
<div class="float-left grid-item-w-25">
<div id="articles-sidebar">
	<?php get_sidebar('articles-sidebar');?>
		</div>
	</div></div></div>
<?php get_footer(); ?>