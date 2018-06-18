<?php

$section_layout = get_sub_field('section_layout');
    
//DO ONE COLUMN LAYOUT
if($section_layout == 'One Column'):

    $columnHTML = get_column_content('column_one_content', 'col-md-12');
    $pageHTML .= $columnHTML;

endif;//END ONE COLUMN LAYOUT

//DO TWO COLUMN LAYOUT
if($section_layout == 'Two Columns'):

    $first_column_width = get_sub_field('first_column_width');
    
    if($first_column_width == 'One Quarter'):
        $col1w = 'col-md-3';
        $col2w = 'col-md-9';
    elseif($first_column_width == 'One Third'):
        $col1w = 'col-md-4';
        $col2w = 'col-md-8';
    elseif($first_column_width == 'One Half'):
        $col1w = 'col-md-6';
        $col2w = 'col-md-6';
    elseif($first_column_width == 'Two Thirds'):
        $col1w = 'col-md-8';
        $col2w = 'col-md-4';
    elseif($first_column_width == 'Three Quarters'):
        $col1w = 'col-md-9';
        $col2w = 'col-md-3';
    endif;

    //COLUMN ONE
    
    $columnHTML = get_column_content('column_one_content', $col1w);
    $pageHTML .= $columnHTML;
    
    //COLUMN TWO
    
    $columnHTML = get_column_content('column_two_content', $col2w);
    $pageHTML .= $columnHTML;

endif;//END TWO COLUMN LAYOUT

//DO THREE COLUMN LAYOUT
if($section_layout == 'Three Columns'):



//COLUMN ONE

$columnHTML = get_column_content('column_one_content', 'col-md-4');
$pageHTML .= $columnHTML;

//COLUMN TWO

$columnHTML = get_column_content('column_two_content', 'col-md-4');
$pageHTML .= $columnHTML;

//COLUMN THREE

$columnHTML = get_column_content('column_three_content', 'col-md-4');
$pageHTML .= $columnHTML;

endif;//END THREE COLUMN LAYOUT

//DO FOUR COLUMN LAYOUT
if($section_layout == 'Four Columns'):


//COLUMN ONE

$columnHTML = get_column_content('column_one_content', 'col-lg-3 col-md-6 col-sm-12');
$pageHTML .= $columnHTML;

//COLUMN TWO

$columnHTML = get_column_content('column_two_content', 'col-lg-3 col-md-6 col-sm-12');
$pageHTML .= $columnHTML;

//COLUMN THREE

$columnHTML = get_column_content('column_three_content', 'col-lg-3 col-md-6 col-sm-12');
$pageHTML .= $columnHTML;

//COLUMN FOUR

$columnHTML = get_column_content('column_four_content', 'col-lg-3 col-md-6 col-sm-12');
$pageHTML .= $columnHTML;

endif;//END FOUR COLUMN LAYOUT
    


?>
