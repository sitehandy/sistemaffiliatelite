<?php
// Check Referer ID
if( isset($_GET['ref']) and $_GET['ref'] != '' )
{
    // Filter $_GET['ref']
    $idagen = preg_replace('/[^a-zA-Z0-9-]/', '', $_GET['ref'] );
    
    // Include system config file.
    include 'pwjafflite_config.php';
	
    // Delete rekod cookie & session asal (jika ada)
    setcookie('ref', '', time() - 3600 *24 * 365, $cookiePath, $cookieDomain);
    unset($_SESSION['ref']);

    // Set Cookie Expiry
    if($cookieExpiration != 0)
    {
        $cookieLifetime = time() + $cookieExpiration*86400;
    }
    
    else
    {
        $cookieLifetime = time() + 3650*86400;
    }

    // Daftarkan cookie baru
    setcookie('ref', $idagen, $cookieLifetime, $cookiePath, $cookieDomain);

    // Tetapkan session baru
    session_start();
    $_SESSION['ref'] = $idagen;

}    

else if( isset($_COOKIE['ref']) )
{
    $idagen = $_COOKIE['ref'];
}

else
{
    $idagen = 'admin';
}


// Dapatkan Fungsi Fail Yang Diperlukan
include 'pwjafflite_database.php';


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

if( isset($idagen) and $idagen != '' )
{
    $affiliates = mysql_query("SELECT * FROM affiliates where refid = '".$idagen."'  LIMIT 1", $database_connection);
    
    if(mysql_num_rows($affiliates))
    {
        while ($qryaffiliate = mysql_fetch_array($affiliates))
        {
            $namaaffiliate = $qryaffiliate['firstname'].' '.$qryaffiliate['lastname'];
            $emailaffiliate = $qryaffiliate['email'];
            $phoneaffiliate = $qryaffiliate['phone'];
            $toneexcel_id = $qryaffiliate['website'];
        }
    }
}
else
{
    $affiliates = mysql_query("SELECT * FROM affiliates where refid = 'admin'  LIMIT 1", $database_connection);
    
    if(mysql_num_rows($affiliates))
    {
        while ($qryaffiliate = mysql_fetch_array($affiliates))
        {
            $namaaffiliate = $qryaffiliate['firstname'].' '.$qryaffiliate['lastname'];
            $emailaffiliate = $qryaffiliate['email'];
            $phoneaffiliate = $qryaffiliate['phone'];
            $toneexcel_id = $qryaffiliate['website'];
        }
    }
}
?>