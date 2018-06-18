jQuery(function($){


	$('.post-listing').append( '<span class="load-more">HELLOOOOO</span>' );

	var button = $('.post-listing .load-more');
	var page = 2;
	var loading = false;
	var scrollHandling = {
	    allow: true,
	    reallow: function() {
	        scrollHandling.allow = true;
	    },
	    delay: 400 //(milliseconds) adjust to the highest acceptable value
	};

	$(window).scroll(function(){
		
		if( ! loading && scrollHandling.allow ) {
			scrollHandling.allow = false;
			setTimeout(scrollHandling.reallow, scrollHandling.delay);
			var offset = $(button).offset().top - $(window).scrollTop();
			if( 2000 > offset ) {
				
				loading = true;
				var data = {
					action: 'be_ajax_load_more',
					page: page,
					query: beloadmore.query,
				};
				$.post(beloadmore.url, data, function(res) {
					if( res.success) {
						$('.post-listing').append( res.data );
						$('.post-listing').append( button );
						page = page + 1;
						loading = false;
						
					} else {
						
						 console.log(res);
					}
				}).fail(function(xhr, textStatus, e) {
					 console.log(xhr.responseText);
				});

			}
		}
	});
});