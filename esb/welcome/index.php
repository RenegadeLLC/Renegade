<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Welcome to the Empire State Building</title>

<link type="text/css" rel="stylesheet" href="../esb_fonts.css" />

<style>

	body{
		margin:0;
		font-family: 'ProximaNova-Regular', sans-serif;
		font-size:19px;
		color:#000000;
		line-height:128.5%;
		overflow:hidden;
		text-align: center;
	}
	
	a{
		color:#ffffff;
		cursor:pointer;
		text-decoration: none;
	}
	
	.bold{
		font-family: 'ProximaNova-Bold', sans-serif;
	}
	
	.main{
		background:url(images/ESB_Welcome_background.jpg) no-repeat;
		height:1300px;
		width:810px;
	}
	
	.content-wrapper{
		height:100%;
		overflow: hidden;
		position: relative;
		width:100%;
	}
	
	.content-inner{
		padding:24px;
	}
	
	.content-section{
		background:url(images/goldBand01.jpg) no-repeat bottom;
		color:#ffffff;
		font-size:16px;
		height:232px;
		line-height: 110%;
		overflow: hidden;
		text-align: center;
		text-shadow:2px 2px #857326;
		width:405px;
	}
	
	.content-section:last-of-type{
	
		height:240px;

	}
	
	.content-section img{
		clear:both;
		display: block;
		margin:0 auto;
	}
	
	.content-section-bottom{
		background:url(images/goldBand02.jpg) no-repeat bottom;
		bottom:0px;
		color:#ffffff;
		font-size:28px;
		height:114px;
		line-height: 140%;
		overflow: hidden;
		padding:48px 0 0 0;
		position: absolute;
		text-align: center;
		text-shadow:2px 2px #857326;
		width:405px;
	}
	
	
	
	.fleft{
		float:left;
	}
	
	.fright{
		float:right;
	}
	
	.w-50{
		width:50%;
	}
	
</style>
</head>

<body>
<div class="main">
	<div class="content-wrapper">
		<div class="fright w-50">
			<div class="content-inner">
				<img src="images/welcome_to.png" alt="Welcome to the world’s most famous building">
				
				<p style="padding:0 20px;">
				Welcome to the Empire State Building’s official Facebook page! Like this page to learn about our nightly tower lightings, special ticket offers, celebrity visitors, contests and daily happenings at the most iconic landmark in New York City.
				</p>
				
				<p style="padding:0 20px;">
				Feel free to post comments, share your favorite photos and check out inspiring photos taken by others.</p>
				<p style="padding:0 20px;">
				We hope you enjoy the view!
				</p>
			</div><!--  .content-inner -->
			<div class="content-section">
				<div class="content-inner">
					<div class="fleft w-50"><a href="http://www.facebook.com/empirestatebuilding" target="_blank"><img src="images/post_photos.png" alt="Post Photos">Post your best<br>photos of the Empire<br>State Building</a></div>
					<div class="fright w-50"><a href="http://www.esbnyc.com/buy_tickets.asp" target="_blank"><img src="images/buy_tickets.png" alt="Buy Tickets">Buy tickets</a></div>
				</div><!--  .content-inner -->
			</div><!-- .content-section -->
			
			<div class="content-section">
				<div class="content-inner">
					<div class="fleft w-50"><a href="http://www.esbnyc.com/current_events_tower_lights.asp" target="_blank"><img src="images/lighting_schedule.png" alt="Lighting Schedule">Check out our tower lighting schedule</a></div>
					<div class="fright w-50"><a href="http://store.empirestatebuildinggifts.com/" target="_blank"><img src="images/book.png" alt="Souvenir Book">Shop our<br>online store</a></div>
				</div><!--  .content-inner -->
			</div><!-- .content-section -->
			
			<div class="content-section-bottom">
				<a href="http://esbnyc.com" target="_blank" class="bold">www.esbnyc.com</a><br>
Open daily until 2AM
			</div><!-- .content-section-bottom -->
			
			
		</div><!-- .fright .w-50 -->
	</div><!-- .content-wrapper -->
</div><!-- .main -->

<script type="text/javascript">
window.fbAsyncInit = function () {
    FB.init({
        appId: '241690039268179', // App ID
        channelUrl: '/index.php', // Channel File
        status: true, // check login status
        cookie: true, // enable cookies to allow the server to access the session
        xfbml: true  // parse XFBML
    });
	 FB.Canvas.setSize({ height: 2850 });
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
