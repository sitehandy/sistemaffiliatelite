<?php

session_start();
include '../../pwjafflite_config.php';
include '../lang/'.$language;

if(!aff_admin_check_security())
{
    aff_redirect('index.php');
    exit();
}

// Papar Header Sistem Affiliate
include 'header.php';
 
// Dapatkan TOP Sales Affiliate VERIFIED COMMISSION
$statusverified = AFF_AS_STATUSVERIFIED;

$resulttopaffiliateverified = mysql_query("SELECT refid, sum(payment) as payments, count(payment) as salescount FROM sales WHERE statuspelanggan = '$statusverified' group by refid ORDER BY salescount desc LIMIT $cartatopaffiliate", $database_connection) or die ("Database Sales Connect Error");

if (mysql_num_rows($resulttopaffiliateverified))
{
    print "<br /><table class=\"SA_adminarea_statisticbox\" cellspacing=\"1\">";
    print "<tr><td colspan=\"3\" class=\"SA_adminarea_statisticbox_header\"><font color=\"#FF0000\">".AFF_MA_TOPAFFILIATEVERIFIEDTITLE."</font></td></tr>";
    print "<tr><td colspan=\"3\" class=\"SA_adminarea_statisticbox_row1\"><br />$topaffiliatenotis_verified<br /><br /></td>";
    print "<tr><td class=\"SA_adminarea_statisticbox_header\">".AFF_MA_MEMBERTOPAFF."</td><td class=\"SA_adminarea_statisticbox_header\">".AFF_MA_MEMBERTOPSALES."</td><td class=\"SA_adminarea_statisticbox_header\">".AFF_MA_MEMBERTOPCOMMISSION."</td>";

    $sumall     = 0;
    $sumsales   = 0;

    while ($qryverified = mysql_fetch_array($resulttopaffiliateverified))
    {
        $sumall     += $qryverified['payments'];
        $sumsales   += $qryverified['salescount'];
	  
          print "<tr>";
          print "<td class=\"SA_adminarea_statisticbox_row1\"><div align=\"center\">".$qryverified['refid']."</div></td>";
          print "<td class=\"SA_adminarea_statisticbox_row2\"><div align=\"center\">".$qryverified['salescount']." ".AFF_AA_UNIT."</div></td>";
          print "<td class=\"SA_adminarea_statisticbox_row1\"><div align=\"center\">$currency ".$qryverified['payments']."</div></td>";
          print "</tr>";

    }

    print "<tr><td colspan=\"3\" class=\"SA_adminarea_statisticbox_row1\"><div align=\"center\">&nbsp;</div></td></tr>";
    print "</table><br />";

}

//Papar Informasi Jika Tiada Klik Terhasil Lagi
else echo "<br /><table cellspacing=\"1\" class=\"SA_norecord_box\"><tr><td><br />".AFF_AC_STATISTICPROBLEMTOPAFFILIATE." - ".AFF_AS_STATUSVERIFIED."<br /><br /></td></tr></table><br />";


// Dapatkan TOP Sales Affiliate PAID COMMISSION
$statuspaid = AFF_AS_STATUSPAID;

$resulttopaffiliatepaid = mysql_query("SELECT refid, sum(payment) as payments2, count(payment) as salescount2 FROM sales WHERE statuspelanggan = '$statuspaid' group by refid ORDER BY salescount2 desc LIMIT $cartatopaffiliate") or die ("Database Sales Connect Error");

if (mysql_num_rows($resulttopaffiliatepaid))
{
    print "<br /><table class=\"SA_adminarea_statisticbox\" cellspacing=\"1\">";
    print "<tr><td colspan=\"3\" class=\"SA_adminarea_statisticbox_header\"><font color=\"#0000FF\">".AFF_MA_TOPAFFILIATEPAIDTITLE."</font></td></tr>";
    print "<tr><td colspan=\"3\" class=\"SA_adminarea_statisticbox_row1\"><br />$topaffiliatenotis_paid<br /><br /></td>";
    print "<tr><td class=\"SA_adminarea_statisticbox_header\">".AFF_MA_MEMBERTOPAFF."</td><td class=\"SA_adminarea_statisticbox_header\">".AFF_MA_MEMBERTOPSALES."</td><td class=\"SA_adminarea_statisticbox_header\">".AFF_MA_MEMBERTOPCOMMISSION."</td>";

    $sumall2    = 0;
    $sumsales2  = 0;

    while ($qrypaid = mysql_fetch_array($resulttopaffiliatepaid))
    {
        $sumall2    += $qrypaid['payments2'];
        $sumsales2  += $qrypaid['salescount2'];
	  
        print "<tr>";
        print "<td class=\"SA_adminarea_statisticbox_row1\"><div align=\"center\">".$qrypaid['refid']."</div></td>";
        print "<td class=\"SA_adminarea_statisticbox_row2\"><div align=\"center\">".$qrypaid['salescount2']." ".AFF_AA_UNIT."</div></td>";
        print "<td class=\"SA_adminarea_statisticbox_row1\"><div align=\"center\">$currency ".$qrypaid['payments2']."</div></td>";
        print "</tr>";

    }

    print "<tr><td colspan=\"3\" class=\"SA_adminarea_statisticbox_row1\"><div align=\"center\">&nbsp;</div></td></tr>";
    print "</table><br />";
}


//Papar Informasi Jika Tiada Klik Terhasil Lagi
else echo "<br /><table cellspacing=\"1\" class=\"SA_norecord_box\"><tr><td><br />".AFF_AC_STATISTICPROBLEMTOPAFFILIATE." - ".AFF_AS_STATUSPAID."<br /><br /></td></tr></table><br />";  

//Paparkan Footer
echo $footerdisplay;    

?>