<?php
/**
 * Template Name: Clients Page Template
 *
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2015
 */

get_header(); ?>

<?php

	$pageTopHTML = require_once (FUNCTIONS . '/standard_page_top.php');
//QUERY PROJECT POST TYPES FOR LOGO GRID
	$workHTML = '';
	$workHTML.=$pageTopHTML;


	$logo_grid_header = get_field('logo_grid_header');
	$logo_grid_subheader = get_field('logo_grid_subheader');
	$body_wrapper_color = get_field('body_wrapper_color');
	$body_background_color = get_field('body_background_color');
	$body_copy = get_field('body_copy');
	$intro_image = get_field('intro_image');
	
	$workHTML .= '<div class="outer-wrapper" style="background-color:' . $body_wrapper_color . ';">';
	$workHTML .= '<div class="wrapper" style="background:';
	$workHTML .= $body_background_color  .';"><div class="clients-body-ct">';
	$workHTML .= '<div class="clients-text-ct"><div class="clients-text">' . $body_copy . '</div></div>';
	$workHTML .= '<div class="clients-image-ct" style="background-image:url(' . $intro_image . '); background-position: bottom right;"><img src="' . $intro_image . '"></div>';	
	$workHTML .= '<div class="clients-grid-header-bk"></div>';
	$workHTML .= '<div class="clients-grid-header">';
	$workHTML .= '<div class="saw-ct-64" style="background-color:' . $intro_background_color  . ';"></div>';

	
	$workHTML .='<h3 class="text-center" style="color:' . $intro_background_color. ';">' . $logo_grid_header  . '</h3>';
	$workHTML .='<h4 class="text-center">'. $logo_grid_subheader . '</h4>';
	$workHTML .= '</div>';//clients grid header
//	$workHTML .= '</div><!-- .wrapper -->';
	$workHTML .= '</div></div>';
	
	
//QUERY CLIENTS POST TYPES FOR LOGO GRID
	//$workHTML .= '<div class="logos-ct">';
	$workHTML .= '<div class="wrapper" style="background:#fff;">';
	$workHTML .= '<div class="client-logo-grid" style="background-color:#fff;"><div class="client-grid-gutter"></div>';
	
	$rc_args = array( 'post_type' => 'clients', 'posts_per_page' => -1 , 'orderby' => 'menu_order', 'meta_key' => $meta_key, 'order' => 'ASC');
	$rc_loop = new WP_Query( $rc_args );

		while ( $rc_loop->have_posts() ) : $rc_loop->the_post();
			$client_name = get_the_title();
			$client_id = get_the_ID();
			$client_logo = get_field('clientLogo');
			$industry_vertical = get_field('industry_vertical');
			$case_study = get_field('case_study');
			$case_study_url = get_field('case_study_url');
			//$industry_vertical_name = $industry_vertical -> name;
				if($client_name != 'Renegade'):
					$workHTML .= '<div class="client-logo-ct circ client-grid-item client-grid-item-w-25 ';
				//	$workHTML .= $industry_vertical;
					$workHTML .= '">';
					
						if($case_study == 'Yes'):
							$workHTML .= '<a href="' . $case_study_url . '">';
						endif;
						
					$workHTML .= '<div class="client-logo-border"></div><div class="client-logo"><img src="' . $client_logo . '" alt=""></div></div>';
						
						if($case_study == 'Yes'):
							$workHTML .= '</a>';
						endif;
					endif;
			endwhile;
		
	$workHTML .= '</div>';//end grid
	$workHTML .= '</div><!-- .wrapper -->';
	$workHTML .= '</div>';//end left col

//	$workHTML .= '<div class="utility-box">';
//	$workHTML .= '<h3>Filter Clients By:</h3>Industry Vertical<p>Service Type';
	//$workHTML .= '</div>';//end utility-box

	//$workHTML .= '</div>';//end wrapper
	
echo $workHTML;

?>

</div><!-- .wrapper -->
</div><!-- .work -->
	<script type="text/javascript">
	/*$( function() {
	  
	  $('.client-logo-grid').masonry({
		 percentPosition: true,
		 isFitWidth: true,
		 // layoutMode: 'packery',
		 // layoutMode: 'masonry',
	    itemSelector: '.client-grid-item',
	//    packery: {
		masonry: {
	      gutter: '.case-grid-gutter',
	      }
	  });

	  imagesLoaded( '.client-logo-grid', function() {
			$('.client-logo-grid').masonry('layout');
			//var $logo_names = $('.grid-item');
			//TweenLite.to($logo_names, 2, {opacity:1, ease:Power2.easeOut, delay:1.5});
			
			  });
	  
	  
	});*/
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
		  lazy_load();
		});
	


	//$.noConflict();
	function lazy_load(){


		
		$(".lazy").bttrlazyloading({
			
			xs: {
			//	src: "img/720x200.gif",
				//width: 200,
				//height: 267
			},
			sm: {
			//	src: "img/360x200.gif",
				width: 378,
				height: 518
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
			placeholder:'<?php echo(get_template_directory_uri() . '/library/images/loading.gif');?>',
			backgroundcolor: '#ffffff'
			
		})
		}
	

</script>
<?php get_footer(); ?>