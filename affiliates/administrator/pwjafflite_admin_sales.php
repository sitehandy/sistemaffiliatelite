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

?>
<script language="javascript">
function checkAll(sales_records, checktoggle)
{
  var checkboxes = new Array(); 
  checkboxes = document[sales_records].getElementsByTagName('input');
 
  for (var i=0; i<checkboxes.length; i++)  {
    if (checkboxes[i].type == 'checkbox')   {
      checkboxes[i].checked = checktoggle;
    }
  }
}
</script>
<br />
<form name="sales_agen" method="get" action="pwjafflite_affiliate_sales.php">
    <table width="400" cellspacing="1" class="SA_general_table">
        <tr>
            <td colspan="3" class="SA_general_table_header"><?=AFF_S_INFOAGEN?></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><?=AFF_S_SHOWSALESFOR?></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1"><div align="center">
                    <select name="agen">
<?          

// Dapatkan Data Affiliate
$result = mysql_query("SELECT refid FROM affiliates ORDER BY refid", $database_connection) or die ('Database Error');

if (mysql_num_rows($result))
{
    while ($qry = mysql_fetch_array($result))
    {
        print '<option value='.$qry['refid'].'>'.$qry['refid'].'</option>';
    }
}

?>
                    </select></div>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row2">
                <div align="center">
                    <input type="hidden" name="status" value="<?=AFF_AS_STATUSPENDING?>">
                    <input type="submit" value="<?=AFF_G_SHOW?>">
                </div>
            </td>
        </tr>
    </table>
</form>
<br />
<br />
<form name="sales_status" method="get" action="pwjafflite_admin_sales2.php">
    <table width="400" cellspacing="1" class="SA_general_table">
        <tr>
            <td colspan="3" class="SA_general_table_header"><?=AFF_AS_STATUSCHOOSE?></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><?=AFF_AS_STATUSOPTION?></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1">
                <div align="center">
                    <select name="status">
                        <option><?=AFF_AS_STATUSPENDING?></option>
                        <option><?=AFF_AS_STATUSVERIFIED?></option>
                        <option><?=AFF_AS_STATUSPAID?></option>
                        <option><?=AFF_AS_STATUSCANCELLED?></option>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row2">
                <div align="center">
                    <input type="submit" value="<?=AFF_AS_STATUSVIEW?>">
                </div>
            </td>
        </tr>
    </table>
</form>
<br />
<?

// Papar Statistic Sistem Affiliate 

// Papar Jumlah Agen Affiliate
$totalaff = mysql_query("SELECT * FROM affiliates", $database_connection) or die ('Database Error');

$totalmembers = mysql_num_rows($totalaff);
print '<br /><table cellspacing="1" class="SA_adminarea_statisticbox"><tr>';
print '<td colspan="3" class="SA_adminarea_statisticbox_header">'.AFF_AA_ADMINSTATISTIC.'</td></tr>';
print '<tr><td class="SA_adminarea_statisticbox_row1">'.AFF_AA_TOTALAFFILIATE.'</td>';
print '<td class="SA_adminarea_statisticbox_row1"><div align="right">';
print $totalmembers;
print '</div></td>';
print '<td class="SA_adminarea_statisticbox_row1"><div align="right">';
print AFF_AA_TOTALAFFILIATETITLE;
print '</div></td></tr>';

// Jumlah Keseluruhan Jualan Menerusi Sistem Affiliate
// Jumlah Jualan PENDING
$statuspending = AFF_AS_STATUSPENDING;

$querystatuspending = mysql_query("SELECT sum(payment) AS pendingpayments, count(payment) AS pendingsalescount FROM sales WHERE statuspelanggan = '$statuspending'", $database_connection) or die ('Database Error');

if (mysql_num_rows($querystatuspending))
{
    $sumpending         = 0;
    $sumpendingsales    = 0;

    while ($qrypending = mysql_fetch_array($querystatuspending))
    {
        $sumpending += $qrypending['pendingpayments'];
        $sumpendingsales += $qrypending['pendingsalescount'];

        print '<tr><td class="SA_adminarea_statisticbox_row2">'.AFF_AA_TOTALAFFILIATESALES.' - <font color="#FF0000">'.$statuspending.'</font></td>';
        print '<td class="SA_adminarea_statisticbox_row2"><div align="right">'.$sumpendingsales.' '.AFF_AA_UNIT.'</div></td>';
        print '<td class="SA_adminarea_statisticbox_row2"><div align="right">'.$currency.' '.$sumpending.'</div></td></tr>';
    }
}

// Jumlah Jualan VERIFIED
$statusverified = AFF_AS_STATUSVERIFIED;

$querystatusverified = mysql_query("SELECT sum(payment) AS verifiedpayments, count(payment) AS verifiedsalescount from sales WHERE statuspelanggan = '$statusverified'", $database_connection) or die ('Database Error');

