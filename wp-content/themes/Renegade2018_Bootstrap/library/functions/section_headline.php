<?php


$headlineHTML = '';

if( have_rows('section_headline_items') ):
    while ( have_rows('section_headline_items') ) : the_row();
    
    $headline_background_image = get_sub_field('headline_background_image');
    $text_align = get_sub_field('text_align');
    
    $headlineHTML .= '<div class="section-headline-ct" style="text-align:' . $text_align . ';';
     if($headline_background_image):
        $headlineHTML .= ' background-image:url(' . $headline_background_image . ');';
     endif;
    
    $headlineHTML .= '">';
    //add invisible bk image to set div height
    $headlineHTML .= '<img src="' . $headline_background_image . '" class="heightSet" />';
    $headlineHTML .= '<div class="section-headline-text">';
    if( have_rows('section_headine_text') ):
    
    while ( have_rows('section_headine_text') ) : the_row();
    $text = get_sub_field('text');
    $text_color = get_sub_field('text_color');
    $text_size = get_sub_field('text_size');
    
    $headlineHTML .= '<' . $text_size. ' style="color:' . $text_color . ';">';
    $headlineHTML .= $text;
    $headlineHTML .= '</' . $text_size . '>';
    endwhile;//END HEADLINE TEXT REPEATER WHILE
    
    endif;//END HEADLINE TEXT REPEATER IF
    $headlineHTML .= '</div><!--.section-headline-text -->';
    $headlineHTML .= '</div><!--.section-headline-ct -->';
    
    endwhile;
endif;

?>
