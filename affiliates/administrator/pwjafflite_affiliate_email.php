<?php

session_start();
include '../../pwjafflite_config.php';
include '../lang/'.$language;

if(!aff_admin_check_security())
{
    aff_redirect('index.php');
    exit();
}

// Intergrasi konfigurasi sistem borang
  
// Dapatkan data dari borang  
$idaffiliate        = $_GET['agen'];
$namapengguna       = $_POST['namapengguna'];
$emailpengguna      = $_POST['emailpengguna'];
$namapelanggan      = $_POST['namapelanggan'];
$emailpelanggan     = $_POST['emailpelanggan'];
$statuspelanggan    = $_POST['statuspelanggan'];
$tajuksoalan        = $_POST['tajuksoalan'];
$kandungansoalan    = $_POST['kandungansoalan'];
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? print $namaproduk; ?> - Affiliate Contact Form</title>
<link href="../pwjafflite_temp/pwjafflite_styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="container">
    <div id="SA_content_area"> 
<?

$affiliatedata = mysql_query("SELECT * FROM affiliates where refid = '$idaffiliate'", $database_connection) or die ("Database Connection Error");

if (mysql_num_rows($affiliatedata))
{
    while ($qryclient = mysql_fetch_array($affiliatedata))
    {	
	$clientname = $qryclient['firstname']." ".$qryclient['lastname'];
	$clientemail = $qryclient['email'];
	$clientstatus = $qryclient['phone'];
    }
}

// Jika wujud masalah sewaktu menghantar borang
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

    if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $emailpengguna)){
    $errorMsg .= '<br />'.AFF_MA_CONTACTEMAILMISSINGVALID.'<br />';
    }

    if($tajuksoalan == ''){
    $errorMsg .= '<br />'.AFF_MA_CONTACTTITLEMISSING.'<br />';
    }
	  
    if($kandungansoalan == ''){
    $errorMsg .= '<br />'.AFF_MA_CONTACTCONTENTMISSING.'<br />';
    }

    // Jika tiada masalah dengan borang, sistem hantar notifikasi

    if($errorMsg == ''){

$emailbalaspengguna = "

Salam sejahtera admin, $namapengguna

Anda telah mengirimkan pesanan kepada agen affiliate
anda di 

=> http://$domain/$folderaffiliates.

Berikut adalah salinan pesanan yang telah anda kirimkan.

===========================================================
Salinan Pesanan Email
===========================================================

=> Nama Anda: $namapengguna
=> Email Anda: $emailpengguna

=> Nama Agen Anda: $namapelanggan
=> Email Agen Anda: $emailpelanggan
=> Tel Agen Anda: $statuspelanggan

=> Tajuk Pesanan Anda: $tajuksoalan
=> Kandungan Anda: 

$kandungansoalan

===========================================================

Segala email maklum balas daripada agen anda selepas ini
boleh dijalankan secara terus daripada penyedia email anda
tanpa perlu menggunakan sistem borang daripada sistem affiliate.

Sekian, terima kasih.

Sistem Affiliate Lite
http://$domain


























===========================================================
Affiliate Script Powered By:
[+] http://www.SistemAffiliate.com/?aff_id=$idaffiliatePIS
===========================================================
";


// Hantar email balas di atas kepada pelanggan

mail("$emailpengguna", "Re: ".AFF_MA_CONTACTCLIENTREPLYEMAIL."","$emailbalaspengguna","From: $admininfo<$emailadminsupport>");



// Seterusnya hantar email borang pengesahan kepada admin


$emailkepadapelanggan = "

Salam sejahtera $namapelanggan.

Email ini dikirimkan adalah kerana $namapelanggan adalah
merupakan salah seorang agen affiliate kami bagi produk:

=> $namaproduk 

Berikut adalah butiran pesanan yang pihak pengurusan ingin
sampaikan:

===========================================================
Butiran Pesanan Daripada Admin, $namapengguna
===========================================================

=> Nama Anda: $namapelanggan
=> Email Anda: $emailpelanggan
=> Tel Anda: $statuspelanggan

=> Tajuk Pesanan: $tajuksoalan
=> Kandungan Penaja: 

$kandungansoalan





===========================================================
Maklumat akaun affiliate anda
===========================================================

=> ID Affiliate Anda: $idaffiliate

=> URL Login Ahli:
http://$domain/$folderaffiliates

=> URL Promosi Anda: 
http://$domain/hop.php?ref=$idaffiliate


===========================================================

Sebarang pemasalahan atau pertanyaan berkenaan dengan pesanan
ini, sila hubungi kami menerusi $emailadminsupport.


Sekian, terima kasih.

Ikhlas,
$admininfo
http://$domain

























===========================================================
Affiliate Script Powered By:
[+] http://www.SistemAffiliate.com/?aff_id=$idaffiliatePIS
===========================================================
";


// Hantar email borang pengesahan kepada admin
mail("$emailpelanggan", "$namapelanggan: $tajuksoalan","$emailkepadapelanggan","From: $namapengguna<$emailpengguna>");

// Setelah selesai proses diatas, hantar pelanggan ke URL baru
echo "<table cellspacing=\"1\" class=\"SA_success_box\"><tr><td><br />".AFF_MA_CONTACTEMAILSENT."<br /><br /></td></tr></table><br />";

}

