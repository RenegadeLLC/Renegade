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
<div class="page-grid-item-w-75" style="background:#fff;">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); 
			
			if($index <= 1):
			
			if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
			
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
			
			} else{
				$image = '';
			}
				echo('<div class="featured-post grid-item-w-100"><div class="featured-post-left"><div class="featured-post-image circle" style="background-image:url(' . $image[0] . ');">');		
				echo('</div></div><div class="featured-post-right"><div class="featured-post-right-text">');	
				echo '<div class="date">' . the_date( 'l, F, j, Y') . '</div>';
				echo('<h1>' . get_the_title() . '</h1>');
				$excerpt = get_the_excerpt();
				echo($excerpt);
				echo('</div></div></div>');				
				$index++;	
				echo '<div class="blog-grid" style="background-color:#f1f1f1;"><div class="blog-grid-gutter"></div>';		
			else:
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
			
				echo '<div class="blog-grid-item blog-grid-item-w-33 blog-tile">';
			
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
		
		<div class="page-grid-item-w-25">
		
		<?php /******************  BUILD SIDEBAR *********************/


	//	$sidebar_item = get_field('sidebar_item', get_option('page_for_posts'));
		
		$sidebarHTML = '';

		if( have_rows('sidebar_item', get_option('page_for_posts')) ):
		
	
 	
   		 while ( have_rows('sidebar_item', get_option('page_for_posts')) ) : the_row();
		
			$sidebar_content_type = get_sub_field('sidebar_content_type');
			$sidebar_headline = get_sub_field('sidebar_headline');
			$background_color = get_sub_field('background_color');
			$background_image = get_sub_field('sidebar_background_image');
			$text_color = get_sub_field('text_color');
			$sidebar_headline_color = get_sub_field('sidebar_headline_color');
			$link_color = get_sub_field('link_color');

			$sidebarBlockHTML = '';
			
			$sidebarBlockHTML .= '<div class="square"><div class="sidebar-block" style="';
			
			
			if($background_color):
				$sidebarBlockHTML .= 'background-color:' . $background_color . '; '; 
			endif;
			
			if($background_image):
				$sidebarBlockHTML .= 'background-image:url(' . $background_image . '); background-repeat:no-repeat; background-size:cover; background-position:center; ';
			endif;
			
			if($text_color):
				$sidebarBlockHTML .= 'color:' . $text_color . '; ';
			endif;
			
			$sidebarBlockHTML .= '">';//CLOSE CUSTSOM STYLING
			
			$sidebarBlockHTML .= '<div class="mark"></div>';
			
			$sidebarBlockHTML .= 	'<h1 style="color:' . $sidebar_headline_color . ';">' . $sidebar_headline . '</h1>';

			switch ($sidebar_content_type) {
				
				case 'Inline Navigation':
					echo 'Inline Navigation';
					break;
					
				case 'Subscribe to List':
					$signup_form_shortcode = get_sub_field('signup_form_shortcode', get_option('page_for_posts'));
					
				//	echo $signup_form_shortcode;
					//[acf field='signup_form_shortcode']
					$sidebarBlockHTML .= do_shortcode($signup_form_shortcode);
					 
					break;
				
				case 'Archives':
					$sidebarBlockHTML .= '<ul class="archive">';
					
					 $args = array(
						'type'            => 'monthly',
						'limit'           => '',
						'format'          => 'custom', 
						'before'          => '',
						'after'           => '<br />',
						'show_post_count' => false,
						'echo'            => 0,
						'order'           => 'DESC'
					);
					
					$archives = wp_get_archives( $args );
					
					$sidebarBlockHTML .= $archives . '</ul>';
					
					break;
					
				case 'Categories':
					
					$category_args = array(
							'type'                     => 'post',
							'child_of'                 => 0,
							'parent'                   => '',
							'orderby'                  => 'name',
							'order'                    => 'ASC',
							'hide_empty'               => 1,
							'hierarchical'             => 1,
							'exclude'                  => '',
							'include'                  => '',
							'number'                   => '',
							'taxonomy'                 => 'category',
							'pad_counts'               => false
					
					);
					
					$categories = get_the_category_list();
					
					$sidebarBlockHTML .= $categories;
					
					break;
					
				case 'Tags':
						echo 'Tags';
						break;
						
				case 'Image':
						echo 'Image';
						break;
						
				case 'Custom':
						//echo 'Custom';
						break;
			}
			
		$sidebarBlockHTML .='</div></div>'; //CLOSE SIDEBAR BLOCK

		$sidebarHTML .= $sidebarBlockHTML;
		
		endwhile;
		echo $sidebarHTML;
else :

    // no rows found

endif;
		
		?>
		</div><!-- .page-grid-item-25 -->
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<script type="text/javascript">
$( function() {
	  
	  $('.blog-grid').isotope({
		 percentPosition: true,
	  layoutMode: 'packery',
	  //   layoutMode: 'masonry',
	    itemSelector: '.blog-grid-item',
	    packery: {
	  // masonry: {
	      gutter: '.blog-grid-gutter'
	      }
	  });
	  
	});
</script>
<?php get_footer(); ?>
