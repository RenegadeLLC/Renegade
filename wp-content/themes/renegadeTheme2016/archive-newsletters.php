<?php
/**
 * Template Name: Archived Newsletter Page Template
 *
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2015
 */

get_header();

$data = get_post(24);

global $year;

$headline_wrapper_color = $data->headline_wrapper_color;
$body_wrapper_color = $data->body_wrapper_color;
$headline = $data->headline; 
$subheadline = $data->sub_headline;
$page_class = $data->page_class;
$year = get_the_date('Y');


/*
$sidebar_headline = $data->sidebar_headline;
$sidebar_content_type = $data->idebar_content_type;
$signup_form_shortcode = $data->signup_form_shortcode;
$sidebar_custom_content = $data->sidebar_custom_content;

//////SUBSCRIBE FORM VARS///////////
$add_subscribe_form = $data->add_subscribe_form;
$form_name = $data->form_name;
$subscribe_form_shortcode = $data->subscribe_form_shortcode;
$form_background_color = $data->form_background_color;
$form_text_color = $data->form_text_color;
*/
$newsletterHTML = '';
$newsletterPageHTML = '';

if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		$newsletterHTML = require_once (FUNCTIONS . '/newsletter_loop.php');
		$rn_title = get_the_title( $post->ID );
		$rn_date = get_field('rn_date');
		$rn_final_note = get_field('rn_final_note');
	endwhile;
endif;
$newsletterPageHTML .= '<div class="' . $page_class . '">';

///////BEGIN HTML RENDER////////////
$newsletterPageHTML .= '<div class="newsletters post-list" year="' . $year . '"></div>';
$newsletterPageHTML .= '<div class="outer-wrapper" style="background-color:' . $headline_wrapper_color . '; overflow:hidden;"><div class="wrapper">';
$newsletterPageHTML .= '<div id="container">';
$newsletterPageHTML .= '<div class="headline-ct"><h1 class="white text-center">' . $headline . ' <span class="gray">' . $subheadline . '</span></h1></div>';
$newsletterPageHTML .= '<div class="clear-fix"></div>';

$newsletterPageHTML .= '</div><!-- .container-->';
$newsletterPageHTML .= '</div><!-- .wrapper -->';
$newsletterPageHTML .= '</div><!-- .outer-wrapper -->';
$newsletterPageHTML .= '<div class="outer-wrapper" style="background-color:' . $body_wrapper_color . '; overflow:hidden;"><div class="wrapper"><div class="newsletter-content grid-item-w-75 float-left">';
	
wp_reset_postdata();

//$newsletterPageHTML .= '<div class="newsletter-page-left">';
$newsletterPageHTML .= $newsletterHTML;

if($rn_final_note):
$newsletterPageHTML  .= '<div style="background-color:#333; color:#fff; padding:16px;">' . $rn_final_note . '</div>';

endif;
$newsletterPageHTML .= '</div>';

$newsletterPageHTML .= '<div class="float-right grid-item-w-25">';

$post_type = 'newsletters';
$archive_type = 'monthly';

//require_once (FUNCTIONS . '/build_sidebarB.php');


//$newsletterPageHTML .= $sidebarHTML;
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
		</div>
</div>
	<?php  get_footer(); ?>