// Tutup Post
}	  

// Jika ada masalah dengan borang, paparkan masalah
	  	  	  
if($errorMsg != '')
{
    echo "<table cellspacing=\"1\" class=\"SA_error_box\"><tr><td>$errorMsg<br /></td></tr></table><br />";
}

?> 

<form name="borangpengesahan" method="post" action="pwjafflite_affiliate_email.php?agen=<?=$idaffiliate?>">
    <table bgcolor="#FFFFFF" width="500" cellspacing="1" class="SA_general_table" >
        <tr>
            <td colspan="3" class="SA_general_table_header"><?=AFF_AA_CONTACTAFFILIATETITLE?></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row1"><br /><?=$arahan_contact_affiliate_admin?><br /><br /></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><div align="right"><?=AFF_MA_CONTACTFORMNAME?></div></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1"><input name="namapengguna" type="text" size="30" maxlength="100" readonly="readonly" value="<?=$admininfo?>" /><font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td class="SA_general_table_row2"><div align="right"><?=AFF_MA_CONTACTFORMEMAIL?></div></td>
            <td class="SA_general_table_row2"><div align="center">:</div></td>
            <td class="SA_general_table_row2"><input name="emailpengguna" type="text" size="30" maxlength="100" readonly="readonly" value="<?=$emailadminsupport?>" /><font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><div align="right"><?=AFF_AA_CONTACTAFFILIATENAME?></div></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1"><input name="namapelanggan" type="text" size="30" maxlength="100" readonly="readonly" value="<?=$clientname?>" /><font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td class="SA_general_table_row2"><div align="right"><?=AFF_AA_CONTACTAFFILIATEEMAIL?></div></td>
            <td class="SA_general_table_row2"><div align="center">:</div></td>
            <td class="SA_general_table_row2"><input name="emailpelanggan" type="text" size="30" maxlength="100" readonly="readonly" value="<?=$clientemail?>" /><font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><div align="right"><?=AFF_AA_CONTACTAFFILIATEPHONE?></div></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1"><input name="statuspelanggan" type="text" size="30" maxlength="100" readonly="readonly" value="<?=$clientstatus?>" /><font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td class="SA_general_table_row2"><div align="right"><?=AFF_MA_CONTACTFORMCONTENTTITLE?></div></td>
            <td class="SA_general_table_row2"><div align="center">:</div></td>
            <td class="SA_general_table_row2"><input name="tajuksoalan" type="text" size="30" maxlength="100" /><font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><div align="right"><?=AFF_MA_CONTACTFORMCONTENT?></div></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1"><textarea name="kandungansoalan" cols="30" rows="7"></textarea><font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row2">
                <div align="center">
                    <input type="hidden" name="commited" value="yes" />
                    <input name="submit" type="submit" value="Hantar Borang" />&nbsp;&nbsp;
                    <input name="reset" type="reset" value="Isi Semula" />
                </div>
            </td>
        </tr>
    </table>
</form>
    </div>
</div>
</body>
</html>