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
  
echo '<br /><table width="600" cellspacing="1" class="SA_general_table"><tr><td class="SA_general_table_header">'.AFF_PT_ADMINPRODUCTTITLE.'</td></tr><tr><td class="SA_general_table_row1"><div align="justify"><br />'.$arahanproducts.'<br /><br /></div></td></tr><tr><td class="SA_general_table_row2"><form method="post" action="pwjafflite_products_add.php"><div align="center"><input type="submit" value="'.AFF_PT_ADMINPRODUCTADD.'"></div></form></td></tr></table><br />';

// Sambung Ke Database Table Produk
$result = mysql_query("SELECT * FROM produk ORDER BY idproduk asc", $database_connection) or die ('Database Error');

if (mysql_num_rows($result))
{
    print '<br /><table width="600" cellspacing="1" class="SA_general_table"><tr><td colspan="4" class="SA_general_table_header">'.AFF_PT_ADMINPRODUCTTITLE2.'</td></tr><tr><td colspan="4" class="SA_general_table_row1"><div align="justify"><br />'.$arahanproductsready.'<br /><br /></div></td></tr><tr><td colspan="4" class="SA_general_table_row2">&nbsp;</td></tr>';
    while ($qry = mysql_fetch_array($result))
    {
        print '<tr><td width="5%" class="SA_general_table_header"><div align="right">';
        print $qry['idproduk'];
        print '</div></td>';
        print '<td class="SA_general_table_header">';
        print AFF_PT_ADMINPRODUCTKOMISYEN;
        print '</td>';
        print '<td width="20%" class="SA_general_table_header"><div align="center"><a href="pwjafflite_products_edit.php?edit='.$qry['idproduk'].'">'.AFF_PT_ADMINPRODUCTEDIT.'</a></div></td>';
        print '<td width="20%" class="SA_general_table_header"><div align="center"><a href="pwjafflite_products_delete.php?delete='.$qry['idproduk'].'" onClick="return confirm(\''.AFF_P_DELETE.'\')">'.AFF_PT_ADMINPRODUCTDELETE.'</a></div></td></tr>';
        print '<tr><td align="center" colspan="4" class="SA_general_table_row1"><br />';
        print '<div align="center">';
        print $qry['namaproduk'];
        print '</div><br /></td></tr>';
        print '<tr><td colspan="4" class="SA_general_table_row2">';
        print '<div align="center">';
        print AFF_PT_ADMINPRODUCTKOMISYENTITLE.': <b>'.$qry['komisyenproduk'].'</b>';
        print '</div></td></tr><tr><td colspan="4" class="SA_general_table_row1">&nbsp;</td></tr>';
    }
    print '</table><br />';
}

// Paparan Mesej Jika Tiada Produk
else echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_PT_ADMINNOPRODUCTS.'<br /><br /></td></tr></table><br />';

//Papar Footer
echo $footerdisplay; 

?>