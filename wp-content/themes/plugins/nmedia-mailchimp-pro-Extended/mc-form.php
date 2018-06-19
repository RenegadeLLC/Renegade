<?php
$options_file = dirname(__FILE__).'/get-plugin-options.php';
include ($options_file);
$shortname = "nm_mc";

$post_url = plugins_url('api_mailchimp/postToMailChimp.php', __FILE__);

/*
* Designs options
*/
$button_bg 		= get_option($shortname .'_button_bg');
$button_border 	= get_option($shortname . '_button_border');
$button_text_color 	= get_option($shortname . '_button_text');

if(get_option($shortname . '_bg_image') != 'none.png')
	$box_bg_image = plugins_url('images/'.get_option($shortname . '_bg_image'), __FILE__);
	
$box_bg			= get_option($shortname . '_box_bg');
$box_border     = get_option($shortname . '_box_border');
$title_color    = get_option($shortname . '_title_color');
$title_size_type= get_option($shortname . '_title_size_type');
?>

<div class="nm_mc_form">
 <input type="hidden" value="<?php echo $list_id;?>" id="nm_mc_list_id-<?php echo $widget_id?>" />
<ul>

<li> 
<input type="text" id="nm_mc_email-<?php echo $widget_id?>" placeholder="<?php _e('Email', 'nm_mailchimp_plugin')?>" class="nm_mc_text" / >
</li>
    <?php
	if($show_names) 
		echo '<li><input type="text" class="nm_mc_text" id="nm_mc_fullname-'.$widget_id.'" placeholder="'.__('Firstname, Lastname', 'nm_mailchimp_plugin').'" / ></li>';	
	?>
    
    <?php 
	if($show_address): 
	//print_r($country_list);
		foreach($show_address as $info):
		
		echo '<li>';
		if($info == 'country')
		{
			nmMailChimp::listCountries($widget_id);
		}
		else
		{
	?>
    	<input type="text" id="<?php echo $info.'-'.$widget_id?>" class="nm_mc_text" placeholder="<?php echo $info?>" />
        
    <?php 
		echo '</li>';
		}
	endforeach;
	endif;
	?>
    
    <li> 
	<input type="button" class="nm_mc_button" value="<?php echo $button_text?>" id="nm_mc_button-<?php echo $widget_id?>" onclick="postToMailChimp('<?php echo $post_url?>', '<?php echo ABSPATH?>', '<?php echo $widget_id?>')" / >
    </li>
    
    <span id="placehoder_ie_fix_email" style="display:none"><?php _e('Email', 'nm_mailchimp_plugin')?></span>
    <span id="placehoder_ie_fix_fname" style="display:none"><?php _e('Firstname, Lastname', 'nm_mailchimp_plugin')?></span>
    
</ul>
</div>

<script type="text/javascript">

/*nm_setDesign('<?php echo $widget_id?>', '<?php echo $button_bg?>','<?php echo $button_border?>', '<?php echo $button_text_color?>', '<?php echo $box_bg_image?>', '<?php echo $box_bg?>', '<?php echo $box_border?>', '<?php echo $title_color?>', '<?php echo $title_size_type?>');*/
</script>