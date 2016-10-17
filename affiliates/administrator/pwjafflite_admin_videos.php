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

echo "<br /><table width=\"600\" cellspacing=\"1\" class=\"SA_general_table\"><tr><td class=\"SA_general_table_header\">".AFF_P_VIDEOADDINFO."</td></tr><tr><td class=\"SA_general_table_row1\"><div align=\"justify\"><br />".$arahan_video_promosi."<br /><br /></div></td></tr><tr><td class=\"SA_general_table_row2\"><form method=\"post\" action=\"pwjafflite_video_add.php\"><div align=\"center\"><input type=\"submit\" value='".AFF_P_VIDEOADDBUTTON."'></div></form></td></tr></table><br />";

// Dapatkan Data Video Promosi
$result = mysql_query("SELECT * from videopromosi ORDER BY number asc", $database_connection) or die ("Database Error");
if (mysql_num_rows($result)) 
{
    print "<br /><table width=\"600\" cellspacing=\"1\" class=\"SA_general_table\"><tr><td colspan=\"4\" class=\"SA_general_table_header\">".AFF_P_VIDEOADDEDTITLE."</td></tr><tr><td colspan=\"4\" class=\"SA_general_table_row1\"><div align=\"justify\"><br />".$arahan_edit_video."<br /><br /></div></td></tr><tr><td colspan=\"4\" class=\"SA_general_table_row2\">&nbsp;</td></tr>";
    while ($qry = mysql_fetch_array($result))
    {
        print "<tr><td width=\"5%\" class=\"SA_general_table_header\"><div align=\"right\">";
        print $qry['number'];
        print "</div></td>";
        print "<td class=\"SA_general_table_header\">";
        print $qry['arahan'];
        print "</td><td width=\"20%\" class=\"SA_general_table_header\"><div align=\"center\"><a href=\"pwjafflite_video_edit.php?edit=".$qry[number]."\">".AFF_P_VIDEOEDIT."</a></div></td>";
        print "<td width=\"20%\" class=\"SA_general_table_header\"><div align=\"center\"><a href=\"pwjafflite_video_delete.php?delete=".$qry[number]."\" onClick=\"return confirm('".AFF_P_VIDEODELETECONFIRM."')\">".AFF_P_VIDEODELETE."</a></div></td>";
        print "<tr><td colspan=\"4\" class=\"SA_general_table_row1\"><br /><div align=\"center\">".$qry['kandungan']."</div><br /></td></tr>";
        print "<tr><td colspan=\"4\" class=\"SA_general_table_row2\"><div align=\"center\"><input size=\"70\" type=\"text\" name=\"tajuk\" value='".$qry['tajuk']."'></div></td></tr>";
        print "<tr><td colspan=\"4\" class=\"SA_general_table_row1\"><div align=\"center\"><textarea cols=\"60\" rows=\"15\">".$qry['kandungan']."</textarea></div></td></tr>";
        print "<tr><td colspan=\"4\" class=\"SA_general_table_row2\">&nbsp;</td></tr>";
   }
   print "</table><br />";
}

else echo "<br /><table cellspacing=\"1\" class=\"SA_norecord_box\"><tr><td><br />".AFF_P_NOVIDEO."<br /><br /></td></tr></table><br />";

//Papar Footer
echo $footerdisplay; 

?>