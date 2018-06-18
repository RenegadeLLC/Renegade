<?php

function build_subscribe_form($subscribe_form_shortcode, $headlineHTML){  
    
    $subscribeHTML = '';
   
    $subscribeHTML .= '<div class="col-lg-6 col-sm-12 float-left">' . $headlineHTML . '</div>';
    $subscribeHTML .= '<div class="col-lg-6 col-sm-12 float-left">' . do_shortcode($subscribe_form_shortcode) . '</div>';
    
    return $subscribeHTML;
}

?>