<?php
/**
 * Template Name: HOME Modules Template
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
		$content_type = get_sub_field('content_type');
		$post_type = get_sub_field('post_type');
		$number_posts = get_sub_field('number_posts');
		
		if($customize_background == 'Yes'):
			$background_color = get_sub_field('background_color');
			$background_image = get_sub_field('background_image');
			$background_hor_position = get_sub_field('background_hor_position');
			$background_vert_position = get_sub_field('background_vert_position');
			$text_color = get_sub_field('text_color');
			$custom_class = get_sub_field('custom_class');
		endif;

		
		
	//	$pageHTML .= $module_name . ' ' . $module_width . ' ' . $background_color . ' ' . $background_image . ' ' . $content_type . ' ' . $text_color . ' ' . $text_alignment . ' ' . $content_type;
		$pageHTML .= '<div class="grid-item';

		if($module_width == '100%'):
			$pageHTML .= ' grid-item-w-100';
		elseif($module_width == '75%'):
			$pageHTML .= ' grid-item-w-75';
		elseif($module_width == '67%'):
			$pageHTML .= ' grid-item-w-67';
		elseif($module_width == '50%'):
			$pageHTML .= ' grid-item-w-50';
		elseif($module_width == '33%'):
			$pageHTML .= ' grid-item-w-33';
		elseif($module_width == '25%'):
			$pageHTML .= ' grid-item-w-25';
		endif;
		
		if($custom_class):
			$pageHTML .= ' ' . $custom_class;
		endif;
		
		//end class dec
		$pageHTML .= '" ';
		
		//look for style options
		
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

				if($module_height):
					$pageHTML .= ' min-height:' . $module_height . 'px;';
				endif;
				
				if($text_color):
					$pageHTML .= ' color:' . $text_color . ';';
				endif;
		
			//close style dec
			$pageHTML .= '"';
			
		endif;
		
		//close class and style dec
		$pageHTML .= '>';
		
	switch($content_type){
			
			case 'Text or Mixed':
				$pageHTML .= '<div class="vert-center-outer"><div class="vert-center-inner">';
				$pageHTML .= '<div class="md-text">';
				require(FUNCTIONS . '/mod_text_mixed.php');
				$pageHTML .= '</div>';
				$pageHTML .= '</div><!--.vert inner--></div><!--.vert outer-->';
			break;
			
			case 'Case Study':	
				$pageHTML .= '<div class="home-case">';
				require(FUNCTIONS . '/mod_case_study.php');
				$pageHTML.= '</div><!--.home-case-->';
			break;
			
			case 'Text Highlight':
				$pageHTML .= '<div class="vert-center-outer square"><div class="vert-center-inner">';
				require(FUNCTIONS . '/mod_text_highlight.php');
				$pageHTML .= '</div><!--.vert inner--></div><!--.vert outer-->';
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

				if($number_posts > 1):
				$pageHTML .= '<div class="dot-nav-vertical-ct">';
				$single_type_left = substr($post_type, 0, -1);
				
				for($i=0; $i< $number_posts ; $i++){
					$pageHTML .= '<div class="dot-nav" id="bt_' . $single_type_left . '_' . $i .'"></div>';
				}
				
				$pageHTML .='</div>';//ends dot-nav container
				endif;
				
			break;
			
		}
		

				
		$pageHTML .= '</div><!--.grid-item-->';
		
	endwhile;
	
endif;
//END REPEATER LOOP
		

$pageHTML .= '</div><!--.grid--></div><!--.wrapper-->';

wp_reset_postdata();
echo $pageHTML;
?>
<script type="text/javascript">

( function() {
	  
	  $('.grid').isotope({
		 percentPosition: true,
	  layoutMode: 'packery',
	  //   layoutMode: 'masonry',
	    itemSelector: '.grid-item',
	    packery: {
	  // masonry: {
	      gutter: '.grid-gutter'
	    	  //  gutter: 2
	      }
	  });


	  imagesLoaded( '.grid', function() {
$('.grid').isotope('layout');
	  });
	  
	});
</script>
<?php get_footer();?>