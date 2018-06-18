// JavaScript Document

$(document).ready(function() {

//GET THE WIDTH OF THE CIRCLE
var w = $('.circle').width();
var wp = w + 'px';
$('.circle').css({'height': wp})

var wB = $('.circle-big').width();
var wBp = wB + 'px';
$('.circle-big').css({'height': wBp})


var sawW = $('.saw-med').width();
var sawWp = sawW + 'px';

$('.saw-med').css({'height': sawWp});

var clW = $('.text-highlight').width() + 32;
var clWp = clW + 'px';

$('.text-highlight').css({'height': clWp});
	var clH = $('.text-highlight').height();
});

$(window).resize(function() {
	
	var w = $('.circle').width();
	var wp = w + 'px';
	$('.circle').css({'height': wp});
	
	var wB = $('.circle-big').width();
	var wBp = wB + 'px';
	$('.circle-big').css({'height': wBp})

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
		$( '.circle' ).each(function( index ) {
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
