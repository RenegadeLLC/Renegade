<?php
/**
 * Template Name: Home Page Template
 *
 *
 * @package Renegade
 * @subpackage Renegade
 * @since 2015
 */

get_header(); ?>

<?php 
//define('FUNCTIONS', TEMPLATEPATH . '/library/functions/');



$pageHTML;

// check if the repeater field has rows of data
if( have_rows('rh_home_row') ):

$pageHTML = '';

	// FIND HOME ROWS
	while ( have_rows('rh_home_row') ) : the_row();
		$rh_row_name = get_sub_field('rh_row_name');
		$rh_row_id = clean_string($rh_row_name);
		$rh_row_category = get_sub_field('rh_row_category');
		$rh_row_background_color = get_sub_field('rh_row_background_color');
		$rh_row_background_image = get_sub_field('rh_row_background_image');
		$rh_content_type = get_sub_field('rh_content_type');
		$rh_row_layout = get_sub_field('rh_row_layout');
		$one_column_content_type = get_sub_field('one_column_content_type');
		$floater = get_sub_field('floater');
		
		$pageHTML .= '<div class="home-row" id="' . $rh_row_id .'" style="background:';
		
			if($rh_row_background_image):
				
				$pageHTML .= 'url:(' . $rh_row_background_image . ') ' . $rh_row_background_color . ';">';
			
			else :
			
				$pageHTML .= $rh_row_background_color . ';">'; 
			
			endif;
		
		/**** IF ROW LAYOUT IS ONE COLUMN*******/
		
			if($rh_row_layout=="One Column"):
			
				//Get one column content section part
				include( FUNCTIONS . 'home_regular_content_one_col.php' );
		
			/**** IF ROW LAYOUT IS TWO COLUMNS *******/
			elseif($rh_row_layout=='Two Columns'):
				
				//Get two columns section part
				include( FUNCTIONS . 'home_regular_content_two_cols.php' );
				
			endif;
		
		if( have_rows('floater') ):
		
			$floaterHTML = '';
		
			while ( have_rows('floater') ) : the_row();
				$floater_name = clean_link_name(get_sub_field('floater_name'));
				$floater_image = get_sub_field('floater_image');
				$floaterX = get_sub_field('x_position');
				$floaterY = get_sub_field('y_position');
				$transition_direction = get_sub_field('transition');
				$transitions = get_sub_field('transition_type');
				$z_index = get_sub_field('z_index');
						
					if($transition_direction == "From Left"):
						$direction = 'left';
					elseif($transition_direction == "From Right"):
						$direction = 'right';
					elseif($transition_direction == 'Static'):
						$direction = 'static';	
					endif;
			
				$floaterHTML .= '<div class="floater" direction="' . $direction . '" targetPos="' . $floaterX . '" id="' . $floater_name . '" style="left: ' . $floaterX . '%; bottom:' . $floaterY . 'px; z-index:' . $z_index . ';"><div class="' . $transition . '"><img src="' . $floater_image . '"></div></div>';
			
			endwhile;
		
		$pageHTML .= $floaterHTML;
		endif;
		
		$pageHTML .= '</div>';//end HOME ROW
		
		endwhile;
		
	else :
	
		// no rows found
	
	endif;


echo $pageHTML;?>


<script type="text/javascript">

$(function(){

	
//$('.home-row').scrollSpy();

});

</script>

<?php get_footer(); ?>