<?php

global $ajax_vars;
global $ra_loop;

add_action('wp_enqueue_scripts', 'renegade_scripts');
//Making jQuery Google API

function renegade_scripts() {
	
	global $wp_query;
	
	$scriptdir = get_template_directory_uri();
	$scriptdir .= '/library/js/';
	$functiondir = get_template_directory_uri();
	$functiondir .='/library/functions/';
	
	// Load jQuery
	if ( !is_admin() ) {
	wp_deregister_script('jquery');
	wp_register_script('jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"), true);
	//wp_register_script('jquery', $scriptdir . 'jquery-1.11.3.min.js');
	wp_enqueue_script('jquery');
	}
		
	wp_localize_script( 'afp_script', 'afp_vars', array(
		'afp_nonce' => wp_create_nonce( 'afp_nonce' ),
		'afp_ajax_url' => admin_url( 'admin-ajax.php' ),
		//'query' => $wp_query->query,
		)
	);
	
	wp_register_script('archive_script', $scriptdir  . 'archive_getter.js', false, null, false);
	wp_enqueue_script('archive_script');
	
	wp_localize_script( 'archive_script', 'arc_vars', array(
			'arc_nonce' => wp_create_nonce( 'arc_nonce' ), // Create nonce which we later will use to verify AJAX request
			'arc_ajax_url' => admin_url( 'admin-ajax.php' ),
	)
			);
	
	wp_register_script('jqueryUI', 'https://code.jquery.com/ui/1.11.4/jquery-ui.min.js');
	//wp_register_script('easing', $scriptdir . 'EasePack.min.js');
	wp_enqueue_script('jqueryUI');
	

	//EASING EQUATIONS FOR GREENSOCK PLUGIN	
	wp_register_script('easing', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/easing/EasePack.min.js');
	//wp_register_script('easing', $scriptdir . 'EasePack.min.js');
	wp_enqueue_script('easing');
	
	//CSS FOR GREENSOCK PLUGIN	
	wp_register_script('css', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/plugins/CSSPlugin.min.js');
	//wp_register_script('css',$scriptdir .  'CSSPlugin.min.js');
	wp_enqueue_script('css');

	//GREENSOCK TWEENLITE PLUGIN
	wp_register_script('tweenLite', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenLite.min.js');
	//wp_register_script('tweenLite', $scriptdir . 'TweenLite.min.js');
	wp_enqueue_script('tweenLite');
	
	//SCROLLTO FOR GREENSOCK PLUGIN
	wp_register_script('scrollTo', $scriptdir . 'ScrollToPlugin.min.js');
	wp_enqueue_script('scrollTo');
	
	//SLIDING MENU PLUGIN
	wp_register_script('menuSlide', $scriptdir . 'jquery.mmenu.min.all.js');
	wp_enqueue_script('menuSlide');
	
	wp_register_script('menuSlideCanvas', $scriptdir . 'jquery.mmenu.oncanvas.min.js');
	//wp_enqueue_script('menuSlideCanvas');
	
	wp_register_script('menuJQmobile', $scriptdir . 'jquery.mmenu.jquerymobile.js');
	//wp_enqueue_script('menuJQmobile');
	
	wp_register_script('menuWP', $scriptdir . 'jquery.mmenu.wordpress.js');
	//wp_enqueue_script('menuWP');
	
	wp_register_script('lazyLoad', $scriptdir . 'jquery.bttrlazyloading.js');
	wp_enqueue_script('lazyLoad');
	
	//SCROLLSPY PLUGIN
	wp_register_script('scrollSpy', $scriptdir . 'scrollspy.js');
	wp_enqueue_script('scrollSpy');
	
	//STICKY NAV PLUGIN FOR BLOG PAGES
	wp_register_script('sticky', $scriptdir . 'jquery.sticky.js');
	wp_enqueue_script('sticky');
	
	//PREVENT TEXT ORPHANS
	wp_register_script('orphans', $scriptdir . 'savetheorphans.js');
	wp_enqueue_script('orphans');
	
	//	wp_register_script('stickyScroll', $scriptdir . 'jquery-contained-sticky-scroll-min.js');
	//	wp_enqueue_script('stickyScroll');
	
	//CUSTOM SCRIPTS
	
	wp_register_script('postScroller', $scriptdir . 'post_scroller.js');
	wp_enqueue_script('postScroller');
	
	wp_register_script('headerPanel', $scriptdir . 'header_panel.js');
	wp_enqueue_script('headerPanel');
	
	wp_register_script('expandDiv', $scriptdir . 'expand_next_div.js');
	wp_enqueue_script('expandDiv');
	
	//wp_register_script('headerPanel', $scriptdir . 'header_panel.js');
	//wp_enqueue_script('headerPanel');
	
	//PANEL POST SCROLLER
	wp_register_script('mod_home_case', $scriptdir . 'mod_home_case.js');
	wp_enqueue_script('mod_home_case');
	
	//SIDEBAR NAVIGATION
	wp_register_script('sidebar', $scriptdir . 'sidebar.js');
	wp_enqueue_script('sidebar');
	
	//MAINTAIN CIRCLE RATIO
	wp_register_script('makeCircle', $scriptdir . 'makeCircle.js');
	wp_enqueue_script('makeCircle');
	
	//MAINTAIN SQUARE RATIO
	wp_register_script('makeSquare', $scriptdir . 'makeSquare.js');
	wp_enqueue_script('makeSquare');
	
	//wp_register_script('expandOnScroll', $scriptdir . 'expandOnScroll.js');
	//wp_enqueue_script('expandOnScroll');
	
	//wp_register_script('ribbonCap', $scriptdir . 'ribbonCap.js');
//	wp_enqueue_script('ribbonCap');
	
	//	wp_register_script('slideShow', $scriptdir . 'jquery.slideshow.js');
	//	wp_enqueue_script('slideShow');

	wp_register_script('homeJS', $scriptdir . 'home.js');
	wp_enqueue_script('homeJS');

	wp_register_script('blogTitle', $scriptdir . 'blog_title.js');
	wp_enqueue_script('blogTitle');
	
	//ESTABLISH ROW HEIGHTS BASED ON CONTENTS
	//wp_register_script('fixRowHeight', $scriptdir . 'fix_row_height.js');
	//wp_enqueue_script('fixRowHeight');
	
	//wp_register_script('fixedElements', $scriptdir . 'jquery.mmenu.fixedelements.min.js');
	//wp_enqueue_script('fixedElements');
	
	//wp_register_script('subnav', $scriptdir . 'subnav.js');
	//wp_enqueue_script('subnav');

	//ISOTOPE PLUGIN (FOR LAYOUTS)
	wp_register_script('isotope', $scriptdir . 'isotope.pkgd.min.js');
	wp_enqueue_script('isotope');
	
	//ADD PACKERY LAYOUT TO ISOTOPE
	wp_register_script('packery', $scriptdir . 'packery-mode.pkgd.min.js');
	wp_enqueue_script('packery');
	
	//LAYOUT EXTENSION TO ISOTOPE
	wp_register_script('layoutModes', $scriptdir . 'layout-mode.js');
	wp_enqueue_script('layoutModes');
	
	//IMAGES LOADED
	wp_register_script('imagesLoaded', $scriptdir . 'imagesloaded.pkgd.min.js');
	wp_enqueue_script('imagesLoaded');
	
	//LAYOUT EXTENSION TO ISOTOPE
	//wp_register_script('DHF', $scriptdir . 'Draggable.js');
	//wp_enqueue_script('DHF');
}
?>