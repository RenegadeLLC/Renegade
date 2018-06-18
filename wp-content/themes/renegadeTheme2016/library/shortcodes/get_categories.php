<?php 


function get_categories_func($atts, $content = null){

$category_args = array(
	'type'                     => 'post',
	'child_of'                 => 0,
	'parent'                   => '',
	'orderby'                  => 'name',
	'order'                    => 'ASC',
	'hide_empty'               => 1,
	'hierarchical'             => 1,
	'exclude'                  => '',
	'include'                  => '',
	'number'                   => '',
	'taxonomy'                 => 'category',
	'pad_counts'               => false 

); 

$categories = get_categories( $category_args );

$category_list;

foreach ( $categories as $category ) {
	$category_list .= '<h5><a href="' . get_category_link( $category->term_id ) . '">' . $category->name . '</a></h5>';
}


return $category_list;


}

 ?>