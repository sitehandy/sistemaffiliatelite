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
 
$errorMsg = '';

if($_POST['commited'] == 'yes')
{
    // check banner name
    if($_POST['bannername'] == ''){
    $errorMsg .= AFF_B_BANNERNAMEERROR.'<br /><br />';
    }

    // check banner URL
    if($_POST['bannerurl'] == ''){
    $errorMsg .= AFF_B_BANNERURLERROR.'<br /><br />';
    }

    if($errorMsg == '')
    {
        // Sambung Ke Database
        if (!$database_connection)
	{
            die('Could not connect: ' . mysql_error());
        }

        mysql_query("INSERT INTO banners VALUES ('', '".$_POST['bannername']."', '".$_POST['bannerurl']."', '".$_POST['bannerdesc']."')", $database_connection) or die('Database INSERT Error');
        aff_redirect('pwjafflite_admin_banners.php');
    }

//Close POST Committed
}

// Papar Masalah Jika Wujud
if($errorMsg != '')
{
    echo '<br /><table cellspacing="1" class="SA_error_box"><tr><td><br />'.$errorMsg.'</td></tr></table><br />';
}

?>

<br />
<form method="post" action="pwjafflite_banner_add.php">
    <table cellspacing="1" class="SA_adminarea_statisticbox">
        <tr>
            <td colspan="3" class="SA_adminarea_statisticbox_header"><?=AFF_B_ADDBANNER?></td>
        </tr>
        <tr>
            <td class="SA_adminarea_statisticbox_row1"><div align="right"><?=AFF_B_BANNERNAME?></div></td>
            <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
            <td class="SA_adminarea_statisticbox_row1">
                <input type="text" name="bannername" size="60">
            </td>
        </tr>
        <tr>
            <td class="SA_adminarea_statisticbox_row2"><div align="right"><?=AFF_B_BANNERURL?></div></td>
            <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
            <td class="SA_adminarea_statisticbox_row2"><input type="text" name="bannerurl" size="60" value="http://<?=$domain?>/images/image.gif" /></td>
        </tr>
        <tr>
            <td class="SA_adminarea_statisticbox_row1"><div align="right"><?=AFF_B_BANNERDESCRIPTION?></div></td>
            <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
            <td class="SA_adminarea_statisticbox_row1">
                <textarea name="bannerdesc" cols="45" rows="6"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="SA_adminarea_statisticbox_row2">
                <div align="center">
                    <input type="hidden" name="commited" value="yes" />
                    <input type="submit" name="Submit" value="<?=AFF_B_ADDBANNERBUTTON?>" />
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