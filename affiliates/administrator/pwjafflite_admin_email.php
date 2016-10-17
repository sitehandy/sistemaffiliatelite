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

// Paparkan Table Penerangan Ruangan Email Admin
echo '<br /><table width="600" cellspacing="1" class="SA_general_table"><tr><td class="SA_general_table_header">'.AFF_E_ADMINEMAILINFO.'</td></tr><tr><td class="SA_general_table_row1"><br />'.$arahan_email_template.'<br /><br /></td></tr></table><br />';
  
// Jika Ada Masalah Paparkan
$errorMsg = '';

// Update Email Pendaftaran Affiliate
if($_POST['commited01'] == 'yes')
{
    // Semak Penghantaran Data
    if($_POST['emailpendaftaran'] == '')
    $errorMsg .= '<br />'.AFF_E_ADMINEMAILERROR.'<br />';
	
    if($errorMsg == '')
    {
        mysql_query("UPDATE emailadmin SET emaildaftar = '".$_POST['emailpendaftaran']."' ", $database_connection) or die('Database INSERT Error');
	echo '<br /><table cellspacing="1" class="SA_success_box"><tr><td><br />'.AFF_E_ADMINEMAILCHANGED.'<br /><br /></td></tr></table><br />';
    }
}

// Update Email Pengesahan Bayaran
if($_POST['commited02'] == 'yes')
{
    // Semak Penghantaran Data
    if($_POST['emailpengesahanbayaran'] == '')
    $errorMsg .= '<br />'.AFF_E_ADMINEMAILERROR.'<br />';
	
    if($errorMsg == '')
    {
    	mysql_query("UPDATE emailadmin SET emailpengesahan = '".$_POST['emailpengesahanbayaran']."' ", $database_connection) or die('Database INSERT Error');
	echo '<br /><table cellspacing="1" class="SA_success_box"><tr><td><br />'.AFF_E_ADMINEMAILCHANGED.'<br /><br /></td></tr></table><br />';
    }
}

// Update Email Pengesahan Bayaran Kepada Admin
if($_POST['commited03'] == 'yes')
{
    // Semak Penghantaran Data
    if($_POST['emailpengesahanbayaranadmin'] == '')
    $errorMsg .= '<br />'.AFF_E_ADMINEMAILERROR.'<br />';
	
    if($errorMsg == '')
    {
    	mysql_query("UPDATE emailadmin SET emailpengesahanadmin = '".$_POST['emailpengesahanbayaranadmin']."' ", $database_connection) or die('Database INSERT Error');
    	echo '<br /><table cellspacing="1" class="SA_success_box"><tr><td><br />'.AFF_E_ADMINEMAILCHANGED.'<br /><br /></td></tr></table><br />';
    }
}

// Update Email Pengesahan Bayaran Kepada Admin
if($_POST['commited04'] == 'yes')
{
    // Semak Penghantaran Data
    if($_POST['emailpasswordpengguna'] == '')
    $errorMsg .= '<br />'.AFF_E_ADMINEMAILERROR.'<br />';
	
    if($errorMsg == '')
    {
    	mysql_query("UPDATE emailadmin SET emailpassworduser = '".$_POST['emailpasswordpengguna']."' ", $database_connection) or die('Database INSERT Error');
	echo '<br /><table cellspacing="1" class="SA_success_box"><tr><td><br />'.AFF_E_ADMINEMAILCHANGED.'<br /><br /></td></tr></table><br />';
    }
}

// Update Email Pengesahan Bayaran Kepada Admin
if($_POST['commited05'] == 'yes')
{
    // Semak Penghantaran Data
    if($_POST['emailpasswordpengguna2'] == '')
    $errorMsg .= '<br />'.AFF_E_ADMINEMAILERROR.'<br />';
	
    if($errorMsg == '')
    {
	mysql_query("UPDATE emailadmin SET emailpassworduserreset = '".$_POST['emailpasswordpengguna2']."' ", $database_connection) or die('Database INSERT Error');
	echo '<br /><table cellspacing="1" class="SA_success_box"><tr><td><br />'.AFF_E_ADMINEMAILCHANGED.'<br /><br /></td></tr></table><br />';
    }
}

