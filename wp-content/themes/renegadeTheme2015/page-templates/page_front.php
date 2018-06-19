<?php
/**
 * Template Name: Front Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Renegade
 * @since 2013
 */

get_header(); ?>



<?php 

	if ( have_posts() ) while ( have_posts() )
		{
			the_post();
		} ?>


<?php the_content(); ?>



        

<?php get_footer(); ?>