<?php

// Theme options adapted from renegade's options page and an article on WPShout "what I wrote".
// Google WPShout theme options page to find it.

$themename = "renegade";
$shortname = "ren";

// Create theme options

$options = array (

				array(	"name" => __('Twitter Username'),
						"desc" => __('Your Twitter username, to be used on the social media links'),
						"id" => $shortname."_twitter",
						"std" => "AlexDenning",
						"type" => "text"),
						
				array(	"name" => __('Feedburner URL'),
						"desc" => __("Copy and paste your Feedburner URL, ie --> http://feeds2.feedburner.com/nometech"),
						"id" => $shortname."_feedburner",
						"std" => __(""),
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94") ),								
						
				array(	"name" => __(''),
						"desc" => __("<h3>With the options below, you can choose a layout for your blog. Select one only.</h3>"),
						"id" => $shortname."_layout",
						"std" => __("Below you've got the option to choose a layout. Check one box only."),
						"type" => "nothing"),						
						
				array(	"name" => __('Two column layout'),
						"desc" => __("A simple two column layout"),
						"id" => $shortname."_two_column",
						"std" => "true",
						"type" => "checkbox"),
						
				array(	"name" => __('Two column wide layout'),
						"desc" => __("Two columns, with a wider content area and smaller sidebar (590px expanded to 640px)"),
						"id" => $shortname."_two_column_wide",
						"std" => "false",
						"type" => "checkbox"),						
					
				array(	"name" => __('Two column really wide layout'),
						"desc" => __("Two columns with a massive content area and a sidebar only 135px wide."),
						"id" => $shortname."_two_column_really_wide",
						"std" => "false",
						"type" => "checkbox"),
						
				array(	"desc" => __("<h3>Choose elements on the homepage to display/hide</h3>"),
						"type" => "nothing"),	
						
				array(	"name" => __('Featured content'),
						"desc" => __("Hide the featured content?"),
						"id" => $shortname."_featured_content",
						"std" => "false",
						"type" => "checkbox"),
						
				array(	"name" => __('Two featured posts'),
						"desc" => __("Hide the two featured posts below the featured content?"),
						"id" => $shortname."_two_featured_posts",
						"std" => "false",
						"type" => "checkbox"),
						
				array(	"name" => __('Three featured posts'),
						"desc" => __("Hide three posts beneath the two featured posts?"),
						"id" => $shortname."_three_featured_posts",
						"std" => "false",
						"type" => "checkbox"),							
						
				array(	"desc" => __("<h3>Choose sidebar elements to display/not display</h3>"),
						"type" => "nothing"),	

				array(	"name" => __('Tabbed area'),
						"desc" => __("Hide the tabbed area?"),
						"id" => $shortname."_tabs",
						"std" => "false",
						"type" => "checkbox"),		

				array(	"name" => __('Recent comments'),
						"desc" => __("Hide recent comments?"),
						"id" => $shortname."_recent_comments",
						"std" => "false",
						"type" => "checkbox"),
						
				array(	"name" => __('Ad code at 300x250 size'),
						"desc" => __("Copy and paste into the box below your advert code 300x250 size, for displaying on the two column layout"),
						"id" => $shortname."_300_250_ad",
						"std" => __(""),
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94") ),		

				array(	"name" => __('Ad code at 250x200 size'),
						"desc" => __("Copy and paste into the box below your advert code 250x200 size, for displaying on the two column wide layout"),
						"id" => $shortname."_250_200_ad",
						"std" => __(""),
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94") ),	

				array(	"name" => __('Ad code at 125x125 size'),
						"desc" => __("Copy and paste into the box below your advert code 125x125 size, for displaying on the two column really wide layout."),
						"id" => $shortname."_125_125_ad",
						"std" => __(""),
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94") ),

				array(	"desc" => __("<h3>Customise the footer</h3>"),
						"type" => "nothing"),

				array(	"name" => __('Three column footer'),
						"desc" => __("Hide the three column footer?"),
						"id" => $shortname."_three_column_footer",
						"std" => "false",
						"type" => "checkbox"),							
						
				array(	"name" => __('Text in Footer'),
						"desc" => __("Fill out the box with the text you want to be displayed at the very bottom of the theme."),
						"id" => $shortname."_footer_text",
						"std" => __("&#169; 2009 Your Site Name &bull; Powered by WordPress"),
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94") ),
											
				array(	"name" => __('Analytics code'),
						"desc" => __("Paste your Google Analytics (or other tracking) code in the box below"),
						"id" => $shortname."_analytics",
						"std" => __(""),
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94") ),

		);

function mytheme_add_admin() {

    global $themename, $shortname, $options;

    if ( $_GET['page'] == basename(__FILE__) ) {
    
        if ( 'save' == $_REQUEST['action'] ) {

                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

                header("Location: themes.php?page=theme-options.php&saved=true");
                die;

        } else if( 'reset' == $_REQUEST['action'] ) {

            foreach ($options as $value) {
                delete_option( $value['id'] ); }

            header("Location: themes.php?page=theme-options.php&reset=true");
            die;

        } else if ( 'reset_widgets' == $_REQUEST['action'] ) {
            $null = null;
            update_option('sidebars_widgets',$null);
            header("Location: themes.php?page=theme-options.php&reset=true");
            die;
        }
    }

    add_theme_page($themename." Options", "Renegade Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');

}

function mytheme_admin() {

    global $themename, $shortname, $options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' '.__('settings saved.','renegade').'</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' '.__('settings reset.','renegade').'</strong></p></div>';
    if ( $_REQUEST['reset_widgets'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' '.__('widgets reset.','renegade').'</strong></p></div>';
    
?>
<div class="wrap">
<?php if ( function_exists('screen_icon') ) screen_icon(); ?>
<h2><?php echo $themename; ?> Options</h2>

<form method="post" action="">

	<table class="form-table">

<?php foreach ($options as $value) { 
	
	switch ( $value['type'] ) {
		case 'text':
		?>
		<tr valign="top"> 
			<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo __($value['name'],'renegade'); ?></label></th>
			<td>
				<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" />
				<?php echo __($value['desc'],'renegade'); ?>

			</td>
		</tr>
		<?php
		break;
		
		case 'select':
		?>
		<tr valign="top">
			<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo __($value['name'],'renegade'); ?></label></th>
				<td>
					<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
					<?php foreach ($value['options'] as $option) { ?>
					<option<?php if ( get_option( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<?php
		break;
		
		case 'textarea':
		$ta_options = $value['options'];
		?>
		<tr valign="top"> 
			<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo __($value['name'],'renegade'); ?></label></th>
			<td><textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="<?php echo $ta_options['rows']; ?>"><?php 
				if( get_option($value['id']) != "") {
						echo __(stripslashes(get_option($value['id'])),'renegade');
					}else{
						echo __($value['std'],'renegade');
				}?></textarea><br /><?php echo __($value['desc'],'renegade'); ?></td>
		</tr>
		<?php
		break;
		
		case 'nothing':
		$ta_options = $value['options'];
		?>
		</table>
			<?php echo __($value['desc'],'renegade'); ?>
		<table class="form-table">
		<?php
		break;

		case 'radio':
		?>
		<tr valign="top"> 
			<th scope="row"><?php echo __($value['name'],'renegade'); ?></th>
			<td>
				<?php foreach ($value['options'] as $key=>$option) { 
				$radio_setting = get_option($value['id']);
				if($radio_setting != ''){
					if ($key == get_option($value['id']) ) {
						$checked = "checked=\"checked\"";
						} else {
							$checked = "";
						}
				}else{
					if($key == $value['std']){
						$checked = "checked=\"checked\"";
					}else{
						$checked = "";
					}
				}?>
				<input type="radio" name="<?php echo $value['id']; ?>" id="<?php echo $value['id'] . $key; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><label for="<?php echo $value['id'] . $key; ?>"><?php echo $option; ?></label><br />
				<?php } ?>
			</td>
		</tr>
		<?php
		break;
		
		case 'checkbox':
		?>
		<tr valign="top"> 
			<th scope="row"><?php echo __($value['name'],'renegade'); ?></th>
			<td>
				<?php
					if(get_option($value['id'])){
						$checked = "checked=\"checked\"";
					}else{
						$checked = "";
					}
				?>
				<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
				<label for="<?php echo $value['id']; ?>"><?php echo __($value['desc'],'renegade'); ?></label>
			</td>
		</tr>
		<?php
		break;

		default:

		break;
	}
}
?>

	</table>

	<p class="submit">
		<input name="save" type="submit" value="<?php _e('Save changes','renegade'); ?>" />    
		<input type="hidden" name="action" value="save" />
	</p>
</form>
<form method="post" action="">
	<p class="submit">
		<input name="reset" type="submit" value="<?php _e('Reset','renegade'); ?>" />
		<input type="hidden" name="action" value="reset" />
	</p>
</form>

</div>
<?php
}

add_action('admin_menu' , 'mytheme_add_admin'); 


?>