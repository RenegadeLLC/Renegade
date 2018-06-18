<?php

/*
 Plugin Name: Renegade Podcasts
Plugin URI:
Description: Custom Post Type for Renegade Podcasts
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


add_action( 'init', 'create_podcast_post_type' );

function create_podcast_post_type() {
	
	$labels = array(
			'name'               => _x( 'Podcasts', 'post type general name', 'your-plugin-textdomain' ),
			'singular_name'      => _x( 'Podcast', 'post type singular name', 'your-plugin-textdomain' ),
			'menu_name'          => _x( 'Renegade Podcasts', 'admin menu', 'your-plugin-textdomain' ),
			'name_admin_bar'     => _x( 'Podcast', 'add new on admin bar', 'your-plugin-textdomain' ),
			'add_new'            => _x( 'Add New', 'podcast', 'your-plugin-textdomain' ),
			'add_new_item'       => __( 'Add New Podcast', 'your-plugin-textdomain' ),
			'new_item'           => __( 'New Podcast', 'your-plugin-textdomain' ),
			'edit_item'          => __( 'Edit Podcast', 'your-plugin-textdomain' ),
			'view_item'          => __( 'View Podcast', 'your-plugin-textdomain' ),
			'all_items'          => __( 'All Podcasts', 'your-plugin-textdomain' ),
			//'search_items'       => __( 'Search Books', 'your-plugin-textdomain' ),
			//'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
			'not_found'          => __( 'No podcasts found.', 'your-plugin-textdomain' ),
			'not_found_in_trash' => __( 'No podcasts found in Trash.', 'your-plugin-textdomain' )
	);
	
	$args = array(
			'labels' => $labels,
			'singular_label' => __('Podcast'),
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'add_new_item' => __( 'Add New Podcast' ),
			'add_new' => __( 'Add New' ),
			'show_in_menu' => true,
			'menu_position' => 24,
			//'taxonomies' => array('category', 'post_tag'),
			'show_in_admin_bar' => true,
			'capability_type' => 'post',
			//'register_meta_box_cb' => 'add_custom_meta_box',
			'hierarchical' => true,
			'rewrite' => true,
			'supports' => array('title', 'revisions', 'editor', 'tags', 'categories', 'archives'),
			'has_archive' => true,
	       'publicly_queryable'  => true
			
				
	);

	register_post_type( 'podcasts' , $args );
}

/****************************************************************************************************************/
/*                              CREATE THE CUSTOM COLUMNS FOR THE POST TYPE                                      */
/****************************************************************************************************************/



//add_filter( 'manage_podcast_columns', 'set_custom_podcast_columns' );
/*
function add_new_podcast_columns( $columns ) {
	unset(  $columns['author']  );
	unset(  $columns['date']  );
	
	return array_merge ( $columns, array (
			$columns['rpd_guest'] = 				__( 'Podcast Author', 'your_text_domain' ),
			$columns['rpd_publication'] = 		__( 'Publication', 'your_text_domain' ),
			$columns['rpd_date'] = 				__( 'Date Published', 'your_text_domain' ),
			$columns['rpd_url'] = 				__( 'Podcast URL', 'your_text_domain' ),
	) );
	

}
*/


function add_new_podcast_columns($columns) {
	unset(  $columns['author']  );
//	unset(  $columns['date']  );
	$columns['rpd_guest'] = 				__( 'Author', 'your_text_domain' );
//	$columns['rpd_publication'] = 		__( 'Publication', 'your_text_domain' );
	$columns['rpd_date'] = 				__( 'Date Published', 'your_text_domain' );
	$columns['rpd_url'] = 				__( 'Podcast URL', 'your_text_domain' );
	
	return $columns;
}
add_filter("manage_podcasts_posts_columns", "add_new_podcast_columns");

/****************************************************************************************************************/
/*                              MAKE COLUMNs SORTABLE BY CUSTOM META DATA                                     */
/****************************************************************************************************************/
add_action( 'pre_get_posts', 'custom_rpd_orderby' );
function custom_rpd_orderby( $query ) {
	if( ! is_admin() )
		return;
		
		$orderby = $query->get( 'orderby');
		
	if ( 'rpd_date' == $orderby ) {
			$query->set('meta_key','rpd_date');
			$query->set('orderby','meta_value_num');
		}
		elseif ( 'rpd_guest' == $orderby ) {
			$query->set('meta_key','rpd_guest');
			$query->set('orderby','meta_value');
		}
}


