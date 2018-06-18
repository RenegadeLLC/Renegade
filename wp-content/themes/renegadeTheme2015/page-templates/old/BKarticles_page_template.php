<?php
/**
 * Template Name: BKArticles Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2014
 */

get_header(); ?>

<script>

</script>
<div class="news-page">

<div class="content-wrapper" style="background:#fff; overflow:hidden; padding-bottom:64px;">
<?php 
$ra_header = get_field('ra_header');
$ra_subheader = get_field('ra_subheader');


if($ra_header){
	echo('<h1>'. $ra_header . '</h1>');
	
}

	if($ra_subheader){
	echo('<h2>'. $ra_subheader . '</h2>');
}
?>
<div class="sidebar-left"></div>
<div class="content-diag">
<?php

$meta_key = $ra_date;


// the query

$ra_args = array( 'post_type' => 'articles', 'posts_per_page' => -1 , 'orderby' => 'meta_value', 'meta_key' => $meta_key, 'order' => 'ASC');
$ra_loop = new WP_Query( $ra_args );
while ( $ra_loop->have_posts() ) : $ra_loop->the_post();


$ra_author = get_field('ra_author');
$ra_publication = get_field('ra_publication');
$ra_date = get_field('ra_date');
$ra_url = get_field('ra_url');
$ra_blurb = get_field('ra_blurb');

echo '<div class="article-item">';

if($ra_date){
	echo '<div class="ra-date">' . $ra_date . '</div>';
}

if($ra_author){
	echo '<div class="ra-author">' . $ra_author;
}

if($ra_publication ){
	echo ' for ' . $ra_publication . '</div>';
}

if($ra_url){
	echo '<a href="' . $ra_url . '" target=_blank>';
}
the_title( '<h3>', '</h3>', true );
if($ra_url){
	echo '</a>';
}
if($ra_blurb){
	echo '<div class="ra-blurb">' . $ra_blurb . '</div>';
}

echo '</div>';
endwhile;
 ?>
</div><!-- .content-diag -->
</div><!-- .content-wrapper -->
</div><!-- .company -->

<?php get_footer(); ?>