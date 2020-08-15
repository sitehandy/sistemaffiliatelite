<?php

session_start();

include '../pwjafflite_config.php';
include './lang/'.$language;

if(!aff_check_security())
{
    aff_redirect('index.php');
    exit();
}

include 'header.php';

// Dapatkan Data Affiliate
$affiliatedata = mysql_query("SELECT * FROM affiliates where refid = '".$_SESSION['aff_valid_user']."'", $database_connection) or die ("Database Affiliate Connect Error");

// Greet affiliate
if (mysql_num_rows($affiliatedata))
{
    while ($qry = mysql_fetch_array($affiliatedata))
    {
?>
<br />
<table cellspacing="1" class="SA_adminarea_greeting">
    <tr>
        <td class="SA_adminarea_greeting_header"><?=AFF_MA_MEMBERWELCOME?> <?=$qry['title']?> <?=$qry['firstname']?> <?=$qry['lastname']?>!</td>
    </tr>
    <tr>
        <td class="SA_adminarea_greeting_row1">
            <br />
            <?=$member_greeting?>
            <br />
            <?
            // Dapatkan Berita Terkini Daripada Admin
            $newsdata = mysql_query("SELECT * FROM beritaagen ORDER BY idberita DESC LIMIT 3", $database_connection) or die ("Database News Connect Error");
            if (mysql_num_rows($newsdata))
            {
                print '<ul>';
                while ($qrynews = mysql_fetch_array($newsdata))
                {
                    ?>
                    <li>
                        <a href="pwjafflite_member_news.php"><?=$qrynews['tajukberita']?></a> <i><?=$qrynews['tarikhberita']?></i>
                    </li>
                    <?
                }
                print '</ul>';
            }
            ?>
            <br />
        </td>
    </tr>
</table>
<br />
<br  />
<table cellspacing="1" class="SA_adminarea_statisticbox">
 <tr>
    <td class="SA_adminarea_statisticbox_header">DEFAULT AFFILIATE LINK</td>
 </tr>
 <tr>
    <td class="SA_adminarea_statisticbox_row1">
    <div align="center">
    <input name="linkaffiliate" type="text" size="70" value="https://<? echo $domain ?>/hop.php?ref=<? print $_SESSION['aff_valid_user']?>">
    </div>
    </td>
 </tr>
 <tr>
 	<td class="SA_adminarea_statisticbox_row2">
    <div align="center">
    [ <a href="https://<? echo $domain ?>/hop.php?ref=<? print $_SESSION['aff_valid_user']?>" target="_blank"><?=AFF_MA_MEMBERAFFTESTLINK?></a> ]
    </div>
    </td>
 </tr>
</table>

<?php
// Dapatkan Berita Terkini Daripada Admin
$affiliate_links = mysql_query("SELECT * FROM produk ORDER BY idproduk", $database_connection) or die ("Database Produk Connect Error");
if (mysql_num_rows($affiliate_links))
{
    echo '<table cellspacing="1" class="SA_adminarea_statisticbox">';
    while ($qryproduct = mysql_fetch_array($affiliate_links))
    {
        echo '<tr><td class="SA_adminarea_statisticbox_header">AFFILIATE LINK - ' . $qryproduct['namaproduk'] . '</td></tr>';
        echo '<tr>
           <td class="SA_adminarea_statisticbox_row1">
           <div align="center">
           <input name="linkaffiliate" type="text" size="70" value="https://' . $domain . '/hop.php?ref=' . $_SESSION['aff_valid_user'] . '&p=' . $qryproduct['idproduk'] . '">
           </div>
           </td>
        </tr>';
        echo '<tr>
        	<td class="SA_adminarea_statisticbox_row2">
           <div align="center">
           [ <a href="https://' . $domain . '/hop.php?ref=' . $_SESSION['aff_valid_user'] . '&p=' . $qryproduct['idproduk'] . '" target="_blank">' . AFF_MA_MEMBERAFFTESTLINK . '</a> ]
           </div>
           </td>
        </tr>';
    }
    echo '</table>';
}
?>




<br />
<br />
<table cellspacing="1" class="SA_adminarea_statisticbox">
    <tr><td colspan="3" class="SA_adminarea_statisticbox_header"><?=AFF_MA_MEMBERSTATISTIC?></td></tr>
    <tr>
        <td class="SA_adminarea_statisticbox_row1">
            <?=AFF_MA_MEMBERSTATISTICCLICKS?>
        </td>
        <td colspan="2" class="SA_adminarea_statisticbox_row1">
            <div align="right">
            <?
            $clicksdata = mysql_query("SELECT * FROM clickthroughs where refid = '".$_SESSION['aff_valid_user']."'", $database_connection) or die ("Database INSERT Error");
            if ($clicksdata)
            {
                print mysql_num_rows($clicksdata);
            }
            ?> Click(s)
            </div>
        </td>
    </tr>

<?
// Jumlah Keseluruhan Jualan Menerusi Sistem Affiliate

// Jumlah Jualan PENDING
$statuspending = AFF_AS_STATUSPENDING;
$querystatuspending = mysql_query("SELECT sum(payment) as pendingpayments, count(payment) as pendingsalescount FROM sales WHERE refid = '".$_SESSION['aff_valid_user']."' AND statuspelanggan = '$statuspending'", $database_connection) or die ("Database Error");

$sumpending         = 0;
$sumpendingsales    = 0;

while ($qrypending = mysql_fetch_array($querystatuspending))
{
    $sumpending         += $qrypending['pendingpayments'];
    $sumpendingsales    += $qrypending['pendingsalescount'];

    print '<tr><td class="SA_adminarea_statisticbox_row2">'.AFF_MA_MEMBERSTATISTICSALES.' - <font color="#FF0000">'.$statuspending.'</font></td>';
    print '<td class="SA_adminarea_statisticbox_row2"><div align="right">'.$sumpendingsales.' '.AFF_AA_UNIT.'</div></td>';
    print '<td class="SA_adminarea_statisticbox_row2"><div align="right">'.$currency.' '.$sumpending.'</div></td></tr>';
}

// Jumlah Jualan VERIFIED
$statusverified = AFF_AS_STATUSVERIFIED;
$querystatusverified = mysql_query("SELECT sum(payment) as verifiedpayments, count(payment) as verifiedsalescount FROM sales WHERE refid = '".$_SESSION['aff_valid_user']."' AND statuspelanggan = '$statusverified'", $database_connection) or die ("Database Error");

$sumverified        = 0;
$sumverifiedsales   = 0;

while ($qryverified = mysql_fetch_array($querystatusverified))
{
    $sumverified        += $qryverified['verifiedpayments'];
    $sumverifiedsales   += $qryverified['verifiedsalescount'];

    print '<tr><td class="SA_adminarea_statisticbox_row1">'.AFF_MA_MEMBERSTATISTICSALES.' - <font color="#00CC00">'.$statusverified.'</font></td>';
    print '<td class="SA_adminarea_statisticbox_row1"><div align="right">'.$sumverifiedsales.' '.AFF_AA_UNIT.'</div></td>';
    print '<td class="SA_adminarea_statisticbox_row1"><div align="right">'.$currency.' '.$sumverified.'</div></td></tr>';
}

// Jumlah Jualan PAID
$statuspaid = AFF_AS_STATUSPAID;
$querystatuspaid = mysql_query("SELECT sum(payment) as paidpayments, count(payment) as paidsalescount FROM sales WHERE refid = '".$_SESSION['aff_valid_user']."' AND statuspelanggan = '$statuspaid'", $database_connection) or die ("Database Error");

$sumpaid = 0;
$sumpaidsales = 0;
while ($qrypaid = mysql_fetch_array($querystatuspaid))
{
    $sumpaid        += $qrypaid['paidpayments'];
    $sumpaidsales   += $qrypaid['paidsalescount'];

    print '<tr><td class="SA_adminarea_statisticbox_row2">'.AFF_MA_MEMBERSTATISTICSALES.' - <font color="#0000FF">'.$statuspaid.'</font></td>';
    print '<td class="SA_adminarea_statisticbox_row2"><div align="right">'.$sumpaidsales.' '.AFF_AA_UNIT.'</div></td>';
    print '<td class="SA_adminarea_statisticbox_row2"><div align="right">'.$currency.' '.$sumpaid.'</div></td></tr>';
}

print '<tr><td colspan="3" class="SA_adminarea_statisticbox_row1"><div align="center">&nbsp;</div></td></tr>';
print '<tr><td colspan="3" class="SA_adminarea_statisticbox_row2"><div align="center">[ <a href="pwjafflite_member_sales.php">'.AFF_MA_MEMBERFULLRECORD.'</a> ]</div></td></tr></table><br />';

?>
<br />
<table class="SA_adminarea_statisticbox" cellspacing="1">
    <tr>
        <td class="SA_adminarea_statisticbox_header"><?=AFF_MA_MEMBERTERMSINFO?></td>
    </tr>
    <tr>
    <?
    // Dapatkan Notis / Terma Affiliate
    $noticedata = mysql_query("SELECT * FROM notisagen", $database_connection) or die ("Database Notice Connect Error");
    if (mysql_num_rows($noticedata))
    {
        while ($qrynotice = mysql_fetch_array($noticedata))
        {
            print '<td class="SA_adminarea_statisticbox_row1"><br  />'.$qrynotice['kandungannotis'].'<br /><br /></td>';
        }
    }
    ?>
    </tr>
</table>
<br />
<?
//Paparkan Keputusan TOP Affiliate

$resulttopaffiliate = mysql_query("SELECT refid, sum(payment) as payments, count(payment) as salescount FROM sales WHERE statuspelanggan = '$statusverified' group by refid ORDER BY salescount desc LIMIT $cartatopaffiliate", $database_connection) or die ("Database Sales Connect Error");
if (mysql_num_rows($resulttopaffiliate))
{
    print '<br /><table class="SA_adminarea_statisticbox" cellspacing="1">';
    print '<tr><td colspan="3" class="SA_adminarea_statisticbox_header">'.AFF_MA_MEMBERTOPAFFILIATEINFO.'</td></tr>';
    print '<tr><td colspan="3" class="SA_adminarea_statisticbox_row1"><br />'.$topaffiliatenotis.'<br /><br /></td>';
    print '<tr><td class="SA_adminarea_statisticbox_header">'.AFF_MA_MEMBERTOPAFF.'</td><td class="SA_adminarea_statisticbox_header">'.AFF_MA_MEMBERTOPSALES.'</td><td class="SA_adminarea_statisticbox_header">'.AFF_MA_MEMBERTOPCOMMISSION.'</td>';

    $sumall     = 0;
    $sumsales   = 0;
    while ($qry = mysql_fetch_array($resulttopaffiliate))
    {
        $sumall     += $qry['payments'];
        $sumsales   += $qry['salescount'];

        print '<tr>';
        print '<td class="SA_adminarea_statisticbox_row1"><div align="center">'.$qry['refid'].'</div></td>';
        print '<td class="SA_adminarea_statisticbox_row2"><div align="right">'.$qry['salescount'].' '.AFF_AA_UNIT.'</div></td>';
        print '<td class="SA_adminarea_statisticbox_row1"><div align="right">'.$currency.' '.$qry['payments'].'</div></td>';
        print '</tr>';

    }
    print '<tr><td colspan="3" class="SA_adminarea_statisticbox_row1"><div align="center">&nbsp;</div></td></tr>';
    print '<tr><td colspan="3" class="SA_adminarea_statisticbox_row2"><div align="center">[ <a href="pwjafflite_member_topaffiliates.php">'.AFF_MA_MEMBERTOPSALESFULLRECORD.'</a> ]</div></td></tr>';
    print '</table><br />';
}

?>
<br />
<table class="SA_adminarea_statisticbox" cellspacing="1">
    <tr>
        <td class="SA_adminarea_statisticbox_header"><?=AFF_MA_MEMBEROPTIN?></td>
    </tr>
    <tr>
    <?
    // Dapatkan Borang OPT-IN Admin

    $optindata = mysql_query("SELECT * FROM optinadmin", $database_connection) or die ("Database OPTIN Connect Error");
    if (mysql_num_rows($optindata))
    {
        while ($qryoptin = mysql_fetch_array($optindata))
        {
            print '<td class="SA_adminarea_statisticbox_row1"><br /><div align="center">'.$qryoptin['optincode'].'</div><br  /><br  /></td>';
        }
    }
    ?>
    </tr>
</table>
<br />
<br />
<table cellspacing="1" class="SA_adminarea_greeting">
    <tr>
        <td class="SA_adminarea_greeting_header"><?=AFF_MA_MEMBERADS?></td>
    </tr>
    <tr>
        <td class="SA_adminarea_greeting_row1">
            <br />
            <?
            //Dapatkan Maklumat Iklan dari Admin
            $adsdata = mysql_query("SELECT * FROM iklanadmin", $database_connection) or die ("Database Iklan Connect Error");
            if (mysql_num_rows($adsdata))
            {
                while ($qryads = mysql_fetch_array($adsdata))
                {
                    echo $qryads['kandunganiklan'];
                }
            }
            ?>
            <br />
        </td>
    </tr>
</table>
<br />
<?

// Tutup Query Data Affiliate
    }
}

//Papar Footer Dari Fail pwjafflite_config.php
echo $footerdisplay;

?>
