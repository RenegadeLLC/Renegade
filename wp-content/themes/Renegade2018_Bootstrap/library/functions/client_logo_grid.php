<?php

function make_logo_grid(){  
    $clientsHTML = '';
    $clientsHTML .= '<div class="wrapper" style="background:#fff;">';
    $clientsHTML .= '<div class="client-logo-grid grid row" style="background-color:#fff;"><div class="grid-gutter"></div>';
    
    if( have_rows('client_logo_grid') ):
    $i=1;
    
    while ( have_rows('client_logo_grid') ) : the_row();

    $numLogos = get_sub_field('number_of_logos_to_display');
    
    if($numLogos == 'All Logos'):

        $rc_args = array( 'post_type' => 'clients', 'posts_per_page' => -1 , 'orderby' => 'menu_order', /*'meta_key' => $meta_key,*/ 'order' => 'ASC');
        $rc_loop = new WP_Query( $rc_args );
        
        if(have_posts($rc_loop)):
        while ( $rc_loop->have_posts() ) : $rc_loop->the_post();
            $client_name = get_the_title();
            $client_id = get_the_ID();
            $client_logo = get_field('clientLogo');
            $industry_vertical = get_field('industry_vertical');
            $case_study = get_field('case_study');
            $case_study_url = get_field('case_study_url');
            //$industry_vertical_name = $industry_vertical -> name;
            if($client_name != 'Renegade'):
                  $clientsHTML .= '<div class="client-grid-item col-lg-3 col-md-4 col-sm-6 col-xs-6';
              
                $clientsHTML .= '">';
                
                if($case_study == 'Yes'):
                    $clientsHTML .= '<a href="' . $case_study_url . '">';
                endif;
                
                $clientsHTML .= '<div class="client-logo-border"></div><div class="client-logo"><img src="' . $client_logo . '" alt=""></div></div>';
                
                if($case_study == 'Yes'):
                    $clientsHTML .= '</a>';
                endif;
            endif;
            $i++;
            wp_reset_postdata();
        endwhile;
    endif;//end main query for all
    elseif($numLogos == 'Select Logos'):
  $i = 1;
        if(have_rows('client_logo')):
            while ( have_rows('client_logo') ) : the_row();   
                $client = get_sub_field('client');
                $post = $client;
                setup_postdata( $post );
                $client_logo = get_field('clientLogo', $post);
                $case_study = get_field('case_study', $post);
                
                $clientsHTML .= '<div class="client-grid-item col-lg-3 col-md-3 col-sm-6 col-xs-6 ';
            
                $clientsHTML .= '">';
               //$clientsHTML .= '<div class="grid-sizer grid-item col-lg-3 col-md-3 col-sm-6">';
               if($case_study == 'Yes'):
                    $case_study_url = get_field('case_study_url', $post);
                    $clientsHTML .= '<a href="' . $case_study_url . '">';
               endif;
               $clientsHTML .= '<img src="' . $client_logo .'">';
               if($case_study == 'Yes'):
                    $clientsHTML .= '</a>';
               endif;
               $clientsHTML .= '</div><!-- .client-grid-item -->';
               $i++;
                wp_reset_postdata();
            endwhile;
        endif;
    
    endif;
    
    
    $clientsHTML .= '</div>';//end grid
    $clientsHTML .= '</div><!-- .wrapper -->';
    endwhile;
    endif;
    return $clientsHTML;
}

