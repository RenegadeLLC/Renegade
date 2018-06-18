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

$navArray = getNext(get_the_ID());
?>
<div class="bt-submenu"></div><div class="clearfix"></div>


<div class="sub-nav-menu-ct"><?php wp_nav_menu( array( 'theme_location' => 'people', 'menu_class' => 'sub-nav-menu' ) ); ?></div>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		
		<div class="company-page">
<div class="content-wrapper" style="background:#fff; overflow:hidden; padding-bottom:64px;">
<div class="headline-ct">
<?php 
$rp_last_name = get_the_title( $post->ID );
$rp_first_name = get_field('rp_first_name');
$rp_job_title = get_field('rp_job_title');

echo('<h1>' . $rp_first_name . ' ' . $rp_last_name . ', </h1>');
echo('<h2>{' . $rp_job_title  .  '}</h2>');
?>

</div><!-- .headline-ct  -->
<?php 
if($navArray[0]!='0'){
	echo('<div class="prev-arrow square"><a href="' . $navArray[3] . '"><div class="prev-arrow-inner"></div></a></div>');
}
?><?php 

if($navArray[0]<$navArray[2]){
	echo('<div class="next-arrow square"><a href="' . $navArray[1] . '"><div class="next-arrow-inner"></div></a></div>');
}

?>
<div class="person-ct content-diag">
<div class="person-content-ct">

<?php 

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
		
		$rp_contact_link = get_field('rp_contact_link');
		
		
		$people_html = '';
		
		switch ($rp_social_channel){
			
			case "Twitter":
				$rp_social_icon= 'social-twitter';
				break;
				
			case "Facebook":
				$rp_social_icon= 'social-facebook';
				break;
					
			case "Pinterest":
				$rp_social_icon= 'social-pinterest';
				break;
				
			case "Instagram":
				$rp_social_icon= 'social-instagram';
				break;
				
			case "LinkedIn":
					$rp_social_icon= 'social-linkedIn';
					break;		
		}
		

		$people_html .= '<div style="width:100%; max-width:996px; padding:0px 32px 32px 32px; background:#fff; overflow:hidden;">';
		//$people_html .= '<div class="people-left-col">';
		
		//MAIN BIO IMAGE
		$people_html .= '<div class="people-bio-image-ct"><div class="people-bio-image">' .  wp_get_attachment_image($rp_bio_image, $rp_size ) . '</div></div>';
		
		//FUN FACT
		$people_html .= '<div class="people-fun-fact-ct"><div class="people-fun-box-inner square" style="background:url(' . $rp_fun_fact_image . ') no-repeat #c3bd06; background-size: 100% 100%;"><div class="people-fun-box-text">' .  $rp_fun_fact . '</div><div class="people-contact-link"><div class="block-text">'. $rp_contact_link .'</div></div></div></div>';
		
		//END FIRST ROW CONTAINER
		$people_html .= '</div>';
		
		$people_html .= '<div style="display:block; position:relative; overflow:hidden; z-index:999; margin:-32px 0 0 0;">';
		
		//SECOND ROW LEFT COLUMN CONTAINER
		$people_html .= '<div style="float:left; width:50%; max-width:498px; padding:0px 0px 32px 32px; background:#fff; overflow:hidden; margin:32px 0 0 0;">';
		
		$people_html .= '<div class="people-bio-intro">'. $rp_bio_intro . '<div class="dec-short"></div></div>';
		$people_html .= '<div class="people-bio-text-ct"><div class="people-bio-text">' . $rp_biography . '</div></div>';
		
		//END SECOND ROW LEFT COLUMN CONTAINER
		$people_html .= '</div>';
		
		//SECOND ROW RIGHT COLUMN CONTAINER
		$people_html .= '<div style="width:50%; max-width:498px; padding:0px; overflow:hidden; float:right;">';
		
		if($rp_social_channel_url){
			
		
		$people_html .= '<div class="people-social-ct"><div class="people-social-line"></div><a href="'. $rp_social_channel_url . '" target="_blank"><div class="people-social ' . $rp_social_icon . '"><div class="people-social-name">Follow<br>'. $rp_first_name .'</a></div></div></div>';
		}
		
		if($rp_random_image){
		$people_html .= '<div class="people-random-image-ct"><img src="'. $rp_random_image .'"></div></div></div>';
		}
		//END SECOND ROW RIGHT COLUMN CONTAINER
		$people_html .= '</div></div>';
		
		//$people_html .= '<div class="people-bio-text-ct"><div class="people-bio-text">' . $rp_biography . '</div></div></div>';
		
		//$people_html .= '<div class="people-right-col">';
		
		
		

		//$people_html .= '<div class="people-random-image-ct"> <img src="'. $rp_random_image .'"></div></div></div>';
		echo $people_html;
		
		?>
		</div>
		</div><!-- .content-wrapper -->

<!-- .company-page -->
		
</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
