<?php if(has_action('alm_users_installed')){ ?>
<div class="row input users add-on" id="alm-users">
   <h3 class="heading"><?php _e('Users', 'ajax-load-more'); ?></h3>
   <div class="expand-wrap">
      <div class="section-title">
         <p><?php _e('Infinite scroll WordPress users', 'ajax-load-more'); ?>.</p>
		 </div>
      <div class="wrap">
         <div class="inner">
            <ul>
                <li>
                 <input class="alm_element" type="radio" name="users" value="true" id="users-true" >
                 <label for="users-true"><?php _e('True', 'ajax-load-more'); ?></label>
                </li>
                <li>
                 <input class="alm_element" type="radio" name="users" value="false" id="users-false" checked="checked">
                 <label for="users-false"><?php _e('False', 'ajax-load-more'); ?></label>
                </li>
            </ul>
         </div>
      </div>

      <div class="clear"></div>
      <div id="users-extended">

         <hr/>
         <div class="section-title">
            <h4><?php _e('User Role', 'ajax-load-more'); ?></h4>
   		 	<p><?php _e('Select the role of user to be displayed', 'ajax-load-more'); ?>.</p>
         </div>
         <div class="wrap">
            <div class="inner">
					<select class="alm_element" id="users-role" name="users-role">
						<option value="" selected="selected">-- <?php _e('Select Role', 'ajax-load-more'); ?> --</option>
						<option value="all"><?php _e('All Roles', 'ajax-load-more'); ?></option>
						<?php 
							if(function_exists('alm_role_encrypt')) :
								global $wp_roles;
								$roles = $wp_roles->get_names();
								$role_value = 100;
								foreach($roles as $role) { 
								?>
								<option value="<?php echo $role;?>"><?php echo $role;?></option>
							<?php 
							} 
							endif;
						?>
					</select>
            </div>
         </div>  

         <div class="clear"></div>
         <hr>
         <div class="section-title">
            <h4><?php _e('Include', 'ajax-load-more'); ?></h4>
   		 	<p>
	   		 	<?php _e('A comma separated list of users to be included by ID', 'ajax-load-more'); ?>.<em><br/>e.g. 1, 2, 3</em>
   		 	</p>
         </div>
   		<div class="wrap">
            <div class="inner">
               <input type="text" class="alm_element" name="users-include" id="users-include">
            </div>
         </div>  

         <div class="clear"></div>
         <hr>
         <div class="section-title">
            <h4><?php _e('Exclude', 'ajax-load-more'); ?></h4>
				<p>
					<?php _e('A comma separated list of users to be excluded by ID', 'ajax-load-more'); ?>.<em><br/>e.g. 3, 6, 7</em>
				</p>
         </div>
   		<div class="wrap">
            <div class="inner">
               <input type="text" class="alm_element" name="users-exclude" id="users-exclude">
            </div>
         </div>   

         <div class="clear"></div>
         <hr>
         <div class="section-title">
            <h4><?php _e('Users Per Page', 'ajax-load-more'); ?></h4>
   		 	<p><?php _e('The number of users to show.', 'ajax-load-more'); ?></p>
         </div>
   		<div class="wrap">
            <div class="inner">
               <input type="number" class="alm_element numbers-only" name="users-per-page" id="users-per-page" step="1" min="1" value="5">
            </div>
         </div>       

         <div class="clear"></div>
         <hr/>
         <div class="section-title">
            <h4><?php _e('Orderby', 'ajax-load-more'); ?></h4>
   		 	<p><?php _e('Sort users by Order and Orderby parameters', 'ajax-load-more'); ?>.</p>
   		 </div>
   		 <div class="wrap">
            <div class="inner half">
               <label class="full"><?php _e('Order', 'ajax-load-more'); ?>:</label>
               <select class="alm_element" name="users-order" id="users-order">
                   <option value="ASC" selected="selected">ASC (default)</option>
                   <option value="DESC">DESC</option>
               </select>
            </div>
            <div class="inner half">
               <label class="full"><?php _e('Order By', 'ajax-load-more'); ?>:</label>
               <select class="alm_element" name="users-orderby" id="users-orderby">
                   <option value="login" selected="selected">Login (default)</option>
                   <option value="ID">ID</option>
                   <option value="display_name">Display Name</option>
                   <option value="user_name">Name</option>
                   <option value="include">Include</option>
                   <option value="email">Email</option>
                   <option value="user_url">URL</option>
                   <option value="registered">Registration Date</option>
                   <option value="post_count">Post Count</option>
               </select>
               <!-- Add Meta Value Num soon, also need to add alm_query_args filter to users addon. -->
            </div>
         </div>

      </div>

   </div>
</div>
<?php } ?>