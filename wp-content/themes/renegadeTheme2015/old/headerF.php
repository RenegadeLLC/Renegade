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
<![endif]-->
</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'ad' ); ?></a>
<div class="header-ct">
<div class="topDiag"></div>

	<div class="content-wrapper">
	<header id="masthead" class="site-header" role="banner" style="max-height:120px;">

		<div class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo bloginfo('template_url'); ?>/library/images/renegadeLogo.png"></a>
		</div><!-- .logo -->
<nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
	</div><!-- .content-wrapper -->
	</div><!-- .header-ct -->
	<div id="content" class="site-content">
