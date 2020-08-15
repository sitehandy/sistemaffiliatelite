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

// protection against script injection
$status = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['status']);

?>
<br />
<form method="get" action="pwjafflite_member_sales2.php">
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

//Papar Informasi Sales

$querysales = mysql_query("select sum(payment) as payments, count(payment) as salescount from sales WHERE refid = '".$_SESSION['aff_valid_user']."' AND statuspelanggan = '$status'", $database_connection) or die ("Database Error");

$sumall = 0;
while ($qry = mysql_fetch_array($querysales))
{
    $sumall     += $qry['payments'];
    $sumsales   += $qry['salescount'];

    print "<br /><table cellspacing=\"1\" class=\"SA_general_table\">";
    print "<tr><td colspan=\"3\" class=\"SA_general_table_header\">".AFF_AS_STATUSJUALANTITLE." - $status</td></tr>";
    print "<tr><td class=\"SA_general_table_row1\">".AFF_AS_STATUSTOTALSALES." - $status</td>";
    print "<td class=\"SA_general_table_row1\"><div align=\"center\">:</div></td>";
    print "<td class=\"SA_general_table_row1\"><div align=\"right\">$sumsales ".AFF_AA_UNIT."</div></td></tr>";
    print "<tr><td class=\"SA_general_table_row2\">".AFF_AS_STATUSTOTALCOMMISSION." - $status</td>";
    print "<td class=\"SA_general_table_row2\"><div align=\"center\">:</div></td>";
    print "<td class=\"SA_general_table_row2\"><div align=\"right\">$currency $sumall</div></td></tr>";
    print "</table><br />";

}

////////////// Setup Paging Sistem///////////

$salesPage = 20;
function buildLeadIndex($qty, $salesPage) {
	if($qty > $salesPage) {
		echo "Page: ";
		$index = 0;
		$start = 0;
		while($qty > 0) {
			echo "[<a href=\"pwjafflite_member_sales2.php?status=".$_REQUEST['status']."&start=".$start."\">".++$index."</a>] ";
			$qty = $qty - $salesPage;
			$start = $start + $salesPage;
		}
	}

}


// get total Sales
$qryT = mysql_query("SELECT * FROM sales WHERE refid = '".$_SESSION['aff_valid_user']."' AND statuspelanggan = '$status'", $database_connection);
$totalSales = mysql_num_rows($qryT);

// get Sales
if($_REQUEST[start]) { $start = $_REQUEST[start]; }
else { $start = 0; }

////Get Clicks Data

$query = "SELECT * FROM sales WHERE refid = '".$_SESSION['aff_valid_user']."' AND statuspelanggan = '$status' ORDER BY idsales DESC LIMIT $start, $salesPage";
$result = mysql_query($query, $database_connection) or die ("Database Query Error");


//////////////// Papar Senarai Halaman /////////
if (mysql_num_rows($result) > 0)
{
    print "<br /><table cellspacing=\"1\" class=\"SA_general_table\">";
    print "<tr><td colspan=\"3\" class=\"SA_general_table_header\">".AFF_AS_SALESSTATUS." - <b><u>";
    print $status." </u></b></td></tr>";
    print "<tr><td colspan=\"3\" class=\"SA_general_table_row1\"><div id=\"text\" align=\"center\">";
    buildLeadIndex($totalSales, $salesPage);
    print "</div></td></tr>";
    print "</table><br />";

//Papar Data Sales

    print "<br /><table cellspacing=\"1\" class=\"SA_details_table\">";
    print "<tr><td class=\"SA_details_table_header\">".AFF_C_REFERRER."</td>";
    print "<td class=\"SA_details_table_header\">".AFF_G_PRODUKJUALAN."</td>";
    print "<td class=\"SA_details_table_header\">".AFF_G_KAEDAHPEMBAYARAN."</td>";
    print "<td class=\"SA_details_table_header\">".AFF_G_DATE."</td>";
    print "<td class=\"SA_details_table_header\">".AFF_G_TIME."</td>";
    print "<td class=\"SA_details_table_header\">".AFF_G_EARNINGS."</td>";
    print "<td class=\"SA_details_table_header\">".AFF_G_PELANGGAN."</td>";
    print "<td class=\"SA_details_table_header\">".AFF_G_EMAILPELANGGAN."</td>";
    print "<td class=\"SA_details_table_header\">".AFF_G_STATUSPELANGGAN."</td>";

    while ($qry = mysql_fetch_array($result))
    {
        print "<tr>";
        print "<td class=\"SA_details_table_row1\">".$qry['refid']."";
        print "</td>";
        print "<td class=\"SA_details_table_row2\"><div align=\"center\">";
        print $qry['jumlahpembayaran'];
        print "</div></td>";
        print "<td class=\"SA_details_table_row1\"><div align=\"center\">";
        if (!is_null($qry['transaction_id']))
        {
            print $qry['transaction_id'];
        }
        else
        {
            print $qry['kaedahpembayaran'];
        }
        print "</div></td>";
        print "<td class=\"SA_details_table_row2\"><div align=\"center\">";
        print $qry['date'];
        print "</div></td>";
        print "<td class=\"SA_details_table_row1\"><div align=\"center\">";
        print $qry['time'];
        print "</div></td>";
        print "<td class=\"SA_details_table_row2\"><div align=\"center\">";
        print $qry['payment'];
        print "</div></td>";
        print "<td class=\"SA_details_table_row1\"><div align=\"center\">";
        print $qry['namapelanggan'];
        print "</div></td>";
        print "<td class=\"SA_details_table_row2\"><div align=\"center\">";
        print "<a href=\"pwjafflite_member_client.php?idjualan=".$qry['idsales']."\" toptions=\"width = 550, height = 500, type = iframe, title = Sistem Affiliate Lite, layout = quicklook\">";
        print $qry['emailpelanggan'];
        print "</a></div></td>";
        print "<td class=\"SA_details_table_row1\"><div align=\"center\">".$qry['statuspelanggan']."</div></td>";
        print "</tr>";
    }
    print "</table><br />";
}

//Papar Informasi Jika Tiada Jualan Terhasi Lagi
else echo "<br /><table cellspacing=\"1\" class=\"SA_norecord_box\"><tr><td><br />".AFF_AS_STATUSNORECORD." - $status<br /><br /></td></tr></table><br />";

//Papar Footer
echo $footerdisplay;

?>
