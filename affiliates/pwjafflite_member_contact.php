<?php

session_start();

// Intergrasi sistem borang dengan PHPMailer
include '../includes/mail/class.phpmailer.php';

include '../pwjafflite_config.php';
include './lang/'.$language;

if(!aff_check_security())
{
    aff_redirect('index.php');
    exit();
}

// Intergrasi konfigurasi sistem borang
  
// Dapatkan data dari borang  
$idaffiliate        = $_SESSION['aff_valid_user'];
$namapengguna       = $_POST['namapengguna'];
$emailpengguna      = $_POST['emailpengguna'];
$tajuksoalan        = $_POST['tajuksoalan'];
$kandungansoalan    = $_POST['kandungansoalan'];


// Jika wujud masalah sewaktu menghantar borang
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
// Tajuk Masalah Yang Tampil

$errorMsg = '';

if($_POST['commited'] == 'yes')
{
    if($namapengguna == ''){
    $errorMsg .= '<br />'.AFF_MA_CONTACTNAMEMISSING.'<br />';
    }
	  
    if($emailpengguna == ''){
    $errorMsg .= '<br />'.AFF_MA_CONTACTEMAILMISSING.'<br />';
    }

    if(!filter_var($emailpengguna, FILTER_VALIDATE_EMAIL)){
    $errorMsg .= '<br />'.AFF_MA_CONTACTEMAILMISSINGVALID.'<br />';
    }
	  
    if($tajuksoalan == ''){
    $errorMsg .= '<br />'.AFF_MA_CONTACTTITLEMISSING.'<br />';
    }
	  
    if($kandungansoalan == ''){
    $errorMsg .= '<br />'.AFF_MA_CONTACTCONTENTMISSING.'<br />';
    }


// Jika tiada masalah dengan borang, sistem hantar notifikasi
if($errorMsg == '')
{

$emailbalaspengguna = "

Salam sejahtera, $namapengguna

Terima kasih kerana telah menghubungi kami menerusi 
http://$domain/$folderaffiliates.

Berikut adalah salinan soalan yang anda kirimkan.

===========================================================
Salinan Email
===========================================================

=> ID Agen: $idaffiliate
=> Nama Anda: $namapengguna
=> Email Anda: $emailpengguna

=> Tajuk Soalan Anda: $tajuksoalan
=> Soalan Anda: 

$kandungansoalan

===========================================================

Kami akan membalas soalan anda dalam tempoh 3 hari bekerja.

Jika tiada jawapan yang anda terima, kirimkan pesanan anda ke 
$emailadminsupport.

Sekian, terima kasih.

Ikhlas

$admininfo
http://$domain


























===========================================================
Sistem Pesanan ini disediakan oleh www.SistemAffiliate.com/?aff_id=$idaffiliatePIS
===========================================================
";



        /********************************
        * Versi lama proses kiriman emel
        *********************************/
        // Hantar email balas di atas kepada pelanggan.
        // mail($emailpengguna, 'Re: '.AFF_MA_CONTACTEMAILCOPY, $emailbalaspengguna, 'From: '.$admininfo.'<'.$emailadminsupport.'>');

        /********************************
        * Versi baru proses kiriman emel (Updated July 2013)
        * Penggunaan PHPMailer: https://github.com/Synchro/PHPMailer
        *********************************/

        $mail = new PHPMailer;

        $mail->IsMail();									// Set mailer to use PHP Mail

        $mail->From = $emailadminsupport;
        $mail->FromName = $admininfo;
        $mail->AddAddress($emailpengguna, $namapengguna);		// Add a recipient
        $mail->AddReplyTo($emailadminsupport);

        $mail->IsHTML(false);								// Set email format to plain text

        $mail->Subject = 'Re: '.AFF_MA_CONTACTEMAILCOPY;

        $mail->Body    = $emailbalaspengguna; 				// Email body

        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->Send()) {
           echo 'Message could not be sent.';
           echo 'Mailer Error: ' . $mail->ErrorInfo;
           exit();
        }
        

// Seterusnya hantar email borang pengesahan kepada admin


$emailkepadaadmin = "

Salam sejahtera admin, $admininfo.

Anda telah menerima pesanan daripada agen affiliate anda
dari http://$domain/$folderaffiliates.

Berikut adalah butiran soalan yang dikemukakan.

===========================================================
Butiran Soalan
===========================================================

=> ID Agen: $idaffiliate
=> Nama Agen: $namapengguna
=> Email Agen: $emailpengguna

=> Tajuk Soalan: $tajuksoalan
=> Kandungan Soalan: 

$kandungansoalan


===========================================================
Rekod Komputer Agen Semasa Borang Dikirimkan
===========================================================

=> No. IP: $clientip

=> Tarikh: $clientdate
=> Masa: $clienttime

=> Browser: 
$clientbrowser

===========================================================

Sila simpan email ini untuk rujukan anda dimasa akan datang.

Sekian,
Sistem Affiliate
http://$domain

























===========================================================
Sistem ini disediakan oleh www.SistemAffiliate.com
===========================================================
";



        /********************************
        * Versi lama proses kiriman emel
        *********************************/        
        // Hantar email borang pengesahan kepada admin
        // mail($emailadminsupport, 'Affiliate '.$idaffiliate.': '.$tajuksoalan, $emailkepadaadmin, 'From: '.$namapengguna<$emailpengguna.'>');
        

        /********************************
        * Versi baru proses kiriman emel (Updated July 2013)
        * Penggunaan PHPMailer: https://github.com/Synchro/PHPMailer
        *********************************/

        $mail = new PHPMailer;

        $mail->IsMail();									// Set mailer to use PHP Mail

        $mail->From = $emailpengguna;
        $mail->FromName = $namapengguna;
        $mail->AddAddress($emailadminsupport, $admininfo);		// Add a recipient
        $mail->AddReplyTo($emailpengguna);

        $mail->IsHTML(false);								// Set email format to plain text

        $mail->Subject = 'Affiliate '.$idaffiliate.': '.$tajuksoalan;

        $mail->Body    = $emailkepadaadmin; 				// Email body

        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->Send()) {
           echo 'Message could not be sent.';
           echo 'Mailer Error: ' . $mail->ErrorInfo;
           exit();
        }

