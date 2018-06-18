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
?>
<style type="text/css">

.acf-map {
	width: 100%;
	height: 400px;
	border: #ccc solid 1px;
	margin: 40px 40px 40px 0;
	max-width:620px;
}

/* fixes potential theme css conflict */
.acf-map img {
   max-width: inherit !important;
}

.google-map-ct{
	display:block;
	position:relative;
	overflow:hidden;
	width:100%;
	height:auto;
	margin:0 auto;
}
</style>

<?php 

$grid_num = 0;
$page_class = get_field('page_class');
$headline = get_field('headline');
$sub_headline = get_field('sub_headline');

$headline_background_color = get_field('headline_background_color');
$grid = get_field('grid');

$pageHTML = '';

//IF THIS IS THE FIRST GRID, ADD THE HEADLINE AND SUBHEADLINE BEFORE IT
$pageTopHTML = require_once (FUNCTIONS . '/standard_page_top.php');
//QUERY PROJECT POST TYPES FOR LOGO GRID

$pageHTML .= $pageTopHTML;

//$pageHTML .= '<div style="display:block; position:relative; overflow:hidden; background:#E6E7E8; height:100%; width:100%;"';

//if($page_class):
	//$pageHTML .= ' class="' . $page_class . '"';
//endif;
 		
 //$pageHTML .= '>';
// GET GRIDS

	if( have_rows('grid') ):
	
	while ( have_rows('grid') ) : the_row();	

		$grid_class;
	
		$customize_wrapper_row_background = get_sub_field('customize_wrapper_row_background');
		
		//if($customize_wrapper_row_background == 'Yes'):
		$wrapper_background_color = get_sub_field('background_color');
		$wrapper_background_image = get_sub_field('background_image');
		$wrapper_background_repeat = get_sub_field('wrapper_background_repeat');
		$wrapper_background_image_size = get_sub_field('wrapper_background_image_size');
		$wrapper_background_image_position = get_sub_field('wrapper_background_image_position');
			
	//	endif;
	
		$customize_grid_background = get_sub_field('customize_grid_background');
		$gutter_spacing = get_sub_field('gutter_spacing');
		$grid_width = get_sub_field('grid_width');
		$vertical_align = get_sub_field('vertical_alignment');
		$content_section = get_sub_field('modules');
		
		if($customize_grid_background = 'Yes' || $customize_grid_background = 'yes'):
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
		
	$pageHTML .= '<div class="row"';
		
		if($customize_wrapper_row_background == 'Yes'):
			$pageHTML .= ' style="';
		endif;
		
		if($wrapper_background_color):
			$pageHTML .=	'background-color:' . $wrapper_background_color . '; ';
		endif;
		
		if($wrapper_background_image):
			$pageHTML .= ' background-image:url('. $wrapper_background_image . ');';
		endif;
			
		if($wrapper_background_image_size):
			$pageHTML .= ' background-size:' . $wrapper_background_image_size . ';';
		endif;
		
		if($wrapper_background_repeat):
			$pageHTML .= ' background-repeat:' . $wrapper_background_repeat . ';';
		else:
			$pageHTML .= ' background-repeat:no-repeat;';
		endif;
		
		if($wrapper_background_image_position):
			$pageHTML .= ' background-position:' . $wrapper_background_image_position . ';';
		endif;
					
		if($customize_wrapper_row_background == 'Yes'):
			$pageHTML .= '"';
		endif;
		//close out row styling
		
		$pageHTML .= ' class="background-image">';

		$grid_num++;
		
		if($grid_width == 'Yes'):
			$pageHTML .= '<div class="wrapper">';
		else:
			$pageHTML .= '<div class="wrapper" style="max-width:100% !important;">';
		endif;
		
		$pageHTML .= '<div class="grid ' . $grid_class . '"';
		
