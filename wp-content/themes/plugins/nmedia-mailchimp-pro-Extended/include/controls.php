<?php
/*
rendering top controls in campaign
*/
$urlCreate = get_admin_url('', 'admin.php?page=mailchimp-campaigns').'&act=create-camp';
$urlList = get_admin_url('', 'admin.php?page=mailchimp-campaigns').'&act=list-camp';
?>
<h2>Mailchimp Campaigns</h2>

<ul class="mc-controls">
	<li>
    	<a href="<?php echo $urlCreate?>">
		<img border="0" src="<?php echo plugins_url('images/button-add-camp.png', __FILE__)?>" alt="<?php _e('Add New Campaign', 'nm_mailchimp_plugin');?>" /></a>
    </li>
    
    <li>
    	<a href="<?php echo $urlList?>"><img border="0" src="<?php echo plugins_url('images/button-list-camp-all.png', __FILE__)?>" alt="<?php _e('Campaigns (not sent)', 'nm_mailchimp_plugin');?>" /></a>
    </li>
    
</ul>

<div class="clearfix"></div>
