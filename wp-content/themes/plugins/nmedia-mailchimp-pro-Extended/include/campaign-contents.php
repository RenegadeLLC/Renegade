<?php
/*
** setting contents for campaign
*/
$args = array( 'numberposts' => -1, 'post_type'	=> 'page');
$all_pages = get_posts( $args );

$args = array( 'numberposts' => -1, 'post_type'	=> 'post');
$all_posts = get_posts( $args );

$args = array( 'numberposts' => -1, 'post_type'	=> 'newsletters');
$all_newsletters = get_posts( $args );

$colors = array('AliceBlue','AntiqueWhite','Aqua', 'Aquamarine', 'Azure', 'Beige', 'Bisque', 'Black', 'BlanchedAlmond', 'Blue', 'BlueViolet', 'BurlyWood', 'CadetBlue')
?>

<div class="nm_heading_block" onclick="loadStep('s-4')"><?php _e('Step 4: Contents', 'nm_mailchimp_plugin')?><span class="update-title" id="title-s-4"></span></div>
<input type="hidden" name="content-html" id="content-html" />

<div id="s-4" style="display:none" class="camp-steps">
<ul>
	<li><h3><?php _e('Step 4: Content', 'nm_mailchimp_plugin')?></h3>
    	<label class="nm-label" for="camp-content"><?php _e('Select Newsletter/Post/Page', 'nm_mailchimp_plugin')?></label>
    	<input type="hidden" name="camp-data-section[main]" id="camp-section-main-data" />
        <select name="camp-content-section[main]" id="camp-content">
        	<option value=""></option>
        	 <option value=""><strong>Newsletter list</strong></option>
        	     <?php 
			if($all_newsletters):
			foreach($all_newsletters as $newsletter):
			?>
           	<option value="<?php echo $newsletter -> ID?>">-- <?php echo $newsletter -> post_title?></option>
           <?php 
		   endforeach;
		   endif;
		   ?>
		   
		   
            <option value=""><strong>Page list</strong></option>
            
         
		   
            <?php 
			if($all_pages):
			foreach($all_pages as $page):
			?>
            	<option value="<?php echo $page -> ID?>">-- <?php echo $page -> post_title?></option>
           <?php 
		   endforeach;
		   endif;
		   ?>
           
           <option value=""><strong>Post list</strong></option>
            <?php 
			if($all_posts):
			foreach($all_posts as $post):
			?>
            	<option value="<?php echo $post -> ID?>">-- <?php echo $post -> post_title?></option>
           <?php 
		   endforeach;
		   endif;
		 ?>
        </select>
    </li>
    
    <!-- if template selected -->
    
    <li id="camp-more-contents" style="display:none"><h3><?php _e('Template based campaign', 'nm_mailchimp_plugin')?></h3>
    <em><?php _e('You have selected Base Template in step one, now you need to put some extra content for header, sidebard and footer', 'nm_mailchimp_plugin')?></em>
    	<ul>
              <li>
                <label class="nm-label" for="camp-section-header-content"><h3><?php _e('Content Header', 'nm_mailchimp_plugin')?></h3></label>
                  <textarea name="camp-content-section[header]" cols="75" rows="4" class="regular-text" id="camp-section-header-content"></textarea>
                  <em><?php _e('You can use HTML. CSS must be IN-LINE', 'nm_mailchimp_plugin')?>. 
                  <!--  <a href="javascript:toggleArea('camp-section-header-designer')"><?php //_e('Smart designer', 'nm_mailchimp_plugin')?></a> -->
                  </em>
                  <div id="camp-section-header-designer">
                  	<table style="width:600px" cellpadding="1">
                  		<tr>
                  			<td style="width:200px"><?php _e("Background color","nm_mailchimp_plugin")?>:</td>
                  			<td>
                  				<ul class="camp-section-bg-color" id="camp-section-header-bgcolor">
                  				<?php foreach($colors as $c):?>
                  				<li class="<?php echo $c?>" style="background-color:<?php echo $c?>"></li>
                  				<?php endforeach;?>
                  				</ul>                  				
                  			</td>
                  		</tr>
                        <tr>
                  			<td><?php _e("Font color","nm_mailchimp_plugin")?>:</td>
                  			<td>
                  				<ul class="camp-section-bg-color" id="camp-section-header-fontcolor">
                  				<?php foreach($colors as $c):?>
                  				<li class="<?php echo $c?>" style="background-color:<?php echo $c?>"></li>
                  				<?php endforeach;?>
                  				</ul>                  				
                  			</td>
                  		</tr>
                        <tr>
                  			<td><?php _e("Font size","nm_mailchimp_plugin")?>:</td>
                  			<td><div id="camp-section-header-fontsize"></div></td>
                  		</tr>
                  		<tr>
                  			<td><?php _e("Padding","nm_mailchimp_plugin")?>:</td>
                  			<td><div id="camp-section-header-slider"></div></td>
                  		</tr>
                  		<tr>
                  			<td><?php _e("Text align","nm_mailchimp_plugin")?>:</td>
                  			<td><label for="camp-section-header-align-left">
                  				<input type="radio" value="left" name="camp-section-header-align" id="camp-section-header-align-left">
                  				Left</label>
                  				<label for="camp-section-header-align-center">
                  				<input type="radio" value="center" name="camp-section-header-align" id="camp-section-header-align-center">
                  				Center</label>
                  				<label for="camp-section-header-align-right">
                  				<input type="radio" value="right" name="camp-section-header-align" id="camp-section-header-align-right">
                  				Right</label>
                  			</td>
                  		</tr>
                  		<tr>
                  			<td><?php _e("Preview","nm_mailchimp_plugin")?>:</td>
                  			<td><div id="camp-section-header-preview" class="camp-section-preview">
                  			<p>Content goes here</p>
                  			</div>
                  			</td>                  			
                  		</tr>
                  		<tr>
                  			<td></td>
                  			<td><a href="javascript:getDesignCode('camp-section-header')">Hide</a>
                  			</td>                  			
                  		</tr>
                  	</table>
                  	
                  </div>
                </li>
                
                <li id="container-sidebar-content">
                <label class="nm-label" for="camp-section-sidebar-content"><h3><?php _e('Content Sidebar', 'nm_mailchimp_plugin')?></h3></label>
               <textarea name="camp-content-section[sidebar]" cols="75" rows="4" class="regular-text" id="camp-section-sidebar-content"></textarea>
                  <em><?php _e('You can use HTML. CSS must be IN-LINE', 'nm_mailchimp_plugin')?>. 
                  <!--  <a href="javascript:toggleArea('camp-section-sidebar-designer')"><?php //_e('Smart designer', 'nm_mailchimp_plugin')?></a> -->
                  <div id="camp-section-sidebar-designer">
                  	<table style="width:600px" cellpadding="1">
                  		<tr>
                  			<td style="width:200px"><?php _e("Background color","nm_mailchimp_plugin")?>:</td>
                  			<td>
                  				<ul class="camp-section-bg-color" id="camp-section-sidebar-bgcolor">
                  				<?php foreach($colors as $c):?>
                  				<li class="<?php echo $c?>" style="background-color:<?php echo $c?>"></li>
                  				<?php endforeach;?>
                  				</ul>                  				
                  			</td>
                  		</tr>
                        <tr>
                  			<td><?php _e("Font color","nm_mailchimp_plugin")?>:</td>
                  			<td>
                  				<ul class="camp-section-bg-color" id="camp-section-sidebar-fontcolor">
                  				<?php foreach($colors as $c):?>
                  				<li class="<?php echo $c?>" style="background-color:<?php echo $c?>"></li>
                  				<?php endforeach;?>
                  				</ul>                  				
                  			</td>
                  		</tr>
                        <tr>
                  			<td><?php _e("Font size","nm_mailchimp_plugin")?>:</td>
                  			<td><div id="camp-section-sidebar-fontsize"></div></td>
                  		</tr>
                  		<tr>
                  			<td><?php _e("Padding","nm_mailchimp_plugin")?>:</td>
                  			<td><div id="camp-section-sidebar-slider"></div></td>
                  		</tr>
                  		<tr>
                  			<td><?php _e("Text align","nm_mailchimp_plugin")?>:</td>
                  			<td><label for="camp-section-sidebar-align-left">
                  				<input type="radio" value="left" name="camp-section-sidebar-align" id="camp-section-sidebar-align-left">
                  				Left</label>
                  				<label for="camp-section-sidebar-align-center">
                  				<input type="radio" value="center" name="camp-section-sidebar-align" id="camp-section-sidebar-align-center">
                  				Center</label>
                  				<label for="camp-section-sidebar-align-right">
                  				<input type="radio" value="right" name="camp-section-sidebar-align" id="camp-section-sidebar-align-right">
                  				Right</label>
                  			</td>
                  		</tr>
                  		<tr>
                  			<td><?php _e("Preview","nm_mailchimp_plugin")?>:</td>
                  			<td><div id="camp-section-sidebar-preview" class="camp-section-preview camp-section-sidebar-preview">
                  			<p>Content goes here</p>
                  			</div>
                  			</td>                  			
                  		</tr>
                  		<tr>
                  			<td></td>
                  			<td><a href="javascript:getDesignCode('camp-section-sidebar')">Hide</a>
                  			</td>                  			
                  		</tr>
                  	</table>
                  	
                  </div>
                  
                </li>
				
                <li>
                <label class="nm-label" for="camp-content-footer"><h3><?php _e('Content Footer', 'nm_mailchimp_plugin')?></h3></label>
                 <textarea name="camp-content-section[footer]" cols="75" rows="4" class="regular-text" id="camp-section-footer-content"></textarea>
                  <em><?php _e('You can use HTML. CSS must be IN-LINE', 'nm_mailchimp_plugin')?>. 
                  <!--  <a href="javascript:toggleArea('camp-section-footer-designer')"><?php //_e('Smart designer', 'nm_mailchimp_plugin')?></a> -->
                  <div id="camp-section-footer-designer">
                  	<table style="width:600px" cellpadding="1">
                  		<tr>
                  			<td style="width:200px"><?php _e("Background color","nm_mailchimp_plugin")?>:</td>
                  			<td>
                  				<ul class="camp-section-bg-color" id="camp-section-footer-bgcolor">
                  				<?php foreach($colors as $c):?>
                  				<li class="<?php echo $c?>" style="background-color:<?php echo $c?>"></li>
                  				<?php endforeach;?>
                  				</ul>                  				
                  			</td>
                  		</tr>
                        <tr>
                  			<td><?php _e("Font color","nm_mailchimp_plugin")?>:</td>
                  			<td>
                  				<ul class="camp-section-bg-color" id="camp-section-footer-fontcolor">
                  				<?php foreach($colors as $c):?>
                  				<li class="<?php echo $c?>" style="background-color:<?php echo $c?>"></li>
                  				<?php endforeach;?>
                  				</ul>                  				
                  			</td>
                  		</tr>
                  		<tr>
                  			<td><?php _e("Padding","nm_mailchimp_plugin")?>:</td>
                  			<td><div id="camp-section-footer-slider"></div></td>
                  		</tr>
                        <tr>
                  			<td><?php _e("Font size","nm_mailchimp_plugin")?>:</td>
                  			<td><div id="camp-section-footer-fontsize"></div></td>
                  		</tr>
                  		<tr>
                  			<td><?php _e("Text align","nm_mailchimp_plugin")?>:</td>
                  			<td><label for="camp-section-footer-align-left">
                  				<input type="radio" value="left" name="camp-section-footer-align" id="camp-section-footer-align-left">
                  				Left</label>
                  				<label for="camp-section-footer-align-center">
                  				<input type="radio" value="center" name="camp-section-footer-align" id="camp-section-footer-align-center">
                  				Center</label>
                  				<label for="camp-section-footer-align-right">
                  				<input type="radio" value="right" name="camp-section-footer-align" id="camp-section-footer-align-right">
                  				Right</label>
                  			</td>
                  		</tr>
                  		<tr>
                  			<td><?php _e("Preview","nm_mailchimp_plugin")?>:</td>
                  			<td><div id="camp-section-footer-preview" class="camp-section-preview">
                  			<p>Content goes here</p>
                  			</div>
                  			</td>                  			
                  		</tr>
                  		<tr>
                  			<td></td>
                  			<td><a href="javascript:getDesignCode('camp-section-footer')">Hide</a>
                  			</td>                  			
                  		</tr>
                  	</table>
                  	
                  </div>
                </li>

        </ul>
        
    </li>
    
</ul>
</div>
