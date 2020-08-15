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

// Papar Maklumat Pada Ruangan Utama Admin
echo '<br /><table cellspacing="1" class="SA_adminarea_greeting"><tr><td class="SA_adminarea_greeting_header">'.AFF_AA_ADMINGREETING.', '.$admininfo.'!</td></tr><tr><td class="SA_adminarea_greeting_row1"><br />'.$admin_greeting_content;
?>

<script src="http://feeds.feedburner.com/usahaniaga?format=sigpro" type="text/javascript" ></script><noscript><p>Subscribe to RSS headline updates from: <a href="http://feeds.feedburner.com/usahaniaga"></a><br/>Powered by FeedBurner</p></noscript>

<?

echo '</td></tr></table><br />';


// Papar Statistic Sistem Affiliate
// Papar Jumlah Agen Affiliate

$totalaff = mysql_query("SELECT * FROM affiliates", $database_connection) or die ('Database Error');
$totalMember = mysql_num_rows($totalaff);

print '<br /><table cellspacing="1" class="SA_adminarea_statisticbox"><tr>';
print '<td colspan="3" class="SA_adminarea_statisticbox_header">'.AFF_AA_ADMINSTATISTIC.'</td></tr>';
print '<tr><td class="SA_adminarea_statisticbox_row1">'.AFF_AA_TOTALAFFILIATE.'</td>';
print '<td class="SA_adminarea_statisticbox_row1"><div align="right">';
print $totalMember;
print '</div></td>';
print '<td class="SA_adminarea_statisticbox_row1"><div align="right">';
print AFF_AA_TOTALAFFILIATETITLE;
print '</div></td></tr>';


// Jumlah Keseluruhan Jualan Menerusi Sistem Affiliate
// Jumlah Jualan PENDING
$statuspending = AFF_AS_STATUSPENDING;

$querystatuspending = mysql_query("SELECT sum(payment) as pendingpayments, count(payment) as pendingsalescount from sales WHERE statuspelanggan = '$statuspending'", $database_connection) or die ('Database Error');

$sumpending         = 0;
$sumpendingsales    = 0;
while ($qrypending = mysql_fetch_array($querystatuspending))
{
    $sumpending         += $qrypending['pendingpayments'];
    $sumpendingsales    += $qrypending['pendingsalescount'];

    print '<tr><td class="SA_adminarea_statisticbox_row2">'.AFF_AA_TOTALAFFILIATESALES.' - <font color="#FF0000">'.$statuspending.'</font></td>';
    print '<td class="SA_adminarea_statisticbox_row2"><div align="right">'.$sumpendingsales.' '.AFF_AA_UNIT.'</div></td>';
    print '<td class="SA_adminarea_statisticbox_row2"><div align="right">'.$currency.' '.$sumpending.'</div></td></tr>';
}

// Jumlah Jualan VERIFIED
$statusverified = AFF_AS_STATUSVERIFIED;

$querystatusverified = mysql_query("SELECT sum(payment) as verifiedpayments, count(payment) as verifiedsalescount FROM sales WHERE statuspelanggan = '$statusverified'", $database_connection) or die ('Database Error');

$sumverified        = 0;
$sumverifiedsales   = 0;
while ($qryverified = mysql_fetch_array($querystatusverified))
{
    $sumverified        += $qryverified['verifiedpayments'];
    $sumverifiedsales   += $qryverified['verifiedsalescount'];

    print '<tr><td class="SA_adminarea_statisticbox_row1">'.AFF_AA_TOTALAFFILIATESALES.' - <font color="#00CC00">'.$statusverified.'</font></td>';
    print '<td class="SA_adminarea_statisticbox_row1"><div align="right">'.$sumverifiedsales.' '.AFF_AA_UNIT.'</div></td>';
    print '<td class="SA_adminarea_statisticbox_row1"><div align="right">'.$currency.' '.$sumverified.'</div></td></tr>';
}

// Jumlah Jualan PAID
$statuspaid = AFF_AS_STATUSPAID;

$querystatuspaid = mysql_query("SELECT sum(payment) as paidpayments, count(payment) as paidsalescount FROM sales WHERE statuspelanggan = '$statuspaid'", $database_connection) or die ('Database Error');

$sumpaid = 0;
$sumpaidsales = 0;
while ($qrypaid = mysql_fetch_array($querystatuspaid))
{
    $sumpaid        += $qrypaid['paidpayments'];
    $sumpaidsales   += $qrypaid['paidsalescount'];

    print '<tr><td class="SA_adminarea_statisticbox_row2">'.AFF_AA_TOTALAFFILIATESALES.' - <font color="#0000FF">'.$statuspaid.'</font></td>';
    print '<td class="SA_adminarea_statisticbox_row2"><div align="right">'.$sumpaidsales.' '.AFF_AA_UNIT.'</div></td>';
    print '<td class="SA_adminarea_statisticbox_row2"><div align="right">'.$currency.' '.$sumpaid.'</div></td></tr>';
}

