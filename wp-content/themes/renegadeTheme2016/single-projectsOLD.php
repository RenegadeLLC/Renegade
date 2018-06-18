<?php
/**
 * Template Name: Single Projects Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2016
 */

get_header();


$grid_num = 0;
$grid_index = 0;


$header = get_field('header');
$subheader = get_field('subheader');
$headline_background_color = get_field('headline_background_color');
$grid = get_field('grid');

$projectID = get_the_title( $post->ID );
$project_title = get_field('project_title');

$pageHTML = '';

//$pageHTML .= '<div style="display:block; position:relative; overflow:hidden; background:#E6E7E8; height:100%; width:100%;">';


// GET GRIDS

	if( have_rows('grid') ):
	
	while ( have_rows('grid') ) : the_row();	
	$section_index = 0;
		$grid_class;
	
		$customize_wrapper_row_background = get_sub_field('customize_wrapper_row_background');
		
		//if($customize_wrapper_row_background == 'Yes'):
			$wrapper_background_color = get_sub_field('background_color');
			$wrapper_background_image = get_sub_field('background_image');
			$wrapper_background_repeat = get_sub_field('wrapper_background_repeat');
			$wrapper_background_image_size = get_sub_field('wrapper_background_image_size');
			$wrapper_background_image_opacity = get_sub_field('background_image_opacity');
		//endif;

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
		
		$client = get_field('client_name');
		
		if($client):
			$client_name = $post->name;
			$client_name = get_the_title( $client->ID );
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
			$pageHTML .= ' background-image:url('. $wrapper_background_image . ');';
			$pageHTML .= ' background-size:' . $wrapper_background_image_size . ';';
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
			
			if($client_name){
				$pageHTML .= '<h1 class="text-center white">'. $client_name;
			}
			
			if($project_title){
				$pageHTML .= ' <span class="light-serif gray">' . $project_title . '</span></h1><!--<a href="#submenu" id="bt-submenu"><div class="bt-submenu"></div></a>-->';
			}
			
			?>
						<nav id="submenu">
										<?php //wp_nav_menu( array( 'menu' => 'work','theme_location' => 'work', 'menu_class' => 'sub-nav-menu','container_class' => 'sub-nav-menu-ct' ) ); ?>
						</nav>
					
						<?php
						
			$pageHTML .= '</div><!-- headline-ct -->';
			$pageHTML .= '<div class="clear-fix"></div><!-- .clearfix -->';
			
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
		
		$pageHTML .= '<div class="grid ' . $grid_class . ' case-study"';
		
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
		
		$pageHTML .= '<div class="case-grid-item';

	//GET MODULE WIDTH
			if($module_width == '100%'):
				$pageHTML .= ' case-grid-item-w-100';
			elseif($module_width == '75%'):
				$pageHTML .= ' case-grid-item-w-75';
			elseif($module_width == '67%'):
				$pageHTML .= ' case-grid-item-w-67b';
			elseif($module_width == '50%'):
				$pageHTML .= ' case-grid-item-w-50';
			elseif($module_width == '33%'):
				$pageHTML .= ' case-grid-item-w-33b';
			elseif($module_width == '25%'):
				$pageHTML .= ' case-grid-item-w-25';
			endif;

