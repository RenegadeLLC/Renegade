<?php
/**
 * The template for displaying all single projects.
 *
 * @package Renegade
 */

get_header(); 



$pageHTML = '';
?>


	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

<?php 
$headline_background_color = get_field('headline_background_color');
$case_intro_text = get_field('case_intro_text');

$pageHTML .= '<div class="work case-study">';
$pageHTML .= '<div style="background-color:' . $headline_background_color . ';   width:100%; height:600px; position:absolute;"></div>';
$pageHTML .= '<div class="wrapper">';
$pageHTML .= '<div class="headline-ct"><a href="#submenu"><div class="bt-submenu"></div></a><div class="sub-nav-menu-ct" id="submenu">';
//$pageHTML .=  wp_nav_menu( array( 'theme_location' => 'people', 'menu_class' => 'sub-nav-menu' ) ) ; 
$pageHTML .= '</div>';
//$client = get_the_terms( get_the_ID(), 'client_name');
$projectID = get_the_title( $post->ID );
$project_title = get_field('project_title');
$client = get_field('client_name');
$client_name = $client->name;
//$client_name = get_the_terms( get_the_ID(), 'client_name');
$pageHTML .= '<div class="vert-center-outer"><div class="vert-center-inner">';
//$pageHTML .= '<h1><span class="red">' . $client_name . '</span> ' . $project_title  . '</h1><div class="clearfix"></div>';
//$pageHTML .= '<h1>' . $case_intro_text  . '</h1><div class="clearfix"></div>';
$pageHTML .= '<h1>' . $case_intro_text  . '</h1><div class="clearfix"></div>';
$pageHTML .= '</div></div><!--.vert-center-inner--><!--.vert-center-outer-->';
$pageHTML .= '</div><!-- .headline-ct  -->';

//$pageHTML .= '<div class="topDiag" style="margin-bottom:24px;"></div>';
$pageHTML .= '<div class="case-block"><div class="case-block-gutter"></div>';
if( have_rows('case_content') ):

	// GET CONTENT MODULES AND VARS
	while ( have_rows('case_content') ) : the_row();
		$module_name = get_sub_field('module_name');
		$module_width = get_sub_field('module_width');
		$module_height = get_sub_field('module_height');
		$content_type = get_sub_field('content_type');
		$background_color = get_sub_field('background_color');
		$background_image = get_sub_field('background_image');
		$highlight_text = get_sub_field('highlight_text');
		$text_color = get_sub_field('text_color');
		$link_color = get_sub_field('link_color');
		$case_content = get_sub_field('custom_content');
		$project_image = get_sub_field('project_image');
		$image_alt_tag = get_sub_field('image_alt_tag');
		$custom_content = get_sub_field('custom_content');
		$custom_class = get_sub_field('custom_class');
		//$floater = get_sub_field('floater');
		
		$text_class;
		
	//	$pageHTML .= $module_name . ' ' . $module_size . ' ' . $background_color . ' ' . $background_image . ' ' . $content_type . ' ' . $text_color . ' ' . $text_alignment . ' ' . $content_type;
		$pageHTML .= '<div class="case-block-item ' . $custom_class;

		
		if($module_width):
			switch($module_width){
			
				case '100%':
					$pageHTML .= ' case-block-item-w-100';
				break;
				
				case '75%':
					$pageHTML .= ' case-block-item-w-75';
				break;
					
				case '67%':
					$pageHTML .= ' case-block-item-w-67';
				break;		
							
				case '50%':
					$pageHTML .= ' case-block-item-w-50';
				break;
				
				case '40%':
					$pageHTML .= ' case-block-item-w-40';
					break;
				
				case '33%':
					$pageHTML .= ' case-block-item-w-33';
				break;
				
				case '25%':
					$pageHTML .= ' case-block-item-w-25';
				break;
						
			}//end switch
			
		//	$pageHTML .= ' ' . $text_class;
		endif;
		//end class dec
		$pageHTML .= '" ';
		
		//look for style options
		
		if($background_color || $background_image || $text_color):
		
			$pageHTML .= 'style="';
		
		if($module_height):
			$pageHTML .= ' min-height:' . $module_height . 'px !important;';
		endif;
		
			if($background_color):
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
		
		
		if($content_type == 'Image'):
	
		$pageHTML .= '<div class="center">';
			$pageHTML .= '<img src="' . $project_image .'" alt="">'	;
			$pageHTML .= '</div>';
		elseif($content_type == 'Highlight Text'):
		
			$pageHTML .= '<div class="case-highlight-ct"><div class="case-highlight">';
			$pageHTML .= $highlight_text ;
			$pageHTML .= '</div></div>';
			
		elseif($content_type == 'Text or Mixed'):
			
		$pageHTML .= '<div class="case-text-block">';
		$pageHTML .= '<div class="case-text">';
		$pageHTML .= $custom_content;
		$pageHTML .= '</div></div>';
		
		elseif($content_type == 'Services'):
		
			$services = get_field('service_type');
			
				if($services):
					$pageHTML .= '<div class="services-outer"><div class="services-inner"><h2>Services Provided</h2>';
				endif;
	
				if( $services ):
				
					foreach( $services as $service ):
						$pageHTML .= $service->name;
					
						//$pageHTML .= 'Yes';
					endforeach;
					else:
						$pageHTML .= '<div class="warning">You have not entered any services for this project.</div>';
						
					endif;
					
				if($services):
						$pageHTML .= '</div></div>';
				endif;
				
		elseif($content_type == 'Industries'):
	
		$industry_vertical = get_field('industry_vertical');

		
			if( $industry_vertical ):
				foreach( $industry_vertical as $industry ):
					$pageHTML .=  $industry->name;
					//$pageHTML .= 'Yes';
				endforeach;
			endif;
		
		endif;
		

		
		$pageHTML .= '</div><!--.case-block-item-->';
	endwhile;
	
endif;
		

$pageHTML .= '</div><!--.case-block-->';

echo $pageHTML;
?>



		

		
</div><!-- .wrapper -->

</div><!-- .work page -->
		
</div>
		</main><!-- #main -->
	</div><!-- #primary -->
	
	
	
	

<?php get_footer(); ?>
