<?php

	$rh_row_layout = get_sub_field('rh_row_layout');

		if( $rh_row_layout=="One Column"):
		
		$one_column_background_image = get_sub_field('one_column_background_image');
		$one_column_background_color = get_sub_field('rh_one_column_background_color');
		$one_column_background_color = get_sub_field('rh_one_column_content');

		endif;
		
		if( $rh_row_layout=="Two Columns"):
		
		$rh_left_background_image = get_sub_field('rh_left_background_image');
		$rh_left_background_color= get_sub_field('rh_left_background_color');
		$rh_left_column_content = get_sub_field('rh_left_column_content');
		
		endif;
		

?>