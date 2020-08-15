<?php
session_start();
// Include system config file.
require 'pwjafflite_config.php';
// Check Referer ID
if (isset($_GET['ref']) && !empty($_GET['ref']))
{
    // Filter $_GET['ref']
    $idagen = preg_replace('/[^a-zA-Z0-9-]/', '', $_GET['ref']);

    // Check affiliate id existance

    if (isset($idagen) && !empty($idagen))
    {
        $sql = "SELECT * FROM affiliates where refid = '" . $idagen . "'  LIMIT 1";

        $result = mysql_query($sql, $database_connection);

        if (mysql_num_rows($result) > 0)
        {
            // Delete rekod cookie & session asal (jika ada)
            setcookie('ref', '', time() - 3600 *24 * 365, $cookiePath, $cookieDomain);
            if (isset($_SESSION['ref']))
            {
                unset($_SESSION['ref']);
            }

            // Set Cookie Expiry
            if ($cookieExpiration != 0)
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
            $_SESSION['ref'] = $idagen;
        }
        elseif (isset($_COOKIE['ref']))
        {
            $idagen = $_COOKIE['ref'];
        }
        else
        {
            $idagen = null;
        }
    }
    elseif (isset($_COOKIE['ref']))
    {
        $idagen = $_COOKIE['ref'];
    }
    else
    {
        $idagen = null;
    }
}
elseif (isset($_COOKIE['ref']))
{
    $idagen = $_COOKIE['ref'];
}
else
{
    $idagen = null;
}

if (!is_null($idagen))
{
    $sql = "SELECT * FROM affiliates where refid = '" . $idagen . "'  LIMIT 1";

    $result = mysql_query($sql, $database_connection);

    if (mysql_num_rows($result) > 0)
    {
        while ($qryaffiliate = mysql_fetch_array($result))
        {
            $usernameaffiliate = $idagen;
            $namaaffiliate = $qryaffiliate['firstname'].' '.$qryaffiliate['lastname'];
            $emailaffiliate = $qryaffiliate['email'];
            $phoneaffiliate = $qryaffiliate['phone'];
            $websiteaffiliate = $qryaffiliate['website'];
        }
    }
}
