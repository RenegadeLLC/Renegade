<?php
/*
** this is smart script using wp core file out of the box, DO NOT touch it
*/

/*ini_set('display_errors',1);
error_reporting(E_ALL);*/

/* Loading wp core files */

$url = filter_var ($_POST['plugin_url'], FILTER_VALIDATE_URL);
$arr = explode('plugins/', $url);
$plugin_name = $arr[1];
$wp_path = dirname(__FILE__);
$generate_path = str_replace("wp-content/plugins/".$plugin_name, "wp-load.php", $wp_path);

if(file_exists($generate_path))
	require $generate_path;
else
	die('file could not be loaded '. $generate_path);

//print_r($_POST);
if(isset($_POST['plugin_url']))
{
	//loading uploader class
	include_once ("class.mailchimp.php");
	$mc = new clsMailchimp();
	
	
	$sections['header'] = $_POST['c_header'];
	$sections['main'] = $_POST['c_main'];
	$sections['sidebar'] = $_POST['c_sidebar'];
	$sections['footer'] = $_POST['c_footer'];
	
	$content = $mc -> mergeContentWithTemplate($_POST['template_id'], $sections);
	
	echo $content;
}

?>