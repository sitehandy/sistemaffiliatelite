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

// protection against script injection
$change = preg_replace('/[^a-zA-Z0-9_]/', '', $_REQUEST['change']);

echo "<br /><form method=post action=\"pwjafflite_affiliate_statistic.php\">
<table cellspacing=\"1\" class=\"SA_general_table\">
<tr>
<td colspan=\"3\" class=\"SA_general_table_header\">".AFF_AC_STATISTICTITLE." - $change</td>
</tr>
<tr> 
<td class=\"SA_general_table_row1\">".AFF_AC_STATISTICCHOOSE."
</td>
<td class=\"SA_general_table_row1\"><div align=\"center\">:</div></td> 
<td class=\"SA_general_table_row1\"><div align=\"center\"> 
<select name=\"change\">";
          
//Dapat Data Affiliate
$result = mysql_query("SELECT refid FROM affiliates ORDER BY refid", $database_connection) or die ("Database Error");

if (mysql_num_rows($result))
{
    while ($qry = mysql_fetch_array($result))
    {
        echo "<option value=".$qry['refid']." ".($qry['refid'] == $change ? 'selected' : '').">".$qry['refid']."</option>";        
    }
}
echo "</select></div></td></tr>
<tr><td colspan=\"3\" class=\"SA_general_table_row2\"><div align=\"center\">
<input type=\"submit\" value=".AFF_AC_STATISTICBUTTON.">
</div></td>
</tr>
</table>
</form><br />";


// Papar Maklumat Ringkas Agen
$maklumat = mysql_query("SELECT * from affiliates where refid = '$change'", $database_connection) or die ("Database Error");

if (mysql_num_rows($maklumat)) 
{
    //Papar Data Agen

    print "<br /><table cellspacing=\"1\" class=\"SA_details_table\">";
    print "<tr><td class=\"SA_details_table_header\">".AFF_AA_IDAFFILIATE."</td>";
    print "<td class=\"SA_details_table_header\">".AFF_AA_NAMAAFFILIATE."</td>";
    print "<td class=\"SA_details_table_header\">".AFF_AA_EMAILAFFILIATE."</td>";
    print "<td class=\"SA_details_table_header\">".AFF_AA_PHONEAFFILIATE."</td>";
    print "<td class=\"SA_details_table_header\">".AFF_AA_NEGERIAFFILIATE."</td>";
    print "<td class=\"SA_details_table_header\">".AFF_AA_TARIKHDAFTAR."</td>";
    print "<td class=\"SA_details_table_header\">".AFF_AA_IPDAFTAR."</td>";
    print "<td class=\"SA_details_table_header\">".AFF_G_SAHKOMISYEN."</td></tr>";

    while ($qry = mysql_fetch_array($maklumat))
    {
        print "<tr><td class=\"SA_details_table_row1\"><div align=\"center\">";
        print $qry['refid'];
        print "</div></td>";
        print "<td class=\"SA_details_table_row2\"><div align=\"center\">";
        print $qry['title'];
        print " ";
        print $qry['firstname'];
        print " ";
        print $qry['lastname'];
        print "</div></td>";
        print "<td class=\"SA_details_table_row1\"><div align=\"center\">";
        print "<a href=\"pwjafflite_affiliate_email.php?agen=".$qry['refid']."\" toptions=\"width = 550, height = 500, type = iframe, title = Sistem Affiliate Lite, layout = quicklook\">";
        print $qry['email'];
        print "</a></div></td>";
        print "<td class=\"SA_details_table_row2\"><div align=\"center\">";
        print $qry['phone'];
        print "</div></td>";
        print "<td class=\"SA_details_table_row1\"><div align=\"center\">";
        print $qry['county'];
        print "</div></td>";
        print "<td class=\"SA_details_table_row2\"><div align=\"center\">";
        print $qry['date'];
        print "</div></td>";
        print "<td class=\"SA_details_table_row1\"><div align=\"center\">";
        print $qry['ipaddress'];
        print "</div></td>";
        print "<td class=\"SA_details_table_row2\"><center>[<a href=\"pwjafflite_affiliate_profile.php?edit=".$qry['refid']."\">Detail</a>]<br />[<a href=\"pwjafflite_affiliate_delete.php?delete=".$qry['refid']."&validation=".$_SESSION['aff_valid_admin']."\"  onClick=\"return confirm('".AFF_P_DELETE."')\">Hapuskan</a>]</center></td>";
        print "</tr>";
    }
    print "</table><br />";

}

