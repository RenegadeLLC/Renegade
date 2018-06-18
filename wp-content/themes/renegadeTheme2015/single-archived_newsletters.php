<?php
/**
 * The template for displaying a single Archived Newsletter
 *
 * @package Renegade
 */

get_header(); 

//wp_head();

$archived_newsletter_html = '';
?>
<div style="background:#E6E7E8; display:block; overflow:hidden;">
<div class="wrapper">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
		<div class="newsletter-page">
		<!-- external blog container --><div class="grid-item-w-75" style="background:#f2f2f2;">
<div class="archived-newsletter-wrapper"><div class="newsletter-ct">

<div class="newsletter-content-ct">
<?php 
the_content(); ?>
		</div>
		</div><!-- .content-wrapper -->

<!-- .news-page -->
		<?php endwhile;?>
</div>
	<div class="clearfix"></div>
		</div><!-- .left col 75 -->
	<div class="grid-item-w-25">
		<div id="blog-sidebar">
		<?php 
		require_once( FUNCTIONS . 'build_sidebar.php' );
		
		?>
		</div><!-- #blog-sidebar -->
		</div><!-- .page-grid-item-25 -->
		
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- gray back -->
<?php get_footer(); ?>