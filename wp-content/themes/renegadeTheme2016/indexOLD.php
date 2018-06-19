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
$headline = get_field('headline', get_option('page_for_posts'));
$subheadline = get_field('subheadline', get_option('page_for_posts'));
$headline_background_color = get_field('headline_background_color', get_option('page_for_posts'));


$pageHTML .= '<div class="outer-wrapper" style="background-color:#000;"><div class="wrapper">';
$pageHTML .= '<div class="headline-ct">';
$pageHTML .= '<h1 class="white text-center">'. $headline . '</h1>';
$pageHTML .= '</div><!-- headline-ct -->';
$pageHTML .=  '</div><!-- .wrapper--></div><!-- .outer-wrapper-->';

$index = 1;
echo $pageHTML;
//pageHTML .= '<div class="outer-wrapper" style="background-color:#e6e7e8;">';

?>

<div class="outer-wrapper" style="background-color:#e6e7e8;"><div class="wrapper">
<!-- external blog container --><div class="grid-item-w-75" style="background:#fff !important;">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			
			<?php while ( have_posts() ) : the_post(); 
			
			$post_url = esc_url( get_permalink() );
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
			
			if($index <= 1):
			
			if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
				
				echo('<div class="featured-post grid-item-w-100"><div class="featured-post-left"><a href="' . $post_url . '"><div class="post-img-ct" style="background:url(' . $image[0] . ') no-repeat cover center;"><img class="featured-post-image circle-big" src="' . $image[0] . '"></a></div>');
					
			} else{
				//echo('<div class="featured-post grid-item-w-100">');
				$upload_dir = content_url();
				$upload_path = $upload_dir . '/uploads/';
				echo('<div class="featured-post grid-item-w-100"><div class="featured-post-left"><div class="saw-circle circle"><img src="' . $upload_path  . 'saw_white_300x300.png"></div>');
					
			
			}
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

			<?php rmg_paging_nav(); ?>
			
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
		
		<div class="clearfix"></div>
		</div><!-- .left col 75 -->
		
		<div class="grid-item-w-25">
		<div id="blog-sidebar">
		<?php 
		get_sidebar();
		
		?>
		</div><!-- #blog-sidebar -->
		</div><!-- .page-grid-item-25 -->
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
