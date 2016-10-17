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
  
echo "<br /><table width=\"600\" cellspacing=\"1\" class=\"SA_general_table\"><tr><td class=\"SA_general_table_header\">".AFF_P_ADMINTERMSINFO."</td></tr><tr><td class=\"SA_general_table_row1\"><div align=\"justify\"><br />".$arahan_terma."<br /><br /></div></td></tr></table><br />";

$errorMsg = '';

if($_POST['commited'] == 'yes')
{
    // check firstname
    if($_POST['kandunganterma'] == ''){
    $errorMsg .= '<br />'.AFF_P_ADMINTERMSMISSING.'<br />';
    }

    if($errorMsg == '')
    {
        mysql_query("UPDATE termadaftar SET kandunganterma = '".$_POST['kandunganterma']."' ", $database_connection) or die("Database Update Error");
        echo "<br /><table cellspacing=\"1\" class=\"SA_success_box\"><tr><td><br />".AFF_P_ADMINTERMSCONTENTCHANGED."<br /><br /></td></tr></table><br />";
    }
}

// Dapatkan data terma daftar
$result = mysql_query("SELECT * FROM termadaftar", $database_connection) or die ("Database Error");

if($errorMsg != '')
{
    echo "<br /><table cellspacing=\"1\" class=\"SA_error_box\"><tr><td><br />$errorMsg<br /></td></tr></table><br />";
}

if (mysql_num_rows($result))
{
    while ($qry = mysql_fetch_array($result))
    {
?>   
<br  />
<form name="kandunganterma" method="post" action="pwjafflite_admin_registerterms.php">
    <table cellspacing="1" class="SA_general_table">
        <tr>
            <td colspan="3" class="SA_general_table_header"><?=AFF_P_ADMINTERMSTITLE?></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><div align="right"><?=AFF_P_ADMINTERMSCONTENT?></div></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1">
                <textarea id="elm2" name="kandunganterma" rows="15" cols="80" style="width: 80%"><?=$qry[kandunganterma]?></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row2">
                <div align="center">
                    <input type="hidden" name="commited" value="yes">
                    <input type="submit" name="Submit" value="<?=AFF_P_ADMINTERMSBUTTON?>">
                </div>
            </td>
        </tr>
    </table>
</form>
<br />
<br />
<table width="600" cellspacing="1" class="SA_general_table">
    <tr>
        <td class="SA_general_table_header"><?=AFF_P_ADMINTERMSTITLE?></td>
    </tr>
    <tr>
        <td class="SA_general_table_row1"><div align="center"><br /><textarea rows="15" cols="80" style="width: 80%" readonly="readonly"><?=$qry[kandunganterma]?></textarea><br /><br /></div></td>
    </tr>
</table>
<br />
<?
    }
}

//Papar Footer
echo $footerdisplay;

?>