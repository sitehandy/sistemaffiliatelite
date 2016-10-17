<?php

// Penetapan fungsi session untuk sistem captcha
session_start();

// Intergrasi sistem borang dengan PHPMailer
include 'includes/mail/class.phpmailer.php';

// Intergrasi sistem borang dengan sistem affiliate
include 'pwjafflite_config.php';
include $folderaffiliates.'/lang/'.$language;

// Dapatkan maklumat yang dikirimkan pada borang tempahan
$namapembeli 		= $_POST['namapembeli'];
$emailpembeli		= $_POST['emailpembeli'];
$telefonpembeli 	= $_POST['telefonpembeli'];  
$alamatpembeli 		= $_POST['alamatpembeli'];
$jumlahpembayaran 	= $_POST['jumlahpembayaran'];
$kaedahpembayaran 	= $_POST['kaedahpembayaran'];
$tarikhpembayaran 	= $_POST['tarikhpembayaran'];
$masapembayaran 	= $_POST['masapembayaran'];
$buktipembayaran 	= $_POST['buktipembayaran'];
$notatambahan 		= $_POST['notatambahan'];

// Semak cookies agen affiliate
$ref = preg_replace('/[^a-zA-Z0-9-]/', '', $_COOKIE['ref'] );


// Berikut adalah konfigurasi tajuk dan penerangan masalah yang timbul sekiranya borang tidak diisi dengan betul.
// Tajuk Masalah Yang Tampil
$titleErrorMsg = BORANG_TAJUK_MASALAH;

// Kandungan masalah
$errorMsg = '';

if($namapembeli == '')
{
    $errorMsg .= BORANG_NAMA_PEMBELI.'<br /><br />';
}
	  
if($emailpembeli == '')
{
    $errorMsg .= BORANG_EMAIL_PEMBELI.'<br /><br />';
}

if(!filter_var($emailpembeli, FILTER_VALIDATE_EMAIL))
{
    $errorMsg .= BORANG_EMAIL_SAH_PEMBELI.'<br /><br />';
}
	  
if($telefonpembeli == '')
{
    $errorMsg .= BORANG_TELEFON_PEMBELI.'<br /><br />';  	  	  
}

if($jumlahpembayaran == BORANG_PILIH_JUMLAH_BAYARAN)
{
    $errorMsg .= BORANG_JUMLAH_BAYARAN.'<br /><br />';
}

if($kaedahpembayaran == BORANG_PILIH_KAEDAH_BAYARAN)
{
    $errorMsg .= BORANG_KAEDAH_BAYARAN.'<br /><br />';
}

if($tarikhpembayaran == '')
{
    $errorMsg .= BORANG_TARIKH_BAYARAN.'<br /><br />';
}

if($masapembayaran == '')
{
    $errorMsg .= BORANG_MASA_BAYARAN.'<br /><br />';
}
	  
if($buktipembayaran == '')
{
    $errorMsg .= BORANG_BUKTI_BAYARAN.'<br /><br />';
}
	  

// Semak code keselamatan borang dan pastikan ia tidak kosong serta 
// data yang dimasukkan haruslah sama seperti yang dipaparkan 

if( $kodcaptchaborang == 'ENABLE' )
{
    if( ($_REQUEST['nomborcaptcha'] == $_SESSION['kodsekuriti']) && (!empty($_REQUEST['nomborcaptcha']) && !empty($_SESSION['kodsekuriti'])) )
    {
	$errorMsg .= '';
    }
    
    else
    {
        $errorMsg .= BORANG_KOD_SEKURITI.'<br /><br />';
    }
}

// Berikut adalah konfigurasi paparan yang akan tampil jika wujud mana - mana satu masalah di atas. 	    
if($errorMsg != '')
{
    echo '<div align="center"><table width="400" border="0" cellspacing="2" cellpadding="4"><tr><td bgcolor="#DFDFDF"><font face="verdana" size="3" color="#FF0000"><center><b>'.$titleErrorMsg.'</b></center></font></td></tr><tr><td  bgcolor="#EFEFEF"><font face="verdana" size="2" color="#FF0000"><center>'.$errorMsg.'</center></font></td></tr><tr><td bgcolor="#DFDFDF"><font face="verdana" size="2" color="#FF0000"><center><b>>>> <a href="javascript:history.go(-1)">'.BORANG_KEMBALI.'</a> <<<</b></center></font></td></tr></table></div>';
}

