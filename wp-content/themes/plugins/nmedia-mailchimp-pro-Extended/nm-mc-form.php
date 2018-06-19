<?php
/**
** rendering form for user
**/

$post_url = plugins_url('api_mailchimp/postToMailChimp.php', __FILE__);

$form = nmMailChimp::getForm($fid);
$meta = json_decode($form -> form_meta);
$arrVars = $meta -> vars;
?>

<!-- loading custom css here -->
<style>
<?php echo get_option('nm_mc_custom_css')?>
</style>


<div class="nm_mc_form">
  <input type="hidden" value="<?php echo $fid?>" id="nm_mc_form_id-<?php echo $widget_id?>" />
  <ul>
    <?php 
	foreach($arrVars as $key => $val):
  		$tag = $val -> tag;
		$label = $val -> label;
	?>
    <li>
      <label for="<?php echo $tag.'-'.$widget_id?>"><?php echo $label?></label>
      <input type="text" name="nm-form-meta[<?php echo $tag?>]" id="<?php echo $tag.'-'.$widget_id?>" class="nm_mc_input" />
    </li>
    <?php endforeach;?>
    <li>
      <input type="button" class="nm_mc_button" value="<?php echo $button_text?>" id="nm_mc_button-<?php echo $widget_id?>" onclick="postToMailChimp('<?php echo $post_url?>', '<?php echo ABSPATH?>', '<?php echo $widget_id?>', '<?php echo get_option('nm_mc_redirect_to')?>')" / >
     <?php
		echo '<img style="display:none" id="nm-mc-loading" src="'.plugins_url( 'images/loading.gif' , __FILE__).'" />';
	?>
    <div id="mc-response-area">
	</div>
    </li>
  </ul>
</div>
