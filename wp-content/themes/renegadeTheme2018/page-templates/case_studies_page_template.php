<?php
/**
 * Template Name: Case Studies Page Template
 *
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2016
 */

get_header();

$pageTopHTML = require_once (FUNCTIONS . '/standard_page_top.php');
//QUERY PROJECT POST TYPES FOR LOGO GRID
	$workHTML = '';
	$workHTML.= $pageTopHTML;
	$workHTML.=	'<div class="outer-wrapper" style="background:#e6e7e8;">';
	$workHTML .= '<div class="wrapper"><div class="grid-g-0 grid cases-grid"><div class="grid-gutter"></div>';
	
	$rw_args = array( 'post_type' => 'projects', 'post_status' => 'publish', 'posts_per_page' => -1 , 'orderby' => 'menu_order', 'meta_key' => $meta_key, 'order' => 'ASC');
	$rw_loop = new WP_Query( $rw_args );

		while ( $rw_loop->have_posts() ) : $rw_loop->the_post();
			$client_cat = get_field('client_name');
			$client_name = $client_cat -> post_name;
			$case_id = get_the_ID();
			$case_link = get_post_permalink( $case_id );
			$case_image = get_field('case_image');
			$project_thumbnail_image = get_field('project_thumbnail_image');
			$industry_vertical = get_field('industry_vertical');
			
			if($client_name != 'renegade'):
				$workHTML .= '<div class="case-image-ct circ case-grid-item case-grid-item-w-25 ';
				$workHTML .= '"><div class="case-image"><a href="' . $case_link . '"><img src="' . $project_thumbnail_image . '" alt="' . $case_id .'" class="lazy"></a></div></div>';
			endif;
			
			endwhile;
		
	$workHTML .= '</div>';//end grid
	$workHTML .= '</div>';//end left col
	
echo $workHTML;

?>

</div><!-- .wrapper -->
</div><!-- .outer-wrapper -->
</div><!-- .work -->
	<script type="text/javascript">

	$(document).ready(function() {
		  var $container = $('.grid');
		  $container.imagesLoaded( function() {
		    $container.isotope({
		   	 percentPosition: true,
			 isFitWidth: true,
		      itemSelector: '.case-grid-item',
		      masonry: {
			      gutter: '.grid-gutter',
			      }
		    });
		  });

		});
</script>
<?php get_footer(); ?>