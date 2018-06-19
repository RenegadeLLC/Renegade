<?php

/*
 Plugin Name: Renegade People
Plugin URI:
Description: Custom Post Type for Renegade People
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

add_action( 'init', 'create_people_post_type' );

function create_people_post_type() {
	
	$labels = array(
			'name'               => _x( 'People', 'post type general name', 'your-plugin-textdomain' ),
			'singular_name'      => _x( 'Person', 'post type singular name', 'your-plugin-textdomain' ),
			'menu_name'          => _x( 'Renegade People', 'admin menu', 'your-plugin-textdomain' ),
			'name_admin_bar'     => _x( 'Person', 'add new on admin bar', 'your-plugin-textdomain' ),
			'add_new'            => _x( 'Add New', 'people', 'your-plugin-textdomain' ),
			'add_new_item'       => __( 'Add New Person', 'your-plugin-textdomain' ),
			'new_item'           => __( 'New Person', 'your-plugin-textdomain' ),
			'edit_item'          => __( 'Edit Person', 'your-plugin-textdomain' ),
			'view_item'          => __( 'View Person', 'your-plugin-textdomain' ),
			'all_items'          => __( 'All People', 'your-plugin-textdomain' ),
			//'search_items'       => __( 'Search Books', 'your-plugin-textdomain' ),
			//'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
			'not_found'          => __( 'No people found.', 'your-plugin-textdomain' ),
			'not_found_in_trash' => __( 'No people found in Trash.', 'your-plugin-textdomain' )
	);
	
	$args = array(
			'labels' => $labels,
			'singular_label' => __('Person'),
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'add_new_item' => __( 'Add New Person' ),
			'add_new' => __( 'Add New' ),
			'show_in_menu' => true,
			'menu_position' => 22,
			'taxonomies' => array('category', 'post_tag'),
			'show_in_admin_bar' => true,
			'capability_type' => 'page',
			//'register_meta_box_cb' => 'add_custom_meta_box',
			'hierarchical' => true,
			'rewrite' => true,
			'supports' => array('title', 'rp_first_name', 'rp_job_title', 'rp_image', 'rp_social', 'rp_socialURL', 'rp_email', 'rp_phone', 'rp_fun_fact', 'rp_fun_fact_image', 'rp_fun_fact_cta', 'custom_meta_fields', 'custom-fields', 'revisions')
	);

	register_post_type( 'people' , $args );
}


/****************************************************************************************************************/
/*                              DETERMINE PAGE ORDER BY CUSTOM MENU                                     */
/****************************************************************************************************************/
// Menu item IDs

function whereAmI($page_id){
	
	$people_menu = 'people';

	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $people_menu ] ) ) {

		$people_menu_list = wp_get_nav_menu_object( $locations[ $people_menu ] );
		$people_menu_items = wp_get_nav_menu_items($people_menu_list->term_id);
		
		foreach ( (array) $people_menu_items as $key => $menu_item ) {
			$people_order[] = get_post_meta( $menu_item->ID, '_menu_item_object_id', true );
		}

		$thisPerson =  array_search($page_id, $people_order);

		echo $thisPerson;
	}
	
}
//add_action(init, 'whereAmI');

/****************************************************************************************************************/
/*                              CREATE THE CUSTOM COLUMNS FOR THE POST TYPE                                      */
/****************************************************************************************************************/



//add_filter( 'manage_people_columns', 'set_custom_people_columns' );

add_filter("manage_people_posts_columns", "add_new_people_columns");

function add_new_people_columns($rp_columns) {
	unset(  $rp_columns['author'], $rp_columns['date'], $rp_columns['categories'], $rp_columns['tags']  );
	//$rp_columns['people_name'] = 				__( 'Person Name', 'your_text_domain' );
	$rp_columns['id'] =							 __('ID');
	
	$rp_columns['rp_first_name'] =				__( 'First Name', 'your_text_domain' );
	$rp_columns['rp_job_title'] = 		__( 'Job Title', 'your_text_domain' );
	$rp_columns	['menu_order'] = 				__('Order', 'your_text_domain' );
	$rp_columns['rp_bio_image'] = 				__( 'Bio Image', 'your_text_domain' );
//	$rp_columns['rp_social'] = 				__( 'Social Channel', 'your_text_domain' );
//	$rp_columns['rp_fun_fact_image'] = 				__( 'Fun Fact Image', 'your_text_domain' );
	//$rp_columns['rp_order'] = 				__( 'Order', 'your_text_domain' );
	
	
	return $rp_columns;
}


