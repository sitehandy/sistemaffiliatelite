<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="ROBOTS" content="noindex,nofollow">
<title><? print $namaproduk; ?> - <?=ADMIN_PAGE_TITLE?></title>
<link href="../pwjafflite_temp/pwjafflite_styles.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../pwjafflite_temp/chromemenu/chrometheme/chromestyle.css" />
<script type="text/javascript" src="../pwjafflite_temp/popup/javascripts/top_up-min.js"></script>
<script type="text/javascript">  
  TopUp.images_path = "../pwjafflite_temp/popup/images/top_up/";
</script>
<script type="text/javascript">  
  TopUp.players_path = "../pwjafflite_temp/popup/players/";
</script>
<script type="text/javascript" src="../pwjafflite_temp/chromemenu/chromejs/chrome_admin.js">

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
    	<h1 id="SA_header_logo"><a href="http://<?=$domain?>" class="ir"><span></span><?=$namaproduk?></a></h1><h1 id="SA_header_title"><? print $namaproduk; ?> - <?=ADMIN_PAGE_TITLE?></h1>
  </div>
	<div id="SA_top_navigation">
    <? if(aff_admin_check_security()) { ?>
    	<div class="chromestyle" id="chromemenu">
			<ul>
                <li><a href="pwjafflite_admin_area.php"><?=AFF_M_ADMINAREA?></a></li>
                <li><a href="#" rel="dropmenu1"><?=AFF_M_ADMINCONFIGURATION?></a></li>
                <li><a href="#" rel="dropmenu2"><?=AFF_M_ADMINAFFILIATE?></a></li>
                <li><a href="#" rel="dropmenu3"><?=AFF_M_ADMINSALES?></a></li>
                <li><a href="#" rel="dropmenu4"><?=AFF_M_ADMINSTATISTIC?></a></li>                
                <li><a href="#" rel="dropmenu5"><?=AFF_M_ADMINPROMOTION?></a></li>
                <li><a href="#" rel="dropmenu6"><?=AFF_M_ADMININFORMATION?></a></li>
                <li><a href="#" rel="dropmenu7"><?=AFF_M_ADMINHELP?></a></li>
                <li><a href="logout.php"><?=AFF_M_ADMINLOGOUT?></a></li>	
			</ul>
		</div>

        <!--1st drop down menu -->                                                   
        <div id="dropmenu1" class="dropmenudiv" style="width: 150px;">
        	<a href="pwjafflite_admin_profile.php"><?=AFF_M_ADMINPROFILE?></a>
        	<a href="pwjafflite_admin_system.php"><?=AFF_M_ADMINSYSTEM?></a>
            <a href="pwjafflite_admin_products.php"><?=AFF_M_ADMINPRODUCTS?></a>
            <a href="pwjafflite_admin_email.php"><?=AFF_M_ADMINEMAIL?></a>
            <a href="pwjafflite_admin_tracking.php"><?=AFF_M_ADMINAFFTRACKING?></a>
            <a href="pwjafflite_admin_form.php"><?=AFF_M_ADMINFORMCODE?></a>
        </div>
                
        <!--2nd drop down menu -->                                                
        <div id="dropmenu2" class="dropmenudiv" style="width: 150px;">
        	<a href="pwjafflite_admin_affiliates.php"><?=AFF_M_ADMINAFFILIATELIST?></a>
            <a href="pwjafflite_affiliate_search.php"><?=AFF_M_ADMINAFFILIATESEARCH?></a>
        </div>
        
        <!--3rd drop down menu -->                                                   
        <div id="dropmenu3" class="dropmenudiv" style="width: 150px;">
        	<a href="pwjafflite_sales_search.php"><?=AFF_M_ADMINSALESSEARCH?></a>
            <a href="pwjafflite_admin_sales.php"><?=AFF_M_ADMINSALESRECORD?></a>
            <a href="pwjafflite_admin_pay.php"><?=AFF_M_ADMINPAYCOMMISSION?></a>
        </div>
        
        <!--4th drop down menu -->                                                   
        <div id="dropmenu4" class="dropmenudiv" style="width: 150px;">
            <a href="pwjafflite_admin_clicks.php"><?=AFF_M_ADMINSTATISTICCLICKS?></a>
            <a href="pwjafflite_affiliate_statistic.php"><?=AFF_M_ADMINSTATISTICAFFILIATE?></a>
            <a href="pwjafflite_admin_topaffiliates.php"><?=AFF_M_ADMINSTATISTICTOPAFFILIATE?></a>
        </div>
        
        <!--5th drop down menu -->                                                   
        <div id="dropmenu5" class="dropmenudiv" style="width: 150px;">
            <a href="pwjafflite_admin_banners.php"><?=AFF_M_ADMINBANNERS?></a>
            <a href="pwjafflite_admin_articles.php"><?=AFF_M_ADMINARTICLES?></a>
            <a href="pwjafflite_admin_videos.php"><?=AFF_M_ADMINVIDEOS?></a>
        </div>
        
        <!--6th drop down menu -->                                                   
        <div id="dropmenu6" class="dropmenudiv" style="width: 150px;">
            <a href="pwjafflite_admin_optin.php"><?=AFF_M_ADMINOPTIN?></a>
            <a href="pwjafflite_admin_news.php"><?=AFF_M_ADMINNEWS?></a>
            <a href="pwjafflite_admin_notice.php"><?=AFF_M_ADMINNOTIFICATION?></a>
            <a href="pwjafflite_admin_ads.php"><?=AFF_M_ADMINADVERTISE?></a>
            <a href="pwjafflite_admin_registerterms.php"><?=AFF_M_ADMINTERMS?></a>
        </div>
        
        <!--7th drop down menu -->                                                   
        <div id="dropmenu7" class="dropmenudiv" style="width: 150px;">
        	<a href="http://www.sistemaffiliate.com/v2/userfile/pwjafflite_admin_help.php?verified=user"><?=AFF_M_ADMINHELPFUNCTION?></a>
            <a href="http://www.sistemaffiliate.com/v2/userfile/faq_members.php"><?=AFF_M_ADMINHELPFAQ?></a>
            <a href="pwjafflite_admin_update.php"><?=AFF_M_ADMINHELPSCRIPTVERSION?></a>
            <a href="http://www.sistemaffiliate.com/v2/userfile/services.php"><?=AFF_M_ADMINHELPSERVICES?></a>
            <a href="http://www.sistemaffiliate.com/v2/userfile/request.php"><?=AFF_M_ADMINHELPREQUEST?></a>
        </div>
        <script type="text/javascript">cssdropdown.startchrome("chromemenu")</script>
    <? } ?>    
  </div>
    <div id="SA_content_area">