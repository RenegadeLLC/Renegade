<?php
/**
 * Template Name: HOME Full Width Template
 *
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2015
 */
global $link_color;
get_header();

$pageHTML = '';

$pageHTML .= '<div style="display:block; position:relative; overflow:hidden; background:#E6E7E8; height:100%; width:100%;">';

//HEADLINE VARS

$headline = get_field('headline');
$sub_headline = get_field('sub_headline');

//COLOR VARS

$headline_background_color = get_field('headline_background_color');
$headline_color = get_field('headline_color');
$sub_headline_color = get_field('sub_headline_color');
$right_side_background_color = get_field('right_side_background_color');
$right_side_image = get_field('right_side_image');

//DO HEADLINE


$pageHTML .='<div class="home">';
$pageHTML .= '<div style="background-color:' . $headline_background_color . '; width:100%; height:600px; position:absolute;"></div>';
	
	
	$pageHTML .= '<div class="headline-ct" style="background-color:' . $headline_background_color .';">'; 
	$pageHTML .= '<div class="wrapper" style="height:100%;">';
	$pageHTML .= '<div class="headline-left">';
	$pageHTML .= '<div class="vert-center-outer"><div class="vert-center-inner">';
	$pageHTML .='<h1><span style="color:' . $headline_color . ';">' . $headline . '</span></h1>';
	$pageHTML .='<h2><span style="color:' . $sub_headline_color . ';">' . $sub_headline . '</span></h2>';
	$pageHTML .= '</div><!--headline-left-->';
	$pageHTML .= '</div></div><!--.vert-center-inner--><!--.vert-center-outer-->';
	$pageHTML .= '<div class="headline-right" style="background-color:' . $right_side_background_color . ';"><img src="' . $right_side_image .'"></div>';
	$pageHTML .= '</div><!--headline-ct--></div><!--.wrapper-->';
	
	//END HEADLINE

	
	//START GRID
	
$pageHTML .= '<div class="wrapper"><div class="grid"><div class="grid-gutter"></div>';

//GET MODULE CONTENT

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
			$pageHTML .= ' grid-item-w-67';
		elseif($module_width == '50%'):
			$pageHTML .= ' grid-item-w-50';
		elseif($module_width == '33%'):
			$pageHTML .= ' grid-item-w-33';
		elseif($module_width == '25%'):
			$pageHTML .= ' grid-item-w-25';
		endif;
		
		//GET CUSTOM CLASS
		
		if($custom_class):
			$pageHTML .= ' ' . $custom_class;
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
				$pageHTML .= '<div class="vert-center-outer square"><div class="vert-center-inner">';
				require(FUNCTIONS . '/mod_text_highlight.php');
				$pageHTML .= '</div><!--.vert inner--></div><!--.vert outer-->';
			break;
			
			case 'Post Feed':
				
				if($module_name):
					$pageHTML .= '<div class="title-tag" style="margin-left:40px !important;">' . $module_name . '</div>';
				endif;
				
				$pageHTML .= '<div class="mod-text-inner">';
				
				/*switch($post_type){
					case 'post':
						$pageHTML .= '<h1>Saw a Good Idea</h1>';
						break;
					case 'rss':
						$rss_feed_name = get_sub_field('rss_feed_name');
						$pageHTML .= '<h1>' . $rss_feed_name  . '</h1>';
						break;
				}*/
				$blog_name = get_sub_field('blog_name');
				if($blog_name):
				$pageHTML .= '<h1>' . $blog_name  . '</h1>';
				endif;
				
				
				$pageHTML .= '<div class="post-list-inner"><div class="post-list-ct" id="' . $module_name . '">';
				
			/*	if($post_type == 'rss'):
				
					$rss_address = get_sub_field('rss_address');		
					$pageHTML .= do_shortcode( '[recent_rss feed="' . $rss_address . '" excerpt="Yes" numberposts="' . $number_posts  .'"]' );
					
				endif;*/
			
				$pageHTML .= do_shortcode( '[recent_post post_type="' . $post_type . '" excerpt="Yes" numberposts="' . $number_posts  .'"]' );
				$pageHTML .= '</div></div></div>';
	
			break;
			
			case 'RSS Feed':
			
				if($module_name):
				$pageHTML .= '<div class="title-tag" style="margin-left:40px !important;">' . $module_name . '</div>';
				endif;
			
				$pageHTML .= '<div class="mod-text-inner mod-rss">';
			
				
				$rss_feed_name = get_sub_field('rss_feed_name');
				$pageHTML .= '<h1>' . $rss_feed_name  . '</h1>';
				$pageHTML .= '<div class="post-list-inner"><div class="post-list-ct">';
			
			//	if($post_type == 'rss'):
			
				$rss_address = get_sub_field('rss_address');
				$pageHTML .= do_shortcode( '[recent_rss feed="' . $rss_address . '" excerpt="Yes" numberposts="' . $number_posts  .'" text_color="' . $text_color . '"]' );
					
				//endif;
					
				//$pageHTML .= do_shortcode( '[recent_post post_type="' . $post_type . '" excerpt="Yes" numberposts="' . $number_posts  .'"]' );
				$pageHTML .= '</div></div></div>';
			
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
		
	//CLOSE GRID WRAPPER AND HOME DIVS
	$pageHTML .= '</div><!--.gray back--></div><!--.grid--></div><!--.wrapper--></div><!--.home-->';
	
	wp_reset_postdata();
	
	//RENDER PAGE
	echo $pageHTML;
?>

<!-- call grid packery function -->

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
		    	  //  gutter: 2
		      }
		  });//end isotope

		<!-- render grid when images have loaded -->
	  
	  imagesLoaded( '.grid', function() {
			$('.grid').isotope('layout');
	  });

	  
	});//end doc ready
</script>

<script type="text/javascript">
			$(function() {
				var $menu = $('#submenu'),
				$html = $('html, body'),
				$num;
				$menu.mmenu({
					//isMenu: false,
					dragOpen: true,
					offCanvas: 
						{
		              position  : 'right',
		             //   menuWrapperSelector : 'div',
		             //   pageSelector: 'site-content',
		            //    moveBackground : false,
		                //modal: true,
		           zposition	: "front"
		             }
			         // options
			      }, {
			         // configuration
			         classNames: {

				      //   panel: 'site-content',
			            fixedElements: {
			              //fixedTop: "header-ct",
			              // fixedBottom: "footer"
			            },

			         //   panelNodetype: "div"
			           
			         }
			      });
			      
			
				$menu.find( 'li > a' ).on(
						'click',
						function( e )
						{
							var href = $(this).attr( 'href' );

							//	if the clicked link is linked to an anchor, scroll the page to that anchor 
							if ( href.slice( 0, 1 ) == '#' )
							{
								$menu.one(
									'closed.mm',
									function()
									{
										setTimeout(
												
											function()
											{
												
												$html.animate({
														
													scrollTop: $( href ).offset().top

												});	
											}, 10
										);	
									}
								);
							}
						}
					);
			});
		</script>
	
<?php get_footer();?>