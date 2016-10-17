<?php

require '../pwjafflite_database.php';
$pwjafflite_version = 'Version 2.6.0';

// Sample Data For Installation

// Data Table admin
$data_table_admin = "INSERT INTO admin (id, user, pass, namaadmin, emailadmin, emailadminsupport, emailadminpayment, namaproduk, domain, folderaffiliates, folderadmin, domainredirect, landingpage, cookieExpiration, cookieDomain, cartatopaffiliate, currency, language, idaffiliatePIS, tahunoperasi, onoffpendaftaran, kodpendaftaran, kodcaptchaborang, affiliatetracking, scriptcredit) VALUES
('', 'admin', '7b2e9f54cdff413fcde01f330af6896c3cd7e6cd', 'Nama Admin', 'emailadmin@domain.com', 'emailsupport@domain.com', 'emailtempahan@domain.com', 'Pakej Sistem Affiliate', 'www.sistemaffiliate.com', 'affiliates', 'administrator', 'http://www.ebisnes.com', 'index.html', '0', '', '10', 'MYR', 'mly.php', '19', '2013', 'ON', '123', 'DISABLE', 'L', '0')";

// Data Table affiliates
$data_table_affiliates = "INSERT INTO affiliates (id, refid, pass, title, firstname, lastname, email, website, street, town, county, postcode, country, phone, processor, account, payto, date, ipaddress, upline) VALUES
('', 'demo', '334cae45db13ceaf21183e0c8f867af25ab403ad', 'En', 'Ahmad', 'Albab', 'emailagen@domain.com', 'www.sistemaffiliate.com', '123 Alamat Surat Menyurat', 'Seremban', 'Negeri Sembilan', '1234567', 'MY', '60123456789', 'MAYBANK', '12345678910', 'Nama Penerima Bayaran', '2013-12-24', '175.137.251.139', '')";

// Data Table emailadmin
$data_table_emailadmin = "INSERT INTO emailadmin (emaildaftar, emailpengesahan, emailpengesahanadmin, emailpassworduser, emailpassworduserreset, emailsahkomisyen, emailbayarkomisyen) VALUES
('Salam sejahtera %%namaagen%%,\r\n\r\nTerima kasih kerana telah mendaftar sebagai agen pemasaran kami \r\nmenerusi program affiliate yang kami tawarkan iaitu program affiliate\r\nbagi:\r\n\r\n%%namaproduk%%\r\n\r\nBerikut adalah maklumat akaun affiliate anda:\r\n\r\n=============================================\r\nAkaun Affiliate Anda\r\n=============================================\r\n\r\nNama Program Affiliate:\r\n=> %%namaproduk%%\r\n\r\nURL Halaman Affiliate:\r\n=> %%loginaffiliate%%\r\n\r\nLogin Affiliate Anda:\r\n[+] Username: %%idagen%%\r\n[+] Password: %%passwordagen%%\r\n\r\nLink Affiliate Anda:\r\n=> %%linkaffiliate%%\r\n\r\n=============================================\r\n\r\nAnda boleh login ke akaun affiliate anda untuk melihat statistik \r\n\"real-time\", jumlah komisyen, bahan promosi dan lain - lain perkara \r\nyang telah kami sediakan.\r\n\r\nAkhir kata, terima kasih sekali lagi kami ucapkan kerana telah\r\nmendaftar sebagai agen affiliate kami.\r\n\r\nSelamat menjana wang bersama perniagaan kami!\r\n\r\nYang Benar,\r\n\r\n%%namaadmin%%\r\n%%domain%%', 'Salam sejahtera %%namapembeli%%.\r\n\r\nTerima kasih kerana telah membuat pembelian produk:\r\n\r\n=> %%namaproduk%%\r\n\r\ndaripada laman web kami di:\r\n\r\n=> http://%%domain%%\r\n\r\nDibawah ini adalah salinan butiran pengesahan tempahan dan\r\npembayaran anda yang telah kami terima:\r\n\r\n===========================================================\r\nButiran Tempahan %%namaproduk%%\r\n===========================================================\r\n\r\nPembelian di: %%domain%%\r\n\r\n\r\n===========================================================\r\nButiran Pengesahan Transaksi Pembayaran\r\n===========================================================\r\n\r\n=> Nama Anda: %%namapembeli%%\r\n=> Email Anda: %%emailpembeli%%\r\n=> Tel. Anda: %%telefonpembeli%%\r\n\r\n=> Alamat Anda (Jika Telah Di Isi):\r\n%%alamatpembeli%%\r\n\r\n=> Produk & Bayaran: %%jumlahpembayaran%%\r\n=> Kaedah Pembayaran: %%kaedahpembayaran%%\r\n\r\n=> Tarikh Pembayaran: %%tarikhpembayaran%%\r\n=> Masa Pembayaran: %%masapembayaran%%\r\n\r\n=> Bukti Pembayaran:\r\n%%buktipembayaran%%\r\n\r\n\r\n=> Nota Tambahan (Jika Ada):\r\n%%notapembeli%%\r\n\r\n\r\n===========================================================\r\n\r\nKami akan memproses tempahan anda dalam tempoh 24 jam dari\r\nsekarang atau selewat - lewatnya 48 jam.\r\n\r\nProduk yang ditempah akan dikirimkan kepada anda selepas\r\npengesahan data pembelian anda kami semak.\r\n\r\nPastikan anda menyimpan email ini sebagai rekod dan juga pastikan\r\nalamat email kami iaitu %%emailsupport%% di simpan ke dalam address\r\nbook email anda.\r\n\r\nIni adalah untuk memastikan email kami selepas ini akan senantiasa\r\nmasuk ke dalam INBOX anda bagi memudahkan urusan kita di masa\r\nhadapan.\r\n\r\nJika anda menghadapi sebarang masalah atau pertanyaan, sila\r\nkirimkan pesanan anda ke %%emailsupport%%.\r\n\r\nSekian, terima kasih.\r\n\r\nIkhlas\r\n\r\n%%namaadmin%%\r\n%%domain%%\r\n%%emailsupport%%', 'Salam sejahtera admin %%namaadmin%%.\r\n\r\nAnda telah menerima tempahan produk %%namaproduk%%\r\nyang anda jual di http://%%domain%%\r\n\r\nBerikut adalah senarai tempahan / bukti pengesahan\r\nyang telah dikirimkan oleh pembeli.\r\n\r\n===========================================================\r\nTempahan & Pengesahan Pembelian\r\n===========================================================\r\n\r\nProduk & Harga: %%jumlahpembayaran%%\r\nURL: http://%%domain%%\r\n\r\n\r\n===========================================================\r\nButiran Pengesahan Transaksi Pembayaran\r\n===========================================================\r\n\r\n=> Nama Pembeli: %%namapembeli%%\r\n=> Email Pembeli: %%emailpembeli%%\r\n=> Tel. Pembeli: %%telefonpembeli%%\r\n\r\n=> Alamat Pembeli(Jika Telah Di Isi):\r\n%%alamatpembeli%%\r\n\r\n\r\n=> Produk & Bayaran: %%jumlahpembayaran%%\r\n=> Kaedah Pembayaran: %%kaedahpembayaran%%\r\n\r\n=> Tarikh Pembayaran: %%tarikhpembayaran%%\r\n=> Masa Pembayaran: %%masapembayaran%%\r\n\r\n=> Bukti Pembayaran:\r\n%%buktipembayaran%%\r\n\r\n\r\n=> Nota Tambahan Pembeli (Jika Ada):\r\n%%notapembeli%%\r\n\r\n\r\n\r\n===========================================================\r\nData Sponsor / Agen Affiliate Yang Terlibat (Jika Ada)\r\n===========================================================\r\n\r\n=> ID Agen (Sponsor): %%idagen%%\r\n=> Komisyen Agen: %%komisyenagen%%\r\n=> Status Jualan: %%statuskomisyen%%\r\n\r\n\r\n===========================================================\r\nRekod Komputer Pelanggan Semasa Borang Tempahan Dikirimkan\r\n===========================================================\r\n\r\n=> No. IP: %%ippelanggan%%\r\n\r\n=> Tarikh: %%tarikhborang%%\r\n=> Masa: %%masaborang%%\r\n\r\n=> Browser: \r\n%%browserpelanggan%%\r\n\r\n===========================================================\r\n\r\nSilalah %%namaadmin%% semak data pengesahan pembelian ini\r\nmenerusi:\r\n\r\n1. Menyemak transaksi ke dalam akaun anda.\r\n2. Menyemak data affiliate yang terlibat.\r\n3. Jika ada agen affiliate terlibat, semak komisyennya.\r\n4. Kirimkan produk kepada pembeli, %%namapembeli%%\r\n\r\n\r\nSila simpan email ini untuk rujukan anda dimasa akan datang.\r\n\r\nSekian,\r\nSistem Affiliate', 'Salam sejahtera %%namaagen%%,\r\n\r\nAnda telah memohon untuk mendapatkan kembali password login\r\naffiliate bagi username %%idagen%% di:\r\n\r\n=> %%loginaffiliate%%\r\n\r\nUntuk maklumat %%namaagen%%, password tersebut tidak \r\ndapat dikembalikan. Jadi %%namaagen%% perlu RESET kepada password yang\r\nbaru.\r\n\r\nJika ingin meneruskan proses reset, sila layari ke link dibawah ini untuk reset kembali password anda.\r\n\r\n[+] %%urlresetpassword%%\r\n\r\nJika anda menghadapi sebarang masalah atau mempunyai sebarang pertanyaan, kirimkan pesanan anda kepada kami ke alamat %%emailsupport%%.\r\n\r\nSekian, terima kasih.\r\n\r\nIkhlas,\r\n%%namaadmin%%\r\n%%domain%%\r\n\r\n\r\n==============================================================\r\nSebagai langkah keselamatan, butiran anda dibawah telah direkod\r\n==============================================================\r\n\r\nIP Address Anda: %%ippelanggan%%\r\nMasa Permohonan Dibuat: %%masaborang%%\r\nTarikh Permohonan Dibuat: %%tarikhborang%%\r\nBrowser Yang Anda Gunakan: %%browserpelanggan%%\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', 'Salam sejahtera %%namaagen%%,\r\n\r\nPenukaran password login affiliate di  %%loginaffiliate%%\r\ntelah berjaya dilakukan.\r\n\r\nBerikut adalah maklumat login anda:\r\n\r\n==============================================\r\nMaklumat Akaun Login Affiliate\r\n==============================================\r\n\r\nURL Halaman Affiliate: \r\n=> %%loginaffiliate%%\r\n\r\nUsername: %%idagen%%\r\nPassword: %%passwordbaruagen%%\r\n\r\nLink Affiliate Anda:\r\n=> %%linkaffiliate%%\r\n\r\n==============================================\r\n\r\n\r\nJika anda menghadapi sebarang masalah atau mempunyai sebarang pertanyaan, kirimkan pesanan anda kepada kami di %%emailsupport%%.\r\n\r\nSekian, terima kasih.\r\n\r\nIkhlas,\r\n%%namaadmin%%\r\n%%domain%%\r\n\r\n\r\n==============================================================\r\nSebagai langkah keselamatan, butiran anda dibawah telah direkod\r\n==============================================================\r\n\r\nIP Address Anda: %%ippelanggan%%\r\nMasa Permohonan Dibuat: %%masaborang%%\r\nTarikh Permohonan Dibuat: %%tarikhborang%%\r\nBrowser Yang Anda Gunakan: %%browserpelanggan%%\r\n', 'Salam sejahtera, %%namaagen%%\r\n\r\nAnda telah berjaya menerima komisyen yang telah di\r\nsahkan (VERIFIED) untuk usaha promosi yang anda \r\njalankan bagi produk kami seperti berikut:\r\n\r\n\r\n=========================================\r\nButiran Produk Terlibat\r\n=========================================\r\n\r\nPromosi: %%namaproduk%%\r\nURL Jualan: %%linkaffiliate%%\r\n\r\nNama Produk & Harga Jualan: %%jualan%%\r\nJumlah Komisyen: %%komisyenagen%%\r\nStatus Komisyen: DISAHKAN (VERIFIED)\r\n\r\n\r\n=========================================\r\nMaklumat Pelanggan Anda\r\n=========================================\r\n\r\nNama Pelanggan: %%namapelanggan%%\r\nEmail Pelanggan: %%emailpelanggan%%\r\n\r\n\r\nNOTA: Anda boleh menghubungi pelanggan yang anda taja ini \r\nuntuk memberi sebarang BONUS atau SOKONGAN kepada beliau atas\r\nurusniaga yang telah beliau jalankan menerusi link affiliate anda.\r\n\r\nUntuk menyemak maklumat lanjut tentang komisyen anda, berikut \r\nadalah butiran yang anda perlukan:\r\n\r\n=========================================\r\nMaklumat Akaun Affiliate Anda\r\n=========================================\r\n\r\nURL Login Affiliate:\r\n=> %%loginaffiliate%%\r\n\r\nID Affiliate Anda: %%idagen%%\r\nPassword Anda: (tidak dipaparkan)\r\n\r\nNOTA: Jika anda lupa password, sila pohon password \r\nbaru di halaman agen atau hubungi kami di  %%emailsupport%%\r\n\r\nLink Promosi (Affiliate) Anda:\r\n=> %%linkaffiliate%%\r\n\r\n=========================================\r\n\r\n\r\n\r\nTeruskan usaha promosi anda untuk meraih lebih komisyen terhadap\r\nproduk kami.\r\n\r\nSekian, terima kasih.\r\n\r\nIkhlas,\r\n%%namaadmin%%\r\n%%domain%%', 'Salam sejahtera, %%namaagen%%\r\n\r\nTahniah! Pembayaran komisyen affiliate telah dilakukan \r\nke akaun anda.\r\n\r\nMaklumat pembayaran komisyen affiliate adalah seperti \r\nberikut:\r\n\r\n=========================================\r\nMaklumat Pembayaran Komisyen\r\n=========================================\r\n\r\nPromosi: %%namaproduk%%\r\nURL Jualan:  %%linkaffiliate%%\r\n\r\nID Affiliate Anda: %%idagen%%\r\nNama Anda: %%namaagen%%\r\n\r\nPemprosesan Bayaran: %%pemprosesanbayaran%%\r\nNo. Akaun: %%akaunbayaran%%\r\nPemegang Akaun (jika ada): %%pemilikakaun%%\r\n\r\nJumlah Komisyen Dibayar: %%currency%% %%jumlahkomisyenagen%%\r\nTarikh Bayaran Disahkan: %%tarikhbayaran%%\r\n\r\n=========================================\r\nMaklumat Akaun Affiliate Anda\r\n=========================================\r\n\r\nURL Login Affiliate:\r\n=> %%loginaffiliate%%\r\n\r\nID Affiliate Anda: %%idagen%%\r\nPassword Anda: (tidak dipaparkan)\r\n\r\nNOTA: Jika anda lupa password, sila pohon password \r\nbaru di halaman agen atau hubungi kami di %%emailsupport%%\r\n\r\nLink Promosi (Affiliate) Anda:\r\n=> %%linkaffiliate%%\r\n\r\n=========================================\r\n\r\nKami amat berbesar hati kerana telah berpeluang untuk\r\nbekerja sama dengan anda.\r\n\r\nRibuan terima kasih kami ucapkan kepada %%namaagen%% \r\nkerana telah mempromosikan produk kami.\r\n\r\nTeruskan usaha promosi yang %%namaagen%% jalankan dan raih\r\nlebih komisyen daripada kami.\r\n\r\nSekiranya %%namaagen%% mempunyai sebarang pertanyaan, sila\r\nhubungi kami di %%emailsupport%%\r\n\r\nSekian, terima kasih.\r\n\r\nIkhlas,\r\n%%namaadmin%%\r\n%%domain%%')";


