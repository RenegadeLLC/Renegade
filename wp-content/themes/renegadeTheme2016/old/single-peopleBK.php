<?php
/**
 * The template for displaying all single posts.
 *
 * @package Renegade
 */

get_header(); 
global $navArray;
global $people_urls;

$args = array(
		'theme_location'  => 'people',
		'menu'            => 'people',
		//'container'       => 'div',
		//'container_class' => '',
		'container_id'    => '',
		'menu_class'      => 'subnav-menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
);

$menu = wp_nav_menu( $args);



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

		$thisPerson =  array_search($page_id, $people_order);
		$nextPerson =  intval(array_search($page_id, $people_order) + 1);
		$lastPerson =  intval(array_search($page_id, $people_order) - 1);


		$next_url = ($people_urls[$nextPerson]);
		$last_url = ($people_urls[$lastPerson]);

		$numPeople = count($people_urls);
		$numPeople --;

		$navArray = array($thisPerson, $next_url, $numPeople, $last_url);

	}

	return $navArray;
}

//$navArray = getNext(get_the_ID());



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
//$people_menu = 
$people_html = '';
$people_html .= '<div id="primary" class="content-area">';
$people_html .= '<main id="main" class="site-main" role="main">';
		
$people_html .= '<div class="company person">';
$people_html .= '<div style="display:block; position:relative; overflow:hidden; background:#E6E7E8; height:100%; width:100%;">';
$people_html .= '<div style="background-color:#000; width:100%; height:740px; position:absolute;"></div>';
$people_html .= '<div class="wrapper">';
$people_html .= '<div class="headline-ct">';
$people_html .= '<h1>' . $rp_first_name . ' ' . $rp_last_name . '<span class="light-serif gray"> - ' . $rp_job_title  . '</span></h1>';

//$people_html .= '<a href="#submenu"><div class="bt-submenu"></div></a><div class="sub-nav-menu-ct" id="submenu">' . wp_nav_menu( array( 'menu' => 'work','theme_location' => 'people', 'menu_class' => 'sub-nav-menu' ) ) . '</div></a>';
$people_html .= '<a href="#submenu"><div class="bt-submenu"></div></a><div class="sub-nav-menu-ct" id="submenu">';
$people_html .= $menu;
		//$people_html .=  '</div></a>';
		
$people_menu_html ='';


//$people_html .= $people_menu_html;
$people_html .= '</div>';

$people_html .= '</div><!-- .headline-ct  --><div class="person-ct">';

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
		
		
		//$people_html .=  '<div class="sub-nav-menu-ct" id="submenu"><a href="#submenu"><div class="bt-submenu"></div></a><div class="sub-nav-menu-ct" id="submenu">';
		//wp_nav_menu( array( 'menu' => 'people','theme_location' => 'people', 'menu_class' => 'sub-nav-menu' ) );
		//$people_html .= '<div class="clearfix"></div></div>';

		//$people_html .= '<div style="width:100%; padding:0px 32px 32px 32px; background:#fff; overflow:hidden;">';
		//$people_html .= '<div class="people-left-col">';
		
		
		$people_html .= '<div class="grid"><div class="grid-gutter"></div>';
		
		//MAIN BIO IMAGE
		$people_html .= '<div class="people-bio-image-ct grid-item" style="width:51%; max-width:600px;"><div class="people-bio-image">' .  wp_get_attachment_image($rp_bio_image, $rp_size ) . '</div></div>';
		
		//CONTACT BOX
		$people_html .= '<div class="contact-box-outer grid-item grid-item-w-25 square"><div class="vert-center-outer"><div class="vert-center-inner"><div class="circle"><div class="vert-center-outer"><div class="vert-center-inner email"><a href="mailto:' .  $rp_email_address . '">Contact '. $rp_first_name . '</a></div></div></div></div></div></div>';
		
		//EMPTY BOX
		$people_html .= '<div class="grid-item grid-item-w-25 square"><div class="corner-saw"></div></div>';
		//FUN FACT
		$people_html .= '<div class="grid-item grid-item-w-25 people-fun-fact-ct"><div class="people-fun-box-inner square" style="background:url(' . $rp_fun_fact_image . ') no-repeat #c3bd06; background-size: 100% 100%;"></div></div>';
		
		//FOLLOW BOX
		$people_html .= '<div class="follow-box-outer grid-item grid-item-w-25 square"><div class="vert-center-outer"><div class="vert-center-inner">';
		
		if(!$rp_social_channel_url):
			
		$people_html .= '<div class="saw-back"></div>';
		
		else:
		$people_html .= '<div class="circle"><div class="vert-center-outer"><div class="vert-center-inner">';
				$people_html .= '<div class="people-social-ct"><div class="people-social ' . $rp_social_icon . '"><a href="'. $rp_social_channel_url . '" target="_blank"><div class="people-social-name">Follow '. $rp_first_name .'</a></div></div></div>';
		endif;
			
		$people_html .= '</div></div></div></div></div></div>';
		
		//END FIRST ROW CONTAINER
		//$people_html .= '</div>';
	//	<div class="people-fun-box-text">' .  $rp_fun_fact . '</div>
	//	$people_html .= '<div style="display:block; position:relative; overflow:hidden; z-index:999; background:#fff;">';
		
		//SECOND ROW LEFT COLUMN CONTAINER
		//$people_html .= '<div style="float:left; width:75%; padding:0px 0px 32px 32px; background:#fff; border-right:1px dotted #dedede; overflow:hidden;">';
		
		$people_html .= '<div class="bio-outer grid-item grid-item-w-67"><div class="people-bio-intro   intro">'. $rp_bio_intro . '</div></div>';
		
		if($rp_random_image){
			$people_html .= '<div class="grid-item grid-item-w-33"><div class="people-random-image-ct"><img src="'. $rp_random_image .'"></div></div>';
		}
		
		$people_html .= '<div class="bio-outer grid-item grid-item-w-67"><div class="people-bio-text-ct"><div class="people-bio-text">' . $rp_biography . '</div></div></div>';
		
		//END SECOND ROW LEFT COLUMN CONTAINER
	//	$people_html .= '</div>';
		
		//SECOND ROW RIGHT COLUMN CONTAINER
		//$people_html .= '<div style="width:25%; padding:0px; overflow:hidden; float:right; background:#fff;">';
		
		
		
	
		//END SECOND ROW RIGHT COLUMN CONTAINER
		//$people_html .= '</div></div>';
		
		//$people_html .= '<div class="people-bio-text-ct"><div class="people-bio-text">' . $rp_biography . '</div></div></div>';
		
		//$people_html .= '<div class="people-right-col">';
		
		
		

		//$people_html .= '<div class="people-random-image-ct"> <img src="'. $rp_random_image .'"></div></div></div>';
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
		
</div>
		</main><!-- #main -->
	</div><!-- #primary -->
<script type="text/javascript">

	$( function() {
		  
		  $('.grid').isotope({
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
	  
	  imagesLoaded( '.grid', function() {
			$('.grid').isotope('layout');
	  });

	  
	});//end doc ready
		
</script>
<?php get_footer(); ?>
