<?php
// Penetapan fungsi session untuk sistem captcha
session_start();
// Intergrasi sistem borang dengan sistem affiliate
require '../pwjafflite_config.php';
include '../' .$folderaffiliates.'/lang/'.$language;
require 'form-config.php';
require 'form-helpers.php';
require 'sb-includes/vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

// https://agen.cikguhafis.com/order/toyyibpay-return.php?status_id=3&billcode=qisxgwm0&order_id=1590453121&msg=ok&transaction_id=TP14985221553108260520
// https://agen.cikguhafis.com/order/toyyibpay-return.php?status_id=1&billcode=sinkto37&order_id=1590455126&msg=ok&transaction_id=TP14986028220509260520
if (isset($_REQUEST['status_id']) && isset($_REQUEST['billcode']) && isset($_REQUEST['order_id']) && isset($_REQUEST['transaction_id']))
{
    $status = $_REQUEST['status_id'];
    $billcode = $_REQUEST['billcode'];
    $orderid = $_REQUEST['order_id'];
    $transactionid = $_REQUEST['transaction_id'];

    // Now double check the record with toyyibPay
    $data = array(
        'billCode' => $billcode
    );

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_URL, TOYYIBPAY_ENDPOINT . '/index.php/api/getBillTransactions');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    $result = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($result, true);

    $payment_status = $response[0]['billpaymentStatus'];

    if ($payment_status == 1)
    {
        // Update order
        $sqlorder = "SELECT * FROM orders WHERE transaction_id = '$billcode' LIMIT 1";

        $resultorder = mysql_query($sqlorder, $database_connection) or die ('Something wrong with the order.');

        if ( mysql_num_rows($resultorder) > 0)
        {
            // Update Database Table Admin
            mysql_query("UPDATE orders SET status = 'PAID' WHERE transaction_id = '$billcode'", $database_connection) or die ('Database Transaction Failed.');

            while ($order = mysql_fetch_array($resultorder))
    		{
                // Send email notification
                // Process and send emails
            	$mail = new PHPMailer;                           // Enable verbose debug output
            	$mail->IsMail();                                    // Set mailer to use SMTP						// TCP port to connect to
            	$mail->setFrom( EMAIL_FROM, SENDER_NAME );
            	$mail->addAddress( $order['customer_email'], $order['customer_name'] );     // Add a recipient
            	$mail->addReplyTo( EMAIL_REPLY_TO, SENDER_NAME );
            	$mail->Subject = emailSubjectToPaidCustomer( $order['customer_name'], 'Butiran Tempahan OGCBE - PAID' );
            	$mail->Body    = emailContentToPaidCustomer( $order );
            	$mail->isHTML(false);								// Set email format to HTML
            	$mail->AltBody = 'Please enable HTML to view the email content';
            	$mail->send();
    		}

        }

        // Update commission
        $sqlsale = "SELECT * FROM sales WHERE transaction_id = '$billcode' LIMIT 1";

        $resultsale = mysql_query($sqlsale, $database_connection) or die ('Something wrong with the transaction');

        if ( mysql_num_rows($resultsale) > 0)
        {
            // Update Database Table Admin
            mysql_query("UPDATE sales SET statuspelanggan = 'VERIFIED' WHERE transaction_id = '$billcode'", $database_connection) or die ('Database Transaction Error');
        }

        // Redirect to success thankyou page
        header('Location: ' . THANK_YOU_PAGE_PAID);
        exit();
    }
}
header('Location: ' . THANK_YOU_PAGE);
exit();