// Jika tiada masalah dengan borang, proses data yang dikirimkan dan integrasi dengan sistem affiliate
if($errorMsg == '')
{
    if($ref == '')
    {
	//Semak dengan session dulu
	$ref = $_SESSION['ref'];

        //Jika tiada rekod dengan session, semak dengan database pula
        if ($_SESSION['ref'] == '')
        {   
            //Semak ID Affiliate Menerusi IP Address Pelawat
            $resultref = mysql_query("SELECT refid from clickthroughs WHERE ipaddress = '$clientip' ORDER BY date, time desc LIMIT 1", $database_connection) or die ('Database Connection Error');
            if( mysql_num_rows($resultref) )
            {
                while ($qryidref = mysql_fetch_array($resultref))
		          $ref = $qryidref['refid'];
            }
	}		
    }

    //Jika WUJUD ID affiliate, maka kreditkan komisyen kepada table SALES
    if( $ref != '' )
    {
        // Nilai komisyen affiliate
        $resultkomisyen = mysql_query("SELECT komisyenproduk FROM produk WHERE namaproduk = '$jumlahpembayaran' LIMIT 1", $database_connection) or die ('Database Connection Error');

        if( mysql_num_rows($resultkomisyen) )
        {
            while ($qrykomisyen = mysql_fetch_array($resultkomisyen))
            $komisyenaffiliate = $qrykomisyen['komisyenproduk'];
        }

        // Status pelanggan untuk pengesahan komisyen
        $statuspelanggan = AFF_AS_STATUSPENDING;

        // Data rekod pembelian dan komisyen ke dalam database sistem affiliate
        mysql_query("INSERT INTO sales (idsales, refid, jumlahpembayaran, kaedahpembayaran, date, time, browser, ipaddress, payment, namapelanggan, emailpelanggan, statuspelanggan) VALUES ('', '$ref', '$jumlahpembayaran', '$kaedahpembayaran', '$clientdate', '$clienttime', '$clientbrowser', '$clientip', '$komisyenaffiliate', '$namapembeli', '$emailpembeli', '$statuspelanggan')", $database_connection) or die('Database INSERT Error');
    }

    // Proses email kepada admin dan pelanggan
    // Berikut adalah konfigurasi untuk email balas kepada pelanggan.

    $resultemailpembeli = mysql_query('SELECT * FROM emailadmin', $database_connection) or die ('Database Connect Error');

    if( mysql_num_rows($resultemailpembeli))
    {
        while ($qryemailpembeli = mysql_fetch_array($resultemailpembeli))
        {
            // Dapatkan Data Email Dari Database
            $email_pengesahan_pembeli = $qryemailpembeli['emailpengesahan'];

            // Kesan Tag dan Data
            $emailtag = array('%%namaproduk%%', '%%namaadmin%%', '%%domain%%', '%%emailsupport%%', '%%namapembeli%%', '%%emailpembeli%%', '%%telefonpembeli%%', '%%alamatpembeli%%', '%%jumlahpembayaran%%', '%%kaedahpembayaran%%', '%%tarikhpembayaran%%', '%%masapembayaran%%', '%%buktipembayaran%%', '%%notapembeli%%', '%%idagen%%', '%%komisyenagen%%', '%%statuskomisyen%%');

            $emailtagreplace = array($namaproduk, $admininfo, $domain, $emailadminsupport, $namapembeli, $emailpembeli, $telefonpembeli, $alamatpembeli, $jumlahpembayaran, $kaedahpembayaran, $tarikhpembayaran, $masapembayaran, $buktipembayaran, $notatambahan, $ref, $komisyenaffiliate, $statuspelanggan, ENT_QUOTES, 'UTF-8');

            // Convert Tag Kepada Data Dalam Email
            $email_pembeli_send = str_replace($emailtag, $emailtagreplace, $email_pengesahan_pembeli);


            /********************************
            * Versi lama proses kiriman emel
            *********************************/
            // Hantar email balas di atas kepada pelanggan.
            // mail($_POST['emailpembeli'], BORANG_TAJUK_EMAIL_PELANGGAN.': '.$_POST['jumlahpembayaran'], $email_pembeli_send, 'From: '.$admininfo.'<'.$emailadminsupport.'>');

            /********************************
            * Versi baru proses kiriman emel (Updated July 2013)
            * Penggunaan PHPMailer: https://github.com/Synchro/PHPMailer
            *********************************/

            $mail = new PHPMailer;

            $mail->IsMail();									// Set mailer to use PHP Mail

            $mail->From = $emailadminsupport;
            $mail->FromName = $admininfo;
            $mail->AddAddress($emailpembeli, $namapembeli);		// Add a recipient
            $mail->AddReplyTo($emailadminsupport);

            $mail->IsHTML(false);								// Set email format to plain text

            $mail->Subject = BORANG_TAJUK_EMAIL_PELANGGAN .': '.$jumlahpembayaran;

            $mail->Body    = $email_pembeli_send; 				// Email body

            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if(!$mail->Send()) {
               echo 'Message could not be sent.';
               echo 'Mailer Error: ' . $mail->ErrorInfo;
               exit();
            }
        }
    }


    // Seterusnya hantar email borang pengesahan kepada admin
    $resultemailadmin = mysql_query('SELECT * FROM emailadmin', $database_connection) or die ('Database Error');

    if( mysql_num_rows($resultemailadmin) )
    {
        while( $qryemailadmin = mysql_fetch_array($resultemailadmin) )
        {
            // Dapatkan Data Email Dari Database
            $email_pengesahan_admin = $qryemailadmin['emailpengesahanadmin'];

            // Kesan Tag dan Data
            $emailtagadmin = array('%%namaproduk%%', '%%namaadmin%%', '%%domain%%', '%%emailsupport%%', '%%namapembeli%%', '%%emailpembeli%%', '%%telefonpembeli%%', '%%alamatpembeli%%', '%%jumlahpembayaran%%', '%%kaedahpembayaran%%', '%%tarikhpembayaran%%', '%%masapembayaran%%', '%%buktipembayaran%%', '%%notapembeli%%', '%%idagen%%', '%%komisyenagen%%', '%%statuskomisyen%%', '%%ippelanggan%%', '%%tarikhborang%%', '%%masaborang%%', '%%browserpelanggan%%');

            $emailtagadminreplace = array($namaproduk, $admininfo, $domain, $emailadminsupport, $namapembeli, $emailpembeli, $telefonpembeli, $alamatpembeli, $jumlahpembayaran, $kaedahpembayaran, $tarikhpembayaran, $masapembayaran, $buktipembayaran, $notatambahan, $ref, $komisyenaffiliate, $statuspelanggan, $clientip, $clientdate, $clienttime, $clientbrowser, ENT_QUOTES, 'UTF-8');

            // Convert Tag Kepada Data Dalam Email
            $email_admin_send = str_replace($emailtagadmin, $emailtagadminreplace, $email_pengesahan_admin);


            /********************************
            * Versi lama proses kiriman emel
            *********************************/
            // Hantar email borang pengesahan kepada admin   
            // mail($emailadminpayment, BORANG_TAJUK_EMAIL_ADMIN.': '.$jumlahpembayaran, $email_admin_send, 'From: '.$namapembeli.'<'.$emailpembeli.'>');

            /********************************
            * Versi baru proses kiriman emel (Updated July 2013)
            * Penggunaan PHPMailer: https://github.com/Synchro/PHPMailer
            *********************************/

            $mail = new PHPMailer;

            $mail->IsMail();									// Set mailer to use PHP Mail

            $mail->From = $emailadminsupport;
            $mail->FromName = $namapembeli;
            $mail->AddAddress($emailadminpayment, $admininfo);		// Add a recipient
            $mail->AddReplyTo($emailpembeli);

            $mail->IsHTML(false);								// Set email format to plain text

            $mail->Subject = BORANG_TAJUK_EMAIL_ADMIN .': '.$jumlahpembayaran;

            $mail->Body    = $email_admin_send; 				// Email body

            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if(!$mail->Send()) {
               echo 'Message could not be sent.';
               echo 'Mailer Error: ' . $mail->ErrorInfo;
               exit();
            }

            //JANGAN USIK BAHAGIAN INI JIKA ANDA TIDAK TAHU FUNGSINYA...
            // Setelah selesai proses diatas, hantar pelanggan ke URL baru
            header('Location: '.$domainredirect.'');
            exit();
        }
    }
}

?>