if (mysql_num_rows($querystatusverified))
{
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
}

// Jumlah Jualan PAID
$statuspaid = AFF_AS_STATUSPAID;

$querystatuspaid = mysql_query("SELECT sum(payment) AS paidpayments, count(payment) AS paidsalescount from sales WHERE statuspelanggan = '$statuspaid'", $database_connection) or die ('Database Error');

if (mysql_num_rows($querystatuspaid))
{
    $sumpaid        = 0;
    $sumpaidsales   = 0;

    while ($qrypaid = mysql_fetch_array($querystatuspaid))
    {
        $sumpaid        += $qrypaid['paidpayments'];
        $sumpaidsales   += $qrypaid['paidsalescount'];

        print '<tr><td class="SA_adminarea_statisticbox_row2">'.AFF_AA_TOTALAFFILIATESALES.' - <font color="#0000FF">'.$statuspaid.'</font></td>';
        print '<td class="SA_adminarea_statisticbox_row2"><div align="right">'.$sumpaidsales.' '.AFF_AA_UNIT.'</div></td>';
        print '<td class="SA_adminarea_statisticbox_row2"><div align="right">'.$currency.' '.$sumpaid.'</div></td></tr>';
    }
}

// Jumlah KESELURUHAN Jualan
$querytotal = mysql_query("SELECT sum(payment) AS payments, count(payment) AS salescount FROM sales", $database_connection) or die ('Database Error');

if (mysql_num_rows($querytotal))
{
    $sumall     = 0;
    $sumsales   = 0;

    while ($qrytotalcommission = mysql_fetch_array($querytotal))
    {
        $sumall += $qrytotalcommission['payments'];
        $sumsales += $qrytotalcommission['salescount'];
        
        print '<tr><td class="SA_adminarea_statisticbox_row1"><b>'.AFF_AA_TOTALSALES.'</b></td>';
        print '<td class="SA_adminarea_statisticbox_row1"><div align="right"><b>'.$sumsales.' '.AFF_AA_UNIT.'</b></div></td>';
        print '<td class="SA_adminarea_statisticbox_row1"><div align="right"><b>'.$currency.' '.$sumall.'</b></div></td></tr>';
    }
}

print '</table><br />';
	
	
////////////// Setup Paging Sistem///////////

$salesPage = 20;
function buildLeadIndex($qty, $salesPage)
{
    if($qty > $salesPage)
    {
        echo 'Page(s): ';
        $index = 0;
        $start = 0;
        while($qty > 0)
	{
            echo '[<a href="pwjafflite_admin_sales.php?start='.$start.'">'.++$index.'</a>]';
            $qty = $qty - $salesPage;
            $start = $start + $salesPage;
	}
    }
}


// get total Sales
$qryT = mysql_query("SELECT * FROM sales", $database_connection) or die ('Database Error');
$totalSales = mysql_num_rows($qryT);

// get Sales
if($_REQUEST[start]) { $start = $_REQUEST[start]; }
else { $start = 0; }

////Get Clicks Data

$querysalesrecords = mysql_query("SELECT * FROM sales ORDER BY idsales DESC LIMIT $start, $salesPage", $database_connection) or die ('Database Error');

//////////////// Papar Senarai Halaman /////////  

