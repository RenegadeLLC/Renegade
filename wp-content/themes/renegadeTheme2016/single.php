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

<div class="blog-post-ct">
<div class="blog-header-ct">
<div class="outer-wrapper" style="background-color:#000;"><div class="wrapper">
<div class="headline-ct">

<header class="page-header">
				<h1 class="white text-center">
Saw a Good Idea

</h1></header></div><!-- .headline-ct--></div><!-- .wrapper --></div><!-- .outerwrapper -->
</div><!-- .blog-header-ct -->

<div class="outer-wrapper" style="background-color:#e6e7e8;"><div class="wrapper">
<div class="grid-item-w-75" style="background:#fff !important; padding:40px;">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' );
				?>
				<p>
				<?php rmg_post_nav(); ?></p>
		<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || get_comments_number() ) :
				//	comments_template();
				endif;
			?>

		<?php endwhile; // end of the loop?>
				<div class="clearfix"></div>
		</div><!-- .left col 75 -->
		
		<div class="grid-item-w-25">
		<div id="blog-sidebar">
		<?php 
		get_sidebar();
		
		?>
				</div><!-- .blog-post-ct -->
			</div><!-- .wrapper --></div><!-- .outer-wrapper -->
		</main><!-- #main -->
	</div><!-- #primary -->
	<script type="text/javascript">
	
	</script>
	
<?php get_footer(); ?>