<?php

// Penetapan fungsi session untuk sistem captcha
session_start();

// Jangan ubah apa - apa pada bahagian ini
include 'pwjafflite_config.php';
include $folderaffiliates.'/lang/'.$language;

//Set Data DEFAULT yang ingin ditampilkan pada rekod jualan

//Nama pembeli DEFAULT. Abaikan variable ini melainkan anda tahu programming
$namapembeli = 'Tiada';

//Email pembeli DEFAULT. Abaikan variable ini melainkan anda tahu programming
$emailpembeli = 'Tiada';

//Masukkan URL Redirect untuk pelanggan layari selepas pembayaran dibuat.
$domainredirect_custom = 'http://www.sistemaffiliate.com';

//Nama ITEM DAN Harga Item
$jumlahpembayaran = 'Ebook A - RM2.00';

//Nama Kaedah Transaksi
$kaedahpembayaran = 'PayPal';

//Komisyen Untuk Agen Affiliate
$komisyenaffiliate = '1.00';

//Jangan usik apa - apa code dibawah ini

// PHPLOCKITOPT START
//Semak cookies ID agen affiliate

$ref = preg_replace('/[^a-zA-Z0-9-]/', '', $_COOKIE['ref'] );

if ($ref == '')
{
    //Semak dengan session dulu
    $ref = $_SESSION['ref'];

    if ($_SESSION["ref"] == '')
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
    // Status pelanggan untuk pengesahan komisyen
    $statuspelanggan = AFF_AS_STATUSPENDING;
    mysql_query("INSERT INTO sales (idsales, refid, jumlahpembayaran, kaedahpembayaran, date, time, browser, ipaddress, payment, namapelanggan, emailpelanggan, statuspelanggan) VALUES ('', '$ref', '$jumlahpembayaran', '$kaedahpembayaran', '$clientdate', '$clienttime', '$clientbrowser', '$clientip', '$komisyenaffiliate', '$namapembeli', '$emailpembeli', '$statuspelanggan')", $database_connection) or die ('Database Connection Error');
}


// Setelah selesai proses diatas, hantar pelanggan ke URL baru
header('Location: '.$domainredirect_custom.'');

?>