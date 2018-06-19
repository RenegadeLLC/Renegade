// JavaScript Document

//STRIP THE DATES OUT OF SOCIAL MEDIA ROUND UP ENTRIES

$(function(){

var title = $('a.blog-title-ct').html();

var grouped_title = $('a.blog-title-ct:contains(Social News Roundup)');

//$('a.blog-title-ct:contains(Social News Roundup)').css({'background-color' : 'yellow'})
$(grouped_title).html('Social News Roundup');
});



