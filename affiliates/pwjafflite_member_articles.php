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

//Dapatkan Data Affiliate
$resultaffiliate = mysql_db_query($database, "select * from affiliates where refid = '".$_SESSION['aff_valid_user']."'") or die ("Database INSERT Error (line 19)");

if (mysql_num_rows($resultaffiliate))
{
    while ($qryaffiliate = mysql_fetch_array($resultaffiliate))
    {
        $namaagen = $qryaffiliate['firstname'].' '.$qryaffiliate['lastname'];
    }
}

?>	

<br  />
<table cellspacing="1" class="SA_adminarea_statisticbox">
    <tr>
        <td class="SA_adminarea_statisticbox_header"><?=AFF_MA_MEMBERAFFLINK?></td>
    </tr>
    <tr>
        <td class="SA_adminarea_statisticbox_row1">
            <div align="center"><input name="linkaffiliate" type="text" size="70" value="http://<? echo $domain ?>/hop.php?ref=<? print $_SESSION['aff_valid_user']?>"></div>
        </td>
    </tr>
    <tr>
 	<td class="SA_adminarea_statisticbox_row2">
            <div align="center">[ <a href="https://<? echo $domain ?>/hop.php?ref=<? print $_SESSION['aff_valid_user']?>" target="_blank"><?=AFF_MA_MEMBERAFFTESTLINK?></a> ]</div>
        </td>
    </tr>
</table>
<br />

<?		
// Dapatkan Data Artikel Promosi
$resultartikel = mysql_query("SELECT * from artikelpromosi ORDER BY number asc", $database_connection) or die ("Database INSERT Error (line 19");

if (mysql_num_rows($resultartikel))
{
    print '<br /><table width="600" cellspacing="1" class="SA_general_table"><tr><td colspan="4" class="SA_general_table_header">'.AFF_P_MEMBERARTICLESTITLE.'</td></td></tr><td class="SA_general_table_row1"><br />'.$arahan_promosi_agen.'<br /><br /></td></tr><tr><td class="SA_general_table_row2">&nbsp;</td></tr>';
    while ($qryartikel = mysql_fetch_array($resultartikel))
        {
            print '<tr><td class="SA_general_table_header"><div align="left">';
            print $qryartikel['number'];
            print ' - ';
            print $qryartikel['arahan'];
            print '</div></td>';
            print '<tr><td class="SA_general_table_row1"><div align="center"><input size="70" type="text" name="tajuk" value="'.$qryartikel['tajuk'].'"></div></td></tr>';
            print '<tr><td class="SA_general_table_row2"><div align="center">';

            $tagaffiliate = array('%%linkaffiliate%%', '%%namaagen%%');
            $tagaffiliatereplace = array('http://'.$domain.'/hop.php?ref='.$_SESSION['aff_valid_user'], $namaagen);
            echo str_replace($tagaffiliate, $tagaffiliatereplace, '<textarea cols="60" rows="15">'.$qryartikel['kandungan'].'</textarea>');
            print '</div></td></tr>';
            print '<tr><td class=\"SA_general_table_row1\">&nbsp;</td></tr>';
        }

    print '</table><br />';
}

else echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_MA_MEMBERNOARTICLES.'<br /><br /></td></tr></table><br />';

//Papar Footer
echo $footerdisplay; 

?>