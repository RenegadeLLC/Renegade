<?php
/*
** listing all shortcodes
*/

$arrList = nmMailChimp::getAccountLists();
$post_url = plugins_url('api_mailchimp/postToMailChimp.php', __FILE__);
//print_r($arrList);
?>


<h2><?php _e('N-Media Mailchimp Shortcodes', 'nm_mailchimp_plugin')?></h2>
<p>

<strong><?php _e('Select List', 'nm_mailchimp_plugin')?></strong>
<ol>
<?php
foreach($arrList as $list):
?>
	<li>
    <input type="radio" name="l" id="l" value="<?php echo $list['id']?>" onchange="updateShortcode(this.value, 'c-list')">
	<?php echo $list['name']?></li>
<?php endforeach?>
</ol>

<strong>Variables attached with selelecte List</strong>
<p>
<?php 
$vars = nmMailChimp::getMergeVars('2a5fae950f');
echo '<pre>';
//print_r($vars);
echo '</pre>';
?>
</p>

</p>

<p>
<strong><?php _e('Select Fields', 'nm_mailchimp_plugin')?></strong>
<ol class="mc_lists">
	
    <li>
    <input type="checkbox" name="f" id="f" value="fname" onchange="updateShortcode(this.value, 'c-field')">
	Fullname
    </li>
    
    <li>
    <input type="checkbox" name="a" id="a" value="addr1,addr2,city,state,zip,country" onchange="updateShortcode(this.value, 'c-addr')">
	Address
    </li>
    
    <li>
    Button Text: <input type="text" id="b-text" onkeyup="updateShortcode(this.value, 'c-button')">
    </li>

</ol>
</p>

<strong>Shortcodes</strong>
<pre>
[nm-mc-render field="<span class="c-field"></span>" list_id="<span class="c-list"></span>" button_text="<span class="c-button">Subscribe</span>" show_address="<span class="c-addr"></span>"]
</pre>



<script type="text/javascript">
function updateShortcode(val, area)
{
	//alert(area);
	if(area == 'c-field')
	{
		if(jQuery("#f").is(":checked"))
		{
			jQuery("."+area).html(val);
		}
		else
		{
			jQuery("."+area).html('');
		}
	}
	else if(area == 'c-addr')
	{
		if(jQuery("#a").is(":checked"))
		{
			jQuery("."+area).html(val);
		}
		else
		{
			jQuery("."+area).html('');
		}
	}
	else
	{
		jQuery("."+area).html(val);
	}
	
	
	getMergVars('<?php echo $post_url?>', val);
}


/*
** getting Merge Vars attached to list
*/

function getMergVars(post_url, listid)
{
	jQuery.post(post_url, 	{act: 'get_vars', list_id: listid}, function(data){
		
			alert(data);
			
	});
	
}
</script>