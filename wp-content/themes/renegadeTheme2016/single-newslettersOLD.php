<?php
/**
 * the template for displaying a single Newsletter
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

$newsletterPageHTML .= '<div class="outer-wrapper" style="background-color:' . $headline_wrapper_color . '; overflow:hidden;"><div class="wrapper">';
$newsletterPageHTML .= '<h1>'. $headline . ' <span class="gray">' . $subheadline . '</span></h1>';
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
$newsletterPageHTML .= '</div><!-- .wrapper -->';
$newsletterPageHTML .= '</div><!-- .outer-wrapper -->';
$newsletterPageHTML .= '<div class="outer-wrapper" style="background-color:' . $body_wrapper_color . '; overflow:hidden;"><div class="wrapper"><div class="newsletter-content">';
	
wp_reset_postdata();

//$newsletterPageHTML .= '<div class="newsletter-page-left">';
$newsletterPageHTML .= $newsletterHTML;
$newsletterPageHTML .= '</div>';

$newsletterPageHTML .= '<div class="newsletter-page-right">';
$sidebar_item = get_field('sidebar_item');

	if( have_rows('sidebar_item') ):
	
	while ( have_rows('sidebar_item') ) : the_row();
	
			$sidebar_headline = get_sub_field('sidebar_headline');
			$sidebar_content_type = get_sub_field('sidebar_content_type');
			$signup_form_shortcode = get_sub_field('signup_form_shortcode');
			$sidebar_custom_content = get_sub_field('sidebar_custom_content');
			$sidebar_image = get_sub_field('sidebar_image');
			$background_color = get_sub_field('background_color');
			$sidebar_background_image = get_sub_field('sidebar_background_image');
			$sidebar_headline_color = get_sub_field('sidebar_headline_color');
			$text_color = get_sub_field('text_color');
			$link_color = get_sub_field('link_color');
			
			$newsletterPageHTML .= '<div class="sidebar-module" style="background-color:' .$background_color. '; color:' . $text_color . ';">';
	

	

	if($sidebar_content_type == 'Subscribe to List' ):
	
		//GET POST ARCHIVES
		$newsletterPageHTML .= '<h1 style="color:' . $sidebar_headline_color  . ';">Subscribe to List</h1><div class="<div class="clearfix sidebar-content">';
		
		$signup = do_shortcode( '[mc4wp_form id="3849"]' );
		
		$newsletterPageHTML .= $signup  . '</div>';
	
	endif;

	if($sidebar_content_type == 'Archives' ):
	
	//GET POST CATEGORIES
	$newsletterPageHTML .= '<div class="sidebar-item"><h1>Archives</h1><div class="sidebar-content categories-list">';
	
	//$archives = do_shortcode( '[list_archives type="monthly" format="custom" post_type="newsletters"]' );
	
	$args = array(
			'type'            => 'monthly',
			'limit'           => '',
			'format'          => 'html',
			'before'          => '',
			'after'           => '',
			'show_post_count' => false,
			'echo'            => 0,
			'order'           => 'DESC',
			'post_type'     => 'newsletters'
	);
	$archives = wp_get_archives( $args );/**/
	//$archives = wp_custom_archive();
	$newsletterPageHTML .= $archives . '</div></div>';
	
	endif;

	if($sidebar_content_type == 'Categories' ):
	
	//GET POST CATEGORIES
	$newsletterPageHTML .= '<div class="sidebar-item"><h1>Categories</h1><div class="sidebar-content tags-list">';
	
	$categories = do_shortcode( '[list_categories]' );
	
	$newsletterPageHTML .= $categories . '</div></div>';
	
	endif;
	
	
	$newsletterPageHTML .= '</div>';
			endwhile;
	endif;
	
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