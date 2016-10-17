<?php

session_start();
include '../../pwjafflite_config.php';
include '../lang/'.$language;

if(!aff_admin_check_security())
{
    aff_redirect('index.php');
    exit();
}

if (($_REQUEST['delete']) && ($_REQUEST['validation'] == $_SESSION['aff_valid_admin']))
{
    mysql_query("DELETE FROM artikelpromosi WHERE number = '".$_REQUEST['delete']."' LIMIT 1", $database_connection) or die("Database DELETE Error");
    aff_redirect('pwjafflite_admin_articles.php');        
}
	
include 'header.php';
  
//Papar Footer
echo $footerdisplay;

?>