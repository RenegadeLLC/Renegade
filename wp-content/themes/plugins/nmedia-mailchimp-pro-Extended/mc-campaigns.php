<?php 
/*
** this file is about Mailchimp compaigns
*/

$mailchimp = dirname(__FILE__) . '/class.mailchimp.php';
include ( $mailchimp );

$mc = new clsMailchimp();

//loading templates
$file_template = '';

switch (@$_REQUEST['act'])
{
	case 'create-camp':
		$file_template = dirname(__FILE__) . '/include/create-campaign.php';
	break;
	
	case 'save-camp':
		$mc -> createCampaign($_POST);
		$file_template = dirname(__FILE__) . '/include/list-campaigns.php';
	break;
	
	case 'list-camp':
		$file_template = dirname(__FILE__) . '/include/list-campaigns.php';
	break;
	
	case 'camp-del':
		$mc -> deleteCampaign(@$_REQUEST['cid']);
		$file_template = dirname(__FILE__) . '/include/list-campaigns.php';
		break;
	
	case 'send-test':
		$mc -> sendTestCampaign(@$_REQUEST['cid']);
		$file_template = dirname(__FILE__) . '/include/list-campaigns.php';
	break;
	
	case 'send':
		$mc -> sendCampaign(@$_REQUEST['cid']);
		$file_template = dirname(__FILE__) . '/include/list-campaigns.php';
	break;
	
	case 'camp-report':
		/*  loading controls */
		$file_template = dirname(__FILE__) . '/include/camp-report.php';
	break;
	
	default:
		$file_template = dirname(__FILE__) . '/include/controls.php';
	break;
}

if(file_exists($file_template))
	include ($file_template);
else
	echo 'file not found '.$file_template;
?>

<script type="text/javascript">
jQuery(function(){

	jQuery('input:radio[name="mc-template"]').click(function(){	
		jQuery("#title-s-1").html('template selected: '+jQuery(this).attr('title'));
		
		if(jQuery(this).val() != 0)
		{
			jQuery("#camp-more-contents").show();
			
			/* hiding/showing the sidebar if template is not Simple*/
			if(jQuery(this).val() != 1001)
				jQuery("#container-sidebar-content").show();
			else
				jQuery("#container-sidebar-content").hide();
		}else
		{
			jQuery("#camp-more-contents").hide();
		}
	});
	
	//selecting no template by default
	//jQuery("input:radio['value=0']:checked");

	/* for slider used in campaign-contents.php*/
	/* header section */
	
	/*jQuery( "#camp-section-header-slider" ).slider({

		'max': 30,
		'min':0,
		slide: function( event, ui ) {
			jQuery("#camp-section-header-preview").css({'padding':ui.value});
		}
		});*/

	/* font size slider */
	/*jQuery( "#camp-section-header-fontsize" ).slider({

		'max': 45,
		'min':10,
		slide: function( event, ui ) {
			jQuery("#camp-section-header-preview").css({'font-size':ui.value + 'px'});
		}
		});*/

	/* camp header section bg color */
	jQuery("#camp-section-header-bgcolor li").click(function(){
			alert(jQuery(this).attr('class'));
			jQuery("#camp-section-header-preview").css({'background-color': jQuery(this).attr('class')});
		});

	/* camp header section font color */
	jQuery("#camp-section-header-fontcolor li").click(function(){
			//alert(jQuery(this).attr('class'));
			jQuery("#camp-section-header-preview").css({'color': jQuery(this).attr('class')});
		});

	/* camp header section align */
	jQuery("input[name^=camp-section-header-align]").click(function(){
			//alert(jQuery(this).val());
		jQuery("#camp-section-header-preview").css({'text-align':jQuery(this).val()});
		});

	/* sidebar section */
	/*jQuery( "#camp-section-sidebar-slider" ).slider({

		'max': 30,
		'min':0,
		slide: function( event, ui ) {
			jQuery("#camp-section-sidebar-preview").css({'padding':ui.value});
		}
		});*/

	/* font size slider */
	/*jQuery( "#camp-section-sidebar-fontsize" ).slider({

		'max': 45,
		'min':10,
		slide: function( event, ui ) {
			jQuery("#camp-section-sidebar-preview").css({'font-size':ui.value + 'px'});
		}
		});*/

	/* camp sidebar section bg color */
	jQuery("#camp-section-sidebar-bgcolor li").click(function(){
			//alert(jQuery(this).attr('class'));
			jQuery("#camp-section-sidebar-preview").css({'background-color': jQuery(this).attr('class')});
		});

	/* camp SIDEBAR section font color */
	jQuery("#camp-section-sidebar-fontcolor li").click(function(){
			//alert(jQuery(this).attr('class'));
			jQuery("#camp-section-sidebar-preview").css({'color': jQuery(this).attr('class')});
		});

	/* camp sidebar section align */
	jQuery("input[name^=camp-section-sidebar-align]").click(function(){
			//alert(jQuery(this).val());
		jQuery("#camp-section-sidebar-preview").css({'text-align':jQuery(this).val()});
		});


	/* footer section */
	/*jQuery( "#camp-section-footer-slider" ).slider({

		'max': 30,
		'min':0,
		slide: function( event, ui ) {
			jQuery("#camp-section-footer-preview").css({'padding':ui.value});
		}
		});*/

	/* font size slider */
	/*jQuery( "#camp-section-footer-fontsize" ).slider({

		'max': 45,
		'min':10,
		slide: function( event, ui ) {
			jQuery("#camp-section-footer-preview").css({'font-size':ui.value + 'px'});
		}
		});*/

	/* camp footer section bg color */
	jQuery("#camp-section-footer-bgcolor li").click(function(){
			//alert(jQuery(this).attr('class'));
			jQuery("#camp-section-footer-preview").css({'background-color': jQuery(this).attr('class')});
		});

	/* camp FOOTER 	section font color */
	jQuery("#camp-section-footer-fontcolor li").click(function(){
			//alert(jQuery(this).attr('class'));
			jQuery("#camp-section-footer-preview").css({'color': jQuery(this).attr('class')});
		});

	/* camp footer section align */
	jQuery("input[name^=camp-section-footer-align]").click(function(){
			//alert(jQuery(this).val());
		jQuery("#camp-section-footer-preview").css({'text-align':jQuery(this).val()});
		});
});

