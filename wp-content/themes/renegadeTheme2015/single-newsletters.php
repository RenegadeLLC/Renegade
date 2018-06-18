<?php
/**
 * The template for displaying a single Newsletter
 *
 * @package Renegade
 */
get_header();
?>

<div id="primary" class="content-area">
<main id="main" class="site-main" role="main">

	
<?php 
$newsletterHTML = '';
$accent_color = get_field('accent_color');
//$headline = get_field('headline');


$newsletterHTML .= '<div class="wrapper"><div class="newsletter-page">';
//$newsletterHTML .= '<div class="newsletter-ct">';
$newsletterHTML .= '<div class="grid-item-w-75" style="display:block; overflow:hidden; background:#f2f2f2;">';

//$newsletterHTML .= '<div class="blue-border"></div>';
//$newsletterHTML .= '<div class="newsletter-content-ct">';

		//$rn_title = wp_title('', FALSE);
		$rn_title = get_the_title( $post->ID );
		$rn_date = get_field('rn_date');
		$rn_introduction= get_field('rn_introduction');
		$rn_list_type = get_field('rn_list_type');	
		$rn_banner = get_field('rn_banner');
		$rn_size = "full";
		$rn_final_note = get_field('rn_final_note');
	
	$newsletterHTML .= '<div class="newsletter-header"><div class="newsletter-mark"></div>';
	$newsletterHTML .= '<div class="newsletter-title">' . $rn_title . '</div>';
	$newsletterHTML .= '<div class="newsletter-date">' . $rn_date . '</div></div>';
	$newsletterHTML .= '<div class="newsletter-banner">' . wp_get_attachment_image($rn_banner, $rn_size ) . '</div>';
	$newsletterHTML .= '<div class="newsletter-intro">' . $rn_introduction . '</div>';
	

if( have_rows('rn_section') ):

	if($rn_list_type == 'Ordered List'){
		$newsletterHTML .= '<ol>';
	}else if($rn_list_type == 'Unordered List'){
		$newsletterHTML .= '<ul>';
	}


 	// loop through the rows of data
    while ( have_rows('rn_section') ) : the_row();
    
   	 	$newsletterSECTIONShtml = '';
		$rn_section_header = get_sub_field('rn_section_header');
		$rn_section_layout = get_sub_field('rn_section_layout');
		$rn_one_column_content = get_sub_field('rn_one_column_content');
		$rn_left_column_content = get_sub_field('rn_left_column_content');
		$rn_right_column_content = get_sub_field('rn_right_column_content');

		$newsletterSECTIONShtml .= '<li>';
		$newsletterSECTIONShtml .= '<h3 class="newsletter">' . $rn_section_header . '</h3>' ;
		
		if($rn_section_layout == 'One Column'){
			
			
			$newsletterSECTIONShtml .= '<div class="newsletter-text">' . $rn_one_column_content . '</div>';
		
		} else if($rn_section_layout == 'Two Columns'){
			
			$newsletterSECTIONShtml .= '<div class="left-col">' . $rn_left_column_content . '</div>';
			$newsletterSECTIONShtml .= '<div class="right-col">' . $rn_right_column_content . '</div>';
		}
		//$newsletterSECTIONShtml .= '<a href="#submenu"><div class="bt-submenu"></div></a><div class="sub-nav-menu-ct" id="submenu">' . wp_nav_menu( array( 'menu' => 'people','theme_location' => 'people', 'menu_class' => 'sub-nav-menu' ) ) . '</div></a>';
		$newsletterSECTIONShtml.= '</li>';
		
		
		$newsletterHTML .=  $newsletterSECTIONShtml;
			
	
    endwhile;

   if($rn_final_note):
   
   $newsletterHTML .= '<div class="newsletter-final-note">' . $rn_final_note . '</div>';
   
   endif;
   
    if($rn_list_type == 'Ordered List'):
    	$newsletterHTML .= '<ol>';
    elseif($rn_list_type == 'Unordered List'):
    	$newsletterHTML .= '<ul>';
  	endif;
   
else :

    // no rows found

endif;

$newsletterHTML .= '<div class="clearfix"></div>';
$newsletterHTML .= '</div></div><!-- .left col 75 -->';
$newsletterHTML .= '<div class="grid-item-w-25">';
$newsletterHTML .= '<div id="blog-sidebar">';
$newsletterHTML .= '<h2>Archives</h2><div class="archive-list clearfix sidebar-content">';

//GET POST ARCHIVES
$archives = do_shortcode( '[list_archives type="monthly" format="custom" post_type="newsletters"]' );

$newsletterHTML .= $archives . '</div>';

//GET POST CATEGORIES
$newsletterHTML .= '<h2>Categories</h2><div class="categories-list sidebar-content">';

$categories = do_shortcode( '[list_categories]' );

$newsletterHTML .= $categories . '</div>';


$newsletterHTML .= '</div><!-- #blog-sidebar -->';
$newsletterHTML .=	'</div><!-- .page-grid-item-25 -->';


$newsletterHTML .= '</div></div>';//wrapper

echo $newsletterHTML;

get_footer(); ?>
