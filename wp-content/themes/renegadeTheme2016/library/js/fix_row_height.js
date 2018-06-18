// JavaScript Document

$(document).ready(function() {

	$('.aBottom')
	
	
//GET THE HEIGHT OF THE GRID CONTAINED WITHIN THE ROW
/*
var section_row = $('.row');
var grid = $('.grid')
var section_height = 0;



$(section_row).each(function(){
	var section_height = 0;
	var grid_height = 0;
	var grids = $(this).children(grid);
	var hp;
	
	$(grids).each(function(){		
		grid_height = $(this).height();
		section_height = section_height + grid_height;
	})
	
	hp = section_height + 'px';
	$('.row').css({'height': hp })
	alert(grid_height);
	
	
})


*/
	var section_row = $('.row');
	
	$(section_row).each(function(){
		var section_height = $(this).height();
		alert(section_height);
		/*var section_grid = $(this).children('.grid');
		var grid_height = 0;
		var section_height = 0;
		
			$('.grid').each(function(){
				var grid_height = $(this).height();
				section_height = section_height + grid_height;
		
			});
			*/
		
	});

});

$(window).resize(function() {

});

