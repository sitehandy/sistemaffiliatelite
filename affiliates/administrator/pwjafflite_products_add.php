<?php

session_start();
include '../../pwjafflite_config.php';
include '../lang/'.$language;

if(!aff_admin_check_security())
{
    aff_redirect('index.php');
    exit();
}
  
$errorMsg = '';
if($_POST['commited'] == 'yes')
{
    // check product name
    if($_POST['namaproduk'] == ''){
    $errorMsg .= AFF_PT_ADMINPRODUCTSNAMEERROR.'<br /><br />';
    }
  
    // check commission record
    if($_POST['komisyenproduk'] == ''){
    $errorMsg .= AFF_PT_ADMINPRODUCTSCOMMISSIONERROR.'<br /><br />';
    }

    if($errorMsg == '')
    {
        //Add Products & Commission Records
        mysql_query("INSERT INTO produk VALUES ('', '".$_POST['namaproduk']."', '".$_POST['komisyenproduk']."')", $database_connection) or die("Database INSERT Error");
        aff_redirect('pwjafflite_admin_products.php');
    }
// Close POST Check
}
  
// Papar Header Sistem Affiliate
include 'header.php';  
	  
if($errorMsg != '')
{
    echo '<br /><table cellspacing="1" class="SA_error_box"><tr><td><br />'.$errorMsg.'</td></tr></table><br />';
}

?>
<br />
<form method="post" action="pwjafflite_products_add.php">
    <table cellspacing="1" class="SA_adminarea_statisticbox">
        <tr>
            <td colspan="3" class="SA_adminarea_statisticbox_header"><?=AFF_PT_ADMINPRODUCTADD2?></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_adminarea_statisticbox_row2"><br /></td>
        </tr>
        <tr>
            <td class="SA_adminarea_statisticbox_row1"><div align="right"><?=AFF_PT_ADMINPRODUCTSNAME?></div></td>
            <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
            <td class="SA_adminarea_statisticbox_row1">
                <input type="text" name="namaproduk" size="60"><br />
                <font color="#FF0000"><?=AFF_PT_ADMINPRODUCTSNAMESAMPLE?></font>
            </td>
        </tr>
        <tr>
            <td class="SA_adminarea_statisticbox_row2"><div align="right"><?=AFF_PT_ADMINPRODUCTCOMMISSION?></div></td>
            <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
            <td class="SA_adminarea_statisticbox_row2"><input type="text" name="komisyenproduk" size="20" value="">
                <br /><font color="#FF0000"><?=AFF_PT_ADMINPRODUCTCOMMISSIONWARNING?></font>
                <br /><br /><font color="#FF0000"><?=AFF_PT_ADMINPRODUCTSCOMMISSIONSAMPLE?></font>
            </td class="registration_row1_box">
        </tr>
        <tr>
            <td colspan="3" class="SA_adminarea_statisticbox_row1"><br /></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_adminarea_statisticbox_row2">
                <div align="center">
                    <input type="hidden" name="commited" value="yes">
                    <input type="submit" name="Submit" value="<?=AFF_PT_ADMINPRODUCTSCOMMISSIONADD?>">
                </div>
            </td>
        </tr>
    </table>
</form>
<br />

<? 

//Papar Footer
echo $footerdisplay; 

?>