/****************************************************************************************************************/
/*                              MAKE COLUMN SORTABLE BY CLIENT NAME                                      */
/****************************************************************************************************************/
add_filter( 'manage_edit-podcasts_sortable_columns', 'sortable_rpd_column' );

function sortable_rpd_column( $rpd_columns ) {
	$rpd_columns['title'] = 'title';
	//$rpd_columns['rpd_publication'] = 'rpd_publication';
	$rpd_columns['rpd_date'] = 'rpd_date';
//	$rpd_columns['rpd_guest'] = 'rpd_guest';
	//To make a column 'un-sortable' remove it from the array
	unset($rpd_columns['date']);

	return $rpd_columns;
}


/****************************************************************************************************************/
/*                              LOAD CLIENT DATA PREVIOUSLY ENTERED                                      */
/****************************************************************************************************************/

//add_action("manage_posts_custom_column",  "podcast_custom_columns");


function podcast_custom_columns($column){

	global $post;
	switch ($column)
	{
				
		case 'rpd_guest':
			//$custom = get_post_custom();
			
			$RAauthor = get_field('rpd_guest');
			
			if( $RAauthor ) {
				echo($RAauthor);
				//echo get_post_meta ( $post_id, 'rpd_guest', true );
				//echo('wtf');
			}
			break;
				
		
				
			case "rpd_date":
				$RAdate = get_field('rpd_date');
				echo($RAdate);
			break;
			
			case "rpd_url":
				$RAurl = get_field('rpd_url');
				if(  $RAurl ) {
					echo('<a href="' . $RAurl . '" target="_blank">' . $RAurl . '</a>');
				}
				break;


	}

}

add_action("manage_podcasts_posts_custom_column", "podcast_custom_columns");
/****************************************************************************************************************/
/*                              ADD EDIT LINKS TO CLIENT NAME COLUMN                                      */
/****************************************************************************************************************/




function rpd_title_text_input ( $title ) {
	if ( get_post_type() == 'podcasts' ) {
		$title = __( 'Enter the podcast title here' );
	}
	return $title;
} // End title_text_input()
add_filter( 'enter_title_here', 'rpd_title_text_input' );

/****************************************************************************************************************/
/*                              ADD TAXONOMY TO POST TYPE                                     */
/****************************************************************************************************************/


function rpd_taxonomies() {

	$taxonomies = array(
		array(
	 		'slug'         => 'podcast_categories',
			'single_name'  => 'Podcast Category',
			'plural_name'  => 'Podcast Categories',
			'post_type'    => 'podcasts',
			//	'rewrite'      => array( 'slug' => 'podcast_category' ),
	),
		
	array(
			'slug'         => 'podcast_tags',
			'single_name'  => 'Podcast Tags',
			'plural_name'  => 'Podcast Tags',
			'post_type'    => 'podcasts',
			//	'rewrite'      => array( 'slug' => 'department' ),
	),

	);

	foreach( $taxonomies as $taxonomy ) {
		$labels = array(
				'name' => $taxonomy['plural_name'],
				'singular_name' => $taxonomy['single_name'],
				'search_items' =>  'Search ' . $taxonomy['plural_name'],
				'all_items' => 'All ' . $taxonomy['plural_name'],
				'parent_item' => 'Parent ' . $taxonomy['single_name'],
				'parent_item_colon' => 'Parent ' . $taxonomy['single_name'] . ':',
				'edit_item' => 'Edit ' . $taxonomy['single_name'],
				'update_item' => 'Update ' . $taxonomy['single_name'],
				'add_new_item' => 'Add New ' . $taxonomy['single_name'],
				'new_item_name' => 'New ' . $taxonomy['single_name'] . ' Name',
				'menu_name' => $taxonomy['plural_name']
		);

		$rewrite = isset( $taxonomy['rewrite'] ) ? $taxonomy['rewrite'] : array( 'slug' => $taxonomy['slug'] );
		$hierarchical = isset( $taxonomy['hierarchical'] ) ? $taxonomy['hierarchical'] : true;

		register_taxonomy( $taxonomy['slug'], $taxonomy['post_type'], array(
		'hierarchical' => $hierarchical,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => $rewrite,
		//'public' => false
		));
	}

	//ADD ABILITIY TO ASSIGN A CATEGORY TO AN IMAGE ATTACHMENT

	register_taxonomy_for_object_type( 'category', 'attachments' );
}
add_action( 'init', 'rpd_taxonomies' );

