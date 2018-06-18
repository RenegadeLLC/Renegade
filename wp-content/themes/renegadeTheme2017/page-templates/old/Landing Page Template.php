<?php
/**
 * Template Name: Standard Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2015
 */

get_header();

$grid_num = 0;
$header = get_field('header');
$subheader = get_field('subheader');
$headline_background_color = get_field('headline_background_color');
$grid = get_field('grid');

$pageHTML = '';
$pageHTML .= '<div class="home-top"></div>';
$pageHTML .= '<div style="display:block; position:relative; overflow:hidden; background:#E6E7E8; height:100%; width:100%;">';


// GET GRIDS

	if( have_rows('grid') ):
	
	while ( have_rows('grid') ) : the_row();	

		$grid_class;
	
		$customize_wrapper_row_background = get_sub_field('customize_wrapper_row_background');
		
		if($customize_wrapper_row_background == 'Yes'):
			$wrapper_background_color = get_sub_field('background_color');
			$wrapper_background_image = get_sub_field('background_image');
			$wrapper_background_repeat = get_sub_field('wrapper_background_repeat');
			$wrapper_background_image_size = get_sub_field('wrapper_background_image_size');
			$wrapper_background_image_opacity = get_sub_field('background_image_opacity');
		endif;
		

		$customize_grid_background = get_sub_field('customize_grid_background');
		$gutter_spacing = get_sub_field('gutter_spacing');
		$grid_width = get_sub_field('grid_width');
		$vertical_align = get_sub_field('vertical_alignment');
		$content_section = get_sub_field('modules');
		
		if($customize_grid_background = 'Yes'):
			$grid_background_color = get_sub_field('grid_background_color');
			$grid_background_image = get_sub_field('grid_background_image');
		else:
			$grid_background_color = 'transparent';
		endif;
		
		switch($gutter_spacing){
				
			case '0%':
				$grid_class = 'grid-g-0';
			break;
			
			case '2%':
				$grid_class = 'grid-g-2';
			break;
			
			case '3%':
				$grid_class = 'grid-g-3';
			break;
				
		}
		
		if($vertical_align == 'Bottom'):
			$grid_class = 'B' . $grid_class;
		endif;
		
		$pageHTML .= '<div class="row" style="';
		
		if($wrapper_background_color):
			$pageHTML .=	'background-color:' . $wrapper_background_color . '; ';
		endif;
		
		if($wrapper_background_image):
			$pageHTML .= 'background-image:url('. $wrapper_background_image . ');';
			$pageHTML .= 'background-size:' . $wrapper_background_image_size . ';';
			$pageHTML .= ' background-repeat:' . $wrapper_background_repeat . ';';
		endif;
		
		$pageHTML .= '" class="background-image">';
		//close out row styling
		
		//IF THIS IS THE FIRST GRID, ADD THE HEADLINE AND SUBHEADLINE BEFORE IT
		
		if($grid_num == 0):
		
			if($grid_width == 'Yes'):
				$pageHTML .= '<div class="wrapper">';
			endif;
		
			$pageHTML .= '<div class="headline-ct">';
			
			if($header){
				$pageHTML .= '<h1>'. $header . '</h1>';
			}
			
			if($subheader){
				$pageHTML .= '<div class="sub-headline-ct">';
				$pageHTML .= '<h2>'. $subheader . '</h2></div>';
			}
			
			$pageHTML .= '</div><!-- headline-ct -->';
			
			if($grid_width == 'Yes'):
				$pageHTML .=  '</div><!-- .wrapper-->';
			endif;
						
		endif;
		
		$grid_num++;
		
		if($grid_width == 'Yes'):
			$pageHTML .= '<div class="wrapper">';
		else:
			$pageHTML .= '<div class="wrapper" style="max-width:100% !important;">';
		endif;
		
		$pageHTML .= '<div class="grid ' . $grid_class . '"';
		
		if($customize_grid_background = 'Yes'):
			$pageHTML .= 'style="background:url() ' . $grid_background_color . ';"';
		endif;
		
		
