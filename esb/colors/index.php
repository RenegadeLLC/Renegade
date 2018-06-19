<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>

<style>

body{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	margin:0px;
	overflow:hidden;
}
#wrapper{
	border: 1px solid #DEDEDE;
	width:808px;
	overflow:hidden;
	margin:0px;
	padding:0px;
}

#main{
	display:block;
	position:relative;
	background:url(images/mainBk.png) no-repeat; 
	width: 762px;
	height: 573px;
	overflow:hidden;
	padding:40px 24px 0px 24px;
}


a{
	color: #2aadeb;
	text-decoration:none;
}

#header{
	background:url(images/header.png) no-repeat; width:810px; height:96px;
}

#headline{
	display:block;
	position:relative;
}

.link{
	position:absolute;
	left: 24px;
	bottom: 8px;
}

.colorBlock{

	float:left;
	padding-right:8px;
	
}

.row1{
	float:none;
	clear:both;
	display:block;
	position:relative;
	margin:40px 0px 0px 0px;
}

.row2{
	float:none;
	clear:both;
	display:block;
	position:relative;
	padding-top:24px;

}

</style>
</head>

<body>
<div id="wrapper">
<div id="header">


</div>

<div id="main">
<div id="headline"><img border="0" src="images/headline.png" alt="Introducing Our New Official Colors" /></div>

<div class="row1">
<img border="0" src="images/red_west.png" class="colorBlock" /><img border="0" src="images/orange_north.png" class="colorBlock" /><img border="0" src="images/yellow_south.png" class="colorBlock" /><img border="0" src="images/green_east.png" class="colorBlock" />
</div>

<div class="row2">
<img border="0" src="images/blue_north.png" class="colorBlock" /><img border="0" src="images/purple_north.png" class="colorBlock" /><img border="0" src="images/pink_south.png" class="colorBlock" />
</div>



<div class="link"><a href="http://www.esbnyc.com/current_events_tower_lights.asp" target="_blank">> View lighting schedule</a></div>

</div>
</div>

<script type="text/javascript">
window.fbAsyncInit = function () {
    FB.init({
        appId: '430058113742967', // App ID
        channelUrl: '/index.php', // Channel File
        status: true, // check login status
        cookie: true, // enable cookies to allow the server to access the session
        xfbml: true  // parse XFBML
    });
	 FB.Canvas.setSize({ height: 800 });
    FB.Canvas.setAutoGrow(true); //Resizes the iframe to fit content
};
// Load the SDK Asynchronously
(function (d) {
    var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
    if (d.getElementById(id)) { return; }
    js = d.createElement('script'); js.id = id; js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    ref.parentNode.insertBefore(js, ref);
} (document));
</script>



</body>
</html>
