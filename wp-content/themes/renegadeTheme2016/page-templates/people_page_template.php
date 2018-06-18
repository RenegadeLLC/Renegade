<?php
/**
 * Template Name: People Page Template
 *
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2016
 */

get_header();


	$pageTopHTML = require_once (FUNCTIONS . '/standard_page_top.php');
	$workHTML = '';
	$workHTML.=$pageTopHTML;
	$workHTML .= '<div class="wrapper"><div class="grid-g-w-0 grid cases-grid"><div class="grid-gutter"></div>';
	//QUERY PEOPLE POST TYPES FOR GRID
	$rp_args = array( 'post_type' => 'people', 'post_status' => 'publish', 'posts_per_page' => -1 , 'orderby' => 'meta_value', 'meta_key' => $meta_key, 'order' => 'ASC');
	$rp_loop = new WP_Query( $rp_args );
			while ( $rp_loop->have_posts() ) : $rp_loop->the_post();
			$person_id = get_the_ID();
			$person_link = get_post_permalink( $person_id );
			$person_image = get_field('case_image');
			$first_name = get_field('rp_first_name');
			$last_name = get_the_title( $post->ID );
			$job_title = get_field('rp_job_title');
			$person_thumbnail_image = get_field('rp_bio_image');
			$industry_vertical = get_field('industry_vertical');
			$workHTML .= '<div class="case-image-ct circ grid-item grid-item-w-33 ';
			$workHTML .= '">';
			if($first_name != 'Pinky'):
				$workHTML .= '<a href="' . $person_link . '">';
			endif;
			$workHTML .= '<div class="case-image person-image">';
			$workHTML .= '<div class="person-label-ct"><div class="person-label-text">' . $first_name . ' ' . $last_name . '<br>' . $job_title . '</div></div>';
			$workHTML .= '<img src="';
			$workHTML .= $person_thumbnail_image;
			$workHTML .='" alt="' . $person_id .'" class="lazy">';
		
			$workHTML .= '</div><div class="person-info-ct"><div class="vert-center-outer"><div class="vert-center-inner"><div class="circle" style="background-color:#7ccce8;"><div class="vert-center-outer"><div class="vert-center-inner">';
			$workHTML .= '<h1>' . $first_name . ' ' . $last_name . '</h1><h3>' . $job_title;
			
			$workHTML .= '</h3></div></div></div></div></div>';
			if($first_name != 'Pinky'):
			$workHTML .= '</a>';
			endif;
			$workHTML .= '</div></div>';
		endwhile;
		
	$workHTML .= '</div>';//end grid
	$workHTML .= '</div>';//end left col
	
echo $workHTML;

?>

</div><!-- .wrapper -->
</div><!-- .work -->

<script type="text/javascript">
	
	$(document).ready(function() {
		  var $container = $('.grid');
		  $container.imagesLoaded( function() {
		    $container.isotope({
		   	 percentPosition: true,
			 isFitWidth: true,
		      itemSelector: '.grid-item',
		      masonry: {
			      gutter: '.grid-gutter',
			      }
		    });

		    
		  });
		  $('.grid').imagesLoaded( function() {
			  $('.grid').masonry('layout');
			});
		});
	
</script>

<?php get_footer(); ?>