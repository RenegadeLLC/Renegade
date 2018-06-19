<?php

/*
 Plugin Name: Renegade Work
Plugin URI:
Description: Custom Post Type for Renegade Projects
Version: 1.0
Author: Anne Rothschild
Author URI:
*/
/********************************************************/
/*                CREATE ADMIN AREA                     */
/********************************************************/
$GLOBALS['RenegadePluginPath'] = plugins_url('/', __FILE__);


$pluginDIR = plugin_dir_path( __FILE__ );
//$renegade_project_icon = $pluginDIR . 'image/ic_admin_project.png';


add_action( 'init', 'init_projects' );

function init_projects() {

	//CREATE PRODUCTS TABLE IN WP DATABASE
	/*
	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();

	$product_sql = "CREATE TABLE $projects_table(

	id mediumint(9) NOT NULL AUTO_INCREMENT,
	time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	name tinytext NOT NULL,
	text text NOT NULL,
	url varchar(55) DEFAULT '' NOT NULL,
	UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $product_sql );
	*/
	wp_register_script('jquery', $GLOBALS['RenegadePluginPath'] . 'js/jquery-1.11.2.js');
	wp_enqueue_script('jquery');

	$pluginDIR = plugin_dir_path( __FILE__ );

	$pluginJS = $pluginDIR . 'js/';
	$ajaxURL = plugin_dir_path( __FILE__ ) .'saveorder.php';

	wp_enqueue_script( 'my-ajax-request', plugin_dir_url( __FILE__ ) . 'js/sorting.js', array( 'jquery' ) );
	wp_localize_script( 'my-ajax-request', 'MyAjax', array( 'ajaxurl' =>$ajaxURL ) );

	wp_register_style('jqueryUICSS', $GLOBALS['RenegadePluginPath'] . 'css/jquery-ui.css');
	wp_enqueue_style('jqueryUICSS');

	wp_register_style('jqueryStructureCSS', $GLOBALS['RenegadePluginPath'] . 'css/jquery-ui.structure.css');
	wp_enqueue_style('jqueryStructureCSS');

	wp_register_script('jqueryUI', 'https://code.jquery.com/ui/1.11.3/jquery-ui.js');
	wp_enqueue_script('jqueryUI');
	
	wp_register_script('isotope', $GLOBALS['RenegadePluginPath'] . 'js/isotope.pkgd.min.js');
	wp_enqueue_script('isotope');

}



/****************************************************************************************************************/
/*                                        CREATE THE CUSTOM POST TYPE                                           */
/****************************************************************************************************************/


add_action( 'init', 'create_project_post_type' );

function create_project_post_type() {
	
	$labels = array(
			'name'               => _x( 'Projects', 'post type general name', 'your-plugin-textdomain' ),
			'singular_name'      => _x( 'Project', 'post type singular name', 'your-plugin-textdomain' ),
			'menu_name'          => _x( 'Renegade Work', 'admin menu', 'your-plugin-textdomain' ),
			'name_admin_bar'     => _x( 'Project', 'add new on admin bar', 'your-plugin-textdomain' ),
			'add_new'            => _x( 'Add New', 'project', 'your-plugin-textdomain' ),
			'add_new_item'       => __( 'Add New Project', 'your-plugin-textdomain' ),
			'new_item'           => __( 'New Project', 'your-plugin-textdomain' ),
			'edit_item'          => __( 'Edit Project', 'your-plugin-textdomain' ),
			'view_item'          => __( 'View Project', 'your-plugin-textdomain' ),
			'all_items'          => __( 'All Projects', 'your-plugin-textdomain' ),
			//'search_items'       => __( 'Search Books', 'your-plugin-textdomain' ),
			//'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
			'not_found'          => __( 'No projects found.', 'your-plugin-textdomain' ),
			'not_found_in_trash' => __( 'No projects found in Trash.', 'your-plugin-textdomain' )
	);
	
	$args = array(
			'labels' => $labels,
			'singular_label' => __('Project'),
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'add_new_item' => __( 'Add New Project' ),
			'add_new' => __( 'Add New' ),
			'show_in_menu' => true,
			'menu_position' => 21,
			'taxonomies' => array('industry_verticals', 'service_types'),
			'show_in_admin_bar' => true,
			'capability_type' => 'post',
			//'register_meta_box_cb' => 'add_custom_meta_box',
			'hierarchical' => true,
			'rewrite' => true,
			'has_archive' => false,
			'supports' => array('title', 'custom_meta_fields', 'page_attributes', 'revisions')
	);

	register_post_type( 'projects' , $args );
	
	
}
/****************************************************************************************************************/
/*                              CREATE CLIENT POST TYPE (FOR LOGOS)                                     */
/****************************************************************************************************************/


