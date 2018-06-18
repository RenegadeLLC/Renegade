<?php /******************  BUILD SIDEBAR *********************/

$sidebarHTML = '';

$sidebar_item = get_field('sidebar_item');


if( have_rows('sidebar_item') ):

while ( have_rows('sidebar_item') ) : the_row();
//if( have_rows('sidebar_item', get_option('page_for_posts')) ):

//while ( have_rows('sidebar_item', get_option('page_for_posts')) ) : the_row();

$sidebar_headline = get_sub_field('sidebar_headline');
$sidebar_content_type = get_sub_field('sidebar_content_type');
$signup_form_shortcode = get_sub_field('signup_form_shortcode');
$sidebar_custom_content = get_sub_field('sidebar_custom_content');
$sidebar_image = get_sub_field('sidebar_image');
$background_color = get_sub_field('background_color');
$sidebar_background_image = get_sub_field('sidebar_background_image');
$sidebar_headline_color = get_sub_field('sidebar_headline_color');
$text_color = get_sub_field('text_color');
$link_color = get_sub_field('link_color');
$circle_background = get_sub_field('circle_background');
$highlight_text = get_sub_field('highlight_text');

if($sidebar_content_type == 'Subscribe to List' ):
	//if($add_subscribe_form == 'Yes'):		
		$subscribe = do_shortcode( $subscribe_form_shortcode );
		$sidebarHTML .= '<div class="sidebar-item subscribe" style="background-color:' . $form_background_color . ';">';
		$sidebarHTML .= '<h1>' . $form_name . '</h1>';
		$sidebarHTML .= $subscribe;
		$sidebarHTML .= '</div><!-- .grid-item-->';
	//endif;

endif;

if($sidebar_content_type == 'Archives' ):

//GET POST CATEGORIES
$sidebarHTML .= '<div class="sidebar-item" style="background-color:' .$background_color. '; color:' . $text_color . ';"><h1>Archives</h1><div class="sidebar-content categories-list">';

//$sidebarHTML .= '<div class="sidebar-item"><h1>Archives</h1><div class="sidebar-content categories-list">';

//$archives = do_shortcode( '[list_archives type="monthly" format="custom" post_type="newsletters"]' );


$before= '<div class="archive-link">';
$after='</div>';

$args = array(
		'type'            => $archive_type,
		'limit'           => '',
		'format'          => 'html',
		'before'          => $before,
		'after'           => $after,
		//'before'          => 'hi',
		//'after'           => 'bye',
		'show_post_count' => false,
		'echo'            => 0,
		'order'           => 'DESC',
		'post_type'     => $post_type
);
$archives = wp_get_archives( $args );
//$archives = wp_custom_archive($args);
$sidebarHTML .= $archives . '</div></div>';

endif;

if($sidebar_content_type == 'Categories' ):

$sidebarHTML .= '<div class="sidebar-item" style="background-color:' . $background_color . '; color:' . $text_color . ';">';

//GET POST CATEGORIES
$sidebarHTML .= '<h1>Categories</h1><div class="sidebar-content tags-list">';

$categories = do_shortcode( '[list_categories]' );

$sidebarHTML .= $categories . '</div></div>';

endif;

if($sidebar_content_type == 'Text Highlight'):
$sidebarHTML .= '<div class="sidebar-item square" style="background-color:' .$background_color. '; color:' . $text_color . ';">';
$sidebarHTML .= '<div class="circle" style="background-color:' . $circle_background . ';">';
$sidebarHTML .= '<div class="vert-center-outer"><div class="vert-center-inner text-highlight">';
$sidebarHTML .= $highlight_text;
$sidebarHTML .= '</div><!--.vert inner--></div><!--.vert outer-->';
$sidebarHTML .= '</div></div>';
endif;
$sidebarHTML .= '</div>';
endwhile;
endif;

return $sidebarHTML;

		?>