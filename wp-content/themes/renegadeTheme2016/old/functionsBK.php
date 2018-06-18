<?php
/**
 * Renegade functions and definitions
 *
 * @package Renegade
 */


/********  DEFINE FILE PATHS ********/

define('LIBRARY', TEMPLATEPATH . '/library');
define('IMAGES', TEMPLATEPATH . '/library/images');



/*****ADD FILES THAT LOAD JAVASCRIPT AND CSS *****/
require_once (LIBRARY . '/javascript_loader.php');
require_once (LIBRARY. '/css_loader.php');
require_once (LIBRARY. '/shortcode_loader.php');



//*****  GET RID OF AUTO PARAGRAPHS *****//
function custom_editor(){
	//remove_filter( 'the_content', 'wpautop' );
	remove_filter( 'the_excerpt', 'wpautop' );
	remove_filter( 'the_title', 'wpautop' );
	remove_filter ('acf_the_content', 'wpautop');
}

add_action('init', 'custom_editor');
/**
 * Hide editor for specific page templates.
 *
 */
add_action( 'admin_init', 'hide_editor' );

function hide_editor() {
	// Get the Post ID.
	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
	if( !isset( $post_id ) ) return;

	// Get the name of the Page Template file.
	$template_file = get_post_meta($post_id, '_wp_page_template', true);

	$customTemplates = array('page-templates/standard_page_template.php', 'page-templates/resources_template.php', 'page-templates/thankYou_template.php', 'page-templates/video_template.php', 'page-templates/home_template.php' );

	if (in_array($template_file, $customTemplates)) {
		remove_post_type_support('page', 'editor');
	}


}

//***** ADD READ MORE LINK AFTER POST EXCERPTS *****//
function new_excerpt_more( $more ) {
	return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">' . __('...read more', 'your-text-domain') . '</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );


/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'rmg_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function rmg_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Renegade, use a find and replace
	 * to change 'rmg' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'rmg', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in three locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'Renegade' ),
		'people' => __( 'People Menu', 'Renegade' ),
		'work' => __( 'Work Menu', 'Renegade' ),
	) );



	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'rmg_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // rmg_setup
add_action( 'after_setup_theme', 'rmg_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function rmg_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'rmg' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'rmg_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function rmg_scripts() {
	wp_enqueue_style( 'rmg-style', get_stylesheet_uri() );

	//wp_enqueue_script( 'rmg-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'rmg-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'rmg_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

function add_custom_types_to_tax( $query ) {
	if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {

		// Get all your post types
		$post_types = get_post_types();

		$query->set( 'post_type', $post_types );
		return $query;
	}
}
add_filter( 'pre_get_posts', 'add_custom_types_to_tax' );

add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode', 11);
 

 function rn_search_form( $form ) {
 	$form = '<form role="search" method="get" class="search-form" action="http://localhost:8888/Renegade/" novalidate="">
				<label>
					<span class="screen-reader-text">Search for:</span>
					<input type="search" class="search-field" placeholder="Search Saw a Good Idea" value="" name="s" title="Search for:">
				</label>
				<input type="submit" class="search-submit" value="go">
			</form>';
 
 	return $form;
 }
 
add_filter( 'get_search_form', 'rn_search_form' );

//EXCERPTS FILTER FOR RSS FEED PLUGIN

include_once( ABSPATH . WPINC . '/feed.php' );

//ADD ADVANCED CUSTOM FIELDS OPTIONS
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page();

}

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
	'page_title' 	=> 'Theme General Settings',
	'menu_title'	=> 'Theme Settings',
	'menu_slug' 	=> 'theme-general-settings',
	'capability'	=> 'edit_posts',
	'redirect'		=> false
	));

	acf_add_options_sub_page(array(
	'page_title' 	=> 'Theme Header Settings',
	'menu_title'	=> 'Header',
	'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
	'page_title' 	=> 'Theme Footer Settings',
	'menu_title'	=> 'Footer',
	'parent_slug'	=> 'theme-general-settings',
	));

}