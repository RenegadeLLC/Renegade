<?php
add_action( 'init', 'alm_core_update' ); // Core Update
add_action( 'wp_ajax_alm_save_repeater', 'alm_save_repeater' ); // Ajax Save Repeater
add_action( 'wp_ajax_alm_update_repeater', 'alm_update_repeater' ); // Ajax Update Repeater
add_action( 'wp_ajax_alm_get_tax_terms', 'alm_get_tax_terms' ); // Ajax Get Taxonomy Terms
add_action( 'wp_ajax_alm_delete_cache', 'alm_delete_cache' ); // Delete Cache
add_action( 'wp_ajax_alm_layouts_dismiss', 'alm_layouts_dismiss' ); // Dismiss Layouts CTA
add_action( 'wp_ajax_alm_license_activation', 'alm_license_activation' ); // Activate Add-on
add_action( 'alm_get_layouts', 'alm_get_layouts' ); // Add layout selection
add_action( 'wp_ajax_alm_get_layout', 'alm_get_layout' ); // Get layout
add_action( 'wp_ajax_alm_dismiss_sharing', 'alm_dismiss_sharing' ); // Dismiss sharing
add_filter( 'admin_footer_text', 'alm_filter_admin_footer_text'); // Admin menu text
add_action( 'admin_notices', 'alm_admin_notice_errors' ); // License notice



/*
*  alm_admin_notice_errors
*  Invalid license notifications
*
*  @since 3.3.0
*/
function alm_admin_notice_errors() {
   $screen = get_current_screen();
   $alm_is_admin_screen = alm_is_admin_screen();
   // Exit if screen is not dashboard, plugins or ALM admin.
	if(!$alm_is_admin_screen && $screen->id !== 'dashboard' && $screen->id !== 'plugins'){
		return;
	}
   $class = 'notice error alm-err-notice';
   $message = '';
   $count = 0;
   $addons = alm_get_addons();
    // Loop each addon
   foreach($addons as $addon){
      $action = $addon['action']; // Get action
      if (has_action($action)){
         $key = $addon['key']; // Option key
         $status = $addon['status']; // license status
         $addon_status = get_option( $status );
         if( !isset($addon_status) || empty($addon_status) || $addon_status !== 'valid' ) {
            $count++;
         }
      }
   }
	if( $count > 0 ) {
		$message = __( 'You have invalid <a href="admin.php?page=ajax-load-more"><b>Ajax Load More</b></a> license keys - please visit the <a href="admin.php?page=ajax-load-more-licenses">Licenses</a> section and input your license keys.', 'ajax-load-more' );
		printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
	}
}


/*
*  alm_license_activation
*  Activate Add-on licenses
*
*  @since 2.8.3
*/

