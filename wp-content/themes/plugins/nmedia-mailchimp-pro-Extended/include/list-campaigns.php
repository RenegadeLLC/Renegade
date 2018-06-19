<?php
/*
listing all campaigns
*/

$arrCampaigns = $mc -> getCampaigns();

/* echo '<pre>';
print_r($arrCampaigns);
echo '</pre>'; */

$urlCreate = get_admin_url('', 'admin.php?page=mailchimp-campaigns').'&act=create-camp';
?>

<h2><?php _e('Mailchimp campaigns', 'nm_mailchimp_plugin')?></h2>
<ul class="mc-controls">
	<li>
    	<a href="<?php echo $urlCreate?>">
		<img border="0" src="<?php echo plugins_url('images/button-add-camp.png', __FILE__)?>" alt="<?php _e('Add New Campaign', 'nm_mailchimp_plugin');?>" /></a>
    </li>
    
</ul>

<div style="clear:both"></div>

<div class="nm_mc_div">
<h3><?php _e('Following found under your MailChimp account', 'nm_mailchimp_plugin')?></h3>

<?php if(@$_REQUEST['lid'])
	echo '<a href="'.get_admin_url('', 'admin.php?page=lists-manager').'">Back to list</a>';
?>
    

<ul>
<?php
$current = '';
if($arrCampaigns):
	foreach($arrCampaigns as $camp):
	$urlSend		= get_admin_url('', 'admin.php?page=mailchimp-campaigns').'&cid='.$camp['id'].'&act=send';	
	$urlSentTest 	= get_admin_url('', 'admin.php?page=mailchimp-campaigns').'&cid='.$camp['id'].'&act=send-test';	
	$urlReport		= get_admin_url('', 'admin.php?page=mailchimp-campaigns').'&cid='.$camp['id'].'&act=camp-report&lid='.$camp['list_id'].'&ste='.$camp['from_email'].'&stn='.$camp['from_name'].'&subject='.$camp['subject'].'&title='.$camp['title'];
	$urlDelete 		= get_admin_url('', 'admin.php?page=mailchimp-campaigns').'&cid='.$camp['id'].'&act=camp-del';
		

?>
	<li class="good-links">
    <h3><?php echo $camp['title']?></h3>
    <br />
    <?php if($camp['status'] == 'save'):?>
	<a class="camp-links" href="javascript:showDetail('camp-detail-<?php echo $camp['id']?>')"><?php _e('Campaign detail', 'nm_mailchimp_plugin')?></a> 
	| <a class="camp-links" href="<?php echo $urlSentTest?>"><?php _e('Sent test', 'nm_mailchimp_plugin')?></a>
	| <a class="camp-links" href="<?php echo $urlSend?>"><?php _e('Send campaign', 'nm_mailchimp_plugin')?></a>
	| <a class="camp-links" href="javascript:confirmDel('<?php echo $urlDelete?>')"><?php _e('Delete', 'nm_mailchimp_plugin')?></a>
	<?php else:?>
	<a class="camp-links" href="<?php echo $urlReport?>"><?php _e('Campaign report', 'nm_mailchimp_plugin')?></a>
	| <strong><?php _e('Campaing sent on: ', 'nm_mailchimp_plugin')?><?php echo date('M-d, Y' ,strtotime($camp['send_time']))?></strong>
	<?php endif;?>
<?php 
	if(!isset($_GET['cid'])):
		$mc -> renderCampaignStats($camp);
	endif;
	?>
    </li>
<?php
endforeach;
endif;
?>
</ul>
</div>


<script type="text/javascript">
function showDetail(a)
{
	//alert(a);
	jQuery('#'+a).slideToggle();
}

function confirmDel(url)
{
	var a = confirm("<?php _e('It will delete the campaing, are you sure?', 'nm_mailchimp_plugin')?>");
	
	if(a)
	{
		window.location = url;
	}
}
</script>
