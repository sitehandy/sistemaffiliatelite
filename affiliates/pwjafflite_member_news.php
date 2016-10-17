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

$salesPage = 5;
function buildLeadIndex($qty, $salesPage) {
	if($qty > $salesPage) {
		echo 'Page: ';
		$index = 0;
		$start = 0;
		while($qty > 0) {
			echo "[<a href=\"pwjafflite_member_news.php?start=".$start."\">".++$index."</a>] ";
			$qty = $qty - $salesPage;
			$start = $start + $salesPage;
		}
	}

}
// get data from berita
$qryT = mysql_query("SELECT * FROM beritaagen", $database_connection);
$totalSales = mysql_num_rows($qryT);

// get berita page
if($_REQUEST[start]) { $start = $_REQUEST[start]; }
else { $start = 0; }

////Get Clicks Data

$query = "SELECT * FROM beritaagen ORDER BY idberita DESC LIMIT $start, $salesPage";
$result = mysql_query($query, $database_connection) or die ("Database Query Error");


//////////////// Papar Senarai Halaman /////////  

if (mysql_num_rows($result) > 0)  
{
    print "<br /><table width=\"600\" cellspacing=\"1\" class=\"SA_general_table\"><tr><td colspan=\"4\" class=\"SA_general_table_header\">".AFF_MA_MEMBERCURRENTNEWS."</td></td></tr><td colspan=\"4\" class=\"SA_general_table_row1\"><br />".$arahan_berita_member."<br /><br /></td></tr><td colspan=\"4\" class=\"SA_general_table_row2\">";
    buildLeadIndex($totalSales, $salesPage);
    print "</td></tr></table><br />";
	
    while ($qry = mysql_fetch_array($result))
    {
        print "<br /><table width=\"600\" cellspacing=\"1\" class=\"SA_general_table\"><tr>";
        print "<td width=\"5%\" class=\"SA_general_table_header\"><div align=\"right\">";
        print $qry['idberita'];
        print "</div></td>";
        print "<td class=\"SA_general_table_header\">";
        print $qry['tajukberita'];
        print "</td></tr>";
        print "<tr><td colspan=\"2\" class=\"SA_general_table_row1\">".$qry['tarikhberita']."</td></tr>";
        print "<tr><td colspan=\"2\" class=\"SA_general_table_row2\"><br />".$qry['kandunganberita']."<br /></td></tr>";
        print "<tr><td colspan=\"2\" class=\"SA_general_table_row1\">&nbsp;</td></tr></table><br />";

   }
}

else echo "<br /><table cellspacing=\"1\" class=\"SA_norecord_box\"><tr><td><br />".AFF_MA_MEMBERNONEWS."<br /><br /></td></tr></table><br />";

//Papar Footer
echo $footerdisplay; 

?>