<?
// PHPLOCKITOPT NOENCODE

/*
Script ini diolah dan diedit oleh Amirol Zolkifli. Edaran sah
hanya menerusi www.webjualan.com dan www.sistemaffiliate.com sahaja.
Tiada mana - mana bahagian olahan pada script ini dibenarkan di salin atau
ditiru.

Penggunaan script ini adalah dibawah tanggungan anda sendiri. Pihak penyedia
script tidak akan bertanggungjawab untuk segala musibah atau masalah
yang melanda ketika anda menggunakan script ini.
*/

// Please change the command below to english language if you wish to use english.


// Menu / Navigation ADMIN Area (header.php)

define('AFF_M_ADMINBERITA', 'Konfigurasi Berita');
define('AFF_M_CHANGEDETAILS', 'Ubah Profile');
define('AFF_M_CLICKTHROUGHS', 'Statistik Klik');
define('AFF_M_ADMINAREA', 'Halaman Utama');
define('AFF_M_ADMINCONFIGURATION', 'Konfigurasi');
define('AFF_M_ADMINPROFILE', 'Profil Admin');
define('AFF_M_ADMINSYSTEM', 'Sistem Affiliate');
define('AFF_M_ADMINPRODUCTS', 'Produk & Komisyen');
define('AFF_M_ADMINEMAIL', 'Template Email');
define('AFF_M_ADMINAFFTRACKING', 'Kod Tracking');
define('AFF_M_ADMINFORMCODE', 'Kod Borang');
define('AFF_M_ADMINAFFILIATE', 'Affiliate');
define('AFF_M_ADMINAFFILIATELIST', 'Senarai Agen');
define('AFF_M_ADMINAFFILIATESEARCH', 'Cari Agen');
define('AFF_M_ADMINSALES', 'Jualan');
define('AFF_M_ADMINSALESSEARCH', 'Cari Jualan');
define('AFF_M_ADMINSALESRECORD', 'Rekod Jualan');
define('AFF_M_ADMINPAYCOMMISSION', 'Bayar Komisyen');
define('AFF_M_ADMINSTATISTIC', 'Statistik');
define('AFF_M_ADMINSTATISTICCLICKS', 'Statistik Klik');
define('AFF_M_ADMINSTATISTICAFFILIATE', 'Statistik Affiliate');
define('AFF_M_ADMINSTATISTICTOPAFFILIATE', 'Statistik TOP Affiliate');
define('AFF_M_ADMINPROMOTION', 'Bahan Promosi');
define('AFF_M_ADMINBANNERS', 'Banners/Links');
define('AFF_M_ADMINARTICLES', 'Artikel Promosi');
define('AFF_M_ADMINVIDEOS', 'Video Promosi');
define('AFF_M_ADMININFORMATION', 'Informasi');
define('AFF_M_ADMINOPTIN', 'Autoresponder Admin');
define('AFF_M_ADMINNEWS', 'Berita Admin');
define('AFF_M_ADMINNOTIFICATION', 'Notifikasi Admin');
define('AFF_M_ADMINADVERTISE', 'Iklan Admin');
define('AFF_M_ADMINTERMS', 'Terma Pendaftaran');
define('AFF_M_ADMINHELP', 'Bantuan');
define('AFF_M_ADMINHELPFUNCTION', 'Fungsi Sistem');
define('AFF_M_ADMINHELPFAQ', 'Soalan Lazim');
define('AFF_M_ADMINHELPSCRIPTVERSION', 'Versi Skrip');
define('AFF_M_ADMINHELPSERVICES', 'Perkhidmatan');
define('AFF_M_ADMINHELPREQUEST', 'Tambah Fungsi');
define('AFF_M_ADMINLOGOUT', 'Log Out');


// Menu / Navigation MEMBER Area (header.php)

define('MEMBER_PAGE_TITLE', 'Halaman Agen');
define('AFF_M_MEMBERAREA', 'Halaman Utama');
define('AFF_M_MEMBERPROFILE', 'Profil Agen');
define('AFF_M_MEMBERNEWS', 'Informasi');
define('AFF_M_MEMBERSALES', 'Rekod Jualan');
define('AFF_M_MEMBERSTATISTIC', 'Statistik');
define('AFF_M_MEMBERSTATISTICCLICKS', 'Klik');
define('AFF_M_MEMBERSTATISTICTOPAFFILIATE', 'TOP Affiliate');
define('AFF_M_MEMBERPROMOTION', 'Bahan Promosi');
define('AFF_M_MEMBERPROMOTIONARTICLES', 'Artikel');
define('AFF_M_MEMBERPROMOTIONBANNERS', 'Banner');
define('AFF_M_MEMBERPROMOTIONVIDEOS', 'Video');
define('AFF_M_MEMBERSUPPORT', 'Bantuan');
define('AFF_M_MEMBERCONTACT', 'Borang Hubungi');
define('AFF_M_MEMBERLOGOUT', 'Log Out');



// global message

define('AFF_G_DATE', 'Tarikh');
define('AFF_G_TIME', 'Masa');
define('AFF_G_AFFID', 'Affiliate ID');
define('AFF_G_PASSWORD', 'Password');
define('AFF_G_USERNAME', 'Username');
define('AFF_G_SHOW', 'Paparkan Rekod Agen');
define('AFF_G_DELETE', 'Hapuskan');
define('AFF_G_BROWSER', 'Browser Pelanggan');
define('AFF_G_EARNINGS', 'Komisyen');
define('AFF_D_WARNING', '<b>AMARAN! </b>Adakah anda pasti? Semua data akan Terhapus dan tidak akan dapat dikembalikan!');
define('AFF_R_WARNING', '');
define('AFF_G_ACTION', 'Tindakan');
define('AFF_G_IP', 'IP');
define('AFF_G_IPPELANGGAN', 'IP Pelanggan');
define('AFF_G_PELANGGAN', 'Nama Pelanggan');
define('AFF_G_EMAILPELANGGAN', 'Email Pelanggan');
define('AFF_G_STATUSPELANGGAN', 'Status Pelanggan');
define('AFF_G_STATUS', 'Status');
define('AFF_G_SAHKOMISYEN', 'Tindakan');
define('AFF_G_PRODUKJUALAN', 'Item');
define('AFF_G_KAEDAHPEMBAYARAN', 'Transaksi');
define('AFF_G_AFFILIATELOGINPROFILE', 'Butiran Login Agen Affiliate');
define('AFF_G_AFFILIATELOGINCHANGED', 'Butiran Login Agen Affiliate Telah Ditukar!');


// General Message In Admin Area
define('AFF_AA_ADMINLOGINTITLE', 'Login Ke Ruangan Admin');
define('AFF_AA_ADMINLOGIN', 'Daftar Masuk [Log In]');
define('AFF_AA_ADMINCANNOTLOG', 'Harap Maaf. Tidak Dapat Login');
define('AFF_AA_ADMINNOTLOGGED', 'Admin Belum Mendaftar Masuk');
define('AFF_AA_ADMINCANNOTLOGNOTIFICATION', 'Notifikasi Login Admin Affiliate Gagal.');
define('AFF_AA_ADMINCHANGEPASSWORD', 'Butiran Login Admin Telah Berjaya Ditukar!');
define('AFF_AA_ADMINGREETING', 'Selamat Datang Admin');
define('AFF_AA_ADMINSTATISTIC', 'Statistik Keseluruhan Program Affiliate');
define('AFF_AA_ADMINTOPAFFILIATEINFO', 'Statistik TOP Agen Affiliate Terbaik!');
define('AFF_AA_TOTALAFFILIATE', 'Jumlah Keseluruhan Agen Affiliate');
define('AFF_AA_TOTALAFFILIATETITLE', 'orang');
define('AFF_AA_UNIT', 'Unit');
define('AFF_AA_TITLEAFFILIATE', 'Agen Affiliate');
define('AFF_AA_TITLESALESCOUNT', 'Jumlah Jualan');
define('AFF_AA_TITLECOMMISSIONEARNED', 'Komisyen');
define('AFF_AA_TOTALAFFILIATESALES', 'Jualan Affiliate');
define('AFF_AA_TOTALSALES', 'Jumlah Keseluruhan Jualan & Komisyen Agen');
define('AFF_AA_REKODJUALAN', 'Semak Rekod Jualan Sepenuhnya');
define('AFF_AA_REKODAFFILIATES', 'Semak Senarai Agen Berdaftar Sepenuhnya');
define('AFF_AA_TOTALCOMMISSION', 'Jumlah Keseluruhan Komisyen');
define('AFF_AA_TIADATOPAFFILITE', 'Tiada Top Affiliate Lagi');
define('AFF_AA_SEEALLTOPAFFILITE', 'Lihat Rekod Top Affiliate');
define('AFF_AA_INFOAGEN', 'Lihat Butiran Agen Affiliate');
define('AFF_AA_PAPARAGEN', 'Pilih ID Agen Yang Terlibat');
define('AFF_AA_PAPARAGENBUTTON', 'Papar Butiran Agen');
define('AFF_AA_AFFILIATESPAGES', 'Jumlah Keseluruhan Agen Affiliate');
define('AFF_AA_TIADABANNERPROMOSI', 'Anda Belum Menyediakan Banner Promosi');
define('AFF_AA_IDAFFILIATE', 'ID Agen');
define('AFF_AA_NAMAAFFILIATE', 'Nama Agen');
define('AFF_AA_EMAILAFFILIATE', 'Email Agen');
define('AFF_AA_NEGERIAFFILIATE', 'Lokasi Agen');
define('AFF_AA_TARIKHDAFTAR', 'Tarikh Mendaftar');
define('AFF_AA_IPDAFTAR', 'IP Pendaftaran');
define('AFF_AA_UPLINE', 'Ada UPLINE?');
define('AFF_AA_TIADAAGEN', 'Masih Belum Ada Agen Mendaftar');
define('AFF_AA_PHONEAFFILIATE', 'Tel. Agen');
define('AFF_AA_TODAYSALES', 'Jualan Pada Hari Ini ');
define('AFF_AA_TODAYSIGNUP', 'Agen Baru Mendaftar Hari Ini ');
define('AFF_AA_EXCLUSIVEOFFER', 'Tawaran Istimewa Untuk Admin');

define('AFF_AA_INFOCHANGED', 'Maklumat Telah Berjaya Diubah!');

// Text in pwjafflite_admin_main.php

$amaranbayarkomisyen = "<br />Berikut adalah <u>senarai terkumpul jumlah jualan dan komisyen yang telah DISAHKAN (VERIFIED)</u>.<br /><br />Semakan lengkap terhadap SETIAP jualan yang terhasil boleh dilihat pada menu <a href=\"pwjafflite_admin_sales.php\">Rekod Jualan</a>.<br />";

$topaffiliateadminnotis = "Berikut adalah data agen affiliate yang terpilih berdasarkan jumlah KESELURUHAN status jualan yang terhasil.<br /><br />Anda boleh melihat senarai lengkap data jualan agen affiliate menerusi menu <a href=\"pwjafflite_admin_sales.php\">Rekod Jualan</a> atau klik pada ID Agen untuk melihat statistik jualan mereka.";

$todaysalesinfo = "Berikut adalah rekod senarai jualan yang dihasilkan oleh agen affiliate pada hari ini, iaitu bersamaan $clientdate. Anda boleh melihat rekod penuh menerusi menu <a href=\"pwjafflite_admin_sales.php\">Rekod Jualan</a>.";

