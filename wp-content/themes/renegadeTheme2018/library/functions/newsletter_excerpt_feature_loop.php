<?php
$rn_title = get_the_title( $post->ID );
$rn_date = get_field('rn_date');
$rn_introduction= get_field('rn_introduction');
$rn_banner = get_field('rn_banner');
$rn_thumb = get_field('rn_thumb');
$rn_size = "full";
$accent_color = get_field('accent_color');
$newsletter_html = '';

$newsletter_html.= '<style>li:before{background-color:' . $accent_color . ';}</style>';

$newsletter_html .= '<div class="newsletter-header">';
$newsletter_html .= '<div class="newsletter-title">' . $rn_title . '</div>';
$newsletter_html .= '<div class="newsletter-date">' . $rn_date . '</div></div>';
$newsletter_html .= '<div class="newsletter-banner">' . wp_get_attachment_image($rn_banner, $rn_size ) . '</div>';
$newsletter_html .= '<div class="newsletter-intro">' . $rn_introduction . '</div>';

$newsletter_content_html = '';





return $newsletter_html;

?>