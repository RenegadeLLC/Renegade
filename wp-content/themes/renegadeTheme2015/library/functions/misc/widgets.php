<?php
/* Widgets ********************************************/

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Main Sidebar',
        'before_widget' => '<div class="widget clearfloat">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
    ));

	if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Sidebar Thin',
        'before_widget' => '<div class="widget clearfloat">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
    ));

	if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Sidebar Left',
        'before_widget' => '<div class="widget clearfloat">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
    ));

	if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Footer Left',
	    'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

	if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Footer Center',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

	if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Footer Right',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));	?>
