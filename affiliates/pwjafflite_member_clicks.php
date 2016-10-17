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
  
  
////////////// Setup Paging Sistem///////////

$salesPage = 50;
function buildLeadIndex($qty, $salesPage) {
	if($qty > $salesPage) {
		echo 'Page: ';
		$index = 0;
		$start = 0;
		while($qty > 0) {
			echo '[<a href="pwjafflite_member_clicks.php?details='.$_REQUEST['details'].'&start='.$start.'">'.++$index.'</a>] ';
			$qty = $qty - $salesPage;
			$start = $start + $salesPage;
		}
	}

}


// get total Clicks
$qryT = mysql_query("SELECT * FROM clickthroughs WHERE refid = '".$_SESSION['aff_valid_user']."'", $database_connection);
$totalClicks = mysql_num_rows($qryT);

// get Clicks
if($_REQUEST[start]) { $start = $_REQUEST[start]; }
else { $start = 0; }

$query = "SELECT * FROM clickthroughs WHERE refid = '".$_SESSION['aff_valid_user']."' ORDER BY date DESC, time DESC LIMIT $start, $salesPage";
$result = mysql_query($query, $database_connection) or die ("Database Query Error");

if (mysql_num_rows($result) > 0) 
{
    //Papar Informasi Klik
    print "<br /><table cellspacing=\"1\" class=\"SA_general_table\">";
    print "<tr><td colspan=\"3\" class=\"SA_general_table_header\">".AFF_C_CLICKSFROM." - ".$_SESSION['aff_valid_user']."</td></tr>";
    print "<tr><td class=\"SA_general_table_row1\">".AFF_C_TOTALCLICK."</td>";
    print "<td class=\"SA_general_table_row2\"><div align=\"center\">:</div></td>";
    print "<td class=\"SA_general_table_row1\"><div align=\"right\">$totalClicks click(s)</div></td></tr>";
    print "<tr><td colspan=\"3\" class=\"SA_general_table_row2\"><div id=\"text\" align=\"center\">";
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

//Papar Informasi Jika Tiada Jualan Terhasi Lagi
else echo "<br /><table cellspacing=\"1\" class=\"SA_norecord_box\"><tr><td><br />".AFF_AC_STATISTICPROBLEMCLICK."<br /><br /></td></tr></table><br />"; 

//Papar Footer
echo $footerdisplay; 

?>