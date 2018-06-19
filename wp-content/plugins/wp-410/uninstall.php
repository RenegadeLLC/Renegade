<?php 
if( !defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') ) 
	exit;

function remove_wp_410_table(){
	global $wpdb;
	$table = $wpdb->prefix . '410_links';
	$wpdb->query( "DROP TABLE $table;" );
}

remove_wp_410_table();
delete_option( 'wp_410_options_version' );
delete_option( 'wp_410_max_404s' );
