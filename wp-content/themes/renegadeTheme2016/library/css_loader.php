<?php


add_action('wp_enqueue_scripts', 'renegade_stylesheets');

function renegade_stylesheets() {
	
	$scriptdirCSS = get_template_directory_uri() . '/library/css/';
	
	
	//wp_register_style('headerFooter', $scriptdirCSS . 'header_footer.css');
	//wp_enqueue_style('headerFooter');
	wp_register_style('master', $scriptdirCSS . 'new_master.css');
	wp_enqueue_style('master');
	
	wp_register_style('menu', $scriptdirCSS . 'jquery.mmenu.all.css');
	wp_enqueue_style('menu');
	
	//wp_register_style('main', $scriptdirCSS . 'main.css');
	//wp_enqueue_style('main');
	
	//wp_register_style('modules', $scriptdirCSS . 'modules.css');
	//wp_enqueue_style('modules');
	
	wp_register_style('responsive', $scriptdirCSS . 'responsive.css');
	wp_enqueue_style('responsive');

	//wp_register_style('navigation', $scriptdirCSS . 'navigation.css');
	//wp_enqueue_style('navigation');

	wp_register_style('fonts', $scriptdirCSS . 'fonts.css');
	wp_enqueue_style('fonts');
	
	wp_register_style('fontAwesome', $scriptdirCSS . 'font-awesome.css');
	wp_enqueue_style('fontAwesome');
	
	wp_register_style('colorsCSS', $scriptdirCSS . 'colors.css');
	//wp_enqueue_style('colorsCSS');
	
	wp_register_style('editorStyles', $scriptdirCSS . 'editor_styles.css');
	//wp_enqueue_style('editorStyles');


	
}




?>
