<?php
################################################################################
#
# Nama Sistem: Sistem Affiliate (Lite)
# Penerbit: Amirol Zolkifli
# Web Asal: www.sistemaffiliate.com
# Versi: SA Lite 2.6.1
#
# Sistem ini telah dihasilkan, dioleh dan diterbitkan oleh Amirol Zolkifli.
# Anda tidak dibenarkan melakukan sebarang perubahan pada sistem tanpa
# mendapat kebenaran daripada pihak penerbit.
#
# Segala SOKONGAN TERHADAP SISTEM hanya diberikan JIKA anda membuat
# membuat PEMBELIAN SECARA TERUS dari www.sistemaffiliate.com. Sokongan
# hanya diberikan apabila anda dapat menyatakan RESIT PEMBELIAN terhadap
# sistem ini yang diterbitkan oleh pihak www.sistemaffiliate.com
#
# Pihak penerbit tidak akan bertanggungjawab atas segala kerosakan,
# kecacatan, permasalahan, kemalangan atau apa jua perkara buruk yang
# menimpa sebelum, semasa atau selepas pihak anda menggunakan sistem ini
# pada hosting, server dan laman web anda.
#
# Segala tindakan penggunaan sistem ini adalah 100% dibawah tanggungjawab
# anda sendiri.
#
################################################################################

// Dapatkan Fungsi Fail Yang Diperlukan
include 'pwjafflite_database.php';
ini_set('display_errors',0);
// Sambung ke Database
$database_connection = mysql_connect($server, $db_user, $db_pass);
if (!$database_connection)
{
    $output = 'Unable to connect to the database server.';
    echo $output;
    exit();
}
if (!mysql_select_db($database, $database_connection))
{
    $output = 'Unable to locate the affiliate database.';
    echo $output;
    exit();
}

// Dapat Konfigurasi Sistem Daripada Database Table Admin
$konfigurasi_sistem = mysql_query('SELECT * FROM admin LIMIT 1', $database_connection);

if (!$konfigurasi_sistem)
{
    $error = 'Error fetching data: ' . mysql_error($database_connection);
    echo $error;
    exit();
}

while ($qry = mysql_fetch_array($konfigurasi_sistem))
{
    // Nama Admin
    $admininfo = $qry['namaadmin'];

    // Email Admin
    $emailadmin = $qry['emailadmin'];

    // Alamat Email Bantuan Perniagaan Admin
    $emailadminsupport = $qry['emailadminsupport'];

    // Alamat Email Terima Tempahan Admin
    $emailadminpayment = $qry['emailadminpayment'];

    // Nama Produk atau Perniagaan Admin
    $namaproduk = $qry['namaproduk'];

    // Alamat Domain Perniagaan Admin
    $domain = $qry['domain'];

    // Nama Folder Sistem Affiliates
    $folderaffiliates = $qry['folderaffiliates'];

    // Nama Folder adminSistem Affiliates
    $folderadmin = $qry['folderadmin'];

    // Alamat URL Redirection Untuk Form Order
    $domainredirect = $qry['domainredirect'];

    // Landing Page Tracking Sistem Affiliate
    $landingpage = $qry['landingpage'];

    // cookie expiration in days. If 0, it is "unlimited" (JANGAN DIUBAH!!!! Biarkan saja)
    $cookieExpiration = $qry['cookieExpiration'];

    // Typekan '.domainanda.com' jika anda turut mau cookies disetkan di dalam subdomain anda.
    $cookieDomain = $qry['cookieDomain'];

    // Bilangan Paparan TOP Affiliates
    $cartatopaffiliate = $qry['cartatopaffiliate'];

    // Nilai Matawang Yang Ingin Digunakan
    $currency = $qry['currency'];

    // Bahasa Yang Ingin Digunakan
    $language = $qry['language'];

    // ID Affiliate KelabNiaga.com
    $idaffiliatePIS = $qry['idaffiliatePIS'];

    // Tahun Perniagaan Operasi
    $tahunoperasi = $qry['tahunoperasi'];

    // Benarkan Pendaftaran Affiliate
    $onoffregistration = $qry['onoffpendaftaran'];

    // Kod Unik Pendaftaran
    $kodpendaftaran = $qry['kodpendaftaran'];

    // Kod Unik Captcha
    $kodcaptchaborang = $qry['kodcaptchaborang'];

    // Affiliate Tracking
    $affiliate_tracking = $qry['affiliatetracking'];

    // Kredit Sistem Affiliate Lite
    $scriptcredit = $qry['scriptcredit'];

    // cookie path, should be always '/'   JANGAN DIUBAH!!!! Biarkan saja
    $cookiePath = '/';

    // Konfigurasi Cookies Sistem Affiliate (JANGAN USIK)
    $debugMessage = 'false';
}
	
