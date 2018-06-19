// JavaScript Document
String.prototype.trim = function () {
    return this.replace(/^\s*/, "").replace(/\s*$/, "");
}



function postToMailChimp(post_url, abspath, widget_id, redirect_to)
{
	// var img_loading = '<img
	// src="http://theproductionarea.net/wp-content/plugins/nmedia-mailchimp-pro-v3/images/loading.gif">';
	jQuery("#nm-mc-loading").show();
	
	var e 		 = jQuery('#nm_mc_email-'+widget_id).val();
	var formid	 = jQuery('#nm_mc_form_id-'+widget_id).val();
	
	var formmeta = Array();
	jQuery("input[name^=nm-form-meta]").each(function (index)
	{
	    // alert(jQuery(this).val());
		formmeta.push(jQuery(this).val());
	});
		
	jQuery('#nm_mc_email-'+widget_id).val('Subscribing...');
	
	//alert(php_serialize(formmeta));
	
	var post_data = {
				'action': 'mailchimp_subscribe',
				email: e,
				form_id: formid,
				form_meta: formmeta		
	};
	
	jQuery.post(mailchimp_vars.ajaxurl,
			post_data,
			
			function(data){
			//alert(data.status);
			if(data.status == 'success' && redirect_to != '')
			{
				window.location = redirect_to;
			}
			else
			{
				jQuery("#nm-mc-loading").hide();
				jQuery("#mc-response-area").html(data.message);
				jQuery('#nm_mc_email-'+widget_id).val('');
				jQuery('#nm_mc_fullname-'+widget_id).val('');
			}
	}, 'json');
}

function php_serialize(obj)
{
    var string = '';

    if (typeof(obj) == 'object') {
        if (obj instanceof Array) {
            string = 'a:';
            tmpstring = '';
            count = 0;
            for (var key in obj) {
                tmpstring += php_serialize(key);
                tmpstring += php_serialize(obj[key]);
                count++;
            }
            string += count + ':{';
            string += tmpstring;
            string += '}';
        } else if (obj instanceof Object) {
            classname = obj.toString();

            if (classname == '[object Object]') {
                classname = 'StdClass';
            }

            string = 'O:' + classname.length + ':"' + classname + '":';
            tmpstring = '';
            count = 0;
            for (var key in obj) {
                tmpstring += php_serialize(key);
                if (obj[key]) {
                    tmpstring += php_serialize(obj[key]);
                } else {
                    tmpstring += php_serialize('');
                }
                count++;
            }
            string += count + ':{' + tmpstring + '}';
        }
    } else {
        switch (typeof(obj)) {
            case 'number':
                if (obj - Math.floor(obj) != 0) {
                    string += 'd:' + obj + ';';
                } else {
                    string += 'i:' + obj + ';';
                }
                break;
            case 'string':
                string += 's:' + obj.length + ':"' + obj + '";';
                break;
            case 'boolean':
                if (obj) {
                    string += 'b:1;';
                } else {
                    string += 'b:0;';
                }
                break;
        }
    }

    return string;
}