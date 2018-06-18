// JavaScript Document

//KEEP THE SUBNAV IN VIEW WHILE PAGE IS SCROLLING


$(function(){
	
	slide_count = 1;
	//slide_num = parseInt(slide_count);
	
	//$('#slide_1').addClass('slide_on');
	
	//current_slide = "#slide_1";
	
	$('.dot-nav').click(function() {
		next_num = parseInt(slide_count) + 1;
		current_slide='#slide_' + parseInt(slide_count);
		
		
	
		next_slide='#slide_' + next_num;
		alert(next_slide);
		//$('#slide_1').toggleClass('slide_on slide_off');
		//$('#slide_1').css('visibility' , 'hidden');
		$(current_slide).css('left' , '-1600px');
		$(next_slide).css('left' , '0px');
		$(next_slide).css('display' , 'block');
	//	$(next_slide).toggleClass('slide_on');
		//slide_count++;
	});


});