/****************************************************************************************************************/
/*                              MAKE COLUMN SORTABLE BY CLIENT NAME                                      */
/****************************************************************************************************************/
add_filter( 'manage_edit-people_sortable_columns', 'sortable_rp_column' );

function sortable_rp_column( $rp_columns ) {
	
	$rp_columns['title'] = 'title';
	//$rp_columns['id'] = __('ID');
	$rp_columns	['menu_order'] = "Order";
	$rp_columns['rp_first_name'] = 'rp_first_name';
	$rp_columns['rp_job_title'] = 'rp_job_title';
//	$rp_columns['rp_social'] = 'rp_social';
//	$rp_columns['rp_socialURL'] = 'rp_socialURL';
//	$rp_columns['rp_emailL'] = 'rp_email';
//	$rp_columns['rp_phone'] = 'rp_phone';
	$rp_columns['rp_order'] = 'rp_order';
//	$rp_columns['rp_fun_fact'] = 'rp_fun_fact';
//	$rp_columns['rp_cta'] = 'rp_cta';
	//To make a column 'un-sortable' remove it from the array
	//unset($bg_columns['date']);

	return $rp_columns;
}


/****************************************************************************************************************/
/*                              LOAD CLIENT DATA PREVIOUSLY ENTERED                                      */
/****************************************************************************************************************/

add_action('manage_pages_custom_column', 'people_custom_columns');

function people_custom_columns($rp_column){
	
	

	global $post;
	global $people_menu_items;
	global $rp_order;
	switch ($rp_column)
	{
		
		case "id":
			
			$id = get_the_ID(); 
			//$peopleNum = array_search($post, $people_menu_items);
			echo($id);
				
			break;

		case "menu_order":
			
			$id = get_the_ID();
			
			$rp_order= whereAmI($id);
			echo $rp_order;
			
			break;
			
		case "rp_first_name":

			$RPfirstName = get_field('rp_first_name');
	
			if( $RPfirstName ) {
				echo($RPfirstName);
			} 
			break;
				
		case "rp_job_title":
			
			$RPjobTitle = get_field('rp_job_title');
			
			if( $RPjobTitle) {
					echo($RPjobTitle); 
			} 
			break;
			
		case "rp_bio_image":
					
				$RPbioImage = get_field('rp_bio_image');
				$size = 'thumb';
				if( $RPbioImage) {
					//echo('<image src="' . $RPbioImage . '">');
					//echo($RPbioImage);
					echo wp_get_attachment_image( $RPbioImage, $size );
				}
				break;
				
		case "rp_social":
			$RPsocial = get_field('rp_social_channel');
			
			if( $RPsocial) {
				echo($RPsocial);
			}
			break;
			
		
		case "rp_fun_fact_image":
						
					$RPfunImage = get_field('rp_fun_fact_image');
					$size = 'thumb';
					if( $RPfunImage) {
						//echo('<image src="' . $RPbioImage . '">');
						//echo($RPbioImage);
						echo wp_get_attachment_image( $RPfunImage, $size );
					}
					break;
					
			case "rp_order":
					
						$RPorder= get_field('rp_order');
						if( $RPorder) {
							echo($RPorder);
						}
						break;

	}
	
	
}

/****************************************************************************************************************/
/*                              ADD EDIT LINKS TO CLIENT NAME COLUMN                                      */
/****************************************************************************************************************/




function rp_title_text_input ( $title ) {
	if ( get_post_type() == 'people' ) {
		$title = __( 'Enter the last name here' );
	}
	return $title;
} // End title_text_input()
add_filter( 'enter_title_here', 'rp_title_text_input' );



