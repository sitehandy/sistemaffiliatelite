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
$status = preg_replace('/[^a-zA-Z0-9_]/', '', $_REQUEST['status']);

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
<form method="get" action="pwjafflite_admin_sales2.php">
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
       <tr><td colspan="3" class="SA_general_table_row2"><div align="center"> 
         <input type="submit" value="<?=AFF_AS_STATUSVIEW?>">
       </div></td>
       </tr>
   </table>
 </form>
<br />
<?

//Papar Informasi Sales

$totalsales = mysql_query("SELECT sum(payment) as payments, count(payment) as salescount from sales WHERE statuspelanggan = '$status'", $database_connection) or die ('Database Error');
$sumall = 0;

if (mysql_num_rows($totalsales))
{
    while ($qry = mysql_fetch_array($totalsales))
    {
        $sumall     += $qry['payments'];
        $sumsales   += $qry['salescount'];

        print '<br /><table cellspacing="1" class="SA_general_table">';
        print '<tr><td colspan="3" class="SA_general_table_header">'.AFF_AS_STATUSJUALANTITLE.' - '.$status.'</td></tr>';
        print '<tr><td class="SA_general_table_row1">'.AFF_AS_STATUSTOTALSALES.' - '.$status.'</td>';
        print '<td class="SA_general_table_row1"><div align="center">:</div></td>';
        print '<td class="SA_general_table_row1"><div align="right">'.$sumsales.' '.AFF_AA_UNIT.'</div></td></tr>';
        print '<tr><td class="SA_general_table_row2">'.AFF_AS_STATUSTOTALCOMMISSION.' - '.$status.'</td>';
        print '<td class="SA_general_table_row2"><div align="center">:</div></td>';
        print '<td class="SA_general_table_row2"><div align="right">'.$currency.' '.$sumall.'</div></td></tr>';
        print '</table><br />';
    }
}

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
			echo '[<a href="pwjafflite_admin_sales2.php?status='.$_REQUEST['status'].'&start='.$start.'">'.++$index.'</a>] ';
			$qty = $qty - $salesPage;
			$start = $start + $salesPage;
		}
	}

}


// get total Sales
$qryT = mysql_query("SELECT * FROM sales WHERE statuspelanggan = '$status'", $database_connection);
$totalSales = mysql_num_rows($qryT);

// get Sales
if($_REQUEST[start]) { $start = $_REQUEST[start]; }
else { $start = 0; }

// Get Sales Record Status

$result = mysql_query("SELECT * FROM sales WHERE statuspelanggan = '$status' ORDER BY idsales DESC LIMIT $start, $salesPage", $database_connection) or die ('Database Error');

//////////////// Papar Senarai Halaman /////////  

if (mysql_num_rows($result) > 0)
{
    print '<br /><table cellspacing="1" class="SA_general_table">';
    print '<tr><td colspan="3" class="SA_general_table_header">'.AFF_AS_SALESSTATUS.' - <b><u>';
    print $status.' </u></b></td></tr>';
    print '<tr><td colspan="3" class="SA_general_table_row1"><div id="text" align="center">';
    buildLeadIndex($totalSales, $salesPage);
    print '</div></td></tr>';
    print '<tr><td colspan="3" class="SA_general_table_row2"><div id="text" align="center">';
    print '<form action="pwjafflite_sales_delete_all.php?delete='.$_REQUEST['status'].'&validation='.$_SESSION['aff_valid_admin'].'" method="POST" ENCTYPE="multipart/form-data"><a href="#" onClick="return confirm(\''.AFF_A_SALESSTATUSRESETCONFIRM.'\')"><input name="markpaid" class="SA_login_button" type="submit" value="'.AFF_A_SALESSTATUSRESET.' - '.$_REQUEST['status'].'" /></a></form>';
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

    while ($qry = mysql_fetch_array($result))
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
else echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_AS_STATUSNORECORD.' - '.$status.'<br /><br /></td></tr></table><br />';

//Papar Footer
echo $footerdisplay;  

?>