// Data Table iklanadmin
$data_table_iklanadmin = "INSERT INTO iklanadmin (kandunganiklan) VALUES
('<p style=\"text-align: left;\">Dapatkan produk terkini daripada kami iaitu Pakej Sistem Affiliate. Klik banner dibawah untuk maklumat lanjut!</p>\r\n<p style=\"text-align: center;\">&nbsp;</p>\r\n<p style=\"text-align: center;\"><a href=\"http://www.sistemaffiliate.com/?aff_id=19\" target=\"_blank\"><img style=\"border: 0pt none;\" title=\"Pakej Sistem Affiliate Lite\" src=\"http://www.sistemaffiliate.com/images/banner468.gif\" alt=\"Sistem Affiliate Lite\" width=\"468\" height=\"60\" /></a></p>')";


// Data Table notisagen
$data_table_notisagen = "INSERT INTO notisagen (datetime, kandungannotis) VALUES
('07/03/2011 [01:53:40]', '<h1 style=\"text-align: center;\"><span style=\"color: #ff0000;\">Syarat &amp; Peraturan Program Affiliate</span></h1>\r\n<p style=\"text-align: center;\">&nbsp;</p>\r\n<p>Agen Affiliate DILARANG sama sekali melakukan SPAM. Jika didapati mana - mana ahli yang melakukan SPAM, maka keahlian akan ditamatkan serta - merta. Komisyen yang terkumpul tidak akan dibayar kepada ahli yang melakukan SPAM. Oleh itu, silalah mengamalkan teknik promosi yang baik dan beretika.&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>Untuk setiap jualan yang terhasil menerusi link affiliate agen, nilai komisyen seperti berikut akan diberikan:</p>\r\n<p>&nbsp;</p>\r\n<ol>\r\n<li>Produk A: RM30.00 Komisyen</li>\r\n<li>Produk B: RM40.00 Komisyen</li>\r\n<li>Produk C: RM50.00 Komisyen</li>\r\n</ol>\r\n<p>&nbsp;</p>\r\n<p>Pembayaran komisyen yang telah di SAHkan dan terkumpul akan dilakukan pada setiap hujung bulan. Pastikan agen membekalkan butiran peribadi yang tepat.</p>\r\n<p>&nbsp;</p>\r\n<p>3 TOP Affiliate akan menerima hadiah berikut:</p>\r\n<p>&nbsp;</p>\r\n<ol>\r\n<li>PSP + Wang Tunai RM1000.00</li>\r\n<li>Nokia N95 + Wang Tunai RM500.00</li>\r\n<li>HeadPhone + Wang Tunai RM100.00</li>\r\n</ol>\r\n<p>&nbsp;</p>\r\n<p>Selamat berpromosi!</p>\r\n<p>&nbsp;</p>\r\n<p>Ikhlas,</p>\r\n<p>Pengusaha.</p>')";


// Data Table optinadmin
$data_table_optinadmin = "INSERT INTO optinadmin (optincode) VALUES
('<form action=\"http://www.getresponse.com/cgi-bin/add.cgi\" method=\"post\" id=\"GRSubscribeForm\" accept-charset=\"UTF-8\">\r\n<fieldset>\r\n<table align=\"center\">\r\n<tr> \r\n								<td width=\"107\"><b>Nama: </b></td> \r\n<td width=\"143\">\r\n<input type=\"text\" name=\"category2\" size=\"25\" id=\"GRCategory2\" /></td>\r\n</tr>\r\n<tr>\r\n<td><b>Email: </b></td>\r\n								<td>\r\n<input type=\"text\" name=\"category3\" size=\"25\" id=\"GRCategory3\" /></td> \r\n	</tr> \r\n</table> \r\n<div align=\"center\"> \r\n<input type=\"submit\" value=\"Hantar Pendaftaran\" /> \r\n</div></fieldset> \r\n<input type=\"hidden\" name=\"category1\" value=\"peluanginternet\" /> \r\n<input type=\"hidden\" name=\"confirmation\" value=\"http://www.peluanginternet.com/confirm-your-data.shtml\" /> \r\n<input type=\"hidden\" name=\"error_page\" value=\"http://www.peluanginternet.com/xconfirm-your-data.shtml\" /> \r\n						<input type=\"hidden\" name=\"ref\" value=\"000\" /> \r\n<input type=\"hidden\" name=\"getpostdata\" value=\"get\" /> \r\n</form>')";


// Data Table produk
$data_table_produk = "INSERT INTO produk (idproduk, namaproduk, komisyenproduk) VALUES ('', 'Produk A - RM50.00', '25.00')";


// Data Table termadaftar
$data_table_termadaftar = "INSERT INTO termadaftar (kandunganterma) VALUES
('Saya sebagai bakal agen affiliate, telah BERSETUJU untuk mematuhi segala syarat dan terma program affiliate di laman web ini.\r\n\r\n1 .Saya faham bahawa sekiranya saya melanggar mana - mana syarat dan terma program affiliate ini, akaun saya boleh digantung ataupun dimansuhkan oleh pihak pengurusan tanpa sebarang notifikasi.\r\n\r\n2. Saya berjanji akan melakukan promosi secara beretika dan tidak akan sesekali melakukan aktiviti SPAM.\r\n\r\n3. Saya berjanji tidak akan menggunakan sebarang bahan promosi yang boleh merosakkan nama perniagaan laman web ini.\r\n\r\n4. Saya berjanji tidak akan menggunakan nama - nama organisasi, trademark, copyright, golongan professional dan apa jua bentuk nama yang dilindungi dalam aktiviti promosi saya.\r\n\r\n5. Saya mengakui bahawa segala butiran yang saya daftarkan di atas adalah butiran yang tepat dan sah.\r\n\r\nDengan menghantar butiran pendaftaran ini, saya akan tertakluk kepada syarat dan terma yang telah ditetapkan oleh pihak pengurusan laman web ini.')";

// Declare Message Text
$message = '';

if($_POST['installation_type'] == '')
{
	$message = '<p align="center">Please choose installation type (Upgrade OR Fresh Install).</p><p align="center">[ <a href="index.php">Click here to return to the installation page</a> ]</p>';
	include 'output.html.php';
}

