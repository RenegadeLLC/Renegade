jQuery(document).ready(function($) {
	
	var selected_taxonomy = '';
	var selected_taxonomy_term = '';
	var selected_order = 'DESC';
	var selected_orderby = '';
	
	if(selected_orderby = ''){
	selected_orderby = 'date';
	}

	

//////LOAD MORE POSTS VIA AJAX/////////
	
	// The number of the next page to load (/page/x/).
	var pageNum;
	
	// The maximum number of pages the current query can return.
	var max;
	
	// The link of the next page of posts.
	var nextLink;
	var orderby;
	var order;
	var num_posts;
	var container;
	var selector;
	
	
	function add_load_more(pageNum, max){
	
	
		pageNum = parseInt(pbd_alp.startPage) + 1;
		max = parseInt(pbd_alp.maxPages);
		nextLink = pbd_alp.next_link;
		num_posts = pbd_alp.num_posts;
		container = pbd_alp.container;
		selector = pbd_alp.selector;
		orderby = pbd_alp.orderby;
		order = pbd_alp.order;
		
		if(pageNum <= max) {
		
			$('.pages-ct').append('<div id="load-more"><a href="">Load More</a></div>');

		} else{
			$('#load-more a').remove();
		} 
		
		/**
		 * Load new posts when the link is clicked.
		 */
		$('#load-more a').click(function(e) {
			  
			
			num_posts = num_posts;
			
			if (event.preventDefault) {
				event.preventDefault();
			} else {
				event.returnValue = false;
			}
				    
			if(pageNum <= max) {
			
				$.get( nextLink, function( data ){
						
					$(data).find('.thumb-ct').each(function(){
						var container = pbd_alp.container;
						var $container = $(container);
						var item = $(this);
						    // append elements to container
						    $container.append( item );
						      // add and lay out newly appended elements
						    $container.isotope( 'appended', item);
					} )
				return false;
				}
				
			);
				
			pageNum++;
			
			//generate new nextLink
			
			var trimLink = nextLink.split('page/', 1)[0];
			nextLink = trimLink + 'page/' + pageNum;
			//alert(nextLink);
			
			if(pageNum > max) {
				$('#load-more a').remove();
				}	
			} 
			
			return false;
		});
		
	
	}
	
	/////END LOAD MORE/////
	
	var metakey = '';
	var post_type = null;
	var $html;
	var $container;
	var year = '';
	
	var container = $('#container');
	var ch = $(container).height();
	var chp = ch + 'px';
	
	$(container).css({'height' : chp});
/*	$('.sort-option').click(function(event){
		// Prevent default action - opening tag page
		
		
		if (event.preventDefault) {
			event.preventDefault();
		} else {
			event.returnValue = false;
		}
		
		if(selected_taxonomy_term){
			selected_taxonomy_term = selected_taxonomy_term
		}else{
			selected_taxonomy_term = '';
		}
		
		if(selected_taxonomy){
			selected_taxonomy = selected_taxonomy
		}else{
			selected_taxonomy = '';
		}
		
		if(metakey){
			metakey = metakey;
		}else{
			metakey = ''
		}
		
		var selected_orderby = $(this).attr('title');
		var post_type = $(this).attr('type');

		publication = $(this).attr('publication');
		//selected_taxonomy=null;
		//selected_taxonomy_term=null;
	//	selected_taxonomy = selected_taxonomy;
	//	selected_taxonomy_term = selected_taxonomy_term;
		
		$('#container').fadeOut();
		
		if(selected_orderby == 'title'){
			selected_orderby = 'title';
			selected_order='ASC';
			metakey = metakey;
		}else if(selected_orderby == 'date'){
			selected_order = 'DESC';
			selected_orderby = 'date';
			metakey = metakey;
		}else if(selected_orderby == 'publication'){
			selected_order='ASC';
			selected_orderby = 'meta_value';
			metakey = 'publication';
		}
		
		data = {
				action: 'sort_posts',
				afp_nonce: afp_vars.afp_nonce,
				taxonomy_term: selected_taxonomy_term,
				taxonomy: selected_taxonomy,
				orderby: selected_orderby,
				order: selected_order,
				//	publication:publication,
				metakey: metakey,
				post_type:post_type
		};
		
		$.ajax({
			type: 'GET',
			url: afp_vars.afp_ajax_url,
			dataType: 'html',
			data: data,
			success: function( data ) {
				console.log(data);
				$html = $( data  );
				 	$('.post-grid').html( $html );
				 	$('#container').fadeIn();
			},
			error: function(MLHttpRequest, textStatus, errorThrown ) {
				alert(errorThrown);
				 console.log("AJAX error in request: " + JSON.stringify(errorThrown, null, 2));
		    
				$('#container').fadeIn();

			}
		})

	});*/
	
	$('.sort-option').click( function(event) {

		var thisSort = $(this);
		//var year = $('.year').attr('id');
		
		// Prevent defualt action - opening tag page
		if (event.preventDefault) {
			event.preventDefault();
		} else {
			event.returnValue = false;
		}
		
		$('.sort-option').each(function(){
			var sort = $(this);
			if($( this ).hasClass( "sort-on" )){
				$(this).toggleClass('sort-off sort-on');
			}
		})
		
		$(this).toggleClass('sort-off sort-on');
		  
		year = $(this).parent().attr('year');
		post_type = $(this).attr('type');
		selected_orderby = $(this).attr('title');
	
		if(selected_orderby == 'title'){
			selected_orderby = 'title';
			selected_order='ASC';
			metakey = '';
		}else if(selected_orderby == 'date'){
			selected_orderby = 'date';
			selected_order = 'DESC';
			metakey = '';
		}else if(selected_orderby == 'publication'){
			
			selected_orderby = 'meta_value';
			//selected_orderby = 'title';
			selected_order='ASC';
			metakey = 'ra_publication';
		} 
			if(!selected_taxonomy){
			//	selected_taxonomy = 'article_categories';
				selected_taxonomy = '';
			}
			
			if(!selected_taxonomy_term){
			//	selected_taxonomy_term = 'branding';
				selected_taxonomy_term = '';
			}
		
		$('#post-grid').fadeOut();

		data = {
			action: 'sort_posts',
			afp_nonce: afp_vars.afp_nonce,
			taxonomy_term: selected_taxonomy_term,
			taxonomy: selected_taxonomy,
			orderby: selected_orderby,
			order: selected_order,
			//	publication:publication,
			metakey: metakey,
			post_type:post_type,
			year:year
		};

	
		$.ajax({
			type: 'GET',
			dataType: 'html',
			url: afp_vars.afp_ajax_url,
			data: data,
			success: function( data ) {
				$html = $( data  );
			//alert(selected_orderby);
				$('.post-grid').html( $html );
				$('#post-grid').fadeIn();
				$(container).css({'height' : 'auto'});
				$('.sort-option').each(function(){
					var type = $(this).attr('title');
					if(type == selected_orderby){
						//$(this).toggleClass('sort-on sort-off');
					}
				});
			},
			error: function(MLHttpRequest, textStatus, errorThrown ) {
				alert(errorThrown);
				 console.log("AJAX error in request: " + JSON.stringify(errorThrown, null, 2));
		    
				$('#post-grid').fadeIn();
			//	$('#articles-list').html( 'No posts found' );
			//	$('#articles-list').fadeIn();
			}
		})

	});


	$('.filter-option').click( function(event) {

		// Prevent defualt action - opening tag page
		if (event.preventDefault) {
			event.preventDefault();
		} else {
			event.returnValue = false;
		}
		
		year = $(this).parent().attr('year');
		metakey = null;
		// Get tag slug from title attirbute
		selected_taxonomy_term = $(this).attr('title');
		parent_taxonomy = $(this).parent();
		selected_taxonomy = parent_taxonomy.attr('class');
		selected_order = selected_order;
		selected_orderby = selected_orderby;
		var post_type = $(this).attr('type');
		
	//	publication = $(this).attr('publication');
		
		if(selected_orderby == 'title'){
			selected_orderby = 'title';
			selected_order='ASC';
			metakey = null;
		}else if(selected_orderby == 'date'){
			selected_order = 'DESC';
			selected_orderby = 'date';
			metakey = null;
		}else if(selected_orderby == 'publication'){
			selected_order='ASC';
			selected_orderby = 'meta_value';
			metakey = 'publication';
		}
		
		
		$('#container').fadeOut();

		data = {
			action: 'filter_posts',
			afp_nonce: afp_vars.afp_nonce,
			taxonomy_term: selected_taxonomy_term,
			taxonomy: selected_taxonomy,
			orderby: selected_orderby,
			order: selected_order,
			//	publication:publication,
			metakey: metakey,
			post_type:post_type,
			year:year
		};
		
	
		$.ajax({
			type: 'GET',
			dataType: 'html',
			url: afp_vars.afp_ajax_url,
			data: data,
			success: function( data ) {
				$html = $( data  );
				$('.post-grid').html( $html );
				$('#container').fadeIn();
			},
			error: function(MLHttpRequest, textStatus, errorThrown ) {
				//alert(errorThrown);
				 console.log("AJAX error in request: " + JSON.stringify(errorThrown, null, 2));
		    
				$('#container').fadeIn();
			//	$('#articles-list').html( 'No posts found' );
			//	$('#articles-list').fadeIn();
			}
		})

	});
	
	/*var url = 'page.php';
   $.post(url, { class: myClass })*/
	
});

/************************************ AJAX COMPLETE FUNCTION ************************************/

$( document ).ajaxComplete(function( ) {
	
	var container = $('.post-grid');
	var ch = $(container).height();
	var chp = ch + 'px';
	

	
	$(container).css({'height' : chp});
	
	/*	var elements = $('.post-grid-item');
	$('.post-grid').isotope( 'appended', elements )
		*/
	$('.post-grid').isotope({
		// options
		itemSelector: '.post-grid-item',
		gutter: '.post-grid-gutter',
		percentPosition: true,
	});
	

	$('.post-grid').imagesLoaded( function() {
		//$('.post-grid').isotope('layout');	
		//$('.post-grid').isotope( 'appended', '.post-grid-item');
		var elements = $('.post-grid-item');
		$('.post-grid').isotope( 'appended', elements )
	});

	
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
