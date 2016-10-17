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

<br />
<form method="get" action="pwjafflite_affiliate_clicks.php">
    <table width="400"  cellspacing="1" class="SA_general_table">
        <tr>
            <td colspan="3" class="SA_general_table_header"><?=AFF_C_CLICKSINFO?></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><?=AFF_C_SHOWCLICKSFOR?></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1">
                <div align="center">
                    <select name="details">
<?          

//Dapatkan Data Affiliate
$result = mysql_query("SELECT * from affiliates ORDER BY refid", $database_connection) or die ("Database Error");

if (mysql_num_rows($result))
{
    while ($qry = mysql_fetch_array($result))
    {
        print "<option value=".$qry['refid'].">".$qry['refid']."</option>";
    }
}

?>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row2">
                <div align="center">
                    <input type="submit" value="<?=AFF_G_SHOW?>">
                </div>
            </td>
        </tr>
    </table>
</form>
<br />

<?    

////////////// Setup Paging Sistem///////////

$clicksPage = 50;
function buildLeadIndex($qty, $clicksPage) {
	if($qty > $clicksPage) {
		echo "Page: ";
		$index = 0;
		$start = 0;
		while($qty > 0) {
			echo "[<a href=\"pwjafflite_admin_clicks.php?start=".$start."\">".++$index."</a>] ";
			$qty = $qty - $clicksPage;
			$start = $start + $clicksPage;
		}
	}

}


// get total clicks
$qryT = mysql_query("SELECT * FROM clickthroughs", $database_connection);
$totalClicks = mysql_num_rows($qryT);

// get clicks
if($_REQUEST[start]) { $start = $_REQUEST[start]; }
else { $start = 0; }

////Get Clicks Data

$query = "SELECT * FROM clickthroughs ORDER BY date DESC, time DESC LIMIT $start, $clicksPage";
$result = mysql_query($query, $database_connection);
echo mysql_error();


//////////////// Papar Senarai Halaman /////////  

if (mysql_num_rows($result) > 0) 
{
    print "<br /><table cellspacing=\"1\" class=\"SA_general_table\">";
    print "<tr><td colspan=\"3\" class=\"SA_general_table_header\">".AFF_C_INFO."<b><u>";
    print $totalClicks."</u></b></td></tr>";
    print "<tr><td colspan=\"3\" class=\"SA_general_table_row1\"><div id=\"text\" align=\"center\">";
    buildLeadIndex($totalClicks, $clicksPage);
    print "</div></td></tr>";
    print "<tr><td class=\"SA_general_table_row2\"><div align=\"center\"><form action=\"pwjafflite_clicks_reset_all.php?reset=allclicksrecords&validation=".$_SESSION['aff_valid_admin']."\" method=\"POST\" ENCTYPE=\"multipart/form-data\"><a href=\"#\" onClick=\"return confirm('".AFF_A_CLICKRESETCONFIRM."')\"><input name=\"markpaid\" class=\"SA_login_button\" type=\"submit\" value=\"".AFF_A_CLICKRESET."\" /></a></form></a></div></td></tr>";
    print "</table><br />";
    
    //Papar Informasi Click
    print "<br /><table cellspacing=\"1\" class=\"SA_general_table\">";
    print "<tr><td class=\"SA_general_table_header\">".AFF_C_REFERRER."</td><td class=\"SA_general_table_header\">".AFF_G_DATE."</td><td class=\"SA_general_table_header\">".AFF_G_TIME."</td><td class=\"SA_general_table_header\">".AFF_G_IP."</td>";
    print "<td class=\"SA_general_table_header\">".AFF_C_REFERRERURL."</td></tr>";

    while ($qry = mysql_fetch_array($result))
    {
        print "<tr>";
        print "<td class=\"SA_general_table_row1\">";
        print $qry['refid'];
        print "</td>";
        print "<td class=\"SA_general_table_row2\">";
        print $qry['date'];
        print "</td>";
        print "<td class=\"SA_general_table_row1\">";
        print $qry['time'];
        print "</td>";
        print "<td class=\"SA_general_table_row2\">";
        print $qry['ipaddress'];
        print "</td>";
        print "<td class=\"SA_general_table_row1\">";
        print $qry['refferalurl'];
        print "</td>";
        print "</tr>";
    }
    print "</table><br />";
}

//Papar Informasi Jika Tiada Klik Terhasil Lagi
else echo "<br /><table cellspacing=\"1\" class=\"SA_norecord_box\"><tr><td><br />".AFF_AC_STATISTICPROBLEMCLICK."<br /><br /></td></tr></table><br />";  

//Papar Footer
echo $footerdisplay; 

?>