<?php
/**
 * The template for displaying a single Newsletter
 *
 * @package Renegade
 */

//get_header(); 

wp_head();

$newsletter_html = '';
?>
<div style="background:#E6E7E8;">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		
		<div class="newsletter-page">
<div style="max-width:900px;"><div class="newsletter-top">
<div class="newsletter-logo"></div><div class="newsletter-tag">News that Made <span class="bold">THE CUT</span></div></div>
<div class="newsletter-ct">

<div class="newsletter-content-ct">
<?php 

		//$rn_title = wp_title('', FALSE);
require( FUNCTIONS . 'newsletter_loop.php' );


?><div class="newsletter-footer"></div>
		</div>
		</div><!-- .content-wrapper -->

<!-- .news-page -->
		
</div>
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- gray back -->
<?php get_footer(); ?>
