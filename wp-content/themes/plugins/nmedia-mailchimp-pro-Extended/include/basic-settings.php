<?php
/*
Salt & Pepper (Advance settings)
*/

$arrList = $mc -> getAccountLists();
?>

<div class="nm_heading_block" onclick="loadStep('s-2')"><?php _e('Step 2: Basic Settings (these all required) ', 'nm_mailchimp_plugin')?><span class="update-title" id="title-s-2"></span></div>

<div id="s-2" style="display:none" class="camp-steps">
<ul>
	<li>
    	<label class="nm-label" for="camp-subject"><?php _e('Select List', 'nm_mailchimp_plugin')?></label>
        <select name="camp-list" id="camp-list">
        	<option value=""></option>
            <?php
			if($arrList):
			foreach($arrList as $list):
			?>
            <option value="<?php echo $list['id']?>"><?php echo $list['name']?></option>
            <?php
			endforeach;
			endif;
			?>
            
        </select>
    </li>
    
	<li>
    	<label class="nm-label" for="camp-subject"><?php _e('Campaign Subject', 'nm_mailchimp_plugin')?></label>
        <input type="text" name="camp-subject" id="camp-subject" class="regular-text">
    </li>
    
    <li>
    	<label class="nm-label" for="camp-from-email"><?php _e('From Email', 'nm_mailchimp_plugin')?></label>
        <input type="text" name="camp-from-email" id="camp-from-email" value="<?php echo get_bloginfo('admin_email')?>" class="regular-text">
    </li>
    
    <li>
    	<label class="nm-label" for="camp-from-name"><?php _e('From Name', 'nm_mailchimp_plugin')?></label>
        <input type="text" name="camp-from-name" id="camp-from-name" class="regular-text" value="<?php echo get_bloginfo('blog_name')?>">
    </li>
</ul>
<a href="javascript:changeStep('s-2', 's-3')">
		<img border="0" src="<?php echo plugins_url('images/button-next.png', __FILE__)?>" alt="<?php _e('Next', 'nm_mailchimp_plugin');?>" /></a>
</div>
