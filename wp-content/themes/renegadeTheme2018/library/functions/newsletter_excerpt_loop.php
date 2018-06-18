<?php
$rn_title = get_the_title( $post->ID );
$rn_date = get_field('rn_date');
$rn_introduction= get_field('rn_introduction');
$rn_banner = get_field('rn_banner');
$rn_thumb = get_field('rn_thumb');
$rn_size = "full";
$rn_thumbnail_image = get_field('rn_thumbnail_image');
$rn_link = get_permalink();
$accent_color = get_field('accent_color');
$newsletter_html = '';

$newsletter_html.= '<style>li:before{background-color:' . $accent_color . ';}</style>';

$newsletter_info= '';
$newsletter_info .= '<div class="newsletter-title-sm">' . $rn_title . '</div>';
$newsletter_info .= '<div class="newsletter-date-sm">' . $rn_date . '</div>';
$newsletter_info .= '<div class="newsletter-intro-sm">' . $rn_introduction . '</div>';

$newsletter_html .= '<div class="newsletter-excerpt grid-item-w-50 grid-item ">';

    $newsletter_html .= '<a href="' . $rn_link . '">';
    $newsletter_html .= '<div>' . wp_get_attachment_image($rn_banner, $rn_size ) . '</div>';
    $newsletter_html .= '<div class="newsletter-info">' . $newsletter_info . '</div>';



$newsletter_html .= '</div></a>';
$newsletter_content_html = '';


return $newsletter_html;

?>