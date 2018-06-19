<?php
function uwpqsf_ajax_pagination($pagenumber, $pages = '', $range = 4, $id,$getdata){
	$showitems = ($range * 2)+1;  
	 
	$paged = $pagenumber;
	if(empty($paged)) $paged = 1;

	if($pages == '')
	 {
		 
	   global $wp_query;
	   $pages = $query->max_num_pages;
			 
	    if(!$pages)
		 {
				 $pages = 1;
		 }
	}   
	 
	if(1 != $pages)
	 {
	  $html = "<div class=\"uwpqsfpagi\">  ";  
	  $html .= '<input type="hidden" id="curuform" value="#uwpqsffrom_'.$id.'">';
	
	 if($paged > 2 && $paged > $range+1 && $showitems < $pages) 
	 $html .= '<a id="1" class="upagievent" href="#">&laquo; '.__("First","UWPQSF").'</a>';
	 $previous = $paged - 1;
	 if($paged > 1 && $showitems < $pages) $html .= '<a id="'.$previous.'" class="upagievent" href="#">&lsaquo; '.__("Previous","UWPQSF").'</a>';
	
	 for ($i=1; $i <= $pages; $i++)
	  {
		 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
		 {
		 $html .= ($paged == $i)? '<span class="upagicurrent">'.$i.'</span>': '<a id="'.$i.'" href="#" class="upagievent inactive">'.$i.'</a>';
		 }
	 }
				
	 if ($paged < $pages && $showitems < $pages){
		 $next = $paged + 1;
		 $html .= '<a id="'.$next.'" class="upagievent"  href="#">'.__("Next","UWPQSF").' &rsaquo;</a>';}
		 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) {
		 $html .= '<a id="'.$pages.'" class="upagievent"  href="#">'.__("Last","UWPQSF").' &raquo;</a>';}
		 $html .= "</div>\n";$max_num_pages = $pages;
		 return apply_filters('uwpqsf_pagination',$html,$max_num_pages,$pagenumber,$id);
	 }
		 
		 
}// pagination


function get_uwpqsf_form($args=array()){
	$default = array('id' => false, 'formtitle' =>1, 'button' => 1,'divclass' => '', 'infinite'=>'');
	$atts=array_merge($default,$args);
	extract($atts);
	if($id)
		{
			 ob_start();
			 $output = include UWPQSFBASE . '/html/searchform.php';
			 $output = ob_get_clean();
			 return $output;
		}
		else{
			return 'no form added.';
		}

}
?>
