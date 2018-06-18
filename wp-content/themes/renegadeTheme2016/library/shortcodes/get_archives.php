<?php 


function get_archives_func($atts, $content = null){

$archive_args = array(
	'type'            => 'monthly',
	'limit'           => '',
	'format'          => 'custom', 
	'before'          => '<h5>',
	'after'           => '</h5>',
	'show_post_count' => false,
	'echo'            => 1,
	'order'           => 'DESC'
); 

return(wp_get_archives( $archive_args ));

}

 ?>