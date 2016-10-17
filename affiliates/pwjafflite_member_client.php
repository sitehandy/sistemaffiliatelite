<?php

session_start();

include '../pwjafflite_config.php';
include './lang/'.$language;

if(!aff_check_security())
{
    aff_redirect('index.php');
    exit();
}

// Intergrasi konfigurasi sistem borang
  
// Dapatkan data dari borang  
$idsales            = $_GET['idjualan'];
$idaffiliate        = $_SESSION['aff_valid_user'];
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
<title><? print $namaproduk; ?> - Client Contact Form</title>
<link href="./pwjafflite_temp/pwjafflite_styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
    <div id="SA_content_area"> 
<?

// Dapatkan Data Pelanggan
$clientdata = mysql_query("SELECT * from sales where idsales = '$idsales'", $database_connection) or die ("Database Connection Error");
if (mysql_num_rows($clientdata))
{
    while ($qryclient = mysql_fetch_array($clientdata))
    {
	$clientname     = $qryclient['namapelanggan'];
	$clientemail    = $qryclient['emailpelanggan'];
	$clientstatus   = $qryclient['statuspelanggan'];
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

if($errorMsg == '')
{

// Hantar email kepada affiliate
$emailsalinanaffiliate = "

Salam sejahtera, $namapengguna

Anda telah mengirimkan pesanan kepada pelanggan
affiliate anda di
    
=> http://$domain/$folderaffiliates.

Berikut adalah salinan pesanan yang telah anda kirimkan.

===========================================================
Salinan Pesanan Email
===========================================================

=> Nama Anda: $namapengguna
=> Email Anda: $emailpengguna

=> Nama Pelanggan Anda: $namapelanggan
=> Email Pelanggan Anda: $emailpelanggan
=> Status Pelanggan Anda: $statuspelanggan

=> Tajuk Pesanan Anda: $tajuksoalan
=> Kandungan Anda: 

$kandungansoalan

===========================================================

Segala email maklum balas daripada pelanggan anda selepas ini
boleh dijalankan secara terus daripada penyedia email anda
tanpa perlu menggunakan sistem borang daripada sistem affiliate.

Jika ada sebarang masalah dengan borang ini, sila hubungi kami
di $emailadminsupport.

Sekian, terima kasih.

Ikhlas

$admininfo
http://$domain


























===========================================================
Affiliate Script Powered By:
[+] http://www.SistemAffiliate.com/?aff_id=$idaffiliatePIS
===========================================================
";

// Hantar email balas di atas kepada affiliates
mail("$emailpengguna", "Re: ".AFF_MA_CONTACTCLIENTREPLYEMAIL."", "$emailsalinanaffiliate", "From: $admininfo<$emailadminsupport>");



// Seterusnya hantar email kepada pelanggan
$emailkepadapelanggan = "

Salam sejahtera $namapelanggan.

Email ini dikirimkan oleh sistem pengurusan pelanggan kami.

Anda telah menerima pesanan daripada penaja pembelian anda
bagi produk $namaproduk 

yang dilakukan menerusi link:
=> http://$domain/hop?ref=$idaffiliate

Berikut adalah butiran pesanan yang dikirimkan

===========================================================
Butiran Pesanan Daripada Penaja Anda - $namapengguna
===========================================================

=> Nama Penaja Anda: $namapengguna
=> Email Penaja Anda: $emailpengguna

=> Nama Anda: $namapelanggan
=> Email Anda: $emailpelanggan

=> Tajuk Pesanan Penaja: $tajuksoalan
=> Kandungan Penaja: 

$kandungansoalan


===========================================================

Sebarang pemasalahan atau pertanyaan berkenaan dengan pesanan
ini, sila hubungi penaja anda berdasarkan maklumat diatas.

Sekian, terima kasih.

Ikhlas,
$admininfo
Pihak Pengurusan
$namaproduk
http://$domain

























===========================================================

===========================================================
";

// Hantar email kepada pelanggan
mail("$emailpelanggan", "$namapelanggan: $tajuksoalan","$emailkepadapelanggan","From: $namapengguna<$emailpengguna>");

// Setelah selesai proses diatas, hantar pelanggan ke URL baru
echo "<table cellspacing=\"1\" class=\"SA_success_box\"><tr><td><br />".AFF_MA_CONTACTEMAILSENT."<br /><br /></td></tr></table><br />";

}
//Tutup Fungsi Post
}	  

// Jika ada masalah dengan borang, paparkan masalah
	  	  	  
if($errorMsg != '')
{
    echo "<table cellspacing=\"1\" class=\"SA_error_box\"><tr><td>$errorMsg<br /></td></tr></table><br />";
}

//Dapatkan Data Affiliate
$affiliatedata = mysql_query("SELECT * from affiliates where refid = '".$_SESSION['aff_valid_user']."'", $database_connection) or die ("Database Connection Error");

if (mysql_num_rows($affiliatedata)) 
{
    while ($qry = mysql_fetch_array($affiliatedata))
    {
?> 

      <form name="borangpengesahan" method="post" action="pwjafflite_member_client.php?idjualan=<?=$idsales?>">
          <table bgcolor="#FFFFFF" width="500" cellspacing="1" class="SA_general_table" >
              <tr>
                  <td colspan="3" class="SA_general_table_header"><?=AFF_MA_CONTACTCLIENTTITLE?> - <?=$idaffiliate?></td>
              </tr>
              <tr>
                  <td colspan="3" class="SA_general_table_row1"><br /><?=$arahan_contact_client?><br /><br /></td>
              </tr>
              <tr>
                  <td class="SA_general_table_row1"><div align="right"><?=AFF_MA_CONTACTFORMNAME?></div></td>
                  <td class="SA_general_table_row1"><div align="center">:</div></td>
                  <td class="SA_general_table_row1"><input name="namapengguna" type="text" size="30" maxlength="100" readonly="readonly" value="<?=$qry['firstname']?> <?=$qry['lastname']?>"><font color="#FF0000">*</font></td>
              </tr>
              <tr>
                  <td class="SA_general_table_row2"><div align="right"><?=AFF_MA_CONTACTFORMEMAIL?></div></td>
                  <td class="SA_general_table_row2"><div align="center">:</div></td>
                  <td class="SA_general_table_row2"><input name="emailpengguna" type="text" size="30" maxlength="100" readonly="readonly" value="<?=$qry['email']?>"><font color="#FF0000">*</font></td>
              </tr>
              <tr>
                  <td class="SA_general_table_row1"><div align="right"><?=AFF_G_PELANGGAN?></div></td>
                  <td class="SA_general_table_row1"><div align="center">:</div></td>
                  <td class="SA_general_table_row1"><input name="namapelanggan" type="text" size="30" maxlength="100" readonly="readonly" value="<?=$clientname?>"><font color="#FF0000">*</font></td>
              </tr>
              <tr>
                  <td class="SA_general_table_row2"><div align="right"><?=AFF_G_EMAILPELANGGAN?></div></td>
                  <td class="SA_general_table_row2"><div align="center">:</div></td>
                  <td class="SA_general_table_row2"><input name="emailpelanggan" type="text" size="30" maxlength="100" readonly="readonly" value="<?=$clientemail?>"><font color="#FF0000">*</font></td>
              </tr>
              <tr>
                  <td class="SA_general_table_row1"><div align="right"><?=AFF_G_STATUSPELANGGAN?></div></td>
                  <td class="SA_general_table_row1"><div align="center">:</div></td>
                  <td class="SA_general_table_row1"><input name="statuspelanggan" type="text" size="30" maxlength="100" readonly="readonly" value="<?=$clientstatus?>"><font color="#FF0000">*</font></td>
              </tr>
              <tr>
                  <td class="SA_general_table_row2"><div align="right"><?=AFF_MA_CONTACTFORMCONTENTTITLE?></div></td>
                  <td class="SA_general_table_row2"><div align="center">:</div></td>
                  <td class="SA_general_table_row2"><input name="tajuksoalan" type="text" size="30" maxlength="100"><font color="#FF0000">*</font></td>
              </tr>
              <tr>
                  <td class="SA_general_table_row1"><div align="right"><?=AFF_MA_CONTACTFORMCONTENT?></div></td>
                  <td class="SA_general_table_row1"><div align="center">:</div></td>
                  <td class="SA_general_table_row1"><textarea name="kandungansoalan" cols="30" rows="7"></textarea><font color="#FF0000">*</font></td>
              </tr>
              <tr>
                  <td colspan="3" class="SA_general_table_row2"><div align="center"><input type="hidden" name="commited" value="yes"><input name="submit" type="submit" value="Hantar Borang">&nbsp;&nbsp;<input name="reset" type="reset" value="Isi Semula"></div></td>
              </tr>
          </table>
      </form>
<?      
    }
}

?>
   </div>   
</div>
</body>
</html>