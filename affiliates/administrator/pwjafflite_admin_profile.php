<?php

session_start();

// Intergrasi sistem borang dengan PHPMailer
include '../../includes/mail/class.phpmailer.php';

include '../../pwjafflite_config.php';
include '../lang/'.$language;

if(!aff_admin_check_security())
{
    aff_redirect('index.php');
    exit();
}

// Papar Header Sistem Affiliate
include 'header.php';

$titleErrorMsg = AFF_SI_TITLE;
$errorMsg = '';

if($_POST['commited'] == 'yes')
{
    // check usernameadmin
    if($_POST['usernameadmin'] == ''){
    $errorMsg .= '<br />'.AFF_AA_USERNAMEMISSING.'<br />';
    }

    // check password
    if($_POST['passwordadmin'] == ''){
    $errorMsg .= '<br />'.AFF_AA_PWDMISSING.'<br />';
    }

    // test the new passwords match
    if($_POST['passwordadmin'] != $_POST['passwordadmin2']){
    $errorMsg .= '<br />'.AFF_SI_PWDNOTMATCH.'<br />';
    }

    // check admin name
    if($_POST['namaadmin'] == ''){
    $errorMsg .= '<br />'.AFF_AA_ADMINNAMEMISSING.'<br />';
    }
		
    // check email admin
    if($_POST['emailadmin'] == ''){
    $errorMsg .= '<br />'.AFF_AA_EMAILADMINMISSING.'<br />';
    }
		
//encrypt password admin
$passwordadmin = sha1(sha1($_POST['passwordadmin']));


// Jika tiada masalah, update database admin
if($errorMsg == '')
{
	
// Hantar notifikasi ruangan admin gagal login	  
	
$email_admin_tukar_password = '

Salam sejahtera, '.$admininfo.'

Butiran login ke ruang admin sistem affiliate
di http://'.$domain.'/'.$folderaffiliates.'/'.$folderadmin.'/
telah berjaya ditukar menerusi halaman profile
admin.

===========================================================
Maklumat Login Baru
===========================================================

Login Admin: '.$_POST['usernameadmin'].'
Password Admin: '.$_POST['passwordadmin'].'
Email Admin: '.$_POST['emailadmin'].'


===========================================================
Rekod Komputer Semasa Penukaran Login
===========================================================

=> No. IP: '.$clientip.'

=> Tarikh: '.$clientdate.'
=> Masa: '.$clienttime.'

=> Browser: 
'.$clientbrowser.'

===========================================================

Sekian, terima kasih.

Sistem Affiliate.
http://'.$domain.'/

';


        /********************************
        * Versi lama proses kiriman emel
        *********************************/
        // Proses Email Pengesahan Komisyen.
        // mail($emailadmin, $admininfo.': '.AFF_AA_ADMINCHANGEPASSWORD, $email_admin_tukar_password, 'From: '.$admininfo.'<'.$emailadminsupport.'>');

        /********************************
        * Versi baru proses kiriman emel (Updated July 2013)
        * Penggunaan PHPMailer: https://github.com/Synchro/PHPMailer
        *********************************/

        $mail = new PHPMailer;

        $mail->IsMail();									// Set mailer to use PHP Mail

        $mail->From = $emailadminsupport;
        $mail->FromName = $admininfo;
        $mail->AddAddress($emailadmin, $admininfo);		// Add a recipient
        $mail->AddReplyTo($emailadminsupport);

        $mail->IsHTML(false);								// Set email format to plain text

        $mail->Subject = $admininfo.': '.AFF_AA_ADMINCHANGEPASSWORD;

        $mail->Body    = $email_admin_tukar_password; 				// Email body

        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->Send()) {
           echo 'Message could not be sent.';
           echo 'Mailer Error: ' . $mail->ErrorInfo;
           exit();
        }
        
// Update Database Table Admin
mysql_query("UPDATE admin SET user = '".$_POST['usernameadmin']."', pass = '".$passwordadmin."', namaadmin = '".$_POST['namaadmin']."', emailadmin = '".$_POST['emailadmin']."' ", $database_connection) or die ('Database Error');

echo '<br /><table cellspacing="1" class="SA_success_box"><tr><td><br />'.AFF_AA_INFOCHANGED.'<br /><br /></td></tr></table><br />';
}
//Close if($_POST['commited'] == 'yes')
}

// Jika Wujud masalah, paparkan puncanya
if($errorMsg != '')
{
    echo "<br /><table cellspacing=\"1\" class=\"SA_error_box\"><tr><td>$errorMsg<br /></td></tr></table><br />";
}

// Papar Data Dari Database
$result = mysql_query("SELECT * FROM admin", $database_connection) or die ('Database Error');
if (mysql_num_rows($result))
{
    while ($qry = mysql_fetch_array($result))
    {
?>   
	<br />            
	<form action="pwjafflite_admin_profile.php" method="post" ENCTYPE="multipart/form-data">
            <table cellspacing="1" class="SA_adminarea_statisticbox">
                <tr>
                    <td colspan="3" class="SA_adminarea_statisticbox_header"><?=AFF_AA_ADMINDETAILS?></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row1"><div align="right"><?=AFF_AA_ADMINUSERNAME?></div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left"><input type="text" name="usernameadmin" size="20" value="<?=$qry['user']?>"><font color="#FF0000">*</font></div></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row2"><div align="right"><?=AFF_AA_ADMINPASSWORD?></div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><input type="password" name="passwordadmin" size="20" value=""><font color="#FF0000">*</font></div></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row1"><div align="right"><?=AFF_R_PASSWORD2?></div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left"><input type="password" name="passwordadmin2" size="20"><font color="#FF0000">*</font></div></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row2"><div align="right"><?=AFF_AA_ADMINNAME?></div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><input type="text" name="namaadmin" size="30" value="<?=$qry['namaadmin']?>"><font color="#FF0000">*</font></div></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row1"><div align="right"><?=AFF_AA_ADMINEMAIL?></div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left"><input type="text" name="emailadmin" size="30" value="<?=$qry['emailadmin']?>"><font color="#FF0000">*</font></div></td>
                </tr>
                <tr>
                    <td colspan="3" class="SA_adminarea_statisticbox_row2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan=3 valign="middle" class="SA_adminarea_statisticbox_row1">
                        <div align="center">
                            <input type="hidden" name="commited" value="yes">
                            <input type="submit" name="Submit" value="<?=AFF_AA_SUBMITADMINPROFILE?>">
                        </div>
                    </td>
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