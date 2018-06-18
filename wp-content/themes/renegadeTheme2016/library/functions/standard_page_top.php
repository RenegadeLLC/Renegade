<?php

    //HEADLINE PAGE FIELDS
$page_class = get_field('page_class');
$headline_wrapper_background_color = get_field('headline_wrapper_background_color');
$headline = get_field('headline');
$sub_headline = get_field('sub_headline');
$headline_color = get_field('headline_color');
$sub_headline_color = get_field('sub_headline_color');

$include_page_intro = get_field('include_page_intro');
$banner_image = get_field('banner_image');
$page_intro_copy = get_field('page_intro_copy');

$intro_text_color = get_field('intro_text_color');
$intro_background_color = get_field('intro_background_color');
$intro_background_image = get_field('intro_background_image');

$customize_intro_background_image = get_field('customize_intro_background_image');
$banner_background_repeat = get_field('banner_background_repeat');
$banner_background_size = get_field('banner_background_size');
$banner_background_position = get_field('banner_background_position');

//CLIENTS PAGE FIELDS 
/*
$logo_grid_header = get_field('logo_grid_header');
$logo_grid_subheader = get_field('logo_grid_subheader');
$intro_image = get_field('intro_image');
$body_background_color = get_field('body_background_color');
$body_wrapper_color = get_field('body_wrapper_color');
$body_copy = get_field('body_copy');
*/
//START HTML BUILD
	$pageTopHTML = '';
	
		if($page_class):
			$pageTopHTML .= '<div class="' . $page_class . '">';
		endif;

	$pageTopHTML .= '<div class="outer-wrapper" style="background-color:';
	$pageTopHTML .= $headline_wrapper_background_color . ';">';
	$pageTopHTML .= '<div class="wrapper">';
	
	if($headline){
		$pageTopHTML .= '<div class="headline-ct"><h1 class="white text-center">'. $headline . ' <span class="light-serif gray">' . $sub_headline. '</span></h1></div><!--.headline-ct -->';
	}
	
		if($include_page_intro != 'None'):
			$pageTopHTML .= '<div class="intro-ct"  style="background-color:' . $intro_background_color . ';';
			$pageTopHTML .= ' background-image:url(' . $intro_background_image . '); ';
			
				if($customize_intro_background_image == 'Yes'):
					$pageTopHTML .= ' background-repeat:' . $banner_background_repeat . ';';
					$pageTopHTML .= ' background-size:' . $banner_background_size . ';' ;
					$pageTopHTML .= ' background-position:' . $banner_background_position . ';';
				endif;
				
			$pageTopHTML .= ';">';//close intro style declaration
			$pageTopHTML .= '<div class="page-intro">';
		
				if($include_page_intro == 'Text'):
					$pageTopHTML .= '<div class="page-intro-text">' . $page_intro_copy . '</div><!-- .page-intro-text -->';
				elseif($include_page_intro == "Banner Image" && $banner_image):
					$pageTopHTML .= '<img src="' . $banner_image . '">';
				endif;
			$pageTopHTML .= '</div><!-- .page-intro --></div><!-- .intro-ct -->';
			endif;
		
	$pageTopHTML .= '</div><!-- .wrapper --></div><!-- .outer-wrapper -->';
	
	return $pageTopHTML;
?>