<?php

session_start();

// Intergrasi sistem borang dengan PHPMailer
include '../includes/mail/class.phpmailer.php';

include '../pwjafflite_config.php';
include './lang/'.$language;

// Paparkan Header Sistem Affiliate
include 'header.php';


//Get Data
$idagen = $_REQUEST['id'];
$email = $_REQUEST['email'];
$resetpass = $_REQUEST['resetpass'];


//Hasilkan nilai string password secara rawak menggunakan fungsi md5
$md5_hash = md5(rand(0,999)); 

//Pilih hanya 8 nombor sahaja untuk dipamerkan pada sistem captcha 
$newpassgenerate = substr($md5_hash, 19, 8); 

//encrypt password agen
$passwordagen = sha1(sha1($newpassgenerate));


 // Get Affiliate Record

$result = mysql_query("SELECT * FROM affiliates WHERE refid = '$idagen' AND pass = '$resetpass' LIMIT 1", $database_connection) or die ('Database Error');


if (mysql_num_rows($result)) 
{
    while ($qry = mysql_fetch_array($result))
    {
        $idagenaffiliate = $qry['refid'];
        $namaagen = $qry['firstname']." ".$qry['lastname'];
        $emailaffiliate = $qry['email'];
        $passwordaffiliate = $qry['pass'];
	

        // Hantar Email Pendaftaran Ke Email Agen
        $dataemail = mysql_query('SELECT * FROM emailadmin', $database_connection) or die ('Database Error');

        if (mysql_num_rows($dataemail))
        {
            while ($qryemail = mysql_fetch_array($dataemail))
            {
                // Dapatkan Data Email Dari Database
                $email_pass_reset = $qryemail['emailpassworduserreset'];

                // Kesan Tag dan Data
                $emailtag = array('%%namaagen%%', '%%namaproduk%%', '%%loginaffiliate%%', '%%idagen%%', '%%passwordbaruagen%%','%%linkaffiliate%%', '%%namaadmin%%', '%%emailsupport%%', '%%domain%%', '%%ippelanggan%%', '%%tarikhborang%%', '%%masaborang%%', '%%browserpelanggan%%');
                $emailtagreplace = array($namaagen, $namaproduk, 'http://'.$domain.'/'.$folderaffiliates.'', $idagenaffiliate, $newpassgenerate, 'http://'.$domain.'/'.$landingpage.'?ref='.$idagenaffiliate.'', $admininfo, $emailadminsupport, $domain, $clientip, $clientdate, $clienttime, $clientbrowser, ENT_QUOTES, 'UTF-8');

                // Convert Tag Kepada Data Dalam Email
                $email_send = str_replace($emailtag, $emailtagreplace, $email_pass_reset);
               
                
                /********************************
                * Versi lama proses kiriman emel
                *********************************/
                // Proses Email Dan Hantar Kepada Agen Baru
                // mail($emailaffiliate, $namaagen.' '.AFF_G_AFFILIATELOGINCHANGED, $email_send, 'From: '.$admininfo.'<'.$emailadminsupport.'>');

                /********************************
                * Versi baru proses kiriman emel (Updated July 2013)
                * Penggunaan PHPMailer: https://github.com/Synchro/PHPMailer
                *********************************/

                $mail = new PHPMailer;

                $mail->IsMail();									// Set mailer to use PHP Mail

                $mail->From = $emailadminsupport;
                $mail->FromName = $admininfo;
                $mail->AddAddress($emailaffiliate, $namaagen);		// Add a recipient
                $mail->AddReplyTo($emailadminsupport);

                $mail->IsHTML(false);								// Set email format to plain text

                $mail->Subject = $namaagen.', '.AFF_G_AFFILIATELOGINCHANGED;

                $mail->Body    = $email_send; 				// Email body

                // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                if(!$mail->Send()) {
                   echo 'Message could not be sent.';
                   echo 'Mailer Error: ' . $mail->ErrorInfo;
                   exit();
                }
            }
        }

        // Update Database Table Affiliate
        mysql_query("UPDATE affiliates SET pass = '".$passwordagen."' WHERE refid = '$idagen' AND email = '$email' LIMIT 1", $database_connection) or die ('Database Connection Error');

        // Papar Mesej Password Telah Berjaya Diubah
        echo '<br /><table cellspacing="1" class="SA_login_box"><tr><td class="SA_login_box_header">'.AFF_FP_REQUESTSENT.'</td></tr><tr><td class="SA_login_box_row1"><br />'.AFF_FP_PASSCHANGEDDONE.'<br /><br /></td></tr><tr><td class="SA_login_box_row2"><div align="center">[ <a href="index.php">'.AFF_FP_RETURNLINK.'</a> ]</div></td></tr></table><br />';

    }
}

// if it isn�t then show an error message

else echo '<br /><table cellspacing="1" class="SA_login_box"><tr><td class="SA_login_box_header">'.AFF_FP_NODATATITLE.'</td></tr><tr><td class="SA_login_box_row1"><br />'.$AFF_FP_NODATA2.'<br /><br /></td></tr><tr><td class="SA_login_box_row2"><div align="center">[ <a href="pwjafflite_forgotpass.php">'.AFF_FP_RETURNLINK.'</a> ]</div></td></tr></table><br />';

//Papar Footer Dari Fail pwjafflite_config.php

echo $footerdisplay;    
exit();

?>