/* getting design code of preivew element */
function getDesignCode(area)
{
		
	jQuery("#"+area+"-designer").slideUp();
	
}

/*
 * toggling the content sections
 */
 function toggleArea(area)
{
	 jQuery("#"+area).slideToggle();
}

function createCamp()
{
	jQuery("form").submit();
}

function changeStep(from, to)
{
	//alert(step);
	jQuery("#"+from).slideToggle();
	jQuery("#"+to).slideDown();
}

function loadStep(step)
{
	//alert(step);
	jQuery("#"+step).slideToggle();
}

function openStep(step)
{
	//alert(step);
	jQuery("#"+step).slideDown();
}

function validateCreateCamp()
{
	var vFlag = true;
	
	/* step two */
	var list 	= jQuery("#camp-list").val();
	var subject 	= jQuery("#camp-subject").val();
	var from_email 	= jQuery("#camp-from-email").val();
	var from_name 	= jQuery("#camp-from-name").val();
	
	list == '' ? jQuery("#camp-list").css({'border':'#f00 1px solid'}) : jQuery("#camp-list").css({'border':'#ccc 1px solid'});
	subject == '' ? jQuery("#camp-subject").css({'border':'#f00 1px solid'}) : jQuery("#camp-subject").css({'border':'#ccc 1px solid'});
		from_email == '' ? jQuery("#camp-from-email").css({'border':'#f00 1px solid'}) : jQuery("#camp-from-email").css({'border':'#ccc 1px solid'});
		from_name == '' ? jQuery("#camp-from-name").css({'border':'#f00 1px solid'}) : jQuery("#camp-from-name").css({'border':'#ccc 1px solid'});
	
	if(list == '' || subject == '' || from_email == '' || from_name == '')
	{
		openStep('s-2');
		vFlag = false;		
	}else
	{
		loadStep('s-2');
	}
	/* step two */
	
	/* step four */
	var content 	= jQuery("#camp-content").val();
	content == '' ? jQuery("#camp-content").css({'border':'#f00 1px solid'}) : jQuery("#camp-content").css({'border':'#ccc 1px solid'});
		
	if(content == '')
	{
		openStep('s-4');
		vFlag = false;		
	}else
	{
		loadStep('s-4');
	}
	/* step four */
	
	return vFlag;
}

function previewCamp(urlLoading)
{
	if(!validateCreateCamp())
	{
		return false;
	}

	var loading = '<p>Please wait content is being loaded for preview</p><br><img src="'+urlLoading+'" />';
	
	jQuery("#camp-preview-area").html(loading);
	
	jQuery("#camp-preview-area").show(500);
	jQuery("#camp-preview-buttons").show();
	
	jQuery("#camp-steps").hide(500);
	
	
	var pluginurl = '<?php echo plugins_url('', __FILE__)?>';
	var post_url = '<?php echo plugins_url('/smart.php', __FILE__)?>';
	
	var templateid = jQuery("input:radio[name^=camp-template]:checked").val();
	
	var header = jQuery("#camp-section-header-content").val();
	var main = jQuery("#camp-content").val();
	var sidebar = jQuery("#camp-section-sidebar-content").val();
	var footer = jQuery("#camp-section-footer-content").val();
	
	//alert(templateid); return;
	
	jQuery.post(post_url, {plugin_url: pluginurl, c_header: header,
	c_main:main, c_sidebar:sidebar, c_footer:footer, template_id:templateid}, function(data){

		//alert(data);
				
		jQuery("#camp-preview-area").html('<h2>Preview:</h2><p><?php _e('Campaigns will be created but not sent atfter this step. You can test this campaign later.', 'nm_mailchimp_plugin')?></p><hr>');
		jQuery("#camp-preview-area").append('<div id="camp-final-content">'+data+'</div>');

		
		
		/* applying custom style to HEAD section */
		var header_css = jQuery("#camp-section-header-preview").attr('style');
		jQuery("#head-section").attr('style', header_css);
		

		/* applying custom style to SIDEBAR section */
		var sidebar_new_css = jQuery("#camp-section-sidebar-preview").attr('style');
		var sidebar_old_css = jQuery("#sidebar-section").attr('style');
		jQuery("#sidebar-section").attr('style', sidebar_new_css + sidebar_old_css);
		

		/* applying custom style to FOOTER section */
		var footer_css = jQuery("#camp-section-footer-preview").attr('style');
		jQuery("#footer-section").attr('style', footer_css);

		/* applying main content height to sidebar */
		jQuery("#sidebar-section").css({'height':jQuery("#main-content").css('height')});

		//alert(jQuery("#camp-final-content").html());
		jQuery("#content-html").val(jQuery("#camp-final-content").html());	
	});
}

function cancelPreviewCamp()
{
	jQuery("#camp-preview-area").hide(500);
	jQuery("#camp-preview-buttons").hide();
	
	jQuery("#camp-steps").show(500);
	
}
</script>