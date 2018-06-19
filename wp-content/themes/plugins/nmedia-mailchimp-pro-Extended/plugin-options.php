<?php
$plugin_name = "NajeebMedia MailChimp Campaign Creator Plugin";
$shortname = "nm_mc";
$option_page_name = 'nm-mailchimp';


// Create Plugin nm_mc_options

$nm_mc_options = array (

		/* array( "name" => $plugin_name." Options",
				"type" => "title"),

		array( 	"name" => __("Security", "nm_mailchimp_plugin"),
				"type" => "section"),
		array( "type" => "open"),

		array(  "name" => __("Plugin API Key", "nm_mailchimp_plugin"),
				"desc" => __("Enter your Plugin API Key, don't know where to get? please login into your Member Area <a href=http://www.wordpresspoets.com/member-area/ target=_blank>here</a>", "nm_mailchimp_plugin"),
				"id" => $shortname."_plugin_apikey",
				"type" => "text"),

		array(  "name" => __("Email", "nm_mailchimp_plugin"),
				"desc" => __("Enter your email address used in ordering", "nm_mailchimp_plugin"),
				"id" => $shortname."_email",
				"type" => "text"),

		array( "type" => "close"), */


		array( 	"name" => __("General Settings", "nm_mailchimp_plugin"),
				"type" => "section"),
		array( "type" => "open"),

		array(  "name" => __("API Key", "nm_mailchimp_plugin"),
				"desc" => __("Enter your MailChimp API Key, don't know where to get? please visit this link, <a href=http://www.najeebmedia.com/where-can-i-find-my-mailchimp-api-key/ target=_blank>Get API Key</a>", "nm_mailchimp_plugin"),
				"id" => $shortname."_api_key",
				"type" => "text"),
		array( 	"name" => __("Thanks Message", "nm_mailchimp_plugin"),
				"desc" => __("Type a message here, it will be shown when user will submit the email/info for subscription", "nm_mailchimp_plugin"),
				"id" => $shortname."_thanks_message",
				"type" => "textarea",
				"std" => ""),

		array( 	"name" => __("Button Title", "nm_mailchimp_plugin"),
				"desc" => __("Enter button title text e.g: Subscribe", "nm_mailchimp_plugin"),
				"id" => $shortname."_button_title",
				"type" => "text",
				"std" => "Subscribe"),


		array( 	"name" => __("Redirect after successful subscription", "nm_mailchimp_plugin"),
				"desc" => __("If you want to redirect user after successul subscription, otherwise leave it BLANK to stick on same page", "nm_mailchimp_plugin"),
				"id" => $shortname."_redirect_to",
				"type" => "text",
				"std" => ""),

		array( "type" => "close"),


		array( "name" => __("Style/CSS", "nm_mailchimp_plugin"),
				"type" => "section"),
		array( "type" => "open"),


		array( 	"name" => __("Button Text Color", "nm_mailchimp_plugin"),
				"desc" => __("Style/css will be loaded on plugin page", "nm_mailchimp_plugin"),
				"id" => $shortname."_custom_css",
				"type" => "textarea",
				"std" => ".nm_mc_input{width:150px;}"),

		array( "type" => "close"),


);	//end of nm_mc_options array



