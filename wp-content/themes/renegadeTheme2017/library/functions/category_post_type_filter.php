<?php 
add_action( 'restrict_manage_posts', 'my_restrict_manage_posts' );
function my_restrict_manage_posts() {
	global $typenow;
	$taxonomy = 'your_custom_taxonomy_name';
	if( $typenow != "page" && $typenow != "post" ){
		$filters = array($taxonomy);
		foreach ($filters as $tax_slug) {
			$tax_obj = get_taxonomy($tax_slug);
			$tax_name = $tax_obj->labels->name;
			$terms = get_terms($tax_slug);
			echo "";
		}
	}
}

?>