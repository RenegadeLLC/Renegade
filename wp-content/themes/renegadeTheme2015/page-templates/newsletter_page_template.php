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
$headline = get_field('headline');
$subheadline = get_field('sub_headline');
$newsletterPageHTML = '<div style="background:#E6E7E8; display:block; overflow:hidden;"><div style="background-color:#000; width:100%; position:absolute; height:270px;"></div>';
$newsletterPageHTML .= '<div class="headline-ct"><h1>'. $headline . ' <span class="gray">' . $subheadline . '</span></h1></div>';
$newsletterPageHTML .= '<div class="wrapper"><div class="newsletter-page">';

$sidebar_content = get_field('sidebar_content');
//$sidebar_items = implode(', ', get_field('sidebar_items'));
$sidebar_items = get_field('sidebar_items');
//print_r($sidebar_items);
// the query
$sidebar = get_field('sidebar');

$rn_args = array( 'post_type' => 'newsletters', 'posts_per_page' => 1);

$rn_query = new WP_Query( $rn_args );

	while ($rn_query->have_posts() ) : $rn_query->the_post();
	
		$newsletterPageHTML .=	get_template_part( 'content', get_post_type());
	
	endwhile;
	
wp_reset_postdata();

$newsletterPageHTML .= '</div>';
//$newsletterPageHTML .= '<div class="wrapper">';

	if($sidebar == 'Yes'):
		//$newsletterPageHTML .= '<div class="newsletter-page-left" style="background:#fff; overflow:hidden; border-top:8px solid #1AC3EC;">';
	endif;

//$newsletterPageHTML .= '</div>'; //newsletter-page-left
if($sidebar == 'Yes'):
$newsletterPageHTML .= '</div>';//close left side
$newsletterPageHTML .= '<div class="newsletter-page-right">';
$newsletterPageHTML .= '<div class="news">';
$newsletterPageHTML .= '<div class="saw-small-inv"></div>';
if( in_array( 'archives', $sidebar_items ) ):

//GET POST ARCHIVES
$newsletterPageHTML .= '<div class="ribbon-right clearfix sidebar-nav">Archives</div><div class="sidebar-item sidebar-closed"><div class="archive-list clearfix sidebar-content">';

$archives = do_shortcode( '[list_archives type="monthly" format="custom" post_type="newsletters"]' );

$newsletterPageHTML .= $archives . '</div></div>';

endif;

if( in_array( 'categories', $sidebar_items ) ):

//GET POST CATEGORIES
$newsletterPageHTML .= '<div class="ribbon-right clearfix sidebar-nav">Categories</div><div class="sidebar-item sidebar-closed"><div class="categories-list sidebar-content">';

$categories = do_shortcode( '[list_categories]' );

$newsletterPageHTML .= $categories . '</div></div>';

endif;

if( in_array( 'tags', $sidebar_items ) ):

//GET POST CATEGORIES
$newsletterPageHTML .= '<div class="ribbon-right clearfix sidebar-nav">Tags</div><div class="sidebar-item sidebar-closed"><div class="tags-list sidebar-content">';

$tags = do_shortcode( '[list_tags]' );

$newsletterPageHTML .= $tags . '</div></div>';

endif;

if($sidebar_content):
$newsletterPageHTML .=  $sidebar_content;
endif;
$newsletterPageHTML .= '</div></div>';
endif;

$newsletterPageHTML .= '</div></div>';//wrapper

echo $newsletterPageHTML;

get_footer(); ?>