<?php
/**
 * The template for displaying all single posts.
 *
 * @package Renegade
 */
get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<div class="blog-page">
<div style="background-color:#000; width:100%; position:absolute; height:138px;"></div>
<div class="wrapper" style="overflow:hidden;">

<div class="blog-post-ct">
<div class="blog-header-ct">
		<?php
$bl_header = get_field('bl_header', get_option('page_for_posts'), FALSE);
$bl_subheader = get_field('bl_subheader', get_option('page_for_posts'), FALSE);

if($bl_header){
	echo('<h1 class="blog-page">'. $bl_header . '</h1>');
}

if($bl_subheader){
	//echo('<h2>'. $bl_subheader . '</h2>');
}
?></div><!-- .blog-header-ct -->
<div style="background:#fff; width:100%; height:100%; display:block; overflow:hidden;">
<div class="blog-left">
	

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' );
				?>
				<p>
				<?php rmg_post_nav(); ?></p>
			</div><!-- .blog-left -->
<div class="blog-right"><div id="blog-sidebar">
<?php 
require_once( FUNCTIONS . 'build_sidebar.php' );

?>


</div>
</div>			
		</div>	

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || get_comments_number() ) :
				//	comments_template();
				endif;
			?>

		<?php endwhile; // end of the loop?>
				</div><!-- .blog-post-ct -->
			</div><!-- .wrapper -->
		</main><!-- #main -->
	</div><!-- #primary -->
	<script type="text/javascript">
	
	$(document).ready(function(){
 // $("#blog-sidebar").sticky({topSpacing:0});
});
	</script>
	
<?php get_footer(); ?>