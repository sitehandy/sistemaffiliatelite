<?php

// Penetapan fungsi session untuk sistem captcha
session_start();

// Intergrasi sistem borang dengan sistem affiliate
include 'pwjafflite_config.php';
include $folderaffiliates.'/lang/'.$language;

// Dapatkan maklumat yang dikirimkan pada borang tempahan
// $namapembeli        = $_REQUEST['name'];
// $emailpembeli       = $_REQUEST['email'];
$jumlahpembayaran   = 'GetResponse.com';
$kaedahpembayaran   = 'PPL';
$komisyenaffiliate  = '3.00';

if (isset($_COOKIE['ref']))
{
    $ref = $_COOKIE['ref'];
}
elseif (isset($_SESSION['ref']))
{
    $ref = $_SESSION['ref'];
}
else
{
    // Try to get username from click record if any
    $resultref = mysql_query("SELECT refid FROM clickthroughs WHERE ipaddress = '$clientip' ORDER BY date, time desc LIMIT 1", $database_connection) or die ('Database Connection Error');

    if (mysql_num_rows($resultref) > 0)
    {
        while ($qryidref = mysql_fetch_array($resultref))
        {
            $ref = $qryidref['refid'];
        }
    }
    else
    {
        $ref = null;
    }
}

if (!is_null($ref))
{
    //Semak rekod sama ada pernah didaftarkan ke dalam sistem affiliate atau tidak
    $result = mysql_query("SELECT * FROM sales WHERE refid = '$ref' AND kaedahpembayaran = 'PPL' AND statuspelanggan = 'PENDING' AND ipaddress = '$clientip' ORDER BY date, time desc", $database_connection) or die ('Database Connection Error');

    // Jika masih belum mendaftar, maka proses pendaftaran
    if (mysql_num_rows($result) > 0)
    {
        // Status pelanggan untuk pengesahan komisyen
        $statuspelanggan = AFF_AS_STATUSVERIFIED;

        // Data rekod pembelian dan komisyen ke dalam database sistem affiliate
        mysql_query("UPDATE sales SET statuspelanggan = '$statuspelanggan' WHERE refid = '$ref' AND kaedahpembayaran = 'PPL' AND ipaddress = '$clientip' AND statuspelanggan = 'PENDING'", $database_connection) or die ('Database Update Error');
    }
    else {
        header('Location: '.$domainredirect);
        exit();
    }
}

// Setelah selesai proses diatas, hantar pelanggan ke URL baru
header('Location: '.$domainredirect);
//echo 'test';
exit();

?>
