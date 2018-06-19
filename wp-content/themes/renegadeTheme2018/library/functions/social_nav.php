<?php


function getSocial(){
	
/****** PULL IN ANY SOCIAL ADDRESSES THAT HAVE BEEN LISTED IN THE THEME CUSTOMIZATION MENU *******/

	$facebookLink = get_theme_mod( 'facebook', '' );
	$twitterLink = get_theme_mod( 'twitter', '' );
	$instagramLink = get_theme_mod( 'instagram', '' );
	$pinterestLink = get_theme_mod( 'pinterest', '' );
	$youTubeLink = get_theme_mod( 'youTube', '' );
	$gPlusLink = get_theme_mod( 'googlePlus', '' );
	$linkedInLink = get_theme_mod( 'linkedIn', '' );
	$slideShareLink = get_theme_mod( 'slideShare', '' );
	
	
/****** CREATE AN ARRAY TO HOLD THE OPTIONS FOR SOCIAL CHANNELS *******/

	
	$socialNavOptions = array();
	
	$socialNavOptions[] = array(
	'slug'		=>'facebook', 
	'address' 	=> $facebookLink,
	'icon' 		=> '/ic_fb.png'
	);
	
	$socialNavOptions[] = array(
	'slug'		=>'twitter', 
	'address' 	=> $twitterLink,
	'icon' 		=> '/ic_twitter.png'
	);
	
	$socialNavOptions[] = array(
	'slug'		=>'instagram', 
	'address' 	=> $instagramLink,
	'icon' 		=> '/ic_in.png'
	);
	
	$socialNavOptions[] = array(
	'slug'		=>'pinterest', 
	'address' 	=> $pinterestLink,
	'icon' 		=> '/ic_pin.png'
	);
	
	$socialNavOptions[] = array(
	'slug'		=>'youtube', 
	'address' 	=> $youTubeLink,
	'icon' 		=> '/ic_yt.png'
	);
	
	$socialNavOptions[] = array(
	'slug'		=>'googlePlus', 
	'address' 	=> $gPlusLink,
	'icon' 		=> '/ic_gPlus.png'
	);
	
	
	$socialNavOptions[] = array(
	'slug'		=>'linkedIn', 
	'address' 	=> $linkedInLink,
	'icon' 		=> '/ic_li.png'
	);
	
	$socialNavOptions[] = array(
	'slug'		=>'slideShare', 
	'address' 	=> $slideShareLink,
	'icon' 		=> '/ic_ss.png'
	);
	
	
	/****** DEFINE IMAGE PATH *******/
	
	define('IMAGES', get_bloginfo('template_directory').'/images');
		
	foreach($socialNavOptions as $socialAddress){
			
			if( $socialAddress['address'] !== ''){
				echo '<a href="' .  $socialAddress['address'] . '">' . '<img border="0" src=' . IMAGES .  $socialAddress['icon'] . ' class="social_ic" target="_blank">' . '</a>';
			}
			
			
		}
	}

?>