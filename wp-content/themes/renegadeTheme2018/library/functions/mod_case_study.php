<?php


$case_image = get_sub_field('image');
$case_label = get_sub_field('label_text');
$case_hover = get_sub_field('hover_text');
$link_type = get_sub_field('link_type');
$url;
$case_url = get_sub_field('case_study_url');
$page_url = get_sub_field('page_link');
$external_url = get_sub_field('external_link');
	
	if($link_type == 'Case Study'):
		$url = $case_url;
	elseif($link_type == 'Page Link'):
		$url = $page_url;
	elseif($link_type == 'External Link'):
		$url = $external_url;
	endif;

//var_dump($url);
//if( $case_objs ):
//var_dump($case_objs);
// override $post
//$post = $case_obj;
/*
foreach($case_objs as $case_obj):
$post=$case_obj;
$case_id = $post('ID');
$url = get_post_permalink($case_id);
endforeach;
*/
//endif;

wp_reset_postdata();

$hover_text = get_sub_field('hover_text');

$pageHTML .= '<div class="hm-case">';
$pageHTML .= '<a href="' . $url . '" ';
	if($url == $external_url):
		$pageHTML .= ' target="_blank"';
	endif;
$pageHTML .= '><img src="' . $case_image . '" class="lazy">';

$pageHTML .= '<div class="hm-case-label-ct">';
//$pageHTML .= '<div class="hm-case-label"></div>';
$pageHTML .= '<div class="hm-case-label-text"> ' . $case_label . '</div><!--.label-text--><!--.hm-case-label--></div><!--.hm-case-label-ct-->';
$pageHTML .= '<a href="' . $url . '" style="height:100%; display:block;"';
if($url == $external_url):
$pageHTML .= ' target="_blank"';
endif;
$pageHTML .= '>';
$pageHTML .= '<div class="hm-case-info-ct">';
$pageHTML .= '<div class="hm-case-info">';
$pageHTML .= '<h3>' . $case_label  . '</h3>';
$pageHTML .= $hover_text;
$pageHTML .= '</div></a>';
$pageHTML .= '</div>';
$pageHTML .= '</div>';
?>