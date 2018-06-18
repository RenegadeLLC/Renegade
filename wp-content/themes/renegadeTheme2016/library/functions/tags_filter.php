<?php

function tags_filter() {
	$tax = 'post_tag';
	$terms = get_terms( $tax );
	$count = count( $terms );

    if ( $count > 0 ): ?>
    
        <?php
        foreach ( $terms as $term ) {
            $term_link = get_term_link( $term, $tax );
            echo '<a href="' . $term_link . '" class="tax-filter" title="' . $term->slug . '">' . $term->name . '</a> ';
        } ?>
       
    <?php endif;
}

?>