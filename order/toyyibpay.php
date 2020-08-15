<?php

$data = array(
    // 'userSecretKey' => '0eeyjk9c-nnzi-rss3-5w7h-hohtecz755eh',
    // 'categoryCode' => 'u9w8fpyh',
    'userSecretKey' => TOYYIBPAY_SECRETKEY,
    'categoryCode' => TOYYIBPAY_CATEGORYCODE,
    'billName' => 'OGCBE',
    'billDescription' => 'Online Group Coaching Bisnes Ebook Cikgu Hafis',
    'billPriceSetting' => 1,
    'billPayorInfo' => 1,
    'billAmount' => $_POST['product_price'] * 100,
    'billReturnUrl' => 'https://agen.cikguhafis.com/order/toyyibpay-return.php',
    'billCallbackUrl' => 'https://agen.cikguhafis.com/order/toyyibpay-callback.php',
    'billExternalReferenceNo' => strtotime('now'),
    'billTo' => $_POST['customer_name'],
    'billEmail' => $_POST['customer_email'],
    'billPhone' => $_POST['customer_phone'],
    'billSplitPayment' => 0,
    'billSplitPaymentArgs' => '',
    'billPaymentChannel' => '0',
    'billDisplayMerchant' => 1,
    'billContentEmail' => 'Terima kasih kerana telah menempah Online Group Coaching Bisnes Ebook Cikgu Hafis.',
    'billChargeToCustomer' => ''
);

$toyyib_endpoint = TOYYIBPAY_ENDPOINT;

$curl = curl_init();
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_URL, $toyyib_endpoint . '/index.php/api/createBill');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

$result = curl_exec($curl);
curl_close($curl);
$response = json_decode($result, true);

$billcode = $response[0]['BillCode'];
$toyyibpay_bill_url = $toyyib_endpoint . '/' . $billcode;
