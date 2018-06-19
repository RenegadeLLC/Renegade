<?php
//$campaignID = $mc -> createCampaign();
//echo 'campaign created '.$campaignID;
?>

<div id="camp-steps">
<form method="post" action="" onsubmit="return validateCreateCamp()">
<input type="hidden" name="act" value="save-camp" />
<?php
/* 1- lising all template */
$file_template = dirname(__FILE__) . '/list-templates.php';
if(file_exists($file_template))
	include ($file_template);
else
	echo 'file not found '.$file_template;
	
	
/* 2- Basic settings */
$file_template = dirname(__FILE__) . '/basic-settings.php';
if(file_exists($file_template))
	include ($file_template);
else
	echo 'file not found '.$file_template;

/* 3- advance settings */
$file_template = dirname(__FILE__) . '/advance-settings.php';
if(file_exists($file_template))
	include ($file_template);
else
	echo 'file not found '.$file_template;


/* 4- contents setting */
$file_template = dirname(__FILE__) . '/campaign-contents.php';
if(file_exists($file_template))
	include ($file_template);
else
	echo 'file not found '.$file_template;
?>
</form>
<p class="nm-create-campaign">
<a href="javascript:previewCamp('<?php echo plugins_url('images/loading.gif', __FILE__)?>')"><img src="<?php echo plugins_url('images/button-preview-camp.png', __FILE__)?>"  /></a>
</p>
</div>

<div id="camp-preview-area">
</div>

<p id="camp-preview-buttons" class="nm-create-campaign" style="display:none">
<a href="javascript:cancelPreviewCamp()"><img src="<?php echo plugins_url('images/button-edit-camp.png', __FILE__)?>"  /></a>
<a href="javascript:createCamp()"><img src="<?php echo plugins_url('images/button-create2-camp.png', __FILE__)?>"  /></a>
</p>

