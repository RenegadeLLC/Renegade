<?php
/*
** This class is connector b/w Nmedia mailchimp plugin and MCAPI
Author: ceo@najeebmedia.com (Najeeb Ahmad)
*/

$parent = dirname(__FILE__) . '/api_mailchimp/MCAPI.class.php';
include ($parent);



class clsMailchimp extends MCAPI
{
	var $mc;
	
	var $custom_templates = array(
			1001 	=> array('id'		=> 1001,
					'name'		=> 'Renegade',
					'detail'	=> 'Renegade Newsletter Template',
					'image'	=> 'renegadeTemplate.png',
					'price'	=> 'Free',
					'file'	=> 'renegadeNewsletter.php'
					),
			
			1002 	=> array('id'		=> 1002,
					'name'		=> 'Simple',
					'detail'	=> 'simple template with header, main and footer section, no any sidebar',
					'image'	=> 'twocol-1-2.png',
					'price'	=> 'Free',
					'file'	=> 'simple.php'
					),
			
					1003 	=> array('id'		=> 1003,
					'name'		=> 'Sidebar left',
					'detail'	=> 'simple template with header, LEFT sidebar, main and footer section',
					'image'	=> 'twocol-1-2-leftsidebar.png',
					'price'	=> 'Free',
					'file'	=> 'sidebar-left.php'
					),
										
					1004 	=> array('id'		=> 1004,
					'name'		=> 'Sidebar right',
					'detail'	=> 'simple template with header, RIGHT sidebar, main and footer section',
					'image'	=> 'twocol-1-2-rightsidebar.png',
					'price'	=> 'Free',
					'file'	=> 'sidebar-right.php'
					)
		);
	
										
										
										
										
	
	function __construct()
	{
		$this -> mc = new MCAPI(get_option('nm_mc_api_key'));
		
	}
	
	
	/*
	** Getting Mailchimp account list
	*/
	function getAccountLists()
	{
		$retval = $this -> mc -> lists();
		
		if ($this -> mc -> errorCode){
		  	_e('<div class="error">'.$this -> mc -> errorCode.'</div>');
		 }
		 else
		 {
			 return $retval['data'];
		 }
		 
	}
	
	/*
	 ** Getting Mailchimp account list
	*/
	function getListByID($lid)
	{
		$filter = array('list_id'	=> $lid);
		
		$retval = $this -> mc -> lists($filter);
	
		if ($this -> mc -> errorCode){
			_e('<div class="error">'.$this -> mc -> errorCode.'</div>');
		}
		else
		{
			return $retval['data'];
		}
			
	}
	
	
	/*
	** Getting List vars
	*/
	function getMergeVars($list_id)
	{
		$retval = $this -> mc -> listMergeVars($list_id);
		
		if ($this -> mc -> errorCode){
		  	echo $this -> mc -> errorMessage;
		 }
		 else
		 {
			 return $retval;
		 }
		 
	}
	
	
	/*
	** Getting List ineterst gruops
	*/
	function getListGroups($list_id)
	{
		$retval = $this -> mc -> listInterestGroupings($list_id);
		
		 	return $retval;
	}
	
	
	
