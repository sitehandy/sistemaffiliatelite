<?php

//Mulakan fungsi session untuk membolehkan kod sekuriti disimpan untuk sementara waktu.
session_start();

//Hasilkan imej captcha untuk dipaparkan.
create_image(); 
exit(); 

function create_image() 
{
    //Hasilkan nilai string secara rawak menggunakan fungsi md5
    $md5_hash = md5(rand(0,999)); 

    //Pilih hanya 6 nombor sahaja untuk dipamerkan pada sistem captcha 
    $kodsekuriti = substr($md5_hash, 19, 6); 

    //Tetapkan supaya fungsi session menyimpan kod sekuriti captcha
    $_SESSION['kodsekuriti'] = $kodsekuriti;

    //Tetapkan panjang dan tinggi imej captcha
    $panjang = 100; 
    $tinggi = 25;  

    //Hasilkan imej captcha yang diperlukan
    $imejcaptcha = imagecreate($panjang, $tinggi);  

    //Arahan warna
    $kelabu = imagecolorallocate($imejcaptcha, 128, 128, 128); 
    $putih = imagecolorallocate($imejcaptcha, 255, 255, 255); 

    //Warna imej captcha 
    imagefill($imejcaptcha, 0, 0, $hitam); 

    //Warna kod sekuriti pada imej captcha
    imagestring($imejcaptcha, 8, 26, 4, $kodsekuriti, $putih); 

    //Arahan konfigurasi pada browser untuk memaparkan imej 
    header('Content-Type: image/jpeg'); 
    ImageJpeg($imejcaptcha); 

    //Hapuskan imej apabila selesai proses penghasilan kod sekuriti
    ImageDestroy($imejcaptcha);
} 

?>