// Select Type Of Installation - UPGRADE
if($_POST['installation_type'] == 'upgradescript')
{	
	// Connect to Selected Database
	$database_connection = mysql_connect($server, $db_user, $db_pass);
	if (!$database_connection)
	{
		$output = 'Unable to connect to the database server.';
		include 'output.html.php';
		exit();
	}
	if (!mysql_select_db($database, $database_connection))
	{
		$output = 'Unable to locate the affiliate database.';
		include 'output.html.php';
		exit();
	}

	// Check Table admin Existances
	$table_admin = mysql_query('SELECT * from admin', $database_connection);
	if (!$table_admin)
	{
		$create_table_admin = 'CREATE TABLE IF NOT EXISTS admin (
		id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  		user VARCHAR(30) NOT NULL,
		pass VARCHAR(50) NOT NULL,
		namaadmin VARCHAR(200) NOT NULL,
		emailadmin VARCHAR(200) NOT NULL,
		emailadminsupport VARCHAR(200) NOT NULL,
		emailadminpayment VARCHAR(200) NOT NULL,
		namaproduk VARCHAR(200) NOT NULL,
		domain VARCHAR(200) NOT NULL,
		folderaffiliates VARCHAR(200) NOT NULL,
		folderadmin VARCHAR(200) NOT NULL,
		domainredirect VARCHAR(200) NOT NULL,
		landingpage VARCHAR(200) NOT NULL,
		cookieExpiration VARCHAR(200) NOT NULL,
		cookieDomain VARCHAR(200) NOT NULL,
		cartatopaffiliate VARCHAR(100) NOT NULL,
		currency VARCHAR(100) NOT NULL,
		language VARCHAR(100) NOT NULL,
		idaffiliatePIS VARCHAR(100) NOT NULL,
		tahunoperasi VARCHAR(100) NOT NULL,
		onoffpendaftaran VARCHAR(30) NOT NULL,
		kodpendaftaran VARCHAR(30) NOT NULL,
		kodcaptchaborang VARCHAR(30) NOT NULL,
		affiliatetracking VARCHAR(1) NOT NULL,
		scriptcredit INT NOT NULL
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_admin, $database_connection);
		mysql_query($data_table_admin, $database_connection);
		$message .= '- Table admin has been added!<br />';
	}	
	
        // Check admin column id existance
	$table_admin_id = mysql_query('SELECT id from admin', $database_connection);
	if (!$table_admin_id)
	{
		$create_admin_column_id = 'ALTER TABLE admin ADD id INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST';
		
		mysql_query($create_admin_column_id, $database_connection);
		$message .= '* Column ID in admin table has been added!<br />';
	}
        
	// Check admin column user existance
	$table_admin_user = mysql_query('SELECT user from admin', $database_connection);
	if (!$table_admin_user)
	{
		$create_admin_column_user = 'ALTER TABLE admin ADD user VARCHAR(30) NOT NULL AFTER id';
		
		mysql_query($create_admin_column_user, $database_connection);
		$message .= '* Column user in admin table has been added!<br />';
	}
	
	// Check admin column pass existance
	$table_admin_pass = mysql_query('SELECT pass from admin', $database_connection);
	if (!$table_admin_pass)
	{
		$create_admin_column_pass = 'ALTER TABLE admin ADD pass VARCHAR(50) NOT NULL AFTER user';
		
		mysql_query($create_admin_column_pass, $database_connection);
		$message .=  '* Column pass in admin table has been added!<br />';
	}
	
	// Check admin column namaadmin existance
	$table_admin_namaadmin = mysql_query('SELECT namaadmin from admin', $database_connection);
	if (!$table_admin_namaadmin)
	{
		$create_admin_column_namaadmin = 'ALTER TABLE admin ADD namaadmin VARCHAR(200) NOT NULL AFTER pass';
		
		mysql_query($create_admin_column_namaadmin, $database_connection);
		$message .= '* Column namaadmin in admin table has been added!<br />';
	}
	
	// Check admin column emailadmin existance
	$table_admin_emailadmin = mysql_query('SELECT emailadmin from admin', $database_connection);
	if (!$table_admin_emailadmin)
	{
		$create_admin_column_emailadmin = 'ALTER TABLE admin ADD emailadmin VARCHAR(200) NOT NULL AFTER namaadmin';
		
		mysql_query($create_admin_column_emailadmin, $database_connection);
		$message .= '* Column emailadmin in admin table has been added!<br />';
	}
	
	// Check admin column emailadminsupport existance
	$table_admin_emailadminsupport = mysql_query('SELECT emailadminsupport from admin', $database_connection);
	if (!$table_admin_emailadminsupport)
	{
		$create_admin_column_emailadminsupport = 'ALTER TABLE admin ADD emailadminsupport VARCHAR(200) NOT NULL AFTER emailadmin';
		
		mysql_query($create_admin_column_emailadminsupport, $database_connection);
		$message .= '* Column emailadminsupport in admin table has been added!<br />';
	}
	
	// Check admin column emailadminpayment existance
	$table_admin_emailadminpayment = mysql_query('SELECT emailadminpayment from admin', $database_connection);
	if (!$table_admin_emailadminpayment)
	{
		$create_admin_column_emailadminpayment = 'ALTER TABLE admin ADD emailadminpayment VARCHAR(200) NOT NULL AFTER emailadminsupport';
		
		mysql_query($create_admin_column_emailadminpayment, $database_connection);
		$message .= '* Column emailadminpayment in admin table has been added!<br />';
	}
	
	// Check admin column namaproduk existance
	$table_admin_namaproduk = mysql_query('SELECT namaproduk from admin', $database_connection);
	if (!$table_admin_namaproduk)
	{
		$create_admin_column_namaproduk = 'ALTER TABLE admin ADD namaproduk VARCHAR(200) NOT NULL AFTER emailadminpayment';
		
		mysql_query($create_admin_column_namaproduk, $database_connection);
		$message .= '* Column namaproduk in admin table has been added!<br />';
	}
	
	// Check admin column domain existance
	$table_admin_domain = mysql_query('SELECT domain from admin', $database_connection);
	if (!$table_admin_domain)
	{
		$create_admin_column_domain = 'ALTER TABLE admin ADD domain VARCHAR(200) NOT NULL AFTER namaproduk';
		
		mysql_query($create_admin_column_domain, $database_connection);
		$message .= '* Column domain in admin table has been added!<br />';
	}
	
	// Check admin column folderaffiliates existance
	$table_admin_folderaffiliates = mysql_query('SELECT folderaffiliates from admin', $database_connection);
	if (!$table_admin_folderaffiliates)
	{
		$create_admin_column_folderaffiliates = 'ALTER TABLE admin ADD folderaffiliates VARCHAR(200) NOT NULL AFTER domain';
		
		mysql_query($create_admin_column_folderaffiliates, $database_connection);		
		$message .= '* Column folderaffiliates in admin table has been added!<br />';
	}
	
	// Check admin column folderadmin existance
	$table_admin_folderadmin = mysql_query('SELECT folderadmin from admin', $database_connection);
	if (!$table_admin_folderadmin)
	{
		$create_admin_column_folderadmin = 'ALTER TABLE admin ADD folderadmin VARCHAR(200) NOT NULL AFTER folderaffiliates';
		
		mysql_query($create_admin_column_folderadmin, $database_connection);
		$message .= '* Column folderadmin in admin table has been added!<br />';
	}
	
	// Check admin column domainredirect existance
	$table_admin_domainredirect = mysql_query('SELECT domainredirect from admin', $database_connection);
	if (!$table_admin_domainredirect)
	{
		$create_admin_column_domainredirect = 'ALTER TABLE admin ADD domainredirect VARCHAR(200) NOT NULL AFTER folderadmin';
		
		mysql_query($create_admin_column_domainredirect, $database_connection);
		$message .= '* Column domainredirect in admin table has been added!<br />';
	}
	
	// Check admin column landingpage existance
	$table_admin_landingpage = mysql_query('SELECT landingpage from admin', $database_connection);
	if (!$table_admin_landingpage)
	{
		$create_admin_column_landingpage = 'ALTER TABLE admin ADD landingpage VARCHAR(200) NOT NULL AFTER domainredirect';
		
		mysql_query($create_admin_column_landingpage, $database_connection);
		$message .= '* Column landingpage in admin table has been added!<br />';
	}
	
	// Check admin column cookieExpiration existance
	$table_admin_cookieExpiration = mysql_query('SELECT cookieExpiration from admin', $database_connection);
	if (!$table_admin_cookieExpiration)
	{
		$create_admin_column_cookieExpiration = 'ALTER TABLE admin ADD cookieExpiration VARCHAR(200) NOT NULL AFTER landingpage';
		
		mysql_query($create_admin_column_cookieExpiration, $database_connection);
		$message .= '* Column cookieExpiration in admin table has been added!<br />';
	}
	
	// Check admin column cookieDomain existance
	$table_admin_cookieDomain = mysql_query('SELECT cookieDomain from admin', $database_connection);
	if (!$table_admin_cookieDomain)
	{
		$create_admin_column_cookieDomain = 'ALTER TABLE admin ADD cookieDomain VARCHAR(200) NOT NULL AFTER cookieExpiration';
		
		mysql_query($create_admin_column_cookieDomain, $database_connection);
		$message .= '* Column cookieDomain in admin table has been added!<br />';
	}
	
	// Check admin column cartatopaffiliate existance
	$table_admin_cartatopaffiliate = mysql_query('SELECT cartatopaffiliate from admin', $database_connection);
	if (!$table_admin_cartatopaffiliate)
	{
		$create_admin_column_cartatopaffiliate = 'ALTER TABLE admin ADD cartatopaffiliate VARCHAR(200) NOT NULL AFTER cookieDomain';
		
		mysql_query($create_admin_column_cartatopaffiliate, $database_connection);
		$message .= '* Column cartatopaffiliate in admin table has been added!<br />';
	}	
	
	// Check admin column currency existance
	$table_admin_currency = mysql_query('SELECT currency from admin', $database_connection);
	if (!$table_admin_currency)
	{
		$create_admin_column_currency = 'ALTER TABLE admin ADD currency VARCHAR(200) NOT NULL AFTER cartatopaffiliate';
		
		mysql_query($create_admin_column_currency, $database_connection);
		$message .= '* Column currency in admin table has been added!<br />';
	}
	
	// Check admin column language existance
	$table_admin_language = mysql_query('SELECT language from admin', $database_connection);
	if (!$table_admin_language)
	{
		$create_admin_column_language = 'ALTER TABLE admin ADD language VARCHAR(200) NOT NULL AFTER currency';
		
		mysql_query($create_admin_column_language, $database_connection);
		$message .= '* Column language in admin table has been added!<br />';
	}
	
	// Check admin column idaffiliatePIS existance
	$table_admin_idaffiliatePIS = mysql_query('SELECT idaffiliatePIS from admin', $database_connection);
	if (!$table_admin_idaffiliatePIS)
	{
		$create_admin_column_idaffiliatePIS = 'ALTER TABLE admin ADD idaffiliatePIS VARCHAR(200) NOT NULL AFTER language';
		
		mysql_query($create_admin_column_idaffiliatePIS, $database_connection);
		$message .= '* Column idaffiliatePIS in admin table has been added!<br />';
	}
	
	// Check admin column tahunoperasi existance
	$table_admin_tahunoperasi = mysql_query('SELECT tahunoperasi from admin', $database_connection);
	if (!$table_admin_tahunoperasi)
	{
		$create_admin_column_tahunoperasi = 'ALTER TABLE admin ADD tahunoperasi VARCHAR(200) NOT NULL AFTER idaffiliatePIS';
		
		mysql_query($create_admin_column_tahunoperasi, $database_connection);
		$message .= '* Column tahunoperasi in admin table has been added!<br />';
	}
	
	// Check admin column onoffpendaftaran existance
	$table_admin_onoffpendaftaran = mysql_query('SELECT onoffpendaftaran from admin', $database_connection);
	if (!$table_admin_onoffpendaftaran)
	{
		$create_admin_column_onoffpendaftaran = 'ALTER TABLE admin ADD onoffpendaftaran VARCHAR(200) NOT NULL AFTER tahunoperasi';
		
		mysql_query($create_admin_column_onoffpendaftaran, $database_connection);
		$message .= '* Column onoffpendaftaran in admin table has been added!<br />';
	}
	
	// Check admin column kodpendaftaran existance
	$table_admin_kodpendaftaran = mysql_query('SELECT kodpendaftaran from admin', $database_connection);
	if (!$table_admin_kodpendaftaran)
	{
		$create_admin_column_kodpendaftaran = 'ALTER TABLE admin ADD kodpendaftaran VARCHAR(200) NOT NULL AFTER onoffpendaftaran';
		
		mysql_query($create_admin_column_kodpendaftaran, $database_connection);
		$message .= '* Column kodpendaftaran in admin table has been added!<br />';
	}
	
	// Check admin column kodcaptchaborang existance
	$table_admin_kodcaptchaborang = mysql_query('SELECT kodcaptchaborang from admin', $database_connection);
	if (!$table_admin_kodcaptchaborang)
	{
		$create_admin_column_kodcaptchaborang = 'ALTER TABLE admin ADD kodcaptchaborang VARCHAR(200) NOT NULL AFTER kodpendaftaran';
		
		mysql_query($create_admin_column_kodcaptchaborang, $database_connection);
		$message .= '* Column kodcaptchaborang in admin table has been added!<br />';
	}
	
	// Check admin column scriptcredit existance
	$table_admin_affiliatetracking = mysql_query('SELECT affiliatetracking from admin', $database_connection);
	if (!$table_admin_affiliatetracking)
	{
		$create_admin_column_affiliatetracking = 'ALTER TABLE admin ADD affiliatetracking VARCHAR(1) NOT NULL AFTER kodcaptchaborang';		
		
		mysql_query($create_admin_column_affiliatetracking, $database_connection);
		$message .= '* Column affiliatetracking in admin table has been added!<br />';
	}
	
	// Check admin column scriptcredit existance
	$table_admin_scriptcredit = mysql_query('SELECT scriptcredit from admin', $database_connection);
	if (!$table_admin_scriptcredit)
	{
		$create_admin_column_scriptcredit = 'ALTER TABLE admin ADD scriptcredit INT NOT NULL AFTER affiliatetracking';		
		
		mysql_query($create_admin_column_scriptcredit, $database_connection);
		$message .= '* Column scriptcredit in admin table has been added!<br />';
	}
	
	
	// Check Table affiliates Existances
	$table_affiliates = mysql_query('SELECT * from affiliates', $database_connection);
	if (!$table_affiliates)
	{
		$create_table_affiliates = 'CREATE TABLE IF NOT EXISTS affiliates (
		id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  		refid VARCHAR(30) NOT NULL,
 		pass VARCHAR(50) NOT NULL,
  		title VARCHAR(10) NOT NULL,
	  	firstname VARCHAR(50) NOT NULL,
		lastname VARCHAR(50) NOT NULL,
		email VARCHAR(100) NOT NULL,
		website VARCHAR(100) NOT NULL,
		street VARCHAR(200) NOT NULL,
		town VARCHAR(200) NOT NULL,
		county VARCHAR(200) NOT NULL,
		postcode VARCHAR(20) NOT NULL,
		country VARCHAR(200) NOT NULL,
		phone VARCHAR(30) NOT NULL,
		processor VARCHAR(200) NOT NULL,
		account VARCHAR(200) NOT NULL,
		payto VARCHAR(200) NOT NULL,
		date VARCHAR(40) NOT NULL,
		ipaddress VARCHAR(100) NOT NULL,
		upline VARCHAR(30) NOT NULL,
		KEY email (email)
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_affiliates, $database_connection);
		mysql_query($data_table_affiliates, $database_connection);
		$message .= '- Table affiliates has been added!<br />';
	}
        
        // Check affiliates column id existance
	$table_affiliates_id = mysql_query('SELECT id from affiliates', $database_connection);
	if (!$table_affiliates_id)
	{
		$create_affiliates_column_id = 'ALTER TABLE affiliates ADD id INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST';
		
		mysql_query($create_affiliates_column_id, $database_connection);
		$message .= '* Column ID in affiliates table has been added!<br />';
	}
	
	// Check affiliates column refid existance
	$table_affiliates_refid = mysql_query('SELECT refid from affiliates', $database_connection);
	if (!$table_affiliates_refid)
	{
		$create_affiliates_column_refid = 'ALTER TABLE affiliates ADD refid VARCHAR(30) NOT NULL AFTER id';
		
		mysql_query($create_affiliates_column_refid, $database_connection);
		$message .= '* Column refid in affiliates table has been added!<br />';
	}
	
	// Check affiliates column pass existance
	$table_affiliates_pass = mysql_query('SELECT pass from affiliates', $database_connection);
	if (!$table_affiliates_pass)
	{
		$create_affiliates_column_pass = 'ALTER TABLE affiliates ADD pass VARCHAR(50) NOT NULL AFTER refid';
		
		mysql_query($create_affiliates_column_pass, $database_connection);
		$message .= '* Column pass in affiliates table has been added!<br />';
	}
	
	// Check affiliates column title existance
	$table_affiliates_title = mysql_query('SELECT title from affiliates', $database_connection);
	if (!$table_affiliates_title)
	{
		$create_affiliates_column_title = 'ALTER TABLE affiliates ADD title VARCHAR(10) NOT NULL AFTER pass';
		
		mysql_query($create_affiliates_column_title, $database_connection);
		$message .= '* Column title in affiliates table has been added!<br />';
	}
	
	// Check affiliates column firstname existance
	$table_affiliates_firstname = mysql_query('SELECT firstname from affiliates', $database_connection);
	if (!$table_affiliates_firstname)
	{
		$create_affiliates_column_firstname = 'ALTER TABLE affiliates ADD firstname VARCHAR(50) NOT NULL AFTER title';
		
		mysql_query($create_affiliates_column_firstname, $database_connection);
		$message .= '* Column firstname in affiliates table has been added!<br />';
	}
	
	// Check affiliates column lastname existance
	$table_affiliates_lastname = mysql_query('SELECT lastname from affiliates', $database_connection);
	if (!$table_affiliates_lastname)
	{
		$create_affiliates_column_lastname = 'ALTER TABLE affiliates ADD lastname VARCHAR(50) NOT NULL AFTER firstname';
		
		mysql_query($create_affiliates_column_lastname, $database_connection);
		$message .= '* Column lastname in affiliates table has been added!<br />';
	}
	
	// Check affiliates column email existance
	$table_affiliates_email = mysql_query('SELECT email from affiliates', $database_connection);
	if (!$table_affiliates_email)
	{
		$create_affiliates_column_email = 'ALTER TABLE affiliates ADD email VARCHAR(100) NOT NULL AFTER lastname';
		
		mysql_query($create_affiliates_column_email, $database_connection);
		$message .= '* Column email in affiliates table has been added!<br />';
	}
	
	// Check affiliates column website existance
	$table_affiliates_website = mysql_query('SELECT website from affiliates', $database_connection);
	if (!$table_affiliates_website)
	{
		$create_affiliates_column_website = 'ALTER TABLE affiliates ADD website VARCHAR(100) NOT NULL AFTER email';
		
		mysql_query($create_affiliates_column_website, $database_connection);
		$message .= '* Column website in affiliates table has been added!<br />';
	}
	
	// Check affiliates column street existance
	$table_affiliates_street = mysql_query('SELECT street from affiliates', $database_connection);
	if (!$table_affiliates_street)
	{
		$create_affiliates_column_street = 'ALTER TABLE affiliates ADD street VARCHAR(200) NOT NULL AFTER website';
		
		mysql_query($create_affiliates_column_street, $database_connection);
		$message .= '* Column street in affiliates table has been added!<br />';
	}
	
	// Check affiliates column town existance
	$table_affiliates_town = mysql_query('SELECT town from affiliates', $database_connection);
	if (!$table_affiliates_town)
	{
		$create_affiliates_column_town = 'ALTER TABLE affiliates ADD town VARCHAR(200) NOT NULL AFTER street';
		
		mysql_query($create_affiliates_column_town, $database_connection);
		$message .= '* Column town in affiliates table has been added!<br />';
	}
	
	// Check affiliates column county existance
	$table_affiliates_county = mysql_query('SELECT county from affiliates', $database_connection);
	if (!$table_affiliates_county)
	{
		$create_affiliates_column_county = 'ALTER TABLE affiliates ADD county VARCHAR(200) NOT NULL AFTER town';
		
		mysql_query($create_affiliates_column_county, $database_connection);
		$message .= '* Column county in affiliates table has been added!<br />';
	}
	
	// Check affiliates column postcode existance
	$table_affiliates_postcode = mysql_query('SELECT postcode from affiliates', $database_connection);
	if (!$table_affiliates_postcode)
	{
		$create_affiliates_column_postcode = 'ALTER TABLE affiliates ADD postcode VARCHAR(20) NOT NULL AFTER county';
		
		mysql_query($create_affiliates_column_postcode, $database_connection);
		$message .= '* Column postcode in affiliates table has been added!<br />';
	}
	
	// Check affiliates column country existance
	$table_affiliates_country = mysql_query('SELECT country from affiliates', $database_connection);
	if (!$table_affiliates_country)
	{
		$create_affiliates_column_country = 'ALTER TABLE affiliates ADD country VARCHAR(200) NOT NULL AFTER postcode';
		
		mysql_query($create_affiliates_column_country, $database_connection);
		$message .= '* Column country in affiliates table has been added!<br />';
	}
	
	// Check affiliates column phone existance
	$table_affiliates_phone = mysql_query('SELECT phone from affiliates', $database_connection);
	if (!$table_affiliates_phone)
	{
		$create_affiliates_column_phone = 'ALTER TABLE affiliates ADD phone VARCHAR(30) NOT NULL AFTER country';
		
		mysql_query($create_affiliates_column_phone, $database_connection);
		$message .= '* Column phone in affiliates table has been added!<br />';
	}
	
	// Check affiliates column processor existance
	$table_affiliates_processor = mysql_query('SELECT processor from affiliates', $database_connection);
	if (!$table_affiliates_processor)
	{
		$create_affiliates_column_processor = 'ALTER TABLE affiliates ADD processor VARCHAR(200) NOT NULL AFTER phone';
		
		mysql_query($create_affiliates_column_processor, $database_connection);
		$message .= '* Column processor in affiliates table has been added!<br />';
	}
	
	// Check affiliates column account existance
	$table_affiliates_account = mysql_query('SELECT account from affiliates', $database_connection);
	if (!$table_affiliates_account)
	{
		$create_affiliates_column_account = 'ALTER TABLE affiliates ADD account VARCHAR(200) NOT NULL AFTER processor';
		
		mysql_query($create_affiliates_column_account, $database_connection);
		$message .= '* Column account in affiliates table has been added!<br />';
	}
	
	// Check affiliates column payto existance
	$table_affiliates_payto = mysql_query('SELECT payto from affiliates', $database_connection);
	if (!$table_affiliates_payto)
	{
		$create_affiliates_column_payto = 'ALTER TABLE affiliates ADD payto VARCHAR(200) NOT NULL AFTER account';
		
		mysql_query($create_affiliates_column_payto, $database_connection);
		$message .= '* Column payto in affiliates table has been added!<br />';
	}
	
	// Check affiliates column date existance
	$table_affiliates_date = mysql_query('SELECT date from affiliates', $database_connection);
	if (!$table_affiliates_date)
	{
		$create_affiliates_column_date = 'ALTER TABLE affiliates ADD date VARCHAR(40) NOT NULL AFTER payto';
		
		mysql_query($create_affiliates_column_date, $database_connection);
		$message .= '* Column date in affiliates table has been added!<br />';
	}
	
	// Check affiliates column ipaddress existance
	$table_affiliates_ipaddress = mysql_query('SELECT ipaddress from affiliates', $database_connection);
	if (!$table_affiliates_ipaddress)
	{
		$create_affiliates_column_ipaddress = 'ALTER TABLE affiliates ADD ipaddress VARCHAR(100) NOT NULL AFTER date';
		
		mysql_query($create_affiliates_column_ipaddress, $database_connection);
		$message .= '* Column ipaddress in affiliates table has been added!<br />';
	}
	
	// Check affiliates column upline existance
	$table_affiliates_upline = mysql_query('SELECT upline from affiliates', $database_connection);
	if (!$table_affiliates_upline)
	{
		$create_affiliates_column_upline = 'ALTER TABLE affiliates ADD upline VARCHAR(30) NOT NULL AFTER ipaddress';
		
		mysql_query($create_affiliates_column_upline, $database_connection);
		$message .= '* Column upline in affiliates table has been added!<br />';
	}
	
	
	// Check Table artikelpromosi Existances
	$table_artikelpromosi = mysql_query('SELECT * from artikelpromosi', $database_connection);
	if (!$table_artikelpromosi)
	{
		$create_table_artikelpromosi = 'CREATE TABLE IF NOT EXISTS artikelpromosi (
  		number INT(5) NOT NULL auto_increment,
		arahan VARCHAR(200) NOT NULL,
		tajuk VARCHAR(200) NOT NULL,
		kandungan MEDIUMTEXT NOT NULL,
		PRIMARY KEY (number)
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_artikelpromosi, $database_connection);
		$message .= '- Table artikelpromosi has been added!<br />';
	}
	
	// Check artikelpromosi column number existance
	$table_artikelpromosi_number = mysql_query('SELECT number from artikelpromosi', $database_connection);
	if (!$table_artikelpromosi_number)
	{
		$create_artikelpromosi_column_number = 'ALTER TABLE artikelpromosi ADD number INT(5) AUTO_INCREMENT PRIMARY KEY FIRST';
		
		mysql_query($create_artikelpromosi_column_number, $database_connection);
		$message .= '* Column number in artikelpromosi table has been added!<br />';
	}
	
	// Check artikelpromosi column arahan existance
	$table_artikelpromosi_arahan = mysql_query('SELECT arahan from artikelpromosi', $database_connection);
	if (!$table_artikelpromosi_arahan)
	{
		$create_artikelpromosi_column_arahan = 'ALTER TABLE artikelpromosi ADD arahan VARCHAR(200) NOT NULL AFTER number';
		
		mysql_query($create_artikelpromosi_column_arahan, $database_connection);
		$message .= '* Column arahan in artikelpromosi table has been added!<br />';
	}
	
	// Check artikelpromosi column tajuk existance
	$table_artikelpromosi_tajuk = mysql_query('SELECT tajuk from artikelpromosi', $database_connection);
	if (!$table_artikelpromosi_tajuk)
	{
		$create_artikelpromosi_column_tajuk = 'ALTER TABLE artikelpromosi ADD tajuk VARCHAR(200) NOT NULL AFTER arahan';
		
		mysql_query($create_artikelpromosi_column_tajuk, $database_connection);
		$message .= '* Column tajuk in artikelpromosi table has been added!<br />';
	}
	
	// Check artikelpromosi column kandungan existance
	$table_artikelpromosi_kandungan = mysql_query('SELECT kandungan from artikelpromosi', $database_connection);
	if (!$table_artikelpromosi_kandungan)
	{
		$create_artikelpromosi_column_kandungan = 'ALTER TABLE artikelpromosi ADD kandungan MEDIUMTEXT NOT NULL AFTER tajuk';
		
		mysql_query($create_artikelpromosi_column_kandungan, $database_connection);
		$message .= '* Column kandungan in artikelpromosi table has been added!<br />';
	}
	
	
	// Check Table banners Existances
	$table_banners = mysql_query('SELECT * from banners', $database_connection);
	if (!$table_banners)
	{
		$create_table_banners = 'CREATE TABLE IF NOT EXISTS banners (
  		number INT(5) NOT NULL auto_increment,
		name VARCHAR(200) NOT NULL,
		image VARCHAR(200) NOT NULL,
		description VARCHAR(200) NOT NULL,
		PRIMARY KEY (number)
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_banners, $database_connection);
		$message .= '- Table banners has been added!<br />';
	}
	
	// Check banners column number existance
	$table_banners_number = mysql_query('SELECT number from banners', $database_connection);
	if (!$table_banners_number)
	{
		$create_banners_column_number = 'ALTER TABLE banners ADD number INT(5) AUTO_INCREMENT PRIMARY KEY FIRST';
		
		mysql_query($create_banners_column_number, $database_connection);
		$message .= '* Column number in banners table has been added!<br />';
	}
	
	// Check banners column name existance
	$table_banners_name = mysql_query('SELECT name from banners', $database_connection);
	if (!$table_banners_name)
	{
		$create_banners_column_name = 'ALTER TABLE banners ADD name VARCHAR(200) NOT NULL AFTER number';
		
		mysql_query($create_banners_column_name, $database_connection);
		$message .= '* Column name in banners table has been added!<br />';
	}
	
	// Check banners column image existance
	$table_banners_image = mysql_query('SELECT image from banners', $database_connection);
	if (!$table_banners_image)
	{
		$create_banners_column_image = 'ALTER TABLE banners ADD image VARCHAR(200) NOT NULL AFTER name';
		
		mysql_query($create_banners_column_image, $database_connection);
		$message .= '* Column image in banners table has been added!<br />';
	}
	
	// Check banners column description existance
	$table_banners_description = mysql_query('SELECT description from banners', $database_connection);
	if (!$table_banners_description)
	{
		$create_banners_column_description = 'ALTER TABLE banners ADD description VARCHAR(200) NOT NULL AFTER image';
		
		mysql_query($create_banners_column_description, $database_connection);
		$message .= '* Column description in banners table has been added!<br />';
	}
	
	
	// Check Table beritaagen Existances
	$table_beritaagen = mysql_query('SELECT * from beritaagen', $database_connection);
	if (!$table_beritaagen)
	{
		$create_table_beritaagen = 'CREATE TABLE IF NOT EXISTS beritaagen (
  		idberita INT(5) NOT NULL auto_increment,
		tarikhberita VARCHAR(200) NOT NULL,
		tajukberita VARCHAR(200) NOT NULL,
		kandunganberita MEDIUMTEXT NOT NULL,
		PRIMARY KEY (idberita)
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_beritaagen, $database_connection);
		$message .= '- Table beritaagen has been added!<br />';
	}
	
	// Check beritaagen column idberita existance
	$table_beritaagen_idberita = mysql_query('SELECT idberita from beritaagen', $database_connection);
	if (!$table_beritaagen_idberita)
	{
		$create_beritaagen_column_idberita = 'ALTER TABLE beritaagen ADD idberita INT(5) AUTO_INCREMENT PRIMARY KEY FIRST';
		
		mysql_query($create_beritaagen_column_idberita, $database_connection);
		$message .= '* Column idberita in beritaagen table has been added!<br />';
	}
	
	// Check beritaagen column tarikhberita existance
	$table_beritaagen_tarikhberita = mysql_query('SELECT tarikhberita from beritaagen', $database_connection);
	if (!$table_beritaagen_tarikhberita)
	{
		$create_beritaagen_column_tarikhberita = 'ALTER TABLE beritaagen ADD tarikhberita VARCHAR(200) NOT NULL AFTER idberita';
		
		mysql_query($create_beritaagen_column_tarikhberita, $database_connection);
		$message .= '* Column tarikhberita in beritaagen table has been added!<br />';
	}
	
	// Check beritaagen column tajukberita existance
	$table_beritaagen_tajukberita = mysql_query('SELECT tajukberita from beritaagen', $database_connection);
	if (!$table_beritaagen_tajukberita)
	{
		$create_beritaagen_column_tajukberita = 'ALTER TABLE beritaagen ADD tajukberita VARCHAR(200) NOT NULL AFTER tarikhberita';
		
		mysql_query($create_beritaagen_column_tajukberita, $database_connection);
		$message .= '* Column tajukberita in beritaagen table has been added!<br />';
	}
	
	// Check beritaagen column kandunganberita existance
	$table_beritaagen_kandunganberita = mysql_query('SELECT kandunganberita from beritaagen', $database_connection);
	if (!$table_beritaagen_kandunganberita)
	{
		$create_beritaagen_column_kandunganberita = 'ALTER TABLE beritaagen ADD kandunganberita MEDIUMTEXT NOT NULL AFTER tajukberita';
		
		mysql_query($create_beritaagen_column_kandunganberita, $database_connection);
		$message .= '* Column kandunganberita in beritaagen table has been added!<br />';
	}
	
	
	// Check Table clickthroughs Existances
	$table_clickthroughs = mysql_query('SELECT * from clickthroughs', $database_connection);
	if (!$table_clickthroughs)
	{
		$create_table_clickthroughs = "CREATE TABLE IF NOT EXISTS clickthroughs (
		refid VARCHAR(30) NOT NULL,
		date date NOT NULL default '0000-00-00',
		time time NOT NULL default '00:00:00',
		browser VARCHAR(250) NOT NULL,
		ipaddress VARCHAR(50) NOT NULL,
		refferalurl VARCHAR(250) NOT NULL
		) DEFAULT CHARACTER SET utf8";
		
		mysql_query($create_table_clickthroughs, $database_connection);
		$message .= '- Table clickthroughs has been added!<br />';
	}
	
	// Check clickthroughs column refid existance
	$table_clickthroughs_refid = mysql_query('SELECT refid from clickthroughs', $database_connection);
	if (!$table_clickthroughs_refid)
	{
		$create_clickthroughs_column_refid = 'ALTER TABLE clickthroughs ADD refid VARCHAR(30) NOT NULL FIRST';
		
		mysql_query($create_clickthroughs_column_refid, $database_connection);
		$message .= '* Column refid in clickthroughs table has been added!<br />';
	}
	
	// Check clickthroughs column date existance
	$table_clickthroughs_date = mysql_query('SELECT date from clickthroughs', $database_connection);
	if (!$table_clickthroughs_date)
	{
		$create_clickthroughs_column_date = "ALTER TABLE clickthroughs ADD date DATE NOT NULL DEFAULT '0000-00-00' AFTER refid";
		
		mysql_query($create_clickthroughs_column_date, $database_connection);
		$message .= '* Column date in clickthroughs table has been added!<br />';
	}
	
	// Check clickthroughs column time existance
	$table_clickthroughs_time = mysql_query('SELECT time from clickthroughs', $database_connection);
	if (!$table_clickthroughs_time)
	{
		$create_clickthroughs_column_time = "ALTER TABLE clickthroughs ADD time TIME NOT NULL DEFAULT '00:00:00' AFTER date";
		
		mysql_query($create_clickthroughs_column_time, $database_connection);
		$message .= '* Column time in clickthroughs table has been added!<br />';
	}
	
	// Check clickthroughs column browser existance
	$table_clickthroughs_browser = mysql_query('SELECT browser from clickthroughs', $database_connection);
	if (!$table_clickthroughs_browser)
	{
		$create_clickthroughs_column_browser = 'ALTER TABLE clickthroughs ADD browser VARCHAR(250) NOT NULL AFTER time';
		
		mysql_query($create_clickthroughs_column_browser, $database_connection);
		$message .= '* Column browser in clickthroughs table has been added!<br />';
	}
	
	// Check clickthroughs column ipaddress existance
	$table_clickthroughs_ipaddress = mysql_query('SELECT ipaddress from clickthroughs', $database_connection);
	if (!$table_clickthroughs_ipaddress)
	{
		$create_clickthroughs_column_ipaddress = 'ALTER TABLE clickthroughs ADD ipaddress VARCHAR(50) NOT NULL AFTER browser';
		
		mysql_query($create_clickthroughs_column_ipaddress, $database_connection);
		$message .= '* Column ipaddress in clickthroughs table has been added!<br />';
	}
	
	// Check clickthroughs column refferalurl existance
	$table_clickthroughs_refferalurl = mysql_query('SELECT refferalurl from clickthroughs', $database_connection);
	if (!$table_clickthroughs_refferalurl)
	{
		$create_clickthroughs_column_refferalurl = 'ALTER TABLE clickthroughs ADD refferalurl VARCHAR(250) NOT NULL AFTER ipaddress';
		
		mysql_query($create_clickthroughs_column_refferalurl, $database_connection);
		$message .= '* Column refferalurl in clickthroughs table has been added!<br />';
	}
	
	
	// Check Table emailadmin Existances
	$table_emailadmin = mysql_query('SELECT * from emailadmin', $database_connection);
	if (!$table_emailadmin)
	{
		$create_table_emailadmin = 'CREATE TABLE IF NOT EXISTS emailadmin (
		emaildaftar longtext,
		emailpengesahan longtext,
		emailpengesahanadmin longtext,
		emailpassworduser longtext,
		emailpassworduserreset longtext,
		emailsahkomisyen longtext,
		emailbayarkomisyen longtext
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_emailadmin, $database_connection);
		mysql_query($data_table_emailadmin, $database_connection);
		$message .= '- Table emailadmin has been added!<br />';
	}
	
	// Check emailadmin column emaildaftar existance
	$table_emailadmin_emaildaftar = mysql_query('SELECT emaildaftar from emailadmin', $database_connection);
	if (!$table_emailadmin_emaildaftar)
	{
		$create_emailadmin_column_emaildaftar = 'ALTER TABLE emailadmin ADD emaildaftar LONGTEXT FIRST';
		
		mysql_query($create_emailadmin_column_emaildaftar, $database_connection);
		$message .= '* Column emaildaftar in emailadmin table has been added!<br />';
	}
	
	// Check emailadmin column emailpengesahan existance
	$table_emailadmin_emailpengesahan = mysql_query('SELECT emailpengesahan from emailadmin', $database_connection);
	if (!$table_emailadmin_emailpengesahan)
	{
		$create_emailadmin_column_emailpengesahan = 'ALTER TABLE emailadmin ADD emailpengesahan LONGTEXT AFTER emaildaftar';
		
		mysql_query($create_emailadmin_column_emailpengesahan, $database_connection);
		$message .= '* Column emailpengesahan in emailadmin table has been added!<br />';
	}
	
	// Check emailadmin column emailpengesahanadmin existance
	$table_emailadmin_emailpengesahanadmin = mysql_query('SELECT emailpengesahanadmin from emailadmin', $database_connection);
	if (!$table_emailadmin_emailpengesahanadmin)
	{
		$create_emailadmin_column_emailpengesahanadmin = 'ALTER TABLE emailadmin ADD emailpengesahanadmin LONGTEXT AFTER emailpengesahan';
		
		mysql_query($create_emailadmin_column_emailpengesahanadmin, $database_connection);
		$message .= '* Column emailpengesahanadmin in emailadmin table has been added!<br />';
	}
	
	// Check emailadmin column emailpassworduser existance
	$table_emailadmin_emailpassworduser = mysql_query('SELECT emailpassworduser from emailadmin', $database_connection);
	if (!$table_emailadmin_emailpassworduser)
	{
		$create_emailadmin_column_emailpassworduser = 'ALTER TABLE emailadmin ADD emailpassworduser LONGTEXT AFTER emailpengesahanadmin';
		
		mysql_query($create_emailadmin_column_emailpassworduser, $database_connection);
		$message .= '* Column emailpassworduser in emailadmin table has been added!<br />';
	}
	
	// Check emailadmin column emailpassworduserreset existance
	$table_emailadmin_emailpassworduserreset = mysql_query('SELECT emailpassworduserreset from emailadmin', $database_connection);
	if (!$table_emailadmin_emailpassworduserreset)
	{
		$create_emailadmin_column_emailpassworduserreset = 'ALTER TABLE emailadmin ADD emailpassworduserreset LONGTEXT AFTER emailpassworduser';
		
		mysql_query($create_emailadmin_column_emailpassworduserreset, $database_connection);
		$message .= '* Column emailpassworduserreset in emailadmin table has been added!<br />';
	}
	
	// Check emailadmin column emailsahkomisyen existance
	$table_emailadmin_emailsahkomisyen = mysql_query('SELECT emailsahkomisyen from emailadmin', $database_connection);
	if (!$table_emailadmin_emailsahkomisyen)
	{
		$create_emailadmin_column_emailsahkomisyen = 'ALTER TABLE emailadmin ADD emailsahkomisyen LONGTEXT AFTER emailpassworduserreset';
		
		mysql_query($create_emailadmin_column_emailsahkomisyen, $database_connection);
		$message .= '* Column emailsahkomisyen in emailadmin table has been added!<br />';
	}
	
	// Check emailadmin column emailbayarkomisyen existance
	$table_emailadmin_emailbayarkomisyen = mysql_query('SELECT emailbayarkomisyen from emailadmin', $database_connection);
	if (!$table_emailadmin_emailbayarkomisyen)
	{
		$create_emailadmin_column_emailbayarkomisyen = 'ALTER TABLE emailadmin ADD emailbayarkomisyen LONGTEXT AFTER emailsahkomisyen';
		
		mysql_query($create_emailadmin_column_emailbayarkomisyen, $database_connection);
		$message .= '* Column emailbayarkomisyen in emailadmin table has been added!<br />';
	}
	
	
	// Check Table iklanadmin Existances
	$table_iklanadmin = mysql_query('SELECT * from iklanadmin', $database_connection);
	if (!$table_iklanadmin)
	{
		$create_table_iklanadmin = 'CREATE TABLE IF NOT EXISTS iklanadmin (
		kandunganiklan MEDIUMTEXT NOT NULL
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_iklanadmin, $database_connection);
		mysql_query($data_table_iklanadmin, $database_connection);
		$message .= '- Table iklanadmin has been added!<br />';
	}
	
	// Check iklanadmin column kandunganiklan existance
	$table_iklanadmin_kandunganiklan = mysql_query('SELECT kandunganiklan from iklanadmin', $database_connection);
	if (!$table_iklanadmin_kandunganiklan)
	{
		$create_iklanadmin_column_kandunganiklan = 'ALTER TABLE iklanadmin ADD kandunganiklan MEDIUMTEXT NOT NULL FIRST';
		
		mysql_query($create_iklanadmin_column_kandunganiklan, $database_connection);
		$message .= '* Column kandunganiklan in iklanadmin table has been added!<br />';
	}
	
	
	// Check Table notisagen Existances
	$table_notisagen = mysql_query('SELECT * from notisagen', $database_connection);
	if (!$table_notisagen)
	{
		$create_table_notisagen = 'CREATE TABLE IF NOT EXISTS notisagen (
		datetime VARCHAR(100) NOT NULL,
		kandungannotis MEDIUMTEXT NOT NULL
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_notisagen, $database_connection);
		mysql_query($data_table_notisagen, $database_connection);
		$message .= '- Table notisagen has been added!<br />';
	}
	
	// Check notisagen column datetime existance
	$table_notisagen_datetime = mysql_query('SELECT datetime from notisagen', $database_connection);
	if (!$table_notisagen_datetime)
	{
		$create_notisagen_column_datetime = 'ALTER TABLE notisagen ADD datetime VARCHAR(100) NOT NULL FIRST';
		
		mysql_query($create_notisagen_column_datetime, $database_connection);
		$message .= '* Column datetime in notisagen table has been added!<br />';
	}
	
	// Check notisagen column kandungannotis existance
	$table_notisagen_kandungannotis = mysql_query('SELECT kandungannotis from notisagen', $database_connection);
	if (!$table_notisagen_kandungannotis)
	{
		$create_notisagen_column_kandungannotis = 'ALTER TABLE notisagen ADD kandungannotis MEDIUMTEXT NOT NULL AFTER datetime';
		
		mysql_query($create_notisagen_column_kandungannotis, $database_connection);
		$message .= '* Column kandungannotis in notisagen table has been added!<br />';
	}
	
	
	// Check Table optinadmin Existances
	$table_optinadmin = mysql_query('SELECT * from optinadmin', $database_connection);
	if (!$table_optinadmin)
	{
		$create_table_optinadmin = 'CREATE TABLE IF NOT EXISTS optinadmin (
		optincode MEDIUMTEXT NOT NULL
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_optinadmin, $database_connection);
		mysql_query($data_table_optinadmin, $database_connection);
		$message .= '- Table optinadmin has been added!<br />';
	}
	
	// Check optinadmin column optincode existance
	$table_optinadmin_optincode = mysql_query('SELECT optincode from optinadmin', $database_connection);
	if (!$table_optinadmin_optincode)
	{
		$create_optinadmin_column_optincode = 'ALTER TABLE optinadmin ADD optincode MEDIUMTEXT NOT NULL FIRST';
		
		mysql_query($create_optinadmin_column_optincode, $database_connection);
		$message .= '* Column optincode in optinadmin table has been added!<br />';
	}
	
	
	// Check Table produk Existances
	$table_produk = mysql_query('SELECT * from produk', $database_connection);
	if (!$table_produk)
	{
		$create_table_produk = 'CREATE TABLE IF NOT EXISTS produk (
		idproduk INT(5) AUTO_INCREMENT,
		namaproduk VARCHAR(250) NOT NULL,
		komisyenproduk VARCHAR(250) NOT NULL,
		PRIMARY KEY  (idproduk)
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_produk, $database_connection);
		mysql_query($data_table_produk, $database_connection);
		$message .= '- Table produk has been added!<br />';
	}
	
	// Check produk column idproduk existance
	$table_produk_idproduk = mysql_query('SELECT idproduk from produk', $database_connection);
	if (!$table_produk_idproduk)
	{
		$create_produk_column_idproduk = 'ALTER TABLE produk ADD idproduk INT(5) AUTO_INCREMENT PRIMARY KEY FIRST';
		
		mysql_query($create_produk_column_idproduk, $database_connection);
		$message .= '* Column idproduk in produk table has been added!<br />';
	}
	
	// Check produk column namaproduk existance
	$table_produk_namaproduk = mysql_query('SELECT namaproduk from produk', $database_connection);
	if (!$table_produk_namaproduk)
	{
		$create_produk_column_namaproduk = 'ALTER TABLE produk ADD namaproduk VARCHAR(250) NOT NULL AFTER idproduk';
		
		mysql_query($create_produk_column_namaproduk, $database_connection);
		$message .= '* Column namaproduk in produk table has been added!<br />';
	}
	
	// Check produk column komisyenproduk existance
	$table_produk_komisyenproduk = mysql_query('SELECT komisyenproduk from produk', $database_connection);
	if (!$table_produk_komisyenproduk)
	{
		$create_produk_column_komisyenproduk = 'ALTER TABLE produk ADD komisyenproduk VARCHAR(250) NOT NULL AFTER namaproduk';
		
		mysql_query($create_produk_column_komisyenproduk, $database_connection);
		$message .= '* Column komisyenproduk in produk table has been added!<br />';
	}
	
	
	// Check Table sales Existances
	$table_sales = mysql_query('SELECT * from sales', $database_connection);
	if (!$table_sales)
	{
		$create_table_sales = "CREATE TABLE IF NOT EXISTS sales (
		idsales INT(11) AUTO_INCREMENT,
		refid VARCHAR(30) NOT NULL,
		jumlahpembayaran VARCHAR(250) NOT NULL,
		kaedahpembayaran VARCHAR(250) NOT NULL,
		date DATE NOT NULL default '0000-00-00',
		time TIME NOT NULL default '00:00:00',
		browser VARCHAR(250) NOT NULL,
		ipaddress VARCHAR(50) NOT NULL,
		payment VARCHAR(50) NOT NULL,
		namapelanggan VARCHAR(250) NOT NULL,
		emailpelanggan VARCHAR(250) NOT NULL,
		statuspelanggan VARCHAR(250) NOT NULL,
		PRIMARY KEY (idsales)
		) DEFAULT CHARACTER SET utf8";
		
		mysql_query($create_table_sales, $database_connection);
		$message .= '- Table sales has been added!<br />';
	}
	
	// Check sales column idsales existance
	$table_sales_idsales = mysql_query('SELECT idsales from sales', $database_connection);
	if (!$table_sales_idsales)
	{
		$create_sales_column_idsales = 'ALTER TABLE sales ADD idsales INT(11) AUTO_INCREMENT PRIMARY KEY FIRST';
		
		mysql_query($create_sales_column_idsales, $database_connection);
		$message .= '* Column idsales in sales table has been added!<br />';
	}
	
	// Check sales column refid existance
	$table_sales_refid = mysql_query('SELECT refid from sales', $database_connection);
	if (!$table_sales_refid)
	{
		$create_sales_column_refid = 'ALTER TABLE sales ADD refid VARCHAR(30) NOT NULL AFTER idsales';
		
		mysql_query($create_sales_column_refid, $database_connection);
		$message .= '* Column refid in sales table has been added!<br />';
	}
	
	// Check sales column jumlahpembayaran existance
	$table_sales_jumlahpembayaran = mysql_query('SELECT jumlahpembayaran from sales', $database_connection);
	if (!$table_sales_jumlahpembayaran)
	{
		$create_sales_column_jumlahpembayaran = 'ALTER TABLE sales ADD jumlahpembayaran VARCHAR(250) NOT NULL AFTER refid';
		
		mysql_query($create_sales_column_jumlahpembayaran, $database_connection);
		$message .= '* Column jumlahpembayaran in sales table has been added!<br />';
	}
	
	// Check sales column kaedahpembayaran existance
	$table_sales_kaedahpembayaran = mysql_query('SELECT kaedahpembayaran from sales', $database_connection);
	if (!$table_sales_kaedahpembayaran)
	{
		$create_sales_column_kaedahpembayaran = 'ALTER TABLE sales ADD kaedahpembayaran VARCHAR(250) NOT NULL AFTER jumlahpembayaran';
		
		mysql_query($create_sales_column_kaedahpembayaran, $database_connection);
		$message .= '* Column kaedahpembayaran in sales table has been added!<br />';
	}
	
	// Check sales column date existance
	$table_sales_date = mysql_query('SELECT date from sales', $database_connection);
	if (!$table_sales_date)
	{
		$create_sales_column_date = "ALTER TABLE sales ADD date DATE NOT NULL DEFAULT '0000-00-00' AFTER kaedahpembayaran";
		
		mysql_query($create_sales_column_date, $database_connection);
		$message .= '* Column date in sales table has been added!<br />';
	}
	
	// Check sales column time existance
	$table_sales_time = mysql_query('SELECT time from sales', $database_connection);
	if (!$table_sales_time)
	{
		$create_sales_column_time = "ALTER TABLE sales ADD time TIME NOT NULL DEFAULT '00:00:00' AFTER date";
		
		mysql_query($create_sales_column_time, $database_connection);
		$message .= '* Column time in sales table has been added!<br />';
	}
	
	// Check sales column browser existance
	$table_sales_browser = mysql_query('SELECT browser from sales', $database_connection);
	if (!$table_sales_browser)
	{
		$create_sales_column_browser = 'ALTER TABLE sales ADD browser VARCHAR(250) NOT NULL AFTER time';
		
		mysql_query($create_sales_column_browser, $database_connection);
		$message .= '* Column browser in sales table has been added!<br />';
	}
	
	// Check sales column ipaddress existance
	$table_sales_ipaddress = mysql_query('SELECT ipaddress from sales', $database_connection);
	if (!$table_sales_ipaddress)
	{
		$create_sales_column_ipaddress = 'ALTER TABLE sales ADD ipaddress VARCHAR(50) NOT NULL AFTER browser';
		
		mysql_query($create_sales_column_ipaddress, $database_connection);
		$message .= '* Column ipaddress in sales table has been added!<br />';
	}
	
	// Check sales column payment existance
	$table_sales_payment = mysql_query('SELECT payment from sales', $database_connection);
	if (!$table_sales_payment)
	{
		$create_sales_column_payment = 'ALTER TABLE sales ADD payment VARCHAR(50) NOT NULL AFTER ipaddress';
		
		mysql_query($create_sales_column_payment, $database_connection);
		$message .= '* Column payment in sales table has been added!<br />';
	}
	
	// Check sales column namapelanggan existance
	$table_sales_namapelanggan = mysql_query('SELECT namapelanggan from sales', $database_connection);
	if (!$table_sales_namapelanggan)
	{
		$create_sales_column_namapelanggan = 'ALTER TABLE sales ADD namapelanggan VARCHAR(250) NOT NULL AFTER payment';
		
		mysql_query($create_sales_column_namapelanggan, $database_connection);
		$message .= '* Column namapelanggan in sales table has been added!<br />';
	}
	
	// Check sales column emailpelanggan existance
	$table_sales_emailpelanggan = mysql_query('SELECT emailpelanggan from sales', $database_connection);
	if (!$table_sales_emailpelanggan)
	{
		$create_sales_column_emailpelanggan = 'ALTER TABLE sales ADD emailpelanggan VARCHAR(250) NOT NULL AFTER namapelanggan';
		
		mysql_query($create_sales_column_emailpelanggan, $database_connection);
		$message .= '* Column emailpelanggan in sales table has been added!<br />';
	}
	
	// Check sales column statuspelanggan existance
	$table_sales_statuspelanggan = mysql_query('SELECT statuspelanggan from sales', $database_connection);
	if (!$table_sales_statuspelanggan)
	{
		$create_sales_column_statuspelanggan = 'ALTER TABLE sales ADD statuspelanggan VARCHAR(250) NOT NULL AFTER emailpelanggan';
		
		mysql_query($create_sales_column_statuspelanggan, $database_connection);
		$message .= '* Column statuspelanggan in sales table has been added!<br />';
	}
	
	
	// Check Table termadaftar Existances
	$table_termadaftar = mysql_query('SELECT * from termadaftar', $database_connection);
	if (!$table_termadaftar)
	{
		$create_table_termadaftar = 'CREATE TABLE IF NOT EXISTS termadaftar (
		kandunganterma MEDIUMTEXT NOT NULL
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_termadaftar, $database_connection);
		mysql_query($data_table_termadaftar, $database_connection);
		$message .= '- Table termadaftar has been added!<br />';
	}
	
	// Check termadaftar column kandunganterma existance
	$table_termadaftar_kandunganterma = mysql_query('SELECT kandunganterma from termadaftar', $database_connection);
	if (!$table_termadaftar_kandunganterma)
	{
		$create_termadaftar_column_kandunganterma = 'ALTER TABLE termadaftar ADD kandunganterma MEDIUMTEXT FIRST';
		
		mysql_query($create_termadaftar_column_kandunganterma, $database_connection);
		$message .= '* Column kandunganterma in termadaftar table has been added!<br />';
	}
	
	
	// Check Table videopromosi Existances
	$table_videopromosi = mysql_query('SELECT * from videopromosi', $database_connection);
	if (!$table_videopromosi)
	{
		$create_table_videopromosi = 'CREATE TABLE IF NOT EXISTS videopromosi (
  		number INT(5) NOT NULL auto_increment,
		arahan VARCHAR(200) NOT NULL,
		tajuk VARCHAR(200) NOT NULL,
		kandungan MEDIUMTEXT NOT NULL,
		PRIMARY KEY (number)
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_videopromosi, $database_connection);
		$message .= '- Table videopromosi has been added!<br />';
	}
	
	// Check videopromosi column number existance
	$table_videopromosi_number = mysql_query('SELECT number from videopromosi', $database_connection);
	if (!$table_videopromosi_number)
	{
		$create_videopromosi_column_number = 'ALTER TABLE videopromosi ADD number INT(5) AUTO_INCREMENT PRIMARY KEY FIRST';
		
		mysql_query($create_videopromosi_column_number, $database_connection);
		$message .= '* Column number in videopromosi table has been added!<br />';
	}
	
	// Check videopromosi column arahan existance
	$table_videopromosi_arahan = mysql_query('SELECT arahan from videopromosi', $database_connection);
	if (!$table_videopromosi_arahan)
	{
		$create_videopromosi_column_arahan = 'ALTER TABLE videopromosi ADD arahan VARCHAR(200) NOT NULL AFTER number';
		
		mysql_query($create_videopromosi_column_arahan, $database_connection);
		$message .= '* Column arahan in videopromosi table has been added!<br />';
	}
	
	// Check videopromosi column tajuk existance
	$table_videopromosi_tajuk = mysql_query('SELECT tajuk from videopromosi', $database_connection);
	if (!$table_videopromosi_tajuk)
	{
		$create_videopromosi_column_tajuk = 'ALTER TABLE videopromosi ADD tajuk VARCHAR(200) NOT NULL AFTER arahan';
		
		mysql_query($create_videopromosi_column_tajuk, $database_connection);
		$message .= '* Column tajuk in videopromosi table has been added!<br />';
	}
	
	// Check videopromosi column kandungan existance
	$table_videopromosi_kandungan = mysql_query('SELECT kandungan from videopromosi', $database_connection);
	if (!$table_videopromosi_kandungan)
	{
		$create_videopromosi_column_kandungan = 'ALTER TABLE videopromosi ADD kandungan MEDIUMTEXT AFTER tajuk';
		
		mysql_query($create_videopromosi_column_kandungan, $database_connection);
		$message .= '* Column kandungan in videopromosi table has been added!<br />';		
	}
	
	
	
	// Upgrade Process For Affiliate Lite Below 2.4
	
	// For affiliate lite version 2.1 - Drop bank column form affiliates table
	$table_affiliates_bank = mysql_query('SELECT bank from affiliates', $database_connection);
	if ($table_affiliates_bank != 0)
	{
		$drop_affiliates_column_bank = 'ALTER TABLE affiliates DROP bank';
		
		mysql_query($drop_affiliates_column_bank, $database_connection);
		$message .= '* Column bank in affiliates table has been dropped!<br />';
	}
	
	// For affiliate lite version 2.1 - Drop table promosi
	$table_promosi = mysql_query('SELECT * from promosi', $database_connection);
	if ($table_promosi != 0)
	{
		$drop_table_promosi = 'DROP TABLE promosi';
		
		mysql_query($drop_table_promosi, $database_connection);
		$message .= '- Table promosi has been dropped!<br />';
	}
	
	// For affiliate lite version 2.1 - Drop bank column form affiliates table
	$table_clickthroughs_buy = mysql_query('SELECT buy from clickthroughs', $database_connection);
	if ($table_clickthroughs_buy != 0)
	{
		$drop_clickthroughs_column_buy = 'ALTER TABLE clickthroughs DROP buy';
		
		mysql_query($drop_clickthroughs_column_buy, $database_connection);
		$message .= '* Column buy in clickthroughs table has been dropped!<br />';
	}
	
	
	
	