$todaysignupinfo = "Berikut adalah senarai agen affiliate yang baru mendaftar pada hari ini, iaitu bersamaan $clientdate.";

$admin_greeting_content = "Salam sejahtera $admininfo. Sudahkah $admininfo membaca informasi ini?";


// Text in Admin Configuration

define('AFF_AA_ADMINDETAILS', 'Butiran Peribadi Admin');
define('AFF_AA_ADMINSETTINGS', 'Konfigurasi Sistem Affiliate');
define('AFF_AA_ADMINUSERNAME', 'Username Admin');
define('AFF_AA_ADMINPASSWORD', 'Password Admin');
define('AFF_AA_ADMINNAME', 'Nama Admin');
define('AFF_AA_ADMINEMAIL', 'Email Login Admin');
define('AFF_AA_EMAILADMINSUPPORT', 'Email Bantuan Pelanggan');
define('AFF_AA_EMAILADMINPAYMENT', 'Email Terima Tempahan');
define('AFF_AA_NAMAPRODUK', 'Nama Perniagaan');
define('AFF_AA_NAMADOMAIN', 'Domain Web Jualan (TANPA http://)');
define('AFF_AA_FOLDERAFFILIATES', 'Folder Sistem Affiliates');
define('AFF_AA_FOLDERADMIN', 'Folder Admin Sistem Affiliates');
define('AFF_AA_DOMAINREDIRECT', 'Domain Redirect Tempahan (URL Penuh)');
define('AFF_AA_LANDINGPAGE', 'Fail Landing Page (Cth: index.php)');
define('AFF_AA_COOKIEEXPIRATION', 'Jangka Hayat Cookies Affiliate');
define('AFF_AA_COOKIEDOMAIN', 'Cookies KESELURUHAN Domain (Jika Perlu)');
define('AFF_AA_CARTATOPAFFILIATE', 'Bilangan Carta TOP Affiliate');
define('AFF_AA_CURRENCY', 'Matawang Sistem');
define('AFF_AA_LANGUAGE', 'Fail Bahasa (Cth: malay.php)');
define('AFF_AA_IDAFFILIATEPIS', 'ID Affiliate');
define('AFF_AA_TAHUNOPERASI', 'Tahun Operasi');
define('AFF_AA_ONOFFPENDAFTARAN', 'Ruangan Pendaftaran Affiliate');
define('AFF_AA_KODPENDAFTARAN', 'Kod Link Pendaftaran Affiliate');
define('AFF_AA_LINKPENDAFTARAN', 'Link Pendaftaran Rahsia (Jemputan VIP)');
define('AFF_AA_KODCAPTCHABORANG', 'Aktif Sistem Captcha Pada Borang Tempahan?');
define('AFF_AA_SUBMITSETTINGS', 'Kemaskini Konfigurasi Sistem Affiliate');
define('AFF_AA_SUBMITADMINPROFILE', 'Kemaskini Data Peribadi Admin');

define('AFF_AA_SETTINGSTITLE', 'Konfigurasi Sistem Affiliate Lite');

define('AFF_AA_USERNAMEMISSING', 'Username Admin Haruslah Ditetapkan');
define('AFF_AA_PWDMISSING', 'Password Admin Haruslah Di Isi');
define('AFF_AA_ADMINNAMEMISSING', 'Nama Admin Haruslah Ditetapkan');
define('AFF_AA_EMAILADMINMISSING', 'Email Admin Haruslah Ditetapkan');
define('AFF_AA_EMAILSUPPORTMISSING', 'Email Bantuan Pelanggan Haruslah Ditetapkan');
define('AFF_AA_EMAILPAYMENTMISSING', 'Email Penerimaan Butiran Tempahan Haruslah Ditetapkan');
define('AFF_AA_NAMAPRODUKMISSING', 'Nama Produk / Perniagaan Haruslah Ditetapkan');
define('AFF_AA_NAMADOMAINMISSING', 'URL Domain Web Jualan Haruslah Ditetapkan');
define('AFF_AA_FOLDERAFFILIATESMISSING', 'Sila Isikan Nama Folder Sistem Affiliate Ini');
define('AFF_AA_DOMAINREDIRECTMISSING', 'Sila Tetapkan URL Redirect Selepas Borang Tempahan Dikirimkan');
define('AFF_AA_LANDINGPAGEMISSING', 'Sila Tetapkan HALAMAN UTAMA Web Jualan Untuk Tracking');
define('AFF_AA_COOKIEEXPIRATIONMISSING', 'Sila Tetapkan JANGKA HAYAT COOKIES Yang Ingin Di Tanam');
define('AFF_AA_CARTATOPAFFILIATEMISSING', 'Sila Tetapkan Bilangan Paparan Carta TOP Affiliate');
define('AFF_AA_CURRENCYMISSING', 'Tetapkan Nilai Matawang Yang Ingin Digunakan Dalam Sistem');
define('AFF_AA_LANGUAGEMISSING', 'Sila Masukkan Nama Fail Bahasa Yang Ingin Digunakan');
define('AFF_AA_KODPENDAFTARANMISSING', 'Nilai Kod Pendaftaran Tidak Dimasukkan');
define('AFF_AA_SETTINGCHANGED', 'Konfigurasi Sistem Berjaya Diubah!');

define('AFF_AA_DETAILSLINK', 'Detail');
define('AFF_AA_DELETELINK', 'Hapuskan');


$systemconfigurationinfo = "<br />Berikut adalah konfigurasi sistem affiliate yang akan digunakan untuk mengoperasikan program affiliate anda.<br /><br />";

// Message For Invoice & PAID Status

define('AFF_AA_INVOICEINFO', 'Resit Pembayaran Komisyen');
define('AFF_AA_INVOICEAGEN', 'Butiran Peribadi Agen Affiliate');
define('AFF_AA_INVOICEPAYINFO', 'Jumlah Komisyen Perlu Dibayar');
define('AFF_AA_INVOICEPAYINFOSUM', 'Jumlah Komisyen Keseluruhan');
define('AFF_AA_INVOICEPAYINFODATE', 'Tarikh Invoice Dikeluarkan');
define('AFF_AA_INVOICEPAY', 'Pembayaran Komisyen Kepada');
define('AFF_AA_INVOICEDONE', 'Diatas adalah invoice butiran pembayaran komisyen untuk bulan ini. Terima kasih kerana telah berurusniaga dengan pihak kami.');
define('AFF_AA_INVOICESIGNATURE', 'Yang Benar');
define('AFF_AA_COMMISSIONPAID', 'Tahniah! Komisyen Telah Dibayar!');
define('AFF_AA_PAYMENTPROCESSOR', 'Pemprosesan Bayaran');
define('AFF_AA_PAYMENTACCOUNT', 'No. Akaun Bayaran');
define('AFF_AA_PAYMENTACCOUNTHOLDER', 'Pemilik Akaun');
//define('AFF_AA_TOTALCOMMISSION', 'Jumlah Komisyen Dibayar');
define('AFF_AA_COMMISSIONPAIDDATE', 'Tarikh Bayaran');
define('AFF_AA_COMMISSIONPAIDTITLE', 'Notifikasi Komisyen Dibayar Telah Dikirim');
define('AFF_AA_COMMISSIONPAIDSTATUS', 'Maklumat komisyen yang terlibat telahpun dilabel sebagai dibayar (PAID) dan notifikasi pembayaran komisyen telah dikirimkan kepada agen affiliate berikut:');
define('AFF_AA_KEMBALIBAYARKOMISYEN', 'Kembali Ke Halaman Bayar Komisyen');





// Message For index.php (Member Area)

define('AFF_I_INFOLOG', 'Login Ke Ruangan Agen');
define('AFF_I_CANNOTLOG', 'Harap Maaf. Tidak Dapat Login');
define('AFF_I_NOTLOGGED', 'Affiliate Belum Daftar Masuk');
define('AFF_I_LOGBUTTON', 'Daftar Masuk [Login]');
define('AFF_I_NOTAFFILIATE', 'Jadi Agen Pemasaran Kami');
define('AFF_I_AFFILIATEREGISTRATIONOFF', 'Pendaftaran Agen Affiliate Ditutup');
define('AFF_I_SIGNUP', 'Klik Di Sini Untuk Mendaftar');
define('AFF_I_LUPAPASSWORDINFO', 'Terlupa Password Login?');
define('AFF_I_LUPAPASSWORDBUTTON', 'Dapatkan Kembali Password');


// pwjafflite_thankyou.php

define('AFF_TY_TITLE', 'Pendaftaran Anda Telah Berjaya!');

$instruction_page_thankyou = "
Terima kasih kerana telah mendaftar sebagai rakan affiliate kami. Kami amat gembira kerana anda sudi bersama - sama kami menjalankan perniagaan ini.
<br /><br />
Silalah semak email anda sekarang untuk mendapatkan butiran login anda. Jika tiada email daripada kami di dalam <font color=#FF0000>INBOX</font>, sila semak di dalam folder <font color=#FF0000>SPAM/JUNK/BULK</font>.
<br /><br />Jika masih tiada email daripada sistem kami dalam tempoh 24 jam, sila maklumkan kepada kami.
<br /><br />
Sekian, terima kasih!
<br />
$admininfo
<br /><br /><div align=\"center\">[ <a href=\"index.php\">Klik Di Sini Untuk Kembali Halaman Utama</a> ]</div>

";


// Admin Area - pwjafflite_affiliate_profile.php

define('AFF_AD_PASSEMAILCHANGED', 'Maklumat Password / Email Agen Telah Berjaya Diubah!');
define('AFF_AD_AFFPROFILECHANGED', 'Maklumat Peribadi Agen Telah Berjaya Diubah!');
define('AFF_AD_USERNAME', 'ID / Username Agen');
define('AFF_AD_PASSWORD', 'Password Agen');
define('AFF_AD_EMAILAGEN', 'Email Agen');
define('AFF_AD_UPDATEPASSEMAIL', 'Kemaskini Data Login Agen');
define('AFF_AD_UPDATEAFFDETAILS', 'Kemaskini Data Peribadi Agen');
define('AFF_AD_NOAFFILIATESELECTION', 'Anda Tidak Memilih Agen Affiliate Untuk Paparan Rekod');

$affiliate_profile_info = "Admin boleh tukar password dan email agen affiliate APABILA mereka memohon sedemikian. Sila berhati - hati untuk proses penukaran ini.";

$affiliate_profile_info2 = "Admin boleh tukar butiran peribadi agen affiliate APABILA mereka memohon sedemikian. Sila berhati - hati untuk proses penukaran ini.";

// details.php - pwjafflite_member_profile.php

define('AFF_MA_PROFILECHANGED', 'Maklumat Akaun Affiliate Anda Telah Berjaya Diubah!');
define('AFF_MA_AFFUSERNAME', 'ID / Username Anda');
define('AFF_MA_AFFPASSWORD', 'Password Anda');
define('AFF_MA_AFFUPDATEBUTTON', 'Kemaskini Data Peribadi');
define('AFF_MA_AFFNODATA', 'Tiada Rekod Peribadi? Sila Hubungi Admin');

$instruction_page_profile = "<font color=#FF0000>NOTA:</font> Anda boleh mengubah butiran password dan email anda di sini.";