// Versi Skrip Sistem Affiliate Lite
$pwjafflite_version = 'Version 2.6.1';

//-------------------------------------------------------------------------------
// Butiran Konfigurasi Sistem BORANG HUBUNGI di dalam Ruangan Ahli Affiliate
//-------------------------------------------------------------------------------

// Setting dibawah ini adalah untuk sistem contact DIDALAM sistem affiliate
// Padamkan fungsi menghantar email daripada domain anda sendiri?
// Proses ini akan mengurangkan masalah SPAM
$checkdomain = 'yes';

// Anda boleh memadamkan fungsi Powered By : yang telah ditetapkan pada ruangan contact.
// Kami menyarankan anda membiarkan sahaja kerana anda berpeluang menjana pendapatan menerusi program affiliate kami
// Untuk menjadi agen affiliate, daftar di http://www.usahaniaga.com/vipaffiliates
// Jika anda ingin padamkan fungsi Powered By ini, anda hanya perlu tetapkan "yes" atau "no" sahaja.
$showlink = 'no';


//-------------------------------------------------------------------------------
// JANGAN UBAH APA - APA PADA BUTIRAN DIBAWAH INI
// MELAINKAN ANDA TAHU APA YANG ANDA LAKUKAN
//-------------------------------------------------------------------------------

// Set default time zone setting.
$time_zone = 'Asia/Kuala_Lumpur';

if(function_exists('date_default_timezone_set'))
{
    date_default_timezone_set($time_zone);
}

$clientdate 	= date('Y-m-d'); // Jangan Usik
$clienttime 	= date('H:i:s'); // Jangan Usik
$clientbrowser 	= $_SERVER['HTTP_USER_AGENT']; // Jangan Usik
$clientip	= $_SERVER['REMOTE_ADDR']; // Jangan Usik
$clienturl 	= $_SERVER['HTTP_REFERER']; // Jangan Usik



// Fungsi Semakan Login Agen Sistem Affiliate
function aff_check_security()
{
    if( !isset($_SESSION['aff_valid_user']) || $_SESSION['aff_valid_user'] == '' )
    {
        return false;
    }
    
    else
    {
        return true;
    }
}

// Fungsi Semakan Login Admin Sistem Affiliate
function aff_admin_check_security()
{
    if( !isset($_SESSION['aff_valid_admin']) || $_SESSION['aff_valid_admin'] == '' )
    {
        return false;
    }
    
    else
    {
        return true;
    }
}

// Fungsi Redirect
function aff_redirect($url, $time = 0)
{
    echo '<META HTTP-EQUIV="Refresh" CONTENT="'.$time.'; URL='.$url.'">';
    echo 'Jika anda tidak dibawa ke halaman baru, klik <a href="'.$url.'">di sini</a>.';
}

// Display Affiliate Version
if( $_GET['system'] == 'version' )
{
    print '<div align="center"><p>&nbsp</p><p>SAL Version: '.$pwjafflite_version.'</p>';
}

// Fungsi Paparan Footer
if( $scriptcredit != 1 )
{
    $poweredby = 'Affiliate Script Powered By &copy; <a href="http://www.sistemaffiliate.com/?aff_id='.$idaffiliatePIS.'" title="Sistem Affiliate Lite" target="_blank">Sistem Affiliate Lite</a>.';
}

$footerdisplay = '
</div>
<div id="SA_footer">Affiliate Programme By <a href="http://'.$domain.'" title="'.$namaproduk.'">'.$namaproduk.'</a> '.$tahunoperasi.'. '.$poweredby.'</div>   
</div>
</body>
</html>';
	
?>