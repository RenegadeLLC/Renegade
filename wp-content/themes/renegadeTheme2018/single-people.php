<?php
/**
 * The template for displaying all single posts.
 *
 * @package Renegade
 */

get_header(); 
global $navArray;
global $people_urls;
function getNext($page_id){

	$people_menu = 'people';
	
	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $people_menu ] ) ) {

		$people_menu_list = wp_get_nav_menu_object( $locations[ $people_menu ] );
		$people_menu_items = wp_get_nav_menu_items($people_menu_list->term_id);
		$people_urls;
		foreach ( (array) $people_menu_items as $key => $menu_item ) {
			$people_order[] = get_post_meta( $menu_item->ID, '_menu_item_object_id', true );
			$thisPage = get_post_meta( $menu_item->ID, '_menu_item_object_id', true );
			$people_urls[] = get_permalink( $thisPage);
			
		}
/*
		$thisPerson =  array_search($page_id, $people_order);
		$nextPerson =  intval(array_search($page_id, $people_order) + 1);
		$lastPerson =  intval(array_search($page_id, $people_order) - 1);
		
		echo('last person ' . $last_person);
		$next_url = ($people_urls[$nextPerson]);
		$last_url = ($people_urls[$lastPerson]);
		
		$numPeople = count($people_urls);
		$numPeople --;

		$navArray = array($thisPerson, $next_url, $numPeople, $last_url);
*/
	}
	
	//return $navArray;
}

$navArray = getNext(get_the_ID());

$people_html = '';

$headline_background_color = get_field('headline_background_color');
$rp_last_name = get_the_title( $post->ID );
$rp_first_name = get_field('rp_first_name');
$rp_job_title = get_field('rp_job_title');
$rp_bio_image = get_field('rp_bio_image');
$rp_size = "full";
$rp_social_channel = get_field('rp_social_channel');
$rp_social_icon;
$rp_social_channel_url = get_field('rp_social_channel_url');
$rp_bio_intro = get_field('rp_bio_intro');
$rp_biography = get_field('rp_biography');
$rp_fun_fact = get_field('rp_fun_fact');
$rp_fun_fact_image = get_field('rp_fun_fact_image');
$rp_random_image = get_field('rp_random_image');
$rp_email_address = get_field('rp_email_address');
$rp_contact_link = get_field('rp_contact_link');


$people_html .= '<div id="primary" class="content-area">';
$people_html .= '<main id="main" class="site-main" role="main"><div class="people">';
$people_html .='<div class="outer-wrapper" style="background-color:#000;">';
$people_html .= '<div class="company person">';
//$people_html .= '<div style="display:block; position:relative; overflow:hidden; background:#E6E7E8; height:100%; width:100%;">';
//$people_html .= '<div class = "page-top"></div>';
$people_html .= '<div class="wrapper">';
//$people_html .= '<div class="headline-ct"><h1>' . $rp_first_name . ' ' . $rp_last_name . '<span class="light-serif gray"> - ' . $rp_job_title  . '</span></h1><a href="#submenu"><div class="bt-submenu"></div></a>';
$people_html .= '<div class="headline-ct"><h1 class="white text-center">' . $rp_first_name . ' ' . $rp_last_name . '<span class="light-serif gray"> - ' . $rp_job_title  . '</span></h1>';
//$people_html .= '<a href="#submenu" id="bt-submenu"><div class="bt-submenu"></div></a>';
//$people_html .= '<nav class="sub-nav-menu-ct" id="submenu">' . wp_nav_menu( array( 'menu' => 'people','theme_location' => 'people', 'menu_class' => 'sub-nav-menu' ) ) . '</nav>';


$people_html .= '</div><!-- .headline-ct  -->';

if($navArray[0]!='0'){
	//echo('<div class="prev-arrow square"><a href="' . $navArray[3] . '"><div class="prev-arrow-inner"></div></a></div>');
}

