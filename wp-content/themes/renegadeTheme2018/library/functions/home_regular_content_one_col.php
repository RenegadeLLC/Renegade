<?php
		$one_column_background_image = get_sub_field('one_column_background_image');
		$one_column_background_color = get_sub_field('one_column_background_color');
		$one_column_content = get_sub_field('one_column_content');
		$one_column_class = get_sub_field('one_column_class');
		$one_column_content_type = get_sub_field('one_column_content_type');
		$rh_customize_column_appearance = get_sub_field('rh_customize_column_appearance');
		
		

		$pageHTML .= '<div class="col-container"><div class="col-one"';
		
		if($one_column_content_type =='Regular'):
		
			$pageHTML .= '<div class="content-wrapper">';
		
		endif;
		
		if($one_column_background_image || $one_column_background_color ):
		
			$pageHTML .= ' style="background:';
		
				if($one_column_background_image):
					
					$pageHTML .= 'url(' . $one_column_background_image . ') ';
					
				endif;
				
				if($one_column_background_color):
				
					$pageHTML .= $one_column_background_color;
					
				endif;
			
			$pageHTML .= ';">';
			
		else:
		
			$pageHTML .= '>';
		
		endif;
		
		if($one_column_class):
				$pageHTML .= '<div class="' . $one_column_class . '">';
		endif;
		
		
		
		if($one_column_content_type == 'Regular'):
			
				$pageHTML .= $one_column_content;
		
		elseif($one_column_content_type == 'Slide Show'):
		
			$pageHTML .= '<div id="slideshow-ct">';
		
			require_once( FUNCTIONS . 'slide_content.php' );
			
			$pageHTML .= '</div>';
			
		endif;
		
		if($one_column_class):
		
			$pageHTML .= '</div>';
		
		endif;
		
		if($one_column_content_type == 'Regular'):
		
		$pageHTML .= '</div>';
		
		endif;
			
	$pageHTML .= '</div></div>';//end col one and col container
		

?>