<?php
/**
 * Template Name: Modules Template
 *
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2015
 */
global $link_color;
get_header();


$pageHTML = '';

$pageHTML .= '<div class="content-wrapper"><div class="grid"><div class="grid-gutter"></div>';

// check if the repeater field has rows of data
if( have_rows('modules') ):

	// GET CONTENT MODULES AND VARS
	while ( have_rows('modules') ) : the_row();
		$module_name = get_sub_field('module_name');
		$module_width = get_sub_field('module_width');
		$module_height = get_sub_field('module_height');
		$customize_background = get_sub_field('customize_background');
		//$content_type = get_sub_field('content_type');
		$custom_content = get_sub_field('custom_content');
		
		if($customize_background == 'Yes'):
			$background_color = get_sub_field('background_color');
			$background_image = get_sub_field('background_image');
			$custom_class = get_sub_field('custom_class');
		endif;

		
		
	//	$pageHTML .= $module_name . ' ' . $module_width . ' ' . $background_color . ' ' . $background_image . ' ' . $content_type . ' ' . $text_color . ' ' . $text_alignment . ' ' . $content_type;
		$pageHTML .= '<div class="grid-item';

		if($module_width == '100%'):
			$pageHTML .= ' grid-item-w-100';
		elseif($module_width == '75%'):
			$pageHTML .= ' grid-item-w-75';
		elseif($module_width == '50%'):
			$pageHTML .= ' grid-item-w-50';
		elseif($module_width == '25%'):
			$pageHTML .= ' grid-item-w-25';
		endif;
		
		if($custom_class):
			$pageHTML .= ' ' . $custom_class;
		endif;
		
		//end class dec
		$pageHTML .= '" ';
		
		//look for style options
		
		if($background_color || $background_image || $module_height):
		
			$pageHTML .= 'style="';
		
			if($background_color):
		//	$pageHTML .= ' background-image:url(' . $background_image . ') no-repeat;';
				$pageHTML .= 'background-color:' . $background_color . ';';
			
			endif;

			if($background_image):
				$pageHTML .= ' background-image:url(' . $background_image . ');';
			endif;
			
			if($module_height):
			$pageHTML .= ' min-height:' . $module_height . 'px;';
			endif;
			//close style dec
			$pageHTML .= '"';
			
		endif;
		
		//close class and style dec
		$pageHTML .= '>';
		
		
		
		
	
			$pageHTML .= $custom_content;
		
	

		
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
		 percentPosition: true,
	  layoutMode: 'packery',
	  //   layoutMode: 'masonry',
	    itemSelector: '.grid-item',
	    packery: {
	  // masonry: {
	      gutter: '.grid-gutter'
	      }
	  });
	  
	});
</script>
<?php get_footer();?>