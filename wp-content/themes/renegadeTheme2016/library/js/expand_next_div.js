// JavaScript Document

//KEEP THE SUBNAV IN VIEW WHILE PAGE IS SCROLLING
jQuery(document).ready(function($) {
	
	$(function(){
		
		$('.expander').click(function(){
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
			
		});
	});

});