$instruction_page_profile2 = "<font color=#FF0000>NOTA:</font> Pastikan maklumat yang di isi pada ruangan butiran peribadi anda adalah benar. Ini adalah untuk memudahkan pihak kami berurusan dengan pihak anda di masa hadapan seperti pembayaran komisyen.<br><br>Pihak kami tidak akan bertanggungjawab sekiranya anda tidak mendapat keuntungan yang sepatutnya disebabkan oleh maklumat yang tidak tepat dan sah.";


// pwjafflite_clicks.php

define('AFF_C_CLICKSINFO', 'Statistik Lawatan Pelawat / Prospek');
define('AFF_C_CLICKS', 'Jumlah Klik Terhadap Link Affiliate Anda');
define('AFF_C_REFERREDFROM', 'Sumber Trafik');
define('AFF_C_REFERRER', 'Agen');
define('AFF_C_REFERRERURL', 'Sumber Trafik');
define('AFF_C_CLICKSFROM', 'Statistik Klik Daripada Agen');
define('AFF_C_TOTALCLICK', 'Jumlah Klik Keseluruhan');
define('AFF_C_SHOWCLICKSFOR', 'Paparkan Senarai Lawatan/Klik Untuk');
define('AFF_C_INFO', 'Statistik Trafik Ke Link Affiliate Agen: ');
define('AFF_C_LAST20', 'Senarai 20 Lawatan/Klik Terakhir');
define('AFF_C_TIADAKLIK', 'Belum Ada Rekod Statistik Trafik');
define('AFF_C_EMAILTIDAKSET', 'Email Admin Belum Ditetapkan');


// pwjafflite_affiliate_statistic.php

define('AFF_AC_STATISTICTITLE', 'Statistik Peribadi Agen');
define('AFF_AC_STATISTICCHOOSE', 'Carian Statistik & Maklumat Agen ');
define('AFF_AC_STATISTICSALES', 'Statistik Jualan Daripada Agen');
define('AFF_AC_STATISTICPROBLEM', 'Tiada Rekod Butiran Agen Yang Dipilih');
define('AFF_AC_STATISTICPROBLEMCLICK', 'Tiada Rekod Statistik Trafik');
define('AFF_AC_STATISTICPROBLEMSALES', 'Tiada Rekod Statistik Jualan');
define('AFF_AC_STATISTICBUTTON', 'Paparkan Statistic Agen');
define('AFF_AC_STATISTICPROBLEMTOPAFFILIATE', 'Tiada Rekod Top Affiliate Lagi');


// pwjafflite_admin_sales.php

define('AFF_AS_STATUSCHOOSE', 'Lihat Rekod Jualan Berdasarkan Status');
define('AFF_AS_STATUSOPTION', 'Paparkan Rekod Jualan Berstatus');
define('AFF_AS_STATUSJUALANTITLE', 'Statistik Jualan Keseluruhan');
define('AFF_AS_STATUSTOTALSALES', 'Jumlah Jualan Yang Direkod');
define('AFF_AS_STATUSTOTALCOMMISSION', 'Jumlah Komisyen Yang Direkod');
define('AFF_AS_STATUSNORECORD', 'Masih Belum Ada Rekod Jualan');
define('AFF_AS_SALESCOMMISSIONTITLE', 'Rekod Jualan & Komisyen Agen');
define('AFF_AS_SALESSTATUS', 'Rekod Keseluruhan Jualan Berstatus');
define('AFF_AS_STATUSPENDING', 'PENDING');
define('AFF_AS_STATUSCANCELLED', 'CANCELLED');
define('AFF_AS_STATUSVERIFIED', 'VERIFIED');
define('AFF_AS_STATUSPAID', 'PAID');
define('AFF_AS_STATUSALL', 'ALL STATUS');
define('AFF_AS_STATUSVIEW', 'Papar Status Komisyen');
define('AFF_AS_SAH', 'Adakah Anda Bersetuju Untuk Sahkan Maklumat Pembelian Ini?');
define('AFF_AS_EMAILKOMISYEN', 'Tahniah! Anda Menerima Komisyen!');
define('AFF_AS_ALREADYVERIFIED', 'Rekod komisyen yang dipilih sudahpun diSAHkan. Anda tidak boleh "undo". Ia hanya boleh dihapuskan sahaja.');
define('AFF_AS_ALREADYPAID', 'Rekod komisyen yang dipilih sudahpun diBAYAR. Anda tidak boleh "undo". Ia hanya boleh dihapuskan sahaja.');
define('AFF_AS_NOITEM', 'Anda Tidak Memilih Data Dari Rekod Yang Tersenarai atau Item Tidak Wujud');


// pwjafflite_affiliate_search.php

define('AFF_AS_AFFILIATESEARCHTITLE', 'Cari Agen Affiliate');
define('AFF_AS_AFFILIATESEARCHKEYWORD', 'Katakunci Carian');
define('AFF_AS_AFFILIATESEARCHCATEGORY', 'Kategori Carian');
define('AFF_AS_AFFILIATESEARCHID', 'ID Agen');
define('AFF_AS_AFFILIATESEARCHNAME', 'Nama Agen (First Name)');
define('AFF_AS_AFFILIATESEARCHEMAIL', 'Email Agen');
define('AFF_AS_AFFILIATESEARCHBUTTON', 'Lakukan Carian');
define('AFF_AS_AFFILIATENORECORD', 'Tiada Sebarang Rekod Dijumpai');
define('AFF_AS_AFFILIATENOINPUT', 'Sila Masukkan Katakunci Carian Berdasarkan Kategori');

$affiliate_search_info = "<br />Masukkan kata kunci carian berdasarkan kategori yang disediakan.<br /><br />";


// pwjafflite_sales_search.php

define('AFF_AS_SALESSEARCHTITLE', 'Cari Jualan Affiliate');
define('AFF_AS_SALESSEARCHKEYWORD', 'Katakunci Carian');
define('AFF_AS_SALESSEARCHCATEGORY', 'Kategori Carian');
define('AFF_AS_SALESSEARCHID', 'ID Affiliate');
define('AFF_AS_SALESSEARCHNAME', 'Nama Pembeli');
define('AFF_AS_SALESSEARCHEMAIL', 'Email Pembeli');
define('AFF_AS_SALESSEARCHPRODUCT', 'Nama / Harga Produk');
define('AFF_AS_SALESSEARCHPROCESSOR', 'Pemprosesan Pembayaran');
define('AFF_AS_SALESSEARCHDATE', 'Tarikh Pembelian (Format: YYYY-MM-DD)');
define('AFF_AS_SALESSEARCHTIME', 'Masa Pembelian (Format: 24 Hours)');
define('AFF_AS_SALESSEARCHIP', 'IP Komputer Pembeli');
define('AFF_AS_SALESSEARCHBUTTON', 'Lakukan Carian');
define('AFF_AS_SALESNORECORD', 'Tiada Sebarang Rekod Dijumpai');
define('AFF_AS_SALESNOINPUT', 'Sila Masukkan Katakunci Carian Berdasarkan Kategori');

$sales_search_info = "<br />Masukkan kata kunci carian berdasarkan kategori yang disediakan.<br /><br />";


// pwjafflite_admin_sahkomisyen.php

define('AFF_AS_TAJUKSAHPEMBELIAN', 'Maklumat Pembelian Telah Disahkan');
define('AFF_AS_KANDUNGANSAHPEMBELIAN', 'Maklumat pembelian yang dipilih telahpun disahkan dan notifikasi komisyen telah dikirimkan kepada agen affiliate berikut:');
define('AFF_AS_IDAGEN', 'ID Agen');
define('AFF_AS_NAMAAGEN', 'Nama Agen');
define('AFF_AS_EMAILAGEN', 'Email Agen');
define('AFF_AS_NAMAPELANGGAN', 'Nama Pelanggan');
define('AFF_AS_EMAILPELANGGAN', 'Email Pelanggan');
define('AFF_AS_KEMBALI', 'Kembali Ke Halaman Rekod Jualan');

//pwjafflite_commisison_paid.php
define('AFF_AS_NOVERIFIEDCOMMISSION', 'Tiada rekod jualan yang telah disahkan untuk pembayaran bagi ID agen affiliate yang dipilih.');



// pwjafflite_sales.php

define('AFF_S_INFOAGEN', 'Lihat Rekod Jualan Agen Affiliate');
define('AFF_S_SALESADMININFO', 'Statistik Jualan Keseluruhan');
define('AFF_S_SALESINFO', 'Statistik Jualan Anda');
define('AFF_S_SALES', 'Jumlah Jualan Dari Link Anda');
define('AFF_S_EARNED', 'Keuntungan Anda');
define('AFF_S_TOTAL', 'Jumlah Keuntungan Anda');
define('AFF_S_IP', 'IP Address Pembeli');
define('AFF_S_SHOWSALESFOR', 'Paparkan Rekod Jualan Daripada');
define('AFF_S_TOTALSALES', 'Jumlah Jualan Menerusi Agen Affiliate');
define('AFF_S_SALESFROM', 'Jualan Daripada');
define('AFF_S_FORSITE', 'Untuk Web Anda');
define('AFF_S_TOTALAMOUNT', 'Jumlah Komisyen Terkumpul');
define('AFF_S_TIADAJUALAN', 'Belum Ada Jualan Daripada Agen Affiliate');
define('AFF_S_TIADAJUALANID', 'Tiada Rekod Jualan Untuk ID Yang Dipilih');
define('AFF_S_TIADAREKODJUALAN', 'Tiada Rekod Jualan Untuk Di UbahSuai ATAU Kod Validasi Tidak Tepat');
define('AFF_S_PERTUKARANJUALAN', 'Jualan / Komisyen Telah DiubahSuai?');
define('AFF_S_PERTUKARANREKODJUALAN', 'Rekod Jualan / Komisyen Berjaya Diubah!');


// pwjafflite_banners.php

define('AFF_B_LINKINFO', 'Link Affiliate Anda');
define('AFF_B_BANNERSINFO', 'Banner Promosi Untuk Laman Web Anda');

define('AFF_B_BANNERSOFFER', 'Informasi Banner Promosi');
define('AFF_B_ADDBANNER', 'Isikan Butiran Banner Baru Yang Diperlukan');
define('AFF_B_ADDBANNERBUTTON', 'Tambah Banner Promosi');
define('AFF_B_BANNERNAME', 'Nama Banner');
define('AFF_B_BANNERNAMEERROR', 'Sila Masukkan Nama Banner');
define('AFF_B_BANNERURL', 'Banner URL');
define('AFF_B_BANNERURLERROR', 'Sila Masukkan Alamat Penuh Ke Imej Banner');
define('AFF_B_BANNERDESCRIPTION', 'Maklumat Banner');
define('AFF_B_EDITBANNER', 'Ubah Suai');
define('AFF_B_DELETEBANNER', 'Hapuskan');
define('AFF_B_CHANGEBANNER', 'Kemaskini Butiran Banner');
define('AFF_B_BANNERADDED', 'Banner Promosi Yang Telah Di Masukkan');
define('AFF_P_EDITBANNERINFO', 'ID Banner Yang Ingin Diubah');
define('AFF_B_BANNERSUCCESSADDED', 'Banner Promosi Telah Berjaya Di Masukkan!');




$arahanbanner = "Anda boleh memasukkan banner promosi untuk kegunaan agen affiliate anda.<br><br>Banner yang disediakan boleh membantu meningkatkan aktiviti pemasaran agen affiliate dan hasil jualan terhadap produk anda.";

