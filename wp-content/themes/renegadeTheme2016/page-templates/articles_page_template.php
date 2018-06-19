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


<div class="articles-page">

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
$order = 'DESC';
$meta_value = '';

//require( FUNCTIONS . 'ajax_filter_posts.php' );

$post_type = 'articles';
$archive_type = 'yearly';
$post_type = 'articles';
//$sidebarHTML = require_once (FUNCTIONS . '/build_sidebarB.php');

$ra_args = array( 'post_type' => 'articles', 'posts_per_page' => -1 , 'orderby' => $order_by, 'order' => $order);
$ra_loop = my_custom_query( $post_type, $taxonomy_type, $taxonomy_term, $orderby, $order, $meta_value);

$articlesHTML = '';

$pageTopHTML = require_once (FUNCTIONS . '/standard_page_top.php');

	$articlesHTML.=$pageTopHTML;
	
$articlesHTML .= '<div class="outer-wrapper" style="background:#E6E7E8;"><div class="wrapper">';
$articlesHTML .= '<div class="posts-ct float-left grid-item-w-75">';

$articlesHTML .= '<div id="container">';



//$articlesHTML .= '<div class="wrapper">';
$articlesHTML .= '<div class="post-grid"><div class="post-grid-gutter"></div>';

if ( $ra_loop->have_posts() ) :

	while ( $ra_loop->have_posts() ) : $ra_loop->the_post();

		require( FUNCTIONS . 'articles_loop.php' );
		
	endwhile;
	
endif;

$articlesHTML .= $loopHTML;
$articlesHTML .= '</div>';//END post-grid div
$articlesHTML .=  '</div><!-- .articles-list --></div><!-- .float-left -->';

//BUILD SIDEBAR

$articlesHTML .= '<div class="float-right grid-item-w-25">';


//$articlesHTML .= $sidebarHTML;


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