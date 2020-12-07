-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 11, 2020 at 03:17 AM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.3.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agen_affiliate`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(30) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `namaadmin` varchar(200) NOT NULL,
  `emailadmin` varchar(200) NOT NULL,
  `emailadminsupport` varchar(200) NOT NULL,
  `emailadminpayment` varchar(200) NOT NULL,
  `namaproduk` varchar(200) NOT NULL,
  `domain` varchar(200) NOT NULL,
  `folderaffiliates` varchar(200) NOT NULL,
  `folderadmin` varchar(200) NOT NULL,
  `domainredirect` varchar(200) NOT NULL,
  `landingpage` varchar(200) NOT NULL,
  `cookieExpiration` varchar(200) NOT NULL,
  `cookieDomain` varchar(200) NOT NULL,
  `cartatopaffiliate` varchar(100) NOT NULL,
  `currency` varchar(100) NOT NULL,
  `language` varchar(100) NOT NULL,
  `idaffiliatePIS` varchar(100) NOT NULL,
  `tahunoperasi` varchar(100) NOT NULL,
  `onoffpendaftaran` varchar(30) NOT NULL,
  `kodpendaftaran` varchar(30) NOT NULL,
  `kodcaptchaborang` varchar(30) NOT NULL,
  `affiliatetracking` varchar(1) NOT NULL,
  `scriptcredit` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `user`, `pass`, `namaadmin`, `emailadmin`, `emailadminsupport`, `emailadminpayment`, `namaproduk`, `domain`, `folderaffiliates`, `folderadmin`, `domainredirect`, `landingpage`, `cookieExpiration`, `cookieDomain`, `cartatopaffiliate`, `currency`, `language`, `idaffiliatePIS`, `tahunoperasi`, `onoffpendaftaran`, `kodpendaftaran`, `kodcaptchaborang`, `affiliatetracking`, `scriptcredit`) VALUES
(1, 'admin', '71a03426f0459615cb6bc821a77a85c95c88e7c9', 'Cikgu Hafis', 'hafisanuar@gmail.com', 'support@cikguhafis.com', 'hafisanuar@gmail.com', 'CikguHafis.com', 'agen.cikguhafis.com', 'affiliates', 'administrator', 'https://www.youtube.com/playlist?list=PL-ScMKPM_vcascr7TtU5jcmmi6rYtsB6Q', 'http://cikguhafis.com/kuasaebook', '0', '.cikguhafis.com', '10', 'MYR', 'mly.php', '19', '2020', 'OFF', '2020vip', 'DISABLE', 'L', 1);

-- --------------------------------------------------------

--
-- Table structure for table `affiliates`
--

CREATE TABLE IF NOT EXISTS `affiliates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `refid` varchar(30) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `title` varchar(10) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  `street` varchar(200) NOT NULL,
  `town` varchar(200) NOT NULL,
  `county` varchar(200) NOT NULL,
  `postcode` varchar(20) NOT NULL,
  `country` varchar(200) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `processor` varchar(200) NOT NULL,
  `account` varchar(200) NOT NULL,
  `payto` varchar(200) NOT NULL,
  `date` varchar(40) NOT NULL,
  `ipaddress` varchar(100) NOT NULL,
  `upline` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `affiliates`
--

INSERT INTO `affiliates` (`id`, `refid`, `pass`, `title`, `firstname`, `lastname`, `email`, `website`, `street`, `town`, `county`, `postcode`, `country`, `phone`, `processor`, `account`, `payto`, `date`, `ipaddress`, `upline`) VALUES
(1, 'demo', '334cae45db13ceaf21183e0c8f867af25ab403ad', 'En', 'Ahmad', 'Albab', 'emailagen@domain.com', 'www.sistemaffiliate.com', '123 Alamat Surat Menyurat', 'Seremban', 'Negeri Sembilan', '1234567', 'MY', '60123456789', 'MAYBANK', '12345678910', 'Nama Penerima Bayaran', '2013-12-24', '175.137.251.139', '');

-- --------------------------------------------------------

--
-- Table structure for table `artikelpromosi`
--

