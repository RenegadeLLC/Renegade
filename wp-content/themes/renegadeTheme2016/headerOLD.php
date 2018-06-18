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
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

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
   $("p").savetheorphans({
        orphansToSave: 1
    });
   
    $("h1").savetheorphans({
        orphansToSave: 1
    });


    $(".home h1").savetheorphans({
        orphansToSave: 20
    });

    $("h2").savetheorphans({
        orphansToSave: 1
    });

    $("h3").savetheorphans({
        orphansToSave: 1
    });

    $("h4").savetheorphans({
        orphansToSave: 1
    });

    $("h5").savetheorphans({
        orphansToSave: 1
    });

    $(".newsletter-title").savetheorphans({
        orphansToSave: 1
    });

    /*   */

 
});
</script>

<script type="text/javascript">

function lazy_load(){

	
$(".lazy").bttrlazyloading({
	
	xs: {
	//	src: "img/720x200.gif",
		//width: 200,
		//height: 267
	},
	sm: {
	//	src: "img/360x200.gif",
	//	width: 300,
	//	height: 300
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
	backgroundcolor: 'transparent'
	
})
}
lazy_load();

</script>
</head>

<body <?php body_class(); ?>>



<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'ad' ); ?></a>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'ad' ); ?></a>


<div class="wrapper">
	
	<header id="masthead" class="site-header" role="banner">

	<div class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo bloginfo('template_url'); ?>/library/images/renegadeLogo.png"></a></div><!-- .logo -->
	
	<div class="nav-ct">
	
		<div class="utility-nav-ct">
		<div class="utility-nav" id="bt-links"></div>
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
	
	$phone_number = get_field('phone_number', 'option');
	$include_search = get_field('include_search', 'option')
?>
	</div></div>
		<div class="utility-nav" id="bt-phone"></div>
		<div id="phone-panel" class="utility-panel"><div class="utility-panel-inner" id="phone-panel-inner"><?php echo($phone_number); ?>
		</div></div><?php 
		if($include_search == 'Yes'):
		?>
		<div class="utility-nav" id="bt-search"></div>
		<div id="search-panel" class="utility-panel"><div class="utility-panel-inner" id="search-inner-panel"></div></div>
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