<?php
/**
 * Template Name: BKHome Page Template
 *
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2014
 */

get_header(); ?>

<?php 

$pageHTML;

// check if the repeater field has rows of data
if( have_rows('rh_home_row') ):

// loop through the rows of data
while ( have_rows('rh_home_row') ) : the_row();
	$num_slides = 0;
	$rh_row_name = get_sub_field('rh_row_name');
//	$term = 'name';
	$rh_row_category = get_sub_field('rh_row_category');
	$rh_row_bk;
	$rh_row_background_color = get_sub_field('rh_row_background_color');
	//$terms = get_field('test_tax');
	
	//$cat = $terms->name;
	echo ($rh_row_category);
	
	switch ($rh_row_category) {
	
		case 'Company';
	
		$slide_row_bk = 'bk-green3';
	
		break;
	
		case 'Work';
		$slide_row_bk = 'bk-red';
	
		break;
	
		case 'News';
	
		$slide_row_bk = 'bk-blue';
		break;
	
		case 'Blog';
		$slide_row_bk = 'bk-pink';
		break;
	}
	
	if($rh_row_category != 'Work'){
		$pageHTML .= '<div class="home-row '. $slide_row_bk .'"><div class="content-wrapper">';
	} else {
		
		$pageHTML .= '<div class="home-row ' . $slide_row_bk .'"><div style="width:100%;">';
		
	}
	

		if( have_rows('rh_slides') ):
	
		while ( have_rows('rh_slides') ) : the_row();
		
		$num_slides ++;
		
		$post_object = get_sub_field('rh_content_slide');
		$slide_content_slide = get_sub_field('rh_content_slide');
		$slide_slide_category = get_field( 'slide_category', $slide_content_slide->ID );
		$slide_one_column_background_image = get_field( 'slide_one_column_background_image', $slide_content_slide->ID );
		$slide_slide_layout = get_field( 'slide_layout', $slide_content_slide->ID );
		$slide_headline = get_field( 'slide_headline', $slide_content_slide->ID );
		$slide_one_column_content = get_field( 'slide_one_column_content', $slide_content_slide->ID );
		$slide_one_column_background_color = get_field( 'slide_one_column_background_color', $slide_content_slide->ID );
		$slide_left_column_content = get_field( 'slide_left_column_content', $slide_content_slide->ID );
		$slide_left_column_background_color = get_field( 'slide_left_column_background_color', $slide_content_slide->ID );
		$slide_right_column_content= get_field( 'slide_right_column_content', $slide_content_slide->ID );
		$slide_right_column_background_color = get_field( 'slide_right_column_background_color', $slide_content_slide->ID );
		
		$pageHTML .= '<div class="home-slide '. $slide_slide_category;
		
		
		if($slide_one_column_background_image){
			$pageHTML .= ' tint t2" style="background:url(' . $slide_one_column_background_image . ') repeat-x;">';
			//$pageHTML .= 'style="background:url(' . $slide_one_column_background_image . ') repeat-x;">';
		} else{
			$pageHTML .= '">';
		}
		
		if($slide_slide_category == 'work' && $slide_one_column_background_image){
			$pageHTML .= '<div class="home-case-ct" style="background:url(' . $slide_one_column_background_image . ') no-repeat #000; opacity: 1 !important;
  //  filter: alpha(opacity=100) !important; /* For IE8 and earlier */">';
			//$pageHTML .= '<div class="home-case-ct" style="background:#fff; opacity: .15;
  //  filter: alpha(opacity=100); /* For IE8 and earlier */">';
		}
		
	
		
		
		if($slide_slide_layout == 'One Column'){
			
		$pageHTML .= '<div class="one-col"><div class="home-slide-text-ct"><div class="home-slide-text">';
		
		if($slide_headline){
			$pageHTML .= '<h1><a href="">' . $slide_headline . '</a></h1><span>';
		}
		
		$pageHTML .= $slide_one_column_content . '</span></div></div></div>';
		
		} else if($slide_slide_layout == 'Two Columns'){
	
		$pageHTML .= '<div class="left-col">'.'<div class="home-slide-text-ct"><div class="home-slide-text">';
		
		if($slide_headline){
			$pageHTML .= '<h1><a href="">' . $slide_headline . '</a></h1>';
		}
		
		$pageHTML .= $slide_left_column_content . '</div></div></div>';
		$pageHTML .= '<div class="right-col"';
		
		if($slide_right_column_background_color){
			$pageHTML .= ' style="background:' . $slide_right_column_background_color . '"';
		}
				
		$pageHTML .=	'><div class="home-slide-text-ct"><div class="home-slide-text">' . $slide_right_column_content . '</div></div></div>';
	
	}

	
		$pageHTML .= '</div>';
		
		if($slide_slide_category == 'work'){
			$pageHTML .= '</div>';
		}
		endwhile;
	
		
		else :
	
		// no rows found
	
		endif;
	
		if($num_slides > 1){
			//echo('DOIT ');
			$pageHTML .= '<ul class="slidenav-ct">';
		
			for($i=0; $i< $num_slides ; $i++){
				$pageHTML .= '<li></li>';
			}
			$pageHTML .= '</ul>';
		
		}
		
	


		$pageHTML .= '</div>';
		
		
		
		$pageHTML .= '</div>';
	
	endwhile;
	
	else :
	
	// no rows found
	
	endif;
	


?>


<?php 
echo $pageHTML;
?>




<?php get_footer(); ?>