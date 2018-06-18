<?php

/*
 Plugin Name: Renegade Slideshows
Plugin URI:
Description: Custom Post Type for Home Page Slideshow
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


add_action( 'init', 'create_slideshow_post_type' );

function create_slideshow_post_type() {
	
	$labels = array(
			'name'               => _x( 'Slideshowshows', 'post type general name', 'your-plugin-textdomain' ),
			'singular_name'      => _x( 'Slideshow', 'post type singular name', 'your-plugin-textdomain' ),
			'menu_name'          => _x( 'Renegade Slideshows', 'admin menu', 'your-plugin-textdomain' ),
			'name_admin_bar'     => _x( 'Slideshow', 'add new on admin bar', 'your-plugin-textdomain' ),
			'add_new'            => _x( 'Add New', 'slideshow', 'your-plugin-textdomain' ),
			'add_new_item'       => __( 'Add New Slideshow', 'your-plugin-textdomain' ),
			'new_item'           => __( 'New Slideshow', 'your-plugin-textdomain' ),
			'edit_item'          => __( 'Edit Slideshow', 'your-plugin-textdomain' ),
			'view_item'          => __( 'View Slideshow', 'your-plugin-textdomain' ),
			'all_items'          => __( 'All Slideshowshows', 'your-plugin-textdomain' ),
			//'search_items'       => __( 'Search Books', 'your-plugin-textdomain' ),
			//'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
			'not_found'          => __( 'No slideshows found.', 'your-plugin-textdomain' ),
			'not_found_in_trash' => __( 'No slideshows found in Trash.', 'your-plugin-textdomain' )
	);
	
	$args = array(
			'labels' => $labels,
			'singular_label' => __('Slideshow'),
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'add_new_item' => __( 'Add New Slideshow' ),
			'add_new' => __( 'Add New' ),
			'show_in_menu' => true,
			'menu_position' => 17,
			'taxonomies' => array(),
			'show_in_admin_bar' => true,
			'capability_type' => 'post',
			//'register_meta_box_cb' => 'add_custom_meta_box',
			'hierarchical' => false,
			'rewrite' => true,
			'supports' => array('title', 'sld_category')
	);

	register_post_type( 'slideshows' , $args );
}

/****************************************************************************************************************/
/*                              CREATE THE CUSTOM COLUMNS FOR THE POST TYPE                                      */
/****************************************************************************************************************/



//add_filter( 'manage_slideshow_columns', 'set_custom_slideshow_columns' );

add_filter("manage_slideshows_posts_columns", "add_new_slideshow_columns");

function add_new_slideshow_columns($columns) {
	unset(  $columns['author'] );
	//$columns['slideshow_name'] = 				__( 'Slideshow Name', 'your_text_domain' );
	$columns['sld_image'] = 				__( 'Image', 'your_text_domain' );
	//$columns['sld_publication'] = 		__( 'Publication', 'your_text_domain' );
	//$columns['sld_date'] = 				__( 'Date Published', 'your_text_domain' );
//	$columns['sld_url'] = 				__( 'Slideshow URL', 'your_text_domain' );
	//$columns['sld_blurb'] = 				__( 'Blurb', 'your_text_domain' );
	
	return $columns;
}

/****************************************************************************************************************/
/*                              MAKE COLUMN SORTABLE BY CLIENT NAME                                      */
/****************************************************************************************************************/
add_filter( 'manage_edit-slideshows_sortable_columns', 'sortable_sld_column' );

function sortable_sld_column( $sld_columns ) {
	$sld_columns['title'] = 'title';
	//$sld_columns['sld_slideshow_category'] = 'sld_slideshow_category';
	//$sld_columns['sld_date'] = 'sld_date';
	//$sld_columns['sld_author'] = 'sld_author';
	//To make a column 'un-sortable' remove it from the array
	//unset($bg_columns['date']);

	return $sld_columns;
}


/****************************************************************************************************************/
/*                              LOAD CLIENT DATA PREVIOUSLY ENTERED                                      */
/****************************************************************************************************************/

//add_action("manage_posts_custom_column",  "slideshow_custom_columns");
add_action("manage_posts_custom_column", "slideshow_custom_columns");

function slideshow_custom_columns($sld_column){
	global $post;
	switch ($sld_column)
	{
				
		case "sld_slideshow_category":
			//$custom = get_post_custom();
			$SLDcategory = get_field('sld_slideshow_category');
			
			if( $SLDcategory ) {
				echo($SLDcategory);
			}
			break;
				


	}
}
/**/
/****************************************************************************************************************/
/*                             CUSTOMIZE TITLE INPUT                                   */
/****************************************************************************************************************/


function sld_title_text_input ( $title ) {
	if ( get_post_type() == 'slideshows' ) {
		$title = __( 'Enter the slideshow title here' );
	}
	return $title;
} // End title_text_input()
add_filter( 'enter_title_here', 'sld_title_text_input' );