// Setelah selesai proses diatas, hantar pelanggan ke URL baru
echo '<br /><table cellspacing="1" class="SA_success_box"><tr><td><br />'.AFF_MA_CONTACTEMAILSENT.'<br /><br /></td></tr></table><br />';

}
}	  

// Jika ada masalah dengan borang, paparkan masalah
	  	  	  
if($errorMsg != ''){
echo '<br /><table cellspacing="1" class="SA_error_box"><tr><td>'.$errorMsg.'<br /></td></tr></table><br />';
}

// Semak Data Affiliate
$affiliatedata = mysql_query("SELECT * from affiliates where refid = '".$_SESSION['aff_valid_user']."'", $database_connection) or die ('Database Error');
if (mysql_num_rows($affiliatedata)) 
{
    while ($qry = mysql_fetch_array($affiliatedata))
    {
?> 
              
<br />
      <form name="borangpengesahan" method="post" action="pwjafflite_member_contact.php">
          <table bgcolor="#FFFFFF" width="500" cellspacing="1" class="SA_general_table" >
              <tr>
                  <td colspan="3" class="SA_general_table_header"><?=AFF_MA_CONTACTFORMTITLE?> - <?=$idaffiliate?></td>
              </tr>
              <tr>
                  <td colspan="3" class="SA_general_table_row1"><div align="justify"><br /><?=$arahan_contact?><br /><br /></div></td>
              </tr>
              <tr>
                  <td class="SA_general_table_row2" colspan="3">&nbsp;</td>
              </tr>
              <tr>
                  <td class="SA_general_table_row1"><div align="right"><?=AFF_MA_CONTACTFORMNAME?></div></td>
                  <td class="SA_general_table_row1"><div align="center">:</div></td>
                  <td class="SA_general_table_row1"><input name="namapengguna" type="text" size="30" maxlength="100" readonly="readonly" value="<?=$qry['firstname']?> <?=$qry['lastname']?>"><font color="#FF0000" />*</font></td>
              </tr>
              <tr>
                  <td class="SA_general_table_row2"><div align="right"><?=AFF_MA_CONTACTFORMEMAIL?></div></td>
                  <td class="SA_general_table_row2"><div align="center">:</div></td>
                  <td class="SA_general_table_row2"><input name="emailpengguna" type="text" size="30" maxlength="100" readonly="readonly" value="<?=$qry['email']?>" /><font color="#FF0000">*</font></td>
              </tr>
              <tr>
                  <td class="SA_general_table_row1"><div align="right"><?=AFF_MA_CONTACTFORMCONTENTTITLE?></div></td>
                  <td class="SA_general_table_row1"><div align="center">:</div></td>
                  <td class="SA_general_table_row1"><input name="tajuksoalan" type="text" size="30" maxlength="100" /><font color="#FF0000">*</font></td>
              </tr>
              <tr>
                  <td class="SA_general_table_row2"><div align="right"><?=AFF_MA_CONTACTFORMCONTENT?></div></td>
                  <td class="SA_general_table_row2"><div align="center">:</div></td>
                  <td class="SA_general_table_row2"><textarea name="kandungansoalan" cols="35" rows="10"></textarea><font color="#FF0000">*</font></td>
              </tr>
              <tr>
                  <td colspan="3" class="SA_general_table_row1">&nbsp;</td>
              </tr>
              <tr>
                  <td colspan="3" class="SA_general_table_row2"><div align="center"><input type="hidden" name="commited" value="yes"><input name="submit" type="submit" value="Hantar Borang">&nbsp;&nbsp;<input name="reset" type="reset" value="Isi Semula"></div></td>
              </tr>
          </table>
      </form>
<br />      
<?      
    }
}

?>
   </div>
</div>
</body>
</html>