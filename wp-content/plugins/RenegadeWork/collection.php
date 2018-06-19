<?php

/********************************************************/
/*                CREATE ADMIN AREA                     */
/********************************************************/
//$GLOBALS['RenegadePluginPath'] = plugins_url('/', __FILE__);
global $RenegadeWork_db_version;
$RenegadeWork_db_version = '1.0';

 function RenegadeWork_install() {
 global $wpdb;
 global $RenegadeWork_db_version;

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

 require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
 dbDelta( $projects_sql );

 add_option( 'RenegadeWork_db_version', $RenegadeWork_db_version );
 }
 register_activation_hook( __FILE__, 'RenegadeWork_install' );

// CREATE COLLECTION FUNCTIONALITY


add_action('admin_menu', 'register_my_custom_submenu_page');

function register_my_custom_submenu_page() {
	
	add_submenu_page( 'edit.php?post_type=projects', 'Projects Display Order', 'Display Order', 'manage_options', 'my-custom-submenu-page', 'build_projects_func' );
}


function build_projects_func() {

// QUERY PRODUCT POSTS


$projectsHTML = '';
$projectsHTML .= '<style>
		
#sortable { list-style-type: none; margin: 0; padding: 0; }
#sortable li { margin:0; padding: 0px; float: left;  height: auto; font-size: 4em; }
		
		
.project-thumb-ct{
	display:block;
	text-align:center;
	float:left;
	width:100%;
	position: relative;
	overflow:hidden;
	margin:8px;

}

.project-thumb img{
	width:90px;
	height:auto;
	display:block;
	margin:0px auto;
}
		
.admin-wrapper{
		width:90%;
		max-width:600px;
		background:#fff;
		padding:12px;
		overflow:hidden;
}
		
.bt-blue {
	background-color: #2EA2CC;
	border-color: #0074A2;
	color: #fff !important;
	border-radius: 3px;
	height: 28px;
	padding: 0 11px 1px;
	cursor: pointer;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	color: #333;
	font-weight: normal;
	font-size: 13px;
	line-height: 26px;
	text-align: center;
	text-decoration: none;
	display:inline-block;

}
		
</style>';


$projectsHTML .= '<div class="admin-wrapper"><ul id="sortable">';

if(!$post_id_array){
	$project_order = 'ID';
}else{
	$project_order='ID';
	
}

$project_args = array( 
		'post_type' => 'projects', 
		'posts_per_page' => -1 , 
		//'meta_key' => 'colorway' ,
		'orderby' => 'menu_order', 
		'order' => 'ASC'	
);


$project_loop = new WP_Query( $project_args );

$post_id_array;
//var_dump($project_loop->request);
while ( $project_loop->have_posts() ) : 

$project_loop->the_post();
//SET POST VARIABLES
/*
$pd_id = '';
$postid = get_the_ID();
$pd_design = get_field('design');
$pd_design_name = $pd_design->name;
$pd_colorway = get_field('colorway');
$pd_title = $pd_design_name . ' ' . $pd_colorway;
$pd_project_image = get_field('project_image');

$pd_project_thumb = substr_replace($pd_project_image, '-357x489.jpg', -4);
$pd_size = 'Preview';
$pd_material = get_field('material');
$pd_knots = get_field('knots');
$pd_custom_availability = get_field('custom_availability');
$pd_design_inspiration = get_field('design_inspiration');
$pd_color_swatch = get_field('color_swatch');
$pd_tearsheet = get_field('tearsheet');
*/


$projectsHTML .= '<li class="ui-state-default" id="' . $postid . '"><div class="project-thumb-ct"><div class="project-thumb"><img src="' . $pd_project_thumb . '" alt="' . $pd_title . '">';

//$projectsHTML .= '<li class="ui-state-default"><div class="project-thumb-ct"><div class="project-thumb">' . $project_image ;


//$projectsHTML .= '<div class="project-thumb-name">' . $pd_design_name;
//$projectsHTML .= '<span class="colorway"> ' . $pd_colorway . $postid . '</span></div></li>';
$projectsHTML .= '</li>';

$projectsHTML .= '';
//echo($pd_design_name);

endwhile;
$projectsHTML .= '</ul></div>';
//var_dump($post_id_array);
//var_dump($post_id_array);
$projectsHTML .= '<button class="bt-blue" id="save_order"/>Save Order</button>';
//$projectsHTML .= '<div class="bt-blue">Save Order</div>';

echo $projectsHTML;
wp_reset_postdata();
}
//add_action('save_post', 'change_title');

function set_menu_order($post_id) {
	//$time = get_field('time',$post_id);
	//$post_title = 'Topic created at '. $time;
	wp_update_post(array('menu_order' => $post_id));
}
?>
