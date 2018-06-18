// JavaScript Document

//KEEP THE SUBNAV IN VIEW WHILE PAGE IS SCROLLING
$(function(){
	  $(window).scroll(function(){
	    //var sTop = $('.subnav').height();
	    var sTop = $(window).scrollTop() - 4;
	    var sTop_p = sTop + 'px';
	    
	    if(sTop == 0){

	    	 $('.subnav').parent().css({'top' : '0'});
	    } else {
	    $('.subnav').parent().css({'top' : sTop_p});
	    }
	  
	  });
	});


$.fn.scrollStopped = function(callback) {           
    $(this).scroll(function(){
        var self = this, $this = $(self);
        if ($this.data('scrollTimeout')) {
          clearTimeout($this.data('scrollTimeout'));
        }
        $this.data('scrollTimeout', setTimeout(callback,250,self));
    });
};

//IF USER HAS SCROLLED BACK TO THE TOP ADJUST THE SCROLL POSITION

$(window).scrollStopped(function(){
	var sTop = $(window).scrollTop() - 4;
	if(sTop == 0){
	$('.subnav').parent().css({'top' : '0'});
	}
});


$(document).ready(function() {
//$(.subnav).next

	var aSubNav = new Array();

	//ADD ALL CURRENT SUBNAV ITEMS TO AN ARRAY
	$( '.subnav .menu-item' ).each(function( index ) {
		aSubNav.push(this);
	});
	
	//FOR THE LENGTH OF THE ARRAY ANIMATE ITEMS IN	
	var al = aSubNav.length;
	
	for (i=0; i<=al; i++){
		var item = $(aSubNav[i]);
		var t = i*.75;
		//$(item).css({'border':'1px solid red'})
		TweenLite.from(item, t, {left:150});
	}
});

//SCRIPT FOR STICKY SIDEBAR

$(document).ready(function(){
	jQuery('.sidebar_left').containedStickyScroll({
		 duration: 500,
	        unstick: false,
	});
});


//SCRIPT FOR ANCHOR LINKS

$(document).ready(function() {
	
	$('.anchor-link').click(function() {
		var contentDiv = '#' + this.id + '-ct';
		var pos = $(contentDiv).offset();
		var newPos = pos.top - 350;
		TweenLite.to(window, 2, {scrollTo:newPos, ease:Back.easeOut});
		//var pos = $(this).position.top;
		//alert(contentDiv + ' top is ' + pos.top);
		//alert(contentDiv);
	});
	
});
