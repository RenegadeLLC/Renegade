<?php
$nonce = wp_create_nonce  ('uwpsfsearch');
$taxo = get_post_meta($id, 'uwpqsf-taxo', true);
$cmf = get_post_meta($id, 'uwpqsf-cmf', true);
$options = get_post_meta($id, 'uwpqsf-option', true);
$css = get_post_meta($id, 'uwpqsf-theme', true);
$excss = explode('|', $css);
$divid = ($excss[2]) ? $excss[2] : 'uwpqsf_id';
$defaultclass = ($excss[3]) ? $excss[3] : 'uwpqsf_class';

if($options[0]['method'] == '1'){
	$hidden = '<input type="hidden" id="uajaxdiv" value="'.$options[0]['div'].'">';
	$btype = 'button';
	$method = '';
	$bclass = 'usearchbtn';
	$auto = true;
}else{
 	$hidden = '<input type="hidden" name="s" value="uwpsfsearchtrg" />';
	$btype = 'submit';
	$method = 'method="get" action="'.home_url( '/' ).'"';
	$bclass ='';
	$auto = false;
}




$fields = new uwpqsfront();

$html = '<div id="'.$divid.'">';
$html .= '<form id="uwpqsffrom_'.$id.'" '.$method.'>';
if($formtitle){
	$html .= '<div class="uform_title">'.get_the_title($id).'</div>';
}
$html .= '<input type="hidden" name="unonce" value="'.$nonce.'" /><input type="hidden" name="uformid" value="'.$id.'">';

$html .= $hidden;

ob_start(); 
$html .= do_action( 'uwpqsf_form_top', $atts);
$html .= ob_get_clean();

if(isset($options[0]['strchk']) && ($options[0]['strchk'] == '1') && $text_position =="top"){
		$stext  = '<div class="'.$defaultclass.' '.$divclass.'"><label class="'.$defaultclass.' '.$divclass.'-keyword">'.$options[0]['strlabel'].'</label>';
		$oldvalue = (isset($_GET['skeyword'])) ? $_GET['skeyword'] : '';
		$stext .= '<input id="'.$divid.'_key" type="text" name="skeyword" class="uwpqsftext" value="'.$oldvalue.'" />';
        $stext .= '</div>';
        $textsearch =  apply_filters('uwpqsf_string_search',$stext, $id,$divid,$defaultclass,$divclass,$options);
        $html .= $textsearch;
}

if(!empty($taxo)){
	$c = 0;
	foreach($taxo as $k => $v){
		$eid = explode(",", $v['exc']);
		$args = array('hide_empty'=>$v['hide'],'exclude'=>$eid );
        $terms = get_terms($v['taxname'],$args);
 	    $count = count($terms);
		$html .= $fields->output_formtaxo_fields($v['type'],$v['exc'],$v['hide'],$v['taxname'],$v['taxlabel'],$v['taxall'],$v['operator'],$c,$defaultclass,$id,$divclass );

	$c++;
  }
}

ob_start(); 
do_action( 'uwpqsf_form_mid', $atts);
$html .= ob_get_clean();

if(!empty($cmf)){
   $i=0;
    foreach($cmf as $k => $v){
		if(isset($v['type'])){
			$html .= $fields->output_formcmf_fields($v['type'],$v['metakey'],$v['compare'],$v['opt'],$v['label'],$v['all'],$i,$defaultclass,$id,$divclass );
		 $i++;
	   }
	}
}

if(isset($options[0]['strchk']) && ($options[0]['strchk'] == '1') && $text_position =="bottom"){
		$stext  = '<div class="'.$defaultclass.' '.$divclass.'"><label class="'.$defaultclass.' '.$divclass.'-keyword">'.$options[0]['strlabel'].'</label>';
		$oldvalue = (isset($_GET['skeyword'])) ? $_GET['skeyword'] : '';
		$stext .= '<input id="'.$divid.'_key" type="text" name="skeyword" class="uwpqsftext" value="'.$oldvalue.'" />';
        $stext .= '</div>';
        $textsearch =  apply_filters('uwpqsf_string_search',$stext, $id,$divid,$defaultclass,$divclass,$options);
        $html .= $textsearch;
}
ob_start(); 
do_action( 'uwpqsf_form_bottom' , $atts);
$html .= ob_get_clean();

if($button && $button == '1'){
$wrapper = '<div class="'.$defaultclass.' '.$divclass.' uwpqsf_submit" id="uwpqsf_btn">';
$wrapper .= '<input type="'.$btype.'" id="'.$divid.'_btn" value="'.$options[0]['button'].'" alt="[Submit]" class="usfbtn '.$bclass.'" /></div>';
$btn = apply_filters('uwpsqf_form_btn', $wrapper, $id,$divclass,$defaultclass,$divid,$options[0]['button'] );
$html .= $btn;
}elseif($button == '0'){
 if($auto){
	$form = '"#uwpqsffrom_'.$id.'"';
	ob_start(); 
  ?>
	<script type="text/javascript">jQuery(document).ready(function($) {
	var formid = <?php echo $form; ?>;
	$(formid).find('input, textarea, button, select').change(function(){ 
		process_data($(this)); 
		
		})
      ;})</script>
  <?php
    $html .= ob_get_clean();
 }
}
if(function_exists('icl_object_id') && $lang) {
	$html .= '<input type="hidden" name="lang" value="'.$current_language.'"/>';
}
$html .= '<div style="clear:both"></div>';
$html .= '</form>';//end form
$html .= '</div>'; //end div
echo $html;
;?>
