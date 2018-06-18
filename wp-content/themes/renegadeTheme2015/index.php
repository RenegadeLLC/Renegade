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
$pageHTML .= '<div style="background-color:#000; width:100%; position:absolute; height:578px;"></div>';
//GET THE MAIN PAGE VARIABLES

//$headline = get_field('headline');
$headline = get_field('headline', get_option('page_for_posts'));
$subheadline = get_field('subheadline', get_option('page_for_posts'));
$headline_background_color = get_field('headline_background_color', get_option('page_for_posts'));


$pageHTML .= '<div class="wrapper">';
$pageHTML .= '<div class="headline-ct">';
$pageHTML .= '<h1>'. $headline . '</h1>';
$pageHTML .= '</div><!-- headline-ct -->';
$pageHTML .=  '</div><!-- .wrapper-->';

$index = 1;
echo $pageHTML;


?>

<div class="wrapper">
<!-- external blog container --><div class="grid-item-w-75" style="background:#fff;">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			
			<?php while ( have_posts() ) : the_post(); 
			
			$post_url = esc_url( get_permalink() );
			
			if($index <= 1):
			
			if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );		
			} else{
				$image = '';
			}
				//echo('<div class="featured-post grid-item-w-100"><div class="featured-post-left"><a href="' . $post_url . '"><div class="featured-post-image circle-big" style="background-image:url(' . $image[0] . ');"></a>');		
				echo('<div class="featured-post grid-item-w-100"><div class="featured-post-left"><a href="' . $post_url . '"><img class="featured-post-image circle-big" src="' . $image[0] . '"></a>');
			
			
				echo('</div><div class="featured-post-right"><div class="featured-post-right-text">');	
				echo '<div class="date">' . the_date( 'l, F, j, Y') . '</div>';
				echo('<h1><a href="' . $post_url . '">' . get_the_title() . '</a></h1>');
				$excerpt = get_the_excerpt();
				echo($excerpt);
				echo('</div></div></div>');				
				$index++;	
				echo '<div class="post-grid" style="background-color:#f1f1f1;"><div class="post-grid-gutter"></div>';		
			else:
				echo '<div class="post-grid-item post-grid-item-w-33 blog-tile">';
				get_template_part( 'content', get_post_format() );
				echo '</div>';					
				endif;
				?>

			<?php endwhile; ?>

			<?php rmg_paging_nav(); ?>
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?><?php //get_sidebar(); ?>
		</div><!-- .grid -->
		<div class="clearfix"></div>
		</div><!-- .left col 75 -->
		
		<div class="grid-item-w-25">
		<div id="blog-sidebar">
		<?php 
		require_once( FUNCTIONS . 'build_sidebar.php' );
		
		?>
		</div><!-- #blog-sidebar -->
		</div><!-- .page-grid-item-25 -->
		</div>
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
