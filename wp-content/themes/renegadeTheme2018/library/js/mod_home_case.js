// JavaScript Document

// FUNCTIONS FOR EXPANDING AND COLLAPSING HOME PAGE INFO PANELS

$(function(){

	
	var case_label = $('.hm-case');
	
	$(case_label).mouseover(function(){
		var thisCase = $(this);
		var label = $(thisCase).children('.hm-case-label-ct').children('.hm-case-label')
		//var case_ct = $(thisCase).parent('.hm-case');
		var info_panel = $(thisCase).children('.hm-case-info-ct');
		
	//	$(info_panel).css({'border' : '1px solid red'});
		TweenLite.to(label, .5, {alpha:1, ease:Power2.easeOut})
		//TweenLite.to(info_panel, .5, {css:{'height':'100%'}, ease:Power2.easeOut})
		TweenLite.to(info_panel, .5, {alpha:1, ease:Power2.easeOut})
	})
	
	$(case_label).mouseout(function(){
		var thisCase = $(this);
		var label = $(thisCase).children('.hm-case-label-ct').children('.hm-case-label')
		//var case_ct = $(thisCase).parent('.hm-case');
		var info_panel = $(thisCase ).children('.hm-case-info-ct');
	//	$(info_panel).css({'border' : '1px solid red'});
		TweenLite.to(label, .5, {alpha:.8, ease:Power2.easeOut})
	//	TweenLite.to(info_panel, .5, {css:{'height':'0'}, ease:Power2.easeOut});
		TweenLite.to(info_panel, .5, {alpha:0, ease:Power2.easeOut});

	})

});



