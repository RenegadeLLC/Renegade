<?php
/**
 * Theme Header
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Renegade
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php 
$google_analytics_code = get_field('google_analytics_code', 'option');

echo($google_analytics_code);
	?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<meta property="og:image" content="http://renegade.com/wp-content/uploads/saw_400_green.png"/>

<meta name="description" content="Helping CMOs Cut Through" /><!--formatted-->

<?php wp_head(); ?>
<!--[if lt IE 9]>
<script>
document.createElement('header');
document.createElement('nav');
document.createElement('section');
document.createElement('article');
document.createElement('aside');
document.createElement('footer');
document.createElement('hgroup');
</script>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
<![endif]-->

<script type="text/javascript">


$(document).ready(function(){

	$(function() {
		$('#submenu-main').mmenu({
			navbar 		: {
				title		: '',
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
	});

});
</script>

</head>

<body <?php body_class(); 
?>>

<?php 	$phone_number = get_field('phone_number', 'option');
	$include_search = get_field('include_search', 'option')
	?>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'ad' ); ?></a>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'ad' ); ?></a>


<div class="wrapper">
	
	<header id="masthead" class="site-header" role="banner">

	<div class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo bloginfo('template_url'); ?>/library/images/renegadeLogo.png"></a></div><!-- .logo -->
	
	<div class="nav-ct">
	
		<div class="utility-nav-ct">
			<!-- <div class="utility-nav" id="bt-phone"></div>-->
		<div id="phone-panel"><a href="tel:+1<?php echo($phone_number); ?>"><div class="utility-panel-inner" id="phone-panel-inner"><?php echo($phone_number); ?>
		</div></a></div>	
	<!--	<div class="utility-nav" id="bt-links"></div>-->
		<div id="links-panel" class="utility-panel header-social-icons-ct">
		<div class="utility-panel-inner" id="links-panel-inner">
	<?php 
	$header_options = get_field('header_social_channels', 'option');
	$socialHTML = '';
	
	foreach($header_options as $option){
	$social_channel_link = '';
	$social_class = '';
	
	switch($option){
				
			case 'Facebook':
				$social_channel_link = get_field('facebook_url', 'option');
				$social_class = 'social-facebook';
			break;
			
			case 'Twitter':
				$social_channel_link = get_field('twitter_url', 'option');
				$social_class = 'social-twitter';
			break;
			
			case 'Instagram':
				$social_channel_link = get_field('instagram_url', 'option');
				$social_class = 'social-instagram';
			break;
					
			case 'YouTube':
				$social_channel_link = get_field('youtube_url', 'option');
				$social_class = 'social-youtube';
			break;
			
			case 'LinkedIn':
				$social_channel_link = get_field('linkedin_url', 'option');
				$social_class = 'social-linkedin';
				break;
					
			case 'Pinterest':
				$social_channel_link = get_field('pinterest_url', 'option');
				$social_class = 'social-pinterest';
			break;
			
			case 'GooglePlus':
				$social_channel_link = get_field('googleplus_url', 'option');
				$social_class = 'social-googleplus';
			break;
			
			case 'SlideShare':
				$social_channel_link = get_field('slideshare_url', 'option');
				$social_class = 'social-slideshare';
			break;
							
		}//end switch
	
		if( in_array($option, $header_options) ) {
			
			$socialHTML .= ' <a href="' . $social_channel_link . '" target="_blank" ><div class="' . $social_class . ' header-social-icons"></div></a>';
			//$headerHTML .= '<a href="' . $social_channel_link . '" target="_blank"><div class="social-facebook header-social-icons"></div></a>';
		}//end if
	}//end foreach
	echo ($socialHTML);
	

?>
	</div></div>
	<?php 
		if($include_search == 'Yes'):
		?>
		<!--<div class="utility-nav" id="bt-search"></div>
		  <div id="search-panel" class="utility-panel"><div class="utility-panel-inner" id="search-inner-panel"></div></div>-->
		<?php endif;?>
		</div><!-- .utility-nav-ct -->
	
		<nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
	
		<?php wp_nav_menu( array('menu' => 'primary', 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
		</nav>	
		
		
	</div><!-- .nav-ct -->
<div class="menu-toggle"><a href="#submenu-main"><div class="bt-submenu-main"></div></a><div class="sub-nav-menu-ct" id="submenu-main"><?php wp_nav_menu( array( 'menu' => 'mobile', 'theme_location' => 'mobile', 'menu_class' => 'sub-nav-menu' , 'before' => '<span>', 'after' => '</span>') ); ?></div>
	</header><!-- #masthead -->
	<!--  <div class="topDiag"></div>-->
	</div><!-- .content-wrapper -->

	<div id="content" class="site-content">