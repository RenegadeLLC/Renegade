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
$newsletterHTML = '<div style="background:#E6E7E8;"><div style="background-color:#000; width:100%; position:absolute; height:270px;"></div>';
$newsletterHTML .= '<div class="headline-ct"><h1>'. $headline . ' <span class="gray">' . $subheadline . '</span></h1></div>';
$newsletterHTML .= '<div class="wrapper"><div class="newsletter-page">';


$sidebar_content = get_field('sidebar_content');
//$sidebar_items = implode(', ', get_field('sidebar_items'));
$sidebar_items = get_field('sidebar_items');
//print_r($sidebar_items);
// the query
$sidebar = get_field('sidebar');

$rn_args = array( 'post_type' => 'newsletters', 'posts_per_page' => 1);

$rn_loop = new WP_Query( $rn_args );


$newsletterHTML .= '<div class="wrapper">';


	if($sidebar == 'Yes'):
		$newsletterHTML .= '<div class="newsletter-page-left" style="background:#fff; overflow:hidden; border-top:8px solid #1AC3EC;">';
	endif;

	//PUT NEWSLETTER POST AJAX CONTAINER HERE
while ( $rn_loop->have_posts() ) : $rn_loop->the_post();

		$rn_title = get_the_title( $post->ID );
		$rn_date = get_field('rn_date');
		$rn_introduction= get_field('rn_introduction');
		$rn_list_type = get_field('rn_list_type');
		$rn_banner = get_field('rn_banner');
		$rn_size = "full";	
	
	$newsletterHTML .= '<div class="newsletter-header">';
	$newsletterHTML .= '<div class="newsletter-title">' . $rn_title . '</div>';
	$newsletterHTML .= '<div class="newsletter-date">' . $rn_date . '</div></div>';
	$newsletterHTML .= '<div class="newsletter-banner">' . wp_get_attachment_image($rn_banner, $rn_size ) . '</div>';
	$newsletterHTML .= '<div class="newsletter-intro">' . $rn_introduction . '</div>';

// check if the repeater field has rows of data
if( have_rows('rn_section') ):

	if($rn_list_type == 'Ordered List'){
		$newsletterHTML .= '<ol>';
	}else if($rn_list_type == 'Unordered List'){
		$newsletterHTML .= '<ul>';
	}


 	// loop through the rows of data
    while ( have_rows('rn_section') ) : the_row();
    $newsletter_content_html = '';
        // display a sub field value
       // the_sub_field('sub_field_name');
      
		$rn_section_header = get_sub_field('rn_section_header');
		$rn_section_layout = get_sub_field('rn_section_layout');
		$rn_one_column_content = get_sub_field('rn_one_column_content');
		$rn_left_column_content = get_sub_field('rn_left_column_content');
		$rn_right_column_content = get_sub_field('rn_right_column_content');

		$newsletter_content_html .= '<li>';
		$newsletter_content_html .= '<h3 class="newsletter">' . $rn_section_header . '</h3>' ;
		
		if($rn_section_layout == 'One Column'){
			
			
			$newsletter_content_html .= '<div class="newsletter-text">' . $rn_one_column_content . '</div>';
		
		} else if($rn_section_layout == 'Two Columns'){
			
			$newsletter_content_html .= '<div class="left-col">' . $rn_left_column_content . '</div>';
			$newsletter_content_html .= '<div class="right-col">' . $rn_right_column_content . '</div></dt>';
		}
		//$newsletter_content_html .= '<a href="#submenu"><div class="bt-submenu"></div></a><div class="sub-nav-menu-ct" id="submenu">' . wp_nav_menu( array( 'menu' => 'people','theme_location' => 'people', 'menu_class' => 'sub-nav-menu' ) ) . '</div></a>';
		
		$newsletter_content_html .= '</li>';
		$newsletterHTML .= $newsletter_content_html;
		
    endwhile;

	    if($rn_list_type == 'Ordered List'):
	    	$newsletterHTML .= '</ol>';
	    elseif($rn_list_type == 'Unordered List'):
	    	$newsletterHTML .= '</ul>';
	    endif;    
   
else :

    // no rows found

endif;

endwhile;


//$newsletterHTML .= '</div>'; //newsletter-page-left
if($sidebar == 'Yes'):
$newsletterHTML .= '</div>';//close left side
$newsletterHTML .= '<div class="newsletter-page-right">';
$newsletterHTML .= '<div class="news">';
$newsletterHTML .= '<div class="saw-small-inv"></div>';
if( in_array( 'archives', $sidebar_items ) ):

//GET POST ARCHIVES
$newsletterHTML .= '<div class="ribbon-right clearfix sidebar-nav">Archives</div><div class="sidebar-item sidebar-closed"><div class="archive-list clearfix sidebar-content">';

$archives = do_shortcode( '[list_archives type="monthly" format="custom" post_type="newsletters"]' );

$newsletterHTML .= $archives . '</div></div>';

endif;

if( in_array( 'categories', $sidebar_items ) ):

//GET POST CATEGORIES
$newsletterHTML .= '<div class="ribbon-right clearfix sidebar-nav">Categories</div><div class="sidebar-item sidebar-closed"><div class="categories-list sidebar-content">';

$categories = do_shortcode( '[list_categories]' );

$newsletterHTML .= $categories . '</div></div>';

endif;

if( in_array( 'tags', $sidebar_items ) ):

//GET POST CATEGORIES
$newsletterHTML .= '<div class="ribbon-right clearfix sidebar-nav">Tags</div><div class="sidebar-item sidebar-closed"><div class="tags-list sidebar-content">';

$tags = do_shortcode( '[list_tags]' );

$newsletterHTML .= $tags . '</div></div>';

endif;

if($sidebar_content):
$newsletterHTML .=  $sidebar_content;
endif;
$newsletterHTML .= '</div></div>';
endif;


$newsletterHTML .= '</div></div>';//wrapper

echo $newsletterHTML;

get_footer(); ?>