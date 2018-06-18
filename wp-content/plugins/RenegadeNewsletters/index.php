<?php

/*
 Plugin Name: Renegade Newsletters
Plugin URI:
Description: Custom Post Type for Renegade Newsletters
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


add_action( 'init', 'create_newsletter_post_type' );

function create_newsletter_post_type() {
	
	$labels = array(
			'name'               => _x( 'Newsletters', 'post type general name', 'your-plugin-textdomain' ),
			'singular_name'      => _x( 'Newsletter', 'post type singular name', 'your-plugin-textdomain' ),
			'menu_name'          => _x( 'Renegade Newsletters', 'admin menu', 'your-plugin-textdomain' ),
			'name_admin_bar'     => _x( 'Newsletter', 'add new on admin bar', 'your-plugin-textdomain' ),
			'add_new'            => _x( 'Add New', 'newsletter', 'your-plugin-textdomain' ),
			'add_new_item'       => __( 'Add New Newsletter', 'your-plugin-textdomain' ),
			'new_item'           => __( 'New Newsletter', 'your-plugin-textdomain' ),
			'edit_item'          => __( 'Edit Newsletter', 'your-plugin-textdomain' ),
			'view_item'          => __( 'View Newsletter', 'your-plugin-textdomain' ),
			'all_items'          => __( 'All Newsletters', 'your-plugin-textdomain' ),
			//'search_items'       => __( 'Search Books', 'your-plugin-textdomain' ),
			//'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
			'not_found'          => __( 'No newsletters found.', 'your-plugin-textdomain' ),
			'not_found_in_trash' => __( 'No newsletters found in Trash.', 'your-plugin-textdomain' )
	);
	
	$args = array(
			'labels' => $labels,
			'singular_label' => __('Newsletter'),
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'add_new_item' => __( 'Add New Newsletter' ),
			'add_new' => __( 'Add New' ),
			'show_in_menu' => true,
			'menu_position' => 22,
			//'taxonomies' => array('category', 'post_tag'),
			'show_in_admin_bar' => true,
			'capability_type' => 'post',
			//'register_meta_box_cb' => 'add_custom_meta_box',
			'hierarchical' => false,
			'rewrite' => true,
			'has_archive' => true,
			'supports' => array('editor', 'title', 'revisions', 'tags', 'categories', 'archives', 'thumbnail')
	);

	register_post_type( 'newsletters' , $args );
}

/****************************************************************************************************************/
/*                              CREATE THE CUSTOM COLUMNS FOR THE POST TYPE                                      */
/****************************************************************************************************************/



//add_filter( 'manage_newsletter_columns', 'set_custom_newsletter_columns' );

add_filter("manage_newsletters_posts_columns", "add_new_newsletter_columns");

function add_new_newsletter_columns($columns) {
	unset(  $columns['author'], $columns['date']  );
	$columns['rn_date'] = 				__( 'Date Published', 'your_text_domain' );
	//$columns['rn_url'] = 				__( 'Newsletter URL', 'your_text_domain' );
	//$columns['rn_blurb'] = 				__( 'Blurb', 'your_text_domain' );
	
	return $columns;
}

/****************************************************************************************************************/
/*                              MAKE COLUMN SORTABLE BY CLIENT NAME                                      */
/****************************************************************************************************************/
add_filter( 'manage_edit-newsletters_sortable_columns', 'sortable_rn_column' );

function sortable_rn_column( $rn_columns ) {
	$rn_columns['title'] = 'title';
	$rn_columns['rn_date'] = 'rn_date';
	//To make a column 'un-sortable' remove it from the array
	//unset($bg_columns['date']);

	return $rn_columns;
}


/****************************************************************************************************************/
/*                              LOAD CLIENT DATA PREVIOUSLY ENTERED                                      */
/****************************************************************************************************************/

//add_action("manage_posts_custom_column",  "newsletter_custom_columns");
add_action("manage_posts_custom_column", "newsletter_custom_columns");

function newsletter_custom_columns($rn_column){
	global $post;
	switch ($rn_column)
	{
				
				
		case "rn_publication":
			
			$RNpublication = get_field('rn_publication');
			
			if( $RNpublication ) {
					echo($RNpublication); 
			}
			break;
				
			case "rn_date":
			$RNdate = get_field('rn_date');
				echo($RNdate);
			break;
			
	


	}
}

/****************************************************************************************************************/
/*                              ADD EDIT LINKS TO CLIENT NAME COLUMN                                      */
/****************************************************************************************************************/




function rn_title_text_input ( $title ) {
	if ( get_post_type() == 'newsletters' ) {
		$title = __( 'Enter the newsletter title here' );
	}
	return $title;
} // End title_text_input()
add_filter( 'enter_title_here', 'rn_title_text_input' );