$arahaneditbanner = "Di bawah ini adalah kandungan banner promosi yang telah dimasukkan sebelum ini.<br><br>Untuk mengubahsuai kandungan yang sedia ada, klik pada menu <b>Ubah Suai</b>. Untuk menghapuskan banner promosi dari database, klik pada menu <b>Hapuskan</b>.";

$kandunganbanner = "Kandungan untuk dimasukkan ke dalam email.<br><br>Sebaik - baiknya kandungan ini diolah mengikut gaya penyampaian agen sendiri.";


// pwjafflite_member_contact.php

define('AFF_MA_CONTACTFORMTITLE', 'Borang Hubungi / Pertanyaan');
define('AFF_MA_CONTACTFORMNAME', 'Nama Anda');
define('AFF_MA_CONTACTFORMEMAIL', 'Email Anda');
define('AFF_MA_CONTACTFORMCONTENTTITLE', 'Tajuk Pesanan Anda');
define('AFF_MA_CONTACTFORMCONTENT', 'Pesanan Anda');
define('AFF_MA_CONTACTNAMEMISSING', 'Sila isi nama anda');
define('AFF_MA_CONTACTEMAILMISSING', 'Sila isi email anda');
define('AFF_MA_CONTACTEMAILMISSINGVALID', 'Sila isi email yang sah sahaja!');
define('AFF_MA_CONTACTTITLEMISSING', 'Sila isi tajuk pesanan anda');
define('AFF_MA_CONTACTCONTENTMISSING', 'Sila isi kandungan pesanan anda');
define('AFF_MA_CONTACTEMAILCOPY', 'Salinan Email Pertanyaan Anda');
define('AFF_MA_CONTACTEMAILSENT', 'Email Pesanan Anda Telah Berjaya Dikirimkan!');
define('AFF_C_CONTACTPROBLEM', 'Terdapat masalah dengan script hubungi. Butiran config tidak dijumpai!');
//define('AFF_C_EMAILTIDAKSET', 'Alamat email admin belum ditetapkan. Sila rujuk butiran config.');
define('AFF_C_CONTACT', 'Anda Boleh Menghubungi Kami Dengan Menghantar E-mail Kepada');

$arahan_contact = "
Sila isikan borang dibawah untuk menghubungi pihak kami.
";



// Language variables pwjafflite_contact.php

$lang_title = "Hantarkan Pesanan Anda Kepada Kami";
$lang_notice = "Sila isi semua butiran yang diperlukan untuk mengirimkan pesanan kepada kami.";
$lang_name = "Nama Anda";
$lang_youremail = "Alamat Email";
$lang_subject = "Tajuk Pesanan";
$lang_message = "Kandungan Pesanan";
$lang_confirmation = "Masukkan Nombor Pengesahan";
$lang_submit = "Hantar Pesanan Anda";

// Mesej Kesilapan / pwjafflite_contact.php

$lang_error = "Pesanan anda tidak dapat dikirim kerana terdapat masalah berikut:";
$lang_noname = "Anda tidak memasukkan nama anda";
$lang_noemail = "Anda tidak memasukkan alamat email anda";
$lang_nosubject = "Anda tidak memasukkan tajuk pertanyaan anda";
$lang_nomessage = "Anda tidak mengisikan pertanyaan anda";
$lang_nocode = "Anda tidak memasukkan nombor pengesahan";
$lang_wrongcode = "Anda telah memasukkan nombor pengesahan yang salah";
$lang_invalidemail = "Alamat email yang anda masukkan adalah tidak sah.";


// Mesej Berjaya pwjafflite_contact.php

$lang_sent = "Pesanan anda telah dikirimkan seperti berikut:";


// Colour of error message pwjafflite_contact.php

$error_colour = "red"; // Must use HTML compatible colour


//pwjlite_register.php

define('AFF_R_INFOREGISTER', 'Borang Pendaftaran Agen Affiliate');
define('AFF_R_DETAILS', 'Butiran Peribadi Agen Affiliate');
define('AFF_R_TITLE', 'Pangkat');
define('AFF_R_FIRSTNAME', 'Nama Pertama Anda');
define('AFF_R_LASTNAME', 'Nama Terakhir Anda');
define('AFF_R_EMAIL', 'Alamat Email Anda');
define('AFF_R_WEBSITE', 'Website Anda (Jika Ada)');
define('AFF_R_STREET', 'Alamat Surat Menyurat');
define('AFF_R_CITY', 'Bandar');
define('AFF_R_STATE', 'Negeri');
define('AFF_R_POSTCODE', 'Poskod');
define('AFF_R_COUNTRY', 'Negara');
define('AFF_R_PHONE', 'No. Telefon');
define('AFF_R_PAYMENTTYPEINFO', 'Pilihan Pemprosesan Pembayaran Komisyen');
define('AFF_R_PAYMENTTYPE', 'Pilihan Pemprosesan');
define('AFF_R_BANK', 'Nama Bank / Paypal');
define('AFF_R_ACCOUNTNO', 'No. Akaun Bank / Paypal');
define('AFF_R_PAYTO', 'Nama Penerima Bayaran');
define('AFF_R_LOGININFO', 'Butiran Login Akaun Sistem Affiliate');
define('AFF_R_USERNAME', 'Username Pilihan');
define('AFF_R_PASSWORD', 'Password Pilihan (Minima 4 karektor)');
define('AFF_R_PASSWORD2', 'Isi Semula Password');
define('AFF_R_TERMS', 'Akuan Perjanjian Pendaftaran Agen Affiliate');
define('AFF_R_TERMSAGREE', 'Saya Bersetuju');
define('AFF_R_TERMSNOTAGREE', 'Saya TIDAK Bersetuju');
define('AFF_R_SUBMITBUTTON', 'Hantar Pendaftaran');

define('AFF_SI_REGISTRATIONNOTAUTHORIZED', 'Pendaftaran Program Affiliate Ini Tidak Dapat Dilakukan!');
define('AFF_SI_FIRSTNAMEMISSING', 'Sila isikan NAMA PERTAMA anda (First Name)');
define('AFF_SI_LASTNAMEMISSING', 'Sila isikan NAMA TERAKHIR anda (Last Name)');
define('AFF_SI_EMAILMISSING', 'Alamat EMAIL tidak diisi!');
define('AFF_SI_EMAILNOTVALID', 'Sila isikan alamat EMAIL yang sah sahaja!');
define('AFF_SI_EMAILSUDAHADA', 'Alamat email yang diisi sudah ada di dalam database kami! Sila pohon password anda kembali.');
define('AFF_SI_ADDRESSMISSING', 'Sila isikan ALAMAT surat menyurat anda!');
define('AFF_SI_TOWNMISSING', 'Sila isikan BANDAR kediaman anda!');
define('AFF_SI_STATEMISSING', 'Sila isikan NEGERI kediaman anda!');
define('AFF_SI_POSKODMISSING', 'Sila isikan POSKOD kediaman anda!');
define('AFF_SI_PHONEMISSING', 'Sila isikan no. TELEFON anda!');
define('AFF_SI_PEMPROSESANMISSING', 'Sila pilih pemprosesan pembayaran yang ingin digunakan!');
define('AFF_SI_ACCOUNTMISSING', 'Sila isikan no. AKAUN bank atau alamat akaun paypal anda!');
define('AFF_SI_USEREXISTS', 'Username yang diisi telah digunakan. Sila pilih username yang lain.');
define('AFF_SI_UNAMEMISSING', 'Butiran USERNAME harus diisi! Hanya HURUF dan DIGIT sahaja dibenarkan.');
define('AFF_SI_PWDMISSING', 'Sila isikan PASSWORD! Minima 4 karektor antara HURUF dan DIGIT sahaja.');
define('AFF_SI_PWDNOTMATCH', 'Password PERTAMA dan password KEDUA yang di isi tidak sama!');
define('AFF_SI_PWDNOTMATCHDATABASE', 'Password yang dimasukkan tidak sama dalam database!');
define('AFF_SI_MINIMUMCHAR', 'Sila isikan sekurang - kurangnya 4 patah perkataan untuk setiap ruang!');
define('AFF_SI_TERMS', 'Anda haruslah BERSETUJU dengan perjanjian pendaftaran affiliate.');
define('AFF_SI_EMAILAFFILIATEWELCOME', 'Selamat Datang Agen Affiliate!');
define('AFF_SI_PASSWORDREQUEST', 'Permohonan Pertukaran Password');


$instruction_page_register = "
Sila isikan ruangan dibawah dengan butiran yang benar dan tepat sahaja.
<br /><br />
Sebarang maklumat yang salah atau tidak benar boleh menyebabkan akaun anda digantung atau dihapuskan daripada sistem kami tanpa sebarang notis.
<br /><br />
<font color=#FF0000>*</font> menandakan ruangan tersebut <font color=#FF0000>WAJIB</font> diisikan.
<br /><br /><font color=#FF0000>NOTA</font>: Jika anda telah mendaftar dan dalam tempoh 24 jam tidak menerima sebarang email maklumat pendaftaran anda daripada sistem ini, sila hubungi kami.
";

$error_Registration = "
Harap Maaf. Pendaftaran Program Affiliate ini tidak dibuka atau mungkin kod pendaftaran adalah tidak sah. Sila hubungi pihak pengurusan untuk maklumat lanjut.
";

// Arahan Artikel promosi

define('AFF_P_ARTICLEADDINFO', 'Informasi Artikel Promosi');
define('AFF_P_TAJUK', 'Tajuk Email Follow Up');
define('AFF_P_ARTICLEADDBUTTON', 'Tambah Artikel Promosi');
define('AFF_P_ARTICLEADDEDTITLE', 'Artikel Promosi Yang Telah Di Masukkan');
define('AFF_P_MEMBERARTICLESTITLE', 'Artikel Promosi Untuk Kegunaan Anda');
define('AFF_P_PROMOSIEDIT', 'Ubah Suai');
define('AFF_P_PROMOSIDELETE', 'Hapuskan');
define('AFF_P_ARTICLENOTE', 'Nota Artikel');
define('AFF_P_ARTICLETITLE', 'Tajuk Artikel');
define('AFF_P_ARTICLECONTENT', 'Kandungan Artikel');
define('AFF_P_DELETE', 'Adakah Anda Bersetuju Untuk Menghapuskan Data Ini?');
define('AFF_P_EDIT', 'Adakah Anda Bersetuju Untuk Ubahsuai Data Ini?');
define('AFF_P_ARTICLEBUTTONADD', 'Tambah Artikel Promosi');
define('AFF_P_ARTICLEADDTITLE', 'Isikan Butiran Artikel Baru Yang Diperlukan');
define('AFF_P_ARTICLEPURPOSEMISSING', 'Sila Isikan Nota / Arahan Untuk Artikel Ini');
define('AFF_P_ARTICLETITLEMISSING', 'Sila Isikan Tajuk Artikel Ini');
define('AFF_P_ARTICLECONTENTMISSING', 'Sila Isikan Kandungan Artikel Yang Diperlukan');
define('AFF_P_ARTICLEEDITINFO', 'ID Artikel Yang Ingin Diubah');
define('AFF_P_ARTICLECHANGEBUTTON', 'Ubah Suai Artikel');
define('AFF_P_NOARTICLE', 'Tiada Artikel Promosi Dimasukkan Lagi');