$pageHTML .='><div class="grid-gutter"></div>';

//CONTENT SECTION REPEATERS

if( have_rows('modules') ):

	// GET CONTENT MODULES AND VARS
	while ( have_rows('modules') ) : the_row();

		$module_name = get_sub_field('module_name');
		$module_width = get_sub_field('module_width');
		$module_height = get_sub_field('module_minimum_height');
		$customize_background = get_sub_field('customize_background');
		$content_type = get_sub_field('content_type');
		$image = get_sub_field('image');
		$post_type = get_sub_field('post_type');
		$number_posts = get_sub_field('number_posts');
		$background_color = get_sub_field('background_color');
		$background_image = get_sub_field('background_image');
		$background_hor_position = get_sub_field('background_hor_position');
		$background_vert_position = get_sub_field('background_vert_position');
		$text_color = get_sub_field('text_color');
		$custom_class = get_sub_field('custom_class');
		
		$pageHTML .= '<div class="grid-item';

	
	
	//GET MODULE WIDTH
			if($module_width == '100%'):
				$pageHTML .= ' grid-item-w-100';
			elseif($module_width == '75%'):
				$pageHTML .= ' grid-item-w-75';
			elseif($module_width == '67%'):
				$pageHTML .= ' grid-item-w-67b';
			elseif($module_width == '50%'):
				$pageHTML .= ' grid-item-w-50';
			elseif($module_width == '33%'):
				$pageHTML .= ' grid-item-w-33b';
			elseif($module_width == '25%'):
				$pageHTML .= ' grid-item-w-25';
			endif;

//GET CUSTOM CLASS
		
		if($custom_class):
			$pageHTML .= ' ' . $custom_class;
		endif;
		
		if($content_type == 'Text Highlight'):
			$pageHTML .= ' square';
		endif;
		
		//close custom class
		
		$pageHTML .= '" ';
		
		//GET STYLE OPTIONS
		
		if($background_color || $background_image || $text_color || $module_height):
		
			$pageHTML .= ' style="';
		
				if($background_color):
			  
					$pageHTML .= 'background-color:' . $background_color . ';';
				
				endif;
	
				if($background_image && $background_image !=''):
			
					$pageHTML .= ' background-image:url(' . $background_image . '); background-repeat:no-repeat;';
				endif;
		
				if($background_hor_position || $background_vert_position):
					$pageHTML .= ' background-position:';
				endif;
				
				if($background_hor_position):
					$pageHTML .= $background_hor_position . ' ';
				endif;
				
				if($background_vert_position):
					$pageHTML .= $background_vert_position;
				endif;
				
				if($background_hor_position || $background_vert_position):
					$pageHTML .= ';';
				endif;

				if($module_height && $content_type != 'Text Highlight'):
					$pageHTML .= ' min-height:' . $module_height . 'px;';
				else:
					$pageHTML .= ' height:' . $module_height . 'px;';
				endif;
				
				if($text_color):
					$pageHTML .= ' color:' . $text_color . ';';
				endif;
		
			//close style dec
			$pageHTML .= '"';
			
		endif;
		
		//close class and style dec
		$pageHTML .= '>';
	
		
		//GET CONTENT TYPE AND LOAD RENDERING FUNCTIONS
		
		switch($content_type){
			
			case 'Text or Mixed':
				$pageHTML .= '<div class="vert-center-outer"><div class="vert-center-inner">';
				$pageHTML .= '<div class="md-text">';
				require(FUNCTIONS . '/mod_text_mixed.php');
				$pageHTML .= '</div>';
				$pageHTML .= '</div><!--.vert inner--></div><!--.vert outer-->';
				
			break;
			
			case 'Case Study':	
				//$pageHTML .= '<div class="home-case">';
				require(FUNCTIONS . '/mod_case_study.php');
				//$pageHTML.= '</div><!--.home-case-->';
			break;
			
			case 'Text Highlight':
				$pageHTML .= '<div class="vert-center-outer"><div class="vert-center-inner">';
				require(FUNCTIONS . '/mod_text_highlight.php');
				$pageHTML .= '</div><!--.vert inner--></div><!--.vert outer-->';
			break;
			
			case 'Image':
				$pageHTML .= '<img src="' . $image . '">';
			break;
				
			case 'Post Feed':
				
			if($module_name):
					$pageHTML .= '<div class="title-tag" style="margin-left:40px !important;">' . $module_name . '</div>';
			endif;
				
				$pageHTML .= '<div class="mod-text-inner">';
				
			switch($post_type){
					case 'post':
						$pageHTML .= '<h1>Saw a Good Idea</h1>';
						break;
					case 'rss':
						$rss_feed_name = get_sub_field('rss_feed_name');
						$pageHTML .= '<h1>' . $rss_feed_name  . '</h1>';
						break;
				}
				$pageHTML .= '<div class="post-list-inner"><div class="post-list-ct">';
				
				if($post_type == 'rss'):
				
					$rss_address = get_sub_field('rss_address');		
					$pageHTML .= do_shortcode( '[recent_rss feed="' . $rss_address . '" excerpt="Yes" numberposts="' . $number_posts  .'"]' );
					
				endif;
				
				$pageHTML .= do_shortcode( '[recent_post post_type="' . $post_type . '" excerpt="Yes" numberposts="' . $number_posts  .'"]' );
				$pageHTML .= '</div></div></div>';
	
			break;
			
			case 'Spacer':
				$pageHTML .= '<div class="space" style="minimum-height:' . $module_height . 'px; background-color:transparent;"></div><!--.space-->';
				break;
			
		}//end content type switch
		