function nm_plugin_add_admin() {

	global $plugin_name, $shortname, $nm_mc_options, $option_page_name;

	if ( @$_GET['page'] == $option_page_name ) {

		if ( 'save' == @$_REQUEST['action'] ) {
				
				
			update_option($shortname.'_security_status', nmMailChimp::connectMe($_REQUEST['nm_mc_plugin_apikey'], $_REQUEST['nm_mc_email']));
				
				
				
			foreach ($nm_mc_options as $value) {
				update_option( $value['id'], $_REQUEST[ $value['id'] ] );
			}

			foreach ($nm_mc_options as $value) {
				if( isset( $_REQUEST[ $value['id'] ] ) ) {
					update_option( $value['id'], $_REQUEST[ $value['id'] ]  );
				} else { delete_option( $value['id'] );
				}
			}

			header("Location: admin.php?page=$option_page_name&saved=true");
			die;

		} else if( 'reset' == @$_REQUEST['action'] ) {

			foreach ($nm_mc_options as $value) {
				delete_option( $value['id'] );
			}

			header("Location: admin.php?page=$option_page_name&reset=true");
			die;

		}
	}


	add_menu_page($plugin_name,
			"Nmedia MailChimp",
			'edit_plugins',
			$option_page_name,
			'nm_mc_admin',
			plugin_dir_url(__FILE__ ).'images/option.png');


	add_submenu_page( $option_page_name,
			'Lists Manager',
			'Lists Manager',
			'manage_options',
			'lists-manager',
			array('nmMailChimp', 'renderListManager'));

	add_submenu_page( $option_page_name,
			'Forms Wizard',
			'Forms Wizard',
			'manage_options',
			'mailchimp-shortcodes',
			array('nmMailChimp', 'renderShortcodes'));

	add_submenu_page( $option_page_name,
			'Campaigns',
			'Campaigns',
			'manage_options',
			'mailchimp-campaigns',
			array('nmMailChimp', 'renderCampaigns'));


	/*add_menu_page($plugin_name, "", 'edit_plugins', basename(__FILE__), 'nm_mc_admin', plugin_dir_url(__FILE__ ).'images/option.png');*/

}


function nm_plugin_add_init() {
	wp_register_style('nm_plugin_option_style', plugins_url('css/options.css', __FILE__));
	wp_enqueue_style( 'nm_plugin_option_style');

	wp_enqueue_script("nm_plugin_script", plugins_url('js/nm_plugin_option.js', __FILE__), false, "1.0");

	
	
	//I am hiding this, because it is not present in plugin package, Najeeb said on 20 Dec, 2012 6:06 PM
	
	/* wp_register_script( 'nm_mc_ui', plugins_url('js/ui/jquery-ui-1.8.16.custom.min.js', __FILE__), 'jquery');
	wp_enqueue_script('nm_mc_ui');

	wp_register_style('nm_mc_ui_style',	plugins_url('js/ui/ui-lightness/jquery-ui-1.8.16.custom.css', __FILE__));

	wp_enqueue_style('nm_mc_ui_style'); */
}


