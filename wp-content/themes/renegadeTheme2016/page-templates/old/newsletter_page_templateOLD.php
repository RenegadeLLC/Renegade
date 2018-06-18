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


$headline_wrapper_color = get_field('headline_wrapper_color');
$body_wrapper_color = get_field('body_wrapper_color');
$headline = get_field('headline');
$subheadline = get_field('sub_headline');

$newsletterHTML = '';
$newsletterPageHTML = '';

$rn_args = array( 'post_type' => 'newsletters', 'posts_per_page' => 1);

$rn_query = new WP_Query( $rn_args );

while ($rn_query->have_posts() ) : $rn_query->the_post();
	$newsletterHTML = require_once (FUNCTIONS . '/newsletter_loop.php');
	//$newsletterHTML .=	get_template_part( 'content', get_post_type());
	$rn_title = get_the_title( $post->ID );
	$rn_date = get_field('rn_date');
endwhile;


$newsletterPageHTML .= '<div class="newsletter-page">';

///////BEGIN HTML RENDER////////////

$newsletterPageHTML .= '<div class="outer-wrapper" style="background-color:' . $headline_wrapper_color . '; overflow:hidden;"><div class="wrapper">';
$newsletterPageHTML .= '<h1>'. $headline . ' <span class="gray">' . $subheadline . '</span></h1>';
$newsletterPageHTML .= '<div class="newsletter-page-left">';
$newsletterPageHTML .= '<div class="newsletter-header">';
$newsletterPageHTML .= '<div class="newsletter-title">' . $rn_title . '</div>';
$newsletterPageHTML .= '<div class="newsletter-date">' . $rn_date . '</div>';

$newsletterPageHTML .= '</div>';

$newsletterPageHTML .= '<div class="outer-wrapper" style="background-color:' . $body_wrapper_color . '; overflow:hidden;"><div class="wrapper"><div class="newsletter-content">';
	
wp_reset_postdata();

$newsletterPageHTML .= $newsletterHTML;
$newsletterPageHTML .= '</div></div></div></div>';

$newsletterPageHTML .= '<div class="newsletter-page-right">';
$sidebar_item = get_field('sidebar_item');


	if( have_rows('sidebar_item') ):
	
	
	
	// loop through the rows of data
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
			
			$newsletterPageHTML .= '<div class="sidebar-item" style="background-color:' .$background_color. '; color:' . $text_color . ';">';
	

	

	if($sidebar_content_type == 'Subscribe to List' ):
	
		//GET POST ARCHIVES
		$newsletterPageHTML .= '<h1 style="color:' . $sidebar_headline_color  . ';">Subscribe to List</h1><div class="<div class="clearfix sidebar-content">';
		
		$signup = do_shortcode( '[mc4wp_form id="3849"]' );
		
		$newsletterPageHTML .= $signup  . '</div>';
	
	endif;

	if($sidebar_content_type == 'Archives' ):
	
	//GET POST CATEGORIES
	$newsletterPageHTML .= '<h1>Categories</h1><div class="sidebar-item"><div class="categories-list sidebar-content">';
	
	$archives = do_shortcode( '[list_archives type="monthly" format="custom" post_type="newsletters"]' );
	
	$newsletterPageHTML .= $archives . '</div></div>';
	
	endif;

	if($sidebar_content_type == 'Categories' ):
	
	//GET POST CATEGORIES
	$newsletterPageHTML .= '<h1>Categories</h1><div class="sidebar-item"><div class="tags-list sidebar-content">';
	
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

get_footer(); ?>