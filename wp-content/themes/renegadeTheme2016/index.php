<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Renegade
 */

get_header(); 
?>

<div id="primary" class="content-area">
<main id="main" class="site-main" role="main">

<?php 

$pageHTML = '';
//$pageHTML .= '<div style="display:block; position:relative; overflow:hidden; background:#E6E7E8; height:100%; width:100%;">';
//GET THE MAIN PAGE VARIABLES

//$headline = get_field('headline');
//$headline = get_the_title();
$headline = get_field('headline', get_option('page_for_posts'));
$subheadline = get_field('subheadline', get_option('page_for_posts'));
$headline_background_color = get_field('headline_background_color', get_option('page_for_posts'));

$left_column_background_color = get_field('left_column_background_color', get_option('page_for_posts'));
$left_column_logo = get_field('left_column_logo', get_option('page_for_posts'));
$left_column_logo_alt_text = get_field('left_column_logo_alt_text', get_option('page_for_posts'));
$left_column_url = get_field('left_column_url', get_option('page_for_posts'));

$right_column_background_color = get_field('right_column_background_color', get_option('page_for_posts'));
$right_column_logo = get_field('right_column_logo', get_option('page_for_posts'));
$right_column_logo_alt_text = get_field('right_column_logo_alt_text', get_option('page_for_posts'));
$right_column_url = get_field('right_column_url', get_option('page_for_posts'));

$pageHTML .= '<div class="outer-wrapper" style="background-color:#000;"><div class="wrapper">';
$pageHTML .= '<div class="headline-ct">';
$pageHTML .= '<h1 class="white text-center">'. $headline . '</h1>';
$pageHTML .= '</div><!-- headline-ct -->';

$pageHTML .= '<div class="fleft grid-item-w-50 property-box"';

	if($left_column_background_color):
		$pageHTML .= ' style="background-color:'. $left_column_background_color . ';"';
	endif;

	$pageHTML .= '>';
	$pageHTML .= '<div class="vert-center-outer"><div class="vert-center-inner">';	

	if($left_column_logo):
	
		if($left_column_url):
			$pageHTML .= '<a href="' . $left_column_url . '" target="_blank">';
		endif;
	
		$pageHTML .= '<img src="' . $left_column_logo . '"';
	
		if($left_column_logo_alt_text):
			$pageHTML .= ' alt="' . $left_column_logo_alt_text . '"';
		endif;
		
		$pageHTML .= '>';
		
		if($left_column_url):
			$pageHTML .= '</a>';
		endif;
		
	endif;

	$pageHTML .= '</div></div>';
	$pageHTML .= '</div>';

$pageHTML .= '<div class="fleft grid-item-w-50 property-box mobile-hide"';


if($right_column_background_color):
	$pageHTML .= ' style="background-color:'. $right_column_background_color . ';"';
endif;

$pageHTML .= '>';

$pageHTML .= '<div class="vert-center-outer"><div class="vert-center-inner">';

	if($right_column_logo):
	
		if($right_column_url):
			$pageHTML .= '<a href="' . $right_column_url . '" target="_blank">';
		endif;
		
		$pageHTML .= '<img src="' . $right_column_logo . '"';
		
		if($right_column_logo_alt_text):
			$pageHTML .= ' alt="' . $right_column_logo_alt_text . '"';
		endif;
		
		$pageHTML .= '>';
		
		if($right_column_url):
			$pageHTML .= '</a>';
		endif;
	
	endif;
	
	$pageHTML .= '</div><!-- .vert-center-inner --></div><!-- .vert-center-outer -->';
	$pageHTML .= '</div><!-- fleft grid-item-w-50 property-box -->';

$pageHTML .=  '</div><!-- .wrapper--></div><!-- .outer-wrapper-->';

$index = 1;

$pageHTML .= '<div class="outer-wrapper" style="background-color:#fff;"><div class="wrapper">';

$pageHTML .= '<div class="fleft grid-item-w-50 blog-column sme">';

$pageHTML .= do_shortcode( '[recent_rss feed="http://feeds.feedburner.com/socialmediaexplorer/gIgD" excerpt="Yes" numberposts="4" text_color="#000"]' );

$pageHTML .= '</div>';

$pageHTML .= '<div class="fright grid-item-w-50 blog-column tbd">';

//TBD HEADER FOR MOBILE

