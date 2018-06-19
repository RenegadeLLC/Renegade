<?php
/**
 * Template Name: People Page Template
 *
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2015
 */

get_header();



//QUERY PEOPLE POST TYPES FOR GRID
	$pageTopHTML = require_once (FUNCTIONS . '/standard_page_top.php');
//QUERY PROJECT POST TYPES FOR LOGO GRID
	$workHTML = '';
	$workHTML.=$pageTopHTML;
	$workHTML .= '<div class="wrapper"><div class="grid-g-w-0 grid cases-grid"><div class="grid-gutter"></div>';
	
	$rp_args = array( 'post_type' => 'people', 'posts_per_page' => -1 , 'orderby' => 'meta_value', 'meta_key' => $meta_key, 'order' => 'ASC');
	$rp_loop = new WP_Query( $rp_args );
			while ( $rp_loop->have_posts() ) : $rp_loop->the_post();
			$person_id = get_the_ID();
			$person_link = get_post_permalink( $person_id );
			$person_image = get_field('case_image');
			$first_name = get_field('rp_first_name');
			$person_thumbnail_image = get_field('rp_bio_image');
			$industry_vertical = get_field('industry_vertical');
			$workHTML .= '<div class="case-image-ct circ grid-item grid-item-w-33 ';
			$workHTML .= '"><div class="case-image">';
			if($first_name != 'Pinky'):
				$workHTML .= '<a href="' . $person_link . '">';
			endif;
			$workHTML .= '<img src="';
			$workHTML .= $person_thumbnail_image;
			//$size;
			//$attr;
			//$icon = false;
			//$workHTML .= wp_get_attachment_image ($person_thumbnail_image , $size = 'thumbnail',  $icon,  $attr = '' );
			$workHTML .='" alt="' . $person_id .'" class="lazy">';
			if($first_name != 'Pinky'):
				$workHTML .= '</a>';
			endif;
			$workHTML .= '</div></div>';
		endwhile;
		
	$workHTML .= '</div>';//end grid
	$workHTML .= '</div>';//end left col
	
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
	    itemSelector: '.case-grid-item',
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
		  var $container = $('.grid');
		  $container.imagesLoaded( function() {
		    $container.isotope({
		   	 percentPosition: true,
			 isFitWidth: true,
		      itemSelector: '.grid-item',
		      masonry: {
			      gutter: '.grid-gutter',
			      }
		    });

		    
		  });
		  $('.grid').imagesLoaded( function() {
			  $('.grid').masonry('layout');
			});
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

<script type="text/javascript">
		/*	$(function() {
				var $menu = $('#submenu'),
				$html = $('html, body'),
				$num;
				$menu.mmenu({
					navbar 		: {
						title		: 'WORK',
					},
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
				         divider: 'menu-item',

				      //   panel: 'site-content',
			            fixedElements: {
			              //fixedTop: "header-ct",
			              // fixedBottom: "footer"
			            },
			            onClick: {
			            	setSelected: true,
			            	close: true
			            }

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
		*/</script>
<?php get_footer(); ?>