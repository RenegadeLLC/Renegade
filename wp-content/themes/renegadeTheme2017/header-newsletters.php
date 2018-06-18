<?php
/**
 * The template for displaying the newsletter header in the Newsletter Page Template
 *
 * @package Renegade
 */
$newsletterHTML = '';

$headline = get_field('headline');
$subheadline = get_field('sub_headline');
$rn_title = get_the_title( $post->ID );
$rn_date = get_field('rn_date');

$newsletterHTML .= '<div class="wrapper"><div class="newsletter-content">';
$newsletterHTML .= '<div class="grid-item-w-75" style="display:block; overflow:hidden; background:#f2f2f2;">';

$newsletterHTML .= '<div style="background-color:#000; width:100%;">';
$newsletterHTML .= '<div class="newsletter-headline-ct"><h1>'. $headline . ' <span class="gray">' . $subheadline . '</span></h1></div>';
$newsletterHTML .= '</div>';


$newsletterHTML .= '<div class="newsletter-header"><div class="newsletter-mark"></div>';
$newsletterHTML .= '<div class="newsletter-title">' . $rn_title . '</div>';
$newsletterHTML .= '<div class="newsletter-date">' . $rn_date . '</div></div>';
echo $newsletterHTML;

 ?>
