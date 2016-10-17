<?php

session_start();
// Intergrasi sistem borang dengan PHPMailer
include '../includes/mail/class.phpmailer.php';

include '../pwjafflite_config.php';
include './lang/'.$language;
include './countries.php';
include './pwjafflite_processor.php';
include './pwjafflite_title.php';
  
$cookiesaffiliate = $_COOKIE['ref'];
$registrationcode = $_GET['registrationcode'];


// Avoid black space & non word and digit char
$getusername    = $_POST['ausername'];
$username       = preg_replace('/[^a-zA-Z0-9_]/', '',$getusername);

$getpassword    = $_POST['apassword'];
$userpassword   = preg_replace('/[^a-zA-Z0-9_]/', '',$getpassword);

// Dapat Konfigurasi Sistem Daripada Database Table Terma Pendaftaran
$result = mysql_query("SELECT * from termadaftar", $database_connection) or die ('Database CONNECT Error'); 

if (mysql_num_rows($result))
{
    while ($qry = mysql_fetch_array($result))
    {	
	$programTerms = $qry['kandunganterma'];
    }
}
	
	
// Tetapkan Masalah Default adalah kosong.
$errorMsg = '';

if($_POST['commited'] == 'yes')
{
    if($username == ''){
    $errorMsg .= '<br />'.AFF_SI_UNAMEMISSING.'<br />';
    }

    // check if user doesnt exist already
    $userid = preg_replace('/[^a-zA-Z0-9_]/', '', $username); // protect against sql injection

    $chk_user = mysql_query("SELECT refid from affiliates where refid='$userid'", $database_connection);

    if(mysql_num_rows($chk_user) > 0)
    {
      $errorMsg .= '<br />'.AFF_SI_USEREXISTS.'<br />';
      $username = '';
    }

	// Check for a password and match against the confirmed password.
	
    if (strlen($userpassword) > 3) {
        if ($userpassword == $_POST['apassword2']) {
            $p = $userpassword;
        } else {
            $p = FALSE;
            $errorMsg .= '<br />'.AFF_SI_PWDNOTMATCH.'<br />';
        }
    } else {
        $p = FALSE;
        $errorMsg .= '<br />'.AFF_SI_PWDMISSING.'<br />';
    }


    // check firstname
    if($_POST['afirstname'] == ''){
    $errorMsg .= '<br />'.AFF_SI_FIRSTNAMEMISSING.'<br />';
    }

    // check lastname
    if($_POST['alastname'] == ''){
    $errorMsg .= '<br />'.AFF_SI_LASTNAMEMISSING.'<br />';
    }

    // check if email is exist
    $aemail = $_POST['aemail'];

    if ($_POST['aemail'] == ''){    
    $errorMsg .= '<br />'.AFF_SI_EMAILMISSING.'<br />'; 
    }

    if(!filter_var($aemail, FILTER_VALIDATE_EMAIL)){
    $errorMsg .= '<br />'.AFF_SI_EMAILNOTVALID.'<br />';
    }
 
    $chk_email = mysql_query("SELECT refid FROM affiliates WHERE email='$aemail'", $database_connection);

    if(mysql_num_rows($chk_email) > 0){
    $errorMsg .= '<br />'.AFF_SI_EMAILSUDAHADA.'<br />';
    }

    // check address
    if($_POST['astreet'] == ''){
    $errorMsg .= '<br />'.AFF_SI_ADDRESSMISSING.'<br />';
    }
  
    // check town
    if($_POST['atown'] == ''){
    $errorMsg .= '<br />'.AFF_SI_TOWNMISSING.'<br />';
    }

    // check state
    if($_POST['acounty'] == ''){
    $errorMsg .= '<br />'.AFF_SI_STATEMISSING.'<br />';
    }

    // check poskod
    if($_POST['apostcode'] == ''){
    $errorMsg .= '<br />'.AFF_SI_POSKODMISSING.'<br />';
    }

    // check phone
    if($_POST['aphone'] == ''){
    $errorMsg .= '<br />'.AFF_SI_PHONEMISSING.'<br />';
    }

    // check pemprosesan
    if($_POST['aprocessor'] == ''){
    $errorMsg .= '<br />'.AFF_SI_PEMPROSESANMISSING.'<br />';
    }

    // check no akaun
    if($_POST['aaccount'] == ''){
    $errorMsg .= '<br />'.AFF_SI_ACCOUNTMISSING.'<br />';
    }
	  
    // check i agree button
    if($_POST['termsagree'] == 'no'){
    $errorMsg .= '<br />'.AFF_SI_TERMS.'<br />';
    }

    //encrypt password:
    $password = sha1(sha1($userpassword));

    // Proses Data Jika Tiada Sebarang Masalah
    if($errorMsg == '')
    {
        mysql_query("INSERT INTO affiliates VALUES ('', '".$username."', '".$password."', '".$_POST['atitle']."', '".$_POST['afirstname']."', '".$_POST['alastname']."', '".$_POST['aemail']."', '".$_POST['awebsite']."', '".$_POST['astreet']."', '".$_POST['atown']."', '".$_POST['acounty']."', '".$_POST['apostcode']."', '".$_POST['acountry']."', '".$_POST['aphone']."', '".$_POST['aprocessor']."', '".$_POST['aaccount']."', '".$_POST['apayto']."', '$clientdate', '$clientip', '".$cookiesaffiliate."')", $database_connection) or die(mysql_error());
        // Hantar Email Pendaftaran Ke Email Agen

        $result = mysql_query('SELECT * FROM emailadmin', $database_connection) or die ('Database Error');

        if (mysql_num_rows($result))
        {
            while ($qry = mysql_fetch_array($result))
            {
                // Dapatkan Data Email Dari Database
                $email_pendaftaran_affiliate = $qry['emaildaftar'];
	
                // Kesan Tag dan Data
                $emailtag = array('%%namaagen%%', '%%namaproduk%%', '%%loginaffiliate%%', '%%idagen%%', '%%passwordagen%%', '%%linkaffiliate%%', '%%namaadmin%%', '%%domain%%');
                $emailtagreplace = array($_POST['afirstname'], $namaproduk, 'http://'.$domain.'/'.$folderaffiliates.'', $username, $userpassword, 'http://'.$domain.'/hop.php?ref='.$username.'', $admininfo, $domain, ENT_QUOTES, 'UTF-8');
		
                // Convert Tag Kepada Data Dalam Email
                $email_send = str_replace($emailtag, $emailtagreplace, $email_pendaftaran_affiliate);
                
                                
                /********************************
                * Versi lama proses kiriman emel
                *********************************/
                // Proses Email Dan Hantar Kepada Agen Baru
                // mail($_POST['aemail'], $_POST['afirstname'].' '.AFF_SI_EMAILAFFILIATEWELCOME, $email_send, 'From: '.$admininfo.'<'.$emailadminsupport.'>');

                /********************************
                * Versi baru proses kiriman emel (Updated July 2013)
                * Penggunaan PHPMailer: https://github.com/Synchro/PHPMailer
                *********************************/

                $mail = new PHPMailer;

                $mail->IsMail();									// Set mailer to use PHP Mail

                $mail->From = $emailadminsupport;
                $mail->FromName = $admininfo;
                $mail->AddAddress($_POST['aemail'], $_POST['afirstname']);		// Add a recipient
                $mail->AddReplyTo($emailadminsupport);

                $mail->IsHTML(false);								// Set email format to plain text

                $mail->Subject = $_POST['afirstname'].', '.AFF_SI_EMAILAFFILIATEWELCOME;

                $mail->Body    = $email_send; 				// Email body

                // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                if(!$mail->Send()) {
                   echo 'Message could not be sent.';
                   echo 'Mailer Error: ' . $mail->ErrorInfo;
                   exit();
                }

            }
        }
        
        // Bawa Agen Baru Ke Halaman Terima Kasih
        include 'pwjafflite_thankyou.php';
        exit();
    }