// Explain what process has been executed.
$message .= '<p align="center">Affiliate Lite System has been successfully upgraded!</a></p>
<p>&nbsp;</p>
<p align="center"><b><font color="#FF0000">AMARAN PENTING - HAPUSKAN FOLDER INSTALL!</font></b></p>
<p>Sila HAPUSKAN (DELETE) folder install sebelum anda mula menggunakan sistem. Kegagalan berbuat demikian boleh menyebabkan server anda di"hack" oleh pihak yang tidak bertanggungjawab.</p>
<p>URL login admin adalah seperti yang telah anda tetapkan sebelum ini. Sekiranya anda tidak dapat login, sila tukar kepada password baru dengan cara recover dari halaman admin. Anda juga perlu menetapkan nama FOLDER ADMIN di dalam konfigurasi sistem affiliate.</p>
<p>URL login affiliate adalah seperti yang telah anda tetapkan sebelum ini. Walaubagaimanapun, agen affiliate lama MUNGKIN PERLU RESET password baru untuk membolehkan mereka login ke dalam ruangan agen affiliate. Makluman kepada mereka hal ini jika perlu.</p>
<p>Sila ubahsuai KONFIGURASI sistem affiliate menerusi halaman admin. Rujuk manual dan tutorial yang dibekalkan sewaktu anda membeli script sistem affiliate ini.<br /><br /><font color="#FF0000">AMARAN</font>: Jangan ULANG proses installasi ini kerana database anda mungkin akan di "overwrite". Hapuskan segera folder install dari server anda.</p>';

