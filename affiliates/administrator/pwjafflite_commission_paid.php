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

// Konfigurasi untuk mengesahkan STATUS pembelian yang dibuat oleh pelanggan

if ($_REQUEST['agen'] != '')
{

// Konfigurasi untuk dapatkan data agen affiliate yang terlibat daripada Sales
$result = mysql_query("SELECT SUM(payment) AS total from sales WHERE refid = '".$_REQUEST['agen']."' and statuspelanggan = '".AFF_AS_STATUSVERIFIED."'", $database_connection) or die ('Database CONNECT Error');
		
if (mysql_num_rows($result))
{
    while ($qry = mysql_fetch_array($result))
    {
        $jumlahkomisyenagen = $qry['total'];
    }
}
 
// Dapatkan data agen affiliate daripada table affiliates
$resultagen = mysql_query("SELECT * from affiliates WHERE refid='".$_REQUEST['agen']."' ", $database_connection) or die ('Database CONNECT Error');

if (mysql_num_rows($resultagen))
{
    while ($qryagen = mysql_fetch_array($resultagen))
    {
	// Tetapkan VARIABLE Agen affiliate
	$idagen         = $_REQUEST['agen'];
	$passwordagen   = $qryagen['pass'];
	$namaagen       = $qryagen['firstname'].' '.$qryagen['lastname'];
	$emailagen      = $qryagen['email'];
	$processor      = $qryagen['processor'];
	$noaccount      = $qryagen['account'];
	$payto          = $qryagen['payto'];
	$tarikhbayaran  = date("Y-m-d");
    }
}

// Dapatkan Kandungan Email Dari Database
$resultemail = mysql_query('SELECT * FROM emailadmin', $database_connection) or die ('Database Error');

if (mysql_num_rows($resultemail))
{
    while ($qryemail = mysql_fetch_array($resultemail))
    {
        $email_bayar_komisyen = $qryemail['emailbayarkomisyen'];

        // Kesan Tag dan Data
	$emailtag = array('%%namaagen%%', '%%namaproduk%%', '%%loginaffiliate%%', '%%idagen%%', '%%passwordagen%%', '%%pemprosesanbayaran%%', '%%akaunbayaran%%', '%%pemilikakaun%%', '%%tarikhbayaran%%', '%%linkaffiliate%%', '%%namaadmin%%', '%%emailsupport%%', '%%domain%%', '%%jumlahkomisyenagen%%', '%%currency%%');			
        $emailtagreplace = array($namaagen, $namaproduk, 'http://'.$domain.'/'.$folderaffiliates.'/', $idagen, $passwordagen, $processor, $noaccount, $payto, $tarikhbayaran, 'http://'.$domain.'/hop.php?ref='.$idagen.'', $admininfo, $emailadminsupport, $domain, $jumlahkomisyenagen, $currency, ENT_QUOTES, 'UTF-8');
		
        // Convert Tag Kepada Data Dalam Email
	$email_send = str_replace($emailtag, $emailtagreplace, $email_bayar_komisyen);	   		
    }
}


if ($jumlahkomisyenagen != '')
{
    // Update STATUS Pembeli kepada verified
    mysql_query("UPDATE sales SET statuspelanggan = '".AFF_AS_STATUSPAID."' WHERE refid = '".$_REQUEST['agen']."' and statuspelanggan = '".AFF_AS_STATUSVERIFIED."' ", $database_connection) or die ('Database CONNECT Error');
    
    
    /********************************
        * Versi lama proses kiriman emel
        *********************************/
        // Proses Email Pengesahan Komisyen.
        // mail($emailagen, $namaagen.' '.AFF_AA_COMMISSIONPAID, $email_send, 'From: '.$admininfo.'<'.$emailadminsupport.'>');

        /********************************
        * Versi baru proses kiriman emel (Updated July 2013)
        * Penggunaan PHPMailer: https://github.com/Synchro/PHPMailer
        *********************************/

        $mail = new PHPMailer;

        $mail->IsMail();									// Set mailer to use PHP Mail

        $mail->From = $emailadminsupport;
        $mail->FromName = $admininfo;
        $mail->AddAddress($emailagen, $namaagen);		// Add a recipient
        $mail->AddReplyTo($emailadminsupport);

        $mail->IsHTML(false);								// Set email format to plain text

        $mail->Subject = $namaagen.', '.AFF_AA_COMMISSIONPAID;

        $mail->Body    = $email_send; 				// Email body

        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->Send()) {
           echo 'Message could not be sent.';
           echo 'Mailer Error: ' . $mail->ErrorInfo;
           exit();
        }
	
    // Papar Notifikasi Telah Dikirim Kepada Agen Terlibat
    print '<br /><table width="600" cellspacing="1" class="SA_general_table">';
    print '<tr><td colspan="3" class="SA_general_table_header">'.AFF_AA_COMMISSIONPAIDTITLE.'</td></tr>';
    print '<tr><td colspan="3" class="SA_general_table_row1"><br />'.AFF_AA_COMMISSIONPAIDSTATUS.'<br /><br /></td></tr>';
    print '<tr><td class="SA_general_table_row2">'.AFF_AS_IDAGEN.'</td>';
    print '<td class="SA_general_table_row2"><div align="center">:</div></td>';
    print '<td class="SA_general_table_row2"><div align="left">'.$idagen.'</div></td></tr>';
    print '<tr><td class="SA_general_table_row1">'.AFF_AS_NAMAAGEN.'</td>';
    print '<td class="SA_general_table_row1"><div align="center">:</div></td>';
    print '<td class="SA_general_table_row1"><div align="left">'.$namaagen.'</div></td></tr>';
    print '<tr><td class="SA_general_table_row2">'.AFF_AS_EMAILAGEN.'</td>';
    print '<td class="SA_general_table_row2"><div align="center">:</div></td>';
    print '<td class="SA_general_table_row2"><div align="left">'.$emailagen.'</div></td></tr>';
    print '<tr><td class="SA_general_table_row1">'.AFF_AA_PAYMENTPROCESSOR.'</td>';
    print '<td class="SA_general_table_row1"><div align="center">:</div></td>';
    print '<td class="SA_general_table_row1"><div align="left">'.$processor.'</div></td></tr>';
    print '<tr><td class="SA_general_table_row2">'.AFF_AA_PAYMENTACCOUNT.'</td>';
    print '<td class="SA_general_table_row2"><div align="center">:</div></td>';
    print '<td class="SA_general_table_row2"><div align="left">'.$noaccount.'</div></td></tr>';
    print '<tr><td class="SA_general_table_row1">'.AFF_AA_PAYMENTACCOUNTHOLDER.'</td>';
    print '<td class="SA_general_table_row1"><div align="center">:</div></td>';
    print '<td class="SA_general_table_row1"><div align="left">'.$payto.'</div></td></tr>';
    print '<tr><td class="SA_general_table_row2">'.AFF_AA_TOTALCOMMISSION.'</td>';
    print '<td class="SA_general_table_row2"><div align="center">:</div></td>';
    print '<td class="SA_general_table_row2"><div align="left">'.$jumlahkomisyenagen.'</div></td></tr>';
    print '<tr><td class="SA_general_table_row1">'.AFF_AA_COMMISSIONPAIDDATE.'</td>';
    print '<td class="SA_general_table_row1"><div align="center">:</div></td>';
    print '<td class="SA_general_table_row1"><div align="left">'.$tarikhbayaran.'</div></td></tr>';
    print '<tr><td colspan="3" class="SA_general_table_row1"><center>[ <a href="pwjafflite_admin_pay.php">'.AFF_AA_KEMBALIBAYARKOMISYEN.'</a> ]</center></td></tr>';
    print '</table><br />';

}

else echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_AS_NOVERIFIEDCOMMISSION.'<br /><br /></td></tr></table><br />';

}

else echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_AS_NOITEM.'<br /><br /></td></tr></table><br />';

//Papar Footer
echo $footerdisplay;  
?>