// Close Post
}
// Paparan Halaman Register

include 'header.php';

$errorRegistration = '';

if ($registrationcode != $kodpendaftaran)
{
    $errorRegistration .= AFF_SI_REGISTRATIONNOTAUTHORIZED;
}

elseif ($kodpendaftaran == '0')
{
    $errorRegistration .= AFF_SI_REGISTRATIONNOTAUTHORIZED;
}

else {

?>
<br />
<table width="600" cellspacing="1" class="SA_general_table">
    <tr>
        <td colspan="3" class="SA_general_table_header"><div align="center"><?=AFF_R_INFOREGISTER?></div></td>
    </tr>
    <tr>
        <td class="SA_general_table_row1"><br /><? echo $instruction_page_register; ?><br /><br /></td>
    </tr>
</table>
<br />

<?

if($errorMsg != '')
{
    echo '<br /><table cellspacing="1" class="SA_error_box"><tr><td>'.$errorMsg.'<br /></td></tr></table><br />';
}

?>

<br />
<div align="center">
<form name="signupform" method="post" action="pwjafflite_register.php?registrationcode=<?=$_REQUEST['registrationcode']?>">
    <table width="600" cellspacing="1" class="SA_general_table">
        <tr>
            <td colspan="3" class="SA_general_table_header"><?=AFF_R_DETAILS?></td>
        </tr>
        <tr>
            <td class="SA_general_table_row2"><?=AFF_R_TITLE?></td>
            <td class="SA_general_table_row2"><div align="center">:</div></td>
            <td class="SA_general_table_row2">
                <select name="atitle" class="dropdown">
                <?
                    foreach($GLOBALS['title'] as $key => $title)
                    print '<option value="'.$key.'" '.($_POST['atitle'] == $key ? 'selected' : '').'>'.$title.'</option>'."\r\n";
		?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><?=AFF_R_FIRSTNAME?></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1"><input type="text" name="afirstname" size="30" value="<?=$_POST['afirstname']?>"><font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td class="SA_general_table_row2"><?=AFF_R_LASTNAME?></td>
            <td class="SA_general_table_row2"><div align="center">:</div></td>
            <td class="SA_general_table_row2"><input type="text" name="alastname" size="30" value="<?=$_POST['alastname']?>"><font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row1">&nbsp;</td>
        </tr>
        <tr>
            <td class="SA_general_table_row2"><?=AFF_R_EMAIL?></td>
            <td class="SA_general_table_row2"><div align="center">:</div></td>
            <td class="SA_general_table_row2"><input type="text" name="aemail" size="30" value="<?=$_POST['aemail']?>"><font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><?=AFF_R_WEBSITE?></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1"><input type="text" name="awebsite" size="30" value="<?=$_POST['awebsite']?>"></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row2">&nbsp;</td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><?=AFF_R_STREET?></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1"><input type="text" name="astreet" size="30" value="<?=$_POST['astreet']?>"><font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td class="SA_general_table_row2"><?=AFF_R_CITY?></td>
            <td class="SA_general_table_row2"><div align="center">:</div></td>
            <td class="SA_general_table_row2"><input type="text" name="atown" size="30" value="<?=$_POST['atown']?>"><font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><?=AFF_R_STATE?></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1"><input type="text" name="acounty" size="30" value="<?=$_POST['acounty']?>"><font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td class="SA_general_table_row2"><?=AFF_R_POSTCODE?></td>
            <td class="SA_general_table_row2"><div align="center">:</div></td>
            <td class="SA_general_table_row2"><input type="text" name="apostcode" size="10" value="<?=$_POST['apostcode']?>"><font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><?=AFF_R_COUNTRY?></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1">
                <select name="acountry" class="dropdown">
                    <?
                        foreach($GLOBALS['countries'] as $key => $country)
                        if($key == 'MY')
                        {
                            print '<option value="'.$key.'" selected>'.$country.'</option>';
			}
                        
                        else
                        {
                            print '<option value="'.$key.'" '.($_POST['acountry'] == $key ? 'selected' : '').'>'.$country.'</option>';
			}
                        
                   ?>
                </select><font color="#FF0000">*</font>
            </td>
        </tr>
        <tr>
            <td class="SA_general_table_row2"><?=AFF_R_PHONE?></td>
            <td class="SA_general_table_row2"><div align="center">:</div></td>
            <td class="SA_general_table_row2"><input type="text" name="aphone" size="30" value="<?=$_POST['aphone']?>"><font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row1">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_header"><?=AFF_R_PAYMENTTYPEINFO?></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><?=AFF_R_PAYMENTTYPE?></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1">
                <select name="aprocessor" class="dropdown" value="BANK" >
                        <?
                            foreach($GLOBALS['processor'] as $key => $processor)
                            print '<option value="'.$key.'" '.($_POST['aprocessor'] == $key ? 'selected' : '').'>'.$processor.'</option>'."\n";
                        ?>
                </select><font color="#FF0000">*</font>
            </td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><?=AFF_R_ACCOUNTNO?></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1"><input type="text" name="aaccount" size="30" value="<?=$_POST['aaccount']?>"><font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td class="SA_general_table_row2"><?=AFF_R_PAYTO?></td>
            <td class="SA_general_table_row2"><div align="center">:</div></td>
            <td class="SA_general_table_row2"><input type="text" name="apayto" size="30" value="<?=$_POST['apayto']?>"></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row1">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_header"><?=AFF_R_LOGININFO?></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><?=AFF_R_USERNAME?></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1"><input type="text" name="ausername" maxlength="12" size=20 value="<?=$_POST['ausername']?>"><font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td class="SA_general_table_row2"><?=AFF_R_PASSWORD?></td>
            <td class="SA_general_table_row2"><div align="center">:</div></td>
            <td class="SA_general_table_row2"><input type="password" name="apassword" size="20" maxlength="12" ><font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><?=AFF_R_PASSWORD2?></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1"><input type="password" name="apassword2" size="20" maxlength="12" ><font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_header"><?=AFF_R_TERMS?></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row1">
                <div align="center"><br />
                    <textarea name="terms" cols="50" rows="7" readonly="readonly"><?=$programTerms?></textarea>
                    <br />
                    <input name="termsagree" type="radio" value="yes"><?=AFF_R_TERMSAGREE?> <input name="termsagree" type="radio" value="no" checked><?=AFF_R_TERMSNOTAGREE?>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row2">
                <div align="center">
                    <input type="hidden" name="commited" value="yes">
                    <input type="submit" value="<?=AFF_R_SUBMITBUTTON?>" name="submit" >
                </div>
            </td>
        </tr>
    </table>
</form>
</div>
<br />

<?php
} 

if($errorRegistration != ''){
    echo '<br /><table width="600" cellspacing="1" class="SA_general_table"><tr><td class="SA_general_table_header">'.$errorRegistration.'</td></tr><tr><td class="SA_general_table_row1"><br />'.$errorRegistration.'<br /><br /></td></tr></table><br />';
}

//Papar Footer Dari Fail pwjafflite_config.php
echo $footerdisplay;

?>