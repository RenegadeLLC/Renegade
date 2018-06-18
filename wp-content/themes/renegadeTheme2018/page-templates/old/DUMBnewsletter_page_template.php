<?php
/**
 * DUMBTemplate Name: Newsletter Page Template
 *
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2015
 */

get_header();

$headline_wrapper_color = get_field('headline_wrapper_color');
$body_wrapper_color = get_field('body_wrapper_color');
$headline = get_field('headline');
$subheadline = get_field('sub_headline');

//////SUBSCRIBE FORM VARS///////////
$add_subscribe_form = get_field('add_subscribe_form');
$form_name = get_field('form_name');
$subscribe_form_shortcode = get_field('subscribe_form_shortcode');
$form_background_color = get_field('form_background_color');
$form_text_color = get_field('form_text_color');

$newsletterHTML = '';
$newsletterPageHTML = '';

$rn_args = array( 'post_type' => 'newsletters', 'posts_per_page' => 1);

$rn_query = new WP_Query( $rn_args );

	while ($rn_query->have_posts() ) : $rn_query->the_post();
		$newsletterHTML = require_once (FUNCTIONS . '/newsletter_loop.php');
		$rn_title = get_the_title( $post->ID );
		$rn_date = get_field('rn_date');
	endwhile;

$newsletterPageHTML .= '<div class="newsletter-page">';

///////BEGIN HTML RENDER////////////
$newsletterPageHTML .= '<div id="container">';
$newsletterPageHTML .= '<div class="outer-wrapper" style="background-color:' . $headline_wrapper_color . '; overflow:hidden;"><div class="wrapper">';
$newsletterPageHTML .= '<div class="headline-ct"><h1 class="white text-center">'. $headline . ' <span class="gray">' . $subheadline . '</span></h1></div>';
$newsletterPageHTML .= '<div class="clear-fix"></div>';
$newsletterPageHTML .= '<div class="grid"><div class="grid-gutter"></div><div class="grid-item grid-item-w-75">';
$newsletterPageHTML .= '<div class="newsletter-header">';
$newsletterPageHTML .= '<div class="newsletter-title">' . $rn_title . '</div>';
$newsletterPageHTML .= '<div class="newsletter-date">' . $rn_date . '</div>';	
$newsletterPageHTML .= '</div><!-- .newsletter-header-->';
$newsletterPageHTML .= '</div><!-- .grid-item-->';
	
	if($add_subscribe_form == 'Yes'):		
		$subscribe = do_shortcode( $subscribe_form_shortcode );
		$newsletterPageHTML .= '<div class="grid-item grid-item-w-25 sidebar-item subscribe" style="background-color:' . $form_background_color . ';">';
		$newsletterPageHTML .= '<h1>' . $form_name . '</h1>';
		$newsletterPageHTML .= $subscribe;
		$newsletterPageHTML .= '</div><!-- .grid-item-->';
	endif;
	
$newsletterPageHTML .= '</div><!-- .grid-->';
$newsletterPageHTML .= '</div><!-- .container-->';
$newsletterPageHTML .= '</div><!-- .wrapper -->';
$newsletterPageHTML .= '</div><!-- .outer-wrapper -->';
$newsletterPageHTML .= '<div class="outer-wrapper" style="background-color:' . $body_wrapper_color . '; overflow:hidden;"><div class="wrapper"><div class="newsletter-content grid-item-w-75 float-left">';
	
wp_reset_postdata();

//$newsletterPageHTML .= '<div class="newsletter-page-left">';
$newsletterPageHTML .= $newsletterHTML;
$newsletterPageHTML .= '</div>';

$newsletterPageHTML .= '<div class="float-right grid-item-w-25">';

$post_type = 'newsletters';
$archive_type = 'monthly';

require_once (FUNCTIONS . '/build_sidebarB.php');

$newsletterPageHTML .= $sidebarHTML;
	$newsletterPageHTML .= '</div>';//newsletter-right
	$newsletterPageHTML .= '</div>';//wrapper
	$newsletterPageHTML .= '</div>';//newsletter-page
	
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
	<?php  get_footer(); ?>