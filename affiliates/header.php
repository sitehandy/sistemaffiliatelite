<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="ROBOTS" content="noindex,nofollow">
<title><? print $namaproduk; ?> - <?=ADMIN_PAGE_TITLE?></title>
<link href="./pwjafflite_temp/pwjafflite_styles.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="./pwjafflite_temp/chromemenu/chrometheme/chromestyle.css" />
<script type="text/javascript" src="./pwjafflite_temp/popup/javascripts/top_up-min.js"></script>
<script type="text/javascript">
  TopUp.images_path = "./pwjafflite_temp/popup/images/top_up/";
</script>
<script type="text/javascript">
  TopUp.players_path = "./pwjafflite_temp/popup/players/";
</script>
<script type="text/javascript" src="./pwjafflite_temp/chromemenu/chromejs/chrome_affiliates.js">

/***********************************************
* Chrome CSS Drop Down Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>
</head>

<body>
<div id="container">
  <div id="SA_header">
    	<h1 id="SA_header_logo"><a href="http://<?=$domain?>" class="ir"><span></span><?=$namaproduk?></a></h1><h1 id="SA_header_title"><? print $namaproduk; ?> - <?=MEMBER_PAGE_TITLE?></h1>
  </div>
	<div id="SA_top_navigation">
    <? if(aff_check_security()) { ?>
    	<div class="chromestyle" id="chromemenu">
			<ul>
                <li><a href="pwjafflite_member_area.php"><?=AFF_M_MEMBERAREA?></a></li>
                <li><a href="pwjafflite_member_profile.php"><?=AFF_M_MEMBERPROFILE?></a></li>
                <li><a href="pwjafflite_member_news.php"><?=AFF_M_MEMBERNEWS?></a></li>
                <li><a href="pwjafflite_member_sales.php"><?=AFF_M_MEMBERSALES?></a></li>
                <li><a href="#" rel="dropmenu1"><?=AFF_M_MEMBERSTATISTIC?></a></li>                                
                <li><a href="#" rel="dropmenu2"><?=AFF_M_MEMBERPROMOTION?></a></li>
                <li><a href="#" rel="dropmenu3"><?=AFF_M_MEMBERSUPPORT?></a></li>
                <li><a href="logout.php"><?=AFF_M_MEMBERLOGOUT?></a></li>	
			</ul>
		</div>

        <!--1st drop down menu -->                                                           
        <div id="dropmenu1" class="dropmenudiv" style="width: 150px;">
        	<a href="pwjafflite_member_clicks.php"><?=AFF_M_MEMBERSTATISTICCLICKS?></a>
            <a href="pwjafflite_member_topaffiliates.php"><?=AFF_M_MEMBERSTATISTICTOPAFFILIATE?></a>
        </div>
        
        <!--2rd drop down menu -->                                                   
        <div id="dropmenu2" class="dropmenudiv" style="width: 150px;">
        	<a href="pwjafflite_member_articles.php"><?=AFF_M_MEMBERPROMOTIONARTICLES?></a>
            <a href="pwjafflite_member_banners.php"><?=AFF_M_MEMBERPROMOTIONBANNERS?></a>
            <a href="pwjafflite_member_videos.php"><?=AFF_M_MEMBERPROMOTIONVIDEOS?></a>
        </div>
        
        <!--3th drop down menu -->                                                   
        <div id="dropmenu3" class="dropmenudiv" style="width: 150px;">
            <a href="pwjafflite_member_contact.php" toptions="width = 550, height = 550, type = iframe, title = Sistem Affiliate Lite, layout = quicklook"><?=AFF_M_MEMBERCONTACT?></a>
        </div>

        <script type="text/javascript">cssdropdown.startchrome("chromemenu")</script>
    <? } ?>    
  </div>
    <div id="SA_content_area">