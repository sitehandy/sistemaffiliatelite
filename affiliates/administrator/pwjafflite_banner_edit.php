<?php

session_start();
include '../../pwjafflite_config.php';
include '../lang/'.$language;

if(!aff_admin_check_security())
{
    aff_redirect('index.php');
    exit();
}

// Jika Ada Masalah Paparkan
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

    // Jika Tiada Masalah
    if($errorMsg == '')
    {
        // Sambung Ke Database
	if (!$database_connection)
	{
            die('Could not connect: ' . mysql_error());
	}

	mysql_query("UPDATE banners SET name = '".$_POST['bannername']."', image = '".$_POST['bannerurl']."', description = '".$_POST['bannerdesc']."' WHERE number = '".$_POST['edit']."'", $database_connection) or die ('Database INSERT Error');
	aff_redirect('pwjafflite_admin_banners.php');
    }

//Close POST Committed
}

// Dapatkan Header Sistem Affiliate
include 'header.php';

// Papar Masalah Jika Wujud
if($errorMsg != '')
{
    echo '<br /><table cellspacing="1" class="SA_error_box"><tr><td><br />'.$errorMsg.'</td></tr></table><br />';
}

// Dapatkan Data dari Table Banner Admin
$result = mysql_query("SELECT * from banners WHERE number = '".$_REQUEST['edit']."' ORDER BY name asc", $database_connection) or die ('Database Error');

if (mysql_num_rows($result))
{
    print '<br /><form method="post" action="pwjafflite_banner_edit.php"><table cellspacing="1" class="SA_adminarea_statisticbox">';
    while ($qry = mysql_fetch_array($result))
    {
        print '<tr><td colspan="3" class="SA_adminarea_statisticbox_header">'.AFF_P_EDITBANNERINFO.' - '.$_GET['edit'].'</td></tr><tr><td colspan="3" class="SA_adminarea_statisticbox_row1"><br /><div align="center"><img src="'.$qry['image'].'"></div><br /></td></tr><tr><td class="SA_adminarea_statisticbox_row2"><div align="right">'.AFF_B_BANNERURL.'</div></td><td  class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td><td class="SA_adminarea_statisticbox_row2"><input type="text" name="bannerurl" size="60" value="'.$qry['image'].'"></td></tr><tr><td class="SA_adminarea_statisticbox_row1"><div align="right">'.AFF_B_BANNERNAME.'</div></td><td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td><td class="SA_adminarea_statisticbox_row1"><input type="text" name="bannername" size="60" value="'.$qry['name'].'"></td></tr><tr><td class="SA_adminarea_statisticbox_row2"><div align="right">'.AFF_B_BANNERDESCRIPTION.'</div></td><td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td><td class="SA_adminarea_statisticbox_row2"><textarea name="bannerdesc" cols="45" rows="5">'.$qry['description'].'</textarea></td></tr><tr><td colspan="3" class="SA_adminarea_statisticbox_row1">&nbsp;</td></tr>';
    }

    print '<tr><td colspan="3" class="SA_adminarea_statisticbox_row2"><div align="center"><input type="hidden" name="commited" value="yes"><input type="hidden" name="edit" value="'.$_REQUEST['edit'].'"><input type="submit" value="'.AFF_B_CHANGEBANNER.'"></div></td></tr>';
    print '</table></form><br />';
}

//Papar Footer
echo $footerdisplay; 

?>