//SET UP POST SCROLLER

		if($number_posts > 1):
			$pageHTML .= '<div class="dot-nav-vertical-ct">';
			$single_type_left = substr($post_type, 0, -1);
		
		for($i=0; $i< $number_posts ; $i++){
			$pageHTML .= '<div class="dot-nav" id="bt_' . $single_type_left . '_' . $i .'"></div>';
		}
		
		$pageHTML .='</div>';//ends dot-nav container
		endif;
				
		
//CLOSE GRID ITEM	
		$pageHTML .= '</div><!--.grid-item-->';
		
		
		endwhile;//end repeater loop
	
	endif;//END REPEATER LOOP
		
	$pageHTML .= '</div><!--.grid-->';
	
		//if($grid_width == 'Yes'):
			$pageHTML .=  '</div><!-- .wrapper-->';
		//endif;
			
	$pageHTML .= '<div class="clearfix"></div>';
	
	$pageHTML .= '</div><!--.row-->';
	
	endwhile;//end grid repeater loop
	
	endif;//END GRID REPEATER 


wp_reset_postdata();
echo $pageHTML;
?>


<script type="text/javascript">
$( function() {
	  
	  $('.grid-g-0').isotope({
		 percentPosition: true,
	  layoutMode: 'packery',
	  //   layoutMode: 'masonry',
	    itemSelector: '.grid-item',
	    isOriginTop: true,
	    packery: {
	  // masonry: {
	      gutter: '.grid-gutter'
	      }
	  });
	  
	});

$( function() {
	  
	  $('.Bgrid-g-0').isotope({
		 percentPosition: true,
	  layoutMode: 'packery',
	  //   layoutMode: 'masonry',
	    itemSelector: '.grid-item',
	    isOriginTop: false,
	    packery: {
	  // masonry: {
	      gutter: '.grid-gutter'
	      }
	  });
	  
	});

$( function() {
	  
	  $('.grid-g-2').isotope({
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

</div></div><!-- .content-wrapper -->
</div><!-- .company-page -->

<?php get_footer(); ?>