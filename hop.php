<?php
// Include filters
include 'includes/filters/content.inc.php';
include 'includes/filters/magicquotes.inc.php';

// Include system config file.
include 'pwjafflite_config.php';

// Check referer ID
if (isset($_GET['ref']) && !empty($_GET['ref']) )
{
    // Filter $_GET['ref']
    $ref = preg_replace('/[^a-zA-Z0-9-]/', '', $_GET['ref']);

    // Check Referer Cookie
    if( isset( $_COOKIE['ref'] ) )
    {
        // Check if cookie rewrite is allowed (F = First referral)
        if( ($affiliate_tracking != 'F') && ($_COOKIE['ref'] != $ref) )
        {
            // Delete old cookie record if exist
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

            // Register new cookie on user browser
            setcookie('ref', $ref, $cookieLifetime, $cookiePath, $cookieDomain);

            // Set new session
            session_start();
            $_SESSION['ref'] = $ref;

            // Set Referral URL if not refered
            if( $clienturl == '' )
            {
                $clienturl = 'Direct Linking Referred by Affiliate';
            }

            // Update Clicks
            mysql_query("INSERT INTO clickthroughs
                (refid, date, time, browser, ipaddress, refferalurl) VALUES
                ('$ref', '$clientdate', '$clienttime', '$clientbrowser', '$clientip', '$clienturl')", $database_connection)
                    or die ('Cannot Connect to Server');
        }

        // If Cookie and Referral are the same
        else if( ($affiliate_tracking != 'F') && ($_COOKIE['ref'] == $ref) )
        {
            // Set Referral URL if not refered
            if($clienturl == '')
            {
                $clienturl = 'Direct Linking Referred by Affiliate';
            }

            else
            {
                $clienturl = $clienturl.' - Return Visitor';
            }

            // Update clicks
            mysql_query("INSERT INTO clickthroughs
                (refid, date, time, browser, ipaddress, refferalurl) VALUES
                ('$ref', '$clientdate', '$clienttime', '$clientbrowser', '$clientip', '$clienturl')", $database_connection)
                    or die ('Cannot Connect to Server');
        }

        // If rewrite cookie is not allowed
        else
        {
            // Set Referral URL if not refered
            if($clienturl == '')
            {
                $clienturl = 'Direct Linking Referred by Affiliate';
            }

            else
            {
                $clienturl = $clienturl.' - Return Visitor';
            }

            //Update status klik agen
            mysql_query("INSERT INTO clickthroughs
                (refid, date, time, browser, ipaddress, refferalurl) VALUES
                ('".$_COOKIE['ref']."', '$clientdate', '$clienttime', '$clientbrowser', '$clientip', '$clienturl')", $database_connection)
                    or die ('Cannot Connect to Server');
        }

    } // Close Referer Cookie Checking

    // IF cookie not exist
    else
    {
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
        setcookie('ref', $ref, $cookieLifetime, $cookiePath, $cookieDomain);

        // Tetapkan session baru
        session_start();
        $_SESSION['ref'] = $ref;

        // Tetapkan referrer URL jika kosong
        if ($clienturl == '')
        {
            $clienturl = 'Direct Linking Referred by Affiliate';
        }

        //Update status klik agen
        mysql_query("INSERT INTO clickthroughs
            (refid, date, time, browser, ipaddress, refferalurl) VALUES
            ('$ref', '$clientdate', '$clienttime', '$clientbrowser', '$clientip', '$clienturl')", $database_connection)
                or die ('Cannot Connect to Server');
    }
} // Close GET Referer checking

// Check referer ID
if (isset($_GET['p']) && !empty($_GET['p']))
{
    // Get only DIGITS
    // http://agen.cikguhafis.com/hop.php?ref=demo&p=1
    $product_id = preg_replace('/[^0-9]/', '', $_GET['p']);

    // Get product ID
    $product = mysql_query("SELECT * FROM produk WHERE idproduk = '" . $product_id . "'", $database_connection) or die ("Database Affiliate Connect Error");

    if (mysql_num_rows($product))
    {
        while ($qry = mysql_fetch_array($product))
        {
            if (!is_null($qry['produkUrl']))
            {
                // Redirect User to Landing Page
                header('Location: ' . $qry['produkUrl'] . '?ref=' . $ref);
                exit();
            }
        }
    }
}

// Redirect User to Landing Page by default
header('Location: ' . $landingpage . '?ref=' . $ref);
exit();
?>
