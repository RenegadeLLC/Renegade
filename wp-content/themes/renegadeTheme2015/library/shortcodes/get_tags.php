<?php 


function get_tags_func($atts, $content = null){

$tag_args = array(


); 

$tags = get_tags( $tag_args  );

$tag_list;

foreach ( $tags as $tag ) {
	
	
	$tag_list .= '<h5><a href="' . get_tag_link( $tag->term_id ) . '">' . $tag->name . '</a></h5>';
}


//return $tag_list;
//var_dump ($tags);
return $tag_list;

}

 ?>