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

// Dapatkan Data Affiliate
$resultbanneraffiliate = mysql_query("SELECT * from affiliates where refid = '".$_SESSION['aff_valid_user']."'", $database_connection) or die ("Database INSERT Error (line 19)");

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
            <div align="center">[ <a href="http://<? echo $domain ?>/hop.php?ref=<? print $_SESSION['aff_valid_user']?>" target="_blank"><?=AFF_MA_MEMBERAFFTESTLINK?></a> ]</div>
        </td>
    </tr>
</table>
<br />

<?		

// Dapatkan Data Banner
$resultbanner = mysql_query("SELECT * from banners ORDER BY number asc", $database_connection) or die ("Database INSERT Error (line 19");

if (mysql_num_rows($resultbanner)) 
{
    print '<br /><table width="600" cellspacing="1" class="SA_general_table"><tr><td colspan="4" class="SA_general_table_header">'.AFF_B_BANNERSINFO.'</td></tr><tr><td class="SA_general_table_row1"><br />'.$arahanbanneragen.'<br /><br /></td></tr><tr><td class="SA_general_table_row2">&nbsp;</td></tr>';
    while ($qry = mysql_fetch_array($resultbanner)) 
    {
        print '<tr><td class="SA_general_table_header">';
        print $qry['name'];
        print '</td></tr><tr>';
        print '<td class="SA_general_table_row1"><br>';
        print '<a href="http://';
        print $domain;
        print '/hop.php?ref='.$_SESSION['aff_valid_user'].'" target="_blank">';
        print '<div align="center"><img src="';        
        print $qry['image'];
        print '" border="0"></div></a></td></tr>';
        print '<tr><td class="SA_general_table_row2"><div align="center">';
        print '<textarea cols="60" rows="3"><a href="http://';
        print $domain;
        print '/hop.php?ref='.$_SESSION['aff_valid_user'].'" target="_blank"><img src="';
        print $qry['image'];
        print '"></a></textarea>';
        print '</div></td></tr><tr><td class="SA_general_table_row1">&nbsp;</td></tr>';
    }
    print '</table><br />';
}

//Papar Informasi Jika Tiada Banner Terhasil Lagi

else echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_MA_MEMBERNOBANNERS.'<br /><br /></td></tr></table><br />';

//Papar Footer
echo $footerdisplay; 

?>