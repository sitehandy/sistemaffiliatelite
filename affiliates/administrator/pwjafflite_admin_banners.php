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

echo '<br /><table width="600" cellspacing="1" class="SA_general_table"><tr><td class="SA_general_table_header">'.AFF_B_BANNERSOFFER.'</td></tr><tr><td class="SA_general_table_row1"><div align="justify"><br />'.$arahanbanner.'<br /><br /></div></td></tr><tr><td class="SA_general_table_row2"><form method="post" action="pwjafflite_banner_add.php"><div align="center"><input type="submit" value="'.AFF_B_ADDBANNER.'"></div></form></td></tr></table><br />';

// Dapatkan Data Banner
$result = mysql_query('SELECT * FROM banners ORDER BY number asc', $database_connection) or die ('Database Error');
if (mysql_num_rows($result))
{
    print '<br /><table width="600" cellspacing="1" class="SA_general_table"><tr><td colspan="4" class="SA_general_table_header">'.AFF_B_BANNERADDED.'</td></tr><tr><td colspan="4" class="SA_general_table_row1"><div align="justify"><br />'.$arahaneditbanner.'<br /><br /></div></td></tr><tr><td colspan="4" class="SA_general_table_row2">&nbsp;</td></tr>';

    while ($qry = mysql_fetch_array($result))
    {
        print '<tr><td width="5%" class="SA_general_table_header"><div align="right">';
        print $qry['number'];
        print '</div></td>';
        print '<td class="SA_general_table_header">';
        print $qry['name'];
        print '</td>';
        print '<td width="20%" class="SA_general_table_header"><div align="center"><a href="pwjafflite_banner_edit.php?edit='.$qry['number'].'&validation='.$_SESSION['aff_valid_admin'].'">'.AFF_B_EDITBANNER.'</a></div></td>';
        print '<td width="20%" class="SA_general_table_header"><div align="center"><a href="pwjafflite_banner_delete.php?delete='.$qry['number'].'&validation='.$_SESSION['aff_valid_admin'].'" onClick="return confirm(\''.AFF_P_DELETE.'\')">'.AFF_B_DELETEBANNER.'</a></div></td></tr>';
        print '<tr><td align="center" colspan="4" class="SA_general_table_row1"><br>';
        print '<a href="http://'.$domain.'/hop.php?ref=id_agen" target="_blank">';
        print '<div align="center"><img src="'.$qry['image'].'" style="max-width: 400px !important;" border="0"></div></a><br /></td>';
        print '</tr>';
        print '<tr><td colspan="4" class="SA_general_table_row2">';
        print '<div align="center"><textarea cols="60" rows="3"><a href="http://'.$domain.'/hop.php?ref=id_agen" target="_blank"><img src="'.$qry['image'].'" style="max-width: 400px !important;"></a></textarea></div>';
        print '</td></tr><tr><td colspan="4" class="SA_general_table_row1">&nbsp;</td></tr>';
    }

    print '</table><br />';
}

// Paparkan notis jika tiada banner lagi
else echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_AA_TIADABANNERPROMOSI.'<br /><br /></td></tr></table><br />';

//Papar Footer
echo $footerdisplay; 

?>