add_action( 'init', 'create_client_post_type' );

function create_client_post_type() {

	$client_labels = array(
			'name'               => _x( 'Clients', 'post type general name', 'your-plugin-textdomain' ),
			'singular_name'      => _x( 'Client', 'post type singular name', 'your-plugin-textdomain' ),
			'menu_name'          => _x( 'Renegade Work', 'admin menu', 'your-plugin-textdomain' ),
			'name_admin_bar'     => _x( 'Clients', 'add new on admin bar', 'your-plugin-textdomain' ),
			'add_new'            => _x( 'Add New', 'project', 'your-plugin-textdomain' ),
			'add_new_item'       => __( 'Add New Client', 'your-plugin-textdomain' ),
			'new_item'           => __( 'New Client', 'your-plugin-textdomain' ),
			'edit_item'          => __( 'Edit Client', 'your-plugin-textdomain' ),
			'view_item'          => __( 'View Client', 'your-plugin-textdomain' ),
			'all_items'          => __( 'All Clients', 'your-plugin-textdomain' ),
			//'search_items'       => __( 'Search Books', 'your-plugin-textdomain' ),
			//'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
			'not_found'          => __( 'No clients found.', 'your-plugin-textdomain' ),
			'not_found_in_trash' => __( 'No clients found in Trash.', 'your-plugin-textdomain' ),
	       
	);

	$client_args = array(
			'labels' => $client_labels,
			'singular_label' => __('Client'),
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'add_new_item' => __( 'Add New Client' ),
			'add_new' => __( 'Add New' ),
			'show_in_menu' => 'edit.php?post_type=projects',
			'menu_position' => 21,
			//'taxonomies' => array('industry_verticals', 'service_types'),
			'show_in_admin_bar' => true,
			'capability_type' => 'post',
			//'register_meta_box_cb' => 'add_custom_meta_box',
			'hierarchical' => true,
			'rewrite' => true,
			'has_archive' => true,
			'supports' => array('title', 'custom_meta_fields', 'page_attributes'),
	    'publicly_queryable'  => false
	);

	register_post_type( 'clients' , $client_args );


}

/****************************************************************************************************************/
/*                              CREATE THE CUSTOM COLUMNS FOR THE POST TYPE                                      */
/****************************************************************************************************************/



//add_filter( 'manage_project_columns', 'set_custom_project_columns' );

add_filter("manage_projects_posts_columns", "add_new_project_columns");

function add_new_project_columns($columns) {
	unset(  $columns['author'], $columns['date']  );
	$columns['project_name'] = 				__( 'Project Name', 'your_text_domain' );
	//$columns['rw_logo'] = 				__( 'Logo', 'your_text_domain' );
	$columns['client_name'] = 		__( 'Client Name', 'your_text_domain' );
	//$columns['rw_industry'] = 				__( 'Industry', 'your_text_domain' );
	//$columns['rw_services'] = 				__( 'Services', 'your_text_domain' );
	//$columns['rw_blurb'] = 				__( 'Blurb', 'your_text_domain' );
	
	return $columns;
}

add_filter("manage_clients_posts_columns", "add_new_clients_columns");

