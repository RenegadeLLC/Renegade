<?php
/*
This script is written by Najeeb Ahmad, NajeebMedia.com

postToMailChimp class is interface class between NMedia Mailchimp plugin and Mailchimp API class.
Do not modify this.
*/


class postToMailChimp
{
	var $email;
	var $list_id;
	var $full_name;
	var $vars = array();
	
	var $api_key;
	var $thanks;
	
	var $err;
	var $errMessage;
	
	/*
	** following function is saving subscriber data to mailchimp list
	*/
	function saveToList()
	{
		$mcapi = dirname(__FILE__).'/MCAPI.class.php';
		if(file_exists($mcapi)){
			require_once($mcapi);
		}else
		{
			die('file not found '.$mcapi);
		}
		
	
		$comm = new MCAPI($this -> api_key);		

		
		$names 	 = explode(',', $this -> full_name);
				
		//var_dump($mergeVars); exit;
		
		if($comm->listSubscribe($this -> list_id, $this -> email, $this -> vars) === true) {
			if($this -> thanks == '')
				return 'Success! Check your email to confirm sign up.';
			else
				return $this -> thanks;
		}else{
			// An error ocurred, return error message	
			$this -> errMessage = $comm->errorMessage;
			return 'error';
		}
	}
	
	
	/*
	** validating posted data
	*/
	function validateCredentials($posted_meta, $arrVars)
	{
		$i = 0;
		$this -> errMessage = '<div class="nm_mc_error">';
		foreach($arrVars as $key => $val):
		
			$tag = $val -> tag;
			
			if($val -> req == 1 and $posted_meta[$i] == '')
			{
				$this -> err = true;
				$this -> errMessage .= $val -> tag." is required<br />";
			}
			
			$this -> vars [$tag] = sanitize_text_field($posted_meta[$i]);
			$i++;
		endforeach;
		
		$this -> email = $this -> vars['EMAIL'];
		
		
		/* populating checking validation for vars, email, list id and api key */
		if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $this -> email)) 
		{
			$this -> errMessage .=  'Email address is invalid '.$this -> email.'<br />'; 
			$this -> err = true;
		}
		
		if($this -> api_key == '')
		{
			$this -> errMessage .= 'No API key found, please set API from plugin option in admin<br />';
			$this -> err = true;
		}
		
		if($this -> list_id == '')
		{
			$this -> errMessage .=  'No List ID found, please set List ID from plugin option in admin<br />';
			$this -> err = true;
		}
		/* checking validation for email, list id and api key */
		
		$this -> errMessage .= '</div>';
				
	}
}

$mailchimp = new postToMailChimp();

$form = nmMailChimp::getForm($_POST['form_id']);
/* print_r(unserialize(stripcslashes($_POST['form_meta'])));
exit; */

$posted_meta = $_POST['form_meta'];

$meta = json_decode($form -> form_meta);

$mailchimp -> list_id = $meta -> list_id;
$mailchimp -> api_key = get_option('nm_mc_api_key');
$mailchimp -> thanks  = get_option('nm_mc_thanks_message');

$mailchimp -> validateCredentials($posted_meta, $meta -> vars);

/* pushing list interest/groups into VARS array */
$interest = array();
foreach($meta -> interest as $grouping)
{
	$temp['id'] 	= $grouping -> id;
	$temp['groups']	= $grouping -> groups;
	
	array_push($interest, $temp);
	$mailchimp -> vars ['GROUPINGS'] = $interest;
}
/* pushing list interest/groups into VARS array */


$json_resp = array();
if($mailchimp -> err)
{
	$mailchimp -> err = false;
	//echo $mailchimp -> errMessage;
	$json_resp['status'] = 'failed';
	$json_resp['message'] = $mailchimp -> errMessage;
}
else
{
	$resp = $mailchimp -> saveToList();
	if($resp == 'error')
	{
		$json_resp['status'] = 'failed';
		$json_resp['message'] = $mailchimp -> errMessage;
	}
	else
	{
		$json_resp['status'] = 'success';
		$json_resp['message'] = $resp;
	}
}
echo json_encode($json_resp);

?>