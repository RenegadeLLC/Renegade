<?php

function build_feed(){  
    ob_start();
    $feedHTML = '';
   
    $paged = get_query_var('paged');
    
    $theme = get_template_directory(); 
    $feedHTML .= $theme;
    if(have_rows('post_feed_items')):
    while ( have_rows('post_feed_items') ) : the_row();
   
        $feed_type = get_sub_field('feed_type');
        
        if($feed_type == 'Dynamic Post Feed' || $feed_type == 'Pinned Posts and Dynamic Post Feed'):
        
            $number_of_posts_to_include = get_sub_field('number_of_posts_to_include');
            $included_post_types = get_sub_field('included_post_types');
            $post_type_array = [];
            
            if(!$number_of_posts_to_include):
            $number_of_posts_to_include = -1;
            endif;
            
            foreach($included_post_types as $post_type):
            array_push($post_type_array, $post_type);
            endforeach;
            
            
            $rpd_args = array( 'post_type' => $post_type_array, 'posts_per_page' => $number_of_posts_to_include, 'post_status' => 'publish', 'order' => 'DESC', 'orderby' => 'date', 'paged' => $paged  );
            // $rpd_args = array( 'post_type' => array('newsletters', 'articles', 'podcasts'), 'posts_per_page' => $number_of_posts_to_include, 'post_status' => 'publish', 'order' => 'DESC', 'orderby' => 'date', 'paged' => $paged  );
            
            $wp_query = new WP_Query( $rpd_args );
            
            
            $feedHTML .= '<div class="post-feed-grid grid row post-grid"><div class="grid-gutter"></div>';
            
            while ($wp_query->have_posts() ) : $wp_query->the_post();
            //use buffering to capture HTML
            
            $post_type = get_post_type();
            
            if($post_type == 'podcasts'):
            //$feedHTML .= 'podcasts';
            
            get_template_part( '/loop-templates/content', 'podcast' );
            elseif($post_type == 'newsletters'):
            $feedHTML .= 'newsletters';
            get_template_part( '/loop-templates/content', 'newsletter' );
            elseif($post_type == 'post'):
            //$feedHTML .= 'posts';
            get_template_part( '/loop-templates/content', 'post' );
            endif;
            
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
            
            //comments_template();
            
            endif;
            endwhile; // end of the loop.
        
        endif;
        
        
        $feed_content = ob_get_contents();
        $feedHTML .= $feed_content;
        //End buffering
        
        
        $feedHTML .= '</div><!-- .grid .row -->';
    endwhile;   
    endif;
    ob_end_clean();
    
    return $feedHTML;
}

