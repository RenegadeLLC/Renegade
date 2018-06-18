<?php

/********************************************************/
/*                CREATE ADMIN AREA                     */
/********************************************************/
//$GLOBALS['RenegadePluginPath'] = plugins_url('/', __FILE__);
global $RenegadeWork_db_version;
$RenegadeWork_db_version = '1.0';

function RenegadeWork_install() {
	
global $wpdb;

 $table_name = $wpdb->prefix . 'projects_display_order';
 $charset_collate = $wpdb->get_charset_collate();

 $projects_sql = "CREATE TABLE $table_name (
 id mediumint(9) NOT NULL AUTO_INCREMENT,
 time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
 name tinytext NOT NULL,
 text text NOT NULL,
 url varchar(55) DEFAULT '' NOT NULL,
 UNIQUE KEY id (id)
 ) $charset_collate;";

$clients_table_name = $wpdb->prefix . 'clients_display_order';
$charset_collateC = $wpdb->get_charset_collate();
 
$clients_sql = "CREATE TABLE $clients_table_name (
 id mediumint(9) NOT NULL AUTO_INCREMENT,
 time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
 name tinytext NOT NULL,
 text text NOT NULL,
 url varchar(55) DEFAULT '' NOT NULL,
 UNIQUE KEY id (id)
 ) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
//dbDelta( $projects_sql );
dbDelta( $clients_sql );
add_option( 'RenegadeWork_db_version', $RenegadeWork_db_version );
 }
 
register_activation_hook( __FILE__, 'RenegadeWork_install' );

add_action('admin_menu', 'register_my_custom_submenu_page');

function register_my_custom_submenu_page() {
	
	add_submenu_page( 'edit.php?post_type=projects', 'Display Order', 'Cases and Clients Display Order', 'manage_options', 'my-custom-submenu-page', 'build_projects_func' );
}

function build_projects_func() {

//ADD ADMIN STYLING
$projectsHTML = '<style>

		#sortable { list-style-type: none; margin: 0; padding: 0; }
		#sortable li { margin:0; padding: 0px; float: left;  height: auto; font-size: 4em; }
				
		#sortableC { list-style-type: none; margin: 0; padding: 0; }
		#sortableC li { margin:0; padding: 0px; float: left;  height: auto; font-size: 4em; }
					
		.project-thumb-ct, .client-thumb-ct{
			display:block;
			text-align:center;
			float:left;
			width:100%;
			position: relative;
			overflow:hidden;
			margin:8px;
		}
		
		.project-thumb img, .client_thumb img{
			width:160px;
			height:auto;
			display:block;
			margin:0px auto;
			font-size:.3em;
		}
		
		.admin-wrapper{
			width:90%;
			max-width:800px;
			background:#fff;
			padding:12px;
			overflow:hidden;
		}
		
		h2{
			font-size:20px;
			margin:64px 0 8px 0;
		}

</style>';
	
//BUILD CASE STUDY GRID

$projectsHTML .= '<h2>Case Study Display Order</h2>';

$projectsHTML .= '<div class="admin-wrapper"><ul id="sortable">';

$project_args = array(
	'post_type' => 'projects',
	'posts_per_page' => -1 ,
	//'meta_key' => 'colorway' ,
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'post_status' => 'publish'
);

	$project_loop = new WP_Query( $project_args );

	$post_id_array;
	
	while ( $project_loop->have_posts() ) :

		$project_loop->the_post();
	
		$pd_id = '';
		$postid = get_the_ID();
		$client_cat = get_field('client_name');
		$client_name = $client_cat -> post_name;
		$project_title = get_field('project_title');
		$project_thumb = get_field('project_thumbnail_image');
	
			if($client_name != 'renegade'):
				$projectsHTML .= '<li class="ui-state-default" id="' . $postid . '"><div class="project-thumb-ct"><div class="project-thumb"><img src="' . $project_thumb . '" alt="' . $client_name . '">';
			endif;
		
		$projectsHTML .= '</li>';
	
		$projectsHTML .= '';

	endwhile;
	
	$projectsHTML .= '</ul></div>';

	
	// BUILD CLIENT GRID
	
	$projectsHTML .= '<h2>Clients Display Order</h2>';
	
	$projectsHTML .= '<div class="admin-wrapper"><ul id="sortableC">';
	/*
	 if(!$post_id_array){
	 $project_order = 'ID';
	 }else{
	 $project_order='ID';
	
	 }*/
	
	$client_args = array(
			'post_type' => 'clients',
			'posts_per_page' => -1 ,
			//'meta_key' => 'colorway' ,
			'orderby' => 'menu_order',
			'order' => 'ASC'
	);
	
	
	$client_loop = new WP_Query( $client_args );
	
	$client_id_array;

	while ( $client_loop->have_posts() ) :
	
		$client_loop->the_post();
		
		$cl_id = '';
		$clientid = get_the_ID();
		$client_name = get_the_title($clientid);
		$client_logo= get_field('clientLogo');		
		
		if( have_rows('client_testimonial') ):
        		while ( have_rows('client_testimonial') ) : the_row();
            		$first_name = get_sub_field('first_name');
            		$last_name = get_sub_field('last_name');
            		$job_title = get_sub_field('job_title');
            		$client_name = get_the_title;
            		$quote_text = get_sub_field('quote_text');
        		endwhile;
        	endif;//end if have client testimonial
		
		if($client_name != 'Renegade'):
				$projectsHTML .= '<li class="ui-state-default" id="' . $clientid . '"><div class="client-thumb-ct"><div class="client-thumb"><img src="' . $client_logo . '" alt="' . $client_name . '">';
				$projectsHTML .= '</div></li>';
			endif;
		
		$projectsHTML .= '';
	
	endwhile;
	
	$projectsHTML .= '</ul></div>';
	
	echo $projectsHTML;
	wp_reset_postdata();
}

//add_action('save_post', 'change_title');
/*
function set_menu_order($post_id) {
	//$time = get_field('time',$post_id);
	//$post_title = 'Topic created at '. $time;
	wp_update_post(array('menu_order' => $post_id));
}*/


?>