else echo "<br /><table cellspacing=\"1\" class=\"SA_norecord_box\"><tr><td><br />".AFF_AC_STATISTICPROBLEM."<br /><br /></td></tr></table><br />";

// get total clicks from selected refid
$klik = mysql_query("SELECT * from clickthroughs where refid = '$change' ORDER BY date and time", $database_connection) or die ("Database Error");

$jumlahklik = (mysql_num_rows($klik));
if (mysql_num_rows($klik))
{
    //Papar Informasi Klik
    print "<br /><table cellspacing=\"1\"class=\"SA_adminarea_statisticbox\">";
    print "<tr><td colspan=\"4\" class=\"SA_adminarea_statisticbox_header\">".AFF_C_CLICKSFROM." - $change</td></tr>";
    print "<tr><td class=\"SA_adminarea_statisticbox_row1\">".AFF_C_TOTALCLICK."</td>";
    print "<td class=\"SA_adminarea_statisticbox_row2\"><div align=\"center\">:</div></td>";
    print "<td class=\"SA_adminarea_statisticbox_row1\"><div align=\"right\">".$jumlahklik." clicks</div></td>";
    print "<td class=\"SA_adminarea_statisticbox_row2\"><div align=\"center\">[<a href=\"pwjafflite_affiliate_clicks.php?details=$change\">".AFF_AA_DETAILSLINK."</a>] [<a href=\"pwjafflite_clicks_reset.php?agen=".$change."&validation=".$_SESSION['aff_valid_admin']."\" onClick=\"return confirm('".AFF_A_RESETCONFIRM."')\">".AFF_A_RESET."</a>]</div></td></tr>";
    print "</table><br />";
}

//Papar Informasi Jika Tiada Klik Terhasil Lagi
else echo "<br /><table cellspacing=\"1\" class=\"SA_norecord_box\"><tr><td><br />".AFF_AC_STATISTICPROBLEMCLICK."<br /><br /></td></tr></table><br />";

// Get Total Sales From Selected RefID
$resultsales = mysql_query("SELECT * from sales where refid = '$change' ORDER BY idsales desc", $database_connection) or die ("Database Error");

