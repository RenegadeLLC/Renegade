<?php 
	$theme_repeaters = false;
	if (isset($_GET['theme-repeaters'])) {
		$theme_repeaters = $_GET['theme-repeaters'];
		
		if($theme_repeaters == 'true' && has_action('alm_get_theme_repeater')){
			$theme_repeaters = true;
		}else{
			$theme_repeaters = false;
		}
	}
?>

<div class="admin ajax-load-more" id="alm-repeaters">
	<div class="wrap main-cnkt-wrap">
		
		<header class="header-wrap">
			<h1>
   			<?php echo ALM_TITLE; ?>: <strong><?php _e('Repeater Templates', 'ajax-load-more'); ?></strong>
            <em><?php _e('The library of editable templates for use within your theme', 'ajax-load-more'); ?></em>
         </h1>
		</header>
		
		<div class="ajax-load-more-inner-wrapper">
		
			<div class="cnkt-main repeaters">									
				
				<?php if(has_action('alm_get_theme_repeater')){ ?>
				   <ul class="alm-toggle-switch">
	   			   <li><a href="?page=ajax-load-more-repeaters" class="<?php if(!$theme_repeaters){ echo 'active'; } ?>"><?php _e('Repeater Templates', 'ajax-load-more'); ?></a></li>
	   			   <li><a href="?page=ajax-load-more-repeaters&theme-repeaters=true" class="<?php if($theme_repeaters){ echo 'active'; } ?>"><?php _e('Theme Repeaters', 'ajax-load-more'); ?></a></li>
				   </ul>		
				<?php } ?>
				
				
				<?php
				// List Theme Repeaters
				
				if($theme_repeaters){ ?>
				<div class="group no-shadow">
				
				<?php 	
					$options = get_option( 'alm_settings' );					
					if(!isset($options['_alm_theme_repeaters_dir'])) 
						$options['_alm_theme_repeaters_dir'] = 'alm_templates';
											      	         
		         // Get template location
		         if(is_child_theme()){
	            	$dir = get_stylesheet_directory() . '/' . $options['_alm_theme_repeaters_dir']; 		      	         
		         }else{		      	         
	            	$dir = get_template_directory() . '/' . $options['_alm_theme_repeaters_dir']; 
		         } 
	                
	            $count = 0;	            
	            foreach (glob($dir.'/*') as $file) { 
	               $count++;                     
	               $file = realpath($file);
	               $link = substr($file, strlen($dir) + 1);
	               $file_extension = strtolower(substr(basename($file), strrpos(basename($file), '.') + 1));
	               $file_directory = get_option('stylesheet') .'/'. strtolower(substr(basename($dir), strrpos(basename($dir), '/')));
	               
						$id = preg_replace('/\\.[^.\\s]{3,4}$/', '', $link);					
						
	               if($file_extension == 'php'){ // Only display .php files files ?>
	               
		            <div class="row template" id="tr-<?php echo $id; ?>">
		               <h3 class="heading"><?php echo basename($file); ?></h3>
							<div class="expand-wrap">
								<div class="wrap repeater-wrap cm-readonly">								
	   							<?php
	   								$template = fopen ($file, "r"); // Open file
	   								$tr_contents = '';
	   								if(filesize ($file) != 0){
	   									$tr_contents = fread ($template, filesize ($file));
	   								}
	   								fclose ($template);
	   							?>
	   							<textarea rows="10" id="template-tr-<?php echo $id; ?>" class="_alm_repeater"><?php echo $tr_contents; ?></textarea>
	   			            <script>
	                           var editorDefault = CodeMirror.fromTextArea(document.getElementById("template-tr-<?php echo $id; ?>"), {
	                             mode:  "application/x-httpd-php",
	                             lineNumbers: true,
	                             lineWrapping: true,
	                             indentUnit: 0,
	                             matchBrackets: true,
	                             readOnly: true,
	                             viewportMargin: Infinity,
	                             extraKeys: {"Ctrl-Space": "autocomplete"},
	                           });
	                        </script>	
	   							<p class="file-location" title="<?php echo $file; ?>"><?php _e('File Location', 'ajax-load-more'); ?>:<code><?php echo $file_directory; ?>/<?php echo basename($file); ?></code></p>
								</div>
							</div>
	               </div>               
		            <?php    	            
							unset($template);
							unset($file);
	               }             
	            }               
	               
	            if($count > 1){?>
					<span class="toggle-all">
						<span class="inner-wrap">
							<em class="collapse"><?php _e('Collapse All', 'ajax-load-more'); ?></em>
							<em class="expand"><?php _e('Expand All', 'ajax-load-more'); ?></em>
						</span>
					</span>
	            <?php 
	            } 
	            
	            if($count == 0){ ?>
	            <div style="padding: 20px;">
	               <h3><?php _e('Templates Not Found', 'ajax-load-more'); ?></h3>
	               <p>
	                  <?php _e('Oh no - looks like you haven\'t added any Theme Repeater templates - you need to create and upload templates to your theme directory before you can access them in Ajax Load More', 'ajax-load-more'); ?>.
	               </p>
	               <p style="margin: 20px 0 0;">
	                  <a href="https://connekthq.com/plugins/ajax-load-more/add-ons/theme-repeaters/" class="button button-primary button-large" target="_blank"><?php _e('Learn More About Theme Repeaters', 'ajax-load-more'); ?></a>
	               </p>
	            </div>
	            <?php }          
	         ?>
				</div>
				
				<?php } else { ?>			
				
			   <!-- Repeaters -->
			   <div class="group no-shadow">
	
			      <?php
	            if (has_action('alm_custom_repeaters') || has_action('alm_unlimited_repeaters')){ ?>
					<span class="toggle-all">
						<span class="inner-wrap">
							<em class="collapse"><?php _e('Collapse All', 'ajax-load-more'); ?></em>
							<em class="expand"><?php _e('Expand All', 'ajax-load-more'); ?></em>
						</span>
					</span>
	            <?php } ?>
	
				   <!-- Default Template -->
				   <div class="row template default-repeater" id="default-template">
	
	   			   <?php
	      			   // Check for local repeater template
	         			$local_template = false;
	         			$readOnly = 'false';
	         			$template_dir = 'alm_templates';
	               	if(is_child_theme()){
	               		$template_theme_file = get_stylesheet_directory().'/'. $template_dir .'/default.php';
	               		if(!file_exists($template_theme_file)){
	                  		$template_theme_file = get_template_directory().'/'. $template_dir .'/default.php';
	               		}
	               	}
	               	else{
	               		$template_theme_file = get_template_directory().'/'. $template_dir .'/default.php';
	               	}
	               	// if theme or child theme contains the template, use that file
	               	if(file_exists($template_theme_file)){
	               		$local_template = true;
	               		$readOnly = true;
	               	}
	
	                  $filename = alm_get_default_repeater(); // Get default repeater template
	
		               $handle = fopen ($filename, "r"); // Open file
	      				$contents = '';
	      				if(filesize ($filename) != 0){
	      				   $contents = fread ($handle, filesize ($filename));
	      				}
	      				fclose ($handle);
		            ?>
		            <h3 class="heading"><?php _e('Default Template', 'ajax-load-more'); ?></h3>
		            <div class="expand-wrap">
			            <div class="wrap repeater-wrap<?php if($local_template){ echo ' cm-readonly'; } ?>" data-name="default" data-type="default">
								<?php 
									if(!$local_template){										
										// Add Label
										echo '<label class="template-title" for="template-default">';
										   _e('Enter the HTML and PHP code for the default template', 'ajax-load-more');
										echo ':</label>';
										
										// Layouts - Template Selection
	                        	do_action('alm_get_layouts'); 
	                        }
	      			      ?>
				            <textarea rows="10" id="template-default" class="_alm_repeater"><?php echo $contents; ?></textarea>
				            <script>
	                        var editorDefault = CodeMirror.fromTextArea(document.getElementById("template-default"), {
	                          mode:  "application/x-httpd-php",
	                          lineNumbers: true,
	                          lineWrapping: true,
	                          indentUnit: 0,
	                          matchBrackets: true,
	                          readOnly: <?php echo $readOnly; ?>,
	                          viewportMargin: Infinity,
	                          extraKeys: {"Ctrl-Space": "autocomplete"},
	                        });
	                     </script>
	                     
	                     <?php if(!$local_template){ ?>
	
								<input type="submit" value="<?php _e('Save Template', 'ajax-load-more'); ?>" class="button button-primary save-repeater" data-editor-id="template-default">
			            	<div class="saved-response">&nbsp;</div>
								<?php include( ALM_PATH . 'admin/includes/components/repeater-options.php'); ?>
	
								<?php } else { 
	                        $file_directory = get_option('stylesheet') .'/'. strtolower(substr(basename($template_dir), strrpos(basename($template_dir), '/')));
								?>
	 
								<p class="warning-callout"><?php _e('It appears you are loading the <a href="https://connekthq.com/plugins/ajax-load-more/docs/repeater-templates/#default-template" target="_blank"><b>default template</b></a> (<em>default.php</em>) from your current theme directory. To modify this template, you must edit the file directly on your server.', 'ajax-load-more'); ?></p>
								<p class="file-location" title="<?php echo $filename; ?>" style="margin-top: 20px;"><?php _e('File Location', 'ajax-load-more'); ?>:<code><?php echo $file_directory; ?>/default.php</code></p>
	
								<?php } ?>
								
			            </div>
		            </div>
				   </div>
	
				   <!-- End Default Template -->
	
				   <!-- Custom Repeaters -->
	            <?php
	
	            	if (!has_action('alm_get_unlimited_repeaters') && !has_action('alm_get_custom_repeaters')){
	               	// If Custom Repeaters & Theme Repeaters is NOT installed
	                  echo '<div class="row no-brd">';
	                  include( ALM_PATH . 'admin/includes/cta/extend.php');
	                  echo '</div>';
					   }
	
				   	if (has_action('alm_custom_repeaters')){ // List custom repeaters v1
							do_action('alm_custom_repeaters');
						}
				   	if (has_action('alm_unlimited_repeaters')){ // List custom repeaters v2
							do_action('alm_unlimited_repeaters');
	               }
					?>
	
					<script>
						jQuery(document).ready(function($) {
						   "use strict";
							var _alm_admin = {};
	
						    /*
						    *  _alm_admin.saveRepeater
						    *  Save Custom Repeater Value
						    *
						    *  @since 2.0.0
						    */
	
							_alm_admin.saveRepeater = function(btn, editorId) {
								var container = btn.parent('.repeater-wrap'),
									el = $('textarea._alm_repeater', container),
									textarea = el.next('.CodeMirror'),
									btn = btn,
									value = '',
									repeater = container.data('name'), // Get templete name
									type = container.data('type'), // Get template type (default/repeater/unlimited)
									alias = ($('input._alm_repeater_alias', container).length) ? $('input._alm_repeater_alias', container).val() : '',
									responseText = $(".saved-response", container);
	
	                     if(type === undefined) // Fix for custom repeaters v1
	                        type = 'undefined';
	
								//Get value from CodeMirror textarea
								var id = editorId.replace('template-', ''); // Editor ID
	
								if(id === 'default'){ // Default Template
									value = editorDefault.getValue();
							   }else{ // Repeater Templates
							      var eid = window['editor_'+id]; // Set editor ID
							      value = eid.getValue();
							   }
	
							   // if value is null, then set repeater to non breaking space
							   if(value === '' || value === 'undefined'){
							      value = '&nbsp;';
							   }
	
							   //If template is not already saving, then proceed
								if (!btn.hasClass('saving')) {
								   btn.addClass('saving');
								   textarea.addClass('loading');
									responseText.addClass('loading').html('<?php _e('Saving template...', 'ajax-load-more') ?>');
									responseText.animate({'opacity' : 1});
	
									$.ajax({
										type: 'POST',
										url: alm_admin_localize.ajax_admin_url,
										data: {
											action: 'alm_save_repeater',
											value: value,
											repeater: repeater,
											type: type,
											alias: alias,
											nonce: alm_admin_localize.alm_admin_nonce,
										},
										success: function(response) {
	
										  $('textarea#'+editorId).val(value); // Set the target textarea val to 'value'
	
										  setTimeout(function() {
											   responseText.delay(500).html(response).removeClass('loading');
											   textarea.removeClass('loading');
										  }, 250);
	
										  setTimeout(function() {
											   responseText.animate({'opacity': 0}, function(){
	   										   responseText.html('&nbsp;');
	                                    btn.removeClass('saving');
											   });
	
											}, 3000);
	
										},
										error: function(xhr, status, error) {
											responseText.html('<?php _e('Something went wrong and the data could not be saved.', 'ajax-load-more') ?>').removeClass('loading');
											btn.removeClass('saving');
											textarea.removeClass('loading');
										}
	                        });
								}
							}
	
	
							$(document).on('click', 'input.save-repeater', function(){
								var btn = $(this),
								    editorId = btn.data('editor-id');
								_alm_admin.saveRepeater(btn, editorId);
							});
	
	
							/*
						    *  _alm_admin.updateRepeater
						    *  Update Repeater Value
						    *
						    *  @since 2.5
						    */
	
							_alm_admin.updateRepeater = function(btn, editorId) {
								var container = btn.closest('.repeater-wrap'),
									el = $('textarea._alm_repeater', container),
									btn = btn,
									btn_text = btn.html(),
									editor = $('.CodeMirror', container),
									repeater = container.data('name'), // Get templete name
									type = container.data('type'); // Get template type (default/repeater/unlimited)
	
								//Get value from CodeMirror textarea
								var editorId = repeater,
									 id = editorId.replace('template-', ''); // Editor ID
	
							   //If template is not already saving, then proceed
								if (!btn.hasClass('updating')) {
								   btn.addClass('updating').text("<?php _e('Updating template...', 'ajax-load-more'); ?>");
								   editor.addClass('loading');
									$.ajax({
										type: 'POST',
										url: alm_admin_localize.ajax_admin_url,
										data: {
											action: 'alm_update_repeater',
											repeater: repeater,
											type: type,
											nonce: alm_admin_localize.alm_admin_nonce,
										},
										success: function(response) {
										   if(id === 'default'){ // Default Template
	         								editorDefault.setValue(response);
	                              }else{ // Repeater Templates
	         						      var eid = window['editor_'+id]; // Set editor ID
	         						      eid.setValue(response);
	         						   }
	
										  	// Clear button styles
										   setTimeout(function() {
	                                 btn.text("<?php _e('Template Updated', 'ajax-load-more'); ?>").blur();
	                                 setTimeout(function() {
	                                    btn.closest('.alm-drop-btn').trigger('click'); // CLose drop menu
		                                 btn.removeClass('updating').html(btn_text).blur();
		                                 editor.removeClass('loading');
												}, 400);
											}, 400);
	
										},
										error: function(xhr, status, error) {
	                              btn.removeClass('updating').html(btn_text).blur();
	                              editor.removeClass('loading');
										}
	                        });
								}
							}
	
							$('.option-update a').click(function(){
								var btn = $(this);
								_alm_admin.updateRepeater(btn);
							});
	
						});
					</script>
	
			   </div>
			   <!-- End Repeaters -->
			   
			   <?php } ?>
	
		   </div>
	
		   <aside class="cnkt-sidebar">
			   
	   	   <div id="cnkt-sticky-wrapper">
		   	   <div id="cnkt-sticky">
			   	   
			   	   <?php 
			      	   // Add TOC if users has Custom Repeaters
			      	   if (has_action('alm_unlimited_repeaters') || $theme_repeaters){      	   
			   	   ?>
			   	   <div class="table-of-contents repeaters-toc">
			   	   	<div class="cta">
			      	   	<div class="cta-inner">
			   	   	      <select class="toc"></select>
			      	   	</div>
			   	   	</div>
			   	   </div>
						<?php } ?>
		   	  
		      	   <div class="cta">
		   				<h3><?php _e('What\'s a Repeater Template?', 'ajax-load-more'); ?></h3>
		   				<div class="cta-inner">
		   					<p><?php _e('A <a href="https://connekthq.com/plugins/ajax-load-more/docs/repeater-templates/" target="_blank">Repeater Template</a> is a snippet of code that will execute over and over within a <a href="http://codex.wordpress.org/The_Loop" target="_blank">WordPress loop</a>', 'ajax-load-more'); ?>.</p>
		   				</div>		   				
							<div class="major-publishing-actions">
								<a class="button button-primary" href="https://connekthq.com/plugins/ajax-load-more/docs/repeater-templates/" target="_blank"><?php _e('Learn More', 'ajax-load-more'); ?></a>
							</div>
						</div>
		   	   	
		            <?php 
		               if(!$theme_repeaters){
		                  include_once( ALM_PATH . 'admin/includes/cta/writeable.php'); 
		               }
		            ?>
		
		   	   </div>
	   	   </div>
	
		   </aside>
		   
		   <div class="clear"></div>
		</div>

	</div>
</div>