// Jumlah KESELURUHAN Jualan
$query3 = mysql_query("SELECT sum(payment) as payments, count(payment) as salescount FROM sales", $database_connection) or die ('Database Error');

$sumall     = 0;
$sumsales   = 0;

while ($qry = mysql_fetch_array($query3))
{
    $sumall     += $qry['payments'];
    $sumsales   += $qry['salescount'];

    print '<tr><td class="SA_adminarea_statisticbox_row1"><b>'.AFF_AA_TOTALSALES.'</b></td>';
    print '<td class="SA_adminarea_statisticbox_row1"><div align="right"><b'.$sumsales.' '.AFF_AA_UNIT.'</b></div></td>';
    print '<td class="SA_adminarea_statisticbox_row1"><div align="right"><b>'.$currency.' '.$sumall.'</b></div></td></tr>';
}

print '<tr><td colspan="3" class="SA_adminarea_statisticbox_row2"><div align="center">&nbsp;</div></td></tr>';
print '<tr><td colspan="3" class="SA_adminarea_statisticbox_row1"><div align="center">[ <a href="pwjafflite_admin_sales.php">'.AFF_AA_REKODJUALAN.'</a> ]</div></td></tr>';
print '</table><br />';

///// Papar Top Affiliate

$resulttopaffiliate = mysql_query("SELECT refid, sum(payment) as payments, count(payment) as salescount FROM sales group by refid ORDER BY salescount desc LIMIT $cartatopaffiliate", $database_connection) or die ('Database Error');

if (mysql_num_rows($resulttopaffiliate))
{
    print '<br /><table cellspacing="1" class="SA_adminarea_statisticbox">';
    print '<tr><td colspan="3" class="SA_adminarea_statisticbox_header">'.AFF_AA_ADMINTOPAFFILIATEINFO.'</td></tr>';
    print '<tr><td colspan="3" class="SA_adminarea_statisticbox_row1"><br />'.$topaffiliateadminnotis.'<br /><br /></td>';
    print '<tr><td class="SA_adminarea_statisticbox_header">'.AFF_AA_TITLEAFFILIATE.'</td><td class="SA_adminarea_statisticbox_header">'.AFF_AA_TITLESALESCOUNT.'</td><td class="SA_adminarea_statisticbox_header">'.AFF_AA_TITLECOMMISSIONEARNED.'</td>';

    while ($qrytopaff = mysql_fetch_array($resulttopaffiliate))
    {
        print '<tr><td class="SA_adminarea_statisticbox_row1"><div align="center"><a href="pwjafflite_affiliate_sales.php?agen='.$qrytopaff['refid'].'&status='.AFF_AS_STATUSPENDING.'">'.$qrytopaff['refid'].'</a></div></td>';
        print '<td class="SA_adminarea_statisticbox_row2"><div align="center">'.$qrytopaff['salescount'].' '.AFF_AA_UNIT.'</div></td>';
        print '<td class="SA_adminarea_statisticbox_row1"><div align="center">'.$currency.' '.$qrytopaff['payments'].'</div></td></tr>';
    }

    print '<tr><td colspan="3" class="SA_adminarea_statisticbox_row2"><div align="center">&nbsp;</div></td></tr>';
    print '<tr><td colspan="3" class="SA_adminarea_statisticbox_row1"><div align="center">[ <a href="pwjafflite_admin_topaffiliates.php">'.AFF_AA_SEEALLTOPAFFILITE.'</a> ]</div></td></tr>';
    print '</table><br />';
}

// papar jualan affiliate baru

$resultjualanbaru = mysql_query("SELECT * FROM sales WHERE date = CURDATE() ORDER BY time desc", $database_connection) or die ('Database Error');

