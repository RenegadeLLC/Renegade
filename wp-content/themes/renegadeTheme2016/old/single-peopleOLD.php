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
			//$people_urls[] = get_post_meta( $menu_item->ID, 'url');
			$people_urls[] = get_permalink( $thisPage);
			
		}

		$thisPerson =  array_search($page_id, $people_order);
		$nextPerson =  intval(array_search($page_id, $people_order) + 1);
		$lastPerson =  intval(array_search($page_id, $people_order) - 1);
		
		
		$next_url = ($people_urls[$nextPerson]);
		$last_url = ($people_urls[$lastPerson]);
		
	//	echo($nextPerson);
		//return ($person_urls);
		$numPeople = count($people_urls);
		$numPeople --;
		//echo $numPeople;
		$navArray = array($thisPerson, $next_url, $numPeople, $last_url);
		//$navArray($person_url, $numPeople);
		//return $navArray;
		
		//return ('num is ' . $numPeople);
	}
	
	return $navArray;
	//var_dump($person_urls);
	//return $person_url;
	//print_r ($person_url, true);
}
//$rp_order = getNext(get_the_ID());
//
$navArray = getNext(get_the_ID());
?>

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
<div class="bt-submenu"></div><div class="clearfix"></div>


<div class="sub-nav-menu-ct"><?php wp_nav_menu( array( 'theme_location' => 'people', 'menu_class' => 'sub-nav-menu' ) ); ?></div>
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
		$rp_biography = get_field('rp_biography');
		//$the_order= get_post_meta( get_the_ID(), 'field_545fa9fb2a8bf', true );
		
		$rp_random_image = get_field('rp_random_image');
		
		//$the_order=get_post_meta(get_the_ID(), 'menu_order', true);
		//$the_order=get_post_meta(get_the_ID(), 'rp_order', true);
		
		$people_html = '';
		
		switch ($rp_social_channel){
			
			case "Twitter":
				//$rp_social_icon = (IMAGES. '/shortcode_loader.php');
				$rp_social_icon= 'social-twitter';
				break;
				
			case "Facebook":
				//$rp_social_icon = (IMAGES. '/shortcode_loader.php');
				$rp_social_icon= 'social-facebook';
				break;
					
			case "Pinterest":
				//$rp_social_icon = (IMAGES. '/shortcode_loader.php');
				$rp_social_icon= 'social-pinterest';
				break;
				
			case "Instagram":
				//$rp_social_icon = (IMAGES. '/shortcode_loader.php');
				$rp_social_icon= 'social-instagram';
				break;
				
			case "LinkedIn":
					//$rp_social_icon = (IMAGES. '/shortcode_loader.php');
					$rp_social_icon= 'social-linkedIn';
					break;		
		}
		

		$people_html .= '<div class="people-left-col">';
		//var_dump($people_urls);
		$people_html .= '<div class="people-bio-image">' .  wp_get_attachment_image($rp_bio_image, $rp_size ) . '</div>';
		
		//$people_html .= '<div class="people-title-box"><div class="people-title-box-inner"><div class="people-name">' . $rp_first_name . ' ' . $rp_last_name . '</div>';
		//$people_html .= '<div class="people-title">' . $rp_job_title . '</div><a href="'. $rp_social_channel_url . '" target="_blank"><div class="people-social ' . $rp_social_icon . '"><div class="people-social-name">Follow<br>'. $rp_first_name .'</a></div></div></div></div><!--.people-title-box -->';
		$people_html .= '<div class="people-bio-text-ct"><div class="people-bio-text">' . $rp_biography . '</div></div></div>';
		
		$people_html .= '<div class="people-right-col">';
		$rp_fun_fact = get_field('rp_fun_fact');
		$rp_fun_fact_image = get_field('rp_fun_fact_image');
		
		$people_html .= '<div class="people-fun-fact-ct"><div class="people-fun-box-inner square" style="background:url(' . $rp_fun_fact_image . ') no-repeat #c3bd06;"><div class="people-fun-box-text">' .  $rp_fun_fact . '</div></div></div>';
		//$people_html .= '<div class="people-fun-fact-image-ct"><div class="fun-fact-image">'.  wp_get_attachment_image($rp_fun_fact_image, $rp_size ). '</div></div>';
		//echo $numPeople;
		$people_html .= '<div class="people-random-image-ct"> <img src="'. $rp_random_image .'"></div></div></div>';
		echo $people_html;
		
		?>
		</div>
		</div><!-- .content-wrapper -->

<!-- .company-page -->
		
</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
