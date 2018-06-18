<?php

$module_content = get_sub_field('module_content');
$pageHTML .= '<div class="vert-center-outer"><div class="vert-center-inner">';
//$pageHTML .= '<div class="md-text">';
$pageHTML .= $module_content;
//$pageHTML .= '</div><!--.md-text-->';
$pageHTML .= '</div><!--.vert-inner--></div><!--.vert-outer-->';
?>