// Update Email Pengesahan Bayaran Kepada Admin
if($_POST['commited06'] == 'yes')
{
    // Semak Penghantaran Data
    if($_POST['emailsahkomisyen'] == '')
    $errorMsg .= '<br />'.AFF_E_ADMINEMAILERROR.'<br />';
	
    if($errorMsg == '')
    {
    	mysql_query("UPDATE emailadmin SET emailsahkomisyen = '".$_POST['emailsahkomisyen']."' ", $database_connection) or die('Database INSERT Error');
	echo '<br /><table cellspacing="1" class="SA_success_box"><tr><td><br />'.AFF_E_ADMINEMAILCHANGED.'<br /><br /></td></tr></table><br />';
    }
}

// Update Email Pengesahan Bayaran Kepada Admin
if($_POST['commited07'] == 'yes')
{
    // Semak Penghantaran Data
    if($_POST['emailbayarkomisyen'] == '')
    $errorMsg .= '<br />'.AFF_E_ADMINEMAILERROR.'<br />';

    if($errorMsg == '')
    {
    	mysql_query("UPDATE emailadmin SET emailbayarkomisyen = '".$_POST['emailbayarkomisyen']."' ", $database_connection) or die('Database INSERT Error');
	echo '<br /><table cellspacing="1" class="SA_success_box"><tr><td><br />'.AFF_E_ADMINEMAILCHANGED.'<br /><br /></td></tr></table><br />';
    }
}

// Dapatkan Data dari Table OPT-IN Admin
$result = mysql_query('SELECT * from emailadmin', $database_connection) or die ('Database Error');

if($errorMsg != '')
echo '<br /><table cellspacing="1" class="SA_error_box"><tr><td>'.$errorMsg.'<br /></td></tr></table><br />';

