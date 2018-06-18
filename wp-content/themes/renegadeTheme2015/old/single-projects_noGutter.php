<?php
/**
 * The template for displaying all single projects.
 *
 * @package Renegade
 */

get_header(); 




?>


	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		
<div class="work">
<div class="content-wrapper">
<div class="headline-ct"><a href="#submenu"><div class="bt-submenu"></div></a><div class="sub-nav-menu-ct" id="submenu"><?php wp_nav_menu( array( 'theme_location' => 'people', 'menu_class' => 'sub-nav-menu' ) ); ?></div>


<?php 
//$client = get_the_terms( get_the_ID(), 'client_name');
$projectID = get_the_title( $post->ID );
$project_title = get_field('project_title');
$client = get_field('client_name');
$client_name = $client->name;
//$client_name = get_the_terms( get_the_ID(), 'client_name');
$pageHTML = '';
$pageHTML .= '<h1><span class="red">' . $client_name . '</span> ' . $project_title  . '</h1><div class="clearfix"></div>';

$pageHTML .= '</div><!-- .headline-ct  -->';

//$pageHTML .= '<div class="topDiag" style="margin-bottom:24px;"></div>';
$pageHTML .= '<div class="ng-grid"><div class="ng-grid-gutter"></div>';
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
		
		
		
		
		
		
		//$floater = get_sub_field('floater');
		
		$text_class;
		
	//	$pageHTML .= $module_name . ' ' . $module_size . ' ' . $background_color . ' ' . $background_image . ' ' . $content_type . ' ' . $text_color . ' ' . $text_alignment . ' ' . $content_type;
		$pageHTML .= '<div class="ng-grid-item';


		
		if($module_width):
			switch($module_width){
			
				case '100%':
					$pageHTML .= ' ng-grid-item-w-100';
				break;
				
				case '75%':
					$pageHTML .= ' ng-grid-item-w-75';
				break;
					
				case '67%':
					$pageHTML .= ' ng-grid-item-w-67';
				break;		
							
				case '50%':
					$pageHTML .= ' ng-grid-item-w-50';
				break;
				
				case '33%':
					$pageHTML .= ' ng-grid-item-w-33';
				break;
				
				case '25%':
					$pageHTML .= ' ng-grid-item-w-25';
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
	
	
			$pageHTML .= '<img src="' . $project_image .'" alt="">'	;
			
		elseif($content_type == 'Highlight Text'):
		
			$pageHTML .= '<div class="highlight-ct"><div class="highlight">';
			$pageHTML .= $highlight_text ;
			$pageHTML .= '</div></div>';
			
		elseif($content_type == 'Text or Mixed'):
			
		$pageHTML .= '<div class="text-block">';
		$pageHTML .= $custom_content;
		$pageHTML .= '</div>';
		
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
		

		
		$pageHTML .= '</div><!--.ng-grid-item-->';
	endwhile;
	
endif;
		

$pageHTML .= '</div><!--.ng-grid-->';

echo $pageHTML;
?>



		

		
</div><!-- .wrapper -->

</div><!-- .work page -->
		
</div>
		</main><!-- #main -->
	</div><!-- #primary -->
	
	<script type="text/javascript">
$( function() {
	  
	  $('.ng-grid').isotope({
		 percentPosition: true,
	  layoutMode: 'packery',
	  //   layoutMode: 'masonry',
	    itemSelector: '.ng-grid-item',
	    packery: {
	  // masonry: {
	      gutter: 0
	      }
	  });
	  
	});
</script>
	
	

<?php get_footer(); ?>
