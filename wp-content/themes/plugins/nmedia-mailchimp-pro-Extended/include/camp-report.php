<?php
/*
 * this file showing campaign detail
 */

$arrStats = $mc -> getCampaignReport($_REQUEST['cid']);

$arrList 	= $mc -> getListByID($_REQUEST['lid']);
$listName 	= $arrList[0]['name'];


/* echo '<pre>';
print_r($arrStats);
echo '</pre>'; */
$urlList = get_admin_url('', 'admin.php?page=mailchimp-campaigns').'&act=list-camp';
?>

<ul class="mc-controls">
	   
    <li>
    	<a href="<?php echo $urlList?>"><img border="0" src="<?php echo plugins_url('images/button-list-camp-all.png', __FILE__)?>" alt="<?php _e('Campaigns (not sent)', 'nm_mailchimp_plugin');?>" /></a>
    </li>
    
</ul>
<div class="clearfix"></div>

<div class="clearfix"></div>
<div id="chart_div" style="width: 900px; height: 500px;"></div>
<div class="clearfix"></div>

<div id="camp-report-container">
<div id="camp-report-left">
<ul>
	<li><strong><?php _e('Sent to (List)', 'nm_mailchimp_plugin')?></strong><br>
		<?php echo $listName?>
	</li>
	<li><strong><?php _e('Send from Email', 'nm_mailchimp_plugin')?></strong><br>
		<?php echo $_REQUEST['ste']?><br>
		<?php echo $_REQUEST['stn']?>
	</li>
	<li><strong><?php _e('Subject', 'nm_mailchimp_plugin')?></strong><br>
		<?php echo $_REQUEST['subject']?>
	</li>
</ul>
</div>

<div id="camp-report-right">
<ul class="camp-report-stats">
	<li><?php _e('successful deliveries', 'nm_mailchimp_plugin')?>: <strong><?php echo $arrStats['emails_sent']?></strong></li>
	<li><?php _e('forwarded', 'nm_mailchimp_plugin')?>: <strong><?php echo $arrStats['forwards']?></strong></li>
	<li><?php _e('forwarded opens', 'nm_mailchimp_plugin')?>: <strong><?php echo $arrStats['forwards_opens']?></strong></li>
	<li><?php _e('hard bounces', 'nm_mailchimp_plugin')?>: <strong><?php echo $arrStats['hard_bounces']?></strong></li>
	<li><?php _e('people who clicked', 'nm_mailchimp_plugin')?>: <strong><?php echo $arrStats['users_who_clicked']?></strong></li>
	<li><?php _e('forwarded opens', 'nm_mailchimp_plugin')?>: <strong><?php echo $arrStats['forwards_opens']?></strong></li>
	<li><?php _e('total times opened', 'nm_mailchimp_plugin')?>: <strong><?php echo $arrStats['opens']?></strong></li>
	<li><?php _e('total clicks', 'nm_mailchimp_plugin')?>: <strong><?php echo $arrStats['clicks']?></strong></li>
	<li><?php _e('facebook likes', 'nm_mailchimp_plugin')?>: <strong><?php echo $arrStats['facebook_likes']?></strong></li>
	<li><?php _e('last open', 'nm_mailchimp_plugin')?>: <strong><?php echo date('M-d, Y', strtotime($arrStats['last_open']))?></strong></li>
</ul>
</div>

</div><!--  camp-report-container -->

<script
	type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Campaign Stats',	'Stats'],
          ['Email Sent',  		<?php echo $arrStats['emails_sent']?>],
          ['Opens',  			<?php echo $arrStats['unique_opens']?>],
          ['Clicks',  			<?php echo $arrStats['unique_clicks']?>],
          ['Unsubscribers',  	<?php echo $arrStats['unsubscribes']?>]
        ]);

        var options = {
          title: 'Report: <?php echo $_REQUEST['title']?>',
          hAxis: {title: 'Statistics', titleTextStyle: {color: 'green'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