CREATE TABLE IF NOT EXISTS `artikelpromosi` (
  `number` int(5) NOT NULL AUTO_INCREMENT,
  `arahan` varchar(200) NOT NULL,
  `tajuk` varchar(200) NOT NULL,
  `kandungan` mediumtext NOT NULL,
  PRIMARY KEY (`number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `number` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  PRIMARY KEY (`number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `beritaagen`
--

CREATE TABLE IF NOT EXISTS `beritaagen` (
  `idberita` int(5) NOT NULL AUTO_INCREMENT,
  `tarikhberita` varchar(200) NOT NULL,
  `tajukberita` varchar(200) NOT NULL,
  `kandunganberita` mediumtext NOT NULL,
  PRIMARY KEY (`idberita`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clickthroughs`
--

CREATE TABLE IF NOT EXISTS `clickthroughs` (
  `refid` varchar(30) NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `time` time NOT NULL DEFAULT '00:00:00',
  `browser` varchar(250) NOT NULL,
  `ipaddress` varchar(50) NOT NULL,
  `refferalurl` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clickthroughs`
--

-- --------------------------------------------------------

--
-- Table structure for table `emailadmin`
--

CREATE TABLE IF NOT EXISTS `emailadmin` (
  `emaildaftar` longtext DEFAULT NULL,
  `emailpengesahan` longtext DEFAULT NULL,
  `emailpengesahanadmin` longtext DEFAULT NULL,
  `emailpassworduser` longtext DEFAULT NULL,
  `emailpassworduserreset` longtext DEFAULT NULL,
  `emailsahkomisyen` longtext DEFAULT NULL,
  `emailbayarkomisyen` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emailadmin`
--

INSERT INTO `emailadmin` (`emaildaftar`, `emailpengesahan`, `emailpengesahanadmin`, `emailpassworduser`, `emailpassworduserreset`, `emailsahkomisyen`, `emailbayarkomisyen`) VALUES
('Salam sejahtera %%namaagen%%,\r\n\r\nTerima kasih kerana telah mendaftar sebagai agen pemasaran kami \r\nmenerusi program affiliate yang kami tawarkan iaitu program affiliate\r\nbagi:\r\n\r\n%%namaproduk%%\r\n\r\nBerikut adalah maklumat akaun affiliate anda:\r\n\r\n=============================================\r\nAkaun Affiliate Anda\r\n=============================================\r\n\r\nNama Program Affiliate:\r\n=> %%namaproduk%%\r\n\r\nURL Halaman Affiliate:\r\n=> %%loginaffiliate%%\r\n\r\nLogin Affiliate Anda:\r\n[+] Username: %%idagen%%\r\n[+] Password: %%passwordagen%%\r\n\r\nLink Affiliate Anda:\r\n=> %%linkaffiliate%%\r\n\r\n=============================================\r\n\r\nAnda boleh login ke akaun affiliate anda untuk melihat statistik \r\n\"real-time\", jumlah komisyen, bahan promosi dan lain - lain perkara \r\nyang telah kami sediakan.\r\n\r\nAkhir kata, terima kasih sekali lagi kami ucapkan kerana telah\r\nmendaftar sebagai agen affiliate kami.\r\n\r\nSelamat menjana wang bersama perniagaan kami!\r\n\r\nYang Benar,\r\n\r\n%%namaadmin%%\r\n%%domain%%', 'Salam sejahtera %%namapembeli%%.\r\n\r\nTerima kasih kerana telah membuat pembelian produk:\r\n\r\n=> %%namaproduk%%\r\n\r\ndaripada laman web kami di:\r\n\r\n=> http://%%domain%%\r\n\r\nDibawah ini adalah salinan butiran pengesahan tempahan dan\r\npembayaran anda yang telah kami terima:\r\n\r\n===========================================================\r\nButiran Tempahan %%namaproduk%%\r\n===========================================================\r\n\r\nPembelian di: %%domain%%\r\n\r\n\r\n===========================================================\r\nButiran Pengesahan Transaksi Pembayaran\r\n===========================================================\r\n\r\n=> Nama Anda: %%namapembeli%%\r\n=> Email Anda: %%emailpembeli%%\r\n=> Tel. Anda: %%telefonpembeli%%\r\n\r\n=> Alamat Anda (Jika Telah Di Isi):\r\n%%alamatpembeli%%\r\n\r\n=> Produk & Bayaran: %%jumlahpembayaran%%\r\n=> Kaedah Pembayaran: %%kaedahpembayaran%%\r\n\r\n=> Tarikh Pembayaran: %%tarikhpembayaran%%\r\n=> Masa Pembayaran: %%masapembayaran%%\r\n\r\n=> Bukti Pembayaran:\r\n%%buktipembayaran%%\r\n\r\n\r\n=> Nota Tambahan (Jika Ada):\r\n%%notapembeli%%\r\n\r\n\r\n===========================================================\r\n\r\nKami akan memproses tempahan anda dalam tempoh 24 jam dari\r\nsekarang atau selewat - lewatnya 48 jam.\r\n\r\nProduk yang ditempah akan dikirimkan kepada anda selepas\r\npengesahan data pembelian anda kami semak.\r\n\r\nPastikan anda menyimpan email ini sebagai rekod dan juga pastikan\r\nalamat email kami iaitu %%emailsupport%% di simpan ke dalam address\r\nbook email anda.\r\n\r\nIni adalah untuk memastikan email kami selepas ini akan senantiasa\r\nmasuk ke dalam INBOX anda bagi memudahkan urusan kita di masa\r\nhadapan.\r\n\r\nJika anda menghadapi sebarang masalah atau pertanyaan, sila\r\nkirimkan pesanan anda ke %%emailsupport%%.\r\n\r\nSekian, terima kasih.\r\n\r\nIkhlas\r\n\r\n%%namaadmin%%\r\n%%domain%%\r\n%%emailsupport%%', 'Salam sejahtera admin %%namaadmin%%.\r\n\r\nAnda telah menerima tempahan produk %%namaproduk%%\r\nyang anda jual di http://%%domain%%\r\n\r\nBerikut adalah senarai tempahan / bukti pengesahan\r\nyang telah dikirimkan oleh pembeli.\r\n\r\n===========================================================\r\nTempahan & Pengesahan Pembelian\r\n===========================================================\r\n\r\nProduk & Harga: %%jumlahpembayaran%%\r\nURL: http://%%domain%%\r\n\r\n\r\n===========================================================\r\nButiran Pengesahan Transaksi Pembayaran\r\n===========================================================\r\n\r\n=> Nama Pembeli: %%namapembeli%%\r\n=> Email Pembeli: %%emailpembeli%%\r\n=> Tel. Pembeli: %%telefonpembeli%%\r\n\r\n=> Alamat Pembeli(Jika Telah Di Isi):\r\n%%alamatpembeli%%\r\n\r\n\r\n=> Produk & Bayaran: %%jumlahpembayaran%%\r\n=> Kaedah Pembayaran: %%kaedahpembayaran%%\r\n\r\n=> Tarikh Pembayaran: %%tarikhpembayaran%%\r\n=> Masa Pembayaran: %%masapembayaran%%\r\n\r\n=> Bukti Pembayaran:\r\n%%buktipembayaran%%\r\n\r\n\r\n=> Nota Tambahan Pembeli (Jika Ada):\r\n%%notapembeli%%\r\n\r\n\r\n\r\n===========================================================\r\nData Sponsor / Agen Affiliate Yang Terlibat (Jika Ada)\r\n===========================================================\r\n\r\n=> ID Agen (Sponsor): %%idagen%%\r\n=> Komisyen Agen: %%komisyenagen%%\r\n=> Status Jualan: %%statuskomisyen%%\r\n\r\n\r\n===========================================================\r\nRekod Komputer Pelanggan Semasa Borang Tempahan Dikirimkan\r\n===========================================================\r\n\r\n=> No. IP: %%ippelanggan%%\r\n\r\n=> Tarikh: %%tarikhborang%%\r\n=> Masa: %%masaborang%%\r\n\r\n=> Browser: \r\n%%browserpelanggan%%\r\n\r\n===========================================================\r\n\r\nSilalah %%namaadmin%% semak data pengesahan pembelian ini\r\nmenerusi:\r\n\r\n1. Menyemak transaksi ke dalam akaun anda.\r\n2. Menyemak data affiliate yang terlibat.\r\n3. Jika ada agen affiliate terlibat, semak komisyennya.\r\n4. Kirimkan produk kepada pembeli, %%namapembeli%%\r\n\r\n\r\nSila simpan email ini untuk rujukan anda dimasa akan datang.\r\n\r\nSekian,\r\nSistem Affiliate', 'Salam sejahtera %%namaagen%%,\r\n\r\nAnda telah memohon untuk mendapatkan kembali password login\r\naffiliate bagi username %%idagen%% di:\r\n\r\n=> %%loginaffiliate%%\r\n\r\nUntuk maklumat %%namaagen%%, password tersebut tidak \r\ndapat dikembalikan. Jadi %%namaagen%% perlu RESET kepada password yang\r\nbaru.\r\n\r\nJika ingin meneruskan proses reset, sila layari ke link dibawah ini untuk reset kembali password anda.\r\n\r\n[+] %%urlresetpassword%%\r\n\r\nJika anda menghadapi sebarang masalah atau mempunyai sebarang pertanyaan, kirimkan pesanan anda kepada kami ke alamat %%emailsupport%%.\r\n\r\nSekian, terima kasih.\r\n\r\nIkhlas,\r\n%%namaadmin%%\r\n%%domain%%\r\n\r\n\r\n==============================================================\r\nSebagai langkah keselamatan, butiran anda dibawah telah direkod\r\n==============================================================\r\n\r\nIP Address Anda: %%ippelanggan%%\r\nMasa Permohonan Dibuat: %%masaborang%%\r\nTarikh Permohonan Dibuat: %%tarikhborang%%\r\nBrowser Yang Anda Gunakan: %%browserpelanggan%%\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', 'Salam sejahtera %%namaagen%%,\r\n\r\nPenukaran password login affiliate di  %%loginaffiliate%%\r\ntelah berjaya dilakukan.\r\n\r\nBerikut adalah maklumat login anda:\r\n\r\n==============================================\r\nMaklumat Akaun Login Affiliate\r\n==============================================\r\n\r\nURL Halaman Affiliate: \r\n=> %%loginaffiliate%%\r\n\r\nUsername: %%idagen%%\r\nPassword: %%passwordbaruagen%%\r\n\r\nLink Affiliate Anda:\r\n=> %%linkaffiliate%%\r\n\r\n==============================================\r\n\r\n\r\nJika anda menghadapi sebarang masalah atau mempunyai sebarang pertanyaan, kirimkan pesanan anda kepada kami di %%emailsupport%%.\r\n\r\nSekian, terima kasih.\r\n\r\nIkhlas,\r\n%%namaadmin%%\r\n%%domain%%\r\n\r\n\r\n==============================================================\r\nSebagai langkah keselamatan, butiran anda dibawah telah direkod\r\n==============================================================\r\n\r\nIP Address Anda: %%ippelanggan%%\r\nMasa Permohonan Dibuat: %%masaborang%%\r\nTarikh Permohonan Dibuat: %%tarikhborang%%\r\nBrowser Yang Anda Gunakan: %%browserpelanggan%%\r\n', 'Salam sejahtera, %%namaagen%%\r\n\r\nAnda telah berjaya menerima komisyen yang telah di\r\nsahkan (VERIFIED) untuk usaha promosi yang anda \r\njalankan bagi produk kami seperti berikut:\r\n\r\n\r\n=========================================\r\nButiran Produk Terlibat\r\n=========================================\r\n\r\nPromosi: %%namaproduk%%\r\nURL Jualan: %%linkaffiliate%%\r\n\r\nNama Produk & Harga Jualan: %%jualan%%\r\nJumlah Komisyen: %%komisyenagen%%\r\nStatus Komisyen: DISAHKAN (VERIFIED)\r\n\r\n\r\n=========================================\r\nMaklumat Pelanggan Anda\r\n=========================================\r\n\r\nNama Pelanggan: %%namapelanggan%%\r\nEmail Pelanggan: %%emailpelanggan%%\r\n\r\n\r\nNOTA: Anda boleh menghubungi pelanggan yang anda taja ini \r\nuntuk memberi sebarang BONUS atau SOKONGAN kepada beliau atas\r\nurusniaga yang telah beliau jalankan menerusi link affiliate anda.\r\n\r\nUntuk menyemak maklumat lanjut tentang komisyen anda, berikut \r\nadalah butiran yang anda perlukan:\r\n\r\n=========================================\r\nMaklumat Akaun Affiliate Anda\r\n=========================================\r\n\r\nURL Login Affiliate:\r\n=> %%loginaffiliate%%\r\n\r\nID Affiliate Anda: %%idagen%%\r\nPassword Anda: (tidak dipaparkan)\r\n\r\nNOTA: Jika anda lupa password, sila pohon password \r\nbaru di halaman agen atau hubungi kami di  %%emailsupport%%\r\n\r\nLink Promosi (Affiliate) Anda:\r\n=> %%linkaffiliate%%\r\n\r\n=========================================\r\n\r\n\r\n\r\nTeruskan usaha promosi anda untuk meraih lebih komisyen terhadap\r\nproduk kami.\r\n\r\nSekian, terima kasih.\r\n\r\nIkhlas,\r\n%%namaadmin%%\r\n%%domain%%', 'Salam sejahtera, %%namaagen%%\r\n\r\nTahniah! Pembayaran komisyen affiliate telah dilakukan \r\nke akaun anda.\r\n\r\nMaklumat pembayaran komisyen affiliate adalah seperti \r\nberikut:\r\n\r\n=========================================\r\nMaklumat Pembayaran Komisyen\r\n=========================================\r\n\r\nPromosi: %%namaproduk%%\r\nURL Jualan:  %%linkaffiliate%%\r\n\r\nID Affiliate Anda: %%idagen%%\r\nNama Anda: %%namaagen%%\r\n\r\nPemprosesan Bayaran: %%pemprosesanbayaran%%\r\nNo. Akaun: %%akaunbayaran%%\r\nPemegang Akaun (jika ada): %%pemilikakaun%%\r\n\r\nJumlah Komisyen Dibayar: %%currency%% %%jumlahkomisyenagen%%\r\nTarikh Bayaran Disahkan: %%tarikhbayaran%%\r\n\r\n=========================================\r\nMaklumat Akaun Affiliate Anda\r\n=========================================\r\n\r\nURL Login Affiliate:\r\n=> %%loginaffiliate%%\r\n\r\nID Affiliate Anda: %%idagen%%\r\nPassword Anda: (tidak dipaparkan)\r\n\r\nNOTA: Jika anda lupa password, sila pohon password \r\nbaru di halaman agen atau hubungi kami di %%emailsupport%%\r\n\r\nLink Promosi (Affiliate) Anda:\r\n=> %%linkaffiliate%%\r\n\r\n=========================================\r\n\r\nKami amat berbesar hati kerana telah berpeluang untuk\r\nbekerja sama dengan anda.\r\n\r\nRibuan terima kasih kami ucapkan kepada %%namaagen%% \r\nkerana telah mempromosikan produk kami.\r\n\r\nTeruskan usaha promosi yang %%namaagen%% jalankan dan raih\r\nlebih komisyen daripada kami.\r\n\r\nSekiranya %%namaagen%% mempunyai sebarang pertanyaan, sila\r\nhubungi kami di %%emailsupport%%\r\n\r\nSekian, terima kasih.\r\n\r\nIkhlas,\r\n%%namaadmin%%\r\n%%domain%%');

-- --------------------------------------------------------

--
-- Table structure for table `iklanadmin`
--

CREATE TABLE IF NOT EXISTS `iklanadmin` (
  `kandunganiklan` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `iklanadmin`
--

INSERT INTO `iklanadmin` (`kandunganiklan`) VALUES
('<p style=\"text-align: center;\">CikguHafis.com</p>');

-- --------------------------------------------------------

--
-- Table structure for table `notisagen`
--

CREATE TABLE IF NOT EXISTS `notisagen` (
  `datetime` varchar(100) NOT NULL,
  `kandungannotis` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notisagen`
--

INSERT INTO `notisagen` (`datetime`, `kandungannotis`) VALUES
('26/05/2020 [18:46:55]', '<h1 style=\"text-align: center;\"><span style=\"color: #ff0000;\">Syarat &amp; Peraturan Program Affiliate</span></h1>\r\n<p style=\"text-align: center;\">&nbsp;</p>\r\n<p>Agen Affiliate DILARANG sama sekali melakukan SPAM. Jika didapati mana - mana ahli yang melakukan SPAM, maka keahlian akan ditamatkan serta - merta. Komisyen yang terkumpul tidak akan dibayar kepada ahli yang melakukan SPAM. Oleh itu, silalah mengamalkan teknik promosi yang baik dan beretika.&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>Untuk setiap jualan yang terhasil menerusi link affiliate agen, nilai komisyen seperti berikut akan diberikan:</p>\r\n<p>&nbsp;</p>\r\n<ol>\r\n<li>PPL: RM3.00 Komisyen</li>\r\n<li>Online Group Coaching Bisnes Ebook: RM20.00 Komisyen</li>\r\n</ol>\r\n<p>&nbsp;</p>\r\n<p>Pembayaran komisyen yang telah di SAHkan dan terkumpul akan dilakukan pada setiap hujung bulan. Pastikan agen membekalkan butiran peribadi yang tepat.</p>\r\n<p>&nbsp;</p>\r\n<p>Selamat berpromosi!</p>\r\n<p>&nbsp;</p>\r\n<p>Ikhlas,</p>\r\n<p>Pengusaha.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `optinadmin`
--

CREATE TABLE IF NOT EXISTS `optinadmin` (
  `optincode` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `optinadmin`
--

INSERT INTO `optinadmin` (`optincode`) VALUES
(' ');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(191) NOT NULL,
  `product_price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `transaction_id` varchar(191) NOT NULL,
  `transaction_url` varchar(191) NOT NULL,
  `customer_name` varchar(191) NOT NULL,
  `customer_email` varchar(191) NOT NULL,
  `customer_phone` varchar(191) NOT NULL,
  `customer_address` text DEFAULT NULL,
  `status` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=212 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--


-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE IF NOT EXISTS `produk` (
  `idproduk` int(11) NOT NULL AUTO_INCREMENT,
  `namaproduk` varchar(191) NOT NULL,
  `hargaproduk` decimal(8,2) DEFAULT NULL,
  `komisyenproduk` decimal(8,2) NOT NULL,
  `produkUrl` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`idproduk`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`idproduk`, `namaproduk`, `hargaproduk`, `komisyenproduk`, `produkUrl`) VALUES
(1, 'Kuasa Bisnes Ebook - PPL', '0.00', '3.00', 'https://cikguhafis.com/kuasaebook'),
(2, 'Online Group Coaching Bisnes Ebook', '40.00', '20.00', 'http://onlinecoaching.cikguhafis.com'),
(3, 'Kuasa Bisnes Ebook - PPL ', '0.00', '3.00', 'https://cikguhafis.com/free_bos5angka/'),
(4, 'Online Group Coaching Buat Online Sales', '20.00', '10.00', 'https://buatonlinesales.com');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `idsales` int(11) NOT NULL AUTO_INCREMENT,
  `refid` varchar(30) NOT NULL,
  `jumlahpembayaran` varchar(250) NOT NULL,
  `kaedahpembayaran` varchar(250) NOT NULL,
  `transaction_id` varchar(191) DEFAULT NULL,
  `date` date DEFAULT '0000-00-00',
  `time` time DEFAULT '00:00:00',
  `browser` varchar(250) NOT NULL,
  `ipaddress` varchar(50) NOT NULL,
  `payment` decimal(8,2) DEFAULT NULL,
  `namapelanggan` varchar(250) NOT NULL,
  `emailpelanggan` varchar(250) NOT NULL,
  `statuspelanggan` varchar(250) NOT NULL,
  PRIMARY KEY (`idsales`)
) ENGINE=InnoDB AUTO_INCREMENT=3091 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales`
--


-- --------------------------------------------------------

--
-- Table structure for table `termadaftar`
--

CREATE TABLE IF NOT EXISTS `termadaftar` (
  `kandunganterma` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `termadaftar`
--

INSERT INTO `termadaftar` (`kandunganterma`) VALUES
('Saya sebagai bakal agen affiliate, telah BERSETUJU untuk mematuhi segala syarat dan terma program affiliate di laman web ini.\r\n\r\n1 .Saya faham bahawa sekiranya saya melanggar mana - mana syarat dan terma program affiliate ini, akaun saya boleh digantung ataupun dimansuhkan oleh pihak pengurusan tanpa sebarang notifikasi.\r\n\r\n2. Saya berjanji akan melakukan promosi secara beretika dan tidak akan sesekali melakukan aktiviti SPAM.\r\n\r\n3. Saya berjanji tidak akan menggunakan sebarang bahan promosi yang boleh merosakkan nama perniagaan laman web ini.\r\n\r\n4. Saya berjanji tidak akan menggunakan nama - nama organisasi, trademark, copyright, golongan professional dan apa jua bentuk nama yang dilindungi dalam aktiviti promosi saya.\r\n\r\n5. Saya mengakui bahawa segala butiran yang saya daftarkan di atas adalah butiran yang tepat dan sah.\r\n\r\nDengan menghantar butiran pendaftaran ini, saya akan tertakluk kepada syarat dan terma yang telah ditetapkan oleh pihak pengurusan laman web ini.');

-- --------------------------------------------------------

--
-- Table structure for table `videopromosi`
--

CREATE TABLE IF NOT EXISTS `videopromosi` (
  `number` int(5) NOT NULL AUTO_INCREMENT,
  `arahan` varchar(200) NOT NULL,
  `tajuk` varchar(200) NOT NULL,
  `kandungan` mediumtext NOT NULL,
  PRIMARY KEY (`number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