$article_add_guide = "
Anda boleh menggunakan TAG berikut pada KANDUNGAN ARTIKEL anda untuk membolehkan data agen terpapar secara AUTOMATIK di dalam kandungan artikel yang anda sediakan:<br />
<ul>
<li><font color=\"#FF0000\">%%namaagen%%</font> untuk memaparkan nama agen affiliate.</li>
<li><font color=\"#FF0000\">%%linkaffiliate%%</font> untuk memaparkan link agen affiliate.</li>
</ul>
NOTA: TAG ini hanya boleh digunakan pada ruang KANDUNGAN ARTIKEL sahaja.
";


// Arahan Video Ppromosi

define('AFF_P_VIDEOADDINFO', 'Informasi Video Promosi');
define('AFF_P_VIDEOADDBUTTON', 'Tambah Video Promosi');
define('AFF_P_VIDEOADDEDTITLE', 'Video Promosi Yang Telah Di Masukkan');
define('AFF_P_VIDEOEDIT', 'Ubah Suai');
define('AFF_P_VIDEODELETE', 'Hapuskan');
define('AFF_P_VIDEODELETECONFIRM', 'Adakah Anda Bersetuju Untuk Menghapuskan Data Ini?');
define('AFF_P_VIDEONOTE', 'Nota Video');
define('AFF_P_VIDEOTITLE', 'Tajuk Video');
define('AFF_P_VIDEOCONTENT', 'Code Embed Video');
define('AFF_P_VIDEOBUTTONADD', 'Tambah Video Promosi');
define('AFF_P_VIDEOADDTITLE', 'Isikan Butiran Video Baru Yang Diperlukan');
define('AFF_P_VIDEOPURPOSEMISSING', 'Sila Isikan Nota / Arahan Untuk Video Ini');
define('AFF_P_VIDEOTITLEMISSING', 'Sila Isikan Tajuk Video Ini');
define('AFF_P_VIDEOCONTENTMISSING', 'Sila Isikan Code Embed Video Promosi Yang Diperlukan');
define('AFF_P_VIDEOEDITINFO', 'ID Video Yang Ingin Diubah');
define('AFF_P_VIDEOCHANGEBUTTON', 'Ubah Suai Video');
define('AFF_P_NOVIDEO', 'Tiada Video Promosi Dimasukkan Lagi');

$arahan_video_promosi = "Anda boleh memasukkan video - video promosi untuk kegunaan agen affiliate anda.<br /><br />Video - video ini boleh dihost pada YouTube dan masukkan kod embed video dia ruangan ini untuk kegunaan agen.";

$arahan_edit_video = "Di bawah ini adalah video promosi yang telah dimasukkan sebelum ini.<br><br>Untuk mengubahsuai video yang sedia ada, klik pada menu <b>Ubah Suai</b>. Untuk menghapuskan video promosi dari database, klik pada menu <b>Hapuskan</b>.";


$arahanbanneragen = "Anda boleh menggunakan grafik promosi dibawah ini untuk diletakkan ke dalam blog, forum dan sebagainya.<br><br>COPY dan PASTE kan code HTML yang dibekalkan ke dalam laman web anda.";

$arahan_promosi_agen = "Anda boleh menggunakan artikel - artikel promosi dibawah ini untuk diletakkan ke dalam blog, email follow up dan sebagainya.<br /><br />Kami akan menyarankan anda supaya mengubahsuai artikel - artikel ini mengikut gaya penyampaian anda sendiri.<br /><br />Jangan lupa juga masukkan LINK AFFILIATE anda ke dalam artikel ini (jika perlu)";

$arahan_artikel_promosi = "Anda boleh memasukkan artikel - artikel promosi atau email follow up untuk kegunaan agen affiliate anda.<br><br>Artikel - artikel yang disediakan boleh membantu meningkatkan aktiviti pemasaran agen affiliate dan hasil jualan terhadap produk anda.";

$arahan_edit_artikel = "Di bawah ini adalah kandungan artikel promosi yang telah dimasukkan sebelum ini.<br><br>Untuk mengubahsuai kandungan yang sedia ada, klik pada menu <b>Ubah Suai</b>. Untuk menghapuskan artikel promosi dari database, klik pada menu <b>Hapuskan</b>.";

$kandunganpromosi = "Kandungan untuk dimasukkan ke dalam email.<br><br>Sebaik - baiknya kandungan ini diolah mengikut gaya penyampaian agen sendiri.";


// pwjafflite_admin_pay.php

define('AFF_A_DELETEAFF', 'Hapus Ahli Affiliate:');
define('AFF_AA_COMMISSIONPAIDINFO', 'Informasi Pembayaran Komisyen (VERIFIED)');
define('AFF_AA_COMMISSIONPAIDTOTITLE', 'Butiran Agen Affiliate Yang Layak Menerima Pembayaran');
define('AFF_A_SALESCOUNT', 'Jualan');
define('AFF_A_EARNED', 'Komisyen');
define('AFF_A_INVOICE', 'Invoice');
define('AFF_A_TANDAPAID', 'Tandakan Paid');
define('AFF_A_SAHTANDAPAID', 'Adakah anda telah melakukan pembayaran komisyen kepada agen ini? Dengan menekan butang ini notifikasi pembayaran akan dikirimkan kepada agen.');
define('AFF_A_RESET', 'Reset');
define('AFF_A_RESETINFO', 'Hapuskan Keseluruhan Data?');
define('AFF_A_RESETCONFIRM', 'Dengan meneruskan proses RESET ini data akan terhapus daripada database. Adakah anda bersetuju untuk hapuskan data ini? ');
define('AFF_A_SALESRESET', 'Delete SEMUA REKOD Jualan?');
define('AFF_A_SALESSTATUSRESET', 'Delete REKOD Jualan');
define('AFF_A_SALESRESETCONFIRM', 'Adakah anda bersetuju untuk menghapuskan SEMUA data jualan PENDING, VERIFIED, CANCELLED dan PAID daripada DATABASE? Proses ini TIDAK DAPAT mengembalikan data apabila ia sudah dihapuskan.');
define('AFF_A_SALESSTATUSRESETCONFIRM', 'Adakah anda bersetuju untuk menghapuskan SEMUA data jualan berdasarkan STATUS jualan daripada DATABASE? Proses ini TIDAK DAPAT mengembalikan data apabila ia sudah dihapuskan.');
define('AFF_A_1SALESRESETCONFIRM', 'Adakah anda bersetuju untuk menghapuskan data jualan yang dipilih? Proses ini TIDAK DAPAT mengembalikan data apabila ia sudah dihapuskan.');
define('AFF_A_TOTAL', 'Jumlah Keseluruhan');
define('AFF_MA_MEMBERNOARTICLES', 'Tiada Artikel Promosi Yang Disediakan');
define('AFF_MA_MEMBERNOBANNERS', 'Tiada Banner Promosi Yang Disediakan');
define('AFF_MA_MEMBERNOVIDEOS', 'Tiada Video Promosi Yang Disediakan');
define('AFF_A_TIADAJUALAN', 'Anda Belum Menghasilkan Sebarang Jualan Lagi');
define('AFF_A_TIADAKLIK', 'Anda Belum Mempunyai Statistik Trafik');
define('AFF_DELETE_CONFIRM', 'Teruskan Hapus Data');


//pwjafflite_admin_clicks.php
define('AFF_A_CLICKRESET', 'Delete SEMUA REKOD Klik?');
define('AFF_A_CLICKRESETCONFIRM', 'Adakah anda bersetuju untuk menghapuskan SEMUA data klik link affiliate daripada DATABASE? Proses ini TIDAK DAPAT mengembalikan data apabila ia sudah dihapuskan.');

//pwjafflite_affiliate_delete.php
define('AFF_A_AFFILIATEDELETE', 'Delete Rekod Affiliate?');
define('AFF_A_AFFILIATEDELETECONFIRM', 'Adakah anda bersetuju untuk menghapuskan rekod data agen affiliate yang dipilih daripada DATABASE? Proses ini TIDAK DAPAT mengembalikan data apabila ia sudah dihapuskan.');


$instruction_affiliate_pay = "<font color=#FF0000>NOTA:</font> Pastikan anda SEMAK rekod jualan agen affiliate sebelum melaksanakan pembayaran komisyen.<br /><ul><li>Untuk melihat butiran peribadi agen, klik pada ID agen affiliate.</li><li>Untuk melihat maklumat akaun pembayaran agen, klik pada INVOICE.</li><li>Selepas pembayaran, klik TANDAKAN PAID untuk mengesahkan bayaran komisyen telah dibuat.</ul><br /><font color=#FF0000>AMARAN:</font> Dengan menekan butang Tandakan PAID, sistem akan menghantar NOTIFIKASI pembayaran komisyen telah dibuat kepada agen.";

// pwjafflite_admin_update.php

define('AFF_AA_ADMINUPDATETITLE', 'Script Sistem Affiliate Lite Anda Adalah');


//order.php

define('AFF_O_DELETEBUY', 'Hapus Pembeli');
define('AFF_O_RESET', 'Reset');

//pwjafflite_admin_news.php

define('AFF_P_ADMINNEWSADDINFO', 'Informasi Berita Untuk Dimaklumkan Kepada Agen');
define('AFF_P_ADMINNEWNEWSBUTTON', 'Tambah Berita Baru');
define('AFF_P_ADMINCURRENTNEWS', 'Butiran Berita Yang Telah Dimasukkan');
define('AFF_P_ADMINNONEWS', 'Tiada Sebarang Berita Dimasukkan Lagi');
define('AFF_P_ADMINNEWSDATEMISSING', 'Tarikh Berita Tidak Dimasukkan');
define('AFF_P_ADMINNEWSTITLEMISSING', 'Tajuk Berita Tidak Dimasukkan');
define('AFF_P_ADMINNEWSCONTENTMISSING', 'Kandungan Berita Tidak Dimasukkan');
define('AFF_P_ADMINNEWSADDTITLE', 'Isikan Butiran Berita Baru Yang Ingin Dikongsikan');
define('AFF_P_ADMINNEWSDATEADD', 'Tarikh & Waktu Berita');
define('AFF_P_ADMINNEWSTITLEADD', 'Tajuk Berita');
define('AFF_P_ADMINNEWSCONTENTADD', 'Kandungan Berita');
define('AFF_P_ADMINNEWSBUTTONADD', 'Tambah Kandungan Berita Baru');
define('AFF_P_ADMINNEWSEDITINFO', 'ID Berita Yang Ingin Diubah');
define('AFF_P_ADMINNEWSCHANGEBUTTON', 'Ubah Suai Kandungan Berita');
define('AFF_P_ADMINNEWSEDIT', 'Ubah Suai');
define('AFF_P_ADMINNEWSDELETE', 'Hapuskan');

$arahan_berita = "Anda boleh memasukkan informasi atau berita yang anda ingin sampaikan kepada agen affiliate anda.";

$arahan_edit_berita = "Di bawah ini adalah kandungan berita yang telah dimasukkan sebelum ini.<br /><br />Untuk mengubahsuai kandungan yang sedia ada, klik pada menu <b>Ubah Suai</b>. Untuk menghapuskan berita tertentu dari database, klik pada menu <b>Hapuskan</b>.";


//pwjafflite_admin_notice.php

