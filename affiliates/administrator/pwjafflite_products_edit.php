<?php

session_start();
include '../../pwjafflite_config.php';
include '../lang/'.$language;

if(!aff_admin_check_security())
{
    aff_redirect('index.php');
    exit();
}

// Semak Masalah Jika Ada
$errorMsg = '';
if($_POST['commited'] == 'yes')
{
    // check product name
    if($_POST['namaproduk'] == ''){
    $errorMsg .= AFF_PT_ADMINPRODUCTSNAMEERROR.'<br /><br />';
    }

    // check commission record
    if($_POST['hargaproduk'] == ''){
    $errorMsg .= 'Sila masukkan harga produk.<br /><br />';
    }

    // check commission record
    if($_POST['komisyenproduk'] == ''){
    $errorMsg .= AFF_PT_ADMINPRODUCTSCOMMISSIONERROR.'<br /><br />';
    }

    // check commission record
    if($_POST['produkUrl'] == ''){
    $errorMsg .= 'Sila masukkan URL ke halaman web produk.<br /><br />';
    }

    // JIka Tiada Masalah Proses Data
    if($errorMsg == '')
    {
        $result = mysql_query("UPDATE produk SET namaproduk = '".$_POST['namaproduk']."', hargaproduk = '".$_POST['hargaproduk']."', komisyenproduk = '".$_POST['komisyenproduk']."', produkUrl = '".$_POST['produkUrl']."' WHERE idproduk = '".$_POST['edit']."'", $database_connection) or die ('Database Update Error');
        aff_redirect('pwjafflite_admin_products.php');
    }

// Close Post Committed
}

// Papar Header Sistem Affiliate
include 'header.php';

// Papar Punca Masalah Jika Wujud
if($errorMsg != '')
{
    echo '<br /><table cellspacing="1" class="SA_error_box"><tr><td><br />'.$errorMsg.'</td></tr></table><br />';
}

// Connect to Database & Select Data
$result = mysql_query("SELECT * from produk WHERE idproduk = '".$_REQUEST['edit']."'", $database_connection) or die ('Database Error');

if (mysql_num_rows($result))
{
    print '<br /><form method="post" action="pwjafflite_products_edit.php"><table cellspacing="1" class="SA_adminarea_statisticbox">';
    while ($qry = mysql_fetch_array($result))
    {
        print '<tr><td colspan="3" class="SA_adminarea_statisticbox_header">'.AFF_PT_ADMINPRODUCTCOMMISSIONEDIT.' - '.$_GET['edit'].'</td></tr><tr><td colspan="3" class="SA_adminarea_statisticbox_row1"><br /></td></tr>';
        print '<tr><td class="SA_adminarea_statisticbox_row2"><div align="right">'.AFF_PT_ADMINPRODUCTSNAME.'</div></td><td  class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td><td class="SA_adminarea_statisticbox_row2"><input type="text" name="namaproduk" size="60" value="'.$qry['namaproduk'].'"><br />
        <font color="#FF0000">'.AFF_PT_ADMINPRODUCTSNAMESAMPLE.'</font></td></tr>';
        print '<tr><td class="SA_adminarea_statisticbox_row1"><div align="right">Harga Jualan Produk</div></td><td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td><td class="SA_adminarea_statisticbox_row1"><input type="text" name="hargaproduk" size="20" value="'.$qry[hargaproduk].'"><br /><font color="#FF0000">'.AFF_PT_ADMINPRODUCTCOMMISSIONWARNING.'</font></td></tr><tr><td colspan="3" class="SA_adminarea_statisticbox_row2">&nbsp;</td></tr>';
        print '<tr><td class="SA_adminarea_statisticbox_row1"><div align="right">'.AFF_PT_ADMINPRODUCTCOMMISSION.'</div></td><td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td><td class="SA_adminarea_statisticbox_row1"><input type="text" name="komisyenproduk" size="20" value="'.$qry[komisyenproduk].'"><br /><font color="#FF0000">'.AFF_PT_ADMINPRODUCTCOMMISSIONWARNING.'</font></td></tr><tr><td colspan="3" class="SA_adminarea_statisticbox_row2">&nbsp;</td></tr>';
        print '<tr>
            <td class="SA_adminarea_statisticbox_row1"><div align="right">PRODUK URL</div></td>
            <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
            <td class="SA_adminarea_statisticbox_row1">
                <input type="url" name="produkUrl" placeholder="http://domain.com" value="' . $qry['produkUrl'] . '"><br />
                <font color="#FF0000">Masukkan alamat penuh ke laman web produk.</font>
            </td>
        </tr>
        ';
    }

    print '<tr><td colspan="3" class="SA_adminarea_statisticbox_row1"><div align="center"><input type="hidden" name="commited" value="yes"><input type="hidden" name="edit" value="'.$_REQUEST['edit'].'"><input type="submit" value="'.AFF_PT_ADMINPRODUCTSCOMMISSIONADD.'"></div></td></tr>';
    print '</table>';
    print '</form><br />';
}

//Papar Footer
echo $footerdisplay;

?>
