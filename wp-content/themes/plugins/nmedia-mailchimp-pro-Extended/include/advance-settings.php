<?php
/*
Salt & Pepper (Advance settings)
*/

$analytic_google = 'your_campaign_subject_'.date('m_d_Y');
?>

<div class="nm_heading_block" onclick="loadStep('s-3')"><?php _e('Step 3: Advance Settings (if not sure leave it default) ', 'nm_mailchimp_plugin')?><span class="update-title" id="title-s-3"></span></div>

<div id="s-3" style="display:none" class="camp-steps">
<ul id="camp-advance">
	<li><h3><?php _e('Tracking', 'nm_mailchimp_plugin')?></h3>
    <em><?php _e('optional - set which recipient actions will be tracked, as a struct of boolean values with the following keys: "opens", "html_clicks", and "text_clicks". By default, opens and HTML clicks will be tracked. Click tracking can not be disabled for Free accounts.', 'nm_mailchimp_plugin');?></em>
    
	    <ul>
    	    <li>
	    		<label class="nm-label" for="camp-track-open">
	        	<input type="checkbox" name="camp-track-open" id="camp-track-open" checked="checked" value="true">
                <?php _e('Open', 'nm_mailchimp_plugin')?>
                </label>
    		</li>
            <li>
	    		<label class="nm-label" for="camp-click-html">
	        	<input type="checkbox" name="camp-click-html" id="camp-click-html" checked="checked" value="true">
                <?php _e('Html Click', 'nm_mailchimp_plugin')?>
                </label>
    		</li>
            <li>
	    		<label class="nm-label" for="camp-click-text">
	        	<input type="checkbox" name="camp-click-text" id="camp-click-text" value="true">
                <?php _e('Text Click', 'nm_mailchimp_plugin')?>
                </label>
    		</li>
	    </ul>
    </li>
    
    <li><h3><?php _e('Title', 'nm_mailchimp_plugin')?></h3>
    <em><?php _e('optional - an internal name to use for this campaign. By default, the campaign subject will be used.', 'nm_mailchimp_plugin');?></em>
    	<label class="nm-label" for="camp-title"><?php _e('Campaign Title', 'nm_mailchimp_plugin')?></label>
        <input type="text" name="camp-title" id="camp-title" class="regular-text">
    </li>
    
    <li><h3><?php _e('Authenticate', 'nm_mailchimp_plugin')?></h3>
    <em><?php _e('optional - set to true to enable SenderID, DomainKeys, and DKIM authentication, defaults to false.', 'nm_mailchimp_plugin')?></em>
   		<label class="nm-label" for="camp-authenticate">
      	<input type="checkbox" name="camp-authenticate" id="camp-authenticate" value="true">
        <?php _e('Authenticate', 'nm_mailchimp_plugin')?>
        </label>
	</li>
    
    <li><h3><?php _e('Analytics Google', 'nm_mailchimp_plugin')?></h3>
    <em><?php _e('Note - You will need to have Google Analytics setup on your website to use this feature', 'nm_mailchimp_plugin')?></em>
   		<label class="nm-label" for="camp-analytics"><?php _e('Title For Campaign (You\'ll See This In Google Analytics™) - up to 50 characters', 'nm_mailchimp_plugin')?></label>
      	<input type="text" name="camp-analytics" id="camp-analytics" class="regular-text">
        <em>e.g: <?php echo $analytic_google?></em>
	</li>
    
    <li><h3><?php _e('Generate Text', 'nm_mailchimp_plugin')?></h3>
    <em><?php _e('optional - Whether of not to auto-generate your Text content from the HTML content. Note that this will be ignored if the Text part of the content passed is not empty, defaults to false.', 'nm_mailchimp_plugin')?></em>
   		<label class="nm-label" for="camp-generate-text">
      	<input type="checkbox" name="camp-generate-text" id="camp-generate-text" value="true">
        <?php _e('Generate Text', 'nm_mailchimp_plugin')?>
        </label>
	</li>
    
    <li><h3><?php _e('Auto Tweet', 'nm_mailchimp_plugin')?></h3>
    <em><?php _e('optional - If set, this campaign will be auto-tweeted when it is sent - defaults to false. Note that if a Twitter account isn\'t linked, this will be silently ignored.', 'nm_mailchimp_plugin')?></em>
   		<label class="nm-label" for="camp-auto-tweet">
      	<input type="checkbox" name="camp-auto-tweet" id="camp-auto-tweet" value="true">
        <?php _e('Auto Tweet', 'nm_mailchimp_plugin')?>
        </label>
	</li>
    
    <li><h3><?php _e('Auto Facebook Post', 'nm_mailchimp_plugin')?></h3>
    <em><?php _e('optional - If set, this campaign will be auto-posted to the page_ids contained in the array. If a Facebook account isn\'t linked or the account does not have permission to post to the page_ids requested, those failures will be silently ignored.', 'nm_mailchimp_plugin');?></em>
    	<label class="nm-label" for="camp-auto-fb"><?php _e('Facebook pages IDs', 'nm_mailchimp_plugin')?></label>
        <input type="text" name="camp-auto-fb" id="camp-auto-fb" class="regular-text">
        <em><?php _e('each fb page id separated by comma', 'nm_mailchimp_plugin')?></em>
    </li>
    
    <li><h3><?php _e('Facebook Comments', 'nm_mailchimp_plugin')?></h3>
    <em><?php _e('optional - If true, the Facebook comments (and thus the <a href="http://kb.mailchimp.com/article/i-dont-want-an-archiave-of-my-campaign-can-i-turn-it-off/">archive bar</a> will be displayed. If false, Facebook comments will not be enabled (does not imply no archive bar, see previous link). Defaults to "true".', 'nm_mailchimp_plugin')?></em>
   		<label class="nm-label" for="camp-fb-comment">
      	<input type="checkbox" name="camp-fb-comment" id="camp-fb-comment" value="true" checked="checked">
        <?php _e('Facebook Comments', 'nm_mailchimp_plugin')?>
        </label>
	</li>
    
    <li><h3><?php _e('Ecomm360', 'nm_mailchimp_plugin')?></h3>
    <em><?php _e('optional - If set, our <a href="http://www.mailchimp.com/blog/ecommerce-tracking-plugin/">Ecommerce360</a> tracking will be enabled for links in the campaign', 'nm_mailchimp_plugin')?></em>
   		<label class="nm-label" for="camp-ecomm360">
      	<input type="checkbox" name="camp-ecomm360" id="camp-ecomm360" value="true">
        <?php _e('Ecomm360', 'nm_mailchimp_plugin')?>
        </label>
	</li>
</ul>
<a href="javascript:changeStep('s-3', 's-4')">
		<img border="0" src="<?php echo plugins_url('images/button-next.png', __FILE__)?>" alt="<?php _e('Next', 'nm_mailchimp_plugin');?>" /></a>
</div>