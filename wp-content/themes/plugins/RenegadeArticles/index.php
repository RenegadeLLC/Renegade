<?php

/*
 Plugin Name: Renegade Articles
Plugin URI:
Description: Custom Post Type for Renegade Articles
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


add_action( 'init', 'create_article_post_type' );

function create_article_post_type() {
	
	$labels = array(
			'name'               => _x( 'Articles', 'post type general name', 'your-plugin-textdomain' ),
			'singular_name'      => _x( 'Article', 'post type singular name', 'your-plugin-textdomain' ),
			'menu_name'          => _x( 'Renegade Articles', 'admin menu', 'your-plugin-textdomain' ),
			'name_admin_bar'     => _x( 'Article', 'add new on admin bar', 'your-plugin-textdomain' ),
			'add_new'            => _x( 'Add New', 'article', 'your-plugin-textdomain' ),
			'add_new_item'       => __( 'Add New Article', 'your-plugin-textdomain' ),
			'new_item'           => __( 'New Article', 'your-plugin-textdomain' ),
			'edit_item'          => __( 'Edit Article', 'your-plugin-textdomain' ),
			'view_item'          => __( 'View Article', 'your-plugin-textdomain' ),
			'all_items'          => __( 'All Articles', 'your-plugin-textdomain' ),
			//'search_items'       => __( 'Search Books', 'your-plugin-textdomain' ),
			//'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
			'not_found'          => __( 'No articles found.', 'your-plugin-textdomain' ),
			'not_found_in_trash' => __( 'No articles found in Trash.', 'your-plugin-textdomain' )
	);
	
	$args = array(
			'labels' => $labels,
			'singular_label' => __('Article'),
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'add_new_item' => __( 'Add New Article' ),
			'add_new' => __( 'Add New' ),
			'show_in_menu' => true,
			'menu_position' => 23,
			//'taxonomies' => array('category', 'post_tag'),
			'show_in_admin_bar' => true,
			'capability_type' => 'post',
			//'register_meta_box_cb' => 'add_custom_meta_box',
			'hierarchical' => true,
			'rewrite' => true,
			'supports' => array('title', 'revisions', 'tags', 'categories', 'archives'),
			'has_archive' => true,
			
				
	);

	register_post_type( 'articles' , $args );
}

/****************************************************************************************************************/
/*                              CREATE THE CUSTOM COLUMNS FOR THE POST TYPE                                      */
/****************************************************************************************************************/



//add_filter( 'manage_article_columns', 'set_custom_article_columns' );
/*
function add_new_article_columns( $columns ) {
	unset(  $columns['author']  );
	unset(  $columns['date']  );
	
	return array_merge ( $columns, array (
			$columns['ra_author'] = 				__( 'Article Author', 'your_text_domain' ),
			$columns['ra_publication'] = 		__( 'Publication', 'your_text_domain' ),
			$columns['ra_date'] = 				__( 'Date Published', 'your_text_domain' ),
			$columns['ra_url'] = 				__( 'Article URL', 'your_text_domain' ),
	) );
	

}
*/


function add_new_article_columns($columns) {
	unset(  $columns['author']  );
	unset(  $columns['date']  );
	$columns['ra_author'] = 				__( 'Author', 'your_text_domain' );
	$columns['ra_publication'] = 		__( 'Publication', 'your_text_domain' );
	$columns['ra_date'] = 				__( 'Date Published', 'your_text_domain' );
	$columns['ra_url'] = 				__( 'Article URL', 'your_text_domain' );
	
	return $columns;
}
add_filter("manage_articles_posts_columns", "add_new_article_columns");
/****************************************************************************************************************/
/*                              MAKE COLUMN SORTABLE BY CLIENT NAME                                      */
/****************************************************************************************************************/
add_filter( 'manage_edit-articles_sortable_columns', 'sortable_ra_column' );

function sortable_ra_column( $ra_columns ) {
	$ra_columns['title'] = 'title';
	$ra_columns['ra_publication'] = 'ra_publication';
	$ra_columns['ra_date'] = 'ra_date';
//	$ra_columns['ra_author'] = 'ra_author';
	//To make a column 'un-sortable' remove it from the array
	//unset($ra_columns['date']);

	return $ra_columns;
}


/****************************************************************************************************************/
/*                              LOAD CLIENT DATA PREVIOUSLY ENTERED                                      */
/****************************************************************************************************************/

//add_action("manage_posts_custom_column",  "article_custom_columns");


function article_custom_columns($column){

	global $post;
	switch ($column)
	{
				
		case 'ra_author':
			//$custom = get_post_custom();
			
			$RAauthor = get_field('ra_author');
			
			if( $RAauthor ) {
				echo($RAauthor);
				//echo get_post_meta ( $post_id, 'ra_author', true );
				//echo('wtf');
			}
			break;
				
		case 'ra_publication':
			
			$RApublication = get_field('ra_publication');
			
			if( $RApublication ) {
					echo($RApublication); 
					//echo('wtf');
			}
			break;
				
			case "ra_date":
				$RAdate = get_field('ra_date');
				echo($RAdate);
			break;
			
			case "ra_url":
				$RAurl = get_field('ra_url');
				if(  $RAurl ) {
					echo('<a href="' . $RAurl . '" target="_blank">' . $RAurl . '</a>');
				}
				break;


	}

}

add_action("manage_articles_posts_custom_column", "article_custom_columns");
/****************************************************************************************************************/
/*                              ADD EDIT LINKS TO CLIENT NAME COLUMN                                      */
/****************************************************************************************************************/




function ra_title_text_input ( $title ) {
	if ( get_post_type() == 'articles' ) {
		$title = __( 'Enter the article title here' );
	}
	return $title;
} // End title_text_input()
add_filter( 'enter_title_here', 'ra_title_text_input' );

/****************************************************************************************************************/
/*                              ADD TAXONOMY TO POST TYPE                                     */
/****************************************************************************************************************/


function ra_taxonomies() {

	$taxonomies = array(
		array(
	 		'slug'         => 'article_categories',
			'single_name'  => 'Article Category',
			'plural_name'  => 'Article Categories',
			'post_type'    => 'articles',
			//	'rewrite'      => array( 'slug' => 'article_category' ),
	),
		
	array(
			'slug'         => 'article_tags',
			'single_name'  => 'Article Tags',
			'plural_name'  => 'Article Tags',
			'post_type'    => 'articles',
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
		));
	}

	//ADD ABILITIY TO ASSIGN A CATEGORY TO AN IMAGE ATTACHMENT

	register_taxonomy_for_object_type( 'category', 'attachments' );
}
add_action( 'init', 'ra_taxonomies' );