include 'output.html.php';

// Close Upgrade Selection	
}


// Select Type Of Installation - NEW INSTALLATION
if($_POST['installation_type'] == 'freshinstall')
{
	// Declare Message Text
	$message ='';
	
	// Connect to Selected Database
	// Connect to Selected Database
	$database_connection = mysql_connect($server, $db_user, $db_pass);
	if (!$database_connection)
	{
		$output = 'Unable to connect to the database server.';
		include 'output.html.php';
		exit();
	}
	if (!mysql_select_db($database, $database_connection))
	{
		$output = 'Unable to locate the affiliate database.';
		include 'output.html.php';
		exit();
	}
	
	// Check Table admin Existances
	$table_admin = mysql_query('SELECT * from admin', $database_connection);
	if (!$table_admin)
	{
		$create_table_admin = 'CREATE TABLE IF NOT EXISTS admin (
		id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  		user VARCHAR(30) NOT NULL,
		pass VARCHAR(50) NOT NULL,
		namaadmin VARCHAR(200) NOT NULL,
		emailadmin VARCHAR(200) NOT NULL,
		emailadminsupport VARCHAR(200) NOT NULL,
		emailadminpayment VARCHAR(200) NOT NULL,
		namaproduk VARCHAR(200) NOT NULL,
		domain VARCHAR(200) NOT NULL,
		folderaffiliates VARCHAR(200) NOT NULL,
		folderadmin VARCHAR(200) NOT NULL,
		domainredirect VARCHAR(200) NOT NULL,
		landingpage VARCHAR(200) NOT NULL,
		cookieExpiration VARCHAR(200) NOT NULL,
		cookieDomain VARCHAR(200) NOT NULL,
		cartatopaffiliate VARCHAR(100) NOT NULL,
		currency VARCHAR(100) NOT NULL,
		language VARCHAR(100) NOT NULL,
		idaffiliatePIS VARCHAR(100) NOT NULL,
		tahunoperasi VARCHAR(100) NOT NULL,
		onoffpendaftaran VARCHAR(30) NOT NULL,
		kodpendaftaran VARCHAR(30) NOT NULL,
		kodcaptchaborang VARCHAR(30) NOT NULL,
		affiliatetracking VARCHAR(1) NOT NULL,
		scriptcredit INT NOT NULL
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_admin, $database_connection);
		mysql_query($data_table_admin, $database_connection);
		$message .= '- Table admin has been created!<br />';
	}
	
	// Check Table affiliates Existances
	$table_affiliates = mysql_query('SELECT * from affiliates', $database_connection);
	if (!$table_affiliates)
	{
		$create_table_affiliates = 'CREATE TABLE IF NOT EXISTS affiliates (
		id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  		refid VARCHAR(30) NOT NULL,
 		pass VARCHAR(50) NOT NULL,
  		title VARCHAR(10) NOT NULL,
	  	firstname VARCHAR(50) NOT NULL,
		lastname VARCHAR(50) NOT NULL,
		email VARCHAR(100) NOT NULL,
		website VARCHAR(100) NOT NULL,
		street VARCHAR(200) NOT NULL,
		town VARCHAR(200) NOT NULL,
		county VARCHAR(200) NOT NULL,
		postcode VARCHAR(20) NOT NULL,
		country VARCHAR(200) NOT NULL,
		phone VARCHAR(30) NOT NULL,
		processor VARCHAR(200) NOT NULL,
		account VARCHAR(200) NOT NULL,
		payto VARCHAR(200) NOT NULL,
		date VARCHAR(40) NOT NULL,
		ipaddress VARCHAR(100) NOT NULL,
		upline VARCHAR(30) NOT NULL,
		KEY email (email)
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_affiliates, $database_connection);
		mysql_query($data_table_affiliates, $database_connection);
		$message .= '- Table affiliates has been created!<br />';
	}
	
	// Check Table artikelpromosi Existances
	$table_artikelpromosi = mysql_query('SELECT * from artikelpromosi', $database_connection);
	if (!$table_artikelpromosi)
	{
		$create_table_artikelpromosi = 'CREATE TABLE IF NOT EXISTS artikelpromosi (
  		number INT(5) NOT NULL auto_increment,
		arahan VARCHAR(200) NOT NULL,
		tajuk VARCHAR(200) NOT NULL,
		kandungan MEDIUMTEXT NOT NULL,
		PRIMARY KEY (number)
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_artikelpromosi, $database_connection);
		$message .= '- Table artikelpromosi has been created!<br />';
	}
	
	// Check Table banners Existances
	$table_banners = mysql_query('SELECT * from banners', $database_connection);
	if (!$table_banners)
	{
		$create_table_banners = 'CREATE TABLE IF NOT EXISTS banners (
  		number INT(5) NOT NULL auto_increment,
		name VARCHAR(200) NOT NULL,
		image VARCHAR(200) NOT NULL,
		description VARCHAR(200) NOT NULL,
		PRIMARY KEY (number)
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_banners, $database_connection);
		$message .= '- Table banners has been created!<br />';
	}
	
	// Check Table beritaagen Existances
	$table_beritaagen = mysql_query('SELECT * from beritaagen', $database_connection);
	if (!$table_beritaagen)
	{
		$create_table_beritaagen = 'CREATE TABLE IF NOT EXISTS beritaagen (
  		idberita INT(5) NOT NULL auto_increment,
		tarikhberita VARCHAR(200) NOT NULL,
		tajukberita VARCHAR(200) NOT NULL,
		kandunganberita MEDIUMTEXT NOT NULL,
		PRIMARY KEY (idberita)
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_beritaagen, $database_connection);
		$message .= '- Table beritaagen has been created!<br />';
	}
	
	// Check Table clickthroughs Existances
	$table_clickthroughs = mysql_query('SELECT * from clickthroughs', $database_connection);
	if (!$table_clickthroughs)
	{
		$create_table_clickthroughs = "CREATE TABLE IF NOT EXISTS clickthroughs (
		refid VARCHAR(30) NOT NULL,
		date date NOT NULL default '0000-00-00',
		time time NOT NULL default '00:00:00',
		browser VARCHAR(250) NOT NULL,
		ipaddress VARCHAR(50) NOT NULL,
		refferalurl VARCHAR(250) NOT NULL
		) DEFAULT CHARACTER SET utf8";
		
		mysql_query($create_table_clickthroughs, $database_connection);
		$message .= '- Table clickthroughs has been created!<br />';
	}
	
	// Check Table emailadmin Existances
	$table_emailadmin = mysql_query('SELECT * from emailadmin', $database_connection);
	if (!$table_emailadmin)
	{
		$create_table_emailadmin = 'CREATE TABLE IF NOT EXISTS emailadmin (
		emaildaftar longtext,
		emailpengesahan longtext,
		emailpengesahanadmin longtext,
		emailpassworduser longtext,
		emailpassworduserreset longtext,
		emailsahkomisyen longtext,
		emailbayarkomisyen longtext
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_emailadmin, $database_connection);
		mysql_query($data_table_emailadmin, $database_connection);
		$message .= '- Table emailadmin has been created!<br />';
	}
	
	// Check Table iklanadmin Existances
	$table_iklanadmin = mysql_query('SELECT * from iklanadmin', $database_connection);
	if (!$table_iklanadmin)
	{
		$create_table_iklanadmin = 'CREATE TABLE IF NOT EXISTS iklanadmin (
		kandunganiklan MEDIUMTEXT NOT NULL
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_iklanadmin, $database_connection);
		mysql_query($data_table_iklanadmin, $database_connection);
		$message .= '- Table iklanadmin has been created!<br />';
	}
	
	// Check Table notisagen Existances
	$table_notisagen = mysql_query('SELECT * from notisagen', $database_connection);
	if (!$table_notisagen)
	{
		$create_table_notisagen = 'CREATE TABLE IF NOT EXISTS notisagen (
		datetime VARCHAR(100) NOT NULL,
		kandungannotis MEDIUMTEXT NOT NULL
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_notisagen, $database_connection);
		mysql_query($data_table_notisagen, $database_connection);
		$message .= '- Table notisagen has been created!<br />';
	}
	
	// Check Table optinadmin Existances
	$table_optinadmin = mysql_query('SELECT * from optinadmin', $database_connection);
	if (!$table_optinadmin)
	{
		$create_table_optinadmin = 'CREATE TABLE IF NOT EXISTS optinadmin (
		optincode MEDIUMTEXT NOT NULL
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_optinadmin, $database_connection);
		mysql_query($data_table_optinadmin, $database_connection);
		$message .= '- Table optinadmin has been created!<br />';
	}
	
	// Check Table produk Existances
	$table_produk = mysql_query('SELECT * from produk', $database_connection);
	if (!$table_produk)
	{
		$create_table_produk = 'CREATE TABLE IF NOT EXISTS produk (
		idproduk INT(5) AUTO_INCREMENT,
		namaproduk VARCHAR(250) NOT NULL,
		komisyenproduk VARCHAR(250) NOT NULL,
		PRIMARY KEY  (idproduk)
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_produk, $database_connection);
		mysql_query($data_table_produk, $database_connection);
		$message .= '- Table produk has been created!<br />';
	}
	
	// Check Table sales Existances
	$table_sales = mysql_query('SELECT * from sales', $database_connection);
	if (!$table_sales)
	{
		$create_table_sales = "CREATE TABLE IF NOT EXISTS sales (
		idsales INT(11) AUTO_INCREMENT,
		refid VARCHAR(30) NOT NULL,
		jumlahpembayaran VARCHAR(250) NOT NULL,
		kaedahpembayaran VARCHAR(250) NOT NULL,
		date DATE NOT NULL default '0000-00-00',
		time TIME NOT NULL default '00:00:00',
		browser VARCHAR(250) NOT NULL,
		ipaddress VARCHAR(50) NOT NULL,
		payment VARCHAR(50) NOT NULL,
		namapelanggan VARCHAR(250) NOT NULL,
		emailpelanggan VARCHAR(250) NOT NULL,
		statuspelanggan VARCHAR(250) NOT NULL,
		PRIMARY KEY (idsales)
		) DEFAULT CHARACTER SET utf8";
		
		mysql_query($create_table_sales, $database_connection);
		$message .= '- Table sales has been created!<br />';
	}
	
	// Check Table termadaftar Existances
	$table_termadaftar = mysql_query('SELECT * from termadaftar', $database_connection);
	if (!$table_termadaftar)
	{
		$create_table_termadaftar = 'CREATE TABLE IF NOT EXISTS termadaftar (
		kandunganterma MEDIUMTEXT NOT NULL
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_termadaftar, $database_connection);
		mysql_query($data_table_termadaftar, $database_connection);
		$message .= '- Table termadaftar has been created!<br />';
	}
	
	// Check Table videopromosi Existances
	$table_videopromosi = mysql_query('SELECT * from videopromosi', $database_connection);
	if (!$table_videopromosi)
	{
		$create_table_videopromosi = 'CREATE TABLE IF NOT EXISTS videopromosi (
  		number INT(5) NOT NULL auto_increment,
		arahan VARCHAR(200) NOT NULL,
		tajuk VARCHAR(200) NOT NULL,
		kandungan MEDIUMTEXT NOT NULL,
		PRIMARY KEY (number)
		) DEFAULT CHARACTER SET utf8';
		
		mysql_query($create_table_videopromosi, $database_connection);
		$message .= '- Table videopromosi has been created!<br />';
	}
	
	
