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

$salesid = $_REQUEST['salesid'];

if (($_REQUEST['salesid']) && ($_REQUEST['validation'] == $_SESSION['aff_valid_admin']))
{
    // Dapatkan Data Sales Untuk Di UbahSuai
    $saletoedit = mysql_query("SELECT * FROM sales WHERE idsales = '$salesid' LIMIT 1", $database_connection) or die ('Database Connect Error');

    if (!mysql_num_rows($saletoedit))
    {
        print '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_S_TIADAJUALANID.'<br /><br /></td></tr></table><br />';
    }

    if (mysql_num_rows($saletoedit) > 0)
    {

        // Fungsi Update Rekod
        $titleErrorMsg = AFF_SI_TITLE;
        $errorMsg = '';

        if($_POST['commited'] == 'yes')
        {
            // check refid
            if($_POST['refid'] == ''){
            $errorMsg .= '<br />Please assign a referrer ID.<br />';
            }

            // check jumlah pembayaran
            if($_POST['jumlahpembayaran'] == ''){
            $errorMsg .= '<br />Please enter product name.<br />';
            }

            // Check Komisyen
            if($_POST['payment'] == ''){
            $errorMsg .= '<br />Please assign commission value.<br />';
            }

            // Check Status Pelanggan
            if($_POST['statuspelanggan'] == ''){
            $errorMsg .= '<br />Please assign sales status.<br />';
            }

            // Jika tiada masalah, update database admin
            if($errorMsg == '')
            {
                // Dapatkan ID agen yang terlibat
                while ($qryinfojualan = mysql_fetch_array($saletoedit))
                {
                    $idagen = $qryinfojualan['refid'];
                    $namajualan = $qryinfojualan['jumlahpembayaran'];
                    $komisyen = $qryinfojualan['payment'];
                    $pelanggannama = $qryinfojualan['namapelanggan'];
                    $pelangganemail = $qryinfojualan['emailpelanggan'];
                    $statusjualan = $qryinfojualan['statuspelanggan'];
                }

                // Dapatkan info agen
                $data_agen_asal = mysql_query("SELECT * FROM affiliates WHERE refid = '$idagen'", $database_connection) or die ('Database Connect Error');

                if(mysql_num_rows($data_agen_asal) > 0)
                {
                    while ($qryinfoagen = mysql_fetch_array($data_agen_asal))
                    {
                        $namaagen   = $qryinfoagen['firstname'];
                        $emailagen  = $qryinfoagen['email'];
                    }

// Hantar notifikasi komisyen telah diubah

$email_notifikasi_agen_asal = '

Salam sejahtera, '.$namaagen.'

Maklumat komisyen anda bagi promosi program affiliate di:

=> http://'.$domain.'/'.$folderaffiliates.'/

telah diubahsuai oleh admin.

===========================================================
Maklumat ASAL jualan affiliate anda adalah seperti berikut:
===========================================================

ID Jualan: '.$salesid.'
Nama Produk: '.$namajualan.'
ID Affiliate: '.$idagen.'

Nama Pelanggan: '.$pelanggannama.'
Email Pelanggan: '.$pelangganemail.'
Jumlah Komisyen: '.$komisyen.'

Status Jualan Sebelum Ini: '.$statusjualan.'


===========================================================
Maklumat BARU jualan affiliate telah diubah kepada:
===========================================================

ID Jualan: '.$salesid.'
Nama Produk: '.$_POST['jumlahpembayaran'].'
ID Affiliate: '.$_POST['refid'].'

Nama Pelanggan: '.$pelanggannama.'
Email Pelanggan: '.$pelangganemail.'
Jumlah Komisyen: '.$_POST['payment'].'

Status Jualan: '.$_POST['statuspelanggan'].'

===========================================================

Jika '.$namaagen.' mempunyai sebarang pertanyaan, silalah
berhubung dengan pihak admin.

Sekian, terima kasih.

Sistem Affiliate.
http://'.$domain.'/




';


        /********************************
        * Versi lama proses kiriman emel
        *********************************/
        // Proses Email Pengesahan Komisyen.
	// mail($emailagen, $namaagen.': '.AFF_S_PERTUKARANJUALAN, $email_notifikasi_agen_asal, 'From: '.$admininfo.'<'.$emailadminsupport.'>');

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

        $mail->Subject = $namaagen.': '.AFF_S_PERTUKARANJUALAN;

        $mail->Body    = $email_notifikasi_agen_asal; 				// Email body

        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->Send()) {
           echo 'Message could not be sent.';
           echo 'Mailer Error: ' . $mail->ErrorInfo;
           exit();
        }
            // Close Dapatkan Info Agen
            }

// Update Database Table Admin
mysql_query("UPDATE sales SET refid = '".$_POST['refid']."', jumlahpembayaran = '".$_POST['jumlahpembayaran']."', payment = '".$_POST['payment']."', statuspelanggan = '".$_POST['statuspelanggan']."' WHERE idsales = '$salesid'", $database_connection) or die ('Database Error');

echo '<br /><table cellspacing="1" class="SA_success_box"><tr><td><br />'.AFF_S_PERTUKARANREKODJUALAN.'<br /><br /></td></tr></table><br />';
        }

        // Jika Wujud masalah, paparkan puncanya
        if($errorMsg != '')
        {
            echo "<br /><table cellspacing=\"1\" class=\"SA_error_box\"><tr><td>$errorMsg<br /></td></tr></table><br />";
        }
//Close if($_POST['commited'] == 'yes')
    }
        print '<br /><form action="pwjafflite_sales_edit.php?salesid='.$salesid.'&validation='.$_SESSION['aff_valid_admin'].'" method="post" ENCTYPE="multipart/form-data"><table cellspacing="1" class="SA_details_table">';
        print '<tr><td class="SA_details_table_header">'.AFF_C_REFERRER.'</td>';
        print '<td class="SA_details_table_header">'.AFF_G_PRODUKJUALAN.'</td>';
        print '<td class="SA_details_table_header">'.AFF_G_KAEDAHPEMBAYARAN.'</td>';
        print '<td class="SA_details_table_header">'.AFF_G_DATE.'</td>';
        print '<td class="SA_details_table_header">'.AFF_G_TIME.'</td>';
        print '<td class="SA_details_table_header">'.AFF_G_EARNINGS.'</td>';
        print '<td class="SA_details_table_header">'.AFF_G_IPPELANGGAN.'</td>';
        print '<td class="SA_details_table_header">'.AFF_G_BROWSER.'</td>';
        print '<td class="SA_details_table_header">'.AFF_G_PELANGGAN.'</td>';
        print '<td class="SA_details_table_header">'.AFF_G_EMAILPELANGGAN.'</td>';
        print '<td class="SA_details_table_header">'.AFF_G_STATUSPELANGGAN.'</td>';
        print '<td class="SA_details_table_header">'.AFF_G_SAHKOMISYEN.'</td></tr>';

        while ($qry = mysql_fetch_array($saletoedit))
        {
            $refidselected = $qry['refid'];
            print '<tr><td class="SA_details_table_row1">';
            print '<select name="refid">';
            // Dapatkan Data Affiliate
            $resultrefidaffiliate = mysql_query("SELECT refid FROM affiliates ORDER BY refid", $database_connection) or die ('Database Error');
            if (mysql_num_rows($resultrefidaffiliate))
            {
                while ($qryrefid = mysql_fetch_array($resultrefidaffiliate))
                {
                    echo '<option value="'.$qryrefid['refid'].'" '.($qryrefid['refid'] == $refidselected ? 'selected' : '').'>'.$qryrefid['refid'].'</option>';
                }
            }
            print '</select>';
            print '</td><td class="SA_details_table_row2"><div align="center">';
            print '<input type="text" name="jumlahpembayaran" value="';
            print $qry['jumlahpembayaran'];
            print '" /></div></td>';
            print '<td class="SA_details_table_row1"><div align="center">';
            print '<input type="text" name="kaedahpembayaran" value="';
            print $qry['transaction_id'];
            print '" disabled="disabled" /></div></td>';
            print '<td class="SA_details_table_row2"><div align="center">';
            print $qry['date'];
            print '</div></td>';
            print '<td class="SA_details_table_row1"><div align="center">';
            print $qry['time'];
            print '</div></td>';
            print '<td class="SA_details_table_row2"><div align="center">';
            print '<input type="text" name="payment" value="';
            print $qry['payment'];
            print '" /></div></td>';
            print '<td class="SA_details_table_row1"><div align="center">';
            print $qry['ipaddress'];
            print '</div></td>';
            print '<td class="SA_details_table_row2"><div align="center">';
            print $qry['browser'];
            print '</div></td>';
            print '<td class="SA_details_table_row1"><div align="center">';
            print $qry['namapelanggan'];
            print '</div></td>';
            print '<td class="SA_details_table_row2"><div align="center">';
            print '<a href="pwjafflite_admin_client.php?idjualan='.$qry['idsales'].'" toptions="width = 550, height = 500, type = iframe, title = Sistem Affiliate Lite, layout = quicklook">';
            print $qry['emailpelanggan'];
            print '</a></div></td>';
            print '<td class="SA_details_table_row1"><div align="center">';
            print '<select name="statuspelanggan">';

            $statuspending  = AFF_AS_STATUSPENDING;
            $statusverified = AFF_AS_STATUSVERIFIED;
            $statuspaid     = AFF_AS_STATUSPAID;
            $statuscancel     = AFF_AS_STATUSCANCELLED;

            $status = array($statuspending, $statusverified, $statuspaid, $statuscancel);
            foreach($status as $key => $valuestatus){
            print '<option value="'.$valuestatus.'" '.($valuestatus == $qry['statuspelanggan'] ? 'selected' : '').'>'.$valuestatus.'</option>';
            }

            print '</select>';
            print '</div></td>';
            print '<td class="SA_details_table_row2"><center>[<a href="pwjafflite_sales_delete.php?delete='.$qry['idsales'].'&validation='.$_SESSION['aff_valid_admin'].' "onClick="return confirm(\''.AFF_P_DELETE.'\')"">Delete</a>]';
            print '<br /><div align="center"><input type="hidden" name="commited" value="yes"><input type="submit" name="Submit" value="Update"></div></center></td>';
            print '</tr>';
        }
        print '</table></form><br />';
    }

//Close Request Function
}

//Papar Informasi Jika Rekod Tidak Tepat
else echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_S_TIADAREKODJUALAN.'<br /><br /></td></tr></table><br />';

//Papar Footer
echo $footerdisplay;

?>
