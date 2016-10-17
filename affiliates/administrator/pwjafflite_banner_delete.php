<?php

session_start();
include '../../pwjafflite_config.php';
include '../lang/'.$language;

if(!aff_admin_check_security())
{
    aff_redirect('index.php');
    exit();
}

// Sahkan Proses Penghapusan Data
if (($_REQUEST['delete']) && ($_REQUEST['validation'] == $_SESSION['aff_valid_admin']))
{
    // Sambung Ke Database
    if (!$database_connection)
    {
	die('Could not connect: ' . mysql_error());
    }

    mysql_query("DELETE FROM banners WHERE number = '".$_REQUEST['delete']."' LIMIT 1", $database_connection) or die('Database DELETE Error');
    aff_redirect('pwjafflite_admin_banners.php');
}

// Dapatkan Header Sistem Affiliate
include 'header.php';

echo '<p>&nbsp;</p><p align="center">Data is being deleted</p><p>&nbsp;</p>';

//Papar Footer
echo $footerdisplay; 

?>