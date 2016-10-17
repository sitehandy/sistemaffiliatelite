<?php

// Penetapan fungsi session untuk sistem captcha
session_start();

// Intergrasi sistem borang dengan sistem affiliate
include 'pwjafflite_config.php';
include $folderaffiliates.'/lang/'.$language;

// Dapatkan maklumat yang dikirimkan pada borang tempahan
$namapembeli        = 'Tiada';
$emailpembeli       = 'Tiada';
$jumlahpembayaran   = 'Nama Autoresponder';
$kaedahpembayaran   = 'PPL';
$komisyenaffiliate  = '1.00';
$URLdomainredirect  = 'http://www.sistemaffiliate.com';

/* Tetapkan konfigurasi DUPLIKASI Komisyen berdasarkan IP Address
 *
 * Letakkan nilai 1 JIKA anda ingin membenarkan data IP Address boleh didaftarkan
 * berulang kali ke dalam database.
 *
 * Letakkan nila 0 JIKA anda tidak mahu komisyen diberikan kepada agen affiliate
 * jika sudah terdapat data daripada IP Address pelanggan yang sama.
 *
 *  */

$duplikasikomisyen = 1;

// Semak cookies agen affiliate

$ref = $_COOKIE['ref'];

if ($ref == '')
{
    //Semak dengan session dulu
    $ref = $_SESSION['ref'];
    if ($_SESSION['ref'] == '')
    {
        $resultref = mysql_query("SELECT refid FROM clickthroughs WHERE ipaddress = '$clientip' ORDER BY date, time desc LIMIT 1", $database_connection) or die ('Database Connection Error');
        if (mysql_num_rows($resultref))
        {
            while ($qryidref = mysql_fetch_array($resultref))
            $ref = $qryidref['refid'];
        }
    }
}

if ($ref != '')
{
    if ($duplikasikomisyen != 0)
    {
        // Status pelanggan untuk pengesahan komisyen
        $statuspelanggan = AFF_AS_STATUSPENDING;
            
        // Data rekod pembelian dan komisyen ke dalam database sistem affiliate
        mysql_query("INSERT INTO sales (idsales, refid, jumlahpembayaran, kaedahpembayaran, date, time, browser, ipaddress, payment, namapelanggan, emailpelanggan, statuspelanggan) VALUES ('', '$ref', '$jumlahpembayaran', '$kaedahpembayaran', '$clientdate', '$clienttime', '$clientbrowser', '$clientip', '$komisyenaffiliate', '$namapembeli', '$emailpembeli', '$statuspelanggan')", $database_connection) or die ('Database Insert Error');
    }
    else
    {
        //Semak rekod sama ada pernah didaftarkan ke dalam sistem affiliate atau tidak
        $result = mysql_query("SELECT * FROM sales WHERE ipaddress = '$clientip'", $database_connection) or die ('Database Connection Error');

        // Jika masih belum mendaftar, maka proses pendaftaran
        if (!mysql_num_rows($result))
        {
            // Status pelanggan untuk pengesahan komisyen
            $statuspelanggan = AFF_AS_STATUSPENDING;

            // Data rekod pembelian dan komisyen ke dalam database sistem affiliate
            mysql_query("INSERT INTO sales (idsales, refid, jumlahpembayaran, kaedahpembayaran, date, time, browser, ipaddress, payment, namapelanggan, emailpelanggan, statuspelanggan) VALUES ('', '$ref', '$jumlahpembayaran', '$kaedahpembayaran', '$clientdate', '$clienttime', '$clientbrowser', '$clientip', '$komisyenaffiliate', '$namapembeli', '$emailpembeli', '$statuspelanggan')", $database_connection) or die ('Database Insert Error');
        }
    }


// Close Komisyen Generate
}

// Setelah selesai proses diatas, hantar pelanggan ke URL baru
header('Location: '.$URLdomainredirect.'');
exit();

?>