$customize_grid_background = get_sub_field('customize_grid_background');
		
		if($customize_grid_background = 'Yes'):
			$grid_background_color = get_sub_field('grid_background_color');
			$grid_background_image = get_sub_field('grid_background_image');
			$grid_background_image_repeat = get_sub_field('grid_background_image_repeat');
			$grid_background_image_size = get_sub_field('grid_background_image_size');
			$grid_background_image_position = get_sub_field('grid_background_image_position');
		else:
			$grid_background_color = 'transparent';
		endif;
		
		if($customize_grid_background = 'Yes'):
			$pageHTML .= 'style="';
		endif;
		
		if($customize_grid_background = 'Yes'):
		
			if($grid_background_image):
				$pageHTML .= 'background-image:url(' . $grid_background_image . '); ';
			endif;
			
			if($grid_background_color):
				$pageHTML .= 'background-color:' . $grid_background_color . '; ';
			endif;
			
			$customize_grid_background_image = get_sub_field('customize_grid_background_image');
			
			if($customize_grid_background_image == 'Yes'):
			
				if($grid_background_image_repeat):
					$pageHTML .= 'background-repeat:' . $grid_background_image_repeat . '; ';
				else:
					$pageHTML .= 'background-repeat:no-repeat; ';
				endif;
				
				if($grid_background_image_size):
					$pageHTML .= 'background-size:' . $grid_background_image_size . ';';
				endif;
				
				if($grid_background_image_position):
					$pageHTML .= 'background-position:' . $grid_background_image_position . ';';
				endif;
				
			endif;
			
			if($customize_grid_background = 'Yes'):
				$pageHTML .= '"';
			endif;
		endif;
		
$pageHTML .='><div class="grid-gutter"></div>';
		

//CONTENT SECTION REPEATERS

if( have_rows('modules') ):

	// GET CONTENT MODULES AND VARS
	while ( have_rows('modules') ) : the_row();

		$module_name = get_sub_field('module_name');
		$module_width = get_sub_field('module_width');
		$module_height = get_sub_field('module_minimum_height');
		$custom_class = get_sub_field('custom_class');
		//$customize_background = get_sub_field('customize_background');
		$content_type = get_sub_field('content_type');
		/* CONTENT TYPES */
			
			//for text-mixed and text-highlight
			$module_content = get_sub_field('module_content');
			//image
			$image = get_sub_field('image');
			//post or rss feeds
			$post_type = get_sub_field('post_type');
			//streaming video
			$video = get_sub_field('video');
			//map
			$google_map = get_sub_field('google_map');
			//for post feeds
			$number_posts = get_sub_field('number_posts');
			
			//change appearance vars
			$customize_appearance = get_sub_field('customize_appearance');
			
			//for text highlights
			$add_circle_background = get_sub_field('add_circle_background');
			$circle_background_color = get_sub_field('circle_background_color');
			
			$text_color = get_sub_field('text_color');
			$section_background_color = get_sub_field('section_background_color');
			$section_background_image = get_sub_field('section_background_image');
			
			//customize background image settings
			$customize_section_background_image = get_sub_field('customize_section_background_image');
			$section_background_repeat = get_sub_field('section_background_image_repeat');
			$section_background_size = get_sub_field('section_background_image_size');
			$section_background_position = get_sub_field('section_background_image_position');
			
		
		
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
		
		if($content_type == 'Text Highlight'):
			$pageHTML .= ' square';
		endif;
		
		//close custom class
		
		$pageHTML .= '" ';
		
		//GET STYLE OPTIONS
		
		if($section_background_color || $section_background_image || $text_color || $module_height):
		
			$pageHTML .= ' style="';
		
				if($section_background_color):
			  
					$pageHTML .= 'background-color:' . $section_background_color . ';';
				
				endif;
	
				if($section_background_image && $section_background_image !=''):
					$pageHTML .= ' background-image:url(' . $section_background_image . ');';
				endif;
		
				if($section_background_repeat):
					$pageHTML .= 'background-repeat:' . $section_background_repeat . ';';
				endif;
				
				if($section_background_size):
					$pageHTML .= 'background-size:' . $section_background_size . ';';
				endif;
				
				if($section_background_position):
				$pageHTML .= 'background-position:' . $section_background_position . ';';
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
				$pageHTML .= '</div><!--.md-text-->';
				$pageHTML .= '</div><!--.vert inner--></div><!--.vert outer-->';
			break;
			
			case 'Case Study':	
				//$pageHTML .= '<div class="home-case">';
				require(FUNCTIONS . '/mod_case_study.php');
				//$pageHTML.= '</div><!--.home-case-->';
			break;
			
			case 'Text Highlight':
				//$pageHTML .= '<div class="vert-center-outer"><div class="vert-center-inner">';
				require(FUNCTIONS . '/mod_text_highlight.php');
				//$pageHTML .= '</div><!--.vert inner--></div><!--.vert outer-->';
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
					//	$pageHTML .= '<h1>Saw a Good Idea</h1>';
						break;
					case 'rss':
						$rss_feed_name = get_sub_field('rss_feed_name');
						$pageHTML .= '<h2>' . $rss_feed_name  . '</h2>';
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
				$pageHTML .= '<div class="space" style="min-height:' . $module_height . 'px; background-color:transparent;"></div><!--.space-->';
			break;
				
				case 'Google Map':
					$google_map = get_field('google_map');
					//if( !empty($google_map) ):
					$data_lat = $google_map['lat'];
					$data_lng = $google_map['lng'];
					$zoom = $google_map['zoom'];
					
					if($data_lat == ''):
					$data_lat = 40.751543;
					endif;
					
					if($data_lng == ''):
					$data_lng = -73.982118;
					endif;
					
					if($zoom == ''):
					$zoom = 5;
					endif;
					
					$pageHTML .='<div class="google-map-ct"><div class="acf-map">';
					$pageHTML .='<div class="marker" data-lat="' . $data_lat . '" data-lng="'. $data_lng .'"></div>';
					$pageHTML .='</div></div>';
							// endif; 
				
					
					break;
					
				
			
		}//end content type switch
		
		
	
		
	
