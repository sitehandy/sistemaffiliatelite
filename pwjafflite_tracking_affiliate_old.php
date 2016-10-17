<?php
// Function to allow cookie to be rewritten
// Check referer ID
if( isset( $_GET['ref'] ) and $_GET['ref'] != '' )
{
    // Filter $_GET['ref']
    $ref = preg_replace('/[^a-zA-Z0-9-]/', '', $_GET['ref'] );
    
    // Include filters
    include 'includes/filters/content.inc.php';
    include 'includes/filters/magicquotes.inc.php';
    
    // Include system config file.
    include 'pwjafflite_config.php';
    
    if($cookieExpiration != 0)
    {
        $cookieLifetime = time() + $cookieExpiration*86400;
    }
    
    else
    {
        $cookieLifetime = time() + 3650*86400;
    }
    
    // Set cookie
	setcookie('ref', $ref, $cookieLifetime, $cookiePath, $cookieDomain);
	
	session_start();
	$_SESSION['ref'] = $ref;

        // Update Clicks
	if ($clienturl == '')
	{
            $clienturl = 'Direct Link Referer';
	}
        
	mysql_query("INSERT INTO clickthroughs (refid, date, time, browser, ipaddress, refferalurl) 
            VALUES ('$ref', '$clientdate', '$clienttime', '$clientbrowser', '$clientip', '$clienturl')", $database_connection)
                or die ('Cannot Connect to Server');
}

?>