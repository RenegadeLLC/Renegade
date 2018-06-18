// JavaScript Document

$(document).ready(function() {

	var link_panel;
	var phone_panel;
	var panel_status = 'closed';
	var current_panel = null;
	var current_button = null;
	/*
	$("#bt-link").on('click', function(){
		
		
		var link_panel = $('#links-panel');
		var link_button = $(this);
		
		if(current_panel == null){
		
			open_panel(link_panel, link_button);
			
		} else if($(current_panel).attr('id') == $(link_panel).attr('id')){

			close_panel(current_panel, current_button);
		} else{
			
			transition_panels(current_panel,current_button, link_panel, link_button);
		}
		
	});
	
	

	$('.utility-nav').on('click', function(){
		
			var button = $(this);
			//var button_id = '#' + $(button).attr('id');
			var item_name = $(button).attr('id').replace('bt-', '');
			var item_panel_id = '#' + item_name + '-panel';
			var panel = $(item_panel_id);
			var panel_inner = $(panel).children('.utility-panel-inner');
			var panel_inner_id =$(panel_inner).attr('id');
			var panel_width = $(panel_inner).width();
			//alert(panel_width);
			if(current_panel==null){
				open_panel(panel, button, panel_width, 0);
			} else if($(current_panel).attr('id') == $(panel).attr('id')){
				close_panel(current_panel, current_button);
			} else{
				close_panel(current_panel, current_button);
				open_panel(panel, button, panel_width, .5);
			}
			
		alert(panel_width + ' ' + panel_inner_id);
	});
	
	*/
	
	$('.utility-nav').on('click', function(){
		
		var button = $(this);
		//var button_id = '#' + $(button).attr('id');
		var panel = $(button).next('.utility-panel');
		var panel_inner = $(panel).children('.utility-panel-inner');
		var panel_width = $(panel_inner).width() + 16;
		if(current_panel==null){
			open_panel(panel, button, panel_width, 0);
		} else if($(current_panel).attr('id') == $(panel).attr('id')){
			close_panel(current_panel, current_button);
		} else{
			close_panel(current_panel, current_button);
			open_panel(panel, button, panel_width, .5);
		}
		
	//alert(panel_width + ' ' + panel_inner_id);
});


	
	function open_panel(panel, button, width, delay){
		
		var w= parseInt(width);
		TweenLite.to(panel, .5, {width:w, alpha:1, delay:delay});
		$(panel).css({'border-left': '0px solid #fff'});
		$(panel).css({'border-right': '0px solid #fff'});
		$(button).toggleClass('utility-on');
		current_button_id = '#' +  $(button).attr('id');
		current_panel_id = '#' +  $(panel).attr('id');
		current_panel = $(current_panel_id);
		current_button = $(current_button_id);
	}
	
	function close_panel(panel, button){
		TweenLite.to(panel, .5, {width:"0px", alpha:1});
		$(panel).css({'border-left': 'none'});
		$(panel).css({'border-right': 'none'});
		$(button).toggleClass('utility-on');
		current_panel = null;
		current_button = null;
	}
	


});


