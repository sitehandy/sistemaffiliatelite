<?php

session_start();
include '../../pwjafflite_config.php';
include '../lang/'.$language;

// Papar Header Sistem Affiliate
include 'header.php';

//Get Data
$idadmin    = $_REQUEST['id'];
$email      = $_REQUEST['emailadmin'];
$resetpass  = $_REQUEST['resetpass'];


//Hasilkan nilai string password secara rawak menggunakan fungsi md5
$md5_hash = md5(rand(0,999)); 

//Pilih hanya 8 nombor sahaja untuk dipamerkan pada sistem captcha 
$newpassgenerate = substr($md5_hash, 19, 8); 

//encrypt password agen
$passwordagen = sha1(sha1($newpassgenerate));


 // Get Affiliate Record
$result = mysql_query("SELECT * FROM admin WHERE user = '$idadmin' AND pass = '$resetpass' LIMIT 1", $database_connection) or die ('Database Error');

if (mysql_num_rows($result)) 
{
    while ($qry = mysql_fetch_array($result))
    {
        $idadmin        = $qry['user'];
        $namaadmin      = $qry['namaadmin'];
        $emailadmin     = $qry['emailadmin'];
        $passwordadmin  = $qry['pass'];
	
// Set email
$dataemail = '

Dear Admin, you OR someone has requested a new password for your admin login
for your affiliate program hosted at:

=> http://'.$domain.'/'.$folderaffiliates.'/'.$folderadmin.'/

Your new administrator password:

Admin Login ID: '.$idadmin.'
Admin NEW Password: '.$newpassgenerate.'

==============================================================
Network Detail
==============================================================

IP Address Recorded: '.$clientip.'
Time Recorded: '.$clienttime.'
Date Recorded: '.$clientdate.'
Browser Used: '.$clientbrowser.'


If you didn\'t attempt any password recovery for your administrator login, please change your administrator folder as soon as possible to avoid any damage. 

Update your login ID and password through administrator panel using the data given in this email.

Regards,
Automatic Affiliate System Lite Notification
'.$domain.'

';
    
// Proses Email Dan Hantar Kepada Admin
mail($emailadmin, $namaadmin.' Affiliate Lite Admin NEW Password', $dataemail, 'From: '.$admininfo.'<'.$emailadminsupport.'>');


// Update Database Table Affiliate
mysql_query("UPDATE admin SET pass = '".$passwordagen."' WHERE user = '$idadmin' AND emailadmin = '$emailadmin' LIMIT 1", $database_connection) or die ('Database Connection Error');

// Papar Mesej Password Telah Berjaya Diubah
echo '<br /><table cellspacing="1" class="SA_login_box"><tr><td class="SA_login_box_header">Admin Password Recovery Successful!</td></tr><tr><td class="SA_login_box_row1"><br />Admin password has successfully been changed! The new password has been sent to administrator email. Please check your email.<br /><br /></td></tr><tr><td class="SA_login_box_row2"><div align="center">[ <a href="index.php">Return to Administrator Page</a> ]</div></td></tr></table><br />';

    }
    
//Close mysql result
}

// if it isn�t then show an error message
else echo '<br /><table cellspacing="1" class="SA_login_box"><tr><td class="SA_login_box_header">Data Not Valid!</td></tr><tr><td class="SA_login_box_row1"><br />The request URL is not valid!<br /><br /></td></tr><tr><td class="SA_login_box_row2"><div align="center">[ <a href="pwjafflite_admin_forgotpass.php">Back to Previous Page</a> ]</div></td></tr></table><br />';

//Papar Footer Dari Fail pwjafflite_config.php
echo $footerdisplay;    

?>