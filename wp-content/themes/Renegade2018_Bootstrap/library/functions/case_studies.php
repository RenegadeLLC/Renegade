<?php

function build_case_studies(){  
    
    $caseHTML = '';
    $caseHTML .= '<div class="grid row post-grid"><div class="grid-gutter"></div>';
    
    
    if( have_rows('case_study_items') ):  
        while ( have_rows('case_study_items') ) : the_row();
        
            $numCases = get_sub_field('number_of_case_studies_to_display');
         
            if($numCases == 'All Case Studies'):
            
                $case_args = array( 'post_type' => 'projects', 'posts_per_page' => -1 , 'orderby' => 'menu_order', /*'meta_key' => $meta_key,*/ 'order' => 'ASC');
                $case_loop = new WP_Query( $case_args );
                if(have_posts($case_loop)):
                    while ( $case_loop->have_posts() ) : $case_loop->the_post();
                        
                        $project_title = get_field('project_title');
                        $client_name = get_field('client_name');
                        $post = $client_name ;
                        setup_postdata( $post );
                        $client = get_the_title($post -> ID);
                        
                       
                        $case_url = get_permalink();
                        
                        $service_type = get_field('service_type');
                        $industry_vertical = get_field('industry_vertical');
                        $project_thumbnail_image = get_field('project_thumbnail_image');
                        $summary_headline = get_field('summary_headline');
                        $summary_text = get_field('summary_text');
                   
                        $caseHTML .= '<div class="grid-item post-item col-lg-4 col-md-4 col-sm-12 case-ct">';
                        $caseHTML .= '<a href="' . $case_url . '">';
                        $caseHTML .= '<div class="case-thumb-ct"><img src="'. $project_thumbnail_image . '" title="' . $client . ': ' . $project_title . '"></div><!-- .case-image-ct -->';
                        $caseHTML .= '<div class="case-info">' . $client . '<br>' . $project_title . '</div><!-- .case-info -->';
                        $caseHTML .= '</a></div><!-- .case-ct-->';
                    
                        wp_reset_postdata();
                    endwhile;
                endif;//end query loop for all testimonials
            elseif($numCases == 'Select Case Studies'):
            
                //start case studies repeater
                if(have_rows('case_studies')):
                    while ( have_rows('case_studies') ) : the_row();
                        
                        $case_study = get_sub_field('case_study');
                        $post = $case_study;
                        
                        setup_postdata( $post );

                        $project_title = get_field('project_title', $post -> ID);
                        $client_name = get_field('client_name', $post -> ID);
                     
                        $cpost = $client_name ;
                        setup_postdata( $cpost );
                        $client = get_the_title($cpost -> ID);
                        wp_reset_postdata();
                        $case_url = get_permalink();
                        $service_type = get_field('service_type', $post -> ID);
                        $industry_vertical = get_field('industry_vertical', $post -> ID);
                        $project_thumbnail_image = get_field('project_thumbnail_image', $post -> ID);
                        $summary_headline = get_field('summary_headline', $post -> ID);
                        $summary_text = get_field('summary_text', $post -> ID);
                        
                        $caseHTML .= '<div class="grid-item col-lg-4 col-md-4 col-sm-12 case-ct">';
                        $caseHTML .= '<a href="' . $case_url . '">';
                        $caseHTML .= '<div class="case-thumb-ct"><img src="'. $project_thumbnail_image . '" title="' . $client . ': ' . $project_title . '"></div><!-- .case-image-ct -->';
                        $caseHTML .= '<div class="case-info"><h4>' . $client . ' <span class="light-grey">' . $project_title . '</span></h4></div><!-- .case-info -->';
                        $caseHTML .= '</a></div><!-- .case-ct-->';
    
                        wp_reset_postdata();
                        
                    endwhile;
                endif;//end client-testimonial repeater
            
            endif;//end if numTestimonials is Select
            
            $caseHTML .= '</div><!-- .grid .row -->';//end grid
        
    endwhile;
endif;//end client testimonial items group
    
return $caseHTML;
}
?>
