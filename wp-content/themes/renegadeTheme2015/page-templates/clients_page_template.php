<?php
/**
 * Template Name: Clients Page Template
 *
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2015
 */

get_header(); ?>

<script>

</script>


<?php

//GET THE CUSTOM FIELD VARIABLES
$header = get_field('header');
$subheader = get_field('subheader');
$wk_intro_content = get_field('main_content');
$logo_grid_header = get_field('logo_grid_header');
$logo_grid_subheader = get_field('logo_grid_subheader');
	
//START HTML BUILD
	$workHTML = '';
	$workHTML .= '<div class="work-page">';
	$workHTML .= '<div style="background-color:#000; width:100%; position:relative;"><div class="wrapper">';
	$workHTML .= '<div class="headline-ct">';
	
	if($header){
		$workHTML .= '<div class="wrapper"><h1>'. $header . '</h1></div>';
	}
	
	$workHTML .= '</div></div>';//headline-ct
	
//	if($subheader){
		$workHTML .= '<div class="wrapper"><div class="clients-intro-ct"><div class="clients-intro"><div class="clients-intro-text">'. $wk_intro_content . '</div></div></div></div>';
	//}


	$workHTML .= '<div style="display:block; position:relative; overflow:hidden; background:#E6E7E8; height:auto; width:100%;"><div class="wrapper">';
	
//QUERY CLIENTS POST TYPES FOR LOGO GRID
	$workHTML .= '<div class="logos-ct">';
	//$workHTML .= '<div style="width:75%; float:left; background:#fff; padding:0 0 0 0;">';

	$workHTML .= '<div class="clients-grid-header">';
	$workHTML .='<h3>' . $logo_grid_header  . ' ' . $logo_grid_subheader . '</h3>';
	$workHTML .= '</div>';//clients grid header
	
	$workHTML .= '<div class="client-logo-grid"><div class="case-grid-gutter"></div>';
	
	$rc_args = array( 'post_type' => 'clients', 'posts_per_page' => -1 , 'orderby' => 'meta_value', 'meta_key' => $meta_key, 'order' => 'ASC');
	$rc_loop = new WP_Query( $rc_args );

		while ( $rc_loop->have_posts() ) : $rc_loop->the_post();
			$client_id = get_the_ID();
			$client_logo = get_field('client_logo');
			$workHTML .= '<div class="client-logo-ct circ case-grid-item case-grid-item-w-25"><div class="client-logo-border"></div><div class="client-logo"><img src="' . $client_logo . '" alt=""></div></div>';
		endwhile;
		
	$workHTML .= '</div>';//end grid

	$workHTML .= '</div>';//end left col

	$workHTML .= '<div class="utility-box">';
	$workHTML .= '<h3>Filter Clients By:</h3>Industry Vertical<p>Service Type';
	$workHTML .= '</div>';//end utility-box

//	$workHTML .= '</div>';//end wrapper
	
echo $workHTML;

?>

</div><!-- .wrapper -->
</div><!-- .work -->
	<script type="text/javascript">
$( function() {
	  
	  $('.client-logo-grid').isotope({
		 percentPosition: true,
		 isFitWidth: true,
		 // layoutMode: 'packery',
		  layoutMode: 'masonry',
	    itemSelector: '.case-grid-item',
	//    packery: {
		masonry: {
	      gutter: '.case-grid-gutter',
	      }
	  });

	  imagesLoaded( '.grid', function() {
			$('.grid').isotope('layout');
	  });
	  
	  
	});
</script>
<?php get_footer(); ?>