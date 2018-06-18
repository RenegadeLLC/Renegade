// JavaScript Document


jQuery(document).ready(function($) {

	$('.tax-filter').click( function(event) {

		// Prevent defualt action - opening tag page
		if (event.preventDefault) {
			event.preventDefault();
		} else {
			event.returnValue = false;
		}

		// Get tag slug from title attirbute
		var selected_taxonomy = $(this).attr('title');

		$('.article-item').fadeOut();

		data = {
			action: 'ajax_filter_get_posts',
			afp_nonce: afp_vars.afp_nonce,
			taxonomy: 'category',
			//term: selected_taxonomy,
			term:'wtf',
		};

		$.ajax({
			type: 'post',
			dataType: 'json',
			url: afp_vars.afp_ajax_url,
			data: data,
			//data: {action: 'ajax_filter_get_posts', cat: selected_taxonomy },
			//success: function( data, textStatus, XMLHttpRequest ) {
			success: function( data, textStatus, XMLHttpRequest ) {
				
				var $response=$(data);
				var $wtf = json_encode($response);
				alert($wtf);
				//console.debug($response);
				//alert(selected_taxonomy);
				$('#articles-list').html( data);
				$('#articles-list').fadeIn();
				/*console.log( data );
				console.log( XMLHttpRequest );*/
			},
			error: function( MLHttpRequest, textStatus, errorThrown ) {
				
				/*console.log( MLHttpRequest );
				console.log( textStatus );
				console.log( errorThrown );*/
				$('#articles-list').html( 'No posts found' );
				$('#articles-list').fadeIn();
			}
		})

	});
});