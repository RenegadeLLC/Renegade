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
$rn_args = array( 'post_type' => 'newsletters', 'posts_per_page' => 1, 'post_status' => 'publish');

$rn_query = new WP_Query( $rn_args );

	while ($rn_query->have_posts() ) : $rn_query->the_post();
		$newsletterHTML = require_once (FUNCTIONS . '/newsletter_loop.php');
		$rn_title = get_the_title( $post->ID );
		$rn_date = get_field('rn_date');
		$rn_final_note = get_field('rn_final_note');
	endwhile;
	
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
$newsletterPageHTML .= '<div class="outer-wrapper" style="background-color:' . $body_wrapper_color . '; overflow:hidden;"><div class="wrapper"><div class="newsletter-content grid-item-w-75 float-left">';

$newsletterPageHTML .= $newsletterHTML;

	if($rn_final_note):
		$newsletterPageHTML  .= '<div style="background-color:#333; color:#fff; padding:16px;">' . $rn_final_note . '</div>';
	endif;
	
$newsletterPageHTML .= '</div>';

$newsletterPageHTML .= '</div>';//newsletter-right
	
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
	<div class="float-left grid-item-w-25">
<div id="newsletter-sidebar">
	<?php get_sidebar('newsletter-sidebar');?>
		</div>
	</div>
	</div></div>
	<?php get_footer(); ?>