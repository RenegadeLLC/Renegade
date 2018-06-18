<?php

//define shortcode directory
define('FUNCTIONS', TEMPLATEPATH . '/library/functions/');

//import shortcode files
require_once( FUNCTIONS . 'get_recent_post.php' );
require_once( FUNCTIONS . 'rss_feed.php' );
require_once( FUNCTIONS . 'get_archivesNEW.php' );
require_once( FUNCTIONS . 'get_categories.php' );
require_once( FUNCTIONS . 'get_tags.php' );
require_once( FUNCTIONS . 'get_archives_noList.php' );


//register the shortcodes
add_shortcode('recent_post', 'get_recent_func');
add_shortcode('recent_rss', 'get_rss_func');
add_shortcode('list_archives', 'get_archives_func');
add_shortcode('archives_noList', 'get_archives_no_list_func');
add_shortcode('list_categories', 'get_categories_func');
add_shortcode('list_tags', 'get_tags_func');
?>