define('AFF_P_ADMINNOTICEINFO', 'Maklumat Notis Kepada Agen Affiliate');
define('AFF_P_ADMINNOTICETITLE', 'Maklumat Notis Untuk Dipaparkan Di Halaman Agen Affiliate');
define('AFF_P_ADMINNOTICEDATETIME', 'Tarikh & Masa Notis');
define('AFF_P_ADMINNOTICECONTENT', 'Kandungan Notis');
define('AFF_P_ADMINNOTICEDATETIMEMISSING', 'Sila Masukkan Tarikh & Masa Ubahsuai');
define('AFF_P_ADMINNOTICECONTENTMISSING', 'Sila Masukkan Butiran Maklumat Program Affiliate Yang Anda Anjurkan');
define('AFF_P_ADMINNOTICECONTENTCHANGED', 'Kandungan Informasi Program Affiliate Berjaya Ditukar!');
define('AFF_P_ADMINNOTICEBUTTON', 'Tukar Kandungan Notis');

$arahan_notis = "Dibawah ini adalah merupakan ruangan untuk admin memasukkan NOTIS / PENGUMUMAN atau SYARAT & TERMA yang akan dipaparkan DI DALAM halaman keahlian agen affiliate iaitu pada ruangan NOTIS / PENGUMUMAN PENGANJUR.";


//pwjafflite_admin_ads.php

define('AFF_P_ADMINADSINFO', 'Iklan Admin Di Ruangan Agen Affiliate');
define('AFF_P_ADMINADSTITLE', 'Tawaran Untuk Dipaparkan Di Halaman Agen Affiliate');
define('AFF_P_ADMINADSCONTENT', 'Kandungan Iklan');
define('AFF_P_ADMINADSMISSING', 'Sila Masukkan Kandungan Iklan');
define('AFF_P_ADMINADSCONTENTCHANGED', 'Kandungan Iklan Admin Berjaya Ditukar!');
define('AFF_P_ADMINADSBUTTON', 'Tukar Kandungan Iklan');

$arahan_iklan = "Dibawah ini adalah merupakan ruangan untuk admin memasukkan IKLAN yang akan dipaparkan DI DALAM halaman UTAMA keahlian agen affiliate iaitu pada ruangan bawah.<br /><br />Admin boleh memberikan apa - apa tawaran eksklusif kepada agen affiliate.";


//pwjafflite_admin_optin.php

define('AFF_P_ADMINOPTININFO', 'OPT-IN Form Di Ruangan Agen Affiliate');
define('AFF_P_ADMINOPTINTITLE', 'Borang OPTIN Untuk Agen Affiliate');
define('AFF_P_ADMINOPTINCONTENT', 'Kod Borang OPT-IN');
define('AFF_P_ADMINOPTINMISSING', 'Sila Masukkan Kod Borang OPTIN');
define('AFF_P_ADMINOPTINCONTENTCHANGED', 'Kod Borang OPTIN Admin Berjaya Ditukar!');
define('AFF_P_ADMINOPTINBUTTON', 'Tukar Borang OPTIN');

$arahan_optin = "Dibawah ini adalah merupakan ruangan untuk admin memasukkan OPT IN FORM Autoresponder yang akan dipaparkan DI DALAM halaman UTAMA keahlian agen affiliate.<br /><br />Penggunaan sistem autoresponder dapat membantu admin untuk melakukan follow up terhadap aktiviti pemasaran affiliate agen yang mendaftar.";


//pwjafflite_admin_registerterms.php

define('AFF_P_ADMINTERMSINFO', 'Syarat & Terma Pada Halaman Pendaftaran Agen Affiliate');
define('AFF_P_ADMINTERMSTITLE', 'Terma Yang Akan Dipaparkan Di Halaman Pendaftaran Agen Affiliate');
define('AFF_P_ADMINTERMSCONTENT', 'Kandungan Terma');
define('AFF_P_ADMINTERMSMISSING', 'Sila Masukkan Kandungan Syarat Dan Terma');
define('AFF_P_ADMINTERMSCONTENTCHANGED', 'Kandungan Terma Admin Berjaya Ditukar!');
define('AFF_P_ADMINTERMSBUTTON', 'Tukar Kandungan Terma');

$arahan_terma = "Dibawah ini adalah merupakan ayat syarat dan terma yang akan terpapar pada ruangan pendaftaran agen affiliate baru.<br /><br />Admin boleh mengubahsuai kandungan ayat syarat dan terma program affiliate admin jika diperlukan.";


//pwjafflite_admin_client.php

define('AFF_AA_CONTACTCLIENTTITLE', 'Borang Hubungi Pelanggan');
define('AFF_AA_CONTACTCLIENTREPLYEMAIL', 'Salinan Email Pesanan');
define('AFF_AA_CONTACTCLIENTEMAILTO', 'Pesanan Penaja Anda');

$arahan_contact_client_admin = "Gunakan borang ini untuk menghubungi pelanggan / pembeli anda secara personal.";


//pwjafflite_affiliate_email.php

define('AFF_AA_CONTACTAFFILIATETITLE', 'Borang Hubungi Affiliate');
define('AFF_AA_CONTACTAFFILIATEREPLYEMAIL', 'Salinan Email Pesanan');
define('AFF_AA_CONTACTAFFILIATEEMAILTO', 'Pesanan Penaja Anda');
define('AFF_AA_CONTACTAFFILIATENAME', 'Nama Agen');
define('AFF_AA_CONTACTAFFILIATEEMAIL', 'Email Agen');
define('AFF_AA_CONTACTAFFILIATEPHONE', 'Tel Agen');

$arahan_contact_affiliate_admin = "Gunakan borang ini untuk menghubungi agen affiliate anda secara personal.";


//pwjafflite_admin_tracking.php

define('AFF_P_ADMINTRACKINGINFO', 'Kod Tracking Untuk Dimasukkan Ke Landing Page');
define('AFF_P_ADMINTRACKINGNEWTITLE', 'Kod Tracking - Kredit Komisyen Kepada Agen Terawal');
define('AFF_P_ADMINTRACKINGOLDTITLE', 'Kod Tracking - Kredit Komisyen Kepada Agen Terakhir');

$arahan_tracking = "JIKA anda ingin menggunakan <font color=\"#FF0000\">CUSTOM</font> landing page untuk tracking affiliate selain daripada fail hop.php sistem affliate lite, maka dibawah ini adalah kod tracking sistem affiliate yang PERLU dimasukkan ke halaman landing page web jualan anda. Sila PILIH jenis tracking yang ingin anda gunakan.<br /><br />
Sekiranya kod tracking sistem affiliate ini tidak dimasukkan ke dalam landing page web jualan anda, hal ini boleh menyebabkan sistem affiliate tidak akan dapat mengesan statistik klik link affiliate dan juga memproses komisyen jualan.
<br /><br />
<font color=\"#FF0000\">NOTA</font>: PASTIKAN PATH (laluan) ke alamat fail sistem tracking yang digunakan adalah betul. Jika anda mengubah nama (RENAME) atau mengubahsuai kedudukan fail tracking, anda PERLU menggantikan PATH/NAMA fail tersebut kepada yang baru.
<br /><br />
<font color=\"#FF0000\">ARAHAN</font>: Kod tracking sistem affiliate dibawah perlu dimasukkan dibahagian PALING ATAS \"source code\" halaman web jualan anda iaitu sebelum bermulanya kod HTML.
";

$arahan_tracking_new = "Gunakan kod tracking ini JIKA anda <u>TIDAK MAHU cookies ID Agen affiliate di \"overwrite\"</u>. Ertinya sekiranya prospek membuat pembelian produk, maka agen affiliate terawal yang melakukan promosi akan menerima komisyen WALAUPUN ada agen baru yang mempromosikan produk yang sama kepada prospek.<br /><br />Syaratnya adalah prospek tidak membersihkan cookies atau cache pada pelayar web (web browser) komputernya.";


$arahan_tracking_old = "Gunakan kod tracking ini JIKA anda <u>MAHU cookies ID Agen affiliate di \"overwrite\"</u>. Ertinya sekiranya prospek membuat pembelian produk, maka kredit komisyen akan diberikan kepada agen affiliate terakhir yang mempromosikan produk tersebut. Agen affiliate yang terawal mempromosikan produk tidak akan menerima sebarang komisyen.";


//pwjafflite_admin_form.php

define('AFF_P_ADMINFORMINFO', 'Kod Borang Untuk Halaman Tempahan');
define('AFF_P_ADMINFORMCODETITLE', 'Kod Borang Untuk Anda Edit');
define('AFF_P_ADMINFORMPREVIEWTITLE', 'Contoh Paparan Sistem Borang');

$arahan_form_code = "Dibawah ini adalah kod sistem borang yang telah diintegrasi dengan sistem affiliate. Anda perlu salin kod yang disediakan pada ruang ini dan masukkan ke dalam halaman tempahan web jualan anda.
<br /><br />
<font color=\"#FF0000\">NOTA</font>: PASTIKAN PATH (laluan) ke alamat ACTION form adalah betul iaitu kepada fail bernama pwjafflite_form_submitpayment.php.
<br /><br />
<font color=\"#FF0000\">PILIHAN</font>: Anda boleh menggunakan sistem borang anda sendiri dan integrasikan dengan fail <font color=\"#FF0000\">pwjafflite_ubah.php</font> yang diletakkan di dalam <font color=\"#FF0000\">folder pwjafflite_custom</font> untuk membolehkan sistem borang anda bekerja dengan sistem affiliate lite.
";

$arahan_form_code_edit = "Salin kod borang ini ke dalam halaman tempahan anda. Untuk mengubahsuai nama produk dan komisyen, sila edit menggunakan perisian HTML editor.";


//pwjafflite_admin_email.php

define('AFF_E_ADMINEMAILINFO', 'Senarai Template Email Yang Boleh Diubahsuai');
define('AFF_E_ADMINEMAILDAFTARTITLE', 'Kandungan Email Untuk Pendaftaran Affiliate');
define('AFF_E_ADMINEMAILPENGESAHANTITLE', 'Kandungan Email Untuk Pengesahan Pembayaran (Pembeli)');
define('AFF_E_ADMINEMAILPENGESAHANTITLE2', 'Kandungan Email Untuk Pengesahan Pembayaran (Admin)');
define('AFF_E_ADMINEMAILPASSUSERTITLE1', 'Kandungan Email Untuk Pengesahan Pemohonan Password (Agen)');
define('AFF_E_ADMINEMAILPASSUSERTITLE2', 'Kandungan Email Untuk Makluman Password Berjaya Ditukar (Agen)');
define('AFF_E_ADMINEMAILCOMMISSIONVERIFIED', 'Kandungan Email Untuk Pengesahan Komisyen');
define('AFF_E_ADMINEMAILCOMMISSIONPAID', 'Kandungan Email Untuk Pembayaran Komisyen');
define('AFF_E_ADMINEMAILERROR', 'Kandungan Email Tidak Boleh Dibiar Kosong!');
define('AFF_E_ADMINEMAILUPDATE', 'Kemaskini Kandungan Email Ini');
define('AFF_E_ADMINEMAILCHANGED', 'Kandungan Email Telah Dikemaskini!');

$arahan_email_template = 'Dibawah ini adalah template kandungan email yang boleh diubah suai untuk sesetengah bahagian dalam sistem affiliate lite ini.
<br />';