if (mysql_num_rows($resultjualanbaru))
{
    print '<br /><table cellspacing="1" class="SA_general_table">';
    print '<tr><td colspan="8" class="SA_general_table_header">'.AFF_AA_TODAYSALES.'('.$clientdate.')</td></tr>';
    print '<tr><td colspan="8" class="SA_general_table_row1"><br />'.$todaysalesinfo.'<br /><br /></td></tr>';
    print '<tr><td class="SA_general_table_header">'.AFF_C_REFERRER.'</td>';
    print '<td class="SA_general_table_header">'.AFF_G_PELANGGAN.'</td>';
    print '<td class="SA_general_table_header">'.AFF_G_KAEDAHPEMBAYARAN.'</td>';
    print '<td class="SA_general_table_header">'.AFF_G_DATE.'</td>';
    print '<td class="SA_general_table_header">'.AFF_G_TIME.'</td>';
    print '<td class="SA_general_table_header">'.AFF_G_EARNINGS.'</td>';
    print '<td class="SA_general_table_header">'.AFF_G_IPPELANGGAN.'</td>';
    print '<td class="SA_general_table_header">'.AFF_G_STATUS.'</td></tr>';

    while ($qrysales = mysql_fetch_array($resultjualanbaru))
    {
        print '<tr><td class="SA_general_table_row1"><div align="center">';
        print $qrysales['refid'];
        print '</div></td>';
        print '<td class="SA_general_table_row2"><div align="center">';
        print $qrysales['namapelanggan'];
        print '</div></td>';
        print '<td class="SA_general_table_row1"><div align="center">';
        print $qrysales['kaedahpembayaran'];
        print '</div></td>';
        print '<td class="SA_general_table_row2"><div align="center">';
        print $qrysales['date'];
        print '</div></td>';
        print '<td class="SA_general_table_row1"><div align="center">';
        print $qrysales['time'];
        print '</div></td>';
        print '<td class="SA_general_table_row2"><div align="center">';
        print $qrysales['payment'];
        print '</div></td>';
        print '<td class="SA_general_table_row1"><div align="center">';
        print $qrysales['ipaddress'];
        print '</div></td>';
        print '<td class="SA_general_table_row2"><div align="center">';
        print $qrysales['statuspelanggan'];
        print '</div></td></tr>';
    }

    print '<tr><td colspan="8" class="SA_general_table_row1"><div align="center">&nbsp;</div></td></tr>';
    print '<tr><td colspan="8" class="SA_general_table_row2"><div align="center">[ <a href="pwjafflite_admin_sales.php">'.AFF_AA_REKODJUALAN.'</a> ]</div></td></tr>';
    print '</table><br />';
}

////papar agen affiliate baru

$resultnewaffiliates = mysql_query("SELECT * FROM affiliates WHERE date = CURDATE()", $database_connection) or die ('Database Error');

if (mysql_num_rows($resultnewaffiliates))
{
    print '<br /><table cellspacing="1" class="SA_general_table">';
    print '<tr><td colspan="6" class="SA_general_table_header">'.AFF_AA_TODAYSIGNUP.'('.$clientdate.')</td></tr>';
    print '<tr><td colspan="6" class="SA_general_table_row1"><br/>'.$todaysignupinfo.'<br/><br/></td></tr>';
    print '<tr><td class="SA_general_table_header">'.AFF_AA_IDAFFILIATE.'</td><td class="SA_general_table_header">'.AFF_AA_NAMAAFFILIATE.'</td><td class="SA_general_table_header">'.AFF_AA_EMAILAFFILIATE.'</td><td class="SA_general_table_header">'.AFF_G_DATE.'</td>';
    print '<td class="SA_general_table_header">'.AFF_AA_IPDAFTAR.'</td>';
    print '<td class="SA_general_table_header">'.AFF_AA_UPLINE.'</td></tr>';

    while ($qrynewagent = mysql_fetch_array($resultnewaffiliates))
    {
        print '<tr><td class="SA_general_table_row1"><div align="center"><a href="pwjafflite_affiliate_profile.php?edit=';
        print $qrynewagent['refid'];
        print '">';
        print $qrynewagent['refid'];
        print '</a></div></td>';
        print '<td class="SA_general_table_row2"><div align="center">';
        print $qrynewagent['title'];
        print ' ';
        print $qrynewagent['firstname'];
        print ' ';
        print $qrynewagent['lastname'];
        print '</div></td>';
        print '<td class="SA_general_table_row1"><div align="center">';
        print $qrynewagent['email'];
        print '</div></td>';
        print '<td class="SA_general_table_row2"><div align="center">';
        print $qrynewagent['date'];
        print '</div></td>';
        print '<td class="SA_general_table_row1"><div align="center">';
        print $qrynewagent['ipaddress'];
        print '</div></td>';
        print '<td class="SA_general_table_row2"><div align="center"><a href="pwjafflite_affiliate_profile.php?edit=';
        print $qrynewagent['upline'];
        print '">';
        print $qrynewagent['upline'];
        print '</a></div></td></tr>';

    }
    print '<tr><td colspan="6" class="SA_general_table_row1"><div align="center">&nbsp;</div></td></tr>';
    print '<tr><td colspan="6" class="SA_general_table_row2"><div align="center">[ <a href="pwjafflite_admin_affiliates.php">'.AFF_AA_REKODAFFILIATES.'</a> ]</div></td></tr>';
    print '</table><br />';

}
?>

<br />
<table cellspacing="1" class="SA_general_table">
    <tr>
        <td colspan="5" class="SA_general_table_header"><?=AFF_AA_EXCLUSIVEOFFER?>, <?=$admininfo?></td>
    </tr>
    <tr>
        <td colspan="5" class="SA_general_table_row1">
            <div align="center">
                <script src="http://jvcommerce.com/main/s3/php/banner/view.php?id=4"></script>
            </div>
        </td>
    </tr>
</table>
<br />

<?

//Papar Footer
echo $footerdisplay;

?>