function alm_license_activation(){

	if (current_user_can( 'edit_theme_options' )){

		$nonce = $_GET["nonce"];
	   $type = $_GET["type"]; // activate / deactivate
	   $item = $_GET["item"];
	   $license = $_GET["license"];
	   $url = $_GET["url"];
	   $upgrade = $_GET["upgrade"];
	   $option_status = $_GET["status"];
	   $option_key = $_GET["key"];

	   // Check our nonce, if they don't match then bounce!
	   if (! wp_verify_nonce( $nonce, 'alm_repeater_nonce' ))
	      die('Error - unable to verify nonce, please try again.');

		// data to send in our API request
		if($type === 'activate'){
			$action = 'activate_license';
		}else{
			$action = 'deactivate_license';
		}

		$api_params = array(
			'edd_action'=> $action,
			'license' 	=> $license,
			'item_id'   => $item, // the ID of our product in EDD
			'url'       => home_url()
		);

		// Call API
		// Updated 2.8.7
		$response = wp_remote_post( ALM_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		$license_data = $response['body'];
		$license_data = json_decode($license_data); // decode the license data
		$return["success"] = $license_data->success;

		$msg = '';
		if($type === 'activate'){
			$return["license_limit"] = $license_data->license_limit;
			$return["expires"] = $license_data->expires;
			$return["site_count"] = $license_data->site_count;
			$return["activations_left"] = $license_data->activations_left;
			$return["license"] = $license_data->license;
			$return["item_name"] = $license_data->item_name;
			if($license_data->activations_left === 0 && $license_data->success === false){
				$msg = '<strong>Sorry, but you are out of available licenses <em>('. $license_data->license_limit .' / '. $license_data->site_count .')</em>.</strong> Please visit the <a href="'.$upgrade.'" target="_blank">'.$license_data->item_name.'</a> page to add additional licenses.';
			}
		}
		$return["msg"] = $msg;

		update_option( $option_status, $license_data->license);
		update_option( $option_key, $license );

	   wp_send_json($return);


	} else {

      echo __('You don\'t belong here.', 'ajax-load-more');

   }
}



/*
*  alm_get_layout
*  Get layout and return value to repeater template
*
*  @since 2.8.3
*  @updated 2.14.0
*/

function alm_get_layout(){
   if (current_user_can( 'edit_theme_options' )){

      $nonce = sanitize_text_field($_GET["nonce"]);
      $type = sanitize_text_field($_GET["type"]);
      $custom = sanitize_text_field($_GET["custom"]);

      // Check our nonce, if they don't match then bounce!
      if (! wp_verify_nonce( $nonce, 'alm_repeater_nonce' ))
         die('Error - unable to verify nonce, please try again.');

      if($type === 'default'){

	      // Default Layout
         $content =  file_get_contents(ALM_PATH.'admin/includes/layout/'.$type.'.php');

      }else{

		   // Custom Layout
	      if($custom == 'true'){
		      $dir = 'alm_layouts';

				if(is_child_theme()){
					$path = get_stylesheet_directory().'/'. $dir .'/' .$type;
					// if child theme does not have the layout, check the parent theme
					if(!file_exists($path)){
						$path = get_template_directory().'/'. $dir .'/' .$type;
					}
				}
				else{
					$path = get_template_directory().'/'. $dir .'/' .$type;
				}
         	$content =  file_get_contents($path);

		   }

		   // Layouts Add-on
		   else {
         	$content =  file_get_contents(ALM_LAYOUTS_PATH.'layouts/'.$type.'.php');
         }
      }

      $return["value"] = $content;
      echo json_encode($return);
   }else {
         echo __('You don\'t belong here.', 'ajax-load-more');
   }
   die();
}




/*
*  alm_get_layouts
*  Get the list of layout templates
*
*  @since 2.8.7
*/
function alm_get_layouts(){ // do_action
   include( ALM_PATH . 'admin/includes/components/layout-list.php');
}

/*
*  alm_admin_vars
*  Create admin variables and ajax nonce
*
*  @since 2.0.0
*/
function alm_admin_vars() { ?>
    <script type='text/javascript'>
	 /* <![CDATA[ */
    var alm_admin_localize = <?php echo json_encode( array(
        'ajax_admin_url' => admin_url( 'admin-ajax.php' ),
        'ajax_load_more' => __('Ajax Load More', 'ajax-load-more'),
        'active' => __('Active', 'ajax-load-more'),
        'inactive' => __('Inactive', 'ajax-load-more'),
        'applying_layout' => __('Applying layout', 'ajax-load-more'),
        'template_updated' => __('Template Updated', 'ajax-load-more'),
        'alm_admin_nonce' => wp_create_nonce( 'alm_repeater_nonce' ),
        'select_authors' => __('Select Author(s)', 'ajax-load-more'),
        'select_cats' => __('Select Categories', 'ajax-load-more'),
        'select_tags' => __('Select Tags', 'ajax-load-more'),
        'jump_to_option' => __('Jump to Option', 'ajax-load-more'),
        'jump_to_template' => __('Jump to Template', 'ajax-load-more'),
        'install_now' => __('Are you sure you want to install this Ajax Load More extension?', 'ajax-load-more'),
        'install_btn' => __('Install Now', 'ajax-load-more'),
        'activate_btn' => __('Activate', 'ajax-load-more'),
        'settings_saving' => '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> ' . __('Saving Settings', 'ajax-load-more'),
        'settings_saved' => '<i class="fa fa-check" aria-hidden="true"></i> ' . __('Settings Saved Successfully', 'ajax-load-more'),
        'settings_error' => '<i class="fa fa-exclamation-circle" aria-hidden="true"></i> ' . __('Error Saving Settings', 'ajax-load-more')
    )); ?>
    /* ]]> */
    </script>
<?php }



/*
*  alm_set_admin_nonce
*  Create admin nonce on Repeater Template page only
*
*  @since 2.8.2
*/
function alm_set_admin_nonce(){
   add_action( 'admin_head', 'alm_admin_vars' ); // Localized Vars
}



/**
* alm_core_update
* Update default repeater on plugin update.
* If plugin versions do not match or the plugin has been updated and we need to update our repeaters.
*
* @since 2.0.5
*/

function alm_core_update() {

	if(!get_option( 'alm_version')){ // Add 'alm_version' to WP options table if it does not exist
		add_option( 'alm_version', ALM_VERSION );
	}

	$alm_installed_ver = get_option( "alm_version" ); // Get value from WP Option tbl
	if ( $alm_installed_ver != ALM_VERSION ) {
   	delete_transient('alm_dismiss_sharing'); // Delete ALM transients
		alm_run_update(); // Update repeaters
	}
}



/**
* alm_run_update
* Run the update on all 'blogs'
*
* @since 2.7.2
*/

function alm_run_update(){
   global $wpdb;

   if ( is_multisite()) {
   	$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
   	// Loop all blogs and run update routine
      foreach ( $blog_ids as $blog_id ) {
         switch_to_blog( $blog_id );
         alm_update_template_files();
         restore_current_blog();
      }
   } else {
      alm_update_template_files();
   }

   update_option( "alm_version", ALM_VERSION ); // Update the WP Option tbl with the new version num
}


/**
* alm_update_template_files
* Update routine for template files
*
* @since 2.7.2
*/

function alm_update_template_files(){
   global $wpdb;
	$table_name = $wpdb->prefix . "alm";

	// Get all rows where name is 'default'
   $rows = $wpdb->get_results("SELECT * FROM $table_name WHERE name = 'default'");

   if($rows){

      foreach( $rows as $row ) { // Loop $rows

         $data = $wpdb->get_var("SELECT repeaterDefault FROM $table_name WHERE name = 'default'");

         // Create Base Repeater Dir (alm_templates)
         $base_dir = AjaxLoadMore::alm_get_repeater_path();   
         AjaxLoadMore::alm_mkdir($base_dir);

		   $file = $base_dir .'/default.php';

         // Wrap is file_exists to avoid updating without cause
			if( !file_exists($file) ){
	         try {
	            $o = fopen($file, 'w+'); //Open file
	            if ( !$o ) {
	              throw new Exception(__('[Ajax Load More] Error opening default repeater template - Please check your file path and ensure your server is configured to allow Ajax Load More to read and write files within the /ajax-load-more/core/repeater directory', 'ajax-load-more'));
	            }
	            $w = fwrite($o, $data); //Save the file
	            if ( !$w ) {
	              throw new Exception(__('[Ajax Load More] Error updating default repeater template - Please check your file path and ensure your server is configured to allow Ajax Load More to read and write files within the /ajax-load-more/core/repeater directory.', 'ajax-load-more'));
	            }
	            fclose($o); // Close file

	         } catch ( Exception $e ) { // Display error message in console.
	            if(!isset($options['_alm_error_notices']) || $options['_alm_error_notices'] == '1'){
	               echo '<script>console.log("' .$e->getMessage(). '");</script>';
	            }
	         }
         }

      }
   }
}



/**
* alm_admin_menu
* Create Admin Menu
*
* @since 2.0.0
*/

add_action( 'admin_menu', 'alm_admin_menu' );
function alm_admin_menu() {
   $icon = 'dashicons-plus-alt';
   $icon = ALM_ADMIN_URL . "/img/alm-logo-16x16.svg";

   $alm_page = add_menu_page(
      'Ajax Load More',
      'Ajax Load More',
      'edit_theme_options',
      'ajax-load-more',
      'alm_settings_page',
      $icon
   );

   $alm_settings_page = add_submenu_page(
      'ajax-load-more',
      'Settings',
      'Settings',
      'edit_theme_options',
      'ajax-load-more',
      'alm_settings_page'
   );

   $alm_template_page = add_submenu_page(
      'ajax-load-more',
      'Repeater Templates',
      'Repeater Templates',
      'edit_theme_options',
      'ajax-load-more-repeaters',
      'alm_repeater_page'
   );

   $alm_shortcode_page = add_submenu_page(
      'ajax-load-more',
      'Shortcode Builder',
      'Shortcode Builder',
      'edit_theme_options',
      'ajax-load-more-shortcode-builder',
      'alm_shortcode_builder_page'
   );

   $alm_addons_page = add_submenu_page(
      'ajax-load-more',
      'Add-ons',
      'Add-ons',
      'edit_theme_options',
      'ajax-load-more-add-ons',
      'alm_add_ons_page'
   );

   $alm_extensions_page = add_submenu_page(
      'ajax-load-more',
      'Extensions',
      'Extensions',
      'edit_theme_options',
      'ajax-load-more-extensions',
      'alm_extensions_page'
   );

   $alm_help_page = add_submenu_page(
      'ajax-load-more',
      'Help',
      'Help',
      'edit_theme_options',
      'ajax-load-more-help',
      'alm_help_page'
   );

   $alm_licenses_page = add_submenu_page(
      'ajax-load-more',
      'Licenses',
      'Licenses',
      'edit_theme_options',
      'ajax-load-more-licenses',
      'alm_licenses_page'
   );


   $before_link = '<span style="display:block; border-top: 1px solid #555; padding-top: 8px;">';
	$after_link = '</span>';
	$style_link_icon = 'style="opacity: 0.6; font-size: 18px; height: 18px; width: 18px; position: relative; left: -2px;"';

   if(has_action('alm_cache_installed')){
      $alm_cache_page = add_submenu_page(
         'ajax-load-more',
         __('Cache', 'ajax-load-more'),
         $before_link . '<span class="dashicons dashicons-admin-generic" '.$style_link_icon.'></span> ' .__('Cache', 'ajax-load-more') . $after_link,
         'edit_theme_options',
         'ajax-load-more-cache',
         'alm_cache_page'
      );
      add_action( 'load-' . $alm_cache_page, 'alm_load_admin_js' );
      add_action( 'load-' . $alm_cache_page, 'alm_load_cache_admin_js' );
      add_action( 'load-' . $alm_cache_page, 'alm_set_admin_nonce' );
   }

   if(has_action('alm_filters_installed')){

	   if(has_action('alm_cache_installed')){
		   $before_link = '<span style="display:block;">';
		}

      $alm_filters_page = add_submenu_page(
         'ajax-load-more',
         __('Filters', 'ajax-load-more'),
         $before_link . '<span class="dashicons dashicons-filter" '.$style_link_icon.'></span> '. __('Filters', 'ajax-load-more') . $after_link,
         'edit_theme_options',
         'ajax-load-more-filters',
         'alm_filters_page'
      );
      add_action( 'load-' . $alm_filters_page, 'alm_load_admin_js' );
      add_action( 'load-' . $alm_filters_page, 'alm_load_filters_admin_scripts' );
      add_action( 'load-' . $alm_filters_page, 'alm_set_admin_nonce' );
   }

   //Add our admin scripts
   add_action( 'load-' . $alm_settings_page, 'alm_load_admin_js' );
   add_action( 'load-' . $alm_settings_page, 'alm_set_admin_nonce' );
   add_action( 'load-' . $alm_template_page, 'alm_load_admin_js' );
   add_action( 'load-' . $alm_template_page, 'alm_set_admin_nonce' );
   add_action( 'load-' . $alm_shortcode_page, 'alm_load_admin_js' );
   add_action( 'load-' . $alm_shortcode_page, 'alm_set_admin_nonce' );
   add_action( 'load-' . $alm_help_page, 'alm_load_admin_js' );
   add_action( 'load-' . $alm_help_page, 'alm_set_admin_nonce' );
   add_action( 'load-' . $alm_addons_page, 'alm_load_admin_js' );
   add_action( 'load-' . $alm_addons_page, 'alm_set_admin_nonce' );
   add_action( 'load-' . $alm_extensions_page, 'alm_load_admin_js' );
   add_action( 'load-' . $alm_extensions_page, 'alm_set_admin_nonce' );
   add_action( 'load-' . $alm_licenses_page, 'alm_load_admin_js' );
   add_action( 'load-' . $alm_licenses_page, 'alm_set_admin_nonce' );
}




/*
*  alm_settings_page
*  Settings page
*
*  @since 2.0.0
*/

function alm_settings_page(){
   include_once( ALM_PATH . 'admin/views/settings.php');
}



/*
*  alm_repeater_page
*  Custom Repeaters
*
*  @since 2.0.0
*/

function alm_repeater_page(){
   include_once( ALM_PATH . 'admin/views/repeater-templates.php');
}



/*
*  alm_shortcode_builder_page
*  Shortcode Builder
*
*  @since 2.0.0
*/

function alm_shortcode_builder_page(){
   include_once( ALM_PATH . 'admin/views/shortcode-builder.php');
}



/*
*  alm_add_ons_page
*  Ajax Load More Add-ons
*
*  @since 2.0.0
*/

function alm_add_ons_page(){
   include_once( ALM_PATH . 'admin/views/add-ons.php');
}



/*
*  alm_extensions_ons_page
*  Ajax Load More Add-ons
*
*  @since 3.0.0
*/

function alm_extensions_page(){
   include_once( ALM_PATH . 'admin/views/extensions.php');
}



/*
*  alm_example_page
*  Examples Page
*
*  @since 2.0.0
*/

function alm_examples_page(){
   include_once( ALM_PATH . 'admin/views/examples.php');
}



/*
*  alm_help_page
*  Help Page (Implementation Inforgraphic)
*
*  @since 2.8.7
*/

function alm_help_page(){
   include_once( ALM_PATH . 'admin/views/help.php');
}



/*
*  alm_licenses_page
*  Ajax Load More Licenses
*
*  @since 2.7.0
*/

function alm_licenses_page(){
   include_once( ALM_PATH . 'admin/views/licenses.php');
}


/*
*  alm_cache_page
*  Cache Add-on page
*
*  @since 2.6.0
*/

function alm_cache_page(){
   include_once( ALM_CACHE_ADMIN_PATH . 'admin/views/cache.php');
}


/*
*  alm_filters_page
*  Filters Add-on page
*
*  @since 3.4.0
*/

function alm_filters_page(){
   include_once( ALM_FILTERS_PATH . 'admin/functions.php');
   include_once( ALM_FILTERS_PATH . 'admin/views/filters.php');
}



/**
* alm_load_admin_js
* Load Admin JS
*
* @since 2.0.15
*/

function alm_load_admin_js(){
	add_action( 'admin_enqueue_scripts', 'alm_enqueue_admin_scripts' );
}
// Cache Scripts
function alm_load_cache_admin_js(){
	if(class_exists('ALMCache')){
   	ALMCache::alm_enqueue_cache_admin_scripts();
   }
}
// Filters Scripts
function alm_load_filters_admin_scripts(){
	if(class_exists('ALMFilters')){
   	ALMFilters::alm_enqueue_filters_admin_scripts();
   }
}



/**
* alm_enqueue_admin_scripts
* Enqueue Admin JS
*
* @since 2.0.15
*/

function alm_enqueue_admin_scripts(){

   // Admin CSS
   wp_enqueue_style( 'alm-admin', ALM_ADMIN_URL. 'dist/css/admin.css', '', ALM_VERSION);
   wp_enqueue_style( 'alm-core', ALM_URL. '/core/dist/css/ajax-load-more.css', '', ALM_VERSION);

	// disable ACF select2 on ALM pages
   wp_dequeue_style( 'acf-input' );

   // CodeMirror Syntax Highlighting if on Repater Template page
   $screen = get_current_screen();
   if ( in_array( $screen->id, array( 'ajax-load-more_page_ajax-load-more-repeaters') ) ){

      //CodeMirror CSS
      wp_enqueue_style( 'alm-codemirror-css', ALM_ADMIN_URL. 'codemirror/lib/codemirror.css' );

      //CodeMirror JS
      wp_enqueue_script( 'alm-codemirror', ALM_ADMIN_URL. 'codemirror/lib/codemirror.js');
      wp_enqueue_script( 'alm-codemirror-matchbrackets', ALM_ADMIN_URL. 'codemirror/addon/edit/matchbrackets.js' );
      wp_enqueue_script( 'alm-codemirror-htmlmixed', ALM_ADMIN_URL. 'codemirror/mode/htmlmixed/htmlmixed.js' );
      wp_enqueue_script( 'alm-codemirror-xml', ALM_ADMIN_URL. 'codemirror/mode/xml/xml.js' );
      wp_enqueue_script( 'alm-codemirror-javascript', ALM_ADMIN_URL. 'codemirror/mode/javascript/javascript.js' );
      wp_enqueue_script( 'alm-codemirror-mode-css', ALM_ADMIN_URL. 'codemirror/mode/css/css.js' );
      wp_enqueue_script( 'alm-codemirror-clike', ALM_ADMIN_URL. 'codemirror/mode/clike/clike.js' );
      wp_enqueue_script( 'alm-codemirror-php', ALM_ADMIN_URL. 'codemirror/mode/php/php.js' );

   }

   // Admin JS
   wp_enqueue_script( 'jquery-form' );
   wp_enqueue_script( 'alm-admin', ALM_ADMIN_URL. 'dist/js/admin.js', array( 'jquery' ), ALM_VERSION);
   wp_enqueue_script( 'alm-shortcode-builder', ALM_ADMIN_URL. 'shortcode-builder/js/shortcode-builder.js', array( 'jquery' ), ALM_VERSION);

}



/*
*  alm_save_repeater
*  Repeater Save function
*
*  @return   response
*  @since 2.0.0
*  @updated 3.5
*/

function alm_save_repeater(){

	if (current_user_can( 'edit_theme_options' )){

		global $wpdb;
		$table_name = $wpdb->prefix . "alm";
		$blog_id = $wpdb->blogid;
		$options = get_option( 'alm_settings' ); //Get plugin options
		$nonce = $_POST["nonce"];

		if (! wp_verify_nonce( $nonce, 'alm_repeater_nonce' )){ // Check our nonce
			die('Error - unable to verify nonce, please try again.');
      }

	   // Get _POST Vars
		$c = Trim(stripslashes($_POST["value"])); // Repeater Value
		$n = Trim(stripslashes($_POST["repeater"])); // Repeater name
		$t = Trim(stripslashes($_POST["type"])); // Repeater name
		$a = Trim(stripslashes($_POST["alias"])); // Repeater alias


		// Default
		if($t === 'default'){

         // Create Base Repeater Dir (alm-templates)
         $base_dir = AjaxLoadMore::alm_get_repeater_path();
         AjaxLoadMore::alm_mkdir($base_dir);

		   $f = $base_dir .'/default.php';

	   }

	   // Unlimited (Custom Repeaters v2)
	   elseif($t === 'unlimited'){
		   if($blog_id > 1){
			   $dir = ALM_UNLIMITED_PATH. 'repeaters/'. $blog_id;
		   	if( !is_dir($dir) ){
		         mkdir($dir);
		      }
				$f = ALM_UNLIMITED_PATH. 'repeaters/'. $blog_id .'/'.$n .'.php';
			}else{
				$f = ALM_UNLIMITED_PATH. 'repeaters/'.$n .'.php';
			}

	   }

	   // Custom Repeaters v1
		else{
			$f = ALM_REPEATER_PATH. 'repeaters/'.$n .'.php';
	   }


      // Write Repeater Template
	   try {
	      $o = fopen($f, 'w+'); //Open file
	      if ( !$o ) {
	        throw new Exception(__('[Ajax Load More] Unable to open repeater template - '.$f.' - Please check your file path and ensure your server is configured to allow Ajax Load More to read and write files.', 'ajax-load-more'));
	      }
	      $w = fwrite($o, $c); //Save the file
	      if ( !$w ) {
	        throw new Exception(__('[Ajax Load More] Error saving repeater template - '.$f.' - Please check your file path and ensure your server is configured to allow Ajax Load More to read and write files.', 'ajax-load-more'));
	      }
	      fclose($o); //now close it

	   } catch ( Exception $e ) {
	      // Display error message in console.
	      if(!isset($options['_alm_error_notices']) || $options['_alm_error_notices'] == '1'){
	         echo '<script>console.log("' .$e->getMessage(). '");</script>';
	      }
	   }

		// Save to database

		if($t === 'default')	{
		   $data_update = array('repeaterDefault' => "$c", 'pluginVersion' => ALM_VERSION);
		   $data_where = array('name' => "default");
	   }
	   elseif($t === 'unlimited'){ // Unlimited Repeaters
	      $table_name = $wpdb->prefix . "alm_unlimited";
		   $data_update = array('repeaterDefault' => "$c", 'alias' => "$a", 'pluginVersion' => ALM_UNLIMITED_VERSION);
		   $data_where = array('name' => $n);
	   }
	   else{ // Custom Repeaters
		   $data_update = array('repeaterDefault' => "$c", 'alias' => "$a", 'pluginVersion' => ALM_REPEATER_VERSION);
	      $data_where = array('name' => $n);
	   }

		$wpdb->update($table_name , $data_update, $data_where);

		//Our results
		if($w){
		    echo '<span class="saved">'. __('Template Saved Successfully', 'ajax-load-more') .'</span>';
		} else {
		    echo '<span class="saved-error"><b>'. __('Error Writing File', 'ajax-load-more') .'</b></span><br/>'. __('Something went wrong and the data could not be saved.', 'ajax-load-more');
		}

		die();

	}else {
		echo __('You don\'t belong here.', 'ajax-load-more');
	}
}



/*
*  alm_update_repeater
*  Update repeater template from database
*  User case: User deletes plugin, then installs again and the version has not change. Click 'Update from DB' option to load template.
*
*  @return Database value
*  @since 2.5.0
*/

function alm_update_repeater(){

	if (current_user_can( 'edit_theme_options' )){

		$nonce = $_POST["nonce"];
		// Check our nonce
		if (! wp_verify_nonce( $nonce, 'alm_repeater_nonce' )){ // Check our nonce
			die('Error - unable to verify nonce, please try again.');
      }

	   // Get _POST Vars
		$n = Trim(stripslashes($_POST["repeater"])); // Repeater name
		$t = Trim(stripslashes($_POST["type"])); // Repeater type (default | unlimited)


		// Get value from database
		global $wpdb;
		$table_name = $wpdb->prefix . "alm";

		if($t === 'default')	$n = 'default';
	   if($t === 'unlimited') $table_name = $wpdb->prefix . "alm_unlimited";

	   $the_repeater = $wpdb->get_var("SELECT repeaterDefault FROM " . $table_name . " WHERE name = '$n'");

	   echo $the_repeater; // Return repeater value

		die();

	} else {

		echo __('You don\'t belong here.', 'ajax-load-more');

	}
}



/*
*  alm_get_tax_terms
*  Get taxonomy terms for shortcode builder
*
*  @return   Taxonomy Terms
*  @since 2.1.0
*/

function alm_get_tax_terms(){
	if (current_user_can( 'edit_theme_options' )){

		$nonce = $_GET["nonce"];
		// Check our nonce, if they don't match then bounce!
		if (! wp_verify_nonce( $nonce, 'alm_repeater_nonce' ))
			die('Get Bounced!');

		$taxonomy = (isset($_GET['taxonomy'])) ? $_GET['taxonomy'] : '';
		$index = (isset($_GET['index'])) ? $_GET['index'] : '1';

		$tax_args = array(
			'orderby'       => 'name',
			'order'         => 'ASC',
			'hide_empty'    => false
		);
		$terms = get_terms($taxonomy, $tax_args);
		$returnVal = '';
		if ( !empty( $terms ) && !is_wp_error( $terms ) ){
			$returnVal .= '<ul>';
			foreach ( $terms as $term ) {

				$returnVal .='<li><input type="checkbox" class="alm_element" name="tax-term-'.$term->slug.'" id="tax-term-'.$term->slug.'-'.$index.'" data-type="'.$term->slug.'"><label for="tax-term-'.$term->slug.'-'.$index.'">'.$term->name.'</label></li>';

			}
			$returnVal .= '</ul>';
			echo $returnVal;

			die();
		}else{
			echo "<p class='warning'>No terms exist within this taxonomy</p>";
			die();
		}

	} else {
		echo __('You don\'t belong here.', 'ajax-load-more');
	}
}



/*
*  alm_layouts_dismiss
*  Dismiss Add Layouts CTA in repeater templates.
*
*  @since 2.8.2.1
*/
function alm_layouts_dismiss(){
   if (current_user_can( 'edit_theme_options' )){

		$nonce = $_POST["nonce"];

		// Check our nonce, if they don't match then bounce!
		if (! wp_verify_nonce( $nonce, 'alm_repeater_nonce' ))
			die('Error - unable to verify nonce, please try again.');

      update_option('alm_layouts_dismiss', 'true');
      echo 'Success';

      die();
   }
}



/*
*  alm_dismiss_sharing
*  Dismiss sharing widget on plugin settings page.
*
*  @since 2.8.2.1
*/
function alm_dismiss_sharing(){
   if (current_user_can( 'edit_theme_options' )){

		$nonce = $_POST["nonce"];

		// Check our nonce, if they don't match then bounce!
		if (! wp_verify_nonce( $nonce, 'alm_repeater_nonce' ))
			die('Error - unable to verify nonce, please try again.');

      set_transient( 'alm_dismiss_sharing', 'true', YEAR_IN_SECONDS );
      echo 'ALM sharing dismissed successfully.';

      die();
   }
}



/*
*  alm_filter_admin_footer_text
*  Filter the WP Admin footer text only on ALM pages
*
*  @since 2.12.0
*/

function alm_filter_admin_footer_text( $text ) {
	$screen = alm_is_admin_screen();
	if(!$screen){
		return;
	}

	echo '<strong>Ajax Load More</strong> is made with <span style="color: #e25555;">♥</span> by <a href="https://connekthq.com" target="_blank" style="font-weight: 500;">Connekt</a> | <a href="https://wordpress.org/support/plugin/ajax-load-more/reviews/" target="_blank" style="font-weight: 500;">Leave a Review</a> | <a href="https://connekthq.com/plugins/ajax-load-more/support/" target="_blank" style="font-weight: 500;">Get Support</a>';
}



/*
*  admin_init
*  Initiate the plugin, create our setting variables.
*
*  @since 2.0.0
*/

add_action( 'admin_init', 'alm_admin_init');
function alm_admin_init(){

	register_setting(
		'alm-setting-group',
		'alm_settings',
		'alm_sanitize_settings'
	);

	add_settings_section(
		'alm_general_settings',
		'Global Settings',
		'alm_general_settings_callback',
		'ajax-load-more'
	);

	add_settings_section(
		'alm_admin_settings',
		'Admin Settings',
		'alm_admin_settings_callback',
		'ajax-load-more'
	);

	add_settings_field( // Container type
	    '_alm_container_type',
	    __('Container Type', 'ajax-load-more' ),
	    'alm_container_type_callback',
	    'ajax-load-more',
	    'alm_general_settings'
	);

	add_settings_field(  // Classnames
		'_alm_classname',
		__('Container Classes', 'ajax-load-more' ),
		'alm_class_callback',
		'ajax-load-more',
		'alm_general_settings'
	);

	add_settings_field(  // Disbale CSS
		'_alm_disable_css',
		__('Disable CSS', 'ajax-load-more' ),
		'alm_disable_css_callback',
		'ajax-load-more',
		'alm_general_settings'
	);

	add_settings_field(  // Btn color
		'_alm_btn_color',
		__('Button/Loading Style', 'ajax-load-more' ),
		'alm_btn_color_callback',
		'ajax-load-more',
		'alm_general_settings'
	);

	add_settings_field(  // Button classes
		'_alm_btn_classname',
		__('Button Classes', 'ajax-load-more' ),
		'alm_btn_class_callback',
		'ajax-load-more',
		'alm_general_settings'
	);

	add_settings_field(  // Inline CSS
		'_alm_inline_css',
		__('Load CSS Inline', 'ajax-load-more' ),
		'alm_inline_css_callback',
		'ajax-load-more',
		'alm_general_settings'
	);

	add_settings_field(  // Scroll to top on load
		'_alm_scroll_top',
		__('Top of Page', 'ajax-load-more' ),
		'_alm_scroll_top_callback',
		'ajax-load-more',
		'alm_general_settings'
	);

	add_settings_field(  // Load dynamic queries
		'_alm_disable_dynamic',
		__('Dynamic Content', 'ajax-load-more' ),
		'alm_disable_dynamic_callback',
		'ajax-load-more',
		'alm_admin_settings'
	);

	add_settings_field(  // Hide btn
		'_alm_hide_btn',
		__('Editor Button', 'ajax-load-more' ),
		'alm_hide_btn_callback',
		'ajax-load-more',
		'alm_admin_settings'
	);

	add_settings_field(  // Display error notices
		'_alm_error_notices',
		__('Error Notices', 'ajax-load-more' ),
		'_alm_error_notices_callback',
		'ajax-load-more',
		'alm_admin_settings'
	);


	// CACHE
	if(has_action('alm_cache_settings')){
   	do_action('alm_cache_settings');
   }


	// CUSTOM REPEATERS
	if(has_action('alm_unlimited_settings')){
   	do_action('alm_unlimited_settings');
   }


	// FILTERS
	if(has_action('alm_filters_settings')){
   	do_action('alm_filters_settings');
   }


	// LAYOUTS
	if(has_action('alm_layouts_settings')){
   	do_action('alm_layouts_settings');
   }


	// PAGINATION
	if(has_action('alm_paging_settings')){
   	do_action('alm_paging_settings');
   }


	// PREVIOUS POST
	if(has_action('alm_prev_post_settings')){
   	do_action('alm_prev_post_settings');
   }


	// PRELOADED
	if(has_action('alm_preloaded_settings')){
   	do_action('alm_preloaded_settings');
   }


	// REST API
	if(has_action('alm_rest_api_settings')){
   	do_action('alm_rest_api_settings');
   }


	// SEO
	if(has_action('alm_seo_settings')){
		do_action('alm_seo_settings');
	}


	// THEME REPEATERS
	if(has_action('alm_theme_repeaters_settings')){
   	do_action('alm_theme_repeaters_settings');
   }
}



/*
*  alm_general_settings_callback
*  Some general settings text
*
*  @since 2.0.0
*/

function alm_general_settings_callback() {
    echo '<p>' . __('Customize the user experience of Ajax Load More by updating the fields below.', 'ajax-load-more') . '</p>';
}



/*
*  alm_admin_settings_callback
*  Some general admin settings text
*
*  @since 2.0.0
*/

function alm_admin_settings_callback() {
    echo '<p>' . __('The following settings affect the WordPress admin area only.', 'ajax-load-more') . '</p>';
}


/*
*  alm_sanitize_settings
*  Sanitize our form fields
*
*  @since 2.0.0
*/

function alm_sanitize_settings( $input ) {
    return $input;
}



/*
*  alm_disable_css_callback
*  Diabale Ajax Load More CSS.
*
*  @since 2.0.0
*/

function alm_disable_css_callback(){
	$options = get_option( 'alm_settings' );
	if(!isset($options['_alm_disable_css']))
	   $options['_alm_disable_css'] = '0';

	$html = '<input type="hidden" name="alm_settings[_alm_disable_css]" value="0" />';
	$html .= '<input type="checkbox" id="alm_disable_css_input" name="alm_settings[_alm_disable_css]" value="1"'. (($options['_alm_disable_css']) ? ' checked="checked"' : '') .' />';
	$html .= '<label for="alm_disable_css_input">'.__('I want to use my own CSS styles.', 'ajax-load-more').'<br/><span style="display:block;"><i class="fa fa-file-text-o"></i> &nbsp;<a href="'.ALM_URL.'/core/dist/css/ajax-load-more.css" target="blank">'.__('View Ajax Load More CSS', 'ajax-load-more').'</a></span></label>';

	echo $html;
}



/*
*  alm_hide_btn_callback
*  Disbale the ALM shortcode button in the WordPress content editor
*
*  @since 2.2.1
*/

function alm_hide_btn_callback(){
	$options = get_option( 'alm_settings' );
	if(!isset($options['_alm_hide_btn']))
	   $options['_alm_hide_btn'] = '0';

	$html = '<input type="hidden" name="alm_settings[_alm_hide_btn]" value="0" /><input type="checkbox" id="alm_hide_btn" name="alm_settings[_alm_hide_btn]" value="1"'. (($options['_alm_hide_btn']) ? ' checked="checked"' : '') .' />';
	$html .= '<label for="alm_hide_btn">'.__('Hide shortcode button in WYSIWYG editor.', 'ajax-load-more').'</label>';

	echo $html;
}



/*
*  _alm_error_notices_callback
*  Display admin error notices in browser console.
*
*  @since 2.7.2
*/

function _alm_error_notices_callback(){
	$options = get_option( 'alm_settings' );
	if(!isset($options['_alm_error_notices']))
	   $options['_alm_error_notices'] = '1';

	$html =  '<input type="hidden" name="alm_settings[_alm_error_notices]" value="0" />';
	$html .= '<input type="checkbox" name="alm_settings[_alm_error_notices]" id="_alm_error_notices" value="1"'. (($options['_alm_error_notices']) ? ' checked="checked"' : '') .' />';
	$html .= '<label for="_alm_error_notices">'.__('Display error messaging regarding repeater template updates in the browser console.', 'ajax-load-more').'</label>';

	echo $html;
}



/*
*  alm_disable_dynamic_callback
*  Disable the dynamic population of categories, tags and authors
*
*  @since 2.6.0
*/

function alm_disable_dynamic_callback(){
	$options = get_option( 'alm_settings' );
	if(!isset($options['_alm_disable_dynamic']))
	   $options['_alm_disable_dynamic'] = '0';

	$html =  '<input type="hidden" name="alm_settings[_alm_disable_dynamic]" value="0" />';
	$html .= '<input type="checkbox" name="alm_settings[_alm_disable_dynamic]" id="_alm_disable_dynamic" value="1"'. (($options['_alm_disable_dynamic']) ? ' checked="checked"' : '') .' />';
	$html .= '<label for="_alm_disable_dynamic">'.__('Disable dynamic population of categories, tags and authors in the Shortcode Builder.<span style="display:block">Recommended if you have a large number of categories, tags and/or authors.', 'ajax-load-more').'</label>';

	echo $html;
}


/*
*  alm_container_type_callback
*  The type of container ul or div
*
*  @since 2.0.0
*/

function alm_container_type_callback() {

    $options = get_option( 'alm_settings' );

    if(!isset($options['_alm_container_type']))
	   $options['_alm_container_type'] = '1';

    $html = '<input type="radio" id="_alm_container_type_one" name="alm_settings[_alm_container_type]" value="1"' . checked( 1, $options['_alm_container_type'], false ) . '/>';
    $html .= '<label for="_alm_container_type_one">&lt;ul&gt; <span>&lt;!-- '.__('Ajax Posts Here', 'ajax-load-more').' --&gt;</span> &lt;/ul&gt;</label><br/>';

    $html .= '<input type="radio" id="_alm_container_type_two" name="alm_settings[_alm_container_type]" value="2"' . checked( 2, $options['_alm_container_type'], false ) . '/>';
    $html .= '<label for="_alm_container_type_two">&lt;div&gt; <span>&lt;!-- '.__('Ajax Posts Here', 'ajax-load-more').' --&gt;</span> &lt;/div&gt;</label>';

    $html .= '<label style="cursor: default !important"><span style="display:block">'.__('You can modify the container type when building a shortcode.', 'ajax-load-more').'</span></label>';

    echo $html;

}


/*
*  alm_class_callback
*  Add classes to the Ajax Load More wrapper
*
*  @since 2.0.0
*/

function alm_class_callback(){
	$options = get_option( 'alm_settings' );

	$html = '<label for="alm_settings[_alm_classname]">'.__('Add custom classes to the <i>.alm-listing</i> container - classes are applied globally and will appear with every instance of Ajax Load More. <span style="display:block">You can also add classes when building a shortcode.</span>', 'ajax-load-more').'</label><br/>';
	$html .= '<input type="text" id="alm_settings[_alm_classname]" name="alm_settings[_alm_classname]" value="'.$options['_alm_classname'].'" placeholder="posts listing etc..." /> ';

	echo $html;
}



/*
*  alm_btn_color_callback
*  Get button color
*
*  @since 2.0.0
*/

function alm_btn_color_callback() {

    $options = get_option( 'alm_settings' );
    $type = $options['_alm_btn_color'];

    if(!isset($type))
	   $options['_alm_btn_color'] = '0';

	 $selected0 = '';
	 if($type == 'default') $selected0 = 'selected="selected"';

	 $selected1 = '';
	 if($type == 'blue') $selected1 = 'selected="selected"';

	 $selected2 = '';
	 if($type == 'green') $selected2 = 'selected="selected"';

	 $selected3 = '';
	 if($type == 'red') $selected3 = 'selected="selected"';

	 $selected4 = '';
	 if($type == 'purple') $selected4 = 'selected="selected"';

	 $selected5 = '';
	 if($type == 'grey') $selected5 = 'selected="selected"';

	 $selected6 = '';
	 if($type == 'white') $selected6 = 'selected="selected"';

	 $selected7 = '';
	 if($type == 'infinite classic') $selected7 = 'selected="selected"';

	 $selected8 = '';
	 if($type == 'infinite skype') $selected8 = 'selected="selected"';

	 $selected9 = '';
	 if($type == 'infinite ring') $selected9 = 'selected="selected"';

	 $selected10 = '';
	 if($type == 'infinite fading-blocks') $selected10 = 'selected="selected"';

	 $selected11 = '';
	 if($type == 'infinite fading-circles') $selected11 = 'selected="selected"';

	 $selected12 = '';
	 if($type == 'infinite chasing-arrows') $selected12 = 'selected="selected"';

    $html =  '<label for="alm_settings_btn_color">'.__('Select an Ajax loading style - you can choose between a <strong>Button</strong> or <strong>Infinite Scroll</strong>', 'ajax-load-more');
    $html .= '.<br/><span style="display:block">Selecting an Infinite Scroll style will remove the click interaction and load content on scroll <u>only</u>.</span>';
    $html .= '</label>';
    $html .= '<select id="alm_settings_btn_color" name="alm_settings[_alm_btn_color]">';

    $html .= '<optgroup label="'. __('Button', 'ajax-load-more') .'">';
    $html .= '<option value="default" class="alm-color default" ' . $selected0 .'>Default</option>';
    $html .= '<option value="blue" class="alm-color blue" ' . $selected1 .'>Blue</option>';
    $html .= '<option value="green" class="alm-color green" ' . $selected2 .'>Green</option>';
    $html .= '<option value="purple" class="alm-color purple" ' . $selected4 .'>Purple</option>';
    $html .= '<option value="grey" class="alm-color grey" ' . $selected5 .'>Grey</option>';
    $html .= '</optgroup>';

    $html .= '<optgroup label="'. __('Infinite Scroll (No Button)', 'ajax-load-more') .'">';
    $html .= '<option value="infinite classic" class="infinite classic" ' . $selected7 .'>Classic</option>';
    $html .= '<option value="infinite skype" class="infinite skype" ' . $selected8 .'>Skype</option>';
    $html .= '<option value="infinite ring" class="infinite ring" ' . $selected9 .'>Circle Fill</option>';
    $html .= '<option value="infinite fading-blocks" class="infinite fading-blocks" ' . $selected10 .'>Fading Blocks</option>';
    $html .= '<option value="infinite fading-circles" class="infinite fading-circles" ' . $selected11 .'>Fading Circles</option>';
    $html .= '<option value="infinite chasing-arrows" class="infinite chasing-arrows" ' . $selected12 .'>Chasing Arrows</option>';
    $html .= '</optgroup>';

    $html .= '</select>';

    $html .= '<div class="clear"></div>';
	 $html .= '<div class="alm-btn-wrap">';
	 $html .= '<div class="ajax-load-more-wrap core '.$type.'"><span>'.__('Preview', 'ajax-load-more') .'</span><button class="alm-load-more-btn loading" disabled="disabled">'.apply_filters('alm_button_label', __('Older Posts', 'ajax-load-more')).'</button></div>';
	 $html .= '</div>';

    echo $html;
}



/*
*  alm_inline_css_callback
*  Load CSS Inline vs the head
*
*  @since 3.3.1
*/
function alm_inline_css_callback(){
	$options = get_option( 'alm_settings' );
	if(!isset($options['_alm_inline_css']))
	   $options['_alm_inline_css'] = '1';

	$html =  '<input type="hidden" name="alm_settings[_alm_inline_css]" value="0" />';
	$html .= '<input type="checkbox" name="alm_settings[_alm_inline_css]" id="alm_inline_css" value="1"'. (($options['_alm_inline_css']) ? ' checked="checked"' : '') .' />';
	$html .= '<label for="alm_inline_css">'.__('Improve site performance by loading Ajax Load More CSS inline', 'ajax-load-more').'.</label>';

	echo $html;
}



/*
*  alm_btn_class_callback
*  Add classes to the Ajax Load More button
*
*  @since 2.4.1
*/

function alm_btn_class_callback(){
	$options = get_option( 'alm_settings' );

    if(!isset($options['_alm_btn_classname']))
	   $options['_alm_btn_classname'] = '';

	$html = '<label for="alm_settings[_alm_btn_classname]">'.__('Add classes to your <strong>Load More</strong> button', 'ajax-load-more').'.</label>';
	$html .= '<input type="text" class="btn-classes" id="alm_settings[_alm_btn_classname]" name="alm_settings[_alm_btn_classname]" value="'.$options['_alm_btn_classname'].'" placeholder="button rounded listing etc..." /> ';

	echo $html;
	?>
    <script>

		// Check if Disable CSS  === true
		if(jQuery('input#alm_disable_css_input').is(":checked")){
	      jQuery('select#alm_settings_btn_color').parent().parent().hide(); // Hide button color
	      jQuery('input#alm_inline_css').parent().parent().hide(); // Hide inline css
    	}
    	jQuery('input#alm_disable_css_input').change(function() {
    		var el = jQuery(this);
	      if(el.is(":checked")) {
	      	el.parent().parent('tr').next('tr').hide(); // Hide button
	      	el.parent().parent('tr').next('tr').next('tr').hide(); // Hide button color
	      	el.parent().parent('tr').next('tr').next('tr').next('tr').hide(); // Hide inline css
	      }else{
	      	el.parent().parent('tr').next('tr').show(); // show button
	      	el.parent().parent('tr').next('tr').next('tr').show(); // show button color
	      	el.parent().parent('tr').next('tr').next('tr').next('tr').show(); // show inline css
	      }
	   });

    </script>
	<?php
}



/*
*  _alm_scroll_top_callback
*  Move window to top of screen on page load
*
*  @since 2.6.0
*/

function _alm_scroll_top_callback(){
	$options = get_option( 'alm_settings' );
	if(!isset($options['_alm_scroll_top']))
	   $options['_alm_scroll_top'] = '0';

	$html =  '<input type="hidden" name="alm_settings[_alm_scroll_top]" value="0" />';
	$html .= '<input type="checkbox" name="alm_settings[_alm_scroll_top]" id="_alm_scroll_top" value="1"'. (($options['_alm_scroll_top']) ? ' checked="checked"' : '') .' />';
	$html .= '<label for="_alm_scroll_top">'.__('On initial page load, move the user\'s browser window to the top of the screen.<span style="display:block">This <u>may</u> help prevent the loading of unnecessary posts.</span>', 'ajax-load-more').'</label>';

	echo $html;
}



/*
*  _alm_nonce_security_callback
*  Move window to top of screen on page load
*
*  @since 2.6.3
*/

function _alm_nonce_security_callback(){
	$options = get_option( 'alm_settings' );
	if(!isset($options['_alm_nonce_security']))
	   $options['_alm_nonce_security'] = '0';

	$html =  '<input type="hidden" name="alm_settings[_alm_nonce_security]" value="0" />';
	$html .= '<input type="checkbox" name="alm_settings[_alm_nonce_security]" id="_alm_nonce_security" value="1"'. (($options['_alm_nonce_security']) ? ' checked="checked"' : '') .' />';
	$html .= '<label for="_alm_nonce_security">'.__('Enable <a href="https://codex.wordpress.org/WordPress_Nonces" target="_blank">WP nonce</a> verification to help protect URLs against certain types of misuse, malicious or otherwise on each Ajax Load More query.', 'ajax-load-more').'</label>';

	echo $html;
}

