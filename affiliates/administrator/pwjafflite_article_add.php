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
        mysql_query("INSERT INTO artikelpromosi VALUES ('', '".$_POST['arahan']."', '".$_POST['tajuk']."', '".$_POST['kandungan']."') ", $database_connection) or die("Database INSERT Error");
        aff_redirect('pwjafflite_admin_articles.php');
    }

//Close POST Committed
}

if($errorMsg != '')
{
    echo "<br /><table cellspacing=\"1\" class=\"SA_error_box\"><tr><td><br />$errorMsg</td></tr></table><br />";
}

?>

<br />
<form name="tambahartikel" method="post" action="pwjafflite_article_add.php">
    <table cellspacing="1" class="SA_adminarea_statisticbox">
        <tr>
            <td colspan="3" class="SA_adminarea_statisticbox_header"><div align="center"><?=AFF_P_ARTICLEADDTITLE?></div></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_adminarea_statisticbox_row1"><br /><div align="justify"><?=$article_add_guide?></div><br /><br /></td>
        </tr>
        <tr>
            <td class="SA_adminarea_statisticbox_row2"><div align="right"><?=AFF_P_ARTICLENOTE?></div></td>
            <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
            <td class="SA_adminarea_statisticbox_row2">
                <input type="text" name="arahan" size="60">
            </td>
        </tr>
        <tr>
            <td class="SA_adminarea_statisticbox_row1"><div align="right"><?=AFF_P_ARTICLETITLE?></div></td>
            <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
            <td class="SA_adminarea_statisticbox_row1">
                <input type="text" name="tajuk" size="60">
            </td>
        </tr>
        <tr>
            <td class="SA_adminarea_statisticbox_row2"><div align="right"><?=AFF_P_ARTICLECONTENT?></div></td>
            <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
            <td class="SA_adminarea_statisticbox_row2">
                <textarea name="kandungan" cols="47" rows="10"><? $affiliatag ?></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="SA_adminarea_statisticbox_row1">
                <div align="center">
                    <input type="hidden" name="commited" value="yes">
                    <input type="submit" name="Submit" value="<?=AFF_P_ARTICLEBUTTONADD?>">
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