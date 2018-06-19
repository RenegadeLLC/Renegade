<?php

/*
 Plugin Name: Renegade HomeSlides
Plugin URI:
Description: Custom Post Type for Renegade Slides
Version: 1.0
Author: Anne Rothschild
Author URI:
*/
/********************************************************/
/*                CREATE ADMIN AREA                     */
/********************************************************/
$GLOBALS['RenegadePluginPath'] = plugins_url('/', __FILE__);

/****************************************************************************************************************/
/*                                        CREATE THE CUSTOM POST TYPE                                           */
/****************************************************************************************************************/


add_action( 'init', 'create_homehomeslide_post_type' );

function create_homehomeslide_post_type() {
	
	//CREATE SLIDE POST TYPE
	
	$labels = array(
			'name'               => _x( 'Slides', 'post type general name', 'your-plugin-textdomain' ),
			'singular_name'      => _x( 'Slide', 'post type singular name', 'your-plugin-textdomain' ),
			'menu_name'          => _x( 'Renegade Slides', 'admin menu', 'your-plugin-textdomain' ),
			'name_admin_bar'     => _x( 'Slide', 'add new on admin bar', 'your-plugin-textdomain' ),
			'add_new'            => _x( 'Add New', 'homeslide', 'your-plugin-textdomain' ),
			'add_new_item'       => __( 'Add New Slide', 'your-plugin-textdomain' ),
			'new_item'           => __( 'New Slide', 'your-plugin-textdomain' ),
			'edit_item'          => __( 'Edit Slide', 'your-plugin-textdomain' ),
			'view_item'          => __( 'View Slide', 'your-plugin-textdomain' ),
			'all_items'          => __( 'All Slides', 'your-plugin-textdomain' ),
			//'search_items'       => __( 'Search Books', 'your-plugin-textdomain' ),
			//'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
			'not_found'          => __( 'No homeslides found.', 'your-plugin-textdomain' ),
			'not_found_in_trash' => __( 'No homeslides found in Trash.', 'your-plugin-textdomain' )
	);
	
	$args = array(
			'labels' => $labels,
			'singular_label' => __('Slide'),
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'add_new_item' => __( 'Add New Slide' ),
			'add_new' => __( 'Add New' ),
			'show_in_menu' => true,
			'menu_position' => 6,
			'taxonomies' => array(),
			'show_in_admin_bar' => true,
			'capability_type' => 'post',
			//'register_meta_box_cb' => 'add_custom_meta_box',
			'hierarchical' => false,
			'rewrite' => true,
			'supports' => array('title', 'rh_category')
	);

	register_post_type( 'homeslides' , $args );
	
	//CREATE SLIDE SHOW POST TYPE

	$labels = array(
			'name'               => _x( 'Slideshows', 'post type general name', 'your-plugin-textdomain' ),
			'singular_name'      => _x( 'Slideshow', 'post type singular name', 'your-plugin-textdomain' ),
			'menu_name'          => _x( 'Renegade Slideshows', 'admin menu', 'your-plugin-textdomain' ),
			'name_admin_bar'     => _x( 'Slideshow', 'add new on admin bar', 'your-plugin-textdomain' ),
			'add_new'            => _x( 'Add New', 'homeslideshow', 'your-plugin-textdomain' ),
			'add_new_item'       => __( 'Add New Slideshow', 'your-plugin-textdomain' ),
			'new_item'           => __( 'New Slideshow', 'your-plugin-textdomain' ),
			'edit_item'          => __( 'Edit Slideshow', 'your-plugin-textdomain' ),
			'view_item'          => __( 'View Slideshow', 'your-plugin-textdomain' ),
			'all_items'          => __( 'All Slideshows', 'your-plugin-textdomain' ),
			//'search_items'       => __( 'Search Books', 'your-plugin-textdomain' ),
			//'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
			'not_found'          => __( 'No homeslideshows found.', 'your-plugin-textdomain' ),
			'not_found_in_trash' => __( 'No homeslideshows found in Trash.', 'your-plugin-textdomain' )
	);
	
	$args = array(
			'labels' => $labels,
			'singular_label' => __('Slideshow'),
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'add_new_item' => __( 'Add New Slideshow' ),
			'add_new' => __( 'Add New' ),
			'show_in_menu' => 'edit.php?post_type=homeslides',
			'menu_position' => 7,
			'taxonomies' => array(),
			'show_in_admin_bar' => true,
			'capability_type' => 'post',
			//'register_meta_box_cb' => 'add_custom_meta_box',
			'hierarchical' => false,
			'rewrite' => true,
			'supports' => array('title', 'sld_category')
	);
	
	register_post_type( 'homeslideshows' , $args );
}

/****************************************************************************************************************/
/*                              CREATE THE CUSTOM COLUMNS FOR THE POST TYPE                                      */
/****************************************************************************************************************/



//add_filter( 'manage_homehomeslide_columns', 'set_custom_homehomeslide_columns' );

add_filter("manage_homeslides_posts_columns", "add_new_homehomeslide_columns");

function add_new_homehomeslide_columns($columns) {
	unset(  $columns['author'] );
	//$columns['homehomeslide_name'] = 				__( 'Slide Name', 'your_text_domain' );
	$columns['rh_homeslide_category'] = 				__( 'Category', 'your_text_domain' );
	//$columns['rh_publication'] = 		__( 'Publication', 'your_text_domain' );
	//$columns['rh_date'] = 				__( 'Date Published', 'your_text_domain' );
//	$columns['rh_url'] = 				__( 'Slide URL', 'your_text_domain' );
	//$columns['rh_blurb'] = 				__( 'Blurb', 'your_text_domain' );
	
	return $columns;
}

/****************************************************************************************************************/
/*                              MAKE COLUMN SORTABLE BY CLIENT NAME                                      */
/****************************************************************************************************************/
add_filter( 'manage_edit-homeslides_sortable_columns', 'sortable_rh_column' );

function sortable_rh_column( $rh_columns ) {
	$rh_columns['title'] = 'title';
	$rh_columns['rh_homeslide_category'] = 'rh_homeslide_category';
	//$rh_columns['rh_date'] = 'rh_date';
	//$rh_columns['rh_author'] = 'rh_author';
	//To make a column 'un-sortable' remove it from the array
	//unset($bg_columns['date']);

	return $rh_columns;
}


/****************************************************************************************************************/
/*                              LOAD CLIENT DATA PREVIOUSLY ENTERED                                      */
/****************************************************************************************************************/

//add_action("manage_posts_custom_column",  "homehomeslide_custom_columns");
add_action("manage_posts_custom_column", "homehomeslide_custom_columns");

function homehomeslide_custom_columns($rh_column){
	global $post;
	switch ($rh_column)
	{
				
		case "rh_homeslide_category":
			//$custom = get_post_custom();
			$RHcategory = get_field('rh_homeslide_category');
			
			if( $RHcategory ) {
				echo($RHcategory);
			}
			break;

	}
}


function rh_title_text_input ( $title ) {
	if ( get_post_type() == 'homeslides' ) {
		$title = __( 'Enter the homeslide title here' );
	}
	return $title;
} // End title_text_input()
add_filter( 'enter_title_here', 'rh_title_text_input' );
