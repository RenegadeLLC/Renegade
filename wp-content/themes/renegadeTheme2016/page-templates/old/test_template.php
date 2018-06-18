<?php
/**
 * Template Name: TEST Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2015
 */

get_header(); 

$pageHTML = '';
$pageHTML .= '<div style="display:block; position:relative; overflow:hidden; background:#E6E7E8; height:100%; width:100%;">';
$pageHTML .= '<div style="background-color:#000; width:100%; position:absolute; height:538px;"></div>';
//GET THE MAIN PAGE VARIABLES

$headline = get_field('headline');
$subheader = get_field('subheader');
$headline_background_color = get_field('headline_background_color');

$pageHTML .= '<div class="wrapper">';
$pageHTML .= '<div class="headline-ct">';

//if($header){
$pageHTML .= '<h1>'. $headline . '</h1>';
//}

if($subheader){
	$pageHTML .= '<div class="sub-headline-ct">';
	$pageHTML .= '<h2>'. $subheader . '</h2></div>';
}

$pageHTML .= '</div><!-- headline-ct -->';
$pageHTML .=  '</div><!-- .wrapper-->';


echo $pageHTML;

$scriptdir = get_template_directory_uri();
$scriptdir .= '/library/js/';
$html = '';
echo $scriptdir;
$html .= '<div class="wtf">WTF?????</div>WAAAAAA<div style="color:#000 !important;">';
//$html .= '<a href="#submenu"><div class="bt-submenu"></div></a><div class="sub-nav-menu-ct" id="submenu">' . wp_nav_menu( array( 'menu' => 'work','theme_location' => 'people', 'menu_class' => 'sub-nav-menu' ) ) . '</div></a>';


			$args = array(
					'type'            => 'monthly',
					'limit'           => '',
					'format'          => 'html',
					'before'          => '',
					'after'           => '',
					'show_post_count' => false,
					'echo'            => 1,
					'order'           => 'DESC',
					'post_type'     => 'articles'
			);
	$html .=		wp_get_archives( $args );
$html .= '</div>';
// Enqueue script
function fuckerFucker() {
	echo('why the fuck will this not work????');
	// Enqueue script
	


	wp_register_script('fucker', $scriptdir . 'wtf.js');
	wp_enqueue_script('fucker');
	
	$wtf_vars = array(
		//	'af_nonce' => wp_create_nonce( 'afp_nonce' ), // Create nonce which we later will use to verify AJAX request
			//'afp_ajax_url' => admin_url( 'admin-ajax.php' ),
		//	'query' => $ra_loop->query,
		'wtf' => __('wtf')
	);
	
	//wp_localize_script('my_script', 'my_script_data', array('query' => $qv) );
	//wp_localize_script( 'wtf', 'wtf_vars', $wtf_vars);

}

function load_external_jQuery() { // load external file  
   // wp_deregister_script( 'jquery' ); // deregisters the default WordPress jQuery  
  //  wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"), false);
  //  wp_enqueue_script('jquery');
    wp_register_script('wtf', $scriptdir . 'wtf.js' );
    wp_enqueue_script('wtf');
}  
add_action('wp_enqueue_scripts', 'load_external_jQuery');

echo $html;
 ?>


<?php get_footer(); ?>