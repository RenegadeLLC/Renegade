// JavaScript Document

//KEEP THE SUBNAV IN VIEW WHILE PAGE IS SCROLLING
$(function(){
	  $(window).scroll(function(){
	    //var sTop = $('.subnav').height();
	    var sTop = $(window).scrollTop();
	    var sTop_p = sTop + 'px';
	    
	    if(sTop == 0){

	    	 $('.page-header').parent().css({'top' : '0'});
	    } else {
	    $('.page-header').css({'top' : sTop_p});
	    }
	  
	  });
	});