$arahan_email_daftar = 'Dibawah ini adalah template kandungan email yang akan dikirimkan kepada agen affiliate anda setelah mereka selesai mendaftar.
<br /><br />
Anda boleh menggunakan TAG - TAG berikut untuk memaparkan data yang bersesuaian dalam kandungan email:
<br /><br />
<ul>
<li><font color="#FF0000">%%namaagen%%</font>: Papar Nama Agen</li>
<li><font color="#FF0000">%%namaproduk%%</font>: Papar Nama Produk</li>
<li><font color="#FF0000">%%loginaffiliate%%</font>: Papar Link Login Affiliate</li>
<li><font color="#FF0000">%%idagen%%</font>: Papar Username Agen</li>
<li><font color="#FF0000">%%passwordagen%%</font>: Papar Password Agen</li>
<li><font color="#FF0000">%%linkaffiliate%%</font>: Papar Link Affiliate Agen</li>
<li><font color="#FF0000">%%namaadmin%%</font>: Papar Nama Admin</li>
<li><font color="#FF0000">%%domain%%</font>: Papar URL WebJualan</li>
</ul>
<br /><br />
<font color="#FF0000">NOTA</font>: TAG diatas hanya dapat digunakan pada template email pendaftaran ini sahaja.
';

$arahan_email_pengesahan_pembeli = 'Dibawah ini adalah template kandungan email yang akan dikirimkan kepada pembeli produk anda setelah mereka selesai menghantar pengesahan bayaran.
<br /><br />
Anda boleh menggunakan TAG - TAG berikut untuk memaparkan data yang bersesuaian dalam kandungan email:
<br /><br />
<ul>
<li><font color="#FF0000">%%namaproduk%%</font>: Papar Nama Produk</li>
<li><font color="#FF0000">%%namaadmin%%</font>: Papar Nama Admin</li>
<li><font color="#FF0000">%%domain%%</font>: Papar URL WebJualan</li>
<li><font color="#FF0000">%%emailsupport%%</font>: Papar Email Bantuan Pelanggan</li>
<li><font color="#FF0000">%%namapembeli%%</font>: Papar Nama Pelanggan</li>
<li><font color="#FF0000">%%emailpembeli%%</font>: Papar Email Pelanggan</li>
<li><font color="#FF0000">%%telefonpembeli%%</font>: Papar Telefon Pelanggan</li>
<li><font color="#FF0000">%%alamatpembeli%%</font>: Papar Alamat Pelanggan</li>
<li><font color="#FF0000">%%jumlahpembayaran%%</font>: Papar Nama Produk & Jumlah Pembayaran</li>
<li><font color="#FF0000">%%kaedahpembayaran%%</font>: Papar Kaedah Pembayaran</li>
<li><font color="#FF0000">%%tarikhpembayaran%%</font>: Papar Tarikh Pembayaran</li>
<li><font color="#FF0000">%%masapembayaran%%</font>: Papar Masa Pembayaran</li>
<li><font color="#FF0000">%%buktipembayaran%%</font>: Papar Bukti Pembayaran</li>
<li><font color="#FF0000">%%notapembeli%%</font>: Papar Nota Dari Pembeli</li>
</ul>
<br /><br />
<font color="#FF0000">NOTA</font>: TAG diatas hanya dapat digunakan pada template email pengesahan bayaran ini sahaja.
';

$arahan_email_pengesahan_admin = 'Dibawah ini adalah template kandungan email yang akan dikirimkan kepada pembeli produk anda setelah mereka selesai menghantar pengesahan bayaran.
<br /><br />
<font color="#FF0000">NOTA</font>: Anda boleh menggunakan TAG yang sama seperti pada email pengesahan pembeli diatas dengan TAMBAHAN TAG berikut:
<br /><br />
<ul>
<li><font color="#FF0000">%%idagen%%</font>: Papar ID Agen Affiliate</li>
<li><font color="#FF0000">%%komisyenagen%%</font>: Papar Komisyen Affiliate</li>
<li><font color="#FF0000">%%statuskomisyen%%</font>: Papar Status Komisyen Affiliate</li>
<li><font color="#FF0000">%%ippelanggan%%</font>: Papar IP Komputer Pelanggan</li>
<li><font color="#FF0000">%%tarikhborang%%</font>: Papar Tarikh Borang Dikirimkan</li>
<li><font color="#FF0000">%%masaborang%%</font>: Papar Masa Borang Dikirimkan</li>
<li><font color="#FF0000">%%browserpelanggan%%</font>: Papar Jenis Browser/Pelayar Web Pelanggan</li>
</ul>
';

$arahan_email_password_agen = 'Dibawah ini adalah template kandungan email yang akan dikirimkan kepada agen sewaktu memohon password baru.
<br /><br />
<font color="#FF0000">NOTA</font>: Anda boleh menggunakan TAG dibawah untuk kandungan email:
<br /><br />
<ul>
<li><font color="#FF0000">%%namaagen%%</font>: Papar Nama Agen</li>
<li><font color="#FF0000">%%idagen%%</font>: Papar ID / Username Agen Affiliate</li>
<li><font color="#FF0000">%%loginaffiliate%%</font>: Papar Link Login Affiliate</li>
<li><font color="#FF0000">%%urlresetpassword%%</font>: Papar Link UNIK Proses Pengesahan Password Baru</li>
<li><font color="#FF0000">%%namaadmin%%</font>: Papar Nama Admin</li>
<li><font color="#FF0000">%%domain%%</font>: Papar URL WebJualan</li>
<li><font color="#FF0000">%%emailsupport%%</font>: Papar Email Bantuan Pelanggan</li>
<li><font color="#FF0000">%%ippelanggan%%</font>: Papar IP Komputer Pengirim</li>
<li><font color="#FF0000">%%tarikhborang%%</font>: Papar Tarikh Borang Dikirimkan</li>
<li><font color="#FF0000">%%masaborang%%</font>: Papar Masa Borang Dikirimkan</li>
<li><font color="#FF0000">%%browserpelanggan%%</font>: Papar Jenis Browser/Pelayar Web Pengirim</li>
</ul>
';

$arahan_email_password_agen2 = 'Dibawah ini adalah template kandungan email yang akan dikirimkan kepada agen selepas password baru ditetapkan.
<br /><br />
<font color="#FF0000">NOTA</font>: Anda boleh menggunakan TAG dibawah untuk kandungan email:
<br /><br />
<ul>
<li><font color="#FF0000">%%namaagen%%</font>: Papar Nama Agen</li>
<li><font color="#FF0000">%%idagen%%</font>: Papar ID / Username Agen Affiliate</li>
<li><font color="#FF0000">%%passwordbaruagen%%</font>: Papar Password Baru Agen</li>
<li><font color="#FF0000">%%loginaffiliate%%</font>: Papar Link Login Affiliate</li>
<li><font color="#FF0000">%%namaadmin%%</font>: Papar Nama Admin</li>
<li><font color="#FF0000">%%domain%%</font>: Papar URL WebJualan</li>
<li><font color="#FF0000">%%emailsupport%%</font>: Papar Email Bantuan Pelanggan</li>
<li><font color="#FF0000">%%ippelanggan%%</font>: Papar IP Komputer Pengirim</li>
<li><font color="#FF0000">%%tarikhborang%%</font>: Papar Tarikh Borang Dikirimkan</li>
<li><font color="#FF0000">%%masaborang%%</font>: Papar Masa Borang Dikirimkan</li>
<li><font color="#FF0000">%%browserpelanggan%%</font>: Papar Jenis Browser/Pelayar Web Pengirim</li>
</ul>
';


$arahan_email_komisyen_sah = 'Dibawah ini adalah template kandungan email yang akan dikirimkan kepada agen selepas anda mengesahkan pembelian daripada pelanggan.
<br /><br />
<font color="#FF0000">NOTA</font>: Anda boleh menggunakan TAG dibawah untuk kandungan email:
<br /><br />
<ul>
<li><font color="#FF0000">%%namaagen%%</font>: Papar Nama Agen</li>
<li><font color="#FF0000">%%idagen%%</font>: Papar ID / Username Agen Affiliate</li>
<li><font color="#FF0000">%%loginaffiliate%%</font>: Papar Link Login Affiliate</li>
<li><font color="#FF0000">%%linkaffiliate%%</font>: Papar Link Affiliate Agen</li>
<li><font color="#FF0000">%%jualan%%</font>: Papar Butiran Produk Terjual</li>
<li><font color="#FF0000">%%komisyenagen%%</font>: Papar Komisyen Affiliate</li>
<li><font color="#FF0000">%%namaadmin%%</font>: Papar Nama Admin</li>
<li><font color="#FF0000">%%domain%%</font>: Papar URL WebJualan</li>
<li><font color="#FF0000">%%emailsupport%%</font>: Papar Email Bantuan Pelanggan</li>
<li><font color="#FF0000">%%namaproduk%%</font>: Papar Nama Produk / Website</li>
<li><font color="#FF0000">%%namapembeli%%</font>: Papar Nama Pelanggan</li>
<li><font color="#FF0000">%%emailpembeli%%</font>: Papar Email Pelanggan</li>
</ul>
';

$arahan_email_bayar_komisyen = 'Dibawah ini adalah template kandungan email yang akan dikirimkan kepada agen selepas anda mengesahkan pembayaran komisyen agen.
<br /><br />
<font color="#FF0000">NOTA</font>: Anda boleh menggunakan TAG dibawah untuk kandungan email:
<br /><br />
<ul>
<li><font color="#FF0000">%%namaagen%%</font>: Papar Nama Agen</li>
<li><font color="#FF0000">%%idagen%%</font>: Papar ID / Username Agen Affiliate</li>
<li><font color="#FF0000">%%loginaffiliate%%</font>: Papar Link Login Affiliate</li>
<li><font color="#FF0000">%%linkaffiliate%%</font>: Papar Link Affiliate Agen</li>
<li><font color="#FF0000">%%pemprosesanbayaran%%</font>: Papar Maklumat Pemprosesan Bayaran</li>
<li><font color="#FF0000">%%%akaunbayaran%%%</font>: Papar Maklumat Akaun Bayaran</li>
<li><font color="#FF0000">%%pemilikakaun%%</font>: Papar Maklumat Pemilik Akaun</li>
<li><font color="#FF0000">%%jumlahkomisyenagen%%</font>: Papar Jumlah Komisyen Dibayar</li>
<li><font color="#FF0000">%%namaadmin%%</font>: Papar Nama Admin</li>
<li><font color="#FF0000">%%domain%%</font>: Papar URL WebJualan</li>
<li><font color="#FF0000">%%emailsupport%%</font>: Papar Email Bantuan Pelanggan</li>
<li><font color="#FF0000">%%namaproduk%%</font>: Papar Nama Produk / Website</li>
<li><font color="#FF0000">%%currency%%</font>: Papar Jenis Matawang</li>
</ul>
';



//admin header

define('ADMIN_PAGE_TITLE', 'Ruangan Admin');


//pwjlite_forgotpass.php

define('AFF_FP_PASSCHANGEREQUEST', 'Permohanan Penukaran Password');
define('AFF_FP_INFO', 'Dapatkan Butiran Password');
define('AFF_FP_EMAIL', 'Email Anda');
define('AFF_FP_USERNAME', 'ID Affiliate');
define('AFF_FP_REQUESTPASSBUTTON', 'Dapatkan Password Baru');
define('AFF_FP_USERNAMEMISSING', 'Sila Masukkan Username / ID Affiliate Anda');
define('AFF_FP_EMAILMISSING', 'Sila Masukkan Email Yang Pernah Anda Daftarkan Dahulu');
define('AFF_FP_REQUESTSENT', 'Sila Semak Email Anda');
define('AFF_FP_REQUESTSENTINFO', 'Butiran RESET password telah dikirimkan ke alamat email anda. Silalah semak email tersebut untuk maklumat lanjut.');
define('AFF_FP_PASSCHANGEDDONE', 'Butiran password BARU telah dikirimkan ke alamat email anda. Silalah semak email tersebut untuk maklumat lanjut.');

