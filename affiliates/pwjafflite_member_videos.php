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

?>	

<br  />
<table cellspacing="1" class="SA_adminarea_statisticbox">
    <tr>
        <td class="SA_adminarea_statisticbox_header"><?=AFF_MA_MEMBERAFFLINK?></td>
    </tr>
    <tr>
        <td class="SA_adminarea_statisticbox_row1">
            <div align="center">
                <input name="linkaffiliate" type="text" size="70" value="http://<? echo $domain ?>/hop.php?ref=<? print $_SESSION['aff_valid_user']?>">
            </div>
        </td>
    </tr>
    <tr>
        <td class="SA_adminarea_statisticbox_row2">
            <div align="center">
                [ <a href="http://<? echo $domain ?>/hop.php?ref=<? print $_SESSION['aff_valid_user']?>" target="_blank"><?=AFF_MA_MEMBERAFFTESTLINK?></a> ]
            </div>
        </td>
    </tr>
</table>
<br />

<?
// Dapatkan data video promosi

$result = mysql_query("SELECT * from videopromosi ORDER BY number asc", $database_connection) or die ("Database Error");
if (mysql_num_rows($result))
{
    print "<br /><table width=\"600\" cellspacing=\"1\" class=\"SA_general_table\"><tr><td colspan=\"4\" class=\"SA_general_table_header\">".AFF_MA_MEMBERVIDEOTITLE."</td></tr><tr><td colspan=\"4\" class=\"SA_general_table_row1\"><br />".$arahan_guna_video."<br /><br /></td></tr><tr><td colspan=\"4\" class=\"SA_general_table_row2\">&nbsp;</td></tr>";
    while ($qry = mysql_fetch_array($result))
    {
        print "<tr>";
        print "<td class=\"SA_general_table_header\"><div align=\"left\">";
        print $qry['number'];
        print " - ";
        print $qry['arahan'];
        print "</td></tr>";
        print "<tr><td class=\"SA_general_table_row1\"><br /><div align=\"center\">".$qry['kandungan']."</div><br /></td></tr>";
        print "<tr><td class=\"SA_general_table_row2\"><div align=\"center\"><input size=\"70\" type=\"text\" name=\"tajuk\" value='".$qry['tajuk']."'></div></td></tr>";
        print "<tr><td class=\"SA_general_table_row1\"><div align=\"center\"><textarea cols=\"60\" rows=\"15\">".$qry['kandungan']."</textarea></div></td></tr>";
        print "<tr><td class=\"SA_general_table_row2\">&nbsp;</td></tr>";
    }
    print "</table><br />";
}

else echo "<br /><table cellspacing=\"1\" class=\"SA_norecord_box\"><tr><td><br />".AFF_MA_MEMBERNOVIDEOS."<br /><br /></td></tr></table><br />";

//Papar Footer
echo $footerdisplay; 

?>