	/*
	** Adding new Merge Var to a list
	*/
	function addMergeVar($list_id, $tag, $detail)
	{
		$retval = $this -> mc -> listMergeVarAdd($list_id, $tag, $detail);
		
		if ($this -> mc -> errorCode){
		  	//echo $this -> mc -> errorMessage;
			return false;
		 }
		 else
		 {
			 return $retval;
		 }
	}
	
	
	/*
	** Deleting Merge Var from a list
	*/
	function XMergeVar($list_id, $tag)
	{
		$retval = $this -> mc -> listMergeVarDel($list_id, $tag);
		
		if ($this -> mc -> errorCode){
		  	//echo $this -> mc -> errorMessage;
			return false;
		 }
		 else
		 {
			 return $retval;
		 }
	}
	
	
	/*
	** Adding new Group to a list
	*/
	function addInterestGroup($list_id, $name, $group_id)
	{
		$retval = $this -> mc -> listInterestGroupAdd($list_id, $name, $group_id);
		
		if ($this -> mc -> errorCode){
		  	//echo $this -> mc -> errorMessage;
			return false;
		 }
		 else
		 {
			 return $retval;
		 }
	}
	
	
	/*
	** Adding new Group to a Interest
	*/
	function addGroup($list_id, $name, $groups)
	{
		$groups = explode(",", $groups);
		
		$retval = $this -> mc -> listInterestGroupingAdd($list_id, $name, "hidden", $groups);
		
		if ($this -> mc -> errorCode){
		  	//echo $this -> mc -> errorMessage;
			return false;
		 }
		 else
		 {
			 return $retval;
		 }
	}
	
	
	
	
	/*
	** Deleting Interest Group from a list
	*/
	function XInterestGroup($group_id)
	{
		$retval = $this -> mc -> listInterestGroupingDel($group_id);
		
		if ($this -> mc -> errorCode){
		  	//echo $this -> mc -> errorMessage;
			return false;
		 }
		 else
		 {
			 return $retval;
		 }
	}
	
	
	/*
	** Deleting Group (sub group) from a list
	*/
	function XGroup($list_id, $group_name, $grouping_id)
	{
		$retval = $this -> mc -> listInterestGroupDel($list_id, $group_name, $grouping_id);
		
		if ($this -> mc -> errorCode){
		  	//echo $this -> mc -> errorMessage;
			return false;
		 }
		 else
		 {
			 return $retval;
		 }
	}
	
	
	/*
	** this function rendering list stats
	*/
	
	function renderListStats($arrStats, $lid)
	{
		$html = '<ul style="display:none" id="list-detail-'.$lid.'">';
		foreach($arrStats as $key => $val)
		{
			$html .= '<li style="float:left; text-align:center; margin:5px; border:#ccc 1px dashed;padding:5px;width:30%"><strong>'.$key.'</strong>: '.$val.'</li>';
		}
		$html .='</ul>';

		$html .='<div style="clear:both"></div>';

		echo $html;
	}
	
	
	/* ============= Campaign related ================== */
	
	/*
	** getting last of all campaigns
	*/
	
	function getCampaigns()
	{
		$retval = $this -> mc -> campaigns();
		
		if ($this -> mc -> errorCode){
		  	_e('<div class="error">You did not enter API Keys please enter your API Keys from Nmedia Mailchimp Setting area</div>');
		 }
		
		return $retval['data'];	
	}
	
	/*
	** this function rendering campaign stats
	*/
	
	function renderCampaignStats($campInfo)
	{	
		$arrRequired = array('list_id','title','create_time','from_email','subject');
		
		$html = '<ul style="display:none" id="camp-detail-'.$campInfo['id'].'">';
		foreach($campInfo as $key => $val)
		{
			if(in_array($key, $arrRequired))
			{
				$html .= '<li style="float:left; text-align:center; margin:5px; border:#ccc 1px dashed;padding:5px;width:30%"><strong>'.$key.'</strong>: '.$val.'</li>';
			}
		}
		$html .='</ul>';
		
		$html .='<div style="clear:both"></div>';
		
		echo $html;
	}
	
	/*
	** sending testing email to campaign
	*/
	
	function sendTestCampaign($cid)
	{
		$emails = array(get_bloginfo('admin_email'));

		$this -> mc -> campaignSendTest($cid, $emails);
		if ($this -> mc -> errorCode){
			_e('<div class="error">'.$this -> mc -> errorMessage.'</div>');
		}
		else
		{
			_e('<div class="updated">Campaign Tests Sent!: '.get_bloginfo('admin_email').'</div>');
		}
	}
	
	
	/*
	** get campaieng content
	*/
	
	function getCampaignContents($cid)
	{
		$retval = $this -> mc -> campaignContent($cid);
		if ($this -> mc -> errorCode){
			_e('<div class="error">'.$this -> mc -> errorMessage.'</div>');
		}
		else
		{
			return $retval;
		}
	}
	
	/*
	** creating campaign
	*/
	
