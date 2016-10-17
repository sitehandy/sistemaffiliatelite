<?php

session_start();
include '../../pwjafflite_config.php';
include '../lang/'.$language;

if(!aff_admin_check_security())
{
    aff_redirect('index.php');
    exit();
}

if ($_REQUEST['delete'])
{
    mysql_query("DELETE FROM videopromosi WHERE number = '".$_REQUEST['delete']."' LIMIT 1", $database_connection) or die("Database DELETE Error");
    aff_redirect('pwjafflite_admin_videos.php');        
}

// Dapatkan Header Sistem Affiliate
include 'header.php';

echo '<p>&nbsp;</p><p align="center">Data is being deleted</p><p>&nbsp;</p>';
  
//Papar Footer
echo $footerdisplay;

?>