function add_new_clients_columns($rc_columns) {
	unset(  $rc_columns['author'], $rc_columns['date']  );
	//$columns['client_name'] = 				__( 'Client Name', 'your_text_domain' );
	$rc_columns['clientLogo'] = 				__( 'Client Logo', 'your_text_domain' );
	//$columns['client_name'] = 		__( 'Client Name', 'your_text_domain' );
	//$columns['rw_industry'] = 				__( 'Industry', 'your_text_domain' );
	//$columns['rw_services'] = 				__( 'Services', 'your_text_domain' );
	//$columns['rw_blurb'] = 				__( 'Blurb', 'your_text_domain' );

	return $rc_columns;
}

/****************************************************************************************************************/
/*                             ADD SAVED DATA TO COLUMNS                                    */
/****************************************************************************************************************/

function clients_custom_columns($rc_columns){


//	global $post;
	//global $people_menu_items;
	//global $rp_order;
	switch ($rc_column)
	{				
		case "clientLogo":
				
			$rc_logo = get_field('clientLogo');
			$size = 'thumb';
			if( $rc_logo ) {
				//echo('<image src="' . $RPbioImage . '">');
				//echo($RPbioImage);
			//	echo wp_get_attachment_image( $rc_logo, $size );
			echo('hi');
			}
			break;

}
}
add_action('manage_clients_custom_column', 'clients_custom_columns');


/****************************************************************************************************************/
/*                              MAKE COLUMN SORTABLE BY CLIENT NAME                                      */
/****************************************************************************************************************/

add_filter( 'manage_edit-projects_sortable_columns', 'sortable_rw_column' );

function sortable_rw_column( $rw_columns ) {
	$rw_columns['title'] = 'title';
	$rw_columns['client_name'] = 'client';
	$rw_columns['project_name'] = 'project_name';
	//To make a column 'un-sortable' remove it from the array
	//unset($bg_columns['date']);

	return $rw_columns;
}


function rw_title_text_input ( $title ) {
	if ( get_post_type() == 'projects' ) {
		$title = __( 'Enter the client and project name here' );
	}
	return $title;
} // End title_text_input()

add_filter( 'enter_title_here', 'rw_title_text_input' );



/****************************************************************************************************************/
/*                              ADD TAXONOMY TO POST TYPE                                     */
/****************************************************************************************************************/


function rw_taxonomies() {

	$taxonomies = array(
		array(
			'slug'         => 'industry_verticals',
			'single_name'  => 'Industry Vertical',
			'plural_name'  => 'Industry Verticals',
			'post_type'    => 'projects',
		//	'rewrite'      => array( 'slug' => 'department' ),
		),
			
			array(
					'slug'         => 'services',
					'single_name'  => 'Services',
					'plural_name'  => 'Services',
					'post_type'    => 'projects',
					//	'rewrite'      => array( 'slug' => 'department' ),
					
			),
		array(
			'slug'         => 'service_types',
			'single_name'  => 'Service Type',
			'plural_name'  => 'Service Types',
			'post_type'    => 'projects',
			'hierarchical' => true,
		),
			
	/*	array(
					'slug'         => 'clients',
					'single_name'  => 'Client',
					'plural_name'  => 'Clients',
					'post_type'    => 'projects',
					'hierarchical' => true,
			),
		*/
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
			'menu_name' => $taxonomy['plural_name'],
		    'public' => false,

		);
		
		$rewrite = isset( $taxonomy['rewrite'] ) ? $taxonomy['rewrite'] : array( 'slug' => $taxonomy['slug'] );
		$hierarchical = isset( $taxonomy['hierarchical'] ) ? $taxonomy['hierarchical'] : true;
	
		register_taxonomy( $taxonomy['slug'], $taxonomy['post_type'], array(
			'hierarchical' => $hierarchical,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => $rewrite,
		    'public' => false,
		));
	}
	
	//ADD ABILITIY TO ASSIGN A CATEGORY TO AN IMAGE ATTACHMENT
	
	register_taxonomy_for_object_type( 'category', 'attachments' );
}
add_action( 'init', 'rw_taxonomies' );


//SET UP VISUAL GRID FOR PROJECT DISPLAY ORDER & CLIENT LOGO DISPLAY ORDER

require_once( $pluginDIR . 'saveorder.php' );
require_once( $pluginDIR . 'projects.php' );