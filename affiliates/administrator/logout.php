<?php

session_start();

include '../../pwjafflite_config.php';

$_SESSION['aff_valid_admin'] = '';
unset($_SESSION['aff_valid_admin']);

aff_redirect('index.php');

?>