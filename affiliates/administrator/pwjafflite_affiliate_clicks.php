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
$details    = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['details']);
$result     = mysql_query("SELECT * FROM affiliates ORDER BY refid", $database_connection) or die ("Database Error");

if (mysql_num_rows($result))
{
    while ($qry = mysql_fetch_array($result))
    {
        print"<option value=".$qry['refid'].">".$qry['refid']."</option>";
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

$salesPage = 30;
function buildLeadIndex($qty, $salesPage) {
	if($qty > $salesPage) {
		echo "Page: ";
		$index = 0;
		$start = 0;
		while($qty > 0) {
			echo "[<a href=\"pwjafflite_affiliate_clicks.php?details=".$_REQUEST['details']."&start=".$start."\">".++$index."</a>] ";
			$qty = $qty - $salesPage;
			$start = $start + $salesPage;
		}
	}

}

// get total Clicks
$qryT = mysql_query("SELECT * FROM clickthroughs WHERE refid = '$details'", $database_connection) or die ("Database Error");
$totalClicks = mysql_num_rows($qryT);

// get Clicks
if($_REQUEST[start]) { $start = $_REQUEST[start]; }
else { $start = 0; }

$query = "SELECT * FROM clickthroughs WHERE refid = '$details' ORDER BY date DESC, time DESC LIMIT $start, $salesPage";
$result = mysql_query($query, $database_connection) or die ("Database Error");


if (mysql_num_rows($result) > 0)
{
    //Papar Informasi Klik
    print "<br /><table cellspacing=\"1\" class=\"SA_general_table\">";
    print "<tr><td colspan=\"4\" class=\"SA_general_table_header\">".AFF_C_CLICKSFROM." - ".$_REQUEST['details']."</td></tr>";
    print "<tr><td class=\"SA_general_table_row1\">".AFF_C_TOTALCLICK."</td>";
    print "<td class=\"SA_general_table_row2\"><div align=\"center\">:</div></td>";
    print "<td class=\"SA_general_table_row1\"><div align=\"right\">$totalClicks clicks</div></td>";
    print "<td class=\"SA_general_table_row2\"><div align=\"center\">[<a href=\"pwjafflite_clicks_reset.php?agen=".$_REQUEST['details']."&validation=".$_SESSION['aff_valid_admin']."\" onClick=\"return confirm('".AFF_A_RESETCONFIRM."')\">".AFF_A_RESET."</a>]</div></td></tr>";
    print "<tr><td colspan=\"4\" class=\"SA_general_table_row1\"><div id=\"text\" align=\"center\">";
    buildLeadIndex($totalClicks, $salesPage);
    print "</div></td></tr>";
    print "</table><br />";
}	

if (mysql_num_rows($result)) 
{
    print "<br /><table cellspacing=\"1\" class=\"SA_general_table\">";
    print "<tr><td class=\"SA_general_table_header\">".AFF_C_REFERRER."</td><td class=\"SA_general_table_header\">".AFF_G_DATE."</td><td class=\"SA_general_table_header\">".AFF_G_TIME."</td><td class=\"SA_general_table_header\">".AFF_G_IP."</td>";
    print "<td class=\"SA_general_table_header\">".AFF_C_REFERRERURL."</td></tr>";

    while ($qry = mysql_fetch_array($result))
    {
        print "<tr><td class=\"SA_general_table_row1\">";
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

//Papar Informasi Jika Tiada Jualan Terhasi Lagi
else echo "<br /><table cellspacing=\"1\" class=\"SA_norecord_box\"><tr><td><br />".AFF_AC_STATISTICPROBLEMCLICK."<br /><br /></td></tr></table><br />"; 

//Papar Footer
echo $footerdisplay; 

?>