if (mysql_num_rows($resultsales)) 
{
    //Jumlah Keseluruhan Jualan Agen Pilihan Menerusi Sistem Affiliate
    //Papar Maklumat Statistik Jualan
    
    print "<br /><table cellspacing=\"1\" class=\"SA_adminarea_statisticbox\">";
    print "<tr><td colspan=\"3\" class=\"SA_adminarea_statisticbox_header\">".AFF_AC_STATISTICSALES." - $change</td>";
    print "</tr><tr>";

    // Jumlah Jualan PENDING
    $statuspending = AFF_AS_STATUSPENDING;

    $querystatuspending = mysql_query("SELECT sum(payment) as pendingpayments, count(payment) as pendingsalescount from sales WHERE refid = '$change' AND statuspelanggan = '$statuspending'", $database_connection) or die ("Database Error");
    
    $sumpending         = 0;
    $sumpendingsales    = 0;

    while ($qrypending = mysql_fetch_array($querystatuspending))
    {
        $sumpending         += $qrypending['pendingpayments'];
        $sumpendingsales    += $qrypending['pendingsalescount'];

        print "<tr><td class=\"SA_adminarea_statisticbox_row1\">".AFF_AA_TOTALAFFILIATESALES." $change - <font color=\"#FF0000\">$statuspending</font></td>";
        print "<td class=\"SA_adminarea_statisticbox_row1\"><div align=\"right\">$sumpendingsales ".AFF_AA_UNIT."</div></td>";
        print "<td class=\"SA_adminarea_statisticbox_row1\"><div align=\"right\">$currency $sumpending</div></td></tr>";
    }
	
    // Jumlah Jualan VERIFIED
    $statusverified = AFF_AS_STATUSVERIFIED;

    $querystatusverified = mysql_query("SELECT sum(payment) as verifiedpayments, count(payment) as verifiedsalescount from sales WHERE refid = '$change' AND statuspelanggan = '$statusverified'", $database_connection) or die ("Database Error");

    $sumverified        = 0;
    $sumverifiedsales   = 0;

    while ($qryverified = mysql_fetch_array($querystatusverified))
    {
        $sumverified        += $qryverified['verifiedpayments'];
        $sumverifiedsales   += $qryverified['verifiedsalescount'];

        print "<tr><td class=\"SA_adminarea_statisticbox_row2\">".AFF_AA_TOTALAFFILIATESALES." $change - <font color=\"#00CC00\">$statusverified</font></td>";
        print "<td class=\"SA_adminarea_statisticbox_row2\"><div align=\"right\">$sumverifiedsales ".AFF_AA_UNIT."</div></td>";
        print "<td class=\"SA_adminarea_statisticbox_row2\"><div align=\"right\">$currency $sumverified</div></td></tr>";
    }

    // Jumlah Jualan PAID
    $statuspaid = AFF_AS_STATUSPAID;

    $querystatuspaid = mysql_query("SELECT sum(payment) as paidpayments, count(payment) as paidsalescount from sales WHERE refid = '$change' AND statuspelanggan = '$statuspaid'", $database_connection) or die ("Database Error");

    $sumpaid        = 0;
    $sumpaidsales   = 0;

    while ($qrypaid = mysql_fetch_array($querystatuspaid))
    {
        $sumpaid        += $qrypaid['paidpayments'];
        $sumpaidsales   += $qrypaid['paidsalescount'];
	  	
	print "<tr><td class=\"SA_adminarea_statisticbox_row1\">".AFF_AA_TOTALAFFILIATESALES." $change - <font color=\"#0000FF\">$statuspaid</font></td>";
	print "<td class=\"SA_adminarea_statisticbox_row1\"><div align=\"right\">$sumpaidsales ".AFF_AA_UNIT."</div></td>";
	print "<td class=\"SA_adminarea_statisticbox_row1\"><div align=\"right\">$currency $sumpaid</div></td></tr>";
	print "<tr><td colspan=\"3\" class=\"SA_adminarea_statisticbox_row2\"><div align=\"right\">&nbsp;</div></td></tr>";
	print "<tr><td colspan=\"3\" class=\"SA_adminarea_statisticbox_row1\"><div align=\"center\">
	[<a href=\"pwjafflite_affiliate_sales.php?agen=$change&status=".AFF_AS_STATUSPENDING."\">".AFF_AA_DETAILSLINK."</a>] 
	[<a href=\"pwjafflite_sales_reset.php?agen=".$change."&delete=allsalesrecords&validation=".$_SESSION['aff_valid_admin']."\" onClick=\"return confirm('".AFF_A_RESETCONFIRM."')\">".AFF_A_RESET."</a>]
	</div></td></tr>";	
    }
    print "</table><br />";
}

//Papar Informasi Jika Tiada Jualan Terhasil Lagi
else echo "<br /><table cellspacing=\"1\" class=\"SA_norecord_box\"><tr><td><br />".AFF_AC_STATISTICPROBLEMSALES."<br /><br /></td></tr></table><br />";
  
//Papar Footer
echo $footerdisplay;  

?>