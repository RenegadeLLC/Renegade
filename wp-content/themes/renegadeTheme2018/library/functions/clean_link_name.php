<?php


function clean_link_name($section_title){
	//if string contains whitespace
	if(preg_match('/\s/', $section_title)):
	// strip out all whitespace and replace with _
	$section_title_clean = preg_replace('/\s/', '_', $section_title);
	// convert the string to all lowercase
	$section_title_clean = strtolower($section_title_clean);
	else:
	// convert the string to all lowercase
	$section_title_clean = strtolower($section_title);
	endif;
	return($section_title_clean);
	//$section_title_clean = strtolower($section_title_clean);

}


?>