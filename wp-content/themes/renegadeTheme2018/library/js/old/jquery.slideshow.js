 jQuery(document).ready(function($) {
	  
	 var slide = $('.slide');
	
	 var current_slide = $('.slide:first').attr('id');
	 var current_text = $('.slide-text-ct:first').attr('id');
	 var current_image = $('.slide-image:first').attr('id');
	 
	 var last_slide = $('.slide:last');
	 var last_text = $('.slide-text-ct:last');
	 var last_image = $('.slide-image:last');
	 var autoplay_timer;
	 
	 current_slide	= '#' + current_slide;
	 current_text = '#' + current_text;
	 current_image = '#' + current_image;
	 
	 last_slide = '#' +  last_slide;
	 last_text = '#' +  last_text ;
	 last_image = '#' +  last_image;
	 
	 var numSlides;
	 var n = 1;

	 function init(){
		 
		//turn first slide on
		$( current_slide).toggleClass('slide-off');
		//$( current_text ).css('background' , '#000000');
		numSlides = $('.slide').length;
		//alert(current_text);
		slideshow_start();
		
	 }
	 
	 function slideshow_start() {
		 autoplay_timer = setInterval(function(){ goNext(current_slide, current_text); }, 5000);
		}
	 
	 function slideshow_stop() {
		    clearInterval(autoplay_timer);
		}
	 
	 function goNext(current_slide, current_text){
		 slideshow_stop();
		 if(n < numSlides){
		 
		 next_slide = $(current_slide).next(slide).attr('id');
		 next_slide = '#' + next_slide;
		 
		 next_text = $(next_slide).find('.slide-text-ct').attr('id');
		 next_text= '#' + next_text;
		 
		 $(next_slide).removeClass('slide-off');
		 n++
		 
		 } else {
			 next_slide = $('.slide:first').attr('id');
			 next_slide = '#' + next_slide;	
			 next_text = $(next_slide).find('.slide-text-ct').attr('id');
			 next_text= '#' + next_text;
			 n = 1;		
		 }
		//alert(next_text);
		TweenLite.fromTo(current_slide, 1.25, {css:{alpha:1, left:'0%'}}, {css:{alpha:0, left:'-100%'}, ease: Power1.easeInOut,});
		TweenLite.fromTo(next_slide, 1.25, {css:{alpha:0, left:'100%'}}, {css:{alpha:1, left:'0%'}, ease: Power1.easeInOut,});
		
	//	TweenLite.to(current_text, 1, {alpha:0, ease: Circ.easeOut,});
	//	TweenLite.to(next_text, 1, {alpha:1, ease: Circ.easeOut,});

		 update_next(current_slide, current_text);
	 }
	 
	function goPrevious(current_slide){
		slideshow_stop();
		 if(n == 1){
			
			 previous_slide = $('.slide:last').attr('id');
			 previous_slide = '#' + previous_slide;
			 
			 previous_text = $(previous_slide).find('.slide-text-ct').attr('id');
			 previous_text= '#' + previous_text;
			 n = numSlides;
			 
		 } else {
			 
			 previous_slide = $(current_slide).prev(slide).attr('id');
			 previous_slide = '#' + previous_slide; 	
			 
			 previous_text = $(previous_slide).find('.slide-text-ct').attr('id');
			 previous_text= '#' + previous_text;
			 n--;
	}
		//alert(previous_text);
		$(previous_slide).removeClass('slide-off');
		 
		TweenLite.fromTo(current_slide, 1, {css:{alpha:1, left:'0%'}}, {css:{alpha:0, left:'100%'}, ease:Power3.easeOut});
		TweenLite.fromTo(previous_slide, 1, {css:{alpha:0, left:'-100%'}}, {css:{alpha:1, left:'0%'}, ease:Power3.easeOut});
		
	//	TweenLite.to(current_text, 1, {alpha:0, ease: Circ.easeOut,});
		//TweenLite.from(previous_text, 1, {alpha:1, ease: Circ.easeOut,});
		
		 update_previous(current_slide, current_text);
	 }
	 
	 function update_next(){
		 current_slide = next_slide;
		 current_text = next_text;
		 slideshow_start();
		 
	 }
	 
	 function update_previous(){
		 current_slide = previous_slide;
		 current_text = previous_text;
		 slideshow_start();
	 }
	 
	 $( '.da-arrows-next' ).on('click', function(){
			goNext(current_slide, current_text);
	});	
	 
	 $( '.da-arrows-prev' ).on('click', function(){
		 
			//alert(current_slide);
			goPrevious(current_slide, current_text);
			
	});	
		
		init();
});
