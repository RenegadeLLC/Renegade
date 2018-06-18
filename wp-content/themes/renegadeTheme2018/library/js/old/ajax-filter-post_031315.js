jQuery(document).ready(function($) {
	
	$('.sort-option').click(function(event){
		// Prevent defualt action - opening tag page
		if (event.preventDefault) {
			event.preventDefault();
		} else {
			event.returnValue = false;
		}
		var selected_sort = $(this).attr('title');
		

	//	alert(selected_sort);
		data = {
				action: 'sort_posts',
				afp_nonce: afp_vars.afp_nonce,
				sort:selected_sort,
				query_vars: ajaxpagination.query_vars,
			};
		
		$.ajax({
			type: 'GET',
			dataType: 'json',
			url: afp_vars.afp_ajax_url,
			data: data,
			success: function( data ) {
				$('#articles-list').html( 'yes' );
				$('#articles-list').html( data );
				$('#articles-list').fadeIn();
			},
			error: function( ) {
				$('#articles-list').html( 'no' );
			//	$('#articles-list').html( 'No posts found' );
			//	$('#articles-list').fadeIn();
			}
		})

	});


	$('.tax-filter').click( function(event) {

		// Prevent defualt action - opening tag page
		if (event.preventDefault) {
			event.preventDefault();
		} else {
			event.returnValue = false;
		}

		// Get tag slug from title attirbute
		var selected_taxonomy = $(this).attr('title');
		var tax_type = $(this).parent();
		var selected_taxType = tax_type.attr('class');
		
		$('#articles-list').fadeOut();

		data = {
			action: 'filter_posts',
			afp_nonce: afp_vars.afp_nonce,
			taxonomy: selected_taxonomy,
			taxonomy_type : selected_taxType
		};
	
	
		$.ajax({
			type: 'GET',
			dataType: 'json',
			url: afp_vars.afp_ajax_url,
			data: data,
			success: function( data ) {

				$('#articles-list').html( data );
				$('#articles-list').fadeIn();
			
			},
			error: function( ) {

				$('#articles-list').html( 'No posts found' );
				$('#articles-list').fadeIn();
			}
		})

	});
	
	/**/
	
});