define('AFF_FP_NODATATITLE', 'Data Tidak Ada');
define('AFF_FP_RETURNLINK', 'Kembali Ke Halaman Sebelum');

$AFF_FP_NODATA = "Data yang dimasukkan sama ada tidak dijumpai di dalam rekod kami atau tidak padan antara satu sama lain. Silalah cuba lagi.<br /><br />Jika masalah masih tidak dapat diselesaikan, sila hubungi kami di $emailadminsupport";

$AFF_FP_NODATA2 = "Terdapat masalah dengan proses penukaran password. Sila hubungi pihak pengurusan di $emailadminsupport untuk mendapat penyelesaian lanjut.";

//pwjlite_member_area.php

define('AFF_MA_MEMBERWELCOME', 'Selamat Datang,');
define('AFF_MA_MEMBERAFFLINK', 'Link Affiliate Anda');
define('AFF_MA_MEMBERSTATISTIC', 'Statistic Akaun Affiliate Anda');
define('AFF_MA_MEMBERSTATISTICCLICKS', 'Rekod Klik Terhadap Link Affiliate Anda');
define('AFF_MA_MEMBERSTATISTICSALES', 'Rekod Jualan Anda');
define('AFF_MA_MEMBERFULLRECORD', 'Lihat Rekod Jualan Keseluruhan Anda');
define('AFF_MA_MEMBERTOPSALESFULLRECORD', 'Lihat Rekod Keseluruhan TOP Jualan Affiliate');
define('AFF_MA_MEMBERAFFTESTLINK', 'Klik Sini Untuk Uji Link Affiliate Anda');
define('AFF_MA_MEMBERTOPAFFILIATEINFO', 'Statistik TOP Jualan Agen Affiliate!');
define('AFF_MA_MEMBERTERMSINFO', 'Terma & Notifikasi');
define('AFF_MA_MEMBEROPTIN', 'Daftar Newsletter Super Affiliate');
define('AFF_MA_MEMBERTOPAFF', 'ID Agen TOP');
define('AFF_MA_MEMBERTOPSALES', 'Jumlah Jualan');
define('AFF_MA_MEMBERTOPCOMMISSION', 'Jumlah Komisyen');
define('AFF_MA_MEMBERADS', 'Tawaran Istimewa Untuk Anda');

$member_greeting = "Sudahkah anda membaca informasi terkini daripada kami?";

$topaffiliatenotis = "Berikut adalah carta TOP agen affiliate terbaik yang telah menghasilkan jumlah jualan yang memberangsangkan!<br /><br />Adakah anda salah seorang daripada TOP agen affiliate ini?<br /><br />Segera tambahkan usaha anda dan jadi juara keseluruhan promosi affiliate!";


//pwjafflite_member_news.php

define('AFF_MA_MEMBERCURRENTNEWS', 'Berita Terkini Daripada Pihak Pengurusan');
define('AFF_MA_MEMBERNONEWS', 'Tiada Sebarang Berita Daripada Pihak Pengurusan');

$arahan_berita_member = "
Di bawah ini adalah kandungan berita yang telah dimasukkan oleh pihak pengurusan program affiliate. Sebarang pertanyaan, sila hubungi kami.
";

//pwjafflite_member_sales.php

define('AFF_MA_MEMBERSALESTOTALTITLE', 'Rekod Keseluruhan Jualan Anda');
define('AFF_MA_MEMBERSALESTOTALTITLE2', 'Rekod Jualan Dan Komisyen Anda');
define('AFF_MA_MEMBERSALESTOTAL', 'Jumlah Keseluruhan Jualan Dan Komisyen Anda');

$arahan_berita_member = "
Di bawah ini adalah kandungan berita yang telah dimasukkan oleh pihak pengurusan program affiliate. Sebarang pertanyaan, sila hubungi kami.
";


//pwjafflite_member_sales.php

define('AFF_MA_MEMBERVIDEOTITLE', 'Video Promosi Yang Boleh Anda Gunakan');

$arahan_guna_video = "Anda boleh menggunakan video promosi yang kami sediakan untuk memantapkan lagi pemasaran affiliate bagi produk kami";


//pwjafflite_member_client.php

define('AFF_MA_CONTACTCLIENTTITLE', 'Borang Hubungi Pelanggan Affiliate');
define('AFF_MA_CONTACTCLIENTREPLYEMAIL', 'Salinan Email Pesanan');
define('AFF_MA_CONTACTCLIENTEMAILTO', 'Pesanan Penaja Anda');

$arahan_contact_client = "Gunakan borang ini untuk mengirimkan BONUS kepada pelanggan yang telah membuat pembelian menerusi link affiliate anda (pastikan STATUS mereka telah VERIFIED atau PAID).
";


//pwjafflite_member_topaffiliates.php

define('AFF_MA_TOPAFFILIATEVERIFIEDTITLE', 'Statistik TOP Jualan Status - VERIFIED');
define('AFF_MA_TOPAFFILIATEPAIDTITLE', 'Statistik TOP Jualan Status - PAID');

$topaffiliatenotis_verified = "Berikut adalah carta TOP agen affiliate yang telah menghasilkan jumlah jualan (VERIFIED) yang memberangsangkan pada masa ini!
";

$topaffiliatenotis_paid = "Berikut adalah carta TOP agen affiliate yang telah menerima jumlah pembayaran komisyen jualan (PAID) yang memberangsangkan sepanjang program affiliate ini berlangsung!
";


//Extra instruction




$instruction_affiliate_profile_admin = "<font color=#FF0000>NOTA:</font> Pastikan admin hanya mengubahsuai maklumat yang diperlukan sahaja setelah mendapat kebenaran daripada pihak agen sendiri untuk mengelakkan sebarang kesulitan dikemudian hari.";



$instruction_page_forgotpassdone = "Sila semak email anda untuk mendapatkan butiran login anda.<br><br>Jika tiada email daripada kami di dalam <font color=#FF0000><b>INBOX</b></font>, semak di dalam folder <font color=#FF0000><b>BULK/JUNK/SPAM</b></font>.<br><br>Jika masih tiada email yang diterima dalam tempoh 24 jam, hantarkan pesanan anda kepada kami.<br><br><div align=center><a href=index.php>Klik Di Sini Untuk Kembali Halaman Utama</a></div>";

//pwjafflite_admin_products.php
define('AFF_PT_ADMINPRODUCTTITLE', 'Informasi Produk & Komisyen Affiliate');
define('AFF_PT_ADMINPRODUCTADD', 'Tambah Maklumat Produk Dan Komisyen');
define('AFF_PT_ADMINPRODUCTTITLE2', 'Produk & Komisyen Affiliate Yang Telah Dimasukkan');
define('AFF_PT_ADMINPRODUCTADD2', 'Masukkan Maklumat Produk Dan Komisyen');
define('AFF_PT_ADMINPRODUCTKOMISYEN', 'Nama Produk & Nilai Komisyen');
define('AFF_PT_ADMINPRODUCTKOMISYENTITLE', 'Nilai Komisyen');
define('AFF_PT_ADMINPRODUCTSNAME', 'Nama Produk');
define('AFF_PT_ADMINPRODUCTSNAMESAMPLE', 'Contoh: Produk A - MYR50.00');
define('AFF_PT_ADMINPRODUCTCOMMISSION', 'Nilai Komisyen');
define('AFF_PT_ADMINPRODUCTCOMMISSIONWARNING', 'JANGAN masukkan matawang (currency MYR, USD etc). Masukkan nilai sahaja.');
define('AFF_PT_ADMINPRODUCTSCOMMISSIONSAMPLE', 'Contoh: 30.00');
define('AFF_PT_ADMINPRODUCTSCOMMISSIONADD', 'Simpan Maklumat Produk & Komisyen');
define('AFF_PT_ADMINPRODUCTSNAMEERROR', 'Sila isi nama produk. Contoh: Produk A - MYR50.00');
define('AFF_PT_ADMINPRODUCTSCOMMISSIONERROR', 'Sila isi nilai komisyen produk. Contoh: 30.00');
define('AFF_PT_ADMINPRODUCTCOMMISSIONEDIT', 'Ubah Suai Nama Produk & Nilai Komisyen');
define('AFF_PT_ADMINPRODUCTEDIT', 'Ubah Suai');
define('AFF_PT_ADMINPRODUCTDELETE', 'Hapuskan');
define('AFF_PT_ADMINNOPRODUCTS', 'Tiada Rekod Produk & Komisyen');

$arahanproducts = "Berikut adalah konfigurasi bagi produk dan nilai komisyen yang terlibat untuk konsep program affiliate Pay Per Sale.
<br /><br />Fungsi ini hanya dapat digunakan JIKA admin menggunakan sistem borang yang disediakan oleh sistem affiliate lite ini. Ini adalah berikutan sistem affiliate akan bekerjasama dengan sistem borang yang telah disediakan untuk menghasilkan komisyen agen affiliate.
<br /><br />Sekiranya admin menggunakan sistem borang ciptaan sendiri, maka fungsi ini tidak dapat digunakan. Admin perlu mengintegrasikan sistem borang admin dengan fail penghasil komisyen dalam folder custom yang disediakan.";

$arahanproductsready = "Dibawah ini adalah senarai produk dan nilai komisyen yang telah ditambah ke dalam sistem.
<br /><br />Admin perlu memastikan bahawa NAMA PRODUK yang telah didaftarkan pada ruangan ini HARUS SAMA pada penetapan NAMA PRODUK sistem borang yang disediakan diruangan SETTINGS.";


// Paparan ayat punca masalah (error) pada SISTEM BORANG sistem affiliate lite (pwjaffiliate_form_submitpayment.php)
define('BORANG_TAJUK_MASALAH', 'Terdapat Masalah Dengan Borang');
define('BORANG_NAMA_PEMBELI', 'Sila isi nama penuh anda');
define('BORANG_EMAIL_PEMBELI', 'Sila isi alamat email anda');
define('BORANG_EMAIL_SAH_PEMBELI', 'Sila isi alamat email yang sah sahaja');
define('BORANG_TELEFON_PEMBELI', 'Sila isi nombor telefon anda');
define('BORANG_PILIH_JUMLAH_BAYARAN', 'Sila Pilih');
define('BORANG_JUMLAH_BAYARAN', 'Sila pilih produk dan jumlah pembayaran yang dilakukan');
define('BORANG_PILIH_KAEDAH_BAYARAN', 'Sila Pilih');
define('BORANG_KAEDAH_BAYARAN', 'Sila isi kaedah pembayaran anda');
define('BORANG_TARIKH_BAYARAN', 'Sila isi tarikh pembayaran anda');
define('BORANG_MASA_BAYARAN', 'Sila isi masa pembayaran anda');
define('BORANG_BUKTI_BAYARAN', 'Sila isi bukti pembayaran anda');
define('BORANG_KOD_SEKURITI', 'Kod sekuriti yang diisi adalah tidak tepat (atau dibiar kosong)');
define('BORANG_KEMBALI', 'Klik Di Sini Untuk Kembali');

// Paparan email pada SISTEM BORANG sistem affiliate lite
define('BORANG_TAJUK_EMAIL_PELANGGAN', 'RE: Salinan Tempahan');
define('BORANG_TAJUK_EMAIL_ADMIN', 'Pengesahan Pembelian');
