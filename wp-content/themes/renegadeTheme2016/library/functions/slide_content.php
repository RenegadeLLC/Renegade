<?php
		
		if( have_rows('slides') ):
	
		$num_slides = 1;
		while ( have_rows('slides') ) : the_row();
		$slide_id = 'slide_' . $num_slides;

//GET SLIDE VARIABLES
		
		$slide_content_slide = get_sub_field('rh_content_slide');
		$slide_category = get_field( 'slide_category', $slide_content_slide->ID );
		//$slide_category_name = $slide_category->name;
		$slide_height = get_field('slide_height');
		$slide_layout = get_field( 'slide_layout', $slide_content_slide->ID );

		$slide_one_column_background_image = get_field( 'slide_one_column_background_image', $slide_content_slide->ID );
		
		//$slide_headline = get_field( 'slide_headline', $slide_content_slide->ID );
		
		$slide_one_column_content = get_field( 'slide_one_column_content', $slide_content_slide->ID );
		$slide_one_column_background_color = get_field( 'slide_one_column_background_color', $slide_content_slide->ID );
		
		$slide_left_column_content = get_field( 'slide_left_column_content', $slide_content_slide->ID );
		$slide_left_column_background_color = get_field( 'slide_left_column_background_color', $slide_content_slide->ID );
		$slide_right_column_content= get_field( 'slide_right_column_content', $slide_content_slide->ID );
		$slide_right_column_background_color = get_field( 'slide_right_column_background_color', $slide_content_slide->ID );
		
		
		//$pageHTML .= '<div class="slide">';
		
//GENERATE HTML
		
		$pageHTML .= '<div class="slide tint t2 da-slide';
		
		if($num_slides == 1){
			//echo($num_slides);
			$pageHTML .= ' slide-on';
		}
		
		$pageHTML .=  '" id="' . $slide_id  . '" style="background:url(' . $slide_one_column_background_image . ') repeat-x;">';
		
		if($slide_layout == 'One Column'){
			
			if($slide_one_column_background_image){
				$pageHTML .= '<div class="home-case-ct" style="background:url(' . $slide_one_column_background_image . ') no-repeat #000; opacity: 1 !important;
  //  filter: alpha(opacity=100) !important; /* For IE8 and earlier */">';
	
			}
			
		$pageHTML .= '<div class="one-col"><div class="slide-text-ct"><div class="slide-text">';
		
	//if($slide_headline){
			//$pageHTML .= '<h1><a href="">' . $slide_headline . '</a></h1><span>';
		//}
		
		//$pageHTML .= $slide_one_column_content . '</span></div></div></div>';
		$pageHTML .= $slide_one_column_content . '</div></div></div>';
		
		} else if($slide_layout == 'Two Columns'){
	
		$pageHTML .= '<div class="left-col">'.'<div class="slide-text-ct"><div class="slide-text">';

		$pageHTML .= $slide_left_column_content . '</div></div></div>';
		$pageHTML .= '<div class="right-col"';
		
		if($slide_right_column_background_color){
			$pageHTML .= ' style="background:' . $slide_right_column_background_color . '"';
		}  
				
		$pageHTML .=	'><div class="slide-text-ct"><div class="slide-text">' . $slide_right_column_content . '</div></div></div>';
	
	}

	
		$pageHTML .= '</div></div>';
		
		$num_slides ++;
		endwhile;
	
		
		else :
	
		// no rows found
	
		endif;
	
		if($num_slides > 1){
			//echo('DOIT ');
			$pageHTML .= '<div class="dot-nav-horizontal-ct">';
		
			for($i=0; $i< $num_slides ; $i++){
				$pageHTML .= '<div class="dot-nav"></div>';
			}
			$pageHTML .= '</div>';
		
		}
		
	


		//$pageHTML .= '</div>';
		
		
		
?>