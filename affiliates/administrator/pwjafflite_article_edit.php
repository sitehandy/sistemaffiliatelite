<?php

session_start();
include '../../pwjafflite_config.php';
include '../lang/'.$language;

if(!aff_admin_check_security())
{
    aff_redirect('index.php');
    exit();
}

if($_POST['commited'] == 'yes')
{
    // check firstname
    if($_POST['arahan'] == ''){
    $errorMsg .= AFF_P_ARTICLEPURPOSEMISSING.'<br /><br />';
    }

    // check firstname
    if($_POST['tajuk'] == ''){
    $errorMsg .= AFF_P_ARTICLETITLEMISSING.'<br /><br />';
    }

    // check firstname
    if($_POST['kandungan'] == ''){
    $errorMsg .= AFF_P_ARTICLECONTENTMISSING.'<br /><br />';
    }

    if($errorMsg == '')
    {
        mysql_query("UPDATE artikelpromosi SET arahan = '".$_POST['arahan']."', tajuk = '".$_POST['tajuk']."', kandungan = '".$_POST['kandungan']."' WHERE number = '".$_POST['edit']."'", $database_connection) or die ("Database INSERT Error");
        aff_redirect('pwjafflite_admin_articles.php');
    }
}

include 'header.php';

if($errorMsg != '')
{
    echo "<br /><table cellspacing=\"1\" class=\"SA_error_box\"><tr><td><br />$errorMsg</td></tr></table><br />";
}
	 
//Dapatkan Data Artikel
$result = mysql_query("SELECT * FROM artikelpromosi WHERE number = '".$_REQUEST['edit']."'", $database_connection) or die ("Database Error");

if (mysql_num_rows($result))
{
    print "<br /><form method=\"post\" action=\"pwjafflite_article_edit.php\"><table cellspacing=\"1\" class=\"SA_adminarea_statisticbox\">";

    while ($qry = mysql_fetch_array($result))
    {
        print "<tr><td colspan=\"3\" class=\"SA_adminarea_statisticbox_header\">".AFF_P_ARTICLEEDITINFO." - ".$_REQUEST['edit']."</td></tr>";
        print "<tr><td colspan=\"3\" class=\"SA_adminarea_statisticbox_row1\"><br /><div align=\"left\">$article_add_guide<br /><br /></td></tr>";
        print "<tr><td class=\"SA_adminarea_statisticbox_row1\"><div align=\"right\">".AFF_P_ARTICLENOTE."</div></td><td  class=\"SA_adminarea_statisticbox_row1\"><div align=\"center\">:</div></td><td class=\"SA_adminarea_statisticbox_row1\"><input type=\"text\" name=\"arahan\" size=\"60\" value='".$qry['arahan']."'></td></tr>";
        print "<tr><td class=\"SA_adminarea_statisticbox_row2\"><div align=\"right\">".AFF_P_ARTICLETITLE."</div></td><td class=\"SA_adminarea_statisticbox_row2\"><div align=\"center\">:</div></td><td class=\"SA_adminarea_statisticbox_row2\"><input type=\"text\" name=\"tajuk\" size=\"60\" value='".$qry['tajuk']."'></td></tr>";
        print "<tr><td class=\"SA_adminarea_statisticbox_row1\"><div align=\"right\">".AFF_P_ARTICLECONTENT."</div></td><td class=\"SA_adminarea_statisticbox_row1\"><div align=\"center\">:</div></td><td class=\"SA_adminarea_statisticbox_row1\"><textarea name=\"kandungan\" cols=\"47\" rows=\"10\">".$qry['kandungan']."</textarea></td></tr>";
        print "<tr><td colspan=\"3\" class=\"SA_adminarea_statisticbox_row2\">&nbsp;</td></tr>";
    }
    print "<tr><td colspan=\"3\" class=\"SA_adminarea_statisticbox_row1\"><center><input type=\"hidden\" name=\"commited\" value=\"yes\"><input type=\"hidden\" name=\"edit\" value=".$_REQUEST['edit']."><input type=\"submit\" value='".AFF_P_ARTICLECHANGEBUTTON."'></center></td></tr>";
    print "</table></form><br />";
}

//Papar Footer
echo $footerdisplay; 

?>