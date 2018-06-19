<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>My Empire State Building Photo Contest</title>

	<!-- Add jQuery library -->
	<script type="text/javascript" src="_js/lib/jquery-1.8.2.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="_js/lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="_js/jquery.fancybox.js?v=2.1.3"></script>
	<link rel="stylesheet" type="text/css" href="_js/jquery.fancybox.css?v=2.1.2" media="screen" />

	<!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="_js/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<script type="text/javascript" src="_js/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

	<!-- Add Thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="_js/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="_js/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="_js/helpers/jquery.fancybox-media.js?v=1.0.5"></script>


<style>

body{margin: 0px; overflow:hidden;}
.main{display:block; position:relative; width:810px; height:auto; background:#0078B7; padding:24px; margin:0px; font-family:Arial, Helvetica, sans-serif; overflow:hidden;}
.blue{color:#0078B7;}
.hdr{display:block; position:relative; background:url(_img/header.png) no-repeat center; width:771px; height:72px; text-align:center;}

#grandPrize{display:block; position:relative; width:714px; height:572px; background:#0F6191; padding:24px 24px 0px 24px; border-top:8px solid #FF9900; margin:20px 0px 0px 0px;}

#grandPrizeLeft{display:inline-block; position:relative;  float:left; width:295px; height:inherit; background:url(_img/silhouette.png) no-repeat bottom left;}

.congratsHd{background:url(_img/hd_congratulations.png) no-repeat; width:291px; height:67px; margin:4px 0px 0px 0px;}
.congratsTxt{color:#FFFFFF; font-size:20px; font-weight:lighter; line-height:160%; margin:8px 0px 0px 0px;}

#grandPrizeRight{display:inline-block; position:relative;  float:right; width:419px; height:auto; text-align:right;}

.heroImg{position:relative; display: block; width:342px; height:472px; background:url(_img/img_hero.jpg) no-repeat center #FFFFFF; padding:8px; margin: 4px 0px 0px 61px;}

.heroInfo{display:block; position:relative; width:342px; height:48px; padding: 0px 8px 8px 8px; margin: 0px 0px 0px 61px; text-align:left; background:#FFFFFF; }
.heroCaption{font-size:20px; color:#FF9900;  float:left; display:inline-block;}

.heroEnlarge{display:inline-block; float:right;}

.ribbon{position:absolute; top:0px; left:0px; background:url(_img/ribbon.png) no-repeat; width:137px; height:260px;}

#finalists{display:block; position:relative; width:714px; height:auto; background:#0F6191; padding:24px; margin:24px 0px 0px 0px;}

.hd_finalists{background:url(_img/hd_congratsFinalists.png) no-repeat center; width:713px; height:31px;}

.navFinalists{display:block; position:relative; border-top:8px solid #FF9900; border-bottom:2px solid #FF9900; width:714px; height:32px; margin:16px 0px; padding:8px 0px 0px 0px; clear:both;}

.instructions{display:inline-block; position:relative; float:left; font-size:14px; color:#FFFFFF;}
.navCt{display:inline-block; position:relative; float:right; margin:4px 0px 0px 0px;}

.navBtOn{display:inline-block; width:18px; height:14px; font-size:12px; color:#FF9900; background:#FFFFFF; text-align:center; margin: 0px 0px 0px 6px; padding:2px 0px; cursor:pointer;}

.navBt{display:inline-block; width:18px; height:14px; font-size:12px; color:#FFFFFF; background:#FF9900;  text-align:center; margin: 0px 0px 0px 6px; padding:2px 0px; cursor:pointer;}



.arrowBox{display:inline-block; width:18px; height:14px; font-size:12px; color:#FFFFFF; text-decoration:none; text-align:center; border: 1px solid #FF9900; margin: 0px 0px 0px 6px; padding:2px 0px; background:#0F6191; cursor:pointer}



.entryRow{display:block; position:relative; width:714px; height:250px; margin:8px 0px 0px 0px;}

.thumb{margin:0px 0px 8px 0px;}
.entryCt{display:block; position:relative; float:left; width:156px; height:234px; background:#FFFFFF; padding:8px; color:#FF9900; font-size:14px; margin:0px 8px 0px 0px;}
.entryCtLast{display:block; position:relative; float:left; width:156px; height:234px; background:#FFFFFF; padding:8px; color:#FF9900; font-size:14px; margin:0px;}
.bt_enlarge{display:block; position:absolute; top:0px; left:0px; width:32px; height:32px; background:#FFFFFF; padding:4px 0px 0px 4px;}

.pageOn{display:block;}
.pageOff{display:none;}

.arrowOn{visibility:visible;}
.arrowOff{visibility:hidden;}

.fancybox-wrap{
margin-top:auto !important;
margin-bottom: auto !important;
}

</style>

</head>

<body>
<div class="main">
<div class="hdr"></div>

<div id="grandPrize">
<div id="grandPrizeLeft">
<div class="congratsHd"></div>
<div class="congratsTxt">The Empire State Building congratulates Rafael Paez on winning the My Empire State Building Photo Contest!
</div>

</div><!--END GRAND PRIZE LEFT COLUMN-->

<div id="grandPrizeRight">
<div class="heroImg"></div><div class="heroInfo"><div class="heroEnlarge"><a class="fancybox-effects-a" href="_img/photos/RafaelPaez.jpg" data-fancybox-group="gallery" title="The Empire State Front View"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div><div class="heroCaption">Empire State Front View<br />
<span class="blue">by Rafael Paez</span></div></div><div class="ribbon"></div>


</div><!--END GRAND PRIZE DIV RIGHT COLUMN-->
</div><!--END GRANDPRIZE DIV-->

<div id="finalists">
<div class="hd_finalists"></div>
<div class="navFinalists">
<div class="instructions"><img border="0" src="_img/btEnlargeSm.png" align="absmiddle" /> Click to enlarge</div>
<div class="navCt">
<div class="arrowBox arrowOff arrowPrev" id="arrowPrev"><</div><div class="navBtOn btn1" id="btn1">1</div><div class="navBt btn2" id="btn2">2</div><div class="navBt btn3" id="btn3">3</div><div class="navBt btn4" id="btn4">4</div><div class="arrowBox arrowNext" id="arrowNext">></div>
</div><!--END NAV CT DIV-->
</div><!--END FINALISTS NAV DIV-->

<div id="page1" class="pageOn">

<!--BEGIN ENTRY ROW 1-->
<div class="entryRow">
<div class="entryCt"><img border="0" src="_img/thumbs/DeniseAcker.jpg" alt="Denise Acker" class="thumb" /><div class="blue">Capturing an Icon</div>
by Denise Acker</span><div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/DeniseAcker.jpg" data-fancybox-group="gallery" title="Capturing an Icon by Denise Acker"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/TimAdams.jpg" alt="Tim Adams" class="thumb" /><div class="blue">
Empirical Edifice
</div>by Tim Adams<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/TimAdams.jpg" data-fancybox-group="gallery" title="Empirical Edifice by Tim Adams"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/CarolinaAguilera.jpg" alt="Carolina Aguilera" class="thumb" />
<div class="blue">Empire Magic</div>
by Carolina Aguilera<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/CarolinaAguilera.jpg" data-fancybox-group="gallery" title="Empire Magic by Carolina Aguilera"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCtLast"><img border="0" src="_img/thumbs/RachelAlban.jpg" alt="Rachel Alban" class="thumb" /><div class="blue">Big Lights Will Inspire You</div>
by Rachel Alban<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/RachelAlban.jpg" data-fancybox-group="gallery" title="Big Lights Will Inspire You by Rachel Alban"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

</div><!--END ENTRY ROW 1-->


<!--BEGIN ENTRY ROW 2-->
<div class="entryRow">
<div class="entryCt"><img border="0" src="_img/thumbs/JasonAlicea.jpg" alt="Jason Alicea" class="thumb" /><div class="blue">The Empire from Brooklyn</div>
by Jason Alicea</span><div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/JasonAlicea.jpg" data-fancybox-group="gallery" title="The Empire from Brooklyn
by Jason Alicea"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/CarollAlvarado.jpg" alt="Caroll Alvarado" class="thumb" /><div class="blue">
Nothing Like the Empire State</div>
by Caroll Alvarado<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/CarollAlvarado.jpg" data-fancybox-group="gallery" title="Nothing Like the Empire State
by Caroll Alvarado"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/AlexanderAsimi.jpg" alt="Alexander Asimi" class="thumb" />
<div class="blue">An Empire Window</div>
by Alexander Asimi<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/AlexanderAsimi.jpg" data-fancybox-group="gallery" title="An Empire Window
by Alexander Asimi"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCtLast"><img border="0" src="_img/thumbs/KamranAslam.jpg" alt="Kamran Aslam" class="thumb" /><div class="blue">Empire State Space Ship</div>
by Kamran Aslam<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/KamranAslam.jpg" data-fancybox-group="gallery" title="Empire State Space Ship
by Kamran Aslam"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

</div><!--END ENTRY ROW 2-->


<!--BEGIN ENTRY ROW 3-->
<div class="entryRow">
<div class="entryCt"><img border="0" src="_img/thumbs/LeslieBliss.jpg" alt="Leslie Bliss" class="thumb" /><div class="blue">On Top of the World</div>
by Leslie Bliss</span><div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/LeslieBliss.jpg" data-fancybox-group="gallery" title="On Top of the World
by Leslie Bliss"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/BarbaraBorghesi.jpg" alt="Barbara Borghesi" class="thumb" /><div class="blue">
The Lobby Ground Floor</div>
by Barbara Borghesi<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/BarbaraBorghesi.jpg" data-fancybox-group="gallery" title="The Lobby Ground Floor
by Barbara Borghesi"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/EmilyCafritz.jpg" alt="Emily Cafritz" class="thumb" />
<div class="blue">Breaking Clouds</div>
by Emily Cafritz<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/EmilyCafritz.jpg" data-fancybox-group="gallery" title="Breaking Clouds
by Emily Cafritz"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCtLast"><img border="0" src="_img/thumbs/CassieCarter.jpg" alt="Cassie Carter" class="thumb" /><div class="blue">White Empire
</div>by Cassie Carter<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/CassieCarter.jpg" data-fancybox-group="gallery" title="White Empire
by Cassie Carter"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

</div><!--END ENTRY ROW 3-->

</div><!--END PAGE 1 DIV-->

<div id="page2" class="pageOff">

<!--BEGIN ENTRY ROW 1-->
<div class="entryRow">
<div class="entryCt"><img border="0" src="_img/thumbs/AlexanderCerna.jpg" alt="Alexander Cerna" class="thumb" /><div class="blue">New Yorker Empire State Building</div>
by Alexander Cerna</span><div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/AlexanderCerna.jpg" data-fancybox-group="gallery" title="New Yorker Empire State Building by Alexander Cernar"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/RichardCleves.jpg" alt="Richard Cleves" class="thumb" /><div class="blue">
Empire State Lego Building
</div>by Richard Cleves<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/RichardCleves.jpg" data-fancybox-group="gallery" title="Empire State Lego Building by Richard Cleves"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/AmberCollins.jpg" alt="Amber Collins" class="thumb" />
<div class="blue">The Calm Before the Storm</div>
by Amber Collins<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/AmberCollins.jpg" data-fancybox-group="gallery" title="The Calm Before the Storm by Amber Collins"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCtLast"><img border="0" src="_img/thumbs/ChelseaConner.jpg" alt="Chelsea Conner" class="thumb" /><div class="blue">Let's Set the World on Fire</div>
by Chelsea Conner<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/ChelseaConner.jpg" data-fancybox-group="gallery" title="Let's Set the World on Fire by Chelsea Conner"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

</div><!--END ENTRY ROW 1-->


<!--BEGIN ENTRY ROW 2-->
<div class="entryRow">
<div class="entryCt"><img border="0" src="_img/thumbs/DeShaunCraddock.jpg" alt="DeShaun Craddock" class="thumb" /><div class="blue">Imperial</div>
by DeShaun Craddock</span><div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/DeShaunCraddock.jpg" data-fancybox-group="gallery" title="Imperial
by DeShaun Craddock"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/RyanCrane.jpg" alt="Ryan Crane" class="thumb" /><div class="blue">
Greeley Square</div>
by Ryan Crane<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/RyanCrane.jpg" data-fancybox-group="gallery" title="Greeley Square
by Ryan Crane"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/HeatherEllis.jpg" alt="Heather Ellis" class="thumb" />
<div class="blue">Don't Wanna Go!</div>
by Heather Ellis<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/HeatherEllis.jpg" data-fancybox-group="gallery" title="Don't Wanna Go!
by Heather Ellis"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCtLast"><img border="0" src="_img/thumbs/DavidFormichella.jpg" alt="David Formichella" class="thumb" /><div class="blue">Closer to Heaven</div>
by David Formichella<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/DavidFormichella.jpg" data-fancybox-group="gallery" title="Closer to Heaven
by David Formichella"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

</div><!--END ENTRY ROW 2-->


<!--BEGIN ENTRY ROW 3-->
<div class="entryRow">
<div class="entryCt"><img border="0" src="_img/thumbs/ReginaGeoghan.jpg" alt="Regina Geoghan" class="thumb" /><div class="blue">New York in Gold</div>
by Regina Geoghan</span><div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/ReginaGeoghan.jpg" data-fancybox-group="gallery" title="New York in Gold
by Regina Geoghan"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/LydibertoGonzalez.jpg" alt="Lydiberto Gonzalez" class="thumb" /><div class="blue">
The Empire</div>
by Lydiberto Gonzalez<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/LydibertoGonzalez.jpg" data-fancybox-group="gallery" title="The Empire
by Lydiberto Gonzalez"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/JamieGreene.jpg" alt="Jamie Greene" class="thumb" />
<div class="blue">Neon Skyline</div>
by Jamie Greene<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/JamieGreene.jpg" data-fancybox-group="gallery" title="Neon Skyline
by Jamie Greene"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCtLast"><img border="0" src="_img/thumbs/ReetomHazarika.jpg" alt="Reetom Hazarika" class="thumb" /><div class="blue">Standing Tall Among All
</div>by Reetom Hazarika<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/ReetomHazarika.jpg" data-fancybox-group="gallery" title="Standing Tall Among All
by Reetom Hazarika"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

</div><!--END ENTRY ROW 3-->

</div><!--END PAGE 2 DIV-->


<div id="page3" class="pageOff">

<!--BEGIN ENTRY ROW 1-->
<div class="entryRow">
<div class="entryCt"><img border="0" src="_img/thumbs/ShaunJones.jpg" alt="Shaun Jones" class="thumb" /><div class="blue">The Empire State Building</div>
by Shaun Jones</span><div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/ShaunJones.jpg" data-fancybox-group="gallery" title="The Empire State Building by Shaun Jones"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/KevinKoepke.jpg" alt="Kevin Koepke" class="thumb" /><div class="blue">
The Empire State Building…Picture Perfect!
</div>by Kevin Koepke<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/KevinKoepke.jpg" data-fancybox-group="gallery" title="The Empire State Building…Picture Perfect! by Kevin Koepke"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/DanielKoszegi.jpg" alt="Daniel Koszegi" class="thumb" />
<div class="blue">With Lightning</div>
by Daniel Koszegi<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/DanielKoszegi.jpg" data-fancybox-group="gallery" title="With Lightning by Daniel Koszegi"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCtLast"><img border="0" src="_img/thumbs/KevinLandrigan.jpg" alt="Kevin Landrigan" class="thumb" /><div class="blue">Celebrating the Empire State Building</div>
by Kevin Landrigan<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/KevinLandrigan.jpg" data-fancybox-group="gallery" title="Celebrating the Empire State Building by Kevin Landrigan"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

</div><!--END ENTRY ROW 1-->


<!--BEGIN ENTRY ROW 2-->
<div class="entryRow">
<div class="entryCt"><img border="0" src="_img/thumbs/DixieLopez.jpg" alt="Dixie Lopez" class="thumb" /><div class="blue">My Empire State of Mine</div>
by Dixie Lopez</span><div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/DixieLopez.jpg" data-fancybox-group="gallery" title="My Empire State of Mine
by Dixie Lopez"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/YvonneLundin.jpg" alt="Yvonne Lundin" class="thumb" /><div class="blue">
Christmas at the Empire State Building</div>
by Yvonne Lundin<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/YvonneLundin.jpg" data-fancybox-group="gallery" title="Christmas at the Empire State Building
by Yvonne Lundin"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/KeithMooney.jpg" alt="Keith Mooney" class="thumb" />
<div class="blue">A Different View</div>
by Keith Mooney<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/KeithMooney.jpg" data-fancybox-group="gallery" title="A Different View
by Keith Mooney"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCtLast"><img border="0" src="_img/thumbs/JenniferOwens.jpg" alt="Jennifer Owens" class="thumb" /><div class="blue">Night View <3</div>
by Jennifer Owens<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/JenniferOwens.jpg" data-fancybox-group="gallery" title="Night View <3
by Jennifer Owens"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

</div><!--END ENTRY ROW 2-->


<!--BEGIN ENTRY ROW 3-->
<div class="entryRow">
<div class="entryCt"><img border="0" src="_img/thumbs/GerardPadden.jpg" alt="Gerard Padden" class="thumb" /><div class="blue">The Apple of the Eye</div>
by Gerard Padden</span><div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/GerardPadden.jpg" data-fancybox-group="gallery" title="The Apple of the Eye
by Gerard Padden"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/JosePagan.jpg" alt="Jose Pagan" class="thumb" /><div class="blue">
In the Heights</div>
by Jose Pagan<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/JosePagan.jpg" data-fancybox-group="gallery" title="In the Heights
by Jose Pagan"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/StephenPapageorge.jpg" alt="Stephen Papageorge" class="thumb" />
<div class="blue">Black & White Empire State</div>
by Stephen Papageorge<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/StephenPapageorge.jpg" data-fancybox-group="gallery" title="Black & White Empire State
by Stephen Papageorge"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCtLast"><img border="0" src="_img/thumbs/BillPellegrino.jpg" alt="Bill Pellegrino" class="thumb" /><div class="blue">The Building to Infinity
</div>by Bill Pellegrino<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/BillPellegrino.jpg" data-fancybox-group="gallery" title="The Building to Infinity
by Bill Pellegrino"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

</div><!--END ENTRY ROW 3-->

</div><!--END PAGE 3 DIV-->

<div id="page4" class="pageOff">

<!--BEGIN ENTRY ROW 1-->
<div class="entryRow">
<div class="entryCt"><img border="0" src="_img/thumbs/GinnettePolanco.jpg" alt="Ginnette Polanco" class="thumb" /><div class="blue">The Happy Hour with an Amazing View, Empire State of Mind</div>
by Ginnette Polanco</span><div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/GinnettePolanco.jpg" data-fancybox-group="gallery" title="Happy Hour with an Amazing View, Empire State of Mind by Ginnette Polanco"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/KiritPrajapati.jpg" alt="Kirit Prajapati" class="thumb" /><div class="blue">
High Voltage on Empire State
</div>by Kirit Prajapati<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/KiritPrajapati.jpg" data-fancybox-group="gallery" title="High Voltage on Empire State by Kirit Prajapati"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/MichelleSager.jpg" alt="Michelle Sager" class="thumb" />
<div class="blue">The Old, the New & the ESB</div>
by Michelle Sager<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/MichelleSager.jpg" data-fancybox-group="gallery" title="The Old, the New & the ESB"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCtLast"><img border="0" src="_img/thumbs/RafaelSantana.jpg" alt="Rafael Santana" class="thumb" /><div class="blue">Glass the Empire</div>
by Rafael Santana<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/RafaelSantana.jpg" data-fancybox-group="gallery" title="Glass the Empire by Rafael Santana"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

</div><!--END ENTRY ROW 1-->


<!--BEGIN ENTRY ROW 2-->
<div class="entryRow">
<div class="entryCt"><img border="0" src="_img/thumbs/BradSloan.jpg" alt="Brad Sloan" class="thumb" /><div class="blue">Empire State of Mind</div>
by Brad Sloan</span><div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/BradSloan.jpg" data-fancybox-group="gallery" title="Empire State of Mind
by Brad Sloan"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/ChristyStaton.jpg" alt="Christy Staton" class="thumb" /><div class="blue">
ESB at Twilight</div>
by Christy Staton<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/ChristyStaton.jpg" data-fancybox-group="gallery" title="ESB at Twilight
by Christy Staton"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/LisaThomas.jpg" alt="Lisa Thomas" class="thumb" />
<div class="blue">Empire State Building from the Ground Up!</div>
by Lisa Thomas<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/LisaThomas.jpg" data-fancybox-group="gallery" title="Empire State Building from the Ground Up!
by Lisa Thomas"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCtLast"><img border="0" src="_img/thumbs/StevenTom.jpg" alt="Steven Tom" class="thumb" /><div class="blue">Looking Up</div>
by Steven Tom<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/StevenTom.jpg" data-fancybox-group="gallery" title="Looking Up 
by Steven Tom"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

</div><!--END ENTRY ROW 2-->


<!--BEGIN ENTRY ROW 3-->
<div class="entryRow">
<div class="entryCt"><img border="0" src="_img/thumbs/DorianVazquez.jpg" alt="Dorian Vazquez" class="thumb" /><div class="blue">Downlooking</div>
by Dorian Vazquez</span><div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/DorianVazquez.jpg" data-fancybox-group="gallery" title="Downlooking
by Dorian Vazquez"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/MichaelWiltbank.jpg" alt="Michael Wiltbank" class="thumb" /><div class="blue">
Empire State, New York, NY, 2012</div>
by Michael Wiltbank<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/MichaelWiltbank.jpg" data-fancybox-group="gallery" title="Empire State, New York, NY, 2012
by Michael Wiltbank"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>

<div class="entryCt"><img border="0" src="_img/thumbs/SimosXenakis.jpg" alt="Simos Xenakis" class="thumb" />
<div class="blue">Black & White Empire State</div>
by Simos Xenakis<div class="bt_enlarge"><a class="fancybox-effects-a" href="_img/photos/SimosXenakis.jpg" data-fancybox-group="gallery" title="Black & White Empire State
by Simos Xenakis"><img border="0" src="_img/bt_enlarge.png" alt="enlarge photo" /></a></div></div>



</div><!--END ENTRY ROW 3-->

</div><!--END PAGE 4 DIV-->

<div class="navFinalists">
<div class="instructions"><img border="0" src="_img/btEnlargeSm.png" align="absmiddle" /> Click to enlarge</div>
<div class="navCt">
<div class="arrowBox arrowOff arrowPrev" id="arrowPrev"><</div><div class="navBtOn btn1" id="btn1">1</div><div class="navBt btn2" id="btn2">2</div><div class="navBt btn3" id="btn3">3</div><div class="navBt btn4" id="btn4">4</div><div class="arrowBox arrowNext" id="arrowNext">></div>
</div><!--END NAV CT DIV-->
</div><!--END FINALISTS NAV DIV-->

</div><!--END FINALISTS DIV-->
</div>
	<script type="text/javascript">
		$(document).ready(function() {
		

			$('.fancybox').fancybox({'centerOnScroll' : true});
			
			

			/*
			 *  Different effects
			 */

			// Change title type, overlay closing speed
			$(".fancybox-effects-a").fancybox({
				
				
				
				helpers: {
					title : {
						type : 'inside'
					},
					overlay : {
						
						css : {
							'background' : 'rgba(8,54,80,0.9)'
						}
					}
				}
			});

			

			
			


		});
	</script>

<script type="text/javascript">
<!--SET DEFAULT PAGE TO NUMBER ONE -- >


<!--ASSIGN FUNCTIONS TO NUMBERED BUTTONS-->
$(document).ready(function() {
		
	var currentID = 1;	
				
		for(i=1; i<=4; i++){
				var myButtonClass = ".btn" +i;
				
				
		$(myButtonClass).bind('click', function(event){

 				var myButtonID = event.target.id;
 				var n = myButtonID.substr(myButtonID.length - 1);
  				var myPageID = "page" + n;
  				var myPage = $(document.getElementById(myPageID));
  				
				currentID = parseInt(n);
				
  				for(i=1; i<=4; i++){
					var myPageID = "page" +i;
					var myPage = $(document.getElementById(myPageID));
	 
					var myButtonClass = ".btn" +i;
					var myButton = $(myButtonClass);
	  
	 				if(i!= currentID){
		 				$(myPage).removeClass("pageOn").addClass("pageOff");
		  				$(myButton).removeClass("navBtOn").addClass("navBt");
		  
	  				} else if(i ==  currentID){
		   				$(myPage).removeClass("pageOff").addClass("pageOn");
		   				$(myButton).removeClass("navBt").addClass("navBtOn");
	  				}
	  
  				}
				
				if(currentID == 4){
						$(".arrowNext").removeClass("arrowOn").addClass("arrowOff");
					} else {
						$(".arrowNext").removeClass("arrowOff").addClass("arrowOn");
				}
				
				if(currentID != 1){
						$(".arrowPrev").removeClass("arrowOff").addClass("arrowOn");
					} else {
						$(".arrowPrev").removeClass("arrowOn").addClass("arrowOff");
				}

		});
				
				
		}
		
		
<!--ASSIGN FUNCTIONS TO ARROW BUTTONS-->

		$(".arrowNext").bind('click', function(event){
		currentID = currentID + 1;
		for(i=1; i<=4; i++){
					var myPageID = "page" +i;
					var myPage = $(document.getElementById(myPageID));
	 
					var myButtonClass = ".btn" +i;
					var myButton = $(myButtonClass);
					
					if(currentID == 4){
						$(".arrowNext").removeClass("arrowOn").addClass("arrowOff");
					} else {
						$(".arrowNext").removeClass("arrowOff").addClass("arrowOn");
					}
					
						if(currentID != 1){
						$(".arrowPrev").removeClass("arrowOff").addClass("arrowOn");
					} else {
						$(".arrowPrev").removeClass("arrowOn").addClass("arrowOff");
					}
	  
	 				if(i!=currentID){
		 				$(myPage).removeClass("pageOn").addClass("pageOff");
		  				$(myButton).removeClass("navBtOn").addClass("navBt");
		  
	  				} else if(i == currentID){
		   				$(myPage).removeClass("pageOff").addClass("pageOn");
		   				$(myButton).removeClass("navBt").addClass("navBtOn");
	  				}
	  
  				}
		
		
	});
	
	$(".arrowPrev").bind('click', function(event){
		currentID = currentID - 1;
		
		for(i=1; i<=4; i++){
					var myPageID = "page" +i;
					var myPage = $(document.getElementById(myPageID));
	 
					var myButtonClass = ".btn" +i;
					var myButton = $(myButtonClass);
					
					if(currentID == 1){
						$(".arrowPrev").removeClass("arrowOn").addClass("arrowOff");
					} else {
						$(".arrowPrev").removeClass("arrowOff").addClass("arrowOn");
					}
					
					if(currentID == 4){
						$(".arrowNext").removeClass("arrowOn").addClass("arrowOff");
					} else {
						$(".arrowNext").removeClass("arrowOff").addClass("arrowOn");
				}
	  
	 				if(i!=currentID){
		 				$(myPage).removeClass("pageOn").addClass("pageOff");
		  				$(myButton).removeClass("navBtOn").addClass("navBt");
		  
	  				} else if(i == currentID){
		   				$(myPage).removeClass("pageOff").addClass("pageOn");
		   				$(myButton).removeClass("navBt").addClass("navBtOn");
	  				}
	  
  				}
		
		
	});
				
		
			
});


		
</script>

<script type="text/javascript">
window.fbAsyncInit = function () {
    FB.init({
        appId: '275103132593374', // App ID
        channelUrl: '/index.php', // Channel File
        status: true, // check login status
        cookie: true, // enable cookies to allow the server to access the session
        xfbml: true  // parse XFBML
    });
	 FB.Canvas.setSize({ height: 2000 });
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
