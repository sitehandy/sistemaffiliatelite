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
    // check firstname
    if($_POST['arahan'] == ''){
    $errorMsg .= AFF_P_VIDEOPURPOSEMISSING.'<br /><br />';
    }

    // check firstname
    if($_POST['tajuk'] == ''){
    $errorMsg .= AFF_P_VIDEOTITLEMISSING.'<br /><br />';
    }

    // check firstname
    if($_POST['kandungan'] == ''){
    $errorMsg .= AFF_P_VIDEOCONTENTMISSING.'<br /><br />';
    }

    if($errorMsg == '')
    {
        mysql_query("INSERT INTO videopromosi VALUES ('', '".$_POST['arahan']."', '".$_POST['tajuk']."', '".$_POST['kandungan']."')", $database_connection) or die("Database INSERT Error");
        aff_redirect('pwjafflite_admin_videos.php');
    }
}

include 'header.php';

if($errorMsg != '')
{
    echo "<br /><table cellspacing=\"1\" class=\"SA_error_box\"><tr><td><br />$errorMsg</td></tr></table><br />";
}

?>

  
<br />
<form name="tambahartikel" method="post" action="pwjafflite_video_add.php">
    <table cellspacing="1" class="SA_adminarea_statisticbox">
        <tr>
            <td colspan="3" class="SA_adminarea_statisticbox_header"><div align="center"><?=AFF_P_VIDEOADDTITLE?></div></td>
        </tr>
        <tr>
            <td class="SA_adminarea_statisticbox_row1"><div align="right"><?=AFF_P_VIDEONOTE?></div></td>
            <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
            <td class="SA_adminarea_statisticbox_row1">
                <input type="text" name="arahan" size="60" value="<?=$_POST['arahan']?>">
            </td>
        </tr>
        <tr>
            <td class="SA_adminarea_statisticbox_row2"><div align="right"><?=AFF_P_VIDEOTITLE?></div></td>
            <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
            <td class="SA_adminarea_statisticbox_row2">
                <input type="text" name="tajuk" size="60" value="<?=$_POST['tajuk']?>">
            </td>
        </tr>
        <tr>
            <td class="SA_adminarea_statisticbox_row1"><div align="right"><?=AFF_P_VIDEOCONTENT?></div></td>
            <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
            <td class="SA_adminarea_statisticbox_row1">
                <textarea name="kandungan" cols="47" rows="10"><?=$_POST['kandungan']?></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="SA_adminarea_statisticbox_row2">
                <div align="center">
                    <input type="hidden" name="commited" value="yes">
                    <input type="submit" name="Submit" value="<?=AFF_P_VIDEOBUTTONADD?>">
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