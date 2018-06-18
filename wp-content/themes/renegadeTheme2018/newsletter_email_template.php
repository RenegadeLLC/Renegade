<?php
/**
 * Template Name: Newsletter Email Template
 *
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2015
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
		$rn_title = get_the_title( $post->ID );
		$rn_date = get_field('rn_date');
		$rn_introduction= get_field('rn_introduction');
		$rn_list_type = get_field('rn_list_type');
		$rn_banner = get_field('rn_banner');
		$rn_size = "full";	
	
	$newsletter_html .= '<div class="newsletter-header">';
	$newsletter_html .= '<div class="newsletter-title">' . $rn_title . '</div>';
	$newsletter_html .= '<div class="newsletter-date">' . $rn_date . '</div></div>';
	$newsletter_html .= '<div class="newsletter-banner">' . wp_get_attachment_image($rn_banner, $rn_size ) . '</div>';
	$newsletter_html .= '<div class="newsletter-intro">' . $rn_introduction . '</div>';

// check if the repeater field has rows of data
if( have_rows('rn_section') ):

	if($rn_list_type == 'Ordered List'){
		$newsletter_html .= '<ol>';
	}else if($rn_list_type == 'Unordered List'){
		$newsletter_html .= '<ul>';
	}
	
 	// loop through the rows of data
    while ( have_rows('rn_section') ) : the_row();
    $newsletter_content_html = 'WHAT THE FUCK?';
        // display a sub field value
       // the_sub_field('sub_field_name');
      
		$rn_section_header = get_sub_field('rn_section_header');
		$rn_section_layout = get_sub_field('rn_section_layout');
		$rn_one_column_content = get_sub_field('rn_one_column_content');
		$rn_left_column_content = get_sub_field('rn_left_column_content');
		$rn_right_column_content = get_sub_field('rn_right_column_content');

		$newsletter_content_html .= '<li class="newsletter-section">';
		$newsletter_content_html .= '<h3 class="newsletter">' . $rn_section_header . '</h3>' ;
		
		if($rn_section_layout == 'One Column'){
				
			$newsletter_content_html .= '<div class="newsletter-text">' . $rn_one_column_content . '</div>';
		
		} else if($rn_section_layout == 'Two Columns'){
			
			$newsletter_content_html .= '<div class="left-col">' . $rn_left_column_content . '</div>';
			$newsletter_content_html .= '<div class="right-col">' . $rn_right_column_content . '</div></dt>';
		}
		//$newsletter_content_html .= '<a href="#submenu"><div class="bt-submenu"></div></a><div class="sub-nav-menu-ct" id="submenu">' . wp_nav_menu( array( 'menu' => 'people','theme_location' => 'people', 'menu_class' => 'sub-nav-menu' ) ) . '</div></a>';
		
		$newsletter_content_html .= '</li>';
		$newsletter_html .= $newsletter_content_html;
		
    endwhile;

	    if($rn_list_type == 'Ordered List'):
	    	$newsletter_html .= '</ol>';
	    elseif($rn_list_type == 'Unordered List'):
	    	$newsletter_html .= '</ul>';
	    endif;
	    
   
else :

    // no rows found

endif;
echo $newsletter_html;
echo('</div>');


?><div class="newsletter-footer"></div>
		</div>
		</div><!-- .content-wrapper -->

<!-- .news-page -->
		
</div>
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- gray back -->
<?php //get_footer(); ?>