//GET CUSTOM CLASS

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
	
		//if($custom_class):
		$pageHTML .= '<div class="' . $custom_class . '">';
		//endif;
		
		//GET CONTENT TYPE AND LOAD RENDERING FUNCTIONS
		
		switch($content_type){
			
			case 'Text or Mixed':
				$pageHTML .= '<div class="vert-center-outer"><div class="vert-center-inner">';
				$pageHTML .= '<div class="case-study-text">';
				require(FUNCTIONS . '/mod_text_mixed.php');
				$pageHTML .= '</div>';
				$pageHTML .= '</div><!--.vert inner--></div><!--.vert outer-->';
				
			break;
			
			
			case 'Text Highlight':
				$pageHTML .= '<div class="vert-center-outer"><div class="vert-center-inner">';
				require(FUNCTIONS . '/mod_text_highlight.php');
				$pageHTML .= '</div><!--.vert inner--></div><!--.vert outer-->';
			break;
			
			case 'Image':
				$pageHTML .= '<img src="' . $image . '" class="lazys">';
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
				
		$pageHTML .= '</div><!--.custom-class-->';
//CLOSE GRID ITEM	
		$pageHTML .= '</div><!--.case-grid-item-->';
		
	
		$grids = get_field('grid');
		$num_grids = count($grids, 0);
		
		$content_sections = get_sub_field('modules');
		$num_sections = count($content_sections, 0);
	/*
		
		if($grid_index >= $num_grids && $section_index >= $num_sections):
		
	
		//SERVICES PROVIDED
		
		$service_types = get_field('service_type');
		
		
		$pageHTML .= '<div class="case-grid-item case-grid-item-w-100"><div class="services-provided">';
		
		if($service_types):
			$pageHTML .= '<h3>Services Provided</h3>';
			
			foreach( $service_types as $service ):
				$service_name = $service->name;
				$pageHTML .= $service_name . '<br>';
			endforeach;
		
		endif;
		
		$pageHTML .= '</div></div>';
		
		endif;
		
		$section_index++;
		$grid_index++;
		*/
		endwhile;//end repeater loop
		
	
	
	
		endif;//END REPEATER LOOP
	
		
		
		
	$pageHTML .= '</div><!--.grid-->';
	
		//if($grid_width == 'Yes'):

			$pageHTML .=  '</div><!-- .wrapper-->';
		//endif;
			//$pageHTML  .= '<div class="wrapper"><div style="display:block; position:relative; overflow:hidden; height:48px; width:100%; background-color:"></div></div><!-- .wrapper-->';
					
	$pageHTML .= '<div class="clearfix"></div>';
		$pageHTML .= '</div><!--.row-->';
	
	
	
	
	endwhile;//end grid repeater loop
	
	
	endif;//END GRID REPEATER 
	
	$pageHTML .= '</div><!--.case-study-->';

wp_reset_postdata();
echo $pageHTML;
?>


<script type="text/javascript">

jQuery(document).ready(function($) {


//	lazy_load();
$(".lazy").bttrlazyloading({
		
		xs: {
		//	src: "img/720x200.gif",
			//width: 200,
			//height: 267
		},
		sm: {
		//	src: "img/360x200.gif",
			width: 1200,
			height: 400
		},
		md: {
		//	src: "img/470x200.gif",
		//	width: 566,
			//height: 755
		},
		lg: {
		//	src: "img/347x489.gif",
			//width: 2700,
			//height: 3600
		},
		//retina: true,
		animation: 'fadeIn',
		delay: 1000,
		event: 'scroll',
		triggermanually: false,
		//container: 'document.body',
		threshold: 666,
		//backgroundcolor: '#ffffff',
		//placeholder:'<?php //echo(get_template_directory_uri() . '/library/images/loading.gif');?>',
		

	})
	
	  $('.grid-g-0').isotope({
			 percentPosition: true,
		  layoutMode: 'packery',
		  //   layoutMode: 'masonry',
		    itemSelector: '.case-grid-item',
		    isOriginTop: false,
		    packery: {
		  // masonry: {
		      gutter: '.grid-gutter'
		      }
		  });

	  $('.grid-g-0').imagesLoaded( function() {
		  $('.grid-g-0').isotope('layout');
			
		});
		
	  $('.Bgrid-g-0').isotope({
			 percentPosition: true,
		  layoutMode: 'packery',
		  //   layoutMode: 'masonry',
		    itemSelector: '.case-grid-item',
		    isOriginTop: false,
		    packery: {
		  // masonry: {
		      gutter: '.grid-gutter'
		      }
		  });
		  
		  $('.Bgrid-g-0').imagesLoaded( function() {
			  $('.Bgrid-g-0').isotope('layout');
				
			});

		  $('.grid-g-2').isotope({
				 percentPosition: true,
			  layoutMode: 'packery',
			  //   layoutMode: 'masonry',
			    itemSelector: '.case-grid-item',
			    packery: {
			  // masonry: {
			      gutter: '.grid-gutter'
			      }
			  });

			  $('.grid-g-2').imagesLoaded( function() {
				  $('.grid-g-2').isotope('layout');
					
				});
				
		  $('.grid-g-3').isotope({
			 percentPosition: true,
		  layoutMode: 'packery',
		  //   layoutMode: 'masonry',
		    itemSelector: '.case-grid-item',
		    packery: {
		  // masonry: {
		      gutter: '.grid-gutter'
		      }
		  });

		  $('.grid-g-3').imagesLoaded( function() {
			  $('.grid-g-3').isotope('layout');
				
			});
		  
		  
	  
	});

function lazy_load(){

	$(".lazy").bttrlazyloading({
		
		xs: {
		//	src: "img/720x200.gif",
			//width: 200,
			//height: 267
		},
		sm: {
		//	src: "img/360x200.gif",
			width: 1200,
			height: 400
		},
		md: {
		//	src: "img/470x200.gif",
		//	width: 566,
			//height: 755
		},
		lg: {
		//	src: "img/347x489.gif",
			//width: 2700,
			//height: 3600
		},
		//retina: true,
		animation: 'fadeIn',
		delay: 1000,
		event: 'scroll',
		triggermanually: false,
		//container: 'document.body',
		//threshold: 666,
		backgroundcolor: '#000000',
		//placeholder:'<?php //echo(get_template_directory_uri() . '/library/images/loading.gif');?>',
		

	})
	
	}
</script>


</div></div><!-- .content-wrapper -->
</div><!-- .company-page -->

<?php get_footer(); ?>