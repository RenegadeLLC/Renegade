jQuery(document).ready(function($) {

//jQuery(function() {

	var $html;
	var $container;
	
	//jQuery("#archive-wrapper").height(jQuery("#archive-pot").height());
	

	$('.articles-page .archive-link').click(function(event){
		
		if (event.preventDefault) {
			event.preventDefault();
		} else {
			event.returnValue = false;
		}
		
		//get the next instance of anchor
		//var thisLink = $(this);
		var thisLink = $(this).next('a');
		//get the href 
		var url = $(thisLink).attr('href');
		//alert(url);
		
		//split the url after query to get post type
		var url_array = url.split('?post_type=');
		//get post type from 2nd value in array
		var url_base = url_array[0];
		

		var n = url_base.length;
		//count backwards 9 characters to get index where date begins
		i = n-5;
		
		
		//slice off the last 9 characters of string to get date string
		var date_string = url_base.slice(i, n);
		//split string into month and year
		var date_array = date_string.split('/');

		//variables to pass to wp query
		var year = parseInt(date_array[1]);
		var month = parseInt(date_array[2]);
		var post_type = url_array[1];
		
		//if(post_type == 'articles'){
	//		month='';
	//	}
		
		//alert(date_string);
	//	$( "#container" ).load( url );
		alert(url);

/*
		data = {
				action: 'load_archives',
				arc_nonce: arc_vars.arc_nonce,
				year: year,
				month : month,
				post_type: post_type,
				//url : url,
		};
		
		$.ajax({
			type: 'POST',
			url: arc_vars.arc_ajax_url,
			dataType: 'html',
			data: data,
			success: function( data ) {
				console.log(data);
				$html = $( data  );
				 	$('.post-grid').html( $html );
					var elements = $('.post-grid-item');
				 	$('.post-grid').append( elements )
				 		
				$('#articles-list').fadeIn();
				alert(data);
			},
			error: function(xhr, status, error) {
		        // Display a generic error for now.
		     //   alert(status);
		      }
		})

			*/
	});//end click function
	


});//end doc ready
