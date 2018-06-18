<?php

$left_column_name = get_sub_field('left_column_name');
$left_background_image = get_sub_field('left_background_image');
$left_background_color= get_sub_field('left_background_color');
$left_column_content = get_sub_field('left_column_content');
$left_column_class = get_sub_field('left_column_class');
$content_type_left = get_sub_field('content_type_left');

$right_column_name = get_sub_field('right_column_name');
$right_background_image = get_sub_field('right_background_image');
$right_background_color = get_sub_field('right_background_color');
$right_column_content = get_sub_field('right_column_content');
$right_column_class = get_sub_field('right_column_class');
$content_type_right = get_sub_field('content_type_right');

$rh_customize_column_appearance = get_sub_field('rh_customize_column_appearance');

$pageHTML .= '<div class="content-wrapper">';

$pageHTML .= '<div class="col-container">';
				
$pageHTML .= '<div class="col-one-half"';

	
	if($left_background_image || $left_background_color):
		
			$pageHTML .= ' style="background:';
		
				if($left_background_image ):
					
					$pageHTML .= 'url(' . $left_background_image  . ') ';
					
				endif;
				
				if($left_background_color):
				
					$pageHTML .= $left_background_color;
					
				endif;
			
			$pageHTML .= ';">';
			
		else:
		
			$pageHTML .= '>';
		
	endif;
	
	if($left_column_name):
	$pageHTML .= '<div class="title-tag">' . $left_column_name . '</div>';
	endif;
		
	if($left_column_class):
	
		$pageHTML .= '<div class="' . $left_column_class . '">';
	
	endif;

			if($content_type_left == 'Regular'):
			
				$pageHTML .= $left_column_content;
			
			elseif($content_type_left == 'Post List'):
			
			$left_column_post_type = get_sub_field('left_column_post_type');
			
			if($left_column_post_type == 'Blog Posts'):
				$left_column_post_type = 'post';
			else:
				$left_column_post_type = clean_link_name(get_sub_field('left_column_post_type'));
			endif;
		
		$number_posts_left_column = get_sub_field('number_posts_left_column');
		$show_post_excerpts_left = get_sub_field('show_post_excerpts_left');

		if($left_column_post_type == 'post' ):
		
			$pageHTML .= '<div class="post-list-ct" id="posts-ct">';
		
		else:
		
			$pageHTML .= '<div class="post-list-ct" id="' . $left_column_post_type . '-ct">';
		
		endif;
			if($number_posts_left_column > 1):
				
				$pageHTML .= '<div class="post-list-inner">';
				
			endif;
			
		$pageHTML .=	do_shortcode( '[recent_post post_type="' . $left_column_post_type . '" excerpt="' . $show_post_excerpts_left . '" numberposts="' . $number_posts_left_column . '"]' );
		$pageHTML .= '</div>';
		endif;
		
	
		if($number_posts_left_column > 1){
			
			$pageHTML .= '</div>';//ends posts with nav container
			
			$pageHTML .= '<div class="dot-nav-vertical-ct">';
			
			$single_type_left = substr($left_column_post_type, 0, -1);
			
			for($i=0; $i< $number_posts_left_column ; $i++){
				$pageHTML .= '<div class="dot-nav" id="bt_' . $single_type_left . '_' . $i .'"></div>';
			}
		
			$pageHTML .='</div>';//ends dot-nav container
		}
		
		if($left_column_class):
		
			$pageHTML .= '</div>';
			
		endif;

	$pageHTML .= '</div>';//end col one half

	$pageHTML .= '<div class="col-one-half"';

	if($right_background_image || $right_background_color):
		
			$pageHTML .= ' style="background:';
		
				if($right_background_image ):
					
					$pageHTML .= 'url(' . $right_background_image  . ') ';
					
				endif;
				
				if($right_background_color):
				
					$pageHTML .= $right_background_color;
					
				endif;
			
			$pageHTML .= ';">';
			
		else:
		
			$pageHTML .= '>';
		
	endif;
		

	if($right_column_name):
		$pageHTML .= '<div class="title-tag" style="margin-left:40px !important;">' . $right_column_name . '</div>';
	endif;
	
	if($right_column_class):
	
		$pageHTML .= '<div class="' . $right_column_class . '">';
	
	endif;

	if($content_type_right == 'Regular'):
		
			$pageHTML .= $right_column_content;
		
	elseif($content_type_right == 'Post List'):
	
		$number_posts_right_column = get_sub_field('number_posts_right_column');
		$show_post_excerpts_right = get_sub_field('show_post_excerpts_right');
		$right_column_post_type = get_sub_field('right_column_post_type');
		
			if($number_posts_right_column > 1):
			
				$pageHTML .= '<div class="post-list-inner">';
			
			endif;
	
			if($right_column_post_type == 'Blog Posts'):
			
				$right_column_post_type = 'post';
		
			else:
			
				$right_column_post_type = clean_link_name(get_sub_field('right_column_post_type'));
			
			endif;
		
		$pageHTML .= '<div class="post-list-ct" id="' . $right_column_post_type . '-ct">';
			
		$pageHTML .=	do_shortcode( '[recent_post post_type="' . $right_column_post_type . '" excerpt="' . $show_post_excerpts_right . '" numberposts="' . $number_posts_right_column . '"]' );
			
		$pageHTML .= '</div>';//end post list container
		
		if($number_posts_right_column > 1){
			
			$pageHTML .= '</div>';//ends posts inner 
			
			$pageHTML .= '<div class="dot-nav-vertical-ct">';
			
			$single_type_right = substr($right_column_post_type, 0, -1);
			for($i=0; $i< $number_posts_right_column ; $i++){
				$pageHTML .= '<div class="dot-nav" id="bt_' . $single_type_right . '_' . $i .'"></div>';
			}
		
			$pageHTML .='</div>';//ends dot-nav container
		}
		
	endif;

	if($right_column_class):
	
		$pageHTML .= '</div>';
	
	endif;

$pageHTML .= '</div></div>';//end one col half and col container
$pageHTML .= '</div>';// end content-wrapper

?>