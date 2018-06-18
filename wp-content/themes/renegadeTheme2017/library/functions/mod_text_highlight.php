<?php


				
				$highlight_text = get_sub_field('module_content');
				$add_circle_background = get_sub_field('add_circle_background');
				$circle_background_color = get_sub_field('circle_background_color');
				$section_background_color = get_sub_field('section_background_color');
				$section_background_image = get_sub_field('section_background_image');
				$text_color = get_sub_field('text_color');
			//	$highlight_link = get_sub_field('highlight_link');
				
				
				//if($add_circle_background == 'yes'):
			
				//endif;
			//	if($add_circle_background == 'yes'):
				//$pageHTML .='<div style="display:block; position:relative; overflow:hidden;" ';
				//else:
				//$pageHTML .='<div class="text-highlight-ct square"';
				//endif;
		/*		
				//check for custom styling
				if($background_color || $background_image || $text_color):
					$pageHTML .= '<div style=" ';
				endif;
				
				//background-color
				if($background_color):
					$pageHTML .='background-color:' . $background_color . ';';
				endif;
				
				//background-image
				if($background_image):
					$pageHTML .=	' background-image:' . $background_image . ' no-repeat;';
				endif;
				
				//text-color
				if($text_color):
					$pageHTML .= ' color:' . $text_color . ';';
				endif;
			
				//end style declaration
				if($background_color || $background_image || $text_color):
					$pageHTML .= '"';
				endif;
				
				// close out styled class
				$pageHTML .= '>';
				 
				if($add_circle_background == 'yes'):
					$pageHTML .= '<div class="vert-center-outer"><div class="vert-center-inner text-highlight">';
					$pageHTML .= $highlight_text;		
				else:
					$pageHTML .= '<div class="vert-center-outer"><div class="vert-center-inner text-highlight">' . $highlight_text . '';
				endif;
				
				if($add_circle_background == 'yes'):
				
					$pageHTML .= '</div><!-- .vert-center-inner --></div><!-- .vert-center-outer -->';
				else:
					$pageHTML .= '</div><!-- .vert-center-outer --></div></div><!-- .vert-center-inner --><!-- .text-highlight --></div><!-- .text-highlight-ct -->';
				
				endif;*/
				$pageHTML .= '<div class="vert-center-outer"><div class="vert-center-inner">';
				$pageHTML .= '<div class="circle" style="background-color:';
				$pageHTML .= $circle_background_color . ';">';
				$pageHTML .= '<div class="vert-center-outer"><div class="vert-center-inner text-highlight">' . $highlight_text;
				$pageHTML .= '</div><!-- .vert-center-inner --></div><!-- .vert-center-outer -->';
				$pageHTML .= '</div><!-- .circle -->';
				$pageHTML .= '</div><!--.vert inner--></div><!--.vert outer-->';
				//add content
?>