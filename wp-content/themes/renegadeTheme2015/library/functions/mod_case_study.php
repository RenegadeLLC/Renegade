<?php


$case_image = get_sub_field('case_image');
$case_label = get_sub_field('label_text');
$case_hover = get_sub_field('hover_text');
$case_url = get_sub_field('case_study_url');
$hover_text = get_sub_field('hover_text');

$pageHTML .= '<div class="hm-case">';
$pageHTML .= '<a href="' . $case_url . '"><img src="' . $case_image . '">';

$pageHTML .= '<div class="hm-case-label-ct">';
$pageHTML .= '<div class="hm-case-label">';
$pageHTML .= '</div><div class="hm-case-label-text"> ' . $case_label . '</div><!--.label-text--><!--.hm-case-label--></div><!--.hm-case-label-ct-->';
$pageHTML .= '<div class="hm-case-info-ct">';
$pageHTML .= '<div class="hm-case-info">';
$pageHTML .= '<h1>' . $case_label  . '</h1>';
$pageHTML .= $hover_text;
$pageHTML .= '</a></div>';
$pageHTML .= '</div>';
$pageHTML .= '</div>';
?>