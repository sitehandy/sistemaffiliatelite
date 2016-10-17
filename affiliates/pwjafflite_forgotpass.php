<?php

session_start();

// Intergrasi sistem borang dengan PHPMailer
include '../includes/mail/class.phpmailer.php';

include '../pwjafflite_config.php';
include './lang/'.$language;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? print $namaproduk; ?> - Client Contact Form</title>
<link href="./pwjafflite_temp/pwjafflite_styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
    <div id="SA_content_area">

<?php

// Cek data yang dihantar
if ($_POST)
{
    // if the user submited the form
    $usertosend = (isset($_POST['refid'])) ? $_POST['refid'] : '';
    $passtosend = '';
    $nametosend = '';
    $useremail = (isset($_POST['email'])) ? $_POST['email'] : '';


    if ($usertosend != '' || $useremail != '')
    {
        $result = mysql_query("SELECT * FROM affiliates WHERE email = '{$_REQUEST['email']}' AND refid = '{$_REQUEST['refid']}' LIMIT 1", $database_connection)
                or die ("ERROR:" . mysql_error());
        
        while ($qry = mysql_fetch_array($result))
        {
            $usertosend = $qry['refid'];
            $passtosend = $qry['pass'];
            $nametosend = $qry['firstname'].' '.$qry['lastname'];
        }
    }

    // if it is then send the email with his data
    if (($usertosend != '') && ($passtosend != '') && ($nametosend != ''))
    {
        // Hantar Email Pendaftaran Ke Email Agen
        $dataemail = mysql_query('SELECT * FROM emailadmin', $database_connection) or die ('Database Error');

        if (mysql_num_rows($dataemail))
        {
            while ($qryemail = mysql_fetch_array($dataemail))
            {
                // Dapatkan Data Email Dari Database
                $email_pohon_pass = $qryemail['emailpassworduser'];
                
                // Kesan Tag dan Data
                $emailtag = array('%%namaagen%%', '%%namaproduk%%', '%%loginaffiliate%%', '%%idagen%%', '%%urlresetpassword%%', '%%namaadmin%%', '%%emailsupport%%', '%%domain%%', '%%ippelanggan%%', '%%tarikhborang%%', '%%masaborang%%', '%%browserpelanggan%%');
                $emailtagreplace = array($nametosend, $namaproduk, 'http://'.$domain.'/'.$folderaffiliates.'', $usertosend, 'http://'.$domain.'/'.$folderaffiliates.'/pwjafflite_forgotpass_request.php?id='.$usertosend.'&email='.$_REQUEST['email'].'&resetpass='.$passtosend.'', $admininfo, $emailadminsupport, $domain, $clientip, $clientdate, $clienttime, $clientbrowser, ENT_QUOTES, 'UTF-8');

                // Convert Tag Kepada Data Dalam Email
                $email_send = str_replace($emailtag, $emailtagreplace, $email_pohon_pass);

                                
                /********************************
                * Versi lama proses kiriman emel
                *********************************/
                // Proses Email Dan Hantar Kepada Agen Baru
                // mail($_REQUEST['email'], $nametosend.', '.AFF_SI_PASSWORDREQUEST, $email_send, 'From: '.$admininfo.'<'.$emailadminsupport.'>');

                /********************************
                * Versi baru proses kiriman emel (Updated July 2013)
                * Penggunaan PHPMailer: https://github.com/Synchro/PHPMailer
                *********************************/

                $mail = new PHPMailer;

                $mail->IsMail();									// Set mailer to use PHP Mail

                $mail->From = $emailadminsupport;
                $mail->FromName = $admininfo;
                $mail->AddAddress($_REQUEST['email'], $nametosend);		// Add a recipient
                $mail->AddReplyTo($emailadminsupport);

                $mail->IsHTML(false);								// Set email format to plain text

                $mail->Subject = AFF_SI_PASSWORDREQUEST;

                $mail->Body    = $email_send; 				// Email body

                // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                if(!$mail->Send()) {
                   echo 'Message could not be sent.';
                   echo 'Mailer Error: ' . $mail->ErrorInfo;
                   exit();
                }
            }
        }


echo '<br /><table bgcolor="#FFFFFF" cellspacing="1" class="SA_login_box"><tr><td class="SA_login_box_header">'.AFF_FP_REQUESTSENT.'</td></tr><tr><td class="SA_login_box_row1"><div align="justify"><br />'.AFF_FP_REQUESTSENTINFO.'<br /><br /></div></td></tr><tr><td class="SA_login_box_row2"><div align="center"></div></td></tr></table><br />';


	} else {

		// if it isn�t then show an error message

		echo '<br /><table bgcolor="#FFFFFF" cellspacing="1" class="SA_login_box"><tr><td class="SA_login_box_header">'.AFF_FP_NODATATITLE.'</td></tr><tr><td class="SA_login_box_row1"><br />'.$AFF_FP_NODATA.'<br /><br /></td></tr><tr><td class="SA_login_box_row2"><div align="center">[ <a href="pwjafflite_forgotpass.php">'.AFF_FP_RETURNLINK.'</a> ]</div></td></tr></table><br />';

	}

} else { // and if he didn�t submitted the form, then show it :)

?>

<br />
<form method="post" action="pwjafflite_forgotpass.php">
<table bgcolor="#FFFFFF" cellspacing="1" class="SA_login_box">
    <tr>
        <td colspan="3" class="SA_login_box_header"><?=AFF_FP_INFO?></td>
    </tr>
    <tr>
        <td class="SA_login_box_row1"><div align="right"><?=AFF_FP_EMAIL?></div></td>
        <td class="SA_login_box_row1"><div align="center">:</div></td>
        <td class="SA_login_box_row1"><input name="email" type="text" id="email" size="30" /></td>
    </tr>
    <tr>
        <td class="SA_login_box_row2"><div align="right"><?=AFF_FP_USERNAME?></div></td>
        <td class="SA_login_box_row2"><div align="center">:</div></td>
        <td class="SA_login_box_row2"><input name="refid" type="text" id="mail" size="30" /></td>
    </tr>
    <tr>
        <td colspan="3" class="SA_login_box_row1">
            <div align="center">
                <input type="submit" name="Submit" value="<?=AFF_FP_REQUESTPASSBUTTON?>" />
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" class="SA_login_box_row2"><div align="center"></div></td>
    </tr>
</table>
</form>
<br />
<? } 

?>

   </div>
</div>
</body>
</html>