//SET UP POST SCROLLER
/*
		if($number_posts > 1):
			$pageHTML .= '<div class="dot-nav-vertical-ct">';
			$single_type_left = substr($post_type, 0, -1);
		
		for($i=0; $i< $number_posts ; $i++){
			$pageHTML .= '<div class="dot-nav" id="bt_' . $single_type_left . '_' . $i .'"></div>';
		}
		
		$pageHTML .='</div>';//ends dot-nav container
		endif;
*/				
		
//CLOSE GRID ITEM	
		$pageHTML .= '</div><!--.grid-item-->';
		//$pageHTML .= '</div><!--.grid-item-->';
		
		endwhile;//end repeater loop
		
	endif;//END REPEATER LOOP
	//$pageHTML .= '</div><!--.grid-item-->';

	$pageHTML .= '</div><!--.grid-->';
	
	$pageHTML .=  '</div><!-- .wrapper-->';
	$pageHTML .= '</div><!--.row-->';
	//$pageHTML .= '<div class="clear-fix"></div>';
		//if($grid_width == 'Yes'):
			
		//endif;\
	if($page_class):
	//$pageHTML .= '</div>';
	endif;
	
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
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&"></script>
<script type="text/javascript">
(function($) {

/*
*  new_map
*
*  This function will render a Google Map onto the selected jQuery element
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$el (jQuery element)
*  @return	n/a
*/

function new_map( $el ) {
	
	// var
	var $markers = $el.find('.marker');
	
	
	// vars
	var args = {
		zoom		: 16,
		center		: new google.maps.LatLng(0, 0),
		mapTypeId	: google.maps.MapTypeId.ROADMAP
	};
	
	
	// create map	        	
	var map = new google.maps.Map( $el[0], args);
	
	
	// add a markers reference
	map.markers = [];
	
	
	// add markers
	$markers.each(function(){
		
    	add_marker( $(this), map );
		
	});
	
	
	// center map
	center_map( map );
	
	
	// return
	return map;
	
}

/*
*  add_marker
*
*  This function will add a marker to the selected Google Map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$marker (jQuery element)
*  @param	map (Google Map object)
*  @return	n/a
*/

function add_marker( $marker, map ) {

	// var
	var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

	// create marker
	var marker = new google.maps.Marker({
		position	: latlng,
		map			: map
	});

	// add to array
	map.markers.push( marker );

	// if marker contains HTML, add it to an infoWindow
	if( $marker.html() )
	{
		// create info window
		var infowindow = new google.maps.InfoWindow({
			content		: $marker.html()
		});

		// show info window when marker is clicked
		google.maps.event.addListener(marker, 'click', function() {

			infowindow.open( map, marker );

		});
	}

}

/*
*  center_map
*
*  This function will center the map, showing all markers attached to this map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	map (Google Map object)
*  @return	n/a
*/

function center_map( map ) {

	// vars
	var bounds = new google.maps.LatLngBounds();

	// loop through all markers and create bounds
	$.each( map.markers, function( i, marker ){

		var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

		bounds.extend( latlng );

	});

	// only 1 marker?
	if( map.markers.length == 1 )
	{
		// set center of map
	    map.setCenter( bounds.getCenter() );
	    map.setZoom( 16 );
	}
	else
	{
		// fit to bounds
		map.fitBounds( bounds );
	}

}

/*
*  document ready
*
*  This function will render each map when the document is ready (page has loaded)
*
*  @type	function
*  @date	8/11/2013
*  @since	5.0.0
*
*  @param	n/a
*  @return	n/a
*/
// global var
var map = null;

$(document).ready(function(){

	$('.acf-map').each(function(){

		// create map
		map = new_map( $(this) );

	});

});

})(jQuery);
</script>
<?php get_footer(); ?>