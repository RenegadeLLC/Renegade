<?php

function do_bio($team_member, $headlineHTML){  
    
    $bioHTML = '';
   
   
    $post = $team_member;
    setup_postdata( $post );
    
    $rp_first_name= get_field('rp_first_name', $post);
    $rp_last_name = get_the_title($post);
    $rp_job_title = get_field('rp_job_title', $post);
    $rp_bio_image = get_field('rp_bio_image', $post);
    $rp_short_bio = get_field('rp_short_bio', $post);
    $rp_email_address = get_field('rp_email_address', $post);
    
    $bioHTML .= '<div class="feature-bio-ct">';
    $bioHTML .= '<div class="col-lg-6 col-md-6 col-sm-12 fleft bio-highlight-left">'. $headlineHTML;
    $bioHTML .= '<div class="bio-image-ct"><img src="' . $rp_bio_image . '" alt="' . $rp_first_name . ' ' . $rp_last_name .  '"></div><!-- .bio-image-ct -->';
    $bioHTML .= '</div><!-- .w-50 -->';
    
    $bioHTML .= '<div class="col-lg-6 col-md-6 col-sm-12 fleft">';
    $bioHTML .= '<div class="text-ct">';
    $bioHTML .= '<h2 class="black">' . $rp_first_name . ' ' . $rp_last_name . '</h2>';
    $bioHTML .= '<div class="bio">' . $rp_short_bio;
    $bioHTML .= '<div class="bt-black"><a href="mailto:' . $rp_email_address . '">' . 'Contact ' . $rp_first_name . '</a></div><!-- .bt-black -->';
    
    
    $bioHTML .= '</div><!-- .text-ct --></div><!-- .bio -->';
    
    $bioHTML .= '</div><!-- .w-50 -->';
    $bioHTML .= '</div><!-- .feature-bio-ct-->';
    return $bioHTML;
}

