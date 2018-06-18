// JavaScript Document

//KEEP THE SUBNAV IN VIEW WHILE PAGE IS SCROLLING

$(function(){


$('.floater').each(function(){

var floater = $(this);
var floater_id = $(floater).attr('id');
var slide = $(floater).children('.trans-slide');
var scale = $(floater).find('.trans-scale');
var fade = $(floater).find('.trans-fade');
var rotate = $(floater).find('.trans-rotate');
var direction = $(floater).attr('direction');
var xPos = parseInt($(floater).attr('targetPos')) + '%';
var startPos;

if(direction == 'left'){
	
	startPos = parseInt(-100) + '%';
	
} else if(direction == 'right'){
	
	startPos = parseInt(100) + '%';
	
} else if(direction == 'static'){
	
	startPos = parseInt(xPos);
}

//alert(startPos + ' ' + xPos);
var anim_property1 = '';
var anime_value1 = '';

TweenLite.fromTo(floater, 1, {css:{alpha:0, left: startPos}}, {css:{alpha:1, left:xPos}, ease: Power1.easeInOut,});
	
});



	var row = $('.home-row');
	//TweenLite.to(row, .5, {height:"400px", alpha:.5, delay:0});
	
	$(row).on('scrollSpy:enter', function() {
	    console.log('enter:', $(this).attr('id'));
	   // TweenLite.to(row, .5, {height:"400px", alpha:1, delay:0});
	 //   TweenLite.to(row, .5, {height:"600px", alpha:1, delay:0});
	});

	$(row).on('scrollSpy:exit', function() {
	    console.log('exit:', $(this).attr('id'));
	   // TweenLite.to(row, .5, {height:"400px", alpha:.5, delay:0});
	  //  TweenLite.to(row, .5, {height:"200px", alpha:1, delay:1});
	});

	
	//$('#work').scrollSpy();

});



