// JavaScript Document

$(document).ready(function() {

//GET THE HEIGHT OF THE HIGHLIGHT BOX AND DIVDE BY HALF TO FIND CAP BORDER WIDTH
var subnv_w = $('.subnav').width();

var bhp = bh + 'px';



$('.highlight').next('.highlight-cap').css({'border-width' : bhp});

//GET THE WIDTH OF THE HIGHLIGHT CAP AND SET HIGHLIGHT WIDTH TO REMAINDER
var ctWidth = $('.highlight-ct').width();
var capWidth = h;
var highMax = ctWidth - capWidth - 10;
var highMaxp = highMax + 'px';

$('.highlight').css({'max-width' : highMaxp});

});


$(window).resize(function() {
  $('#log').append('<div>Handler for .resize() called.</div>');var h = $('.highlight').height();

  
var bh = h * .5;
var bhp = bh + 'px';
$('.highlight').next('.highlight-cap').css({'border-width' : bhp});

$('#log').append('<div>Handler for .resize() called.</div>');var ctWidth = $('.highlight-ct').width();
$('#log').append('<div>Handler for .resize() called.</div>');var capWidth = bh;
var ctWidth = $('.highlight-ct').width();
var capWidth = h;
var highMax = ctWidth - capWidth;
var highMaxp = highMax + 'px';
$('.highlight').css({'max-width' : highMaxp});


});


