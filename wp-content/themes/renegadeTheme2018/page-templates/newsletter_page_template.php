<?php
/**
 * Template Name: Newsletter Page Template
 *
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2015
 */

get_header();

global $year;

$headline_wrapper_color = get_field('headline_wrapper_color');
$body_wrapper_color = get_field('body_wrapper_color');
$headline = get_field('headline');
$subheadline = get_field('sub_headline');
$page_class=get_field('page_class');

//////SUBSCRIBE FORM VARS///////////
$add_subscribe_form = get_field('add_subscribe_form');
$form_name = get_field('form_name');
$subscribe_form_shortcode = get_field('subscribe_form_shortcode');
$form_background_color = get_field('form_background_color');
$form_text_color = get_field('form_text_color');
$year = current_time('Y');

$newsletterHTML = '';
$newsletterPageHTML = '';
$newsletterPageHTML .= '<div class="newsletters post-list" year="' . $year . '"></div>';
$rn_args = array( 'post_type' => 'newsletters', 'posts_per_page' => -1, 'post_status' => 'publish', 'order' => 'DESC' );

$rn_query = new WP_Query( $rn_args );
$i = 1;
$newsletterHTML = '';

	while ($rn_query->have_posts() ) : $rn_query->the_post();
	
	   if($i==1):
         $newsletterHTML .= require (FUNCTIONS . 'newsletter_excerpt_feature_loop.php');
	   else:
	       $newsletterHTML .= require (FUNCTIONS . 'newsletter_excerpt_loop.php');
       endif;
      
	
    //   $newsletterHTML .= require (FUNCTIONS . 'newsletter_excerpt_loop.php');
       
       	$rn_title = get_the_title( $post->ID );
        	$rn_date = get_field('rn_date');
        	$rn_final_note = get_field('rn_final_note');
        	
		$i++;
	
	endwhile;
	
	//do_shortcode('[ajax_load_more id="newsletter" post_type="newsletters" posts_per_page="10" button_label="Load More" button_loading_label="Loading...."]');
	wp_reset_postdata();
	
$newsletterPageHTML .= '<div class="' . $page_class .  '">';

///////BEGIN HTML RENDER////////////

$newsletterPageHTML .= '<div class="outer-wrapper" style="background-color:' . $headline_wrapper_color . '; overflow:hidden;"><div class="wrapper">';
$newsletterPageHTML .= '<div id="container">';
$newsletterPageHTML .= '<div class="headline-ct"><h1 class="white text-center">'. $headline . ' <span class="gray">' . $subheadline . '</span></h1></div>';
$newsletterPageHTML .= '<div class="clear-fix"></div>';
$newsletterPageHTML .= '</div><!-- .container-->';
$newsletterPageHTML .= '</div><!-- .wrapper -->';
$newsletterPageHTML .= '</div><!-- .outer-wrapper -->';

$newsletterPageHTML .= '<div class="outer-wrapper" style="background-color:' . $body_wrapper_color . '; overflow:hidden;"><div class="wrapper"><div class="newsletter-content">';
$newsletterPageHTML .= '<div class="grid"><div class="grid-gutter"></div>';
$newsletterPageHTML .= $newsletterHTML;
	
$newsletterPageHTML .= '</div><!--.grid --></div><!--.newsletter-content-->';

$newsletterPageHTML .= '</div><!-- .wrapper --></div><!-- .outer-wrapper -->';
	
echo $newsletterPageHTML;
	
	?>
	
	<script type="text/javascript">
	
	$( function() {
	  
	  $('.grid').isotope({
		 percentPosition: true,
	  layoutMode: 'packery',
	  //   layoutMode: 'masonry',
	    itemSelector: '.grid-item',
	    isOriginTop: false,
	    packery: {
	  // masonry: {
	      gutter: '.grid-gutter'
	      }
	  });
	  
	});
	</script>
	
	</div></div>
	<?php get_footer(); ?>