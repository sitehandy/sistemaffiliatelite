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

// Paparkan Table Penerangan Ruangan OPT-IN Admin
echo '<br /><table width="600" cellspacing="1" class="SA_general_table"><tr><td class="SA_general_table_header">'.AFF_P_ADMINOPTININFO.'</td></tr><tr><td class="SA_general_table_row1"><div align="justify"><br />'.$arahan_optin.'<br /><br /></div></td></tr></table><br />';
  
// Jika Ada Masalah Paparkan
$errorMsg = '';
if($_POST['commited'] == 'yes')
{
	// Semak Penghantaran Data
	if($_POST['optincode'] == '')
	$errorMsg .= '<br />'.AFF_P_ADMINOPTINMISSING.'<br />';
	
	if($errorMsg == '')
	{
		mysql_query("UPDATE optinadmin SET optincode = '".$_POST['optincode']."' ", $database_connection) or die('Database INSERT Error');
		echo '<br /><table cellspacing="1" class="SA_success_box"><tr><td><br />'.AFF_P_ADMINOPTINCONTENTCHANGED.'<br /><br /></td></tr></table><br />';
	}
}

// Dapatkan Data dari Table OPT-IN Admin
$result = mysql_query('SELECT * from optinadmin', $database_connection) or die ('Database Error');

if($errorMsg != '')
echo '<br /><table cellspacing="1" class="SA_error_box"><tr><td>'.$errorMsg.'<br /></td></tr></table><br />';

if (mysql_num_rows($result))
{
    while ($qry = mysql_fetch_array($result))
    {
?>   
<br  />
<form name="optincode" method="post" action="pwjafflite_admin_optin.php">
    <table width="600" cellspacing="1" class="SA_general_table">
        <tr>
            <td colspan="3" class="SA_general_table_header"><?=AFF_P_ADMINOPTINTITLE?></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><div align="right"><?=AFF_P_ADMINOPTINCONTENT?></div></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1"><textarea id="elm2" name="optincode" rows="15" cols="40"><?=$qry['optincode']?></textarea></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row2">
                <div align="center">
                    <input type="hidden" name="commited" value="yes">
                    <input type="submit" name="Submit" value="<?=AFF_P_ADMINOPTINBUTTON?>">
                </div>
            </td>
        </tr>
    </table>
</form>
<br />
<br />
<table width="600" cellspacing="1" class="SA_general_table">
    <tr>
        <td class="SA_general_table_header"><?=AFF_P_ADMINOPTINTITLE?></td>
    </tr>
    <tr>
        <td class="SA_general_table_row1"><br /><div align="center"><?=$qry['optincode']?></div><br /><br /></td>
    </tr>
</table>
<br />
<?  
    }
}

//Papar Footer
echo $footerdisplay;

?>