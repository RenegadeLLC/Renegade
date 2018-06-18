jQuery(document).ready(function($) {
	
	var selected_taxonomy=null;
	var selected_taxonomy_term=null;
	var selected_order=null;
	var selected_orderby=null;
	var $html;
	var $container;
	
	$('.sort-option').click(function(event){
		// Prevent defualt action - opening tag page
		
		
		if (event.preventDefault) {
			event.preventDefault();
		} else {
			event.returnValue = false;
		}
		var selected_orderby = $(this).attr('orderby');
		selected_taxonomy = selected_taxonomy;
		selected_taxonomy_term = selected_taxonomy_term;
		$('#articles-list').fadeOut();
		
		if(selected_orderby == 'title'){
			selected_order='ASC';
		}else{
			selected_order = selected_order;
		}
		
		data = {
				action: 'sort_posts',
				afp_nonce: afp_vars.afp_nonce,
				taxonomy:selected_taxonomy,
				taxonomy_term:selected_taxonomy_term,
				order:selected_order,
				orderby:selected_orderby,
			};
		
		$.ajax({
			type: 'POST',
			url: afp_vars.afp_ajax_url,
			dataType: 'json',
			data: data,
			success: function( data ) {
				//console.log(data.taxonomy_term);
				$html = $( data  );
				 	$('.grid').html( $html );
					var elements = $('.grid-item');
				 	$('.grid').append( elements )
				 		
				$('#articles-list').fadeIn();
			},
			error: function(MLHttpRequest, textStatus, errorThrown ) {
				alert(errorThrown);
				console.log(data)
				$('#articles-list').fadeIn();
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
		selected_order = selected_order;
		selected_orderby = selected_orderby;
		
		$('#articles-list').fadeOut();

		data = {
			action: 'filter_posts',
			afp_nonce: afp_vars.afp_nonce,
			taxonomy_term: selected_taxonomy_term,
			taxonomy: selected_taxonomy,
			orderby: selected_orderby,
			order: selected_order,
		};

	
		$.ajax({
			type: 'GET',
			dataType: 'json',
			url: afp_vars.afp_ajax_url,
			data: data,
			success: function( data ) {
				$html = $( data  );
			 	$('.grid').html( $html);
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

/************************************ AJAX COMPLETE FUNCTION ************************************/

$( document ).ajaxComplete(function( ) {
	
	var elements = $('.grid-item');
	$('.grid').isotope( 'appended', elements )

	
//	$('.grid').isotope('layout');
	/*
	  $('.grid').isotope({
			 percentPosition: true,
			//  layoutMode: 'packery',
		    layoutMode: 'masonry',
		    itemSelector: '.grid-item',
		 //   packery: {
		  masonry: {
		      gutter: '.grid-gutter'
		      }
		  });
		  
*/
});
