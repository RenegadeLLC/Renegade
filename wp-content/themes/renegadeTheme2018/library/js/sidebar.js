// JavaScript Document

//KEEP THE SUBNAV IN VIEW WHILE PAGE IS SCROLLING

$(function(){

	/*
$('.sidebar-nav').click(function() {
	//$('.sub-nav-menu-ct').toggleClass('nav-open');
	
	subitem = $(this).next();
	
	subcontent = $(subitem).children('.sidebar-content');
	
	h = $(subcontent).height();
	
	hp = h + 'px';
	
	
	//TweenLite.to(subitem, .75, {height:hp});
	$(subitem).toggleClass('sidebar-closed', 20000, "easeOutSine");
	//$(subcontent).css('margin-top' , '80px');
	//alert( "hi" );
});

*/


	$( ".sidebar-nav" ).click(function() {

		var sidebar_ct = $(this).next('.sidebar-item-ct');
		var sidebar_item = $(sidebar_ct).children('.sidebar-item');

		var cth = $(sidebar_ct).height();
		var h = $(sidebar_item).height() + 16;
		var w = $(sidebar_item).width();
	//	alert('h is ' + h + 'w is ' + w);
		
		if(cth == 0){
			TweenLite.to(sidebar_ct, .25, {height:h, alpha:1, delay:0});
		} else{
			TweenLite.to(sidebar_ct, .25, {height:0, alpha:1, delay:0});
		}

	});


});