	function createCampaign($data)
	{
		/* echo '<pre>';
		print_r($data);
		echo '</pre>';
		exit; */
		
		$type = 'regular';
 
		$opts['list_id'] = $data['camp-list'];		// wp poets
		$opts['subject'] = $data['camp-subject'];
		$opts['from_email'] = $data['camp-from-email'];
		$opts['from_name'] = $data['camp-from-name'];
		
		 
		$opts['tracking'] = array('opens' => $data['camp-track-open'], 
									'html_clicks' => $data['camp-click-html'], 
									'text_clicks' => $data['camp-click-text']);
		 
		$opts['authenticate'] = $data['camp-authenticate'];
		$opts['analytics'] = $data['camp-analytics'];
		$opts['generate_text'] = $data['camp-generate-text'];
		$opts['auto_tweet'] = $data['camp-auto-tweet'];
		$opts['auto_fb_post'] = $data['camp-auto-fb'];
		$opts['fb_comments'] = $data['camp-fb-comments'];
		$opts['ecomm360'] = $data['camp-ecomm360'];
		
		$opts['title'] = $data['camp-title'];
		
		//$content_html = get_post_field( 'post_content', $data['camp-content']);
		
		
		
		//$content_html = $this -> mergeContentWithTemplate($data['camp-template'], $data['camp-data-section']);
		$content_html = stripcslashes($data['content-html']);
		
		//echo $content_html; exit;
		
		$content = array('html'=> $content_html,
							'text'	=> $content_html);
		
		/*echo '<pre>';
		print_r($content);
		echo '</pre>';
		exit;*/
		
				  
		$cid = $this -> mc -> campaignCreate($type, $opts, $content);
		 
		 if ($this -> mc -> errorCode){
			_e('<div class="error">'.$this -> mc -> errorMessage.'</div>');
		}
		else
		{
			return $cid;
		}
		 
	}
	
	/*
	 * send campaign
	 */
	function sendCampaign($campID)
	{
		$this -> mc -> campaignSendNow($campID);
		if($this -> mc ->  errorCode){
			_e('<div class="error">'.$this -> mc -> errorMessage.'</div>');
		}else{
			_e('<div class="updated">Campaign is SENT successfully!</div>');
		}
	}
	
	
	/*
	 * get campaign report
	 */
	
	function getCampaignReport($cid)
	{
		$stats = $this -> mc -> campaignStats($cid);
		if($this -> mc ->  errorCode){
			_e('<div class="error">'.$this -> mc -> errorMessage.'</div>');
		}else{
			return $stats;
		}
	}
	/*
	** get campaieng content
	*/
	
	function getTemplates()
	{
		/* loading base templates */
		$retval = $this -> mc -> templates(true);
		if ($this -> mc -> errorCode){
			_e('<div class="error">'.$this -> mc -> errorMessage.'</div>');
		}
		else
		{
			return $retval['base'];
		}
	}
	
	/*
	** loading custom template
	*/
	
	function mergeContentWithTemplate($template_id, $section)
	{
		if($template_id == 0)
		{
			$p_id = 7;
			$post = get_post($section['main']);
			$content_html = '<h2>'.$post -> post_title.'</h2>';
			$content_html .= wpautop($post -> post_content);
			
		}
		else
		{
			
			$template = $this -> custom_templates[$template_id];
			
			$template_path = dirname(__FILE__).'/templates/'.$template['file'];
			//echo $template_path;
			$content_html = file_get_contents($template_path);
			
			$header_content = $section['header'];
			$main_content = get_post_field( 'post_content', $section['main']);
			$sidebar_content = $section['sidebar'];
			$footer_content = $section['footer'];
			
			
			$content_html = str_replace('[header_content]', $header_content, $content_html);
			$content_html = str_replace('[main_content]', $main_content, $content_html);
			$content_html = str_replace('[sidebar_content]', $sidebar_content, $content_html);
			$content_html = str_replace('[footer_content]', $footer_content, $content_html);
		}
		
		return stripslashes($content_html);
		//return '<h2>lovely</h2>';
		
	}
	
	/*
	 * deleting campaign
	 */
	
	function deleteCampaign($cid)
	{
		$res = $this -> mc -> campaignDelete($cid);
		
		if ($this -> mc -> errorCode){
			_e('<div class="error">'.$this -> mc -> errorMessage.'</div>');
		}
		else
		{
			_e('<div class="updated">Campaign deleted</div>');
		}
	}
	
	

}
?>