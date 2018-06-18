	
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
	
	jQuery(document).ready(function($) {

		var saved_filters = localStorage.getItem('selected_filters');
		//  alert(saved_filters);
	
	/**
	 * Replace the traditional navigation with our own,
	 * but only if there is at least one page of new posts to load.
	 */
		
	var $loadMore = ('#load-more');
	
	if ($('#load-more').length > 0) { 
		
	} else{
		add_load_more(pageNum, max);
	}
	
	
	




});

function lm_lazy_load(){

	var $thumb_height = pbd_alp.thumb_height; 
	
	$(".lazy").bttrlazyloading({
		
		xs: {
		//	src: "img/720x200.gif",
			//width: 200,
			//height: 267
		},
		sm: {
		//	src: "img/360x200.gif",
			//width: 378,
			height: $thumb_height
		},
		md: {
		//	src: "img/470x200.gif",
			//width: 378,
			//height: 378
		},
		lg: {
		//	src: "img/347x489.gif",
			//width: 2700,
			//height: 3600
		},
		//retina: true,
		animation: 'fadeIn',
		delay: 1000,
		event: 'scroll',
		triggermanually: false,
		//container: 'document.body',
		//threshold: 666,
		//placeholder:'<?php echo(get_template_directory_uri() . '/library/images/loading.gif');?>',
		backgroundcolor: '#ffffff'

			
	})
	}


$( document ).ajaxComplete(function() {

	var container = pbd_alp.container;
	var $container = $(container);
	var $selector = pbd_alp.selector;
	
	$container.isotope({
		// options
		itemSelector: $selector,
		layoutMode: 'masonry',
		masonry: {
		    columnWidth: '.grid-sizer',
		    gutter: 32,
		  },
		  
		percentPosition: true,

		});
	
	lm_lazy_load()
	
	$container.imagesLoaded( function() {
		$container.isotope('layout');
		var $product_names = $('.product-thumb-name');
		if($product_names){
			TweenLite.to($product_names, 2, {opacity:1, ease:Power2.easeOut, delay:1.5});
		}
		
	});

	
});


