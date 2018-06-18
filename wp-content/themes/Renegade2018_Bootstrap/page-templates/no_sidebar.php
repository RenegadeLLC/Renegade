<?php
/**
 * Template Name: Standard Page No Sidebar
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */

global $columnHTML;
global $headlineHTML;

get_header();
$container = get_field('container_width', 'option');

$pageHTML = '';

?>

<div class="wrapper" id="full-width-page-wrapper">

	<?php 

if ($container == 'Fixed Width Container'):
    $pageHTML = '<div class="container" id="content">';
elseif ($container == 'Full Width Container'):
    $pageHTML = '<div class="container" id="content">';
endif;//END CONTAINER WIDTH IF
?>

<div class="row">

			<div class="col-md-12 content-area" id="primary">

				<main class="site-main" id="main" role="main">
				
<?php 

//CHECK FOR CONTENT SECTIONS
if( have_rows('content_sections') ):

    while ( have_rows('content_sections') ) : the_row();
    
    //GET SECTION NAME
    $content_section_name = get_sub_field('content_section_name');
    //MAKE SECTION NAME LINK FRIENDLY
    $content_section_name = clean_link_name($content_section_name);
    
    $vertical_alignment = get_sub_field('vertical_alignment');
 
    $align_items = '';
    if($vertical_alignment == 'Top'):
        $align_items = 'flex-start';
    elseif($vertical_alignment == 'Bottom'):
        $align_items = 'flex-middle';
    elseif($vertical_alignment == 'Centered'):
        $align_items = 'center';
    elseif($vertical_alignment == 'Stretched'):
        $align_items = 'stretch';
    elseif($vertical_alignment == 'Baseline'):
        $align_items = 'baseline';
    endif;
    
    $add_bottom_border = get_sub_field('add_bottom_border');
    
    //CUSTOMIZE SECTION BACKGROUND
    $customize_section_background = get_sub_field('customize_section_background');
    
    if($customize_section_background == 'Yes'):
        $section_background_options = get_sub_field('section_background_options');
        $background_color = $section_background_options['background_color'];
        $background_image = $section_background_options['background_image'];
        $customize_background_image = $section_background_options['customize_background_image'];
        
        //CUSTOMIZE BACKGROUND IMAGE
        if($customize_background_image == 'Yes'):
            $background_image_repeat = $section_background_options['background_image_repeat'];
            $background_image_position = $section_background_options['background_image_position'];
            $background_image_size = $section_background_options['background_image_size'];
            
         else:
         
             $background_image_repeat = 'no-repeat';
             $background_image_position = 'center';
             $background_image_size = 'cover';
         
        endif;  //END IF CUSTOMIZE BACKGROUND IMAGE
  
        
    endif;//END IF CUSTOMIZE SECTION BACKGROUND
   
    //ADD CONTENT SECTION DIV
    $pageHTML .= '<div class="content-section"';
    //ADD A SECTION HEADLINE
    $pageHTML .= ' style="align-items:' . $align_items . '; ';
    
    if($customize_section_background == 'Yes'):
    
    
    
    //CUSTOM SECTION BACKGROUND STYLING
    
    if($background_color):
        $pageHTML .= 'background-color:' . $background_color . '; ';
    endif;
    
    if($background_image):
        $pageHTML .= 'background-image:url(' . $background_image . '); ';
    
        if($background_image_repeat):
            $pageHTML .=' background-repeat:' . $background_image_repeat . ';';
        else:
            $pageHTML .=' background-repeat:no-repeat;';
        endif;
        
        if($background_image_position):
            $pageHTML.= 'background-position:' . $background_image_position . ';';
        endif;
        
        if($background_image_size):
            $pageHTML .= ' background-size:' . $background_image_size . ';';
        endif;
        
    endif;
    
    endif;//end if customize section background
    $pageHTML .= '"';
    $pageHTML .= ' id="' . $content_section_name  . '"';
    $pageHTML .= '>';//end of div declaration
   
    $add_a_section_headline = get_sub_field('add_a_section_headline');
    
    if($add_a_section_headline == 'Yes'):
    
        require(FUNCTIONS. '/section_headline.php');
    
    endif;//END IF ADD SECTION HEADLINE

            
            $pageHTML .= $headlineHTML;
            require (FUNCTIONS. '/custom_content.php');
            
        
       
        
        //END CONTENT SECTION DIV
        $pageHTML .= '</div><!-- .content-section #' . $content_section_name . '-->';
    
        if($add_bottom_border == 'Yes'):
            $pageHTML .= '<div class="section-sep"></div>';
        endif;
   endwhile; //END CONTENT SECTIONS WHILE
    
endif; // END CONTENT SECTIONS IF

echo $pageHTML;

?>
		
				
				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row end -->

	</div><!-- Container end -->

</div><!-- Wrapper end -->


	<script type="text/javascript">

	$(document).ready(function() {
		
		  var $container = $('.client-logo-grid');
		  $container.imagesLoaded( function() {
		    $container.isotope({
		   	 percentPosition: true,
			 isFitWidth: true,
		      itemSelector: '.client-grid-item',
		      masonry: {
			      gutter: '.client-grid-gutter',
			      }
		    });
		  });
		  //lazy_load();
		});
	
	
	var $container = $('.post-feed-grid');

	//$('.post-grid').css('border' : '1px solid red');
	$(window).on('load', function () {
	    // Fire Isotope only when images are loaded
	    $container.imagesLoaded(function () {
	        $container.isotope({
	            itemSelector: '.post-item', 
	       	 	percentPosition: true,
	       		isOriginTop: true,
	   	  		layoutMode: 'packery',
	            	packery: {
	          	  // masonry: {
	      	      gutter: '.grid-gutter'
	      	      }
	           
	        });
	    });

	    // Infinite Scroll
	   /* $('.post-grid').infinitescroll({
	            navSelector: 'div.pagination',
	            nextSelector: 'div.pagination a:first',
	            itemSelector: '.grid-item',
	            bufferPx: 200,
	            loading: {
	                finishedMsg: 'We\'re done here.',
	                
	            },
	        },

	        function (newElements) {
	            var $newElems = jQuery(newElements).hide();
	            $newElems.imagesLoaded(function () {
	                $newElems.fadeIn();
	                $container.isotope('appended', $newElems);
	            });
	        });*/
	});
	$( function() {
	  
	  $('.grid4').isotope({
		 percentPosition: true,
	  layoutMode: 'packery',
	  //   layoutMode: 'masonry',
	    itemSelector: '.grid-item',
	    isOriginTop: true,
	    packery: {
	  // masonry: {
	      gutter: '.grid-gutter4'
	      }
	  });
	  
	});


	</script>
<?php get_footer(); ?>
