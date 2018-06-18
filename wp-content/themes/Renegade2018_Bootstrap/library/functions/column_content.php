<?php

function get_column_content($column_name, $column_width){  

    $columnHTML = '';
    
    $column_content = get_sub_field($column_name);
    
    $customize_column_background = $column_content['customize_column_background'];
    
    if($customize_column_background == 'Yes'):
        $column_background_options = $column_content['column_background_options'];
        $column_background_color = $column_background_options['background_color'];
        $column_background_image = $column_background_options['background_image'];
        $customize_column_background_image = $column_background_options['customize_background_image'];
    endif;
    
    
    $columnHTML .= '<div class="column ' . $column_width . '"';
   
    if($customize_column_background == 'Yes'):
    
        $columnHTML .= ' style="';
    
    //CUSTOM SECTION BACKGROUND STYLING
    
    if($column_background_color):
        $columnHTML .= 'background-color:' .  $column_background_color . '; ';
    endif;
    
    if($column_background_image):
        $columnHTML .= 'background-image:url(' . $column_background_image . '); ';
        
        $column_background_image_repeat = $column_background_options['background_image_repeat'];
        $column_background_image_position = $column_background_options['background_image_position'];
        $column_background_image_size = $column_background_options['background_image_size'];
    
    if($column_background_image_repeat):
        $columnHTML .=' background-repeat:' . $column_background_image_repeat . ';';
    else:
        $columnHTML .=' background-repeat:no-repeat;';
    endif;
    
    if($column_background_image_position):
        $columnHTML.= 'background-position:' . $column_background_image_position . ';';
    endif;
    
    if($column_background_image_size):
        $columnHTML .= ' background-size:' . $column_background_image_size. ';';
    endif;
    endif;//end if column background image
    
    $columnHTML .= '"';
    
    endif;//end if customize section background
    
    $columnHTML .= '>';//end of COLUMN div declaration
    
    
    $customize_column_background = $column_content['customize_column_background'];
    $column_background_options = $column_content['column_background_options'];
    
    $background_color = $column_background_options['background_color'];
    $background_image = $column_background_options['background_image'];
    $customize_background_image = $column_background_options['customize_background_image'];
    $background_image_repeat = $column_background_options['background_image_repeat'];
    $background_image_position = $column_background_options['background_image_position'];
    $background_image_size = $column_background_options['background_image_size'];
    
    if(!$background_image_repeat):
        $background_image_repeat = 'no-repeat';
    endif;
    
    
    $column_section_headline_items = $column_content['column_section_headline_items'];
    $text_align = $column_section_headline_items['text_align'];
    $section_headine_text = $column_section_headline_items['section_headine_text'];
    
    if( have_rows($column_section_headline_items['section_headine_text']) ):
    
    while ( have_rows($column_section_headline_items['section_headine_text']) ) : the_row();
        $text = get_sub_field('text');
        $text_color = get_sub_field('text_color');
        $text_size = get_sub_field('text_size');
    endwhile;//END COLUMN HEADLINE TEXT REPEATER WHILE
    
    endif;//END COLUMN HEADLINE TEXT REPEATER IF
    
    $content_type = $column_content['content_type'];
    
    if($content_type == 'Image' || $content_type == 'Image Text Stack'):
        $image = $column_content['image'];
        $image_title = $column_content['image_title'];
        $include_image_on_mobile = $column_content['include_image_on_mobile'];
    endif;
    
    if($content_type == 'Text' || $content_type == 'Image Text Stack'):
        $column_headline = $column_content['column_headline'];
        $text= $column_content['text'];
    endif;
    
    if($content_type == 'Image'):
        $columnHTML .= '<div class="image-ct';
    
    if($include_image_on_mobile == 'No'):
        $columnHTML .= ' mbl-hide';
    endif;
        $columnHTML .= '">';
        $columnHTML .= '<img src="' . $image . '" alt="' . $image_title . '">';
        $columnHTML .= '</div><!-- .image-ct -->';
    endif;
      
    if($content_type == 'Text'):
    $columnHTML .= '<div class="text-ct">';
    if($column_headline):
        $columnHTML .= '<h3 class="image-text-stack">' . $column_headline . '</h3>';
    endif;
    $columnHTML .=  $text . '</div><!-- .text-ct -->';
    endif;
    
    if($content_type == 'Image Text Stack'):
        $link_text = $column_content['link_text'];
        $link_url = $column_content['link_url'];
        
        $columnHTML .= '<div class="image-text-wrapper">';
        $columnHTML .= '<div class="image-ct"><img src="' . $image . '" alt="' . $image_title . '"></div><!-- .image-ct -->';
        $columnHTML .= '<div class="text-ct">';
        if($column_headline):
            $columnHTML .= '<h3 class="image-text-stack">' . $column_headline . '</h3>';
        endif;
        
        $columnHTML .=  $text . '</div><!-- .text-ct -->';
        $columnHTML .= '<div class="bt-fixed"><div class="bt-ct"><div class="bt"><a href="' . $link_url . '">' . $link_text . '</a></div><!-- .bt --></div><!-- .bt-ct --></div><!-- .bt-fixed -->';
        $columnHTML .= '</div><!--.image-text-wrapper -->';
    endif;
    
    
    $columnHTML .= '</div><!-- .column-->';

   return $columnHTML;
}

