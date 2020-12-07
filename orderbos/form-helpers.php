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

function emailSubjectToCustomer( $name, $subject )
{
	return $name . ', ' . $subject;
}

function emailContentToCustomer( $data )
{
	return "
<html>
    <head>
        <title></title>
    </head>
    <body>
		<p>Hi $data[customer_name],</p>
		<p>Terima kasih kerana telah membuat tempahan Online Group Coaching Bisnes Ebook daripada Cikgu Hafis.</p>
		<p>Berikut adalah maklumat tempahan anda:</p>
		<ul>
			<li>Nama Produk: Online Group Coaching Bisnes Ebook</li>
			<li>Harga Produk: $data[product_price]</li>
			<li>URL Tempahan: <a href=\"https://agen.cikguhafis.com/order\">https://agen.cikguhafis.com/order</a></li>
			<li>URL Bayaran: <a href=\"$data[toyyibpay_bill_url]\">$data[toyyibpay_bill_url]</a></li>
			<li>Nama Pembeli: $data[customer_name]</li>
			<li>Email Pembeli: $data[customer_email]</li>
			<li>Telefon Pembeli: $data[customer_phone]</li>
			<li>Alamat Pembeli: $data[customer_address]</li>
		</ul>
		<p>Jika anda mempunyai sebarang masalah dengan tempahan yang dibuat, sila hubungi kami.</p>
		<p>Sekian, terima kasih.</p>
		<p>Cikgu Hafis</p>
    </body>
</html>
	";
}


function emailSubjectToAdmin( $name, $subject )
{
	return $name . ', ' . $subject;
}

function emailContentToAdmin( $data )
{
	return "
<html>
    <head>
        <title></title>
    </head>
    <body>
		<p>Hi Admin,</p>
		<p>Ada pelanggan telah membuat tempahan Online Group Coaching Bisnes Ebook Cikgu Hafis.</p>
		<p>Berikut adalah maklumat tempahan:</p>
		<ul>
			<li>Nama Produk: Online Group Coaching Bisnes Ebook</li>
			<li>Harga Produk: $data[product_price]</li>
			<li>URL Tempahan: <a href=\"https://agen.cikguhafis.com/order\">https://agen.cikguhafis.com/order</a></li>
			<li>URL Bayaran: <a href=\"$data[toyyibpay_bill_url]\">$data[toyyibpay_bill_url]</a></li>
			<li>Nama Pembeli: $data[customer_name]</li>
			<li>Email Pembeli: $data[customer_email]</li>
			<li>Telefon Pembeli: $data[customer_phone]</li>
			<li>Alamat Pembeli: $data[customer_address]</li>
		</ul>
		<p>Sekian, terima kasih.</p>
		<p>Cikgu Hafis</p>
    </body>
</html>
	";
}


function emailSubjectToPaidCustomer( $name, $subject )
{
	return $name . ', ' . $subject;
}

function emailContentToPaidCustomer( $data )
{
	return "
<html>
    <head>
        <title></title>
    </head>
    <body>
		<p>Hi $data[customer_name],</p>
		<p>Terima kasih kerana telah membuat bayaran bagi tempahan Online Group Coaching Bisnes Ebook daripada Cikgu Hafis.</p>
		<p>Berikut adalah maklumat status tempahan anda:</p>
		<ul>
			<li>Nama Produk: Online Group Coaching Bisnes Ebook</li>
			<li>Harga Produk: $data[product_price]</li>
			<li>URL Tempahan: <a href=\"https://agen.cikguhafis.com/order\">https://agen.cikguhafis.com/order</a></li>
			<li>URL Bayaran: <a href=\"$data[transaction_url]\">$data[transaction_url]</a></li>
			<li>Status Bayaran: PAID</li>
		</ul>
		<p>Berikut adalah langkah - langkah untuk menyertai Online Group Coaching Bisnes Ebook bersama Cikgu Hafis.</p>
		<p>Step 1 – Lihat Panduan Cara Register Join Online Group Coaching melalui GoToWebinar</p>
		<p>=&gt; <a href=\"https://youtu.be/QClGlids-dI\" target=\"_blank\">https://youtu.be/QClGlids-dI</a></p>
		<p>Step 2 – Daftar Penyertaan Link GoToWebinar untuk join Online Group Coaching</p>
		<p>=&gt; <a href=\"https://register.gotowebinar.com/register/3735371260335779595\" target=\"_blank\">https://register.gotowebinar.com/register/3735371260335779595</a></p>
		<p>Step 3 – Daftar Group WhatsApp</p>
		<p>=&gt; <a href=\"https://chat.whatsapp.com/CsXB7tdb8UIK6oqqc1eKtx\" target=\"_blank\">https://chat.whatsapp.com/CsXB7tdb8UIK6oqqc1eKtx</a></p>
		<p>Untuk sebarang pertanyaan melalui WhatsApp mengenai Online Group Coaching ini, anda boleh terus hubungi Pn Dalia 017 235 9542</p>
		<p>Sekian, terima kasih.</p>
		<p>Cikgu Hafis</p>
    </body>
</html>
	";
}
