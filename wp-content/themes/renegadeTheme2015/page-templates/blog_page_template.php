<?php
/**
 * Template Name: Blog Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2015
 */


get_header(); 
?>

<div id="primary" class="content-area">
<main id="main" class="site-main" role="main">

<?php 

$pageHTML = '';
$pageHTML .= '<div style="display:block; position:relative; overflow:hidden; background:#E6E7E8; height:100%; width:100%;">';
$pageHTML .= '<div style="background-color:#000; width:100%; position:absolute; height:538px;">SERIOUSLY????</div>';
//GET THE MAIN PAGE VARIABLES

$headline = get_field('headline');
$subheader = get_field('subheader');
$headline_background_color = get_field('headline_background_color');

$pageHTML .= '<div class="wrapper">';
$pageHTML .= '<div class="headline-ct">';

//if($header){
	$pageHTML .= '<h1>'. $headline . '</h1>';
//}

if($subheader){
	$pageHTML .= '<div class="sub-headline-ct">';
	$pageHTML .= '<h2>'. $subheader . '</h2></div>';
}

$pageHTML .= '</div><!-- headline-ct -->';
$pageHTML .=  '</div><!-- .wrapper-->';


echo $pageHTML;

?>





		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php rmg_paging_nav(); ?>
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?><?php get_sidebar(); ?>
</div>
		</main><!-- #main -->
	</div><!-- #primary -->


<?php get_footer(); ?>
