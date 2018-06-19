<?php
/*
Listing all Mailchimp Base Templates
*/

//$arrTemplates = $mc -> getTemplates();


/*echo '<pre>';
print_r($arrTemplates);
echo '</pre>';*/

?>

<div class="nm_heading_block" onclick="loadStep('s-1')"><?php _e('Step 1: Select Template ', 'nm_mailchimp_plugin')?><span class="update-title" id="title-s-1"></span></div>

<div id="s-1" style="display:none" class="camp-steps">
<ul class="mc-tempates">
<?php foreach($mc -> custom_templates as $key => $template):
$preview_image = plugins_url('images/'.$template['image'], __FILE__);
?>
	<li>
    	<img src="<?php echo $preview_image?>" alt="<?php echo $template['name']?>" height="300"><br>
    <label for="camp-template-<?php echo $template['id']?>">
    <input title="<?php echo $template['name']?>" type="radio" name="camp-template" value="<?php echo $template['id']?>" id="camp-template-<?php echo $template['id']?>"><?php echo $template['detail']?></label>    
    </li>
<?php endforeach;?>
	<li>
    	<img src="<?php echo plugins_url('images/no-template.png', __FILE__)?>" alt="<?php _e('Just use my post/page contents, which will be selected in step 4', 'nm_mailchimp_plugin')?>" height="300"><br>
    <label for="camp-template-0">
    <input title="None" type="radio" name="camp-template" value="0" id="camp-template-0" checked="checked">
	<?php _e('Just use my post/page contents, which will be selected in step 4', 'nm_mailchimp_plugin')?></label>    
    </li>
</ul>

<div style="clear:both"></div>
<a href="javascript:changeStep('s-1', 's-2')">
		<img border="0" src="<?php echo plugins_url('images/button-next.png', __FILE__)?>" alt="<?php _e('Next', 'nm_mailchimp_plugin');?>" /></a>
</div>