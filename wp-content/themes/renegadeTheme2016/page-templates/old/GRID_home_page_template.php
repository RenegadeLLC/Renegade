<?php
/**
 * Template Name: GRID Home Page Template
 *
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2015
 */
global $link_color;
get_header();

require( FUNCTIONS . 'post_feed.php' );

$pageHTML = '';

$pageHTML .= '<div class="content-wrapper"><div class="grid">';

// check if the repeater field has rows of data
if( have_rows('modules') ):

	// GET CONTENT MODULES AND VARS
	while ( have_rows('modules') ) : the_row();
		$module_name = get_sub_field('module_name');
		$module_size = get_sub_field('module_size');
		$background_color = get_sub_field('background_color');
		$background_image = get_sub_field('background_image');
		$content_type = get_sub_field('content_type');
		$text_color = get_sub_field('text_color');
		$link_color = get_sub_field('link_color');
		$text_alignment = get_sub_field('text_alignment');
		$custom_content = get_sub_field('custom_content');
		//$floater = get_sub_field('floater');
		
		$text_class;
		
	//	$pageHTML .= $module_name . ' ' . $module_size . ' ' . $background_color . ' ' . $background_image . ' ' . $content_type . ' ' . $text_color . ' ' . $text_alignment . ' ' . $content_type;
		$pageHTML .= '<div class="grid-item';

		if($module_size == '100%'):
			$pageHTML .= ' grid-item-w-100';
		elseif($module_size == '75%'):
			$pageHTML .= ' grid-item-w-75';
		elseif($module_size == '50%'):
			$pageHTML .= ' grid-item-w-50';
		elseif($module_size == '25%'):
			$pageHTML .= ' grid-item-w-25';
		endif;
		
		if($text_alignment):
			switch($text_alignment){
			
				case 'left':
					$text_class='text-left';
				break;
				
				case 'right':
					$text_class='text-right';
					break;
					
					case 'center':
						$text_class='text-center';
						break;
						
						
			}//end switch
			
			$pageHTML .= ' ' . $text_class;
		endif;
		//end class dec
		$pageHTML .= '" ';
		
		//look for style options
		
		if($background_color || $background_image || $text_color):
		
			$pageHTML .= 'style="';
		
			if($background_color):
		//	$pageHTML .= ' background-image:url(' . $background_image . ') no-repeat;';
				$pageHTML .= 'background-color:' . $background_color . ';';
			
			endif;

			if($background_image):
				$pageHTML .= ' background-image:url(' . $background_image . ');';
			endif;
			
			if($text_color):
				$pageHTML .= ' color:' . $text_color . ' !important;';
			endif;
			
			//close style dec
			$pageHTML .= '"';
			
		endif;
		
		//close class and style dec
		$pageHTML .= '>';
		
		
		if($content_type == 'Post Feed'):
	
		$post_type = get_sub_field('post_type');
		$number_posts = get_sub_field('number_posts');
		//$excerpt = get_sub_field('show_excerpt');
		//$pageHTML .= 	do_shortcode( '[recent_post post_type="' . $post_type. '" excerpt="' . $excerpt . '"  numberposts="' . $number_posts . '"]' );
			$feed = get_feed();
			$pageHTML .= get_feed();	
			
		
		elseif($content_type == 'Custom'):
		
			$pageHTML .= $custom_content;
		
		elseif($content_type == 'Image'):
		
			$image_url = get_sub_field('image_url');
			$pageHTML .= '<img src="' . $image_url . '">';
			
		endif;
		

		
		$pageHTML .= '</div><!--.grid-item-->';
	endwhile;
	
endif;
		

$pageHTML .= '</div><!--.grid--></div><!--.wrapper-->';

wp_reset_postdata();
echo $pageHTML;
?>
<script type="text/javascript">
$( function() {
	  
	  $('.grid').isotope({
	    layoutMode: 'packery',
	    itemSelector: '.grid-item',
	    packery: {
	        gutter: 20
	      }
	  });
	  
	});
</script>
<?php get_footer();?>