if (mysql_num_rows($result))
{
    while ($qry = mysql_fetch_array($result))
    {
?>   
<br  />	
<form name="registration" method="post" action="pwjafflite_admin_email.php">
    <table width="600" cellspacing="1" class="SA_general_table">
        <tr>
            <td class="SA_general_table_header"><?=AFF_E_ADMINEMAILDAFTARTITLE?></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1">&nbsp;</td>
        </tr>
        <tr>
            <td class="SA_general_table_row2"><div align="justify"><?=$arahan_email_daftar?><br /><br /></div></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><div align="center"><textarea id="01" name="emailpendaftaran" rows="30" cols="70"><?=$qry['emaildaftar']?></textarea></div></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row2">
                <div align="center">
                    <input type="hidden" name="commited01" value="yes"><input type="submit" name="Submit" value="<?=AFF_E_ADMINEMAILUPDATE?>">
                </div>
            </td>
        </tr>
    </table>
</form>
<br />
<br  />	
<form name="paymentuser" method="post" action="pwjafflite_admin_email.php">
    <table width="600" cellspacing="1" class="SA_general_table">
        <tr>
            <td class="SA_general_table_header"><?=AFF_E_ADMINEMAILPENGESAHANTITLE?></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1">&nbsp;</td>
        </tr>
        <tr>
            <td class="SA_general_table_row2"><div align="justify"><?=$arahan_email_pengesahan_pembeli?><br /><br /></div></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><div align="center"><textarea id="01" name="emailpengesahanbayaran" rows="30" cols="70"><?=$qry['emailpengesahan']?></textarea></div></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row2">
                <div align="center">
                    <input type="hidden" name="commited02" value="yes"><input type="submit" name="Submit" value="<?=AFF_E_ADMINEMAILUPDATE?>">
                </div>
            </td>
        </tr>
    </table>
</form>
<br />
<br  />	
<form name="paymentadmin" method="post" action="pwjafflite_admin_email.php">
    <table width="600" cellspacing="1" class="SA_general_table">
        <tr>
            <td class="SA_general_table_header"><?=AFF_E_ADMINEMAILPENGESAHANTITLE2?></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1">&nbsp;</td>
        </tr>
        <tr>
            <td class="SA_general_table_row2"><div align="justify"><?=$arahan_email_pengesahan_admin?><br /><br /></div></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><div align="center"><textarea id="01" name="emailpengesahanbayaranadmin" rows="30" cols="70"><?=$qry['emailpengesahanadmin']?></textarea></div></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row2">
                <div align="center">
                    <input type="hidden" name="commited03" value="yes"><input type="submit" name="Submit" value="<?=AFF_E_ADMINEMAILUPDATE?>">
                </div>
            </td>
        </tr>
    </table>
</form>
<br />
<br  />	
<form name="passwordconfirm" method="post" action="pwjafflite_admin_email.php">
    <table width="600" cellspacing="1" class="SA_general_table">
        <tr>
            <td class="SA_general_table_header"><?=AFF_E_ADMINEMAILPASSUSERTITLE1?></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1">&nbsp;</td>
        </tr>
        <tr>
            <td class="SA_general_table_row2"><div align="justify"><?=$arahan_email_password_agen?><br /><br /></div></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><div align="center"><textarea id="01" name="emailpasswordpengguna" rows="30" cols="70"><?=$qry['emailpassworduser']?></textarea></div></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row2">
                <div align="center">
                    <input type="hidden" name="commited04" value="yes"><input type="submit" name="Submit" value="<?=AFF_E_ADMINEMAILUPDATE?>">
                </div>
            </td>
        </tr>
    </table>
</form>
<br />
<br  />
<form name="passwordreset" method="post" action="pwjafflite_admin_email.php">
    <table width="600" cellspacing="1" class="SA_general_table">
        <tr>
            <td class="SA_general_table_header"><?=AFF_E_ADMINEMAILPASSUSERTITLE2?></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1">&nbsp;</td>
        </tr>
        <tr>
            <td class="SA_general_table_row2"><div align="justify"><?=$arahan_email_password_agen2?><br /><br /></div></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><div align="center"><textarea id="01" name="emailpasswordpengguna2" rows="30" cols="70"><?=$qry['emailpassworduserreset']?></textarea></div></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row2">
                <div align="center">
                    <input type="hidden" name="commited05" value="yes"><input type="submit" name="Submit" value="<?=AFF_E_ADMINEMAILUPDATE?>">
                </div>
            </td>
        </tr>
    </table>
</form>
<br />
<br  />	
<form name="sahkomisyen" method="post" action="pwjafflite_admin_email.php">
    <table width="600" cellspacing="1" class="SA_general_table">
        <tr>
            <td class="SA_general_table_header"><?=AFF_E_ADMINEMAILCOMMISSIONVERIFIED?></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1">&nbsp;</td>
        </tr>
        <tr>
            <td class="SA_general_table_row2"><div align="justify"><?=$arahan_email_komisyen_sah?><br /><br /></div></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><div align="center"><textarea id="01" name="emailsahkomisyen" rows="30" cols="70"><?=$qry['emailsahkomisyen']?></textarea></div>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row2"><div align="center"><input type="hidden" name="commited06" value="yes"><input type="submit" name="Submit" value="<?=AFF_E_ADMINEMAILUPDATE?>"></div>
            </td>
        </tr>
    </table>
</form>
<br />
<br  />	
<form name="bayarkomisyen" method="post" action="pwjafflite_admin_email.php">
    <table width="600" cellspacing="1" class="SA_general_table">
        <tr>
            <td class="SA_general_table_header"><?=AFF_E_ADMINEMAILCOMMISSIONPAID?></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1">&nbsp;</td>
        </tr>
        <tr>
            <td class="SA_general_table_row2"><div align="justify"><?=$arahan_email_bayar_komisyen?><br /><br /></div></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><div align="center"><textarea id="01" name="emailbayarkomisyen" rows="30" cols="70"><?=$qry['emailbayarkomisyen']?></textarea></div></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row2"><div align="center"><input type="hidden" name="commited07" value="yes"><input type="submit" name="Submit" value="<?=AFF_E_ADMINEMAILUPDATE?>"></div></td>
        </tr>
    </table>
</form>
<br />

<?  
    }
}
//Papar Footer
echo $footerdisplay;

?>