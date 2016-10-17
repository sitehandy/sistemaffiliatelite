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
if ($_REQUEST['pembeli'] != '')
{
    // Konfigurasi untuk dapatkan data agen affiliate yang terlibat daripada Sales
    $result = mysql_query("SELECT * from sales WHERE idsales='".$_REQUEST['pembeli']."'", $database_connection) or die ('Database CONNECT Error');
    
    if (mysql_num_rows($result))
        {
            while ($qry = mysql_fetch_array($result))
            {
                $agenaffiliate  = $qry['refid'];
		$produkterjual  = $qry['jumlahpembayaran'];
		$namapelanggan  = $qry['namapelanggan'];
		$emailpelanggan = $qry['emailpelanggan'];
		$komisyenagen   = $qry['payment'];
		$statuskomisyen = $qry['statuspelanggan'];
            }
        }

    // Dapatkan data agen affiliate daripada table affiliates
    $resultagen = mysql_query("SELECT * FROM affiliates WHERE refid='".$agenaffiliate."'", $database_connection) or die ('Database CONNECT Error');

    if (mysql_num_rows($resultagen))
    {
        while ($qryagen = mysql_fetch_array($resultagen))
	{
            // Tetapkan VARIABLE Agen affiliate
            $idagen         = $agenaffiliate;
            $passwordagen   = $qryagen['pass'];
            $namaagen       = $qryagen['firstname'].' '.$qryagen['lastname'];
            $emailagen      = $qryagen['email'];

            // Hantar Email Notifikasi Kepada Agen
	}
    }

    // Dapatkan Kandungan Email Dari Database
    $resultemail = mysql_query('SELECT * FROM emailadmin', $database_connection) or die ('Database Error');

    if (mysql_num_rows($resultemail))
    {
        while ($qryemail = mysql_fetch_array($resultemail))
	{
            $email_pengesahan_komisyen = $qryemail['emailsahkomisyen'];
            
            // Kesan Tag dan Data
            $emailtag = array('%%namaagen%%', '%%namaproduk%%', '%%loginaffiliate%%', '%%idagen%%', '%%passwordagen%%', '%%linkaffiliate%%', '%%namaadmin%%', '%%emailsupport%%', '%%domain%%', '%%jualan%%', '%%komisyenagen%%', '%%namapelanggan%%', '%%emailpelanggan%%');
            $emailtagreplace = array($namaagen, $namaproduk, 'http://'.$domain.'/'.$folderaffiliates.'/', $agenaffiliate, $passwordagen, 'http://'.$domain.'/hop.php?ref='.$agenaffiliate.'', $admininfo, $emailadminsupport, $domain, $produkterjual, $komisyenagen, $namapelanggan, $emailpelanggan, ENT_QUOTES, 'UTF-8');
            
            // Convert Tag Kepada Data Dalam Email
            $email_send = str_replace($emailtag, $emailtagreplace, $email_pengesahan_komisyen);	
	}
    }

    // Proses Komisyen Atau Tidak
    if ($statuskomisyen ==	AFF_AS_STATUSPENDING)
    {
        // Update STATUS Pembeli kepada verified
	mysql_query("UPDATE sales SET statuspelanggan = '".AFF_AS_STATUSVERIFIED."' WHERE idsales='".$_REQUEST['pembeli']."' LIMIT 1", $database_connection) or die ('Database CONNECT Error');
        
        /********************************
        * Versi lama proses kiriman emel
        *********************************/
        // Proses Email Pengesahan Komisyen.
	// mail($emailagen, $namaagen.' '.AFF_AS_EMAILKOMISYEN, $email_send, 'From: '.$admininfo.'<'.$emailadminsupport.'>');

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

        $mail->Subject = $namaagen.', '.AFF_AS_EMAILKOMISYEN;

        $mail->Body    = $email_send; 				// Email body

        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->Send()) {
           echo 'Message could not be sent.';
           echo 'Mailer Error: ' . $mail->ErrorInfo;
           exit();
        }
        	

	// Papar Notifikasi Telah Dikirim Kepada Agen Terlibat
	print '<br /><table width="600" cellspacing="1" class="SA_general_table">';
        print '<tr><td colspan="3" class="SA_general_table_header">'.AFF_AS_TAJUKSAHPEMBELIAN.'</td></tr>';
        print '<tr><td colspan="3" class="SA_general_table_row1"><br />'.AFF_AS_KANDUNGANSAHPEMBELIAN.'<br /><br /></td></tr>';
        print '<tr><td class="SA_general_table_row2">'.AFF_AS_IDAGEN.'</td>';
        print '<td class="SA_general_table_row2"><div align="center">:</div></td>';
        print '<td class="SA_general_table_row2"><div align="left">'.$agenaffiliate.'</div></td></tr>';
        print '<tr><td class="SA_general_table_row1">'.AFF_AS_NAMAAGEN.'</td>';
        print '<td class="SA_general_table_row1"><div align="center">:</div></td>';
        print '<td class="SA_general_table_row1"><div align="left">'.$namaagen.'</div></td></tr>';
        print '<tr><td class="SA_general_table_row2">'.AFF_AS_EMAILAGEN.'</td>';
        print '<td class="SA_general_table_row2"><div align="center">:</div></td>';
        print '<td class="SA_general_table_row2"><div align="left">'.$emailagen.'</div></td></tr>';
        print '<tr><td class="SA_general_table_row1">'.AFF_AS_NAMAPELANGGAN.'</td>';
        print '<td class="SA_general_table_row1"><div align="center">:</div></td>';
        print '<td class="SA_general_table_row1"><div align="left">'.$namapelanggan.'</div></td></tr>';
        print '<tr><td class="SA_general_table_row2">'.AFF_AS_EMAILPELANGGAN.'</td>';
        print '<td class="SA_general_table_row2"><div align="center">:</div></td>';
        print '<td class="SA_general_table_row2"><div align="left">'.$emailpelanggan.'</div></td></tr>';
        print '<tr><td colspan="3" class="SA_general_table_row1">&nbsp;</td></tr>';
        print '<tr><td colspan="3" class="SA_general_table_row2"><center>[ <a href="pwjafflite_admin_sales.php">'.AFF_AS_KEMBALI.'</a> ]</center></td></tr>';
        print '</table><br />';
    }
	
    if ($statuskomisyen == AFF_AS_STATUSVERIFIED)
    {
        echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_AS_ALREADYVERIFIED.'<br /><br /></td></tr></table><br />';
    }

    if ($statuskomisyen == AFF_AS_STATUSPAID)
    {
	echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_AS_ALREADYPAID.'<br /><br /></td></tr></table><br />';
    }

// Tutup REQUEST Pembeli
}

else echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_AS_NOITEM.'<br /><br /></td></tr></table><br />';

//Papar Footer
echo $footerdisplay;

?>