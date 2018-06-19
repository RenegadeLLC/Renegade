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

$year = get_the_date( _x( 'Y', 'yearly archives date format', 'rmg' ) ) ;
$month = get_the_date( _x( 'F Y', 'monthly archives date format', 'rmg' ) );
?>

	<section id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<div class="articles-page">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
			<?php 
			//$articlesHTML .= '<div class="outer-wrapper" style="background-color:#000000; overflow:hidden;"><div class="wrapper">';
			$articlesHTML  .= '<div class="outer-wrapper" style="background-color:' . $headline_wrapper_color . '; overflow:hidden;"><div class="wrapper">';
			$articlesHTML .= '<div class="headline-ct">';
			$articlesHTML .= '<h1 class="white text-center">Articles - <span class="gray">' . $year . '</span>';
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

				
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
					endif;
					
					$articlesHTML .= '</header><!-- .page-header -->';

					$articlesHTML .= '<div class="outer-wrapper" style="background:#E6E7E8;"><div class="wrapper">';
					$articlesHTML .= '<div class="posts-ct float-left grid-item-w-75">';
						
					$articlesHTML .= '<div class="post-grid"><div class="post-grid-gutter"></div>';
 			/* Start the Loop */ 
			while ( have_posts() ) : the_post();
				$articles = require( FUNCTIONS . 'articles_loop.php' );
 			endwhile; 
			
 			$articlesHTML .= $articles;
 			$articlesHTML .= '</div><!-- .post-grid -->';
 			$articlesHTML .= '</div><!-- .posts-ct float-left grid-item-w-75 -->';
 		//	$articlesHTML .= '</div><!-- .wrapper -->';
			//$articlesHTML .= '</div><!-- .outer-wrapper -->';
			
			
			
			echo($articlesHTML);
		?>


			<?php //rmg_paging_nav(); ?>

		<?php else : ?>

			<?php //get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>
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