$message .= '<p align="center">Affiliate Lite System has been successfully installed!</a></p>
<p>&nbsp;</p>
<p align="center"><b><font color="#FF0000">AMARAN PENTING - HAPUSKAN FOLDER INSTALL!</font></b></p>
<p>Sila HAPUSKAN (DELETE) folder install sebelum anda mula menggunakan sistem. Kegagalan berbuat demikian boleh menyebabkan server anda di"hack" oleh pihak yang tidak bertanggungjawab.</p>
<ul>
<li><a href="../affiliates/administrator/" target="_blank">Klik Sini Untuk Login Ke Ruangan Admin</a> (Admin ID: <i>admin</i> | Admin Password: <i>admin</i>)</li>
<li><a href="../affiliates/" target="_blank">Klik Sini Untuk Login Ke Ruangan Agen</a> (User ID: <i>demo</i> | User Password: <i>demo</i>)</li>
</ul>
<p><font color="#FF0000">NOTA</font>: Jika anda telah menukar NAMA folder affiliates dan admin, pastikan anda tetapkan maklumatnya di dalam konfigurasi sistem di ruangan admin.
<p>Sila ubahsuai KONFIGURASI sistem affiliate menerusi halaman admin. Rujuk manual dan tutorial yang dibekalkan sewaktu anda membeli script sistem affiliate ini.<br /><br /><font color="#FF0000">AMARAN</font>: Jangan ULANG proses installasi ini kerana database anda mungkin akan di "overwrite". Hapuskan segera folder install dari server anda.</p>';

include 'output.html.php';

// Close installation type fresh install
}
?>