$pageHTML .= '<div class="fleft grid-item-w-50 property-box mobile-show tbd-head-mobile"';


if($right_column_background_color):
$pageHTML .= ' style="background-color:'. $right_column_background_color . ';"';
endif;

$pageHTML .= '>';

$pageHTML .= '<div class="vert-center-outer"><div class="vert-center-inner">';

if($right_column_logo):

if($right_column_url):
$pageHTML .= '<a href="' . $right_column_url . '" target="_blank">';
endif;

$pageHTML .= '<img src="' . $right_column_logo . '"';

if($right_column_logo_alt_text):
$pageHTML .= ' alt="' . $right_column_logo_alt_text . '"';
endif;

$pageHTML .= '>';

if($right_column_url):
$pageHTML .= '</a>';
endif;

endif;

$pageHTML .= '</div><!-- .vert-center-inner --></div><!-- .vert-center-outer -->';

$pageHTML .= '</div><!-- fleft grid-item-w-50 property-box -->';

//END TBD HEADER FOR MOBILE

$pageHTML .= do_shortcode( '[recent_rss feed="http://www.thedrewblog.com/index.php/feed/" excerpt="Yes" numberposts="4" text_color="#000"]' );

$pageHTML .= '</div>';

$pageHTML .=  '</div><!-- .wrapper--></div><!-- .outer-wrapper-->';

echo $pageHTML;
//pageHTML .= '<div class="outer-wrapper" style="background-color:#e6e7e8;">';

?>

<div class="outer-wrapper" style="background-color:#e6e7e8;"><div class="wrapper">
<!-- external blog container --><div class="grid-item-w-100" style="background:#fff !important;">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			
			<?php while ( have_posts() ) : the_post(); 
			
			$post_url = esc_url( get_permalink() );
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
			
			if($index <= 1):
			
		//	if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
				
			//	echo('<div class="featured-post grid-item-w-100"><div class="featured-post-left"><a href="' . $post_url . '"><div class="post-img-ct" style="background:url(' . $image[0] . ') no-repeat cover center;"><img class="featured-post-image circle-big" src="' . $image[0] . '"></a></div>');
					
			//} else{
				//echo('<div class="featured-post grid-item-w-100">');
				$upload_dir = content_url();
				$upload_path = $upload_dir . '/uploads/';
				echo('<div class="featured-post grid-item-w-100" style="height:380px;"><div class="featured-post-left"><div class="saw-circle circle"><img src="' . $upload_path  . 'saw_white_300x300.png"></div>');
					
			
			//}
				//echo('<div class="featured-post grid-item-w-100"><div class="featured-post-left"><a href="' . $post_url . '"><div class="featured-post-image circle-big" style="background-image:url(' . $image[0] . ');"></a>');		
				
				$date = get_the_date( 'l, F, j, Y'); 
				echo('</div><div class="featured-post-right"><div class="featured-post-right-text">');	
				
				echo('<h1><a href="' . $post_url . '">' . get_the_title() . '</a></h1>');
				echo '<div class="date">' . $date . '</div>';
				$excerpt = get_the_excerpt();
				echo($excerpt);
				echo('</div></div></div>');				
				$index++;	
				echo '<div class="post-grid grid"><div class="post-grid-gutter"></div>';		
			else:
				echo '<div class="post-grid-item post-grid-item-w-25 blog-tile">';
				get_template_part( 'content', get_post_format() );
				echo '</div>';					
				endif;
				?>

			<?php endwhile; ?>
</div><!-- .grid -->
<div class="outer-wrapper"><div class="wrapper">
			<?php rmg_paging_nav(); ?>
			</div></div>
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
		
		<div class="clearfix"></div>
		</div><!-- .left col 75 -->
		
		
		</div></div><!-- .outer-wrapper -->
	</main><!-- #main -->
</div><!-- #primary -->

<script type="text/javascript">
$( function() {
	  
	  $('.post-grid').isotope({
		 percentPosition: true,
	  layoutMode: 'packery',
	  //   layoutMode: 'masonry',
	    itemSelector: '.post-grid-item',
	    packery: {
	  // masonry: {
	      gutter: '.post-grid-gutter'
	      }
	  });
	  
	});


$(document).ready(function(){
 // $("#blog-sidebar").sticky({topSpacing:0});
});


</script>
<?php get_footer(); ?>