function nm_mc_admin() {

	global $plugin_name, $shortname, $nm_mc_options, $nm_bgs;
	//print_r($nm_mc_options);


	if ( @$_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$plugin_name.' '.__('Settings saved.','nm_mailchimp_plugin').'</strong></p></div>';
	if ( @$_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$plugin_name.' '.__('Settings reset.','nm_mailchimp_plugin').'</strong></p></div>';
	if ( @$_REQUEST['reset_widgets'] ) echo '<div id="message" class="updated fade"><p><strong>'.$plugin_name.' '.__('Widgets reset.','nm_mailchimp_plugin').'</strong></p></div>';

	?>
<div class="wrap rm_wrap">
	<h2>
		<?php echo $plugin_name; ?>
		Settings
	</h2>

	<div class="nm_opts">
		<form method="post">

			<?php foreach ($nm_mc_options as $value) {

				$security = json_decode(get_option($shortname.'_security_status'));

				$status = '';
				if(isset($value['id']) &&  ($value['id'] == $shortname.'_plugin_apikey'))
				{

					if($security -> code == 1)
					{
						$status = '<br /><span style="color:green">'.$security -> message.'</span>';
					}
					else
					{
						$status = '<br /><span style="color:red">'.$security -> message.'</span>';
					}
				}

				switch ( $value['type'] ) {

					case "open":
						?>

			<?php break;

case "close":
	?>
	
	</div>
</div>
<br />

<?php break;

case "title":
	?>

<?php break;

case 'text':
	?>

<div class="rm_input rm_text">
	<label for="<?php echo $value['id']; ?>"><?php _e($value['name'], 'nm_mailchimp_plugin') ?>
	</label> <input name="<?php echo $value['id']; ?>"
		id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>"
		value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />
	<?php echo $status?> <small><?php _e($value['desc'], 'nm_mailchimp_plugin') ?> </small>
	<div class="clearfix"></div>

</div>
<?php
break;

case 'textarea':
	?>

<div class="rm_input rm_textarea">
	<label for="<?php echo $value['id']; ?>"><?php _e($value['name'], 'nm_mailchimp_plugin') ?>
	</label>
	<textarea name="<?php echo $value['id']; ?>"
		type="<?php echo $value['type']; ?>" cols="" rows="">
		<?php if ( get_option( $value['id'] ) != "") { 
			echo stripslashes(get_option( $value['id']) );
		} else { echo $value['std'];
		} ?>
	</textarea>
	<small><?php _e($value['desc'], 'nm_mailchimp_plugin') ?> </small>
	<div class="clearfix"></div>

</div>

<?php
break;

case 'bgs'		//custom field set by Najeeb
?>

<div class="rm_input">
	<div style="float: left; width: 200px;">
		<label for="<?php echo $value['id']; ?>"><?php _e($value['name'], 'nm_mailchimp_plugin') ?>
		</label>
	</div>
	<div class="nm_bgs">
		<?php foreach($nm_bgs as $bg => $val):
		$bg_img_name = 'images/'.$val;
		?>
		<div class="item">
			<img src="<?php echo plugins_url($bg_img_name, __FILE__)?>"
				alt="<?php echo $bg ?>" width="75" /><br /> <input type="radio"
				name="<?php echo $value['id']; ?>" value="<?php echo $val?>"
				<?php if (get_option( $value['id'] ) == $val) { echo 'checked="checked"'; } ?> />
			<?php echo $bg ?>
		</div>
		<?php endforeach;?>

		<div class="clearfix"></div>
	</div>

	<small><?php _e($value['desc'], 'nm_mailchimp_plugin') ?> </small>
	<div class="clearfix"></div>

</div>

<?php
break;

case 'select':
	?>

<div class="rm_input rm_select">
	<label for="<?php echo $value['id']; ?>"><?php _e($value['name'], 'nm_mailchimp_plugin') ?>
	</label> <select name="<?php echo $value['id']; ?>"
		id="<?php echo $value['id']; ?>">
		<?php foreach ($value['nm_mc_options'] as $option) { ?>
		<option
		<?php if (get_option( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>>
			<?php echo $option; ?>
		</option>
		<?php } ?>
	</select> <small><?php _e($value['desc'], 'nm_mailchimp_plugin') ?> </small>
	<div class="clearfix"></div>
</div>
<?php
break;

case "checkbox":
	?>

<div class="rm_input rm_checkbox">
	<label for="<?php echo $value['id']; ?>"><?php _e($value['name'], 'nm_mailchimp_plugin') ?>
	</label>

	<?php if(get_option($value['id'])){ 
		$checked = "checked=\"checked\"";
	}else{ $checked = "";
} ?>
	<input type="checkbox" name="<?php echo $value['id']; ?>"
		id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />

	<small><?php _e($value['desc'], 'nm_mailchimp_plugin') ?> </small>
	<div class="clearfix"></div>
</div>
<?php break;
case "section":

	?>

<div class="nm_section">
	<div class="rm_title">
		<h3>
			<img src="<?php plugins_url('css/images/trans.gif', __FILE__)?>"
				class="inactive" alt=""">
			<?php _e($value['name'], 'nm_mailchimp_plugin') ?>
		</h3>
		<span class="submit"><input name="save<?php echo $i; ?>" type="submit"
			value="<?php _e('Save Changes', 'nm_mailchimp_plugin')?>" /> </span>
		<div class="clearfix"></div>
	</div>
	<div class="nm_options">

		<?php break;

				}
			}
			?>

		<input type="hidden" name="action" value="save" />
		</form>
		<form method="post">
			<p class="submit">
				<input name="reset" type="submit"
					value="<?php _e('Reset', 'nm_mailchimp_plugin')?>" /> <input
					type="hidden" name="action" value="reset" />
			</p>
		</form>
		<div style="font-size: 9px; margin-bottom: 10px;">
			2012 © <a href="http://www.najeebmedia.com">Nmedia</a>
		</div>
	</div>

	<?php
	// get company ad
	$file = dirname(__FILE__).'/nmedia-ad.php';
	include($file);
}

/*add_action('admin_menu', 'mytheme_add_admin');*/
add_action('admin_init', 'nm_plugin_add_init');
add_action('admin_menu' , 'nm_plugin_add_admin');
