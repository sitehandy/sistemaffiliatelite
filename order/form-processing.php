<?php

/**
 * Application Name: Custom PHP Form
 * Application URI: http://github.com/amirolzolkifli/customphpform
 * Description: Custom PHP Form.
 * Version: 1.0.0
 * Author: Amirol Zolkifli
 * Author URI: http://www.amirolzolkifli.com
 * License: MIT
 */

session_start();
// Intergrasi sistem borang dengan sistem affiliate
require '../pwjafflite_config.php';
include '../' .$folderaffiliates.'/lang/'.$language;
require 'form-config.php';
require 'form-helpers.php';
require 'sb-includes/vendor/wixel/gump/gump.class.php';
require 'sb-includes/vendor/phpmailer/phpmailer/PHPMailerAutoload.php';


// Process submitted form post
if ( $_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['form_action'] == 'submit')
{
	// Get recaptcha class
	// require_once 'sb-includes/recaptcha/autoload.php';

	// Set recaptcha
	// $recaptcha_secret = RECAPTCHA_SECRET_KEY;
	// $reCaptcha = new \ReCaptcha\ReCaptcha($recaptcha_secret, new \ReCaptcha\RequestMethod\SocketPost());

	// Validate recaptcha
	// $response = $reCaptcha->verify(
	//         $_POST['g-recaptcha-response'],
	//         $_SERVER['REMOTE_ADDR']
	//     );
	//
  	// if ( ! $response->isSuccess() )
  	// {
  	// 	$errors = 'Captcha is not valid or empty.';
	// 	include('form-errors.php');
	// 	exit();
  	// }

	// Form Validation
	$gump = new GUMP();

	$_POST = $gump->sanitize( $_POST );

	$gump->validation_rules(array(
	    'customer_name'    => 'required|min_len,3',
	    'customer_email'   => 'required|valid_email',
	    'customer_phone'   => 'required|min_len,3',
	    'customer_address' => 'required|min_len,3'
	));

	$validated_data = $gump->run( array_merge( $_POST, $_FILES ) );

	if( $validated_data === false )
	{
	    $errors = $gump->get_readable_errors(true);
	    include('form-errors.php');
	    exit();
	}

	// Send payment request to toyyibPay
	include('toyyibpay.php');
	// Add $toyyibpay_bill_url to array to $_POST
	$_POST['toyyibpay_bill_url'] = $toyyibpay_bill_url;

	// Process and send emails
	$mail = new PHPMailer;                           // Enable verbose debug output
	$mail->IsMail();                                    // Set mailer to use SMTP						// TCP port to connect to
	$mail->setFrom( EMAIL_FROM, SENDER_NAME );
	$mail->addAddress( $_POST['customer_email'], $_POST['customer_name'] );     // Add a recipient
	$mail->addReplyTo( EMAIL_REPLY_TO, SENDER_NAME );
	$mail->Subject = emailSubjectToCustomer( $_POST['customer_name'], 'Tempahan OGCBE ' . $data['billExternalReferenceNo'] );
	$mail->Body    = emailContentToCustomer( $_POST );
	$mail->isHTML(false);								// Set email format to HTML
	$mail->AltBody = 'Please enable HTML to view the email content';
	$mail->send();

	$mail2 = new PHPMailer;                           // Enable verbose debug output
	$mail2->IsMail();                                    // Set mailer to use SMTP						// TCP port to connect to
	$mail2->setFrom( EMAIL_FROM, SENDER_NAME );
	$mail2->addAddress( EMAIL_REPLY_TO, SENDER_NAME );
	$mail2->addReplyTo( $_POST['customer_email'], $_POST['customer_name'] );     // Add a recipient
	$mail2->Subject = emailSubjectToAdmin( SENDER_NAME, 'Tempahan OGCBE ' . $data['billExternalReferenceNo'] );
	$mail2->Body    = emailContentToAdmin( $_POST );
	$mail2->isHTML(false);								// Set email format to HTML
	$mail2->AltBody = 'Please enable HTML to view the email content';
	$mail2->send();


	// Check Referer ID
	if (isset($_POST['ref']) && !empty($_POST['ref']))
	{
	    // Filter $_POST['ref']
	    $idagen = preg_replace('/[^a-zA-Z0-9-]/', '', $_POST['ref']);

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

	// Add order record (2020-03-04)
	$sqlproduk = "SELECT * FROM produk WHERE idproduk = '$_POST[product_id]' LIMIT 1";

	$resultproduk = mysql_query($sqlproduk, $database_connection) or die ('Something wrong with the product.');

	if( mysql_num_rows($resultproduk) )
	{
		while ($qrykomisyen = mysql_fetch_array($resultproduk))
		{
			$produk = $qrykomisyen;
		}

	}

	// Status pelanggan
	$statuspelanggan 	= AFF_AS_STATUSPENDING;
	$product_id			= $produk['idproduk'];
	$product_name		= $produk['namaproduk'];
	$product_price		= $produk['hargaproduk'];
	$namapembeli 		= $_POST['customer_name'];
	$emailpembeli		= $_POST['customer_email'];
	$telefonpembeli 	= $_POST['customer_phone'];
	$alamatpembeli 		= $_POST['customer_address'];
	$jumlahpembayaran 	= $data['billName'] . ' - ' . $produk['hargaproduk'];
	$kaedahpembayaran 	= '<a target="_blank" href="' . $toyyibpay_bill_url . '">' . $billcode . '</a>';
	$transaction_id	 	= $billcode;
	$tarikhpembayaran 	= null;
	$masapembayaran 	= null;
	$created_at 		= date("Y-m-d H:i:s");;

	$sqlorder = "INSERT INTO orders (id, product_id, product_name, product_price, transaction_id, transaction_url, customer_name, customer_email, customer_phone, customer_address, status, created_at)
	VALUES ('', '$product_id', '$product_name', '$product_price', '$transaction_id', '$toyyibpay_bill_url', '$namapembeli', '$emailpembeli', '$telefonpembeli', '$alamatpembeli', '$statuspelanggan', '$created_at')";
	// Data rekod pembelian dan komisyen ke dalam database sistem affiliate
	$resultorder = mysql_query($sqlorder, $database_connection) or die ('Database Insert Error');


	// Credit commission to agent if available
	if (!is_null($idagen))
	{
	    $sqlproduk = "SELECT komisyenproduk FROM produk WHERE idproduk = '$_POST[product_id]' LIMIT 1";

	    $resultproduk = mysql_query($sqlproduk, $database_connection) or die ('Something wrong with the product.');

        if( mysql_num_rows($resultproduk) )
        {
            while ($qrykomisyen = mysql_fetch_array($resultproduk))
			{
				$komisyenaffiliate = $qrykomisyen['komisyenproduk'];
			}

        }

		$sqlkomisen = "INSERT INTO sales (idsales, refid, jumlahpembayaran, kaedahpembayaran, transaction_id, date, time, browser, ipaddress, payment, namapelanggan, emailpelanggan, statuspelanggan)
		VALUES ('', '$idagen', '$jumlahpembayaran', '$kaedahpembayaran', '$transaction_id', '$clientdate', '$clienttime', '$clientbrowser', '$clientip', '$komisyenaffiliate', '$namapembeli', '$emailpembeli', '$statuspelanggan')";
		// Data rekod pembelian dan komisyen ke dalam database sistem affiliate
	    $resultkomisyen = mysql_query($sqlkomisen, $database_connection) or die ('Database Insert Error');
	}

	header( 'location: ' . $toyyibpay_bill_url );
	exit();

}

echo '<meta http-equiv="refresh" content="2;url=./">';
exit();
