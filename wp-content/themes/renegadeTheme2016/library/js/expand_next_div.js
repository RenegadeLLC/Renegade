// JavaScript Document

//KEEP THE SUBNAV IN VIEW WHILE PAGE IS SCROLLING
jQuery(document).ready(function($) {
	
	$(function(){
		
		$('.expander').click(function(){
			var container = $(this);
			$(this).toggleClass('active');
			expand(container);
			/*
			var container = $(this).next('.expanded-ct');
			var content = $(container).children('.expanded');
			var content_height = $(content).height();
			var container_height = $(container).height();
			
			if(container_height == 0){
				//$(container).css({'height' : content_height});
				TweenLite.to(container, .75, {height:content_height, ease:Circ.easeOut});
			}else{
			//	$(container).css({'height' : 0});
				TweenLite.to(container, .5, {height:0, ease:Circ.easeOut});
			}
			*/
		});
	});

});

function expand(thing){
	var container = $(thing).next('.expanded-ct');
	var content = $(container).children('.expanded');
	var content_height = $(content).height();
	var container_height = $(container).height();
	
	if(container_height == 0){
		//$(container).css({'height' : content_height});
		TweenLite.to(container, .75, {height:content_height, ease:Circ.easeOut});
	}else{
	//	$(container).css({'height' : 0});
		TweenLite.to(container, .5, {height:0, ease:Circ.easeOut});
	}
	
}
$(document).ready(function() {
	
	var thisYear = $('.post-list').attr('year');
	
	$('.archive-year').each(function(){
	
		var text = $(this).text();
	
		if(text == thisYear){
			//$(this).css({'border' : '1px solid red'});
			$(this).addClass('active');
			var container = $(this);
			expand(container);
			//$(container).css({'border' : '1px solid red'})
		}
	
		
	})
	
});
