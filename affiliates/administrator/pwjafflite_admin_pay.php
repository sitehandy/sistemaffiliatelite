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

echo '<br /><table cellspacing="1" class="SA_adminarea_statisticbox"><tr><td class="SA_adminarea_statisticbox_header">'.AFF_AA_COMMISSIONPAIDINFO.'</td></tr><tr><td class="SA_adminarea_statisticbox_row1">'.$amaranbayarkomisyen.'<br /></td></tr></table><br />';

// Dapatkan data sales
$result = mysql_query("SELECT refid, sum(payment) as payments, count(payment) as salescount from sales WHERE statuspelanggan = '".AFF_AS_STATUSVERIFIED."' group by refid ORDER BY salescount desc", $database_connection) or die ('Database CONNECT Error');
  
if (mysql_num_rows($result))
{
    print '<br /><table cellspacing="1" class="SA_adminarea_statisticbox">';
    print '<tr><td colspan="4" class="SA_adminarea_statisticbox_header">'.AFF_AA_COMMISSIONPAIDTOTITLE.'</td><tr>';
    print '<tr><td colspan="4" class="SA_adminarea_statisticbox_row1"><br />'.$instruction_affiliate_pay.'<br /><br /></td><tr>';
    print '<tr><td class="SA_adminarea_statisticbox_header">'.AFF_AA_IDAFFILIATE.'</td><td class="SA_adminarea_statisticbox_header">'.AFF_A_SALESCOUNT.'</td><td class="SA_adminarea_statisticbox_header">'.AFF_A_EARNED.'</td><td class="SA_adminarea_statisticbox_header">'.AFF_G_ACTION.'</td></tr>';

    // Papar Jumlah Jualan
    $sumall = 0;
    while ($qry = mysql_fetch_array($result))
    {
        $sumall     += $qry['payments'];
        $sumsales   += $qry['salescount'];

        print '<tr><td class="SA_adminarea_statisticbox_row1"><div align="center"><a href="pwjafflite_affiliate_sales.php?agen='.$qry['refid'].'&status='.AFF_AS_STATUSVERIFIED.'">'.$qry['refid'].'</a></div></td>';
        print '<td class="SA_adminarea_statisticbox_row2"><div align="center">'.$qry['salescount'].' '.AFF_AA_UNIT.'</div></td>';
        print '<td class="SA_adminarea_statisticbox_row1"><div align="center">'.$qry['payments'].' '.$currency.'</div></td>';
        print '<td class="SA_adminarea_statisticbox_row2"><div align="center"><form action="pwjafflite_commission_paid.php?agen='.$qry['refid'].'" method="POST" ENCTYPE="multipart/form-data">';
        print '<a href="pwjafflite_admin_invoice.php?agen='.$qry['refid'].'" toptions="width = 550, height = 500, type = iframe, title = Sistem Affiliate Lite, layout = quicklook"><input class="SA_login_button" type="submit" value="'.AFF_A_INVOICE.'" /></a> ';
        print '<a href="#" onClick="return confirm(\''.AFF_A_SAHTANDAPAID.'\')"><input name="markpaid" class="SA_login_button" type="submit" value="'.AFF_A_TANDAPAID.'" /></a>';
        print '</form></div></td></tr>';
    }
    print '<tr><td class="SA_adminarea_statisticbox_row2" colspan="4">&nbsp;</td></tr>';
    print '<tr><td class="SA_adminarea_statisticbox_header"><div align="center"><b>'.AFF_A_TOTAL.'</b></div></td><td class="SA_adminarea_statisticbox_header"><div align="center"><b>'.$sumsales.' '.AFF_AA_UNIT.'</b></div></td><td class="SA_adminarea_statisticbox_header"><div align="center"><b>'.$sumall.' '.$currency.'</b></div></td><td class="SA_adminarea_statisticbox_header"><div align="center"><form action="pwjafflite_sales_delete_all.php?delete=allsalesrecords&validation='.$_SESSION['aff_valid_admin'].'" method="POST" ENCTYPE="multipart/form-data"><a href="#" onClick="return confirm(\''.AFF_A_SALESRESETCONFIRM.'\')"><input name="markpaid" class="SA_login_button" type="submit" value="'.AFF_A_SALESRESET.'" /></a></form></div></td></tr>';
    print '</table><br />';
}

//Papar Informasi Jika Tiada Jualan Terhasi Lagi
else echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_S_TIADAJUALAN.'<br /><br /></td></tr></table><br />';  

//Papar Footer
echo $footerdisplay;   

?>