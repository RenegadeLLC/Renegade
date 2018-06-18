<?php

function build_testimonials(){  
    
    $testimonialHTML = '<br>';
    
    $testimonialHTML .= '<div class="grid row post-grid"><div class="grid-gutter"></div>';
    
    if( have_rows('client_testimonial_items') ):  
        while ( have_rows('client_testimonial_items') ) : the_row();
        
        $numTestimonials = get_sub_field('number_of_testimonials_to_display');
        
        if($numTestimonials == 'All Testimonials'):
        
           $testimonial_args = array( 'post_type' => 'clients', 'posts_per_page' => -1 , 'orderby' => 'menu_order', /*'meta_key' => $meta_key,*/ 'order' => 'ASC'); 
           $testimonial_loop = new WP_Query( $testimonial_args );
           
            if(have_posts($testimonial_loop)):
            
             while ( $testimonial_loop->have_posts() ) : $testimonial_loop->the_post();
            
             
                $client_name = get_the_title();
                $client_id = get_the_ID();
                $client_logo = get_field('clientLogo');
                $industry_vertical = get_field('industry_vertical');
                $case_study = get_field('case_study');
                
               
                   if(have_rows('client_testimonial')):
                   while(have_rows('client_testimonial')) : the_row();
                        $first_name = get_sub_field('first_name');
                        $last_name = get_sub_field('last_name');
                        $job_title = get_sub_field('job_title');
                        $quote_text = get_sub_field('quote_text');

                        $testimonialHTML .= '<div class="grid-item col-lg-6 col-md-6 col-sm-12">';
                       
                        $testimonialHTML .= '<div class="testimonial-ct">';
                        $testimonialHTML .=  '<div class="open-quote"></div>';
                        $testimonialHTML .=  '<div class="quote-text">' . $quote_text . '</div><!-- .quote-text -->';
                        $testimonialHTML .=  '<div class="quote-attrib"><span class="bold">' . $first_name . ' ' . $last_name . ',</span><br>';
                        
                            if($job_title):
                                $testimonialHTML .= $job_title .'<br>';
                            endif;
                            
                        $testimonialHTML .= $client_name  . '</div><!-- .quote-attrib -->';
                        $testimonialHTML .=  '<div class="close-quote"></div>';
                        $testimonialHTML .= '</div><!-- . testimonial-ct --></div><!-- .grid-item -->';
            
                    endwhile;
                endif;
            endwhile;//end query loop for all testimonials
            wp_reset_postdata();
        endif;
        elseif($numTestimonials == 'Select Testimonials'):
        
            //start client testimonials repeater
            if(have_rows('client_testimonials')):
                while ( have_rows('client_testimonials') ) : the_row();
                    
                    $client = get_sub_field('client');
                    $post = $client;
                    setup_postdata( $post );
                
                    
                    if(have_rows('client_testimonial', $post -> ID)):
                        while(have_rows('client_testimonial', $post -> ID)): the_row();
                            
                            $client_name = get_the_title($post -> ID);
                            $first_name = get_field('first_name');
                            $last_name = get_sub_field('last_name');
                            $job_title = get_sub_field('job_title');
                            $quote_text = get_sub_field('quote_text');
                            
                            $testimonialHTML .= '<div class="grid-item col-lg-6 col-md-6 col-sm-12"><div class="testimonial-ct">';
                            $testimonialHTML .=  '<div class="open-quote"></div>';
                            $testimonialHTML .=  '<div class="quote-text">' . $quote_text . '</div><!-- .quote-text -->';
                            $testimonialHTML .=  '<div class="quote-attrib">' . $first_name . ' ' . $last_name . ',<br>';
                            
                                if($job_title):
                                    $testimonialHTML .= $job_title .'<br>';
                                endif;
                            
                            $testimonialHTML .= $client_name  . '</div><!-- .quote-attrib -->';
                            $testimonialHTML .= '</div><!-- . testimonial-ct --></div><!-- .grid-item -->';
                            
                        endwhile;
                      
                    endif;
                    wp_reset_postdata();
                endwhile;
            endif;//end client-testimonial repeater
        
        endif;//end if numTestimonials is Select
        
        $testimonialHTML .= '</div><!-- .grid .row -->';//end grid
        
    endwhile;
endif;//end client testimonial items group

return $testimonialHTML;
}
?>