$people_html .= '<div class="person-content-ct">';	
		
		switch ($rp_social_channel){
			
			case "Twitter":
				$rp_social_icon= 'bio-twitter';
				break;
				
			case "Facebook":
				$rp_social_icon= 'bio-facebook';
				break;
					
			case "Pinterest":
				$rp_social_icon= 'bio-pinterest';
				break;
				
			case "Instagram":
				$rp_social_icon= 'bio-instagram';
				break;
				
			case "LinkedIn":
				$rp_social_icon= 'bio-linkedIn';
				break;		
		}
		
		

		//$people_html .= '<div style="width:100%; padding:0px 32px 32px 32px; background:#fff; overflow:hidden;">';
		//$people_html .= '<div class="people-left-col">';
		
		$people_html .= '<div class="grid grid-g-0" style="background-color:#000;"><div class="grid-gutter"></div>';
		
		//MAIN BIO IMAGE
	//	$people_html .= '<div class="people-bio-image-ct grid-item grid-item-w-50"><div class="people-bio-image">' .  wp_get_attachment_image($rp_bio_image, $rp_size ) . '</div></div>';
		$people_html .= '<div class="people-bio-image-ct grid-item grid-item-w-50"><div class="people-bio-image"><img src="' . $rp_bio_image . '" alt="' .  $rp_first_name . ' ' . $rp_last_name .'"></div></div>';
		
		//CONTACT BOX
		$people_html .= '<div class="contact-box-outer grid-item grid-item-w-25 square"><div class="vert-center-outer"><div class="vert-center-inner"><div class="circle"><a href="mailto:' .  $rp_email_address . '"><div class="vert-center-outer"><div class="vert-center-inner email">Contact<span class="mobile-hide">'. $rp_first_name . '</span></div></div></a></div></div></div></div>';
		
		//EMPTY BOX
		$people_html .= '<div class="grid-item grid-item-w-25 square mobile-hide"><div class="corner-saw"></div></div>';
		//FUN FACT
		$people_html .= '<div class="grid-item grid-item-w-25 fact-box-outer square"><div class="people-fun-box-inner square" style="background:url(' . $rp_fun_fact_image . ') no-repeat #c3bd06; background-size: cover;"></div></div>';
		
		//FOLLOW BOX
		$people_html .= '<div class="follow-box-outer grid-item grid-item-w-25 square"><div class="vert-center-outer"><div class="vert-center-inner">';
		
		if(!$rp_social_channel_url):
			
			$people_html .= '<div class="saw-back"></div>';
		
		else:
			$people_html .= '<div class="circle"><div class="vert-center-outer"><div class="vert-center-inner">';
			$people_html .= '<a href="'. $rp_social_channel_url . '" target="_blank"><div class="people-social-ct"><div class="people-social ' . $rp_social_icon . '"><div class="people-social-name">Follow<span class="mobile-hide"> '. $rp_first_name .'</span></div></div></div></a>';
		endif;
			
		$people_html .= '</div></div></div></div></div></div></div></div></div></div>';
		$people_html .='<div class="outer-wrapper" style="background-color:#E6E7E8;">';
		$people_html .= '<div class="wrapper">';
		$people_html .= '<div class="grid grid-g-0"><div class="grid-gutter"></div>';
		
		$people_html .= '<div class="bio-outer grid-item grid-item-w-75b"><div class="people-bio-intro intro">'. $rp_bio_intro . '</div></div>';
		
		if($rp_random_image){
			$people_html .= '<div class="grid-item grid-item-w-25 mobile-hide"><div class="random-image-outer"><img src="'. $rp_random_image .'"></div></div>';
		}
		
		$people_html .= '<div class="bio-outer grid-item grid-item-w-75b"><div class=" mobile-show"><img src="'. $rp_random_image .'"></div><div class="people-bio-text">' . $rp_biography . '</div></div></div>';
		$people_html .= '</div></div></div><!--.people -->';
		echo $people_html;
		
?>
		</div>
<?php 
		if($navArray[0]<$navArray[2]){
			//echo('<div class="next-arrow square"><a href="' . $navArray[1] . '"><div class="next-arrow-inner"></div></a></div>');
		}
?>
</div><!-- .content-wrapper -->

<!-- .company-page -->
	
			<div class="submenu-toggle"><a href="#submenu-people"><div class="bt-submenu-people"></div></a><div class="sub-nav-menu-ct" id="submenu-people"><?php wp_nav_menu( array( 'menu' => 'people', 'theme_location' => 'people', 'menu_class' => 'sub-nav-menu' , 'before' => '<span>', 'after' => '</span>') ); ?></div></div>
			
</div>
		</main><!-- #main -->
	</div><!-- #primary -->
<script type="text/javascript">

	$( function() {
		  
		  $('.grid-g-0').isotope({
			percentPosition: true,
		  	layoutMode: 'packery',
		  //	columnWidth: '100%',
		  //   layoutMode: 'masonry',
		    itemSelector: '.grid-item',
		    packery: {
		  // masonry: {
		     gutter: '.grid-gutter'
		    	  //  gutter: 2
		      }
		  });//end isotope

		<!-- render grid when images have loaded -->
	  
	  imagesLoaded( '.grid-g-0', function() {
			$('.grid-g-0').isotope('layout');
	  });

	  
	});//end doc ready
		
</script>

	<script type="text/javascript">
	$(document).ready(function(){

		$(function() {
			$('#submenu-people').mmenu({
				navbar 		: {
					title		: 'Leadership',
				},
				isMenu: true,
				dragOpen: true,
				slidingSubmenus: true,
				//setSelected, true,
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
		              fixedTop: "header-ct",
		              // fixedBottom: "footer"
		            },
		            onClick: {
		            	setSelected: true,
		            	close: true
		            }

		         //   panelNodetype: "div"
		           
		         }
				});
		});
	});
		</script>
<?php get_footer(); ?>
