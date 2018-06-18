// JavaScript Document

$(document).ready(function() {

//GET THE WIDTH OF THE CIRCLE
var w = $('.square').width();
var wp = w + 'px';
var h = $('.square').height(); 

$('.square').css({'height': wp});
//$('.square').css({'border-radius': '50%'});


var sawW = $('.saw-med').width();
var sawWp = sawW + 'px';

$('.saw-med').css({'height': sawWp});

var clW = $('.text-highlight').width() + 32;
var clWp = clW + 'px';

$('.text-highlight').css({'height': clWp});
var clH = $('.text-highlight').height();


});

$(window).resize(function() {
	
	var w = $('.square').width();
	var wp = w + 'px';
	$('.square').css({'height': wp});
	//$('.square').css({'border-radius': '50%'});
	
	var sawW = $('.saw_med').width();
	var sawWp = sawW + 'px';
	$('.saw-med').css({'height': sawWp});

	var clW = $('.text-highlight').width() + 32;
	var clWp = clW + 'px';
	$('.text-highlight').css({'height': clWp});



});



$(document).ready(function() {
	//$(.subnav).next

		var aCirc = new Array();

		//ADD ALL CURRENT SUBNAV ITEMS TO AN ARRAY
		$( '.square' ).each(function( index ) {
			aCirc.push(this);
		});
		
		//FOR THE LENGTH OF THE ARRAY ANIMATE ITEMS IN	
		var bl = aCirc.length;
		
		for (j=0; j<=bl; j++){
			var item = $(aCirc[j]);
			var t = j*.75;
			//$(item).css({'border':'1px solid red'})
			//TweenLite.from(item, t, {scaleX:0, scaleY:0});
		}
	});
