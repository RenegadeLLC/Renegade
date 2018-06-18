<?php

//define shortcode directory
define('SHORTCODES', TEMPLATEPATH . '/library/shortcodes/');

//import shortcode files
require_once( SHORTCODES . 'articles.php' );
require_once( SHORTCODES . 'columns.php' );
require_once( SHORTCODES . 'graphic_elements.php' );
require_once( SHORTCODES . 'get_recent_post.php' );
require_once( SHORTCODES . 'get_archives.php' );
require_once( SHORTCODES . 'get_categories.php' );
require_once( SHORTCODES . 'get_tags.php' );
require_once( SHORTCODES . 'ribbon_highlight.php' );



//register the shortcodes
//inline register column shortcodes in column.php since there are a lot
add_shortcode('article', 'article_func');
add_shortcode('one_half', 'one_half_func');
add_shortcode('one_half_last', 'one_half_last_func');
add_shortcode('col_inner', 'col_inner_func');
add_shortcode('three_cols', 'three_cols_func');
add_shortcode('three_cols_inner', 'three_cols_inner_func');
add_shortcode('dec1', 'dec1_func');
add_shortcode('ribbon_highlight', 'ribbon_highlight_func');
add_shortcode('arrow_highlight', 'arrow_highlight_func');
add_shortcode('circ', 'circ_func');
add_shortcode('recentPost', 'get_recent_func');
add_shortcode('archives', 'get_archives_func');
add_shortcode('categories', 'get_categories_func');
add_shortcode('tags', 'get_tags_func');
//add_shortcode('ribbonR', 'ribbon_right');
//add_shortcode('ribbonL', 'ribbon_left');
?>