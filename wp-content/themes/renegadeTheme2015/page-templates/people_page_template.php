<?php
/**
 * Template Name: People Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2014
 */

get_header(); ?>

<script>

</script>
<div class="company-page">
<div class="content-wrapper" style="background:#fff; overflow:hidden; padding-bottom:64px;">

<?php

$co_header = get_field('co_header');
$co_subheader = get_field('co_subheader');
$co_sidebar = get_field('co_sidebar');
$co_sidebar_content = get_field('co_sidebar_content');
$co_inline_navigation = get_field('co_inline_navigation');


if($co_header){
	echo('<h1>'. $co_header . '</h1>');
}

if($co_subheader){
	echo('<h2>'. $co_subheader . '</h2>');
}
?>

<?php 
if($co_sidebar == 'Yes'){
	
	$co_sidebar_html = '<div class="sidebar-left">';
	
	if($co_inline_navigation == 'Yes'){
		$co_sidebar_html .= '<div class="inline-nav-ct">';
		//$co_sidebar_html = '<div class="sidebar-left">' . $co_sidebar_content . '</div>';
		
		// check if the repeater field has rows of data
		if( have_rows('co_section') ):
		
		// loop through the rows of data
		while ( have_rows('co_section') ) : the_row();
		$co_nav_label = get_sub_field('co_nav_label');
		$co_section_name = get_sub_field('co_section_name');
		$co_section_headline = get_sub_field('co_section_headline');
		
		if(	$co_section_name  && $co_nav_label){
			
	
		$co_sidebar_html .= '<div class="circ medium"><div class="inline-nav-inner"><a href="#' . $co_section_name . '">' . $co_nav_label . '</a></div></div>';
			}
		endwhile;
		$co_sidebar_html .= '</div>';
		else :
		
		// no rows found
		
		endif;
	}
	
	$co_sidebar_html .=  $co_sidebar_content;
	echo $co_sidebar_html . '</div>';
}

?>

<div class="content-diag">
<?php

// check if the repeater field has rows of data
if( have_rows('co_section') ):

// loop through the rows of data
while ( have_rows('co_section') ) : the_row();

$co_section_name = get_sub_field('co_section_name');
$co_section_headline = get_sub_field('co_section_headline');
$co_section_layout = get_sub_field('co_section_layout');
$co_one_column_content = get_sub_field('co_one_column_content');
$co_left_column_content = get_sub_field('co_left_column_content');
$co_right_column_content = get_sub_field('co_right_column_content');

/*
wp_nav_menu( array(
	'menu' => 'Company Menu',
	'menu_class'      => 'subNav',
	'container_class'      => 'subNav_ct'
 		
));

*/

$co_section_html = '<a name="' . $co_section_name . '">';


$co_section_html .= '<div class="section">';

if($co_section_layout == 'One Column'){
	
	$co_section_html .= '<div class="one-col">';
	
	if($co_section_headline){
		$co_section_html .= '<h3>' . $co_section_headline . '</h3>';
	}
	
	$co_section_html .= '<div class="one-col-inner"><div class="section-content">' . $co_one_column_content . '</div></div></div>';

} else if($co_section_layout == 'Two Columns'){
	
}

$co_section_html .= '</div>';

echo $co_section_html;

endwhile;

else :

// no rows found

endif;


?>
</div><!-- .content-diag -->
</div><!-- .content-wrapper -->
</div><!-- .company -->

<?php get_footer(); ?>