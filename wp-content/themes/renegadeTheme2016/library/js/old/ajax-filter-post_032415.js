jQuery(document).ready(function($) {
	
	var selected_taxonomy=null;
	var selected_taxonomy_term=null;
	var selected_order=null;
	var selected_orderby=null;
	
	
	$('.sort-option').click(function(event){
		// Prevent defualt action - opening tag page
		
		
		if (event.preventDefault) {
			event.preventDefault();
		} else {
			event.returnValue = false;
		}
		var selected_orderby = $(this).attr('orderby');
		alert( selected_orderby );

	//alert(selected_sort);
		data = {
				action: 'sort_posts',
				afp_nonce: afp_vars.afp_nonce,
				//sort:selected_sort,
				taxonomy:selected_taxonomy,
				taxonomy_term:selected_taxonomy_term,
				order:selected_order,
				orderby:selected_orderby,
				//query: afp_vars.query,
			};
		
		$.ajax({
			type: 'POST',
			url: afp_vars.afp_ajax_url,
			//dataType: 'json',
			data: data,
			success: function( data ) {
				console.log(data)
				$('#articles-list').html( 'yes' );
				$('#articles-list').html( data );
				$('#articles-list').fadeIn();
			},
			error: function(MLHttpRequest, textStatus, errorThrown ) {
				alert(errorThrown);
				console.log(data)
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
		selected_taxonomy_term = $(this).attr('title');
		parent_taxonomy = $(this).parent();
		selected_taxonomy = parent_taxonomy.attr('class');
		
		$('#articles-list').fadeOut();

		data = {
			action: 'filter_posts',
			afp_nonce: afp_vars.afp_nonce,
			taxonomy: selected_taxonomy_term ,
			taxonomy_type : selected_taxonomy
			
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
	
	/*var url = 'page.php';
   $.post(url, { class: myClass })*/
	
});