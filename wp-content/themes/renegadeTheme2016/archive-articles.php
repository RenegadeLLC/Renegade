<?php
/**
 * Template Name: Archived Articles By Year
 *
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2015
 */


get_header();


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

//AJAX SCRIPT FOR SORTING POSTS
$scriptdir = get_template_directory_uri();
$scriptdir .= '/library/js/';
wp_register_script('afp_script', $scriptdir . 'ajax-filter-post.js');
wp_enqueue_script('afp_script');

//GET DATA FROM ARTICLES LANDING PAGE
$data = get_post(1726);

$headline_wrapper_color = $data->headline_wrapper_background_color;
$body_wrapper_color = $data->body_wrapper_color;
$headline = $data->headline; 
$subheadline = $data->sub_headline;
$page_intro_copy = $data->page_intro_copy;
$intro_background_color = $data->intro_background_color;
$intro_background_image = $data->intro_background_image;
$intro_background_image_url = wp_get_attachment_url($intro_background_image);
$banner_background_repeat = $data->banner_background_repeat;
$banner_background_size = $data->banner_background_size;
$banner_background_position = $data->banner_background_position;
$custom_banner_background_position = $data->custom_banner_background_position;
$customize_intro_background_image = $data->customize_intro_background_image;
$articlesHTML = '';
$cat_taxonomy = 'article_categories';
$cat_tax_terms = get_terms($cat_taxonomy);
$year = get_the_date( _x( 'Y', 'yearly archives date format', 'rmg' ) ) ;
$month = get_the_date( _x( 'F Y', 'monthly archives date format', 'rmg' ) );
?>

	<section id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<div class="articles-page">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
			<?php 
			//$pageTopHTML = require_once (FUNCTIONS . '/standard_page_top.php');
			//$articlesHTML .= '<div class="outer-wrapper" style="background-color:#000000; overflow:hidden;"><div class="wrapper">';
			$articlesHTML  .= '<div class="outer-wrapper" style="background-color:' . $headline_wrapper_color . '; overflow:hidden;"><div class="wrapper">';
			$articlesHTML .= '<div class="headline-ct">';
			$articlesHTML .= '<h1 class="white text-center">Articles';
			//$articlesHTML .= ' - <span class="gray">' . $year . '</span>';
			$articlesHTML .=  '</h1>';
			$articlesHTML .= '</div><!-- .headline-ct-->';
			$articlesHTML .= '<div class="clear-fix"></div>';
			
			$articlesHTML .= '<div class="intro-ct"  style="background-color:' . $intro_background_color . ';';
			$articlesHTML .= ' background-image:url(' . $intro_background_image_url . ');';
			/*
			if($customize_intro_background_image == 'Yes'):
			$articlesHTML .= ' background-repeat:' . $banner_background_repeat . ';';
			$articlesHTML .= ' background-size:' . $banner_background_size . ';' ;
			$articlesHTML .= ' background-position:' . $banner_background_position . ';';
			endif;
			*/
			$articlesHTML .= '">';//close intro style declaration
			$articlesHTML .= '<div class="page-intro"><div class="page-intro-text">'. $page_intro_copy . '</div></div></div>';
			
			
			$articlesHTML .= '</div><!-- .wrapper -->';
			$articlesHTML .= '</div><!-- .outer-wrapper -->';
			
			$articlesHTML .= '<div class="outer-wrapper" style="background-color:#000;"><div class="wrapper">';
			$articlesHTML .= '<div style="background-color:#333; overflow:hidden;" class="articles post-list" year="' . $year . '">';
			$articlesHTML .= '</div></div></div>';
				
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
					endif;
						
					$articlesHTML .= '</header><!-- .page-header -->';
					$articlesHTML .= '<div class="outer-wrapper" style="background:#E6E7E8;"><div class="wrapper">';
					$articlesHTML .= '<div class="posts-ct float-left grid-item-w-75">';
					
					$articlesHTML .= '<div class="sort-bar" year="' . $year . '"><div class="sort-head">SORT BY: </div><div class="sort-option sort-on" title="date" type="articles">DATE</div>';
					$articlesHTML .= '<div class="sort-option sort-off" title="title" type="articles">TITLE </div>';
					$articlesHTML .= '<div class="sort-option sort-off" title="publication" type="articles">PUBLICATION</div>';
					$articlesHTML .= '<div class="article_categories">';
					foreach($cat_tax_terms as $cat_tax_term):
					//	$url = get_term_link($cat_tax_term, $cat_taxonomy);
					//$articlesHTML .=$url;
					//$articlesHTML .= '<div class="filter-option" title="' . $cat_tax_term->slug . '" type="articles">' . $cat_tax_term->name . '</div>';
					endforeach;
					$articlesHTML .= '</div></div>';
					
					$articlesHTML .= '<div class="post-grid"><div class="post-grid-gutter"></div>';
 			/* Start the Loop */ 
			while ( have_posts() ) : the_post();
				$articles = require( FUNCTIONS . 'articles_loop.php' );
 			endwhile; 
			
 			$articlesHTML .= $articles;
 			$articlesHTML .= '</div><!-- .post-grid -->';
 			
 			$next_posts = get_next_posts_link('Older Articles');
 			$prev_posts = get_previous_posts_link('Newer Articles');
 			
 			$articlesHTML .= '<div class="outer-wrapper"><div class="wrapper" style="overflow:hidden; background:#fff; padding-bottom:12px;">';
 			$articlesHTML .= '<nav class="paging-navigation"><div class="nav-links">';
 			
 			global $max_pages;
 			global $num_posts;

 			$articlesHTML .= $max_pages;
 			if($paged != $max_pages):
 			
 			$articlesHTML .= '<div class="nav-previous">' . $next_posts . '</div>';
 			endif;
 			
 			if($paged !=1):
 			$articlesHTML .= '<div class="nav-next">' . $prev_posts . '</div>';
 			endif;
 			
 			$articlesHTML .= '</div></nav>';
 			$articlesHTML .= '</div></div>';
 			
 			
 			$articlesHTML .= '</div><!-- .posts-ct float-left grid-item-w-75 -->';
 		//	$articlesHTML .= '</div><!-- .wrapper -->';
			//$articlesHTML .= '</div><!-- .outer-wrapper -->';
			
			
			echo($articlesHTML);
		?>


			<?php //rmg_paging_nav(); ?>

		<?php else : ?>

			<?php //get_template_part( 'content', 'none' ); ?>

		<?php endif; 
		
		global $ajax_vars;

wp_localize_script( 'afp_script', 'afp_vars', array(
		'afp_nonce' => wp_create_nonce( 'afp_nonce' ), // Create nonce which we later will use to verify AJAX request
		'afp_ajax_url' => admin_url( 'admin-ajax.php' ),
		'orderby' => $orderby,
		'order' => $order,
		'publication' => $publication,
		'post_type' => $post_type
)
		);

?>
<div class="float-left grid-item-w-25">
<div id="articles-sidebar"><?php get_sidebar('articles-sidebar'); ?></div></div></div><!-- .wrapper --></div><!-- .outer-wrapper -->
		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>
	<script type="text/javascript">


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

</script>
