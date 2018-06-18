// JavaScript Document

//POST SCROLLER

//var current_post = null;
//var post_ids_array = new Array();
//var post_positions_array = new Array();


$(function(){

	var post_ids_array = new Array();
	var post_positions_array = new Array();
	var posts = $('.post-list-ct').children('.post');
	
	$( posts ).each(function(){
		
		var post_id = $(this).attr('id');
		var this_post = $(this);
		var post_position = $(this_post).position();
		var post_top = post_position.top;
		
		post_ids_array.push(post_id);
		post_positions_array.push(post_top);

	})

	var current_post=null;
	
$('.dot-nav').on('click', function(){

	var this_button = $(this);	
	var this_button_id = $(this_button).attr('id');	
	var this_post_id ='#' + this_button_id.substring(3);
	var this_post = $(this_post_id);
	var post_container_id = '#' + $(this_post).parent().attr('id');
	var post_container = $(post_container_id);
	//var first_post = $(post_container).children(':first');
	
	$(post_container).find('.post').each(function(){
		$(this).css({'display' : 'block'});
		if($(this) != this_post){
			TweenLite.to(this, 1, {alpha:.25, ease:Power2.easeOut, onComplete:fadeAdjust(this_post)});
		}else{
			
		}
	})
	
	var post_index = post_ids_array.indexOf($(this_post).attr('id'));
	var post_top = post_positions_array[post_index];
	
	TweenLite.to(post_container, 1, {y:parseInt('-' + post_top), ease:Power2.easeOut, onComplete:fadeAdjust(this_post)});
	
	function fadeAdjust(this_post){
		//post_id = ($(this_post).attr('id'));
		//this_post = $(this_post);
		//this_post=$(post_id);
		//$(this_post).css({'border' : '1px solid red'});
	//	alert($(this_post).attr('id'))
		
	
		$(post_container).find('.post').each(function(){
			
			//var post_it = $(this);
			//alert($(this_post).attr('id'));
			
			
			TweenLite.to(this, 1, {alpha:0, ease:Power2.easeOut, delay:.5, onComplete:hideThese()});
		
			$(this_post).css({'display' : 'block'});
			TweenLite.to(this_post, 1, {alpha:1, ease:Power2.easeOut, delay:.5});
			/*if($(this) != this_post){
				//TweenLite.to(this, 1, {alpha:0, ease:Power2.easeOut});
			}else{
				alert('this')
				TweenLite.to(this, 1, {alpha:1, ease:Power2.easeOut});
			}*/
		})
		
		function hideThese(){
			$(post_container).find('.post').each(function(){
				$(this).css({'display' : 'none'});
			})
			
		}
	
	}

	/*
	if(current_post == null){
		TweenLite.to(first_post, 1, {alpha:.25, ease:Power2.easeOut});
		TweenLite.to(this_post, 1, {alpha:1, ease:Power2.easeOut});
		current_post = this_post;
	}else{
		TweenLite.to(current_post, 1, {alpha:.25, ease:Power2.easeOut});
		TweenLite.to(this_post, 1, {alpha:1, ease:Power2.easeOut})
		current_post = this_post;
	}

	function fadeOut(){
		TweenLite.to(this_post, 1, {alpha:0, ease:Power2.easeOut})
	}*/
	
	

	//TweenLite.to(post_container, 1, {scrollTo:{y:post_top}, ease:Power2.easeOut});
	


	
})


});