if (mysql_num_rows($querysalesrecords) > 0)
{
    print '<br /><table cellspacing="1" class="SA_general_table">';
    print '<tr><td colspan="3" class="SA_general_table_header">'.AFF_AS_SALESCOMMISSIONTITLE.' - <b><u>';
    print $currency.' '.$sumall.' <-> '.$totalSales.' Units</u></b></td></tr>';
    print '<tr><td colspan="3" class="SA_general_table_row1"><div id="text" align="center">';
    buildLeadIndex($totalSales, $salesPage);
    print '</div></td></tr>';
    print '<tr><td colspan="3" class="SA_general_table_row2"><div id="text" align="center">';
    print '<form action="pwjafflite_sales_delete_all.php?delete=allsalesrecords&validation='.$_SESSION['aff_valid_admin'].'" method="POST" ENCTYPE="multipart/form-data"><a href="#" onClick="return confirm(\''.AFF_A_SALESRESETCONFIRM.'\')"><input name="markpaid" class="SA_login_button" type="submit" value="'.AFF_A_SALESRESET.'" /></a></form>';
    print '</div></td></tr>';
    print '</table><br />';

    //Papar Data Sales
    print '<form id="sales_records" name="sales_records" method="post" action="pwjafflite_multiple_action.php">';
    print '<br /><table cellspacing="1" class="SA_details_table">';
    print '<tr><td class="SA_details_table_header"></td>';
    print '<td class="SA_details_table_header">'.AFF_C_REFERRER.'</td>';
    print '<td class="SA_details_table_header">'.AFF_G_PRODUKJUALAN.'</td>';
    print '<td class="SA_details_table_header">'.AFF_G_KAEDAHPEMBAYARAN.'</td>';
    print '<td class="SA_details_table_header">'.AFF_G_DATE.'</td>';
    print '<td class="SA_details_table_header">'.AFF_G_TIME.'</td>';
    print '<td class="SA_details_table_header">'.AFF_G_EARNINGS.'</td>';
    print '<td class="SA_details_table_header">'.AFF_G_IPPELANGGAN.'</td>';
    print '<td class="SA_details_table_header">'.AFF_G_BROWSER.'</td>';
    print '<td class="SA_details_table_header">'.AFF_G_PELANGGAN.'</td>';
    print '<td class="SA_details_table_header">'.AFF_G_EMAILPELANGGAN.'</td>';
    print '<td class="SA_details_table_header">'.AFF_G_STATUSPELANGGAN.'</td>';
    print '<td class="SA_details_table_header">'.AFF_G_SAHKOMISYEN.'</td></tr>';

    while ($qry = mysql_fetch_array($querysalesrecords))
    {
        print '<tr>';
        print '<td class="SA_details_table_row2"><input name="checkbox[]" type="checkbox" id="checkbox[]" value="'.$qry['idsales'].'"></td>';
        print '<td class="SA_details_table_row1"><a href="pwjafflite_affiliate_profile.php?edit='.$qry['refid'].'">'.$qry['refid'].'</a></td>';
        print '<td class="SA_details_table_row2"><div align="center">';
        print $qry['jumlahpembayaran'];
        print '</div></td>';
        print '<td class="SA_details_table_row1"><div align="center">';
        print $qry['kaedahpembayaran'];
        print '</div></td>';
        print '<td class="SA_details_table_row2"><div align="center">';
        print $qry['date'];
        print '</div></td>';
        print '<td class="SA_details_table_row1"><div align="center">';
        print $qry['time'];
        print '</div></td>';
        print '<td class="SA_details_table_row2"><div align="center">';
        print $qry['payment'];
        print '</div></td>';
        print '<td class="SA_details_table_row1"><div align="center">';
        print $qry['ipaddress'];
        print '</div></td>';
        print '<td class="SA_details_table_row2"><div align="center">';
        print $qry['browser'];
        print '</div></td>';
        print '<td class="SA_details_table_row1"><div align="center">';
        print $qry['namapelanggan'];
        print '</div></td>';
        print '<td class="SA_details_table_row2"><div align="center">';
        print '<a href="pwjafflite_admin_client.php?idjualan='.$qry['idsales'].'" toptions="width = 550, height = 500, type = iframe, title = Sistem Affiliate Lite, layout = quicklook">';
        print $qry['emailpelanggan'];
        print '</a></div></td>';
        print '<td class="SA_details_table_row1"><div align="center"><a href="pwjafflite_admin_sahkomisyen.php?pembeli='.$qry['idsales'].' "onClick="return confirm(\''.AFF_AS_SAH.'\')"">'.$qry['statuspelanggan'].'</a></div></td>';
        print '<td class="SA_details_table_row2"><center>[<a href="pwjafflite_sales_delete.php?delete='.$qry['idsales'].'&validation='.$_SESSION['aff_valid_admin'].'" onClick="return confirm(\''.AFF_P_DELETE.'\')"">Delete</a>]';
        print '<br />[<a href="pwjafflite_sales_edit.php?salesid='.$qry['idsales'].'&validation='.$_SESSION['aff_valid_admin'].' "onClick="return confirm(\''.AFF_P_EDIT.'\')"">Edit</a>]</center></td>';
        print '</tr>';        
    }
    print '<tr><td colspan="13" class="SA_details_table_header" style="text-align: left;">
        <a href="javascript:void();" onclick="javascript:checkAll(\'sales_records\', true);">Check All</a> | 
        <a href="javascript:void();" onclick="javascript:checkAll(\'sales_records\', false);">Un-Check All</a> 
        <select name="action">
        <option value="null">With selected...</option>
        <option value="paid">Mark as Paid</option>
        <option value="verified">Mark as Verified</option>
        <option value="pending">Mark as Pending</option>
        <option value="cancel">Mark as Cancel</option>
        <option value="delete">Delete Selected</option>        
        </select>&nbsp;<input type="submit" name="submit" value="Take Action" /></td></tr>';
    print '</table><br /></form>';
}

//Papar Informasi Jika Tiada Jualan Terhasi Lagi
else echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_S_TIADAJUALAN.'<br /><br /></td></tr></table><br />';

//Papar Footer
echo $footerdisplay;  

?>