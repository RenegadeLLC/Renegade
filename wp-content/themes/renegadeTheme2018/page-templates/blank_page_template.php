<?php
/**
 * Template Name: Blank Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2015
 */

get_header();
?>

<div class="wrapper">
<?php 
the_content();
?>
</div>



<?php get_footer(); ?>