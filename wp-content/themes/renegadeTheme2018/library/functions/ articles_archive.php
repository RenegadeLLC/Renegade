<?php

$ra_args = array(
    'post_type' => 'articles',
    'posts_per_page' => -1,
    //'orderby' => $orderby,
    'orderby'  => 'meta_value_num',
    'order' => $order,
    //'year' => $ra_year,
    'paged' => $paged,
    'max_num_pages' => 20,
    'meta_key' => $ra_date,
    'meta_query' => array(
        
        'key'		=> $ra_year,
        'compare'	=> '!=',
        'value'		=> $year,
        
    ),
    
);
if($ra_year == $year):

endif;
//$ra_loop = my_custom_query( $post_type, $taxonomy_type, $taxonomy_term, $orderby, $order, $meta_value, $year);

$ra_loop = new WP_Query( $ra_args );
    
?>