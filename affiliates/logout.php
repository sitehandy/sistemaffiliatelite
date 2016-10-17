<?php

session_start();
include '../pwjafflite_config.php';
 
$_SESSION['aff_valid_user'] = '';
unset($_SESSION['aff_valid_user']);

aff_redirect('index.php');

?>