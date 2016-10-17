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

echo "<br /><table width=\"600\" cellspacing=\"1\" class=\"SA_general_table\"><tr><td class=\"SA_general_table_header\">".AFF_P_ARTICLEADDINFO."</td></tr><tr><td class=\"SA_general_table_row1\"><div align=\"justify\"><br />".$arahan_artikel_promosi."<br /><br /></div></td></tr><tr><td class=\"SA_general_table_row2\"><form method=\"post\" action=\"pwjafflite_article_add.php\"><div align=\"center\"><input type=\"submit\" value='".AFF_P_ARTICLEADDBUTTON."'></div></form></td></tr></table><br />";

// Dapatkan data artikel promosi
$result = mysql_query("SELECT * FROM artikelpromosi ORDER BY number asc", $database_connection) or die ("Database Error");

if (mysql_num_rows($result))
{
    print "<br /><table width=\"600\" cellspacing=\"1\" class=\"SA_general_table\"><tr><td colspan=\"4\" class=\"SA_general_table_header\">".AFF_P_ARTICLEADDEDTITLE."</td></tr><tr><td colspan=\"4\" class=\"SA_general_table_row1\"><div align=\"justify\"><br />".$arahan_edit_artikel."<br /><br /></div></td></tr><tr><td colspan=\"4\" class=\"SA_general_table_row2\">&nbsp;</td></tr>";
    
    while ($qry = mysql_fetch_array($result))
    {
        print "<tr><td width=\"5%\" class=\"SA_general_table_header\"><div align=\"right\">";
        print $qry['number'];
        print "</div></td>";
        print "<td class=\"SA_general_table_header\">";
        print $qry['arahan'];
        print "</td>";
        print "<td width=\"20%\" class=\"SA_general_table_header\"><div align=\"center\"><a href=\"pwjafflite_article_edit.php?edit=".$qry['number']."&validation=".$_SESSION['aff_valid_admin']."\">".AFF_P_PROMOSIEDIT."</a></div></td>";
        print "<td width=\"20%\" class=\"SA_general_table_header\"><div align=\"center\"><a href=\"pwjafflite_article_delete.php?delete=".$qry['number']."&validation=".$_SESSION['aff_valid_admin']."\" onClick=\"return confirm('".AFF_P_DELETE."')\">".AFF_P_PROMOSIDELETE."</a></div></td>";
        print "<tr><td colspan=\"4\" class=\"SA_general_table_row1\"><div align=\"center\"><input size=\"70\" type=\"text\" name=\"tajuk\" value='".$qry['tajuk']."'></div></td></tr>";
        print "<tr><td colspan=\"4\" class=\"SA_general_table_row2\"><div align=\"center\"><textarea cols=\"60\" rows=\"15\">".$qry['kandungan']."</textarea></div></td></tr>";
        print "<tr><td colspan=\"4\" class=\"SA_general_table_row1\">&nbsp;</td></tr>";
    }

    print "</table><br />";
}

// Paparkan notis jika tiada artikel lagi
else echo "<br /><table cellspacing=\"1\" class=\"SA_norecord_box\"><tr><td><br />".AFF_P_NOARTICLE."<br /><br /></td></tr></table><br />";

//Papar Footer
echo $footerdisplay; 

?>