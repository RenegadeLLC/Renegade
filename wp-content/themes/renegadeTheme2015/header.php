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

    
});
</script>
</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'ad' ); ?></a>


<div id="header-ct">


<div class="wrapper">
	
	<header id="masthead" class="site-header" role="banner">
	<div class="header-main">
	<div class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo bloginfo('template_url'); ?>/library/images/renegadeLogo.png"></a></div><!-- .logo -->
	
	<div class="nav-ct">
	
		<div class="utility-nav-ct">
		<div class="utility-nav" id="bt-links"></div>
		<div id="links-panel" class="utility-panel header-social-icons-ct">
		<div class="utility-panel-inner" id="links-panel-inner">
		<div class="social-facebook header-social-icons"></div>
		<div class="social-twitter header-social-icons"></div>
		<div class="social-instagram header-social-icons"></div>
		<div class="social-linkedIn header-social-icons"></div>
		<div class="social-youTube header-social-icons"></div>
		</div></div>
		<div class="utility-nav" id="bt-phone"></div>
		<div id="phone-panel" class="utility-panel"><div class="utility-panel-inner" id="phone-panel-inner">646.838.9000 </div></div>
		<div class="utility-nav" id="bt-search"></div>
		<div id="search-panel" class="utility-panel"><div class="utility-panel-inner" id="search-inner-panel"></div></div>
		</div><!-- .utility-nav-ct -->
	
		<nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
	
		<?php wp_nav_menu( array('menu' => 'primary', 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
		</nav>	
	</div><!-- .nav-ct -->
	</div><!-- .header-main -->
	
	</header><!-- #masthead -->
	<!--  <div class="topDiag"></div>-->
	</div><!-- .content-wrapper -->
	</div><!-- .header-ct -->
	<div id="content" class="site-content">